<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');
// $usuario = $_SESSION['login'];
// if ((empty($_GET["id"])) || (!isset($_GET["id"])) || (is_null($_GET["id"]))) {
//     session_start();
//     $id = $_SESSION['funcionario'];
// } else {
//     $id = (int)$_GET["id"];
// }

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once('fpdf/fpdf.php');

$idFolha = (int)$_GET["idFolha"];

$sql = "SELECT FPMDD.folhaPontoMensal, FPMDD.dia, FPMDD.horaEntrada, FPMDD.inicioAlmoco, FPMDD.fimAlmoco, FPMDD.horaSaida, FPMDD.horaExtra, FPMDD.atraso, FPMDD.observacaoAtraso, FPMDD.observacaoExtra,
FPMDD.lancamento, L.descricao, L.diaFolga, FPMDD.atrasoAlmoco, FPMDD.horaTotalDia, FPMDD.horasPositivasDia, FPMDD.horasNegativasDia, FPM.mesAno, FPM.funcionarioId as codigoFuncionario
FROM dbo.folhaPontoMensalDetalheDiario FPMDD
LEFT JOIN dbo.folhaPontoMensal FPM on FPMDD.folhaPontoMensal = FPM.codigo
LEFT JOIN dbo.lancamento L on L.codigo = FPMDD.lancamento
WHERE FPMDD.folhaPontoMensal = $idFolha";
$reposit = new reposit();
$result = $reposit->RunQuery($sql);

if ($row = $result[0]) {
    $horaEntrada = $row['horaEntrada'];
    $horaSaida = $row['horaSaida'];
    $folhaPontoMensal = $row['folhaPontoMensal '];
    $dia = $row['dia'];
    $horaEntrada = $row['horaEntrada'];
    $almocoInicio = $row['inicioAlmoco'];
    $fimAlmoco = $row['fimAlmoco'];
    $horaSaida = $row['horaSaida'];
    $horaExtra = $row['horaExtra'];
    $atraso = $row['atraso'];
    $observacaoAtraso = $row['observacaoAtraso'];
    $observacaoExtra = $row['observacaoExtra'];
    $lancamento = $row['lancamento'];
    $atrasoAlmoco = $row['atrasoAlmoco'];
    $horaTotalDia = $row['horaTotalDia'];
    $codigoFuncionario = $row['codigoFuncionario'];
    $mesAno = $row['mesAno'];
}

$ponto = array();
$data = explode('-', ($result[0])['mesAno']);
$mes = (int)$data[1];
$totalDiasMes = cal_days_in_month(CAL_GREGORIAN, $data[1], $data[0]);
$controleDiaPonto = 0;
$contador = 1;

$hhNegativaTotal = 0;
$mmNegativaTotal = 0;
$ssNegativaTotal = 0;

$totalHorasPositivasMes = "00:00:00";
$totalHorasNegativasMes = "00:00:00";


