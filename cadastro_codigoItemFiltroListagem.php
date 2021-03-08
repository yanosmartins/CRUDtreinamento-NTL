<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Codigo Item</th>
                    <th class="text-left" style="min-width:30px;">Codigo Fabricante</th>
                    <th class="text-left" style="min-width:30px;">Descricao</th>
                    <th class="text-left" style="min-width:30px;">Estoque</th>
                    <th class="text-left" style="min-width:30px;">Grupo </th>
                    <th class="text-left" style="min-width:30px;">Localizacao </th>
                    <th class="text-left" style="min-width:30px;">Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $where = " WHERE (0=0) ";
                $codigoItem = $_GET["codigoItem"];
                $codigoFabricante = $_GET["codigoFabricante"];
                $descricaoItem = $_GET["descricaoItem"];
                $estoque = $_GET["estoque"];
                $grupoItem = $_GET["grupoItem"];
                $localizacaoItem = $_GET["localizacaoItem"];
                $ativo = $_GET["ativo"];

                if ($codigoItem != "") {
                    $where = $where . " and (CI.codigoItem like '%' + " . "replace('" . $codigoItem . "',' ','%') + " . "'%')";
                }
                if ($codigoFabricante != "") {
                    $where = $where . " and (CI.codigoFabricante like '%' + " . "replace('" . $codigoFabricante . "',' ','%') + " . "'%')";
                }
                if ($descricaoItem != "") {
                    $where = $where . " and (CI.descricaoItem like '%' + " . "replace('" . $descricaoItem . "',' ','%') + " . "'%')";
                }

                if ($estoque != "") {
                    $where = $where . " AND CI.estoque = $estoque ";
                }
                if ($grupoItem != "") {

                    $where = $where . " AND CI.grupoItem = $grupoItem ";
                }
                if ($localizacaoItem != "") {

                    $where = $where . " AND CI.localizacaoItem = $localizacaoItem ";
                }
                if ($ativo != "") {

                    $where = $where . " AND CI.ativo = $ativo ";
                }

                $reposit = new reposit();
                $sql = "SELECT CI.codigo,CI.codigoItem,CI.codigoFabricante,CI.descricaoItem,CI.estoque,E.descricao AS descricaoEstoque ,
                                CI.grupoItem,GI.descricao as grupoItemDescricao,CI.localizacaoItem,LI.localizacaoItem as descricaoLocalizacaoItem,CI.ativo
                            FROM Estoque.codigoItem AS CI
                            LEFT JOIN Estoque.estoque E ON CI.estoque = E.codigo 
                            LEFT JOIN Estoque.grupoItem GI ON CI.grupoItem = GI.codigo
                            LEFT JOIN Estoque.localizacaoItem LI ON CI.localizacaoItem = LI.codigo";

                $sql = $sql . $where;
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $codigo = $row['codigo'];
                    $codigoItem = $row['codigoItem'];
                    $codigoFabricante = $row['codigoFabricante'];
                    $descricaoItem = $row['descricaoItem'];
                    $estoque = $row['descricaoEstoque'];
                    $grupoItem = $row['grupoItemDescricao'];
                    $localizacaoItem = $row['descricaoLocalizacaoItem'];
                    $ativo = $row['ativo'];

                    echo '<tr>';
                    echo '<td class="text-left"><a href="cadastro_codigoItemCadastro.php?codigo=' . $codigo . '">'  . $codigoItem . '</a></td>';
                    echo '<td class="text-left">' . $codigoFabricante . '</td>';
                    echo '<td class="text-left">' . $descricaoItem . '</td>';
                    echo '<td class="text-left">' . $estoque . '</td>';
                    echo '<td class="text-left">' . $grupoItem . '</td>';
                    echo '<td class="text-left">' . $localizacaoItem . '</td>';
                    if ($ativo == 1) {
                        echo '<td class="text-left">' . 'Sim' . '</td>';
                    } else {
                        echo '<td class="text-left">' . 'Não' . '</td>';
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUIN(S) -->
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