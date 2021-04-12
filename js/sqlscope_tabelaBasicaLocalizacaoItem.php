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
    $possuiPermissao = $reposit->PossuiPermissao("LOCALIZACAOITEM_ACESSAR|LOCALIZACAOITEM_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $codigo =  (int) $_POST['codigo'];
    $estoque =  (int) $_POST['estoque'];
    $localizacaoItem = "'" . $_POST['localizacaoItem'] . "'";
    
    if (validaLocalizacaoItem($estoque,$localizacaoItem) && $codigo == 0) {
        echo "failed#" . "Localização já cadastrada no estoque!";
        return;
    }
    // $ativo = (int) $_POST['ativo'];

    $sql = "Estoque.localizacaoItem_Atualiza
            $codigo, 
            $estoque,
            $localizacaoItem, 
            1, 
            $usuario
            ";

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

    $sql = "SELECT codigo, estoque, localizacaoItem, ativo FROM Estoque.localizacaoItem WHERE (0 = 0) ";

    if ($condicaoCodigo) {
        $sql = $sql . " AND codigo = " . $codigo . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        $codigo = (int)$row['codigo'];
        $estoque = (int)$row['estoque'];
        $localizacaoItem = $row['localizacaoItem'];

        $out = $codigo . "^" .
            $localizacaoItem . "^" .
            $estoque;

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
    $possuiPermissao = $reposit->PossuiPermissao("LOCALIZACAOITEM_ACESSAR|LOCALIZACAOITEM_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["codigo"];

    if ((empty($_POST['codigo']) || (!isset($_POST['codigo'])) || (is_null($_POST['codigo'])))) {
        $mensagem = "Selecione uma estoque!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Estoque.localizacaoItem' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function validaLocalizacaoItem($estoque,$localizacaoItem)
{
    $sql = "SELECT codigo,localizacaoItem,ativo FROM estoque.localizacaoItem 
    WHERE estoque = $estoque AND localizacaoItem LIKE $localizacaoItem and ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($result[0]) {
        return true;
    } else {
        return false;
    }
}