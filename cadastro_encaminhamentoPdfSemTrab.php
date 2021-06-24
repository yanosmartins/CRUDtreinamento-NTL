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

$tipoExame = $_GET["tipoExame"]; // TIPO EXAME RECEBIDO PELO ASO
$dataAgendamento = $_GET["dataAgendamento"]; // DATA DO AGENDAMENTO RECEBIDA PELO ASO
$clinicaId = $_GET["clinicaId"];

// SPLIT DATA AGENDAMENTO // 
$dataAgendamento = explode("/", $dataAgendamento);
$dataAgendamentoTeste = $dataAgendamento[2] . "/" . $dataAgendamento[1] . "/" . $dataAgendamento[0];
$dataAgendamentoTela = $dataAgendamento[0] . "/" . $dataAgendamento[1] . "/" . $dataAgendamento[2];
$diaAgendamento = $dataAgendamento[0];
$mesAgendamento = $dataAgendamento[1];
$anoAgendamento = $dataAgendamento[2];
// FIM SPLIT AGENDAMENTO // 

// MES DE DIGITO PARA ESCRITO POR EXTENSO//
$mesExtenso = ucfirst(mb_convert_encoding(strftime('%B', strtotime("$anoAgendamento-$mesAgendamento")), 'UTF-8', 'HTML-ENTITIES'));

$nome = strtoupper($nome);

$reposit = new reposit();

$sql = "SELECT F.nome,C.descricao,D.descricao AS 'departamento' FROM ntl.funcionario F 
INNER JOIN ntl.cargo C ON F.cargo = C.codigo 
INNER JOIN ntl.beneficioProjeto BP ON F.codigo = BP.funcionario
INNER JOIN ntl.departamento D ON BP.departamento = D.codigo 
WHERE BP.ativo = 1 AND F.codigo =" . $id;

$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";
$row = $result[0];
if ($row) {

    $nome = $row['nome'];
    $nome = strtoupper($nome);
    $cargo = $row['descricao'];
    $departamento = $row['departamento'];
}
$reposit = new reposit();
$sql = "SELECT C.codigo AS 'clinicaId',C.fornecedor,C.solicitante,FU.nome AS 'nomeSolicitante' FROM ntl.clinica C 
INNER JOIN ntl.fornecedor F ON C.fornecedor = F.codigo
INNER JOIN ntl.funcionario FU ON C.solicitante = FU.codigo
WHERE C.codigo = " . $clinicaId;

$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";
$row = $result[0];
if ($row) {
    $clinicaId = $row['clinicaId'];
    $nomeSolicitante = $row['nomeSolicitante'];
    
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

$pdf->Image('img\semtrab.png',32,17,-139);



//BORDAS
$pdf->Line(29, 16, 182, 16); //BORDA DE CIMA

$pdf->Line(29, 16, 29, 139); // BORDA ESQUERDA

$pdf->Line(29, 139, 182, 139);  // BORDA DE BAIXO

$pdf->Line(182, 16, 182, 139); // BORDA DIREITA

// FIM BORDAS

// INICIO DIVISÓRIAS

$pdf->Line(29, 38, 182, 38); // LINHA DIVISÓRIA ACIMA DO NOME

$pdf->Line(29, 44, 182, 44); // LINHA DIVISÓRIA ABAIXO DO NOME

$pdf->Line(29, 58, 182, 58); // LINHA DIVISÓRIA ABAIXO DA EMPRESA

$pdf->Line(105.5, 58, 105.5, 78); // LINHA DIVISÓRIA ENTRE CNPJ/SETOR E DATA/FUNÇÃO

$pdf->Line(29, 68.3, 182, 68.3); // LINHA DIVISÓRIA ABAIXO DO CNPJ E DA DATA

$pdf->Line(29, 78, 182, 78); // LINHA DIVISÓRIA ABAIXO DO SETOR E FUNÇÃO

$pdf->Line(29, 88, 182, 88); // LINHA DIVISÓRIA ABAIXO DOS RISCOS OCUPACIONAIS

$pdf->Line(29, 104.5, 182, 104.5); // LINHA DIVISÓRIA ABAIXO DO TIPO DE EXAME    

$pdf->Line(29, 119, 182, 119); // LINHA DIVISÓRIA ABAIXO DOS EXAMES COMPLEMENTARES

$pdf->Line(80.5, 16, 80.5, 38); // LINHA DIVISÓRIA DA LOGO E O GUIA DE ENCAMINHAMENTO   

// FIM DIVISÓRIAS


//INICIO GUIA DE ENCAMINHAMENTO E ATESTADO DE SAUDE OCUPACIONAL - ASO
$pdf->setY(22);
$pdf->SetFont('Arial', 'B', 12);
$pdf->setX(100);

$pdf->SetTextColor(125, 125, 125);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "GUIA DE ENCAMINHAMENTO"), 0, 0, "L", 0);
$pdf->setY(28);
$pdf->SetFont('Arial', '', 12.5);
$pdf->SetTextColor(120, 120, 120);
$pdf->setX(93);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Atestado de Saúde Ocupacional - ASO"), 0, 0, "L", 0);

$pdf->SetTextColor(0, 0, 0);
// FIM GUIA DE ENCAMINHAMENTO E ATESTADO DE SAUDE OCUPACIONAL - ASO

// NOME FUNCIONARIO
$pdf->setY(39);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Nome do funcionário (a):"), 0, 0, "L", 0);
$pdf->setY(39);
$pdf->SetFont('Arial', 'B', 10.5);
$pdf->setX(74);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "$nome"), 0, 0, "L", 0);
// FIM NOME FUNCIONARIO

