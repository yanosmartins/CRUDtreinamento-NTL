<?php

require 'vendor/autoload.php';
include "js/repositorio.php";
//index2 é uma aba oculta de endereco
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$codigoConsultaBeneficio = (int)$_GET["id"];
$sql = "SELECT PB.projeto,PB.mesAno,P.descricao,PB.mesAno,PB.codigo AS codigoConsultaBeneficio,PBD.processaBeneficio,PBD.codigoFuncionario,PBD.funcionario,PBD.diaUtilVAVR,PBD.valorDiarioFuncionarioVAVR,PBD.totalFaltaVAVR,PBD.totalAusenciaVAVR,
        PBD.totalFaltasAusenciasComAbatimentoProjetoSindicato,PBD.diaUtilFerias,PBD.afastamentoAbaterVAVR,PBD.diasTrabalhadosVAVR,PBD.valorMensalFuncionarioVAVR,
        PBD.descricaoDescontoVAVR,PBD.valorExtraVAVR,PBD.vavrTotal,PBD.totalValorAcrescimoBeneficioIndiretoExtra,
        PBD.totalAcrescimoBeneficioIndiretoComExtra,PBD.valorCestaBasicaExtra,PBD.cestaBasicaExtraComCestaBasica,PBD.valorTotalPlanoSaude,PBD.totalValorAbaterBeneficioIndireto,
        PBD.valorTotalPlanoSaudeBeneficio,PBD.valorTotalFuncionarioVT,PBD.diaUtilVT,PBD.totalFaltasValeTransporte,PBD.totalAusenciasValeTransporte,PBD.diasTrabalhadosVT,PBD.valorExtraVT,PBD.VTMensal, 
        F.ativo AS situacaoFuncionario,F.cpf,F.matricula,F.dataNascimento,PBD.codigoBeneficio,PBD.produtoVAVR,FO.codigoCliente,E.codigoDepartamento
        FROM Beneficio.processaBeneficio PB
        LEFT JOIN Beneficio.processaBeneficioDetalhe PBD ON PBD.processaBeneficio = PB.codigo
        LEFT JOIN Ntl.projeto P ON PB.projeto = P.codigo 
        LEFT JOIN Ntl.funcionario F ON PBD.codigoFuncionario = F.codigo 
        LEFT JOIN Beneficio.produtoBeneficio BPROD ON PBD.produtoVAVR = BPROD.codigo
        LEFT JOIN Ntl.fornecedor FO ON BPROD.fornecedor = FO.codigo
        LEFT JOIN Ntl.empresa E ON E.codigo = 1
        WHERE PBD.processaBeneficio = $codigoConsultaBeneficio";

$reposit = new reposit();
$result = $reposit->RunQuery($sql);

