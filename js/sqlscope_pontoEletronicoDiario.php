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

if ($funcao == 'validarIp') {
    call_user_func($funcao);
}

if ($funcao == 'verificaFeriado') {
    call_user_func($funcao);
}

if ($funcao == 'verificarAutorizacao') {
    call_user_func($funcao);
}

if ($funcao == 'selecionaHora') {
    call_user_func($funcao);
}

if ($funcao == 'consultarAbateBancoHoras') {
    call_user_func($funcao);
}

if ($funcao == 'verificaLancamento') {
    call_user_func($funcao);
}

if ($funcao == 'confirmaRegistro') {
    call_user_func($funcao);
}

if ($funcao == 'registrarPausa') {
    call_user_func($funcao);
}

if ($funcao == 'consultaLancamentoAbono') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaDados') {
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

    $sql = "SELECT codigo FROM dbo.folhaPontoMensal WHERE funcionarioId = $funcionario AND mesAno = '$mesAno'";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if ($row = $result[0]) {
        $idFolha = (int)$row['codigo'];
    }

    $sql = "SELECT codigo, folhaPontoMensal, dia, horaEntrada, inicioAlmoco, fimAlmoco, horaSaida, horaExtra, atraso, observacaoAtraso, observacaoExtra, lancamento, atrasoAlmoco FROM dbo.folhaPontoMensalDetalheDiario where folhaPontoMensal = $idFolha AND dia = $dia";
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
        $atrasoAlmoco;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function validarIp()
{

    $projeto = $_POST['projeto'];

    $sql = "SELECT ip 
            FROM Ntl.projetoIpPermitido
            WHERE projeto = $projeto";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (count($result) > 0) {
        $permitido = false;
        foreach ($result as $row) {
            $ip = $_POST['ip'];
            $ip = explode('.', $ip);
            $ip = implode($ip);

            $ipPermitido = $row['ip'];
            $ipPermitido = explode('.', $ipPermitido);
            $ipPermitido = implode($ipPermitido);

            $tamanhoIpPermitido = mb_strlen($ipPermitido);
            $ip = mb_substr($ip, 0, $tamanhoIpPermitido);

            if ($ipPermitido == $ip) {
                $permitido = true;
            }
        }

        if ($permitido == true) {
            echo 'sucess#';
            return true;
        }

        $out = "IP não permitido!";

        echo "failed#" . $out;
        return false;
    } else {
        $out = "IP não permitido!";

        echo "failed#" . $out;
        return false;
    }
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

function verificaFeriado()
{
    $mesAno = "'" . $_POST['mesAno'] . "'";
    $funcionario = $_POST['funcionario'];

    $sql = "SELECT BP.codigo,BP.funcionario,BP.projeto,P.apelido,P.estado,P.cidade,P.municipioFerias
            FROM Ntl.beneficioProjeto BP
            INNER JOIN Ntl.projeto P ON P.codigo = BP.projeto
            INNER JOIN Ntl.funcionario F ON F.codigo = BP.funcionario
            WHERE BP.funcionario = $funcionario AND BP.ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $row = $result[0];
    if ($row) {
        $estado = "'" . $row['estado'] . "'";
        $municipioFerias = $row['municipioFerias'];
    }

    $sqlFeriado = "SELECT F.codigo,F.descricao,F.tipoFeriado,F.municipio,M.descricao,F.unidadeFederacao,F.data
                FROM Ntl.feriado F 
                LEFT JOIN Ntl.municipio M ON M.codigo = F.municipio
                WHERE F.ativo = 1 AND data = $mesAno
                AND (F.tipoFeriado = 3 OR (F.tipoFeriado = 1 and (F.unidadeFederacao = $estado)) OR F.tipoFeriado = 2 and M.codigo = $municipioFerias)";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sqlFeriado);

    $out = "";

    if ($row = $result[0]) {
        echo 'sucess#';
        return true;
    }
    echo ('failed#');
    return false;
}

