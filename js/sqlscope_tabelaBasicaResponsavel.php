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

    $reposit = new reposit(); //Abre a conexão.
    
    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("PORTAL_ACESSAR|PORTAL_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantcodigoo pela sessão.
    $codigo = $_POST['codigo'];
    $nome = "'" . $_POST['nome'] . "'";
    $telefone = "'" . $_POST['telefone']. "'" ;
    $ativo = (int) $_POST['ativo'];
 
    $sql = "Ntl.responsavel_Atualiza
            $codigo,
            $nome,
            $telefone,
            $ativo,
            $usuario";

    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera() {
    $condicaoCodigo = !((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    if (($condicaoCodigo === false) && ($condicaoLogin === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if (($condicaoCodigo === true) && ($condicaoLogin === true)) {
        $mensagem = "Somente 1 parâmetro de pesquisa deve ser informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoCodigo) {
        $codigo = $_POST["codigo"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT codigo, nome, telefone, ativo FROM Ntl.responsavel WHERE (0 = 0)";

    if ($condicaoCodigo) {
        $sql = $sql . " AND codigo = " . $codigo . " ";
    } 

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    
    if($row = $result[0]) {

        $codigo = +$row['codigo']; 
        $nome = $row['nome']; 
        $telefone = $row['telefone']; 
        $ativo = +$row['ativo'];  

        $out = $codigo . "^" . $nome . "^" . $telefone .  "^" . $ativo; 

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
    $possuiPermissao = $reposit->PossuiPermissao("RESPONSAVEL_ACESSAR|RESPONSAVEL_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["codigo"];

    if ((empty($_POST['codigo']) || (!isset($_POST['codigo'])) || (is_null($_POST['codigo'])))) {
        $mensagem = "Selecione um responsável.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
 
    $result = $reposit->update('Ntl.responsavel' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}