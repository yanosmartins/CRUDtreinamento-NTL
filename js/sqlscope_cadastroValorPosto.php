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
    session_start();
    $usuario = $_SESSION['login'];
    $valorPosto = $_POST['valorPosto'];
    $codigo = +$valorPosto['codigo'];
    $projeto = +$valorPosto['projeto'];
    $descricaoPosto =  +$valorPosto['descricaoPosto'];
    $valor = $valorPosto['valor'];
    $valor = limparValor($valor); 
    $horaExtraSegSab = +$valorPosto['horaExtraSegSab'];
    $horaExtraDomFer =  +$valorPosto['horaExtraDomFer'];
    $adicionalNoturno =  +$valorPosto['adicionalNoturno'];
    $atrasos = "'" . $valorPosto['atrasos'] . "'";
    $ativo = $valorPosto['ativo'];



    $sql = "Ntl.valorPosto_Atualiza(
                $codigo,
                $projeto,
                $descricaoPosto,
                $valor,
                $horaExtraSegSab,
                $horaExtraDomFer,
                $adicionalNoturno,
                $atrasos,
                $ativo,
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


function recupera()
{

    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT 
    codigo,
    projeto,
    descricaoPosto,
    valor,
    horaExtraSegSab,
    horaExtraDomFer,
    adicionalNoturno,
    atrasos,
    ativo
     FROM Ntl.valorPosto
    WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);

    $id = +$row['codigo'];
    $projeto = +$row['projeto'];
    $descricaoPosto = +$row['descricaoPosto'];
    $valor =  +$row['valor'];
    $valor = preencherValor($valor); 
    $horaExtraSegSab =  +$row['horaExtraSegSab'];
    $horaExtraDomFer =  +$row['horaExtraDomFer'];
    $adicionalNoturno =  +$row['adicionalNoturno'];
    $atrasos =  $row['atrasos'];
    $ativo = $row['ativo'];
    


    $out =   $id . "^" .
    $projeto. "^" . 
    $descricaoPosto. "^" .
    $valor. "^" .
    $horaExtraSegSab. "^" .
    $horaExtraDomFer. "^" .
    $adicionalNoturno. "^" .
    $atrasos. "^" .
    $ativo ;


    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function preencheFuncionario()
{
    $funcionario = +$_POST['funcionario'];

    $reposit = new reposit();


    $sql = "SELECT P.codigo,  P.salarioFuncionario, P.projeto, P.funcionario, F.nome, numeroCentroCusto, descricao, apelido AS nomeFuncionario, C.descricao
    FROM Ntl.beneficioProjeto P

    LEFT JOIN syscbNTL.syscb.funcionario F ON funcionario = F.codigo
    LEFT JOIN syscbNTL.syscb.cargo C ON cargo = C.codigo
     WHERE P.codigo = $funcionario";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";

    if (($row = odbc_fetch_array($result))) {
        $row = array_map('utf8_encode', $row);

        // $funcionario = $row['nomeFuncionario'];
        $cargo = $row['descricao'];
        $salario =  $row['salarioFuncionario'];
    }


    $out =  
        $cargo . "^" .
        $salario;

    if ($out != '' || $out == 0) {
        echo "sucess#" . $out;
    }
    return;
}
function excluir()
{

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Código de Servico.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "UPDATE Ntl.valorPosto SET ativo ='0' WHERE codigo=$id";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
function limparValor($string)
{
    $string = preg_replace('/[^A-Za-z0-9,\-]/', '', $string);
    $string = str_replace(',', '.', $string);
    return +$string;
}

function preencherValor($string)
{
    // $string = preg_replace('/[^A-Za-z0-9,\-]/', '', $string);
    $string = str_replace('.', ',', $string);

    return $string;
}







