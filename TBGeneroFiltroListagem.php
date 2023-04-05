<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Nome</th>
                    <th class="text-left" style="min-width:30px;">CPF</th>
                    <th class="text-left" style="min-width:30px;">RG</th>
                    <th class="text-left" style="min-width:30px;">Data de Nascimento</th>
                    <th class="text-left" style="min-width:30px;">Estado Civil</th>
                    <th class="text-left" style="min-width:30px;">Genero</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomeFiltro = "";
                $cpfFiltro = "";
                $rgFiltro = "";
                $dataNascimentoFiltro = "";
                $dataNascimentoInicio = "";
                $dataNascimentoFim = "";
                $where = " WHERE (0 = 0)";

                if ($_POST["nomeFiltro"] != "") {
                    $nomeFiltro = $_POST["nomeFiltro"];
                    $where = $where . " AND (funcionario.[nome] like '%' + " . "replace('" . $nomeFiltro . "',' ','%') + " . "'%')";
                }
                if ($_POST["cpfFiltro"] != "") {
                    $cpfFiltro = $_POST["cpfFiltro"];
                    $where = $where . " AND (funcionario.[cpf] like '%' + " . "replace('" . $cpfFiltro . "',' ','%') + " . "'%')";
                }
                if ($_POST["rgFiltro"] != "") {
                    $rgFiltro = $_POST["rgFiltro"];
                    $where = $where . " AND (funcionario.[rg] like '%' + " . "replace('" . $rgFiltro . "',' ','%') + " . "'%')";
                }
                if ($_POST["dataNascimentoFiltro"] != "") {
                    $dataNascimentoFiltro = $_POST["dataNascimentoFiltro"];
                    $where = $where . " AND (funcionario.[dataNascimento] = '$dataNascimentoFiltro')";
                }
                $estadoCivilFiltro = "";
                $estadoCivilFiltro = $_POST["estadoCivilFiltro"];
                if ($_POST["estadoCivilFiltro"] != "") {
                    $estadoCivilFiltro = $_POST["estadoCivilFiltro"];
                    $where = $where . " AND (funcionario.[estadoCivil] ='$estadoCivilFiltro')";
                } 

                $dataNascimentoInicioFiltro = "";
                $dataNascimentoInicioFiltro = $_POST["dataNascimentoInicioFiltro"];
                if ($_POST["dataNascimentoInicioFiltro"] != "") {
                    $dataNascimentoInicioFiltro = $_POST["dataNascimentoInicioFiltro"];
                    $where = $where . " AND (funcionario.[dataNascimento] >='$dataNascimentoInicioFiltro')";
                } 
                $dataNascimentoFimFiltro = "";
                $dataNascimentoFimFiltro = $_POST["dataNascimentoFimFiltro"];
                if ($_POST["dataNascimentoFimFiltro"] != "") {
                    $dataNascimentoFimFiltro = $_POST["dataNascimentoFimFiltro"];
                    $where = $where . " AND (funcionario.[dataNascimento] <='$dataNascimentoFimFiltro')";
                } 
                $generoFiltro = "";
                $generoFiltro = $_POST["generoFiltro"];
                if ($_POST["generoFiltro"] != "") {
                    $generoFiltro = $_POST["generoFiltro"];
                    $where = $where . " AND funcionario.[genero] =" . $generoFiltro;
                }

                $ativoFiltro = "";
                $ativoFiltro = $_POST["ativoFiltro"];
                if ($_POST["ativoFiltro"] != "") {
                    $ativoFiltro = $_POST["ativoFiltro"];
                    $where = $where . " AND funcionario.[ativo] =" . $ativoFiltro;
                }



                $sql = " SELECT codigo, ativo, cpf, rg, dataNascimento, estadoCivil, nome, genero from dbo.funcionario
                 ";

                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id = (int) $row['codigo'];
                    $nomeFiltro = $row['nome'];
                    $cpfFiltro = $row['cpf'];;
                    $rgFiltro = $row['rg'];
                    $genero=  $row['genero'];

                    $dataNascimentoFiltro = $row['dataNascimento'];
                    if ($dataNascimentoFiltro) {
                        $dataNascimentoFiltro = explode(" ", $dataNascimentoFiltro);
                        $data = explode("-", $dataNascimentoFiltro[0]);
                        $dataNascimentoFiltro = ($data[2] . "/" . $data[1] . "/" . $data[0]);
                    };

                    $estadoCivilFiltro = (int)$row['estadoCivil'];
                    if ($estadoCivilFiltro == 1) {
                        $estadoCivilFiltro = "Solteiro";
                    }
                    if ($estadoCivilFiltro == 2) {
                        $estadoCivilFiltro = "Casado";
                    }
                    if ($estadoCivilFiltro == 3) {
                        $estadoCivilFiltro = "Separadp";
                    }
                    if ($estadoCivilFiltro == 4) {
                        $estadoCivilFiltro = "Divorciado";
                    }
                    if ($estadoCivilFiltro == 5) {
                        $estadoCivilFiltro = "Viúvo";
                    }




                    $ativoFiltro = (int) $row['ativo'];
                    if ($ativoFiltro == 1) {
                        $ativoFiltro = "Sim";
                    } else {
                        $ativoFiltro = "Não";
                    }

                    echo '<tr >';
                    echo '<td class="text-left"><a href="cadastroFuncionario.php?id=' . $id . '">' . $nomeFiltro . '</a></td>';
                    echo '<td class="text-left">' . $cpfFiltro . '</td>';
                    echo '<td class="text-left">' . $rgFiltro . '</td>';
                    echo '<td class="text-left">' . $dataNascimentoFiltro . '</td>';
                    echo '<td class="text-left">' . $estadoCivilFiltro . '</td>';
                    echo '<td class="text-left">' . $genero . '</td>';
                    echo '<td class="text-left">' . $ativoFiltro . '</td>';
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
<script>
    $(document).ready(function() {

        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({
            // Tabletools options: 
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sLengthMenu": "_MENU_ Resultados por página",
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
            "oTableTools": {
                "aButtons": ["copy", "csv", "xls", {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }
                ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
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

    });
</script>

<!-- SELECT nome_aluno, data_conclusao FROM alunos WHERE data_conclusao BETWEEN '2020-01-01' AND '2020-12-31' 



 if ($_POST["dataNascimentoFim"] != "") {
                    $dataNascimentoFim = $_POST["dataNascimentoFim"];

                    $where = $where . " BETWEEN dataNascimento = '$dataNascimentoInicio' 'AND'  $dataNascimentoFim)";






-->