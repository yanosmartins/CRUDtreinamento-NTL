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
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FOLHAPONTO_ACESSAR|FOLHAPONTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" .  $_SESSION['login'] . "'";

    /* Objeto com os arrays de objetos com dias,horas e etc para montar o XML */


    /* Objeto com o informações que não pertencem ao array do XML */
    $folhaPontoInfo = $_POST['folhaPontoInfo'];

    $codigo = (int) $folhaPontoInfo['codigo'];
    $funcionario = (int) $folhaPontoInfo['funcionario'];
    $observacao = "'" . (string)$folhaPontoInfo['observacao'] . "'";
    $ativo = (int) $folhaPontoInfo['ativo'];

    /* Objeto com o informações pertencentes ao array do XML */
    $folhaPontoMensal = $_POST['folhaPontoMensalTabela'];
    $arrayFolhaPontoMensal = $folhaPontoMensal;
    $xmlFolhaPontoMensal = "";
    $nomeXml = "ArrayOfPonto";
    $nomeTabela = "ponto";
    $xmlFolhaPontoMensal = "<?xml version=\"1.0\"?>";
    $xmlFolhaPontoMensal .= "<$nomeXml xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">";
    foreach ($arrayFolhaPontoMensal as $folha) {
        $xmlFolhaPontoMensal .= "<$nomeTabela>";
        foreach ($folha as $key => $value) {
            if (in_array($key, ['horaEntrada', 'horaSaida', 'horaExtra', 'atraso'])) {
                if ($value == '') {
                    $xmlFolhaPontoMensal .= "<$key>00:00:00</$key>";
                } else {
                    $xmlFolhaPontoMensal .= "<$key>$value</$key>";
                }
                continue;
            }
            if (in_array($key, ['inicioAlmoco', 'fimAlmoco'])) {
                if ($value == '') {
                    $xmlFolhaPontoMensal .= "<$key>00:00</$key>";
                } else {
                    $xmlFolhaPontoMensal .= "<$key>$value</$key>";
                }
                continue;
            }
            if ($key == 'mes') {
                $xmlFolhaPontoMensal .= "<$key>" . (int)$value . "</$key>";
                continue;
            }
            $xmlFolhaPontoMensal .= "<$key>$value</$key>";
        }
        $xmlFolhaPontoMensal .= "</$nomeTabela>";
    }
    $xmlFolhaPontoMensal .= "</$nomeXml>";
    $xml = simplexml_load_string($xmlFolhaPontoMensal);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlFolhaPontoMensal = "'" . $xmlFolhaPontoMensal . "'";

    $sql =
        "Funcionario.folhaPontoMensal_Atualiza 
        $codigo,
        $funcionario,
        $observacao,
        $usuario,
        $xmlFolhaPontoMensal
    ";


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

    $funcionario = $_POST["funcionario"];
    $mesAno = $_POST["mesAno"];
    if ($mesAno != "") {
        $aux = explode('/', $mesAno);
        $data = $aux[0] . '-' . $aux[1]."-01";
        $data =  trim($data);
        $mesAno = $data;
    } else {
        $mesAno = '';
    }
    $folha = "";

    if ($funcionario != 0) {
        $sql = "SELECT F.codigo AS 'folha',FU.codigo AS 'funcionario' FROM Funcionario.folhaPontoMensal F
        INNER JOIN Ntl.funcionario FU ON F.funcionario = FU.codigo
        INNER JOIN Ntl.usuario U ON U.funcionario = FU.codigo
        WHERE FU.codigo = " . $funcionario ." AND F.mesAno like '%$mesAno' ";
    } else {
        $sql = "SELECT F.codigo AS 'folha',FU.codigo AS 'funcionario' FROM Funcionario.folhaPontoMensal F
            INNER JOIN Ntl.funcionario FU ON F.funcionario = FU.codigo
            INNER JOIN Ntl.usuario U ON U.funcionario = FU.codigo
            WHERE U.login = '" . $_SESSION['login'] . "'" ." AND F.mesAno like '%$mesAno' ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        $folha = $row['folha'];
        $funcionario = $row['funcionario'];
    }

    $sql =
        "SELECT F.codigo, FU.codigo AS 'funcionario', F.mesAno, F.observacao
        FROM Funcionario.folhaPontoMensal F
        INNER JOIN Ntl.funcionario FU ON FU.codigo = F.funcionario
        WHERE (0=0) AND F.codigo = " . $folha;

    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {

        $folha = $row['codigo'];
        $funcionario = $row['funcionario'];

        $mesAno = $row['mesAno'];
        
        if ($mesAno != "") {
            $aux = explode(' ', $mesAno);
            $data = $aux[0];
            $data =  trim($data);
            $aux = explode('-', $data);
            $data = $aux[1] . '/' . $aux[0];
            $data =  trim($data);
            $mesAno = $data;
        } else {
            $mesAno = '';
        }


        $observacao = $row['observacao'];

        $out =
            $folha . "^" .
            $funcionario . "^" .
            $observacao . "^" .
            $mesAno;
    }

    if ($out == "") {
        echo "failed#";
        return;
    }

    $sql =  "SELECT FD.dia,FD.horaEntrada,FD.horaSaida,FD.inicioAlmoco,FD.fimAlmoco,FD.horaExtra,FD.atraso,FD.lancamento 
    FROM Funcionario.folhaPontoMensalDetalheDiario FD 
    INNER JOIN Funcionario.folhaPontoMensal F ON F.codigo = FD.folhaPontoMensal
    WHERE (0=0) AND F.codigo = " . $folha;

    $result = $reposit->RunQuery($sql);

    $arrayPonto = array();

    foreach ($result as $row) {

        $arrayRow = array(
            "dia"           =>  $row["dia"],
            "entrada"       =>  $row["horaEntrada"],
            "inicioAlmoco"  =>  $row["inicioAlmoco"],
            "fimAlmoco"     =>  $row["fimAlmoco"],
            "saida"         =>  $row["horaSaida"],
            "horaExtra"     =>  $row["horaExtra"],
            "atraso"        =>  $row["atraso"],
            "lancamento"    =>  $row["lancamento"]
        );

        array_push($arrayPonto, $arrayRow);
    }

    $jsonFolha = json_encode($arrayPonto);

    echo "sucess#" . "$out#" . $jsonFolha;
    return;
}

function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FOLHAPONTO_ACESSAR|FOLHAPONTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Caução.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $result = $reposit->update('Funcionario.FOLHAPONTO' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
