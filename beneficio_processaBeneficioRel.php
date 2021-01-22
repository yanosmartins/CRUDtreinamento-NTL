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
    $id = (int) $_GET["id"];
}

$sql = "SELECT * , P.descricao as projetoDescricao , S.descricao as sindicatoDescricao, S.apelido as siglaSindicato, F.nome as funcionarioNome FROM syscb.beneficioProjeto as BP 
inner join syscb.projeto as P on BP.projeto = P.codigo
inner join syscb.sindicato as S on BP.sindicato = S.codigo
inner join syscb.funcionario as F on BP.funcionario = F.codigo
WHERE BP.codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0]) {


        $projeto =  $row['projetoDescricao'];
        $funcionario = $row['funcionarioNome'];
        $tipoDiaUtil = validaNumeroRecupera($row['tipoDiaUtil']);
        $sindicatoSigla = validaNumeroRecupera($row['siglaSindicato']); 
        $sindicato = $row['sindicatoDescricao'];
        $salarioFuncionario = validaNumeroRecupera($row['salarioFuncionario']);

        $percentualDescontoProjetoVR = validaNumeroRecupera($row['percentualDescontoProjetoVR']);
        $valorDescontoProjetoVR = validaNumeroRecupera($row['valorDescontoProjetoVR']);
        $percentualDescontoSindicatoVR = validaNumeroRecupera($row['percentualDescontoSindicatoVR']);
        $valorDescontoSindicatoVR = validaNumeroRecupera($row['valorDescontoSindicatoVR']);
        $percentualDescontoFuncionarioVR = validaNumeroRecupera($row['percentualDescontoFuncionarioVR']);
        $valorDescontoFuncionarioVR = validaNumeroRecupera($row['valorDescontoFuncionarioVR']);
        $percentualDescontoMesCorrenteVR = validaNumeroRecupera($row['percentualDescontoMesCorrenteVR']);
        $valorDescontoMesCorrenteVR = validaNumeroRecupera($row['valorDescontoMesCorrenteVR']);
        $valorDiarioProjetoVR = validaNumeroRecupera($row['valorDiarioProjetoVR']);
        $valorMensalProjetoVR = validaNumeroRecupera($row['valorMensalProjetoVR']);
        $valorDiarioSindicatoVR = validaNumeroRecupera($row['valorDiarioSindicatoVR']);
        $valorMensalSindicatoVR = validaNumeroRecupera($row['valorMensalSindicatoVR']);
        $valorDiaFuncionarioVR = validaNumeroRecupera($row['valorDiaFuncionarioVR']);
        $valorMensalFuncionarioVR = validaNumeroRecupera($row['valorMensalFuncionarioVR']);
        $valorProdutoVR = validaNumeroRecupera($row['valorProdutoVR']);
        $valorFuncionarioVR = validaNumeroRecupera($row['valorFuncionarioVR']);
        $valorEmpresaVR = validaNumeroRecupera($row['valorEmpresaVR']);
        $tipoDescontoVR = validaNumeroRecupera($row['tipoDescontoVR']);


        $percentualDescontoProjetoVAVR = validaNumeroRecupera($row['percentualDescontoProjetoVAVR']);
        $valorDescontoProjetoVAVR = validaNumeroRecupera($row['valorDescontoProjetoVAVR']);
        $percentualDescontoSindicatoVAVR = validaNumeroRecupera($row['percentualDescontoSindicatoVAVR']);
        $valorDescontoSindicatoVAVR = validaNumeroRecupera($row['valorDescontoSindicatoVAVR']);
        $valorDiarioFuncionarioVAVR = validaNumeroRecupera($row['valorDiarioFuncionarioVAVR']);
        $valorMensalFuncionarioVAVR = validaNumeroRecupera($row['valorMensalFuncionarioVAVR']);
        $percentualDescontoMesCorrenteVAVR = validaNumeroRecupera($row['percentualDescontoMesCorrenteVAVR']);
        $valorDescontoMesCorrenteVAVR = validaNumeroRecupera($row['valorDescontoMesCorrenteVAVR']);
        $valorDiarioFuncionarioVAVR = validaNumeroRecupera($row['valorDiarioFuncionarioVAVR']);
        $valorDiarioProjetoVAVR = validaNumeroRecupera($row['valorDiarioProjetoVAVR']);
        $valorMensalProjetoVAVR = validaNumeroRecupera($row['valorMensalProjetoVAVR']);
        $valorDiarioSindicatoVAVR = validaNumeroRecupera($row['valorDiarioSindicatoVAVR']);
        $valorMensalSindicatoVAVR = validaNumeroRecupera($row['valorMensalSindicatoVAVR']);
        $percentualDescontoFolhaFuncionarioVAVR = validaNumeroRecupera($row['percentualDescontoFolhaFuncionarioVAVR']);
        $valorDescontoFolhaFuncionarioVAVR = validaNumeroRecupera($row['valorDescontoFolhaFuncionarioVAVR']);
        $valorProdutoVAVR = validaNumeroRecupera($row['valorProdutoVAVR']);
        $valorFuncionarioVAVR = validaNumeroRecupera($row['valorFuncionarioVAVR']);
        $valorEmpresaVAVR = validaNumeroRecupera($row['valorEmpresaVAVR']);
        $tipoDescontoVAVR = validaNumeroRecupera($row['tipoDescontoVAVR']);


        $valorCestaBasica = validaNumeroRecupera($row['valorCestaBasica']);
        $valorDiarioSindicatoCestaBasica = validaNumeroRecupera($row['valorDiarioSindicatoCestaBasica']);
        $valorMensalSindicatoCestaBasica = validaNumeroRecupera($row['valorMensalSindicatoCestaBasica']);
        $percentualDescontoSindicatoCestaBasica = validaNumeroRecupera($row['percentualDescontoSindicatoCestaBasica']);
        $valorDescontoSindicatoCestaBasica = validaNumeroRecupera($row['valorDescontoSindicatoCestaBasica']);
        $perdaBeneficio = validaNumeroRecupera($row['perdaBeneficio']);

        $valorProdutoCestaBasica = validaNumeroRecupera($row['valorProdutoCestaBasica']);
        $valorFuncionarioCestaBasica = validaNumeroRecupera($row['valorFuncionarioCestaBasica']);
        $valorEmpresaCestaBasica = validaNumeroRecupera($row['valorEmpresaCestaBasica']);

     
        $consideraVAVR = validaNumeroRecupera($row['consideraVAVR']);
        $consideraVr = validaNumeroRecupera($row['consideraVr']);
        $consideraVt = validaNumeroRecupera($row['consideraVt']);

        $diaUtilJaneiro = validaNumeroRecupera($row['diaUtilJaneiroVAVR']);
        $diaUtilFevereiro = validaNumeroRecupera($row['diaUtilFevereiroVAVR']);
        $diaUtilMarco = validaNumeroRecupera($row['diaUtilMarcoVAVR']);
        $diaUtilAbril = validaNumeroRecupera($row['diaUtilAbrilVAVR']);
        $diaUtilMaio = validaNumeroRecupera($row['diaUtilMaioVAVR']);
        $diaUtilJunho = validaNumeroRecupera($row['diaUtilJunhoVAVR']);
        $diaUtilJulho = validaNumeroRecupera($row['diaUtilJulhoVAVR']);
        $diaUtilAgosto = validaNumeroRecupera($row['diaUtilAgostoVAVR']);
        $diaUtilSetembro = validaNumeroRecupera($row['diaUtilSetembroVAVR']);
        $diaUtilOutubro = validaNumeroRecupera($row['diaUtilOutubroVAVR']);
        $diaUtilNovembro = validaNumeroRecupera($row['diaUtilNovembroVAVR']);
        $diaUtilDezembro = validaNumeroRecupera($row['diaUtilDezembroVAVR']);

        $diaUtilJaneiroVT = validaNumeroRecupera($row['diaUtilJaneiroVT']);
        $diaUtilFevereiroVT = validaNumeroRecupera($row['diaUtilFevereiroVT']);
        $diaUtilMarcoVT = validaNumeroRecupera($row['diaUtilMarcoVT']);
        $diaUtilAbrilVT = validaNumeroRecupera($row['diaUtilAbrilVT']);
        $diaUtilMaioVT = validaNumeroRecupera($row['diaUtilMaioVT']);
        $diaUtilJunhoVT = validaNumeroRecupera($row['diaUtilJunhoVT']);
        $diaUtilJulhoVT = validaNumeroRecupera($row['diaUtilJulhoVT']);
        $diaUtilAgostoVT = validaNumeroRecupera($row['diaUtilAgostoVT']);
        $diaUtilSetembroVT = validaNumeroRecupera($row['diaUtilSetembroVT']);
        $diaUtilOutubroVT = validaNumeroRecupera($row['diaUtilOutubroVT']);
        $diaUtilNovembroVT = validaNumeroRecupera($row['diaUtilNovembroVT']);
        $diaUtilDezembroVT = validaNumeroRecupera($row['diaUtilDezembroVT']);


        $saldoDisponivel = validaNumeroRecupera($row['saldoDisponivel']);
        if ($saldoDisponivel == 0) {
            $saldoDisponivel = 0;
        }

        //----------------------Montando o array do Plane Saude Titular

        $reposit = "";
        $result = "";
        $sql = "SELECT BP.codigo, BS.funcionario, BS.convenio, BS.produto, BS.cobranca, BS.idade, 
        BS.percentualDescontoSindicato,
        BS.valorDescontoSindicato, BS.percentualDescontoProjeto, BS.valorDescontoProjeto, BS.valorProduto, BS.valorFuncionario, BS.valorEmpresa, BS.baseDesconto,
        BS.percentualDescontoPlanoSaude, BS.valorDescontoPlanoSaude , P.produto as produtoDescricao , C.apelido
        FROM syscb.beneficioProjeto BP
        INNER JOIN syscb.beneficioProjetoPlanoSaudeTitular BS ON BP.codigo = BS.beneficioProjeto
        inner join syscb.produto as P on BS.produto = P.codigo
        inner join syscb.convenioSaude as C on BS.convenio = C.codigo
         WHERE (0=0) AND BP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorPlanoSaude = 0;
        $arrayPlanoSaude = array();
        foreach($result as $row) {




            $funcionarioPlanoSaude = $funcionario;
            $convenio = $row['apelido'];
            $cobranca = (int) $row['cobranca'];
            $idade = (int) $row['idade'];

            $produto = $row['produtoDescricao'];


            $percentualDescontoSindicato = $row['percentualDescontoSindicato'];
            $percentualDescontoSindicato = str_replace('.', ',', $percentualDescontoSindicato);

            $valorDescontoSindicato = $row['valorDescontoSindicato'];
            $valorDescontoSindicato = str_replace('.', ',', $valorDescontoSindicato);

            $percentualDescontoProjeto = $row['percentualDescontoProjeto'];
            $percentualDescontoProjeto = str_replace('.', ',', $percentualDescontoProjeto);

            $valorDescontoProjeto = $row['valorDescontoProjeto'];
            $valorDescontoProjeto = str_replace('.', ',', $valorDescontoProjeto);

            $valorProduto = $row['valorProduto'];
            $valorProduto = str_replace('.', ',', $valorProduto);

            $valorFuncionario = $row['valorFuncionario'];
            $valorFuncionario = str_replace('.', ',', $valorFuncionario);

            $valorEmpresa = $row['valorEmpresa'];
            $valorEmpresa = str_replace('.', ',', $valorEmpresa);

            $percentualDescontoPlanoSaude = $row['percentualDescontoPlanoSaude'];
            $percentualDescontoPlanoSaude = str_replace('.', ',', $percentualDescontoPlanoSaude);

            $valorDescontoPlanoSaude = $row['valorDescontoPlanoSaude'];
            $valorDescontoPlanoSaude = str_replace('.', ',', $valorDescontoPlanoSaude);

            $baseDescontoTitular = (float) $row['baseDesconto'];

            $contadorPlanoSaude = $contadorPlanoSaude + 1;
            $arrayPlanoSaude[] = array(
                "descricaoFuncionarioTitular" => $funcionarioPlanoSaude,
                "descricaoConvenioTitular" => $convenio,
                "descricaoProdutoTitular" => $produto,
                "cobrancaTitular" => $cobranca,
                "idadeTitular" => $idade,
                "descontoSindicatoTitular" => $percentualDescontoSindicato,
                "valorDescontoSindicatoTitular" => $valorDescontoSindicato,
                "descontoProjetoTitular" => $percentualDescontoProjeto,
                "valorDescontoProjetoTitular" => $valorDescontoProjeto,
                "valorProdutoTitular" => $valorProduto,
                "valorFuncionarioTitular" => $valorFuncionario,
                "valorEmpresaTitular" => $valorEmpresa,
                "sequencialPlanoSaude" => $contadorPlanoSaude,
                "baseDescontoPlanoSaudeTitular" => $baseDescontoTitular,
                "valorDescontoPlanoSaudeTitular" => $valorDescontoPlanoSaude,
                "percentualDescontoPlanoSaudeTitular" => $percentualDescontoPlanoSaude
            );
        }


        //----------------------Montando o array do Plane Saude Dependente

        $reposit = "";
        $result = "";
        $sql = "SELECT BP.codigo, BS.dependente, BS.convenio, BS.produto, BS.cobranca, BS.idade, 
        BS.percentualDescontoSindicato,
        BS.valorDescontoSindicato, BS.percentualDescontoProjeto, BS.valorDescontoProjeto, BS.valorProduto, BS.valorDependente, BS.valorEmpresa 
        FROM syscb.beneficioProjeto BP
        INNER JOIN syscb.beneficioProjetoPlanoSaudeDependente BS ON BP.codigo = BS.beneficioProjeto WHERE (0=0) AND BP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorPlanoSaudeDependente = 0;
        $arrayPlanoSaudeDependente = array();
        foreach($result as $row) {




            $dependentePlanoSaude = (int) $row['dependente'];
            $convenio = (int) $row['convenio'];
            $cobranca = (int) $row['cobranca'];
            $idade = (int) $row['idade'];

            $produto = (int) $row['produto'];
            $baseDescontoDependente = (float) $row['baseDesconto'];

            $percentualDescontoSindicato = $row['percentualDescontoSindicato'];
            $percentualDescontoSindicato = str_replace('.', ',', $percentualDescontoSindicato);

            $valorDescontoSindicato = $row['valorDescontoSindicato'];
            $valorDescontoSindicato = str_replace('.', ',', $valorDescontoSindicato);

            $percentualDescontoProjeto = $row['percentualDescontoProjeto'];
            $percentualDescontoProjeto = str_replace('.', ',', $percentualDescontoProjeto);

            $valorDescontoProjeto = $row['valorDescontoProjeto'];
            $valorDescontoProjeto = str_replace('.', ',', $valorDescontoProjeto);

            $valorProduto = $row['valorProduto'];
            $valorProduto = str_replace('.', ',', $valorProduto);

            $valorDependente = $row['valorDependente'];
            $valorDependente = str_replace('.', ',', $valorDependente);

            $valorEmpresa = $row['valorEmpresa'];
            $valorEmpresa = str_replace('.', ',', $valorEmpresa);




            $contadorPlanoSaudeDependente = $contadorPlanoSaudeDependente + 1;
            $arrayPlanoSaudeDependente[] = array(
                "descricaoNomeDependente" => $dependentePlanoSaude,
                "descricaoConvenioDependente" => $convenio,
                "descricaoProdutoDependente" => $produto,
                "cobrancaDependente" => $cobranca,
                "idadeDependente" => $idade,
                "descontoSindicatoDependente" => $percentualDescontoSindicato,
                "valorDescontoSindicatoDependente" => $valorDescontoSindicato,
                "descontoProjetoDependente" => $percentualDescontoProjeto,
                "valorDescontoProjetoDependente" => $valorDescontoProjeto,
                "valorProdutoDependente" => $valorProduto,
                "valorDependente" => $valorDependente,
                "valorEmpresaDependente" => $valorEmpresa,
                "sequencialPlanoSaudeDependente" => $contadorPlanoSaudeDependente,
                "baseDescontoPlanoSaudeDependente" => $baseDescontoDependente

            );
        }


        $strArrayPlanoSaudeDependente = json_encode($arrayPlanoSaudeDependente);


        //----------------------Montando o array do VT

        $reposit = "";
        $result = "";
        $sql = "SELECT BP.codigo, BT.tipoDesconto, BT.transporte, BT.tipoVale, BT.trajeto, BT.valorTotal, BT.observacao, BT.trajetoIdaVolta FROM syscb.beneficioProjeto BP
        INNER JOIN syscb.beneficioProjetoVT BT ON BP.codigo = BT.beneficioProjeto WHERE BP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorVT = 0;
        $arrayVT = array();
        foreach($result as $row) {

            $beneficioProjetoId = $row['beneficioProjeto'];
            $trajetoIdaVolta = (int) $row['trajetoIdaVolta'];
            $tipoDesconto = (int) $row['tipoDesconto'];
            if ($tipoDesconto == 1) {
                $descricaoTipoDesconto = "Conforme a lei";
            } else if ($tipoDesconto == 2) {
                $descricaoTipoDesconto = "Real utilização";
            } else if ($tipoDesconto == 3) {
                $descricaoTipoDesconto = "Nenhum";
            }


            $tipoVale = (int) $row['tipoVale']; //
            if ($tipoVale == 0) {
                $descricaoTipoVale = "Modal";
            } else if ($tipoVale == 1) {
                $descricaoTipoVale = "Unitário";
            }
            $trajeto = (int) $row['trajeto']; //
            if ($trajeto == 1) {
                $descricaoTrajeto =  "Ida";
            } else if ($trajeto == 2) {
                $descricaoTrajeto = "Volta";
            } else if ($trajeto == 3) {
                $descricaoTrajeto = "Ida e Volta";
            }

            if($trajetoIdaVolta !== 1){
                $valorTotalVT = $row['valorTotal'];
                $valorTotalVT = str_replace('.', ',', $valorTotalVT);                
            }else{
                $valorTotalVT = ($row['valorTotal']) / 2;
                $valorTotalVT = str_replace('.', ',', $valorTotalVT);       
            }

            $observacaoVT = $row['observacao'];
            $codigoVT = (int) $row['transporte'];



            if ($descricaoTipoVale == "Modal") {

                $sql = "SELECT codigo, descricao FROM syscb.valeTransporteModal WHERE codigo =  " . $codigoVT;
                $reposit = new reposit();
                $result2 = $reposit->RunQuery($sql);
                if($row = $result2[0]) {

                    $descricaoVT = $row['descricao'];
                }
            } else {

                $sql = "SELECT codigo, descricao FROM syscb.valeTransporteUnitario WHERE codigo =  " . $codigoVT;
                $reposit = new reposit();
                $result2 = $reposit->RunQuery($sql);
                if($row = $result2[0]) {

                    $descricaoVT = $row['descricao'];
                }
            }

            //Verifica se o vale transporte é ida e volta

            $contadorVT = $contadorVT + 1;
            $arrayVT[] = array(
                "sequencialValeTransporte" => $contadorVT,
                "descricaoTipoDesconto" => $descricaoTipoDesconto,
                "descricaoTipoVale" => $descricaoTipoVale,
                "descricaoVT" => $descricaoVT,
                "descricaoTrajeto" => $descricaoTrajeto,
                "valorPassagem" => $valorTotalVT,
                "valorTotalVT" => $valorTotalVT,

                "observacaoVT" => $observacaoVT,
                "tipoDesconto" => $tipoDesconto,
                "tipoVale" => $tipoVale,
                "valeTransporte" => $codigoVT,
                "trajetoVT" => $trajeto
            );
        }


        $strArrayVT = json_encode($arrayVT);

        //----------------------Montando o array do Beneficio Direto

        $reposit = "";
        $result = "";
        $sql = "SELECT BP.codigo, BD.beneficio, BD.valorBeneficioFuncionario, BD.valorAcrescimo, BD.valorAbater, BD.valorFinalBeneficio 
        FROM syscb.beneficioProjeto BP INNER JOIN syscb.beneficioProjetoBeneficioIndireto BD ON BP.codigo = BD.beneficioProjeto WHERE BP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorBeneficioDireto = 0;
        $arrayBeneficioIndireto = array();
        foreach($result as $row) {



            $valorBeneficioFuncionario = $row['valorBeneficioFuncionario'];
            $valorBeneficioFuncionario = str_replace('.', ',', $valorBeneficioFuncionario);

            $valorAcrescimo = $row['valorAcrescimo'];
            $valorAcrescimo = str_replace('.', ',', $valorAcrescimo);

            $valorAbater = $row['valorAbater'];
            $valorAbater = str_replace('.', ',', $valorAbater);

            $valorFinalBeneficio = $row['valorFinalBeneficio'];
            $valorFinalBeneficio = str_replace('.', ',', $valorFinalBeneficio);

            $beneficio = (int) $row['beneficio']; //
            



            $contadorBeneficioDireto = $contadorBeneficioDireto + 1;
            $arrayBeneficioIndireto[] = array(
                "sequencialBeneficioIndireto" => $contadorBeneficioDireto,
                "beneficioIndireto" => $beneficio,
                "descricaoBeneficio" => $beneficio,
                "valorBeneficioFuncionario" => $valorBeneficioFuncionario,
                "valorAcrescimo" => $valorAcrescimo,
                "valorAbater" => $valorAbater,
                "valorFinalBeneficio" => $valorFinalBeneficio

            );
        }


        $strArrayBeneficioIndireto = json_encode($arrayBeneficioIndireto);

   
}

