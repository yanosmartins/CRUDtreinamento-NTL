<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravar') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}


return;

function gravar()
{
    // if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
    //     $ativo = 0;
    // } else {
    //     $ativo = (int) $_POST["ativo"];
    // }

    $reposit = new reposit();

    $descricao = $_POST['descricao'];
    $ativo = (int)$_POST['ativo'];
    $codigo = (int)$_POST['codigo'];

    $sql = "dbo.Genero_Atualiza 
    $codigo
    ,'$descricao'
    ,$ativo
    ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}





function recupera()
{
    $codigo = $_POST["codigo"];
    $sql = "SELECT generoAtivo, descricao FROM dbo.generoFuncionario WHERE codigo = $codigo";



    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {
        $ativo = (int)$row['generoAtivo'];
        $descricao = $row['descricao'];

        $out =  $ativo . "^" .
            $descricao;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out;
        }
        return;
    }
}

function excluir()
{

    $reposit = new reposit();


    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'" . $usuario . "'";

    $result = $reposit->update('dbo.funcionario' .'|'.'ativo = 0'.'|'.'codigo ='.$id);


    $reposit = new reposit();

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}


