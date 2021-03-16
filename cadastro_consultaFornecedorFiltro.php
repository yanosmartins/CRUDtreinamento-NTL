<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('FORNECEDOR_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('FORNECEDOR_GRAVAR', $arrayPermissao, true));

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

$page_title = "Consulta fornecedor";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["fornecedor"]["active"] = true;

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
        <section id="widget-grid" class="">                
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Consulta fornecedor</h2>
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
 
                                                        <section class="col col-3 col-auto">
                                                                <label class="label" for="projeto">Fornecedor</label>
                                                                <label class="select">
                                                                    <select id="fornecedor" name="fornecedor" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select F.codigo, F.apelido  from Ntl.fornecedor F  where ativo = 1 order by apelido";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $id = (int) $row['codigo'];
                                                                            $descricao = $row['apelido'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="projeto">Material</label>
                                                                <label class="select">
                                                                    <select id="estoque" name="estoque" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        // $reposit = new reposit();
                                                                        // $sql = "select E.codigo, E.descricao  from Estoque.estoque E  where ativo = 1 order by descricao";
                                                                        // $result = $reposit->RunQuery($sql);
                                                                        // foreach($result as $row) {
                                                                        //     $id = (int) $row['codigo'];
                                                                        //     $estoque = $row['descricao'];
                                                                        //     echo '<option value=' . $id . '>' . $estoque . '</option>';
                                                                        // }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="projeto">Grupo Item</label>
                                                                <label class="select">
                                                                    <select id="grupoItem" name="grupoItem" class="">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, estoque, descricao, ativo FROM Estoque.grupoItem WHERE ativo = 1";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $id = (int) $row['codigo'];
                                                                            $grupoItem = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $grupoItem . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
<!--                                                             
                                                               <section class="col col-2 col-auto">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option></option>
                                                                        <option value="1" selected>Sim</option> 
                                                                        <option value="0">Não</option> 
                                                                    </select><i></i> 
                                                                </label> 
                                                            </section>  -->

                                                            <section class="col col-1 col-auto">
                                                                <label class="label">NF</label>
                                                                <label class="select">
                                                                    <select id="notaFiscal" name="notaFiscal">
                                                                        <option></option>
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
       $(document).ready(function () {
         $('#btnSearch').on("click", function () {
            listarFiltro();
        });
    });

    function listarFiltro() {
       
        var apelido = $('#fornecedor').val();
        var estoque = $('#estoque').val();
        var grupoItem = $('#grupoItem').val();
        var notaFiscal = $('#notaFiscal').val();
           
         
        var parametrosUrl = '&apelido=' + apelido + '&estoque=' + estoque  + '&grupoItem=' + grupoItem   + '&notaFiscal=' + notaFiscal;
        $('#resultadoBusca').load('cadastro_consultaFornecedorFiltroListagem.php?' + parametrosUrl);
    }
    
   
    
</script>    