// EMPRESA
$pdf->setY(44.5);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Empresa:"), 0, 0, "L", 0);
$pdf->setY(44.5);
$pdf->SetFont('Arial', 'B', 10.5);
$pdf->setX(47);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "NTL Nova Tecnologia"), 0, 0, "L", 0);
// FIM EMPRESA

// CNPJ
$pdf->setY(58.5);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CNPJ:"), 0, 0, "L", 0);
$pdf->setY(58.5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->setX(42);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "32.185.480/0001-07"), 0, 0, "L", 0);
// FIM CNPJ

// DATA
$pdf->setY(58.5);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(104.9);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Data:"), 0, 0, "L", 0);
$pdf->setY(58.5);
$pdf->SetFont('Arial', 'B', 11.5);
$pdf->setX(114.8);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "$dataAgendamentoTela"), 0, 0, "L", 0);
// FIM DATA

// SETOR
$pdf->setY(69.4);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Setor:"), 0, 0, "L", 0);
$pdf->setY(69.4);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(41);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "$departamento"), 0, 0, "L", 0);
// FIM SETOR

// FUNÇÃO
$pdf->setY(69.4);
$pdf->SetFont('Arial', '', 10);
$pdf->setX(104.8);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Função:"), 0, 0, "L", 0);
$pdf->setY(69.7);
$pdf->SetFont('Arial', 'B', 9);
$pdf->setX(117.8);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "$cargo"), 0, 0, "L", 0);
// FIM FUNÇÃO

// Riscos Ocupacionais
$pdf->setY(78.5);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Riscos Ocupacionais:"), 0, 0, "L", 0);
$pdf->setY(78.5);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(68);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Não Há"), 0, 0, "L", 0);
// FIM Riscos Ocupacionais

// Tipo do Exame
if ($tipoExame == 1) {
    $pdf->setY(88.8);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Tipo do Exame:"), 0, 0, "L", 0);
    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(X) Admissional"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Periódico"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(110);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Retorno ao Trabalho"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Mudança de função"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Demissional"), 0, 0, "L", 0);
} else if ($tipoExame == 2 ) {
    $pdf->setY(88.8);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Tipo do Exame:"), 0, 0, "L", 0);
    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Admissional"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(X) Periódico"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(110);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Retorno ao Trabalho"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Mudança de função"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Demissional"), 0, 0, "L", 0);
} else if ($tipoExame == 4 ) {
    $pdf->setY(88.8);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Tipo do Exame:"), 0, 0, "L", 0);
    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Admissional"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Periódico"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(110);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(X) Retorno ao Trabalho"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Mudança de função"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Demissional"), 0, 0, "L", 0);
}else if ($tipoExame == 3) {
    $pdf->setY(88.8);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Tipo do Exame:"), 0, 0, "L", 0);
    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Admissional"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Periódico"), 0, 0, "L", 0);

    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(110);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Retorno ao Trabalho"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(X) Mudança de função"), 0, 0, "L", 0);

    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Demissional"), 0, 0, "L", 0);
} else { 

    $pdf->setY(88.8);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Tipo do Exame:"), 0, 0, "L", 0);
    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Admissional"), 0, 0, "L", 0);
    
    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Periódico"), 0, 0, "L", 0);
    
    $pdf->setY(93.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(110);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Retorno ao Trabalho"), 0, 0, "L", 0);
    
    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(30);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(  ) Mudança de função"), 0, 0, "L", 0);
    
    $pdf->setY(98.5);
    $pdf->SetFont('Arial', '', 11);
    $pdf->setX(75);
    $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(X) Demissional"), 0, 0, "L", 0);
    
}

// FIM Tipo do Exame

// Exames Complementares
$pdf->setY(105.5);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Exames Complementares:"), 0, 0, "L", 0);
// FIM Exames Complementares

// Solicitante
$pdf->setY(120);
$pdf->SetFont('Arial', '', 11);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Solicitante:"), 0, 0, "L", 0);

$pdf->setY(125);
$pdf->SetFont('Arial', 'B', 10.5);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "$nomeSolicitante"), 0, 0, "L", 0);
// FIM Solicitante

// NOTA 
$pdf->setY(144);
$pdf->SetFont('Arial', 'B', 10);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "NOTA:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 10);
$pdf->setY(149);
$pdf->setX(37);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "•     Os Funcíonarios deverão estar com documento com foto e CPF"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 10);
$pdf->setY(153);
$pdf->setX(37);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "•     Para Enquadramento PCD é necessário apresentar o laudo com o CID."), 0, 0, "L", 0);
// FIM NOTA 

// NOME ENDEREÇO EMPRESA//
$pdf->SetFont('Arial', 'B', 10.3);
$pdf->setY(162);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Semtrab Segurança e Medicina do Trabalho"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 9);
$pdf->setY(166.8);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rua Maestro Felício Tolêdo, 500, Sala 801 e 802, Centro, Niterói"), 0, 0, "L", 0);
// FIM NOME ENDEREÇO EMPRESA

// ATENDIMENTO
$pdf->SetFont('Arial', 'B', 8.7);
$pdf->setY(171.6);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Atendimento:"), 0, 0, "L", 0);

$pdf->setY(176.3);
$pdf->SetFont('Arial', '', 9);
$pdf->setX(30);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "2° à 6° feira, 07:30 às 11:30 (ordem de chegada) e das 11:30 às 17:00 (agendamento)"), 0, 0, "L", 0);
// FIM ATENDIMENTO


$pdf->Output();
