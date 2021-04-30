<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */
session_start();
$id = $_SESSION['funcionario'];

$page_title = "Home";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["home"]["active"] = true;
include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable leftBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-user"></i></span>
                            <h2> <b>Área do Funcionário</b>
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formLocalizacao" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <!-- <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Selecione um atalho ou navegue pelo menu lateral
                                                    </a>
                                                </h4>
                                            </div> -->
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden">
                                                        <!-- <div class="row "> -->
                                                        <!-- <section class="col col-1">
                                                              <label class="input">
                                                                    <input id="descricao" name="descricao" class="hidden" autocomplete="off" type="text" class="required" value="" required>
                                                                </label> 
                                                            </section> -->
                                                        <!-- </div>  -->
                                                        <!-- <div class="row "> -->
                                                        <!-- <section class="col col-1">
                                                            </section> -->
                                                        <!-- <section class="col col-6"> -->
                                                        <button>
                                                            <a href=".php" class="btn btn-primary btn-xs disabled" id="buttonFolhaMensal" name="buttonPonto" style="display:inline-grid "><i class="fa fa-clock-o fa-2x"></i><br> Bater Ponto </a>
                                                        </button>
                                                        <button>
                                                            <a href="funcionario_folhaPontoMensalCadastro.php" class="btn btn-primary btn-xs " id="buttonFolhaMensal" name="buttonPonto" style="display:inline-grid "><i class="fa fa-calendar fa-2x"></i><br>Ponto Mensal </a>
                                                        </button>
                                                        <button>
                                                            <a href="funcionario_folhaDePontoPdf.php?id=<?php echo $id ?>" target="_blank" class="btn btn-primary btn-xs" id="buttonPonto" name="buttonPonto" style="display:inline-grid"><i class="fa fa-file fa-2x"> </i><br>Folha Mensal</a>
                                                        </button>
                                                        <button>
                                                            <a href="javascript:void(0);" class="btn btn-primary btn-xs disabled" id="buttonPonto" name="buttonPonto" style="display:inline-grid" disabled><i class="fa fa-file-text fa-2x "> </i>Folha Mensal <br> Preenchida</a>
                                                        </button>
                                                        <!-- </section> 
                                                            <section class="col col-5"> -->
                                                        <button>
                                                            <a href="http://www.contrachequeweb.com.br/ntl/" target="_blank" class="btn btn-primary btn-xs" id="buttonFolhaMensal" name="buttonPonto" style="display:inline-grid"><i class="fa fa fa-money fa-2x"></i><br>contracheque </a>
                                                        </button>
                                                        <button>
                                                            <a href="" class="btn btn-primary btn-xs disabled" id="buttonFolhaMensal" name="buttonPonto" style="display:inline-grid" disabled><i class="fa fa fa-stethoscope fa-2x "></i><br>Consulta ASO</a>
                                                        </button>
                                                        <!-- </section>
                                                        </div> -->
                                                        <div class="row">
                                                            <!-- <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col col-auto">
                                                                            <a href="" class="btn btn-primary fadeIn" id="buttonFolhaMensal" name="buttonPonto" style="display:inline-grid"><i class="fa fa-clock-o fa-3x"></i><br>Bater Ponto   </a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="col col-auto">
                                                                            <a href="funcionario_folhaDePontoPdf.php?id=<?php echo $id ?>" class="btn btn-primary " id="buttonPonto" name="buttonPonto" style="display:inline-grid"><i class="fa fa-file fa-3x"> </i><br>Folha Mensal</a>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="col col-auto">
                                                                            <a href="funcionario_folhaDePontoPdf.php?id=<?php echo $id ?>" class="btn btn-primary " id="buttonPonto" name="buttonPonto" style="display:inline-grid"><i class="fa fa-file fa-3x"> </i><br>Folha Mensal</a>
                                                                        </div >
                                                                    </td>
                                                                </tr> -->
                                                            <!-- <tr> </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col">
                                                                            <a href="funcionario_folhaDePontoPdf.php?id=<?php echo $id ?>" class="btn btn-primary " id="buttonPonto" name="buttonPonto" style="display:inline-grid"><i class="fa fa-file fa-3x"> </i><br>Folha Mensal</a>
                                                                        </div >
                                                                    </td>
                                                                    <td>
                                                                        <div class="col">
                                                                            <a href="funcionario_folhaDePontoPdf.php?id=<?php echo $id ?>" class="btn btn-primary " id="buttonPonto" name="buttonPonto" style="display:inline-grid"><i class="fa fa-file fa-3x"> </i><br>Folha Mensal</a>
                                                                        </div>
                                                                    </td>
                                                                </tr> -->

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <footer>
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
                                    </footer> -->
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
        $('span.minifyme').trigger("click");
    });
</script>