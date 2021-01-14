<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('CANDIDATO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CANDIDATO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CANDIDATO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Candidato";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['operacao']['sub']['contratacao']['sub']["candidato"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Recursos Humanos"] = "";
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
                            <h2>Usuário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuario" method="post">
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
                                                        <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>


                                                        <!--  LISTA DE FILHOS -->
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend> Filhos de <strong>até 14 anos</strong></legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonFilho" name="jsonFilho" type="hidden" value="[]">
                                                        <div id="formFilho">

                                                            <div class="row">
                                                                <input id="filhoId" name="filhoId" type="hidden" value="">
                                                                <input id="descricaoDataNascimentoFilho" name="descricaoDataNascimentoFilho" type="hidden" value="">
                                                                <input id="sequencialFilho" name="sequencialFilho" type="hidden" value="">

                                                                <section class="col col-6">
                                                                    <label class="label" for="nomeFilho">Nome do Filhos</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="nomeFilho" name="nomeFilho" maxlength="60" autocomplete="new-password">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="cpfFilho">CPF</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="cpfFilho" name="cpfFilho" placeholder="XXX.XXX.XXX-XX" autocomplete="new-password">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="dataNascimentoFilho">Nascimento</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataNascimentoFilho" name="dataNascimentoFilho" autocomplete="new-password" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker " value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnAddFilho" type="button" class="btn btn-primary" title="Adicionar Filho">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverFilho" type="button" class="btn btn-danger" title="Remover Filho">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableFilho" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">Nome</th>
                                                                            <th class="text-left" style="min-width: 10px;">CPF</th>
                                                                            <th class="text-left" style="min-width: 10px;">Data de Nascimento</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!--  LISTA DE DEPENDENTES -->
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend> Dependentes</legend>
                                                                </section>
                                                            </div>
                                                            <input id="jsonDependente" name="jsonDependente" type="hidden" value="[]">
                                                            <div id="formDependente">

                                                                <div class="row">
                                                                    <input id="DependenteId" name="DependenteId" type="hidden" value="">
                                                                    <input id="descricaoDataNascimentoDependente" name="descricaoDataNascimentoDependente" type="hidden" value="">
                                                                    <input id="sequencialDependente" name="sequencialDependente" type="hidden" value="">

                                                                    <section class="col col-6">
                                                                        <label class="label" for="nomeDependente">Nome</label>
                                                                        <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                            <input id="nomeDependente" name="nomeDependente" maxlength="60" autocomplete="new-password">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="cpfDependente">CPF</label>
                                                                        <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                            <input id="cpfDependente" name="cpfDependente" placeholder="XXX.XXX.XXX-XX" autocomplete="new-password">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="dataNascimentoDependente">Nascimento</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="dataNascimentoDependente" name="dataNascimentoDependente" autocomplete="new-password" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker " value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-4">
                                                                        <button id="btnAddDependente" type="button" class="btn btn-primary" title="Adicionar Dependente">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverDependente" type="button" class="btn btn-danger" title="Remover Dependente">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                                <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableDependente" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
                                                                                <th class="text-left" style="min-width: 10px;">Nome</th>
                                                                                <th class="text-left" style="min-width: 10px;">CPF</th>
                                                                                <th class="text-left" style="min-width: 10px;">Data de Nascimento</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                    </fieldset>
                                                </div>
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

<!-- <script src="<?php echo ASSETS_URL; ?>/js/businessUsuario.js" type="text/javascript"></script>  -->

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

        //Jsons da página
        jsonFilhoArray = JSON.parse($("#jsonFilho").val());
        jsonDependenteArray = JSON.parse($("#jsonDependente").val());

        carregaPagina();


        //Máscaras dos campos

        $("#cpfFilho").mask("999.999.999-99", {
            placeholder: "X"
        });

        $("#cpfDependente").mask("999.999.999-99", {
            placeholder: "X"
        });

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

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });


        //Botões de Dependente
        $("#btnAddDependente").on("click", function() {
            if (validaDependente())
                addDependente();
        });

        $("#btnRemoverDependente").on("click", function() {
            excluirDependente();
        });

        //Botões de Filhos
        $("#btnAddFilho").on("click", function() {
            if (validaFilho())
                addFilho();
        });

        $("#btnRemoverFilho").on("click", function() {
            excluirFilho();
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
                recuperaUsuario(idd);
            }
        }
        $("#nome").focus();

    }

    function novo() {
        $(location).attr('href', 'contratacao_candidatoListas.php');
    }

    function voltar() {
        $(location).attr('href', 'contratacao_candidatoFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirUsuario(id);
    }

    function gravar() {
        var id = +($("#codigo").val());
        var ativo = 0;
        if ($("#ativo").is(':checked')) {
            ativo = 1;
        }
        var login = $("#login").val();
        var senha = $("#senha").val();
        var senhaConfirma = $("#senhaConfirma").val();
        var tipoUsuario = "C";
        if (login === "") {
            smartAlert("Atenção", "Informe o login !", "error");
            $("#login").focus();
            return;
        }

        gravaUsuario(id, ativo, login, senha, senhaConfirma, tipoUsuario);
    }


    //############################################################################## LISTA DEPENDENTE INICIO ####################################################################################################################

    function fillTableDependente() {
        $("#tableDependente tbody").empty();
        for (var i = 0; i < jsonDependenteArray.length; i++) {
            var row = $('<tr />');
            $("#tableDependente tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonDependenteArray[i].sequencialDependente + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaDependente(' + jsonDependenteArray[i].sequencialDependente + ');">' + jsonDependenteArray[i].nomeDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].cpfDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].descricaoDataNascimentoDependente + '</td>'));
        }
    }

    function validaDependente() {
        var achouCPF = false;
        var achouRG = false;
        var cpfDependente = $('#cpfDependente').val();
        var sequencial = +$('#sequencialDependente').val();

        if (cpfDependente === '') {
            smartAlert("Erro", "Informe o CPF do Dependente", "error");
            return false;
        }

        for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
            if (cpfDependente !== "") {
                if ((jsonDependenteArray[i].cpfDependente === cpfDependente) && (jsonDependenteArray[i].sequencialDependente !== sequencial)) {
                    achouCPF = true;
                    break;
                }
            }
        }

        if (achouCPF === true) {
            smartAlert("Erro", "Já existe o CPF do Dependente na lista.", "error");
            return false;
        }

        return true;
    }

    function addDependente() {

        var item = $("#formDependente").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataDependente
        });

        if (item["sequencialDependente"] === '') {
            if (jsonDependenteArray.length === 0) {
                item["sequencialDependente"] = 1;
            } else {
                item["sequencialDependente"] = Math.max.apply(Math, jsonDependenteArray.map(function(o) {
                    return o.sequencialDependente;
                })) + 1;
            }
            item["dependenteId"] = 0;
        } else {
            item["sequencialDependente"] = +item["sequencialDependente"];
        }

        var index = -1;
        $.each(jsonDependenteArray, function(i, obj) {
            if (+$('#sequencialDependente').val() === obj.sequencialDependente) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonDependenteArray.splice(index, 1, item);
        else
            jsonDependenteArray.push(item);

        $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
        fillTableDependente();
        clearFormDependente();

    }

    function processDataDependente(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';


        if (fieldName !== '' && (fieldId === "descricaoDataNascimentoDependente")) {

            return {
                name: fieldName,
                value: $("#dataNascimentoDependente").val()
            };
        }

        if (fieldName !== '' && (fieldId === "dataNascimentoDependente")) {

            var dataNascimentoDependente = $('#dataNascimentoDependente').val();
            dataNascimentoDependente = dataNascimentoDependente.split("/");
            dataNascimentoDependente = dataNascimentoDependente[2] + "/" + dataNascimentoDependente[1] + "/" + dataNascimentoDependente[0];

            return {
                name: fieldName,
                value: dataNascimentoDependente
            };
        }

        return false;
    }

    function clearFormDependente() {
        $("#nomeDependente").val('');
        $("#dataNascimentoDependente").val('');
        $("#cpfDependente").val('');
        $("#dependenteId").val('');
        $("#sequencialDependente").val('');
        $('#descricaoDataNascimentoDependente').val('');
    }

    function carregaDependente(sequencialDependente) {
        var arr = jQuery.grep(jsonDependenteArray, function(item, i) {
            return (item.sequencialDependente === sequencialDependente);
        });

        clearFormDependente();

        if (arr.length > 0) {
            var item = arr[0];
            $("#nomeDependente").val(item.nomeDependente);
            $("#dataNascimentoDependente").val(item.descricaoDataNascimentoDependente);
            $("#cpfDependente").val(item.cpfDependente);
            $("#dependenteId").val(item.dependenteId);
            $("#sequencialDependente").val(item.sequencialDependente);
        }
    }


    function excluirDependente() {
        var arrSequencial = [];
        $('#tableDependente input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
                var obj = jsonDependenteArray[i];
                if (jQuery.inArray(obj.sequencialDependente, arrSequencial) > -1) {
                    jsonDependenteArray.splice(i, 1);
                }
            }
            $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
            fillTableDependente();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 dependente para excluir.", "error");
    }

    //############################################################################## LISTA DEPENDENTE FIM #######################################################################################################################
    //############################################################################## LISTA FILHO INICIO ####################################################################################################################

    function fillTableFilho() {
        $("#tableFilho tbody").empty();
        for (var i = 0; i < jsonFilhoArray.length; i++) {
            var row = $('<tr />');
            $("#tableFilho tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonFilhoArray[i].sequencialFilho + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaFilho(' + jsonFilhoArray[i].sequencialFilho + ');">' + jsonFilhoArray[i].nomeFilho + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFilhoArray[i].cpfFilho + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFilhoArray[i].descricaoDataNascimentoFilho + '</td>'));
        }
    }

    function validaFilho() {
        var achouCPF = false;
        var achouRG = false;
        var cpfFilho = $('#cpfFilho').val();
        var sequencial = +$('#sequencialFilho').val();

        if (cpfFilho === '') {
            smartAlert("Erro", "Informe o CPF do Filho", "error");
            return false;
        }

        for (i = jsonFilhoArray.length - 1; i >= 0; i--) {
            if (cpfFilho !== "") {
                if ((jsonFilhoArray[i].cpfFilho === cpfFilho) && (jsonFilhoArray[i].sequencialFilho !== sequencial)) {
                    achouCPF = true;
                    break;
                }
            }
        }

        if (achouCPF === true) {
            smartAlert("Erro", "Já existe o CPF do Filho na lista.", "error");
            return false;
        }

        return true;
    }

    function addFilho() {
        debugger;
        var item = $("#formFilho").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataFilho
        });

        if (item["sequencialFilho"] === '') {
            if (jsonFilhoArray.length === 0) {
                item["sequencialFilho"] = 1;
            } else {
                item["sequencialFilho"] = Math.max.apply(Math, jsonFilhoArray.map(function(o) {
                    return o.sequencialFilho;
                })) + 1;
            }
            item["filhoId"] = 0;
        } else {
            item["sequencialFilho"] = +item["sequencialFilho"];
        }

        var index = -1;
        $.each(jsonFilhoArray, function(i, obj) {
            if (+$('#sequencialFilho').val() === obj.sequencialFilho) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonFilhoArray.splice(index, 1, item);
        else
            jsonFilhoArray.push(item);

        $("#jsonFilho").val(JSON.stringify(jsonFilhoArray));
        fillTableFilho();
        clearFormFilho();

    }

    function processDataFilho(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';



        if (fieldName !== '' && (fieldId === "descricaoDataNascimentoFilho")) {

            return {
                name: fieldName,
                value: $("#dataNascimentoFilho").val()
            };
        }

        if (fieldName !== '' && (fieldId === "dataNascimentoFilho")) {

            var dataNascimentoFilho = $('#dataNascimentoFilho').val();
            dataNascimentoFilho = dataNascimentoFilho.split("/");
            dataNascimentoFilho = dataNascimentoFilho[2] + "/" + dataNascimentoFilho[1] + "/" + dataNascimentoFilho[0];

            return {
                name: fieldName,
                value: dataNascimentoFilho
            };
        }

        return false;
    }

    function clearFormFilho() {
        $("#nomeFilho").val('');
        $("#dataNascimentoFilho").val('');
        $("#cpfFilho").val('');
        $("#filhoId").val('');
        $("#sequencialFilho").val('');
        $('#descricaoDataNascimentoFilho').val('');
    }

    function carregaFilho(sequencialFilho) {
        var arr = jQuery.grep(jsonFilhoArray, function(item, i) {
            return (item.sequencialFilho === sequencialFilho);
        });

        clearFormFilho();

        if (arr.length > 0) {
            var item = arr[0];
            $("#nomeFilho").val(item.nomeFilho);
            $("#dataNascimentoFilho").val(item.descricaoDataNascimentoFilho);
            $("#cpfFilho").val(item.cpfFilho);
            $("#filhoId").val(item.filhoId);
            $("#sequencialFilho").val(item.sequencialFilho);
        }
    }


    function excluirFilho() {
        var arrSequencial = [];
        $('#tableFilho input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonFilhoArray.length - 1; i >= 0; i--) {
                var obj = jsonFilhoArray[i];
                if (jQuery.inArray(obj.sequencialFilho, arrSequencial) > -1) {
                    jsonFilhoArray.splice(i, 1);
                }
            }
            $("#jsonFilho").val(JSON.stringify(jsonFilhoArray));
            fillTableFilho();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Filho para excluir.", "error");
    }

    //############################################################################## LISTA Filho FIM #######################################################################################################################
</script>