function verificarAutorizacao()
{
    $dia = $_POST['dia'];
    $mesAno = $_POST['mesAno'];
    $mesAno = preg_replace("/\d\d$/", "01", $mesAno);
    $funcionario = $_POST['funcionario'];

    $sql = "SELECT BP.funcionario, BP.projeto, P.autorizacaoHoraExtra
            FROM Ntl.beneficioProjeto BP
            INNER JOIN Ntl.projeto P ON P.codigo = BP.projeto
            WHERE BP.funcionario = $funcionario";
    $reposit = new reposit();

    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        $autorizacaoHoraExtra = $row['autorizacaoHoraExtra'];
    }

    if ($autorizacaoHoraExtra == 1) {
        $sql = "SELECT funcionario, dia, mesAno, status
            FROM Funcionario.autorizacaoHoraExtra
            WHERE funcionario = $funcionario AND dia = '$dia' AND mesAno = '$mesAno'";

        $result = $reposit->RunQuery($sql);
        $row = $result[0];
        if ($row) {
            $status = $row['status'];
        }
        $out = "";

        if ($status == "AP") {
            echo 'sucess#';
            return true;
        }
        echo ('failed#');
        return false;
    } else {
        echo 'sucess#';
        return true;
    }
}

function selecionaHora()
{

    $sql = "SELECT CONVERT (time, GETDATE()) as hora";
    $reposit = new reposit();

    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        $hora = explode(".", $row['hora']);
        $hora = $hora[0];
    }

    $out = $hora;

    echo "sucess#" . $out;
    return true;
}

function formataHora($hora)
{
    $horas = gmdate("H:i:s", $hora);

    return $horas;
}

function parse($horario)
{
    // divide a string em duas partes, separado por dois-pontos, e transforma em número
    $hora = explode(":", $horario);

    return $hora[2] + ($hora[1] * 60) + ($hora[0] * pow(60, 2));
}

