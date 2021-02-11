<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-center" style="min-width:30px;" hidden></th>
                    <th class="text-left" style="min-width:30px;">Portal</th>
                    <th class="text-left" style="min-width:150px;">Orgão</th>
                    <th class="text-center" style="min-width:100px;">Número do Pregao</th>
                    <th class="text-left" style="min-width:30px;">Data</th>
                    <th class="text-center" style="min-width:30px;">Hora</th>
                    <th class="text-center" style="min-width:150px;">Tarefa</th>
                    <th class="text-center" style="min-width:100px;">Responsável</th>
                    <th class="text-left" style="min-width:100px;">Grupo do pregão</th>
                    <th class="text-left" style="min-width:110px;">Responsável do pregão</th>
                    <th class="text-center" style="min-width:30px;">Tipo Tarefa</th>
                    <th class="text-center" style="min-width:30px;">DataFinal</th>
                    <th class="text-center" style="min-width:30px;">Data/Hora Solicitação</th>
                    <th class="text-center" style="min-width:30px;">Data de Conclusão</th>


                </tr>
            </thead>
            <tbody>
                <?php
                $nomeTarefa = "";
                $tipoTarefa = "";
                $visivel = "";
                $ativo = "";


                $sql = " SELECT GP.codigo, P.descricao,  GP.orgaoLicitante, GP.numeroPregao, T.descricao as tarefa, GPD.tipo, R.nome as responsavel,S.codigo as codigoSituacao, S.descricao as situacao, GP.posicao, GP.dataReabertura, 
                  GP.horaReabertura, GP.prioridade, GP.ativo, GPD.dataFinal, GPD.dataSolicitacao , GPD.dataConclusao,
                  G.descricao AS grupoResponsavel, R.nome AS responsavelPregao
                  FROM ntl.pregao GP
                  LEFT JOIN ntl.portal P ON P.codigo = GP.portal
				  LEFT JOIN ntl.situacao S ON S.codigo = GP.situacao
				  LEFT JOIN ntl.pregaoDetalhe GPD ON GPD.pregao = GP.codigo
				  LEFT JOIN ntl.tarefa T ON T.codigo = GPD.tarefa
                  LEFT JOIN ntl.responsavel R ON R.codigo = GPD.responsavel
                  LEFT JOIN ntl.grupoLicitacao G ON G.codigo = GP.grupoResponsavel";
                $where = " WHERE (0 = 0) AND GP.participaPregao = 1 AND GP.condicao = 2 AND GPD.tipo = 1";

                if ($_POST["portal"] != "") {
                    $portal = $_POST["portal"];
                    $where = $where . " AND ( P.descricao like '%' + " . "replace('" . $portal . "',' ','%') + " . "'%')";
                }
                if ($_POST["resumoPregao"] != "") {
                    $resumoPregao = $_POST["resumoPregao"];
                    $where = $where . " AND ( GP.objetoLicitado like '%' + " . "replace('" . $resumoPregao . "',' ','%') + " . "'%')";
                }


                if ($_POST["situacao"] != "") {
                    $situacao = +$_POST["situacao"];
                    $where = $where . " AND S.codigo = " . $situacao;
                }

                if ($_POST["dataPregao"] != "") {
                    $dataPregao = $_POST["dataPregao"];
                    $data = explode("/", $dataPregao);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND GP.dataPregao = '" . $data . "'";
                }

                if ($_POST["orgaoLicitante"] != "") {
                    $orgaoLicitante = $_POST["orgaoLicitante"];
                    $where = $where . " AND ( GP.orgaoLicitante like '%' + " . "replace('" . $orgaoLicitante . "',' ','%') + " . "'%')";
                }

                if ($_POST["responsavel"] != "") {
                    $responsavel = $_POST["responsavel"];
                    $where = $where . " AND ( R.nome like '%' + " . "replace('" . $responsavel . "',' ','%') + " . "'%')";
                }

                if ($_POST["numeroPregao"] != "") {
                    $numeroPregao = +$_POST["numeroPregao"];
                    $where = $where . " AND GP.numeroPregao = " . $numeroPregao;
                }

                if ($_POST["tipoTarefa"] != "") {
                    $tipoTarefa = +$_POST["tipoTarefa"];
                    $where = $where . " AND T.tipo = " . $tipoTarefa;
                }

                if ($_POST["grupo"] != "") {
                    $grupo = +$_POST["grupo"];
                    $where = $where . " AND G.codigo = " . $grupo;
                }

                if ($_POST["responsavelPregao"] != "") {
                    $responsavelPregao = +$_POST["responsavelPregao"];
                    $where = $where . " AND R.codigo = " . $responsavelPregao;
                }

                $where = $where . " order by GP.dataPregao, GP.horaPregao";

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                while (($row = odbc_fetch_array($result))) {
                    $id = $row['codigo'];
                    $portal = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                    $orgaoLicitante = mb_convert_encoding($row['orgaoLicitante'], 'UTF-8', 'HTML-ENTITIES');
                    $numeroPregao = mb_convert_encoding($row['numeroPregao'], 'UTF-8', 'HTML-ENTITIES');

                    //A data recuperada foi formatada para D/M/Y
                    $dataReabertura = mb_convert_encoding($row['dataReabertura'], 'UTF-8', 'HTML-ENTITIES');
                    if ($dataReabertura != "") {
                        $dataReabertura = explode("-", $dataReabertura);
                        $dataReabertura = $dataReabertura[2] . "/" . $dataReabertura[1] . "/" . $dataReabertura[0];
                        $horaReabertura = mb_convert_encoding($row['horaReabertura'], 'UTF-8', 'HTML-ENTITIES');
                    }

                    $tarefa = mb_convert_encoding($row['tarefa'], 'UTF-8', 'HTML-ENTITIES');
                    $responsavel = mb_convert_encoding($row['responsavel'], 'UTF-8', 'HTML-ENTITIES');
                    $tipoTarefa = mb_convert_encoding($row['tipo'], 'UTF-8', 'HTML-ENTITIES');

                    $dataFinal = mb_convert_encoding($row['dataFinal'], 'UTF-8', 'HTML-ENTITIES');
                    if ($dataFinal != "") {
                        $dataFinal = explode(" ", $dataFinal);
                        $dataFinal = $dataFinal[0];
                        $dataFinal = explode("-", $dataFinal);
                        $dataFinal = $dataFinal[2] . "/" . $dataFinal[1] . "/" . $dataFinal[0];
                    }

                    $dataSolicitacao = mb_convert_encoding($row['dataSolicitacao'], 'UTF-8', 'HTML-ENTITIES');
                    $dataSolicitacao = explode(" ", $dataSolicitacao);
                    $dataSolicitacao = $dataSolicitacao[0];
                    $dataSolicitacao = explode("-", $dataSolicitacao);
                    $dataSolicitacao = $dataSolicitacao[2] . "/" . $dataSolicitacao[1] . "/" . $dataSolicitacao[0];

                    $dataConclusao = mb_convert_encoding($row['dataConclusao'], 'UTF-8', 'HTML-ENTITIES');
                    if ($dataConclusao != "") {
                        $dataConclusao = explode(" ", $dataConclusao);
                        $dataConclusao = $dataConclusao[0];
                        $dataConclusao = explode("-", $dataConclusao);
                        $dataConclusao = $dataConclusao[2] . "/" . $dataConclusao[1] . "/" . $dataConclusao[0];
                    }

                    $tipoTarefa = mb_convert_encoding($row['tipo'], 'UTF-8', 'HTML-ENTITIES');
                    if ($tipoTarefa == "1") {
                        $link = "licitacao_pregaoEmAndamentoCadastro.php?id=";
                        $descricaoTarefa = "Pós-Pregao";
                    }

                    $grupo = mb_convert_encoding($row['grupoResponsavel'], 'UTF-8', 'HTML-ENTITIES');
                    $responsavelPregao = mb_convert_encoding($row['responsavelPregao'], 'UTF-8', 'HTML-ENTITIES');




                    echo '<tr>';
                    echo '<td class="text-left" hidden></td>';
                    echo '<td class="text-left">' . $portal . '</td>';
                    echo '<td class="text-left">' . $orgaoLicitante . '</td>';
                    echo '<td class="text-left"><a href="licitacao_pregaoEmAndamentoCadastro.php?id=' . $id . '">' . $numeroPregao . '</a></td>';
                    echo '<td class="text-justify">' . $dataReabertura . '</td>';
                    echo '<td class="text-justify">' . $horaReabertura . '</td>';
                    echo '<td class="text-justify">' . $tarefa . '</td>';
                    echo '<td class="text-left">' . $responsavel . '</td>';
                    echo '<td class="text-justify">' . $grupo . '</td>';
                    echo '<td class="text-justify">' . $responsavelPregao . '</td>';
                    echo '<td class="text-left">' . $descricaoTarefa . '</td>';
                    echo '<td class="text-center">' . $dataFinal . '</td>';
                    echo '<td class="text-center">' . $dataSolicitacao . '</td>';
                    echo '<td class="text-center">' . $dataConclusao . '</td>';
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