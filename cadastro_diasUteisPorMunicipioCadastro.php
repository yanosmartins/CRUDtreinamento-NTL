<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('DIASUTEISMUNICIPIO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('DIASUTEISMUNICIPIO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('DIASUTEISMUNICIPIO_EXCLUIR', $arrayPermissao, true));

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

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Dias Úteis por Município";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["diasUteisPorMunicipio"]["active"] = true;

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
                            <h2>Dias Úteis por Município</h2>
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
                                                        <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden" value="">
                                                        <div class="row">

                                                            <input id="codigo" name="codigo" type="text" class="hidden" value="">

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="unidadeFederacao">UF</label>
                                                                <label class="select">
                                                                    <select id="unidadeFederacao" name="unidadeFederacao" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {

                                                                            $sigla = mb_convert_encoding($row['sigla'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="municipio">Município</label>
                                                                <label class="select">
                                                                    <select id="municipio" name="municipio" class="required">
                                                                        <option></option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="cidade">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" name="cidade" type="text" class="required" maxlength="50" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required">
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Dias Úteis</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">

                                                            <!-- DIAS ÚTEIS -->
                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>

                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Janeiro" disabled>
                                                                </label>


                                                            </section>

                                                            <!-- JANEIRO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasJaneiro">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasJaneiro" name="qtdDiasJaneiro">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" disabled type="text" value="Fevereiro">
                                                                </label>
                                                            </section>

                                                            <!-- FEVEREIRO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasFevereiro">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasFevereiro" name="qtdDiasFevereiro">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Março" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- MARÇO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasMarco">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasMarco" name="qtdDiasMarco">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Abril" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- ABRIL -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasAbril"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasAbril" name="qtdDiasAbril">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Maio" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- MAIO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasMaio"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasMaio" name="qtdDiasMaio">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Junho" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- JUNHO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="Junho"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasJunho" name="qtdDiasJunho">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Julho" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- JULHO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasJulho"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasJulho" name="qtdDiasJulho">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Agosto" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- AGOSTO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasAgosto"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasAgosto" name="qtdDiasAgosto">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Setembro" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- SETEMBRO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasSetembro"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasSetembro" name="qtdDiasSetembro">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Outubro" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- OUTUBRO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasOutubro"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasOutubro" name="qtdDiasOutubro">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Novembro" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- NOVEMBRO-->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasNovembro"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasNovembro" name="qtdDiasNovembro">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input autocomplete="on" class="readonly" type="text" value="Dezembro" disabled>
                                                                </label>
                                                            </section>

                                                            <!-- DEZEMBRO -->
                                                            <section class="col col-1">
                                                                <label class="label" for="qtdDiasDezembro"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="qtdDiasDezembro" name="qtdDiasDezembro">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <!-- DIAS ÚTEIS ─  -->

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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroDiasUteisPorMunicipio.js" type="text/javascript"></script>


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

        carregaPagina();


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

        $("#unidadeFederacao").on("change", function() {
            preencheComboMunicipio();
        });

        $("#municipio").on("change", function() {
            var val = $("#municipio").val();
            var funcao = 'verificaMunicipio';
            $.ajax({
                method: 'POST',
                url: 'js/sqlscope.php',
                data: {
                    funcao,
                    val
                },
                success: function(data) {
                    var status = data.split('#');
                    if (status[0] == 'failed') {
                        smartAlert("Atenção", "O Municipio digitado já existe.", "error");
                        $("#municipio").val("");
                        return;
                    }
                }
            });

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
                recuperaDiasUteisPorMunicipio(idd,
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
                            var unidadeFederacao = piece[1];
                            var municipio = piece[2];
                            var cidade = piece[3];
                            var ativo = +piece[4];
                            var qtdDiasJaneiro = +piece[5];
                            var qtdDiasFevereiro = +piece[6];
                            var qtdDiasMarco = +piece[7];
                            var qtdDiasAbril = +piece[8];
                            var qtdDiasMaio = +piece[9];
                            var qtdDiasJunho = +piece[10];
                            var qtdDiasJulho = +piece[11];
                            var qtdDiasAgosto = +piece[12];
                            var qtdDiasSetembro = +piece[13];
                            var qtdDiasOutubro = +piece[14];
                            var qtdDiasNovembro = +piece[15];
                            var qtdDiasDezembro = +piece[16];
                            var nomeMunicipio = piece[17];

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#unidadeFederacao").val(unidadeFederacao);
                            preencheComboMunicipio();
                            $("#municipio").append('<option value="' + municipio + '">' + nomeMunicipio + '</option>');
                            $("#municipio").val(municipio);
                            $("#cidade").val(cidade);
                            $("#ativo").val(ativo);
                            $("#qtdDiasJaneiro").val(qtdDiasJaneiro);
                            $("#qtdDiasFevereiro").val(qtdDiasFevereiro);
                            $("#qtdDiasMarco").val(qtdDiasMarco);
                            $("#qtdDiasAbril").val(qtdDiasAbril);
                            $("#qtdDiasMaio").val(qtdDiasMaio);
                            $("#qtdDiasJunho").val(qtdDiasJunho);
                            $("#qtdDiasJulho").val(qtdDiasJulho);
                            $("#qtdDiasAgosto").val(qtdDiasAgosto);
                            $("#qtdDiasSetembro").val(qtdDiasSetembro);
                            $("#qtdDiasOutubro").val(qtdDiasOutubro);
                            $("#qtdDiasNovembro").val(qtdDiasNovembro);
                            $("#qtdDiasDezembro").val(qtdDiasDezembro);
                            $("#verificaRecuperacao").val(1);
                            return;

                        }
                    }
                );
            }
        }
        $("#nome").focus();

    }

    function novo() {
        $(location).attr('href', 'cadastro_diasUteisPorMunicipioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_diasUteisPorMunicipioFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirDiasUteisPorMunicipio(id,
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

        // Variáveis que vão ser gravadas no banco:
        var id = +$("#codigo").val();
        var ativo = +$("#ativo").val();
        var unidadeFederacao = $("#unidadeFederacao").val();
        var municipio = $("#municipio").val();
        var cidade = $('#cidade').val().trim().replace(/'/g, " ");
        var qtdDiasJaneiro = +$('#qtdDiasJaneiro').val();
        var qtdDiasFevereiro = +$('#qtdDiasFevereiro').val();
        var qtdDiasMarco = +$('#qtdDiasMarco').val();
        var qtdDiasAbril = +$('#qtdDiasAbril').val();
        var qtdDiasMaio = +$('#qtdDiasMaio').val();
        var qtdDiasJunho = +$('#qtdDiasJunho').val();
        var qtdDiasJulho = +$('#qtdDiasJulho').val();
        var qtdDiasAgosto = +$('#qtdDiasAgosto').val();
        var qtdDiasSetembro = +$('#qtdDiasSetembro').val();
        var qtdDiasOutubro = +$('#qtdDiasOutubro').val();
        var qtdDiasNovembro = +$('#qtdDiasNovembro').val();
        var qtdDiasDezembro = +$('#qtdDiasDezembro').val();


        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!municipio) {
            smartAlert("Atenção", "Informe o município", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cidade) {
            smartAlert("Atenção", "Informe a cidade", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!unidadeFederacao) {
            smartAlert("Atenção", "Informe a unidade federativa", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        gravaDiasUteisPorMunicipio(id, ativo, unidadeFederacao, municipio, cidade, qtdDiasJaneiro, qtdDiasFevereiro, qtdDiasMarco,
            qtdDiasAbril, qtdDiasMaio, qtdDiasJunho, qtdDiasJulho, qtdDiasAgosto, qtdDiasSetembro, qtdDiasOutubro, qtdDiasNovembro, qtdDiasDezembro,
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

    function preencheComboMunicipio() {
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
    }
</script>