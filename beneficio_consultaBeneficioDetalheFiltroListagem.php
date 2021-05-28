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

                $codigo = $_GET["codigo"];

                $reposit = new reposit();


                // $sql = "SELECT codigo,processaBeneficio,codigoFuncionario,funcionario,diaUtilVAVR,valorDiarioFuncionarioVAVR,totalFaltaVAVR,totalAusenciaVAVR,
                //         totalFaltasAusenciasComAbatimentoProjetoSindicato,diaUtilFerias,afastamentoAbaterVAVR,diasTrabalhadosVAVR,valorMensalFuncionarioVAVR,
                //         descricaoDescontoVAVR,valorExtraVAVR,vavrTotal,totalValorAcrescimoBeneficioIndiretoExtra,
                //         totalAcrescimoBeneficioIndiretoComExtra,valorCestaBasicaExtra,cestaBasicaExtraComCestaBasica,valorTotalPlanoSaude,totalValorAbaterBeneficioIndireto,
                //         valorTotalPlanoSaudeBeneficio,valorTotalFuncionarioVT,diaUtilVT,totalFaltasValeTransporte,totalAusenciasValeTransporte,diasTrabalhadosVT,valorExtraVT,VTMensal 
                //         FROM Beneficio.processaBeneficioDetalhe WHERE processaBeneficio = $codigo";
                // $where = " WHERE (0=0) ";

                $sql = "SELECT PB.projeto,P.descricao,PB.mesAno,PB.codigo AS codigoConsultaBeneficio,PBD.processaBeneficio,PBD.codigoFuncionario,PBD.funcionario,PBD.diaUtilVAVR,PBD.valorDiarioFuncionarioVAVR,PBD.totalFaltaVAVR,PBD.totalAusenciaVAVR,
                        PBD.totalFaltasAusenciasComAbatimentoProjetoSindicato,PBD.diaUtilFerias,PBD.afastamentoAbaterVAVR,PBD.diasTrabalhadosVAVR,PBD.valorMensalFuncionarioVAVR,
                        PBD.descricaoDescontoVAVR,PBD.valorExtraVAVR,PBD.vavrTotal,PBD.totalValorAcrescimoBeneficioIndiretoExtra,
                        PBD.totalAcrescimoBeneficioIndiretoComExtra,PBD.valorCestaBasicaExtra,PBD.cestaBasicaExtraComCestaBasica,PBD.valorTotalPlanoSaude,PBD.totalValorAbaterBeneficioIndireto,
                        PBD.valorTotalPlanoSaudeBeneficio,PBD.valorTotalFuncionarioVT,PBD.diaUtilVT,PBD.totalFaltasValeTransporte,PBD.totalAusenciasValeTransporte,PBD.diasTrabalhadosVT,PBD.valorExtraVT,PBD.VTMensal 
                        FROM Beneficio.processaBeneficio PB
                        LEFT JOIN Beneficio.processaBeneficioDetalhe PBD ON PBD.processaBeneficio = PB.codigo
                        LEFT JOIN Ntl.projeto P ON PB.projeto = P.codigo WHERE PBD.processaBeneficio = $codigo";


                $sql = $sql . $where;
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {

                    $codigoConsultaBeneficio = (int) $row['codigoConsultaBeneficio'];
                    $processaBeneficio = (int) $row['processaBeneficio'];
                    $codigoFuncionario = (int) $row['codigoFuncionario'];
                    $funcionario = (string) $row['funcionario'];
                    $diaUtilVAVR = (int) $row['diaUtilVAVR'];
                    $valorDiarioFuncionarioVAVR = (float) $row['valorDiarioFuncionarioVAVR'];
                    $totalAusenciaVAVR = (int) $row['totalAusenciaVAVR'];
                    $totalFaltaVAVR = (int) $row['totalFaltaVAVR'];
                    $totalFaltasAusenciasComAbatimentoProjetoSindicato = (int) $row['totalFaltasAusenciasComAbatimentoProjetoSindicato'];
                    $diaUtilFerias = (int) $row['diaUtilFerias'];
                    $afastamentoAbaterVAVR = (int) $row['afastamentoAbaterVAVR'];
                    $diasTrabalhadosVAVR = (int) $row['diasTrabalhadosVAVR'];
                    $valorMensalFuncionarioVAVR = (int) $row['valorMensalFuncionarioVAVR'];
                    $descricaoDescontoVAVR = (string) $row['descricaoDescontoVAVR'];
                    $valorExtraVAVR = (float) $row['valorExtraVAVR'];
                    $vavrTotal = (float) $row['vavrTotal'];
                    $totalValorAcrescimoBeneficioIndiretoExtra = (float) $row['totalValorAcrescimoBeneficioIndiretoExtra'];
                    $totalAcrescimoBeneficioIndiretoComExtra = (float) $row['totalAcrescimoBeneficioIndiretoComExtra'];
                    $valorCestaBasicaExtra = (float) $row['valorCestaBasicaExtra'];
                    $cestaBasicaExtraComCestaBasica = (float) $row['cestaBasicaExtraComCestaBasica'];
                    $valorTotalPlanoSaude = (float) $row['valorTotalPlanoSaude'];
                    $totalValorAbaterBeneficioIndireto = (float) $row['totalValorAbaterBeneficioIndireto'];
                    $valorTotalPlanoSaudeBeneficio = (float) $row['valorTotalPlanoSaudeBeneficio'];
                    $valorTotalFuncionarioVT = (float) $row['valorTotalFuncionarioVT'];
                    $diaUtilVT = (int) $row['diaUtilVT'];
                    $totalFaltasValeTransporte = (int) $row['totalFaltasValeTransporte'];
                    $totalAusenciasValeTransporte = (int) $row['totalAusenciasValeTransporte'];
                    $diasTrabalhadosVT = (int) $row['diasTrabalhadosVT'];
                    $valorExtraVT = (float) $row['valorExtraVT'];
                    $VTMensal = (float) $row['VTMensal'];

                    echo '<tr>';
                    echo '<td class="text-center">' . $funcionario . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorDiarioFuncionarioVAVR, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . $diaUtilVAVR . '</a></td>';
                    echo '<td class="text-center">' . $totalFaltaVAVR . '</a></td>';
                    echo '<td class="text-center">' . $totalAusenciaVAVR . '</a></td>';
                    echo '<td class="text-center">' . $totalFaltasAusenciasComAbatimentoProjetoSindicato . '</a></td>';
                    echo '<td class="text-center">' . $diaUtilFerias . '</a></td>';
                    echo '<td class="text-center">' . $afastamentoAbaterVAVR . '</a></td>';
                    echo '<td class="text-center">' . $diasTrabalhadosVAVR . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorMensalFuncionarioVAVR, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . $descricaoDescontoVAVR . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorExtraVAVR, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($vavrTotal, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($totalValorAcrescimoBeneficioIndiretoExtra, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($totalAcrescimoBeneficioIndiretoComExtra, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorCestaBasicaExtra, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($cestaBasicaExtraComCestaBasica, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorTotalPlanoSaude, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($totalValorAbaterBeneficioIndireto, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorTotalPlanoSaudeBeneficio, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorTotalFuncionarioVT, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . $diaUtilVT . '</a></td>';
                    echo '<td class="text-center">' . $totalFaltasValeTransporte . '</a></td>';
                    echo '<td class="text-center">' . $totalAusenciasValeTransporte . '</a></td>';
                    echo '<td class="text-center">' . $diasTrabalhadosVT . '</a></td>';
                    echo '<td class="text-center">' . number_format($valorExtraVT, 2, ',', '.') . '</a></td>';
                    echo '<td class="text-center">' . number_format($VTMensal, 2, ',', '.') . '</a></td>';
                    echo '</tr>';
                }

                if ($result) { //apresnetar o nome e mes ano da consulta
                    $projetoDescricao = (string) $row['descricao'];
                    $mesAno = (string) $row['mesAno'];
                }

                ?>
            </tbody>
        </table>
    </div>
    <?php
    echo '<h1>' . '<b>Projeto: </b>' . $projetoDescricao . ' - <b>Mês/Ano: </b>' . $mesAno . '</h1>';
    ?>
    <button id="btnExcelSodexo" name="btnExcelSodexo" type="button" class="btn btn-success" title="grava">
        Gerar Excel Sodexo
    </button>
    <button id="btnExcelSodexoBeneficioIndireto" name="btnExcelSodexoBeneficioIndireto" type="button" class="btn btn-success" title="grava">
        Sodexo Benefício Indireto
    </button>
</div>

<!-- PAGE RELATED PLUGIN(S) -->

<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
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
     
        $("#btnExcelSodexo").on("click", function() {
            $("#btnExcelSodexo").prop('disabled', true);
            var codigoConsultaBeneficio = <?php echo $codigoConsultaBeneficio ?>;
            $(location).attr('href', `beneficio_excelBeneficioSodexo.php?id=${codigoConsultaBeneficio}`);
        });

        $("#btnExcelSodexoBeneficioIndireto").on("click", function() {
            $("#btnExcelSodexoBeneficioIndireto").prop('disabled', true);
            var codigoConsultaBeneficio = <?php echo $codigoConsultaBeneficio ?>;
            $(location).attr('href', `beneficio_excelBeneficioIndireto.php?id=${codigoConsultaBeneficio}`);
        });

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
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($(
                        '#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

        /* END TABLETOOLS */
    });

    // function gerarExcel() {
    //     $('#resultadoBusca').load('beneficio_consultaBeneficioDetalheFiltroListagem.php?' + parametrosUrl);
    // }
</script>