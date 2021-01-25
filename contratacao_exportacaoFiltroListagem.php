<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">

                    <!-- <th class="text-left" style="min-width:30px;" scope="col">Código</th> -->

                    <th class="text-left" scope="col">Escolha</th>
                    <th class="text-left" scope="col">Nome do Candidato</th>
                    <th class="text-left" scope="col">CPF</th>
                    <th class="text-left" scope="col">Projeto</th>
                    <th class="text-left" scope="col">Cargo</th>
                    <th class="text-left" scope="col">Situação da Exportação</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $nomeBanco = "";
                $codigoBanco = "";

                $sql = "SELECT C.codigo, C.nomeCompleto AS nome, P.descricao AS projeto, C.cpf, NC.descricao AS cargo, E.situacao FROM Contratacao.controleCandidato CC
                LEFT JOIN Contratacao.candidato C ON C.codigo = CC.candidato
                LEFT JOIN Ntl.projeto P ON P.codigo = CC.projeto
                LEFT JOIN Ntl.cargo NC ON NC.codigo = CC.cargo
				LEFT JOIN Contratacao.exportacao E ON E.candidato = C.codigo
                WHERE CC.verificadoPeloRh = 1 ";
                $where = "AND (0 = 0) ";


                if ($_POST["projeto"] != "") {
                    $projeto = $_POST["projeto"];
                    $where = $where . " and (P.descricao like '%' + " . "replace('" . $projeto . "',' ','%') + " . "'%')";
                }

                if ($_POST["nome"] != "") {
                    $funcionario = $_POST["nome"];
                    $where = $where . " and (C.nomeCompleto like '%' + " . "replace('" . $funcionario . "',' ','%') + " . "'%')";
                }

                if ($_POST["cpf"] != "") {
                    $cpf = $_POST["cpf"];
                    $where = $where . " and (C.cpf like '%' + " . "replace('" . $cpf . "',' ','%') + " . "'%')";
                }

                if ($_POST["cargo"] != "") {
                    $cargo = $_POST["cargo"];
                    $where = $where . " and (NC.descricao like '%' + " . "replace('" . $cargo . "',' ','%') + " . "'%')";
                }

                if ($_POST["situacao"] != "") {
                    $situacao = $_POST["situacao"];
                    $where = $where . "AND (ISNULL(E.situacao, 0) =" . $situacao . ")";
                }

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                $row = array();
                for ($i = 0; $i < count($result); $i++) {
                    $codigo = mb_convert_encoding($result[$i]['codigo'], 'UTF-8', 'HTML-ENTITIES');
                    $nome = mb_convert_encoding($result[$i]['nome'], 'UTF-8', 'HTML-ENTITIES');
                    $cpf = mb_convert_encoding($result[$i]['cpf'], 'UTF-8', 'HTML-ENTITIES');
                    $projeto = mb_convert_encoding($result[$i]['projeto'], 'UTF-8', 'HTML-ENTITIES');;
                    $cargo = mb_convert_encoding($result[$i]['cargo'], 'UTF-8', 'HTML-ENTITIES');
                    $situacao = mb_convert_encoding($result[$i]['situacao'], 'UTF-8', 'HTML-ENTITIES');
                    switch ($situacao) {
                        default:
                            $situacao = "<b><font color='#dbc616'>Pendente</font></b>";
                            break;
                        case 1:
                            $situacao = "<b><font color='#228B22'>Exportado</font></b>";
                            break;
                    }

                    echo '<tr >';
                    echo '<td class="text-left"><input type="checkbox" value="' . $codigo . '"></td>';
                    echo '<td class="text-left">' . $nome . '</td>';
                    echo '<td class="text-left">' . $cpf . '</td>';
                    echo '<td class="text-left">' . $projeto . '</td>';
                    echo '<td class="text-left">' . $cargo . '</td>';
                    echo '<td class="text-left">' . $situacao . '</td>';
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