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
        $this->SetXY(190, 5);
        $this->SetFont('Arial', 'B', 8); #Seta a Fonte
        $this->Cell(20, 5, 'Pagina ' . $this->pageno()); #Imprime o Número das Páginas

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

$tamanhoFonte = 10;
$tamanhoFonteMenor = 6;
$tipoDeFonte = 'Courier';
$fontWeight = 'B';


$pdf->Line(5, 5, 205, 5); //primeira linha
$pdf->Line(5, 10, 205, 10);

$pdf->setY(9);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'RELATÓRIO DE FUNCIONÁRIOS'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 20);

$pdf->setY(20);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(10);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'NOME'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(20);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(65);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DATA DE NASCIMENTO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(20);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(100);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'CPF',), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(20);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(125);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'ATIVO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(20);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(150);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'GÊNERO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);



// $sql = "SELECT nome, dataNascimento,ativo, cpf, genero FROM dbo.funcionario  WHERE (0=0)";

// $reposit = new reposit();
// $resultQuery = $reposit->RunQuery($sql);
// $i = 22;        

// foreach ($resultQuery as $row) {
//     $nome = $row['nome'];
//     $dataNascimento = $row['dataNascimento'];    
//     $dataNascimento = explode(" ", $dataNascimento);
//     $dataNascimento = explode("-", $dataNascimento[0]);
//     $dataNascimento =  $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];
//     $ativo = +$row['ativo'];
//     if($ativo == 1 ){
//         $ativo = 'Sim';
//     }else{
//         $ativo = 'Não';
//     }

//     $cpf = $row['cpf'];
//     $genero = $row['genero'];    


//     $i += 5;

//     $pdf->setY($i);
//     $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
//     $pdf->setX(10);
//     $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0);
//     $pdf->SetFont($tipoDeFonte, '', 8);

//     $pdf->setY($i);
//     $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
//     $pdf->setX(62);
//     $pdf->multiCell(20, -1, iconv('UTF-8', 'windows-1252', $dataNascimento ), 0, 0, "C", 0);
//     $pdf->SetFont($tipoDeFonte, '', 8);

//     $pdf->setY($i);
//     $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
//     $pdf->setX(100);
//     $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "C", 0);
//     $pdf->SetFont($tipoDeFonte, '', 8);

//     $pdf->setY($i);
//     $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
//     $pdf->setX(125);
//     $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $ativo), 0, 0, "C", 0);
//     $pdf->SetFont($tipoDeFonte, '', 8);           


// }





$pdf->Ln(8);
$pdf->Output();
