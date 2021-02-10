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
    $possuiPermissao = $reposit->PossuiPermissao("LANCAMENTO_ACESSAR|LANCAMENTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = $_SESSION['login'];
    $lancamentoTabela = $_POST['lancamentoTabela'];
    $codigo =  (int) $lancamentoTabela['codigo'];

    //Inicio do Json Lançamento
    $strJsonLancamento = $lancamentoTabela["JsonLancamento"];
    $arrayJsonLancamento = json_decode($strJsonLancamento, true);
    $xmlJsonLancamento = "";
    $nomeXml = "ArrayOfContratoLancamento";
    $nomeTabela = "contratoLancamento";
    if (sizeof($arrayJsonLancamento) > 0) {
        $xmlJsonLancamento = '<?xml version="1.0"?>';
        $xmlJsonLancamento = $xmlJsonLancamento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonLancamento as $chave) {
            $xmlJsonLancamento = $xmlJsonLancamento . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialLancamento")) {
                    continue;
                }
                if ($valor == 'Selecione') {
                    $valor = NULL;
                }
                $xmlJsonLancamento = $xmlJsonLancamento . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonLancamento = $xmlJsonLancamento . "</" . $nomeTabela . ">";
        }
        $xmlJsonLancamento = $xmlJsonLancamento . "</" . $nomeXml . ">";
    } else {
        $xmlJsonLancamento = '<?xml version="1.0"?>';
        $xmlJsonLancamento = $xmlJsonLancamento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonLancamento = $xmlJsonLancamento . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonLancamento);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonLancamento = "'" . $xmlJsonLancamento . "'";


    //Fim do Json  Lancamento
   
    $sql = "Ntl.lancamentoFolhaPonto_Atualiza
        $codigo ,
        $xmlJsonLancamento 
        ";


    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera()
{

    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

 

    $sql = "SELECT F.codigo, F.funcionario, FU.nome as nomeFuncionario, F.projeto, P.descricao as projetoDescricao, F.mesAnoFolhaPonto,F.ativo 
    FROM Beneficio.folhaPonto F

    LEFT JOIN Ntl.funcionario FU ON FU.codigo = F.funcionario
    LEFT JOIN Ntl.projeto P ON P.codigo = F.projeto
    WHERE (0=0) AND F.codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])


    $id = $row['codigo'];
    $projeto = $row['projeto'];
    $funcionario = $row['funcionario'];
    $mesAnoFolhaPonto = $row['mesAnoFolhaPonto'];

    $mesAnoFolhaPonto = ($row['mesAnoFolhaPonto']);
    if ($row['mesAnoFolhaPonto'] != "") {
        $aux = explode(' ', $row['mesAnoFolhaPonto']);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data =  $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $mesAnoFolhaPonto = $data;
    } else {
        $mesAnoFolhaPonto = '';
    }

    $out =   $id . "^" .
    $funcionario . "^" .
        $projeto . "^" .
        $mesAnoFolhaPonto;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("LANCAMENTO_ACESSAR|LANCAMENTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Caução.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $result = $reposit->update('Ntl.LANCAMENTO' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
