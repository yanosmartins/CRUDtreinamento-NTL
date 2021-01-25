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
    $possuiPermissao = $reposit->PossuiPermissao("DECIMOTERCEIRO_ACESSAR|DECIMOTERCEIRO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = (string)$_SESSION['login'];
    $codigo =  (int) $_POST['codigo'];
    $percentual =  (float)$_POST['percentual'];
    $ativo = (int)$_POST['ativo'];

    $sql = "Ntl.decimoTerceiro_Atualiza
        $codigo ,
        $ativo ,
        $percentual ,
        $usuario
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

    $sql = "SELECT codigo, percentual, ativo FROM Ntl.decimoTerceiro
    WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])


    $id = (int)$row['codigo'];
    $percentual = (float)$row['percentual'];
    $ativo = (int)$row['ativo'];

    $out =   $id . "^" .
        $percentual . "^" .
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
    $possuiPermissao = $reposit->PossuiPermissao("DECIMOTERCEIRO_ACESSAR|DECIMOTERCEIRO_GRAVAR|DECIMOTERCEIRO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = +$_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Valor.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Ntl.decimoTerceiro' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
