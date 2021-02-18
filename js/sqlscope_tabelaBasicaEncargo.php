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

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("ENCARGO_ACESSAR|ENCARGO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = $_SESSION['login'];

    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    $percentual = $_POST['percentual'];
    $ativo = 1;
    $percentual = str_replace(",", ".", $percentual);

    $sql = "Ntl.encargo_Atualiza
        $codigo,
        $descricao,
        $percentual,
        $ativo ,
        $usuario
        ";

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
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT codigo, descricao, percentual,ativo FROM Ntl.encargo WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $row = $result[0];

    $id = $row['codigo'];
    $descricao = $row['descricao'];
    $percentual = $row['percentual'];
    $ativo = $row['ativo'];
    $percentual = str_replace(".", ",", $percentual);

    $out =   $id . "^" .
        $descricao . "^" .
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
    $possuiPermissao = $reposit->PossuiPermissao("ENCARGO_ACESSAR|ENCARGO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Encargo.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $result = $reposit->update('Ntl.encargo' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
