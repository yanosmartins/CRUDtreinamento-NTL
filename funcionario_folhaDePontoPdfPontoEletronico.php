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
    $id = (int)$_GET["id"];
}
$folha = (int)$_GET["folha"];
$pag = (int)$_GET["pag"];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once('fpdf/fpdf.php');


$mesAno = $_GET["data"];
if ($mesAno != "") {
    $mesteste = explode("-", $mesAno);
    $mes = $mesteste[1];
    if ($pag == 0 && $mes == 01) {
        $mes = 12;
    }
    if ($pag == 0 && $mes != 01) {
        $mes = $mes - 1;
    }
    $ano = $mesteste[0];
    $mesExtenso = ucfirst(mb_convert_encoding(strftime('%B', strtotime("$ano-$mes")), 'UTF-8', 'HTML-ENTITIES'));
    // $mes = date("m"); //02
    $days = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    // $ano = date("Y"); //2021
} else {

    $mes = date("m"); //02
    if ($pag == 0 && $mes == 01) {
        $mes = 12;
    }
    if ($pag == 0 && $mes != 01) {
        $mes = $mes - 1;
    }
    $ano = date("Y"); //2021
    $days = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

    $mesExtenso = ucfirst(mb_convert_encoding(strftime('%B', strtotime("$ano-$mes")), 'UTF-8', 'HTML-ENTITIES'));
}

$reposit = new reposit();

$sql = "SELECT BP.codigo,F.codigo AS 'funcionario',F.nome,F.matricula,F.logradouro,P.codigo AS 'projeto',BP.horaEntrada,BP.horaSaida,BP.horaInicio,BP.horaFim,P.apelido,P.estado,P.cidade,P.municipioFerias,C.descricao AS 'cargo'
    FROM Ntl.beneficioProjeto BP
    INNER JOIN Ntl.projeto P ON P.codigo = BP.projeto 
    INNER JOIN Ntl.funcionario F ON F.codigo = BP.funcionario
    INNER JOIN Ntl.cargo C ON C.codigo = F.cargo 
    WHERE (0=0) AND F.codigo = $id AND BP.ativo = 1";

$result = $reposit->RunQuery($sql);

if ($row = $result[0]) {
    $beneficioProjeto = $row['codigo'];
    $funcionario = $row['funcionario'];
    $nome = $row['nome'];
    $matricula = $row['matricula'];
    $logradouro = $row['logradouro'];
    $projeto = $row['projeto'];
    $horaEntrada = $row['horaEntrada'];
    $horaSaida = $row['horaSaida'];
    $horaInicio = $row['horaInicio'];
    $horaFim = $row['horaFim'];
    $apelido = $row['apelido'];
    $estado = $row['estado'];
    $cidade = $row['cidade'];
    $municipioFerias = $row['municipioFerias'];
    $cargo = $row['cargo'];
}

$dataInicio = "$ano-$mes-01";
$dataFim = "$ano-$mes-$days";

$sql = "SELECT F.codigo,F.descricao,F.tipoFeriado,F.municipio,M.descricao,F.unidadeFederacao,F.data,F.sabado,F.domingo 
FROM Ntl.feriado F 
LEFT JOIN Ntl.municipio M ON M.codigo = F.municipio
WHERE F.ativo = 1 AND data BETWEEN '2021-03-01' AND '2021-03-31'
AND (F.tipoFeriado = 3 OR (F.tipoFeriado = 1 and (F.unidadeFederacao = 'RJ')) OR F.tipoFeriado = 2 and M.codigo = 1) 
AND DATENAME(weekday,F.data) NOT IN ('Saturday', 'Sunday')";
$result = $reposit->RunQuery($sql);

$feriados = array();
foreach ($result as $row) {
    array_push($feriados, $row);
}
$ponto = array();
$sql = "SELECT F.codigo AS 'folha',FD.dia,F.mesAno,FD.horaEntrada,FD.inicioAlmoco,FD.fimAlmoco,FD.horaSaida,FD.horaExtra,FD.atraso,FD.lancamento,L.descricao,F.observacao FROM Funcionario.folhaPontoMensal F
INNER JOIN Funcionario.folhaPontoMensalDetalheDiario FD ON F.codigo = FD.folhaPontoMensal
INNER JOIN ntl.funcionario FU ON FU.codigo = F.funcionario 
LEFT JOIN ntl.lancamento L ON L.codigo = FD.lancamento
WHERE (0=0) AND FU.codigo = 13080 AND F.codigo = 14";
$result = $reposit->RunQuery($sql);
foreach ($result as $row) {
    array_push($ponto, [
        "codigo" => $row["codigo"],
        "dia" => $row["dia"],
        "horaEntrada" => $row["horaEntrada"],
        "inicioAlmoco" => $row["inicioAlmoco"],
        "fimAlmoco" => $row["fimAlmoco"],
        "horaSaida" => $row["horaSaida"],
        "horaExtra" => $row["horaExtra"],
        "atraso" => $row["atraso"],
        "descricao" => $row["descricao"],
        "lancamento" => $row["lancamento"],
        "observacao" => $row["observacao"]
    ]);
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
$pdf->SetFillColor(220, 220, 220);
$pdf->SetMargins(0, 0, 0); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->AddPage();

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
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "NTL Nova Tecnologia Ltda"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->setY(17);
$pdf->setX(67);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "CNPJ: 32185480/0001-07"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->SetFont('Arial', 'B', 8);
$pdf->setY(17);
$pdf->setX(106);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Rua: Visconde de Inhaúma, 38 - 701 - Centro - RJ"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Line(5, 21, 205, 21); // linha abaixo de ntl cnpj e endereco


$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Expediente: $horaEntrada ÀS $horaSaida"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(6);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "(Intervalo: $horaInicio ÀS $horaFim)"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(67);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Cliente:NTL"), 0, 0, "L", 0);