function validaNumeroRecupera($value)
{
    $aux = $value;
    $aux = str_replace('.', ',', $aux);
    if (!$aux) {
        $aux = 0;
    }
    return $aux;
}


require_once('fpdf/fpdf.php');

class PDF extends FPDF {

    function Header() {
        global $codigo;

//        if ($nomeLogoRelatorio != "")
//        $this->SetFont('Arial', '', 8); #Seta a Fonte
//        $dataAux = new DateTime();
//        $dataAux->setTimezone(new DateTimeZone("GMT-3"));
//        $dataAtualizada = $dataAux->format('d/m/Y H:i:s');
//        $this->Cell(288, 0, $dataAtualizada, 0, 0, 'R', 0); #Título do Relatório
        $this->Cell(116, 1, "", 0, 1, 'C', 0); #Título do Relatório
        $this->Image('img/logo.png', 10, 5, 20, 20); #logo da empresa
        $this->SetXY(190, 5);
        $this->SetFont('Arial', 'B', 8); #Seta a Fonte
        $this->Cell(20, 5, 'Pagina ' . $this->pageno()); #Imprime o Número das Páginas
       
        $this->Ln(11); #Quebra de Linhas
        $this->Ln(10);
    }

    function Footer() {
//        $dataAux = new DateTime();
//        $dataAtualizada = $dataAux->format('d/m/Y H:i:s');
//
//        $this->AliasNbPages(); #Método de Numerar Páginas
//        $this->Line(5, 280, 205, 280); #Linha na horizontal
//        $this->SetFont('Arial', 'BI', 8); #Seta a Fonte
//
//        $this->SetXY(5, 250); #Tavo o cursor para escrever no Ponto Y
//        $this->Line(5, 250, 205, 250); #Linha na Horizontal
//        $descricaoRodape = iconv('UTF-8', 'windows-1252', " Atesto que os serviços de assistência técnica foram prestados satisfatoriamente. ");
//        $this->Cell(120, 5, $descricaoRodape, 0, 1, 'L', 0); #Frase de Rodapé
//
//
//        $this->SetXY(5, 265); #Tavo o cursor para escrever no Ponto Y
//        $this->Line(5, 265, 90, 265); #Linha na Horizontal
//        $descricaoRodape = iconv('UTF-8', 'windows-1252', " Responsável pelo atendimento. ");
//        $this->Cell(85, 5, $descricaoRodape, 0, 1, 'C', 0); #Frase de Rodapé
//        $this->SetFont('Arial', '', 8); #Seta a Fonte
//        $descricaoRodape = iconv('UTF-8', 'windows-1252', $nomeColaborador . ".");
//        $this->Cell(85, 5, $descricaoRodape, 0, 1, 'C', 0); #Frase de Rodapé
//
//        $this->SetFont('Arial', 'BI', 8); #Seta a Fonte
//        $this->SetXY(110, 265); #Tavo o cursor para escrever no Ponto Y
//        $this->Line(105, 265, 205, 265); #Linha na Horizontal
//        $descricaoRodape = iconv('UTF-8', 'windows-1252', " Assinatura do Cliente. ");
//        $this->Cell(85, 5, $descricaoRodape, 0, 1, 'C', 0); #Frase de Rodapé
//
//        $this->SetFont('Arial', '', 8); #Seta a Fonte
//        $this->SetXY(50, 280); #Tavo o cursor para escrever no Ponto Y
//        $descricaoRodape = iconv('UTF-8', 'windows-1252', " Av. das Américas, 500 (Downtown) bl.06 cob.301. Barra da Tijuca - RJ. RJ CEP. 22640-100. Tel.(21) 2491-7990 Fax (21) 2491-7776 ");
//        $this->Cell(85, 5, $descricaoRodape, 0, 1, 'C', 0); #Frase de Rodapé

        $this->SetY(202);
    }

}

