<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:50px;">Funcionário</th>
                    <th class="text-left" style="min-width:50px;">Valor do posto</th>
                    <th class="text-left" style="min-width:50px;">Ocorrências</th>



                </tr>
            </thead>
            <tbody>
                <?php


                $sql = "SELECT  BP.funcionario AS funcionario,
                BP.projeto AS Projeto,
                P.codigo AS projetoCodigo,
                FU.codigo as funcionarioCodigo,
                FU.nome AS nome,
                P.ativo AS ProjetoAtivo
 FROM Ntl.beneficioProjeto BP
 INNER JOIN Ntl.funcionario FU ON BP.funcionario = FU.codigo 
 INNER JOIN Ntl.projeto P ON BP.projeto = P.codigo 
 WHERE P.ativo = 1  AND FU.dataDemissaoFuncionario IS NULL";

                if ($_GET['funcionarioFiltro'] != "") {
                    $funcionario = $_GET["funcionarioFiltro"];
                    $where = $where . " and BP.funcionario = " . $funcionario;
                }
                if ($_GET["projetoFiltro"] != "") {
                    $projetoFiltro = $_GET["projetoFiltro"];
                    $where = $where . " and  BP.projeto = " . $projetoFiltro;
                }

                $valorDoPosto = "904,00";

                $sql .= $where;
                $reposit = new reposit();
                $result1 = $reposit->RunQuery($sql);
                $mesAno = $_GET["data"];

                $mes = explode("/", $mesAno);
                $mes = +$mes[0];

                $value = explode("/", $mesAno);
                $mesAno = "'" . $value[1] . "-" . $value[0] . "-" . "01 00:0:00'";

                foreach ($result1 as $row) {
                    $id = (int) $row['codigo'];
                    $funcionario = $row['nome'];
                    $funcionarioCodigo = (int) $row['funcionario'];
                    $lancamento = (string)$row['descricao'];
                    $projeto = (int) $row['projeto'];


                    echo '<tr >';
                    echo '<td class="text-left">' . $funcionario . '</a></td>';
                    echo '<td class="text-left">' . $valorDoPosto . '</a></td>';
                    echo '<td class="text-left">' .  "Falta Justificada" . '</a></td>';


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