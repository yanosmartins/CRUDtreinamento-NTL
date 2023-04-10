<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravar') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosUsuario') {
    call_user_func($funcao);
}
if ($funcao == 'VerificaCPF') {
    call_user_func($funcao);
}
if ($funcao == 'ValidaCPF') {
    call_user_func($funcao);
}
if ($funcao == 'VerificaRG') {
    call_user_func($funcao);
}


return;

function gravar()
{

    $reposit = new reposit();

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = (int) $_POST["ativo"];
    }

    $id = (int)$_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $dataNascimento = $_POST['dataNascimento'];
    $dataNascimento = implode("-", array_reverse(explode("/", $dataNascimento)));
    $rg = $_POST['rg'];
    $genero = $_POST['genero'];
    $estadoCivil= (int)$_POST['estadoCivil'];


    $sql = "dbo.Funcionario_Atualiza 
            $id, 
            $ativo,
            '$nome', 
            '$cpf',
            '$dataNascimento',
            '$rg',
            '$genero',           
            '$estadoCivil'
            ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}



function VerificaCPF(){
////////verifica registros duplicados

    $cpf = $_POST["cpf"];
    
    $sql = "SELECT cpf, codigo FROM dbo.funcionario WHERE cpf='$cpf'";
    //achou 
    // $sql = "SELECT cpf FROM dbo.funcionario WHERE (0 = 0) AND" . "' cpf ='".$cpf;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);    
    // $result = $reposit->RunQuery($sql);
    // if ($id > 0) {
    //     $sql = "SELECT codigo FROM dbo.funcionario WHERE cpf='$cpf' and codigo =$id";
    // }
    ////! ANTES É NEGAÇÃO
    if (!$result){
        echo  'success#';
    }
    else{
        $mensagem = "CPF já registrado!";
        echo "failed#" . $mensagem .' ';    
    }
    
}



function ValidaCPF() {
 
    // Extrai somente os números
    $cpf = $_POST["cpf"];
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        echo "failed";
        return;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        echo "failed";
        return;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            echo "failed";
            return;
        }
    }
    echo "success";
    return;

}


function VerificaRG(){
    ////////verifica registros duplicados
    
        $rg = $_POST["rg"];
        
        $sql = "SELECT rg FROM dbo.funcionario WHERE rg='$rg'";
        //achou 
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);    

        ////! ANTES É NEGAÇÃO
        if (!$result){
            echo  'success#';
        }
        else{
            $mensagem = "RG já registrado!";
            echo "failed#" . $mensagem .' ';
        }
        
    }



function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("USUARIO_ACESSAR|USUARIO_EXCLUIR");


    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'" . $usuario . "'";

    $result = $reposit->update('dbo.funcionario' .'|'.'ativo = 0'.'|'.'codigo ='.$id);


    $reposit = new reposit();

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}


function recupera()
{
    $condicaoId = !((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"])));
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
        $id = $_POST["codigo"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }


    $sql = "SELECT codigo, nome, ativo, cpf, rg, dataNascimento FROM dbo.funcionario WHERE (0 = 0)";


    if ($condicaoId) {
        $sql = $sql . " AND codigo = " . $id . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        $id = (int)$row['codigo'];
        $ativo = (int)$row['ativo'];
        $nomeCompleto = (string)$row['nome'];
        $cpf = (string)$row['cpf'];
        $rg = (string)$row['rg'];
        $genero = (int)$row['genero'];
        $dataNascimento = (string)$row['dataNascimento'];
        $dataNascimento = explode("-", $dataNascimento);
        $dataNascimento = $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];
     

        $out =  $id . "^" .
            $ativo . "^" .
            $nomeCompleto . "^" .
            $cpf . "^" .
            $dataNascimento . "^" .
            $rg.
            $genero;

  if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out;
        }
        return;
    }
}