<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');
$usuario = $_SESSION['login'];
if ((empty($_GET["id"])) || (!isset($_GET["id"])) || (is_null($_GET["id"]))) {
    $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
    echo "failed#" . $mensagem . ' ';
    return;
} else {
    $id = +$_GET["id"];
}

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once('fpdf/fpdf.php');

$tipoExame = $_GET["tipoExame"];
$dataAgendamento = $_GET["dataAgendamento"];


$dataAgendamento = explode("/", $dataAgendamento);
$dataAgendamentoTeste = $dataAgendamento[2] . "/" . $dataAgendamento[1] . "/" . $dataAgendamento[0];
$diaAgendamento = $dataAgendamento[0];
$mesAgendamento = $dataAgendamento[1];
$anoAgendamento = $dataAgendamento[2];

$mesExtenso = ucfirst(mb_convert_encoding(strftime('%B', strtotime("$anoAgendamento-$mesAgendamento")), 'UTF-8', 'HTML-ENTITIES'));

if ($tipoExame == 1 ) {
    $tipoExame = 'ADMISSIONAL';
}

if ($tipoExame == 2 ) {
    $tipoExame = 'PERIÓDICO';
}

if ($tipoExame == 3 ) {
    $tipoExame = 'MUDANÇA DE RISCO OCUPACIONAL';
}

if ($tipoExame == 4 ) {
    $tipoExame = 'RETORNO AO TRABALHO';
}



$reposit = new reposit();

$sql = "SELECT F.nome,C.descricao FROM ntl.funcionario F INNER JOIN
ntl.cargo C ON F.cargo = C.codigo WHERE F.codigo =" . $id;

$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";
$row = $result[0];
if ($row) {

    $nome = $row['nome'];
    $cargo = $row['descricao'];
}

class PDF extends FPDF
{

    function Header()
    {
        global $codigo;

        //        if ($nomeLogoRelatorio != "")
        //        $this->SetFont('Arial', '', 8); #Seta a Fonte
        //        $dataAux = new DateTime();
        //        $dataAux->setTimezone(new DateTimeZone("GMT-3"));
        //        $dataAtualizada = $dataAux->format('d/m/Y H:i:s');
        //        $this->Cell(288, 0, $dataAtualizada, 0, 0, 'R', 0); #Título do Relatório
        $this->Cell(116, 1, "", 0, 1, 'C', 0); #Título do Relatório
        $this->SetXY(190, 5);
        $this->SetFont('Arial', 'B', 8); #Seta a Fonte

        $this->Ln(11); #Quebra de Linhas
        $this->Ln(8);
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

$pdf->Line(19, 22 , 192, 22  ); //primeira linha

// RJ DATA DE HOJE
$pdf->setY(25);
$pdf->SetFont('Arial', '', 13);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rio de Janeiro, $diaAgendamento de $mesExtenso de $anoAgendamento."), 0, 0, "L", 0);

//TEXTO SOLICITACAO
$pdf->setY(48.5);
$pdf->SetFont('Arial', 'B', 15);
$pdf->setX(24);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "SOLICITAÇÃO DE ATESTADO DE SAÚDE OCUPACIONAL (ASO)"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

//NOME FUNCIONARIO
$pdf->setY(65.8);
$pdf->SetFont('Arial', 'B', 14.5);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "FUNCIONÁRIO:$nome"), 0, 0, "L", 0);

//TIPO EXAME FUNCIONARIO
$pdf->setY(78);
$pdf->SetFont('Arial', 'B', 14.5);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "TIPO:"), 0, 0, "L", 0);
$pdf->setY(78);
$pdf->SetFont('Arial', '', 14.5);
$pdf->setX(33);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', " $tipoExame"), 0, 0, "L", 0);

//CARGO FUNCIONARIO
$pdf->setY(90.2);
$pdf->SetFont('Arial', 'B', 14.5);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CARGO: $cargo"), 0, 0, "L", 0);

//QUADRADO
$pdf->Line(19, 100, 192, 100); //CIMA
$pdf->Line(19, 100, 19, 161); // LATERAL ESQUERDA
$pdf->Line(19, 161, 192, 161); // BAIXO
$pdf->Line(192, 100, 192, 161); // LATERAL DIREITA

//CLINICA
$pdf->setY(106);
$pdf->SetFont('Arial', 'B', 14);
$pdf->setX(99);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CLÍNICA"), 0, 0, "L", 0);

//NOME CLINICA
$pdf->setY(117);
$pdf->SetFont('Arial', 'B', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "( X ) Clínica Italab:"), 0, 0, "L", 0);

//RUA CLINICA
$pdf->setY(123);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rua Rita Batista, 2-28 - Campo Lindo, Seropédica."), 0, 0, "L", 0);

//TELEFONE CLINICA
$pdf->setY(129);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "3905-9031."), 0, 0, "L", 0);

//AVISO CLINICA
$pdf->setY(135);
$pdf->SetFont('Arial', 'B', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "3º e 5º feira: 7:30 ás 11:30h"), 0, 0, "L", 0);

// FIM AVISO CLINICA

// FOOTER NTL
$pdf->setY(205);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "NTL NOVA TECNOLOGIA LTDA"), 0, 0, "L", 0);
$pdf->setY(211);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "32.185.480/0001-07"), 0, 0, "L", 0);

$pdf->setY(217);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rua Visconde de Inhaúma, 38, 701, Centro, RJ - CEP:20091-007"), 0, 0, "L", 0);

$pdf->setY(223);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "3523-7300"), 0, 0, "L", 0);

$pdf->Line(19, 260, 192, 260); //primeira linha

$pdf->setY(260);
$pdf->SetFont('Arial', '', 8);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "RJ: R.Visconde de Inháuma,38,7º andar - Centro - Tel.:(21)3523-7300 / 2233-6226 / 3177-3395"), 0, 0, "L", 0);

$pdf->Output();
