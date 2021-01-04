<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Vale Transporte Unitário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["valeTransporteUnitario"]["active"] = true;

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
            <div class="row" class="smart-form">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Vale Transporte Unitário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formCliente" method="post" enctype="multipart/form-data">
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
                                                        <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden" value="">
                                                        <div class="row">
                                                            <input type="text" class="hidden" id="codigo" name="codigo" value="">
                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="descricao">Descrição</label>
                                                                <label class="input">
                                                                    <input type="text" id="descricao" maxlength="100" name="descricao" class="required" autocomplete="off" />
                                                                </label>
                                                            </section>

                                                            <section class="col col-2  col-auto">
                                                                <label class="label" for="valorUnitario">Valor Unitário </label>
                                                                <label class="input"><i class="icon-append fa fa-dollar"></i>
                                                                    <input type="text" maxlength="5" id="valorUnitario" name="valorUnitario" placeholder="0,00" class="required decimal-2-casas" autocomplete="off" />
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="unidadeFederacao">UF</label>
                                                                <label class="select">
                                                                    <select id="unidadeFederacao" name="unidadeFederacao" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $sigla = mb_convert_encoding($row['sigla'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required">
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <footer>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
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
                                        <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-floppy-o"></span>
                                        </button>
                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o"></span>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroValeTransporteUnitario.js" type="text/javascript"></script>


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


<!-- Validador de CPF -->
<script src="js/plugin/cpfcnpj/jquery.cpfcnpj.js"></script>


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        carregaPagina();

        $('.valorUnitario').mask('#.##9,99', {
            reverse: true
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
            var id = $("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnGravar").on("click", function() {
            var verifica = $("#verificaRecuperacao").val();
            if (verifica == 1) {
                gravar();
            } else {
                verificaDescricaoExistente();
            }
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
                recuperaValeTransporteUnitario(idd, function(data) {
                    if (data.indexOf('failed') > -1) {
                        return;
                    } else {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        var out = piece[1];
                        piece = out.split("^");

                        // Atributos de vale transporte unitário que serão recuperados: 
                        var codigo = +piece[0];
                        var descricao = piece[1];
                        var valorUnitario = piece[2];
                        var uf = piece[3];
                        var ativo = +piece[4];

                        //Mostra apenas dois pontos decimais para o usuário, e com vírgula.
                        valorUnitario = roundDecimal(floatToString(valorUnitario), 2);

                        //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                        $("#codigo").val(codigo);
                        $("#ativo").val(ativo);
                        $("#descricao").val(descricao);
                        $("#valorUnitario").val(valorUnitario);
                        $("#unidadeFederacao").val(uf);
                        $("#verificaRecuperacao").val(1);

                        return;
                    }
                });
            }
        }
        $("#descricao").focus();
    }

    function novo() {
        $(location).attr('href', 'cadastro_valeTransporteUnitarioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_valeTransporteUnitarioFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirValeTransporteUnitario(id, function(data) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
                voltar();
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                voltar();
            }
        });
    }

    function verificaDescricaoExistente() {
        var descricao = $("#descricao").val();
        verificaDescricao(descricao,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    smartAlert("Atenção", "Já existe um Vale Transporte com essa descrição no Sistema!", "error");
                    $("#descricao").focus();
                    return false;
                } else {
                    gravar();
                    return true;
                }
            }

        );
    }

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        //Variáveis que vão ser gravadas no banco: 
        var id = +$("#codigo").val();
        var ativo = +$("#ativo").val();
        var unidadeFederacao = $("#unidadeFederacao").val().trim();
        var descricao = $("#descricao").val().trim().replace(/'/g, " ");
        var valorUnitario = $("#valorUnitario").val();

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!descricao) {
            smartAlert("Atenção", "Informe a Descrição", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!valorUnitario) {
            smartAlert("Atenção", "Informe o Valor Unitário", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!unidadeFederacao) {
            smartAlert("Atenção", "Informe a UF", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        //Chama a função de gravar do business de vale transporte.
        gravaValeTransporteUnitario(id, ativo, unidadeFederacao, descricao, valorUnitario,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                        $("#btnGravar").prop('disabled', false);
                    }
                    return '';
                } else {

                    //Verifica se a função de recuperar os campos foi executada.
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");

                    if (verificaRecuperacao === 1) {
                        voltar();
                    } else {
                        novo();
                    }
                }
            }
        );
    }
</script>