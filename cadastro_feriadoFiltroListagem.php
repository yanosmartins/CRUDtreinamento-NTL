<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed  dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:35px;">Descrição</th>
                    <th class="text-left" style="min-width:35px;">Tipo de Feriado</th>
                    <th class="text-left" style="min-width:35px;">Município</th>
                    <th class="text-left" style="min-width:35px;">UF</th>
                    <th class="text-left" style="min-width:35px;">Data</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>

                </tr>
            </thead>
            <tbody>
                <?php

                $descricao = "";
                $dataInicial = "";
                $dataFinal = "";
                $unidadeFederacao = "";
                $tipoFeriado = "";
                $municipio = "";
                $ativo = "";
                //                $where = "WHERE (0 = 0)";

                $sql = "SELECT F.codigo, F.tipoFeriado , F.ativo, F.descricao, M.descricao as municipio, F.unidadeFederacao, F.data FROM Ntl.feriado F
                LEFT JOIN Ntl.municipio M ON M.codigo = F.municipio WHERE (0=0) ";
                //                $dataInicial = $_POST['data'];




                if ($_GET["dataInicial"] != "") {
                    $dataInicial = $_GET["dataInicial"];

                    $dataInicial = explode("/", $dataInicial);
                    $dataInicialCerta = $dataInicial[2] . "/" . $dataInicial[1] . "/" . $dataInicial[0];
                    $dataInicial = "'" . $dataInicialCerta . "'";

                    $where = $where . " AND F.[data] >= " . $dataInicial;
                }

                if ($_GET["dataFinal"] != "") {
                    $dataFinal = $_GET["dataFinal"];

                    $dataFinal = explode("/", $dataFinal);
                    $dataFinalCerta = $dataFinal[2] . "/" . $dataFinal[1] . "/" . $dataFinal[0];
                    $dataFinal = "'" . $dataFinalCerta . "'";


                    $where = $where . " AND F.[data] <= " . $dataFinal;
                }


                if ($_GET["descricao"] != "") {
                    $descricao = $_GET["descricao"];
                    $where = $where . " and (F.descricao like '%' + " . "replace('" . $descricao . "',' ','%') + " . "'%')";
                }

                if ($_GET["unidadeFederacao"] != "") {
                    $unidadeFederacao = $_GET["unidadeFederacao"];
                    $where = $where . " AND F.[unidadeFederacao] = '" . $unidadeFederacao . "'";
                }

                if ($_GET["tipoFeriado"] != "") {
                    $tipoFeriado = $_GET["tipoFeriado"];
                    $where = $where . " AND tipoFeriado =  '" . $tipoFeriado . "'";
                }
                if ($_GET["municipio"] != "") {
                    $municipio = $_GET["municipio"];
                    $where = $where . " AND F.[municipio] = " . $municipio;
                }
                if ($_GET["ativo"] != "") {
                    $municipio = $_GET["ativo"];
                    $where = $where . " AND F.[ativo] = " . $municipio;
                }



                $sql = $sql . $where . " ORDER BY F.data";
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                while (($row = odbc_fetch_array($result))) {
                    $id = +$row['codigo'];
                    $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                    $tipoFeriado = mb_convert_encoding($row['tipoFeriado'], 'UTF-8', 'HTML-ENTITIES');
                    $municipio = mb_convert_encoding($row['municipio'], 'UTF-8', 'HTML-ENTITIES');
                    $unidadeFederacao = mb_convert_encoding($row['unidadeFederacao'], 'UTF-8', 'HTML-ENTITIES');
                    $data = mb_convert_encoding($row['data'], 'UTF-8', 'HTML-ENTITIES');
                    $ativo = +$row['ativo'];

                    $dataSeparada = explode(" ", $data);
                    $dataSeparadaCerta = explode("-", $dataSeparada[0]);
                    $dataCerta = $dataSeparadaCerta[2] . "/" . $dataSeparadaCerta[1] . "/" . $dataSeparadaCerta[0];




                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else {
                        $ativo = "Não";
                    }

                    if ($tipoFeriado == 1) {
                        $tipoFeriado = "Estadual";
                    } else if ($tipoFeriado == 2) {
                        $tipoFeriado = "Municipal";
                    } else {
                        $tipoFeriado = "Nacional";
                    }

                    echo '<tr >';
                    echo '<td class="text-left"><a href="cadastro_feriadoCadastro.php?codigo=' . $id . '">' . $descricao . '</a></td>';
                    echo '<td class="text-left">' . $tipoFeriado . '</td>';
                    echo '<td class="text-left">' . $municipio . '</td>';
                    echo '<td class="text-left">' . $unidadeFederacao . '</td>';
                    echo '<td class="text-left">' . $dataCerta . '</td>';
                    echo '<td class="text-left">' . $ativo . '</td>';
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
<script src="js/plugin/moment/moment.min.js"></script>
<script src="js/plugin/moment/datetime-moment.js"></script>
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
        $.fn.dataTable.moment('DD/MM/YYYY');
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
                {extend: 'excel', className: 'btn btn-default'},
                {extend: 'pdf', className: 'btn btn-default'},
                //{extend: 'print', className: 'btn btn-default'}
            ],
            "autoWidth": true,
            
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

        /* END TABLETOOLS */
    });
</script>