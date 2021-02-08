<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');

if ((empty($_GET["id"])) || (!isset($_GET["id"])) || (is_null($_GET["id"]))) {
    $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
    echo "failed#" . $mensagem . ' ';
    return;
} else {
    $id = +$_GET["id"];
}

$sql = "SELECT codigo,ativo,nomeCompleto,cpf 
FROM ntl.funcionario WHERE (0=0) AND codigo =" . $id;

$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";
$row = $result[0];
if ($row) {
    
    $codigo = $row['codigo'];
    $ativo = $row['ativo'];
    $nomeCompleto = $row['nomeCompleto'];
    $cpf = $row['cpf'];

    
}


require_once('fpdf/fpdf.php');

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
$pdf->SetMargins(5, 5, 5); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->AddPage();

//$pdf->SetFont('Arial','',10);
//$pdf->SetLeftMargin(10);

$pdf->SetFont('Times', 'B', 12);
$pdf->setY(10);
$pdf->Cell(193, 5, iconv('UTF-8', 'windows-1252', "FOLHA DE PONTO INDIVIDUAL DE TRABALHO"), 0, 0, "C", 0);
$pdf->Ln(10);
// $pdf->Line(5, 20, 205, 20); #Linha na Horizontal
$pdf->setY(17);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "NTL Nova Tecnologia Ltda"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);
$pdf->Line(5, 21, 205, 21);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Expediente: 08:00H AS 17:00H"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);
$pdf->Line(5, 25, 205, 25);

$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CPF:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);
$pdf->Line(5, 29, 205, 29);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(57);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Cliente:NTL"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);



$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(57);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Nome:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);
$pdf->Line(100, 25, 100, 17);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(100);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Mês:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);
$pdf->Line(160, 25, 160, 21);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(160);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Ano:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);


// DIAS // 

$pdf->Line(5, 47, 14, 47);
$pdf->Line(14, 47, 14, 41);
$pdf->Cell(5, 18, iconv('UTF-8', 'windows-1252', "1"), 0, 0, "L", 0);

$pdf->Line(5, 53, 14, 53);
$pdf->Line(14, 53, 14, 41);


$pdf->Line(5, 59, 14, 59);
$pdf->Line(14, 59, 14, 41);


$pdf->Line(5, 65, 14, 65);
$pdf->Line(14, 65, 14, 41);


$pdf->Line(5, 71, 14, 71);
$pdf->Line(14, 71, 14, 41);


$pdf->Line(5, 77, 14, 77);
$pdf->Line(14, 77, 14, 41);

$pdf->Line(5, 83, 14, 83);
$pdf->Line(14, 83, 14, 41);

$pdf->Line(5, 89, 14, 89);
$pdf->Line(14, 89, 14, 41);

$pdf->Line(5, 96, 14, 96);
$pdf->Line(14, 96, 14, 41);

$pdf->Line(5, 102, 14, 102);
$pdf->Line(14, 102, 14, 41);

$pdf->Line(5, 108, 14, 108);
$pdf->Line(14, 108, 14, 41);

$pdf->Line(5, 114, 14, 114);
$pdf->Line(14, 114, 14, 41);


$pdf->Line(5, 120, 14, 120);
$pdf->Line(14, 120, 14, 41);


$pdf->Line(5, 126, 14, 126);
$pdf->Line(14, 126, 14, 41);


$pdf->Line(5, 132, 14, 132);
$pdf->Line(14, 132, 14, 41);


$pdf->Line(5, 138, 14, 138);
$pdf->Line(14, 138, 14, 41);

$pdf->Line(5, 144, 14, 144);
$pdf->Line(14, 144, 14, 41);

$pdf->Line(5, 150, 14, 150);
$pdf->Line(14, 150, 14, 41);

$pdf->Line(5, 156, 14, 156);
$pdf->Line(14, 156, 14, 41);

$pdf->Line(5, 162, 14, 162);
$pdf->Line(14, 162, 14, 41);


$pdf->Line(5, 168, 14, 168);
$pdf->Line(14, 168, 14, 41);


// CÉLULAS // 
$pdf->Line(5, 41, 205, 41);
$pdf->Line(14, 47, 205, 47);
$pdf->Line(5, 53, 205, 53);
$pdf->Line(5, 59, 205, 59);
$pdf->Line(5, 65, 205, 65);
$pdf->Line(5, 71, 205, 71);
$pdf->Line(5, 77, 205, 77);
$pdf->Line(5, 83, 205, 83);
$pdf->Line(5, 89, 205, 89);
$pdf->Line(5, 96, 205, 96);
$pdf->Line(5, 102, 205, 102);


