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
        '$atrasoAlmoco'
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





function gravarAAA()
{
    $reposit = new reposit(); //Abre a conexão.

    session_start();
    $usuario = $_SESSION['login'];
    $codigo = $_POST['codigo'];
    $funcionario = (int)$_POST['funcionario'];
    $mesAno = $_POST['mesAno'];
    $mesAno = preg_replace("/\d\d$/", "01", $mesAno);

    $mesAnoAtual = date('Y-m-01');
    if ($mesAno != $mesAnoAtual) {
        $mensagem = "Não foi possivel registrar ponto!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
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
    $observacao = (string)$_POST['observacao'];

    $data = explode('-', $mesAno);
    $totalDiasMes = cal_days_in_month(CAL_GREGORIAN, $data[1], $data[0]);

    $sql = "SELECT BP.tipoEscala, BP.tipoRevezamento, BP.horaEntrada, BP.horaSaida, BP.horaInicio as inicioAlmoco, BP.horaFim as fimAlmoco,
            P.limiteEntrada, P.limiteSaida, P.toleranciaDia, BP.dataInicioRevezamento
            FROM Ntl.beneficioProjeto BP
            INNER JOIN Ntl.projeto P ON P.codigo = BP.projeto
            WHERE BP.funcionario = $funcionario AND BP.ativo = 1";

    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        $tipoEscala = $row['tipoEscala'];
        $tipoRevezamento = $row['tipoRevezamento'];
        $inicioExpediente = $row['horaEntrada'];
        $fimExpediente = $row['horaSaida'];
        $saidaAlmoco = $row['inicioAlmoco'];
        $retornoAlmoco = $row['fimAlmoco'];
        $toleranciaExtra = $row['limiteSaida'];
        $toleranciaAtraso = $row['limiteEntrada'];
        $toleranciaDia = $row['toleranciaDia'];

        $dataInicioRevezamento = explode(" ", $row['dataInicioRevezamento']);
        $dataInicioRevezamento[1] = $inicioExpediente;
        $dataInicioRevezamento = implode(" ", $dataInicioRevezamento);
    }

    $msg = "";

    if ($tipoEscala == 1) {

        if ($horaExtra != "00:00:00" && $horaExtra != "" && $lancamento != 0) {

            $compensaFalta = verificaLancamento($lancamento, $horaExtra, $idFolha, $dia);
            if ($compensaFalta == 1) {
                $horaExtra = "00:00:00";
            } else if ($compensaFalta != 0) {

                $msg .= "#$compensaFalta";
                $lancamento = "";
            }
        }
        if ($atraso != '00:00:00' && $horaExtra != "" && $lancamento != 0) {
            $abonaAtraso = consultaLancamentoAbono();

            ob_clean();
            if ($abonaAtraso == 1) {
                $atraso = "00:00:00";
            }
        }
    }

    if ($tipoEscala == 2) {
        if ($inicioExpediente > $fimExpediente) {
            if ($horaSaida != "00:00:00") {

                if ($tipoRevezamento == 1) {
                    $cargaHorariaTrabalho = 12;
                    $cargaHorariaDescanso = 36;
                } else if ($tipoRevezamento == 2) {
                    $cargaHorariaTrabalho = 18;
                    $cargaHorariaDescanso = 36;
                } else if ($tipoRevezamento == 3) {
                    $cargaHorariaTrabalho = 24;
                    $cargaHorariaDescanso = 48;
                }

                // Montar array com os dias que o funcionário deve trabalhar no mes.
                $diaTrabalho = new DateTime($dataInicioRevezamento);
                $diaMesAno = preg_replace("/\d{2}$/", $totalDiasMes, $mesAno);
                $diaMesAno = new DateTime($diaMesAno);
                $diasTrabalho = array();

                while ($diaTrabalho <= $diaMesAno) {

                    $diaTrabalho = $diaTrabalho->add(new DateInterval("PT{$cargaHorariaTrabalho}H"));
                    $diaTrabalhado = $diaTrabalho->format('Y-m-d H:i:s');

                    $dataTrabalho = explode(" ", $diaTrabalhado);

                    $dataTrabalho = preg_replace("/\d{2}$/", '01', $dataTrabalho[0]);

                    if ($mesAno == $dataTrabalho) {
                        // Guarda os dias que devem ser trabalhados no mês selecionado.
                        array_push($diasTrabalho, $diaTrabalhado);
                    }

                    $diaTrabalho =  $diaTrabalho->add(new DateInterval("PT{$cargaHorariaDescanso}H"));
                }
                // Fim array //

                $diaExtra = true;
                for ($i = 0; $i <= count($diasTrabalho); $i++) {
                    $diaSelecionado = $dia;
                    if (strlen($diaSelecionado) < 2) $diaSelecionado = `0$diaSelecionado`;

                    $data = $diasTrabalho[$i];
                    if ($data) {
                        $data = explode(" ", $data);
                        $data = $data[0];
                    }
                    $diaSelecionado = preg_replace("/\d{2}$/", $diaSelecionado, $mesAno);

                    if ($data == $diaSelecionado) {
                        $diaExtra = false;
                    }
                }

                // Expediente em segundos.
                $parseHoraInicio = parse($inicioExpediente);
                $parseHoraFim = parse($fimExpediente);

                // Tolerancia
                if ($toleranciaExtra || $toleranciaAtraso) {
                    $parseToleranciaExtra = parse($toleranciaExtra);
                    $parseToleranciaAtraso = parse($toleranciaAtraso);
                } else if ($toleranciaDia) {
                    $parseToleranciaExtra = parse($toleranciaDia);
                    $parseToleranciaAtraso = parse($toleranciaDia);
                }

                $parseHoraSaida = parse($horaSaida);
                $jornadaModerada = $parseHoraInicio - $parseHoraFim;
                $jornadaModeradaToleranteExtra = $jornadaModerada + $parseToleranciaExtra;
                $jornadaModeradaToleranteAtraso = $jornadaModerada - $parseToleranciaAtraso;

                $saidaDiaAnterior = "00:00:00";
                $entradaDiaAnterior = "00:00:00";
                $dataAnterior = $dia - 1;

                while (($saidaDiaAnterior == "00:00:00") && ($entradaDiaAnterior == "00:00:00")) {

                    if ($dataAnterior > 0) {
                        // Pegar dia anterior
                        $sql = "SELECT dia,horaEntrada,horaSaida,inicioAlmoco,fimAlmoco,horaExtra,atraso,lancamento
                        FROM Funcionario.folhaPontoMensalDetalheDiario WHERE folhaPontoMensal = $idFolha and dia = $dataAnterior";

                        $result = $reposit->RunQuery($sql);

                        if ($diaAnterior = $result[0]) {
                            $diaEntrada = $diaAnterior['dia'];
                            $entradaDiaAnterior = $diaAnterior['horaEntrada'];
                            $saidaDiaAnterior = $diaAnterior['horaSaida'];
                        }

                        $dataAnterior--;
                    } else {
                        break;
                    }
                }

                if ($diaExtra) {

                    if ($entradaDiaAnterior && ($entradaDiaAnterior != '00:00:00')) {

                        $diaSaida = $dia;
                        if (strlen($diaSaida) < 2) $diaSaida = `0$diaSaida`;

                        $dataSaida = preg_replace("/\d{2}$/", $diaSaida, $mesAno);
                        $dataHoraSaida = new DateTime($dataSaida . " " . $horaSaida);

                        $dataEntrada = preg_replace("/\d{2}$/", $diaEntrada, $mesAno);
                        $dataHoraEntrada = new DateTime($dataEntrada . " " . $entradaDiaAnterior);

                        $diff = $dataHoraSaida->diff($dataHoraEntrada);

                        $horaExtra = $diff->format("%H:%I:%S");
                    }
                } else if ($entradaDiaAnterior && ($entradaDiaAnterior != '00:00:00')) {

                    $diaSaida = $dia;

                    if (strlen($diaSaida) < 2) $diaSaida = `0.$diaSaida`;

                    $dataSaida = preg_replace("/\d\d$/", $diaSaida, $mesAno);
                    $dataEntrada = preg_replace("/\d\d$/", $diaEntrada, $mesAno);

                    $dataHoraSaida = new DateTime($dataSaida . ' ' . $horaSaida);
                    $dataHoraEntrada = new DateTime($dataEntrada . ' ' . $entradaDiaAnterior);

                    //Dia e hora maximo que poderia entrar
                    $diaHoraEntrada = date_sub($dataHoraSaida, date_interval_create_from_date_string($cargaHorariaTrabalho . 'hours')); //jornada do revezamento, pegar do tipo revezamento no banco;

                    $entradaDia = $diaHoraEntrada->format('d');

                    if ($diaEntrada < $entradaDia) {
                        // extra
                        $diff = $diaHoraEntrada->diff($dataHoraEntrada);

                        if ($diff != 0) {
                            $horaExtra = $diff->format("%H:%I:%S");
                        }
                    } else {
                        // quantidade de minutos efetivamente trabalhados
                        $parseEntrada = parse($entradaDiaAnterior);

                        $jornada = $parseEntrada - $parseHoraSaida;

                        $diff = abs($jornada - $jornadaModerada);

                        if ($diff != 0) {

                            if ($jornada < $jornadaModeradaToleranteExtra) {
                                $horaExtra = formataHora($diff);
                            } else if ($jornada > $jornadaModeradaToleranteAtraso) {
                                $atraso = formataHora($diff);
                            }
                        }
                    }
                }
            }

            if ($horaExtra != "00:00:00" && $horaExtra != "") {
                $msg = "O funcionário possui horas extras";
                $autorizacaoExtra = verificarAutorizacao($dia);
                if (!$autorizacaoExtra) {
                    $autorizacao = 0;
                    $msg .= "#$autorizacao";
                }
            }
            if ($atraso != "00:00:00" && $atraso != "") {
                $abonaAtraso = consultaLancamentoAbono();

                if ($abonaAtraso == 1) {
                    $atraso = "00:00:00";
                } else {
                    $msg = "O funcionário possui atrasos";
                }
            }
        }
    }

    $sql = "SELECT dia,horaEntrada,horaSaida,inicioAlmoco,fimAlmoco,horaExtra,atraso,lancamento
  FROM Funcionario.folhaPontoMensalDetalheDiario WHERE folhaPontoMensal = $idFolha ORDER BY dia";

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

            $xmlFolhaPontoMensal .=  $i + 1 . "</dia>";
            $xmlFolhaPontoMensal .= "<horaEntrada>00:00:00</horaEntrada>";
            $xmlFolhaPontoMensal .= "<inicioAlmoco>00:00</inicioAlmoco>";
            $xmlFolhaPontoMensal .= "<fimAlmoco>00:00</fimAlmoco>";
            $xmlFolhaPontoMensal .= "<horaSaida>00:00:00</horaSaida>";
            $xmlFolhaPontoMensal .= "<horaExtra>00:00:00</horaExtra>";
            $xmlFolhaPontoMensal .= "<atraso>00:00:00</atraso>";
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
    } else {
        $xml->ponto[$dia - 1]->dia = $dia;
        $xml->ponto[$dia - 1]->horaEntrada = $horaEntrada;
        $xml->ponto[$dia - 1]->inicioAlmoco = $inicioAlmoco;
        $xml->ponto[$dia - 1]->fimAlmoco = $fimAlmoco;
        $xml->ponto[$dia - 1]->horaSaida = $horaSaida;
        $xml->ponto[$dia - 1]->horaExtra = $horaExtra;
        $xml->ponto[$dia - 1]->atraso = $atraso;
        $xml->ponto[$dia - 1]->lancamento = $lancamento;

        $xmlFolhaPontoMensal = $xml->asXML();
    }
    $xmlFolhaPontoMensal = "'" . $xmlFolhaPontoMensal . "'";

    $arrayBancoHoras = json_decode(json_encode($xml), TRUE);

    $arrayDiasAlterados = $_POST['diasAlterados'];
    $xmlDiasAlterados = "";
    $nomeXml = "ArrayOfDiaAlterado";
    $nomeTabela = "diaAlterado";
    $xmlDiasAlterados = "<?xml version=\"1.0\"?>";
    $xmlDiasAlterados .= "<$nomeXml xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">";
    foreach ($arrayDiasAlterados as $diaAlterado) {
        $xmlDiasAlterados .= "<$nomeTabela>";
        foreach ($diaAlterado as $key => $value) {
            if (in_array($key, ['horaEntrada', 'horaSaida'])) {
                if ($value == '00:00:00') {
                    $xmlDiasAlterados .= "<$key></$key>";
                } else {
                    $xmlDiasAlterados .= "<$key>$value</$key>";
                }
                continue;
            }
            if (in_array($key, ['inicioAlmoco', 'fimAlmoco'])) {
                if ($value == '00:00') {
                    $xmlDiasAlterados .= "<$key></$key>";
                } else {
                    $xmlDiasAlterados .= "<$key>$value</$key>";
                }
                continue;
            }
            if (in_array($key, ['ipEntrada', 'ipSaida'])) {
                if ($value == '') {
                    $xmlDiasAlterados .= "<$key></$key>";
                } else {
                    $xmlDiasAlterados .= "<$key>$value</$key>";
                }
                continue;
            }
            $xmlDiasAlterados .= "<$key>$value</$key>";
        }
        $xmlDiasAlterados .= "</$nomeTabela>";
    }
    $xmlDiasAlterados .= "</$nomeXml>";
    $xml = simplexml_load_string($xmlDiasAlterados);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlDiasAlterados = "'" . $xmlDiasAlterados . "'";

    //===== BANCO DE HORAS =====//
    $sql =  "SELECT BP.bancoHoras, BP.inicioBancoHoras, S.abateBancoHoras
            FROM Ntl.beneficioProjeto BP
            LEFT JOIN Ntl.sindicato S ON S.codigo = BP.sindicato
            WHERE BP.funcionario = $funcionario AND BP.ativo = 1";

    $resultBancoHoras = $reposit->RunQuery($sql);

    if ($row = $resultBancoHoras[0]) {
        $bancoHoras = (int) $row['bancoHoras'];
        $inicioBancoHoras = $row['inicioBancoHoras'];
        $inicioBancoHoras = explode(' ', $inicioBancoHoras);
    }

    if ($bancoHoras == 1) {
        $sql = "SELECT codigo
                FROM Ntl.lancamento
                WHERE abateBancoHoras = 1";

        $result = $reposit->RunQuery($sql);

        if ($result) {
            foreach ($arrayBancoHoras['ponto'] as $folha) {
                $lancamento = $folha['lancamento'];
                $dia = $folha['dia'];
                foreach ($result as $lancamentoAbateBanco) {

                    if ($lancamentoAbateBanco['codigo'] == $lancamento) {

                        $cargaHoraria = parse($fimExpediente) - parse($inicioExpediente);
                        $cargaHoraria = $cargaHoraria - (parse($retornoAlmoco) - parse($saidaAlmoco));

                        if (($folha['horaEntrada'] == '00:00:00') && ($folha['horaSaida'] == '00:00:00')) {

                            $cargaHoraria = sprintf("%02d%s%02d%s%02d", floor($cargaHoraria / 3600), ":", ($cargaHoraria / 60) % 60, ":", $cargaHoraria % 60);

                            $arrayBancoHoras['ponto'][$dia - 1]['atraso'] = $cargaHoraria;
                        } else if (($folha['horaEntrada'] != '00:00:00') && ($folha['horaSaida'] != '00:00:00')) {

                            $cargaHorariaTrabalhada = strtotime($folha['horaSaida']) - strtotime($folha['horaEntrada']);
                            $cargaHorariaTrabalhada = $cargaHorariaTrabalhada - (strtotime($folha['fimAlmoco']) - strtotime($folha['inicioAlmoco']));

                            $dif = $cargaHoraria - $cargaHorariaTrabalhada;
                            $dif = sprintf("%02d%s%02d%s%02d", floor($dif / 3600), ":", ($dif / 60) % 60, ":", $dif % 60);

                            $arrayBancoHoras['ponto'][$dia - 1]['atraso'] = $dif;
                        }
                    }
                }
            }
        }
    }
    $xmlBancoHoras = "";
    $nomeXml = "ArrayOfBanco";
    $nomeTabela = "bancoHoras";
    $xmlBancoHoras = "<?xml version=\"1.0\"?>";
    $xmlBancoHoras .= "<$nomeXml xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">";
    foreach ($arrayBancoHoras['ponto'] as $banco) {
        $dia = $banco['dia'];
        if ($dia < 10) {
            $dia = "0" . $dia;
        }
        $diaMesAno = $_POST["mesAno"];
        if ((($banco['horaExtra'] != '00:00:00') || ($banco['atraso'] != '00:00:00')) && (strtotime($diaMesAno) >= strtotime($inicioBancoHoras[0]))) {
            $xmlBancoHoras .= "<$nomeTabela>";
            foreach ($banco as $key => $value) {
                if (in_array($key, ['horaExtra', 'atraso'])) {
                    if ($value == '') {
                        $xmlBancoHoras .= "<$key>00:00:00</$key>";
                    } else {
                        $xmlBancoHoras .= "<$key>$value</$key>";
                    }
                    continue;
                }
                if (in_array($key, ['horaEntrada', 'horaSaida', 'inicioAlmoco', 'fimAlmoco', 'lancamento'])) {
                    continue;
                }
                $xmlBancoHoras .= "<$key>$value</$key>";
            }
            $xmlBancoHoras .= "</$nomeTabela>";
        }
    }
    $xmlBancoHoras .= "</$nomeXml>";
    $xml = simplexml_load_string($xmlBancoHoras);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlBancoHoras = "'" . $xmlBancoHoras . "'";
    //==================================/

    // FALTA A COMPENSAR
    //Recupera código da falta a compensar e da compensação de falta
    $sqlFaltaCompensar = "SELECT codigo FROM Ntl.lancamento WHERE descricao = 'Falta a compensar'";

    $result = $reposit->RunQuery($sqlFaltaCompensar);

    if ($row = $result[0]) {
        $faltaCompensar = $row['codigo'];
    }

    $sqlCompensacaoFalta = "SELECT codigo FROM Ntl.lancamento WHERE descricao = 'Compensação de Falta'";

    $result = $reposit->RunQuery($sqlCompensacaoFalta);

    if ($row = $result[0]) {
        $compensaFalta = $row['codigo'];
    }
    //FIM

    $arrayCompensacaoFalta = $arrayBancoHoras['ponto'];
    $xmlCompensacaoFalta = "";
    $nomeXml = "ArrayOfCompensacaoFalta";
    $nomeTabela = "compensacaoFalta";
    $xmlCompensacaoFalta = "<?xml version=\"1.0\"?>";
    $xmlCompensacaoFalta .= "<$nomeXml xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">";

    foreach ($arrayCompensacaoFalta as $compensacaoFalta) {
        $dia = $compensacaoFalta['dia'];
        if ($compensacaoFalta['lancamento'] == $faltaCompensar) {

            $cargaHoraria = strtotime($fimExpediente) - strtotime($inicioExpediente);
            $cargaHoraria = $cargaHoraria - (strtotime($fimAlmoco) - strtotime($inicioAlmoco));

            $horaCompensar = sprintf("%02d%s%02d", floor($cargaHoraria / 3600), ":", ($cargaHoraria / 60) % 60);

            $xmlCompensacaoFalta .= "<$nomeTabela>";

            $xmlCompensacaoFalta .= "<horaCompensar>$horaCompensar</horaCompensar>";
            $xmlCompensacaoFalta .= "<horaCompensada>00:00</horaCompensada>";
            $xmlCompensacaoFalta .= "<dia>$dia</dia>";

            $xmlCompensacaoFalta .= "</$nomeTabela>";
        }

        if ($compensacaoFalta['lancamento'] == $compensaFalta) {
            if (($compensacaoFalta['horaSaida'] != '00:00:00') && ($compensacaoFalta['horaEntrada'] != '00:00:00')) {
                // Inicio e Fim expediente em segundos
                $fimExpedienteSegundos = explode(":", $fimExpediente);
                $fimExpedienteSegundos = $fimExpedienteSegundos[0] * 3600 + $fimExpedienteSegundos[1] * 60;
                $inicioExpedienteSegundos = explode(":", $inicioExpediente);
                $inicioExpedienteSegundos = $inicioExpedienteSegundos[0] * 3600 + $inicioExpedienteSegundos[1] * 60;

                $jornadaModerada = $fimExpedienteSegundos - $inicioExpedienteSegundos;

                // Hora entrada e saida em segundos
                $horaSaidaSegundos = explode(":", $compensacaoFalta['horaSaida']);
                $horaSaidaSegundos = $horaSaidaSegundos[0] * 3600 + $horaSaidaSegundos[1] * 60;
                $horaEntradaSegundos = explode(":", $compensacaoFalta['horaEntrada']);
                $horaEntradaSegundos = $horaEntradaSegundos[0] * 3600 + $horaEntradaSegundos[1] * 60;

                $jornada = $horaSaidaSegundos - $horaEntradaSegundos;

                $diff = abs($jornada - $jornadaModerada);

                if ($diff != 0) {

                    if ($toleranciaDia) {
                        $jornadaModeradaToleranteExtra = $jornadaModerada + $toleranciaDia;
                        if ($jornada > $jornadaModeradaToleranteExtra) {
                            $horaCompensada = sprintf("%02d%s%02d", floor($diff / 3600), ":", ($diff / 60) % 60);
                        }
                    } else {

                        $limiteEntradaSegundos = explode(":", $toleranciaAtraso);
                        $limiteEntradaSegundos = $limiteEntradaSegundos[0] * 3600 + $limiteEntradaSegundos[1] * 60;
                        $horaInicioExtraTolerante = $inicioExpedienteSegundos - $limiteEntradaSegundos;

                        $limiteSaidaSegundos = explode(":", $toleranciaExtra);
                        $limiteSaidaSegundos = $limiteSaidaSegundos[0] * 3600 + $limiteSaidaSegundos[1] * 60;
                        $horaFimExtraTolerante = $fimExpedienteSegundos + $limiteSaidaSegundos;

                        if ($horaEntradaSegundos < $horaInicioExtraTolerante) {
                            $horaCompensada = $inicioExpedienteSegundos - $horaEntradaSegundos;
                        }

                        if ($horaSaidaSegundos > $horaFimExtraTolerante) {
                            $horaCompensada += $horaSaidaSegundos - $fimExpedienteSegundos;
                        }
                        $horaCompensada = sprintf("%02d%s%02d", floor($horaCompensada / 3600), ":", ($horaCompensada / 60) % 60);
                    }
                }

                $xmlCompensacaoFalta .= "<$nomeTabela>";

                $xmlCompensacaoFalta .= "<horaCompensar>00:00</horaCompensar>";
                $xmlCompensacaoFalta .= "<horaCompensada>$horaCompensada</horaCompensada>";
                $xmlCompensacaoFalta .= "<dia>$dia</dia>";

                $xmlCompensacaoFalta .= "</$nomeTabela>";
            }
        }
    }
    $xmlCompensacaoFalta .= "</$nomeXml>";
    $xml = simplexml_load_string($xmlCompensacaoFalta);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlCompensacaoFalta = "'" . $xmlCompensacaoFalta . "'";
    //==================================/
    // XML Justificativa
    $comum = new comum();
    $xmlJustificativa = new \FluidXml\FluidXml('ArrayOfJustificativa', ['encoding' => '']);
    $xmlJustificativa->addChild('justificativa', true) //nome da tabela
        ->add('folhaPontoMensal', $idFolha)
        ->add('dia', $_POST['dia'])
        ->add('observacao', $observacao)
        ->add('campo', $_POST['btnClicado']);
    $xmlJustificativa = $comum->formatarString($xmlJustificativa);

    $sql =
        "Funcionario.folhaPontoMensal_Atualiza 
        $idFolha,
        $funcionario,
        '$mesAno',
        '$observacao',
        $status,
        $usuario,
        $xmlFolhaPontoMensal,
        $xmlDiasAlterados,
        $bancoHoras,
        $xmlBancoHoras,
        $xmlCompensacaoFalta,
        $xmlJustificativa";

    $reposit = new reposit();

    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret . $msg;
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

    $sql = "SELECT codigo, folhaPontoMensal, dia, horaEntrada, inicioAlmoco, fimAlmoco, horaSaida, horaExtra, atraso, observacaoAtraso, observacaoExtra, lancamento FROM dbo.folhaPontoMensalDetalheDiario where folhaPontoMensal = $idFolha AND dia = $dia";
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
        $lancamento
        ;

        if ($out == "") {
            echo "failed#";
            return;
        }
    
        echo "sucess#" . $out;
        return;






        // $sql = "SELECT FPM.codigo, FPM.status, FD.dia, FD.folhaPontoMensal,FD.codigo AS codigoDetalhe,FD.horaEntrada,FD.horaSaida,FD.inicioAlmoco,
    //         FD.fimAlmoco,FD.horaExtra,FD.atraso, FD.lancamento, S.descricao
    //         FROM Funcionario.folhaPontoMensal FPM
    //         LEFT JOIN Funcionario.folhaPontoMensalDetalheDiario FD ON FD.folhaPontoMensal = FPM.codigo
    //         LEFT JOIN Ntl.status S ON S.codigo = FPM.status
    //         LEFT JOIN Ntl.funcionario F ON F.codigo = FPM.funcionario
    //         INNER JOIN Ntl.beneficioProjeto BP ON BP.funcionario = F.codigo
    //         WHERE (0=0) AND FPM.funcionario = $id AND mesAno ='$mesAno' AND dia = $dia AND BP.ativo = 1";



    // $sql = " SELECT FU.codigo, FU.ativo, FU.cpf, FU.rg, FU.dataNascimento, FU.estadoCivil, FU.nome, FU.cep, FU.primeiroEmprego, FU.pisPasep, G.descricao as genero 
    // from dbo.funcionario FU
    // LEFT JOIN dbo.genero G on G.codigo = FU.genero";





    // $sql = "SELECT P.codigo, P.registraAlmoco, BP.horaInicio, BP.horaFim, BP.tipoEscala, P.layoutFolhaPonto, P.limiteEntrada AS 'limiteAtraso',
    //         P.limiteSaida AS 'limiteExtra', P.toleranciaDia, BP.verificaIp,BP.registraPonto, BP.dataRegistro, BP.fimPonto,BP.escalaDia,BP.intervaloSabado,
    //         BP.horaInicioSabado, BP.horaFimSabado,BP.intervaloDomingo,BP.horaInicioDomingo, BP.horaFimDomingo, BP.registraPausa, P.verificaIp as verificaIpProjeto
    //         FROM Ntl.projeto P
    //         INNER JOIN Ntl.beneficioProjeto BP ON BP.projeto = P.codigo
    //         WHERE P.ativo = 1 AND P.codigo = $projeto AND BP.funcionario = $id AND BP.ativo = 1";
    // $result = $reposit->RunQuery($sql);
    // if ($row = $result[0]) {
    //     $tipoEscala = $row['tipoEscala'];
    //     $registraAlmoco = $row['registraAlmoco'];
    //     $layoutFolhaPonto = (int)trim($row['layoutFolhaPonto']);
    //     $toleranciaAtraso = trim($row['limiteAtraso']);
    //     $toleranciaExtra = trim($row['limiteExtra']);
    //     $toleranciaDia = trim($row['toleranciaDia']);
    //     $verificaIp = $row['verificaIp'];
    //     if (!$verificaIp) {
    //         $verificaIp = $row['verificaIpProjeto'];
    //     }
    //     $registraPonto = $row['registraPonto'];
    //     $inicioRegistroPonto = $row['dataRegistro'];
    //     $inicioRegistroPonto = explode(' ', $inicioRegistroPonto);
    //     $fimRegistroPonto = $row['fimPonto'];
    //     $fimRegistroPonto = explode(" ", $fimRegistroPonto);
    //     $escalaDia = $row['escalaDia'];
    //     $intervaloSabado = $row['intervaloSabado'];
    //     $intervaloDomingo = $row['intervaloDomingo'];

    //     // Registro de pausas para descanso
    //     $registraPausa = $row['registraPausa'];

    //     if ($registraAlmoco == 0) {
    //         $inicioAlmoco = $row['horaInicio'];
    //         $fimAlmoco = $row['horaFim'];
    //         // verifica se é sabado para pegar hora almoco sabado.
    //         $diaSemana = date("w", strtotime($diaMesAno));
    //         if ($diaSemana == 6) {
    //             $inicioAlmoco = $row['horaInicioSabado'];
    //             $fimAlmoco = $row['horaFimSabado'];
    //         }
    //         // verifica se é domingo para pegar hora almoco domingo.
    //         if ($diaSemana == 0) {
    //             $inicioAlmoco = $row['horaInicioDomingo'];
    //             $fimAlmoco = $row['horaFimDomingo'];
    //         }
    //     }
    // }

    // if ($fimRegistroPonto[0] != "") {
    //     if (($diaMesAno > $fimRegistroPonto[0]) || ($diaMesAno < $inicioRegistroPonto[0])) {
    //         $registraPonto = 0;
    //     }
    // } else {
    //     if (($diaMesAno < $inicioRegistroPonto[0])) {
    //         $registraPonto = 0;
    //     }
    // }

    // // Verifica se esta de férias
    // $sqlFerias = "SELECT dataInicio, dataFim
    //                 FROM Beneficio.funcionarioFerias 
    //                 WHERE funcionario = $id AND mesAno = '$mesAno' AND ativo = 1";
    // $resultFerias = $reposit->RunQuery($sqlFerias);

    // $ferias = 0;
    // if ($row = $resultFerias[0]) {
    //     $dataInicio = $row['dataInicio'];
    //     $dataFim = $row['dataFim'];

    //     for ($i = $dataInicio; $i < $dataFim;) {
    //         $i = date('Y-m-d', strtotime($i));

    //         if ($i == $diaMesAno) {
    //             $ferias = 1;
    //             break;
    //         }
    //         $i = date('Y-m-d 00:00:00', strtotime("+1 days", strtotime($i)));
    //     }
    // }

    // // Verifica se esta de folga
    // $sqlFolga = "SELECT dataInicio, dataFim
    //                 FROM Beneficio.folga
    //                 WHERE funcionario = $id AND ('$diaMesAno' >= dataInicio AND '$diaMesAno' <= dataFim) AND ativo = 1";
    // $resultFolga = $reposit->RunQuery($sqlFolga);

    // $folga = 0;
    // if ($row = $resultFolga[0]) {
    //     $dataInicio = $row['dataInicio'];
    //     $dataFim = $row['dataFim'];

    //     for ($i = $dataInicio; $i <= $dataFim;) {
    //         $i = date('Y-m-d', strtotime($i));

    //         if ($i == $diaMesAno) {
    //             $folga = 1;
    //             break;
    //         }
    //         $i = date('Y-m-d 00:00:00', strtotime("+1 days", strtotime($i)));
    //     }
    // }

    // $folgaCobertura = 0;
    // if ($folga == 1) {
    //     $sqlFolgaCobertura = "SELECT * FROM Funcionario.solicitacaoAlteracaoFolga 
    //                         WHERE funcionario = $id AND dataPrevistaFolga = '$diaMesAno' AND tipoFolga = 3";
    //     $resultFolgaCobertura = $reposit->RunQuery($sqlFolgaCobertura);

    //     if ($row = $resultFolgaCobertura[0]) {
    //         $folgaCobertura = 1;
    //     }
    // }

    // // Verifica se tem documento validado pelo RH na data selecionada
    // $sqlUpload = "SELECT UD.dataInicio, UD.dataFim, UD.lancamento, L.abonaAtraso
    //                 FROM Funcionario.uploadDocumentoFolhaPonto UD
    //                 INNER JOIN Ntl.lancamento L ON L.codigo = UD.lancamento
    //                 WHERE UD.funcionario = $id AND ('$diaMesAno' >= UD.dataInicio AND '$diaMesAno' <= UD.dataFim) AND UD.status = 3";
    // $resultUpload = $reposit->RunQuery($sqlUpload);

    // $documento = 0;
    // if ($row = $resultUpload[0]) {
    //     $dataInicio = $row['dataInicio'];
    //     $dataFim = $row['dataFim'];
    //     $abonaAtraso = $row['abonaAtraso'];

    //     for ($i = $dataInicio; $i <= $dataFim;) {
    //         $i = date('Y-m-d', strtotime($i));

    //         if ($i == $diaMesAno && ($abonaAtraso == 0 || !$abonaAtraso)) {
    //             $documento = 1;
    //             break;
    //         }
    //         $i = date('Y-m-d 00:00:00', strtotime("+1 days", strtotime($i)));
    //     }
    // }

    // $sqlPausa = "SELECT inicioPrimeiraPausa, fimPrimeiraPausa,inicioSegundaPausa, fimSegundaPausa
    //             FROM Funcionario.pausasDescanso
    //             WHERE folhaPontoMensal = $idFolha AND dia = $dia";
    // $result = $reposit->RunQuery($sqlPausa);

    // if ($row = $result[0]) {
    //     $inicioPrimeiraPausa = $row['inicioPrimeiraPausa'];
    //     $fimPrimeiraPausa = $row['fimPrimeiraPausa'];
    //     $inicioSegundaPausa = $row['inicioSegundaPausa'];
    //     $fimSegundaPausa = $row['fimSegundaPausa'];
    // }

    //     $lancamento . "^" .
    //     $status . "^" .
    //     $descricaoStatus . "^" .
    //     $registraAlmoco . "^" .
    //     $registraPonto . "^" .
    //     $tipoEscala . "^" .
    //     $layoutFolhaPonto . "^" .
    //     $toleranciaAtraso . "^" .
    //     $toleranciaExtra . "^" .
    //     $toleranciaDia . "^" .
    //     $verificaIp . "^" .
    //     $ferias . "^" .
    //     $escalaDia . "^" .
    //     $intervaloSabado . "^" .
    //     $intervaloDomingo . "^" .
    //     $registraPausa . "^" .
    //     $inicioPrimeiraPausa . "^" .
    //     $fimPrimeiraPausa . "^" .
    //     $inicioSegundaPausa . "^" .
    //     $fimSegundaPausa . "^" .
    //     $folga . "^" .
    //     $documento . "^" .
    //     $folgaCobertura;

 
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
