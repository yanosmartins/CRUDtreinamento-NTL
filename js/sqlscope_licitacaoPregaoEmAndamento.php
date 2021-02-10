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

if ($funcao == 'recuperaUpload') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit(); //Abre a conexão.    

    // Gravação do formulário no banco de dados. 
    session_start();
    $codigo =  (int)$_POST['codigo'];
    $observacao = validaString($_POST['observacao']);
    $usuario = validaString($_SESSION['login']);

    //informações adicionais pregões em andamento
    $situacao =  (int) $_POST['situacao'];
    $posicao =  (int) $_POST['posicao'];
    $dataReaberturaPregao = validaData($_POST['dataReaberturaPregao']);
    $horaReaberturaPregao = validaString($_POST['horaReaberturaPregao']);
    $dataAlerta = validaData($_POST['dataAlerta']);
    $horaAlerta = validaString($_POST['horaAlerta']);
    $prioridade = validaString($_POST['prioridade']);
    $condicao = (int) ($_POST['condicao']);
    $observacaoCondicao = validaString($_POST['observacaoCondicao']);

    $strArrayTarefa = $_POST['jsonTarefa'];
    $arrayTarefa = json_decode($strArrayTarefa, true);
    $xmlTarefa = "";
    $nomeXml = "ArrayOfTarefa";
    $nomeTabela = "pregaoDetalhe";
    if (sizeof($arrayTarefa) > 0) {
        $xmlTarefa = '<?xml version="1.0"?>';
        $xmlTarefa = $xmlTarefa . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTarefa as $chave) {
            $xmlTarefa = $xmlTarefa . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialTarefa" || $campo === "tarefaId")) {
                    continue;
                }
                if ($campo  === "dataSolicitacao") {
                    if ($valor == "") {
                        continue;
                    }

                    $horario = explode(" ", $valor);
                    $valor = str_replace('/', '-', $valor);
                    $valor = date("Y-m-d", strtotime($valor));
                }
                if (($campo === "dataFinal") || ($campo === "dataConclusao")) {

                    if ($valor == "") {
                        continue;
                    }
                    if ($valor != "" && $valor != "NULL") {
                        $valor = str_replace('/', '-', $valor);
                        $valor = date("Y-m-d", strtotime($valor));
                    }
                }
                $xmlTarefa = $xmlTarefa . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlTarefa = $xmlTarefa . "</" . $nomeTabela . ">";
        }
        $xmlTarefa = $xmlTarefa . "</" . $nomeXml . ">";
    } else {
        $xmlTarefa = '<?xml version="1.0"?>';
        $xmlTarefa = $xmlTarefa . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTarefa = $xmlTarefa . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlTarefa);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de tarefa!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlTarefa = "'" . $xmlTarefa . "'";

    $sql = "ntl.pregaoEmAndamento_Atualiza 
        $codigo,
        $observacao, 
        $usuario, 
        $situacao,
        $posicao,
        $dataReaberturaPregao,
        $horaReaberturaPregao,
        $dataAlerta,
        $horaAlerta,
        $prioridade,
        $condicao,
        $observacaoCondicao,
        $xmlTarefa
        ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success';
    if ($result < 1) {
        $ret = 'failed';
    }
    echo $ret;
    return;
}

