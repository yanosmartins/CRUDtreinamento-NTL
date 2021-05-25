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

                                                            <section class="col col-4">
                                                                <label class="label">Razão Social</label>
                                                                <label class="input">
                                                                    <input id="razaoSocial" maxlength="70" name="razaoSocial" autocomplete="off" placeholder="Digite a Razao Social" type="text" class=" required">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Apelido</label>
                                                                <label class="input">
                                                                    <input id="apelido" maxlength="70" name="apelido" autocomplete="off" type="text" class=" required">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Codigo Cliente</label>
                                                                <label class="input">
                                                                    <input id="codigoCliente" maxlength="50" name="codigoCliente" autocomplete="off" type="text" class="">
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
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CEP</label>
                                                                <label class="input">
                                                                    <input id="cep" name="cep" type="text" autocomplete="off" maxlength="100" class="required">

                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Endereço</label>
                                                                <label class="input">
                                                                    <input id="endereco" name="endereco" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Número</label>
                                                                <label class="input">
                                                                    <input id="numero" name="numero" type="text" autocomplete="off" maxlength="100" class="required">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" name="bairro" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" name="cidade" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">UF</label>
                                                                <label class="input">
                                                                    <input id="uf" name="uf" type="text" autocomplete="off" cmaxlength="100">

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
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseGrupoDeItem" class="collapsed" id="accordionDadosContrato">
                                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                            <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                            Grupo de Item
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseGrupoDeItem" class="panel-collapse collapse">
                                                    <div class="panel-body no-padding">
                                                        <input id="jsonTipoItem" name="jsonTipoItem" type="hidden" value="[]">
                                                        <fieldset id="formGrupoDeItem">
                                                            <input id="sequencialTipoItem" name="sequencialTipoItem" type="hidden" value="">

                                                            <br>
                                                            <div class="row">
                                                                <section class="col col-3">
                                                                    <label class="label">Tipo Item</label>
                                                                    <label class="select">
                                                                        <select id="tipoItem" name="tipoItem" class="form-control">
                                                                            <option style="display:none;" value="">Selecione</option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM estoque.tipoItem  where ativo = 1  order by descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {

                                                                                $row = array_map('mb_strtoupper', $row);
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-3">
                                                                    <label class="label">Fabricante</label>
                                                                    <label class="select">
                                                                        <select id="fabricante" name="fabricante" class="form-control">
                                                                            <option style="display:none;" value="">Selecione</option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM estoque.fabricante  where ativo = 1  order by descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {

                                                                                $row = array_map('mb_strtoupper', $row);
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-5">
                                                                    <label class="label">Observação</label>
                                                                    <label class="input">
                                                                        <input id="observacao" name="observacao" type="text" autocomplete="off" maxlength="100">

                                                                    </label>
                                                                </section>


                                                                <section class="col col-4">

                                                                    <button id="btnAddGrupoDeItem" type="button" class="btn btn-primary" title="Adicionar Item">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverGrupoDeItem" type="button" class="btn btn-danger" title="Remover Item">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>

                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableGrupoDeItem" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">

                                                                            <th class="text-left" style="min-width: 10px;"></th>
                                                                            <th class="text-left" style="min-width: 10px;">Tipo Item</th>
                                                                            <th class="text-left" style="min-width: 10px;">Fabricante</th>
                                                                            <th class="text-left" style="min-width: 30px;">Observacao</th>
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
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="collapsed" id="accordionContato">
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
                                                                        <section class="col col-md-4">
                                                                            <label class="label">Telefone</label>
                                                                            <label class="input"><i class="icon-prepend fa fa-phone"></i>
                                                                                <input id="telefone" name="telefone" type="text" class="form-control" value="">
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-md-2">
                                                                            <label class="label">&nbsp;</label>
                                                                            <label id="labelTelefonePrincipal" class="checkbox ">
                                                                                <input id="telefonePrincipal" name="telefonePrincipal" type="checkbox" value="true" checked="checked"><i></i>
                                                                                Principal
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-md-2">
                                                                            <label class="label">&nbsp;</label>
                                                                            <label id="labelTelefoneWhatsApp" class="checkbox ">
                                                                                <input id="telefoneWpp" name="telefoneWpp" type="checkbox" value="true" checked="checked"><i></i>
                                                                                WhatsApp
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-md-4">
                                                                            <label class="label">&nbsp;</label>
                                                                            <button id="btnAddTelefone" type="button" class="btn btn-primary">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                            <button id="btnRemoverTelefone" type="button" class="btn btn-danger">
                                                                                <i class="fa fa-minus"></i>
                                                                            </button>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableTelefone" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
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
                                                                        <section class="col col-md-7">
                                                                            <label class="label">Email</label>
                                                                            <label class="input"><i class="icon-prepend fa fa-at"></i>
                                                                                <input id="email" maxlength="50" name="email" type="text" value="">
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-md-2">
                                                                            <label class="label">&nbsp;</label>
                                                                            <label id="labelEmailPrincipal" class="checkbox ">
                                                                                <input id="emailPrincipal" name="emailPrincipal" type="checkbox" value="true" checked="checked"><i></i>
                                                                                Principal
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-auto">
                                                                            <label class="label">&nbsp;</label>
                                                                            <button id="btnAddEmail" type="button" class="btn btn-primary">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                            <button id="btnRemoverEmail" type="button" class="btn btn-danger">
                                                                                <i class="fa fa-minus"></i>
                                                                            </button>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
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
    jsonTipoItemArray = JSON.parse($("#jsonTipoItem").val());
    jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
    jsonEmailArray = JSON.parse($("#jsonEmail").val());
    $(document).ready(function() {

        $("#telefone").mask("(99) 9999-9999?9").on("focusout", function() {
            var len = this.value.replace(/\D/g, '').length;
            $(this).mask(len > 10 ? "(99) 99999-999?9" : "(99) 9999-9999?9");
        });

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
            $ativo = 1;
            gravar();

        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#btnRemoverGrupoDeItem").on("click", function() {
            excluirGrupoDeItem();
        });

        $("#btnAddGrupoDeItem").on("click", function() {
            if (validaGrupoDeItem()) {
                addGrupoDeItem();
            }
        });

        //Botões de Telefone
        $("#btnAddTelefone").on("click", function() {
            if (validaTelefone()) {
                addTelefone();
            }
        });

        $("#btnRemoverTelefone").on("click", function() {
            excluirContato();
        });

        //Botões de Email
        $('#btnAddEmail').on("click", function() {
            if (validaEmail()) {
                addEmail();
            }
        });

        $('#btnRemoverEmail').on("click", function() {
            excluirEmail();
        });


        $("#cnpj").on("focusout", function() {
            var cnpj = $("#cnpj").val();
            if (!validacao_cnpj(cnpj)) {
                smartAlert("Atenção", "CNPJ inválido!", "error");
                $("#cnpj").val('');
            }
        });


        $("#cep").on("change", function() {
            var cep = $("#cep").val().replace(/\D/g, '');
            buscaCep(cep);
        });

        carregaPagina();

    });

    // ############## COMEÇO LISTA ESTOQUE ###################

    function addGrupoDeItem() {
        var item = $("#formGrupoDeItem").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataGrupoDeItem
        });

        if (item["sequencialTipoItem"] === '') {
            if (jsonTipoItemArray.length === 0) {
                item["sequencialTipoItem"] = 1;
            } else {
                item["sequencialTipoItem"] = Math.max.apply(Math, jsonTipoItemArray.map(function(o) {
                    return o.sequencialTipoItem;
                })) + 1;
            }

        } else {
            item["sequencialTipoItem"] = +item["sequencialTipoItem"];
        }

        item.tipoItemText = $('#tipoItem option:selected').text().trim();
        item.fabricanteText = $('#fabricante option:selected').text().trim();

        var index = -1;
        $.each(jsonTipoItemArray, function(i, obj) {
            if (+$('#sequencialTipoItem').val() === obj.sequencialTipoItem) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTipoItemArray.splice(index, 1, item);
        else
            jsonTipoItemArray.push(item);

        $("#jsonTipoItem").val(JSON.stringify(jsonTipoItemArray));
        fillTableGrupoDeItem();

    }

    function processDataGrupoDeItem(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "tipoItem")) {
            return {
                name: fieldName,
                value: $("#tipoItem option:selected").val()
            };
        }


        if (fieldName !== '' && (fieldId === "fabricante")) {
            return {
                name: fieldName,
                value: $("#fabricante option:selected").val()
            };
        }


        if (fieldName !== '' && (fieldId === "observacao")) {
            return {
                name: fieldName,
                value: $("#observacao").val()
            };
        }


        return false;
    }

    function fillTableGrupoDeItem() {
        $("#tableGrupoDeItem tbody").empty();
        if (typeof(jsonTipoItemArray) != 'undefined') {
            for (var i = 0; i < jsonTipoItemArray.length; i++) {
                var row = $('<tr />');
                $("#tableGrupoDeItem tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTipoItemArray[i].sequencialTipoItem + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaGrupoDeItem(' + jsonTipoItemArray[i].sequencialTipoItem + ');">' + jsonTipoItemArray[i].tipoItemText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonTipoItemArray[i].sequencialTipoItem + ');">' + jsonTipoItemArray[i].fabricanteText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonTipoItemArray[i].sequencialTipoItem + ');">' + jsonTipoItemArray[i].observacao + '</td>'));


            }
            clearFormGrupoDeItem();
        }
    }

    function validaGrupoDeItem() {
        var existe = false;
        var achou = false;
        var fabricante = $('#fabricante').val();
        var tipoItem = $('#tipoItem').val();
        var sequencial = +$('#sequencialTipoItem').val();

        if (tipoItem == '') {
            smartAlert("Erro", "Informe o campo Tipo Item.", "error");
            return false;
        }

        return true;
    }

    function clearFormGrupoDeItem() {
        $('#tipoItem').val("");
        $('#fabricante').val("");
        $('#observacao').val('');
    }

    function carregaGrupoDeItem(sequencialTipoItem) {
        // habilitaTodoCampoGrupoDeItem()
        var arr = jQuery.grep(jsonTipoItemArray, function(item, i) {
            return (item.sequencialTipoItem === sequencialTipoItem);
        });



        clearFormGrupoDeItem();
        if (arr.length > 0) {
            var item = arr[0];
            $('#sequencialTipoItem').val(item.sequencialTipoItem);
            $('#tipoItem').val(item.tipoItem);
            $('#fabricante').val(item.fabricante);
            $('#observacao').val(item.observacao);
        }
    }

    function excluirGrupoDeItem() {
        var arrSequencial = [];
        $('#tableGrupoDeItem input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonTipoItemArray.length - 1; i >= 0; i--) {
                var obj = jsonTipoItemArray[i];
                if (jQuery.inArray(obj.sequencialTipoItem, arrSequencial) > -1) {
                    jsonTipoItemArray.splice(i, 1);
                }
            }

            $("#jsonTipoItem").val(JSON.stringify(jsonTipoItemArray));
            fillTableGrupoDeItem();
        } else {
            smartAlert("Erro", "Selecione pelo menos 1 grupo de item para excluir.", "error");
        }
    }


    //############################################################################## LISTA TELEFONE INICIO ####################################################################################################################

    function fillTableTelefone() {
        $("#tableTelefone tbody").empty();
        for (var i = 0; i < jsonTelefoneArray.length; i++) {
            var row = $('<tr />');
            $("#tableTelefone tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelefoneArray[i].sequencialTel + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTel + ');">' + jsonTelefoneArray[i].telefone + '</td>'));
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
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEmailArray[i].sequencialEmail + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaEmail(' + jsonEmailArray[i].sequencialEmail + ');">' + jsonEmailArray[i].email + '</td>'));
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

    //############################################################################## LISTA EMAIL FIM ########################################################################################################################## 

    function buscaCep(cep) {
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        var ocorrencia = dados.logradouro.indexOf(" ")
                        var recorte = dados.logradouro.slice(0, ocorrencia)
                        var endereco = dados.logradouro.slice((dados.logradouro.length * (-1)) + ocorrencia).trim()
                        $("#endereco").val(endereco);
                        $("#logradouro").val(recorte);
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
                            var $strArrayTipoItem = piece[2];
                            var $strArrayTelefone = piece[3];
                            var $strArrayEmail = piece[4];
                            piece = out.split("^");

                            var codigo = +piece[0];
                            var cnpj = piece[1];
                            var razaoSocial = piece[2];
                            var apelido = piece[3];
                            var ativo = piece[4];
                            var logradouro = piece[5];
                            var numero = piece[6];
                            var complemento = piece[7];
                            var bairro = piece[8];
                            var cidade = piece[9];
                            var uf = piece[10];
                            var notaFiscal = piece[11];
                            var cep = piece[12];
                            var endereco = piece[13];
                            var codigoCliente = piece[14];

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.

                            $("#codigo").val(codigo);
                            $("#cnpj").val(cnpj);
                            $("#razaoSocial").val(razaoSocial);
                            $("#apelido").val(apelido);
                            $("#ativo").val(ativo);
                            $("#logradouro").val(logradouro);
                            $("#numero").val(numero);
                            $("#complemento").val(complemento);
                            $("#bairro").val(bairro);
                            $("#cidade").val(cidade);
                            $("#uf").val(uf);
                            $("#notaFiscal").val(notaFiscal);
                            $("#cep").val(cep);
                            $("#endereco").val(endereco);
                            $("#jsonTipoItem").val($strArrayTipoItem);
                            $("#jsonTelefone").val($strArrayTelefone);
                            $("#jsonEmail").val($strArrayEmail);
                            $("#codigoCliente").val(codigoCliente);

                            jsonTipoItemArray = JSON.parse($("#jsonTipoItem").val());
                            fillTableGrupoDeItem();
                            jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                            fillTableTelefone();
                            jsonEmailArray = JSON.parse($("#jsonEmail").val());
                            fillTableEmail();
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
        var logradouro = $("#logradouro").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();
        var bairro = $("#bairro").val();
        var cidade = $("#cidade").val();
        var uf = $("#uf").val();
        var notaFiscal = $("#notaFiscal").val();
        var cep = $("#cep").val();
        var endereco = $("#endereco").val();
        var codigoCliente = $("#codigoCliente").val();
        var jsonTipoItemArray = JSON.parse($("#jsonTipoItem").val());
        var jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        var jsonEmailArray = JSON.parse($("#jsonEmail").val());

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

        gravaFornecedor(id, cnpj, razaoSocial, apelido, ativo, logradouro, numero, complemento, bairro, cidade, uf, notaFiscal, cep, endereco,codigoCliente, jsonTipoItemArray, jsonTelefoneArray, jsonEmailArray,
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