$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$inputFileName = './planilhaSodexo.xlsx';
/** Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

$sheet = $spreadsheet->getSheet(0);

// $spreadsheet->setActiveSheetIndex(3); //buscar pagina planilha pelo index
$sheet = $spreadsheet->getSheetByName("Dados dos Beneficiários-Cartão");
// $sheet = $spreadsheet->getActiveSheet(); // Pega a página ativa da planilha
$i = 8;
foreach ($result as $row) {
        $codigoCliente = $row['codigoCliente'];
        $nomeFuncionario = $row['funcionario'];
        $matricula = $row['matricula'];
        $dataNascimento = $row['dataNascimento'];
        $codigoDepartamento = $row['codigoDepartamento'];

        $dataNascimento = explode("-", $dataNascimento);
        $diaCampo = explode(" ", $dataNascimento[2]);
        $dataNascimento = $diaCampo[0] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];

        $cpf = $row['cpf'];
        $vavrTotal = $row['vavrTotal'];
        if($vavrTotal == 0){
                $situacaoFuncionario = 'Inativo';
        }else{
                $situacaoFuncionario = 'Ativo';
        }
        $mesAno = $row['mesAno'];
        $codigoBeneficio = $row['codigoBeneficio'];
        // $vavrTotal = number_format($vavrTotal, 2, ',', '.');
        $sheet->setCellValue('A' . $i, $codigoCliente);
        $sheet->setCellValue('B' . $i, $codigoDepartamento);
        $sheet->setCellValue('C' . $i, $situacaoFuncionario);
        $sheet->setCellValue('D' . $i, $matricula);
        $sheet->setCellValue('E' . $i, $nomeFuncionario);      
        $sheet->setCellValue('G' . $i, $cpf);      
        $sheet->setCellValue('H' . $i, $dataNascimento);    
        $sheet->setCellValue('J' . $i, 1);   
        $sheet->setCellValue('L' . $i, $vavrTotal);  
        $sheet->setCellValue('O' . $i, $mesAno);  
        $sheet->setCellValue('K' . $i, $codigoBeneficio);  
        $i++;
}

// inicio Dados Empresa
$sheetDadosEmpresa = $spreadsheet->getSheetByName("Dados da Empresa");
$sqlEmpresa = "SELECT codigo,ativo,nome,codigoDepartamento,nomeDepartamento,responsavelRecebimento,cep,tipoLogradouro,logradouro,numero,complemento,bairro,
cidade,uf
FROM ntl.Ntl.empresa";
$resultEmpresa = $reposit->RunQuery($sqlEmpresa);

if($rowEmpresa = $resultEmpresa[0]){
            
        $codigoDepartamento = $rowEmpresa['codigoDepartamento'];
        $nomeDepartamento = $rowEmpresa['nomeDepartamento'];
        $responsavelRecebimento = $rowEmpresa['responsavelRecebimento'];
        $tipoLogradouro = $rowEmpresa['tipoLogradouro'];
        $logradouro = $rowEmpresa['logradouro'];
        $numero = $rowEmpresa['numero'];
        $complemento = $rowEmpresa['complemento'];
        $bairro = $rowEmpresa['bairro'];
        $cidade = $rowEmpresa['cidade'];
        $uf = $rowEmpresa['uf'];
        $cep = $rowEmpresa['cep'];

        $sheetDadosEmpresa->setCellValue('A8', $codigoCliente);
        $sheetDadosEmpresa->setCellValue('B8', $codigoDepartamento);
        $sheetDadosEmpresa->setCellValue('C8', $nomeDepartamento);
        $sheetDadosEmpresa->setCellValue('D8', $responsavelRecebimento);
        $sheetDadosEmpresa->setCellValue('E8', $tipoLogradouro);
        $sheetDadosEmpresa->setCellValue('F8', $logradouro);
        $sheetDadosEmpresa->setCellValue('G8', $numero);
        $sheetDadosEmpresa->setCellValue('H8', $complemento);
        $sheetDadosEmpresa->setCellValue('I8', $bairro);
        $sheetDadosEmpresa->setCellValue('J8', $cidade);
        $sheetDadosEmpresa->setCellValue('K8', $uf);
        $sheetDadosEmpresa->setCellValue('L8', $cep);
}
//Fim dados empresa

$sheet3 = $spreadsheet->getSheetByName("Dados dos Beneficiários-V.T.");
// $sheet->setCellValue('A10', '123');
// $sheet->setCellValue('B10', '1');
// $sheet->setCellValue('C10', 'DESENVOLVIMENTO');
// $sheet->setCellValue('D10', 'Danilo');
// $sheet->setCellValue('E10', 'Rua');
// $sheet->setCellValue('F10', 'Grajau');
// $sheet->setCellValue('G10', '198');

// $sheet2 = $spreadsheet->getSheetByName("Dados da Empresa");
// $sheet2->setCellValue('A10', '123');
// $sheet2->setCellValue('B10', '456');
// $sheet2->setCellValue('C10', 'DEV');

$writer = new Xlsx($spreadsheet);
$fileName = 'nomeSodexo.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
       
exit(); // se nao colocar o exit trava o excel

