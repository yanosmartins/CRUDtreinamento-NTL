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

function grava() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("MOTIVOAFASTAMENTO_ACESSAR|MOTIVOAFASTAMENTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $id = +$_POST['id'];
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $descricao = "'" . $_POST['descricao'] . "'"; 
    $ativo = +$_POST["ativo"];
 
    $sql = "Ntl.motivoAfastamento_Atualiza ($id,$ativo,$descricao, $usuario) ";
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera() {
    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    if (($condicaoId === false) && ($condicaoLogin === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if (($condicaoId === true) && ($condicaoLogin === true)) {
        $mensagem = "Somente 1 parâmetro de pesquisa deve ser informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoId) {
        $motivoDoAfastamentoIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT codigo,ativo,descricao from Ntl.motivoAfastamento WHERE (0=0)";

    if ($condicaoId) {
        $sql = $sql . " AND codigo = " . $motivoDoAfastamentoIdPesquisa . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    
    if (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $ativo = +$row['ativo']; 
        $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES'); 
         
        $out = $id . "^" . $ativo . "^" . $descricao ;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }
} 

function excluir() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("MOTIVOAFASTAMENTO_ACESSAR|MOTIVOAFASTAMENTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um registro para excluir.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    
    $reposit = new reposit();
    $result = $reposit->update('motivoAfastamento'.'|'.'ativo = 0' . '|'. 'codigo ='. $id); 
      
    if ($result < 1) {
        echo('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}