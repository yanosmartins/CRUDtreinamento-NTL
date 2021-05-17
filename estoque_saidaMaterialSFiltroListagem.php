<?php
include "js/repositorio.php";
?>
<div class="table-container" id="formItem">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:20px;">Código</th>
                    <th class="text-left" style="min-width:60px;">Status</th>
                    <th class="text-left" style="min-width:80px;">Numero NF</th>
                    <th class="text-left" style="min-width:60px;">Material</th>
                    <th class="text-left" style="min-width:60px;">Estoque</th>
                    <th class="text-left" style="min-width:100px;">Fornecedor</th>
                    <th class="text-left" style="min-width:60px;">Projeto</th>
                    <th class="text-left" style="min-width:60px;">Solicitante</th>
                    <th class="text-left" style="min-width:100px;">Data Emissão NF</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $where =" WHERE (0=0) ";
                $sql = "";
                $result = "";

                $sql = "SELECT DISTINCT SM.codigo, SM.fornecedor, F.apelido, SM.projeto, P.descricao AS descricaoProjeto,
                SM.solicitante, FS.nome AS descricaoSolicitante, SM.dataCadastramento,EM.situacaoItem,SM.notaFiscal, SM.dataEmissaoNF, SM.fechado,
                    SUBSTRING(
                            (
                                SELECT DISTINCT  '/ ' + CI.descricaoItem  AS [text()]
                                FROM Estoque.estoqueMovimento EM
                                left JOIN Estoque.codigoItem CI ON EM.material = CI.codigo
                                WHERE EM.saidaMaterial = SM.codigo
                                FOR XML PATH ('')
                            ), 2, 1000) [material],
                    
                    SUBSTRING(
                            (
                                SELECT DISTINCT '/ ' + E.descricao  AS [text()]
                                FROM Estoque.estoqueMovimento EM
                                left JOIN Estoque.estoque E ON EM.estoque = E.codigo
                                WHERE EM.saidaMaterial = SM.codigo
                                FOR XML PATH ('')
                            ), 2, 1000) [estoque]
                                            
                    FROM Estoque.saidaMaterial SM
                    LEFT JOIN Ntl.fornecedor F ON F.codigo = SM.fornecedor
                    LEFT JOIN Estoque.saidaMaterialItem SMI ON SMI.saidaMaterial = SM.codigo
                    LEFT JOIN Ntl.projeto P ON P.codigo = SM.projeto
                    LEFT JOIN Ntl.funcionario FS ON FS.codigo = SM.solicitante
					LEFT JOIN Estoque.estoqueMovimento EM ON EM.pedidoMaterial = SM.codigo
					LEFT JOIN Estoque.codigoItem CI ON CI.codigo = SMI.material";


                if ($_POST["codigoItemId"] != "") {
                    $codigoItemId = (int)$_POST["codigoItemId"];
                    $where = $where . " AND ( SMI.material = $codigoItemId)";
                }

                if ($_POST["numero"] != "") {
                    $numero = (int)$_POST["numero"];
                    $where = $where . " AND ( SM.notaFiscal = $numero)";
                }
                
                if ($_POST["fechado"] != "") {
                    $fechado = (int)$_POST["fechado"];
                    $where = $where . " AND ( SM.fechado = $fechado)";
                }
                if ($_POST["unidade"] != "") {
                    $unidade = (int)$_POST["unidade"];
                    $where = $where . " AND ( SMI.unidade = $unidade)";
                }
                if ($_POST["estoque"] != "") {
                    $estoque = (int)$_POST["estoque"];
                    $where = $where . " AND ( SMI.estoque = $estoque)";
                }

                if ($_POST["clienteFornecedorId"] != "") {
                    $clienteFornecedorId = (int)$_POST["clienteFornecedorId"];
                    $where = $where . " AND ( SM.fornecedor = $clienteFornecedorId)";
                }

                if ($_POST["dataEmissaoNFInicial"] != "") {
                    $dataEmissaoNFInicial = $_POST["dataEmissaoNFInicial"];
                    $where = $where . " AND SM.dataEmissaoNF >= CONVERT(DATETIME,'" . $dataEmissaoNFInicial . " 00:00:00', 103) ";
                }
                if ($_POST["dataEmissaoNFFinal"] != "") {
                    $dataEmissaoNFFinal = $_POST["dataEmissaoNFFinal"];
                    $where = $where . " AND SM.dataEmissaoNF <= CONVERT(DATETIME,'" . $dataEmissaoNFFinal . " 23:59:59', 103) ";
                }

                if ($_POST["dataEntradaInicial"] != "") {
                    $dataEntradaInicial = $_POST["dataEntradaInicial"];
                    $where = $where . " AND SM.dataEntrega >= CONVERT(DATETIME,'" . $dataEntradaInicial . " 00:00:00', 103) ";
                }
                if ($_POST["dataEntradaFinal"] != "") {
                    $dataEntradaFinal = $_POST["dataEntradaFinal"];
                    $where = $where . " AND SM.dataEntrega <= CONVERT(DATETIME,'" . $dataEntradaFinal . " 23:59:59', 103) ";
                }

                $orderBy = " ORDER BY SM.codigo";

                $sql .= $where . $orderBy;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                $sequencialItem = 0;

                foreach ($result as $row) {
                    $sequencialItem += 1;
                    $id = $row['codigo'];
                    $descricaoEstoque = $row['estoque'];
                    $material = $row['material'];
                    $numeroNF = $row['notaFiscal'];
                    $fornecedor = $row['apelido'];
                    $fechado = $row['fechado'];
                    $descricaoProjeto = $row['descricaoProjeto'];
                    $descricaoSolicitante = $row['descricaoSolicitante'];
                    $situacaoItem = $row['situacaoItem'];
                    $descricaoSituacaoItem = "";

                    $descricaoFecado = "";
                    if($fechado == 1){
                        $descricaoFecado = "Fechado";
                    }
                    if($fechado == 0){
                        $descricaoFecado = "Aberto";
                    }

                    //A data recuperada foi formatada para D/M/Y
                    $descricaoDataEmissaoNF = "Sem Data";
                    $dataEmissaoNF = $row['dataEmissaoNF'];
                    if ($dataEmissaoNF != '') {
                        $descricaoDataEmissaoNF = explode(" ", $dataEmissaoNF);
                        $descricaoDataEmissaoNF = explode("-", $descricaoDataEmissaoNF[0]);
                        $descricaoHoraEmissaoNF = explode(" ", $dataEmissaoNF);
                        $descricaoHoraEmissaoNF = $descricaoHoraEmissaoNF[1];
                        $descricaoHoraEmissaoNF = explode(":", $descricaoHoraEmissaoNF);
                        $descricaoHoraEmissaoNF = $descricaoHoraEmissaoNF[0] . ":" . $descricaoHoraEmissaoNF[1];
                        $descricaoDataEmissaoNF =  $descricaoDataEmissaoNF[2] . "/" . $descricaoDataEmissaoNF[1] . "/" . $descricaoDataEmissaoNF[0];
                    }
                    //A data recuperada foi formatada para D/M/Y
                    $descricaoCadastramento = "Sem Data";
                    $dataCadastramento = $row['dataCadastramento'];
                    if ($dataCadastramento != '') {
                        $descricaoCadastramento = explode(" ", $dataCadastramento);
                        $descricaoCadastramento = explode("-", $descricaoCadastramento[0]);
                        $descricaoHoraCadastramento = explode(" ", $dataCadastramento);
                        $descricaoHoraCadastramento = $descricaoHoraCadastramento[1];
                        $descricaoHoraCadastramento = explode(":", $descricaoHoraCadastramento);
                        $descricaoHoraCadastramento = $descricaoHoraCadastramento[0] . ":" . $descricaoHoraCadastramento[1];
                        $descricaoCadastramento =  $descricaoCadastramento[2] . "/" . $descricaoCadastramento[1] . "/" . $descricaoCadastramento[0];
                    }

            


                    echo '<tr >';
                    echo '<td class="text-left"><a href="estoque_saidaMaterialCadastro.php?id=' . $id . '">' . $id . '</td>';
                    echo '<td class="text-left">' . $descricaoFecado . '</td>';
                    echo '<td class="text-justify">' . $numeroNF . '</td>';
                    echo '<td class="text-justify">' . $material . '</td>';
                    echo '<td class="text-justify">' . $descricaoEstoque . '</td>';
                    echo '<td class="text-justify">' . $fornecedor .'</td>';
                    echo '<td class="text-justify">' . $descricaoProjeto . '</td>';
                    echo '<td class="text-justify">' . $descricaoSolicitante . '</td>';
                    echo '<td class="text-justify">' . $descricaoDataEmissaoNF . '</td>';
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

        $("#btnSaida").on("change", function() {
            saidaMaterial()
        });
    });
</script>