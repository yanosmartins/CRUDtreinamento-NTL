<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('CANDIDATO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CANDIDATO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CANDIDATO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Canditados";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['recursoshumanos']['sub']["contratacao"]['sub']['candidato']["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Recursos Humanos"] = "";
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
                            <h2>Cadastro</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuario" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Nome</label>
                                                                <label class="input">
                                                                    <input id="nome" maxlength="255" name="nome" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" maxlength="15" data-mask="999.999.999-99" name="cpf" type="text" value="" onchange="verificaCpf('#cpf')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">RG</label>
                                                                <label class="input">
                                                                    <input id="rg" maxlength="15" data-mask="99.999.999-9" name="rg" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cargo</label>
                                                                <label class="input">
                                                                    <input id="cargo" maxlength="50" name="cargo" type="text" autocomplete="off" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Status</label>
                                                                <label class="select">
                                                                    <select id="verifica" name="verifica" class="">
                                                                        <option></option>
                                                                        <option value="0">Não Verificado</option>
                                                                        <option value="1">Pendente</option>
                                                                        <option value="2">Verificado</option>
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
                                        <button id="btnNovo" type="button" class="btn btn-primary pull-left" title="Novo" style="<?= $esconderBtnGravar ?>">
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
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $('#btnSearch').on("click", function() {
            listarFiltro();
        });
        $('#btnNovo').on("click", function() {
            novo();
        });
        $.datepicker.setDefaults($.datepicker.regional["pt-BR"]);

        $("#dataFinal").on("change", function() {
            var valor = "#dataFinal";
            retorno = validaData(valor);
            if (retorno == false) {
                $("#dataFinal").val('');
            }
            if (retorno == true) {
                var dataInicial = $('#dataInicial').datepicker('getDate');
                var dataFinal = $('#dataFinal').datepicker('getDate');
                var retorno = calculaDifDatas(dataInicial, dataFinal, 'D');
                if (retorno < 0) {
                    smartAlert("Erro", "Data de Inicio não pode ser maior do que a Final.",
                        "error");
                    $("#dataFinal").val('');
                }
            }
        });

        // $('#tipoPendencia').change(function() {
        //     var tipoPendencia = +$('#tipoPendencia').val();
        //     if (tipoPendencia != "") {
        //         $("#verifica").removeClass('readonly');
        //         // $("#numeroCartaoVt").addClass('required');
        //         $("#verifica").removeAttr('disabled');
        //     } else {
        //         $("#verifica").addClass('readonly');
        //         // $("#numeroCartaoVt").removeClass('required');
        //         $("#verifica").val('');
        //         $("#verifica").prop('disabled', true);
        //     }
        // });
    });

    function listarFiltro() {

        var nome = $('#nome').val();
        var cpf = $('#cpf').val();
        var rg = $('#rg').val();
        var cargo = $('#cargo').val();
        // var tipoPendencia = $('#tipoPendencia').val();
        var verifica = $('#verifica').val();
        // var pendencia = $('#pendencia').val();
        // var pendencia = $('#pendencia').val();


        //     '&pendencia=' + pendencia

        $('#resultadoBusca').load('contratacao_candidatoFiltroListagem.php?', {
            nome: nome,
            cpf: cpf,
            rg: rg,
            cargo: cargo,
            // tipoPendencia: tipoPendencia,
            verifica: verifica
        });
    }

    function novo() {
        $(location).attr('href', 'contratacao_candidatoCadastro.php');
    }

    function verificaCpf(inputField) {
        var valor = $(inputField).val();
        var retorno = validacao_cpf(valor);
        if (retorno === false) {
            smartAlert("Atenção", "O cpf digitado é inválido.", "error");
            $(inputField).val('');
            return;
        }
    }
</script>