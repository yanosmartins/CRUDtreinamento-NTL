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

if ($funcao == 'verificar') {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PONTOELETRONICOMENSAL_ACESSAR|PONTOELETRONICOMENSAL_GRAVAR");

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
    $status = (int) $folhaPontoInfo['status'];
    $mesAno = (string) $folhaPontoInfo['mesAno'];
    $data = explode('-', $mesAno);
    $totalDiasMes = cal_days_in_month(CAL_GREGORIAN, $data[1], $data[0]);

    if ($funcionario == 0) {
        $funcionario = (int)$_SESSION["funcionario"];
        if ($funcionario == 0) {
            echo "failed#" . "Funcionário não encontrado";
            return;
        }
    }

    $sql =  "SELECT F.codigo, F.mesAno FROM Funcionario.folhaPontoMensal F 
    INNER JOIN Ntl.funcionario FU ON F.funcionario = FU.codigo 
    WHERE (0=0) 
    AND F.mesAno BETWEEN '$mesAno' AND '$data[0]-$data[1]-$totalDiasMes' 
    AND FU.codigo = $funcionario";

    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        if ($row)
            $codigo = $row["codigo"];
    }

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
            if (in_array($key, ['horaEntrada', 'horaSaida'])) {
                if ($value == '') {
                    $xmlFolhaPontoMensal .= "<$key>00:00:00</$key>";
                } else {
                    $xmlFolhaPontoMensal .= "<$key>$value</$key>";
                }
                continue;
            }
            if (in_array($key, ['inicioAlmoco','fimAlmoco','horaExtra', 'atraso'])) {
                if ($value == '') {
                    $xmlFolhaPontoMensal .= "<$key>00:00</$key>";
                } else {
                    $xmlFolhaPontoMensal .= "<$key>$value</$key>";
                }
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
        '$mesAno',
        $observacao,
        $status,
        $usuario,
        $xmlFolhaPontoMensal
    ";


    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#Ponto gravado com sucesso!';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera()
{
    session_start();

    $funcionario = (int)$_POST["funcionario"];
    $mesAno = $_POST["mesAno"];
    $mesAno = preg_replace("/\d\d$/","01",$mesAno);

    $data = explode('-', $mesAno);
    $totalDiasMes = cal_days_in_month(CAL_GREGORIAN, $data[1], $data[0]);
    $folha = "";

    if (!$funcionario) {
        $funcionario = (int)$_SESSION["funcionario"];
    }
        $sql = "SELECT F.codigo AS 'folha',FU.codigo AS 'funcionario' FROM Funcionario.folhaPontoMensal F
            INNER JOIN Ntl.funcionario FU ON F.funcionario = FU.codigo
            WHERE FU.codigo = $funcionario  AND F.mesAno BETWEEN '$mesAno' AND '$data[0]-$data[1]-$totalDiasMes'";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        $folha = $row['folha'];
        $funcionario = $row['funcionario'];
    }

    $sql =
        "SELECT F.codigo, FU.codigo AS 'funcionario', F.mesAno, F.status, F.observacao, P.limiteEntrada AS 'limiteAtraso', P.limiteSaida AS 'limiteExtra'
        FROM Funcionario.folhaPontoMensal F
        INNER JOIN Ntl.funcionario FU ON FU.codigo = F.funcionario
        LEFT JOIN Ntl.beneficioProjeto BP ON FU.codigo = BP.funcionario 
        LEFT JOIN Ntl.projeto P ON P.codigo = BP.projeto
        WHERE (0=0) AND F.codigo = " . $folha;

    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {

        $folha = trim($row['codigo']);
        $funcionario = trim($row['funcionario']);

        $mesAno = trim($row['mesAno']);

        if ($mesAno != "") {
            $data = explode(' ', $mesAno);
            $mesAno = $data[0];
        } else {
            $mesAno = "";
        }

        $observacao = trim($row['observacao']);
        $status = (int)trim($row['status']);
        $toleranciaAtraso = trim($row['limiteAtraso']);
        $toleranciaExtra = trim($row['limiteExtra']);

        $out =
            $folha . "^" .
            $funcionario . "^" .
            $observacao . "^" .
            $mesAno . "^" .
            $toleranciaAtraso . "^" .
            $toleranciaExtra. "^" .
            $status;
    }

    if ($out == "") {
        echo "failed#" . "$out#";
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

    $result = $reposit->update('Funcionario.folhaPontoMensal' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function verificar(){
    /*<-->Espaço destinada a variáveis ou funções utilitárias<-->*/
    session_start();
    $reposit = new reposit();
    $lancamento = $_POST['lancamento'];
    
    $search = "abonaAtraso";
    $table = "Ntl.lancamento";
    $sql = "SELECT ". $search ." FROM ". $table ." WHERE codigo = ". $lancamento ."";
    $result = $reposit->RunQuery($sql);
    /* <-->Função destinada para consultar dados relacionados a página<--> */
    $row = $result[0];
    $abonaAtraso = (int)$row['abonaAtraso'];

    /*<-->Espaço destinado ao envio de dados<-->*/
    $out = $abonaAtraso;

    if ($out == "") {
        echo "failed#" . "$out#";
        return;
    }

    echo "sucess#" . "$out#";
    return;

}
