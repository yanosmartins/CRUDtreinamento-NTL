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
    $possuiPermissao = $reposit->PossuiPermissao("GRUPOITEM_ACESSAR|GRUPOITEM_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $codigo =  (int) $_POST['codigo'];
    $estoque =  (int) $_POST['estoque'];
    $descricao = "'" . $_POST['descricao'] . "'";
    $unidade =  (int) $_POST['unidade'];
    $ativo = 1;

    if (validaGrupoItem($descricao, $estoque)) {
        $mensagem = "Já existe este item neste estoque.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $sql = "Estoque.grupoItem_Atualiza
            $codigo, 
            $estoque,
            $descricao, 
            $ativo, 
            $usuario,
            $unidade";

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
    $condicaoCodigo = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
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
        $codigo = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT codigo, estoque, descricao, ativo, unidade FROM Estoque.grupoItem WHERE (0 = 0) ";

    if ($condicaoCodigo) {
        $sql = $sql . " AND codigo = " . $codigo . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        $codigo = (int)$row['codigo'];
        $estoque = (int)$row['estoque'];
        $descricao = $row['descricao'];
        $unidade = (int)$row['unidade'];

        $out = $codigo . "^" .
            $descricao . "^" .
            $estoque . "^" .
            $unidade;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }
}

function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("GRUPOITEM_ACESSAR|GRUPOITEM_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione uma estoque!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Estoque.grupoItem' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function validaGrupoItem($descricao, $estoque)
{
    $sql = "SELECT codigo,[descricao],ativo FROM Estoque.grupoItem
    WHERE [descricao] LIKE $descricao AND [estoque] = $estoque AND ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($result[0]) {
        return true;
    } else {
        return false;
    }
}
