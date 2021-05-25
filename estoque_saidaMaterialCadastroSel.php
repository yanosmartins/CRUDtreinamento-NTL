<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('SAIDAMATERIAL_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('SAIDAMATERIAL_GRAVAR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

session_start();
$id = $_SESSION['funcionario'];

$arrayEstoqueMovimentoSel = "'" . $_POST['arrayEstoqueMovimentoSel'] . "'";
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
                            <h2>Saída Item</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formSaidaMaterial" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseItemEntrada" class="" id="accordionItemEntrada">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseItemEntrada" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="arrayEstoqueMovimentoSel" name="arrayEstoqueMovimentoSel" type="hidden" value="[]">
                                                        <input id="jsonItem" name="jsonItem" type="hidden" value="[]">
                                                        <div id="formItem">
                                                            <div class="row">
                                                                <input id="pagina" name="pagina" type="hidden" value="SAIDASELECIONADO">
                                                                <input id="ItemId" name="ItemId" type="hidden" value="">
                                                                <input id="sequencialItem" name="sequencialItem" type="hidden" value="">
                                                                <input id="unidadeMedidaId" name="unidadeMedidaId" type="hidden" value="">
                                                                <input id="descricaoUnidadeMedida" name="descricaoUnidadeMedida" type="hidden" value="">
                                                                <input id="situacaoId" name="situacaoId" type="hidden" value="">
                                                            </div>
                                                            <div class="row">
                                                                <input id="tipo" name="tipo" type="hidden" value="0">
                                                                <section class="col col-2">
                                                                    <label class="label">Código</label>
                                                                    <label class="input">
                                                                        <input id="codigo" name="codigo" autocomplete="off" class="form-control readonly" readonly type="text" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Data Movimento</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <?php
                                                                        $hoje = date("d/m/Y");
                                                                        $hoje = "'" . $hoje . "'";
                                                                        echo "<input id='dataMovimento' name='dataMovimento' type='text' data-dateformat='dd/mm/yy' class='readonly' style='text-align: center' value="
                                                                            . $hoje . " data-mask='99/99/9999' data-mask-placeholder='-' autocompvare='new-password' readonly>";
                                                                        ?>

                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Hora Movimento</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-clock-o"></i>
                                                                        <?php
                                                                        // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
                                                                        date_default_timezone_set('America/Sao_Paulo');
                                                                        // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
                                                                        $hora = date('H:i', time());
                                                                        $hora = "'" . $hora . "'";
                                                                        echo "<input id='horaMovimento' name='horaMovimento' class='readonly' style='text-align: center' type='text' autocompvare='new-password' value=" . $hora . " readonly>"
                                                                        ?>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Dados Solicitação</strong></legend>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <input id="login" name="login" type="hidden" value="">
                                                                <section class="col col-6">
                                                                    <label class="label">Solicitante</label>
                                                                    <label class="input">
                                                                        <?php
                                                                        $sql = "SELECT F.nome, BP.projeto FROM Ntl.funcionario F
                                                                        LEFT JOIN Ntl.beneficioProjeto BP ON BP.funcionario = F.codigo
                                                                        WHERE F.codigo =" . $id;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        if ($row = $result[0]) {
                                                                            $nome = "'" . $row['nome'] . "'";
                                                                            $projeto = $row['projeto'];
                                                                            echo "<input id='responsavelFornecimento' maxlength='255' name='responsavelFornecimento' class='readonly' type='select' value=" . $nome . " readonly>";
                                                                            echo "<input id='solicitanteId' name='solicitanteId' type='hidden' value=" . $id . ">";
                                                                        }
                                                                        ?>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    <label class="label" for="projeto">Projeto</label>
                                                                    <label class="select">
                                                                        <select id="projeto" name="projeto" class="required">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM Ntl.projeto where ativo = 1 order by descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                if ($codigo == $projeto) {
                                                                                    echo '<option value=' . $codigo . ' selected>  ' . $descricao . ' </option>';
                                                                                } else {
                                                                                    echo '<option value=' . $codigo . '>  ' . $descricao . ' </option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-6">
                                                                    <label class="label">Cliente/Fornecedor</label>
                                                                    <label class="input">
                                                                        <input id="clienteFornecedorId" name="clienteFornecedorId" type="hidden" value="">
                                                                        <input id="clienteFornecedor" name="clienteFornecedorFiltro" autocomplete="off" class="form-control required" required placeholder="Digite o cliente/fornecedor..." type="text" value="">
                                                                        <i class="icon-append fa fa-filter"></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="naturezaOperacao">Natureza Operação</label>
                                                                    <label class="select">
                                                                        <input id="naturezaOperacaoId" name="naturezaOperacaoId" type="hidden" value="">
                                                                        <select id="naturezaOperacao" name="naturezaOperacao" class="required">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM Estoque.naturezaOperacao where ativo = 1 order by descricao";
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
                                                                    <label class="label">Número da nota</label>
                                                                    <label class="input">
                                                                        <input id="notaFiscal" name="notaFiscal" maxlength="255" autocomplete="off" class="" type="text" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Data Emissão</label>
                                                                    <label class="input">
                                                                        <input id="dataEmissaoNF" name="dataEmissaoNF" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                    </label>
                                                                </section>
                                                            </div>

                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <label class="label">Motivo</label>
                                                                    <textarea id="motivo" name="motivo" class="form-control" rows="3" style="resize:vertical" autocompvare="off"></textarea>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableItem" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Código Material</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Material</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Estoque</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Nota Fiscal</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Valor</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Fornecedor</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <footer>
                                            <!-- <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
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
                                            </div> -->
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


<script src="<?php echo ASSETS_URL; ?>/js/business_saidaMaterial.js" type="text/javascript"></script>


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
    var arrayEstoqueMovimentoSel = [];

    if (arrayEstoqueMovimentoSel !== null) {
        $('#JsonEstoqueMovimentoSel').val(JSON.stringify(arrayEstoqueMovimentoSel));
    }
    jsonItemArray = JSON.parse($("#jsonItem").val());

    $(document).ready(function() {

        carregaPagina();

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


        $("#clienteFornecedor").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroFornecimentoMaterial.php',
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

        $("#notaFiscal").on("change", function() {
            $notaFiscal = $("#notaFiscal").val();

            if ($notaFiscal != '') {
                if (jsonItemArray.length != 0) {
                    for (i = jsonItemArray.length - 1; i >= 0; i--) {
                        jsonItemArray[i].situacaoId = 3;
                        $("#jsonItem").val(JSON.stringify(jsonItemArray));
                    }
                }
            }
            fillTableItem();
        });


        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

    });

    function carregaPagina() {

        let arrayItem = <?php echo $arrayEstoqueMovimentoSel ?>;
        $("#jsonItem").val(arrayItem);
        jsonItemArray = JSON.parse($("#jsonItem").val());
        fillTableItem();

    }

    function voltar() {
        $(location).attr('href', 'estoque_saidaMaterialFiltro.php');
    }

    function novo() {
        $(location).attr('href', 'estoque_saidaMaterialCadastro.php');
    }

    //############################################################################## LISTA ITEM INICIO ####################################################################################################################

    function fillTableItem() {
        $("#tableItem tbody").empty();
        for (var i = 0; i < jsonItemArray.length; i++) {
            var row = $('<tr />');
            $("#tableItem tbody").append(row);
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].codigoItem + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].material + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].estoqueDescricao + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].notaFiscal + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].valor + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].fornecedor + '</td>'));

        }
    }

    //############################################################################## LISTA Filho FIM #######################################################################################################################


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

        var codigo = $('#codigo').val();
        var clienteFornecedorId = $('#clienteFornecedorId').val();
        var projeto = $('#projeto option:selected').val();
        var solicitanteId = $('#solicitanteId').val();
        var naturezaOperacao = $('#naturezaOperacao').val();
        var notaFiscal = $('#notaFiscal').val();
        var dataEmissaoNF = $('#dataEmissaoNF').val();

        if (solicitanteId === '') {
            smartAlert("Erro", "Informe o Solicitante!", "error");
            $('#solicitante').focus();
            return false;
        }
        if (projeto === '') {
            smartAlert("Erro", "Informe o Projeto!", "error");
            $('#projeto').focus();
            return false;
        }
        if (clienteFornecedorId === '') {
            smartAlert("Erro", "Informe o Fornecedor!", "error");
            $('#clienteFornecedor').focus();
            return false;
        }
        if (naturezaOperacao === '') {
            smartAlert("Erro", "Informe a Natureza da Operação!", "error");
            $('#naturezaOperacao').focus();
            return false;
        }
        if ((codigo != '') && (notaFiscal === '')) {
            smartAlert("Erro", "Informe a Nota Fical!", "error");
            $('#notaFiscal').focus();
            return false;
        }
        if ((codigo != '') && (dataEmissaoNF === '')) {
            smartAlert("Erro", "Informe a data de emissão da Nota Fical!", "error");
            $('#dataEmissaoNF').focus();
            return false;
        }
        if (jsonItemArray.length === 0) {
            smartAlert("Erro", "Nenhum item na lista!", "error");
            return false;
        }


        return true;
    }

    function gravar() {

        validaCampos();

        var form = $('#formSaidaMaterial')[0];
        var formData = new FormData(form);
        gravaSaidaMaterial(formData);
    }
</script>