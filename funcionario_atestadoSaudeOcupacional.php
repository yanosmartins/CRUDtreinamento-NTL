<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('ASO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('ASO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('ASO_EXCLUIR', $arrayPermissao, true));
$condicaoGestorOK = (in_array('ASO_GESTOR', $arrayPermissao, true));

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

$page_title = "ASO";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["funcionario"]["sub"]["atestadoSaudeOcupacional"]["active"] = true;

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
                            <h2>ASO</h2>
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
                                                    <fieldset>
                                                        <div class="row">
                                                            <input id="codigo" name="codigo" type="text" class="hidden" value="">
                                                            <input id="cargoId" name="cargoId" type="text" class="hidden" value="">
                                                            <input id="projetoId" name="projetoId" type="text" class="hidden" value="">

                                                            <section class="col col-4">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario" <?php echo $funcionario ?> class="required <?php echo $funcionario ?>">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        if (!$id) {
                                                                            echo '<option></option>';
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigoFuncionario = (int) $row['codigo'];
                                                                                $nome = $row['nome'];

                                                                                echo '<option value=' . $codigoFuncionario . '>' . $nome . '</option>';
                                                                            }
                                                                        }
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL AND codigo =" . $id;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $nome = $row['nome'];
                                                                            echo '<option value=' . $codigoFuncionario . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="matricula">Matrícula</label>
                                                                <label class="input">
                                                                    <input id="matricula" name="matricula" class="readonly" readonly value="">
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="cargo">Cargo</label>
                                                                <label class="input">
                                                                    <input id="cargo" name="cargo" class="readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="input">
                                                                    <input id="projeto" name="projeto" class="readonly" readonly value="">
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="sexo">Sexo</label>
                                                                <label class="input">
                                                                    <input id="sexo" name="sexo" class="readonly" readonly value="">

                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="dataNascimento">Data de Nascimento</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="readonly" readonly value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="idade">Idade</label>
                                                                <label class="input">
                                                                    <input id="idade" name="idade" type="text" class="readonly" readonly value="" maxlength="5" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="dataAdmissao">Data de admissao</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataAdmissao" name="dataAdmissao" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="readonly" readonly value="" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="ativo"></label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="hidden" required>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="dataUltimoAso">Data do ultimo ASO</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataUltimoAso" name="dataUltimoAso" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" readonly class="readonly" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="dataProximoAso">Data de validade ASO</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataProximoAso" name="dataProximoAso" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" readonly class="readonly " value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="diasAtraso">dias atraso</label>
                                                                <label class="input">
                                                                    <input id="diasAtraso" name="diasAtraso" type="text" readonly class="readonly" maxlength="5" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataAgendamento">Data de Agendamento</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataAgendamento" name="dataAgendamento" <?php echo $funcionario ?> type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="<?php echo $esconderData ?>" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off" style="touch-action: none;">

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
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseAso" class="" id="accordionAso">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Data do ASO
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseAso" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <input id="jsonDataAso" name="jsonDataAso" type="hidden" value="[]">
                                                            <div id="formDataAso" class="col-sm-12">
                                                                <input id="dataAsoId" name="dataAsoId" type="hidden" value="">
                                                                <input id="sequencialDataAso" name="sequencialDataAso" type="hidden" value="">
                                                                <input id="descricaoTipoExame" name="descricaoTipoExame" type="hidden" value="">

                                                                <section class="col col-2">
                                                                    <label class="label" for="dataRealizacaoAso">Data da realização do ASO</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataRealizacaoAso" name="dataRealizacaoAso" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label" for="tipoExame">Tipo do exame</label>
                                                                    <label class="select">
                                                                        <select id="tipoExame" name="tipoExame" class="required">
                                                                            <option></option>
                                                                            <option value='1'>Exame Admissional</option>
                                                                            <option value='2'>Exame Periódico</option>
                                                                            <option value='3'>Mudança de Risco Ocupacional</option>
                                                                            <option value='4'>Retorno ao Trabalho</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-md-4">
                                                                    <label class="label">Comprovante Aso</label>
                                                                    <div class="form-control input">
                                                                        <input type="file" name="fileUploadAso" id="fileUploadAso" accept="application/pdf" class="required">
                                                                    </div>
                                                                </section>
                                                                <section class="col col-2 col-auto" style="display:<?php echo $esconderGestor ?>">
                                                                    <label class="label" for="situacao">Situação</label>
                                                                    <label class="select">
                                                                        <select id="situacao" name="situacao" readonly style="display:<?php echo $esconderGestor ?>">

                                                                            <option value='A'>Aberto</option>
                                                                            <option value='F'>Fechado</option>
                                                                            <option value='P'>Pendente</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                              
                                                                <section class="col col-2">
                                                                    <label class="label" for="dataProximoAsoLista"></label>
                                                                    <label class="input">
                                                                        <input id="dataProximoAsoLista" name="dataProximoAsoLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required hidden" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                    </label>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-md-2">
                                                                <label class="label">&nbsp;</label>
                                                                <button id="btnAddDataAso" type="button" class="btn btn-primary">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverDataAso" type="button" class="btn btn-danger" style="display:<?php echo $esconderGestor ?>">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableDataAso" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th style="width: 2px"></th>
                                                                        <th class="text-center">Data da realização do ASO</th>
                                                                        <th class="text-center">Data da validade ASO</th>
                                                                        <th class="text-center">Tipo do exame</th>
                                                                        <th class="text-center">Situação</th>
                                                                        <th class="text-center">Comprovante Aso</th>

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

