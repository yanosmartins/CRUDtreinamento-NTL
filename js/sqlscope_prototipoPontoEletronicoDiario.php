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


return;



function gravar()
{

    $reposit = new reposit(); //Abre a conexão.


    session_start();
    $usuario = $_SESSION['login'];
    $codigo = $_POST['codigo'];
    $funcionario = (int)$_POST['funcionario'];
    $mesAno = $_POST['mesAno'];
    $mesAno = preg_replace("/\d\d$/", "01", $mesAno);
    $idFolha = (int)$_POST['idFolha'];
    $status = (int)$_POST['status'];
    $dia = (int)$_POST['dia'];
    $horaEntrada = (string)$_POST['horaEntrada'];
    $horaSaida = (string)$_POST['horaSaida'];
    $inicioAlmoco = (string)$_POST['inicioAlmoco'];
    $fimAlmoco = (string)$_POST['fimAlmoco'];
    $horaExtra = (string)$_POST['horaExtra'];
    $atraso = (string)$_POST['atraso'];
    $lancamento = (int)$_POST['lancamento'];
    $observacao = (string)$_POST['observacao'];;


    $sql = "SELECT dia,horaEntrada,horaSaida,inicioAlmoco,fimAlmoco,horaExtra,atraso,lancamento
  FROM Funcionario.folhaPontoMensalDetalheDiario WHERE folhaPontoMensal = $idFolha";

   $result = $reposit->RunQuery($sql);


    $xmlFolhaPontoMensal = "";
    $nomeXml = "ArrayOfPonto";
    $nomeTabela = "ponto";
    $xmlFolhaPontoMensal = "<?xml version=\"1.0\"?>";
    $xmlFolhaPontoMensal .= "<$nomeXml xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">";
    if ($result) {


        foreach ($result as $row) {
            $xmlFolhaPontoMensal .= "<$nomeTabela>";
            foreach ($row as $key => $value) {
                if (in_array($key, ['horaEntrada', 'horaSaida'])) {
                    if ($value == '') {
                        $xmlFolhaPontoMensal .= "<$key>00:00:00</$key>";
                    } else {
                        $xmlFolhaPontoMensal .= "<$key>$value</$key>";
                    }
                    continue;
                }
                if (in_array($key, ['inicioAlmoco', 'fimAlmoco', 'horaExtra', 'atraso'])) {
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
    } else {
        $aux = explode('-', $mesAno);
        $ano = $aux[0];
        $mes = $aux[1];
        $totalDias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

        for ($i = 0; $i < $totalDias; $i++) {

            $xmlFolhaPontoMensal .= "<$nomeTabela><dia>";


            $xmlFolhaPontoMensal .=  $i+1 ."</dia>";
            $xmlFolhaPontoMensal .= "<horaEntrada>00:00:00</horaEntrada>";
            $xmlFolhaPontoMensal .= "<inicioAlmoco>00:00</inicioAlmoco>";
            $xmlFolhaPontoMensal .= "<fimAlmoco>00:00</fimAlmoco>";
            $xmlFolhaPontoMensal .= "<horaSaida>00:00:00</horaSaida>";
            $xmlFolhaPontoMensal .= "<horaExtra>00:00</horaExtra>";
            $xmlFolhaPontoMensal .= "<atraso>00:00</atraso>";
            $xmlFolhaPontoMensal .= "<lancamento>0</lancamento>";
            $xmlFolhaPontoMensal .= "</$nomeTabela>";
        }
    }
    $xmlFolhaPontoMensal .= "</$nomeXml>";
    $xml = simplexml_load_string($xmlFolhaPontoMensal);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }else{
        $xml->ponto[$dia-1]->dia=$dia;
        $xml->ponto[$dia-1]->horaEntrada=$horaEntrada;
        $xml->ponto[$dia-1]->inicioAlmoco=$inicioAlmoco;
        $xml->ponto[$dia-1]->fimAlmoco=$fimAlmoco;
        $xml->ponto[$dia-1]->horaSaida=$horaSaida;
        $xml->ponto[$dia-1]->horaExtra=$horaExtra;
        $xml->ponto[$dia-1]->atraso=$atraso;
        $xml->ponto[$dia-1]->lancamento=$lancamento;
        
        $xmlFolhaPontoMensal = $xml-> asXML();
    }
    $xmlFolhaPontoMensal = "'" . $xmlFolhaPontoMensal . "'";

    

    $sql =
        "Funcionario.folhaPontoMensal_Atualiza 
        $idFolha,
        $funcionario,
        '$mesAno',
        '$observacao',
        $status,
        $usuario,
        $xmlFolhaPontoMensal
    ";

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

    if ((empty($_POST["funcionario"])) || (!isset($_POST["funcionario"])) || (is_null($_POST["funcionario"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["funcionario"];
    }
    $mesAno = $_POST["mesAno"];
    $mesAno = preg_replace("/\d\d$/", "01", $mesAno);
    $dia = (int) $_POST["dia"];

    $sql = "SELECT F.codigo, F.status, FD.dia, FD.folhaPontoMensal,FD.codigo AS codigoDetalhe,FD.horaEntrada,FD.horaSaida,FD.inicioAlmoco,FD.fimAlmoco,FD.horaExtra,FD.atraso, FD.lancamento
    FROM Funcionario.folhaPontoMensal F 
    LEFT JOIN Funcionario.folhaPontoMensalDetalheDiario FD ON FD.folhaPontoMensal = F.codigo
    WHERE (0=0) AND funcionario = $id AND mesAno ='$mesAno 00:00:00' AND dia = $dia";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {

        $codigoDetalhe = (int)$row['codigoDetalhe'];
        $idFolha = (int)$row['codigo'];
        $horaEntrada = $row['horaEntrada'];
        $horaSaida = $row['horaSaida'];
        $inicioAlmoco = $row['inicioAlmoco'];
        $fimAlmoco = $row['fimAlmoco'];
        $horaExtra = $row['horaExtra'];
        $atraso = $row['atraso'];
        $lancamento = (int)$row['lancamento'];
        $status = (int)$row['status'];
    }

    $out =   $idFolha . "^" .
        $codigoDetalhe . "^" .
        $horaEntrada . "^" .
        $horaSaida . "^" .
        $inicioAlmoco . "^" .
        $fimAlmoco . "^" .
        $horaExtra . "^" .
        $atraso . "^" .
        $lancamento . "^" .
        $status;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}
