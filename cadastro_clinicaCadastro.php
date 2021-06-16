<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('CLINICA_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CLINICA_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CLINICA_EXCLUIR', $arrayPermissao, true));
// $condicaoGestorOK = (in_array('ASO_GESTOR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}
$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}
$esconderGestor = "";
$funcionario = "";
$esconderData = "datepicker";
if ($condicaoGestorOK === false) {
    $esconderGestor = "none";
    $funcionario = "readonly";
    $esconderData = "readonly";
}



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Clínica";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["seguranca"]["sub"]["cadastroAso"]["sub"]["cadastroClinica"]["active"] = true;

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
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Clínica</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formClinica" method="post" enctype="multipart/form-data">
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
                                                            <input id="codigo" name="codigo" type="text" class="hidden" value="">
                                                            <input id="codigoFornecedor" name="codigoFornecedor" type="text" class="hidden" value="">


                                                            <section class="col col-3">
                                                                <label class="label">CNPJ</label>
                                                                <label class="input">
                                                                    <input id="cnpj" name="cnpj" type="text" autocomplete="off" maxlength="100" required class="required">

                                                                </label>
                                                            </section>
                                                            <section class="col col-5 col-auto">
                                                                <label class="label" for="razaoSocial">Razão Social</label>
                                                                <label class="input">
                                                                    <input id="razaoSocial" name="razaoSocial" class="readonly" readonly value="">
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="apelido">Apelido</label>
                                                                <label class="input">
                                                                    <input id="apelido" name="apelido" class="readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CEP</label>
                                                                <label class="input">
                                                                    <input id="cep" name="cep" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Endereço</label>
                                                                <label class="input">
                                                                    <input id="endereco" name="endereco" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Número</label>
                                                                <label class="input">
                                                                    <input id="numero" name="numero" type="text" readonly class="readonly" autocomplete="off" maxlength="100">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

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
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="" id="accordionContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Contato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="jsonTelefone" name="jsonTelefone" type="hidden" value="[]">
                                                        <input id="jsonEmail" name="jsonEmail" type="hidden" value="[]">
                                                        <div id="formTelefone" class="col-sm-6">
                                                            <input id="telefoneId" name="telefoneId" type="hidden" value="">
                                                            <input id="descricaoTelefonePrincipal" name="descricaoTelefonePrincipal" type="hidden" value="">
                                                            <input id="descricaoTelefoneWhatsApp" name="descricaoTelefoneWhatsApp" type="hidden" value="">
                                                            <input id="sequencialTel" name="sequencialTel" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">


                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableTelefone" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th class="text-left" style="min-width: 500%;">Telefone</th>
                                                                            <th class="text-left">Principal</th>
                                                                            <th class="text-left">WhatsApp</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div id="formEmail" class="col-sm-6">
                                                            <input id="emailId" name="emailId" type="hidden" value="">
                                                            <input id="descricaoEmailPrincipal" name="descricaoEmailPrincipal" type="hidden" value="">
                                                            <input id="sequencialEmail" name="sequencialEmail" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">

                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th class="text-left" style="min-width: 100px;">Email</th>
                                                                            <th class="text-left">Principal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseAtendimento" class="" id="accordionAtendimento">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Atendimento
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseAtendimento" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div id="formAgendamento" class="col-sm-6">
                                                            <input id="agendamentoId" name="agendamentoId" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <label class="label">Observações</label>
                                                                        <textarea maxlength="500" id="observacao" name="observacao" class="form-control" rows="3" value="" style="resize:vertical"></textarea>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseAgendamento" class="" id="accordionAgendamento">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Agendamento
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseAgendamento" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>


                                                        <div id="formAgendamento" class="col-sm-12">
                                                            <input id="agendamentoId" name="agendamentoId" type="hidden" value="">

                                                            <div class="row">
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label" for="agendamentoData">Agendamento Data</label>
                                                                    <label class="select">
                                                                        <select id="agendamentoData" name="agendamentoData" class="required">
                                                                            <option></option>
                                                                            <option value='1' selected>Sim</option>
                                                                            <option value='0'>Não</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2 col-auto">
                                                                    <label class="label" for="agendamentoHorario">Agendamento Horário</label>
                                                                    <label class="select">
                                                                        <select id="agendamentoHorario" name="agendamentoHorario" class="required">
                                                                            <option></option>
                                                                            <option value='1' selected>Sim</option>
                                                                            <option value='0'>Não</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2 col-auto">
                                                                    <label class="label" for="quantidadeMaxima">Quantidade por Dia</label>
                                                                    <label class="select">
                                                                        <select id="quantidadeMaxima" name="quantidadeMaxima" class="required">
                                                                            <option></option>
                                                                            <option value='1' selected>Sim</option>
                                                                            <option value='0'>Não</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <label class="label">Quantidade</label>
                                                                    <label class="input">
                                                                        <input id="quantidade" name="quantidade" type="text" autocomplete="off" maxlength="100" required class="">

                                                                    </label>
                                                                </section>
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label" for="agendamentoPorEmail">Agendamento por email</label>
                                                                    <label class="select">
                                                                        <select id="agendamentoPorEmail" name="agendamentoPorEmail" class='required'>
                                                                            <option></option>
                                                                            <option value='1' selected>Sim</option>
                                                                            <option value='0'>Não</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-3">
                                                                    <label class="label">Email de Agendamento</label>
                                                                    <label class="input">
                                                                        <input id="emailAgendamento" name="emailAgendamento" type="text" autocomplete="off" maxlength="100" required class="">

                                                                    </label>
                                                                </section>
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label" for="ativo"></label>
                                                                    <label class="select">
                                                                        <select id="ativo" name="ativo" class="hidden">
                                                                            <option></option>
                                                                            <option value='1' selected>Sim</option>
                                                                            <option value='0'>Não</option>
                                                                        </select>
                                                                    </label>
                                                                </section>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroClinica.js" type="text/javascript"></script>

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
        $("#cnpj").mask("99.999.999/9999-99");
        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($("#jsonEmail").val());

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
            gravar()
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#cnpj").on("change", function() {
            recuperarDadosCnpj();
        });
        $("#quantidadeMaxima").on("change", function() {
            var quantidadeMaxima = $("#quantidadeMaxima").val();
            if (quantidadeMaxima == 1) {
            } else {
                $("#quantidade").prop('readonly', true);
                $("#quantidade").val('');
            }
        });
        $("#agendamentoPorEmail").on("change", function() {
            var agendamentoPorEmail = $("#agendamentoPorEmail").val();
            if (agendamentoPorEmail == 1) {

            } else {
                $("#emailAgendamento").prop('readonly', true);
                $("#emailAgendamento").val('');
            }
        });


        carregaPagina();
    });

    function carregaPagina() {
        const urlx = window.document.URL.toString();
        const params = urlx.split("?");
        if (params.length === 2) {
            const id = params[1];
            const idx = id.split("=");
            const idd = idx[1];
            if (idd !== "") {
                recuperaClinica(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            let piece = data.split("#");
                            const mensagem = piece[0];
                            const registros = piece[1].split("^");
                            const $strArrayTelefone = piece[2];
                            const $strArrayEmail = piece[3];
                            const codigo = +registros[0];
                            const codigoFornecedor = +registros[1];
                            const cnpj = registros[2];
                            const nome = registros[3];
                            const apelido = registros[4];
                            const cep = registros[5];
                            const logradouro = registros[6];
                            const endereco = registros[7];
                            const numero = registros[8]
                            const complemento = registros[9]
                            const bairro = registros[10];
                            const cidade = registros[11];
                            const uf = registros[12];
                            const observacao = registros[13];
                            const agendamentoData = registros[14];
                            const agendamentoHorario = registros[15];
                            const quantidadeDia = registros[16];
                            const quantidade = registros[17];
                            const agendamentoEmail = registros[18];
                            const emailDeAgendamento = registros[19];



                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#codigoFornecedor").val(codigoFornecedor);
                            $("#cnpj").val(cnpj);
                            $("#razaoSocial").val(nome);
                            $("#apelido").val(apelido);
                            $("#cep").val(cep);
                            $("#logradouro").val(logradouro);
                            $("#endereco").val(endereco);
                            $("#numero").val(numero);
                            $("#complemento").val(complemento);
                            $("#bairro").val(bairro);
                            $("#cidade").val(cidade);
                            $("#uf").val(uf);
                            $("#observacao").val(observacao);
                            $("#agendamentoData").val(agendamentoData);
                            $("#agendamentoHorario").val(agendamentoHorario);
                            $("#quantidadeMaxima").val(quantidadeDia);
                            $("#quantidade").val(quantidade);
                            $("#agendamentoPorEmail").val(agendamentoEmail);
                            $("#emailAgendamento").val(emailDeAgendamento);
                            $("#jsonTelefone").val($strArrayTelefone);
                            $("#jsonEmail").val($strArrayEmail);



                            jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                            jsonEmailArray = JSON.parse($("#jsonEmail").val());

                            fillTableTelefone();
                            fillTableEmail();
                        }
                    }
                );
            }
        }
    }

    function recuperarDadosCnpj() {
        var cnpj = $("#cnpj").val()
        recuperaDadosCnpj(cnpj,
            function(data) {
                var atributoId = '#' + 'estoqueDestino';
                if (data.indexOf('failed') > -1) {
                    $("#cnpj").focus()
                    // $("#matricula").val("")
                    return;
                } else {
                    $("#cnpj").prop("disabled", false)
                    $("#cnpj").removeClass("readonly")
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    if (piece == "") {
                        smartAlert("Erro", "Está clinica ja está cadastrada!", "error");
                        $("#razaoSocial").val('');
                        $("#apelido").val('');
                        $("#cep").val('');
                        $("#logradouro").val('');
                        $("#endereco").val('');
                        $("#numero").val('');
                        $("#complemento").val('');
                        $("#bairro").val('');
                        $("#cidade").val('');
                        $("#uf").val('');
                        $("#jsonTelefone").val('');
                        $("#jsonEmail").val('');
                    } else {
                        var mensagem = piece[0];
                        var registros = piece[1].split("^");
                        var $strArrayTelefone = piece[2];
                        var $strArrayEmail = piece[3];
                        var fornecedor = registros[1];
                        var razaoSocial = registros[2];
                        var apelido = registros[3];
                        var cep = registros[4];
                        var logradouro = registros[5];
                        var endereco = registros[6];
                        var numero = registros[7];
                        var complemento = registros[8];
                        var bairro = registros[9];
                        var cidade = registros[10];
                        var uf = registros[11];

                        $("#codigoFornecedor").val(fornecedor);
                        $("#razaoSocial").val(razaoSocial);;
                        $("#apelido").val(apelido);;
                        $("#cep").val(cep);;
                        $("#logradouro").val(logradouro);;
                        $("#endereco").val(endereco);;
                        $("#numero").val(numero);;
                        $("#complemento").val(complemento);;
                        $("#bairro").val(bairro);;
                        $("#cidade").val(cidade);;
                        $("#uf").val(uf);;
                        $("#jsonTelefone").val($strArrayTelefone);
                        $("#jsonEmail").val($strArrayEmail);



                        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                        jsonEmailArray = JSON.parse($("#jsonEmail").val());

                        fillTableTelefone();
                        fillTableEmail();
                    }

                }
            }
        );
    }


    function novo() {
        $(location).attr('href', 'cadastro_clinicaCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_clinicaCadastroFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirClinica(id,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];

                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                    }
                } else {
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    voltar();
                }
            }
        );
    }


    //############################################################################## LISTA TELEFONE INICIO ####################################################################################################################

    function fillTableTelefone() {
        $("#tableTelefone tbody").empty();
        for (var i = 0; i < jsonTelefoneArray.length; i++) {
            var row = $('<tr />');
            $("#tableTelefone tbody").append(row);
            row.append($('<td class="text-nowrap">' + jsonTelefoneArray[i].telefone + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTelefoneArray[i].descricaoTelefonePrincipal + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTelefoneArray[i].descricaoTelefoneWhatsApp + '</td>'));
        }
    }

    function validaTelefone() {
        var existe = false;
        var achou = false;
        var tel = $('#telefone').val();
        var sequencial = +$('#sequencialTel').val();
        var telefonePrincipalMarcado = 0;



        if ($("#telefonePrincipal").is(':checked') === true) {
            telefonePrincipalMarcado = 1;
        }


        if (tel === '') {
            smartAlert("Erro", "Informe um telefone.", "error");
            return false;
        }

        if (!phonenumber(tel)) {
            smartAlert("Erro", "Informe um telefone correto.", "error");
            return false;
        }

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefonePrincipalMarcado === 1) {
                if ((jsonTelefoneArray[i].telefonePrincipal === 1) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonTelefoneArray[i].telefone === tel) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    existe = true;
                    break;
                }
            }
        }

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {

            if (tel !== "") {
                if ((jsonTelefoneArray[i].telefone === tel) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    existe = true;
                    break;
                }
            }
        }

        if (existe === true) {
            smartAlert("Erro", "Telefone já cadastrado.", "error");
            return false;
        }

        if ((achou === true) && (telefonePrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um telefone principal na lista.", "error");
            return false;
        }


        return true;
    }


    function phonenumber(inputtxt) {
        var phoneno = /(0?[1-9]{2})*\D*(9?)\D?(\d{4})+\D?(\d{4})\b/g;
        if ((inputtxt.match(phoneno))) {
            return true;
        } else {
            return false;
        }
    }



    function addTelefone() {
        var item = $("#formTelefone").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataTel
        });

        if (item["sequencialTel"] === '') {
            if (jsonTelefoneArray.length === 0) {
                item["sequencialTel"] = 1;
            } else {
                item["sequencialTel"] = Math.max.apply(Math, jsonTelefoneArray.map(function(o) {
                    return o.sequencialTel;
                })) + 1;
            }
            item["telefoneId"] = 0;
        } else {
            item["sequencialTel"] = +item["sequencialTel"];
        }

        var index = -1;
        $.each(jsonTelefoneArray, function(i, obj) {
            if (+$('#sequencialTel').val() === obj.sequencialTel) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTelefoneArray.splice(index, 1, item);
        else
            jsonTelefoneArray.push(item);

        $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
        fillTableTelefone();
        clearFormTelefone();

    }

    function processDataTel(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "telefone")) {
            var valorTel = $("#telefone").val();
            if (valorTel !== '') {
                fieldName = "telefone";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }
        if (fieldName !== '' && (fieldId === "telefonePrincipal")) {
            var telefonePrincipal = 0;
            if ($("#telefonePrincipal").is(':checked') === true) {
                telefonePrincipal = 1;
            }
            return {
                name: fieldName,
                value: telefonePrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "telefoneWpp")) {
            var telefoneWpp = 0;
            if ($("#telefoneWpp").is(':checked') === true) {
                telefoneWpp = 1;
            }
            return {
                name: fieldName,
                value: telefoneWpp
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoTelefonePrincipal")) {
            var descricaoTelefonePrincipal = "Não";
            if ($("#telefonePrincipal").is(':checked') === true) {
                descricaoTelefonePrincipal = "Sim";
            }
            return {
                name: fieldName,
                value: descricaoTelefonePrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoTelefoneWhatsApp")) {
            var descricaoTelefoneWhatsApp = "Não";
            if ($("#telefoneWpp").is(':checked') === true) {
                descricaoTelefoneWhatsApp = "Sim";
            }
            return {
                name: fieldName,
                value: descricaoTelefoneWhatsApp
            };
        }

        return false;
    }

    function clearFormTelefone() {
        $("#telefone").val('');
        $("#telefoneId").val('');
        $("#sequencialTel").val('');
        $('#telefonePrincipal').val(0);
        $('#telefonePrincipal').prop('checked', false);
        $('#telefoneWpp').prop('checked', false);
        $('#descricaoTelefonePrincipal').val('');
        $('#descricaoTelefoneWhatsApp').val('');
    }

    function carregaTelefone(sequencialTel) {
        var arr = jQuery.grep(jsonTelefoneArray, function(item, i) {
            return (item.sequencialTel === sequencialTel);
        });

        clearFormTelefone();

        if (arr.length > 0) {
            var item = arr[0];
            $("#telefoneId").val(item.telefoneId);
            $("#telefone").val(item.telefone);
            $("#sequencialTel").val(item.sequencialTel);
            $("#telefonePrincipal").val(item.telefonePrincipal);
            $("#telefoneWpp").val(item.telefoneWpp);

            if (item.telefonePrincipal === 1) {
                $('#telefonePrincipal').prop('checked', true);
                $('#descricaoTelefonePrincipal').val("Sim");
            } else {
                $('#telefonePrincipal').prop('checked', false);
                $('#descricaoTelefonePrincipal').val("Não");
            }

            if (item.telefoneWpp === 1) {
                $('#telefoneWpp').prop('checked', true);
                $('#descricaoTelefoneWhatsApp').val("Sim");
            } else {
                $('#telefoneWpp').prop('checked', false);
                $('#descricaoTelefoneWhatsApp').val("Não");
            }
        }
    }

    function excluirContato() {
        var arrSequencial = [];
        $('#tableTelefone input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
                var obj = jsonTelefoneArray[i];
                if (jQuery.inArray(obj.sequencialTel, arrSequencial) > -1) {
                    jsonTelefoneArray.splice(i, 1);
                }
            }
            $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
            fillTableTelefone();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 telefone para excluir.", "error");
    }

    //############################################################################## LISTA TELEFONE FIM #######################################################################################################################

    //############################################################################## LISTA EMAIL INICIO #######################################################################################################################

    function fillTableEmail() {
        $("#tableEmail tbody").empty();
        for (var i = 0; i < jsonEmailArray.length; i++) {
            var row = $('<tr />');
            $("#tableEmail tbody").append(row);

            row.append($('<td class="text-nowrap">' + jsonEmailArray[i].email + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEmailArray[i].descricaoEmailPrincipal + '</td>'));
        }
    }

    function validaEmail() {
        var existe = false;
        var achou = false;
        var email = $('#email').val();
        var sequencial = +$('#sequencialEmail').val();
        var emailValido = false;
        var emailPrincipalMarcado = 0;

        if ($("#emailPrincipal").is(':checked') === true) {
            emailPrincipalMarcado = 1;
        }
        if (email === '') {
            smartAlert("Erro", "Informe um email.", "error");
            return false;
        }
        if (validateEmail(email)) {
            emailValido = true;
        }
        if (emailValido === false) {
            smartAlert("Erro", "Email inválido.", "error");
            return false;
        }
        for (i = jsonEmailArray.length - 1; i >= 0; i--) {
            if (emailPrincipalMarcado === 1) {
                if ((jsonEmailArray[i].emailPrincipal === 1) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if ((jsonEmailArray[i].email === email) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                existe = true;
                break;
            }
        }
        if (existe === true) {
            smartAlert("Erro", "Email já cadastrado.", "error");
            return false;
        }
        if ((achou === true) && (emailPrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um email principal na lista.", "error");
            return false;
        }
        return true;
    }

    function addEmail() {
        var item = $("#formEmail").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEmail
        });

        if (item["sequencialEmail"] === '') {
            if (jsonEmailArray.length === 0) {
                item["sequencialEmail"] = 1;
            } else {
                item["sequencialEmail"] = Math.max.apply(Math, jsonEmailArray.map(function(o) {
                    return o.sequencialEmail;
                })) + 1;
            }
            item["emailId"] = 0;
        } else {
            item["sequencialEmail"] = +item["sequencialEmail"];
        }
        var index = -1;
        $.each(jsonEmailArray, function(i, obj) {
            if (+$('#sequencialEmail').val() === obj.sequencialEmail) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEmailArray.splice(index, 1, item);
        else
            jsonEmailArray.push(item);

        $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
        fillTableEmail();
        clearFormEmail();
    }

    function processDataEmail(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "emailPrincipal")) {
            var valorEmailPrincipal = 0;
            if ($("#emailPrincipal").is(':checked') === true) {
                valorEmailPrincipal = 1;
            }
            return {
                name: fieldName,
                value: valorEmailPrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoEmailPrincipal")) {
            var valorDescricaoEmailPrincipal = "Não";
            if ($("#emailPrincipal").is(':checked') === true) {
                valorDescricaoEmailPrincipal = "Sim";
            }
            return {
                name: fieldName,
                value: valorDescricaoEmailPrincipal
            };
        }
        return false;
    }

    function clearFormEmail() {
        $("#email").val('');
        $("#emailId").val('');
        $("#sequencialEmail").val('');
        $('#emailPrincipal').val(0);
        $('#emailPrincipal').prop('checked', false);
        $('#descricaoEmailPrincipal').val('');
    }

    function carregaEmail(sequencialEmail) {
        var arr = jQuery.grep(jsonEmailArray, function(item, i) {
            return (item.sequencialEmail === sequencialEmail);
        });

        clearFormEmail();

        if (arr.length > 0) {
            var item = arr[0];
            $("#emailId").val(item.emailId);
            $("#email").val(item.email);
            $("#sequencialEmail").val(item.sequencialEmail);
            $("#emailPrincipal").val(item.emailPrincipal);
            if (item.emailPrincipal === 1) {
                $('#emailPrincipal').prop('checked', true);
                $('#descricaoEmailPrincipal').val("Sim");
            } else {
                $('#emailPrincipal').prop('checked', false);
                $('#descricaoEmailPrincipal').val("Não");
            }
        }

    }

    function excluirEmail() {
        var arrSequencial = [];
        $('#tableEmail input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonEmailArray.length - 1; i >= 0; i--) {
                var obj = jsonEmailArray[i];
                if (jQuery.inArray(obj.sequencialEmail, arrSequencial) > -1) {
                    jsonEmailArray.splice(i, 1);
                }
            }
            $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
            fillTableEmail();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 email para excluir.", "error");
    }

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        const id = +$('#codigo').val();
        const codigoFornecedor = $("#codigoFornecedor").val();
        const observacao = $('#observacao').val();
        const agendamentoData = $('#agendamentoData').val();
        const agendamentoHorario = $('#agendamentoHorario').val();
        const quantidadeDia = $('#quantidadeMaxima').val();
        const quantidade = $('#quantidade').val();
        const agendamentoEmail = $('#agendamentoPorEmail').val();
        const emailDeAgendamento = $('#emailAgendamento').val();
        const ativo = $('#ativo').val();

        if (!codigoFornecedor) {
            smartAlert("Atenção", "Esta clínica não é um fornecedor", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!agendamentoData) {
            smartAlert("Atenção", "Preencha o campo Agendamento Data", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!agendamentoHorario) {
            smartAlert("Atenção", "Preencha o campo Agendamento Horário", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!quantidadeDia) {
            smartAlert("Atenção", "Preencha o campo Quantidade por Dia", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if ((quantidadeDia == 1) && (quantidade == '')) {
            smartAlert("Atenção", "Preencha o campo Quantidade", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!agendamentoEmail) {
            smartAlert("Atenção", "Preencha o campo Agendamento por Email", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if ((agendamentoEmail == 1) && (emailDeAgendamento == '')) {
            smartAlert("Atenção", "Preencha o campo Email de Agendamento", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }


        const clinica = {
            id,
            codigoFornecedor,
            observacao,
            agendamentoData,
            agendamentoHorario,
            quantidadeDia,
            quantidade,
            agendamentoEmail,
            emailDeAgendamento,
            ativo
        }

        //Chama a função de gravar do business de convênio de saúde.
        gravaClinica(clinica,
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
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    novo();
                }
            }
        );
    }
</script>