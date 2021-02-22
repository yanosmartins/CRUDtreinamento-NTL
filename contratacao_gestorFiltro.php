<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('GESTOR_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('GESTOR_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('GESTOR_EXCLUIR', $arrayPermissao, true));

$condicaoAcessarOK = true;
$condicaoGravarrOK = true;
$condicaoExcluirOK = true;

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

$page_title = "Controle do Gestor";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['operacao']['sub']['recursoshumanos']['sub']["contratacao"]['sub']["gestor"]["active"] = true;

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
                            <h2>Controle do Gestor</h2>
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
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Projeto</label>
                                                                <label class="input">
                                                                    <input id="projeto" maxlength="255" name="projeto" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Funcionario</label>
                                                                <label class="input">
                                                                    <input id="funcionario" maxlength="255" name="funcionario" type="text" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Sindicato</label>
                                                                <label class="input">
                                                                    <input id="sindicato" maxlength="255" name="sindicato" type="text" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Cargo</label>
                                                                <label class="input">
                                                                    <input id="cargo" maxlength="255" name="cargo" type="text" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Salário Base</label>
                                                                <label class="input">
                                                                    <input id="salarioBase" maxlength="255" name="salarioBase" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="verificadoPeloGestor">Verificado</label>
                                                                <label class="select">
                                                                    <select id="verificadoPeloGestor" name="verificadoPeloGestor" class="">
                                                                        <option></option>
                                                                        <option value="Não" selected>Não</option>
                                                                        <option value="Sim">Sim</option>
                                                                    </select><i></i>
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

        listarFiltro(); //Lista assim que entrar na tela. 

        $('#btnSearch').on("click", function() {
            listarFiltro();
        });

        $('#btnNovo').on("click", function() {
            novo();
        });
    });

    function listarFiltro() {

        let projeto = $('#projeto').val();
        let funcionario = $('#funcionario').val();
        let sindicato = $("#sindicato").val();
        let cargo = $("#cargo").val();
        let salarioBase = $("#salarioBase").val();
        let verificadoPeloGestor = $("#verificadoPeloGestor").val();

        $('#resultadoBusca').load('contratacao_gestorFiltroListagem.php?', {
            projeto: projeto,
            funcionario: funcionario,
            sindicato: sindicato,
            cargo: cargo,
            salarioBase: salarioBase,
            verificadoPeloGestor: verificadoPeloGestor
        });
    }

    function novo() {
        $(location).attr('href', 'contratacao_gestorCadastro.php');
    }
</script>