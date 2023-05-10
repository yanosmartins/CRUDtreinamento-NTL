<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Nome</th>
                    <th class="text-left" style="min-width:30px;">CPF</th>
                    <th class="text-left" style="min-width:30px;">RG</th>
                    <th class="text-left" style="min-width:30px;">Data de Nascimento</th>
                    <th class="text-left" style="min-width:30px;">Estado Civil</th>
                    <th class="text-left" style="min-width:30px;">Gênero</th>
                    <th class="text-left" style="min-width:35px;">CEP</th>
                    <th class="text-left" style="min-width:35px;">Primeiro Emprego</th>
                    <th class="text-left" style="min-width:35px;">Pis/Pasep</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>
                    <th class="text-left" style="min-width:35px;">PDF</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomeFiltro = "";
                $cpfFiltro = "";
                $rgFiltro = "";
                $dataNascimentoFiltro = "";
                $dataNascimentoInicio = "";
                $dataNascimentoFim = "";
                $cepFiltro = "";
                $primeiroEmprego = "";
                $pispasep = "";

                $where = " WHERE (0 = 0)";

                if ($_POST["nomeFiltro"] != "") {
                    $nomeFiltro = $_POST["nomeFiltro"];
                    $where = $where . " AND (FU.nome like '%' + " . "replace('" . $nomeFiltro . "',' ','%') + " . "'%')";
                }
                if ($_POST["cpfFiltro"] != "") {
                    $cpfFiltro = $_POST["cpfFiltro"];
                    $where = $where . " AND (FU.cpf like '%' + " . "replace('" . $cpfFiltro . "',' ','%') + " . "'%')";
                }
                if ($_POST["rgFiltro"] != "") {
                    $rgFiltro = $_POST["rgFiltro"];
                    $where = $where . " AND (FU.rg like '%' + " . "replace('" . $rgFiltro . "',' ','%') + " . "'%')";
                }
                if ($_POST["dataNascimentoFiltro"] != "") {
                    $dataNascimentoFiltro = $_POST["dataNascimentoFiltro"];
                    $where = $where . " AND (FU.dataNascimento = '$dataNascimentoFiltro')";
                }
                $estadoCivilFiltro = "";
                $estadoCivilFiltro = $_POST["estadoCivilFiltro"];
                if ($_POST["estadoCivilFiltro"] != "") {
                    $estadoCivilFiltro = $_POST["estadoCivilFiltro"];
                    $where = $where . " AND (FU.estadoCivil ='$estadoCivilFiltro')";
                }

                $dataNascimentoInicioFiltro = "";
                $dataNascimentoInicioFiltro = $_POST["dataNascimentoInicioFiltro"];
                if ($_POST["dataNascimentoInicioFiltro"] != "") {
                    $dataNascimentoInicioFiltro = $_POST["dataNascimentoInicioFiltro"];
                    $where = $where . " AND (FU.dataNascimento >='$dataNascimentoInicioFiltro')";
                }
                $dataNascimentoFimFiltro = "";
                $dataNascimentoFimFiltro = $_POST["dataNascimentoFimFiltro"];
                if ($_POST["dataNascimentoFimFiltro"] != "") {
                    $dataNascimentoFimFiltro = $_POST["dataNascimentoFimFiltro"];
                    $where = $where . " AND (FU.dataNascimento <='$dataNascimentoFimFiltro')";
                }
                $generoFiltro = "";
                $generoFiltro = $_POST["generoFiltro"];
                if ($_POST["generoFiltro"] != "") {
                    $generoFiltro = $_POST["generoFiltro"];
                    $where = $where . " AND GF.codigo =" . $generoFiltro;
                }
                if ($_POST["cepFiltro"] != "") {
                    $cepFiltro = $_POST["cepFiltro"];
                    $where = $where . " AND (FU.cep = '$cepFiltro')";
                }
                $primeiroEmpregoFiltro = "";
                $primeiroEmpregoFiltro = $_POST["primeiroEmpregoFiltro"];
                if ($_POST["primeiroEmpregoFiltro"] != "") {
                    $primeiroEmpregoFiltro = $_POST["primeiroEmpregoFiltro"];
                    $where = $where . " AND FU.primeiroEmprego =" . $primeiroEmpregoFiltro;
                }
                $pisPasepFiltro = "";
                $pisPasepFiltro = $_POST["pisPasepFiltro"];
                if ($_POST["pisPasepFiltro"] != "") {
                    $pisPasepFiltro = $_POST["pisPasepFiltro"];
                    $where = $where . " AND (FU.pisPasep = '$pisPasepFiltro')";
                }
                $ativoFiltro = "";
                $ativoFiltro = $_POST["ativoFiltro"];
                if ($_POST["ativoFiltro"] != "") {
                    $ativoFiltro = $_POST["ativoFiltro"];
                    $where = $where . " AND FU.ativo =" . $ativoFiltro;
                }
                
                
                $sql = " SELECT FU.codigo, FU.ativo, FU.cpf, FU.rg, FU.dataNascimento, FU.estadoCivil, FU.nome, FU.cep, FU.primeiroEmprego, FU.pisPasep, GF.descricao as genero 
                from dbo.funcionario FU
                LEFT JOIN dbo.generoFuncionario GF on GF.codigo = FU.genero";
                //   $sql = "SELECT GF.codigo, GF.descricao, F.ativo  from dbo.generoFuncionario AS GF
                //   // LEFT JOIN dbo.funcionario as F on F.genero = GF.codigo";                
                //  $sql = " SELECT codigo, descricao from dbo.generoFuncionario
                //  ";

                $sql = $sql . $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {
                    $id = (int) $row['codigo'];
                    $nomeFiltro = $row['nome'];
                    $cpfFiltro = $row['cpf'];;
                    $rgFiltro = $row['rg'];
                    $generoFiltro = $row['genero'];
                    $cepFiltro = $row['cep'];
                    $primeiroEmpregoFiltro = $row['primeiroEmprego'];
                    $pisPasepFiltro = $row['pisPasep'];

                    $dataNascimentoFiltro = $row['dataNascimento'];
                    if ($dataNascimentoFiltro) {
                        $dataNascimentoFiltro = explode(" ", $dataNascimentoFiltro);
                        $data = explode("-", $dataNascimentoFiltro[0]);
                        $dataNascimentoFiltro = ($data[2] . "/" . $data[1] . "/" . $data[0]);
                    }

                    // $estadoCivilFiltro = (int)$row['estadoCivil'];
                    // if ($estadoCivilFiltro == 1) {
                    //     $estadoCivilFiltro = "Solteiro";
                    // }
                    // if ($estadoCivilFiltro == 2) {
                    //     $estadoCivilFiltro = "Casado";
                    // }
                    // if ($estadoCivilFiltro == 3) {
                    //     $estadoCivilFiltro = "Separado";
                    // }
                    // if ($estadoCivilFiltro == 4) {
                    //     $estadoCivilFiltro = "Divorciado";
                    // }
                    // if ($estadoCivilFiltro == 5) {
                    //     $estadoCivilFiltro = "Viúvo";
                    // }

                    // USANDO O PHP MATCH, EU CONSIGO REDUZIR A QUANTIDADE DE BLOCOS CONDICIONAIS
                    $estadoCivilFiltro = (int)$row['estadoCivil'];

                    $valor_de_retorno = match ($estadoCivilFiltro) {
                        1 => 'Solteiro',
                        2 => 'Casado',
                        3 => 'Separado',
                        4 => 'Divorciado',
                        5 => 'Viúvo'
                    };
                    $estadoCivilFiltro = $valor_de_retorno;



                    $ativoFiltro = (int) $row['ativo'];
                    if ($ativoFiltro == 1) {
                        $ativoFiltro = "Sim";
                    } else {
                        $ativoFiltro = "Não";
                    }
                    $primeiroEmpregoFiltro = (int) $row['primeiroEmprego'];
                    if ($primeiroEmpregoFiltro == 1) {
                        $primeiroEmpregoFiltro = "Sim";
                    } else {
                        $primeiroEmpregoFiltro = "Não";
                    }


                    echo '<tr >';
                    echo '<td class="text-left"><a href="cadastroFuncionario.php?id=' . $id . '">' . $nomeFiltro . '</a></td>';
                    echo '<td class="text-left">' . $cpfFiltro . '</td>';
                    echo '<td class="text-left">' . $rgFiltro . '</td>';
                    echo '<td class="text-left">' . $dataNascimentoFiltro . '</td>';
                    echo '<td class="text-left">' . $estadoCivilFiltro . '</td>';
                    echo '<td class="text-left">' . $generoFiltro . '</td>';
                    echo '<td class="text-left">' . $cepFiltro . '</td>';
                    echo '<td class="text-left">' . $primeiroEmpregoFiltro . '</td>';
                    echo '<td class="text-left">' . $pisPasepFiltro . '</td>';
                    echo '<td class="text-left">' . $ativoFiltro . '</td>';
                    // echo '<td class="text-left"><button type="button" class="btnPdfFuncionario btn btn-info"><i class="fa fa-file-pdf-o"></i></button></td>';
                    echo '<td class="text-left"><a href="pdfExemplo.php?id=' . $id  .'" class="btnPdfFuncionario btn btn-info"><i class="fa fa-file-pdf-o"></i></button></td>';
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
<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script>
    $(document).ready(function() {

        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };


        $('.btnPdfFuncionario').on("click", function() {
            pdfFuncionario();
        });

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({
            // Tabletools options: 
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sLengthMenu": "_MENU_ Resultados por página",
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
            "oTableTools": {
                "aButtons": ["copy", "csv", "xls", {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }
                ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
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

    });


    function pdfFuncionario() {
        $(location).attr('href', 'pdfExemplo.php?id= ');
       
    }

//     function listarRelatorioFuncionariosAfetados(codRelatorio) {
//         var id =
//     // var dataRelatorio = dataRelatorio;
//     // var dataValidade = dataValidade;
//     var codRelatorio = codRelatorio;
//     $('#resultadoFuncionariosAfetadosBusca').load('saudeSegurancaTrabalho_PPRAFiltroHistoricoListagem.php?', {
//       // dataRelatorio: dataRelatorio,
//       // dataValidade: dataValidade,
//       codRelatorio: codRelatorio
//     });
// }

</script>