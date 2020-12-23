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
    $possuiPermissao = $reposit->PossuiPermissao("BENEFICIOINDIRETO_ACESSAR|BENEFICIOINDIRETO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    session_start();
    $usuario = $_SESSION['login'];
    $codigo =  +$_POST['codigo'];
    $descricao = "'" .$_POST['descricao']. "'";
    $ativo = + $_POST['ativo'];

    $sql = "Ntl.periodoVigencia_Atualiza(
        $codigo ,
        $descricao ,
        $ativo ,
        $usuario
        )";

    $reposit = new reposit();
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
        $id = +$_POST["id"];
    }

    $sql = "SELECT codigo, descricao, ativo FROM Ntl.periodoVigencia
    WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);

    $id = $row['codigo'];
    $descricao = $row['descricao'];
    $ativo = $row['ativo'];

    $out =   $id . "^" .
        $descricao . "^" .
        $ativo;

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
        $id = +$_POST["id"];
    }

    $sql = "UPDATE Ntl.periodoVigencia SET ativo = 0 WHERE codigo=$id";
    $result = $reposit->RunQuery($sql);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
