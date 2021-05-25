<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('ENTRADAITEM_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('ENTRADAITEM_GRAVAR', $arrayPermissao, true));

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

$page_title = "Entrada Material";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['estoque']['sub']['operacao']['sub']['entradaItem']["active"]  = true;

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
                                                                <label class="label">Cliente/Fornecedor</label>
                                                                <label class="input">
                                                                    <input id="clienteFornecedorId" name="clienteFornecedorId" type="hidden" value="">
                                                                    <input id="clienteFornecedor" name="clienteFornecedorFiltro" autocomplete="off" class="form-control" placeholder="Digite o codigo..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Número NF</label>
                                                                <label class="input">
                                                                    <input id="numero" name="numero" maxlength="255" autocomplete="off" class="" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Lançamento – Inicio</label>
                                                                <label class="input">
                                                                    <input id="dataInicial" name="dataInicial" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Lançamento – Fim</label>
                                                                <label class="input">
                                                                    <input id="dataFinal" name="dataFinal" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label"> Descrição Item</label>
                                                                <label class="input">
                                                                    <input id="descricaoItemId" name="descricaoItemId" type="hidden" value="">
                                                                    <input id="descricaoItem" name="descricaoItemFiltro" autocomplete="off" class="form-control " placeholder="Digite a descrição..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Código Material</label>
                                                                <label class="input">
                                                                    <input id="codigoItemId" name="codigoItemId" type="hidden" value="">
                                                                    <input id="codigoItem" name="codigoItemFiltro" autocomplete="off" class="form-control " placeholder="Digite o codigo..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Emissão – Inicio</label>
                                                                <label class="input">
                                                                    <input id="dataInicialEmissao" name="dataInicialEmissao" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Emissão – Fim</label>
                                                                <label class="input">
                                                                    <input id="dataFinalEmissao" name="dataFinalEmissao" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="unidadeDestino">Unidade Destino</label>
                                                                <label class="select">
                                                                    <select id="unidadeDestino" name="unidadeDestino" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.unidade where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="estoqueDestino">Estoque</label>
                                                                <label class="select">
                                                                    <select id="estoqueDestino" name="estoqueDestino" class="readonly" disabled>
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Estoque.estoque where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="tipo">Tipo</label>
                                                                <label class="select">
                                                                    <select id="tipo" name="tipo" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Estoque.tipoDocumento where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Entrada – Inicio</label>
                                                                <label class="input">
                                                                    <input id="dataInicialEntrada" name="dataInicialEntrada" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Entrada – Fim</label>
                                                                <label class="input">
                                                                    <input id="dataFinalEntrada" name="dataFinalEntrada" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
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
<script src="<?php echo ASSETS_URL; ?>/js/business_fornecimentoMaterial.js" type="text/javascript"></script>

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


        $('#btnSearch').on("click", function() {
            listarFiltro();
        });

        $('#btnNovo').on("click", function() {
            novo();
        });

        $("#data").on("change", function() {
            validaCampoData("#data");
        });

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

        $("#codigoItem").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroEntradaItem.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaCodigoAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                                descricaoItem: item.descricaoItem,
                                unidade: item.unidade,
                                estoque: item.estoque,
                                unidadeItem: item.unidadeItem,
                                consumivel: item.consumivel,
                                autorizacao: item.autorizacao
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#codigoItemId").val(ui.item.id);
                $("#codigoItemFiltro").val(ui.item.nome);
                var descricaoId = $("#codigoItemId").val();
                $("#codigoItem").val(descricaoId)
                $("#codigoItemFiltro").val('');

                var descricaoItem = ui.item.descricaoItem;
                $("#descricaoItemFiltro").val(descricaoItem);
                $("#descricaoItemId").val(descricaoId);
                $("#descricaoItem").val(descricaoItem);
                $("#descricaoItemFiltro").val('');

            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#codigoItemId").val('');
                    $("#codigoItemFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };


        $("#descricaoItem").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroEntradaItem.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaDescricaoAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                                codigoItem: item.codigoItem,
                                unidade: item.unidade,
                                estoque: item.estoque,
                                unidadeItem: item.unidadeItem,
                                consumivel: item.consumivel,
                                autorizacao: item.autorizacao
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#descricaoItemId").val(ui.item.id);
                $("#descricaoItemFiltro").val(ui.item.nome);
                var descricaoId = $("#descricaoItemId").val();
                $("#descricaoItem").val(descricaoId)
                $("#descricaoItemFiltro").val('');

                var codigoItem = ui.item.codigoItem;
                $("#codigoItemFiltro").val(codigoItem);
                $("#codigoItemId").val(descricaoId);
                $("#codigoItem").val(codigoItem);
                $("#codigoItemFiltro").val('');
            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#descricaoItemId").val('');
                    $("#descricaoItemsFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };

        $("#unidadeDestino").on("change", function() {
            popularComboEstoque();
        });
    });

    function novo() {
        $(location).attr('href', 'estoque_entradaMaterialCadastro.php');
    }

    function popularComboEstoque() {
        var unidadeDestino = $("#unidadeDestino").val()
        populaComboEstoque(unidadeDestino,
            function(data) {
                var atributoId = '#' + 'estoqueDestino';
                if (data.indexOf('failed') > -1) {
                    smartAlert("Aviso", "A unidade informada não possui estoques!", "info");
                    $("#unidade").focus()
                    $("#estoqueDestino").val("")
                    $("#estoqueDestino").prop("disabled", true)
                    $("#estoqueDestino").addClass("readonly")
                    return;
                } else {
                    $("#estoqueDestino").prop("disabled", false)
                    $("#estoqueDestino").removeClass("readonly")
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");

                    var mensagem = piece[0];
                    var qtdRegs = piece[1];
                    var arrayRegistros = piece[2].split("|");
                    var registro = "";

                    $(atributoId).html('');
                    $(atributoId).append('<option></option>');

                    for (var i = 0; i < qtdRegs; i++) {
                        registro = arrayRegistros[i].split("^");
                        $(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
                    }
                }
            }
        );
    }

    function listarFiltro() {
        var clienteFornecedorId = $('#clienteFornecedorId').val();
        var dataInicial = $('#dataInicial').val();
        var dataFinal = $('#dataFinal').val();
        var dataInicialEntrada = $('#dataInicialEntrada').val();
        var dataFinalEntrada = $('#dataFinalEntrada').val();
        var dataInicialEmissao = $('#dataInicialEmissao').val();
        var dataFinalEmissao = $('#dataFinalEmissao').val();
        var tipo = $('#tipo').val();
        var estoqueDestino = $('#estoqueDestino').val();
        var numero = $('#numero').val();
        var codigoItemId = $('#codigoItemId').val();

        $('#resultadoBusca').load('estoque_entradaMaterialFiltroListagem.php?', {
            clienteFornecedorId: clienteFornecedorId,
            dataInicial: dataInicial,
            dataFinal: dataFinal,
            tipo: tipo,
            estoqueDestino: estoqueDestino,
            numero: numero,
            codigoItemId: codigoItemId
        });
    }
</script>