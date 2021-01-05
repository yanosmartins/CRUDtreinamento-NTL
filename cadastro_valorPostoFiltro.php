<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('VALORPOSTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('VALORPOSTO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('VALORPOSTO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Filtro de Valor do Posto";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['cadastro']['sub']['valorPosto']['active'] = true;
// $page_nav["cadastrar"]["sub"]["Lista de Clientes"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Controle de Permissão"] = "";
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
                            <h2>Filtro de Valor do Posto</h2>
                        </header>

                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formBanco" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados para Pesquisa
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden">

                                                        <div class="row">

                                                        <section class="col col-4">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="">
                                                                    <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT P.codigo, P.numeroCentroCusto, P.descricao, P.apelido, C.projeto
                                                                        FROM Ntl.projeto P 
                                                                        LEFT JOIN Ntl.contrato C ON projeto = P.codigo 
                                                                        order by codigo ";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            $numeroCentroCusto  = ($row['numeroCentroCusto']);
                                                                            $apelido = ($row['apelido']);
                                                                            echo '<option value=' . $codigo . '>  '  . $apelido . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>


                                                            <section class="col col-3">
                                                                <label class="label">Descrição do Posto</label>
                                                                <label class="select">
                                                                    <select id="descricaoPosto" name="descricaoPosto" class="">
                                                                    <option style="display:none;">Selecione</option>
                                                                        <?php                                                                
                                                                        $sql =  "SELECT codigo, descricao
                                                                        FROM Ntl.posto 
                                                                        order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  '.$descricao . '</option>';
                                                                        }
                                                                        ?>
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

                                        </button>
                                    </footer>
                                </form>
                            </div>
                            <div id="resultadoBusca"> </div>


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

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        
        $('#btnNovo').on("click", function() {
            $(location).attr('href', 'cadastro_valorPostoCadastro.php');
        });

        $('#btnSearch').on("click", function() {
            listarFiltro();
        });

    });



    function listarFiltro() {

        var projeto = +$('#projeto').val();
        var descricaoPosto = +$('#descricaoPosto').val();
        
        
        

        var parametrosUrl = 'projeto=' + projeto;
        parametrosUrl += '&descricaoPosto=' + descricaoPosto;
       
        

      
        $('#resultadoBusca').load('cadastro_valorPostoListagem.php?' + parametrosUrl);
    }
</script>