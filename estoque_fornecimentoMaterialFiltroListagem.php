<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:60px;">Lançamento</th>
                    <th class="text-left" style="min-width:110px;">Data Pedido</th>
                    <th class="text-left" style="min-width:300px;">Solicitante</th>
                    <th class="text-left" style="min-width:100px;">Cliente/Fornecedor</th>
                    <th class="text-left" style="min-width:300px;">Responsável</th>
                    <th class="text-left" style="min-width:300px;">Projeto</th>
                    <th class="text-left" style="min-width:30px;">Aprovado</th>
                    <th class="text-left" style="min-width:50px;">Materiais</th>
                    <th class="text-left" style="min-width:100px;">Estoque</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $clienteFornecedorId = "";
                $solicitanteId = "";
                $projeto = "";
                $responsavelFornecimentoId = $_SESSION['funcionario'];


                $sql = "SELECT DISTINCT PM.codigo, PM.fornecedor, F.apelido, PM.projeto, P.descricao AS descricaoProjeto,
                PM.solicitante, FS.nome AS descricaoSolicitante, PM.responsavel, FR.nome AS descricaoResponsavel, PM.aprovado, PM.dataCadastramento,
                    SUBSTRING(
                            (
                                SELECT DISTINCT  '/ ' + CI.descricaoItem  AS [text()]
                                FROM Estoque.estoqueMovimento EMI
                                left JOIN Estoque.codigoItem CI ON EMI.material = CI.codigo
                                WHERE EMI.pedidoMaterial = PM.codigo
                                FOR XML PATH ('')
                            ), 2, 1000) [material],
                    
                    SUBSTRING(
                            (
                                SELECT DISTINCT '/ ' + E.descricao  AS [text()]
                                FROM Estoque.estoqueMovimento EMI
                                left JOIN Estoque.estoque E ON EMI.estoque = E.codigo
                                WHERE EMI.pedidoMaterial = PM.codigo
                                FOR XML PATH ('')
                            ), 2, 1000) [estoque]
                                            
                    FROM Estoque.pedidoMaterial PM
                    LEFT JOIN Ntl.fornecedor F ON F.codigo = PM.fornecedor
                    LEFT JOIN Estoque.entradaMaterialItem EMI ON EMI.entradaMaterial = PM.codigo
                    LEFT JOIN Ntl.projeto P ON P.codigo = PM.projeto
                    LEFT JOIN Ntl.funcionario FS ON FS.codigo = PM.solicitante
                    LEFT JOIN Ntl.funcionario FR ON FR.codigo = PM.responsavel";

                $where = " WHERE (0 = 0)";

                if ($_POST["clienteFornecedorId"] != "") {
                    $clienteFornecedorId = (int)$_POST["clienteFornecedorId"];
                    $where = $where . " AND ( PM.fornecedor = $clienteFornecedorId)";
                }

                if ($_POST["solicitanteId"] != "") {
                    $solicitanteId = (int)$_POST["solicitanteId"];
                    $where = $where . " AND ( PM.solicitante = $solicitanteId)";
                }

                if ($_POST["responsavelFornecimentoId"] != "") {
                    $responsavelFornecimentoId = (int)$_POST["responsavelFornecimentoId"];
                    $where = $where . " AND ( PM.responsavel = $responsavelFornecimentoId)";
                }

                if ($_POST["projeto"] != "") {
                    $projeto = (int)$_POST["projeto"];
                    $where = $where . " AND ( PM.projeto = $projeto)";
                }

                if ($_POST["dataInicial"] != "") {
                    $dataInicial = $_POST["dataInicial"];
                    $data = explode("/", $dataInicial);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND PM.dataCadastramento >= CONVERT(DATETIME,'".$dataInicial." 00:00:00', 103) ";
                }
                if ($_POST["dataFinal"] != "") {
                    $dataFinal = $_POST["dataFinal"];
                    $data = explode("/", $dataFinal);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND PM.dataCadastramento <= CONVERT(DATETIME,'".$dataFinal." 23:59:59', 103) ";
                }

                $orderBy = "";

                $sql .= $where . $orderBy;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id = $row['codigo'];
                    $fornecedor = $row['apelido'];
                    $solicitante = $row['descricaoSolicitante'];
                    $responsavel = $row['descricaoResponsavel'];
                    $projeto = $row['descricaoProjeto'];
                    $aprovado = $row['aprovado'];
                    $descricaoAprovado = "";

                    if($aprovado === 1){
                        $descricaoAprovado = "SIM";
                    }
                    if($aprovado === 0){
                        $descricaoAprovado = "NÃO";
                    }

                    //A data recuperada foi formatada para D/M/Y
                    $dataCadastramento = $row['dataCadastramento'];
                    $descricaoData = explode(" ", $dataCadastramento);
                    $descricaoData = explode("-", $descricaoData[0]);
                    $descricaoHora = explode(" ", $dataCadastramento);
                    $descricaoHora = $descricaoHora[1];
                    $descricaoHora = explode(":", $descricaoHora);
                    $descricaoHora = $descricaoHora[0] . ":" . $descricaoHora[1];
                    $descricaoData =  $descricaoData[2] . "/" . $descricaoData[1] . "/" . $descricaoData[0];

                    $material = $row['material'];
                    $estoque = $row['estoque'];

                    echo '<tr >';
                    echo '<td class="text-left">' . $id . '</td>';
                    echo '<td class="text-left"><a href="estoque_fornecimentoMaterialCadastro.php?id=' . $id . '">' . $descricaoData . '</td>';
                    echo '<td class="text-left">' . $solicitante . '</td>';
                    echo '<td class="text-left">' . $fornecedor . '</td>';
                    echo '<td class="text-justify">' . $responsavel . '</td>';
                    echo '<td class="text-justify">' . $projeto . '</td>';
                    echo '<td class="text-justify">' . $descricaoAprovado . '</td>';
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