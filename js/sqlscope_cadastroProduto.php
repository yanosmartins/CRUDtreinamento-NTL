<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'grava') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PRODUTO_ACESSAR|PRODUTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    //Variáveis
    if ((empty($_POST['id'])) || (!isset($_POST['id'])) || (is_null($_POST['id']))) {
        $id = 0;
    } else {
        $id = formatarNumero(+$_POST["id"]);
    }

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = formatarNumero(+$_POST["ativo"]);
    }

    session_start();
    $usuario = formatarString($_SESSION['login']);  //Pegando o nome do usuário mantido pela sessão.
    $convenioSaude = +$_POST['convenioSaude'];
    $produto = formatarString($_POST['produto']);
    $mesAniversario = formatarNumero(+$_POST['mesAniversario']);
    $cobranca = formatarString($_POST['cobranca']);
    $seguroVida = formatarNumero(+$_POST['seguroDeVida']);
    $valorProduto = formatarNumero($_POST['valorProduto']);
    $descontoFolha = validaNumero($_POST['descontoFolha']);
    $valorDescontoFolha = validaNumero($_POST['valorDescontoFolha']);

    //Início do Json
    $strIdadeProduto = $_POST["jsonIdade"];
    $arrayIdadeProduto = json_decode($strIdadeProduto, true);
    $xmlIdadeProduto = "";
    $nomeXml = "ArrayOfIdadeProduto";
    $nomeTabela = "produtoIdade";
    if (sizeof($arrayIdadeProduto) > 0) {
        $xmlIdadeProduto = '<?xml version="1.0"?>';
        $xmlIdadeProduto = $xmlIdadeProduto . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayIdadeProduto as $chave) {
            $xmlIdadeProduto = $xmlIdadeProduto . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialIdade")) {
                    continue;
                }

                if (($campo === "valorIdade")) {
                    $valor = str_replace('.', '', $valor);
                    $valor = str_replace(',', '.', $valor);
                }

                $xmlIdadeProduto = $xmlIdadeProduto . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlIdadeProduto = $xmlIdadeProduto . "</" . $nomeTabela . ">";
        }
        $xmlIdadeProduto = $xmlIdadeProduto . "</" . $nomeXml . ">";
    } else {
        $xmlIdadeProduto = '<?xml version="1.0"?>';
        $xmlIdadeProduto = $xmlIdadeProduto . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlIdadeProduto = $xmlIdadeProduto . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlIdadeProduto);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de vale transporte modal";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlIdadeProduto = "'" . $xmlIdadeProduto . "'";
    //Fim do Json
    $sql = "Ntl.produto_Atualiza (" . $id . "," . $ativo . "," . $convenioSaude . "," . $produto . ","
        . $mesAniversario . "," . $cobranca . "," . $seguroVida . "," . $valorProduto . "," . $descontoFolha . "," . $valorDescontoFolha . ","
        . $usuario . "," . $xmlIdadeProduto . ") ";
    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    //fim do json 
    echo $ret;
    return;
}

function recupera()
{
    $id = $_POST["id"];

    if ($id) {
        $sql = "SELECT * FROM Ntl.produto WHERE (0=0) AND codigo =" . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        if (($row = odbc_fetch_array($result))) {
            $row = array_map('utf8_encode', $row);
            $codigo = +$row['codigo'];
            $produto = $row['produto'];
            $convenioSaude = +$row['convenioSaude'];
            $mesAniversario = $row['mesAniversario'];
            $cobranca = $row['cobranca'];
            $seguroVida = +$row['seguroVida'];
            $valorProduto = validaNumeroRecupera($row['valorProduto']);
            $descontoFolha = validaNumeroRecupera($row['descontoFolha']);
            $ativo = +$row['ativo'];
            $valorDescontoFolha = validaNumeroRecupera($row['valorDescontoFolha']);
        }

        $sql = " SELECT * FROM Ntl.produtoIdade WHERE produto = " . $id;

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contadorProduto = 0;
        $arrayProduto = array();
        while (($row = odbc_fetch_array($result))) {

            $codigoIdade = +$row['codigo'];
            //$produtoIdade = +$row['produto'];
            $idadeInicial = +$row['idadeInicial'];
            $idadeFinal = +$row['idadeFinal'];
            $valorIdade = validaNumeroRecupera($row['valorIdade']);
            $contadorProduto = $contadorProduto + 1;
            $arrayProduto[] = array(
                "produtoIdadeId" => $codigoIdade,
                "sequencialIdade" => $contadorProduto,
                "idadeInicial" => $idadeInicial,
                "idadeFinal" => $idadeFinal,
                "valorIdade" => $valorIdade
            );
        }
        $strArrayIdadeProduto = json_encode($arrayProduto);

        $outValorIdade = $valorIdade;

        $out = $codigo . "^" . $produto . "^" . $convenioSaude . "^" . $mesAniversario . "^" .
            $cobranca . "^" . $seguroVida . "^" . $valorProduto . "^" . $descontoFolha . "^" . $ativo . "^" . $valorDescontoFolha;


        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . "#" . $strArrayIdadeProduto . "#" . $outValorIdade;
        }
        return;
    }
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PRODUTO_ACESSAR|PRODUTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um produto para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $result = $reposit->update('produto' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function formatarNumero($value)
{
    $aux = $value;
    $aux = str_replace('.', '', $aux);
    $aux = str_replace(',', '.', $aux);
    $aux = floatval($aux);
    if (!$aux) {
        $aux = 'null';
    }
    return $aux;
}

function formatarString($value)
{
    $aux = $value;
    $aux = str_replace("'", " ", $aux);
    if (!$aux) {
        return 'null';
    }
    $aux = '\'' . trim($aux) . '\'';
    return $aux;
}


function formatarData($value)
{
    $aux = $value;
    if (!$aux) {
        return 'null';
    }
    $aux = explode('/', $value);
    $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
    $data = '\'' . trim($data) . '\'';
    return $data;
}

//Transforma uma data Y-M-D para D-M-Y. 
function formataDataRecuperacao($campo)
{
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}


function validaNumero($value)
{
    $aux = $value;
    $aux = str_replace('.', '', $aux);
    $aux = str_replace(',', '.', $aux);
    $aux = floatval($aux);
    if (!$aux) {
        $aux = 0;
    }
    return $aux;
}
function validaNumeroRecupera($value)
{
    $aux = $value;
    $aux = str_replace('.', ',', $aux);
    if (!$aux) {
        $aux = 0;
    }
    return $aux;
}

function validaString($value)
{
    $null = 'NULL';
    if ($value == '')
        return $null;
    return '\'' . $value . '\'';
}
