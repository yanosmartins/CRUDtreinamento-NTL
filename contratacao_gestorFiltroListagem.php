<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">

                    <!-- <th class="text-left" style="min-width:30px;" scope="col">Código</th> -->

                    <th class="text-left" style="min-width:30px;" scope="col">Projeto</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Candidato</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Sindicato</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Cargo</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Salário Base</th>
                    <th class="text-left" style="min-width:70px;" scope="col">Verificado </th>
                </tr>
            </thead>
            <tbody>
                <?php

                $nomeBanco = "";
                $codigoBanco = "";

                $sql = "SELECT  P.descricao AS projeto, F.nomeCompleto, S.descricao AS sindicato, C.descricao AS cargo, CF.codigo AS codigoControleCandidato, F.codigo AS codigoCandidato, CF.salarioBase, CF.verificadoPeloGestor
                FROM Contratacao.candidato F
                LEFT JOIN Contratacao.controleCandidato CF ON F.codigo = CF.candidato
                LEFT JOIN Ntl.projeto P ON P.codigo = CF.projeto 
                LEFT JOIN Ntl.sindicato S ON S.codigoSindicatoSCI = CF.sindicato
                LEFT JOIN Ntl.cargo C ON C.codigoCargoSCI = CF.cargo 
                LEFT JOIN Contratacao.exportacao E ON E.situacao = F.codigo
                WHERE  F.aprovado = 1";
                $where = " AND (0 = 0) AND E.situacao IS NULL";


                if ($_POST["projeto"] != "") {
                    $projeto = $_POST["projeto"];
                    $where = $where . " AND (P.descricao like '%' + " . "replace('" . $projeto . "',' ','%') + " . "'%')";
                }

                if ($_POST["funcionario"] != "") {
                    $candidato = $_POST["funcionario"];
                    $where = $where . " AND (F.nomeCompleto like '%' + " . "replace('" . $candidato . "',' ','%') + " . "'%')";
                }

                if ($_POST["sindicato"] != "") {
                    $sindicato = $_POST["sindicato"];
                    $where = $where . " AND (S.descricao like '%' + " . "replace('" . $sindicato . "',' ','%') + " . "'%')";
                }

                if ($_POST["cargo"] != "") {
                    $cargo = $_POST["cargo"];
                    $where = $where . " AND (C.descricao like '%' + " . "replace('" . $cargo . "',' ','%') + " . "'%')";
                }

                if ($_POST["salarioBase"] != "") {
                    $salarioBase = toFloat($_POST["salarioBase"]);
                    $where = $where . " AND (CF.salarioBase >= $salarioBase )";
                }

                if ($_POST["verificadoPeloGestor"] != "") {
                    $verificadoPeloGestor = $_POST["verificadoPeloGestor"];

                    if ($verificadoPeloGestor == "Sim") {
                        $where = $where . " AND (CF.verificadoPeloGestor = 1)";
                    } else {
                        $where = $where . " AND (CF.verificadoPeloGestor IS NULL OR CF.verificadoPeloGestor = 0) ";
                    }
                }

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $codigo = $row['codigoControleCandidato'];
                    $codigoCandidato = $row['codigoCandidato'];
                    $nomeCompleto = $row['nomeCompleto'];
                    $descricaoProjeto = $row['projeto'];
                    $descricaoSindicato = $row['sindicato'];
                    $cargo = $row['cargo'];
                    $salarioBase = $row['salarioBase'];
                    $verificado = $row['verificadoPeloGestor'];

                    if ($descricaoProjeto == "") {
                        $descricaoProjeto =  "<b><font color='#dbc616'> Pendente </font></b>";
                    }
                    if ($descricaoSindicato == "") {
                        $descricaoSindicato =  "<b><font color='#dbc616'> Pendente </font></b>";
                    }

                    if ($cargo == "") {
                        $cargo =  "<b><font color='#dbc616'> Pendente </font></b>";
                    }

                    if ($salarioBase == "") {
                        $salarioBase =  "<b><font color='#dbc616'> Pendente </font></b>";
                    }

                    if ($verificado == "") {
                        $verificado =  "<b><font color='#dbc616'> Pendente</font></b>";
                    } else {
                        $verificado =  "<b><font color='#228B22'> Verificado </font></b>";
                    }

                    echo '<tr >';
                    echo '<td class="text-left">' . $descricaoProjeto . '</td>';
                    echo '<td class="text-left"><a href="contratacao_gestorCadastro.php?codigo=' . $codigo . '&candidato=' . $codigoCandidato . '">' . $nomeCompleto . '</a></td>';
                    echo '<td class="text-left">' . $descricaoSindicato . '</td>';
                    echo '<td class="text-left">' . $cargo . '</td>';
                    echo '<td class="text-left">' . 'R$' . number_format(round($salarioBase, 2), 2, ',', '.') . '</td>';
                    echo '<td class="text-left">' . $verificado . '</td>';
                    echo '</tr >';
                }



                function tofloat($num)
                {
                    $dotPos = strrpos($num, '.');
                    $commaPos = strrpos($num, ',');
                    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

                    if (!$sep) {
                        return floatval(preg_replace("/[^0-9]/", "", $num));
                    }

                    return floatval(
                        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
                            preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
                    );
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