<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Fornecedor";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["fornecedor"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Tabela Básica"] = "";
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
                            <h2>Fornecedor</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formCliente" method="post" enctype="multipart/form-data">
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
                                                    <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden" value="">
                                                    <fieldset>
                                                        <div class="row">

                                                            <input id="codigo" name="codigo" type="text" readonly class="hidden" value="">

                                                            <section class="col col-3">
                                                                <label class="label">CNPJ</label>
                                                                <label class="input">
                                                                    <input id="cnpj" name="cnpj" autocomplete="off" placeholder="XX.XXX.XXX/XXXX-XX" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Razão Social</label>
                                                                <label class="input">
                                                                    <input id="razaoSocial" maxlength="70" name="razaoSocial" autocomplete="off" placeholder="Digite a Razao Social" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label">Apelido</label>
                                                                <label class="input">
                                                                    <input id="apelido" maxlength="70" name="apelido" autocomplete="off" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 ">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">CEP</label>
                                                                <label class="input">
                                                                    <input id="cep" name="cep" type="text"  autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Número</label>
                                                                <label class="input">
                                                                    <input id="numero" name="numero" type="text" autocomplete="off" maxlength="100">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" type="text"  autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" name="bairro" type="text" autocomplete="off" readonly class="readonly" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" name="cidade" type="text" autocomplete="off" readonly class="readonly" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">UF</label>
                                                                <label class="input">
                                                                    <input id="uf" name="uf" type="text" autocomplete="off" readonly class="readonly" cmaxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">NF</label>
                                                                <label class="select">
                                                                    <select id="notaFiscal" name="notaFiscal" class="required">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>



                                                </div>
                                                </fieldset>
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
                                                <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroFornecedor.js" type="text/javascript"></script>


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


<!-- Validador de CPF -->
<script src="js/plugin/cpfcnpj/jquery.cpfcnpj.js"></script>


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>





<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $("#cnpj").mask("99.999.999/9999-99", {
            placeholder: "X"
        });

        $("#cep").mask("99999-999", {
            placeholder: 'X'
        });

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "Atenção",
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
            var id = $("#codigo").val();

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

        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#cnpj").on("focusout", function() {
            var cnpj = $("#cnpj").val();
            if (!validacao_cnpj(cnpj)) {
                smartAlert("Atenção", "CNPJ inválido!", "error");
                $("#cnpj").val('');
            }
        });

        $("#unidadeFederacao").on("focusout", function() {

            var id = $("#unidadeFederacao").val();

            populaComboMunicipio(id,
                function(data) {
                    var atributoId = '#' + 'municipio';
                    if (data.indexOf('failed') > -1) {

                        // Código que limpa que limpa um elemento. 
                        var select = document.getElementById("municipio");
                        var length = select.options.length;
                        for (i = length - 1; i >= 0; i--) {
                            select.options[i] = null;
                        }

                        $(atributoId).append('<option></option>');

                    } else {
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

        });

        $("#cep").on("change", function() {
            var cep = $("#cep").val().replace(/\D/g, '');
            buscaCep(cep);
        });

        carregaPagina();

    });

    function buscaCep(cep) {
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {

                        $("#logradouro").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } else {

                        smartAlert("Erro", "CEP não encontrado.", "error");
                    }
                });
            } else {
                smartAlert("Erro", "Formato do CEP inválido.", "error");
            }
        }
    }

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFornecedor(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            piece = out.split("^");

                            // Atributos de vale transporte unitário que serão recuperados: 
                            var codigo = +piece[0];
                            var ativo = +piece[1];
                            var unidadeFederacao = piece[2];
                            var municipio = +piece[3];
                            var descricao = piece[4];
                            var cnpj = piece[5];
                            var nomeMunicipio = piece[6];

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#ativo").val(ativo);
                            $("#unidadeFederacao").val(unidadeFederacao);
                            $("#municipio").append('<option value="' + municipio + '">' + nomeMunicipio + '</option>');
                            $("#municipio").val(municipio);
                            $("#descricao").val(descricao);
                            $("#cnpj").val(cnpj);
                            $("#verificaRecuperacao").val(1);

                            return;

                        }
                    }
                );
            }

        }

    }

    function novo() {
        $(location).attr('href', 'cadastro_fornecedorCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_fornecedorFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFornecedor(id,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];

                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                    }
                    voltar();
                } else {
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    voltar();
                }
            }
        );
    }

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        var id = +$("#codigo").val();
        var cnpj = $("#cnpj").val();
        var razaoSocial = $("#razaoSocial").val();
        var apelido = $("#apelido").val();
        var ativo = $("#ativo").val();
        var cep = $("#cep").val();
        var logradouro = $("#logradouro").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();
        var bairro = $("#bairro").val();
        var cidade = $("#cidade").val();
        var uf = $("#uf").val();
        var notaFiscal = $("#notaFiscal").val();

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!cnpj) {
            smartAlert("Atenção", "Informe o CNPJ", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!razaoSocial) {
            smartAlert("Atenção", "Informe o Razao Social", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!apelido) {
            smartAlert("Atenção", "Informe o Apelido", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cep) {
            smartAlert("Atenção", "Informe o Cep", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!numero) {
            smartAlert("Atenção", "Informe o numero", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        gravaFornecedor(id, cnpj,razaoSocial,apelido,ativo,logradouro,numero,complemento,bairro,cidade,uf,notaFiscal,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                        $("#btnGravar").prop('disabled', false);
                    }
                    return '';
                } else {
                    //Verifica se a função de recuperar os campos foi executada.
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");

                    if (verificaRecuperacao === 1) {
                        voltar();
                    } else {
                        novo();
                    }
                }
            }
        );

    }
</script>