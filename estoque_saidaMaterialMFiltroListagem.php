<?php
include "js/repositorio.php";
?>
<div class="table-container" id="formItem">
    <input id="jsonItem" name="jsonItem" type="hidden" value="[]">

    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:20px;"></th>
                    <th class="text-left" style="min-width:60px;">Estoque</th>
                    <th class="text-left" style="min-width:60px;">Código Item</th>
                    <th class="text-left" style="min-width:60px;">Material</th>
                    <th class="text-left" style="min-width:60px;">Numero Nota Fiscal</th>
                    <th class="text-left" style="min-width:60px;">Fornecedor</th>
                    <th class="text-left" style="min-width:60px;">Data Emissão NF</th>
                    <th class="text-left" style="min-width:60px;">Data Entrega</th>
                    <th class="text-left" style="min-width:60px;">Situação Movimento</th>
                    <th class="text-left" style="min-width:30px;">Situação Item</th>
                    <th class="text-left hidden" style="min-width:20px;"></th>
                    <th class="text-left hidden" style="min-width:20px;"></th>
                    <th class="text-left hidden" style="min-width:20px;"></th>
                    <th class="text-left hidden" style="min-width:20px;"></th>
                    <th class="text-left hidden" style="min-width:20px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $where = " WHERE (0 = 0) AND EM.situacao IN (1, 4, 6) AND EM.situacaoItem IN (1, 2) AND EM.estoqueMovimentoSaida IS NULL   ";

                $sql = "";
                $result = "";

                $sql = "SELECT DISTINCT EM.codigo, EM.estoque, E.descricao AS descricaoEstoque, E.unidade, EM.pedidoMaterial, EM.material,CI.codigoItem, CI.descricaoItem, CI.indicador,
                EM.situacao, ES.descricao AS descricaoSituacao, EM.situacaoItem, EMT.numeroNF, F.apelido,EMT.fornecedor, EMT.dataEmissaoNF, EMT.dataEntrega, EMI.valorTotalItem
                
                FROM Estoque.estoqueMovimento EM 
                LEFT JOIN estoque.codigoItem CI ON CI.codigo = EM.material
                LEFT JOIN estoque.estoqueSituacao ES ON ES.codigo = EM.situacao
                LEFT JOIN estoque.estoque E ON E.codigo = EM.estoque
				LEFT JOIN Estoque.entradaMaterial EMT ON EMT.codigo = EM.entradaMaterial
				LEFT JOIN Estoque.entradaMaterialItem EMI ON EMI.entradaMaterial = EM.codigo
				LEFT JOIN Ntl.fornecedor F ON F.codigo = EMT.fornecedor";


                if ($_POST["codigoItemId"] != "") {
                    $codigoItemId = (int)$_POST["codigoItemId"];
                    $where = $where . " AND ( EM.material = $codigoItemId)";
                }

                if ($_POST["situacao"] != "") {
                    $situacao = (int)$_POST["situacao"];
                    $where = $where . " AND ( EM.situacao = $situacao)";
                }

                if ($_POST["situacaoItem"] != "") {
                    $situacaoItem = (int)$_POST["situacaoItem"];
                    $where = $where . " AND ( EM.situacaoItem = $situacaoItem)";
                }

                if ($_POST["unidade"] != "") {
                    $unidade = (int)$_POST["unidade"];
                    $where = $where . " AND ( E.unidade = $unidade)";
                }

                if ($_POST["estoque"] != "") {
                    $estoque = (int)$_POST["estoque"];
                    $where = $where . " AND ( EM.estoque = $estoque)";
                }

                if ($_POST["numero"] != "") {
                    $numero = (int)$_POST["numero"];
                    $where = $where . " AND ( EMT.numeroNF = $numero)";
                }

                if ($_POST["clienteFornecedorId"] != "") {
                    $clienteFornecedorId = (int)$_POST["clienteFornecedorId"];
                    $where = $where . " AND ( EMT.fornecedor = $clienteFornecedorId)";
                }

                if ($_POST["dataEmissaoNFInicial"] != "") {
                    $dataEmissaoNFInicial = $_POST["dataEmissaoNFInicial"];
                    $where = $where . " AND EMT.dataEmissaoNF >= CONVERT(DATETIME,'" . $dataEmissaoNFInicial . " 00:00:00', 103) ";
                }
                if ($_POST["dataEmissaoNFFinal"] != "") {
                    $dataEmissaoNFFinal = $_POST["dataEmissaoNFFinal"];
                    $where = $where . " AND EMT.dataEmissaoNF <= CONVERT(DATETIME,'" . $dataEmissaoNFFinal . " 23:59:59', 103) ";
                }

                if ($_POST["dataEntradaInicial"] != "") {
                    $dataEntradaInicial = $_POST["dataEntradaInicial"];
                    $where = $where . " AND EMT.dataEntrega >= CONVERT(DATETIME,'" . $dataEntradaInicial . " 00:00:00', 103) ";
                }
                if ($_POST["dataEntradaFinal"] != "") {
                    $dataEntradaFinal = $_POST["dataEntradaFinal"];
                    $where = $where . " AND EMT.dataEntrega <= CONVERT(DATETIME,'" . $dataEntradaFinal . " 23:59:59', 103) ";
                }

                $orderBy = " ORDER BY EM.codigo";

                $sql .= $where . $orderBy;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                $sequencialItem = 0;

                foreach ($result as $row) {
                    $sequencialItem += 1;
                    $id = $row['codigo'];
                    $estoque = $row['estoque'];
                    $unidade = $row['unidade'];
                    $descricaoEstoque = $row['descricaoEstoque'];
                    $pedidoMaterial = $row['pedidoMaterial'];
                    $material = $row['material'];
                    $codigoItem = $row['codigoItem'];
                    $descricaoItem = $row['descricaoItem'];
                    $indicador = $row['indicador'];
                    $situacao = $row['situacao'];
                    $descricaoSituacao = $row['descricaoSituacao'];
                    $situacaoItem = $row['situacaoItem'];
                    $numeroNF = $row['numeroNF'];
                    $fornecedor = $row['apelido'];
                    $valorItem = $row['valorTotalItem'];
                    $descricaoSituacaoItem = "";

                    if ($situacaoItem === 1) {
                        $descricaoSituacaoItem = "Disponível";
                    }
                    if ($situacaoItem === 2) {
                        $descricaoSituacaoItem = "Não Disponível";
                    }
                    if ($situacaoItem === 3) {
                        $descricaoSituacaoItem = "Reservado";
                    }
                    if ($situacaoItem === 4) {
                        $descricaoSituacaoItem = "Fornecido";
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
                    $descricaoDataEntrada = "Sem Data";
                    $dataEntrada = $row['dataEntrega'];
                    if ($dataEntrada != '') {
                        $descricaoDataEntrada = explode(" ", $dataEntrada);
                        $descricaoDataEntrada = explode("-", $descricaoDataEntrada[0]);
                        $descricaoHoraEntrada = explode(" ", $dataEntrada);
                        $descricaoHoraEntrada = $descricaoHoraEntrada[1];
                        $descricaoHoraEntrada = explode(":", $descricaoHoraEntrada);
                        $descricaoHoraEntrada = $descricaoHoraEntrada[0] . ":" . $descricaoHoraEntrada[1];
                        $descricaoDataEntrada =  $descricaoDataEntrada[2] . "/" . $descricaoDataEntrada[1] . "/" . $descricaoDataEntrada[0];
                    }


                    echo '<tr >';
                    echo '<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' . $id . '"><i></i></label></td>';
                    echo '<td class="text-left">' . $descricaoEstoque . '</td>';
                    echo '<td class="text-left">' . $codigoItem . '</td>';
                    echo '<td class="text-justify">' . $descricaoItem . " - " . $indicador . '</td>';
                    echo '<td class="text-justify">' . $numeroNF . '</td>';
                    echo '<td class="text-justify">' . $fornecedor . '</td>';
                    echo '<td class="text-justify">' . $descricaoDataEmissaoNF . '</td>';
                    echo '<td class="text-justify">' . $descricaoDataEntrada . '</td>';
                    echo '<td class="text-justify">' . $descricaoSituacao . '</td>';
                    echo '<td class="text-justify">' . $descricaoSituacaoItem . '</td>';
                    echo '<td class="text-justify hidden">' . $estoque . '</td>';
                    echo '<td class="text-justify hidden">' . $unidade . '</td>';
                    echo '<td class="text-justify hidden">' . $valorItem . '</td>';
                    echo '<td class="text-justify hidden">' . $material . '</td>';
                    echo '<td class="text-justify hidden">' . $id . '</td>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <a class="btn btn-primary" href="javascript:executarSaidaMaterialEstoque();" style="float:right; margin-bottom: 10px">Sair com Material</a>
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
        jsonItemArray = JSON.parse($("#jsonItem").val());

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

    function executarSaidaMaterialEstoque() {
        var arrayEstoqueMovimento = [];
        var arrSelecionados = $('#tableSearchResult').DataTable().rows((i, data, tr) => $(tr).find('input').prop('checked')).data().toArray();
        debugger;

        for (var i = 0; i < arrSelecionados.length; i++) {
            arrayEstoqueMovimento.push({
                'sequencialItem': i,
                'codigoItem': arrSelecionados[i][2],
                'material': arrSelecionados[i][3],
                'estoqueDescricao': arrSelecionados[i][1],
                'notaFiscal': arrSelecionados[i][4],
                'valor': arrSelecionados[i][12],
                'fornecedor': arrSelecionados[i][5],
                'estoque': arrSelecionados[i][10],
                'unidade': arrSelecionados[i][11],
                'codigoItemId': arrSelecionados[i][13],
                'codigoMovimento': arrSelecionados[i][14],
                'quantidade': 1, 
                'situacaoItem' : 1
            });
        };

        if (arrSelecionados.length > 0) {
            post('estoque_saidaMaterialCadastroSel.php', {
                arrayEstoqueMovimentoSel: JSON.stringify(arrayEstoqueMovimento),
            });
        } else {
            smartAlert("Atenção", "Nenhum material foi selecionado.", "error");
        }
    }
</script>