while ($contador <= $totalDiasMes) {
    $diaPonto = ($result[$controleDiaPonto])['dia'];

    while ($diaPonto != $contador && $contador <= $totalDiasMes) {
        $dadoSalvo = $ponto[$contador - 1];
        if ($dadoSalvo) {

            if ($dadoSalvo['dia'] == $contador) {

                $ponto[$diasCount] = [
                    "codigo" => $row["codigo"],
                    "dia" => $row["dia"],
                    "horaEntrada" => $row["horaEntrada"],
                    "inicioAlmoco" => $row["inicioAlmoco"],
                    "fimAlmoco" => $row["fimAlmoco"],
                    "horaSaida" => $row["horaSaida"],
                    "horaExtra" => $row["horaExtra"],
                    "atraso" => $row["atraso"],
                    "descricaoLancamento" => $row["descricao"],
                    "diaFolga" => $row["diaFolga"],
                    "horasPositivasDia" => $row["horasPositivasDia"],
                    "horasNegativasDia" => $row["horasNegativasDia"]
                ];
                $diaFolga = $row['diaFolga'];
                if ($diaFolga != 1) {
                    $horaNegativa = $row["horasNegativasDia"];
                    $horaNegativaPartida = explode(":", $horaNegativa);
                    $hhNegativa = (int)$horaNegativaPartida[0];
                    $mmNegativa = (int)$horaNegativaPartida[1];
                    $ssNegativa = (int)$horaNegativaPartida[2];

                    $hhNegativaTotal += $hhNegativa;
                    $mmNegativaTotal += $mmNegativa;
                    $ssNegativaTotal += $ssNegativa;
                }
            } else {
                array_push($ponto, [
                    "codigo" => "",
                    "dia" => $contador,
                    "horaEntrada" => "",
                    "inicioAlmoco" => "",
                    "fimAlmoco" => "",
                    "horaSaida" => "",
                    "horaExtra" => "",
                    "atraso" => "",
                    "descricaoLancamento" => "",
                    "diaFolga" => "",
                    "horasPositivasDia" => "",
                    "horasNegativasDia" => ""
                ]);
            }
        } else {
            array_push($ponto, [
                "codigo" => "",
                "dia" => $contador,
                "horaEntrada" => "",
                "inicioAlmoco" => "",
                "fimAlmoco" => "",
                "horaSaida" => "",
                "horaExtra" => "",
                "atraso" => "",
                "descricaoLancamento" => "",
                "diaFolga" => "",
                "horasPositivasDia" => "",
                "horasNegativasDia" => ""
            ]);
        }
        $contador++;
    }

    if ($contador == $diaPonto) {
        $sql2 = "SELECT FPMDD.folhaPontoMensal, FPMDD.dia, FPMDD.horaEntrada, FPMDD.inicioAlmoco, FPMDD.fimAlmoco, FPMDD.horaSaida, FPMDD.horaExtra, FPMDD.atraso, FPMDD.observacaoAtraso, FPMDD.observacaoExtra,
        FPMDD.lancamento, L.diaFolga, L.descricao as descricao, FPMDD.atrasoAlmoco, FPMDD.horaTotalDia, FPMDD.horasPositivasDia, FPMDD.horasNegativasDia, FPM.mesAno, FPM.funcionarioId as codigoFuncionario
        FROM dbo.folhaPontoMensalDetalheDiario FPMDD
        LEFT JOIN dbo.folhaPontoMensal FPM on FPMDD.folhaPontoMensal = FPM.codigo
        LEFT JOIN dbo.lancamento L on L.codigo = FPMDD.lancamento
        WHERE FPMDD.folhaPontoMensal = $idFolha AND FPMDD.dia = $diaPonto";
        $reposit = new reposit();
        $result2 = $reposit->RunQuery($sql2);

        if ($row2 = $result2[0]) {

            array_push($ponto, [
                "codigo" => $row2["codigo"],
                "dia" => $row2["dia"],
                "horaEntrada" => $row2["horaEntrada"],
                "inicioAlmoco" => $row2["inicioAlmoco"],
                "fimAlmoco" => $row2["fimAlmoco"],
                "horaSaida" => $row2["horaSaida"],
                "horaExtra" => $row2["horaExtra"],
                "atraso" => $row2["atraso"],
                "descricaoLancamento" => $row2["descricao"],
                "diaFolga" => $row2["diaFolga"],
                "horasPositivasDia" => $row2["horasPositivasDia"],
                "horasNegativasDia" => $row2["horasNegativasDia"]
            ]);
            $diaFolga = $row2['diaFolga'];
            if ($diaFolga != 1) {

                $horaNegativa = $row2["horasNegativasDia"];
                $horaNegativaPartida = explode(":", $horaNegativa);
                $hhNegativa = (int)$horaNegativaPartida[0];
                $mmNegativa = (int)$horaNegativaPartida[1];
                $ssNegativa = (int)$horaNegativaPartida[2];

                $hhNegativaTotal += $hhNegativa;
                $mmNegativaTotal += $mmNegativa;
                $ssNegativaTotal += $ssNegativa;

                if ($ssNegativaTotal >= 60) {
                    $ssNegativaTotal = $ssNegativaTotal - 60;
                    $mmNegativaTotal += 1;
                }
                if ($mmNegativaTotal >= 60) {
                    $mmNegativaTotal = $mmNegativaTotal - 60;
                    $hhNegativaTotal += 1;
                }

                $horaPositiva = $row2["horasPositivasDia"];
                $horaPositivaPartida = explode(":", $horaPositiva);
                $hhPositiva = (int)$horaPositivaPartida[0];
                $mmPositiva = (int)$horaPositivaPartida[1];
                $ssPositiva = (int)$horaPositivaPartida[2];

                $hhPositivaTotal += $hhPositiva;
                $mmPositivaTotal += $mmPositiva;
                $ssPositivaTotal += $ssPositiva;

                if ($ssPositivaTotal >= 60) {
                    $ssPositivaTotal = $ssPositivaTotal - 60;
                    $mmPositivaTotal += 1;
                }
                if ($mmPositivaTotal >= 60) {
                    $mmPositivaTotal = $mmPositivaTotal - 60;
                    $hhPositivaTotal += 1;
                }
            }

            $controleDiaPonto++;
        }
    }

    $contador++;
}

