<?php
//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PROCESSABENEFICIO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PROCESSABENEFICIO_GRAVAR', $arrayPermissao, true));

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

$page_title = "Consulta Benefício";
/* ---------------- END PHP Custom Scripts ------------- */
//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["beneficio"]["sub"]['operacao']["consultaBeneficio"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Operação"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row" style="margin: 0 0 13px 0;">
            </div>
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Consulta Benefício</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="" class="smart-form client-form" id="formFiltro" method="post">
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
                                                        <input id="codigo" name="codigo" type="text" class="hidden" value="">
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Projeto</label>
                                                                <label class="input">
                                                                    <input id="projetoId" type="hidden" value="">
                                                                    <input id="projeto" name="projeto" autocomplete="off" class="form-control required" required placeholder="Digite o Projeto..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label " for="projeto">Projeto Pesquisa</label>
                                                                <label class="select">
                                                                    <select id="projetoFiltro" name="projetoFiltro" class="required" required>
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
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Mês/Ano</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="data" name="data" autocomplete="off" data-mask="99/9999" data-mask-placeholder="MM/AAAA" data-dateformat="mm/yy" placeholder="MM/AAAA" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button id="btnSearch" type="button" class="btn btn-primary" title="Buscar">
                                            <i class="fa bg-red fa-search fa-lg  bg-blue-light text-magenta "></i>
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
<script src="js/business_beneficioProcessaBeneficio.js"></script>
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>
<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>
<script>
    $('body').addClass("minified");
    $(document).ready(function() {
        $('#btnSearch').on("click", function() {
            listarFiltro();
        });
        $('#projetoFiltro').on("change", function() {
            $("#projetoId").val('');
            $("#projeto").val('');
        });

        $("#projeto").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroProjeto.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaProjetoAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao
                            };
                        }));
                    },
                    // async: false,
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#projetoId").val(ui.item.id);
                $("#projeto").val(ui.item.descricao);
                var projetoId = $("#projetoId").val();
                $("#projetoFiltro").val(projetoId);
                $("#projetoFiltro").trigger('change');

            },

            change: function(event, ui) {

                if (ui.item === null) {
                    $("#projetoId").val('');
                    $("#projeto").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);

        };
  

        $("#projetoFiltro").on("change", function() {
            $("#projetoId").val(+$("#projetoFiltro").val());
            $("#projeto").val($("#projetoFiltro option:selected").text());
            $("#projetoFiltro").val('');
        });
    });

    function listarFiltro() {
        var projeto = +$("#projetoId").val();
        var data = $('#data').val();
  
        if (!projeto) {
            smartAlert("Atenção", "Informe o Projeto", "error");
            return;
        }

        var parametrosUrl = '&projeto=' + projeto + '&data=' + data;
        $('#resultadoBusca').load('beneficio_consultaBeneficioFiltroListagem.php?' + parametrosUrl);
    }
</script>