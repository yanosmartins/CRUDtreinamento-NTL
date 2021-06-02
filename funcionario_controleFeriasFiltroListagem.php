<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Projeto</th>
                    <th class="text-left" style="min-width:30px;">Funcionário</th>
                    <th class="text-left" style="min-width:30px;">Período Férias - Início</th>
                    <th class="text-left" style="min-width:30px;">Período Férias - Fim</th>
                    <!-- <th class="text-left" style="min-width:30px;">Férias Vencidas</th>
                    <th class="text-left" style="min-width:30px;">Dias Vencidos</th> -->
                    <!-- <th class="text-left" style="min-width:30px;">Férias Agendadas - Início</th>
                    <th class="text-left" style="min-width:30px;">Férias Agendadas - Fim</th> -->
                    <th class="text-left" style="min-width:30px;">Décimo Terceiro</th>
                    <th class="text-left" style="min-width:30px;">Abono</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $where = " WHERE (0=0) ";
                $projeto = (int) $_GET["projeto"];
                $funcionario = $_GET["funcionario"];
                $periodoFeriasInicio = $_GET["periodoFeriasInicio"];

                if ( $periodoFeriasInicio != "") {
                    $aux = explode(' ', $periodoFeriasInicio);
                    $data = $aux[1] . ' ' . $aux[0];
                    $data = $aux[0];
                    $data =  trim($data);
                    $aux = explode('/', $data);
                    $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
                    $data =  trim($data);
                    $periodoFeriasInicio = $data;
                } else {
                    $periodoFeriasInicio = '';
                };
                $periodoFeriasFim = $_GET["periodoFeriasFim"];
                if ( $periodoFeriasFim != "") {
                    $aux = explode(' ', $periodoFeriasFim);
                    $data = $aux[1] . ' ' . $aux[0];
                    $data = $aux[0];
                    $data =  trim($data);
                    $aux = explode('/', $data);
                    $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
                    $data =  trim($data);
                    $periodoFeriasFim = $data;
                } else {
                    $periodoFeriasFim = '';
                };
                $feriasVencidas = $_GET["feriasVencidas"];
                $feriasAgendadasInicio = $_GET["feriasAgendadasInicio"];
                $feriasAgendadasFim = $_GET["feriasAgendadasFim"];



                if ($projeto != 0) {

                    $where = $where . " AND CF.projeto = " . $projeto;
                }

                if ($funcionario != "") {

                    $where = $where . " AND CF.funcionario = " . $funcionario;
                }
                if ($periodoFeriasInicio != '') {

                    $where = $where . " AND CS.solicitacaoInicioFerias = "."'" . $periodoFeriasInicio."'";
                }
                if ($periodoFeriasFim != '') {

                    $where = $where . " AND CS.solicitacaoFimFerias = "."'" . $periodoFeriasFim."'";
                }



                $reposit = new reposit();
                $sql = "SELECT CF.codigo, CF.funcionario, F.nome, CF.projeto, P.descricao, CS.solicitacaoInicioFerias, CS.solicitacaoFimFerias,CS.adiantamentoDecimo, CS.abono
                FROM funcionario.controleFerias CF
                   INNER JOIN funcionario.controleFeriasSolicitacao CS ON controleFeriasSolicitacao = CF.codigo
                   INNER JOIN ntl.funcionario F ON F.codigo = CF.funcionario
                   INNER JOIN ntl.projeto P ON P.codigo = CF.projeto";
                $sql = $sql . $where;

                $result = $reposit->RunQuery($sql);
                foreach ($result as $row) {

                    $codigo = (int) $row['codigo'];
                    $projeto = $row['descricao'];
                    $funcionario = $row['nome'];

                    $solicitacaoInicioFerias = $row['solicitacaoInicioFerias'];
                    if ($row['solicitacaoInicioFerias'] != "") {
                        $aux = explode(' ', $row['solicitacaoInicioFerias']);
                        $data = $aux[1] . ' ' . $aux[0];
                        $data = $aux[0];
                        $data =  trim($data);
                        $aux = explode('-', $data);
                        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                        $data =  trim($data);
                        $solicitacaoInicioFerias = $data;
                    } else {
                        $solicitacaoInicioFerias = '';
                    };

                    $solicitacaoFimFerias = $row['solicitacaoFimFerias'];
                    if ($row['solicitacaoFimFerias'] != "") {
                        $aux = explode(' ', $row['solicitacaoFimFerias']);
                        $data = $aux[1] . ' ' . $aux[0];
                        $data = $aux[0];
                        $data =  trim($data);
                        $aux = explode('-', $data);
                        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                        $data =  trim($data);
                        $solicitacaoFimFerias = $data;
                    } else {
                        $solicitacaoFimFerias = '';
                    };

                    $adiantamentoDecimo = (int)$row['adiantamentoDecimo'];
                    $abono = (int)$row['abono'];

                    echo '<tr >';
                    echo '<td class="text-left"><a href="funcionario_controleFerias.php?codigo=' . $codigo . '">' . $projeto . '</a></td>';
                    echo '<td class="text-left">' .  $funcionario . '</td>';
                    echo '<td class="text-left">' .  $solicitacaoInicioFerias . '</td>';
                    echo '<td class="text-left">' .  $solicitacaoFimFerias . '</td>';
                    if ($adiantamentoDecimo == 1) {
                        echo '<td class="text-left">' . 'Sim' . '</td>';
                    } else {
                        echo '<td class="text-left">' . 'Não' . '</td>';
                    }
                    if ($abono == 1) {
                        echo '<td class="text-left">' . 'Sim' . '</td>';
                    } else {
                        echo '<td class="text-left">' . 'Não' . '</td>';
                    }

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
</script>