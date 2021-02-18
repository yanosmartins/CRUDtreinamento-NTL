<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Código</th>
                    <th class="text-left" style="min-width:30px;">Funcionário</th>
                    <th class="text-left" style="min-width:30px;">Data Solicitação</th>
                    <th class="text-left" style="min-width:30px;">Hora Solicitação</th>
                    <th class="text-left" style="min-width:30px;">Projeto</th>
                    <th class="text-left" style="min-width:30px;">Data Limite</th>
                    <th class="text-left" style="min-width:30px;">Urgente</th>
                    <th class="text-left" style="min-width:30px;">Ativo</th>
                    <th class="text-left" style="min-width:30px;">Endereço</th>
                    <th class="text-left" style="min-width:110px;">Responsável</th>
                </tr>
            </thead>
            <tbody>
                <?php
                

                $sql = " SELECT S.codigo, S.funcionario, F.nome, S.dataSolicitacao, S.horaSolicitacao, S.dataLimite, 
                S.urgente, S.projeto, P.descricao AS nomeProjeto, S.endereco, S.responsavel, FR.nome AS nomeResponsavel, S.ativo
                FROM mensageria.solicitacao S 
                LEFT JOIN Ntl.funcionario F ON F.codigo = S.funcionario
                LEFT JOIN Ntl.projeto P ON P.codigo = S.projeto
                LEFT JOIN Ntl.funcionario FR ON FR.codigo = S.responsavel";
                $where = " WHERE (0 = 0)";

                if ($_POST["funcionario"] != "") {
                    $funcionario = +$_POST["funcionario"];
                    $where = $where . " AND ( S.funcionario = $funcionario)";
                }
                
                if ($_POST["data"] != "") {
                    $dataSolicitacao = $_POST["data"];
                    $data = explode("/", $dataSolicitacao);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0]."%";
                    $where = $where . " AND CONVERT(VARCHAR(25), S.dataSolicitacao, 126) LIKE '" . $data . "'";
                }
                
                if ($_POST["hora"] != "") {
                    $horaSolicitacao = $_POST["hora"];
                    $where = $where . " AND S.horaSolicitacao = '" . $horaSolicitacao . "'";
                }

                if ($_POST["dataLimite"] != "") {
                    $dataLimite = $_POST["dataLimite"];
                    $data = explode("/", $dataLimite);
                    $data = $data[2] . "-" . $data[1] . "-" . $data[0];
                    $where = $where . " AND S.dataLimite = '" . $data . "'";
                }

                if ($_POST["urgente"] != "") {
                    $urgente = (int)$_POST["urgente"];
                    $where = $where . " AND S.urgente = " . $urgente;
                }

                if ($_POST["projeto"] != "") {
                    $projeto = (int)$_POST["projeto"];
                    $where = $where . " AND S.projeto = " . $projeto;
                }

                if ($_POST["responsavel"] != "") {
                    $responsavel = (int)$_POST["responsavel"];
                    $where = $where . " AND S.responsavel = " . $responsavel;
                }

                if ($_POST["ativo"] != "") {
                    $ativo = (int)$_POST["ativo"];
                    $where = $where . " AND S.ativo = " . $ativo;
                }

                $sql .= $where . " ORDER BY S.urgente DESC, S.dataSolicitacao, S.horaSolicitacao";
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id = (int)$row['codigo'];
                    $funcionario = $row['funcionario'];
                    $nomeFuncionario = $row['nome'];
                    $horaSolicitacao = $row['horaSolicitacao'];
                    $urgente = $row['urgente'];
                    $nomeProjeto = $row['nomeProjeto'];
                    $endereco = $row['endereco'];
                    $nomeResponsavel = $row['nomeResponsavel'];
                    $ativo = $row['ativo'];

                    //A data recuperada foi formatada para D/M/Y
                    $dataLimite = $row['dataLimite'];
                    $dataLimite = explode(" ", $dataLimite);
                    $dataLimite = $dataLimite[0];
                    $dataLimite = explode("-", $dataLimite);
                    $dataLimite = $dataLimite[2] . "/" . $dataLimite[1] . "/" . $dataLimite[0];

                    $dataSolicitacao = $row['dataSolicitacao'];
                    $dataSolicitacao = explode(" ", $dataSolicitacao);
                    $dataSolicitacao = $dataSolicitacao[0];
                    $dataSolicitacao = explode("-", $dataSolicitacao);
                    $dataSolicitacao = $dataSolicitacao[2] . "/" . $dataSolicitacao[1] . "/" . $dataSolicitacao[0];

                    $descricaoUrgente = "";
                    if($urgente == 1){
                        $descricaoUrgente = "Sim";
                    }else{
                        $descricaoUrgente = "Não";
                    }

                    $descricaoAtivo = "";
                    if($ativo == 1){
                        $descricaoAtivo = "Sim";
                    }else{
                        $descricaoAtivo = "Não";
                    }


                    echo '<tr >';
                    echo '<td class="text-left"><a href="mensageria_solicitacaoCadastro.php?id=' . $id . '">' . $id . '</a></td>';
                    echo '<td class="text-justify">' . $nomeFuncionario . '</td>';
                    echo '<td class="text-left">' . $dataSolicitacao . '</td>';
                    echo '<td class="text-left">' . $horaSolicitacao . '</td>';
                    echo '<td class="text-left">' . $nomeProjeto . '</td>';
                    echo '<td class="text-justify">' . $dataLimite . '</td>';
                    echo '<td class="text-justify">' . $descricaoUrgente . '</td>';
                    echo '<td class="text-justify">' . $descricaoAtivo . '</td>';
                    echo '<td class="text-justify">' . $endereco . '</td>';
                    echo '<td class="text-justify">' . $nomeResponsavel . '</td>';
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