$pdf = new PDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
$pdf->SetMargins(5, 10, 5); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->AddPage();

//$pdf->SetFont('Arial','',10);
//$pdf->SetLeftMargin(10);








$pdf->SetY(35);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "PROJETO"), 0, 0, "L", 0);
$pdf->Ln(8);
$pdf->Line(5, 41, 205, 41); #Linha na Horizontal
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22, 5, iconv('UTF-8', 'windows-1252', "Funcionário :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(93, 5, iconv('UTF-8', 'windows-1252', $funcionario), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Projeto :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $projeto), 0, 0, "L", 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', "Salário funcionário :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $salarioFuncionario), 0, 0, "L", 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Sigla sindicato :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(90, 5, iconv('UTF-8', 'windows-1252', $sindicatoSigla), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', "Descrição sindicato :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $sindicato), 0, 0, "L", 0);

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "PRODUTO PLANO DE SAÚDE"), 0, 0, "L", 0);
$linha = $pdf->Ultimalinha();
$pdf->Ln(6);
$pdf->Line(5, $linha + 2, 205, $linha + 2); #Linha na Horizontal
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln();


$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', "Titular"), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', 'Idade'), 1, 0, "C", true);
$pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', 'Convênio'), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', 'Produto'), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', 'Valor Funcionário'), 1, 0, "C", true);
$pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', 'Valor Empresa'), 1, 0, "C", true);

