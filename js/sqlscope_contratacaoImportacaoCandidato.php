<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaImportacaoCandidato') {
    call_user_func($funcao);
}

return;

function gravaImportacaoCandidato()
{
    $reposit = new reposit(); //Abre a conexão.
    $possuiPermissao = $reposit->PossuiPermissao("IMPORTARCANDIDATO_ACESSAR|IMPORTARCANDIDATO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $reposit = new reposit();
    $usuario = "'" . $_SESSION['login'] . "'";
    $importacaoCandidato = $_POST['importacaoCandidato'];
    $codigo =  +$importacaoCandidato['codigo'];
    // $descricao = "'" . $importacaoCandidato['descricao'] . "'";

    $datahojeNome = new DateTime();
    $datahoje = $datahojeNome->format('Y-m-d');
    $datahoje = "'" . $datahoje . "'";
    $dataNome = $datahojeNome->format('Y_m_d_H_i_s');

    $uploadsPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . "uploads";
    $entradaItemPath = $uploadsPath . DIRECTORY_SEPARATOR . "importacaoCandidato";

    if (!is_dir($uploadsPath)) {
        mkdir($uploadsPath);
    }

    if (!is_dir($entradaItemPath)) {
        mkdir($entradaItemPath);
    }

    $fileContent = $_FILES['xmlNota'];
    $nomeTemporario = $fileContent['tmp_name'][0];
    $nomeXmlNota = str_replace("-", "_", $fileContent['name'][0]);
    $nomeXmlNota = tiraAcento($nomeXmlNota);
    $fileName = $dataNome . "-" . $nomeXmlNota;
    $path = $entradaItemPath . DIRECTORY_SEPARATOR . $fileName;

    $filePath = "." . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "importacaoCandidato" . DIRECTORY_SEPARATOR;
    $fileType = $fileContent['type'][0];

    $filePath = "'" . $filePath . "'";
    $fileType = "'" . $fileType . "'";
    $fileName = "'" . $fileName . "'";

    move_uploaded_file($nomeTemporario, $path);
    $handle = fopen($path, "r");

    $arrayErros = [];
    $reposit = new reposit();
    while (($data = fgetcsv($handle)) !== FALSE) {
        // var_dump($data);

        $data = array_map('utf8_encode', $data);
        $descricaoData = explode(";", $data[0]);

        $nome = $descricaoData[0];
        // $nome = iconv('UTF-8', 'windows-1252',$descricaoData[0]);
        $nome =  "'" . strtoupper(tiraAcento($nome)) . "'";

        $telefone = $descricaoData[2];
        $telefoneSemDDD = substr($telefone, 2);
        $telefoneDDD = substr($telefone, 0, 2);
        $telefoneFormatado = "'" . "(" . $telefoneDDD . ")" . " " . $telefoneSemDDD . "'";

        $email = "'" . $descricaoData[3] . "'";
        $cargoAnterior = "'" .  $descricaoData[4] . "'";
        $dataNascimento = validaData($descricaoData[6]);
        $cpf = "'" . $descricaoData[7] . "'";

        $pcd = $descricaoData[8];
        if ($pcd == 'S' || $pcd == 's') {
            $pcd = 1;
        } else {
            $pcd = 0;
        }
        $pis = "'" . $descricaoData[9] . "'";
        $codigo = 0;

        $sql = "";
        $result = "";

        $candidato = [$nome, $telefoneFormatado, $email, $cargoAnterior, $dataNascimento, $cpf, $pis, $pcd];

        if (!validaCPF($descricaoData[7])) {
            $arrayErros[] = $candidato;
            continue;
        }

        if ($nome) {
            $sql = "Contratacao.importacaoCSV_Atualiza
                            $codigo,
                            $nome,	
                            $telefoneFormatado,
                            $email,
                            $cargoAnterior,
                            $dataNascimento,
                            $cpf,
                            $pis,
                            $pcd,
                            $usuario";

            $result = $reposit->Execprocedure($sql);

            if ($result < 1) {
                $arrayErros[] = $candidato;
            } else {
                continue;
            }
        }
    }

    unlink($path);// remove o arquivo que foi feito o upload do sistema.
    $jsonArrayErros = json_encode($arrayErros);
    echo "success#" . $jsonArrayErros;
}

function tiraAcento($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(')/"), explode(" ", "a A e E i I o O u U n N"), $string);
}

function validaData($value)
{
    if ($value == "") {
        $value = 'NULL';
        return $value;
    }
    $value = str_replace('/', '-', $value);
    $value = date("Y-m-d", strtotime($value));
    $value = "'" . $value . "'";
    return $value;
}

function validaCPF($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}
