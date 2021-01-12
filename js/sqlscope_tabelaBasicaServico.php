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
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $codigo = +$_POST['id'];
    $descricaoCodigo = "'" . $_POST['descricaoCodigo'] . "'";
    $descricaoServico = "'" . $_POST['descricaoServico'] . "'";
    $ativo = +$_POST['ativo'];

    $sql = "Ntl.servico_Atualiza(
        $codigo ,
        $descricaoCodigo ,
        $ativo ,
        $descricaoServico,
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

    $sql = "SELECT codigo, descricaoCodigo, descricaoServico, ativo FROM Ntl.servico
    WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);

    $id = $row['codigo'];
    $descricaoCodigo = $row['descricaoCodigo'];
    $descricaoServico = $row['descricaoServico'];
    $ativo = $row['ativo'];

    $out =   $id . "^" .
        $descricaoCodigo . "^" .
        $descricaoServico . "^" .
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

    $possuiPermissao = $reposit->PossuiPermissao("SERVICO_ACESSAR|SERVICO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Código de Servico.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $result = $reposit->update('Ntl.servico' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