$pdf->Ln();

$pdf->SetFont('Arial', '', 8);
$contador = 0;
foreach ($arrayPlanoSaude as $key) {

    $contador = $contador + 1;
    $funcionarioPlanoSaude =iconv('UTF-8', 'windows-1252', $funcionarioPlanoSaude); 
    $convenio = iconv('UTF-8', 'windows-1252', $convenio); 
    $produto = iconv('UTF-8', 'windows-1252', $produto); 
    $valorFuncionarioTitular = $key["valorFuncionarioTitular"];
    $idade = $key["idadeTitular"];
    $valorEmpresaTitular = $key["valorEmpresaTitular"];
    $valorEmpresaTitularTemp = str_replace(',', '.', $valorEmpresaTitular);
    $totalEmpresaTitular = floatval($totalVT) + floatval($valorEmpresaTitularTemp);
    $valorFuncionarioTitularTemp = str_replace(',', '.', $valorFuncionarioTitular);
    $totalFuncionarioTitular = floatval($totalVT) + floatval($valorFuncionarioTitularTemp);



    $pdf->SetWidths(array(30, 30, 40, 30, 30, 40));
    $pdf->Row(array($funcionarioPlanoSaude, $idade, $convenio, $produto, $valorFuncionarioTitular,$valorEmpresaTitular,
    ));
}
$pdf->Ln(2);
$pdf->SetX(120);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Total Funcionário:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', number_format($totalFuncionarioTitular, 5)), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Total Empresa:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', number_format($totalEmpresaTitular, 5)), 0, 0, "L", 0);


