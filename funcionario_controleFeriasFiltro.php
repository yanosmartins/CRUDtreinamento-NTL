<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
// $condicaoAcessarOK = (in_array('CONTROLEFERIAS_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('CONTROLEFERIAS_GRAVAR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }

// $condicaoAcessarOK = "";
// if ($condicaoAcessarOK === false) {
//     $condicaoAcessarOK = "none";
// }

/* ---------------- PHP Custom Scripts ---------
  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Controle Férias Filtro";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["funcionario"]["sub"]["controleFerias"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Área do Funcionário"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <!-- <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/cadastroLocalizacao.php" style="float:right"></a>
                <?php } ?>
            </div> -->

            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Área do Funcionário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formLocalizacaoFiltro" method="post">
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
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="required" required>
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo,descricao FROM Ntl.projeto WHERE ativo = 1 ORDER BY descricao ";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $id = (int) $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
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

                                                            <section class="col col-2">
                                                                <label class="label" for="periodoFeriasInicio">Período Ferias Início</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoFeriasInicio" name="periodoFeriasInicio" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Período Ferias Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoFeriasFim" name="periodoFeriasFim" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" for="feriasVencidas">Férias Vencidas</label>
                                                                <label class="select">
                                                                        <select name="feriasVencidas" id="feriasVencidas">
                                                                            <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="FeriasAgendadasInicio"> Ferias Agendadas - Início</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="FeriasAgendadasInicio" name="FeriasAgendadasInicio" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> Ferias Agendadas - Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="FeriasAgendadasFim" name="FeriasAgendadasFim" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
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
                                        <button id="btnNovo" type="button" class="btn btn-primary pull-left" style="display:<?php echo $esconderBtnGravar ?>" title="Novo">
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
            $(location).attr('href', 'funcionario_controleFerias.php');
        });
    });

    function listarFiltro() {
        var projeto = $('#projeto').val();
        var funcionario = $('#funcionario').val();
        var periodoFeriasInicio = $('#periodoFeriasInicio').val();
        var periodoFeriasFim = $('#periodoFeriasFim').val();
        var periodoFeriasFim = $('#feriasVencidas').val();
        var feriasAgendadasInicio = $('#feriasAgendadasInicio').val();
        var feriasAgendadasFim = $('#feriasAgendadasFim').val();

        var parametrosUrl = '&projeto=' + projeto;
        parametrosUrl = '&funcionario=' + funcionario;
        parametrosUrl = '&periodoFeriasInicio=' + periodoFeriasInicio;
        parametrosUrl = '&periodoFeriasFim=' + periodoFeriasFim;
        parametrosUrl = '&feriasVencidas=' + feriasVencidas;
        parametrosUrl = '&feriasAgendadasInicio=' + feriasAgendadasInicio;
        parametrosUrl = '&feriasAgendadasFim=' + feriasAgendadasFim;

        $('#resultadoBusca').load('funcionario_controleFeriasFiltroListagem.php?' + parametrosUrl);
    }
</script>