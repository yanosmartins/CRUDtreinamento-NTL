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
if ($funcao == 'verificaDependente') {
    call_user_func($funcao);
}



function gravar()
{

    $reposit = new reposit();

    $descricao = $_POST['descricao'];
    $ativo = (int)$_POST['ativo'];
    $codigo = (int)$_POST['codigo'];

    $sql = "dbo.Dependentes_Atualiza 
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
    $sql = "SELECT ativo, descricao FROM dbo.dependente WHERE codigo = $codigo";



    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {
        $ativo = (int)$row['ativo'];
        $descricao = $row['descricao'];

        $out =  $ativo . "^" .
            trim($descricao);

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
    
    // $codigo = $_GET["codigo"];

    session_start();

    $result = $reposit->update('dbo.dependente' .'|'.'ativo = 0'.'|'.'codigo ='.$codigo);

    $reposit = new reposit();

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function verificaDependente()
{
    $descricao = $_POST["descricao"];
    $codigo = $_POST["codigo"];
    $sql = "SELECT descricao FROM dbo.dependente WHERE descricao='$descricao' and codigo !='$codigo'";
    //achou 
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if (!$result) {    ////! ANTES É NEGAÇÃO
        echo  'success#';
    } else {
        echo "failed#";
        return true;
    }
}