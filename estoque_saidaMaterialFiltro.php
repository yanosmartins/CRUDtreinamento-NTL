<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PEDIDOMATERIAL_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PEDIDOMATERIAL_GRAVAR', $arrayPermissao, true));

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

$page_title = "Saída Material";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['estoque']['sub']['operacao']['sub']['saidaMaterial']["active"]  = true;


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
                            <h2>Saída Material</h2>
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
                                                            <section class="col col-2">
                                                                <label class="label" for="filtrarPor">Filtrar por</label>
                                                                <label class="select">
                                                                    <select id="filtrarPor" name="filtrarPor" class="">
                                                                        <option value="0">Material</option>
                                                                        <option value="1">Saída</option>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong></strong></legend>
                                                                </section>
                                                            </div>
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
                                                            <section class="col col-2" id="sectionDataEntradaInicial">
                                                                <label class="label">Data de Entrada – Inicio</label>
                                                                <label class="input">
                                                                    <input id="dataEntradaInicial" name="dataEntradaInicial" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2" id="sectionDataEntradaFinal">
                                                                <label class="label">Data de Entrada – Fim</label>
                                                                <label class="input">
                                                                    <input id="dataEntradaFinal" name="dataEntradaFinal" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2" id="sectionFechado" hidden>
                                                                <label class="label" for="fechado">Fechado</label>
                                                                <label class="select">
                                                                    <select id="fechado" name="fechado" class="">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="2">Não</option>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="localizacaoItem">Unidade</label>
                                                                <label class="select">
                                                                    <select id="unidade" name="unidade" class="">
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM Ntl.unidade WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="estoque">Estoque</label>
                                                                <label class="select">
                                                                    <select id="estoque" name="estoque" class="readonly" disabled>
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM Estoque.estoque WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2" id="sectionSituacao">
                                                                <label class="label" for="situacao">Situação</label>
                                                                <label class="select">
                                                                    <select id="situacao" name="situacao" class="">
                                                                        <option></option>
                                                                        <option value="1">Entrada</option>
                                                                        <option value="4">Entrada por transferência</option>
                                                                        <option value="6">Entrada por doação</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2" id="sectionSituacaoItem">
                                                                <label class="label" for="situacaoItem">Situação Item</label>
                                                                <label class="select">
                                                                    <select id="situacaoItem" name="situacaoItem" class="">
                                                                        <option></option>
                                                                        <option value="1">Disponível</option>
                                                                        <option value="2">Não Disponível</option>
                                                                        <!-- <option value="3">Reservado</option>
                                                                        <option value="4">Fornecido</option> -->
                                                                    </select><i></i>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroCodigoItem.js" type="text/javascript"></script>

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

        $("#unidade").on("change", function() {
            popularComboEstoque()
        });
        $("#filtrarPor").on("change", function() {
            let filtrarPor = $("#filtrarPor").val();
            if (filtrarPor == 1){
                $("#sectionDataEntradaInicial").attr('hidden', true);
                $("#sectionDataEntradaInicial").addClass('hidden');
                $("#sectionDataEntradaFinal").attr('hidden', true);
                $("#sectionDataEntradaFinal").addClass('hidden');
                $("#sectionSituacao").attr('hidden', true);
                $("#sectionSituacao").addClass('hidden');
                $("#sectionSituacaoItem").attr('hidden', true);
                $("#sectionSituacaoItem").addClass('hidden');
                $("#sectionFechado").attr('hidden', false);
                $("#sectionFechado").removeClass('hidden');
                listarFiltro();
            }
            if (filtrarPor == 0){
                $("#sectionDataEntradaInicial").attr('hidden', false);
                $("#sectionDataEntradaInicial").removeClass('hidden');
                $("#sectionDataEntradaFinal").attr('hidden', false);
                $("#sectionDataEntradaFinal").removeClass('hidden');
                $("#sectionSituacao").attr('hidden', false);
                $("#sectionSituacao").removeClass('hidden');
                $("#sectionSituacaoItem").attr('hidden', false);
                $("#sectionSituacaoItem").removeClass('hidden');
                $("#sectionFechado").attr('hidden', true);
                $("#sectionFechado").removeClass('hidden');
                listarFiltro();
            }
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


    });

    function novo() {
        $(location).attr('href', 'estoque_saidaMaterialCadastro.php');
    }

    function popularComboEstoque() {
        var unidade = +$("#unidade").val()
        $("#grupoItem").val("")
        $("#grupoItem").prop("disabled", true)
        $("#grupoItem").addClass("readonly")
        if (unidade != 0) {
            populaComboEstoque(unidade,
                function(data) {
                    var atributoId = '#' + 'estoque';
                    if (data.indexOf('failed') > -1) {
                        smartAlert("Aviso", "A unidade informada não possui estoques!", "info");
                        $("#unidade").focus()
                        $("#estoque").val("")
                        $("#estoque").prop("disabled", true)
                        $("#estoque").addClass("readonly")
                        return;
                    } else {
                        $("#estoque").prop("disabled", false)
                        $("#estoque").removeClass("readonly")
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
    }

    function listarFiltro() {
        var codigoItemId = $('#codigoItemId').val();
        var situacao = $('#situacao').val();
        var situacaoItem = $('#situacaoItem').val();
        var unidade = $('#unidade').val();
        var estoque = $('#estoque').val();
        var clienteFornecedorId = $('#clienteFornecedorId').val();
        var numero = $('#numero').val();
        var dataInicialEmissao = $('#dataInicialEmissao').val();
        var dataFinalEmissao = $('#dataFinalEmissao').val();
        var dataEntradaInicial = $('#dataEntradaInicial').val();
        var dataEntradaFinal = $('#dataEntradaFinal').val();
        var filtrarPor = $('#filtrarPor').val();

        if (filtrarPor == 0) {
            $('#resultadoBusca').load('estoque_saidaMaterialMFiltroListagem.php?', {
                codigoItemId: codigoItemId,
                situacao: situacao,
                situacaoItem: situacaoItem,
                unidade: unidade,
                estoque: estoque,
                clienteFornecedorId: clienteFornecedorId,
                numero: numero,
                dataEmissaoNFInicial: dataInicialEmissao,
                dataEmissaoNFFinal: dataFinalEmissao,
                dataEntradaInicial: dataEntradaInicial,
                dataEntradaFinal: dataEntradaFinal

            });
        }
        if (filtrarPor == 1) {
            $('#resultadoBusca').load('estoque_saidaMaterialSFiltroListagem.php?', {
                codigoItemId: codigoItemId,
                situacao: situacao,
                situacaoItem: situacaoItem,
                unidade: unidade,
                estoque: estoque,
                clienteFornecedorId: clienteFornecedorId,
                numero: numero,
                dataEmissaoNFInicial: dataInicialEmissao,
                dataEmissaoNFFinal: dataFinalEmissao,
                dataEntradaInicial: dataEntradaInicial,
                dataEntradaFinal: dataEntradaFinal

            });
        }


    }
</script>