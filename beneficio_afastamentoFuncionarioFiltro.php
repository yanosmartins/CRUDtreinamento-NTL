<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('AFASTAMENTOFUNCIONARIO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('AFASTAMENTOFUNCIONARIO_GRAVAR', $arrayPermissao, true));

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

$page_title = "Afastamento do Funcionário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]["beneficio"]["sub"]["afastamentoFuncionario"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Departamento Pessoal"] = "";
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
                            <h2>Afastamento do funcionário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuarioFiltro" method="post">
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

                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="funcionario">Funcionário</label>
                                                                <label class="input">
                                                                    <input id="funcionario" name="funcionario" autocomplete="off" type="text" maxlength="255">
                                                                </label>
                                                            </section>

                                                            <section class="col col-4 col-auto">
                                                                <label class="label " for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM Ntl.projeto BP 
                                                                                WHERE ativo = 1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Mês/Ano</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesAno" name="mesAno" autocomplete="off" data-mask="99/9999" data-mask-placeholder="MM/AAAA" data-dateformat="mm/yy" placeholder="MM/AAAA" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="motivoDoAfastamento">Motivo do Afastamento</label>
                                                                <label class="input">
                                                                    <input id="motivoDoAfastamento" name="motivoDoAfastamento" autocomplete="off" type="text" maxlength="50">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="dataInicio">Data Inicial</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataInicio" name="dataInicio" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="dataFim">Data Final</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataFim" name="dataFim" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option></option>
                                                                        <option value='1' selected>Sim</option>
                                                                        <option value='0'>Não</option>
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
    });

    function listarFiltro() {
        var funcionario = $('#funcionario').val();
        var motivoDoAfastamento = $('#motivoDoAfastamento').val();
        var dataInicio = $('#dataInicio').val();
        var dataFim = $('#dataFim').val();
        var ativo = $('#ativo').val();
        var mesAno = $('#mesAno').val();
        var projeto = +$('#projeto').val();

        if (funcionario !== "") {
            funcionario = funcionario.replace(/^\s+|\s+$/g, "");
            funcionario = encodeURIComponent(funcionario);
        }

        if (motivoDoAfastamento !== "") {
            motivoDoAfastamento = motivoDoAfastamento.replace(/^\s+|\s+$/g, "");
            motivoDoAfastamento = encodeURIComponent(motivoDoAfastamento);
        }

        if (dataInicio !== "") {
            dataInicio = dataInicio.replace(/^\s+|\s+$/g, "");
            dataInicio = encodeURIComponent(dataInicio);
        }

        if (dataFim !== "") {
            dataFim = dataFim.replace(/^\s+|\s+$/g, "");
            dataFim = encodeURIComponent(dataFim);
        }

        var parametrosUrl = '&funcionario=' + funcionario + '&motivoDoAfastamento=' + motivoDoAfastamento +
            '&dataInicio=' + dataInicio + '&dataFim=' + dataFim + '&ativo=' + ativo + '&mesAno=' + mesAno + '&projeto=' + projeto;
        $('#resultadoBusca').load('beneficio_afastamentoFuncionarioFiltroListagem.php?' + parametrosUrl);
    }

    function novo() {
        $(location).attr('href', 'beneficio_afastamentoFuncionarioCadastro.php');
    }
</script>


//<?php
    //	//include footer
    //	include("inc/google-analytics.php"); 
    //
    ?>