$hhNegativaTotal = strval($hhNegativaTotal);
$mmNegativaTotal = strval($mmNegativaTotal);
$ssNegativaTotal = strval($ssNegativaTotal);

if (strlen($hhNegativaTotal) == 1) {
    $hhNegativaTotal = "0"  . $hhNegativaTotal;
}

if (strlen($mmNegativaTotal) == 1) {
    $mmNegativaTotal = "0"  . $mmNegativaTotal;
}
if (strlen($ssNegativaTotal) == 1) {
    $ssNegativaTotal = "0"  . $ssNegativaTotal;
}

$totalHorasNegativasMes = $hhNegativaTotal . ":" . $mmNegativaTotal . ":" . $ssNegativaTotal;

$hhPositivaTotal = strval($hhPositivaTotal);
$mmPositivaTotal = strval($mmPositivaTotal);
$ssPositivaTotal = strval($ssPositivaTotal);

if (strlen($hhPositivaTotal) == 1) {
    $hhPositivaTotal = "0"  . $hhPositivaTotal;
}

if (strlen($mmPositivaTotal) == 1) {
    $mmPositivaTotal = "0"  . $mmPositivaTotal;
}
if (strlen($ssPositivaTotal) == 1) {
    $ssPositivaTotal = "0"  . $ssPositivaTotal;
}

$totalHorasPositivasMes = $hhPositivaTotal . ":" . $mmPositivaTotal . ":" . $ssPositivaTotal;


if ($totalHorasPositivasMes == "00:00:00") {
    $bancoNegativoSim = 1;

    $hhBancoMensal = "-" . (int)$hhNegativaTotal;
    $mmBancoMensal = (int)$mmNegativaTotal;
    $ssBancoMensal = (int)$ssNegativaTotal;
} else {
    $hhBancoMensal = (int)$hhPositivaTotal - (int)$hhNegativaTotal;
    $mmBancoMensal = (int)$mmPositivaTotal - (int)$mmNegativaTotal;
    $ssBancoMensal = (int)$ssPositivaTotal - (int)$ssNegativaTotal;
}

if ($hhBancoMensal || $mmBancoMensal || $ssBancoMensal) {
    if ($ssBancoMensal < 0) {
        $ssBancoMensal = 60 + $ssBancoMensal;
        $mmBancoMensal -= 1;
    }
    if ($mmBancoMensal < 0) {
        $mmBancoMensal = 60 + $mmBancoMensal;
        $hhBancoMensal -= 1;
    }
    if ((int)$hhBancoMensal < 0) {
        $hhBancoMensalTesteNegativo = explode("-", $hhBancoMensal);
        $hhBancoMensal = $hhBancoMensalTesteNegativo[1];
    }
    if ($bancoNegativoSim == 1) {
        $hhBancoMensalTesteNegativo = explode("-", $hhBancoMensal);
        $hhBancoMensal = $hhBancoMensalTesteNegativo[1];
    }
}

// $hhBancoMensal = strval($hhBancoMensal);
// $mmBancoMensal = strval($mmBancoMensal);
// $ssBancoMensal = strval($ssBancoMensal);

if (strlen($hhBancoMensal) == 1) {
    $hhBancoMensal = "0"  . $hhBancoMensal;
}
if (strlen($mmBancoMensal) == 1) {
    $mmBancoMensal = "0"  . $mmBancoMensal;
}
if (strlen($ssBancoMensal) == 1) {
    $ssBancoMensal = "0"  . $ssBancoMensal;
}

if ($hhBancoMensalTesteNegativo) {
    if (count($hhBancoMensalTesteNegativo) > 1) {
        $saldoBancoMensal = "- " . $hhBancoMensal . ":" . $mmBancoMensal . ":" . $ssBancoMensal;
    }
} else {
    $saldoBancoMensal = $hhBancoMensal . ":" . $mmBancoMensal . ":" . $ssBancoMensal;
}

