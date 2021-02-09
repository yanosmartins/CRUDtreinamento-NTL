<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
// $condicaoAcessarOK = (in_array('ISS_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('ISS_GRAVAR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }

// $esconderBtnGravar = "";
// if ($condicaoGravarOK === false) {
//     $esconderBtnGravar = "none";
// }

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Encargo";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");


//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]['faturamento']['sub']["insumos"]["active"] = true;

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
        <!-- <section id="widget-grid" class="">
            <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/cadastro.php" style="float:right"></a>
                <?php } ?>
            </div> -->

        <div class="row">
            <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                    <header>
                        <span class="widget-icon"><i class="fa fa-cog"></i></span>
                        <h2>Insumos</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <form action="javascript:gravar()" class="smart-form client-form" id="formRetencaoTributariaFiltro" method="post">
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
                                                    <div class="row ">

                                                    <section class="col col-4">
                                                                <label class="label">Nome</label>
                                                                <label class="input">
                                                                    <input id="nome" maxlength="255" name="nome" type="text" value="">
                                                                </label>
                                                            </section>

                                                        <section class="col col-2">
                                                            <label class="label">Valor</label>
                                                            <label class="input"><i class="icon-append fa fa-money"></i>
                                                                <input id="percentual" name="percentual" maxlength="5" style="text-align: right;" type="text" autocomplete="off">

                                                            </label>
                                                        </section>
                                                        <section class="col col-2">
                                                            <label class="label">Ativo</label>
                                                            <label class="select">
                                                                <select name="ativo" id="ativo" class="" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                    <option value=""></option>
                                                                    <option value="1" selected>Sim</option>
                                                                    <option value="0">Não</option>
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

                                    <button id="btnNovo" type="button" class="btn btn-primary pull-left" title="Novo">
                                        <span class="fa fa-file"></span>
                                    </button>
                                </footer>
                            </form>
                        </div>
                        <div id="resultadoBusca"></div>
                        <div class="table-container">
                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                    <thead>
                                        <tr role="row">
                                            <th class="text-left" style="min-width:30px;">Descrição</th>
                                            <th class="text-left" style="min-width:30px;">Valor</th>
                                            <th class="text-left" style="min-width:35px;">Ativo</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        echo '<tr >';
                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">Uniforme</a></td>';
                                        echo '<td class="text-left">R$ 251,98</td>';
                                        echo '<td class="text-left">Sim</td>';
                                        echo '</tr >';
                                        echo '<tr >';
                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">Capacete</a></td>';
                                        echo '<td class="text-left">R$ 198,88</td>';
                                        echo '<td class="text-left">Sim</td>';
                                        echo '</tr >';
                                        echo '<tr >';
                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">Benefício Social Familiar - Cláusula 26º, parágrafo 2º da CCT</a></td>';
                                        echo '<td class="text-left">R$ 5,00</td>';
                                        echo '<td class="text-left">Sim</td>';
                                        echo '</tr >';
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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

        $('#percentual').focusout(function() {
            var percentual, element;
            element = $(this);
            element.unmask();
            percentual = element.val().replace(/\D/g, '');
            if (percentual.length > 3) {
                element.mask("99.99");
            } else {
                element.mask("9.99?9");
            }
        }).trigger('focusout');


        $('#btnSearch').on("click", function() {
            listarFiltro();
        });
        $('#btnNovo').on("click", function() {
            $(location).attr('href', 'prototipoValorPosto_insumoCadastro.php');
        });
    });

    function listarFiltro() {
        var nome = $('#nome').val();
        var percentual = $('#percentual').val();
        var ativo = $('#ativo').val();

        var parametrosUrl = '&nome=' + nome;
        var parametrosUrl = '&percentual=' + percentual;
        parametrosUrl = '&ativo=' + ativo;
        $('#resultadoBusca').load('tabelaBasica_encargoFiltroListagem.php?' + parametrosUrl);
    }
</script>