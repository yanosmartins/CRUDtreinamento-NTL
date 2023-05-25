<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
//$condicaoAcessarOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('USUARIO_GRAVAR', $arrayPermissao, true));
// $condicaoExcluirOK = (in_array('USUARIO_EXCLUIR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

// $esconderBtnExcluir = "";
// if ($condicaoExcluirOK === false) {
//     $esconderBtnExcluir = "none";
// }

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Gênero";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");


//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["tabelaBasica"]["sub"]["genero"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    $breadcrumbs["Configurações"] = "";
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
                            <h2>Gênero</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formUsuario">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" type="text" value="<?= $_GET['codigo'] ?>" hidden>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Descrição de Gênero:</label>
                                                                <label class="input">
                                                                    <input id="descricao" maxlength="255" name="nome" class="required">
                                                                </label>
                                                            </section>
                                                            <!-- <section class="col col-2" hidden>
                                                                <label class="label">&nbsp;</label>
                                                                <label id="labelAtivo" class="checkbox ">
                                                                    <input checked="checked" id="ativo" name="ativo" type="checkbox" value="true"><i></i>
                                                                    Ativo
                                                                </label>
                                                            </section>                                                                                                                      -->
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-2" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <p>CONFIRMA A EXCLUSÃO ? </p>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $url = explode("?", $_SERVER["REQUEST_URI"]); ////essas linhas fazem a leitura do codigo "id" na url
                                        $codigo = explode("=", $url[1]);
                                        $codigoBtn = (int)$codigo[1];
                                        $esconderBtn = "none";
                                        if ($codigoBtn != 0) {
                                            $esconderBtn = "block"; /// permite aparecer o botao
                                        }
                                        ?>

                                        <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar">
                                            <span class="fa fa-floppy-o"></span>
                                        </button>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtn ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                        <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                            <span class="fa fa-backward "></span>
                                        </button>
                                    </footer>
                                </form>
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

<script src="<?php echo ASSETS_URL; ?>/js/TBbusinessCadastroGenero.js" type="text/javascript"></script>

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
    //     //EVENTO CONSTANTE
    $(document).ready(function() {
        carregaPagina();
        $("#descricao").on("change", function() {

            console.log(this.value)
            if (/[0-9\!\#\$\&\*\-\_\/Ç\'\<\>\^\~\+\?\.\;\,\:\]\[\(\)]/g.test(this.value)) {
                // \ã\â\à\é\ê\í\ó\õ\ô\ú\ç\á\Á\Ã\Â\À\É\Ê\Í\Ó\Õ\Ô\Ú\é
                smartAlert("Atenção", "Nome inválido, use apenas Letras", "error");
                $("#descricao").val('');
                return;
            }
            verificaGenero()
        });

        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Excluir registro",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    excluir();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });

        $("#btnExcluir").on("click", function() {
            var id = +$("#codigo").val();

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');

            }

        });

        $("#btnGravar").on("click", function() {
            document.getElementById("btnGravar").disabled = true;
            setTimeout(function() {
                document.getElementById("btnGravar").disabled = false
            }, 1500)
            var teste = verificaGenero()
            if (verificaGenero())
                gravar();
            
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });
    });


    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaGenero(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayTelefone = piece[2];
                            var strArrayEmail = piece[3];
                            var strArrayDependente = piece[4];
                            piece = out.split("^");
                            // Atributos de vale transporte unitário que serão recuperados: 
                            var ativo = piece[0];
                            var descricao = piece[1];
                            $("#ativo").val(ativo);
                            $("#descricao").val(descricao);
                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            var ativo = $("#ativo").val();
                            var descricao = $("#descricao").val();
                            return;
                        }
                    }
                );
            }
        }
    }

    function gravar() {
        var descricao = $("#descricao").val();
        var codigo = $("#codigo").val();
        var ativo = 1;

        if ($("#ativo").is(':checked')) {
            ativo = 1;
        }

        if (descricao.length === 0 || !descricao.trim()) {
            smartAlert("Atenção", "Informe o nome!", "error");
            $("#descricao").focus();
            return;
        }
        gravaGenero(codigo, descricao, ativo);
    }

    function verificaGenero() {
        var descricao = $("#descricao").val();
        generoVerificado(descricao);
    }

    function voltar() {
        $(location).attr('href', 'TBGeneroFiltro.php');
    }

    function excluir() {
        var ativo = $("#ativo").val();
        var codigo = $("#codigo").val();
        excluiGenero(codigo, ativo);
        voltar()

    }

    function novo() {
        $(location).attr('href', 'TBGeneroFiltro.php');
    }
</script>