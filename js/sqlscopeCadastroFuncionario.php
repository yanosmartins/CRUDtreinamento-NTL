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
if ($funcao == 'validaCpfDependente'){
    call_user_func($funcao);
}
if ($funcao == 'VerificaRG') {
    call_user_func($funcao);
}
if ($funcao == 'verificaPispasep') {
    call_user_func($funcao);
}
return;

function gravar()
{
    $reposit = new reposit();

    $ativo = 1;
    $id = (int)$_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $dataNascimento = $_POST['dataNascimento'];
    $dataNascimento = implode("-", array_reverse(explode("/", $dataNascimento)));
    $rg = $_POST['rg'];
    $genero = $_POST['genero'];
    $estadoCivil = (int)$_POST['estadoCivil'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $uf = $_POST['uf'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $primeiroEmprego = $_POST['primeiroEmprego'];
    $pispasep = $_POST['pispasep'];
    if ($pispasep == "___._____.__-_") {
        $pispasep = "";
    }

    $comum = new comum();
    $strArrayTelefone = $_POST['jsonTelefoneArray'];
    $arrayTelefone = $strArrayTelefone;
    $xmlTelefone = new \FluidXml\FluidXml('ArrayOfTelefone', ['encoding' => '']);
    foreach ($arrayTelefone as $item) {
        $xmlTelefone->addChild('telefoneFuncionario', true) //nome da tabela
            ->add('telefone', $item['telefone']) //setando o campo e definindo o valor
            ->add('telefonePrincipal', $item['telefonePrincipal'])
            ->add('telefoneWhatsApp', $item['telefoneWhatsApp']);
    }
    $xmlTelefone = $comum->formatarString($xmlTelefone);

    $comum = new comum();
    $strArrayEmail = $_POST['jsonEmailArray'];
    $arrayEmail = $strArrayEmail;
    $xmlEmail = new \FluidXml\FluidXml('ArrayOfEmail', ['encoding' => '']);
    foreach ($arrayEmail as $item) {
        $xmlEmail->addChild('emailFuncionario', true) //nome da tabela
            ->add('Email', $item['Email']) //setando o campo e definindo o valor
            ->add('EmailPrincipal', $item['EmailPrincipal']);
    }
    $xmlEmail = $comum->formatarString($xmlEmail);

    $comum = new comum();
    $strArrayDependente = $_POST['jsonDependenteArray'];
    $arrayDependente = $strArrayDependente;
    $xmlDependente = new \FluidXml\FluidXml('ArrayOfDependentes', ['encoding' => '']);
    foreach ($arrayDependente as $item) {
        $xmlDependente->addChild('dependentesListaFuncionario', true) //nome da tabela
            ->add('dependente', $item['Dependente']) //setando o campo e definindo o valor
            ->add('nomeDependente', $item['nomeDependente'])
            ->add('cpfDependente', $item['cpfDependente'])
            ->add('dataNascimentoDependente', $item['dataNascimentoDependente'])
            ->add('tipoDependente', $item['tipoDependente']);
    }
    $xmlDependente = $comum->formatarString($xmlDependente);

    $sql = "dbo.Funcionario_Atualiza 
            $id, 
            $ativo,
            '$nome', 
            '$cpf',
            '$dataNascimento',
            '$rg',
            '$genero',           
            '$estadoCivil',
            $xmlTelefone,
            $xmlEmail,
            '$cep',
            '$logradouro',
            '$uf',
            '$bairro',
            '$cidade',
            '$numero',
            '$complemento',
            $xmlDependente,
            '$primeiroEmprego',
            '$pispasep'
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

function VerificaCPF()
{
    ////////verifica registros duplicados

    $cpf = $_POST["cpf"];
    $id = $_POST["id"];

    $sql = "SELECT cpf, codigo FROM dbo.funcionario WHERE cpf='$cpf'";

    //achou 

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    
    if ($id == 0){    
    }
    else{
        if (!$result) {
            echo  'success#';
        } else {  
            echo "failed#";
        }
    }
    ////! ANTES É NEGAÇÃO
    
}

function ValidaCPF()
{
    // Extrai somente os números
    $cpf = $_POST["cpf"];
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

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

function validaCpfDependente()
{
    // Extrai somente os números
    $cpfDependente = $_POST["cpfDependente"];
    $cpfDependente = preg_replace('/[^0-9]/is', '', $cpfDependente);
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpfDependente) != 11) {
        echo "failed";
        return;
    }
    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpfDependente)) {
        echo "failed";
        return;
    }
    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpfDependente[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpfDependente[$c] != $d) {
            echo "failed";
            return;
        }
    }
    echo "success";
    return;
}

