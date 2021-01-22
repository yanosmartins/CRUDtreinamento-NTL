<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
  
$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Atualizações";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["controle"]["sub"]["atualizacaoVersao"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Controle"] = "";
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
                            <h2>Versões</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <div class="smart-form client-form" id="versao">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <?php

                                                    $reposit = new reposit();

                                                    $codigo = (int) $_GET["codigo"];

                                                    if ($codigo != 0) {
                                                        $sql = "SELECT V.codigo,V.versao FROM sysgc.dbo.controleVersao V WHERE V.codigo = $codigo";
                                                    } else {
                                                        $sql = "SELECT V.codigo,V.versao FROM sysgc.dbo.controleVersao V WHERE V.dataLancamento = (SELECT MAX(dataLancamento) FROM sysgc.dbo.controleVersao)";
                                                    }

                                                    $result = $reposit->RunQuery($sql);
                                                    $row = $result[0];

                                                    $codigo = $row["codigo"];
                                                    $versao = $row["versao"];
                                                    ?>
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Versão <?php echo $versao ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <article>
                                                        <div class="row">
                                                            <?php
                                                            $reposit = new reposit();

                                                            $sql = "SELECT N.codigo, N.titulo,N.versao, N.descricao FROM sysgc.dbo.notaVersao N WHERE N.versao = $codigo";

                                                            $result = $reposit->RunQuery($sql);

                                                            foreach($result as $row) {
                                                                $codigo = (int) $row['codigo'];
                                                                $titulo = $row['titulo'];
                                                                $titulo = str_replace("U+0027", "'", $titulo);
                                                                $descricao = $row['descricao'];
                                                                $descricao = str_replace("U+0027", "'", $descricao);
                                                                if (strlen($titulo) >= 72) {
                                                                    echo "
                                                                    <section class=\"col-sm-12 col-md-12 col-lg-12\">
                                                                        <div style = \"word-wrap:break-word;padding: 0 20px;\">
                                                                            <h3 class=\"text-justify\">$titulo</h3>
                	                                                        <small class=\"text-justify\">$descricao</small>
                                                                        </div>  
                                                                    </section>";
                                                                } else {
                                                                    echo "
                                                                    <section class=\"col-sm-12 col-md-6 col-lg-4\">
                                                                        <div style = \"word-wrap:break-word;padding: 0 20px;\">
                     	                                                    <h3 class=\"text-justify\">$titulo</h3>
                                                                            <small class=\"text-justify\">$descricao</small>
                                                                        </div>
                                                                    </section>";
                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button id="btnVoltar" type="button" class="btn btn-primary pull-right" title="Buscar">
                                            <span class="fa fa-backward"></span>
                                        </button>
                                    </footer>
                                </div>
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

        $('#btnVoltar').on("click", function() {
            voltar();
        });
    });

    function voltar() {
        $(location).attr('href', 'controleVersaoFiltro.php');
    }
</script>