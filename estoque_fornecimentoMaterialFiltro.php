<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('FORNECIMENTOMATERIAL_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('FORNECIMENTOMATERIAL_GRAVAR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Fornecimento Material";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['estoque']['sub']['operacao']['sub']['fornecimentoMaterial']["active"]  = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Cadastro"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Entrada Material</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuarioFiltro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Solicitante</label>
                                                                <label class="input">
                                                                    <input id="solicitanteId" name="solicitanteId" type="hidden" value="">
                                                                    <input id="solicitante" name="solicitanteFiltro" autocomplete="off" class="form-control " placeholder="Digite o nome do solicitante..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label">Cliente/Fornecedor</label>
                                                                <label class="input">
                                                                    <input id="clienteFornecedorId" name="clienteFornecedorId" type="hidden" value="">
                                                                    <input id="clienteFornecedor" name="clienteFornecedorFiltro" autocomplete="off" class="form-control" placeholder="Digite o codigo..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.projeto where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . ' </option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label">Responsavel Fornecimento</label>
                                                                <label class="input">
                                                                    <input id="responsavelFornecimentoId" name="responsavelFornecimentoId" type="hidden" value="">
                                                                    <input id="responsavelFornecimento" name="responsavelFornecimentoFiltro" autocomplete="off" class="form-control " placeholder="Digite o nome do solicitante..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2" id="sectionAprovado">
                                                                <label class="label" for="aprovado">Aprovado</label>
                                                                <label class="select">
                                                                    <select id="aprovado" name="aprovado" class="">
                                                                        <option></option>
                                                                        <option value="0">Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2" >
                                                                <label class="label" for="tipo">Tipo</label>
                                                                <label class="select">
                                                                    <select id="tipo" name="tipo" class="">
                                                                        <option></option>
                                                                        <option value="0">Pedido</option>
                                                                        <option value="1">Fornecedor</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Inicial</label>
                                                                <label class="input">
                                                                    <input id="dataInicial" name="dataInicial" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Final</label>
                                                                <label class="input">
                                                                    <input id="dataFinal" name="dataFinal" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button id="btnSearch" type="button" class="btn btn-primary pull-right" title="Buscar">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        <button id="btnNovo" type="button" class="btn btn-primary pull-left" title="Novo" style="<?= $esconderBtnGravar ?>">
                                            <span class="fa fa-file"></span>
                                        </button>

                                    </footer>
                                </form>
                            </div>
                            <div id="resultadoBusca"></div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
        <!-- end widget grid -->
    </div>
    <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>
<!--script src="<?php echo ASSETS_URL; ?>/js/businessTabelaBasica.js" type="text/javascript"></script-->
<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script>
    $(document).ready(function() {

        listarFiltro();

        $('#btnSearch').on("click", function() {
            listarFiltro();
        });

        $('#btnNovo').on("click", function() {
            novo();
        });

        $("#data").on("change", function() {
            validaCampoData("#data");
        });

        $("#solicitante").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroFornecimentoMaterial.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaSolicitanteAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#solicitanteId").val(ui.item.id);
                $("#solicitanteFiltro").val(ui.item.nome);
                var descricaoId = $("#solicitanteId").val();
                $("#solicitante").val(descricaoId)
                $("#solicitanteFiltro").val('');

            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#solicitanteId").val('');
                    $("#solicitanteFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };

        $("#responsavelFornecimento").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroFornecimentoMaterial.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaSolicitanteAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#responsavelFornecimentoId").val(ui.item.id);
                $("#responsavelFornecimentoFiltro").val(ui.item.nome);
                var descricaoId = $("#responsavelFornecimentoId").val();
                $("#responsavelFornecimento").val(descricaoId)
                $("#responsavelFornecimentoFiltro").val('');

            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#responsavelFornecimentoId").val('');
                    $("#responsavelFornecimentoFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };

        $("#clienteFornecedor").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroEntradaItem.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaClienteFornecedorAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#clienteFornecedorId").val(ui.item.id);
                $("#clienteFornecedorFiltro").val(ui.item.nome);
                var descricaoId = $("#clienteFornecedorId").val();
                $("#clienteFornecedor").val(descricaoId)
                $("#clienteFornecedorFiltro").val('');

            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#clienteFornecedorId").val('');
                    $("#clienteFornecedorFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };

    });

    function novo() {
        $(location).attr('href', 'estoque_fornecimentoMaterialCadastro.php');
    }

    function listarFiltro() {
        var clienteFornecedorId = $('#clienteFornecedorId').val();
        var solicitanteId = $('#solicitanteId').val();
        var projeto = $('#projeto').val();
        var responsavelFornecimentoId = $('#responsavelFornecimentoId').val();
        var dataInicial = $('#dataInicial').val();
        var dataFinal = $('#dataFinal').val();
        var aprovado = $('#aprovado').val();
        var tipo = $('#tipo').val();

        $('#resultadoBusca').load('estoque_fornecimentoMaterialFiltroListagem.php?', {
            clienteFornecedorId: clienteFornecedorId,
            solicitanteId: solicitanteId,
            projeto: projeto,
            responsavelFornecimentoId: responsavelFornecimentoId,
            dataInicial: dataInicial,
            dataFinal: dataFinal,
            aprovado: aprovado,
            tipo: tipo
        });
    }
</script>