function consultarAbateBancoHoras()
{
    session_start();
    $reposit = new reposit();
    $funcionario = $_SESSION['funcionario'];
    $lancamento = $_POST['lancamento'];
    $atraso = $_POST['atraso'];
    $entrada = $_POST['horaEntrada'];
    $saida = $_POST['horaSaida'];

    $abateBancoHoras = 0;

    // Verifica se o lançamento selecionado abate o banco de horas.
    $search = "abateBancoHoras";
    $table = "Ntl.lancamento";
    $sql = "SELECT " . $search . " FROM " . $table . " WHERE codigo = " . $lancamento . "";
    $result = $reposit->RunQuery($sql);
    $row = $result[0];
    $abateBancoHoras = (int)$row['abateBancoHoras'];
    // ======================================================= //

    if ($abateBancoHoras == 1) {
        // Verifica se o funcionário faz banco de horas e qual o expediente

        $sql =  "SELECT BP.bancoHoras, BP.horaEntrada, BP.horaSaida, BP.horaInicio as inicioAlmoco, BP.horaFim as fimAlmoco
                FROM Ntl.funcionario F
                INNER JOIN Ntl.beneficioProjeto BP ON BP.funcionario = F.codigo
                WHERE F.codigo = $funcionario";

        $resultBancoHoras = $reposit->RunQuery($sql);

        $bancoHoras = (int) $resultBancoHoras[0]['bancoHoras'];
        $inicioExpediente = $resultBancoHoras[0]['horaEntrada'];
        $fimExpediente = $resultBancoHoras[0]['horaSaida'];
        $inicioAlmoco = $resultBancoHoras[0]['inicioAlmoco'];
        $fimAlmoco = $resultBancoHoras[0]['fimAlmoco'];

        // ======================================= //

        if ($bancoHoras == 1) {

            $totalExtra = 0;
            $totalAtraso = 0;

            $sqlDetalhe = "SELECT F.nome, B.horaPositiva, B.horaNegativa
                                FROM Funcionario.bancoHoras B
                                LEFT JOIN Ntl.funcionario F ON F.codigo = B.funcionario
                                WHERE F.codigo = $funcionario";

            $resultDetalhe = $reposit->RunQuery($sqlDetalhe);

            foreach ($resultDetalhe as $detalhe) {
                $horaPositiva = $detalhe['horaPositiva'];
                $horaNegativa = $detalhe['horaNegativa'];

                $extra = explode(":", $horaPositiva);
                $horaNegativa = explode(":", $horaNegativa);
                $totalExtra += ($extra[0] * 3600) + ($extra[1] * 60) + $extra[2];
                $totalAtraso += ($horaNegativa[0] * 3600) + ($horaNegativa[1] * 60) + $horaNegativa[2];
            }

            $saldoHoras = $totalExtra - $totalAtraso;

            if ((!$atraso) && ($entrada == '00:00:00') && ($saida == '00:00:00')) {
                $cargaHoraria = strtotime($fimExpediente) - strtotime($inicioExpediente);
                $cargaHoraria = $cargaHoraria - (strtotime($fimAlmoco) - strtotime($inicioAlmoco));
                if (($saldoHoras < 0) || ($saldoHoras < $cargaHoraria)) {
                    $abateBancoHoras = 0;
                    $msg = 'Saldo de Banco de Horas insuficiente';
                }
            } else {
                $atraso = explode(':', $atraso);
                $atrasoSegundos = ($atraso[0] * 3600) + ($atraso[1] * 60) + $atraso[2];
                if (($saldoHoras < 0) || ($saldoHoras < $atrasoSegundos)) {
                    $abateBancoHoras = 0;
                    $msg = 'Saldo de Banco de Horas insuficiente';
                }
            }

            /*<-->Espaço destinado ao envio de dados<-->*/
            $out = $abateBancoHoras;
        } else {
            $abateBancoHoras = 0;
            $out = $abateBancoHoras;
            $msg = 'Não possui Banco de Horas';
        }
    }

    if ($out == "") {
        echo "failed#" . "$out#" . "$msg#";
        return;
    }

    echo "sucess#" . "$out#" . "$msg#";
    return;
}

function verificaLancamento()
{
    /*<-->Espaço destinada a variáveis ou funções utilitárias<-->*/
    session_start();
    $reposit = new reposit();

    $lancamento = $_POST['lancamento'];
    $funcionario = $_SESSION['funcionario'];
    $folha = $_POST['idFolha'];
    $extra = $_POST['horaExtra'];
    $extraSegundos = explode(":", $extra);
    $extraSegundos = $extraSegundos[0] * 3600 + $extraSegundos[1] * 60;

    $dia = $_POST['dia'];

    $sql = "SELECT descricao FROM Ntl.lancamento WHERE codigo = $lancamento";
    $result = $reposit->RunQuery($sql);
    /* <-->Função destinada para consultar dados relacionados a página<--> */
    $row = $result[0];
    $descricao = $row['descricao'];
    $out = "";

    if ($descricao == 'Compensação de Falta') {

        $sql = "SELECT horaCompensar, horaCompensada, dia, folhaPontoMensal
                FROM Funcionario.compensacaoFalta where funcionario = $funcionario
                EXCEPT(  
                    SELECT horaCompensar, horaCompensada, dia, folhaPontoMensal
                    FROM Funcionario.compensacaoFalta where folhaPontoMensal = $folha and dia = $dia)";
        $result = $reposit->RunQuery($sql);

        $totalHoraCompensar = 0;
        $totalHoraCompensada = 0;

        foreach ($result as $compensacao) {
            $horaCompensar = $compensacao['horaCompensar'];
            $horaCompensarSegundos = explode(":", $horaCompensar);
            $horaCompensarSegundos = $horaCompensarSegundos[0] * 3600 + $horaCompensarSegundos[1] * 60;

            $horaCompensada = $compensacao['horaCompensada'];
            $horaCompensadaSegundos = explode(":", $horaCompensada);
            $horaCompensadaSegundos = $horaCompensadaSegundos[0] * 3600 + $horaCompensadaSegundos[1] * 60;

            $totalHoraCompensar += $horaCompensarSegundos;
            $totalHoraCompensada += $horaCompensadaSegundos;
        }

        $saldo = $totalHoraCompensar - $totalHoraCompensada;

        if ($extraSegundos <= $saldo) {
            $compensaFalta = 1;
        } else {
            $mensagem = "Não possui saldo suficiente para compensação de falta!";
            echo "failed#" . "$out#" . $mensagem;
            return $mensagem;
        }
    }
    /*<-->Espaço destinado ao envio de dados<-->*/
    $out = $compensaFalta;

    if ($out == "") {
        echo "failed#" . "$out#";
        return $out;
    }

    echo "sucess#" . "$out#";
    return $out;
}