function recupera()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $codigo = +$_POST["codigo"];
    }

    $sql = "SELECT codigo, portal, ativo, orgaoLicitante, objetoLicitado, oportunidadeCompra,numeroPregao,dataPregao,horaPregao,
    usuarioCadastro,dataCadastro,observacao,garimpado,condicao,observacaoCondicao,situacao,posicao, dataReabertura,horaReabertura,
    dataAlerta,horaAlerta, prioridade, resumoPregao,usuarioAlteracao,dataAlteracao, grupoResponsavel, responsavel  FROM ntl.pregao WHERE (0=0) AND codigo = " . $codigo;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $row = $result[0];
    $codigo = $row['codigo'];
    $codigoPortal = $row['portal'];
    $ativo = $row['ativo'];
    $nomeOrgaoLicitante = $row['orgaoLicitante'];
    $objetoLicitado = $row['objetoLicitado'];
    $oportunidadeCompra = $row['oportunidadeCompra'];
    $numeroPregao = $row['numeroPregao'];
    $dataPregao = $row['dataPregao'];
    $horaPregao = $row['horaPregao'];
    $usuarioCadastro = $row['usuarioCadastro'];
    $dataCadastro = $row['dataCadastro'];
    $usuarioAlteracao = $row['usuarioAlteracao'];
    $dataAlteracao = $row['dataAlteracao'];
    $observacao  = $row['observacao'];

    $situacao = $row['situacao'];
    $posicao =  $row['posicao'];
    $dataReaberturaPregao = $row['dataReabertura'];
    $horaReaberturaPregao = $row['horaReabertura'];
    $dataAlerta = $row['dataAlerta'];
    $horaAlerta = $row['horaAlerta'];
    $prioridade = $row['prioridade'];
    $resumoPregao = $row['resumoPregao'];
    $condicao = $row['condicao'];
    $observacaoCondicao = $row['observacaoCondicao'];

    $grupoResponsavel = $row['grupoResponsavel'];
    $responsavelPregao = $row['responsavel'];


    $reposit = "";
    $result = "";
    $sql = "SELECT PANAD.codigo, PANAD.tarefa, PANAD.responsavel, PANAD.dataFinal, PANAD.dataSolicitacao, PANAD.dataConclusao, PANAD.observacao, PANAD.tipo
    FROM ntl.pregaoDetalhe  PANAD
    INNER JOIN ntl.pregao PANA ON PANA.codigo = PANAD.pregao
    WHERE (0=0) AND PANA.codigo = " . $codigo;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorTarefa = 0;
    $arrayTarefa = array();
    $arrayPrePregao = array();
    foreach ($result as $row) {

        $tarefa = (int)$row['tarefa'];
        $responsavel = (int)$row['responsavel'];
        $dataFinal = validaDataRecupera($row['dataFinal']);
        $dataSolicitacao = $row['dataSolicitacao'];
        $dataConclusao = validaDataRecupera($row['dataConclusao']);
        $tipo = (int)$row['tipo'];


        if ($dataSolicitacao != "") {
            $horario = explode(" ", $dataSolicitacao);
            $horario = explode(":", $horario[1]);
            $dataSolicitacao = date("d-m-Y", strtotime($dataSolicitacao));
            $dataSolicitacao = str_replace('-', '/', $dataSolicitacao);
            $dataSolicitacao = $dataSolicitacao . " " . $horario[0] . ":" . $horario[1];
        }

        $observacaoPrePregao = $row['observacao'];

        $contadorTarefa = $contadorTarefa + 1;
        if ($tipo == "1") {
            $arrayTarefa[] = array(
                "sequencialTarefa" => $contadorTarefa,
                "tarefa" => $tarefa,
                "responsavel" => $responsavel,
                "dataFinal" => $dataFinal,
                "dataSolicitacao" => $dataSolicitacao,
                "observacaoPrePregao" => $observacaoPrePregao,
                "dataConclusao" => $dataConclusao,
                "tipo" => $tipo
            );
        }
        $strArrayTarefa = json_encode($arrayTarefa);

        if ($tipo == "0") {
            $arrayPrePregao[] = array(
                "sequencialTarefa" => $contadorTarefa,
                "tarefa" => $tarefa,
                "responsavel" => $responsavel,
                "dataFinal" => $dataFinal,
                "dataSolicitacao" => $dataSolicitacao,
                "observacaoPrePregao" => $observacaoPrePregao,
                "dataConclusao" => $dataConclusao,
                "tipo" => $tipo
            );
        }
        $strArrayPrePregao = json_encode($arrayPrePregao);
    }

    $out =   $codigo . "^" .
        $codigoPortal . "^" .
        $ativo . "^" .
        $nomeOrgaoLicitante . "^" .
        $objetoLicitado . "^" .
        $oportunidadeCompra . "^" .
        $numeroPregao . "^" .
        $dataPregao . "^" .
        $horaPregao . "^" .
        $usuarioCadastro . "^" .
        $dataCadastro . "^" .
        $observacao . "^" .
        $situacao . "^" .
        $posicao . "^" .
        $dataReaberturaPregao . "^" .
        $horaReaberturaPregao . "^" .
        $dataAlerta . "^" .
        $horaAlerta . "^" .
        $prioridade . "^" .
        $resumoPregao . "^" .
        $condicao . "^" .
        $observacaoCondicao . "^" .
        $usuarioAlteracao . "^" .
        $dataAlteracao . "^" .
        $grupoResponsavel . "^" .
        $responsavelPregao;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayTarefa . "#" . $strArrayPrePregao;
    return;
}


function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PREGOESEMANDAMENTO_ACESSAR|PREGOESEMANDAMENTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $codigo = $_POST["codigo"];

    if ((empty($_POST['codigo']) || (!isset($_POST['codigo'])) || (is_null($_POST['codigo'])))) {
        $mensagem = "Selecione um pregão.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('ntl.pregao' . '|' . 'ativo = 0' . '|' . 'codigo =' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    } else {
        $reposit->update('ntl.pregao' . '|' . 'prioridade = 0' . '|' . 'codigo =' . $codigo);
    }
    echo 'sucess#' . $result;
    return;
}


function validaString($value)
{
    $null = 'NULL';
    if ($value == '')
        return $null;
    return '\'' . $value . '\'';
}

function validaNumero($value)
{
    if ($value == "") {
        $value = 'NULL';
    }
    return $value;
}

function validaCodigo($value)
{
    return $value;
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

function validaDataRecupera($value)
{
    if ($value == "") {
        $value = '';
        return $value;
    }
    $value = date('d/m/Y', strtotime($value));
    return $value;
}

function validaVerifica($value)
{
    if ($value == "") {
        $value = NULL;
    }
    return $value;
}

function verificaDiretorio($enderecoPasta)
{

    /*Verifica se o diretório com o endereço especificado existe,
    se não, ele cria e atribui permissões de leitura e gravação. */

    if (!file_exists($enderecoPasta)) {
        mkdir($enderecoPasta, 0777, true);
        chmod($enderecoPasta, 0777);
    }
}


function tiraAcento($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
}
