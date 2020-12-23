<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaPosto') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaPosto') {
    call_user_func($funcao);
}

if ($funcao == 'excluirPosto') {
    call_user_func($funcao);
}

return;

function gravaPosto()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("POSTO_ACESSAR|POSTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    session_start();

    $usuario = $_SESSION['login'];
    $usuario = validaString($usuario);
    $posto = $_POST['posto'];
    $codigo =  validaCodigo($posto['codigo'] ?: 0);
    $descricao =  validaString($posto['descricao']);
    $ativo = validaNumero($posto['ativo']);

    $sql = "Ntl.posto_Atualiza(
        $codigo,
        $descricao,
        $ativo,
        $usuario
        )";

    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}


function recuperaPosto()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT codigo, descricao, ativo FROM Ntl.posto WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);
    $codigo = $row['codigo'];
    $descricao = $row['descricao'];
    $ativo = $row['ativo'];

    $out =   $codigo . "^" .
        $descricao . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function excluirPosto()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("POSTO_ACESSAR|POSTO_GRAVAR|POSTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um banco.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $sql = "UPDATE Ntl.posto SET ativo = 0 WHERE codigo = $id";

    $result = $reposit->Execprocedure($sql);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}


function validaString($value)
{
    $null = 'NULL';
    if ($value == '')
        return $null;
    return '\'' . $value . '\'';
}

function validaNumero($value)
{
    if ($value == "") {
        $value = 'NULL';
    }
    return $value;
}
function validaCodigo($value)
{
    return $value;
}
function validaData($value)
{
    if ($value == "") {
        $value = 'NULL';
        return $value;
    }
    $value = str_replace('/', '-', $value);
    $value = date("Y-m-d", strtotime($value));
    $value = "'" . $value . "'";
    return $value;
}

function validaDataRecupera($value)
{
    if ($value == "") {
        $value = '';
        return $value;
    }
    $value = date('d/m/Y', strtotime($value));
    return $value;
}
function validaVerifica($value)
{
    if ($value == "") {
        $value = NULL;
    }
    return $value;
}
