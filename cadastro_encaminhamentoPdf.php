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

$pdf->Image('img\logoNTL.jpg',167,3,-75);

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
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Clínica Ambimed:"), 0, 0, "L", 0);

//RUA CLINICA
$pdf->setY(123);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Av. Presidente Vargas, 482, sala 512."), 0, 0, "L", 0);

//TELEFONE CLINICA
$pdf->setY(129);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "2233-8873/ 3905-9031."), 0, 0, "L", 0);

//AVISO CLINICA
$pdf->setY(135);
$pdf->SetFont('Arial', 'B', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Durante a Pandemia: 2º à 6º feira:8:00 às 12:00h"), 0, 0, "L", 0);

$pdf->setY(135);
$pdf->SetFont('Arial', 'B', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "_________________________________________"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 14);
$pdf->setY(141);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "2º à 5º feira: 8:00 às 16:00h"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 14);
$pdf->setY(147);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "6º feira:08:00 às 11:00h"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 14);
$pdf->setY(153);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Sra. Daiana"), 0, 0, "L", 0);
// FIM AVISO CLINICA


//OBSERVAÇÕES
$pdf->setY(168);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Observações:"), 0, 0, "L", 0);


//PRIMEIRA OBSERVAÇÃO
$pdf->setY(180);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "•  Obrigatório a apresentação de documento de identificação com foto;"), 0, 0, "L", 0);


//SEGUNDA OBSERVAÇÃO
$pdf->setY(186);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "•  Atendimento por ordem de chegada;"), 0, 0, "L", 0);


//TERCEIRA OBSERVAÇÃO
$pdf->setY(192);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(28);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "•  Uso obrigatório de máscara durante a pandemia do Covid-19."), 0, 0, "L", 0);


// FOOTER NTL
$pdf->setY(220);
$pdf->SetFont('Arial', '', 14);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "NTL NOVA TECNOLOGIA LTDA"), 0, 0, "L", 0);
$pdf->setY(226);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "32.185.480/0001-07"), 0, 0, "L", 0);

$pdf->setY(232);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rua Visconde de Inhaúma, 38, 701, Centro, RJ - CEP:20091-007"), 0, 0, "L", 0);

$pdf->setY(238);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "3523-7300"), 0, 0, "L", 0);

$pdf->Line(19, 260, 192, 260); //primeira linha

$pdf->setY(260);
$pdf->SetFont('Arial', '', 8);
$pdf->setX(19);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "RJ: R.Visconde de Inháuma,38,7º andar - Centro - Tel.:(21)3523-7300 / 2233-6226 / 3177-3395"), 0, 0, "L", 0);

$pdf->Output();
