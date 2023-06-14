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
$sql = " SELECT FU.codigo, FU.ativo, FU.cpf, FU.rg, FU.dataNascimento, FU.estadoCivil, FU.nome, FU.cep, FU.logradouro, FU.uf, FU.bairro, FU.cidade, FU.numero, FU.complemento, FU.primeiroEmprego, FU.pisPasep, G.descricao as genero 
                from dbo.funcionario FU 
                LEFT JOIN dbo.genero G on G.codigo = FU.genero";

$reposit = new reposit();
$resultQuery = $reposit->RunQuery($sql);

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

        $this->SetTextColor(255, 192, 203);
        $this->Image('C:\inetpub\wwwroot\Cadastro\img\marcaDagua.png', 35, 45, 135, 145, 'PNG');
        // $this->Image('C:\inetpub\wwwroot\Cadastro\img\logo.png', 80, 90, 80, 90, 'PNG');
        // $this->Image('C:\inetpub\wwwroot\Cadastro\img\logo.png', 10, 278, 35, 9, 'PNG');
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
$tamanhoFonteMenor = 9;
$tipoDeFonte = 'Courier';
$fontWeight = 'B';


$pdf->setY(9);
$pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
$pdf->setX(85);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'RELATÓRIO DE FUNCIONÁRIOS'), 0, 0, "C", 0);
$pdf->SetFont($tipoDeFonte, '', 20);


// $pdf->Line(25, 19, 185, 19); //menor
// $pdf->Line(25, 19, 185, 19); //menor
// $pdf->Line(25, 19, 185, 19); //menor

$pdf->Line(5, 5, 205, 5); //horizontal 1
$pdf->Line(5, 12, 205, 12); //horizontal abaixo
$pdf->Line(5, 5, 5, 290); //vertical 1
$pdf->Line(205, 5, 205, 290); //vertical 2
$pdf->Line(5, 290, 205, 290); //horizontal 2

// $pdf->Line(5, $i, 205, $i); //menor
// $pdf->Line(5, $i, 205, $i); //menor

$i = 15;


