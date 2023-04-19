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


    $comum = new comum();
    $strArrayTelefone = $_POST['jsonTelefoneArray'];
    $arrayTelefone = $strArrayTelefone;
    $xmlTelefone = new \FluidXml\FluidXml('ArrayOfTelefone', ['encoding' => '']);
    foreach ($arrayTelefone as $item) {
        $xmlTelefone->addChild('telefoneFuncionario', true) //nome da tabela
            ->add('telefone', $item['telefone']) //setando o campo e definindo o valor
            ->add('telefonePrincipal', $item['telefonePrincipal'])
            ->add('telefoneWhatsApp', $item['telefoneWhatsApp'])
            // ->add('sequencialTelefone', $item['sequencialTelefone'])
            // ->add('telefoneId', $item['telefoneId'])
            ;
    }
    $xmlTelefone = $comum->formatarString($xmlTelefone);


    $sql = "dbo.Funcionario_Atualiza 
            $id, 
            $ativo,
            '$nome', 
            '$cpf',
            '$dataNascimento',
            '$rg',
            '$genero',           
            '$estadoCivil',
             $xmlTelefone
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
    
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);    
    
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
    

    $id = $_POST["codigo"];
    



    $sql = "SELECT codigo, nome, ativo, cpf, rg, dataNascimento, genero, estadoCivil FROM dbo.funcionario WHERE codigo = $id";
    // $sql = " SELECT FU.codigo, FU.ativo, FU.cpf, FU.rg, FU.dataNascimento, FU.estadoCivil, FU.nome, GF.descricao as genero from dbo.funcionario FU
    // LEFT JOIN dbo.generoFuncionario GF on GF.codigo = FU.genero";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        $id = (int)$row['codigo'];
        $ativo = (int)$row['ativo'];
        $nomeCompleto = (string)$row['nome'];
        $cpf = (string)$row['cpf'];
        $rg = (string)$row['rg'];
        $estadoCivil = (int)$row['estadoCivil'];
        $genero = (int)$row['genero'];
        $dataNascimento = (string)$row['dataNascimento'];
        $dataNascimento = explode("-", $dataNascimento);
        $dataNascimento = $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];

     

        $out =  $id . "^" .
            $ativo . "^" .
            $nomeCompleto . "^" .
            $cpf . "^" .
            $rg. "^" .
            $dataNascimento. "^" .
            $estadoCivil. "^" .
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