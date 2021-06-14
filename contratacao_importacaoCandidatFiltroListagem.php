<?php
include "js/repositorio.php";
?>
<div class="table-container">
<h1> CANDIDATOS COM ERRO NA IMPORTAÇÃO </h1>
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <!-- <th class="text-left" style="min-width:30px;" scope="col">Código</th> -->

                    <th class="text-left" style="min-width:30px;" scope="col">Nome</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Telefone</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Email</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Cargo</th>
                    <th class="text-left" style="min-width:70px;" scope="col">data Nascimento</th>
                    <th class="text-left" style="min-width:70px;" scope="col">cpf</th>
                    <th class="text-left" style="min-width:70px;" scope="col">pcd</th>
                    <th class="text-left" style="min-width:70px;" scope="col">pis</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $jsonArrayErros = $_POST["jsonArrayErros"];
                $tamanhoArray = count($jsonArrayErros);


                foreach ($jsonArrayErros as $item) {
                    $nome = trim($item[0],"'");
                    $telefoneFormatado = trim($item[1],"'");
                    $email = trim($item[2],"'");
                    $cargoAnterior = trim($item[3],"'");
                    $dataNascimento = trim($item[4],"'");
                    $dataNascimento = date('d/m/Y', strtotime($dataNascimento));


                    $cpf = trim($item[5],"'");
                    $pis = trim($item[6],"'");
                    $pcd = trim($item[7],"'");
                    if($pcd == 1){
                        $pcdDescricao = "S";
                    }else{
                        $pcdDescricao = "N";
                    }

                    echo '<tr >';
                    echo '<td class="text-left">' . $nome . '</td>';
                    echo '<td class="text-left">' . $telefoneFormatado . '</td>';
                    echo '<td class="text-left">' . $email . '</td>';
                    echo '<td class="text-left">' . $cargoAnterior . '</td>';
                    echo '<td class="text-left">' . $dataNascimento . '</td>';
                    echo '<td class="text-left">' . $cpf . '</td>';
                    echo '<td class="text-left">' . $pcdDescricao . '</td>';
                    echo '<td class="text-left">' . $pis . '</td>';
                    echo '</tr >';
                    // $tamanhoArray--;
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