<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Fornecedor</th> 
                    <th class="text-left" style="min-width:30px;">Grupo Item</th>
                    <th class="text-left" style="min-width:20px;">Telefone</th>
                    <th class="text-left" style="min-width:20px;">UF</th>
                    <th class="text-left" style="min-width:20px;">Bairro</th>
                    <th class="text-left" style="min-width:20px;">NF</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $apelido = "";
                $grupoItem = "";
                $notaFiscal = "";
               
                $where = "where (0 = 0)";
                
                $sql = "SELECT F.codigo AS fornecedor, F.apelido, F.ativo, F.notaFiscal,UF.sigla,FT.fornecedor,FT.telefone AS tel ,FT.telefonePrincipal, F.uf, F.bairro, FGI.grupoItem, GI.descricao AS grupoItem, GI.codigo FROM ntl.fornecedor F
                INNER JOIN ntl.fornecedorGrupoItem FGI ON FGI.fornecedor = F.codigo AND F.ativo = 1
                INNER JOIN Estoque.grupoItem GI ON GI.codigo = FGI.grupoItem 
                INNER JOIN ntl.unidadeFederacao UF ON F.uf = UF.sigla 
                INNER JOIN ntl.fornecedorTelefone FT ON FT.fornecedor = F.codigo AND FT.telefonePrincipal = 1 ";

                if ($_GET["apelido"] != "") {
                    $apelido = $_GET["apelido"];
                    $where = $where . " AND [fornecedor] = " . $apelido;
                }

                if ($_GET["grupoItem"] != "") {
                    $grupoItem = $_GET["grupoItem"];
                    $where = $where . " AND [grupoItem] = " . $grupoItem;
                }

                if ($_GET["tel"] != "") {
                    $telefone = $_GET["tel"];
                    $where = $where . " AND [tel] = '" .  $telefone . "'";
                }

                if ($_GET["sigla"] != "") {
                    $sigla = $_GET["sigla"];
                    $where = $where . " AND [uf] = '" .  $sigla . "'";
                }

                if ($_GET["bairro"] != "") {
                    $bairro = $_GET["bairro"];
                    $where = $where . " AND [bairro] = " . $bairro;
                }

                if ($_GET["notaFiscal"] != "") {
                    $notaFiscal = $_GET["notaFiscal"];
                    $where = $where . " AND [notaFiscal] = " . $notaFiscal;
                }
                $sql .=$where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach($result as $row) {
                    $id = (int) $row['fornecedor'];
                    $apelido = (string)$row['apelido'];
                    $grupoItem = (string)$row['grupoItem'];
                    $telefone = (string)$row['tel'];
                    $sigla = (string)$row['sigla'];
                    $bairro = (string)$row['bairro']; 
                    $notaFiscal = $row['notaFiscal'];
     
                    if ($notaFiscal == 1) {
                        $notaFiscal = "Sim";
                    } else {
                        $notaFiscal = "Não";
                    }

                    echo '<tr >';
                    echo '<td class="text-left"><a href="cadastro_fornecedorCadastro.php?codigo=' . $id . '">' . $apelido . '</a></td>';  
                    echo '<td class="text-left">' . $grupoItem . '</td>';
                    echo '<td class="text-left">' . $telefone . '</td>';
                    echo '<td class="text-left">' . $sigla . '</td>';
                    echo '<td class="text-left">' . $bairro . '</td>';       
                    echo '<td class="text-left">' . $notaFiscal . '</td>';
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
