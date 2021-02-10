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
                    <th class="text-center" style="min-width:150px;">Tarefa</th>
                    <th class="text-center" style="min-width:100px;">Tipo Tarefa</th>
                    <th class="text-center" style="min-width:100px;">Situação</th>
                    <th class="text-center" style="min-width:30px;">Data da Reabertura</th>
                    <th class="text-center" style="min-width:30px;">Hora da Reabertura</th>
                    <th class="text-center" style="min-width:100px;">Responsável</th>
                    <th class="text-center" style="min-width:30px;">DataFinal</th>
                    <th class="text-center" style="min-width:30px;">Data/Hora Solicitação</th>
                    <th class="text-center" style="min-width:30px;">Concluido</th>

                </tr>
            </thead>
            <tbody>
                <?php 

                $portal = "";
                $ativo= ""; 
                $orgaoLicitante= "";
                $numeroPregao= "";
                $situacao= "";
                $responsavel= "";
                $tarefaConcluida= "";
                $dataReabertura= "";
                $horaReabertura= "";
                $tarefa= "";
                $tipoTarefa= "";

                $sql = "  SELECT GP.codigo, GP.portal, P.descricao, P.endereco, GP.orgaoLicitante, GP.numeroPregao, S.descricao AS situacao,
                T.descricao AS tarefa, T.tipo, GP.dataReabertura, GP.horaReabertura, R.nome AS responsavel, 
                GPD.dataFinal, GPD.dataSolicitacao,GPD.dataConclusao
                FROM Ntl.pregaoDetalhe GPD 
                LEFT JOIN Ntl.responsavel R ON R.codigo = GPD.responsavel
                LEFT JOIN Ntl.pregao GP ON GP.codigo = GPD.pregao
                LEFT JOIN Ntl.portal P ON P.codigo = GP.portal
                LEFT JOIN Ntl.situacao S ON S.codigo = GP.situacao
                LEFT JOIN Ntl.tarefa T ON T.codigo = GPD.tarefa";
                $where = " WHERE (0 = 0) AND GP.participaPregao = 1";

                if ($_POST["portal"] != "") {
                    $portal = +$_POST["portal"];
                    $where = $where . " AND P.codigo = $portal ";
                }

                if ($_POST["ativo"] != "") {
                    $ativo = +$_POST["ativo"];
                    $where = $where . " AND GP.ativo = $ativo ";
                }

                if ($_POST["orgaoLicitante"] != "") {
                    $orgaoLicitante = $_POST["orgaoLicitante"];
                    $where = $where . " AND ( GP.orgaoLicitante like '%' + " . "replace('" . $orgaoLicitante . "',' ','%') + " . "'%')";
                }

                if ($_POST["numeroPregao"] != "") {
                    $numeroPregao = $_POST["numeroPregao"];
                    $where = $where . " AND GP.numeroPregao = '$numeroPregao' ";
                }

                if ($_POST["situacao"] != "") {
                    $situacao = +$_POST["situacao"];
                    $where = $where . " AND GP.situacao = " . $situacao;
                }

                if ($_POST["responsavel"] != "") {
                    $responsavel = +$_POST["responsavel"];
                    $where = $where . " AND R.codigo = $responsavel ";
                }

                if ($_POST["tarefaConcluida"] != "") {
                    $tarefaConcluida = +$_POST["tarefaConcluida"];
                    if($tarefaConcluida == 0){
                        $where = $where . " AND GPD.dataConclusao IS NULL";
                    } else {
                        $where = $where . " AND GPD.dataConclusao IS NOT NULL";
                    }
                }

                if ($_POST["dataReabertura"] != "") {
                    $dataReabertura = formataDataValorSQL($_POST["dataReabertura"]);  
                    $where = $where . " AND GP.dataReabertura = '" . $dataReabertura . "'";
                }

                if ($_POST["horaReabertura"] != "") {
                    $horaReabertura = $_POST["horaReabertura"];
                    $where = $where . " AND GP.horaReabertura = '$horaReabertura' ";
                }
  
                if ($_POST["tipoTarefa"] != "") {
                    $tipoTarefa = +$_POST["tipoTarefa"];
                    $where = $where . " AND T.tipo = " . $tipoTarefa;
                }

                $where = $where . " ORDER BY GPD.dataFinal";

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach($result as $row) {
                    $id = $row['codigo'];
                    $portal = $row['descricao'];
                    $orgaoLicitante = $row['orgaoLicitante'];
                    $numeroPregao = $row['numeroPregao'];
                    $portalEndereco = $row['endereco'];
                    $situacao = $row['situacao'];
                    $dataReabertura = $row['dataReabertura'];
                    $tarefa = $row['tarefa'];
                    $responsavel = $row['responsavel'];
                    $dataFinal = $row['dataFinal'];
                    $dataSolicitacao = $row['dataSolicitacao'];
                    $dataConclusao = $row['dataConclusao'];
                    $tipoTarefa = $row['tipo'];
                    $horaReabertura = $row['horaReabertura'];

                    if ($dataReabertura != "") {
                        $dataReabertura = formataDataValorHtml($dataReabertura);  
                    }
  
                    if ($dataFinal != "") { 
                        $dataFinal = formataDataValorHtml($dataFinal); 
                    }
 
                    if($dataSolicitacao != ""){ 
                        $dataSolicitacao = formataDataValorHtml($dataSolicitacao); 
                    }
 
                    if ($dataConclusao != "") {
                        $dataConclusao = formataDataValorHtml($dataConclusao); 
                    }
 
                    if ($tipoTarefa == "1") {
                        $link = "licitacao_pregaoEmAndamentoCadastro.php?id="; 
                        $descricaoTarefa = "Pós-Pregao";
                    }else if ($tipoTarefa == "2") {
                        $link = "licitacao_pregaoNaoIniciadoCadastro.php?id=";
                        $descricaoTarefa = "Pré-Pregao";
                    } else if ($tipoTarefa == "3"){
                        $link = "licitacao_pregaoEmAndamentoCadastro.php?id="; 
                        $descricaoTarefa = "Ambos";
                    }
 
                    echo '<tr>';
                    echo '<td class="text-left" hidden></td>';
                    echo '<td class="text-left"><a target="_blank" rel="noopener noreferrer" href="'.$portalEndereco.'">' . $portal . '</a></td>';
                    echo '<td class="text-left">' . $orgaoLicitante . '</td>';
                    echo '<td class="text-center"><a href="' . $link  . $id . '">' . $numeroPregao . '</a></td>'; 
                    echo '<td class="text-center">' . $tarefa . '</td>';
                    echo '<td class="text-center">' . $descricaoTarefa . '</td>';
                    echo '<td class="text-center">' . $situacao . '</td>'; 
                    echo '<td class="text-center">' . $dataReabertura . '</td>';
                    echo '<td class="text-center">' . $horaReabertura . '</td>'; 
                    echo '<td class="text-center">' . $responsavel . '</td>';
                    echo '<td class="text-center">' . $dataFinal . '</td>';
                    echo '<td class="text-center">' . $dataSolicitacao . '</td>';
                    echo '<td class="text-center">' . $dataConclusao . '</td>';
                }

                function formataDataValorSQL($data){
                    // O (!) na frente faz com que não precise de um timestamp junto com a data.
                    $data = date_create_from_format('!j/m/Y', $data);  
                    return date_format($data, "Y-m-d");
                }

                function formataDataValorHtml($data){
                    // O (!) na frente faz com que não precise de um timestamp junto com a data.
                    $data = explode(" ", $data); //Vem com os segundos, então precisa dar um explode.
                    $data = date_create_from_format('!Y-m-j', $data[0]);  
                    return date_format($data, "d/m/Y");
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