function confirmaRegistro()
{
    session_start();
    $reposit = new reposit();
    $idFolha = $_POST['idFolha'];
    $dia = $_POST['dia'];
    $funcionario = $_SESSION['funcionario'];
    $mesAno = $_POST['mesAno'];
    $mesAno = preg_replace("/\d\d$/", "01", $mesAno);

    if ($idFolha) {
        $sql = "SELECT horaEntrada, inicioAlmoco, fimAlmoco, horaSaida
                FROM Funcionario.folhaPontoMensalDetalheDiario
                WHERE folhaPontoMensal = $idFolha AND dia = $dia";
        $result = $reposit->RunQuery($sql);

        $sqlPausa = "SELECT inicioPrimeiraPausa, fimPrimeiraPausa, inicioSegundaPausa, fimSegundaPausa
                        FROM Funcionario.pausasDescanso
                        WHERE folhaPontoMensal = $idFolha AND dia = $dia";
        $resultPausa = $reposit->RunQuery($sqlPausa);
    } else {
        $sql = "SELECT horaEntrada, inicioAlmoco, fimAlmoco, horaSaida
                FROM Funcionario.folhaPontoMensalDetalheDiario FPD
                INNER JOIN Funcionario.folhaPontoMensal FP ON FP.codigo = FPD.folhaPontoMensal
                WHERE funcionario = $funcionario and mesAno = '$mesAno' and dia = $dia";
        $result = $reposit->RunQuery($sql);
    }

    if ($dia < 10)
        $dia = '0' . $dia;

    $data = preg_replace("/\d\d$/", $dia, $mesAno);
    $data = implode("/", array_reverse(explode("-", $data)));

    $row = $result[0];
    $horaEntrada = $row['horaEntrada'];
    $horaSaida = $row['horaSaida'];
    $inicioAlmoco = $row['inicioAlmoco'];
    $fimAlmoco = $row['fimAlmoco'];

    $pausa = $resultPausa[0];
    $inicioPrimeiraPausa = $pausa['inicioPrimeiraPausa'];
    $fimPrimeiraPausa = $pausa['fimPrimeiraPausa'];
    $inicioSegundaPausa = $pausa['inicioSegundaPausa'];
    $fimSegundaPausa = $pausa['fimSegundaPausa'];

    if (($horaEntrada == "00:00:00") && ($horaSaida == "00:00:00") && ($inicioAlmoco == "00:00:00") && ($fimAlmoco == "00:00:00")) {
        echo "failed#";
        return;
    }

    if ($resultPausa && (!$inicioPrimeiraPausa) && (!$fimPrimeiraPausa) && (!$inicioSegundaPausa) && (!$fimSegundaPausa)) {
        echo "failed#";
        return;
    }

    echo "sucess#" . "$horaEntrada#" . "$inicioAlmoco#" . "$fimAlmoco#" . "$horaSaida#" . "$inicioPrimeiraPausa#" . "$fimPrimeiraPausa#" . "$inicioSegundaPausa#" . "$fimSegundaPausa#" . "$data#";
    return;
}