$pdf->setY(25);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(67);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Cargo: $cargo"), 0, 0, "L", 0);

$pdf->setY(21);
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(106);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Mês:"), 0, 0, "L", 0);

$pdf->SetFont('Arial', '', 8);
$pdf->setY(21);
$pdf->setX(113);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $mesExtenso), 0, 0, "L", 0);

$pdf->setX(170);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Ano:"), 0, 0, "L", 0);
$pdf->setX(177);
$pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', $ano), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);

$pdf->Line(106, 25, 106, 17); //linha em pé ao lado do mes
$pdf->Line(169, 25, 169, 21); //linha rm pé ao lodo do ano
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
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $matricula), 0, 0, "L", 0);


$pdf->Line(5, 33, 205, 33); //linha abaixo do nome e matricula


$pdf->setY(36);
$pdf->setX(5);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "DIAS"), 0, 0, "L", 0);

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
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "ALMOÇO"), 0, 0, "L", 0);

$pdf->setY(35);
$pdf->setX(71);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "SAIDA"), 0, 0, "L", 0);

$pdf->setY(34);
$pdf->setX(99);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "EXTRAS"), 0, 0, "L", 0);


$pdf->setY(39);
$pdf->setX(89);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Entrada"), 0, 0, "L", 0);

$pdf->setY(39);
$pdf->setX(111);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Saida"), 0, 0, "L", 0);

$pdf->setY(36);
$pdf->setX(136);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "OBSERVAÇÃO"), 0, 0, "L", 0);

$pdf->setY(36);
$pdf->setX(181);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "VISTO"), 0, 0, "L", 0);



$pdf->Line(5, 43, 205, 43); // linha abaixo de diaas entrada saida observacao e visto
$pdf->Line(32, 39, 67, 39); //linha abaixo do almoco
$pdf->Line(86, 39, 126, 39); //linha abaixo de extras