<script src="<?php echo ASSETS_URL; ?>/js/business_atestadoSaudeOcupacional.js" type="text/javascript"></script>

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
        jsonDataAsoArray = JSON.parse($("#jsonDataAso").val());

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
        $("#funcionario").on("change", function() {
            recuperarDadosFuncionario();
        });

        $("#dataProximoAso").on("change", function() {
            recuperarValidadeAso();
        })

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



        $("#btnAddDataAso").on("click", function() {
            var DataAso = $("#dataRealizacaoAso").val();
            var tipoExame = $("#tipoExame").val();
            var existe = true;
            if (validaDataAso()) {
                let situacao = $("#situacao").val();
                var idade = $("#idade").val();

                if (situacao == 'F') {

                    let dataRealizacaoAsoTeste = $("#dataRealizacaoAso").val()
                    let dataRealizacaoAsoValor = $("#dataRealizacaoAso").val();
                    $("#dataUltimoAso").val(dataRealizacaoAsoValor)

                    if ((idade < 18) || (idade > 45)) {
                        aux = dataRealizacaoAsoTeste.split('/')
                        aux[2] = Number(aux[2]) + 1
                        dataRealizacaoAsoTeste = `${aux[0]}/${aux[1]}/${aux[2]}`
                        $("#dataProximoAso").val(dataRealizacaoAsoTeste)
                        calculaIdadeFutura();
                        if ((idade < 18) && (quantos_anos >= 18)) {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 2
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        } else {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 1
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        }
                    } else {
                        aux = dataRealizacaoAsoTeste.split('/')
                        aux[2] = Number(aux[2]) + 2
                        dataRealizacaoAsoTeste = `${aux[0]}/${aux[1]}/${aux[2]}`
                        $("#dataProximoAso").val(dataRealizacaoAsoTeste)
                        calculaIdadeFutura();
                        if (quantos_anos > 45) {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 1
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        } else {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 2
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        }
                    }

                    $("#dataProximoAso").val(dataRealizacaoAsoValor)
                    addDataAso();

                } else {
                    let dataRealizacaoAsoTeste = $("#dataRealizacaoAso").val();
                    let dataRealizacaoAsoValor = $("#dataRealizacaoAso").val();
                    if ((idade < 18) || (idade > 45)) {
                        aux = dataRealizacaoAsoTeste.split('/')
                        aux[2] = Number(aux[2]) + 1
                        dataRealizacaoAsoTeste = `${aux[0]}/${aux[1]}/${aux[2]}`
                        $("#dataProximoAso").val(dataRealizacaoAsoTeste)
                        calculaIdadeFutura();
                        if ((idade < 18) && (quantos_anos >= 18)) {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 2
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        } else {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 1
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        }
                    } else {
                        aux = dataRealizacaoAsoTeste.split('/')
                        aux[2] = Number(aux[2]) + 2
                        dataRealizacaoAsoTeste = `${aux[0]}/${aux[1]}/${aux[2]}`
                        $("#dataProximoAso").val(dataRealizacaoAsoTeste)
                        calculaIdadeFutura();
                        if (quantos_anos > 45) {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 1
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        } else {
                            aux = dataRealizacaoAsoValor.split('/')
                            aux[2] = Number(aux[2]) + 2
                            dataRealizacaoAsoValor = `${aux[0]}/${aux[1]}/${aux[2]}`
                        }
                    }
                    $("#dataProximoAso").val(dataRealizacaoAsoValor)
                    addDataAso();
                }

            }

        });

        $("#btnRemoverDataAso").on("click", function() {
            excluirDataAso();
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
        carregaPagina();
        recuperarDadosFuncionarioASO();
        recuperarValidadeAso();
    });

    function carregaPagina() {
        const urlx = window.document.URL.toString();
        const params = urlx.split("?");
        if (params.length === 2) {
            const id = params[1];
            const idx = id.split("=");
            const idd = idx[1];
            if (idd !== "") {
                recuperaASO(idd,
                    async function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            let piece = data.split("#");
                            const mensagem = piece[0];
                            const out = piece[1];
                            let JsonUpload = JSON.parse(piece[2]);
                            piece = out.split("^");

                            const codigo = +piece[0];
                            const funcionario = piece[1];
                            const matricula = piece[2];
                            const cargo = piece[3];
                            const projeto = piece[4];
                            const sexo = piece[5];
                            const dataNascimento = piece[6];
                            const idade = piece[7]
                            const dataAdmissao = piece[8]
                            const ativo = piece[9];
                            const dataUltimoAso = piece[10]
                            const dataProximoAso = piece[11]
                            const dataAgendamento = piece[12]
                            const cargoId = piece[13];
                            const projetoId = piece[14];
                            

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#matricula").val(matricula);
                            $("#funcionario").val(funcionario);
                            $("#cargo").val(cargo);
                            $("#projeto").val(projeto);
                            $("#sexo").val(sexo);
                            $("#dataNascimento").val(dataNascimento);
                            $("#idade").val(idade);
                            $("#dataAdmissao").val(dataAdmissao);
                            $("#ativo").val(ativo);
                            $("#dataUltimoAso").val(dataUltimoAso);
                            $("#dataProximoAso").val(dataProximoAso);
                            $("#dataAgendamento").val(dataAgendamento);
                            $("#cargoId").val(cargoId);
                            $("#projetoId").val(projetoId);

                            const files = []
                            const jsonUploadAso = []
                            //OK
                            for (obj of JsonUpload) {
                                let file = await fetch(obj.fileUploadAso)
                                file = await file.blob()
                                file = new File([file], obj.fileName, {
                                    type: "application/pdf"
                                })
                                files.push(file)
                            }

                            JsonUpload.forEach((obj, index) => {
                                let dataRealizacaoAso = obj.dataRealizacaoAso.split(" ")
                                let aux = dataRealizacaoAso[0].split("-")
                                aux = `${aux[2]}/${aux[1]}/${aux[0]}`
                                dataRealizacaoAso = aux

                                let dataProximoAsoLista = obj.dataProximoAsoLista.split(" ")
                                aux = dataProximoAsoLista[0].split("-")
                                aux = `${aux[2]}/${aux[1]}/${aux[0]}`
                                dataProximoAsoLista = aux

                                let tipoExame = obj.tipoExame

                                jsonUploadAso.push({
                                    dataRealizacaoAso: dataRealizacaoAso,
                                    dataProximoAsoLista: dataProximoAsoLista,
                                    sequencialDataAso: obj.sequencialDataAso,
                                    situacao: obj.situacao,
                                    tipoExame: obj.tipoExame,
                                    descricaoTipoExame : obj.descricaoTipoExame,
                                    fileUploadAso: files[index]
                                })
                            })

                            jsonDataAsoArray = jsonUploadAso
                            fillTableDataAso();

                            const dataTeste = new Date();
                            let dataProximo = $("#dataProximoAso").val();
                            let aux = dataProximo.split("/");
                            dataProximo = new Date(aux[2], aux[1] - 1, aux[0])
                            let diasAtrasoTeste = $("#diasAtraso").val();

                            if (dataTeste > dataProximo) {
                                const diff = dataTeste.getDate() - dataProximo.getDate()
                                if (diff >= 1)
                                    $("#diasAtraso").val(diff)
                            } else {
                                $("#diasAtraso").val('')
                            }


                            if (dataUltimoAso != "") {
                                <?php $funcionario = "readonly" ?>
                            }

                            return;
                        }
                    }
                );
            }
        }
    }

    function novo() {
        $(location).attr('href', 'funcionario_atestadoSaudeOcupacional.php');
    }

    function voltar() {
        $(location).attr('href', 'funcionario_atestadoSaudeOcupacionalFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirASO(id,
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



    function clearFormDataAso() {
        $("#dataRealizacaoAso").val('');
        $("#dataProximoAsoLista").val('');
        $("#fileUploadAso").val('');
        $("#situacao").val('');
        $("#tipoExame").val('');
    }

    function addDataAso() {
        var item = $("#formDataAso").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataAso
        });

        if (item["sequencialDataAso"] === '') {
            if (jsonDataAsoArray.length === 0) {
                item["sequencialDataAso"] = 1;
            } else {
                item["sequencialDataAso"] = Math.max.apply(Math, jsonDataAsoArray.map(function(o) {
                    return o.sequencialDataAso;
                })) + 1;
            }
            item["dataAsoId"] = 0;
        } else {
            item["sequencialDataAso"] = +item["sequencialDataAso"];
        }
        item.dataProximoAsoLista = $("#dataProximoAso").val()

        var index = -1;
        $.each(jsonDataAsoArray, function(i, obj) {
            if (+$('#sequencialDataAso').val() === obj.sequencialDataAso) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonDataAsoArray.splice(index, 1, item);
        else
            jsonDataAsoArray.push(item);

        $("#jsonDataAso").val(JSON.stringify(jsonDataAsoArray));
        fillTableDataAso();
        clearFormDataAso();

    }



    function fillTableDataAso() {
        $("#tableDataAso tbody").empty();
        for (var i = 0; i < jsonDataAsoArray.length; i++) {
            var row = $('<tr />');
            $("#tableDataAso tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox " value="' + jsonDataAsoArray[i].sequencialDataAso + '"><i></i></label></td>'));
            let situacao = $("#situacao").val()
            if ((situacao == 'F') || (jsonDataAsoArray[i].situacao == 'F')) {
                row.append($('<td class="text-center" >' + jsonDataAsoArray[i].dataRealizacaoAso + '</td>'));
            } else {
                row.append($('<td class="text-center" onclick="carregaDataAso(' + jsonDataAsoArray[i].sequencialDataAso + ');">' + jsonDataAsoArray[i].dataRealizacaoAso + '</td>'));
            }
            row.append($('<td class="text-center" >' + jsonDataAsoArray[i].dataProximoAsoLista + '</td>'));

            row.append($('<td class="text-center" >' + jsonDataAsoArray[i].descricaoTipoExame + '</td>'));

            row.append($('<td class="text-center" >' + jsonDataAsoArray[i].situacao + '</td>'));

            var fileUploadAso = jsonDataAsoArray[i].fileUploadAso;

            row.append($('<td class="text-center" >' + jsonDataAsoArray[i].fileUploadAso.name + '</td>'));

        }
    }

    function processDataAso(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "dataProximoAsoLista")) {
            var dataProximoAsoLista = $("#dataProximoAso").val();
            if (dataProximoAsoLista !== '') {
                fieldName = "dataProximoAsoLista";
            }
            return {
                name: fieldName,
                value: $("#dataProximoAsoLista").val()
            };
        }

        if (fieldName !== '' && (fieldId === "dataRealizacaoAso")) {
            var dataRealizacaoAso = $("#dataRealizacaoAso").val();
            if (dataRealizacaoAso !== '') {
                fieldName = "dataRealizacaoAso";
            }
            return {
                name: fieldName,
                value: dataRealizacaoAso
            };
        }

        if (fieldName !== '' && (fieldId === "situacao")) {
            var situacao = $("#situacao").val();
            if (situacao !== '') {
                fieldName = "situacao";
            }
            return {
                name: fieldName,
                value: situacao
            };
        }

        if (fieldName !== '' && (fieldId === "tipoExame")) {
            var tipoExame = $("#tipoExame").val();
            if (tipoExame !== '') {
                fieldName = "tipoExame";
            }
            return {
                name: fieldName,
                value: tipoExame
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoTipoExame")) {
            var descricaoTipoExame = $("#tipoExame option:selected").text();
            if (descricaoTipoExame !== '') {
                fieldName = "descricaoTipoExame";
            }
            return {
                name: fieldName,
                value: descricaoTipoExame
            };
        }

        if (fieldName !== '' && (fieldId === "fileUploadAso")) {
            return {
                name: fieldName,
                value: $("#fileUploadAso").prop('files')[0]
            };
        }

        return false;
    }

    function carregaDataAso(sequencialDataAso) {
        var arr = jQuery.grep(jsonDataAsoArray, function(item, i) {
            return (item.sequencialDataAso === sequencialDataAso);
        });

        clearFormDataAso();

        if (arr.length > 0) {

            var item = arr[0];
            let list = new DataTransfer();
            list.items.add(item.fileUploadAso)
            $("#fileUploadAso").prop('files', list.files)[0];
            $("#sequencialDataAso").val(item.sequencialDataAso);
            $("#dataProximoAsoLista").val(item.dataProximoAsoLista);
            $("#dataRealizacaoAso").val(item.dataRealizacaoAso);
            $("#tipoExame").val(item.tipoExame);
            $("#situacao").val(item.situacao);



        }
    }

    function excluirDataAso() {
        var arrSequencial = [];
        $('#tableDataAso input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonDataAsoArray.length - 1; i >= 0; i--) {
                var obj = jsonDataAsoArray[i];
                if (((obj.sequencialDataAso == arrSequencial) && (obj.situacao == 'F')) || (obj.situacao == 'F')) {
                    continue;
                };
                if (jQuery.inArray(obj.sequencialDataAso, arrSequencial) > -1) {
                    jsonDataAsoArray.splice(i, 1);
                }
            }
            $("#jsonDataAso").val(JSON.stringify(jsonDataAsoArray));
            fillTableDataAso();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 data para excluir.", "error");
    }

    function validaDataAso() {

        const dataRealizacaoAso = $('#dataRealizacaoAso').val();

        if (!dataRealizacaoAso) {
            smartAlert("Erro", "Informe a data da realização do Aso!", "error");
            return false;
        }

        const tipoExame = $('#tipoExame').val();

        if (!tipoExame) {
            smartAlert("Erro", "Informe o tipo do Exame!", "error");
            return false;
        }

        const fileUploadAso = $('#fileUploadAso').prop('files')[0];

        if (!fileUploadAso) {
            smartAlert("Erro", "Informe o comprovante do Aso!", "error");
            return false;
        }
        return true;
    }

    async function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        const id = +$('#codigo').val();
        const funcionario = $('#funcionario').val();
        const matricula = $('#matricula').val();
        const cargo = $('#cargoId').val();
        const projeto = $('#projetoId').val();
        const sexo = $('#sexo').val();
        const dataNascimento = $('#dataNascimento').val();
        const dataAdmissao = $('#dataAdmissao').val();
        const dataAgendamento = $('#dataAgendamento').val();
        const dataUltimoAso = $('#dataUltimoAso').val();
        const dataProximoAso = $('#dataProximoAso').val();
        const ativo = $('#ativo').val();

        const dataAso = {
            id,
            funcionario,
            matricula,
            cargo,
            projeto,
            sexo,
            dataNascimento,
            dataAdmissao,
            dataAgendamento,
            dataUltimoAso,
            dataProximoAso,
            ativo
        }

        const files = [];
        const datas = [];
        jsonDataAsoArray.forEach(obj => {
            const ob = {};
            for (let prop in obj) {
                if (obj[prop] instanceof File) files.push(obj[prop])
                else ob[prop] = obj[prop]
            }
            datas.push(ob)
        })

        const base64 = [];
        for (let file of files) {
            base64.push(await fileToBase64(file))
        }

        const jsonData = datas.map((obj, index) => {
            obj.fileUploadAso = base64[index]
            return obj
        })

        //Chama a função de gravar do business de convênio de saúde.
        gravaASO(dataAso, jsonData,
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


    function recuperarDadosFuncionario() {
        var funcionario = $("#funcionario").val()
        recuperaDadosFuncionario(funcionario,
            function(data) {
                var atributoId = '#' + 'estoqueDestino';
                if (data.indexOf('failed') > -1) {

                    $("#funcionario").focus()
                    // $("#matricula").val("")
                    return;
                } else {
                    $("#funcionario").prop("disabled", false)
                    $("#funcionario").removeClass("readonly")
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var registros = piece[1].split("^");
                    var matricula = registros[2];
                    var cargo = registros[3];
                    var projeto = registros[4];
                    var sexo = registros[5];
                    var dataNascimento = registros[6];
                    var dataAdmissao = registros[8];
                    var idade = registros[7];
                    var cargoId = registros[9];
                    var projetoId = registros[10];

                    $("#matricula").val(matricula);
                    $("#cargo").val(cargo);
                    $("#projeto").val(projeto);

                    if (sexo == 'M') {
                        sexo = 'Masculino'
                    } else {
                        sexo = 'Feminino'
                    }
                    $("#sexo").val(sexo);
                    $("#dataNascimento").val(dataNascimento);
                    $("#dataAdmissao").val(dataAdmissao);
                    $("#idade").val(idade);
                    $("#cargoId").val(cargoId);
                    $("#projetoId").val(projetoId);


                }
            }
        );
    }





    function recuperarDadosFuncionarioASO() {
        var funcionario = $("#funcionario").val()
        recuperaDadosFuncionarioASO(funcionario,
            async function(data) {
                var atributoId = '#' + 'estoqueDestino';
                if (data.indexOf('failed') > -1) {

                    $("#funcionario").focus()
                    // $("#matricula").val("")
                    return;
                } else {
                    $("#funcionario").prop("disabled", false)
                    $("#funcionario").removeClass("readonly")
                            data = data.replace(/failed/g, '');
                            let piece = data.split("#");
                            const mensagem = piece[0];
                            const out = piece[1];
                            let JsonUpload = JSON.parse(piece[2]);
                            piece = out.split("^");

                            const codigo = +piece[0];
                            const funcionario = piece[1];
                            const matricula = piece[2];
                            const cargo = piece[3];
                            const projeto = piece[4];
                            const sexo = piece[5];
                            const dataNascimento = piece[6];
                            const idade = piece[7]
                            const dataAdmissao = piece[8]
                            const ativo = piece[9]
                            const dataUltimoAso = piece[10]
                            const dataProximoAso = piece[11]
                            const dataAgendamento = piece[12]
                            const cargoId = piece[13];
                            const projetoId = piece[14];

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#funcionario").val(funcionario);
                            $("#matricula").val(matricula);
                            $("#cargo").val(cargo);
                            $("#projeto").val(projeto);
                            $("#sexo").val(sexo);
                            $("#dataNascimento").val(dataNascimento);
                            $("#idade").val(idade);
                            $("#ativo").val(ativo);
                            $("#dataAdmissao").val(dataAdmissao);
                            $("#dataUltimoAso").val(dataUltimoAso);
                            $("#dataProximoAso").val(dataProximoAso);
                            $("#dataAgendamento").val(dataAgendamento);
                            $("#cargoId").val(cargoId);
                            $("#projetoId").val(projetoId);

                            const files = []
                            const jsonUploadAso = []
                            //OK
                            for (obj of JsonUpload) {
                                let file = await fetch(obj.fileUploadAso)
                                file = await file.blob()
                                file = new File([file], obj.fileName, {
                                    type: "application/pdf"
                                })
                                files.push(file)
                            }

                            JsonUpload.forEach((obj, index) => {
                                let dataRealizacaoAso = obj.dataRealizacaoAso.split(" ")
                                let aux = dataRealizacaoAso[0].split("-")
                                aux = `${aux[2]}/${aux[1]}/${aux[0]}`
                                dataRealizacaoAso = aux

                                let dataProximoAsoLista = obj.dataProximoAsoLista.split(" ")
                                aux = dataProximoAsoLista[0].split("-")
                                aux = `${aux[2]}/${aux[1]}/${aux[0]}`
                                dataProximoAsoLista = aux

                                let tipoExame = obj.tipoExame

                                jsonUploadAso.push({
                                    dataRealizacaoAso: dataRealizacaoAso,
                                    dataProximoAsoLista: dataProximoAsoLista,
                                    sequencialDataAso: obj.sequencialDataAso,
                                    situacao: obj.situacao,
                                    tipoExame: obj.tipoExame,
                                    descricaoTipoExame : obj.descricaoTipoExame,
                                    fileUploadAso: files[index]
                                })
                            })

                            jsonDataAsoArray = jsonUploadAso
                            fillTableDataAso();

                            const dataTeste = new Date();
                            let dataProximo = $("#dataProximoAso").val();
                            let aux = dataProximo.split("/");
                            dataProximo = new Date(aux[2], aux[1] - 1, aux[0])
                            let diasAtrasoTeste = $("#diasAtraso").val();

                            if (dataTeste > dataProximo) {
                                const diff = dataTeste.getDate() - dataProximo.getDate()
                                if (diff >= 1)
                                    $("#diasAtraso").val(diff)
                            } else {
                                $("#diasAtraso").val('')
                            }


                            if (dataUltimoAso != "") {
                                <?php $funcionario = "readonly" ?>
                            }

                            return;
                }
            }
        );
    }

    function recuperarValidadeAso() {
        const data = new Date();
        let dataProximo = $("#dataProximoAso").val();
        let aux = dataProximo.split("/");
        dataProximo = new Date(aux[2], aux[1] - 1, aux[0])
        let diasAtrasoTeste = $("#diasAtraso").val();

        if (data > dataProximo) {
            const diff = data.getDate() - dataProximo.getDate()
            if (diff >= 1)
                $("#diasAtraso").val(diff)
        } else {
            $("#diasAtraso").val('')
        }
        return
    }

    function calculaIdadeFutura(anoAniversario, mesAniversario, diaAniversario, anoFuturo, mesFuturo, diaFuturo) {

        dataValidadeAsoIdade = $("#dataProximoAso").val();
        aux = dataValidadeAsoIdade.split('/')
        diaFuturo = aux[0];
        mesFuturo = aux[1];
        anoFuturo = aux[2];

        ano_atual = anoFuturo,
            mes_atual = Number(mesFuturo) + 1,
            dia_atual = diaFuturo,

            dataNascimentoIdade = $("#dataNascimento").val();
        aux = dataNascimentoIdade.split('/')
        diaAniversario = aux[0];
        mesAniversario = aux[1];
        anoAniversario = aux[2];

        ano_aniversario = +anoAniversario,
            mes_aniversario = +mesAniversario,
            dia_aniversario = +diaAniversario,

            quantos_anos = ano_atual - ano_aniversario;

        if (mes_atual < mes_aniversario || mes_atual == mes_aniversario && dia_atual < dia_aniversario) {
            quantos_anos--;
        }
        return quantos_anos < 0 ? 0 : quantos_anos;
    }

    function fileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    };
</script>