<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'grava') {
    call_user_func($funcao);
}

if ($funcao == 'validarProcessaBeneficio') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("ENCARGO_ACESSAR|ENCARGO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'$usuario'";

    $codigo = (int) $_POST['codigo'];
    $mesAno = (string)$_POST['mesAnoReferencia'];
    $mesAno = explode("-", $mesAno);
    $mesAno = "'" . $mesAno[1] . '/' . $mesAno[0] . "'";

    $projeto = (int)$_POST['projeto'];
    $ativo = 1;

    //Inicio do Json ProcessaBeneficio
    $strJsonProcessaBeneficio = $_POST['JsonArrayProcessabeneficio'];
    $arrayJsonProcessaBeneficio = json_decode($strJsonProcessaBeneficio, true);
    $xmlJsonProcessaBeneficio = "";
    $nomeXml = "ArrayOfProcessaBeneficio";
    $nomeTabela = "processaBeneficioDetalhe";
    if (sizeof($arrayJsonProcessaBeneficio) > 0) {
        $xmlJsonProcessaBeneficio = '<?xml version="1.0"?>';
        $xmlJsonProcessaBeneficio = $xmlJsonProcessaBeneficio . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonProcessaBeneficio as $chave) {
            $xmlJsonProcessaBeneficio = $xmlJsonProcessaBeneficio . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                // if (($campo === "sequencialProcessaBeneficio")) {
                //     continue;
                // }
                $xmlJsonProcessaBeneficio = $xmlJsonProcessaBeneficio . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonProcessaBeneficio = $xmlJsonProcessaBeneficio . "</" . $nomeTabela . ">";
        }
        $xmlJsonProcessaBeneficio = $xmlJsonProcessaBeneficio . "</" . $nomeXml . ">";
    } else {
        $xmlJsonProcessaBeneficio = '<?xml version="1.0"?>';
        $xmlJsonProcessaBeneficio = $xmlJsonProcessaBeneficio . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonProcessaBeneficio = $xmlJsonProcessaBeneficio . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonProcessaBeneficio);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML do processa beneficio";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonProcessaBeneficio = "'" . $xmlJsonProcessaBeneficio . "'";
    //Fim do Json ProcessaBeneficio

    $sql = "Beneficio.processaBeneficio_Atualiza
        $codigo,
        $ativo,
        $mesAno,
        $projeto,
        $usuario,
        $xmlJsonProcessaBeneficio";

    $reposit = new reposit();

    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function validarProcessaBeneficio()
{
    $projeto = +$_POST["projeto"];
    $mesAno = "'" . (string)$_POST["mesAno"] . "'";

    $sql = "SELECT codigo,projeto,mesAno,ativo
                FROM Beneficio.processaBeneficio
                WHERE mesAno = $mesAno AND projeto = $projeto AND ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($result[0]) {
        echo "failed#";
        return;
    } else {
        echo "sucess#";
        return;
    }
}