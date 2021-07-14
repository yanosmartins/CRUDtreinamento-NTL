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
if ($funcao == 'verificaDescricao') {
    call_user_func($funcao);
}

return;

function grava()
{

    //Variáveis
    if ((empty($_POST['id'])) || (!isset($_POST['id'])) || (is_null($_POST['id']))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = (int) $_POST["ativo"];
    }

    session_start();
    $nome = "'" . $_POST['nome'] . "'";
    $cpf = "'" . $_POST['cpf'] . "'";
    $dataNascimento =$_POST['dataNascimento'];
    $dataNascimento = explode("/", $dataNascimento);
    $dataNascimento = "'" . $dataNascimento[2] . "-" . $dataNascimento[1] . "-" . $dataNascimento[0] . "'";

    $sql = 'cadastro_Atualiza ' . $id . ',' . $ativo . ',' . $nome . ',' . $cpf . ',' . $dataNascimento . ' ';

    $reposit = new reposit();
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
        $cargoIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT C.codigo,C.ativo,C.descricao,C.cbo,C.descricaoMT,C.codigoCargoSCI from Ntl.cargo C WHERE (0 = 0)";

    if ($condicaoId) {
        $sql = $sql . " AND C.[codigo] = " . $cargoIdPesquisa . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if($row = $result[0]) {
        $id = +$row['codigo'];
        $ativo = +$row['ativo'];
        $descricao = $row['descricao'];
        $cbo =  $row['cbo'];
        $descricaoMT =  $row['descricaoMT'];
        $codigoCargoSCI = +$row['codigoCargoSCI'];


        $out = $id . "^" . $ativo . "^" . $descricao . "^" . $cbo . "^" . $descricaoMT . "^" . $codigoCargoSCI;

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
    $possuiPermissao = $reposit->PossuiPermissao("CARGO_ACESSAR|CARGO_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um cargo para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    
    $result = $reposit->update('Ntl.cargo' .'|'.'ativo = 0'.'|'.'codigo ='.$id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function verificaDescricao()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CARGO_ACESSAR|CARGO_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $descricao = "'" . $_POST["descricao"] . "'";

    $sql = "SELECT * FROM Ntl.cargo WHERE (0=0) AND descricao = " . $descricao;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $row = $result[0];
    if ($row == false) {
        echo ('sucess#');
        return;
    }
    echo 'failed#';
    return;
}
