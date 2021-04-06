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

    $reposit = new reposit(); //Abre a conexão.   
 
    session_start();
    $codigo =  (int)$_POST['codigo'];
    $descricao = "'".$_POST['descricao']."'";
    $ativo = 1; 
    $corFonte =  "'".$_POST['corFonte']."'";
    $corFundo =  "'".$_POST['corFundo']."'";
    $usuario = "'".$_SESSION['login']."'"; 
     
    $sql = "Ntl.situacao_Atualiza  
        $codigo,
        $descricao,  
        $ativo,
        $corFonte, 
        $corFundo,
        $usuario
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

    $sql = "SELECT codigo, descricao, ativo, corFonte, corFundo  FROM Ntl.situacao WHERE (0=0) AND codigo = " . $codigo;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $row = $result[0];

    $codigo = $row['codigo'];
    $descricao = $row['descricao']; 
    $ativo = $row['ativo']; 
    $corFonte = $row['corFonte'];
    $corFundo = $row['corFundo'];

    $out =   $codigo . "^" .
        $descricao . "^" .
        $ativo . "^" .
        $corFonte . "^" .
        $corFundo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess|" . $out;
    return;
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("SITUACAO_ACESSAR|SITUACAO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
      return;
    }

    $codigo = $_POST["codigo"];

    if ((empty($_POST['codigo']) || (!isset($_POST['codigo'])) || (is_null($_POST['codigo'])))) {
        $mensagem = "Selecione uma situação.";
        echo "failed#" . $mensagem . ' ';
        return;
    }


    $result = $reposit->update('Ntl.situacao' . '|' . 'ativo = 0' . '|' . 'codigo =' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}