$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "VA e VR"), 0, 0, "L", 0);
$linha = $pdf->Ultimalinha();
$pdf->Ln(6);
$pdf->Line(5, $linha + 2, 205, $linha + 2); #Linha na Horizontal
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Valor diário :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', $valorDiarioFuncionarioVAVR), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Valor Mensal :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', $valorMensalFuncionarioVAVR), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', "Desconto em Folha :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $percentualDescontoFolhaFuncionarioVAVR), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', "Valor Desconto :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $valorDescontoFolhaFuncionarioVAVR), 0, 0, "L", 0);

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Cesta Básica"), 0, 0, "L", 0);
$linha = $pdf->Ultimalinha();
$pdf->Ln(6);
$pdf->Line(5, $linha + 2, 205, $linha + 2); #Linha na Horizontal
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Valor Mensal :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', $valorMensalSindicatoCestaBasica), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', "Desconto Sindicato :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $percentualDescontoSindicatoCestaBasica), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 5, iconv('UTF-8', 'windows-1252', "Valor Desconto Sindicato :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $valorDescontoSindicatoCestaBasica), 0, 0, "L", 0);
// $pdf->Line(5, 48, 292, 48); #Linha na Horizontal
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Vale Transporte"), 0, 0, "L", 0);
$linha = $pdf->Ultimalinha();
$pdf->Ln(6);
$pdf->Line(5, $linha + 2, 205, $linha + 2); #Linha na Horizontal
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln();