$pdf->Line(5, 108, 205, 108);
$pdf->Line(14, 114, 205, 114);
$pdf->Line(5, 120, 205, 120);
$pdf->Line(5, 126, 205, 126);
$pdf->Line(5, 132, 205, 132);
$pdf->Line(5, 138, 205, 138);
$pdf->Line(5, 144, 205, 144);
$pdf->Line(5, 150, 205, 150);
$pdf->Line(5, 156, 205, 156);
$pdf->Line(5, 162, 205, 162);
$pdf->Line(5, 168, 205, 168);





// VERTICAL//
$pdf->Line(5, 1000, 5, 17);
$pdf->Line(205, 1000, 205, 17);
$pdf->Line(56, 1000, 56, 17);
$pdf->Line(160, 1000, 160, 29);
$pdf->Line(100, 1000, 100, 25);


$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(17);
$pdf->setX(57);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CNPJ: 32185480/0001-07"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
// $pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252',  .  "."), 0, 0, "L", 0);
// $pdf->SetFont('Arial', 'B', 8);

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(17);
$pdf->setX(100);
$pdf->Line(100, 21, 100, 17);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rua:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $rua .  "."), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);

// $pdf->setY(17);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Line(5, 17, 205, 17);
// $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Nome :"), 0, 0, "L", 0);
// $pdf->SetFont('Arial', '', 8);
// $pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);
// $pdf->Line(5, 21, 205, 21);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Ln(5);

$pdf->SetFont('Arial', '', 8);
$contador = 0;
foreach ($arrayTransporte as $key) {

    $contador = $contador + 1;
    $sequencialTransporte = $key["sequencialTransporte"];
    $trajetoTransporte = $key["trajetoTransporte"];

    $tipoTransporte = $key["tipoTransporte"];
    $tipoTransporte = iconv('UTF-8', 'windows-1252', $tipoTransporte);

    $linhaTransporte = $key["linhaTransporte"];
    $linhaTransporte = iconv('UTF-8', 'windows-1252', $linhaTransporte);
    $valorTransporte = $key["valorTransporte"];
    $valorTransporte = iconv('UTF-8', 'windows-1252', $valorTransporte);

    $pdf->SetX(35);
    $pdf->SetWidths(array(30, 35, 40, 30, 50, 33, 10, 20, 20, 20, 20, 20, 30));
    $pdf->Row(array($trajetoTransporte, $tipoTransporte, $linhaTransporte, $valorTransporte));
}
$pdf->Ln(8);


// $pdf->Ln(8);
// $pdf->SetFont('Arial', 'B', 10);

// $pdf->Cell(193, 5, iconv('UTF-8', 'windows-1252', "DECLARAÇÃO"), 0, 0, "C", 0);

// $linha = $pdf->Ultimalinha();
// $pdf->Ln(6);


// $pdf->Line(5, $linha + 2, 205, $linha + 2); #Linha na Horizontal
// $pdf->SetFont('Arial', 'B', 7);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Multicell(0, 3, iconv('UTF-8', 'windows-1252', "Comprometo-me a utilizar o VALE TRANSPORTE unicamente para o deslocamento Residência / Trabalho / Residência,
// bem como a manter atualizadas as informações acima prestadas."), 0, 'J');
// $pdf->Ln(3);
// $pdf->Multicell(0, 3, iconv('UTF-8', 'windows-1252', "Declaro ainda, que as informações supra, são a expressão da verdade, ciente de que o erro nas mesmas ou o uso indevido do Vale Transporte,
// constituirá falta grave, ensejando punição, nos Termos da Legislação específica."), 0, 'J');
// $pdf->Ln(8);
// $pdf->Line(5, $linha + 25, 205, $linha + 25); #Linha na Horizontal
// $pdf->Ln(8);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(100, 5, iconv('UTF-8', 'windows-1252', "Local:_________________________________________________"), 0, 0, "L", 0);
// // $pdf->SetFont('Arial', '', 8);
// // $pdf->Cell(70, 5, iconv('UTF-8', 'windows-1252', $bairro), 0, 0, "L", 0);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(12, 5, iconv('UTF-8', 'windows-1252', "Data :_______________________________"), 0, 0, "L", 0);
// $pdf->SetFont('Arial', '', 8);
// $pdf->Ln(8);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(16, 5, iconv('UTF-8', 'windows-1252', "Nome Completo / Assinatura:___________________________________________________________________________"), 0, 0, "L", 0);
// $pdf->Ln(8);

// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', "Carteira de Trabalho:________________"), 0, 0, "L", 0);
// $pdf->Cell(2, 5, iconv('UTF-8', 'windows-1252', $pis), 0, 0, "L", 0);
// $pdf->Ln(8);


// $pdf->SetFillColor(234, 234, 234);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Ln();


// $pdf->Ln();

// $pdf->SetFont('Arial', '', 8);
// $contador = 0;


$pdf->Ln(8);

$pdf->Output();
