<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravar') {
    call_user_func($funcao);
}

if ($funcao == 'gravarLancamento') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'selecionaHora') {
    call_user_func($funcao);
}

return;

function gravar()
{
    $reposit = new reposit(); //Abre a conexão.
    session_start();

    $idFolha = (int)$_POST['idFolha'];
    $codigo = (int)$_POST['codigo'];
    $dia = (int)$_POST['dia'];
    $horaEntrada = (string)$_POST['horaEntrada'];
    $inicioAlmoco = (string)$_POST['inicioAlmoco'];
    $fimAlmoco = (string)$_POST['fimAlmoco'];
    $horaSaida = (string)$_POST['horaSaida'];
    $horaExtra = (string)$_POST['horaExtra'];
    $atraso = (string)$_POST['atraso'];
    $justificativaAtraso = (string)$_POST['justificativaAtraso'];
    $justificativaExtra = (string)$_POST['justificativaExtra'];
    $atrasoAlmoco = (string)$_POST['atrasoAlmoco'];
    $horaTotalDia = (string)$_POST['horaTotalDia'];
    $horasPositivasDia = (string)$_POST['horasPositivasDia'];
    $horasNegativasDia = (string)$_POST['horasNegativasDia'];

    $sql = "folhaPontoMensalDetalheDiario_Atualiza
        $codigo,
        $idFolha,
        $dia,
        '$horaEntrada',
        '$inicioAlmoco',
        '$fimAlmoco',
        '$horaSaida',
        '$horaExtra',
        '$atraso', 
        '$justificativaAtraso',
        '$justificativaExtra',
        '$atrasoAlmoco',
        '$horaTotalDia',
        '$horasPositivasDia',
        '$horasNegativasDia'
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

function recupera()
{
    $funcionario = (int) $_POST["funcionario"];
    $idFolha = (int) $_POST["idFolha"];
    $mesAno = $_POST["mesAno"];
    $dia = (int) $_POST["dia"];

    while ($idFolha == 0) {

        $sql = "SELECT codigo FROM dbo.folhaPontoMensal WHERE funcionarioId = $funcionario AND mesAno = '$mesAno'";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        if ($row = $result[0]) {
            $idFolha = (int)$row['codigo'];
        } else {
            $codigo = 0;
            $ativo = 1;
            $sql = "folhaPontoMensal_Atualiza

             $codigo,
            $funcionario,
            '$mesAno',
            $ativo
            ";
            $reposit = new reposit();
            $result = $reposit->Execprocedure($sql);
        }
    }


    $sql = "SELECT codigo, folhaPontoMensal, dia, horaEntrada, inicioAlmoco, fimAlmoco, horaSaida, horaExtra, atraso, observacaoAtraso, observacaoExtra, lancamento, atrasoAlmoco, horaTotalDia, horasPositivasDia, horasNegativasDia FROM dbo.folhaPontoMensalDetalheDiario where folhaPontoMensal = $idFolha AND dia = $dia";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);


    $out = "";
    if ($row = $result[0]) {
        $codigo = $row['codigo'];
        $horaEntrada = $row['horaEntrada'];
        $inicioAlmoco = $row['inicioAlmoco'];
        $fimAlmoco = $row['fimAlmoco'];
        $horaSaida = $row['horaSaida'];
        $horaExtra = $row['horaExtra'];
        $atraso = $row['atraso'];
        $observacaoAtraso = $row['observacaoAtraso'];
        $observacaoExtra = $row['observacaoExtra'];
        $lancamento = $row['lancamento'];
        $atrasoAlmoco = $row['atrasoAlmoco'];
        $horaTotalDia = $row['horaTotalDia'];
        $horasPositivasDia = $row['horasPositivasDia'];
        $horasNegativasDia = $row['horasNegativasDia'];
    }



    $sql = "SELECT escala from dbo.funcionario where codigo = $funcionario";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if ($row = $result[0]) {
        $escala = $row['escala'];
    }


    $sql = "SELECT E.codigo, E.descricao, E.horaEntrada, E.inicioIntervalo, E.fimIntervalo, E.horaSaida, E.expediente, E.intervalo, E.domingo, E.segunda, E.terca, E.quarta, E.quinta, E.sexta, E.sabado, E.tolerancia from dbo.escala E
            LEFT JOIN dbo.funcionario F on F.codigo = $funcionario WHERE E.codigo = $escala";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if ($row = $result[0]) {
        $horaEntradaEscala = $row['horaEntrada'];
        $inicioIntervaloEscala = $row['inicioIntervalo'];
        $fimIntervaloEscala = $row['fimIntervalo'];
        $horaSaidaEscala = $row['horaSaida'];
        $expedienteEscala = $row['expediente'];
        $intervaloEscala = $row['intervalo'];
        $segundaEscala = $row['segunda'];
        $tercaEscala = $row['terca'];
        $quartaEscala = $row['quarta'];
        $quintaEscala = $row['quinta'];
        $sextaEscala = $row['sexta'];
        $sabadoEscala = $row['sabado'];
        $toleranciaEscala = $row['tolerancia'];
    }

    $out =  $idFolha . "^" .
        $codigo .  "^" .
        $funcionario . "^" .
        $horaEntrada . "^" .
        $inicioAlmoco . "^" .
        $fimAlmoco . "^" .
        $horaSaida . "^" .
        $horaExtra . "^" .
        $atraso . "^" .
        $horaEntradaEscala . "^" .
        $inicioIntervaloEscala . "^" .
        $fimIntervaloEscala . "^" .
        $horaSaidaEscala . "^" .
        $expedienteEscala . "^" .
        $intervaloEscala . "^" .
        $segundaEscala . "^" .
        $tercaEscala . "^" .
        $quartaEscala . "^" .
        $quintaEscala . "^" .
        $sextaEscala . "^" .
        $sabadoEscala . "^" .
        $toleranciaEscala . "^" .
        $observacaoAtraso . "^" .
        $observacaoExtra . "^" .
        $lancamento . "^" .
        $atrasoAlmoco . "^" .
        $horaTotalDia . "^" .
        $horasPositivasDia . "^" .
        $horasNegativasDia;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function gravarLancamento()
{
    $reposit = new reposit(); //Abre a conexão.
    session_start();
    $codigo = (int)$_POST['codigo'];
    // $idFolha = (int)$_POST['idFolha'];
    // $dia = (int)$_POST['dia'];
    $lancamento = (string)$_POST['lancamento'];

    // $sql = "UPDATE dbo.folhaPontoMensalDetalheDiario SET lancamento = '$lancamento' where dia = '$dia' and folhaPontoMensal = '$idFolha'";
    $sql = "lancamento_Atualiza
        $codigo,
        '$lancamento'";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function selecionaHora()
{

    $sql = "SELECT GETDATE() as hora";
    $reposit = new reposit();

    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        // $hora = explode(".", $row['hora']);
        // $hora = $hora[0];
        $hora = $row['hora'];
        $horaDisplay = $row['hora'];
    }

    $horaPartida = explode(" ", $hora);
    $hora = $horaPartida[1];
    $hora = substr($hora, 0, 8); 

    $out = $hora
     . "^" .
     $horaDisplay;

    echo "sucess#" . $out;
    return true;
}
