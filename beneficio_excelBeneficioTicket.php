<?php

require 'vendor/autoload.php';
include "js/repositorio.php";
//index2 é uma aba oculta de endereco
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$codigoConsultaBeneficio = (int)$_GET["id"];
$sql = "SELECT PB.projeto,P.apelido AS apelidoProjeto,PB.mesAno,P.descricao,PB.mesAno,PB.codigo AS codigoConsultaBeneficio,PBD.processaBeneficio,PBD.codigoFuncionario,PBD.funcionario,PBD.diaUtilVAVR,PBD.valorDiarioFuncionarioVAVR,PBD.totalFaltaVAVR,PBD.totalAusenciaVAVR,
PBD.totalFaltasAusenciasComAbatimentoProjetoSindicato,PBD.diaUtilFerias,PBD.afastamentoAbaterVAVR,PBD.diasTrabalhadosVAVR,PBD.valorMensalFuncionarioVAVR,
PBD.descricaoDescontoVAVR,PBD.valorExtraVAVR,PBD.vavrTotal,PBD.totalValorAcrescimoBeneficioIndiretoExtra,
PBD.totalAcrescimoBeneficioIndiretoComExtra,PBD.valorCestaBasicaExtra,PBD.cestaBasicaExtraComCestaBasica,PBD.valorTotalPlanoSaude,PBD.totalValorAbaterBeneficioIndireto,
PBD.valorTotalPlanoSaudeBeneficio,PBD.valorTotalFuncionarioVT,PBD.diaUtilVT,PBD.totalFaltasValeTransporte,PBD.totalAusenciasValeTransporte,PBD.diasTrabalhadosVT,PBD.valorExtraVT,PBD.VTMensal, 
F.ativo AS situacaoFuncionario,F.cpf,F.matricula,F.dataNascimento,PBD.codigoBeneficio,PBD.produtoVAVR,PROD.nome AS nomeProdutoBeneficio,PBD.produtoBeneficioIndireto,PBD.codigoBeneficioIndireto,FO.codigoCliente,
E.codigoDepartamento,E.nome AS nomeEmpresa
FROM Beneficio.processaBeneficio PB
LEFT JOIN Beneficio.processaBeneficioDetalhe PBD ON PBD.processaBeneficio = PB.codigo
LEFT JOIN Ntl.projeto P ON PB.projeto = P.codigo 
LEFT JOIN Ntl.funcionario F ON PBD.codigoFuncionario = F.codigo 
LEFT JOIN Beneficio.produtoBeneficio BPROD ON PBD.produtoVAVR = BPROD.codigo
LEFT JOIN Ntl.fornecedor FO ON BPROD.fornecedor = FO.codigo
LEFT JOIN Ntl.empresa E ON E.codigo = 1
LEFT JOIN Beneficio.produtoBeneficio PROD ON PROD.codigo = PBD.produtoVAVR
WHERE PBD.processaBeneficio = $codigoConsultaBeneficio";

$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$inputFileName = 'planilhas/planilhaTicket.xlsx';
/** Load $inputFileName to a Spreadsheet Object  **/

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

$sheet = $spreadsheet->getSheet(0);

// $spreadsheet->setActiveSheetIndex(3); //buscar pagina planilha pelo index
$sheet = $spreadsheet->getSheetByName("Planilha3");
// $sheet = $spreadsheet->getActiveSheet(); // Pega a página ativa da planilha
$i = 4;
$arrayProdutos = [];
$arrayProdutosCodigo = [];
foreach ($result as $row) {

        $projeto = $row['projeto'];
        $nomeEmpresa = $row['nomeEmpresa'];
        $apelidoProjeto = $row['apelidoProjeto'];
        $codigoCliente = $row['codigoCliente'];
        $nomeFuncionario = $row['funcionario'];
        $matricula = $row['matricula'];
        $dataNascimento = $row['dataNascimento'];
        $codigoDepartamento = $row['codigoDepartamento'];
        $dataNascimento = explode("-", $dataNascimento);
        $diaCampo = explode(" ", $dataNascimento[2]);
        $dataNascimento = $diaCampo[0] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];
        $cpf = $row['cpf'];
        $valorVAVR = $row['vavrTotal'];

        if ($totalBeneficioIndireto == 0) {
                $situacaoFuncionario = 'Inativo';
        } else {
                $situacaoFuncionario = 'Ativo';
        }

        $mesAno = $row['mesAno'];
        $codigoBeneficio = "";
        $codigoBeneficio = $row['codigoBeneficio'];
        $nomeProdutoBeneficio = $row['nomeProdutoBeneficio'];
        $codigoComNomeBeneficio = "";
        if ($codigoBeneficio) {
                if(!in_array($codigoBeneficio, $arrayProdutosCodigo)){
                        $arrayProdutosCodigo[] = $codigoBeneficio;
                        $arrayProdutosNome =  [$codigoBeneficio,$nomeProdutoBeneficio];
                        $arrayProdutosNomeCodigo[] = $arrayProdutosNome;
                }
                $codigoComNomeBeneficio = $codigoBeneficio . " - " . $nomeProdutoBeneficio;
        }

        // $vavrTotal = number_format($vavrTotal, 2, ',', '.');
        $sheet->setCellValue('A' . $i, $matricula);
        $sheet->setCellValue('B' . $i, $cpf);
        $sheet->setCellValue('C' . $i, $nomeFuncionario);
        $sheet->setCellValue('D' . $i, $dataNascimento);
        $sheet->setCellValue('E' . $i, $codigoDepartamento);
        $sheet->setCellValue('F' . $i, $apelidoProjeto);
        $sheet->setCellValue('G' . $i, $valorVAVR);
        $sheet->setCellValue('H' . $i, $codigoComNomeBeneficio);
        $i++;
}


