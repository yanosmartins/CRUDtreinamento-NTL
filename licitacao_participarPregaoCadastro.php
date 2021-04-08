<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PARTICIPARPREGAO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PARTICIPARPREGAO_GRAVAR', $arrayPermissao, true));

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

$page_title = "Participar de Pregões";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['licitacao']['sub']['operacao']['sub']["participarPregao"]["active"] = true;

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
                            <h2>Avança - Não Avança</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formGarimparPregoes" method="post">
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
                                                        <div class="row">
                                                            <input id="codigo" name="codigo" type="text" class="hidden">
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-9">
                                                                <label class="label" for="portal">Portal</label>
                                                                <label class="select">
                                                                    <select id="portal" name="portal" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao, endereco FROM Ntl.portal where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            $endereco  = ($row['endereco']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . '&nbsp; - &nbsp;' . $endereco . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Valor Estimado</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input id="valorEstimado" name="valorEstimado" class="decimal-2-casas required text-right" type="text" autocomplete="off" placeholder="0,00">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="grupo">Grupo Responsável pelo Pregão</label>
                                                                <label class="select">
                                                                    <select id="grupo" name="grupo" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.grupo where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="responsavelPregao"> Responsável pelo Pregão</label>
                                                                <label class="select">
                                                                    <select id="responsavelPregao" name="responsavelPregao" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, nome FROM Ntl.responsavel where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $nome = ($row['nome']);
                                                                            echo '<option value=' . $codigo . '>  ' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-9">
                                                                <label class="label">Nome do Orgão Licitante</label>
                                                                <label class="input">
                                                                    <input id="orgaoLicitante" maxlength="255" autocomplete="off" name="orgaoLicitante" class="required" type="select" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label" for="participaPregao">Participar</label>
                                                                <label class="select">
                                                                    <select id="participaPregao" name="participaPregao" class="required">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="2">Não</option>
                                                                        <option value="3">Extra Processo</option>

                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Número do Pregão</label>
                                                                <label class="input">
                                                                    <input id="numeroPregao" maxlength="255" autocomplete="off" name="numeroPregao" class="required" type="select" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data do Pregão</label>
                                                                <label class="input">
                                                                    <input id="dataPregao" name="dataPregao" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Hora do Pregão</label>
                                                                <label class="input">
                                                                    <input id="horaPregao" name="horaPregao" class="required" type="text" autocomplete="new-password" placeholder="hh:mm">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Oportunidade de Compra</label>
                                                                <label class="input">
                                                                    <input id="oportunidadeCompra" autocomplete="off" maxlength="255" name="oportunidadeCompra" class="required" type="select" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Objeto Licitado</label>
                                                                <textarea maxlength="2000" id="objetoLicitado" name="objetoLicitado" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Observação</label>
                                                                <textarea id="observacao" name="observacao" class="form-control" rows="3" style="resize:vertical" autocomplete="off"></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Resumo do Pregão</label>
                                                                <textarea id="resumoPregao" name="resumoPregao" class="form-control" rows="3" maxlength="500" style="resize:vertical;background-color:#FFFFC0;" placeholder=" Digite um resumo do pregão para apresentação na lista.."></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Tarefas Pré-Pregão</strong></legend>
                                                            </section>

                                                        </div>
                                                        <input id="jsonTarefa" name="jsonTarefa" type="hidden" value="[]">
                                                        <div id="formTarefa">
                                                            <div class="row">
                                                                <input id="tarefaId" name="tarefaId" type="hidden" value="">
                                                                <input id="sequencialTarefa" name="sequencialTarefa" type="hidden" value="">
                                                                <input id="dataSolicitacao" name="dataSolicitacao" type="hidden" value="">
                                                                <input id="tipo" name="tipo" type="hidden" value="0">
                                                                <section class="col col-3">
                                                                    <label class="label" for="tarefa">Tarefa</label>
                                                                    <label class="select">
                                                                        <select id="tarefa" name="tarefa">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao  FROM Ntl.tarefa  where ativo = 1  
                                                                            AND (visivel = 3 OR visivel = 2) order by descricao;";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-3">
                                                                    <label class="label">Data Final</label>
                                                                    <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataFinal" name="dataFinal" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="off" onchange="validaCampoData('#dataFinal')">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-3">
                                                                    <label class="label" for="responsavel">Responsável</label>
                                                                    <label class="select">
                                                                        <select id="responsavel" name="responsavel">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, nome  FROM Ntl.responsavel  where ativo = 1 order by nome;";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $nome = ($row['nome']);
                                                                                echo '<option value=' . $codigo . '>  ' . $nome . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-3">
                                                                    <label class="label" for="grupoResponsavel">Grupo responsável</label>
                                                                    <label class="select">
                                                                        <select id="grupoResponsavel" name="grupoResponsavel">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM Ntl.grupo where ativo = 1 AND tipo ='L' order by codigo";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $nome = ($row['descricao']);
                                                                                echo '<option value=' . $codigo . '>  ' . $nome . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>

                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <label class="label">Observação</label>
                                                                    <textarea id="observacaoPrePregao" name="observacaoPrePregao" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnAddTarefa" type="button" class="btn btn-primary" title="Adicionar Tarefa">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverTarefa" type="button" class="btn btn-danger" title="Remover Tarefa">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableTarefa" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Tarefa</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data Final</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Responsável</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Grupo Responsável</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data e Hora da Solicitação</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Anexar Documentos / Documentos
                                                                        Anexados</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <p>
                                                                    <strong style="color: red">
                                                                        Atenção:<br>
                                                                        Apenas os arquivos do tipo abaixo são permitidos. <br>
                                                                        Planilhas:
                                                                        [XLS|XLSX|ODS|CSV]<br>
                                                                        Arquivos de Texto:
                                                                        [DOC|DOCX|PDF|RTF|HTML]<br>
                                                                        Arquivos Compactados:
                                                                        [ZIP|RAR].
                                                                    </strong>
                                                                </p>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Upload de Arquivo</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="uploadArquivo" name="uploadArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="uploadArquivoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="uploadArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                        <div class="row" id="legenda">
                                                            <section class="col col-12">
                                                                <legend><strong></strong></legend>
                                                            </section>

                                                        </div>
                                                        <div class="row" id="logUsuario">
                                                            <section class="col col-3">
                                                                <label class="label">Quem Lançou</label>
                                                                <label class="input">
                                                                    <input id="quemLancou" maxlength="255" name="quemLancou" class="readonly" style="text-align: center" type="select" value="" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="dataLancamento" name="dataLancamento" type="text" data-dateformat="dd/mm/yy" class="readonly " style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataLancamento')" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Hora do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="horaLancamento" name="horaLancamento" class="readonly" type="text" style="text-align: center" autocomplete="new-password" readonly> </label>
                                                            </section>
                                                        </div>

                                                        <div class="row" id="logUsuarioAtualizacao">

                                                            <section class="col col-12">
                                                                <legend><strong>Última Atualização</strong></legend>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Quem Lançou</label>
                                                                <label class="input">
                                                                    <input id="quemLancouAtualizacao" maxlength="255" name="quemLancouAtualizacao" style="text-align: center" class="readonly" type="select" value="" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="dataLancamentoAtualizacao" name="dataLancamentoAtualizacao" type="text" data-dateformat="dd/mm/yy" class="readonly " style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataLancamentoAtualizacao')" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Hora do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="horaLancamentoAtualizacao" name="horaLancamentoAtualizacao" class="readonly" style="text-align: center" type="text" autocomplete="new-password" readonly> </label>
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
                                        <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-floppy-o"></span>
                                        </button>
                                        <!-- <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o"></span>
                                        </button> -->
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


<script src="<?php echo ASSETS_URL; ?>/js/business_licitacaoParticiparPregao.js" type="text/javascript"></script>

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
    jsonTarefaArray = JSON.parse($("#jsonTarefa").val());

    $(document).ready(function() {

        $('#horaAlerta').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaPregao').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaReaberturaPregao').mask('99:99', {
            placeholder: "hh:mm"
        });

        carregaPagina();

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

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#dataPregao").on("change", function() {
            var dataAtual = moment().format("DD/MM/YYYY");
            var dataPregao = $("#dataPregao").val();

            //Transformando em um objeto usando moment -> Data Atual
            dataAtual = dataAtual.split("/");
            dataAtual[1] = dataAtual[1] - 1;
            dataAtual = moment([dataAtual[2], dataAtual[1], dataAtual[0]]);

            //ransformando em um objeto usando moment -> Data Pregão
            dataPregao = dataPregao.split("/");
            dataPregao[1] = dataPregao[1] - 1;
            dataPregao = moment([dataPregao[2], dataPregao[1], dataPregao[0]]);

            var diferenca = dataAtual.diff(dataPregao, 'days');

            if (diferenca > 0) {
                smartAlert("Atenção", "A data do pregão não pode ser maior do que o dia de hoje !", "error");
                $("#dataPregao").val(" ");
                return;
            }

        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        //Botões de Tarefa
        $("#btnAddTarefa").on("click", function() {
            if (validaTarefa())
                addTarefa();
        });

        $("#btnRemoverTarefa").on("click", function() {
            excluirTarefa();
        });


        $("#dataLancamento").on("change", function() {
            validaCampoData("#dataLancamento");
        });
        $("#dataPregao").on("change", function() {
            validaCampoData("#dataPregao");
        });
        $("#dataFinal").on("change", function() {
            validaCampoData("#dataFinal");
        });

        // UPLOADS  
        $("input[name='uploadArquivo[]']").change(function() {

            var files = document.getElementById("uploadArquivo").files;
            var array = [];
            var tamanhoTotal = 0;
            var tamanhoMaximoPorCampo =
                20971520; // Foi configurado para 20MB como total máximo || 20MB = 20971520 bytes. 
            for (var i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;

            }

            var arrayString = array.toString();
            $("#uploadArquivoText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção",
                    "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 20MB",
                    "error");
                $("#uploadArquivoText").val("");
                $("#uploadArquivo").val("");

            }

        });

    });

    function carregaPagina() {

        //Desabilita os campos para aparecerem só na recuperação de pregões.
        document.getElementById("legenda").style.display = "none";
        document.getElementById("logUsuario").style.display = "none";

        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaPregoes(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayTarefa = piece[2];

                            piece = out.split("^");
                            codigo = piece[0];
                            portal = piece[1];
                            ativo = piece[2];
                            orgaoLicitante = piece[3];
                            participaPregao = parseInt(piece[4]);
                            objetoLicitado = piece[5];
                            observacao = piece[6];
                            oportunidadeCompra = piece[7];
                            numeroPregao = piece[8];
                            dataPregao = piece[9];

                            //Arrumando o valor de dataPregao
                            dataPregao = dataPregao.split("-");
                            dataPregao = dataPregao[2] + "/" + dataPregao[1] + "/" + dataPregao[0];

                            horaPregao = piece[10];
                            usuarioCadastro = piece[11];
                            dataCadastro = piece[12];
                            usuarioAlteracao = piece[13];
                            dataAlteracao = piece[14];
                            garimpado = piece[15];
                            resumoPregao = piece[16];
                            grupoResponsavel = piece[17];
                            responsavelPregao = piece[18];
                            valorEstimado = piece[19];


                            //Arrumando o valor de dataLancamento e horaLancamento
                            dataCadastro = dataCadastro.split(" ");
                            dataLancamento = dataCadastro[0].split("-");
                            dataLancamento = dataLancamento[2] + "/" + dataLancamento[1] + "/" + dataLancamento[0];
                            horaLancamento = dataCadastro[1].split(":");
                            horaLancamento = horaLancamento[0] + ":" + horaLancamento[1];

                            //Arrumando o valor de dataLancamento e horaLancamento de Atualização
                            dataLancamentoAtualizacao = "";
                            horaLancamentoAtualizacao = "";
                            if (dataAlteracao != "") {
                                dataAlteracao = dataAlteracao.split(" ");
                                dataLancamentoAtualizacao = dataAlteracao[0].split("-");
                                dataLancamentoAtualizacao = dataLancamentoAtualizacao[2] + "/" + dataLancamentoAtualizacao[1] + "/" + dataLancamentoAtualizacao[0];
                                horaLancamentoAtualizacao = dataAlteracao[1].split(":");
                                horaLancamentoAtualizacao = horaLancamentoAtualizacao[0] + ":" + horaLancamentoAtualizacao[1];
                            }


                            $("#codigo").val(codigo);
                            $("#portal").val(portal);
                            $("#ativo").val(ativo);
                            $("#orgaoLicitante").val(orgaoLicitante);
                            $("#participaPregao").val(participaPregao);
                            $("#objetoLicitado").val(objetoLicitado);
                            $("#oportunidadeCompra").val(oportunidadeCompra);
                            $("#numeroPregao").val(numeroPregao);
                            $("#dataPregao").val(dataPregao);
                            $("#horaPregao").val(horaPregao);
                            $("#quemLancou").val(usuarioCadastro);
                            $("#dataLancamento").val(dataLancamento);
                            $("#horaLancamento").val(horaLancamento);
                            $("#quemLancouAtualizacao").val(usuarioAlteracao);
                            $("#dataLancamentoAtualizacao").val(dataLancamentoAtualizacao);
                            $("#horaLancamentoAtualizacao").val(horaLancamentoAtualizacao);
                            $("#observacao").val(observacao);
                            $("#resumoPregao").val(resumoPregao);
                            $("#grupo").val(grupoResponsavel);
                            $("#responsavelPregao").val(responsavelPregao);
                            $("#jsonTarefa").val(strArrayTarefa);
                            $("#valorEstimado").val(valorEstimado);
                            jsonTarefaArray = JSON.parse($("#jsonTarefa").val());
                            fillTableTarefa();

                            document.getElementById("legenda").style.display = "";
                            document.getElementById("logUsuario").style.display = "";
                            if (usuarioAlteracao != "" && dataAlteracao != "") {
                                document.getElementById("logUsuarioAtualizacao").style.display = "";
                            }


                        }
                    }
                );
                recuperaUpload(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var arrayDocumentos = JSON.parse(piece[1]);
                            for (let index = 0; index < arrayDocumentos.length; index++) {
                                let nomeArquivo = arrayDocumentos[index].nomeArquivo;
                                let nomeVisualizacao = nomeArquivo.split("_");
                                let tipoArquivo = arrayDocumentos[index].tipoArquivo;
                                let endereco = arrayDocumentos[index].endereco;
                                let nomeCampo = arrayDocumentos[index].idCampo + "." + tipoArquivo;
                                let idCampo = arrayDocumentos[index].idCampo + "Link";
                                let diretorio = "<?php echo $linkUpload ?>" + endereco + nomeArquivo;

                                $("#" + idCampo).append("<a href ='ChamadoNtl/" + diretorio + "' target='_blank'>" +
                                    nomeVisualizacao[1] + "</a><br>");

                            }

                        }
                    });
            }
        }
    }

    function voltar() {
        $(location).attr('href', 'licitacao_participarPregaoFiltro.php');
    }

    function excluir() {
        var codigo = +$("#codigo").val();

        if (codigo === 0) {
            smartAlert("Atenção", "Selecione um pregão para excluir!", "error");
            return;
        }

        excluirPregoes(codigo);
    }

    //############################################################################## LISTA TAREFA INICIO ####################################################################################################################

    function fillTableTarefa() {
        $("#tableTarefa tbody").empty();
        for (var i = 0; i < jsonTarefaArray.length; i++) {
            var row = $('<tr />');
            $("#tableTarefa tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTarefaArray[i]
                .sequencialTarefa + '"><i></i></label></td>'));

            var tarefa = $("#tarefa option[value = '" + jsonTarefaArray[i].tarefa + "']").text();
            var responsavel = $("#responsavel option[value = '" + jsonTarefaArray[i].responsavel + "']").text();
            var grupoResponsavel = $("#grupoResponsavel option[value = '" + jsonTarefaArray[i].grupoResponsavel + "']").text();

            row.append($('<td class="text-nowrap" onclick="carregaTarefa(' + jsonTarefaArray[i].sequencialTarefa + ');">' +
                tarefa + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTarefaArray[i].dataFinal + '</td>'));
            row.append($('<td class="text-nowrap">' + responsavel + '</td>'));
            row.append($('<td class="text-nowrap">' + grupoResponsavel + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTarefaArray[i].dataSolicitacao + '</td>'));
        }
    }

    function validaTarefa() {

        //Cria-se uma variável para pegar o momento em que um registro foi criado na lista.
        var dataSolicitacao = moment().format("DD/MM/YYYY HH:mm");
        $("#dataSolicitacao").val(dataSolicitacao);

        var dataFinal = $('#dataFinal').val();

        if (dataFinal === '') {
            smartAlert("Erro", "Informe a Data Final!", "error");
            return false;
        }

        return true;
    }

    function addTarefa() {

        var item = $("#formTarefa").toObject({
            mode: 'combine',
            skipEmpty: false
        });

        if (item["sequencialTarefa"] === '') {
            if (jsonTarefaArray.length === 0) {
                item["sequencialTarefa"] = 1;
            } else {
                item["sequencialTarefa"] = Math.max.apply(Math, jsonTarefaArray.map(function(o) {
                    return o.sequencialTarefa;
                })) + 1;
            }
            item["tarefaId"] = 0;
        } else {
            item["sequencialTarefa"] = +item["sequencialTarefa"];
        }

        var index = -1;
        $.each(jsonTarefaArray, function(i, obj) {
            if (+$('#sequencialTarefa').val() === obj.sequencialTarefa) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTarefaArray.splice(index, 1, item);
        else
            jsonTarefaArray.push(item);

        $("#jsonTarefa").val(JSON.stringify(jsonTarefaArray));
        fillTableTarefa();
        clearFormTarefa();

    }

    function processDataTarefa(node) {
        // var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        // var fieldName = node.getAttribute ? node.getAttribute('name') : '';



        // if (fieldName !== '' && (fieldId === "dataNascimentoFilho")) {

        //     var dataNascimentoFilho = $('#dataNascimentoFilho').val();
        //     dataNascimentoFilho = dataNascimentoFilho.split("/");
        //     dataNascimentoFilho = dataNascimentoFilho[2] + "/" + dataNascimentoFilho[1] + "/" + dataNascimentoFilho[0];

        //     return {
        //         name: fieldName,
        //         value: dataNascimentoFilho
        //     };
        // }

        // return false;
    }

    function clearFormTarefa() {
        $("#tarefa").val('');
        $("#dataFinal").val('');
        $("#responsavel").val('');
        $("#grupoResponsavel").val('');
        $("#observacaoPrePregao").val('');
        $("#sequencialTarefa").val('');
    }

    function carregaTarefa(sequencialTarefa) {
        var arr = jQuery.grep(jsonTarefaArray, function(item, i) {
            return (item.sequencialTarefa === sequencialTarefa);
        });

        clearFormTarefa();

        if (arr.length > 0) {
            var item = arr[0];
            $("#tarefa").val(item.tarefa);
            $("#dataFinal").val(item.dataFinal);
            $("#responsavel").val(item.responsavel);
            $("#grupoResponsavel").val(item.grupoResponsavel);
            $("#observacaoPrePregao").val(item.observacaoPrePregao);
            $("#tarefaId").val(item.tarefaId);
            $("#sequencialTarefa").val(item.sequencialTarefa);
        }
    }

    function excluirTarefa() {
        var arrSequencial = [];
        $('#tableTarefa input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTarefaArray.length - 1; i >= 0; i--) {
                var obj = jsonTarefaArray[i];
                if (jQuery.inArray(obj.sequencialTarefa, arrSequencial) > -1) {
                    jsonTarefaArray.splice(i, 1);
                }
            }
            $("#jsonTarefa").val(JSON.stringify(jsonTarefaArray));
            fillTableTarefa();
        } else
            smartAlert("Erro", "Selecione pelo menos uma informação para excluir.", "error");
    }

    //############################################################################## LISTA Filho FIM #######################################################################################################################


    function validaCampoData(campo) {
        var valor = $(campo).val();
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js
        if (validacao === false) {
            $(campo).val("");
        }
    }

    function validaData(valor) {

        if ((valor == undefined) || (valor == " ")) {
            return;
        }

        var date = valor;
        var ardt = new Array;
        var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
        ardt = date.split("/");
        erro = false;
        if (date.search(ExpReg) == -1) {
            erro = true;
        } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30))
            erro = true;
        else if (ardt[1] == 2) {
            if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                erro = true;
            if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                erro = true;
        }
        if (erro) {
            smartAlert("Erro", "O valor inserido é inválido.", "error");
            return false;
        }
        return true;
    }

    function gravar() {
        var portal = $("#portal").val();
        var orgaoLicitante = $("#orgaoLicitante").val();
        var participaPregao = $("#participaPregao option:selected").val();
        var numeroPregao = $("#numeroPregao").val();
        var dataPregao = $("#dataPregao").val();
        var horaPregao = $("#horaPregao").val();
        var oportunidadeCompra = $("#oportunidadeCompra").val();
        var resumoPregao = $("#resumoPregao").val();


        if (portal === "") {
            smartAlert("Atenção", "Selecione um portal !", "error");
            $("#portal").focus();
            return;
        }

        if (orgaoLicitante === "") {
            smartAlert("Atenção", "Digite o Nome do Orgão Licitante !", "error");
            $("#orgaoLicitante").focus();
            return;
        }

        if (participaPregao === "") {
            smartAlert("Atenção", "Escolha uma opção do Participar !", "error");
            $("#participaPregao").focus();
            return;
        }

        if (numeroPregao === "") {
            smartAlert("Atenção", "Digite o Número do Pregão !", "error");
            $("#numeroPregao").focus();
            return;
        }

        if (dataPregao === "") {
            smartAlert("Atenção", "Digite a Data do Pregão !", "error");
            $("#dataPregao").focus();
            return;
        }

        if (horaPregao === "") {
            smartAlert("Atenção", "Digite a Hora do Pregão !", "error");
            $("#horaPregao").focus();
            return;
        }

        if (oportunidadeCompra === "") {
            smartAlert("Atenção", "Digite a Oportunidade de Compra !", "error");
            $("#oportunidadeCompra").focus();
            return;
        }

        if (resumoPregao === "") {
            smartAlert("Atenção", "Escreva um resumo para o pregão !", "error");
            $("#resumoPregao").focus();
            return;
        }

        var form = $('#formGarimparPregoes')[0];
        var formData = new FormData(form);
        gravaPregoes(formData);
    }
</script>