$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', "Tipo Desconto"), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', 'Tipo Vale'), 1, 0, "C", true);
$pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', 'Transporte'), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', 'Trajeto'), 1, 0, "C", true);
$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', 'Valor'), 1, 0, "C", true);
$pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', 'Observação'), 1, 0, "C", true);

$pdf->Ln();

$pdf->SetFont('Arial', '', 8);
$contador = 0;
foreach ($arrayVT as $key) {

    $contador = $contador + 1;
    $descricaoTipoDesconto = $key["descricaoTipoDesconto"];
    $descricaoTipoDesconto = iconv('UTF-8', 'windows-1252', $descricaoTipoDesconto);
    $descricaoTipoVale = $key["descricaoTipoVale"];
    $descricaoTipoVale = iconv('UTF-8', 'windows-1252', $descricaoTipoVale);
    $descricaoVT = $key["descricaoVT"];
    $descricaoVT = iconv('UTF-8', 'windows-1252', $descricaoVT);
    $descricaoTrajeto = $key["descricaoTrajeto"];
    $descricaoTrajeto = iconv('UTF-8', 'windows-1252', $descricaoTrajeto);
    $valorPassagem = $key["valorPassagem"];
    $observacaoVT = iconv('UTF-8', 'windows-1252', $observacaoVT);
    $valorPassagemTemp = str_replace(',', '.', $valorPassagem);
    $totalVT = floatval($totalVT) + floatval($valorPassagemTemp);


    $pdf->SetWidths(array(30, 30, 40, 30, 30, 40));
    $pdf->Row(array($descricaoTipoDesconto, $descricaoTipoVale, $descricaoVT, $descricaoTrajeto, $valorPassagem,
        $observacaoVT
    ));
}
$pdf->Ln(2);
$pdf->SetX(170);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Valor Total:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', number_format($totalVT, 5)), 0, 0, "L", 0);

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Benefício Indireto"), 0, 0, "L", 0);
$linha = $pdf->Ultimalinha();
$pdf->Ln(6);
$pdf->Line(5, $linha + 2, 205, $linha + 2); #Linha na Horizontal
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln();

