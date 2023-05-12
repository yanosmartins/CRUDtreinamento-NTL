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
        $this->SetXY(190, 5);
        $this->SetFont('Arial', 'B', 8); #Seta a Fonte
        $this->Cell(20, 7.5, 'Pagina ' . $this->pageno()); #Imprime o Número das Páginas

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
$tamanhoFonteMenor = 8;
$tipoDeFonte = 'Courier';
$fontWeight = 'B';





$pdf->setY(9);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'RELATÓRIO INDIVIDUAL DO FUNCIONÁRIO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 20);



$pdf->setY(16);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DADOS DO FUNCIONÁRIO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 20);

$pdf->Line(25, 19, 185, 19); //menor
$pdf->Line(25, 19, 185, 19); //menor
$pdf->Line(25, 19, 185, 19); //menor

$pdf->setY(60);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DADOS DE CONTATO'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 20);

$pdf->Line(25, 63, 185, 63); //menor
$pdf->Line(25, 63, 185, 63); //menor
$pdf->Line(25, 63, 185, 63); //menor



$pdf->Line(5, 5, 205, 5); //horizontal 1
$pdf->Line(5, 12, 205, 12); //horizontal abaixo
$pdf->Line(5, 5, 5, 290); //vertical 1
$pdf->Line(205, 5, 205, 290); //vertical 2
$pdf->Line(5, 290, 205, 290); //horizontal 2



$pdf->setY(28);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(5);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'NOME:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(28);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(70);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'CPF:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(28);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(139);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DATA DE NASCIMENTO.:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(35);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(12.55);
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'EST. CIVIL.:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(35);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(73);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'GÊNERO:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(35);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(154);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'ATIVO:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(42);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(6);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'RG:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);

$pdf->setY(42);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(76);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'PRIMEIRO EMPREGO:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);



$pdf->setY(42);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(144);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'PIS/PASEP:'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 8);


$id = $_GET["id"];

$sql = " SELECT FU.codigo, FU.ativo, FU.cpf, FU.rg, FU.dataNascimento, FU.estadoCivil, FU.nome, FU.cep, FU.primeiroEmprego, FU.pisPasep, GF.descricao as genero 
                from dbo.funcionario FU 
                LEFT JOIN dbo.generoFuncionario GF on GF.codigo = FU.genero WHERE FU.codigo = " . $id;

$sql = $sql . $where;
$reposit = new reposit();
$resultQuery = $reposit->RunQuery($sql);
$i = 22;
$margem = 5;

foreach ($resultQuery as $row) {

    $nome = $row['nome'];
    $cpf = $row['cpf'];
    $rg = $row['rg'];
    $dataNascimento = $row['dataNascimento'];
    $dataNascimento = explode(" ", $dataNascimento);
    $dataNascimento = explode("-", $dataNascimento[0]);
    $dataNascimento =  $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];
    $genero = $row['genero'];
    $pispasep = $row['pisPasep'];
    $primeiroEmprego = $row['primeiroEmprego'];
    $estadoCivil = (int)$row['estadoCivil'];
    $cep = $row['cep'];

    $valor_de_retorno = match ($estadoCivil) {
        1 => 'Solteiro',
        2 => 'Casado',
        3 => 'Separado',
        4 => 'Divorciado',
        5 => 'Viúvo'
    };
    $estadoCivil = $valor_de_retorno;
    $ativo = +$row['ativo'];

    if ($ativo == 1) {
        $ativo = 'Sim';
    } else {
        $ativo = 'Não';
    }
    $primeiroEmprego = (int) $row['primeiroEmprego'];
    if ($primeiroEmpreg == 1) {
        $primeiroEmprego = "Sim";
    } else {
        $primeiroEmprego = "Não";
    }
    if ($pispasep == "") {
        $pispasep = "Nenhum";
    }

    $i += 5;


    $pdf->setY(28);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(20 + $margem);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(28);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(80 + $margem);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(28);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(170 + $margem);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $dataNascimento), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(35);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(38);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $estadoCivil), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(35);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(92);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $genero), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(35);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(175);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $ativo), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(42);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(22);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $rg), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(42);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(106.5);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $primeiroEmprego), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);

    $pdf->setY(42);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(166);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $pispasep), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, '', 8);


    $pdf->Line(25, 50, 185, 50); //menor
    $pdf->Line(25, 50, 185, 50); //menor
    $pdf->Line(25, 50, 185, 50); //menor



    


    


    $pdf->SetFont($tipoDeFonte, '', 8);
    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setY(80);
    $pdf->setX(15);
    $pdf->SetFillColor(230, 0, 0);
    $pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', 'TELEFONE:'), 1, 0, "C", 1);
    $pdf->SetFillColor(255, 165, 0);

    $pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', 'PRINCIPAL:'), 1, 0, "C", 1);
    $pdf->SetFillColor(0,230,0);
    $pdf->Cell(23, 5, iconv('UTF-8', 'windows-1252', 'WHATSAPP:'), 1, 0, "C", 1);
    

    $pdf->SetFont($tipoDeFonte, '', 8);
    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setY(80);
    $pdf->setX(100);
    $pdf->SetFillColor(230, 0, 0);
    $pdf->Cell(68, 5, iconv('UTF-8', 'windows-1252', 'EMAIL:'), 1, 0, "C", 1);
    $pdf->SetFillColor(255, 165, 0);
    $pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', 'PRINCIPAL:'), 1, 0, "C", 1);
    






    // $pdf->SetFont('Arial', 'B', 14);
    // // Table with 20 rows and 4 columns
    // $pdf->SetWidths(array(10, 70, 30, 40, "C"));
    
    
    // for ($i = 0; $i < 6; $i++) {
    //     $pdf->MultiCell(20, 5, $ativo, 1, "C", false); //menor
    // }
}




$pdf->Ln(8);
$pdf->Output();