foreach ($resultQuery as $row) {

    if ($i > 240) {
        $pdf->AddPage();
        // $pdf->Line(5, 5, 205, 5); //horizontal 1
        $pdf->Line(5, 12, 205, 12); //horizontal abaixo
        // $pdf->Header();
        // $pdf->Footer();
        $i = 15;
    }

    $i = $i + 5;
    $contadorPrimeiro = 0;
    if ($contadorPrimeiro > 0) {
        $i = $i - 5;
    }

    $codigo = $row['codigo'];
    $nome = mb_strimwidth(trim($row['nome']), 0, 55, "...");
    $cpf = $row['cpf'];
    $rg = $row['rg'];
    $dataNascimento = $row['dataNascimento'];
    $dataNascimento = explode(" ", $dataNascimento);
    $dataNascimento = explode("-", $dataNascimento[0]);
    $dataNascimento =  $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];
    $genero = $row['genero'];
    $pispasep = $row['pisPasep'];
    $estadoCivil = (int)$row['estadoCivil'];
    $cep = $row['cep'];
    $ativo = +$row['ativo'];
    $logradouro = $row['logradouro'];
    $numero = $row['numero'];
    $bairro = mb_strimwidth($row['bairro'], 0, 20, "...");
    $uf = $row['uf'];


    $valor_de_retorno = match ($estadoCivil) {
        1 => 'Solteiro',
        2 => 'Casado',
        3 => 'Separado',
        4 => 'Divorciado',
        5 => 'Viúvo'
    };
    $estadoCivil = $valor_de_retorno;

    if ($ativo == 1) {
        $ativo = 'Sim';
    } else {
        $ativo = 'Não';
    }

    if ($pispasep == "") {
        $pispasep = "Nenhum";
    }

    $split_logradouro = explode(" ", trim($logradouro));
    if (count($split_logradouro) > 2) {
        for ($contador = 1; (count($split_logradouro) - 1) > $contador; $contador++) {
            if (strlen($split_logradouro[$contador]) > 2) {
                $split_logradouro[$contador] = substr($split_logradouro[$contador], 0, 1) . ".";
            }
        }
    }
    $split_logradouro = implode(" ", $split_logradouro);



    $endereco = $split_logradouro . ' - ' . $numero . ', ' . $uf . '.';


    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setY($i);
    $pdf->setX(12);
    $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'NOME:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(25);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0);

    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(154);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'ATIVO:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(170);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $ativo), 0, 0, "L", 0);

    $i = $i + 5;

    $pdf->setY($i);
    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(78);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'DATA DE NASC.:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(110);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $dataNascimento), 0, 0, "L", 0);

    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(12);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'CPF:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(24);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);

    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(154);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'GÊNERO:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(170);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $genero), 0, 0, "L", 0);

    $i = $i + 5;

    $pdf->setY($i);
    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(12);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'RG:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(22);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $rg), 0, 0, "L", 0);

    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(78);
    $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'ESTADO CIVIL:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(108);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $estadoCivil), 0, 0, "L", 0);

    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(154);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'PIS:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(165);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $pispasep), 0, 0, "L", 0);

    $i = $i + 5;
    

    $sqlTelefone = "SELECT telefone from dbo.telefoneFuncionario where principal = 1 and funcionarioId = " . $codigo;
    $reposit = new reposit();
    $resultQueryTelefone = $reposit->RunQuery($sqlTelefone);

    foreach ($resultQueryTelefone as $row) {
        $telefone = $row['telefone'];
        $pdf->setY($i);
        $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
        $pdf->setX(12);
        $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'TELEFONE:'), 0, 0, "L", 0);
        $pdf->setY($i);
        $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
        $pdf->setX(34);
        $pdf->Cell(118, -1, iconv('UTF-8', 'windows-1252', $telefone), 0, 0, "L", 0);
    }

  
    $sqlEmail = "SELECT email from dbo.emailFuncionario where principal = 1 and funcionarioId = " . $codigo;

    $reposit = new reposit();
    $resultQueryEmail = $reposit->RunQuery($sqlEmail);

    foreach ($resultQueryEmail as $row) {
        $email = $row['email'];
        $email = substr_replace($email, '****', 2, strpos($email, '@') - 4);

        $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
        $pdf->setX(78);
        $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'EMAIL:'), 0, 0, "L", 0);
        $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
        $pdf->setX(95);
        $pdf->Cell(118, -1, iconv('UTF-8', 'windows-1252', $email), 0, 0, "L", 0);
    }



    $sqlDependente = "SELECT count(nome) as contador from dbo.dependentesListaFuncionario  where funcionarioId = " . $codigo;
    $reposit = new reposit();
    $resultQueryDependente = $reposit->RunQuery($sqlDependente);

    foreach ($resultQueryDependente as $row) {
        $dependente = (int)$resultQueryDependente;
        $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
        $pdf->setX(154);
        $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'Nº DE DEPENDENTES:'), 0, 0, "L", 0);
        $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
        $pdf->setX(192 );
        $pdf->Cell(118, -1, iconv('UTF-8', 'windows-1252', $dependente), 0, 0, "L", 0);

    }

    $i = $i + 5;
    $pdf->setY($i);
    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(12);
    $pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', 'ENDEREÇO:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(34);
    $pdf->Cell(118, -1, iconv('UTF-8', 'windows-1252', $endereco), 0, 0, "L", 0);

    $pdf->SetFont($tipoDeFonte, $fontWeight, $tamanhoFonte);
    $pdf->setX(154);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', 'CEP:'), 0, 0, "L", 0);
    $pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
    $pdf->setX(165);
    $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $cep), 0, 0, "L", 0);

    $i = $i + 5;

    $pdf->Line(5, $i, 205, $i); //menor

    $contadorPrimeiro = $contadorPrimeiro + 1;
    $contadorPrimeiro = 0;
    if ($contadorPrimeiro > 0) {
        $i = $i - 5;
    }

    // }
}


$i = $i + 5;


$pdf->Ln(8);
$pdf->Output();
