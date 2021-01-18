<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PROJETO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PROJETO_GRAVAR', $arrayPermissao, true));

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

$page_title = "Projeto";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");


//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["projeto"]["active"] = true;

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
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Projeto</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formFiltro" method="post">
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
                                                                <label class="label">Projeto</label>
                                                                <label class="input">
                                                                    <input id="descricao" maxlength="70" name="descricao" type="text" placeholder="" value="" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label">Apelido</label>
                                                                <label class="input">
                                                                    <input id="apelido" name="apelido" type="text" placeholder="" value="" autocomplete="off" maxlength="50">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CNPJ</label>
                                                                <label class="input">
                                                                    <input id="cnpj" name="cnpj" maxlength="18" data-mask="99.999.999/9999-99" data-mask-placeholder="_" class="" type="text" value="" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option></option>
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>

                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Busca por Data</label>
                                                                <label class="select">
                                                                    <select id="busca" name="ativo" class="required">
                                                                        <option></option>
                                                                        <option value="A">Assinatura</option>
                                                                        <option value="R">Renovação</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data inicial</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataInicial" name="dataInicial" type="text" data-dateformat="dd/mm/yy" class="datepicker required" required value="" data-mask="99/99/9999" data-mask-placeholder="_" autocomplete="off" onchange="validaData(this)">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data final</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataFinal" name="dataFinal" type="text" data-dateformat="dd/mm/yy" class="datepicker required" required value="" data-mask="99/99/9999" data-mask-placeholder="_" autocomplete="off" onchange="validaData(this)">
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
                                        <button id="btnNovo" type="button" class="btn btn-primary pull-left" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
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
        $('#btnSearch').on("click", function() {
            listarFiltro();
        });
        $('#btnNovo').on("click", function() {
            novo();
        });
        $.datepicker.setDefaults($.datepicker.regional["pt-BR"]);

        $("#dataFinal").on("change", function() {
            var valor = "#dataFinal";
            retorno = validaData(valor);
            if (retorno == false) {
                $("#dataFinal").val('');
            }
            if (retorno == true) {
                var dataInicial = $('#dataInicial').datepicker('getDate');
                var dataFinal = $('#dataFinal').datepicker('getDate');
                var retorno = calculaDifDatas(dataInicial, dataFinal, 'D');
                if (retorno < 0) {
                    smartAlert("Erro", "Data de Inicio não pode ser maior do que a Final.",
                        "error");
                    $("#dataFinal").val('');
                }
            }
        });



    });

    function listarFiltro() {
        var ativo = $('#ativo').val();
        var descricao = $('#descricao').val();
        var apelido = $('#apelido').val();
        var cnpj = $('#cnpj').val();
        var dataInicial = $('#dataInicial').val();
        var dataFinal = $('#dataFinal').val();
        var dataInicialAssinatura = $('#dataInicialAssinatura').val();
        var dataFinalAssinatura = $('#dataFinalAssinatura').val();
        var busca = $('#busca').val();




        var parametrosUrl = '&ativo=' + ativo + '&descricao=' + descricao + '&apelido=' + apelido + '&cnpj=' + cnpj +
            '&dataInicial=' + dataInicial + '&dataFinal=' + dataFinal + '&busca=' + busca;
        $('#resultadoBusca').load('cadastro_projetoFiltroListagem.php?' + parametrosUrl);
    }

    function novo() {
        $(location).attr('href', 'cadastro_projetoCadastro.php');
    }

    function validaData(valor) {
        var valor = valor;
        var date = $(valor).val();
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
            smartAlert("Erro", "Data incorreta.", "error");
            $(valor).val('');
            return false;
        }
        return true;
    }
</script>