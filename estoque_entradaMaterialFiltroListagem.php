<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:60px;">Codigo</th>
                    <th class="text-left" style="min-width:110px;">Data Entrada</th>
                    <th class="text-left" style="min-width:200px;">Cliente/Fornecedor</th>
                    <th class="text-left" style="min-width:110px;">Tipo Doc.</th>
                    <th class="text-left" style="min-width:30px;">Número</th>
                    <th class="text-left" style="min-width:30px;">Valor Nota</th>
                    <th class="text-left" style="min-width:30px;">Materiais</th>
                    <th class="text-left" style="min-width:300px;">Estoque</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $nomeTarefa = "";
                $tipoTarefa = "";
                $visivel = "";
                $ativo = "";


                $sql = "SELECT DISTINCT EM.codigo, EM.fornecedor, F.apelido, EM.tipoDocumento , T.descricao AS descricaoTipoDocumento, EM.numeroNF, EM.dataEntradaMaterial ,
                SUBSTRING(
                       (
                           SELECT  '/ ' + CI.descricaoItem  AS [text()]
                           FROM Estoque.entradaMaterialItem EMI
                           left JOIN Estoque.codigoItem CI ON EMI.material = CI.codigo
                           WHERE EMI.entradamaterial = EM.codigo
                           ORDER BY CI.descricaoItem
                           FOR XML PATH ('')
                       ), 2, 1000) [material],
               
               SUBSTRING(
                       (
                           SELECT DISTINCT '/ ' + E.descricao  AS [text()]
                           FROM Estoque.entradaMaterialItem EMI
                           left JOIN Estoque.estoque E ON EMI.estoque = E.codigo
                           WHERE EMI.entradamaterial = EM.codigo
                           FOR XML PATH ('')
                       ), 2, 1000) [estoque],
               SUBSTRING(
                       (
                           SELECT SUM(EMI.valorTotalItem)  AS [text()]
                           FROM Estoque.entradaMaterialItem EMI
                           left JOIN Estoque.estoque E ON EMI.estoque = E.codigo
                           WHERE EMI.entradamaterial = EM.codigo
                           FOR XML PATH ('')
                       ), 0, 1000) [valorTotal]
               
               FROM Estoque.entradaMaterial EM
               LEFT JOIN Ntl.fornecedor F ON F.codigo = EM.fornecedor
               LEFT JOIN Estoque.tipoDocumento T ON T.codigo = EM.tipoDocumento
               LEFT JOIN Estoque.entradaMaterialItem EMI ON EMI.entradaMaterial = EM.codigo";

                $where = " WHERE (0 = 0)";

                if ($_POST["clienteFornecedorId"] != "") {
                    $clienteFornecedorId = (int)$_POST["clienteFornecedorId"];
                    $where = $where . " AND ( EM.fornecedor = $clienteFornecedorId)";
                }

                if ($_POST["dataInicial"] != "") {
                    $dataInicial = $_POST["dataInicial"];
                    $data = explode("/", $dataInicial);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND EM.dataEntradaMaterial >= '" . $data . "'";
                }
                if ($_POST["dataFinal"] != "") {
                    $dataFinal = $_POST["dataFinal"];
                    $data = explode("/", $dataFinal);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND EM.dataEntradaMaterial <= '" . $data . "'";
                }

                if ($_POST["tipo"] != "") {
                    $tipo = (int)$_POST["tipo"];
                    $where = $where . " AND EM.tipoDocumento = " . $tipo;
                }

                if ($_POST["estoqueDestino"] != "") {
                    $estoqueDestino = $_POST["estoqueDestino"];
                    $where = $where . " AND EMI.estoque = " . $estoqueDestino;
                }

                if ($_POST["numero"] != "") {
                    $numero = (int)$_POST["numero"];
                    $where = $where . " AND (numeroNF like '%' + " . "replace('" . $numero . "',' ','%') + " . "'%')";
                }


                $orderBy = "";

                $sql .= $where . $orderBy;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id = $row['codigo'];
                    $fornecedor = $row['apelido'];
                    $tipoDocumento = $row['descricaoTipoDocumento'];
                    $numeroNF = $row['numeroNF'];

                    //A data recuperada foi formatada para D/M/Y
                    $dataEntradaMaterial = $row['dataEntradaMaterial'];
                    $descricaoData = explode(" ", $dataEntradaMaterial);
                    $descricaoData = explode("-", $descricaoData[0]);
                    $descricaoHora = explode(" ", $dataEntradaMaterial);
                    $descricaoHora = $descricaoHora[1];
                    $descricaoHora = explode(":", $descricaoHora);
                    $descricaoHora = $descricaoHora[0] . ":" . $descricaoHora[1];
                    $descricaoData =  $descricaoData[2] . "/" . $descricaoData[1] . "/" . $descricaoData[0];

                    $material = $row['material'];
                    $estoque = $row['estoque'];
                    $valorTotal = str_replace(".", ",", $row['valorTotal']);

                    echo '<tr >';
                    echo '<td class="text-left">' . $id . '</td>';
                    echo '<td class="text-left"><a href="estoque_entradaMaterialCadastro.php?id=' . $id . '">' . $descricaoData . '</td>';
                    echo '<td class="text-left">' . $fornecedor . '</td>';
                    echo '<td class="text-justify">' . $tipoDocumento . '</td>';
                    echo '<td class="text-justify">' . $numeroNF . '</td>';
                    echo '<td class="text-justify">' . $valorTotal . '</td>';
                    echo '<td class="text-justify">' . $material . '</td>';
                    echo '<td class="text-justify">' . $estoque . '</td>';
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
            "aaSorting": [],
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