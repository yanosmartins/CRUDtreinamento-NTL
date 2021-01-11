<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">

                    <!-- <th class="text-left" style="min-width:30px;" scope="col">Código</th> -->

                    <th class="text-left" style="min-width:70px;" scope="col">Nome Completo                                                                 </th>
                    <th class="text-left" style="min-width:30px;" scope="col">CPF                       </th>
                    <th class="text-left" style="min-width:30px;" scope="col">RG                       </th>
                    <th class="text-left" style="min-width:30px;" scope="col">Cargo                                              </th>

                    <th class="text-left" style="min-width:30px;" scope="col">Dados Pessoais</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Contato</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Endereco</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Documentos</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Escolaridade</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Conjugue</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Filhos</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Dependentes</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Beneficios</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Transporte</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Dados Bancarios</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Cargo</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Uniforme</th>
                    <th class="text-left" style="min-width:30px;" scope="col">Anexo Documento</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $nome = "";
                $cpf = "";
                $rg = "";
                $cargo = "";
                $tipoPendencia = "";
                $verifica = "";
                $verificaDadoPessoal = "";
                $verificaDadoContato = "";
                $verificaEndereco = "";
                $verificaDocumento = "";
                $verificaEscolaridade = "";
                $verificaDadoConjugue = "";
                $verificaFilho = "";
                $verificaDependente = "";
                $verificaBeneficio = "";
                $verificaVT = "";
                $verificaDadoBancario = "";
                $verificaCargo = "";
                $verificaUniforme = "";
                $verificaAnexoDocumento = "";

                $sql = " SELECT F.codigo, F.nomeCompleto, F.cargo ,F.rg, F.cpf,verificaDadoPessoal,F.verificaDadoContato,F.verificaEndereco,
                F.verificaDocumento,F.verificaEscolaridade,F.verificaDadoConjuge,F.verificaFilho,F.verificaDependente,
				F.verificaBeneficio,F.verificaVT,F.verificaDadoBancario,F.verificaCargo,F.verificaUniforme,F.verificaAnexoDocumento
                FROM dbo.funcionario F
				LEFT JOIN dbo.exportacao E ON F.codigo = E.funcionario  ";
                $where = "WHERE (0 = 0) AND (F.ativo = 1 OR F.ativo IS NULL) AND (E.situacao IS NULL OR E.situacao = 0)";

                if ($_POST["nome"] != "") {
                    $nomeCompleto = $_POST["nome"];
                    $where = $where . " AND (F.nomeCompleto like '%' + " . "replace('" . $nomeCompleto . "',' ','%') + " . "'%')";
                }
                if ($_POST["cpf"] != "") {
                    $cpf = $_POST["cpf"];
                    $where = $where . " AND (F.cpf like '%' + " . "replace('" . $cpf . "',' ','%') + " . "'%')";
                }
                if ($_POST["rg"] != "") {
                    $rg = $_POST["rg"];
                    $where = $where . " AND (F.rg like '%' + " . "replace('" . $rg . "',' ','%') + " . "'%')";
                }
                if ($_POST["cargo"] != "") {
                    $cargo = $_POST["cargo"];
                    $where = $where . " AND (F.cargo like '%' + " . "replace('" . $cargo . "',' ','%') + " . "'%')";
                }

                if ($_POST["verifica"] != "") {
                    $verifica = $_POST["verifica"];
                    if ($verifica == 1) {
                        $where = $where . " AND (F.verificaDadoPessoal like '%' + replace('1',' ','%') + '%')
                            or (F.verificaDadoContato like '%' + replace('1',' ','%') + '%')
                            or (F.verificaEndereco like '%' + replace('1',' ','%') + '%')
                            or (F.verificaDocumento like '%' + replace('1',' ','%') + '%')
                            or (F.verificaEscolaridade like '%' + replace('1',' ','%') + '%')
                            or (F.verificaDadoConjuge like '%' + replace('1',' ','%') + '%')
                            or (F.verificaFilho like '%' + replace('1',' ','%') + '%')
                            or (F.verificaDependente like '%' + replace('1',' ','%') + '%')
                            or (F.verificaBeneficio like '%' + replace('1',' ','%') + '%')
                            or (F.verificaVT like '%' + replace('1',' ','%') + '%')
                            or (F.verificaDadoBancario like '%' + replace('1',' ','%') + '%')
                            or (F.verificaCargo like '%' + replace('1',' ','%') + '%')
                            or (F.verificaUniforme like '%' + replace('1',' ','%') + '%')
                            or (F.verificaAnexoDocumento like '%' + replace('1',' ','%') + '%')";
                    }
                    if ($verifica == 0) {
                        $where = $where . " AND (F.verificaDadoPessoal like '%' + replace('0',' ','%') + '%')
                                or (F.verificaDadoContato like '%' + replace('0',' ','%') + '%')
                                or (F.verificaEndereco like '%' + replace('0',' ','%') + '%')
                                or (F.verificaDocumento like '%' + replace('0',' ','%') + '%')
                                or (F.verificaEscolaridade like '%' + replace('0',' ','%') + '%')
                                or (F.verificaDadoConjuge like '%' + replace('0',' ','%') + '%')
                                or (F.verificaFilho like '%' + replace('0',' ','%') + '%')
                                or (F.verificaDependente like '%' + replace('0',' ','%') + '%')
                                or (F.verificaBeneficio like '%' + replace('0',' ','%') + '%')
                                or (F.verificaVT like '%' + replace('0',' ','%') + '%')
                                or (F.verificaDadoBancario like '%' + replace('0',' ','%') + '%')
                                or (F.verificaCargo like '%' + replace('0',' ','%') + '%')
                                or (F.verificaUniforme like '%' + replace('0',' ','%') + '%')
                                or (F.verificaAnexoDocumento like '%' + replace('0',' ','%') + '%')";
                    }
                    if ($verifica == 2) {
                        $where = $where . " AND (F.verificaDadoPessoal like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaDadoContato like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaEndereco like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaDocumento like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaEscolaridade like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaDadoConjuge like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaFilho like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaDependente like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaBeneficio like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaVT like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaDadoBancario like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaCargo like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaUniforme like '%' + replace('2',' ','%') + '%')
                                    AND (F.verificaAnexoDocumento like '%' + replace('2',' ','%') + '%')";
                    }
                }

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                while (($row = odbc_fetch_array($result))) {
                    $id = $row['codigo'];
                    $nomeCompleto = mb_convert_encoding($row['nomeCompleto'], 'UTF-8', 'HTML-ENTITIES');
                    $cpf = $row['cpf'];
                    $rg = $row['rg'];
                    $cargo = mb_convert_encoding($row['cargo'], 'UTF-8', 'HTML-ENTITIES');
                    $verificaDadoPessoal = descricaoVerifica($row['verificaDadoPessoal']);
                    $verificaDadoContato =  descricaoVerifica($row['verificaDadoContato']);
                    $verificaEndereco =  descricaoVerifica($row['verificaEndereco']);
                    $verificaDocumento = descricaoVerifica($row['verificaDocumento']);
                    $verificaEscolaridade = descricaoVerifica($row['verificaEscolaridade']);
                    $verificaDadoConjugue = descricaoVerifica($row['verificaDadoConjuge']);
                    $verificaFilho = descricaoVerifica($row['verificaFilho']);
                    $verificaDependente = descricaoVerifica($row['verificaDependente']);
                    $verificaBeneficio = descricaoVerifica($row['verificaBeneficio']);
                    $verificaVT = descricaoVerifica($row['verificaVT']);
                    $verificaDadoBancario = descricaoVerifica($row['verificaDadoBancario']);
                    $verificaCargo = descricaoVerifica($row['verificaCargo']);
                    $verificaUniforme = descricaoVerifica($row['verificaUniforme']);
                    $verificaAnexoDocumento = descricaoVerifica($row['verificaAnexoDocumento']);

                    //$login = mb_convert_encoding($row['cpf'], 'UTF-8', 'HTML-ENTITIES');
                    echo '<tr >';
                    // echo "<td class='text-left'>$codigo</td>";
                    echo '<td class="text-left"><a href="funcionarioCadastroDividida.php?codigo=' . $id . '">' . $nomeCompleto . '</a></td>';
                    // echo "<td class='text-left'>$nomeCompleto</td>";
                    echo "<td class='text-center'>$cpf</td>";
                    echo "<td class='text-center'>$rg</td>";
                    echo "<td class='text-left'>$cargo</td>";
                    echo "<td class='text-left'>$verificaDadoPessoal</td>";
                    echo "<td class='text-left'>$verificaDadoContato</td>";
                    echo "<td class='text-left'>$verificaEndereco</td>";
                    echo "<td class='text-left'>$verificaDocumento</td>";
                    echo "<td class='text-left'>$verificaEscolaridade</td>";
                    echo "<td class='text-left'>$verificaDadoConjugue</td>";
                    echo "<td class='text-left'>$verificaFilho</td>";
                    echo "<td class='text-left'>$verificaDependente</td>";
                    echo "<td class='text-left'>$verificaBeneficio</td>";
                    echo "<td class='text-left'>$verificaVT</td>";
                    echo "<td class='text-left'>$verificaDadoBancario</td>";
                    echo "<td class='text-left'>$verificaCargo</td>";
                    echo "<td class='text-left'>$verificaUniforme</td>";
                    echo "<td class='text-left'>$verificaAnexoDocumento</td>";
                    echo '</tr >';
                }

                function descricaoVerifica($numero)
                {
                    if ($numero == 2) {
                        return $numero = "<b><font color='#228B22'> Verificado </font></b>";
                    } else if ($numero == 1) {
                        return $numero = "<b><font color='#dbc616'> Pendente </font></b>";
                    } else if ($numero == 0) {
                        return $numero = "<b><font color='#FF0000'> Não Verificado </font></b>";
                    }
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