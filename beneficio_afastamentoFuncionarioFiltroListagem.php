<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Funcionário</th>
                    <th class="text-left" style="min-width:30px;">Projeto</th>
                    <th class="text-left" style="min-width:35px;">Mês/Ano Refência</th>
                    <th class="text-left" style="min-width:35px;">Motivo do Afastamento</th>
                    <th class="text-left" style="min-width:35px;">Data de Início</th>
                    <th class="text-left" style="min-width:35px;">Data de Fim</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $funcionario = "";
                $motivoDoAfastamento = "";
                $dataInicio = "";
                $dataFim = "";
                $ativo = "";

                $where = "WHERE (0 = 0)";

                $sql = "SELECT AF.codigo,AF.mesAno, F.nome AS funcionario, MA.descricao,AF.dataInicio, AF.dataFim, AF.ativo,AF.projeto,P.descricao AS nomeProjeto 
                        FROM Beneficio.afastamento AF
                        INNER JOIN Ntl.funcionario F ON F.codigo = AF.funcionario
                        INNER JOIN Ntl.motivoAfastamento MA On MA.codigo = AF.motivoAfastamento 
                        LEFT JOIN Ntl.projeto P ON P.codigo = AF.projeto ";

                $where = $where . " AND dataDemissaoFuncionario IS NULL ";

                if ($_GET["funcionario"] != "") {
                    $funcionario = $_GET["funcionario"];
                    $where = $where . " and (F.nome like '%' + " . "replace('" . $funcionario . "',' ','%') + " . "'%')";
                }

                if ($_GET["motivoDoAfastamento"] != "") {
                    $motivoDoAfastamento = $_GET["motivoDoAfastamento"];
                    $where = $where . " and (MA.descricao like '%' + " . "replace('" . $motivoDoAfastamento . "',' ','%') + " . "'%')";
                }

                if ($_GET["dataInicio"] != "") {
                    $dataInicio = $_GET["dataInicio"];

                    $dataInicio = explode("/", $dataInicio);
                    $dataInicio = $dataInicio[2] . "/" . $dataInicio[1] . "/" . $dataInicio[0];
                    $dataInicio = "'" . $dataInicio . "'";

                    $where = $where . " and AF.dataInicio >= " . $dataInicio;
                }

                if ($_GET["dataFim"] != "") {
                    $dataFim = $_GET["dataFim"];

                    $dataFim = explode("/", $dataFim);
                    $dataFim = $dataFim[2] . "/" . $dataFim[1] . "/" . $dataFim[0];
                    $dataFim = "'" . $dataFim . "'";

                    $where = $where . " and AF.dataFim <= " . $dataFim;
                }

                if ($_GET["mesAno"] != "") {

                    $mesAno = $_GET["mesAno"];
                    $value = explode("/", $mesAno);
                    $mesAno = "'" . $value[1] . "-" . $value[0] . "-" . "01 00:0:00'";

                    $where = $where . " and AF.mesAno = " . $mesAno;
                }

                if ($_GET["ativo"] != "") {
                    $ativo = $_GET["ativo"];
                    $where = $where . " and AF.ativo = " . $ativo;
                }

                if ($_GET["projeto"] != 0) {
                    $projeto = $_GET["projeto"];
                    $where = $where . " and P.codigo = " . $projeto;
                }


                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach($result as $row) {
                    $id = (int) $row['codigo'];
                    $funcionario = $row['funcionario'];
                    $motivoDoAfastamento = $row['descricao'];
                    $dataInicio = $row['dataInicio'];
                    $dataFim = $row['dataFim'];

                    $mesAno = $row['mesAno'];
                    $mesAno = explode("-", $mesAno);
                    $mesAno = $mesAno[1] . "/" . $mesAno[0];

                    $dataInicioFormatada = date('d/m/Y', strtotime($dataInicio));
                    $dataFim = date('d/m/Y', strtotime($dataFim));
                    $dataFimAux = explode("/", $dataFim);
                    if ($dataFimAux[2] >= 2100) {
                        $dataFim = "Indeterminado";
                    }

                    $ativo = (int) $row['ativo'];

                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else {
                        $ativo = "Não";
                    }

                    $projeto = $row['nomeProjeto'];

                    echo '<tr >';
                    echo '<td class="text-left"><a href="beneficio_afastamentoFuncionarioCadastro.php?codigo=' . $id . '">' . $funcionario . '</a></td>';
                    echo '<td class="text-left">' . $projeto . '</td>';
                    echo '<td class="text-left">' . $mesAno . '</td>';
                    echo '<td class="text-left">' . $motivoDoAfastamento . '</td>';
                    echo '<td class="text-left">' . $dataInicioFormatada . '</td>';
                    echo '<td class="text-left">' . $dataFim . '</td>';
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