function registrarPausa()
{
    session_start();
    $funcionario = $_SESSION['funcionario'];
    // $codigoPausa = (int)$_POST['codigoPausa'];
    $inicioPrimeiraPausa = (string)$_POST['inicioPrimeiraPausa'];
    $fimPrimeiraPausa = (string)$_POST['fimPrimeiraPausa'];
    $inicioSegundaPausa = (string)$_POST['inicioSegundaPausa'];
    $fimSegundaPausa = (string)$_POST['fimSegundaPausa'];
    $idFolha = $_POST['idFolha'];
    $mesAno = $_POST['mesAno'];
    $mesAno = preg_replace("/\d\d$/", "01", $mesAno);
    $dia = $_POST['dia'];
    $usuario = (string)$_SESSION['login'];

    if ($inicioPrimeiraPausa) {
        $inicioPrimeiraPausa = "'" . $inicioPrimeiraPausa . "'";
    } else {
        $inicioPrimeiraPausa = 'NULL';
    }
    if ($fimPrimeiraPausa) {
        $fimPrimeiraPausa = "'" . $fimPrimeiraPausa . "'";
    } else {
        $fimPrimeiraPausa = 'NULL';
    }

    if ($inicioSegundaPausa) {
        $inicioSegundaPausa = "'" . $inicioSegundaPausa . "'";
    } else {
        $inicioSegundaPausa = 'NULL';
    }
    if ($fimSegundaPausa) {
        $fimSegundaPausa = "'" . $fimSegundaPausa . "'";
    } else {
        $fimSegundaPausa = 'NULL';
    }

    if ($_POST['justificativaPausa']) {
        // XML Justificativa
        $comum = new comum();
        $xmlJustificativa = new \FluidXml\FluidXml('ArrayOfJustificativa', ['encoding' => '']);
        $xmlJustificativa->addChild('justificativa', true) //nome da tabela
            ->add('folhaPontoMensal', $idFolha)
            ->add('dia', $_POST['dia'])
            ->add('observacao', $_POST['justificativaPausa'])
            ->add('campo', $_POST['btnClicado']);
        $xmlJustificativa = $comum->formatarString($xmlJustificativa);
    } else {
        $xmlJustificativa = 'NULL';
    }

    $sql = "Funcionario.pausasDescanso_Atualiza
            $idFolha,
            $funcionario,
            $dia,
            '$mesAno',
            $inicioPrimeiraPausa,
            $fimPrimeiraPausa,
            $inicioSegundaPausa,
            $fimSegundaPausa,
            '$usuario',
            $xmlJustificativa";

    $reposit = new reposit();

    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function consultaLancamentoAbono()
{
    /*<-->Espaço destinada a variáveis ou funções utilitárias<-->*/
    session_start();
    $reposit = new reposit();
    $lancamento = $_POST['lancamento'];

    $search = "abonaAtraso";
    $table = "Ntl.lancamento";
    $sql = "SELECT " . $search . " FROM " . $table . " WHERE codigo = " . $lancamento . "";
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
    return $out;
}

function recuperaDados()
{
    $reposit = new reposit();
    $funcionario = $_POST['funcionario'];

    $sql = "SELECT BP.verificaIp, P.verificaIp AS verificaIpProjeto
                FROM Ntl.beneficioProjeto BP
                INNER JOIN Ntl.projeto P ON  P.codigo = BP.projeto
                WHERE BP.funcionario = $funcionario
                AND (BP.dataDemissaoFuncionario IS NULL OR BP.dataDemissaoFuncionario > GETDATE())";
    $result = $reposit->RunQuery($sql);

    $verificaIp = $result[0]['verificaIp'];

    if (!$verificaIp) {
        $verificaIp = $result[0]['verificaIpProjeto'];
    }
    echo "sucess#" . "$verificaIp";
    return $verificaIp;
}
