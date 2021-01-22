<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Projeto</th>
                    <th class="text-left" style="min-width:35px;">Apelido</th>
                    <th class="text-left" style="min-width:10px;">CNPJ</th>
                    <th class="text-left" style="min-width:35px;">Data Assinatura</th>
                    <th class="text-left" style="min-width:35px;">Data Renovação</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>

                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT codigo, descricao, apelido, cnpj, dataAssinatura, dataRenovacao, ativo FROM Ntl.projeto ";
                $where = "WHERE (0 = 0)";


                if ($_GET["descricao"] != "") {
                    $descricao = $_GET["descricao"];
                    $where = $where . " and (descricao like '%' + " . "replace('" . $descricao . "',' ','%') + " . "'%')";
                }


                if ($_GET["apelido"] != "") {
                    $apelido = $_GET["apelido"];
                    $where = $where . " and (apelido like '%' + " . "replace('" . $apelido . "',' ','%') + " . "'%')";
                }

                if ($_GET["cnpj"] != "") {
                    $cnpj = $_GET["cnpj"];
                    $where = $where . " and (cnpj like '%' + " . "replace('" . $cnpj . "',' ','%') + " . "'%')";
                }


                if ($_GET["ativo"] != "") {
                    $ativo = $_GET["ativo"];
                    $where = $where . " and (ativo = $ativo)";
                }

                if ($_GET["busca"] == "R") {
                    if ($_GET["dataInicial"] != "") {
                        $dataInicial = $_GET["dataInicial"];
                        $where = $where .  " AND (dataRenovacao >= CONVERT(DATETIME, '" . $dataInicial . " 00:00:00', 103))";
                    }

                    if ($_GET["dataFinal"] != "") {
                        $dataFinal = $_GET["dataFinal"];
                        $where = $where . " AND (dataRenovacao <= CONVERT(DATETIME, '" . $dataFinal . " 23:59:59', 103))";
                    }
                }

                if ($_GET["busca"] == "A") {
                    if ($_GET["dataInicial"] != "") {
                        $dataInicial = $_GET["dataInicial"];
                        $where = $where .  " AND (dataAssinatura >= CONVERT(DATETIME, '" . $dataInicial . " 00:00:00', 103))";
                    }

                    if ($_GET["dataFinal"] != "") {
                        $dataFinal = $_GET["dataFinal"];
                        $where = $where . " AND (dataAssinatura <= CONVERT(DATETIME, '" . $dataFinal . " 23:59:59', 103))";
                    }
                }

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach($result as $row) {
                    $row = array_map('utf8_encode',$row);
                    $id = (int) $row['codigo'];
                    $descricao = $row['descricao'];
                    $apelido = $row['apelido'];
                    $cnpj = $row['cnpj'];
                    $dataAssinatura = $row['dataAssinatura'];
                    $dataRenovacao = $row['dataRenovacao'];
                    $ativo = (int) $row['ativo'];

                    $dataAux = new DateTime($dataAssinatura);
                    $dataAssinatura = $dataAux->format('d/m/Y');

                    $dataAux = new DateTime($dataRenovacao);
                    $dataRenovacao = $dataAux->format('d/m/Y');

                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else {
                        $ativo = "Não";
                    }

                    echo '<tr >';
                    echo '<td class="text-left"><a href="cadastro_projetoCadastro.php?id=' . $id . '">' . $descricao . '</a></td>';
                    echo '<td class="text-left">' . $apelido . '</td>';
                    echo '<td class="text-center">' . $cnpj . '</td>';
                    echo '<td class="text-center">' . $dataAssinatura . '</td>';
                    echo '<td class="text-center">' . $dataRenovacao . '</td>';
                    echo '<td class="text-center">' . $ativo . '</td>';
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
            }
        });

        /* END TABLETOOLS */
    });
</script>