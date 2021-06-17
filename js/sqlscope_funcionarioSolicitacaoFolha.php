<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];


if ($funcao == 'recuperaSolicitante') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaSolicitado') {
    call_user_func($funcao);
}
if ($funcao == 'gravaSolicitante') {
    call_user_func($funcao);
}

return;

function gravaSolicitante()
{

    session_start();
    $reposit = new reposit();
    $result = "";
    $funcionario = $_SESSION["funcionario"];
    $usuario = $_SESSION['login'];
    $jsonSolicitacao = $_POST["json"];

    //================ XML ================
    $xmlSolicitante = "";
    $nomeXml = "ArrayOfSolicitante";
    $nomeTabela = "solicitacao";

    if (sizeof($jsonSolicitacao) > 0) {

        $xmlSolicitante = '<?xml version="1.0"?>';
        $xmlSolicitante = $xmlSolicitante . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($jsonSolicitacao as $solicitacao) {

            $xmlSolicitante = $xmlSolicitante . "<" . $nomeTabela . ">";
            $xmlSolicitante = $xmlSolicitante . "<dia>" . $solicitacao["dia"] . "</dia>";
            $xmlSolicitante = $xmlSolicitante . "<funcionario>" . $funcionario . "</funcionario>";
            $xmlSolicitante = $xmlSolicitante . "<campo>" . $solicitacao["campo"] . "</campo>";
            $xmlSolicitante = $xmlSolicitante . "<horas>" . $solicitacao["horas"] . "</horas>";
            $xmlSolicitante = $xmlSolicitante . "<dataReferente>" . $solicitacao["dataReferente"] . "</dataReferente>";
            $xmlSolicitante = $xmlSolicitante . "<justificativa>" . $solicitacao["justificativa"] . "</justificativa>";
            $xmlSolicitante = $xmlSolicitante . "<ativo>" . 1 . "</ativo>";
            $xmlSolicitante = $xmlSolicitante . "<usuarioCadastro>" . $usuario . "</usuarioCadastro>";
            $xmlSolicitante = $xmlSolicitante . "</" . $nomeTabela . ">";
        }
        $xmlSolicitante = $xmlSolicitante . "</" . $nomeXml . ">";
    } else {
        $xmlSolicitante = '<?xml version="1.0"?>';
        $xmlSolicitante = $xmlSolicitante . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlSolicitante = $xmlSolicitante . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlSolicitante);
    if ($xml === false) {
        $mensagem = "Erro na criação das solicitações";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlSolicitante = "'" . $xmlSolicitante . "'";

    //================ SQL ================
    $sql = "Funcionario.solicitacaoFolha_Atualiza $funcionario, $xmlSolicitante";

    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#Solicitação gravada com sucesso!';
    if ($result < 1) {
        $ret = 'failed#Houve um problema durante a gravação da solicitação!';
    }
    echo $ret;

    return;
}

function recuperaSolicitante()
{

    session_start();
    $reposit = "";
    $result = "";
    $funcionario = $_SESSION["funcionario"];

    $sql = "SELECT codigo,dia,campo,horas,mesAno as 'dataReferente',justificativa 
    FROM Funcionario.solicitacaoFolha S
    INNER JOIN Ntl.funcionario F ON F.codigo = S.funcionario
    WHERE (0=0) AND F.codigo =" . $funcionario;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $arraySolicitacao = [];
    foreach ($result as $row) {

        $codigo = $row["codigo"];
        $dia = $row["dia"];
        $campo = $row["campo"];
        $horas = $row["horas"];
        $dataReferente = $row["dataReferente"];
        $justificativa = $row["justificativa"];

        $array =
            [
                "codigo" => $codigo,
                "dia" => $dia,
                "campo" => $campo,
                "horas" => $horas,
                "dataReferente" => $dataReferente,
                "justificativa" => $justificativa
            ];

        array_push($arraySolicitacao, $array);
    }

    $strArraySolicitacao = json_encode($arraySolicitacao);

    if ($strArraySolicitacao == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $strArraySolicitacao;
    return;
}

function recuperaSolicitado()
{
    session_start();
    $reposit = "";
    $result = "";
    $projeto = $_SESSION["projeto"];

    $sql = "SELECT S.codigo,S.funcionario,dia,campo,horas,mesAno as 'dataReferente',justificativa 
    FROM Funcionario.solicitacaoFolha S
    INNER JOIN Ntl.beneficioProjeto BP ON S.funcionario = BP.funcionario
    WHERE (0=0) AND BP.projeto = $projeto";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $sequencial = 0;
    $arraySolicitacao = [];
    foreach ($result as $row) {

        $sequencial++;
        $codigo = $row["codigo"];
        $funcionario = $row["funcionario"];
        $dia = $row["dia"];
        $campo = $row["campo"];
        $horas = $row["horas"];
        $dataReferente = $row["dataReferente"];
        $justificativa = $row["justificativa"];

        $array =
            [
                "sequencial" => $sequencial,
                "codigo" => $codigo,
                "funcionario" => $funcionario,
                "dia" => $dia,
                "campo" => $campo,
                "horas" => $horas,
                "dataReferente" => $dataReferente,
                "justificativa" => $justificativa
            ];

        array_push($arraySolicitacao, $array);
    }

    $strArraySolicitacao = json_encode($arraySolicitacao);

    if ($strArraySolicitacao == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $strArraySolicitacao;
    return;
}