function VerificaRG()
{
    ////////verifica registros duplicados
    $rg = $_POST["rg"];
    $sql = "SELECT rg FROM dbo.funcionario WHERE rg='$rg'";
    //achou 
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    ////! ANTES É NEGAÇÃO
    if (!$result) {
        echo  'success#';
    } else {
        $mensagem = "RG já registrado!";
        echo "failed#" . $mensagem . ' ';
    }
}

function verificaPispasep()
{
    ////////verifica registros duplicados
    $pispasep = $_POST["pispasep"];
    $sql = "SELECT pisPasep FROM dbo.funcionario WHERE pispasep='$pispasep'";
    //achou 
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    ////! ANTES É NEGAÇÃO
    if (!$result) {
        echo  'success#';
    } else {
        $mensagem = "Pis/Pasep já registrado!";
        echo "failed#" . $mensagem . ' ';
    }
}

function recupera()
{
    $id = $_POST["codigo"];

    $sql = "SELECT codigo, nome, ativo, cpf, rg, dataNascimento, estadoCivil, genero, cep, logradouro, uf, bairro, cidade, numero, complemento, primeiroEmprego, pisPasep  FROM dbo.funcionario WHERE codigo = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";

    if ($row = $result[0]) {
        $id = (int)$row['codigo'];
        $ativo = (int)$row['ativo'];
        $nomeCompleto = $row['nome'];
        $cpf = (string)$row['cpf'];
        $rg = (string)$row['rg'];
        $estadoCivil = (int)$row['estadoCivil'];
        $genero = (int)$row['genero'];
        $dataNascimento = (string)$row['dataNascimento'];
        $dataNascimento = explode("-", $dataNascimento);
        $dataNascimento = $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];
        $cep = (string)$row['cep'];
        $logradouro = (string)$row['logradouro'];
        $uf = (string)$row['uf'];
        $bairro = (string)$row['bairro'];
        $cidade = (string)$row['cidade'];
        $numero = (string)$row['numero'];
        $complemento = (string)$row['complemento'];
        $primeiroEmprego = (string)$row['primeiroEmprego'];
        $pisPasep = (string)$row['pisPasep'];     

        $out =  $id . "^" .
            $ativo . "^" .
            trim($nomeCompleto) . "^" .
            $cpf . "^" .
            $rg . "^" .
            $dataNascimento . "^" .
            $estadoCivil . "^" .
            $genero . "^" .
            $cep . "^" .
            $logradouro . "^" .
            $uf . "^" .
            $bairro . "^" .
            $cidade . "^" .
            $numero . "^" .
            $complemento . "^" .
            $primeiroEmprego . "^" .
            $pisPasep;
    }

    $sqlTelefone = "SELECT telefone, principal, whatsapp FROM dbo.telefoneFuncionario WHERE funcionarioId = $id";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sqlTelefone);

    $contador = 0;
    $arrayTelefone = [];
    foreach ($result as $contador => $item) {
        $sequencialTelefone = $contador + 1;

        array_push($arrayTelefone, [
            'codigo' => $item['codigo'],
            'telefone' => $item['telefone'],
            'telefonePrincipal' => $item['principal'],
            'telefoneWhatsApp' => $item['whatsapp'],
            'sequencialTelefone' => $sequencialTelefone

        ]);
    }
    $jsonTelefone = json_encode($arrayTelefone);


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $sqlEmail = "SELECT email, principal FROM dbo.emailFuncionario WHERE funcionarioId = $id";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sqlEmail);

    $contador = 0;
    $arrayEmail = [];
    foreach ($result as $contador => $item) {
        $sequencialEmail = $contador + 1;

        array_push($arrayEmail, [
            'codigo' => $item['codigo'],
            'Email' => $item['email'],
            'EmailPrincipal' => $item['principal'],
            'sequencialEmail' => $sequencialEmail

        ]);
    }
    $jsonEmail = json_encode($arrayEmail);

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $sqlDependente = "SELECT nome, cpf, dataNascimento, tipo FROM dbo.dependentesListaFuncionario WHERE funcionarioId = $id";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sqlDependente);

    $contador = 0;
    $arrayDependente = [];
    foreach ($result as $contador => $item) {
        $sequencialDependente = $contador + 1;

        array_push($arrayDependente, [
            'nomeDependente' => $item['nome'],
            'cpfDependente' => $item['cpf'],
            'dataNascimentoDependente' => $item['dataNascimento'],
            'tipoDependente' => $item['tipo'],
            'sequencialDependente' => $sequencialDependente

        ]);
    }
    $jsonDependente = json_encode($arrayDependente);




    if ($out == "") {
        echo "failed#";
    } else {
        echo "sucess#" . $out . "#" . $jsonTelefone . "#" . $jsonEmail . "#" . $jsonDependente;
    }
    return;
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

    $result = $reposit->update('dbo.funcionario' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);


    $reposit = new reposit();

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
