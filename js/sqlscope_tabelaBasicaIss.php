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
<<<<<<< HEAD
=======

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("ISS_ACESSAR|ISS_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

>>>>>>> Breno
    session_start();
    $usuario = $_SESSION['login'];
    $iss = $_POST['iss'];
    $codigo = +$iss['codigo'];
    $percentual = +$iss['percentual'];
    $ativo = +$iss['ativo'];


<<<<<<< HEAD
    $sql = "dbo.iss_Atualiza(
=======
    $sql = "Ntl.iss_Atualiza(
>>>>>>> Breno
        $codigo ,
        $ativo ,
        $percentual,
        $usuario
        )";

<<<<<<< HEAD
    $reposit = new reposit();
=======
>>>>>>> Breno
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

<<<<<<< HEAD
    $sql = "SELECT codigo, ativo, percentual FROM dbo.iss  
=======
    $sql = "SELECT codigo, ativo, percentual FROM Ntl.iss  
>>>>>>> Breno
    WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);

    $id = $row['codigo'];
    $percentual = +$row['percentual'];
    $ativo = $row['ativo'];




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

<<<<<<< HEAD
=======
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("ISS_ACESSAR|ISS_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

>>>>>>> Breno
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um ISS.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }



<<<<<<< HEAD
    $sql = "UPDATE dbo.iss SET ativo ='0' WHERE codigo=$id";
    $reposit = new reposit();
=======
    $sql = "UPDATE Ntl.iss SET ativo ='0' WHERE codigo=$id";
>>>>>>> Breno
    $result = $reposit->RunQuery($sql);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
