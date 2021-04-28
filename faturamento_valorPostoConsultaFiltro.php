<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('VALORPOSTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('VALORPOSTO_GRAVAR', $arrayPermissao, true));

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

$page_title = "Consulta Valor Posto";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");


//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['faturamento']['sub']['cadastro']['sub']["projetoPostoConsulta"]["active"] = true;

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
                        <h2>Consulta Valor posto</h2>
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
                                                        <section class="col col-6">
                                                            <label class="label" for="projeto">Projeto</label>
                                                            <label class="select">
                                                                <select id="projeto" class="required" name="projeto">
                                                                    <option></option>
                                                                    <?php
                                                                    $sql =  "SELECT codigo, numeroCentroCusto, descricao, apelido FROM Ntl.projeto where ativo = 1 order by codigo";
                                                                    $reposit = new reposit();
                                                                    $result = $reposit->RunQuery($sql);
                                                                    foreach ($result as $row) {

                                                                        $row = array_map('mb_strtoupper', $row);
                                                                        $codigo = $row['codigo'];
                                                                        $descricao = ($row['descricao']);
                                                                        $numeroCentroCusto  = ($row['numeroCentroCusto']);
                                                                        $apelido = ($row['apelido']);
                                                                        echo '<option value=' . $codigo . '>  ' . $apelido . ' - ' . $descricao . '</option>';
                                                                    }
                                                                    ?>
                                                                </select><i></i>
                                                            </label>
                                                        </section>
                                                        <input id="posto" name="posto" type="text" class="hidden" value="">
                                                        <!-- <section class="col col-4">
                                                            <label class="label" for="posto">Posto</label>
                                                            <label class="select">
                                                                <select id="posto" class="required" name="posto">
                                                                    <option></option>
                                                                    <?php
                                                                    $sql =  "SELECT codigo,  descricao FROM Ntl.posto where ativo = 1 order by codigo";
                                                                    $reposit = new reposit();
                                                                    $result = $reposit->RunQuery($sql);
                                                                    foreach ($result as $row) {

                                                                        $row = array_map('mb_strtoupper', $row);
                                                                        $codigo = $row['codigo'];
                                                                        $descricao = ($row['descricao']);
                                                                        $numeroCentroCusto  = ($row['numeroCentroCusto']);
                                                                        $apelido = ($row['apelido']);
                                                                        echo '<option value=' . $codigo . '>  '  . $descricao . '</option>';
                                                                    }
                                                                    ?>
                                                                </select><i></i>
                                                            </label>
                                                        </section> -->
                                                        <input id="ativo" name="ativo" type="text" class="hidden" value="">
                                                        <!-- <section class="col col-2">
                                                            <label class="label" for="ativo">Ativo</label>
                                                            <label class="select">
                                                                <select id="ativo" name="ativo">
                                                                    <option></option>
                                                                    <option value="1" selected>Sim</option>
                                                                    <option value="0">Não</option>
                                                                </select><i></i>
                                                        </section> -->
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <footer>
                                    <!-- <button id="fechaValorPosto" type="button" class="btn btn-danger pull-left" aria-hidden="true" title="btn">
                                        Fechamento
                                    </button> -->
                                    <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                            <span id="ui-id-2" class="ui-dialog-title">
                                            </span>
                                        </div>
                                        <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                            <p>CONFIRMA O FECHAMENTO ? </p>
                                        </div>
                                        <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                            <div class="ui-dialog-buttonset">
                                            </div>
                                        </div>
                                    </div>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_faturamentoValorPosto.js" type="text/javascript"></script>
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

        $("#fechaValorPosto").on("click", function() {
            var id = $("#codigo").val();
            var projeto = $('#projeto').val();
            if (!projeto) {
                smartAlert("Atenção", "Selecione um Projeto para Fechar !", "error");
                $("#projeto").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "Atenção",
            buttons: [{
                html: "Excluir registro",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    fecharValorPosto();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });

    });

    function listarFiltro() {
        var posto = $('#posto').val();
        var projeto = $('#projeto').val();

        if (!projeto) {
            smartAlert("Atenção", "Informe o projeto", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        var ativo = $('#ativo').val();
        var parametrosUrl = '&posto=' + posto;
        parametrosUrl += '&projeto=' + projeto;
        parametrosUrl += '&ativo=' + ativo;
        $('#resultadoBusca').load('faturamento_valorPostoConsultaFiltroListagem.php?' + parametrosUrl);
    }

    function fecharValorPosto() {
        var projeto = $('#projeto').val();
        if (projeto === 0) {
            smartAlert("Atenção", "Selecione um Projeto para Fechar!", "error");
            return;
        }
        fechaValorPosto(projeto, function(data) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
        });
    }
 
</script>