<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('EXPORTACAO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('EXPORTACAO_GRAVAR', $arrayPermissao, true));
$condicaoAcessarOK = true;
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

$page_title = "Exportação de Candidatos";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['operacao']['sub']['recursoshumanos']['sub']["contratacao"]['sub']["exportacao"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Exportação para o SCI"] = "";
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
                            <h2>Exportação dos Candidatos</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuario" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseExportacao" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseExportacao" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <input id="caminho" name="caminho" type="text" readonly class="hidden" value=""></input>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Nome do Candidato:</label>
                                                                <label class="input">
                                                                    <input id="nome" maxlength="255" name="nome" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" maxlength="255" name="cpf" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Projeto</label>
                                                                <label class="input">
                                                                    <input id="projeto" maxlength="255" name="projeto" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cargo</label>
                                                                <label class="input">
                                                                    <input id="cargo" maxlength="255" name="cargo" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Situação</label>
                                                                <label class="select">
                                                                    <select id="situacao" name="situacao">
                                                                        <option></option>
                                                                        <option value="0" selected>Pendente</option>
                                                                        <option value="1">Exportado</option>
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


                                        <label class="btn btn-primary pull-right hidden" style="text-decoration:none" id="labelDiretorio" title="Baixar arquivo"><a style="text-decoration:none; color:white;" href="img\logoNTL.jpg" id="downloadExportacao" download><strong>Baixar arquivo</strong></a></label>
                                        <!-- Telinha de aviso caso a pessoa queira exportar -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExportacao" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-2" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleExportacao" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <p>Você têm certeza que quer exportar esses candidatos ? </p>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>

                                        <button id="btnExportar" type="button" class="btn btn-success pull-right" title="Exportar para o SCI">
                                            <strong>Gerar arquivo</strong>
                                        </button>

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
        listarFiltro();

        $('#btnSearch').on("click", function() {
            listarFiltro();
        });

        $('#downloadExportacao').on('mouseover mouseout', function() {
            let caminho = $("#caminho").val();
            document.getElementById('downloadExportacao').href = 'logs_exportacao_SCI\\' + caminho;
        });

        //Telinha que abre ao se clicar em Exportação        
        $('#dlgSimpleExportacao').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "Atenção",
            buttons: [{
                html: "Sim",
                "class": "btn btn-success",
                click: function() {
                    executarAjax();
                    $("#labelDiretorio").removeClass("hidden");
                    $(this).dialog("close");
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp;Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });




        $("#btnExportar").on("click", function() {

            let checkboxComIdDosFuncionarios = [];
            // Pega o valor do ID do Funcionário e joga para um array chamado 'checkboxSelecionado'.
            $("input[type='checkbox']").each(function() {
                debugger;
                if ($(this).prop("checked")) { //Se o checkbox tiver sido selecionado. 
                    checkboxComIdDosFuncionarios.push(($(this).attr('value'))); //Ele puxa o valor do código do funcionário pra um array.
                }

            });
            //Aviso na tela caso o array seja vazio ou inexistente.
            if (checkboxComIdDosFuncionarios === undefined || checkboxComIdDosFuncionarios.length == 0) {
                smartAlert("Atenção", "Selecione um funcionário para ser exportado!", "error");
                return;
            }

            $('#dlgSimpleExportacao').dialog('open'); //Abre uma janela de aviso pra conferir os funcionários pra exportação.

        });
    });

    function listarFiltro() {

        let nome = $('#nome').val();
        let cpf = $('#cpf').val();
        let projeto = $('#projeto').val();
        let cargo = $('#cargo').val();
        let situacao = $('#situacao').val();

        $('#resultadoBusca').load('contratacao_exportacaoFiltroListagem.php?', {
            nome: nome,
            cpf: cpf,
            projeto: projeto,
            cargo: cargo,
            situacao: situacao
        });
    }

    function executarAjax() {
        let checkboxComIdDosFuncionarios = [];
        // Pega o valor do ID do Funcionário e joga para um array chamado 'checkboxSelecionado'.
        $("input[type='checkbox']").each(function() {
            if ($(this).prop("checked")) { //Se o checkbox tiver sido selecionado. 
                checkboxComIdDosFuncionarios.push(($(this).attr('value'))); //Ele puxa o valor do código do funcionário pra um array.
            }

        });

        $.ajax({
            url: 'js/sqlscope_contratacaoExportacao.php',
            dataType: 'html', //tipo do retorno
            type: 'post', //metodo de envio
            data: {
                funcao: 'exportar',
                checkboxComIdDosCandidatos: checkboxComIdDosFuncionarios
            },
            success: function(data) {
                let valor = data.split("^");

                if (valor[0] === 'success') {
                    smartAlert("Sucesso", "O arquivo foi gerado com sucesso!", "success");

                    debugger;
                    let enderecoCaminho = valor[1];
                    $("#caminho").val(enderecoCaminho);
                } else {
                    smartAlert("Atenção", "Erro ao gerar o arquivo!", "error");
                }
            },
            error: function(xhr, er) {
                console.log(xhr, er);
            }
        });
    }
</script>