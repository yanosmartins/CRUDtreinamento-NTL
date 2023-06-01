<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');
// $codigoLogin = $_SESSION['codigo'];

// if ((empty($_GET["id"])) || (!isset($_GET["id"])) || (is_null($_GET[""]))) {
//     $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
//     echo "failed#" . $mensagem . ' ';
//     return;
// }

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        global $codigo;
        $sqlLogo = "SELECT nome  FROM dbo.funcionario";
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
            $y2 = 10;
            if (($x1 / $x2) < ($y1 / $y2)) {
                $y2 = 5;
            } else {
                $x2 = 5;
            }
            $this->Cell(116, 1, "", 0, 1, 'C', $this->Image($img, $x2, $y2, 0, 15));
        }
        $sqlMarca = "SELECT parametroMarca 
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
            $this->Image($img1, $x4, $y4, 105, 105);
        }
        //        if ($nomeLogoRelatorio != "")
        //        $this->SetFont('Arial', '', 8); #Seta a Fonte
        //        $dataAux = new DateTime();
        //        $dataAux->setTimezone(new DateTimeZone("GMT-3"));
        //        $dataAtualizada = $dataAux->format('d/m/Y H:i:s');
        //        $this->Cell(288, 0, $dataAtualizada, 0, 0, 'R', 0); #Título do Relatório
        // $this->Cell(116, 1, "", 0, 1, 'C', 0); #Título do Relatório
        // $this->Image($img, 7, 5, 13, 13); #logo da empresa
        $this->SetXY(190, 0);
        $this->SetFont('Arial', 'B', 8); #Seta a Fonte

        $this->Cell(20, 7.5, 'Pagina ' . $this->pageno()); #Imprime o Número das Páginas

        $this->Ln(24); #Quebra de Linhas

        $this->SetTextColor(255, 192, 203);
        $this->Image('C:\inetpub\wwwroot\Cadastro\img\marcaDagua.png', 35, 65, 135, 165, 'PNG');
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

$tamanhoFonteMaior = 16;
$tamanhoFonte = 10;
$tamanhoFonteMenor = 8;
$tipoDeFonte = 'Courier';
$fontWeight = 'B';





$pdf->setY(9);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonteMaior);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'FOLHA DE PONTO INDIVIDUAL DO FUNCIONÁRIO'), 0, 0, "C", 0);

$pdf->Line(5, 16, 205, 16); //menor



$pdf->Line(5, 5, 205, 5); //horizontal 1
$pdf->Line(5, 12, 205, 12); //horizontal abaixo
$pdf->Line(5, 5, 5, 290); //vertical 1
$pdf->Line(205, 5, 205, 290); //vertical 2
$pdf->Line(5, 290, 205, 290); //horizontal 2
$pdf->Line(5, 5, 205, 5); //horizontal 1
$pdf->Line(5, 12, 205, 12); //horizontal abaixo
$pdf->Line(5, 5, 5, 290); //vertical 1
$pdf->Line(205, 5, 205, 290); //vertical 2
$pdf->Line(5, 290, 205, 290); //horizontal 2
$pdf->Line(5, 5, 205, 5); //horizontal 1
$pdf->Line(5, 12, 205, 12); //horizontal abaixo
$pdf->Line(5, 5, 5, 290); //vertical 1
$pdf->Line(205, 5, 205, 290); //vertical 2
$pdf->Line(5, 290, 205, 290); //horizontal 2

// $pdf->Ln(5);
// $pdf->SetFont('Arial', 'I', 12);
// $pdf->SetTextColor(128);
// $pdf->MultiCell(0, 4, 'This is my disclaimer. THESE WORDS NEED TO BE BOLD. These words do not need to be bold.', 1, 'C');

$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);



$pdf->Ln(8);
$pdf->Output();