$pdf->Cell(39, 10, iconv('UTF-8', 'windows-1252', "Benefício"), 1, 0, "C", true);
$pdf->Cell(47, 10, iconv('UTF-8', 'windows-1252', 'Valor Benefício Funcionário'), 1, 0, "C", true);
$pdf->Cell(37, 10, iconv('UTF-8', 'windows-1252', 'Valor Acrécimo'), 1, 0, "C", true);
$pdf->Cell(37, 10, iconv('UTF-8', 'windows-1252', 'Valor a Abater'), 1, 0, "C", true);
$pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', 'Valor Final Beneficio'), 1, 0, "C", true);

$pdf->Ln();

$pdf->SetFont('Arial', '', 8);
$contador = 0;
foreach ($arrayBeneficioIndireto as $key) {

    $contador = $contador + 1;
    $descricaoBeneficio = $key["descricaoBeneficio"];
    if($descricaoBeneficio == '1'){
        $descricaoBeneficio = "VA e VR";
    }else if($descricaoBeneficio == '3'){
        $descricaoBeneficio = iconv('UTF-8', 'windows-1252', "Plano Saúde");
    }else {
        $descricaoBeneficio = "";
    }

    $valorBeneficioFuncionario = $key["valorBeneficioFuncionario"];
    $valorBeneficioFuncionario = iconv('UTF-8', 'windows-1252', $valorBeneficioFuncionario);
    $valorAcrescimo = $key["valorAcrescimo"];
    $valorAcrescimo = iconv('UTF-8', 'windows-1252', $valorAcrescimo);
    $valorAbater = $key["valorAbater"];
    $valorAbater = iconv('UTF-8', 'windows-1252', $valorAbater);
    $valorFinalBeneficio = $key["valorFinalBeneficio"];
    $valorFinalBeneficio = iconv('UTF-8', 'windows-1252', $valorFinalBeneficio);
    $valorFinalBeneficioTemp = str_replace(',', '.', $valorFinalBeneficio);
    $totalFinalBeneficio = floatval($totalVT) + floatval($valorFinalBeneficioTemp);


    $pdf->SetWidths(array(39,47,37,37,40));
    $pdf->Row(array($descricaoBeneficio, $valorBeneficioFuncionario, $valorAcrescimo, $valorAbater, $valorFinalBeneficio
    ));
}
$pdf->Ln(2);
$pdf->SetX(170);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Total Benefício:"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', number_format($totalFinalBeneficio, 5)), 0, 0, "L", 0);

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Dias Utéis"), 0, 0, "L", 0);
$linha = $pdf->Ultimalinha();
$pdf->Ln(6);
$pdf->Line(5, $linha + 2, 205, $linha + 2); #Linha na Horizontal

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(95, 5, iconv('UTF-8', 'windows-1252', "VA/VR :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', "Vale Trasporte :"), 0, 0, "L", 0);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Janeiro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilJaneiro), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Julho :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilJulho), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Janeiro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilJaneiroVT), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Julho :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilJulhoVT), 0, 0, "L", 0);
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Fevereiro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilFevereiro), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Agosto :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilAgosto), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Fevereiro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilFevereiroVT), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Agosto :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilAgostoVT), 0, 0, "L", 0);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Março :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilMarco), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Setembro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $diaUtilSetembro), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Março :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilMarcoVT), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Setembro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilSetembroVT), 0, 0, "L", 0);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Abril :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilAbril), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Outubro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilOutubro), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Abril :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilAbrilVT), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Outubro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilOutubroVT), 0, 0, "L", 0);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Maio :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilMaio), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Novembro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $diaUtilNovembro), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "Maio :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilMaioVT), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Novembro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilNovembroVT), 0, 0, "L", 0);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "junho :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilJunho), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Dezembro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(25, 5, iconv('UTF-8', 'windows-1252', $diaUtilDezembro), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, iconv('UTF-8', 'windows-1252', "junho :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35, 5, iconv('UTF-8', 'windows-1252', $diaUtilJunhoVT), 0, 0, "L", 0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, iconv('UTF-8', 'windows-1252', "Dezembro :"), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 5, iconv('UTF-8', 'windows-1252', $diaUtilDezembroVT), 0, 0, "L", 0);


$pdf->Output();
?>

