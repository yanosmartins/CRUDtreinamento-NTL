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
    $possuiPermissao = $reposit->PossuiPermissao("EMPRESA_ACESSAR|EMPRESA_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'$usuario'";

    $codigo = (int) $_POST['codigo'];
    $ativo = 1;
    $nome = "'" . $_POST['nome'] . "'";
    $codigoDepartamento = "'" . $_POST['codigoDepartamento'] . "'";
    $nomeDepartamento = "'" . $_POST['nomeDepartamento'] . "'";
    $responsavelRecebimento = "'" . $_POST['responsavelRecebimento'] . "'";
    $cep = "'" . $_POST['cep'] . "'";
    $tipoLogradouro = "'" . $_POST['tipoLogradouro'] . "'";
    $cep = "'" . $_POST['cep'] . "'";
    $tipoLogradouro = "'" . $_POST['tipoLogradouro'] . "'";
    $logradouro = "'" . $_POST['logradouro'] . "'";
    $numero = "'" . $_POST['numero'] . "'";
    $complemento = "'" . $_POST['complemento'] . "'";
    $uf = "'" . $_POST['uf'] . "'";
    $cidade = "'" . $_POST['cidade'] . "'";
    $bairro = "'" . $_POST['bairro'] . "'";

    $sql = "Ntl.empresa_Atualiza
        $codigo,
        $ativo,
        $nome,
        $codigoDepartamento,
        $nomeDepartamento,
        $responsavelRecebimento,
        $cep,
        $tipoLogradouro,
        $logradouro,
        $numero,
        $complemento,
        $uf,
        $cidade,
        $bairro,
        $usuario";

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
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT codigo, ativo, nome,codigoDepartamento,nomeDepartamento, responsavelRecebimento,
            cep,tipoLogradouro,logradouro,numero,complemento,bairro,cidade,uf
            FROM Ntl.empresa WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $row = $result[0];

    $id = $row['codigo'];
    $ativo = $row['ativo'];
    $nome = $row['nome'];
    $codigoDepartamento = $row['codigoDepartamento'];
    $nomeDepartamento = $row['nomeDepartamento'];
    $responsavelRecebimento = $row['responsavelRecebimento'];
    $cep = $row['cep'];
    $tipoLogradouro = $row['tipoLogradouro'];
    $logradouro = $row['logradouro'];
    $numero = $row['numero'];
    $complemento = $row['complemento'];
    $bairro = $row['bairro'];
    $cidade = $row['cidade'];
    $uf = $row['uf'];


    $out =  $id . "^" .
        $ativo . "^" .
        $nome . "^" .
        $codigoDepartamento . "^" .
        $nomeDepartamento . "^" .
        $responsavelRecebimento . "^" .
        $cep . "^" .
        $tipoLogradouro . "^" .
        $logradouro . "^" .
        $numero . "^" .
        $complemento . "^" .
        $bairro . "^" .
        $cidade . "^" .
        $uf; 


    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}
