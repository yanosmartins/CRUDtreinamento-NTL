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

$sql = "SELECT codigo,nome,cpf,logradouro
FROM ntl.funcionario WHERE (0=0) AND codigo =" . $id;

$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";
$row = $result[0];
if ($row) {

    $funcionario = $row['codigo'];
    $nome = $row['nome'];
    $cpf = $row['cpf'];
    $logradouro = $row['logradouro'];
}
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once('fpdf/fpdf.php');


$mesAno = $_GET["data"];
if ($mesAno != "") {
    $mesteste = explode("/", $mesAno);
    $mes = $mesteste[0];
    $ano = $mesteste[1];
    $mesExtenso = ucfirst( mb_convert_encoding(strftime('%B', strtotime("$ano-$mes")),'UTF-8', 'HTML-ENTITIES'));
    // $mes = date("m"); //02
    $days = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    // $ano = date("Y"); //2021
} else {
     $mes = date("m"); //02
     $ano = date("Y"); //2021
     $days = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
     
     $mesExtenso = ucfirst( mb_convert_encoding(strftime('%B', strtotime("today")),'UTF-8', 'HTML-ENTITIES'));
    
}
$reposit = new reposit();


// $feriados = array();
// $sql = "SELECT codigo,data,descricao,unidadeFederacao,municipio,tipoFeriado FROM ntl.feriado WHERE data BETWEEN DATEFROMPARTS($ano, $mes,01) AND DATEFROMPARTS($ano, $mes,$days) ORDER BY data";

// $result = $reposit->RunQuery($sql);

// foreach($result as $row){   
//     array_push($feriados,$row);
// }

$sql = "SELECT BP.codigo,BP.funcionario,BP.projeto,BP.horaEntrada,BP.horaSaida,BP.horaInicio,BP.horaFim,P.apelido,P.estado,P.cidade,P.municipioFerias
    FROM Ntl.beneficioProjeto BP
    LEFT JOIN Ntl.projeto P ON P.codigo = BP.projeto WHERE BP.funcionario = $funcionario AND BP.ativo = 1";
$result = $reposit->RunQuery($sql);
$row = $result[0];
if ($row) {
    $estado = "'" . $row['estado'] . "'";
    $municipioFerias = $row['municipioFerias'];
    $horaEntrada =$row['horaEntrada'];
    $horaSaida = $row['horaSaida'];
    $horaInicio = $row['horaInicio'];
    $horaFim = $row['horaFim'];
}

$dataInicio = "$ano/$mes/01";
$dataFim = "$ano/$mes/$days";

$sql2 = "SELECT F.codigo,F.descricao,F.tipoFeriado,F.municipio,M.descricao,F.unidadeFederacao,F.data,F.sabado,F.domingo 
FROM Ntl.feriado F 
LEFT JOIN Ntl.municipio M ON M.codigo = F.municipio
WHERE F.ativo = 1 AND data BETWEEN '$dataInicio' AND '$dataFim'
AND (F.tipoFeriado = 3 OR (F.tipoFeriado = 1 and (F.unidadeFederacao = $estado)) OR F.tipoFeriado = 2 and M.codigo = $municipioFerias) 
AND DATENAME(weekday,F.data) NOT IN ('Saturday', 'Sunday')";
$result2 = $reposit->RunQuery($sql2);
$row2 = $result2[0];
// if ($row2) {
//     $dataferiado = "'" . $row2['data'] . "'";
// }

$feriados = array();
foreach ($result2 as $row2) {
    array_push($feriados, $row2);
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
$pdf->SetMargins(0, 0, 0); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
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
$pdf->Line(5, 21, 205, 21);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Expediente: $horaEntrada ÀS $horaSaida"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->Line(5, 25, 205, 25);


$pdf->setY(17);
$pdf->setX(67);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CNPJ: 32185480/0001-07"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CPF:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->setX(13);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);
$pdf->Line(5, 29, 205, 29);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(67);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Cliente:NTL"), 0, 0, "L", 0);



$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(67);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Nome:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->setX(77);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0);
$pdf->Line(106, 25, 106, 17);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Line(5, 17, 205, 17);
$pdf->setX(106);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Mês:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Line(169, 25, 169, 21);
$pdf->setY(21);
$pdf->setX(113);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $mesExtenso), 0, 0, "L", 0);

$pdf->Line(5, 17, 205, 17);
$pdf->setX(170);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Ano:"), 0, 0, "L", 0);
$pdf->setX(177);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', $ano), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);



// DIAS // 

// $pdf->Line(5, 41, 14, 41);
// $pdf->Line(40, 41, 40, 41);
// $pdf->Cell(5, 18, iconv('UTF-8', 'windows-1252', "1"), 0, 0, "L", 0);

// $pdf->Line(5, 48, 14, 48);
// $pdf->Line(14, 48, 14, 41);


$pdf->setY(32);
$pdf->setX(5);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "DIAS"), 0, 0, "L", 0);

$pdf->setY(32);
$pdf->setX(16);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "ENTRADA"), 0, 0, "L", 0);

$pdf->setY(35);
$pdf->setX(35);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Saida"), 0, 0, "L", 0);

$pdf->setY(35);
$pdf->setX(51);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Retorno"), 0, 0, "L", 0);

$pdf->setY(30);
$pdf->setX(42);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "ALMOÇO"), 0, 0, "L", 0);


$pdf->setY(31);
$pdf->setX(71);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "SAIDA"), 0, 0, "L", 0);

