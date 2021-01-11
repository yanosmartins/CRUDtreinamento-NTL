<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Funcionário</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Diário</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Dias Uteis</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Faltas</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Ausência</th>
                    <th class="text-left" style="min-width:35px; color: red">Total Faltas & Ausências VAVR</th>
                    <th class="text-left" style="min-width:35px; color: violet">D. Uteis de Ferias</th>
                    <th class="text-left" style="min-width:35px; color: violet">D.Abater Afastamento</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Dias a Pagar</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Fixo</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Tipo</th>
                    <th class="text-left" style="min-width:70px; color: red;">VA/VR Extra</th>
                    <th class="text-left" style="min-width:35px; color: red;">VA/VR Total</th>
                    <th class="text-left" style="min-width:70px; color:blueviolet ;">VA/VR Bolsa Benef. Extra</th>
                    <th class="text-left" style="min-width:35px; color:blueviolet ;">VA/VR Bolsa Benef.</th>
                    <th class="text-left" style="min-width:70px; color: green;">CB. Extra</th>
                    <th class="text-left" style="min-width:35px; color: green;">Cesta Básica</th>
                    <th class="text-left" style="min-width:35px; color: blue;">PS Funcionário</th>
                    <th class="text-left" style="min-width:35px; color: blue;">PS Bolsa Beneficio</th>
                    <th class="text-left" style="min-width:35px; color: blue;">PS Total</th>
                    <th class="text-left" style="min-width:35px; color: darkorange;">VT Diário</th>
                    <th class="text-left" style="min-width:35px; color: darkorange">VT Dias Úteis</th>
                    <th class="text-left" style="min-width:35px; color: darkorange">VT Faltas</th>
                    <th class="text-left" style="min-width:35px; color: darkorange">VT Ausências</th>
                    <th class="text-left" style="min-width:35px; color: darkorange">VT Dias Trabalhados</th>
                    <th class="text-left" style="min-width:70px; color: darkorange"> VT Extra</th>
                    <th class="text-left" style="min-width:35px; color: darkorange">VT Mensal</th>



                </tr>
            </thead>
            <tbody>
                <?php


                $sql = "SELECT DISTINCT BP.funcionario, FU.nome, BP.codigo, 
                        BP.valorMensalFuncionarioVAVR, BP.valorDiarioFuncionarioVAVR, BP.tipoDescontoVAVR,
                        BP.valorCestaBasica, BP.valorTotalPlanoSaude, BP.tipoDiaUtilVAVR, BP.tipoDiaUtilVT, BP.sindicato,
                        BP.valorDiarioProjetoVAVR, BP.valorDiarioSindicatoVAVR, BP.valorDiarioFuncionarioVAVR, 
                        BP.valorMensalProjetoVAVR, 
                        BP.valorMensalSindicatoVAVR, BP.valorMensalFuncionarioVAVR, BP.tipoDiaUtilVT,
                        BP.perdaBeneficio, BP.valorTotalFuncionarioVT,BP.municipioDiasUteisVAVR,BP.municipioDiasUteisVT,
                        
                        P.diaUtilJaneiroVAVR AS projetoDiaUtilJaneiroVAVR, P.diaUtilFevereiroVAVR AS projetoDiaUtilFevereiroVAVR, 
                        P.diaUtilMarcoVAVR AS projetoDiaUtilMarcoVAVR, P.diaUtilAbrilVAVR AS projetoDiaUtilAbrilVAVR, 
                        P.diaUtilMaioVAVR AS projetoDiaUtilMaioVAVR, P.diaUtilJunhoVAVR AS projetoDiaUtilJunhoVAVR, 
                        P.diaUtilJulhoVAVR AS projetoDiaUtilJulhoVAVR, P.diaUtilAgostoVAVR AS projetoDiaUtilAgostoVAVR, 
                        P.diaUtilSetembroVAVR AS projetoDiaUtilSetembroVAVR, P.diaUtilOutubroVAVR AS projetoDiaUtilOutubroVAVR, 
                        P.diaUtilNovembroVAVR AS projetoDiaUtilNovembroVAVR, P.diaUtilDezembroVAVR AS projetoDiaUtilDezembroVAVR,
                        
                        P.diaUtilJaneiroVT AS projetoDiaUtilJaneiroVT, P.diaUtilFevereiroVT AS projetoDiaUtilFevereiroVT, 
                        P.diaUtilMarcoVT AS projetoDiaUtilMarcoVT, P.diaUtilAbrilVT AS projetoDiaUtilAbrilVT, 
                        P.diaUtilMaioVT AS projetoDiaUtilMaioVT, P.diaUtilJunhoVT AS projetoDiaUtilJunhoVT, 
                        P.diaUtilJulhoVT AS projetoDiaUtilJulhoVT, P.diaUtilAgostoVT AS projetoDiaUtilAgostoVT, 
                        P.diaUtilSetembroVT AS projetoDiaUtilSetembroVT, P.diaUtilOutubroVT AS projetoDiaUtilOutubroVT, 
                        P.diaUtilNovembroVT AS projetoDiaUtilNovembroVT, P.diaUtilDezembroVT AS projetoDiaUtilDezembroVT,
                        
                        S.diaUtilJaneiroVAVR AS sindicatoDiaUtilJaneiroVAVR , S.diaUtilFevereiroVAVR AS sindicatoDiaUtilFevereiroVAVR, 
                        S.diaUtilMarcoVAVR AS sindicatoDiaUtilMarcoVAVR, S.diaUtilAbrilVAVR AS sindicatoDiaUtilAbrilVAVR, 
                        S.diaUtilMaioVAVR AS sindicatoDiaUtilMaioVAVR,S.diaUtilJunhoVAVR AS sindicatoDiaUtilJunhoVAVR,
                        S.diaUtilJulhoVAVR AS sindicatoDiaUtilJulhoVAVR, S.diaUtilAgostoVAVR AS sindicatoDiaUtilAgostoVAVR, 
                        S.diaUtilSetembroVAVR AS sindicatoDiaUtilSetembroVAVR, S.diaUtilOutubroVAVR AS sindicatoDiaUtilOutubroVAVR, 
                        S.diaUtilNovembroVAVR AS sindicatoDiaUtilNovembroVAVR, S.diaUtilDezembroVAVR AS sindicatoDiaUtilDezembroVAVR,
                        
                        S.diaUtilJaneiroVT AS sindicatoDiaUtilJaneiroVT , S.diaUtilFevereiroVT AS sindicatoDiaUtilFevereiroVT, 
                        S.diaUtilMarcoVT AS sindicatoDiaUtilMarcoVT, S.diaUtilAbrilVT AS sindicatoDiaUtilAbrilVT, 
                        S.diaUtilMaioVT AS sindicatoDiaUtilMaioVT,S.diaUtilJunhoVT AS sindicatoDiaUtilJunhoVT,
                        S.diaUtilJulhoVT AS sindicatoDiaUtilJulhoVT, S.diaUtilAgostoVT AS sindicatoDiaUtilAgostoVT, 
                        S.diaUtilSetembroVT AS sindicatoDiaUtilSetembroVT, S.diaUtilOutubroVT AS sindicatoDiaUtilOutubroVT, 
                        S.diaUtilNovembroVT AS sindicatoDiaUtilNovembroVT, S.diaUtilDezembroVT AS sindicatoDiaUtilDezembroVT,
                        
                        BP.diaUtilJaneiroVAVR AS beneficioProjetoDiaUtilJaneiroVAVR,BP.diaUtilFevereiroVAVR AS beneficioProjetoDiaUtilFevereiroVAVR, 
                        BP.diaUtilMarcoVAVR AS beneficioProjetoDiaUtilMarcoVAVR,BP.diaUtilAbrilVAVR AS beneficioProjetoDiaUtilAbrilVAVRVAVR, 
                        BP.diaUtilMaioVAVR AS beneficioProjetoDiaUtilMaioVAVR,BP.diaUtilJunhoVAVR AS beneficioProjetoDiaUtilJunhoVAVR, 
                        BP.diaUtilJulhoVAVR AS beneficioProjetoDiaUtilJulhoVAVR,BP.diaUtilAgostoVAVR AS beneficioProjetoDiaUtilAgostoVAVR, 
                        BP.diaUtilSetembroVAVR AS beneficioProjetoDiaUtilSetembroVAVR, BP.diaUtilOutubroVAVR AS beneficioProjetoDiaUtilOutubroVAVR, 
                        BP.diaUtilNovembroVAVR AS beneficioProjetoDiaUtilNovembroVAVR, BP.diaUtilDezembroVAVR AS beneficioProjetoDiaUtilDezembroVAVR,
                        
                        BP.diaUtilJaneiroVT AS beneficioProjetoDiaUtilJaneiroVT,BP.diaUtilFevereiroVT AS beneficioProjetoDiaUtilFevereiroVT, 
                        BP.diaUtilMarcoVT AS beneficioProjetoDiaUtilMarcoVT,BP.diaUtilAbrilVT AS beneficioProjetoDiaUtilAbrilVTVT, 
                        BP.diaUtilMaioVT AS beneficioProjetoDiaUtilMaioVT,BP.diaUtilJunhoVT AS beneficioProjetoDiaUtilJunhoVT, 
                        BP.diaUtilJulhoVT AS beneficioProjetoDiaUtilJulhoVT,BP.diaUtilAgostoVT AS beneficioProjetoDiaUtilAgostoVT, 
                        BP.diaUtilSetembroVT AS beneficioProjetoDiaUtilSetembroVT, BP.diaUtilOutubroVT AS beneficioProjetoDiaUtilOutubroVT, 
                        BP.diaUtilNovembroVT AS beneficioProjetoDiaUtilNovembroVT, BP.diaUtilDezembroVT AS beneficioProjetoDiaUtilDezembroVT,

                        DMVAVR.quantidadeDiaJaneiro AS beneficioMunicipioDiaUtilVAVRJaneiro, DMVAVR.quantidadeDiaFevereiro AS beneficioMunicipioDiaUtilVAVRFevereiro, 
                        DMVAVR.quantidadeDiaMarco AS beneficioMunicipioDiaUtilVAVRMarco, DMVAVR.quantidadeDiaAbril AS beneficioMunicipioDiaUtilVAVRAbril, 
                        DMVAVR.quantidadeDiaMaio AS beneficioMunicipioDiaUtilVAVRMaio, DMVAVR.quantidadeDiaJunho AS beneficioMunicipioDiaUtilVAVRJunho, 
                        DMVAVR.quantidadeDiaJulho AS beneficioMunicipioDiaUtilVAVRJulho, DMVAVR.quantidadeDiaAgosto AS beneficioMunicipioDiaUtilVAVRAgosto, 
                        DMVAVR.quantidadeDiaSetembro AS beneficioMunicipioDiaUtilVAVRSetembro,  DMVAVR.quantidadeDiaOutubro AS beneficioMunicipioDiaUtilVAVROutubro, 
                        DMVAVR.quantidadeDiaNovembro AS beneficioMunicipioDiaUtilVAVRNovembro,  DMVAVR.quantidadeDiaDezembro AS beneficioMunicipioDiaUtilVAVRDezembro,
                
                    
                        DMVT.quantidadeDiaJaneiro AS beneficioMunicipioDiaUtilVTJaneiro, DMVT.quantidadeDiaFevereiro AS beneficioMunicipioDiaUtilVTFevereiro, 
                        DMVT.quantidadeDiaMarco AS beneficioMunicipioDiaUtilVTMarco, DMVT.quantidadeDiaAbril AS beneficioMunicipioDiaUtilVTAbril, 
                        DMVT.quantidadeDiaMaio AS beneficioMunicipioDiaUtilVTMaio, DMVT.quantidadeDiaJunho AS beneficioMunicipioDiaUtilVTJunho, 
                        DMVT.quantidadeDiaJulho AS beneficioMunicipioDiaUtilVTJulho, DMVT.quantidadeDiaAgosto AS beneficioMunicipioDiaUtilVTAgosto, 
                        DMVT.quantidadeDiaSetembro AS beneficioMunicipioDiaUtilVTSetembro,  DMVT.quantidadeDiaOutubro AS beneficioMunicipioDiaUtilVTOutubro, 
                        DMVT.quantidadeDiaNovembro AS beneficioMunicipioDiaUtilVTNovembro,  DMVT.quantidadeDiaDezembro AS beneficioMunicipioDiaUtilVTDezembro,
                    
                        DMF.quantidadeDiaJaneiro AS feriasMunicipioDiaUtilJaneiro, DMF.quantidadeDiaFevereiro AS feriasMunicipioDiaUtilFevereiro, 
						DMF.quantidadeDiaMarco AS feriasMunicipioDiaUtilMarco, DMF.quantidadeDiaAbril AS feriasMunicipioDiaUtilAbril, 
						DMF.quantidadeDiaMaio AS feriasMunicipioDiaUtilMaio, DMF.quantidadeDiaJunho AS feriasMunicipioDiaUtilJunho, 
						DMF.quantidadeDiaJulho AS feriasMunicipioDiaUtilJulho, DMF.quantidadeDiaAgosto AS feriasMunicipioDiaUtilAgosto, 
						DMF.quantidadeDiaSetembro AS feriasMunicipioDiaUtilSetembro,  DMF.quantidadeDiaOutubro AS feriasMunicipioDiaUtilOutubro, 
						DMF.quantidadeDiaNovembro AS feriasMunicipioDiaUtilNovembro,  DMF.quantidadeDiaDezembro AS feriasMunicipioDiaUtilDezembro,

                        BP.totalValorAcrescimoBeneficioIndireto,BP.totalValorAbaterBeneficioIndireto,BP.municipioFerias,S.descontoFeriasRefeicao AS sindicatoDescontaFerias,
                        S.descontarFeriasCestaBasica as sindicatoDescontaCestaBasicaFerias,S.descontoValeRefeicao AS sindicatoDescontoVAVR,
                        P.descontoVAVR AS projetoDescontoVAVR, P.descontoFeriasVAVR AS projetoDescontaFerias, BP.escalaFerias, BP.escalaFeriasVAVR
                        
                        FROM Ntl.beneficioProjeto BP 
                        INNER JOIN Ntl.funcionario FU ON BP.funcionario = FU.codigo 
                        LEFT JOIN Ntl.projeto P ON BP.projeto = P.codigo
                        LEFT JOIN Ntl.sindicato S ON S.codigo = BP.sindicato
                        LEFT JOIN Ntl.diasUteisPorMunicipio DMVAVR ON DMVAVR.municipio = BP.municipioDiasUteisVAVR and DMVAVR.ativo = 1
                        LEFT JOIN Ntl.diasUteisPorMunicipio DMVT ON DMVT.municipio = BP.municipioDiasUteisVT and DMVT.ativo = 1
                        LEFT JOIN Ntl.diasUteisPorMunicipio DMF ON DMF.municipio = BP.municipioFerias and DMF.ativo = 1
                        WHERE (0=0) AND BP.tipoDescontoVAVR IS NOT NULL AND BP.ativo = 1 AND FU.dataDemissaoFuncionario IS NULL ";

                if ($_GET['funcionarioFiltro'] != "") {
                    $funcionario = $_GET["funcionarioFiltro"];
                    $where = $where . " and BP.funcionario = " . $funcionario;
                }


                if ($_GET["projetoFiltro"] != "") {
                    $projetoFiltro = $_GET["projetoFiltro"];
                    $where = $where . " and  BP.projeto = " . $projetoFiltro;
                }


                $sql .= $where;
                $reposit = new reposit();
                $result1 = $reposit->RunQuery($sql);
                $mesAno = $_GET["data"];

                $mes = explode("/", $mesAno);
                $mes = +$mes[0];

                $value = explode("/", $mesAno);
                $mesAno = "'" . $value[1] . "-" . $value[0] . "-" . "01 00:0:00'";

                while (($row = odbc_fetch_array($result1))) {
                    $row = array_map('utf8_encode', $row);
                    $id = +$row['codigo'];
                    $funcionario = $row['nome'];
                    $funcionarioCodigo = +$row['funcionario'];
                    $tipoDiaUtilVAVR = +$row['tipoDiaUtilVAVR'];
                    $sindicato = +$row['sindicato'];
                    $projeto = +$row['projeto'];
                    $tipoDiaUtilVT = +$row['tipoDiaUtilVT'];
                    $perdaBeneficio = +$row['perdaBeneficio'];
                    $valorTotalFuncionarioVT = +$row['valorTotalFuncionarioVT'];
                    $valorCestaBasica = +$row['valorCestaBasica'];
                    $valorTotalPlanoSaude = +$row['valorTotalPlanoSaude'];
                    $trajetoIdaVoltaVT = +$row['trajetoIdaVolta'];
                    $valorDiarioVT = +$row['valorTotalVTDiario'];
                    $totalValorAcrescimoBeneficioIndireto = +$row['totalValorAcrescimoBeneficioIndireto'];
                    $totalValorAbaterBeneficioIndireto = +$row['totalValorAbaterBeneficioIndireto'];
                    $municipioDiasUteisVAVR = +$row['municipioDiasUteisVAVR'];
                    $municipioDiasUteisVT = +$row['municipioDiasUteisVT'];

                    // $descontoFeriasAlimentacao = +$row['descontoFeriasAlimentacao']; // temporariamente desabilitado
                    // $descontoFeriasRefeicao = +$row['descontoFeriasRefeicao'];
                    $escalaFerias = +$row['escalaFerias'];
                    $escalaFeriasVAVR = +$row['escalaFeriasVAVR'];
                    // $descontarFeriasCestaBasica = +$row['descontarFeriasCestaBasica']; // discutir logica 

                    switch ($tipoDiaUtilVAVR) {
                            //Projeto
                        case 1:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVAVR = +$row['projetoDiaUtilJaneiroVAVR'];
                                    break;
                                case 2:
                                    $diaUtilVAVR = +$row['projetoDiaUtilFevereiroVAVR'];
                                    break;
                                case 3:
                                    $diaUtilVAVR = +$row['projetoDiaUtilMarcoVAVR'];
                                    break;
                                case 4:
                                    $diaUtilVAVR = +$row['projetoDiaUtilAbrilVAVR'];
                                    break;
                                case 5:
                                    $diaUtilVAVR = +$row['projetoDiaUtilMaioVAVR'];
                                    break;
                                case 6:
                                    $diaUtilVAVR = +$row['projetoDiaUtilJunhoVAVR'];
                                    break;
                                case 7:
                                    $diaUtilVAVR = +$row['projetoDiaUtilJulhoVAVR'];
                                    break;
                                case 8:
                                    $diaUtilVAVR = +$row['projetoDiaUtilAgostoVAVR'];
                                    break;
                                case 9:
                                    $diaUtilVAVR = +$row['projetoDiaUtilSetembroVAVR'];
                                    break;
                                case 10:
                                    $diaUtilVAVR = +$row['projetoDiaUtilOutubroVAVR'];
                                    break;
                                case 11:
                                    $diaUtilVAVR = +$row['projetoDiaUtilNovembroVAVR'];
                                    break;
                                case 12:
                                    $diaUtilVAVR = +$row['projetoDiaUtilDezembroVAVR'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;

                            //Sindicato
                        case 2:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilJaneiroVAVR'];
                                    break;
                                case 2:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilFevereiroVAVR'];
                                    break;
                                case 3:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilMarcoVAVR'];
                                    break;
                                case 4:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilAbrilVAVR'];
                                    break;
                                case 5:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilMaioVAVR'];
                                    break;
                                case 6:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilJunhoVAVR'];
                                    break;
                                case 7:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilJulhoVAVR'];
                                    break;
                                case 8:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilAgostoVAVR'];
                                    break;
                                case 9:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilSetembroVAVR'];
                                    break;
                                case 10:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilOutubroVAVR'];
                                    break;
                                case 11:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilNovembroVAVR'];
                                    break;
                                case 12:
                                    $diaUtilVAVR = +$row['sindicatoDiaUtilDezembroVAVR'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;
                            //Funcionario
                        case 3:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilJaneiroVAVR'];
                                    break;
                                case 2:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilFevereiroVAVR'];
                                    break;
                                case 3:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilMarcoVAVR'];
                                    break;
                                case 4:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilAbrilVAVR'];
                                    break;
                                case 5:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilMaioVAVR'];
                                    break;
                                case 6:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilJunhoVAVR'];
                                    break;
                                case 7:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilJulhoVAVR'];
                                    break;
                                case 8:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilAgostoVAVR'];
                                    break;
                                case 9:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilSetembroVAVR'];
                                    break;
                                case 10:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilOutubroVAVR'];
                                    break;
                                case 11:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilNovembroVAVR'];
                                    break;
                                case 12:
                                    $diaUtilVAVR = +$row['beneficioProjetoDiaUtilDezembroVAVR'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;
                            //Mês Corrente
                        case 4:
                            $diaUtilVAVR = $row['diaProjetoVAVR'];
                            break;
                            break;
                            //Projeto
                        case 5:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRJaneiro'];
                                    break;
                                case 2:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRFevereiro'];
                                    break;
                                case 3:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRMarco'];
                                    break;
                                case 4:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRAbril'];
                                    break;
                                case 5:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRMaio'];
                                    break;
                                case 6:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRJunho'];
                                    break;
                                case 7:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRJulho'];
                                    break;
                                case 8:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRAgosto'];
                                    break;
                                case 9:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRSetembro'];
                                    break;
                                case 10:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVROutubro'];
                                    break;
                                case 11:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRNovembro'];
                                    break;
                                case 12:
                                    $diaUtilVAVR = +$row['beneficioMunicipioDiaUtilVAVRDezembro'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;
                        default:
                            # code...
                            break;
                    }

                    switch ($tipoDiaUtilVT) {
                            //Projeto
                        case 1:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVT = +$row['projetoDiaUtilJaneiroVT'];
                                    break;
                                case 2:
                                    $diaUtilVT = +$row['projetoDiaUtilFevereiroVT'];
                                    break;
                                case 3:
                                    $diaUtilVT = +$row['projetoDiaUtilMarcoVT'];
                                    break;
                                case 4:
                                    $diaUtilVT = +$row['projetoDiaUtilAbrilVT'];
                                    break;
                                case 5:
                                    $diaUtilVT = +$row['projetoDiaUtilMaioVT'];
                                    break;
                                case 6:
                                    $diaUtilVT = +$row['projetoDiaUtilJunhoVT'];
                                    break;
                                case 7:
                                    $diaUtilVT = +$row['projetoDiaUtilJulhoVT'];
                                    break;
                                case 8:
                                    $diaUtilVT = +$row['projetoDiaUtilAgostoVT'];
                                    break;
                                case 9:
                                    $diaUtilVT = +$row['projetoDiaUtilSetembroVT'];
                                    break;
                                case 10:
                                    $diaUtilVT = +$row['projetoDiaUtilOutubroVT'];
                                    break;
                                case 11:
                                    $diaUtilVT = +$row['projetoDiaUtilNovembroVT'];
                                    break;
                                case 12:
                                    $diaUtilVT = +$row['projetoDiaUtilDezembroVT'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;

                            //Sindicato
                        case 2:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVT = +$row['sindicatoDiaUtilJaneiroVT'];
                                    break;
                                case 2:
                                    $diaUtilVT = +$row['sindicatoDiaUtilFevereiroVT'];
                                    break;
                                case 3:
                                    $diaUtilVT = +$row['sindicatoDiaUtilMarcoVT'];
                                    break;
                                case 4:
                                    $diaUtilVT = +$row['sindicatoDiaUtilAbrilVT'];
                                    break;
                                case 5:
                                    $diaUtilVT = +$row['sindicatoDiaUtilMaioVT'];
                                    break;
                                case 6:
                                    $diaUtilVT = +$row['sindicatoDiaUtilJunhoVT'];
                                    break;
                                case 7:
                                    $diaUtilVT = +$row['sindicatoDiaUtilJulhoVT'];
                                    break;
                                case 8:
                                    $diaUtilVT = +$row['sindicatoDiaUtilAgostoVT'];
                                    break;
                                case 9:
                                    $diaUtilVT = +$row['sindicatoDiaUtilSetembroVT'];
                                    break;
                                case 10:
                                    $diaUtilVT = +$row['sindicatoDiaUtilOutubroVT'];
                                    break;
                                case 11:
                                    $diaUtilVT = +$row['sindicatoDiaUtilNovembroVT'];
                                    break;
                                case 12:
                                    $diaUtilVT = +$row['sindicatoDiaUtilDezembroVT'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;

                            //Funcionario
                        case 3:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilJaneiroVT'];
                                    break;
                                case 2:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilFevereiroVT'];
                                    break;
                                case 3:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilMarcoVT'];
                                    break;
                                case 4:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilAbrilVT'];
                                    break;
                                case 5:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilMaioVT'];
                                    break;
                                case 6:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilJunhoVT'];
                                    break;
                                case 7:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilJulhoVT'];
                                    break;
                                case 8:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilAgostoVT'];
                                    break;
                                case 9:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilSetembroVT'];
                                    break;
                                case 10:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilOutubroVT'];
                                    break;
                                case 11:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilNovembroVT'];
                                    break;
                                case 12:
                                    $diaUtilVT = +$row['beneficioProjetoDiaUtilDezembroVT'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;
                            //Mês Corrente
                        case 4:
                            $diaUtilVT = $row['diaProjetoVT'];
                            break;


                            // Por municipio
                        case 5:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTJaneiro'];
                                    break;
                                case 2:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTFevereiro'];
                                    break;
                                case 3:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTMarco'];
                                    break;
                                case 4:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTAbril'];
                                    break;
                                case 5:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTMaio'];
                                    break;
                                case 6:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTJunho'];
                                    break;
                                case 7:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTJulho'];
                                    break;
                                case 8:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTAgosto'];
                                    break;
                                case 9:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTSetembro'];
                                    break;
                                case 10:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTOutubro'];
                                    break;
                                case 11:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTNovembro'];
                                    break;
                                case 12:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTDezembro'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;

                        default:
                            # code...
                            break;
                    }

                    //Aqui começam os calculos de VAVR
                    $tipoDescontoVAVR = +$row['tipoDescontoVAVR'];
                    switch ($tipoDescontoVAVR) {
                            //Projeto
                        case 0:
                            $valorDiarioFuncionarioVAVR =  +$row['valorDiarioProjetoVAVR'];
                            $valorMensalFuncionarioVAVR =  +$row['valorMensalProjetoVAVR'];
                            $descricaoDescontoVAVR = 'Projeto';
                            break;
                            //Sindicato
                        case 1:
                            $valorDiarioFuncionarioVAVR =  +$row['valorDiarioSindicatoVAVR'];
                            $valorMensalFuncionarioVAVR =  +$row['valorMensalSindicatoVAVR'];
                            $descricaoDescontoVAVR = 'Sindicato';
                            break;
                            //Funcionario
                        case 2:
                            $valorDiarioFuncionarioVAVR =  +$row['valorDiarioFuncionarioVAVR'];
                            $valorMensalFuncionarioVAVR =  +$row['valorMensalFuncionarioVAVR'];
                            $descricaoDescontoVAVR = 'Funcionário';
                            break;
                        default:
                            # code...
                            break;

                        case 5:
                            switch ($mes) {
                                case 1:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTJaneiro'];
                                    break;
                                case 2:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTFevereiro'];
                                    break;
                                case 3:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTMarco'];
                                    break;
                                case 4:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTAbril'];
                                    break;
                                case 5:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTMaio'];
                                    break;
                                case 6:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTJunho'];
                                    break;
                                case 7:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTJulho'];
                                    break;
                                case 8:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTAgosto'];
                                    break;
                                case 9:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTSetembro'];
                                    break;
                                case 10:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTOutubro'];
                                    break;
                                case 11:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTNovembro'];
                                    break;
                                case 12:
                                    $diaUtilVT = +$row['beneficioMunicipioDiaUtilVTDezembro'];
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            break;
                    }

                    // //Calculo para pegar o total do VAVR levando em consideração o valor mensal e os possíveis benefícios
                    if ($valorMensalFuncionarioVAVR > 0) {
                        $valorTotalVAVR = $valorMensalFuncionarioVAVR;
                    }
                    // $valorTotalVAVR = $valorMensalFuncionarioVAVR * $diaUtilVAVR;

                    $valorTotalPlanoSaudeBeneficio = $valorTotalPlanoSaude - $totalValorAbaterBeneficioIndireto;

                    //Inicio Calculo de Ferias
                    $diaUtilFerias = 0;
                    $diferencaDiasMunicipioFerias = 0;
                    $sqlFerias = "SELECT F.codigo,F.funcionario,F.mesAno,F.diaUtil
                                             FROM Beneficio.funcionarioFerias AS F 
                                             WHERE F.ativo = 1 AND F.mesAno = $mesAno AND F.funcionario = $funcionarioCodigo";

                    $sqlFerias = $reposit->RunQuery($sqlFerias);

                    if ($rowFerias = odbc_fetch_array($sqlFerias)) {
                        $diaUtilFerias = +$rowFerias['diaUtil'];
                        $mes;
                        // pega os dias UTEIS poor municipio de acordo com mes

                        // if($descontoFeriasAlimentacao = 1 && $descontoFeriasRefeicao == 1){
                        // switch ($mes) {
                        //     case 1:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilJaneiro'];
                        //         break;
                        //     case 2:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilFevereiro'];
                        //         break;
                        //     case 3:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilMarco'];
                        //         break;
                        //     case 4:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilAbril'];
                        //         break;
                        //     case 5:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilMaio'];
                        //         break;
                        //     case 6:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilJunho'];
                        //         break;
                        //     case 7:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilJulho'];
                        //         break;
                        //     case 8:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilAgosto'];
                        //         break;
                        //     case 9:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilSetembro'];
                        //         break;
                        //     case 10:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilOutubro'];
                        //         break;
                        //     case 11:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilNovembro'];
                        //         break;
                        //     case 12:
                        //         $diaUtilVAVR = +$row['feriasMunicipioDiaUtilDezembro'];
                        //         break;
                        //     default:
                        //         # code...
                        //         break;
                        // }
                        // }
                        // $diferencaDiasMunicipioFerias = $diaUtilMunicipioFerias - $diaUtilVAVR;
                    }
                    // FIM FERIAS

                    //Faltas e Ausências
                    // $value = explode("/", $_GET["data"]);
                    // $mesAno = "'" . $value[1] . "-" . $value[0] . "-" . "01 00:0:00'";
                    $sqlFaltaAusencia = "SELECT F.codigo,F.totalFaltasVAVR, F.totalAusenciasVAVR, F.totalFaltasValeTransporte,
                                        F.totalAusenciasValeTransporte,FPVA.justificativaValeAlimentacao,FPVA.faltaAusenciaValeAlimentacao
                                        FROM Beneficio.folhaPonto F 
                                        LEFT JOIN Beneficio.folhaPontoDiasUteisVAVR FPVA ON FPVA.folhaPonto = F.codigo
                                        WHERE (0=0) AND F.funcionario = $funcionarioCodigo AND F.mesAnoFolhaPonto = $mesAno AND F.ativo = 1 ";

                    $repositFaltaAusencia = new reposit();
                    $resultFaltaAusencia = $reposit->RunQuery($sqlFaltaAusencia);
                    $totalFaltasAusenciasVAVR = 0;
                    $totalFaltasVAVR = 0;
                    $totalAusenciaVAVR = 0;
                    $totalFaltasValeTransporte = 0;
                    $totalAusenciasValeTransporte = 0;
                    $faltasNaoJustificadas = 0;
                    $diasTrabalhadosVAVR = $diaUtilVAVR;
                    // se tiver ferias vai descontar dos dias uteis em ferias VAVRz

                    $diasTrabalhadosVT = $diaUtilVT;

                    while ($rowFaltaAusencia = odbc_fetch_array($resultFaltaAusencia)) {
                        $row = array_map('utf8_encode', $row);
                        $totalFaltasVAVR = +$rowFaltaAusencia['totalFaltasVAVR'];
                        $totalAusenciaVAVR = +$rowFaltaAusencia['totalAusenciasVAVR'];
                        $justificativaValeAlimentacao = $rowFaltaAusencia['justificativaValeAlimentacao'];
                        $faltaAusenciaValeAlimentacao = $rowFaltaAusencia['faltaAusenciaValeAlimentacao'];
                        $totalFaltasValeTransporte = +$rowFaltaAusencia['totalFaltasValeTransporte'];
                        $totalAusenciasValeTransporte = +$rowFaltaAusencia['totalAusenciasValeTransporte'];

                        $totalFaltasAusenciasVAVR = $totalAusenciaVAVR + $totalFaltasVAVR;
                        // $diasTrabalhadosVAVR = $diaUtilVAVR - $totalFaltasAusenciasVAVR;
                        // $valorMensalFuncionarioVAVR = $valorDiarioFuncionarioVAVR * $diasTrabalhadosVAVR;

                        // FALTA JUSTIFICADA AQUI CALCULo, pegar justificativa se != 0 adicionar uma falta justificada.
                        if ($justificativaValeAlimentacao == "" && $faltaAusenciaValeAlimentacao == "F") {
                            $faltasNaoJustificadas += 1;
                        }

                        $totalFaltasAusenciasVT = $totalFaltasValeTransporte + $totalAusenciasValeTransporte;
                        $diasTrabalhadosVT = $diaUtilVT - $totalFaltasAusenciasVT;
                        $valorMensalVT = $valorDiarioVT * $diasTrabalhadosVT;
                    }


                    switch ($perdaBeneficio) {
                        case 0:
                            if ($faltasNaoJustificadas != 0)
                                $valorCestaBasica = 0;
                            break;
                        case 1:
                            if ($faltasNaoJustificadas != 0 || $totalAusenciaVAVR != 0)
                                $valorCestaBasica = 0;
                            break;
                        default:
                            # code...
                            break;
                    }

                    // $totalFaltasAusenciasVAVR = $totalAusenciaVAVR + $totalFaltasVAVR;


                    // if($diaUtilFerias > 0){

                    if ($escalaFerias != 1) {
                        $diasTrabalhadosVT -= $diaUtilFerias;
                    }

                    // }

                    // Valores Extras Inicio
                    $sqlValorExtra = "SELECT FP.codigo,FP.funcionario,VE.folhaPonto,VE.beneficioExtra,VE.valor,FP.ativo
                            FROM Beneficio.folhaPonto FP                   
                            LEFT JOIN Beneficio.folhaPontoValorExtra VE ON FP.codigo = VE.folhaPonto
                            WHERE funcionario = $funcionarioCodigo AND mesAnoFolhaPonto = $mesAno AND FP.ativo = 1";

                    $repositValorExtra = new reposit();
                    $resultValorExtra = $reposit->RunQuery($sqlValorExtra);

                    $valorExtraVAVR = 0;
                    $valorExtraVT = 0;
                    $valorCestaBasicaExtra = 0;
                    $totalValorAcrescimoBeneficioIndiretoExtra = 0;

                    while ($rowValorExtra = odbc_fetch_array($resultValorExtra)) {
                        $row = array_map('utf8_encode', $row);
                        $valorExtra = 0;
                        $beneficioExtra = $rowValorExtra['beneficioExtra'];

                        switch ($beneficioExtra) {
                            case 1:
                                $valorExtraVAVR = +$rowValorExtra['valor'];
                                break;
                            case 2:
                                $valorExtraVT = +$rowValorExtra['valor'];
                                break;
                            case 3:
                                $valorCestaBasicaExtra = +$rowValorExtra['valor'];
                                break;
                            case 4:
                                $totalValorAcrescimoBeneficioIndiretoExtra = +$rowValorExtra['valor'];
                                break;
                            default:
                                break;
                        }
                    }
                    // FIM

                    // $descontaFerias = 0;
                    switch ($tipoDescontoVAVR) {
                        case 0: //projeto
                            $abatimentoVAVR = +$row['projetoDescontoVAVR'];
                            $projetoDescontaFerias = +$row['projetoDescontaFerias'];

                            if ($projetoDescontaFerias == 1) {
                                $diasTrabalhadosVAVR -= $diaUtilFerias;
                            } else {
                                $diaUtilFerias = 0;
                            }

                            break;
                        case 1: //sindicato
                            $abatimentoVAVR = +$row['sindicatoDescontoVAVR'];
                            $sindicatoDescontaFerias = +$row['sindicatoDescontaFerias'];

                            if ($sindicatoDescontaFerias == 1) {
                                $diasTrabalhadosVAVR -= $diaUtilFerias;
                            } else {
                                $diaUtilFerias = 0;
                            }

                            break;

                        default: // Funcionário
                            if ($escalaFeriasVAVR != 1) { //se tiver escala nao desconta as ferias
                                $diasTrabalhadosVAVR -= $diaUtilFerias;
                            } else {
                                $diaUtilFerias = 0;
                            }
                            // $diasTrabalhadosVAVR -= $diaUtilFerias;
                            $abatimentoVAVR = 3;
                            break;
                    }

                    switch ($abatimentoVAVR) {
                        case 1: //Descontar faltas
                            $diasTrabalhadosVAVR -= $totalFaltasVAVR;
                            $totalAusenciaVAVR = 0;
                            break;
                        case 2: //Descontar ausências
                            $diasTrabalhadosVAVR -= $totalAusenciaVAVR;
                            $totalFaltasVAVR = 0;
                            break;
                        case 3: //Descontar faltas e ausências
                            $diasTrabalhadosVAVR -= ($totalFaltasVAVR + $totalAusenciaVAVR);
                            break;
                        case 4: //Não descontar faltas nem ausências
                            $totalFaltasVAVR = 0;
                            $totalAusenciaVAVR = 0;
                            break;
                        default:
                            $diasTrabalhadosVAVR -= ($totalFaltasVAVR + $totalAusenciaVAVR);
                            break;
                    }


                    $totalFaltasAusenciasComAbatimentoProjetoSindicato = $totalAusenciaVAVR + $totalFaltasVAVR;


                    //Inicio Calculo de AFASTAMENTO FUNCIONARIO
                    // dias a abater dos dias do afastamento
                    $sqlAfastamento = "SELECT A.codigo,A.funcionario,A.mesAno,A.diaUtil,A.descontarVAVR,A.descontarTransporte,A.descontarCestaBasica
                                        FROM Beneficio.afastamento AS A 
                                        WHERE A.ativo = 1 AND A.mesAno = $mesAno AND A.funcionario = $funcionarioCodigo";

                    $resultAfastamento = $reposit->RunQuery($sqlAfastamento);
                    $diaUtilAfastamento = 0;
                    $afastamentoAbaterVAVR = 0;
                    while ($rowAfastamento = odbc_fetch_array($resultAfastamento)) {
                        $rowAfastamento = array_map('utf8_encode', $rowAfastamento);
                        $diaUtilAfastamento = +$rowAfastamento['diaUtil'];
                        $afastamentoDescontarVAVR = +$rowAfastamento['descontarVAVR'];
                        if ($afastamentoDescontarVAVR == 1) {
                            $diasTrabalhadosVAVR -= $diaUtilAfastamento;
                            $afastamentoAbaterVAVR += $diaUtilAfastamento; //dias para serem mostrados na tela de processamento
                        }
                        $afastamentoDescontarCestaBasica = +$rowAfastamento['descontarCestaBasica'];
                        if ($afastamentoDescontarCestaBasica == 1) {
                            $valorCestaBasica = 0;
                        }
                        $afastamentoDescontarTransporte = +$rowAfastamento['descontarTransporte'];
                        if ($afastamentoDescontarTransporte == 1) {
                            $diasTrabalhadosVT -= $diaUtilAfastamento;
                        }
                    }

                    //FIM AFASTAMENTO

                    //Não pode ter dias trabalhados negativos
                    if ($diasTrabalhadosVAVR  < 0) {
                        $diasTrabalhadosVAVR = 0;
                    }
                    if ($diasTrabalhadosVT  < 0) {
                        $diasTrabalhadosVT = 0;
                    }

                    echo '<tr >';
                    echo '<td class="text-left">' . $funcionario . '</a></td>';
                    echo '<td class="text-right">' . $valorDiarioFuncionarioVAVR . '</td>';
                    // se tiver dias uteis de ferias nesse mes o mes base do calculo de VAVR e bustituido pelos dias do municipio
                    // if ($diaUtilFerias > 0) {
                    //     echo '<td class="text-center">' . $diaUtilMunicipioFerias . '</td>';
                    // } else {
                    echo '<td class="text-center">' . $diaUtilVAVR . '</td>';
                    // }
                    echo '<td class="text-center">' . $totalFaltasVAVR . '</td>';
                    echo '<td class="text-center">' . $totalAusenciaVAVR . '</td>';
                    echo '<td class="text-center">' . $totalFaltasAusenciasComAbatimentoProjetoSindicato . '</td>';
                    echo '<td class="text-center">' . $diaUtilFerias . '</td>';
                    echo '<td class="text-center">' . $afastamentoAbaterVAVR . '</td>';
                    echo '<td class="text-center">' . $diasTrabalhadosVAVR . '</td>';
                    echo '<td class="text-right">' . $valorMensalFuncionarioVAVR . '</td>';
                    echo '<td class="text-center">' . $descricaoDescontoVAVR . '</td>';
                    echo '<td class="text-right">' . $valorExtraVAVR . '</td>';

                    //condicao valor total mensal VAVR
                    if ($valorMensalFuncionarioVAVR > 0) { // se o funcionario possui valor mensal (>0) vai aparecer o total sem calcular por dias trabalhados
                        echo '<td class="text-right">' . ($valorMensalFuncionarioVAVR + $valorExtraVAVR) . '</td>';
                    } else {
                        echo '<td class="text-right">' . (($valorDiarioFuncionarioVAVR * $diasTrabalhadosVAVR) +  $valorExtraVAVR) . '</td>';
                    }

                    echo '<td class="text-right">' . $totalValorAcrescimoBeneficioIndiretoExtra . '</td>';
                    echo '<td class="text-right">' . ($totalValorAcrescimoBeneficioIndireto + $totalValorAcrescimoBeneficioIndiretoExtra) . '</td>';
                    echo '<td class="text-right">' . $valorCestaBasicaExtra . '</td>';
                    echo '<td class="text-right">' . ($valorCestaBasica +  $valorCestaBasicaExtra) . '</td>';
                    echo '<td class="text-right">' . $valorTotalPlanoSaude . '</td>';
                    echo '<td class="text-right">' . $totalValorAbaterBeneficioIndireto . '</td>';
                    echo '<td class="text-right">' . $valorTotalPlanoSaudeBeneficio . '</td>';
                    echo '<td class="text-right">' . $valorTotalFuncionarioVT . '</td>';
                    echo '<td class="text-center">' . $diaUtilVT . '</td>';
                    echo '<td class="text-center">' . $totalFaltasValeTransporte . '</td>';
                    echo '<td class="text-center">' . $totalAusenciasValeTransporte . '</td>';
                    echo '<td class="text-center">' . $diasTrabalhadosVT . '</td>';
                    echo '<td class="text-right">' . $valorExtraVT . '</td>';
                    echo '<td class="text-right">' . (($valorTotalFuncionarioVT * $diasTrabalhadosVT) + $valorExtraVT) . '</td>';

                    // echo '<td class="text-center"><a class="btn btn-primary"style="background-color:#735687 ;border: black" target="_blank" rel="noopener noreferrer" href="http://localhost/NTL/operacao_processaBeneficioRel.php?id=' . $benefioCodigo . '";" value="PDF"><i class="fa fa-file-pdf-o  bg-blue-light text-magenta "></i></a></td>';
                    echo '</tr >';
                }

                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<!--script src="js/plugin/datatables/dataTables.tableTools.min.js"></script-->
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="js/plugin/Buttons-1.5.2/css/buttons.dataTables.min.css" />

<script type="text/javascript" src="js/plugin/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({

            // Tabletools options:
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'B'l'C>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                //"sLengthMenu": "_MENU_ Resultados por página",
                "sLengthMenu": "_MENU_",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "buttons": [
                //{extend: 'copy', className: 'btn btn-default'},
                //{extend: 'csv', className: 'btn btn-default'},
                {
                    extend: 'excel',
                    className: 'btn btn-default'
                    // customize: function(xlsx) {
                    //     var sheet = xlsx.xl.worksheets['sheet1.xml'];

                    //     $('row c[r^="C"],c[r^="D"]', sheet).attr('s', '64');
                    // }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-default'
                },
                //{extend: 'print', className: 'btn btn-default'}
            ],
            "autoWidth": true,

            "preDrawCallback": function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            },
            "columnDefs": [{

                "render": function(data) {
                    return parseFloat(data).toLocaleString('pt-br', {
                        type: 'num',
                        style: 'currency',
                        currency: 'BRL'
                        // minimumFractionDigits: 2,
                        // maximumFractionDigits: 2
                    });
                },
                // "targets": [1, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 24, 25]
                "targets": [1, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 25, 26]
            }]
        });

        /* END TABLETOOLS */
    });
</script>