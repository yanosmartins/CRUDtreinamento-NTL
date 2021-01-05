<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Produto</th>
                    <th class="text-left" style="min-width:35px;">Apelido Convenio</th>
                    <th class="text-left" style="min-width:10px;">Seguro de vida</th>
                    <th class="text-left" style="min-width:35px;">Cobrança</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $convenioSaude = "";
                $produto = "";
                $seguroDeVida = "";
                $cobranca = "";
                $ativo = "";
                $where = "WHERE (0 = 0)";

                $sql = "SELECT P.codigo, C.apelido, P.convenioSaude, P.produto, P.seguroVida, P.cobranca, P.ativo FROM Ntl.produto P 
                LEFT JOIN Ntl.convenioSaude C ON P.convenioSaude = C.codigo 
                ";

                if ($_GET["convenioSaude"] != "") {
                    $convenioSaude = $_GET["convenioSaude"];
                    $where = $where . " and (convenioSaude like '%' + " . "replace('" . $convenioSaude . "',' ','%') + " . "'%')";
                }

                if ($_GET["produto"] != "") {
                    $produto = $_GET["produto"];
                    $where = $where . " and (P.codigo = $produto)";
                }

                if ($_GET["seguroDeVida"] != "") {
                    $seguroVida = $_GET["seguroVida"];
                    $seguroVida = $where . " and (seguroVida like '%' + " . "replace('" . $seguroVida . "',' ','%') + " . "'%')";
                }

                if ($_GET["cobranca"] != "") {
                    $cobranca = $_GET["cobranca"];
                    $where = $where . " and (cobranca like '%' + " . "replace('" . $cobranca . "',' ','%') + " . "'%')";
                }


                if ($_GET["ativo"] != "") {
                    $ativo = $_GET["ativo"];
                    $where = $where . " and (P.ativo = $ativo)";
                }



                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                while (($row = odbc_fetch_array($result))) {
                    $id = +$row['codigo'];
                    $apelido = mb_convert_encoding($row['apelido'], 'UTF-8', 'HTML-ENTITIES');
                    $convenioSaude = mb_convert_encoding($row['convenioSaude'], 'UTF-8', 'HTML-ENTITIES');
                    $produto = mb_convert_encoding($row['produto'], 'UTF-8', 'HTML-ENTITIES');
                    $seguroVida = mb_convert_encoding($row['seguroVida'], 'UTF-8', 'HTML-ENTITIES');
                    $cobranca = mb_convert_encoding($row['cobranca'], 'UTF-8', 'HTML-ENTITIES');
                    $ativo = +$row['ativo'];

                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else {
                        $ativo = "Não";
                    }

                    if ($cobranca == 'I') {
                        $cobranca = "Por idade";
                    } else if ($cobranca == 'F') {
                        $cobranca = "Fixo";
                    }

                    if ($seguroVida == 1) {
                        $seguroVida = "Sim";
                    } else {
                        $seguroVida = "Não";
                    }

                    echo '<tr >';
                    echo '<td class="text-left"><a href="cadastro_produtoCadastro.php?codigo=' . $id . '">' . $produto . '</a></td>';
                    echo '<td class="text-left">' . $apelido . '</td>';
                    echo '<td class="text-left">' . $seguroVida . '</td>';
                    echo '<td class="text-left">' . $cobranca . '</td>';
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