// inicio planilha2
$sheetPlanilha1 = $spreadsheet->getSheetByName("Planilha2");
$sqlEmpresa = "SELECT E.codigo,E.ativo,E.nome as nomeEmpresa,E.cnpj,E.cep,E.tipoLogradouro,E.logradouro,E.numero,E.complemento,E.bairro,
                E.cidade,E.uf,P.fornecedorVAVR,F.codigoCliente,F.nomeDepartamento,F.codigoDepartamento,F.responsavelRecebimento
                FROM Ntl.empresa AS E
		LEFT JOIN Ntl.projeto AS P ON P.codigo = $projeto
                LEFT JOIN Ntl.fornecedor AS F ON F.codigo = P.fornecedorVAVR";
$resultEmpresa = $reposit->RunQuery($sqlEmpresa);

if ($rowEmpresa = $resultEmpresa[0]) {

        $codigoDepartamento = $rowEmpresa['codigoDepartamento'];
        $nomeDepartamento = $rowEmpresa['nomeDepartamento'];
        $nomeEmpresa = $rowEmpresa['nomeEmpresa'];
        $responsavelRecebimento = $rowEmpresa['responsavelRecebimento'];
        $codigoClienteProjeto = $rowEmpresa['codigoCliente'];
        $tipoLogradouro = $rowEmpresa['tipoLogradouro'];
        $logradouro = $rowEmpresa['logradouro'];
        $numero = $rowEmpresa['numero'];
        $complemento = $rowEmpresa['complemento'];
        $bairro = $rowEmpresa['bairro'];
        $cidade = $rowEmpresa['cidade'];
        $uf = $rowEmpresa['uf'];
        $cep = $rowEmpresa['cep'];
        $cnpj = $rowEmpresa['cnpj'];

        $sheetPlanilha1->setCellValue('A4', $cnpj);
        $sheetPlanilha1->setCellValue('B4', $codigoDepartamento);
        $sheetPlanilha1->setCellValue('C4', $nomeEmpresa);
        $sheetPlanilha1->setCellValue('D4', $tipoLogradouro);
        $sheetPlanilha1->setCellValue('E4', $logradouro);
        $sheetPlanilha1->setCellValue('F4', $numero);
        $sheetPlanilha1->setCellValue('G4', $complemento);
        $sheetPlanilha1->setCellValue('H4', $bairro);
        $sheetPlanilha1->setCellValue('I4', $uf);
        $sheetPlanilha1->setCellValue('J4', $cidade);
        $sheetPlanilha1->setCellValue('K4', $cep);
        $sheetPlanilha1->setCellValue('L4', $responsavelRecebimento);
}
//Fim planilha2

// inicio planilha1 
$sheetPlanilha1 = $spreadsheet->getSheetByName("Planilha1");
$indexProdutos = 5;
xdebug_break();
foreach ($arrayProdutosNomeCodigo as $value){
   
        $produtoCodigo = $value[0];
        $produtoNome = $value[1];
        $sheetPlanilha1->setCellValue('A' . $indexProdutos, $cnpj);
        $sheetPlanilha1->setCellValue('B' . $indexProdutos, $nomeEmpresa);
        $sheetPlanilha1->setCellValue('C' . $indexProdutos, $produtoCodigo);
        $sheetPlanilha1->setCellValue('D' . $indexProdutos, $produtoNome);
        $indexProdutos++;
}
//Fim planilha1

$writer = new Xlsx($spreadsheet);
$fileName = 'BeneficioTicket.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
$writer->save('php://output');

exit(); // se nao colocar o exit trava o excel
