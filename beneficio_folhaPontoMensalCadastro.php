<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('LANCAMENTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('LANCAMENTO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('LANCAMENTO_EXCLUIR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}
$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
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
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]["controlePonto"]["active"] = true;
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
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Controle de Ponto
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formFolhaPontoMensalCadastro" method="post">
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

                                                        <input id="JsonFolhaPontoMensal" name="JsonFolhaPontoMensal" type="hidden" value="[]">
                                                        <div id="formFolhaPontoMensal" class="col-sm-12">
                                                            <input id="lancamentoId" name="lancamentoId" type="hidden" value="">
                                                            <input id="sequencialFolhaPontoMensal" name="sequencialFolhaPontoMensal" type="hidden" value="">
                                                            <div class="form-group">

                                                                <div class="row">

                                                                    <section class="col col-4">
                                                                        <label class="label " for="funcionario">Funcionário</label>
                                                                        <label class="select">
                                                                            <select id="funcionario" name="funcionario" class="readonly" readonly>
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, nome from Ntl.funcionario where dataDemissaoFuncionario IS NULL AND ativo = 1 order by nome";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $nome = $row['nome'];
                                                                                    echo '<option value= ' . $codigo . '>' . $nome . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </label>
                                                                    </section>

                                                                    <!-- <section class="col col-4">
                                                                        <label class="label" for="projeto">Projeto</label>
                                                                        <label class="select">
                                                                            <select id="projeto" name="projeto" class="readonly" readonly>
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, descricao from Ntl.projeto where ativo = 1 order by descricao";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $descricao = $row['descricao'];
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </label>
                                                                    </section> -->

                                                                    <section class="col col-2">
                                                                        <label class="label" for="Expediente">Expediente</label>
                                                                        <label class="select">
                                                                            <select id="Expediente" name="Expediente"  class="readonly" readonly>
                                                                                <option>08:00 às 17:00</option>
                                                                                <option>10:00 às 16:00</option>
                                                                               
                                                                            </select>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="mesAnoFolhaPonto">Mês Corrente</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="mesAnoFolhaPonto" name="mesAnoFolhaPonto" style="text-align: center;" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="readonly" readonly value="">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-1">
                                                                        <label class="label">&nbsp;</label>
                                                                        <label id="labelCheckAlmoco" class="checkbox">
                                                                            <input id="checkAlmoco" name="checkAlmoco" type="checkbox" value="true"><i></i>
                                                                            Habilitar Almoço
                                                                        </label>
                                                                    </section>



                                                                </div>


                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong></strong></legend>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label"> </label>
                                                                        <input id="horaAtual" name="horaAtual" type="text" class="text-center form-control hidden" hidden data-autoclose="true" value="">

                                                                    </section>

                                                                </div>

                                                                <div class="row">

                                                                    <section class="col col-1">
                                                                        <div class="form-group">
                                                                            <label class="label">Dia</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="dia" name="dia" type="text" class="text-center form-control " data-autoclose="true" value="">
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">Entrada</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="horaEntrada" name="horaEntrada" type="text" class="text-center form-control" placeholder="  00:00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1 sectionAlmoco" style="display: none">
                                                                        <div class="form-group">
                                                                            <label class="label">Inicio/Almoço</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="inicioAlmoco" name="inicioAlmoco" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1 sectionAlmoco" style="display: none">
                                                                        <div class="form-group">
                                                                            <label class="label">Fim/Almoço</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="fimAlmoco" name="fimAlmoco" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">Saída</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="horaSaida" name="horaSaida" type="text" class="text-center form-control" placeholder="  00:00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">H.Extra</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="horaExtra" name="horaExtra" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-1">
                                                                        <div class="form-group">
                                                                            <label id="labelHora" class="label">Atraso</label>
                                                                            <div class="input-group" data-align="top" data-autoclose="true">
                                                                                <input id="atraso" name="atraso" type="text" class="text-center form-control" placeholder="  00:00" data-autoclose="true" value="">
                                                                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="lancamento">Lançamento/Ocorrência</label>
                                                                        <label class="select">
                                                                            <select id="lancamento" name="lancamento">
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, descricao from Ntl.lancamento where ativo = 1 order by descricao";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $descricao = $row['descricao'];
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-md-1">
                                                                        <label class="label"> </label>
                                                                        <button id="btnAddPonto" type="button" class="btn btn-primary">
                                                                            <i class="">Lançar Ponto</i>
                                                                        </button>
                                                                    </section>
                                                                </div>

                                                                <hr><br><br>

                                                                <?php
                                                                $i = 0;
                                                                $days = date("t");
                                                                while ($i  < $days) {
                                                                    $i = $i + 1;
                                                                    echo "<div class=\"row\">

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Dia</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"dia-$i\" name=\"dia-$i\" type=\"text\" class=\"text-center form-control readonly\" readonly data-autoclose=\"true\" value=\"" . $i . "\">
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Entrada</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaEntrada-$i\" name=\"horaEntrada-$i\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1 sectionAlmoco\" style=\" display:none\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Inicio/Almoço</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"inicioAlmoco-$i\" name=\"inicioAlmoco-$i\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1 sectionAlmoco\" style=\"display:none\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Fim/Almoço</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"fimAlmoco-$i\" name=\"fimAlmoco-$i\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Saída</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaSaida-$i\" name=\"horaSaida-$i\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">H.Extra</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaExtra-$i\" name=\"horaExtra-$i\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Atraso</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"atraso-$i\" name=\"atraso-$i\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <label class=\"label\" for=\"lancamento\">Lançamento/Ocorrência</label>
                                                                        <label class=\"select\">
                                                                            <select id=\"lancamento-$i\" name=\"lancamento-$i\" class=\" readonly\" readonly style= \"pointer-events: none; touch-action: none\" tabindex=\"-1\">
                                                                                <option></option>";

                                                                    $reposit = new reposit();
                                                                    $sql = "select codigo, sigla, descricao from Ntl.lancamento where ativo = 1 order by descricao";
                                                                    $result = $reposit->RunQuery($sql);
                                                                    foreach ($result as $row) {
                                                                        $codigo = (int) $row['codigo'];
                                                                        $descricao = $row['descricao'];
                                                                        echo "<option value=' . $codigo . '> $descricao </option>'";
                                                                    }
                                                                    echo " </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                ";
                                                                }
                                                                ?>

                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <label class="label">Observações</label>
                                                                        <textarea maxlength="500" id="observacoes" name="observacoes" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                    </fieldset>
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
                                                <span class="fa fa-backward"></span>
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
    var jsonFolhaPontoMensalArray = [];
    $(document).ready(function() {

        $("#horaEntrada").mask("99:99:99");

        $('#horaEntrada').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm:ss'));

        $("#horaSaida").mask("99:99:99");

        $('#horaSaida').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm:ss'));

        $("#inicioAlmoco").mask("99:99");

        $('#inicioAlmoco').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));

        $("#fimAlmoco").mask("99:99");

        $('#fimAlmoco').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));

        $("#horaExtra").mask("99:99");

        $('#horaExtra').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));

        $("#atraso").mask("99:99");

        $('#atraso').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));



        $("#btnAddPonto").on("click", function() {

            var dia = $("#dia").val()


            $("#horaEntrada-" + dia).val($("#horaEntrada").val())
            $("#inicioAlmoco-" + dia).val($("#inicioAlmoco").val())
            $("#fimAlmoco-" + dia).val($("#fimAlmoco").val())
            $("#horaSaida-" + dia).val($("#horaSaida").val())
            $("#horaExtra-" + dia).val($("#horaExtra").val())
            $("#atraso-" + dia).val($("#atraso").val())
            $("#lancamento-" + dia).val($("#lancamento").val())
        });


        $('#btnNovo').on("click", function() {
            novo()
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#btnExcluir").on("click", function() {
            excluir();
        });
        $("#checkAlmoco").on("click", function() {
            var check = $(".sectionAlmoco")
            check.each((index, el) => {
                console.log(typeof el)
                console.log($(el))

                if ($(el).css('display') != 'block') {

                    $(el).css('display', 'block')
                } else {
                    $(el).css('display', 'none')
                }
            })
        });

        carregaFolhaPontoMensal();


    });

    function voltar() {
        $(location).attr('href', 'beneficio_folhaPontoMensalFiltro.php');

    }

    function novo() {
        $(location).attr('href', 'beneficio_folhaPontoCadastro.php');

    }

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);
        var arrayFolha = $("input[name='dia']")
        var arrayDia = new Array()
        arrayFolha.forEach(folha => {
            return arrayDia.push({
                dia: folha.value
            })
        })

        var arrayFolha = $("input[name='horaEntrada']")
        var arrayHoraEntrada = new Array()
        arrayFolha.forEach(folha => {
            return arrayHoraEntrada.push({
                horaEntrada: folha.value
            })
        })

        var arrayFolha = $("input[name='inicioAlmoco']")
        var arrayInicioAlmoco = new Array()
        arrayFolha.forEach(folha => {
            return arrayInicioAlmoco.push({
                inicioAlmoco: folha.value
            })
        })

        var arrayFolha = $("input[name='fimAlmoco']")
        var arrayFimAlmoco = new Array()
        arrayFolha.forEach(folha => {
            return arrayFimAlmoco.push({
                fimAlmoco: folha.value
            })
        })

        var arrayFolha = $("input[name='horaEntrada']")
        var arrayHoraEntrada = new Array()
        arrayFolha.forEach(folha => {
            return arrayHoraEntrada.push({
                horaEntrada: folha.value
            })
        })


        var codigo = +$("#codigo").val();
        var ativo = $("#ativo").val();
        var funcionario = $("#funcionario").val();
        var mesAnoFolhaPonto = $("#mesAnoFolhaPonto").val();
        var observacaoFolhaPontoMensal = $("#observacaoFolhaPontoMensal").val();

        let lancamentoTabela = $('#formFolhaPontoMensalCadastro').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:


        gravaFolhaPontoMensal(FolhaPontoMensalTabela,
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
                    novo();
                }
            }
        );
    }


    function excluir() {
        debugger;
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFolhaPontoMensal(id, function(data) {
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
                voltar();
            }
        });
    }


    function carregaFolhaPontoMensal() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFolhaPontoMensal(idd,
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
                        var funcionario = piece[1];
                        var projeto = piece[2];
                        var mesAnoFolhaPonto = piece[3];



                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#funcionario").val(funcionario);
                        $("#projeto").val(projeto);
                        $("#mesAnoFolhaPonto").val(mesAnoFolhaPonto);





                    }
                );
            }
        }
    }
</script>