$linhavertical = 46;
$linhahorizontalteste = 50;
$linhaverticalteste = 50;
$days = (int)$days;
foreach ($ponto as $registro) {
    $diadasemana = strftime('%u', strtotime($ano . '-' . $mes . '-' . $registro['dia']));
    $diaferiado = new DateTime($ano . '-' . $mes . '-' . $registro['dia']);

    $pdf->Line(5, $linhaverticalteste, 5, 17); // 0 
    $pdf->Line(16, $linhaverticalteste, 16, 33.1); // 1
    $pdf->Line(32, $linhaverticalteste, 32, 33); // 2
    $pdf->Line(49, $linhaverticalteste, 49, 39.1); // 3 
    $pdf->Line(67, $linhaverticalteste, 67, 17); // 4 
    $pdf->Line(86, $linhaverticalteste, 86, 33); // 5 
    $pdf->Line(106, $linhaverticalteste, 106, 39.1); // 6
    $pdf->Line(126, $linhaverticalteste, 126, 33); // 7
    $pdf->Line(169, $linhaverticalteste, 169, 33); // 8
    $pdf->Line(205, $linhaverticalteste, 205, 17); // 9 
    $pdf->Line(5, $linhahorizontalteste, 205, $linhahorizontalteste);

    // $pdf->Line(5, $linhaverticalteste, 5, 17); // 0 
    // $pdf->Line(16, $linhaverticalteste, 16, 33.1); // 1
    // $pdf->Line(32.1, $linhaverticalteste, 32.1, 33); // 2
    // $pdf->Line(49.1, $linhaverticalteste, 49.1, 39.1); // 3 
    // $pdf->Line(67.1, $linhaverticalteste, 67.1, 17); // 4 
    // $pdf->Line(86.1, $linhaverticalteste, 86.1, 33); // 5 
    // $pdf->Line(106.1, $linhaverticalteste, 106.1, 39.1); // 6
    // $pdf->Line(126.1, $linhaverticalteste, 126.1, 33); // 7
    // $pdf->Line(169.1, $linhaverticalteste, 169.1, 33); // 8
    // $pdf->Line(205.1, $linhaverticalteste, 205.1, 17); // 9 
    $pdf->Line(5, $linhahorizontalteste + 0.1, 205, $linhahorizontalteste + 0.1);
    $pdf->setY($linhavertical - 2.7);

    $pdf->setX(5);
    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', "" . $registro['dia'] . ""), 0, 0, "L", 0);
    $pdf->SetFont('Arial', 'B', 7);
    switch ($diadasemana) {
        case 1:
            $pdf->setX(7);
            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Seg"), 0, 0, "L", 0);
            $pdf->SetFont('Arial', 'B', 8);
            break;
        case 2:
            $pdf->setX(7);
            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Ter"), 0, 0, "L", 0);
            $pdf->SetFont('Arial', 'B', 8);
            break;
        case 3:
            $pdf->setX(7);
            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Qua"), 0, 0, "L", 0);
            $pdf->SetFont('Arial', 'B', 8);
            break;
        case 4:
            $pdf->setX(7);
            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Qui"), 0, 0, "L", 0);
            $pdf->SetFont('Arial', 'B', 8);
            break;
        case 5:
            $pdf->setX(7);
            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " - Sex"), 0, 0, "L", 0);
            $pdf->SetFont('Arial', 'B', 8);
            break;
        case 6:
            $pdf->setX(7);
            $pdf->Cell(9, 7, iconv('UTF-8', 'windows-1252', " - Sab"), 0, 0, "L", 0);
            $pdf->setX(16.2);
            $pdf->Cell(15.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->setX(67.2);
            $pdf->Cell(18.8, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->setX(126.35);
            $pdf->Cell(42.75, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->setX(169.35);
            $pdf->Cell(35.7, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->SetFont('Arial', 'B', 8);
            break;
        case 7:
            $pdf->setX(7);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(9, 7, iconv('UTF-8', 'windows-1252', " - Dom"), 0, 0, "L", 0);
            $pdf->setX(16.2);
            $pdf->Cell(15.65, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->setX(67.21);
            $pdf->Cell(18.69, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->setX(126.35);
            $pdf->Cell(42.55, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->setX(169.35);
            $pdf->Cell(35.5, 6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
            $pdf->SetFont('Arial', 'B', 8);
            break;
        default:
    }

    //isso tem que estar de alguma forma vinculado a um if/else para mostrar...
    foreach ($feriados as $feriado) {
        if ($feriado['data'] == $diaferiado) {
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->setX(14);
            $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', " FERIADO"), 0, 0, "L", 0);// isso...
            $pdf->SetFont('Arial', 'B', 9);
        }
    }
   

   

    //CINZA
    $pdf->setX(32.2);
    $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1);// ou isso
    $pdf->setX(49.2);
    $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1);// ou isso
    $pdf->setX(86.3);
    $pdf->Cell(19.55,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1);// ou isso
    $pdf->setX(106.3);
    $pdf->Cell(19.6,  6.61, iconv('UTF-8', 'windows-1252', ""), 0, 0, "C", 1);// ou isso
    

    if ($diadasemana != 6 && $diadasemana != 7) {

         //Hora Entrada/Saida
    $pdf->setX(14);
    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', $registro['horaEntrada']), 0, 0, "C", 0);// ou isso
    $pdf->setX(66, 5);
    $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', $registro['horaSaida']), 0, 0, "C", 0);// ou isso

    //Almoço Entrada/Saida 
    $pdf->setX(32.2);
    $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', $registro['inicioAlmoco']), 0, 0, "C", 0);// ou isso
    $pdf->setX(49.2);
    $pdf->Cell(17.65,  6.61, iconv('UTF-8', 'windows-1252', $registro['fimAlmoco']), 0, 0, "C", 0);// ou isso

     //Hora Extra/Atraso
     $pdf->setX(86.3);
     $pdf->Cell(19.55,  6.61, iconv('UTF-8', 'windows-1252', $registro['horaExtra']), 0, 0, "C", 0);// ou isso
     $pdf->setX(106.3);
     $pdf->Cell(19.6,  6.61, iconv('UTF-8', 'windows-1252', $registro['atraso']), 0, 0, "C", 0);// ou isso

    //Observacao
    $pdf->setX(128);
    $pdf->Cell(16.65,  6.61, iconv('UTF-8', 'windows-1252', $registro['descricao']), 0, 0, 0, 0);// ou isso

        foreach ($feriados as $feriado) {
            if (mb_ereg("-$mes-" . str_pad($i, 2, 0, STR_PAD_LEFT), $feriado["data"])) {
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->setX(16);
                $pdf->Cell(189, 6.7, iconv('UTF-8', 'windows-1252', ""), 0, 0, "L", 1);
                $pdf->setX(16);
                $pdf->SetTextColor(90, 90, 90);
                $pdf->Cell(20, 7, iconv('UTF-8', 'windows-1252', "FERIADO"), 0, 0, "L", 0);

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


$pdf->Ln(8);

$pdf->Output();
