<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Portal</th>
                    <th class="text-left" style="min-width:150px;">Orgão Licitante</th>
                    <th class="text-center" style="min-width:100px;">Número do Pregao</th> 
                    <th class="text-center" style="min-width:30px;">Data</th>
                    <th class="text-left" style="min-width:30px;">Hora</th> 
                    <th class="text-center" style="min-width:150px;">Condição do Pregão</th>
                    <th class="text-center" style="min-width:100px;">Ativo</th>
                    <th class="text-center" style="min-width:30px;">Tarefa</th>
                    <th class="text-center" style="min-width:30px;">Responsável</th>
                    <th class="text-center" style="min-width:35px;">Tipo Tarefa</th>
                    <th class="text-left" style="min-width:110px;">Responsável do pregão</th> 
                    <th class="text-left" style="min-width:100px;">Grupo do pregão</th>
                    <th class="text-center" style="min-width:30px;">Data de Conclusão</th> 

                </tr>
            </thead>
            <tbody>
                <?php
                $portal = "";
                $orgaoLicitante = "";
                $numeroPregao = "";
                $dataPregao = "";
                $horaPregao = "";  
                $condicao = "";
                $descricaoCondicao = ""; 
                $ativo = "";
                $tarefa = "";
                $responsavel = "";
                $tipoTarefa = "";  
                $resumoPregao = "";  
                $tarefaConcluida = "";
 
                $sql = " SELECT GP.codigo, P.descricao,P.endereco,  GP.orgaoLicitante, GP.numeroPregao, GP.dataPregao, GP.horaPregao, 
                GP.condicao, GP.ativo, T.descricao AS tarefa,R.nome AS responsavel,
                GPD.tipo, GPD.dataConclusao, G.descricao AS grupoResponsavel, R.nome AS responsavelPregao
                FROM Ntl.pregao GP
                LEFT JOIN Ntl.portal P ON P.codigo = GP.portal
                LEFT JOIN Ntl.situacao S ON S.codigo = GP.situacao
                LEFT JOIN Ntl.pregaoDetalhe GPD ON GPD.pregao = GP.codigo
                LEFT JOIN Ntl.tarefa T ON T.codigo = GPD.tarefa
                LEFT JOIN Ntl.grupoLicitacao G ON G.codigo = GP.grupoResponsavel
                LEFT JOIN Ntl.responsavel R ON R.codigo = GPD.responsavel";
                $where = " WHERE (0 = 0) AND GP.participaPregao = 1";

                if ($_POST["portal"] != "") {
                    $portal = +$_POST["portal"];
                    $where = $where . " AND ( P.codigo = $portal)";
                }

                if ($_POST["orgaoLicitante"] != "") {
                    $orgaoLicitante = $_POST["orgaoLicitante"];
                    $where = $where . " AND ( GP.orgaoLicitante like '%' + " . "replace('" . $orgaoLicitante . "',' ','%') + " . "'%')";
                }

                if ($_POST["numeroPregao"] != "") {
                    $numeroPregao = (int)$_POST["numeroPregao"];
                    $where = $where . " AND GP.numeroPregao = " . $numeroPregao;
                }

                if ($_POST["dataPregao"] != "") {
                    $dataPregao = $_POST["dataPregao"];
                    $data = explode("/", $dataPregao);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND GP.dataPregao = '" . $data . "'";
                }

                if ($_POST["horaPregao"] != "") {
                    $horaPregao = $_POST["horaPregao"];
                    $where = $where . " AND GP.horaPregao = '" . $horaPregao . "'";
                }


                if ($_POST["condicao"] != "") {
                    $condicao = +$_POST["condicao"];
                    $where = $where . " AND GP.condicao = " . $condicao;
                } else {
                    $where = $where . " AND (GP.condicao IS NULL OR GP.condicao = 0)";
                }

                if ($_POST["ativo"] != "") {
                    $ativo = (int)$_POST["ativo"];
                    $where = $where . " AND GP.ativo = " . $ativo;
                }

                if ($_POST["tarefa"] != "") {
                    $tarefa = (int)$_POST["tarefa"];
                    $where = $where . " AND T.codigo = " . $tarefa;
                } 
  
                if ($_POST["responsavel"] != "") {
                    $responsavel = (int)$_POST["responsavel"];
                    $where = $where . " AND R.codigo = $responsavel ";
                }

                if ($_POST["tipoTarefa"] != "") {
                    $tipoTarefa = (int)$_POST["tipoTarefa"];
                    $where = $where . " AND GPD.tipo = " . $tipoTarefa . " ";
                }  

                if ($_POST["tarefaConcluida"] != "") {
                    $tarefaConcluida = +$_POST["tarefaConcluida"]; 
                    if($tarefaConcluida == 1){
                        $where = $where . " AND GPD.dataConclusao IS NOT NULL ";
                    } else { 
                        $where = $where . " AND GPD.dataConclusao IS NULL ";
                    }
                }  

                if ($_POST["resumoPregao"] != "") {
                    $resumoPregao = $_POST["resumoPregao"];
                    $where = $where . " AND ( GP.resumoPregao like '%' + " . "replace('" . $resumoPregao . "',' ','%') + " . "'%')";
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
                    $id = (int)$row['codigo'];
                    $portal = $row['descricao'];
                    $endereco = $row['endereco'];
                    $orgaoLicitante = $row['orgaoLicitante'];
                    $numeroPregao = $row['numeroPregao'];
                   

                    //A data recuperada foi formatada para D/M/Y
                    $dataPregao = $row['dataPregao'];
                    if ($dataPregao != "") {
                    $dataPregao = explode("-", $dataPregao);
                    $dataPregao = $dataPregao[2] . "/" . $dataPregao[1] . "/" . $dataPregao[0];
                    $horaPregao = $row['horaPregao'];
                    }

                    $dataConclusao = $row['dataConclusao'];
                    if ($dataConclusao != "") {
                    $dataConclusao = explode(" ", $dataConclusao);
                    $dataConclusao = explode("-", $dataConclusao[0]);
                    $dataConclusao = $dataConclusao[2] . "/" . $dataConclusao[1] . "/" . $dataConclusao[0];
                    }
                    
                    $grupo = $row['grupoResponsavel'];
                    $responsavelPregao = $row['responsavelPregao'];

                    $condicao = $row['condicao']; 

                    switch($condicao){
                        case 1 : 
                            $descricaoCondicao = 'Adiado';
                        break;
                        case 2 : 
                            $descricaoCondicao = 'Em Andamento';
                        break;
                        case 3: 
                            $descricaoCondicao = 'Cancelado';
                        break;
                        case 4: 
                            $descricaoCondicao = 'Fracassado';
                        break;
                    }

                    $ativo = $row['ativo'];  
                    $ativo == "1" ? $descricaoAtivo = 'Sim' : $descricaoAtivo = 'Não'; 
                    $tarefa = $row['tarefa'];
                    $responsavel = $row['responsavel'];
                    $tipoTarefa = $row['tipo'];
                    $tipoTarefa == "0" ? $descricaoTipoTarefa = 'Pré-Pregão' : $descricaoTipoTarefa = ''; 
 
                    $grupo = $row['grupoResponsavel'];
                    $responsavelPregao = $row['responsavelPregao'];


                    echo '<tr>';
                    echo '<td class="text-left"><a target="_blank" rel="noopener noreferrer" href="' . $endereco . '">' . $portal . '</a></td>';
                    echo '<td class="text-left">' . $orgaoLicitante . '</td>';
                    echo '<td class="text-left"><a href="licitacao_pregaoNaoIniciadoCadastro.php?id=' . $id . '">' . $numeroPregao . '</a></td>';
                    echo '<td class="text-justify">' . $dataPregao . '</td>';
                    echo '<td class="text-justify">' . $horaPregao . '</td>';
                    echo '<td class="text-justify">' . $descricaoCondicao . '</td>';
                    echo '<td class="text-justify">' . $descricaoAtivo . '</td>';
                    echo '<td class="text-justify">' . $tarefa . '</td>';
                    echo '<td class="text-left">' . $responsavel . '</td>';
                    echo '<td class="text-left">' . $descricaoTipoTarefa . '</td>'; 
                    echo '<td class="text-justify">' . $responsavelPregao . '</td>';
                    echo '<td class="text-justify">' . $grupo . '</td>';
                    echo '<td class="text-left">' . $dataConclusao . '</td>'; 
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
            "aaSorting":[],
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