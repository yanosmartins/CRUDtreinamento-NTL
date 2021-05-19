<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Funcionario</th>
                    <th class="text-left" style="min-width:35px;">Projeto</th>
                    <th class="text-left" style="min-width:35px;">Idade</th>
                    <th class="text-left" style="min-width:35px;">Validade ASO</th>
                    <th class="text-left" style="min-width:35px;">Dias vencido</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $hoje = date('Y-m-d');
                $sql = "SELECT ASO.codigo,ASO.funcionario,P.descricao,F.nome,ASO.projeto,ASO.ativo,ASO.dataProximoAso,DATEDIFF(yy,ASO.dataNascimento,'$hoje') AS 'idade',DATEDIFF(dd,ASO.dataProximoAso,'$hoje') AS 'diasAtraso' FROM funcionario.atestadoSaudeOcupacional ASO
                 INNER JOIN ntl.funcionario F ON F.codigo = ASO.funcionario
                 INNER JOIN ntl.projeto P ON P.codigo = ASO.projeto WHERE (0 = 0)  ";

                $codigo = (int)$_GET["codigo"];
                $funcionario = (int)$_GET["funcionario"];
                $projeto = (int)$_GET["projeto"];
                $ativo = $_GET["ativo"];
                $dataValidadeAsoInicio = $_GET["dataValidadeAsoInicio"];
                $dataValidadeAsoFim = $_GET["dataValidadeAsoFim"];
                $campo1 = $dataValidadeAsoInicio;
                $campo2 = $dataValidadeAsoFim;
                $idadeInicio = $_GET["idadeInicio"];
                $idadeFim = $_GET["idadeFim"];
                $vencido = $_GET["vencido"];

                if ($campo1 === $dataValidadeAsoInicio) {
                    if($campo1 != "") {
                    $dataValidadeAsoInicio = str_replace('/', '-', $dataValidadeAsoInicio);
                    $dataValidadeAsoInicio = date("Y-m-d", strtotime($dataValidadeAsoInicio));
                    }
                }

                if ($campo2 === $dataValidadeAsoFim) {
                    if($campo2 != "") {
                    $dataValidadeAsoFim = str_replace('/', '-', $dataValidadeAsoFim);
                    $dataValidadeAsoFim = date("Y-m-d", strtotime($dataValidadeAsoFim));
                    }
                }

                if ($codigo > 0) {
                    $where .= $where . " AND codigo = " . $codigo;
                }

                if ($funcionario > 0) {
                    $where .= $where . " AND funcionario = " . $funcionario;
                }

                if ($projeto > 0) {
                    $where .= $where . " AND projeto = " . $projeto;
                }

                if ($ativo != "") {
                    $where .= $where . " AND ASO.ativo = " . $ativo;
                }
               
                if (($dataValidadeAsoInicio != "") && ($dataValidadeAsoFim != "")) {
                    $where .= $where . " AND ASO.dataProximoAso BETWEEN " . "'" . $dataValidadeAsoInicio .  "'" . "AND" .  "'" . $dataValidadeAsoFim .  "'";
                } else if ($dataValidadeAsoInicio != ""){
                    $where .= $where . " AND ASO.dataProximoAso > " . "'" . $dataValidadeAsoInicio .  "'";
                } else if ($dataValidadeAsoFim != "") {
                    $where .= $where . " AND ASO.dataProximoAso < " . "'" . $dataValidadeAsoFim .  "'";
                }
                if($idadeInicio > 0 && $idadeFim >0){
                    $where .= $where . " AND DATEDIFF(yy,ASO.dataNascimento,'$hoje') BETWEEN " . "'" . $idadeInicio .  "'" . "AND" .  "'" . $idadeFim .  "'";

                }  else if($idadeInicio > 0) {
                    $where .= $where . " AND DATEDIFF(yy,ASO.dataNascimento,'$hoje') > " . "'" . $idadeInicio .  "'";
                }else if($idadeFim > 0) {
                    $where .= $where . " AND DATEDIFF(yy,ASO.dataNascimento,'$hoje') < " . "'" . $idadeFim .  "'";
                }
                if($vencido == 1) {
                    $where .= $where . " AND DATEDIFF(dd,'$hoje',ASO.dataProximoAso) < " . 0;
                } 
                if ($vencido == 2){
                    $where .= $where . " AND DATEDIFF(dd,'$hoje',ASO.dataProximoAso) > " . 0;
                }
                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id = (int) $row['codigo'];
                    $nomeFuncionario = (string)$row['nome'];
                    $projeto = (string)$row['descricao'];
                    $ativo = $row['ativo'];
                    $dataValidadeAso = $row['dataProximoAso'];
                    $idade = $row['idade'];
                    $diasAtraso = $row['diasAtraso'];
                    
                    if($diasAtraso < 0) {
                        $diasAtraso = 0;
                    }
                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else {
                        $ativo = "Não";
                    }


                    $dataValidadeAso = explode("-",$dataValidadeAso);
                    $diaCampo = explode(" ",$dataValidadeAso[2]);
                    $dataValidadeAso = $diaCampo[0] . "/" .$dataValidadeAso[1] . "/" .$dataValidadeAso[0];
                    

                    echo '<tr >';
                    echo '<td class="text-left"><a href="funcionario_atestadoSaudeOcupacional.php?codigo=' . $id . '">' . $nomeFuncionario . '</a></td>';
                    echo '<td class="text-left">' . $projeto . '</td>';
                    echo '<td class="text-left">' . $idade .  '</td>';
                    echo '<td class="text-left">' . $dataValidadeAso . '</td>';
                    echo '<td class="text-left">' . $diasAtraso .'</td>';
                    echo '<td class="text-left">' . $ativo . '</td>';
                    echo '</tr >';
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