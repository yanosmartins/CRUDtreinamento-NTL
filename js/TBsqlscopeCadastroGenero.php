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

if ($funcao == 'verificaGenero') {
    call_user_func($funcao);
}

return;

function gravar()
{

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

function verificaGenero()
{
    ////////verifica registros duplicados
    $descricao = $_POST["descricao"];
    $sql = "SELECT descricao FROM dbo.generoFuncionario WHERE descricao='$descricao'";
    //achou 
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    ////! ANTES É NEGAÇÃO
    if (!$result) {
        echo  'success#';
    } else {
        $mensagem = "Gênero já registrado!";
        echo "failed#" . $mensagem . ' ';
        return true;
    }
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
    $codigo = $_POST["codigo"];
    $reposit = new reposit();

    session_start();

    $result = $reposit->update('dbo.generoFuncionario' .'|'.'generoAtivo = 0'.'|'.'codigo ='.$codigo);

    $reposit = new reposit();

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

