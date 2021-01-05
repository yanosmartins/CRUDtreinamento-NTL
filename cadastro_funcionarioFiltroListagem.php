<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Funcionário</th>
                    <th class="text-left" style="min-width:35px;">CPF</th>
                    <th class="text-left" style="min-width:35px;">Data de Admissão</th>
                     <th class="text-left" style="min-width:35px;">Data de Demissão</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $nome = "";
                $cpf= "";
                $dataAdmissaoFuncionario = "";
                $dataDemissaoFuncionario = "";
                $ativo = ""; 


                
                $where = "WHERE (0 = 0)";

                $sql = "SELECT codigo, nome, cpf, dataAdmissaoFuncionario, dataDemissaoFuncionario, ativo FROM Ntl.funcionario ";
 
                if ($_GET["nome"] != "") {
                    $nome = $_GET["nome"];
                    $where = $where . " and (nome like '%' + " . "replace('" . $nome . "',' ','%') + " . "'%')";
                }

                if ($_GET["cpf"] != "") {
                    $cpf = $_GET["cpf"];
                    $where = $where . " and (cpf like '%' + " . "replace('" . $cpf . "',' ','%') + " . "'%')";
                }

                if ($_GET["dataAdmissao"] != "") {
                    $dataAdmissaoFuncionario = $_GET["dataAdmissao"]; 

                    $dataAdmissaoFuncionario = explode("/", $dataAdmissaoFuncionario);
                    $dataAdmissaoFuncionario = $dataAdmissaoFuncionario[2] . "/" . $dataAdmissaoFuncionario[1] . "/" . $dataAdmissaoFuncionario[0];
                    $dataAdmissaoFuncionario = "'" . $dataAdmissaoFuncionario . "'";

                    $where = $where . " and dataAdmissaoFuncionario >= " . $dataAdmissaoFuncionario;
                }
                
                 if ($_GET["dataDemissao"] != "") {
                    $dataDemissaoFuncionario = $_GET["dataDemissao"];

                    $dataDemissaoFuncionario = explode("/", $dataDemissaoFuncionario);
                    $dataDemissaoFuncionario = $dataDemissaoFuncionario[2] . "/" . $dataDemissaoFuncionario[1] . "/" . $dataDemissaoFuncionario[0];
                    $dataDemissaoFuncionario = "'" . $dataDemissaoFuncionario . "'";

                    $where = $where . " and dataDemissaoFuncionario >= " . $dataDemissaoFuncionario;
                }
                
                if ($_GET["ativo"] != "") {
                    $ativo = $_GET["ativo"];
                    $where = $where . " and ativo = " . $ativo;
                }
  
                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                while (($row = odbc_fetch_array($result))) {
                    $id = +$row['codigo'];
                    $nome = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');
                    $cpf = mb_convert_encoding($row['cpf'], 'UTF-8', 'HTML-ENTITIES');
                    $dataAdmissaoFuncionario =  mb_convert_encoding($row['dataAdmissaoFuncionario'], 'UTF-8', 'HTML-ENTITIES');
                    $dataDemissaoFuncionario =  mb_convert_encoding($row['dataDemissaoFuncionario'], 'UTF-8', 'HTML-ENTITIES');
              
                    // Pega apenas o dia cadastrado da Admissão
                    $dataAdmissaoFuncionario = explode("-", $dataAdmissaoFuncionario);
                    $diaDataAdmissaoFuncionario = explode(" ",$dataAdmissaoFuncionario[2]);
                    $dataAdmissaoFuncionario = $diaDataAdmissaoFuncionario[0] . "/". $dataAdmissaoFuncionario[1] . "/" . $dataAdmissaoFuncionario[0]; 
                   
                    // Pega apenas o dia cadastrado da Demissão
                    if($dataDemissaoFuncionario != ""){
                    $dataDemissaoFuncionario = explode("-", $dataDemissaoFuncionario);
                    $diaDataDemissaoFuncionario = explode(" ",$dataDemissaoFuncionario[2]);
                    $dataDemissaoFuncionario = $diaDataDemissaoFuncionario[0] . "/". $dataDemissaoFuncionario[1] . "/" . $dataDemissaoFuncionario[0]; 
                    }
                    else {
                        $dataDemissaoFuncionario = " ";
                    }
                    
                    $ativo = +$row['ativo'];
 
                    if ($ativo == 1) {
                        $ativo = "Sim";
                    } else {
                        $ativo = "Não";
                    }
                     
 
                    echo '<tr >';
                    echo '<td class="text-left"><a href="cadastro_funcionarioCadastro.php?codigo=' . $id . '">' . $nome . '</a></td>';
                    echo '<td class="text-left">' . $cpf . '</td>';
                    echo '<td class="text-left">' . $dataAdmissaoFuncionario . '</td>';
                    echo '<td class="text-left">' . $dataDemissaoFuncionario . '</td>';
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

<link rel="stylesheet" type="text/css" href="js/plugin/Buttons-1.5.2/css/buttons.dataTables.min.css"/>

<script type="text/javascript" src="js/plugin/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function () {
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
                {extend: 'excel', className: 'btn btn-default'},
                {extend: 'pdf', className: 'btn btn-default'},
                        //{extend: 'print', className: 'btn btn-default'}
            ],
            "autoWidth": true,

            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

        /* END TABLETOOLS */
    });
</script>
