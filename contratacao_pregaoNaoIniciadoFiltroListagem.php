<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Portal</th>
                    <th class="text-left" style="min-width:30px;">Orgão</th>
                    <th class="text-left" style="min-width:30px;">Número do Pregão</th>
                    <th class="text-left" style="min-width:30px;">Oportunidade de Compra</th>
                    <th class="text-left" style="min-width:30px;">Data do Pregão</th>
                    <th class="text-left" style="min-width:30px;">Hora do Pregão</th>
                    <th class="text-left" style="min-width:30px;">Resumo do Pregão</th>
                    <th class="text-left" style="min-width:30px;">Ativo</th>
                    <th class="text-left" style="min-width:30px;">Condição do Pregão</th>
                    <th class="text-left" style="min-width:110px;">Responsável</th>
                    <th class="text-left" style="min-width:100px;">Grupo</th>
                    <th class="text-left" style="min-width:30px;">Data de lançamento</th>
                    <th class="text-left" style="min-width:30px;">Valor Estimado</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $nomeTarefa = "";
                $tipoTarefa = "";
                $visivel = "";
                $ativo = "";
                $descricaoCondicao = "";
                $condicao = "";


                $sql = " SELECT GP.codigo, P.descricao, P.endereco,  GP.orgaoLicitante, GP.numeroPregao, GP.oportunidadeCompra, GP.dataPregao, 
                GP.horaPregao, GP.resumoPregao, GP.condicao, GP.ativo,GP.dataCadastro, G.descricao AS grupoResponsavel, R.nome AS responsavelPregao, GP.valorEstimado
                FROM Ntl.pregao GP 
                LEFT JOIN Ntl.portal P ON P.codigo = GP.portal
                LEFT JOIN Ntl.grupoLicitacao G ON G.codigo = GP.grupoResponsavel
                LEFT JOIN Ntl.responsavel R ON R.codigo = GP.responsavel";
                $where = " WHERE (0 = 0) AND GP.participaPregao = 1";

                if ($_POST["portal"] != "") {
                    $portal = +$_POST["portal"];
                    $where = $where . " AND ( P.codigo = $portal)";
                }
                if ($_POST["resumoPregao"] != "") {
                    $resumoPregao = $_POST["resumoPregao"];
                    $where = $where . " AND ( GP.resumoPregao like '%' + " . "replace('" . $resumoPregao . "',' ','%') + " . "'%')";
                }

                if ($_POST["orgaoLicitante"] != "") {
                    $orgaoLicitante = $_POST["orgaoLicitante"];
                    $where = $where . " AND ( GP.orgaoLicitante like '%' + " . "replace('" . $orgaoLicitante . "',' ','%') + " . "'%')";
                }

                if ($_POST["dataPregao"] != "") {
                    $dataPregao = $_POST["dataPregao"];
                    $data = explode("/", $dataPregao);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND GP.dataPregao = '" . $data . "'";
                }

                if ($_POST["condicao"] != "") {
                    $condicao = +$_POST["condicao"];
                    $where = $where . " AND GP.condicao = " . $condicao;
                } else {
                    $where = $where . " AND (GP.condicao IS NULL OR GP.condicao = 0)";
                }

                if ($_POST["ativo"] != "") {
                    $ativo = +$_POST["ativo"];
                    $where = $where . " AND GP.ativo = " . $ativo;
                }

                if ($_POST["grupo"] != "") {
                    $grupo = +$_POST["grupo"];
                    $where = $where . " AND G.codigo = " . $grupo;
                }

                if ($_POST["responsavelPregao"] != "") {
                    $responsavelPregao = +$_POST["responsavelPregao"];
                    $where = $where . " AND R.codigo = " . $responsavelPregao;
                }

                $sql .= $where . " ORDER BY GP.dataPregao, GP.horaPregao";
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach($result as $row) {
                    $id = $row['codigo'];
                    $portal = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                    $endereco = mb_convert_encoding($row['endereco'], 'UTF-8', 'HTML-ENTITIES');
                    $orgaoLicitante = mb_convert_encoding($row['orgaoLicitante'], 'UTF-8', 'HTML-ENTITIES');
                    $numeroPregao = mb_convert_encoding($row['numeroPregao'], 'UTF-8', 'HTML-ENTITIES');

                    //A data recuperada foi formatada para D/M/Y
                    $dataPregao = mb_convert_encoding($row['dataPregao'], 'UTF-8', 'HTML-ENTITIES');
                    $dataPregao = explode("-", $dataPregao);
                    $dataPregao = $dataPregao[2] . "/" . $dataPregao[1] . "/" . $dataPregao[0];

                    $dataLancamento = mb_convert_encoding($row['dataCadastro'], 'UTF-8', 'HTML-ENTITIES');
                    $dataLancamento = explode(" ", $dataLancamento);
                    $dataLancamento = $dataLancamento[0];
                    $dataLancamento = explode("-", $dataLancamento);
                    $dataLancamento = $dataLancamento[2] . "/" . $dataLancamento[1] . "/" . $dataLancamento[0];

                    $horaPregao = mb_convert_encoding($row['horaPregao'], 'UTF-8', 'HTML-ENTITIES');
                    $resumoPregao = mb_convert_encoding($row['resumoPregao'], 'UTF-8', 'HTML-ENTITIES');
                    $oportunidadeCompra = mb_convert_encoding($row['oportunidadeCompra'], 'UTF-8', 'HTML-ENTITIES');
                    $ativo = mb_convert_encoding($row['ativo'], 'UTF-8', 'HTML-ENTITIES');
                    $ativo == 1 ? $descricaoAtivo = 'Sim' : $descricaoAtivo = 'Não';
                    $condicao = mb_convert_encoding(+$row['condicao'], 'UTF-8', 'HTML-ENTITIES');
                    $descricaoCondicao = "";

                    $grupo = mb_convert_encoding($row['grupoResponsavel'], 'UTF-8', 'HTML-ENTITIES');
                    $responsavelPregao = mb_convert_encoding($row['responsavelPregao'], 'UTF-8', 'HTML-ENTITIES');
                    $valorEstimado = number_format($row['valorEstimado'], 2, ',', '.');


                    switch ($condicao) {
                        case "1":
                            $descricaoCondicao = "Adiado";
                            break;
                        case "2":
                            $descricaoCondicao = "Em Andamento";
                            break;
                        case "3":
                            $descricaoCondicao = "Cancelado";
                            break;
                        case "4":
                            $descricaoCondicao = "Fracassado";
                            break;
                        case "5":
                            $descricaoCondicao = "Desistência";
                            break;
                    }


                    echo '<tr >';
                    echo '<td class="text-left"><a target="_blank" rel="noopener noreferrer" href="' . $endereco . '">' . $portal . '</a></td>';
                    echo '<td class="text-left">' . $orgaoLicitante . '</td>';
                    echo '<td class="text-left"><a href="pregoesNaoIniciadosCadastro.php?id=' . $id . '">' . $numeroPregao . '</a></td>';
                    echo '<td class="text-justify">' . $oportunidadeCompra . '</td>';
                    echo '<td class="text-left">' . $dataPregao . '</td>';
                    echo '<td class="text-left">' . $horaPregao . '</td>';
                    echo '<td class="text-justify">' . $resumoPregao . '</td>';
                    echo '<td class="text-justify">' . $descricaoAtivo . '</td>';
                    echo '<td class="text-left">' . $descricaoCondicao . '</td>';
                    echo '<td class="text-justify">' . $responsavelPregao . '</td>';
                    echo '<td class="text-justify">' . $grupo . '</td>';
                    echo '<td class="text-left">' . $dataLancamento . '</td>';
                    echo '<td class="text-left">' . $valorEstimado . '</td>';
                    echo '</tr>';
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
                },
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