$pdf->setY(30);
$pdf->setX(99);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "EXTRAS"), 0, 0, "L", 0);


$pdf->setY(35);
$pdf->setX(89);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Entrada"), 0, 0, "L", 0);

$pdf->setY(35);
$pdf->setX(111);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Saida"), 0, 0, "L", 0);

$pdf->setY(32);
$pdf->setX(136);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "OBSERVAÇÃO"), 0, 0, "L", 0);

$pdf->setY(32);
$pdf->setX(181);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "VISTO"), 0, 0, "L", 0);




$pdf->Line(5, 39, 205, 39);
$linhavertical = 41;
$linhahorizontalteste = 46;
$linhaverticalteste = 46;
$days = (int)$days;
for ($i = 1; $i <= $days; $i++) {
    $pdf->Line(5, $linhaverticalteste, 5, 17); // 0 
    $pdf->Line(32, $linhaverticalteste, 32, 29); // 1 
    $pdf->Line(49, $linhaverticalteste, 49, 35); // 2 
    $pdf->Line(67, $linhaverticalteste, 67, 17); // 3 
    $pdf->Line(86, $linhaverticalteste, 86, 29); // 4 
    $pdf->Line(106, $linhaverticalteste, 106, 35); // 5
    $pdf->Line(126, $linhaverticalteste, 126, 29); // 6
    $pdf->Line(169, $linhaverticalteste, 169, 29); // 7
    $pdf->Line(205, $linhaverticalteste, 205, 17); // 8 
    $pdf->Line(16, $linhaverticalteste, 16, 39); // 9 
    $pdf->Line(5, $linhahorizontalteste, 205, $linhahorizontalteste);
    $pdf->setY($linhavertical);
    $pdf->setX(5);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "$i"), 0, 0, "L", 0);
    $pdf->setX(14);
    $diadasemana = strftime('%u', strtotime("$ano-$mes-$i"));
    $diaferiado = "'$ano-$mes-$i 00:00:00.000'";

    if ($dataferiado == $diaferiado) {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->setX(15);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " FERIADO"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', 'B', 9);
    }

    // 2021 - 02 - 01 
    // 2021 - 02 - 16

    //"$ano-$mes-$i" = "2021-02-??"
    //diasdasemana = [janeiro,...]


    if ($diadasemana == 1) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->setX(7);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " - Seg"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', 'B', 8);
    }


    if ($diadasemana == 2) {
        $pdf->setX(7);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " - Ter"), 0, 0, "L", 0);
    }


    if ($diadasemana == 3) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->setX(7);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " - Qua"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', 'B', 7);
    }


    if ($diadasemana == 4) {
        $pdf->setX(7);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " - Qui"), 0, 0, "L", 0);
    }

    if ($diadasemana == 5) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->setX(7);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " - Sex"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', 'B', 7);
    }








    if ($diadasemana == 6) {
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->setX(7);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " - Sab"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', 'B', 7);
    }

    if ($diadasemana == 7) {
        $pdf->setX(7);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', " - Dom"), 0, 0, "L", 0);
    }
    if ($diadasemana != 6 && $diadasemana != 7) {
        foreach ($feriados as $feriado) {
            if (mb_ereg("-$mes-" . str_pad($i, 2, 0, STR_PAD_LEFT), $feriado["data"])) {
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->setX(16);
                $pdf->SetTextColor(90, 90, 90);
                $pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "FERIADO"), 0, 0, "L", 0);

                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetTextColor(0, 0, 0);
            }
        }
    }

    $linhavertical += 6.9;
    $linhahorizontalteste += 6.9;
    $linhaverticalteste += 6.9;
}

$pdf->setY($linhaverticalteste - 5);
$pdf->setX(95);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "ASSINATURA"), 0, 0, "L", 0);

$pdf->setY($linhaverticalteste + 2);
$pdf->setX(5);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "SUPERVISOR"), 0, 0, "L", 0);

$pdf->setY($linhaverticalteste + 11);
$pdf->setX(5);
$pdf->Cell(0, 0, iconv('UTF-8', 'windows-1252', "FUNCIONARIO"), 0, 0, "L", 0);


$pdf->Line(32, 35, 67, 35);
$pdf->Line(86, 35, 126, 35);


$i = 0;
while ($i != 3) {
    $pdf->Line(5, $linhahorizontalteste, 205, $linhahorizontalteste);
    $pdf->Line(5, $linhaverticalteste, 5, 17);
    $pdf->Line(205, $linhaverticalteste, 205, 17); // 8 
    // 6
    $i++;
    $linhahorizontalteste += 7;
    $linhaverticalteste += 7;
}

// VERTICAL -CABEÇALHO
$pdf->Line(5, 41, 5, 17); // 0 
$pdf->Line(32, 41, 32, 29); // 1 
$pdf->Line(49, 41, 49, 35); // 2 
$pdf->Line(67, 41, 67, 17); // 3 
$pdf->Line(86, 41, 86, 29); // 4 
$pdf->Line(106, 41, 106, 35); // 5
$pdf->Line(126, 41, 126, 29); // 6
$pdf->Line(169, 41, 169, 29); // 7
$pdf->Line(205, 41, 205, 17); // 8 
$pdf->Line(16, 39, 16, 29); // 9 

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(17);
$pdf->setX(106);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rua: Visconde de Inhaúma, 38 - 701 - Centro - RJ"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetFont('Arial', 'B', 8);


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
