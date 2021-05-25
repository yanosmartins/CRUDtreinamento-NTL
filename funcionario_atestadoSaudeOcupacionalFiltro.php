<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('SINDICATO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('SINDICATO_GRAVAR', $arrayPermissao, true));

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

$page_title = "ASO";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["beneficio"]["sub"]["triagem"]["sub"]["relatorioValidade"]["active"] = true;

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
                            <h2>ASO</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formValeTransporteModalFiltro" method="post">
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
                                                        <section class="col col-4">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
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
                                                            <section class="col col-4">
                                                                <label class="label " for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao  from Ntl.projeto where ativo = 1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoProjeto = (int) $row['codigo'];
                                                                            $descricao = $row['descricao'];

                                                                            echo '<option value=' . $codigoProjeto . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                         
                                                            <section class="col col-2">
                                                                <label class="label" for="dataValidadeAsoInicio">Validade ASO Inicio</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataValidadeAsoInicio" name="dataValidadeAsoInicio" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataValidadeAsoFim">Validade ASO Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataValidadeAsoFim" name="dataValidadeAsoFim" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            </div>
                                                            <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label" for="idadeInicio">Idade inicio</label>
                                                                <label class="input">
                                                                    <input id="idadeInicio" name="idadeInicio" class="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="idadeFim">Idade Fim</label>
                                                                <label class="input">
                                                                    <input id="idadeFim" name="idadeFim" class="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="vencido">Vencido</label>
                                                                <label class="select">
                                                                    <select id="vencido" name="vencido" class="">
                                                                    <option></option>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='2'>Não</option>
                                                                    </select><i></i>
                                                                    </section>
                                                          
                                                            
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="" required>
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
//include scripts
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

    function novo() {
        $(location).attr('href', 'funcionario_atestadoSaudeOcupacional.php');
    }

    function listarFiltro() {
        var funcionario = +$('#funcionario').val();
        var projeto = +$("#projeto").val();
        var ativo = $("#ativo").val();
        var dataValidadeAsoInicio = $("#dataValidadeAsoInicio").val();
        var dataValidadeAsoFim = $("#dataValidadeAsoFim").val();
        var vencido = $("#vencido").val();
        var idadeInicio = +$("#idadeInicio").val();
        var idadeFim = +$("#idadeFim").val();

        var parametrosUrl;
        parametrosUrl = '&funcionario=' + funcionario +
            '&projeto=' + projeto +
            '&ativo=' + ativo +
            '&dataValidadeAsoInicio=' + dataValidadeAsoInicio +
            '&dataValidadeAsoFim=' + dataValidadeAsoFim +
            '&vencido=' + vencido +
            '&idadeInicio=' + idadeInicio +
            '&idadeFim=' + idadeFim;
           
        $('#resultadoBusca').load('funcionario_atestadoSaudeOcupacionalFiltroListagem.php?' + parametrosUrl);
    }
</script>