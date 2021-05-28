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

    // Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("NATUREZAOPERACAO_ACESSAR|NATUREZAOPERACAO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $codigo = (int)$_POST['id'];
    $tipo = (int)$_POST['tipo'];
    $descricao = "'" . $_POST['descricao'] . "'";
    if (validaNaturezaOperacao($descricao) && $codigo == 0) {
        echo "failed#" . "Fabricante já cadastrado!";
        return;
    }
    $ativo = (int)$_POST['ativo'];

    $sql = "Estoque.naturezaOperacao_Atualiza
            $codigo,
            $tipo,
            $ativo,
            $descricao,
            $usuario";

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
        $codigo = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT codigo,descricao,ativo FROM Estoque.naturezaOperacao WHERE (0 = 0)";

    if ($condicaoId) {
        $sql = $sql . " AND codigo = " . $codigo . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if($row = $result[0]) {

        $id = (int)$row['codigo'];
        $descricao = (string)$row['descricao'];
        $ativo = (int)$row['ativo'];

        $out = $id . "^" . $descricao . "^" . $ativo;

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
    $possuiPermissao = $reposit->PossuiPermissao("NATUREZAOPERACAO_ACESSAR|NATUREZAOPERACAO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um lancamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }


    $result = $reposit->update('Estoque.naturezaOperacao' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function validaNaturezaOperacao($descricao)
{
    $sql = "SELECT codigo,descricao,ativo FROM Estoque.naturezaOperacao 
    WHERE descricao LIKE $descricao and ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($result[0]) {
        return true;
    } else {
        return false;
    }
}