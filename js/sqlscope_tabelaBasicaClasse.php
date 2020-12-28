<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaClasse') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaClasse') {
    call_user_func($funcao);
}

if ($funcao == 'excluirClasse') {
    call_user_func($funcao);
}

return;

function gravaClasse()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("CLASSE_ACESSAR|CLASSE_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    session_start();
    $usuario = $_SESSION['login'];
    $usuario =  "'$usuario'";
    $classe = $_POST['classe'];
    $codigo =  +$classe['codigo'];
    $descricao = $classe['descricao'];
    $descricao = "'$descricao'";
    $reducaoBaseIR = $classe['reducaoBaseIR'];
    $ativo = $classe['ativo'];


    $sql = "Ntl.classe_Atualiza(
        $codigo,
        $descricao,	
        $reducaoBaseIR,
        $usuario,
        $ativo
        )";

    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}


function recuperaClasse()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT codigo, descricao, reducaoBaseIR, ativo FROM dbo.classe WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result))) {
        $row = array_map('utf8_encode', $row);
        $codigo = +$row['codigo'];
        $descricao = $row['descricao'];
        $reducaoBaseIR = +$row['reducaoBaseIR'];
        $ativo = +$row['ativo'];
    }

    $out =   $codigo . "^" .
        $descricao . "^" .
        $reducaoBaseIR . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function excluirClasse()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CLASSE_ACESSAR|CLASSE_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um classe.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $sql = "UPDATE Ntl.classe SET ativo = 0 WHERE codigo = $id";

    $result = $reposit->RunQuery($sql);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