$sqlFuncionario = "SELECT nome, ativo, escala, empresa, cargo from dbo.funcionario where codigo = $codigoFuncionario";
$reposit = new reposit();
$result = $reposit->RunQuery($sqlFuncionario);

if ($row = $result[0]) {
    $nome = $row['nome'];
    $ativo = $row['ativo'];
    $codigoEscala = $row['escala'];
    $codigoEmpresa = $row['empresa'];
    $codigoCargo = $row['cargo'];
}

$sqlEmpresa = "SELECT nome AS empresa, cnpj, tipoLogradouro, logradouro, numero, complemento, bairro, uf
FROM dbo.empresa where codigo = $codigoEmpresa";
$reposit = new reposit();
$result = $reposit->RunQuery($sqlEmpresa);

if ($row = $result[0]) {
    $empresa = $row['empresa'];
    $cnpj = $row['cnpj'];
    $tipoLogradouro = $row['tipoLogradouro'];
    $logradouro = $row['logradouro'];
    $numero = $row['numero'];
    $complemento = $row['complemento'];
    $bairro = $row['bairro'];
    $uf = $row['uf'];
}

$sqlEscala = "SELECT descricao, horaEntrada, inicioIntervalo, fimIntervalo, horaSaida, expediente, intervalo, domingo, segunda, terca, quarta, quinta, sexta, sabado, tolerancia FROM dbo.escala where codigo = $codigoEscala";
$reposit = new reposit();
$result = $reposit->RunQuery($sqlEscala);

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

$sqlCargo = "SELECT descricao FROM dbo.cargo where codigo = $codigoCargo";

$reposit = new reposit();
$result = $reposit->RunQuery($sqlCargo);
if ($row = $result[0]) {
    $cargo = $row['descricao'];
}

$mesAnoPartido = explode("-", $mesAno);
$ano =  (int)$mesAnoPartido[0];
$mesNumero = $mesAnoPartido[1];

$valor_de_retorno = match ($mesNumero) {
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembto',
    '12' => 'Dezembro'
};

$mesExtenso = $valor_de_retorno;


class PDF extends FPDF
{
    function Header()
    {
        global $codigo;
        global $img1;

        $sqlLogo = "SELECT parametroLogoRelatorio 
        FROM Ntl.parametro ";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sqlLogo);
        $rowLogo = $result[0];
        $logo = $rowLogo['parametroLogoRelatorio'];
        if ($logo != "") {
            $img = explode('/', $logo);
            $img = $img[1] . "/" . $img[2] . "/" . $img[3];
            $img = str_replace('"', "'", $img);
            list($x1, $y1) = getimagesize($img);
            $x2 = 15;
            $y2 = 5;
            if (($x1 / $x2) < ($y1 / $y2)) {
                $y2 = 5;
            } else {
                $x2 = 5;
            }
            if (file_exists($img)) {
                $this->Cell(116, 1, "", 0, 1, 'C', $this->Image($img, $x2, $y2, 0, 10));
            }
        }
        $sqlMarca = "SELECT nome 
        FROM Ntl.parametro ";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sqlMarca);
        $rowMarca = $result[0];
        $logoMarca = $rowMarca['parametroMarca'];
        if ($logoMarca != "") {

            $img1 = explode('/', $logoMarca);
            $img1 = $img1[1] . "/" . $img1[2] . "/" . $img1[3];
            $img1 = str_replace('"', "'", $img1);
            list($x3, $y3) = getimagesize($img1);
            $x4 = 1;
            $y4 = 100;
            if (($x3 / $x4) < ($y3 / $y4)) {
                $y4 = 5;
            } else {
                $x4 = 50;
            }
            if (file_exists($img1)) {
                $this->Image($img1, $x4, $y4, 105, 105);
            }
        }

        $this->Ln(24); #Quebra de Linhas

    }
    function Footer()
    {
        $this->SetY(202);
    }
}

$pdf = new PDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
$pdf->SetFillColor(238, 238, 238);
$pdf->SetMargins(0, 0, 0); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->AddPage();
// $pdf->AcceptPageBreak(0);
$pdf->SetAutoPageBreak(0);

