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

if ($funcao == 'listaComboMunicipio') {
    call_user_func($funcao);
}

return;

function grava() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FORNECEDOR_ACESSAR|FORNECEDOR_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    //Variáveis
    session_start();
    $id =  $_POST['id'];
    $cnpj = $_POST['cnpj'];
    $razaoSocial =$_POST['razaoSocial'];  
    $apelido =$_POST['apelido'];  
    $ativo =$_POST['ativo'];  
    $logradouro =$_POST['logradouro'];  
    $numero =$_POST['numero'];  
    $complemento =$_POST['complemento'];  
    $bairro =$_POST['bairro']; 
    $cidade =$_POST['cidade'];  
    $uf =$_POST['uf'];   
    $notaFiscal =$_POST['notaFiscal'];  

    $sql = "Ntl.fornecedor_Atualiza ".
     $id . ",".
     $cnpj . "," .
     $razaoSocial . "," .
     $apelido . "," .
     $ativo . "," .
     $logradouro . "," .
     $numero  . "," .
     $complemento ." " . 
     $bairro ." " .
     $cidade ." " . 
     $uf ." " .
     $notaFiscal ." ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera() {
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
        $fornecedorIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT FO.[codigo], FO.[ativo], FO.[unidadeFederacao], FO.[municipio], FO.[descricao], FO.[cnpj], M.[descricao] AS nomeMunicipio
    FROM Ntl.fornecedor FO
    WHERE (0=0)";

    if ($condicaoId) {
        $sql = $sql . " AND FO.[codigo] = " . $fornecedorIdPesquisa . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    
    if($row = $result[0]) {
        $id = +$row['codigo'];
        $ativo = +$row['ativo']; 
        $unidadeFederacao = $row['unidadeFederacao'];
        $municipio = +$row['municipio']; 
        $descricao = $row['descricao'];
        $cnpj =  $row['cnpj'];
        $nomeMunicipio = $row['nomeMunicipio'];
        
        $out = $id . "^" . 
        $ativo . "^" . 
        $unidadeFederacao . "^" .
        $municipio  . "^" .
        $descricao . "^" .
        $cnpj. "^" .
        $nomeMunicipio
        ;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }
} 

function excluir() {

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FORNECEDOR_ACESSAR|FORNECEDOR_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um fornecedor.";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    
    $reposit = new reposit();
    $result = $reposit->update('Ntl.fornecedor'.'|'.'ativo = 0' . '|'. 'codigo ='. $id); 
     
    if ($result < 1) {
        echo('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function listaComboMunicipio(){

    $id = $_POST["codigo"];

    if ($id != "") {
        $sql = "SELECT * FROM Ntl.municipio WHERE (0 =0) AND  unidadeFederacao = '" . $id . "' AND ativo = 1";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $contador = 0;

    foreach($result as $row) {
        $id = $row['codigo'];
        $municipio = $row['descricao'];

        $out = $out . $id . "^" . $municipio . "|";
        $contador = $contador + 1;
    }
    if ($out == "") {
        echo "failed#0 ";
    }
    if ($out != '') {
        echo "sucess#" . $contador . "#" . $out;
    }
    return;
}

function formatarNumero($value)
{
    $aux = $value;
    $aux = str_replace('.', '', $aux);
    $aux = str_replace(',', '.', $aux);
    $aux = floatval($aux);
    if (!$aux) {
        $aux = 'null';
    }
    return $aux;
}

function formatarString($value)
{
    $aux = $value;
    $aux = str_replace("'", " ", $aux);
    if (!$aux) {
        return 'null';
    }
    $aux = '\'' . trim($aux) . '\'';
    return $aux;
}


function formatarData($value)
{
    $aux = $value;
    if (!$aux) {
        return 'null';
    }
    $aux = explode('/', $value);
    $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
    $data = '\'' . trim($data) . '\'';
    return $data;
}

//Transforma uma data Y-M-D para D-M-Y. 
function formataDataRecuperacao($campo)
{
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
} 
 