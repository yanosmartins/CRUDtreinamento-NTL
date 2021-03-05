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

if ($funcao == 'populaComboGrupoItem') {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CODIGOITEM_ACESSAR|CODIGOITEM_GRAVAR"); // Checa permissões

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
 
    $id = (int)$_POST['id'];
    $codigoItem = (string)"'" . $_POST['codigoItem'] . "'";
    $codigoFabricante = (string)"'" . $_POST['codigoFabricante'] . "'";
    $descricaoItem = (string)"'" . $_POST['descricaoItem'] . "'";
    $estoque = (int)$_POST['estoque'];
    $grupoItem = (int)$_POST['grupoItem'];
    $localizacaoItem = (int)$_POST['localizacaoItem'];
    $ativo = (int)$_POST['ativo'];
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.

    $sql = "Ntl.codigoItem_Atualiza
            $id,
            $codigoItem,
            $codigoFabricante,
            $descricaoItem,
            $estoque,
            $grupoItem,
            $localizacaoItem,
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

function recupera()
{

    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT CI.codigo,CI.codigoItem,CI.codigoFabricante,CI.descricaoItem,CI.estoque,CI.grupoItem,CI.localizacaoItem,CI.ativo
            FROM Ntl.codigoItem AS CI WHERE codigo = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        //Accordion Dados
        $id = (int)$row['codigo'];
        $codigoItem = $row['codigoItem'];
        $codigoFabricante = $row['codigoFabricante'];
        $descricaoItem = $row['descricaoItem'];
        $estoque = $row['estoque'];
        $grupoItem = $row['grupoItem'];
        $localizacaoItem = $row['localizacaoItem'];
        $ativo = (int)$row['ativo'];
      
        $out = $id . "^" .
            $codigoItem . "^" .
            $codigoFabricante . "^" .
            $descricaoItem . "^" .
            $estoque . "^" .
            $grupoItem . "^" .
            $localizacaoItem . "^" .
            $ativo;

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
    $possuiPermissao = $reposit->PossuiPermissao("CODIGOITEM_ACESSAR|CODIGOITEM_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um campo para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('ntl.codigoItem' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function populaComboGrupoItem()
{
    $estoque = $_POST["estoque"];
    if ($estoque > 0) {
        $sql = "SELECT codigo, descricao, estoque FROM Ntl.grupoItem 
                WHERE ativo = 1 AND estoque = $estoque ORDER BY descricao";

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contador = 0;
        $out = "";
        foreach ($result as $row) {
            $id = $row['codigo'];
            $descricao = $row['descricao'];

            $out = $out . $id . "^" . $descricao . "|";

            $contador = $contador + 1;
        }
        if ($out != "") {
            echo "sucess#" . $contador . "#" . $out;
            return;
        }
        echo "failed#";
        return;
    }
}