$pdf->Line(5, 17, 205, 17); //primeira linha
$pdf->Line(5, 17, 205, 17); //primeira linha
$pdf->Line(5, 17, 205, 17); //primeira linha
$pdf->Line(5, 17, 205, 17); //primeira linha

$pdf->SetFont('Times', 'B', 12);
$pdf->setY(10);
$pdf->Cell(193, 5, iconv('UTF-8', 'windows-1252', "FOLHA DE PONTO INDIVIDUAL DE TRABALHO"), 0, 0, "C", 0);
$pdf->Ln(10);

$pdf->setY(17);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "$empresa"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->setY(17);
$pdf->setX(67);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CNPJ: $cnpj"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(17);
$pdf->setX(106);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "$tipoLogradouro: $logradouro, $numero - $complemento - $bairro - $uf"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Line(5, 21, 205, 21); // linha abaixo de ntl cnpj e endereco

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Expediente: $horaEntradaEscala ÀS $horaSaidaEscala"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(Intervalo: $inicioIntervaloEscala ÀS $fimIntervaloEscala)"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(67);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Cliente: GIR ESTÁTICO"), 0, 0, "L", 0);
$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(67);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Cargo: $cargo"), 0, 0, "L", 0);
$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(127);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Mês:"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 8);
$pdf->setY(21);
$pdf->setX(134);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $mesExtenso), 0, 0, "L", 0);

$pdf->setX(190);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Ano:"), 0, 0, "L", 0);
$pdf->setX(197);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', $ano), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->Line(106, 21, 106, 17); //linha em pé ao lado de rua
$pdf->Line(126, 25, 126, 21); //linha em pé ao lado do mes
$pdf->Line(189, 25, 189, 21); //linha em pé ao lado do ano
$pdf->Line(5, 25, 205, 25); //linha abaixo de expediente cliente mes eno
$pdf->Line(5, 29, 205, 29); //linha abaixo de expediente cliente mes eno

$pdf->setY(29);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(67);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Nome:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->setX(77);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0);

$pdf->setY(29);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Matricula:"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 8);
$pdf->setX(20);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $codigoFuncionario), 0, 0, "L", 0);

$pdf->Line(5, 33, 205, 33); //linha abaixo do nome e matricula


$pdf->SetFillColor(220, 220, 220); //CINZA TITULO
$pdf->setY(33.2);
$pdf->setX(5);
$pdf->Cell(200, 9.8, iconv('UTF-8', 'windows-1252', "DIAS"), 0, 0, "L", 1);

$pdf->setY(36);
$pdf->setX(16);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "ENTRADA"), 0, 0, "L", 0);

$pdf->setY(39);
$pdf->setX(35);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Saida"), 0, 0, "L", 0);

$pdf->setY(39);
$pdf->setX(51);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Retorno"), 0, 0, "L", 0);

$pdf->setY(34);
$pdf->setX(42);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "INTERVALO"), 0, 0, "L", 0);

$pdf->setY(35);
$pdf->setX(71);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "SAIDA"), 0, 0, "L", 0);

$pdf->setY(34);
$pdf->setX(99);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "HORAS"), 0, 0, "L", 0);

$pdf->setY(39);
$pdf->setX(89);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Positivas"), 0, 0, "L", 0);

$pdf->setY(39);
$pdf->setX(109);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Negativas"), 0, 0, "L", 0);

$pdf->setY(36);
$pdf->setX(148);
$pdf->Cell(32, 5, iconv('UTF-8', 'windows-1252', "OBSERVAÇÃO"), 0, 0, "C", 0);

$pdf->SetFillColor(238, 238, 238); //CINZA

$pdf->Line(5, 43, 205, 43); // linha abaixo de diaas entrada saida observacao e visto
$pdf->Line(32, 39, 67, 39); //linha abaixo do almoco
$pdf->Line(86, 39, 126, 39); //linha abaixo de extras

$linhavertical = 46;
$linhahorizontalteste = 50;
$linhaverticalteste = 50;
// $days = (int)$days;
$repetiu = 1;
$valorIndex = 0;
$index = 0;

