<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('ENTRADAITEM_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('ENTRADAITEM_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('ENTRADAITEM_EXCLUIR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
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
                            <h2>Entrada Item</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formEntradaItem" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <div id="formCadastro">
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label">Data Movimento</label>
                                                                    <label class="input">
                                                                        <input id="dataMovimento" name="dataMovimento" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Material Origem</strong></legend>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label">Código Material</label>
                                                                    <label class="input">
                                                                        <input id="codigoItemId" name="codigoItemId" type="hidden" value="">
                                                                        <input id="codigoItem" name="codigoItemFiltro" autocomplete="off" class="form-control required" placeholder="Digite o codigo..." type="text" value="">
                                                                        <i class="icon-append fa fa-filter"></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    <label class="label"> Descrição Item</label>
                                                                    <label class="input">
                                                                        <input id="descricaoItemId" name="descricaoItemId" type="hidden" value="">
                                                                        <input id="descricaoItem" name="descricaoItemFiltro" autocomplete="off" class="form-control required" placeholder="Digite a descrição..." type="text" value="">
                                                                        <i class="icon-append fa fa-filter"></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="situacao">Situação</label>
                                                                    <label class="select">
                                                                        <select id="situacao" name="situacao" class="readonly" disabled>
                                                                            <option></option>
                                                                            <option value="1">Disponível</option>
                                                                            <option value="2">Não Disponível</option>
                                                                            <option value="3">Reservado</option>
                                                                            <option value="4">Fornecido</option>
                                                                        </select><i></i>
                                                                </section>
                                                            </div>
                                                            <div class="row">

                                                                <section class="col col-2">
                                                                    <label class="label" for="unidadeMedida">Unidade Medida</label>
                                                                    <label class="select">
                                                                        <select id="unidadeMedida" name="unidadeMedida" class="readonly" disabled>
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao, sigla FROM Estoque.unidadeItem where ativo = 1 order by sigla";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                $sigla = ($row['sigla']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . ' - ' . $sigla . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-4">
                                                                    <label class="label" for="unidade">Unidade</label>
                                                                    <label class="select">
                                                                        <select id="unidade" name="unidade" class="required">
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
                                                                <section class="col col-4">
                                                                    <label class="label" for="estoque">Estoque</label>
                                                                    <label class="select">
                                                                        <select id="estoque" name="estoque" class="required">
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
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label">Quantiidade em estoque</label>
                                                                    <label class="input">
                                                                        <input id="quantidadeEstoque" name="quantidadeEstoque" maxlength="255" min="0" autocomplete="off" class="readonly" disabled type="number" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Quantiidade</label>
                                                                    <label class="input">
                                                                        <input id="quantidade" name="quantidade" maxlength="255" min="0" autocomplete="off" class="required" type="number" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Quantiidade reservada</label>
                                                                    <label class="input">
                                                                        <input id="quantidadeReservada" name="quantidadeReservada" maxlength="255" min="0" autocomplete="off" class="readonly" disabled type="number" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Quantiidade fora de estoque</label>
                                                                    <label class="input">
                                                                        <input id="quantidadeForaEstoque" name="quantidadeForaEstoque" maxlength="255" min="0" autocomplete="off" class="readonly" disabled type="number" value="">
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Material Destino</strong></legend>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <label class="label" for="unidadeDestino">Unidade Destino</label>
                                                                    <label class="select">
                                                                        <select id="unidadeDestino" name="unidadeDestino" class="required">
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
                                                                <section class="col col-4">
                                                                    <label class="label" for="estoqueDestino">Estoque Destino</label>
                                                                    <label class="select">
                                                                        <select id="estoqueDestino" name="estoqueDestino" class="required">
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
                                                                
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <label class="label">Motivo</label>
                                                                    <textarea id="motivo" name="motivo" class="form-control" rows="3" style="resize:vertical" autocomplete="off"></textarea>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <footer>
                                            <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                                <span class="fa fa-trash"></span>
                                            </button>
                                            <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                                <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                    <span id="ui-id-2" class="ui-dialog-title">
                                                    </span>
                                                </div>
                                                <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                    <p>CONFIRMA A EXCLUSÃO ? </p>
                                                </div>
                                                <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                    <div class="ui-dialog-buttonset">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                                <span class="fa fa-floppy-o"></span>
                                            </button>
                                            <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                                <span class="fa fa-file-o"></span>
                                            </button>
                                            <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                                <span class="fa fa-backward "></span>
                                            </button>
                                        </footer>
                                </form>
                            </div>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_transferenciaMaterial.js" type="text/javascript"></script>

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
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        carregaPagina();

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '/' + mm + '/' + yyyy;
        $("#dataMovimento").val(today);


        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Excluir registro",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    excluir();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });

        $("#btnExcluir").on("click", function() {
            var id = +$("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#estoque").on("change", function() {
            let idd = $("#codigoItemId").val();
            let estoque = $("#estoque").val();
            recuperaQuantidade(idd, estoque);
        });


        $("#codigoItem").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroFornecimentoMaterial.php',
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
                                autorizacao: item.autorizacao,
                                quantidade: item.quantidade,
                                quantidadeReservada: item.quantidadeReservada,
                                quantidadeFora: item.quantidadeFora
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


                $("#unidade").val(ui.item.unidade);
                popularComboEstoque();
                $("#estoque").val(ui.item.estoque);
                $("#quantidadeEstoque").val(ui.item.quantidade);
                $("#quantidadeReservada").val(ui.item.quantidadeReservada);
                $("#quantidadeForaEstoque").val(ui.item.quantidadeFora);

                $("#unidadeMedida").val(ui.item.unidadeItem);
                $("#consumivel").val(ui.item.consumivel);
                $("#autorizacao").val(ui.item.autorizacao);

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
                    url: 'js/sqlscope_cadastroFornecimentoMaterial.php',
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
                                autorizacao: item.autorizacao,
                                quantidade: item.quantidade,
                                quantidadeReservada: item.quantidadeReservada,
                                quantidadeFora: item.quantidadeFora
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


                $("#unidade").val(ui.item.unidade);
                popularComboEstoque();
                $("#estoque").val(ui.item.estoque);
                $("#quantidadeEstoque").val(ui.item.quantidade);
                $("#quantidadeReservada").val(ui.item.quantidadeReservada);
                $("#quantidadeForaEstoque").val(ui.item.quantidadeFora);

                $("#unidadeMedida").val(ui.item.unidadeItem);
                $("#consumivel").val(ui.item.consumivel);
                $("#autorizacao").val(ui.item.autorizacao);
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


        // $("#dataEntrega").on("change", function() {
        //     var dataAtual = moment().format("DD/MM/YYYY");
        //     var dataEntrega = $("#dataEntrega").val();

        //     //Transformando em um objeto usando moment -> Data Atual
        //     dataAtual = dataAtual.split("/");
        //     dataAtual[1] = dataAtual[1] - 1;
        //     dataAtual = moment([dataAtual[2], dataAtual[1], dataAtual[0]]);

        //     //ransformando em um objeto usando moment -> Data Pregão
        //     dataEntrega = dataEntrega.split("/");
        //     dataEntrega[1] = dataEntrega[1] - 1;
        //     dataEntrega = moment([dataEntrega[2], dataEntrega[1], dataEntrega[0]]);

        //     var diferenca = dataAtual.diff(dataEntrega, 'days');

        //     if (diferenca < 0) {
        //         smartAlert("Atenção", "A data do pregão não pode ser maior do que o dia de hoje !", "error");
        //         $("#dataEntrega").val(" ");
        //         return;
        //     }

        // });

        $("#tipo").on("change", function() {
            let tipo = $('#tipo option:selected').text().trim();
            if (tipo == 'NF') {
                $("#numero").removeClass('readonly');
                $("#numero").attr('disabled', false);
                $("#numero").addClass('required');
                $("#numero").attr('required', true);
            } else {
                $("#numero").removeClass('required');
                $("#numero").attr('required', false);
                $("#numero").addClass('readonly');
                $("#numero").attr('disabled', true);
            }
        });

        $("#unidade").on("change", function() {
            popularComboEstoque();
        });


        $("#quantidade").on("change", function() {
            var quantidade = $("#quantidade").val();
            var unitario = $("#unitario").val();
            var desconto = $("#desconto").val();

            if (unitario == "") {
                return;
            }
            if (desconto == "") {
                var desconto = '0';
                $("#desconto").val('0,00');
            }
            unitario = unitario.replace(/,/g, ".");
            desconto = desconto.replace(/,/g, ".");

            var total = (parseFloat(unitario) * parseFloat(quantidade)) - parseFloat(desconto);
            $("#final").val(total);
            $("#final").focusout();

        });

        $("#unitario").on("change", function() {
            var quantidade = $("#quantidade").val();
            var unitario = $("#unitario").val();
            var desconto = $("#desconto").val();

            if (quantidade == "") {
                return;
            }
            if (desconto == "") {
                var desconto = '0';
                $("#desconto").val('0,00');
            }
            unitario = unitario.replace(/,/g, ".");
            desconto = desconto.replace(/,/g, ".");

            var total = (parseFloat(unitario) * parseFloat(quantidade)) - parseFloat(desconto);
            $("#final").val(total);
            $("#final").focusout();

        });

        $("#desconto").on("change", function() {
            var quantidade = $("#quantidade").val();
            var unitario = $("#unitario").val();
            var desconto = $("#desconto").val();

            if (unitario == "") {
                return;
            }
            if (quantidade == "") {
                return;
            }
            unitario = unitario.replace(/,/g, ".");
            desconto = desconto.replace(/,/g, ".");

            var total = (parseFloat(unitario) * parseFloat(quantidade)) - parseFloat(desconto);
            $("#final").val(total);
            $("#final").focusout();

        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        //Botões de Item
        $("#btnAddItem").on("click", function() {
            if (validaItem())
                addItem();
        });

        $("#btnRemoverItem").on("click", function() {
            excluirItem();
        });

    });

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaEntradaItem(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayItem = piece[2];

                            piece = out.split("^");
                            codigo = piece[0];
                            dataEntregaMaterial = piece[1];
                            fornecedorID = piece[2];
                            descricaoFornecedor = piece[3];
                            tipoDocumento = piece[4];
                            numeroNF = piece[5];
                            dataEntrega = piece[6];
                            dataEmissaoNF = piece[7];
                            observacao = piece[8];

                            //Arrumando o valor de data 
                            dataEntregaMaterial = dataEntregaMaterial.split(" ");
                            dataEntregaMaterial = dataEntregaMaterial[0].split("-");
                            dataEntregaMaterial = dataEntregaMaterial[2] + "/" + dataEntregaMaterial[1] + "/" + dataEntregaMaterial[0];
                            // horaLancamento = dataCadastro[1].split(":");
                            // horaLancamento = horaLancamento[0] + ":" + horaLancamento[1];

                            if (dataEntrega != "") {
                                dataEntrega = dataEntrega.split(" ");
                                dataEntrega = dataEntrega[0].split("-");
                                dataEntrega = dataEntrega[2] + "/" + dataEntrega[1] + "/" + dataEntrega[0];
                            }

                            dataEmissaoNF = dataEmissaoNF.split(" ");
                            dataEmissaoNF = dataEmissaoNF[0].split("-");
                            dataEmissaoNF = dataEmissaoNF[2] + "/" + dataEmissaoNF[1] + "/" + dataEmissaoNF[0];



                            $("#codigo").val(codigo);
                            $("#dataMovimento").val(dataEntregaMaterial);
                            $("#clienteFornecedorId").val(fornecedorID);
                            $("#clienteFornecedor").val(descricaoFornecedor);
                            $("#tipo").val(tipoDocumento);
                            $("#numero").val(numeroNF);
                            $("#dataEntrega").val(dataEntrega);
                            $("#dataEmissao").val(dataEmissaoNF);
                            $("#observacao").val(observacao);

                            $("#dataMovimento").addClass('readonly');
                            $("#dataMovimento").attr('disabled', true);
                            $("#clienteFornecedor").addClass('readonly');
                            $("#clienteFornecedor").attr('disabled', true);
                            $("#tipo").addClass('readonly');
                            $("#tipo").attr('disabled', true);
                            $("#numero").addClass('readonly');
                            $("#numero").attr('disabled', true);
                            $("#dataEmissao").addClass('readonly');
                            $("#dataEmissao").attr('disabled', true);

                            $("#btnAddItem").attr('disabled', true);
                            $("#btnRemoverItem").attr('disabled', true);
                            $("#btnGravar").attr('disabled', true);

                        }
                    }
                );
            }
        }
    }

    function voltar() {
        $(location).attr('href', 'estoque_entradaMaterialFiltro.php');
    }

    function novo() {
        $(location).attr('href', 'estoque_entradaMaterialCadastro.php');
    }

    function excluir() {
        var codigo = +$("#codigo").val();

        if (codigo === 0) {
            smartAlert("Atenção", "Selecione uma Entrada Material para excluir!", "error");
            return;
        }

        excluirEntradaItem(codigo);
    }

    function popularComboEstoque() {
        var unidadeDestino = $("#unidade").val()
        populaComboEstoque(unidadeDestino,
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

    function recuperaDescricao() {
        var idd = $("#codigoItem").val();
        recuperaDescricaoCodigo(idd,
            function(data) {
                if (data.indexOf('failed') > -1) {} else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];

                    piece = out.split("^");
                    codigo = piece[0];
                    descricao = piece[1];

                    $("#descricaoItem").val(descricao);
                    $("#descricaoItemFiltro").val(codigo);

                }
            }
        );
    }

    function recuperaQuantidade(idd, estoque) {
        recuperaQuantidadeEstoque(idd, estoque,
            function(data) {
                if (data.indexOf('failed') > -1) {} else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];

                    piece = out.split("^");
                    quantidade = piece[0];
                    quantidadeReservada = piece[1];
                    quantidadeForaEstoque = piece[2];

                    $("#quantidadeEstoque").val(quantidade);
                    $("#quantidadeReservada").val(quantidadeReservada);
                    $("#quantidadeForaEstoque").val(quantidadeForaEstoque);

                }
            }
        );
    }




    function validaCampoData(campo) {
        var valor = $(campo).val();
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js
        if (validacao === false) {
            $(campo).val("");
        }
    }

    function validaData(valor) {

        if ((valor == undefined) || (valor == " ")) {
            return;
        }

        var date = valor;
        var ardt = new Array;
        var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
        ardt = date.split("/");
        erro = false;
        if (date.search(ExpReg) == -1) {
            erro = true;
        } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30))
            erro = true;
        else if (ardt[1] == 2) {
            if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                erro = true;
            if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                erro = true;
        }
        if (erro) {
            smartAlert("Erro", "O valor inserido é inválido.", "error");
            return false;
        }
        return true;
    }

    function validaCampos() {

        // var clienteFornecedorId = $('#clienteFornecedorId').val();
        // if (clienteFornecedorId === '') {
        //     smartAlert("Erro", "Informe o Fornecedor!", "error");
        //     $('#clienteFornecedor').focus();
        //     return false;
        // }

        return true;
    }

    function gravar() {

        if (!validaCampos()) {
            return;
        }

        var form = $('#formEntradaItem')[0];
        var formData = new FormData(form);
        gravaTranferenciaMaterial(formData);
    }
</script>