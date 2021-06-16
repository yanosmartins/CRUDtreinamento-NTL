<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-center" style="min-width:30px;">Apelido</th>
                    <th class="text-center" style="min-width:30px;">Razão Social</th>
                    <th class="text-center" style="min-width:30px;">CNPJ</th>
                    <th class="text-center" style="min-width:30px;">Bairro</th>
                    <th class="text-center" style="min-width:30px;">UF</th>
                    <th class="text-center" style="min-width:30px;">Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $where = " WHERE (0=0) ";
                $apelido = $_GET["apelido"];
                $razaoSocial = $_GET["razaoSocial"];
                $cnpj = $_GET["cnpj"];
                $bairro = $_GET["bairro"];
                $sigla = $_GET["sigla"];
                $ativo = $_GET["ativo"];

                if ($apelido != "") {
                    $where = $where . " AND F.apelido = '$apelido'";
                }
                if ($razaoSocial != "") {
                    $where = $where . " AND F.razaoSocial = '$razaoSocial'";
                }

                if ($bairro != "") {
                    $where = $where . " and (F.bairro like '%' + " . "replace('" . $bairro . "',' ','%') + " . "'%')";
                }
                if ($cnpj != "") {
                    $where = $where . " and (F.cnpj like '%' + " . "replace('" . $cnpj . "',' ','%') + " . "'%')";
                }

                if ($sigla != "") {
                    $where = $where . " AND F.uf = '$sigla' ";
                }
                if ($ativo != "") {

                    $where = $where . " AND C.ativo = $ativo ";
                }

                $reposit = new reposit();
                $sql = "SELECT C.codigo AS 'codigo',C.fornecedor AS 'codigoFornecedor',F.bairro AS 'bairro',
                F.razaoSocial AS 'nome',F.apelido AS 'apelido',C.ativo AS 'ativo',F.uf AS 'uf', F.cnpj AS 'cnpj'
                from ntl.clinica C INNER JOIN ntl.fornecedor F ON F.codigo = C.fornecedor";

                $sql = $sql . $where;
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $codigo = $row['codigo'];
                    $codigoFornecedor = $row['codigoFornecedor'];
                    $nome = $row['nome'];
                    $bairro =$row['bairro'];
                    $cnpj = $row['cnpj'];
                    $apelido = $row['apelido'];
                    $ativo = $row['ativo'];
                    $uf = $row['uf'];

                    if ($ativo == 1) {
                        $ativo = 'Sim';
                    } else {
                        $ativo = 'Não';
                    }

                    echo '<tr>';
                    echo '<td class="text-center"><a href="cadastro_clinicaCadastro.php?codigo=' . $codigo . '">'  . $apelido . '</a></td>';
                    echo '<td class="text-center">' . $nome . '</td>';
                    echo '<td class="text-center">' . $cnpj . '</td>';
                    echo '<td class="text-center">' . $bairro . '</td>';
                    echo '<td class="text-center">' . $uf . '</td>';
                    echo '<td class="text-center">' .  $ativo . '</td>';
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