if ($ponto) {

    while ($repetiu < $totalDiasMes) {

        if ($valorIndex != 0) {
            $index = $valorIndex + 1;
        }

        $tamanho = count($ponto) - $index;

        array_splice($ponto, 0, -$tamanho);

        foreach ($ponto as $index => $registro) {

            $diadasemana = strftime('%u', strtotime($ano . '-' . $mes . '-' . $registro['dia']));
            $diaferiado = new DateTime($ano . '-' . $mes . '-' . $registro['dia']);
            if ($registro['dia'] < 10) {
                $diaMesAno = preg_replace("/\d{2}$/", "0" . $registro['dia'], $mesAno);
            } else {
                $diaMesAno = preg_replace("/\d{2}$/", $registro['dia'], $mesAno);
            }
            $dataAtual = new DateTime();
            $dataAtual = $dataAtual->format('Y-m-d');
            if ($registro['horasPositivasDia'] == "00:00:00") {
                $registro['horasPositivasDia'] = "";
            }
            if ($registro['horasNegativasDia'] == "00:00:00") {
                $registro['horasNegativasDia'] = "";
            }

            $entrada = $registro['horaEntrada'];
            if ($entrada == '00:00:00') {
                $entrada = '';
            }
            $almocoInicio = $registro['inicioAlmoco'];
            if ($almocoInicio == "00:00:00") {
                $almocoInicio = '';
            }
            $almocoFim = $registro['fimAlmoco'];
            if ($almocoFim == "00:00:00") {
                $almocoFim = '';
            }
            $saida = $registro['horaSaida'];
            if ($saida == '00:00:00') {
                $saida = '';
            }
            $atraso = $registro['atraso'];
            if ($atraso == '00:00:00') {
                $atraso = '';
            }
            $horaNegativaDia = $registro['horasNegativasDia'];
            if ($horaNegativaDia == '00:00:00') {
                $horaNegativaDia = '';
            }
            $horaPositivaDia = $registro['horasPositivasDia'];
            if ($horaPositivaDia == '00:00:00') {
                $horaPositivaDia = '';
            }

            $diaFolga = $registro['diaFolga'];
            if ($diaFolga == '1') {
                $entrada = "-";
                $almocoInicio = "-";
                $almocoFim = "-";
                $saida = "-";
                $registro['horasPositivasDia'] = "-";
                $registro['horasNegativasDia'] = "-";
            }


            $y = $pdf->GetY();

            if ($y < $linhaverticalteste) {
                // LINHAS DA ESQUERDA PRA DIREITA // 
                $pdf->Line(5, $linhaverticalteste, 5, 17); // 0 
                $pdf->Line(16, $linhaverticalteste, 16, 33.1); // 1
                $pdf->Line(32, $linhaverticalteste, 32, 33); // 2
                $pdf->Line(49, $linhaverticalteste, 49, 39.1); // 3 
                $pdf->Line(67, $linhaverticalteste, 67, 17); // 4 
                $pdf->Line(86, $linhaverticalteste, 86, 33); // 5 
                $pdf->Line(106, $linhaverticalteste, 106, 39.1); // 6
                $pdf->Line(126, $linhaverticalteste, 126, 33); // 7
                // $pdf->Line(189, $linhaverticalteste, 189, 33); // 8 linha lado esquerdo do visto
                $pdf->Line(205, $linhaverticalteste, 205, 17); // 9 
            }

            $pdf->Line(5, $linhahorizontalteste, 205, $linhahorizontalteste);

            $pdf->Line(5, $linhahorizontalteste + 0.1, 205, $linhahorizontalteste + 0.1);
            $pdf->setY($linhavertical - 2.7);

            $pdf->setX(5);
            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', "" . $registro['dia'] . ""), 0, 0, "L", 0);
            $pdf->SetFont('Arial', 'B', 7);



            switch ($diadasemana) {
                case 1:
                    if ($segundaEscala == 0) { //Seg-Sex
                        $pdf->setX(16);
                        $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //entrada
                        $pdf->setX(32.2);
                        $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // inicio almoco
                        $pdf->setX(49.2);
                        $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // fim almoco
                        $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA EXTRA SAIDA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA POSITIVA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA NEGATIVA
                        $pdf->Cell(79,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //observacao
                    }

                    $pdf->setX(7);
                    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Seg"), 0, 0, "L", 0);
                    $pdf->SetFont('Arial', 'B', 8);
                    break;
                case 2:
                    if ($tercaEscala == 0) { //Seg-Sex
                        $pdf->setX(16);
                        $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //entrada
                        $pdf->setX(32.2);
                        $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // inicio almoco
                        $pdf->setX(49.2);
                        $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // fim almoco
                        $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA EXTRA SAIDA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA POSITIVA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA NEGATIVA
                        $pdf->Cell(79,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //observacao
                    }

                    $pdf->setX(7);
                    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Ter"), 0, 0, "L", 0);
                    $pdf->SetFont('Arial', 'B', 8);
                    break;
                case 3:
                    if ($quartaEscala == 0) { //Seg-Sex
                        $pdf->setX(16);
                        $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //entrada
                        $pdf->setX(32.2);
                        $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // inicio almoco
                        $pdf->setX(49.2);
                        $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // fim almoco
                        $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA EXTRA SAIDA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA POSITIVA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA NEGATIVA
                        $pdf->Cell(79,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //observacao>SetFont('Arial', 'B', 8);
                    }

                    $pdf->setX(7);
                    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Qua"), 0, 0, "L", 0);
                    $pdf->SetFont('Arial', 'B', 8);
                    break;
                case 4:
                    if ($quintaEscala == 0) { //Seg-Sex
                        $pdf->setX(16);
                        $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //entrada
                        $pdf->setX(32.2);
                        $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // inicio almoco
                        $pdf->setX(49.2);
                        $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // fim almoco
                        $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA EXTRA SAIDA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA POSITIVA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA NEGATIVA
                        $pdf->Cell(79,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //observacao
                    }

                    $pdf->setX(7);
                    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Qui"), 0, 0, "L", 0);
                    $pdf->SetFont('Arial', 'B', 8);
                    break;
                case 5:
                    if ($sextaEscala == 0) { //Seg-Sex
                        $pdf->setX(16);
                        $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //entrada
                        $pdf->setX(32.2);
                        $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // inicio almoco
                        $pdf->setX(49.2);
                        $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // fim almoco
                        $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA EXTRA SAIDA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA POSITIVA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA NEGATIVA
                        $pdf->Cell(79,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //observacao
                    }

                    $pdf->setX(7);
                    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Sex"), 0, 0, "L", 0);
                    $pdf->SetFont('Arial', 'B', 8);
                    break;

                    /////////////SABADO\\\\\\\\\\\\\\\
                case 6:
                    $pdf->setX(16);
                    $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //entrada
                    $pdf->setX(32.2);
                    $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // inicio almoco
                    $pdf->setX(49.2);
                    $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // fim almoco
                    $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA EXTRA SAIDA
                    $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA POSITIVA
                    $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA NEGATIVA
                    $pdf->Cell(79,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //observacao

                    $pdf->setX(7);
                    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Sáb"), 0, 0, "L", 0);
                    $pdf->SetFont('Arial', 'B', 8);
                    break;

                    /////////////DOMINGO\\\\\\\\\\\\\\\\\
                case 7:
                    if ($domingoEscala == 0) { //Seg-Sex
                        $pdf->setX(16);
                        $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //entrada
                        $pdf->setX(32.2);
                        $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // inicio almoco
                        $pdf->setX(49.2);
                        $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // fim almoco
                        $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA EXTRA SAIDA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA POSITIVA
                        $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1); // HORA NEGATIVA
                        $pdf->Cell(79,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1); //observacao
                    }

                    $pdf->setX(7);
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(9, 7, iconv('UTF-8', 'windows-1252', " - Dom"), 0, 0, "L", 0); //DOMINGO
                    break;
                default:
            }


            //CINZA

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->setX(14);

            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', $entrada), 0, 0, "C", 0); // hora entrada
            $pdf->SetTextColor(0, 0, 0);
            $pdf->setX(32.2);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', $almocoInicio), 0, 0, "C", 0); // inicio almoco
            $pdf->setX(49.2);
            $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', $almocoFim), 0, 0, "C", 0); // fim almoco

            $pdf->Cell(19.7,  6.4, iconv('UTF-8', 'windows-1252', $saida), 0, 0, "C", 0); // HORA EXTRA SAIDA
            if ($entrada != "-") {
                if ($horaPositivaDia != "") {
                    $pdf->SetTextColor(0, 0, 205);
                }
            }
            $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', $registro['horasPositivasDia']), 0, 0, "C", 0); // HORA POSITIVA
            $pdf->SetTextColor(0, 0, 0);
            if ($entrada != "-") {
                if ($horaNegativaDia != "") {
                    $pdf->SetTextColor(255, 0, 0);
                }
            }
            $pdf->Cell(19.55, 6.61, iconv('UTF-8', 'windows-1252', $registro['horasNegativasDia']), 0, 0, "C", 0); // HORA NEGATIVA
            $pdf->SetTextColor(0, 0, 0);
            $pdf->setX(127);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(75,  6.61, iconv('UTF-8', 'windows-1252', $registro['descricaoLancamento']), 0, 0, "L", 0); //Observacao
            $pdf->setX(169.35);
            if ($resultAtrasoAbonado) {
                $pdf->Cell(55, 6.61, iconv('UTF-8', 'windows-1252', "X"), 0, 0, "C", 0);
            }
            $pdf->SetFont('Arial', 'B', 8);

            $linhavertical += 6.9;
            $linhahorizontalteste += 6.9;
            $linhaverticalteste += 6.9;

            $repetiu += 1;
        }
    }
}

$y = $pdf->GetY();
$pdf->Line(5, $y, 205, $y);

$pdf->SetFillColor(220, 220, 220); //CINZA TITULO
$pdf->setY($linhaverticalteste - 6.4);
$pdf->setX(5);
$pdf->Cell(200, 6.5, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
$pdf->setX(50);
$pdf->Cell(200, 6.5, iconv('UTF-8', 'windows-1252', "RESUMO"), 0, 0, "L", 0);

$pdf->SetFillColor(238, 238, 238); //CINZA
$pdf->Line(49, $linhaverticalteste, 49, $linhaverticalteste + 14); //Linha lado esquerdo de horas negativas


// $pdf->SetFillColor(0, 0, 0);

if ($totalHorasPositivasMes != "00:00:00") {
    $pdf->SetFillColor(152, 251, 152);
}

$pdf->setY($linhaverticalteste);
$pdf->setX(5);
$pdf->Cell(43.9, 7, iconv('UTF-8', 'windows-1252', "HORAS POSITIVAS: $totalHorasPositivasMes"), 0, 0, "L", 1);

$pdf->SetFillColor(255, 255, 255);

if ($totalHorasNegativasMes != "00:00:00") {
    $pdf->SetFillColor(255, 160, 122);
}
$pdf->setY($linhaverticalteste);
$pdf->setX(49.22);
$pdf->Cell(76.5, 7, iconv('UTF-8', 'windows-1252', "HORAS NEGATIVAS: $totalHorasNegativasMes"), 0, 0, "L", 1);

$pdf->SetFillColor(255, 255, 255);

if ($saldoBancoMensal == "::") {
    $saldoBancoMensal = "00:00:00";
}
$bancoNegativoSim = 0;

if ($saldoBancoMensal != "00:00:00") {
    $hhBancoMensalPartido = explode("-", $saldoBancoMensal);
    $bancoNegativoSim = count($hhBancoMensalPartido);
    if ($bancoNegativoSim > 1) {
        $pdf->SetFillColor(255, 160, 122);
    } else {
        $pdf->SetFillColor(152, 251, 152);
    }
}



$pdf->setY($linhaverticalteste + 7);
$pdf->setX(5);
$pdf->Cell(43.9, 7, iconv('UTF-8', 'windows-1252', "SALDO MENSAL: $saldoBancoMensal"), 0, 0, "L", 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->setY($linhaverticalteste - 5);
$pdf->setX(155);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "ASSINATURAS"), 0, 0, "L", 0);

$pdf->setY($linhaverticalteste + 2);
$pdf->setX(126);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "SUPERVISOR"), 0, 0, "L", 0);

$pdf->setY($linhaverticalteste + 11);
$pdf->setX(126);
$pdf->Cell(0, 0, iconv('UTF-8', 'windows-1252', "FUNCIONARIO"), 0, 0, "L", 0);



$i = 0;

while ($i != 3) {
    $pdf->Line(5, $linhahorizontalteste, 205, $linhahorizontalteste); //Linha fim documento
    $pdf->Line(5, $linhaverticalteste, 5, 17); //Linha lado esquerdo documento
    $pdf->Line(205, $linhaverticalteste, 205, 17); // Linha lado direito documento
    $pdf->Line(126, $linhaverticalteste, 126, 33); //Linha lado esquerdo de assinaturas

    $i++;
    $linhahorizontalteste += 7;
    $linhaverticalteste += 7;
}

$pdf->Ln(8);
$pdf->Output();
