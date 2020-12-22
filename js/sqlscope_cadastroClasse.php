<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaClasse') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaClasse') {
    call_user_func($funcao);
}

if ($funcao == 'excluirClasse') {
    call_user_func($funcao);
}

return;

function gravaClasse()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("CLASSE_ACESSAR|CLASSE_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    session_start();
    $reposit = new reposit();
    $usuario = $_SESSION['login'];
    $classe = $_POST['classe'];
    $codigo =  validaCodigo($classe['codigo'] ?: 0);
    $descricao = validaString($classe['descricao']);
    $reducaoBaseIR = validaString($classe['reducaoBaseIR']);


    $sql = "dbo.classe_Atualiza(
        $codigo,
        $descricao,	
        $reducaoBaseIR,
        $usuario,
        $usuario
        )";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);



    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}


function recuperaClasse()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT codigo, descricao, reducaoBaseIR FROM dbo.classe WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);
    $codigo = $row['codigo'];
    $descricao = $row['descricao'];
    $reducaoBaseIR = $row['reducaoBaseIR'];

    $out =   $codigo . "^" .
        $descricao . "^" .
        $reducaoBaseIR;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function excluirClasse()
{

    $reposit = new reposit();

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um classe.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $sql = "classe_Deleta ($id)";

    $reposit = new reposit();
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
