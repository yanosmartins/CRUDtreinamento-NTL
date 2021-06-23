<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
// $condicaoAcessarOK = (in_array('PROGRAMACAOFERIAS_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('PROGRAMACAOFERIAS_GRAVAR', $arrayPermissao, true));
// $condicaoExcluirOK = (in_array('PROGRAMACAOFERIAS_EXCLUIR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }
// $esconderBtnExcluir = "";
// if ($condicaoExcluirOK === false) {
//     $esconderBtnExcluir = "none";
// }
// $esconderBtnGravar = "";
// if ($condicaoGravarOK === false) {
//     $esconderBtnGravar = "none";
// }

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Programação de Férias";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["programacaoFerias"]["active"] = true;
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
            <!-- <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/cadastroProgramacaoFerias.php" style="float:right"></a>
                <?php } ?>
            </div> -->

            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Geral
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formProgramacaoFerias" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden">
                                                        <div class="row ">

                                                            <section class="col col-3">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="required">
                                                                        <option style="display:none;">Selecione</option>
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

                                                            <section class="col col-1">
                                                                <label class="label" for="pedidosSolicitados">Pedidos Solicitados</label>
                                                                <label class="select">
                                                                    <select id="pedidosSolicitados" name="pedidosSolicitados" class="required" required>
                                                                        <option value='0'>1</option>
                                                                        <option value='1'>2</option>
                                                                        <option value='2'>3</option>

                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Dias Impedidos</strong></legend>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Domingo<input type="checkbox" name="checkbox" value="Domingo"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Segunda-Feira<input type="checkbox" name="checkbox" value="Segunda-Feira"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Terça-Feira<input type="checkbox" name="checkbox" value="Terça-Feira"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Quarta-Feira<input type="checkbox" name="checkbox" value="Quarta-Feira"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Quinta-Feira<input type="checkbox" name="checkbox" value="Quinta-Feira"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Sexta-Feira<input type="checkbox" name="checkbox" value="Sexta-Feira"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Sábado<input type="checkbox" name="checkbox" value="Sábado"><i></i></label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Meses Impedidos</strong></legend>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Janeiro<input type="checkbox" name="checkbox" value="Janeiro"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Fevereiro<input type="checkbox" name="checkbox" value="Fevereiro"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Março<input type="checkbox" name="checkbox" value="Março"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Abril<input type="checkbox" name="checkbox" value="Abril"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Maio<input type="checkbox" name="checkbox" value="Maio"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Junho<input type="checkbox" name="checkbox" value="Junho"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Julho<input type="checkbox" name="checkbox" value="Julho"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Agosto<input type="checkbox" name="checkbox" value="Agosto"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Setembro<input type="checkbox" name="checkbox" value="Setembro"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Outubro<input type="checkbox" name="checkbox" value="Outubro"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Novembro<input type="checkbox" name="checkbox" value="Novembro"><i></i></label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="checkbox">Dezembro<input type="checkbox" name="checkbox" value="Dezembro"><i></i></label>
                                                            </section>
                                                        </div>

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
<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroProgramacaoFerias.js" type="text/javascript"></script>
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


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $('#btnNovo').on("click", function() {
            novo();
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });
        $("#btnVoltar").on("click", function() {
            voltar();
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

        carregaProgramacaoFerias();
    });

    function voltar() {
        $(location).attr('href', 'cadastro_programacaoFeriasFiltro.php');
    }

    function novo() {
        $(location).attr('href', 'cadastro_programacaoFeriasCadastro.php');
    }

    function gravar() {
        $("#btnGravar").prop('disabled', true);
        var projeto = $("#projeto").val();
        var id = +$('#codigo').val();
        var ativo = +$('#ativo').val();
        if (!projeto) {
            smartAlert("Erro", "Informe o Projeto.", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        gravaProgramacaoFerias(id, ativo, projeto,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em impedimentos com a GIR !", "error");
                        $("#btnGravar").prop('disabled', false);
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    novo();
                }
            }
        );
    }


    function excluir() {
        debugger;
        var id = +$("#codigo").val();

        if (codigo === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirProgramacaoFerias(id, function(data) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em impedimentos com a GIR!", "error");
                }
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                voltar();
            }
        });
    }

    function carregaProgramacaoFerias() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaProgramacaoFerias(idd,
                    function(data) {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        //Atributos de Cliente
                        var mensagem = piece[0];
                        var out = piece[1];

                        piece = out.split("^");
                        console.table(piece);
                        //Atributos de cliente 
                        var codigo = +piece[0];
                        var descricao = piece[1];
                        var ativo = +piece[2];
                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#descricao").val(descricao);
                        $("#ativo").val(ativo);

                    }
                );
            }
        }
    }
</script>