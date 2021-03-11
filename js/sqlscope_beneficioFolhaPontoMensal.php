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
    // $possuiPermissao = $reposit->PossuiPermissao("LANCAMENTO_ACESSAR|LANCAMENTO_GRAVAR");

    // if ($possuiPermissao === 0) {
    //     $mensagem = "O usuário não tem permissão para gravar!";
    //     echo "failed#" . $mensagem . ' ';
    //     return;
    // }

    session_start();
    $usuario = $_SESSION['login'];
    
    /* Objeto com os arrays de objetos com dias,horas e etc para montar o XML */
    $arrayFolhaPontoMensal = $_POST['folhaPontoMensalTabela'];

    /* Objeto com o informações que não pertencem ao array do XML */
    $folhaPontoInfo = $_POST['folhaPontoInfo'];

    $codigo = (int) $folhaPontoInfo;
    $funcionarioFolha = (int) $folhaPontoInfo; 
    $mesFolha = (int) $folhaPontoInfo;
    $anoFolha = (int) $folhaPontoInfo;
    $observacaoFolha = (string)$folhaPontoInfo;

    /* Verificar como os dados estão sendo passados e então montar o XML */

    $xmlFolhaPontoMensal = "";
    $nomeXml = "ArrayOfPonto";
    $nomeTabela = "ponto";
    $xmlFolhaPontoMensal = "<?xml version=\"1.0\"?>";
    $xmlFolhaPontoMensal .= "<$nomeXml xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">";
    foreach($arrayFolhaPontoMensal as $folha){
        $xmlFolhaPontoMensal .= "<$nomeTabela>";
        foreach($folha as $key => $value){
            $xmlFolhaPontoMensal .= "<$key>$value</$key>";
        }
        $xmlFolhaPontoMensal .= "<$nomeTabela>";
    }
    $xmlFolhaPontoMensal .= "</\"$nomeXml\">";
    $xml = simplexml_load_string($xmlFolhaPontoMensal);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlFolhaPontoMensal = "'" . $xmlFolhaPontoMensal . "'";
   
    $sql = 
        "Ntl.folhaPontoMensal_Atualiza 
        $codigo,
        $funcionarioFolha,
        $observacaoFolha,
        $usuario,
        $xmlFolhaPontoMensal
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

 

    $sql = 
        "SELECT F.codigo, F.funcionario, F.observacao,
        FROM Ntl.folhaPontoMensal F
        INNER JOIN Ntl.funcionario FU ON FU.codigo = F.funcionario
        WHERE (0=0) AND F.codigo = " . $id
    ;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])

    $id = $row['codigo'];
    $funcionario = $row['funcionario'];
    $observacao = $row['observacao'];

    $out =   
        $id . "^" .
        $funcionario . "^" .
        $observacao
    ;

    if ($out == "") {
        echo "failed#";
        return;
    }

    $sql = 
        "SELECT P.dia,P.mes,P.ano,P.horaEntrada,P.horaSaida,
        P.inicioAlmoco,P.fimAlmoco,P.lancamento
        FROM Ntl.ponto P 
        INNER JOIN Ntl.folhaPontoMensal F 
        ON F.codigo = P.folhaPontoMensal 
        WHERE (0=0) AND F.codigo = " . $id
    ;

    $result = $reposit->RunQuery($sql);

    $arrayPonto = array();

    foreach($result as $row){

        $arrayRow = array(
            "dia"           =>  $row[""],
            "entrada"       =>  $row[""],
            "inicioAlmoco"  =>  $row[""],
            "fimAlmoco"     =>  $row[""],
            "saida"         =>  $row[""],
            "horaExtra"     =>  $row[""],
            "atraso"        =>  $row[""],
            "lancamento"    =>  $row[""]
        );

        array_push($arrayPonto,$arrayRow);
    }

    echo "sucess#" . $out . $arrayPonto;
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
