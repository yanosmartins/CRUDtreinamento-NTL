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

if ($funcao == 'recuperaApelido') {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit(); //Abre a conexão.
    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("CONVENIOSAUDE_ACESSAR|CONVENIOSAUDE_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $id = +$_POST["id"];
    $ativo = +$_POST["ativo"];
    $usuario = "'" . $_SESSION['login'] . "'"; //Pegando o nome do usuário mantido pela sessão.
    $apelido = "'" . $_POST['apelido'] . "'";
    $cnpj = "'" . $_POST['cnpj'] . "'";
    $descricao = "'" . $_POST['descricao'] . "'";
    $registroANS = "'" . $_POST['registroAns'] . "'" ;
    $seguroVida = +$_POST["seguroVida"];

    $sql = "Ntl.convenioSaude_Atualiza( $id, $ativo, $apelido, $cnpj, $descricao, $registroANS, $seguroVida, $usuario) ";
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
        $convenioSaudeIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT codigo, apelido, cnpj,descricao, registroAns, seguroVida, ativo
    FROM Ntl.convenioSaude WHERE (0 = 0)";

    if ($condicaoId) {
        $sql = $sql . " AND codigo = " . $convenioSaudeIdPesquisa . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if (($row = odbc_fetch_array($result))) {
        $row = array_map('utf8_encode', $row);
        $id = +$row['codigo'];
        $apelido = $row['apelido'];
        $cnpj = $row['cnpj'];
        $descricao = $row['descricao'];
        $registroAns = $row['registroAns'];
        $seguroVida = +$row['seguroVida'];
        $ativo = +$row['ativo'];

        $out = $id . "^" . $apelido . "^" . $cnpj . "^" . $descricao . "^" . $registroAns . "^" . $seguroVida . "^" . $ativo;

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
    $possuiPermissao = $reposit->PossuiPermissao("CONVENIOSAUDE_ACESSAR|CONVENIOSAUDE_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um convênio de saúde.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $result = $reposit->update('Ntl.convenioSaude' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

