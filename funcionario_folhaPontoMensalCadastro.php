<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$funcionario = $_SESSION["funcionario"];


$condicaoModeradaAcessarOK = (in_array('PONTOELETRONICOMENSALMODERADO_ACESSAR', $arrayPermissao, true));

$condicaoMinimaAcessarOK = (in_array('PONTOELETRONICOMENSALMINIMO_ACESSAR', $arrayPermissao, true));

if (($condicaoModeradaAcessarOK == false) && ($condicaoMinimaAcessarOK == false)) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Controle de Ponto";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$page_css[] = "ponto_mensal.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['funcionario']['sub']["controlePonto"]["active"] = true;
include("inc/nav.php");
?>

<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Área do Funcionário"] = "";
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
                            <h2>Controle de Ponto
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formFolhaPontoMensalCadastro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFolhaPontoMensal" class="collapsed" id="accordionFolhaPontoMensal">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Ponto Mensal
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFolhaPontoMensal" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>


                                                        <div id="formFolhaPontoMensal" class="col-sm-12">
                                                            <input id="codigo" name="codigo" type="hidden" value="0">
                                                            <input id="funcionario" name="funcionario" type="hidden" value="<?= $funcionario ?>">



                                                            <div class="row">
                                                                <section class="col col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                                    <label class="label">Mês/Ano</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="mesAno" name="mesAno" autocomplete="off" data-mask="99/9999" class="text-center">
                                                                        <!--Removido de acordo com a reunião do dia 14.06.2021 as 14h-->
                                                                        <!-- data-mask-placeholder="MM/AAAA" data-dateformat="mm/yy" placeholder="MM/AAAA" type="text" class="datepicker text-center" value="<?= date("m/Y") ?>">
 -->
                                                                </section>
                                                                <section id="sectionStatus" class="col col-2" style="display:none">
                                                                    <label class="label" for="status">Status</label>
                                                                    <label class="select">
                                                                        <select id="status" name="status" class="readonly" readonly style="pointer-events: none; touch-action: none">
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT S.codigo,S.descricao FROM Ntl.status S  WHERE S.ativo = 1 ORDER BY S.codigo";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                $pattern = "/^aberto$/i";
                                                                                if (preg_match($pattern, $descricao)) {
                                                                                    echo '<option value="' . $codigo . '" selected>' . $descricao . '</option>';
                                                                                } else {
                                                                                    echo '<option value="' . $codigo . '">' . $descricao . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-md-2">
                                                                    <label class="label"> </label>
                                                                    <button type="button" id="btnPdf" class="btn btn-danger" aria-hidden="true">
                                                                        <i class="">Imprimir Folha</i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label" for="expediente">Expediente</label>
                                                                    <label class="select">
                                                                        <select id="expediente" name="expediente" class="readonly" readonly style="pointer-events: none; touch-action: none">
                                                                            <option></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, funcionario,horaEntrada,horaSaida FROM Ntl.beneficioProjeto WHERE ativo = 1 ORDER BY codigo";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $horaEntrada = $row['horaEntrada'];
                                                                                $horaSaida = $row['horaSaida'];
                                                                                if ($row['funcionario'] == $funcionario) {
                                                                                    echo '<option value="' . $codigo . '" selected>' . $horaEntrada . " - " . $horaSaida . '</option>';
                                                                                } else {
                                                                                    echo '<option value="' . $codigo . '">' . $horaEntrada . " - " . $horaSaida . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="almoco">Almoço</label>
                                                                    <label class="select">
                                                                        <select id="almoco" name="almoco" class="readonly" readonly style="pointer-events: none; touch-action: none">
                                                                            <option></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, funcionario,horaInicio,horaFim FROM Ntl.beneficioProjeto WHERE ativo = 1 ORDER BY codigo";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $horaInicio = $row['horaInicio'];
                                                                                if (is_null($horaInicio)) {
                                                                                    $horaFim = "00:00";
                                                                                }
                                                                                $horaFim = $row['horaFim'];
                                                                                if (is_null($horaFim)) {
                                                                                    $horaFim = "00:00";
                                                                                }
                                                                                if ($row['funcionario'] == $funcionario) {
                                                                                    echo '<option value="' . $codigo . '" selected>' . $horaInicio . " - " . $horaFim . '</option>';
                                                                                } else {
                                                                                    echo '<option value="' . $codigo . '">' . $horaInicio . " - " . $horaFim . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-1">
                                                                    <label class="label">Dia</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="inputDia" name="inputDia" type="text" class="text-center form-control readonly datepicker" readonly data-autoclose="true" maxlength="2" data-dateformat="d">
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label id="labelHora" class="label">Entrada</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="inputHoraEntrada" name="inputHoraEntrada" type="text" class="text-center form-control readonly" placeholder="  00:00:00" data-autoclose="true" data-mask="99:99:99" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <label class="label">Inicio/Almoço</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="inputInicioAlmoco" name="inputInicioAlmoco" type="text" class="text-center form-control 
                                                                            readonly" placeholder="00:00" data-autoclose="true" data-mask="99:99" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <label class="label">Fim/Almoço</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="inputFimAlmoco" name="inputFimAlmoco" type="text" class="text-center form-control 
                                                                            readonly" placeholder="00:00" data-autoclose="true" data-mask="99:99" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label id="labelHora" class="label">Saída</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="inputHoraSaida" name="inputHoraSaida" type="text" class="text-center form-control 
                                                                            readonly" placeholder="  00:00:00" data-autoclose="true" data-mask="99:99:99" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <label id="labelHora" class="label">H.Extra</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="inputHoraExtra" name="inputHoraExtra" type="text" class="text-center form-control readonly" placeholder="00:00" readonly data-autoclose="true" data-mask="99:99">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <label id="labelHora" class="label">Atraso</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="inputAtraso" name="inputAtraso" type="text" class="text-center form-control readonly" placeholder="00:00" readonly data-autoclose="true" data-mask="99:99">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="lancamento">Lançamento/Ocorrência</label>
                                                                    <label class="select">
                                                                        <select id="inputLancamento" name="inputLancamento" style="touch-action:none;pointer-events:none" readonly class="readonly">
                                                                            <option selected value="0"></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $projeto = $_SESSION['projeto'];
                                                                            $sql = "SELECT L.codigo, L.descricao FROM Ntl.lancamento L 
                                                                            LEFT JOIN 
                                                                            Ntl.lancamentoProjeto LP 
                                                                            ON L.codigo = LP.lancamento
                                                                            LEFT JOIN 
                                                                            Ntl.projeto P 
                                                                            ON P.codigo = LP.projeto
                                                                            where L.ativo = 1 AND (P.codigo = " . $projeto . " OR P.codigo IS NULL) order by L.descricao";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">

                                                                <section class="col col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <button id="btnAddPonto" type="button" class="btn btn-primary btn-xs-left btn-sm-right btn-md-right btn-lg-right " disabled>
                                                                        <i class="">Adicionar Ponto</i>
                                                                    </button>
                                                                </section>

                                                                <section class="col col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <button id="btnGravar" type="button" class="btn btn-success btn-xs-left btn-sm-left btn-md-left btn-lg-left" disabled>
                                                                        <i class="">Salvar alterações</i>
                                                                    </button>
                                                                </section>


                                                            </div>

                                                            <hr><br>

                                                            <div id="pointFieldGenerator"></div>

                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <label class="label">Observações</label>
                                                                    <textarea maxlength="500" id="observacaoFolhaPontoMensal" name="observacaoFolhaPontoMensal" class="form-control" rows="3" value="" style="resize:vertical"></textarea>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- ############################################################# -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseUploadFolha" class="collapsed" id="accordionUploadFolha">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Uploads
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseUploadFolha" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="jsonUploadFolha" name="jsonUploadFolha" type="hidden" value="[]">
                                                        <div id="formUploadFolha" class="col col-sm-12">
                                                            <input id="uploadFolhaId" name="uploadFolhaId" type="hidden" value="">
                                                            <input id="sequencialUploadFolha" name="sequencialUploadFolha" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label">Arquivo</label>
                                                                        <div class="form-control input">
                                                                            <input type="file" name="fileUploadFolha" id="fileUploadFolha" accept="application/pdf">
                                                                        </div>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label" for="uploadType">Tipo de arquivo</label>
                                                                        <label class="input">
                                                                            <input id="uploadType" name="uploadType" autocomplete="new-password" list="type" type="text">
                                                                            <datalist id="type">
                                                                                <option value="Folha de ponto">
                                                                                <option value="Atestado médico">
                                                                                <option value="Comprovante TRE">
                                                                                <option value="Audiência na justiça">
                                                                            </datalist>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label" for="dataReferenteUpload">Data referente</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="dataReferenteUpload" name="dataReferenteUpload" autocomplete="new-password" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker " value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                        </label>
                                                                    </section>
                                                                    <input type="text" name="dataUpload" id="dataUpload" hidden class="hidden">
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddUploadFolha" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverUploadFolha" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableUploadFolha" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 100%;">Arquivo</th>
                                                                            <th class="text-left">Tipo de arquivo</th>
                                                                            <th class="text-left">Mês referente</th>
                                                                            <th class="text-left">Data de upload</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <button id="enviarUploads" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-file-pdf-o" style="font-size:2rem"></i><i style="padding-left: 5px;">Enviar PDF</i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                </div>

                                            </div>
                                        </div>
                                        <footer>
                                            <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimplePoint" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                                <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                    <span id="ui-id-1" class="ui-dialog-title">
                                                    </span>
                                                </div>
                                                <div id="dlgSimplePoint" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                    <p>O dia selecionado é um final de semana.</p>
                                                </div>
                                                <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                    <div class="ui-dialog-buttonset">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- --------------------------------------------- -->
                                            <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleClose" aria-labelledby="ui-id-2" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                                <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                    <span id="ui-id-2" class="ui-dialog-title">
                                                    </span>
                                                </div>
                                                <div id="dlgSimpleClose" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                    <p>Após o fechamento da folha não será possível realizar alterações. Deseja confirmar o fechamento da folha?</p>
                                                </div>
                                                <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                    <div class="ui-dialog-buttonset">
                                                    </div>
                                                </div>
                                            </div>


                                            <button type="button" id="btnFechar" class="btn btn-danger" aria-hidden="true" title="Fechar">
                                                <i class="">Fechar folha</i>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_beneficioFolhaPontoMensal.js" type="text/javascript"></script>
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/momentjs-business.js"></script>

<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script src="js/plugin/clockpicker/clockpicker.min.js"></script>

<script language="JavaScript" type="text/javascript">
    /*---------------Variaveis e constantes globais-------------*/

    var toleranciaExtra = '05:00';
    var toleranciaAtraso = '05:00';

    var jsonUploadFolhaArray = JSON.parse($("#jsonUploadFolha").val());

    var initialDate = $('#mesAno').val().split("/").reverse().join("-").concat("-01")
    const maxMonth = new Date().getMonth() + 1
    var minMonth = maxMonth - 1
    minMonth == 0 ? 12 : minMonth
    /*---------------/Variaveis e constantes globais-------------*/

    $(document).ready(function() {

        // Removido de acordo com a reunião do dia 14 as 14h devido ao datepicker não mostrar APENAS mes/Ano
        // $('#mesAno').datepicker();
        // $('#mesAno').on('focus', function(e) {
        //     e.preventDefault();
        //     $(this).datepicker('show');
        //     $(this).datepicker('widget').css('z-index', 1051);
        // });

        // $('#mesAno').datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     showButtonPanel: true,
        //     dateFormat: 'mm/yyyy',
        //     onClose: function(dateText, inst) {
        //         var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        //         $(this).datepicker('setDate', new Date(year, month, 1));
        //     }
        // });
        // Removido de acordo com a reunião do dia 14 as 14h devido ao datepicker não mostrar APENAS mes/Ano

        $('#inputDia').datepicker();
        $('#inputDia').on('focus', function(e) {
            e.preventDefault();
            $(this).datepicker('show');
            $(this).datepicker('widget').css('z-index', 1051);
        });

        $('#inputDia').datepicker({
            changeMonth: false,
            changeYear: false,
            showButtonPanel: false,
            dateFormat: 'dd',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });

        //========================================================

        /* Evento para recarregar a folha de ponto() */
        $("#mesAno").on("change", function() {
            let mesAno = $('#mesAno').val()


            const month = parseInt(mesAno.split("/")[0])

            if (month < minMonth) {
                if (minMonth.toString.length < 2) $('#mesAno').val(mesAno.replace(/^\d{2}/, "0" + minMonth))
                else $('#mesAno').val(mesAno.replace(/^\d{2}/, minMonth))
            }
            if (month > maxMonth) {
                if (maxMonth.toString.length < 2) $('#mesAno').val(mesAno.replace(/^\d{2}/, "0" + maxMonth))
                else $('#mesAno').val(mesAno.replace(/^\d{2}/, maxMonth))
            }

            const newValue = $('#mesAno').val().split("/").reverse().join("-").concat("-01")
            initialDate = newValue
            carregaFolhaPontoMensal();
        });

        /* Evento para validar a entrada do dia */
        $('#inputDia').on('keydown', () => {
            const pattern = /(\d|\t)/g

            let value = $('#inputDia').val();

            value = value.replace(/\D/gi, "");

            return $('#inputDia').val(value);
        });

        /* Evento para trazer os dados dos respectivos dias */
        $('#inputDia').on('change', function() {
            let dia = $("#inputDia").val();
            dia = dia.replace(/\D/gi, "");
            if (!dia) dia = 1;


            let index = dia - 1;

            let entrada = $("#pointFieldGenerator input[name=horaEntrada]");
            entrada = entrada[index].value;

            try {
                let saida = $("#pointFieldGenerator [name=horaSaida]");
                saida = saida[index].value;

                let extra = $("#pointFieldGenerator [name=extra]");
                extra = extra[index].value;

                let atraso = $("#pointFieldGenerator [name=atraso]");
                atraso = atraso[index].value;

                let lancamento = $("#pointFieldGenerator [name=lancamento]");
                lancamento = lancamento[index].value;

                $("#inputHoraEntrada").val(entrada);
                $("#inputHoraSaida").val(saida);

                $("#inputHoraExtra").val(extra);
                $("#inputAtraso").val(atraso);

                $("#inputLancamento").val(lancamento);

                let isWeekend = checkDay(dia);

                if (isWeekend) {
                    $("#inputInicioAlmoco").val("00:00");
                    $("#inputFimAlmoco").val("00:00");
                } else {
                    const almoco = $("#almoco option:selected")

                    let textoAlmoco = almoco.text().trim();
                    textoAlmoco = textoAlmoco.split("-");
                    textoAlmoco[0] = textoAlmoco[0].trim();
                    textoAlmoco[1] = textoAlmoco[1].trim();

                    $("#inputInicioAlmoco").val(textoAlmoco[0]);
                    $("#inputFimAlmoco").val(textoAlmoco[1]);
                }

            } catch (e) {
                return smartAlert('Atenção', 'Insira um dia válido!', 'error')
            }
        });

        /* Modal para a confirmação de finais de semana */
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#dlgSimplePoint').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimplePoint').css('display', 'none');
                    addPoint();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    return;
                }
            }]
        });

        $('#dlgSimpleClose').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimpleClose').css('display', 'none');
                    fechar();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    return;
                }
            }]
        });

        /* Evento para chamar a addPoint ou o Modal */
        $("#btnAddPonto").on("click", function() {

            let dia = $("#inputDia").val();

            if (!dia) {
                smartAlert('Atenção', 'Insira um dia para a inserção das horas', 'error')
                return;
            }

            let isWeekend = checkDay(dia);

            if (isWeekend) {
                $('#dlgSimplePoint').dialog('open');
            } else {
                addPoint();
            }
            return;
        });

        /* Evento para chamar a imprimir() */
        $('#btnPdf').on("click", function() {
            imprimir();
        })

        /* Evento para enviar folha assinada */
        $('#enviarUploads').on("click", function() {
            enviarPDF();
        })

        /* Eventos para chamar a gravar() */
        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#btnFechar").on("click", function() {
            $('#dlgSimpleClose').dialog('open');
        });

        /* Evento para chamar a addUploadFolha */
        $("#btnAddUploadFolha").on("click", function() {
            if (validaUploadFolha())
                addUploadFolha();
        });

        /*Evento para chamar a excluirUploadFolha() */
        $("#btnRemoverUploadFolha").on("click", function() {
            excluirUploadFolha();
        });

        $("#dataReferenteUpload").on("change", function() {
            let dataReferente = $("#dataReferenteUpload").val();
            dataReferente = dataReferente.replace(/^\d{2}/, '01')
            $("#dataReferenteUpload").val(dataReferente);
            return
        });

        /*Função responsavel pelo carregamento dos dados pessoais e configurações da tela*/
        carregaFolhaPontoMensal();
        recuperaUpload();

    });

    /* Função reponsável por passar os dados para o back-end para a gravação ou reescrita da folha */
    function gravar() {

        $("#btnGravar").prop('disabled', true);

        var arrayFolha = $("#pointFieldGenerator input[name='dia']").serializeArray()

        var arrayDia = arrayFolha.map(folha => {
            return {
                dia: Number(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='horaEntrada']").serializeArray()
        var arrayHoraEntrada = arrayFolha.map(folha => {
            return {
                horaEntrada: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='inicioAlmoco']").serializeArray()
        var arrayInicioAlmoco = arrayFolha.map(folha => {
            return {
                inicioAlmoco: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='fimAlmoco']").serializeArray()
        var arrayFimAlmoco = arrayFolha.map(folha => {
            return {
                fimAlmoco: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='horaSaida']").serializeArray()
        var arrayHoraSaida = arrayFolha.map(folha => {
            return {
                horaSaida: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='extra']").serializeArray()
        var arrayHoraExtra = arrayFolha.map(folha => {
            return {
                horaExtra: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='atraso']").serializeArray()
        var arrayAtraso = arrayFolha.map(folha => {
            return {
                atraso: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator select[name='lancamento']");
        var arrayLancamento = new Array();
        arrayFolha.each((index, el) => {
            if ($(el).val() == null)
                $(el).val(0);
            let value = Number($(el).val());
            arrayLancamento.push({
                lancamento: Number(value)
            })

        })

        var codigo = Number($("#codigo").val())
        var ativo = Number($("#ativo").val())
        var funcionario = Number($("#funcionario").val());
        var status = Number($('#status').val());

        var mesAno = initialDate
        var observacaoFolhaPontoMensal = String($("#observacaoFolhaPontoMensal").val());

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        var folhaPontoMensalTabela = arrayDia.map((array, index) => {
            return {
                dia: array.dia,
                horaEntrada: arrayHoraEntrada[index].horaEntrada,
                horaSaida: arrayHoraSaida[index].horaSaida,
                inicioAlmoco: arrayInicioAlmoco[index].inicioAlmoco,
                fimAlmoco: arrayFimAlmoco[index].fimAlmoco,
                horaExtra: arrayHoraExtra[index].horaExtra,
                atraso: arrayAtraso[index].atraso,
                lancamento: arrayLancamento[index].lancamento
            }

        })

        var folhaPontoInfo = {
            codigo: Number(codigo),
            ativo: Number(ativo),
            funcionario: Number(funcionario),
            mesAno: String(mesAno),
            status: Number(status),
            observacao: String(observacaoFolhaPontoMensal)
        }

        gravaFolhaPontoMensal(folhaPontoInfo, folhaPontoMensalTabela,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                        $("#btnGravar").prop('disabled', false);
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    $("#btnGravar").prop('disabled', false);
                }
            }
        );
    }

    function fechar() {

        $("#btnGravar").prop('disabled', true);
        $("#btnFechar").prop('disabled', true);

        let arrayFolha = $("#pointFieldGenerator input[name='dia']").serializeArray()

        let arrayDia = arrayFolha.map(folha => {
            return {
                dia: Number(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='horaEntrada']").serializeArray()
        let arrayHoraEntrada = arrayFolha.map(folha => {
            return {
                horaEntrada: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='inicioAlmoco']").serializeArray()
        let arrayInicioAlmoco = arrayFolha.map(folha => {
            return {
                inicioAlmoco: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='fimAlmoco']").serializeArray()
        let arrayFimAlmoco = arrayFolha.map(folha => {
            return {
                fimAlmoco: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='horaSaida']").serializeArray()
        let arrayHoraSaida = arrayFolha.map(folha => {
            return {
                horaSaida: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='extra']").serializeArray()
        let arrayHoraExtra = arrayFolha.map(folha => {
            return {
                horaExtra: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator input[name='atraso']").serializeArray()
        let arrayAtraso = arrayFolha.map(folha => {
            return {
                atraso: String(folha.value)
            }
        })

        arrayFolha = $("#pointFieldGenerator select[name='lancamento']");
        let arrayLancamento = new Array();
        arrayFolha.each((index, el) => {
            if ($(el).val() == null)
                $(el).val(0);
            let value = Number($(el).val());
            arrayLancamento.push({
                lancamento: Number(value)
            })

        })

        let codigo = Number($("#codigo").val())
        let ativo = Number($("#ativo").val())
        let funcionario = Number($("#funcionario").val());
        let options = $("#status option");
        let status;

        options.each((index, el) => {
            const pattern = /^fechad(o|a)$/gi;
            const texto = $(el).text();
            if (pattern.test(texto)) {
                status = $(el).val();
                return;
            }
        });

        let mesAno = initialDate;
        let observacaoFolhaPontoMensal = String($("#observacaoFolhaPontoMensal").val());

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        let folhaPontoMensalTabela = arrayDia.map((array, index) => {
            return {
                dia: array.dia,
                horaEntrada: arrayHoraEntrada[index].horaEntrada,
                horaSaida: arrayHoraSaida[index].horaSaida,
                inicioAlmoco: arrayInicioAlmoco[index].inicioAlmoco,
                fimAlmoco: arrayFimAlmoco[index].fimAlmoco,
                horaExtra: arrayHoraExtra[index].horaExtra,
                atraso: arrayAtraso[index].atraso,
                lancamento: arrayLancamento[index].lancamento
            }

        })

        let folhaPontoInfo = {
            codigo: Number(codigo),
            ativo: Number(ativo),
            funcionario: Number(funcionario),
            mesAno: String(mesAno),
            status: Number(status),
            observacao: String(observacaoFolhaPontoMensal)
        }

        gravaFolhaPontoMensal(folhaPontoInfo, folhaPontoMensalTabela,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnFechar").prop('disabled', false);
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                        $("#btnFechar").prop('disabled', false);
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    const funcionario = $("#funcionario").val();
                    const mesAno = initialDate;
                    $(location).attr('href', 'funcionario_folhaPontoMensalCadastro.php?funcionario=' + funcionario + '&mesAno=' + mesAno);
                }
            }
        );
    }

    /*Função reponsável por trazer os dados pessoais e configurações da folha*/
    function carregaFolhaPontoMensal() {

        /*Pega a query da URL e separa seus devidos valores*/
        const funcionario = $("#funcionario").val()

        const mesAno = initialDate

        recuperaFolhaPontoMensal(funcionario, mesAno,
            function(data) {

                data = data.replace(/failed/gi, '');
                let piece = data.split("#");


                let mensagem = piece[0];
                let out = piece[1];
                let JsonFolha = piece[2];
                piece = out.split("^");

                let statusText;
                let status = $("#status option");
                status.each((index, el) => {
                    let texto = $(el).text();
                    let pattern = /abert(o|a)/gi;
                    if (pattern.test(texto)) {
                        statusText = $(el).val();
                    }
                });

                //funcionando
                let codigo = piece[0] || 0;
                let observacao = piece[1] || "";
                toleranciaAtraso = piece[2] || '05:00';
                toleranciaExtra = piece[3] || '05:00';
                status = piece[4] || statusText;

                $("#codigo").val(codigo);
                $("#observacaoFolhaPontoMensal").val(observacao);
                $("#status").val(status);

                //funcionando
                const almoco = $("#almoco option:selected")

                let textoAlmoco = almoco.text().trim();
                textoAlmoco = textoAlmoco.split("-");
                textoAlmoco[0] = textoAlmoco[0].trim();
                textoAlmoco[1] = textoAlmoco[1].trim();

                $("#inputInicioAlmoco").val(textoAlmoco[0]);
                $("#inputFimAlmoco").val(textoAlmoco[1]);

                const row = $("#pointFieldGenerator .row")
                if (row.length > 0) {
                    deleteElements("#pointFieldGenerator .row")
                }

                const hr = $("#pointFieldGenerator hr")
                if (hr.length > 0) {
                    deleteElements("#pointFieldGenerator hr")
                }

                const totalDiasMes = diasMes(initialDate);
                for (let i = 0; i < totalDiasMes; i++) {
                    generateElements('div', '#pointFieldGenerator', '', {
                        class: "row"
                    });

                    $("#pointFieldGenerator").append('<hr/>');
                };


                for (let i = 0; i < 8; i++) {
                    const classList = ['col', 'col-2'];
                    if (/(^0$|^2$|^3$|^5$|^6$)/.test(i)) {
                        classList.pop();
                        classList.push('col-1');
                    }
                    generateElements('section', '#pointFieldGenerator .row', '', {
                        class: classList.join(" ")
                    });
                }


                generateElements('div', '#pointFieldGenerator .row .col', '', {
                    class: 'form-group'
                });
                generateElements('label', '#pointFieldGenerator .row .col .form-group', '--', {
                    label: 'label'
                });
                generateElements('div', '#pointFieldGenerator .row .col .form-group', '', {
                    class: 'input-group'
                });
                generateElements('input', '#pointFieldGenerator .row .col .form-group .input-group', '', {
                    class: 'text-center form-control readonly',
                    readonly: true
                })

                let lancamento = $("#pointFieldGenerator .row .col .form-group .input-group input")
                let length = lancamento.length

                for (let j = 7; j < length; j += 8) {

                    const parent = lancamento[j].parentElement
                    const select = $('<select/>', {
                        class: 'text-center form-control readonly',
                        readonly: true,
                        style: 'pointer-events:none;touch-action:none;',
                        name: 'lancamento'
                    })
                    const options = $('#inputLancamento').children('option').clone(true);
                    select.append(options);

                    $(parent).append(select)
                    lancamento[j].remove()
                }

                let label = $("#pointFieldGenerator .row .col .form-group label")
                let input = $("#pointFieldGenerator .row .col .form-group .input-group input")

                length = label.length

                for (let j = 0; j < length; j += 8) {
                    $(label[j]).text("Dia")
                }


                for (let j = 1; j < length; j += 8) {
                    $(label[j]).text("Entrada")
                }

                for (let j = 2; j < length; j += 8) {
                    $(label[j]).text("Inicio/Almoço")
                }

                for (let j = 3; j < length; j += 8) {
                    $(label[j]).text("Fim/Almoço")
                }

                for (let j = 4; j < length; j += 8) {
                    $(label[j]).text("Saída")
                }

                for (let j = 5; j < length; j += 8) {
                    $(label[j]).text("Extra")
                }

                for (let j = 6; j < length; j += 8) {
                    $(label[j]).text("Atraso")
                }

                for (let j = 7; j < length; j += 8) {
                    $(label[j]).text("Lançamento/Ocorrência")
                }
                //====================================
                length = input.length

                for (let j = 0; j < length; j += 7) {
                    $(input[j]).attr('name', 'dia')
                }
                for (let j = 1; j < length; j += 7) {
                    $(input[j]).attr('name', 'horaEntrada')
                }
                for (let j = 2; j < length; j += 7) {
                    $(input[j]).attr('name', 'inicioAlmoco')
                }
                for (let j = 3; j < length; j += 7) {
                    $(input[j]).attr('name', 'fimAlmoco')
                }
                for (let j = 4; j < length; j += 7) {
                    $(input[j]).attr('name', 'horaSaida')
                }
                for (let j = 5; j < length; j += 7) {
                    $(input[j]).attr('name', 'extra')
                }
                for (let j = 6; j < length; j += 7) {
                    $(input[j]).attr('name', 'atraso')
                }

                preencherPonto(JsonFolha);

                getPermissions();

                return;

            }
        );

    }

    //funcionando
    function preencherPonto(object) {
        if (object)

            object = JSON.parse(object);

        const mesAno = initialDate
        const cutOut = mesAno.split('-');
        const data = new Date(cutOut[0], cutOut[1], 0);

        const totalDias = data.getDate();

        const dia = [];
        const entrada = [];
        const saida = [];
        const inicioAlmoco = [];
        const fimAlmoco = [];
        const extra = [];
        const atraso = [];
        const lancamento = [];

        if (object && !object[0].dia) {
            for (let i = 1; i <= totalDias; i++) {
                dia.push(i);
            }
        }

        if (object && !object[0].entrada) {
            for (let i = 1; i <= totalDias; i++) {
                entrada.push('00:00:00');
            }
        }

        if (object && !object[0].inicioAlmoco) {
            for (let i = 1; i <= totalDias; i++) {
                inicioAlmoco.push('00:00');
            }
        }

        if (object && !object[0].fimAlmoco) {
            for (let i = 1; i <= totalDias; i++) {
                fimAlmoco.push('00:00');
            }
        }

        if (object && !object[0].saida) {
            for (let i = 1; i <= totalDias; i++) {
                saida.push('00:00:00');
            }
        }

        if (object && !object[0].horaExtra) {
            for (let i = 1; i <= totalDias; i++) {
                extra.push('00:00');
            }
        }

        if (object && !object[0].atraso) {
            for (let i = 1; i <= totalDias; i++) {
                atraso.push('00:00');
            }
        }

        if (object)
            for (obj of object) {
                dia.push(obj.dia);
                entrada.push(obj.entrada);
                inicioAlmoco.push(obj.inicioAlmoco);
                fimAlmoco.push(obj.fimAlmoco);
                saida.push(obj.saida);
                extra.push(obj.horaExtra);
                atraso.push(obj.atraso);
                lancamento.push(obj.lancamento);
            }

        $('#pointFieldGenerator [name=dia]').each((index, el) => {
            if (!dia[index]) dia[index] = index + 1;
            $(el).val(dia[index]);
        });

        $('#pointFieldGenerator [name=horaEntrada]').each((index, el) => {
            if (!entrada[index]) entrada[index] = '00:00:00';
            $(el).val(entrada[index]);
        });

        $('#pointFieldGenerator [name=inicioAlmoco]').each((index, el) => {
            if (!inicioAlmoco[index]) inicioAlmoco[index] = '00:00';
            $(el).val(inicioAlmoco[index]);
        });

        $('#pointFieldGenerator [name=fimAlmoco]').each((index, el) => {
            if (!fimAlmoco[index]) fimAlmoco[index] = '00:00';
            $(el).val(fimAlmoco[index]);
        });

        $('#pointFieldGenerator [name=horaSaida]').each((index, el) => {
            if (!saida[index]) saida[index] = '00:00:00';
            $(el).val(saida[index]);
        });

        $('#pointFieldGenerator [name=extra]').each((index, el) => {
            if (!extra[index]) extra[index] = '00:00';
            $(el).val(extra[index]);
        });

        $('#pointFieldGenerator [name=atraso]').each((index, el) => {
            if (!atraso[index]) atraso[index] = '00:00';
            $(el).val(atraso[index]);
        });

        $('#pointFieldGenerator [name=lancamento]').each((index, el) => {
            if (!lancamento[index]) lancamento[index] = '0';
            $(el).val(lancamento[index]);
        });

        return;
    }

    function aleatorizarTempo(hora, expediente) {
        let separador = hora.split(':');
        let h = Number(separador[0]);
        let m = Number(separador[1]);
        let s = Number(separador[2]);

        separador = expediente.split(':');
        const eh = Number(separador[0]);
        const em = Number(separador[1]);
        let es = Number(separador[2]);
        if (isNaN(es)) es = Number('00');

        if ((h == eh) && (m == em)) {
            s = Math.floor(Math.random() * 50);
        }

        if (h.toString().length < 2) h = `0${h}`;
        if (m.toString().length < 2) m = `0${m}`;
        if (s.toString().length < 2) s = `0${s}`;

        const result = `${h}:${m}:${s}`;
        return result;
    }

    function parse(horario) {
        // divide a string em duas partes, separado por dois-pontos, e transforma em número

        let [hora, minuto, segundos] = horario.split(':').map(v => parseInt(v));
        if (!minuto) { // para o caso de não ter os minutos
            minuto = 0;
        }

        if (!segundos) { // para o caso de não ter os segundos
            segundos = 0;
        }
        return segundos + (minuto * 60) + (hora * Math.pow(60, 2));
    }

    function imprimir() {
        const id = $('#funcionario').val();
        const folha = $('#codigo').val();
        const mesAno = initialDate

        $(location).attr('href', `funcionario_folhaDePontoPdfPontoEletronico.php?id=${id}&folha=${folha}&data=${mesAno}`);
    }

    function generateElements(tagName = "div", parent = "body", text = "", properties = {}) {

        const element = $(`<${tagName}/>`, properties)

        if (text) {
            element.text(text)
        }

        return $(parent).append(element)
    }

    function deleteElements(element) {
        $(element).remove();
        return;
    }

    function diasMes(date = '') {
        let ano, mes, cutout;
        if (/\//g.test(date)) {
            cutout = date.split(/\//g);
            ano = cutout[2];
            mes = cutout[1];
        }
        if (/\-/g.test(date)) {
            cutout = date.split(/\-/g);
            ano = cutout[0];
            mes = cutout[1];
        }
        const data = new Date(ano, mes, 0);
        return data.getDate();
    }

    function abonarAtraso() {
        const lancamento = $("#inputLancamento").val();
        let abonarAtraso = 0;

        consultarLancamento(lancamento, function(data) {

            data = data.replace(/failed/gi, '');
            var piece = data.split("#");

            var mensagem = piece[0];
            var out = piece[1];
            piece = out.split("^");

            abonarAtraso = piece[0];

            let arrayFolha = $("#pointFieldGenerator select[name='lancamento']");

            if (abonarAtraso == 1) {
                arrayFolha.each((index, el) => {

                    if ($(el).val() == lancamento)
                        $("input[name=atraso]")[index].value = "00:00";
                })
            }

            return;
        })

    }

    function checkDay(day) {
        if (day.length < 2)
            day = '0'.concat(day);

        let mesAno = initialDate
        mesAno = mesAno.replace(/\d\d$/g, day);
        const aux = mesAno.split('-');
        const date = new Date(aux[0], (aux[1] - 1), aux[2]);
        let isWeekend = false;
        let checkDay = date.getDay();
        const weekend = [0, 6];

        isWeekend = weekend.includes(checkDay);

        return isWeekend;

    }

    function addPoint() {

        const dia = $("#inputDia").val();

        if (!dia || dia < 1) {
            smartAlert("Atenção", "Insira um dia válido", "error");
            return;
        }

        const index = dia - 1;

        const entrada = $("#pointFieldGenerator [name=horaEntrada]")[index]
        const inputEntrada = $("#inputHoraEntrada").val().trim() || '00:00:00'

        const inicioAlmoco = $("#pointFieldGenerator [name=inicioAlmoco]")[index]
        const inputInicioAlmoco = $("#inputInicioAlmoco").val().trim() || '00:00'
        if (inputInicioAlmoco == "00:00") {
            smartAlert("Aviso", "O horário de inicio de almoço encontra-se como: " + inputInicioAlmoco, "warning");
        }

        const fimAlmoco = $("#pointFieldGenerator [name=fimAlmoco]")[index]
        const inputFimAlmoco = $("#inputFimAlmoco").val().trim() || '00:00'
        if (inputFimAlmoco == "00:00") {
            smartAlert("Aviso", "O horário de encerramento de almoço encontra-se como: " + inputFimAlmoco, "warning");
        }

        const saida = $("#pointFieldGenerator [name=horaSaida]")[index]
        const inputSaida = $("#inputHoraSaida").val().trim() || '00:00:00'

        const extra = $("#pointFieldGenerator [name=extra]")[index]
        let inputExtra = $("#inputHoraExtra").val().trim()

        const atraso = $("#pointFieldGenerator [name=atraso]")[index]
        let inputAtraso = $("#inputAtraso").val().trim()

        const lancamento = $("#pointFieldGenerator select[name=lancamento]")[index]

        const inputLancamento = $("#inputLancamento").val()


        //Preparação dos valores para cálculo e aleatorização dos minutos e segundos

        let separador = $("#expediente option:selected").text();
        if (!separador) {
            separador = '00:00 - 00:00';
        }
        separador = separador.split("-");
        separador[0] = separador[0].trim();
        separador[1] = separador[1].trim();

        if (separador[0].toString().length <= 5) separador[0] = separador[0].concat(':00');
        if (separador[1].toString().length <= 5) separador[1] = separador[1].concat(':00');

        let inicioExpediente = separador[0];
        let fimExpediente = separador[1];

        const horaEntrada = aleatorizarTempo(inputEntrada, inicioExpediente);
        const horaSaida = aleatorizarTempo(inputSaida, fimExpediente)

        //Começo Cálculo de Hora Extra
        const parseToleranciaExtra = parse("00:" + toleranciaExtra)
        parseToleranciaAtraso = parse("00:" + toleranciaAtraso)

        if (horaSaida != "00:00:00") {
            //valor em segundos
            const parseHoraEntrada = parse(horaEntrada)
            const parseHoraSaida = parse(horaSaida)
            const parseHoraInicio = parse(inicioExpediente)
            const parseHoraFim = parse(fimExpediente)

            //calculo

            let jornadaModerada = parseHoraFim - parseHoraInicio
            const jornadaModeradaToleranteExtra = jornadaModerada + parseToleranciaExtra
            const jornadaModeradaToleranteAtraso = jornadaModerada - parseToleranciaExtra
            // quantidade de minutos efetivamente trabalhados
            let jornada = parseHoraSaida - parseHoraEntrada;

            // diferença entre as jornadas
            let diff = Math.abs(jornada - jornadaModerada);

            if (diff != 0) {
                let horas = Math.floor(diff / Math.pow(60, 2));
                let minutos = Math.floor(diff / 60);
                let segundos = diff;

                if (horas.toString().length < 2) horas = `0${horas}`;
                if (minutos.toString().length < 2) minutos = `0${minutos}`;

                if (jornada > jornadaModeradaToleranteExtra) {
                    inputExtra = (`${horas}:${minutos}`);
                } else if (jornada < jornadaModeradaToleranteAtraso) {
                    inputAtraso = (`${horas}:${minutos}`);
                }
            }
        }
        //Fim Cálculo de Hora Extra
        //Verificação de Atraso

        separador = inputAtraso.split(':');
        let h = Number(separador[0]);
        let m = Number(separador[1]);

        let separadorTolerancia = toleranciaAtraso.split(':');
        let hTolerancia = Number(separadorTolerancia[0]);
        let mTolerancia = Number(separadorTolerancia[1]);


        //m <= tolerancia Atraso
        if (m < mTolerancia && h == 0) {
            inputAtraso = ""
        }

        //Fim da Verificação de Atraso

        //Verificação de Extra
        separador = inputExtra.split(':');
        h = Number(separador[0]);
        m = Number(separador[1]);

        separadorTolerancia = toleranciaExtra.split(':');
        hTolerancia = Number(separadorTolerancia[0]);
        mTolerancia = Number(separadorTolerancia[1]);

        //m <= tolerancia Extra
        if (m <= mTolerancia && h == 0) {
            inputExtra = ""
        }

        //Fim da Verificação de Extra

        // Verificações antes de adicionar o ponto
        if ((!inputEntrada || inputEntrada == "00:00:00") && !inputLancamento) {
            smartAlert("Atenção", "A Hora de Entrada deve ser preenchida", "error");
            return
        }

        if (inputExtra && (horaSaida != "00:00:00")) {
            smartAlert("Aviso", "O funcionário possui horas extras", "info");
        }
        if (inputAtraso && (horaSaida != "00:00:00")) {
            smartAlert("Aviso", "O funcionário possuiatrasos", "info");
        }


        entrada.value = horaEntrada || "00:00:00";
        inicioAlmoco.value = inputInicioAlmoco || "00:00";
        fimAlmoco.value = inputFimAlmoco || "00:00";
        extra.value = inputExtra || '00:00';
        atraso.value = inputAtraso || '00:00';
        saida.value = horaSaida || "00:00:00";
        lancamento.value = inputLancamento;

        abonarAtraso();

        return;
    }

    function getPermissions() {
        consultarPermissoes(function(data) {
            data = data.replace(/failed/gi, '');
            var piece = data.split("#");

            var mensagem = piece[0];
            var out = piece[1];
            if (!out) {
                smartAlert("Atenção", "Não foi possível verificar a permissão do usuário", "error");
                return;
            }

            try {

                let permissoes = JSON.parse(out);
                setPage(permissoes);

            } catch (e) {
                console.error(e)
                smartAlert("Atenção", "Não foi possível verificar a permissão do usuário", "error")
            } finally {
                return;
            }

        });
    }

    function setPage(obj) {
        for (permissao in obj) {

            if (permissao == 'PONTOELETRONICOMENSALMODERADO') {
                $("#mesAno").attr('readonly', obj[permissao].mesAno.readonly);
                $("#mesAno").removeAttr('style');
                if (!obj[permissao].mesAno.class)
                    $("#mesAno").removeClass('readonly');

                let status = $("#status option:selected").text();
                const pattern = /^fechad(o|a)$/gi;
                const pattern2 = /^validad(o|a) ?(pelo|por)? ?(o|a)?gestor$/gi;
                const pattern3 = /^validad(o|a) ?(pelo|por)? ?(o|a)?(r|recursos?) ?(h|humanos?)$/gi;

                const condition = pattern.test(status);
                const condition2 = pattern2.test(status);
                const condition3 = pattern3.test(status);

                if (!condition && !condition2 && !condition3) {

                    $("#inputDia").attr('readonly', obj[permissao].dia.readonly);
                    if (!obj[permissao].dia.class)
                        $("#inputDia").removeClass('readonly');

                    $("#inputHoraEntrada").attr('readonly', obj[permissao].entrada.readonly);
                    if (!obj[permissao].entrada.class)
                        $("#inputHoraEntrada").removeClass('readonly');

                    $("#inputInicioAlmoco").attr('readonly', obj[permissao].inicioAlmoco.readonly);
                    if (!obj[permissao].inicioAlmoco.class)
                        $("#inputInicioAlmoco").removeClass('readonly');

                    $("#inputFimAlmoco").attr('readonly', obj[permissao].fimAlmoco.readonly);
                    if (!obj[permissao].fimAlmoco.class)
                        $("#inputFimAlmoco").removeClass('readonly');

                    $("#inputHoraSaida").attr('readonly', obj[permissao].saida.readonly);
                    if (!obj[permissao].saida.class)
                        $("#inputHoraSaida").removeClass('readonly');

                    $("#inputHoraExtra").attr('readonly', obj[permissao].extra.readonly);
                    if (!obj[permissao].extra.class)
                        $("#inputHoraExtra").removeClass('readonly');

                    $("#inputAtraso").attr('readonly', obj[permissao].atraso.readonly);
                    if (!obj[permissao].atraso.class)
                        $("#inputAtraso").removeClass('readonly');

                    $("#inputLancamento").attr('readonly', obj[permissao].lancamento.readonly);
                    $("#inputLancamento").removeAttr('style');
                    if (!obj[permissao].lancamento.class)
                        $("#inputLancamento").removeClass('readonly');
                    $("#inputLancamento").css('pointer-events', obj[permissao].lancamento.pointerEvents);
                    $("#inputLancamento").css('touch-action', obj[permissao].lancamento.touchAction);

                    $("#btnAddPonto").attr('disabled', obj[permissao].adicionarPonto.disabled);
                    $("#btnFechar").attr('disabled', obj[permissao].fechar.disabled);
                    $("#btnGravar").attr('disabled', obj[permissao].salvarAlteracoes.disabled);
                } else {

                    $("#inputDia").attr('readonly', true);
                    if (!$("#inputDia").hasClass('readonly')) {
                        $("#inputDia").addClass('readonly');
                    }

                    $("#inputHoraEntrada").attr('readonly', true);
                    if (!$("#inputHoraEntrada").hasClass('readonly')) {
                        $("#inputHoraEntrada").addClass('readonly');
                    }

                    $("#inputInicioAlmoco").attr('readonly', true);
                    if (!$("#inputInicioAlmoco").hasClass('readonly')) {
                        $("#inputInicioAlmoco").addClass('readonly');
                    }

                    $("#inputFimAlmoco").attr('readonly', true);
                    if (!$("#inputFimAlmoco").hasClass('readonly')) {
                        $("#inputFimAlmoco").addClass('readonly');
                    }

                    $("#inputHoraSaida").attr('readonly', true);
                    if (!$("#inputHoraSaida").hasClass('readonly')) {
                        $("#inputHoraSaida").addClass('readonly');
                    }

                    $("#inputHoraExtra").attr('readonly', true);
                    if (!$("#inputHoraExtra").hasClass('readonly')) {
                        $("#inputHoraExtra").addClass('readonly');
                    }

                    $("#inputAtraso").attr('readonly', true);
                    if (!$("#inputAtraso").hasClass('readonly')) {
                        $("#inputAtraso").addClass('readonly');
                    }

                    $("#inputLancamento").attr('readonly', obj[permissao].lancamento.readonly);
                    $("#inputLancamento").removeAttr('style');
                    if (!$("#inputLancamento").hasClass('readonly')) {
                        $("#inputLancamento").addClass('readonly');
                    }
                    $("#inputLancamento").css('pointer-events', 'none');
                    $("#inputLancamento").css('touch-action', 'none');

                    $("#btnAddPonto").attr('disabled', true);
                    $("#btnFechar").attr('disabled', true);
                    $("#btnGravar").attr('disabled', true);
                }

                break;
            } else if (permissao == 'PONTOELETRONICOMENSALMINIMO') {

                $("#mesAno").attr('readonly', obj[permissao].mesAno.readonly);
                $("#mesAno").removeAttr('style');
                if (!obj[permissao].mesAno.class)
                    $("#mesAno").removeClass('readonly');

                let status = $("#status option:selected").text();
                const pattern = /^fechad(o|a)$/gi
                const pattern2 = /^validad(o|a) ?(pelo|por)? ?(o|a)?gestor$/gi;
                const pattern3 = /^validad(o|a) ?(pelo|por)? ?(o|a)?(r|recursos?) ?(h|humanos?)$/gi;

                const condition = pattern.test(status);
                const condition2 = pattern2.test(status);
                const condition3 = pattern3.test(status);

                if (!condition && !condition2 && !condition3) {

                    $("#inputDia").attr('readonly', obj[permissao].dia.readonly);
                    if (!obj[permissao].dia.class)
                        $("#inputDia").removeClass('readonly');

                    $("#inputHoraEntrada").attr('readonly', obj[permissao].entrada.readonly);
                    if (!obj[permissao].entrada.class)
                        $("#inputHoraEntrada").removeClass('readonly');

                    $("#inputInicioAlmoco").attr('readonly', obj[permissao].inicioAlmoco.readonly);
                    if (!obj[permissao].inicioAlmoco.class)
                        $("#inputInicioAlmoco").removeClass('readonly');

                    $("#inputFimAlmoco").attr('readonly', obj[permissao].fimAlmoco.readonly);
                    if (!obj[permissao].fimAlmoco.class)
                        $("#inputFimAlmoco").removeClass('readonly');

                    $("#inputHoraSaida").attr('readonly', obj[permissao].saida.readonly);
                    if (!obj[permissao].saida.class)
                        $("#inputHoraSaida").removeClass('readonly');

                    $("#inputHoraExtra").attr('readonly', obj[permissao].extra.readonly);
                    if (!obj[permissao].extra.class)
                        $("#inputHoraExtra").removeClass('readonly');

                    $("#inputAtraso").attr('readonly', obj[permissao].atraso.readonly);
                    if (!obj[permissao].atraso.class)
                        $("#inputAtraso").removeClass('readonly');

                    $("#inputLancamento").attr('readonly', obj[permissao].lancamento.readonly);
                    $("#inputLancamento").removeAttr('style');
                    if (!obj[permissao].lancamento.class)
                        $("#inputLancamento").removeClass('readonly');
                    $("#inputLancamento").css('pointer-events', obj[permissao].lancamento.pointerEvents);
                    $("#inputLancamento").css('touch-action', obj[permissao].lancamento.touchAction);

                    $("#btnAddPonto").attr('disabled', obj[permissao].adicionarPonto.disabled);
                    $("#btnFechar").attr('disabled', obj[permissao].fechar.disabled);
                    $("#btnGravar").attr('disabled', obj[permissao].salvarAlteracoes.disabled);
                } else {

                    $("#inputDia").attr('readonly', true);
                    if (!$("#inputDia").hasClass('readonly')) {
                        $("#inputDia").addClass('readonly');
                    }

                    $("#inputHoraEntrada").attr('readonly', true);
                    if (!$("#inputHoraEntrada").hasClass('readonly')) {
                        $("#inputHoraEntrada").addClass('readonly');
                    }

                    $("#inputInicioAlmoco").attr('readonly', true);
                    if (!$("#inputInicioAlmoco").hasClass('readonly')) {
                        $("#inputInicioAlmoco").addClass('readonly');
                    }

                    $("#inputFimAlmoco").attr('readonly', true);
                    if (!$("#inputFimAlmoco").hasClass('readonly')) {
                        $("#inputFimAlmoco").addClass('readonly');
                    }

                    $("#inputHoraSaida").attr('readonly', true);
                    if (!$("#inputHoraSaida").hasClass('readonly')) {
                        $("#inputHoraSaida").addClass('readonly');
                    }

                    $("#inputHoraExtra").attr('readonly', true);
                    if (!$("#inputHoraExtra").hasClass('readonly')) {
                        $("#inputHoraExtra").addClass('readonly');
                    }

                    $("#inputAtraso").attr('readonly', true);
                    if (!$("#inputAtraso").hasClass('readonly')) {
                        $("#inputAtraso").addClass('readonly');
                    }

                    $("#inputLancamento").attr('readonly', obj[permissao].lancamento.readonly);
                    $("#inputLancamento").removeAttr('style');
                    if (!$("#inputLancamento").hasClass('readonly')) {
                        $("#inputLancamento").addClass('readonly');
                    }
                    $("#inputLancamento").css('pointer-events', 'none');
                    $("#inputLancamento").css('touch-action', 'none');

                    $("#btnAddPonto").attr('disabled', true);
                    $("#btnFechar").attr('disabled', true);
                    $("#btnGravar").attr('disabled', true);
                }

                break;
            }
        }

    }

    async function enviarPDF() {

        const files = [];
        const datas = [];
        jsonUploadFolhaArray.forEach(obj => {
            const ob = {};
            for (let prop in obj) {
                if (obj[prop] instanceof File) files.push(obj[prop])
                else ob[prop] = obj[prop]
            }
            datas.push(ob)
        })

        const base64 = [];
        for (let file of files) {
            base64.push(await fileToBase64(file))
        }

        const jsonData = datas.map((obj, index) => {
            obj.fileUploadFolha = base64[index]
            return obj
        })

        enviarArquivo(jsonData, function(data) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                    $("#btnEnviarArquivo").prop('disabled', false);
                    return false;
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                    $("#btnEnviarArquivo").prop('disabled', false);
                    return false;
                }
            } else {
                var piece = data.split("#");
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                $("#btnEnviarArquivo").prop('disabled', false);
                return true;
            }
        })
    }

    // === === === === === === === === === === === //
    // === === === === === === === === === === === //
    function fillTableUploadFolha() {
        $("#tableUploadFolha tbody").empty();
        for (var i = 0; i < jsonUploadFolhaArray.length; i++) {

            var row = $('<tr />');
            $("#tableUploadFolha tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonUploadFolhaArray[i].sequencialUploadFolha + '"><i></i></label></td>'));

            var fileUploadFolha = jsonUploadFolhaArray[i].fileUploadFolha;

            row.append($('<td class="text-nowrap" onclick="carregaUploadFolha(' + jsonUploadFolhaArray[i].sequencialUploadFolha + ');">' + fileUploadFolha.name + '</td>'));

            var uploadType = jsonUploadFolhaArray[i].uploadType;

            row.append($('<td class="text-nowrap">' + uploadType + '</td>'));

            var dataReferenteUpload = jsonUploadFolhaArray[i].dataReferenteUpload;
            row.append($('<td class="text-nowrap">' + dataReferenteUpload + '</td>'));

            var dataUpload = jsonUploadFolhaArray[i].dataUpload;
            row.append($('<td class="text-nowrap">' + dataUpload + '</td>'));
        }
    }

    function validaUploadFolha() {

        const fileUploadFolha = $('#fileUploadFolha').prop('files')[0];

        if (!fileUploadFolha) {
            smartAlert("Erro", "Informe o arquivo!", "error");
            return false;
        }

        const dataReferenteUpload = $('#dataReferenteUpload').val();

        if (!dataReferenteUpload) {
            smartAlert("Erro", "Informe a data à qual o arquivo pertence!", "error");
            return false;
        }

        return true;
    }

    function addUploadFolha() {

        var item = $("#formUploadFolha").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataUploadFolha
        });

        if (item["sequencialUploadFolha"] === '') {
            if (jsonUploadFolhaArray.length === 0) {
                item["sequencialUploadFolha"] = 1;
            } else {
                item["sequencialUploadFolha"] = Math.max.apply(Math, jsonUploadFolhaArray.map(function(o) {
                    return o.sequencialUploadFolha;
                })) + 1;
            }
            item["uploadFolhaId"] = 0;
        } else {
            item["sequencialUploadFolha"] = +item["sequencialUploadFolha"];
        }

        var index = -1;
        $.each(jsonUploadFolhaArray, function(i, obj) {
            if (+$('#sequencialUploadFolha').val() === obj.sequencialUploadFolha) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonUploadFolhaArray.splice(index, 1, item);
        else
            jsonUploadFolhaArray.push(item);

        $("#jsonUploadFolha").val(JSON.stringify(jsonUploadFolhaArray));
        fillTableUploadFolha();
        clearFormUploadFolha();
    }

    function processDataUploadFolha(node) {

        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';


        if (fieldName !== '' && (fieldId === "fileUploadFolha")) {

            return {
                name: fieldName,
                value: $("#fileUploadFolha").prop('files')[0]
            };
        }


        if (fieldName !== '' && (fieldId === "dataReferenteUpload")) {

            var dataReferenteUpload = $('#dataReferenteUpload').val();

            return {
                name: fieldName,
                value: dataReferenteUpload
            };
        }

        if (fieldName !== '' && (fieldId === "dataUpload")) {

            var dataUpload = new Date().toLocaleDateString('pt-BR')

            return {
                name: fieldName,
                value: dataUpload
            };
        }

        return false;
    }

    function clearFormUploadFolha() {
        $("#fileUploadFolha").val('');
        $("#uploadType").val('');
        $("#dataReferenteUpload").val('');
        $("#uploadFolhaId").val('');
        $("#dataUpload").val('');
        $("#sequencialUploadFolha").val('');
    }

    function carregaUploadFolha(sequencialUploadFolha) {
        var arr = jQuery.grep(jsonUploadFolhaArray, function(item, i) {
            return (item.sequencialUploadFolha === sequencialUploadFolha);
        });

        clearFormUploadFolha();

        if (arr.length > 0) {
            var item = arr[0];
            let list = new DataTransfer();
            list.items.add(item.fileUploadFolha)
            $("#fileUploadFolha").prop('files', list.files)[0];
            $("#uploadType").val(item.uploadType);
            $("#dataReferenteUpload").val(item.dataReferenteUpload);
            $("#uploadFolhaId").val(item.uploadFolhaId);
            $("#dataUpload").val(item.dataUpload);
            $("#sequencialUploadFolha").val(item.sequencialUploadFolha);
        }
    }

    function excluirUploadFolha() {
        var arrSequencial = [];
        $('#tableUploadFolha input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonUploadFolhaArray.length - 1; i >= 0; i--) {
                var obj = jsonUploadFolhaArray[i];
                if (jQuery.inArray(obj.sequencialUploadFolha, arrSequencial) > -1) {
                    jsonUploadFolhaArray.splice(i, 1);
                }
            }
            $("#jsonUploadFolha").val(JSON.stringify(jsonUploadFolhaArray));
            fillTableUploadFolha();
        } else
            smartAlert("Erro", "Selecione pelo menos um arquivo para excluir.", "error");
    }

    function fileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    };

    function recuperaUpload() {
        recuperaArquivo(async function(data) {
            data = data.replace(/failed/g, '');
            let piece = data.split("#");

            let mensagem = piece[0];
            let out = piece[1];
            let JsonUpload = JSON.parse(piece[2]);

            const files = []
            const jsonUploadFolha = []
            //OK
            for (obj of JsonUpload) {
                let file = await fetch(obj.fileUploadFolha)
                file = await file.blob()
                file = new File([file], obj.fileName, {
                    type: "application/pdf"
                })
                files.push(file)
            }

            JsonUpload.forEach((obj, index) => {
                let dataReferente = obj.dataReferenteUpload.split(" ")
                let aux = dataReferente[0].split("-")
                aux = `${aux[2]}/${aux[1]}/${aux[0]}`
                dataReferente = aux

                let dataUpload = obj.dataUpload.split(" ")
                aux = dataUpload[0].split("-")
                aux = `${aux[2]}/${aux[1]}/${aux[0]}`
                dataUpload = aux

                jsonUploadFolha.push({
                    dataReferenteUpload: dataReferente,
                    dataUpload: dataUpload,
                    uploadType: obj.uploadType,
                    sequencialUploadFolha: obj.sequencialUploadFolha,
                    fileUploadFolha: files[index]
                })
            })

            jsonUploadFolhaArray = jsonUploadFolha
            fillTableUploadFolha()
        })
    }
</script>