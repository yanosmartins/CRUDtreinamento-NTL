<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaTarefa') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaTarefa') {
    call_user_func($funcao);
}

if ($funcao == 'excluirTarefa') {
    call_user_func($funcao);
}

return;

function gravaTarefa()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("TAREFA_ACESSAR|TAREFA_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    session_start();

    $usuario = $_SESSION['login'];
    $usuario = validaString($usuario);
    $tarefa = $_POST['tarefa'];
    $codigo =  validaCodigo($tarefa['codigo'] ?: 0);
    $descricao = validaString($tarefa['descricao']);
    $tipo = validaNumero($tarefa['tipo']);
    $visivel = validaNumero($tarefa['visivel']);
    $ativo = validaNumero($tarefa['ativo']);

    $sql = "Ntl.tarefa_Atualiza(
        $codigo,
        $descricao,	
        $tipo,
        $visivel,
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


function recuperaTarefa()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT codigo, descricao, tipo, visivel, ativo FROM Ntl.tarefa WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);
    $codigo = $row['codigo'];
    $descricao = $row['descricao'];
    $tipo = $row['tipo'];
    $visivel = $row['visivel'];
    $ativo = $row['ativo'];

    $out =   $codigo . "^" .
        $descricao . "^" .
        $tipo . "^" .
        $visivel . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function excluirTarefa()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("TAREFA_ACESSAR|TAREFA_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione uma tarefa para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    
    $result = $reposit->update('Ntl.tarefa' .'|'.'ativo = 0'.'|'.'codigo ='.$id);

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
