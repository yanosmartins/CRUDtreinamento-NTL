<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$funcionario = $_SESSION["funcionario"];
@list($ano, $mes, $dia) = explode("-", $_GET["mesAno"]);
$mesAno = $mes . "/" . $ano;

$condicaoAcessarOK = (in_array('TRIAGEMPONTOELETRONICOMENSALRH_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('TRIAGEMPONTOELETRONICOMENSALRH_GRAVAR', $arrayPermissao, true));

$condicaoAcessarOK = true;

if (($condicaoAcessarOK == false)) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Triagem ponto mensal RH";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$page_css[] = "ponto_mensal.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['funcionario']['sub']["triagemPontoEletronicoRH"]["active"] = true;
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
                            <h2>Controle de folhas
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
                                                        Dados do Mês <span id="showMesAno"><?= $mesAno ?></span>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFolhaPontoMensal" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>


                                                        <div id="formFolhaPontoMensal" class="col-sm-12">
                                                            <input id="codigo" name="codigo" type="hidden" value="0">

                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <label class="label" for="funcionario">Funcionário</label>
                                                                    <label class="select">
                                                                        <select id="funcionario" name="funcionario">
                                                                            <option></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo,nome FROM Ntl.funcionario WHERE ativo = 1 AND nome !='ADMINISTRADOR'  ORDER BY nome";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $nome = $row['nome'];
                                                                                if ($codigo == $_GET["funcionario"]) {
                                                                                    echo "<option value=\"$codigo\" selected>$nome</option>";
                                                                                    continue;
                                                                                }
                                                                                echo "<option value=\"$codigo\">$nome</option>";
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2 col-auto">
                                                                    <label for="mesAno" class="label">Mês/Ano</label>
                                                                    <label class="input">
                                                                        <input id="mesAno" name="mesAno" type="text" data-dateformat="mm/yy" class="datepicker" style="text-align: center" value="<?= $mesAno ?>" data-mask="99/9999" data-mask-placeholder="-" autocomplete="off">
                                                                    </label>
                                                                </section>

                                                                <section class=" col col-md-2">
                                                                    <label class="label"> </label>
                                                                    <button type="button" id="btnSearch" class="btn btn-info" aria-hidden="true">
                                                                        <i class="">Pesquisar</i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <hr><br>
                                                            <div class="row">
                                                                <input id="jsonUploadFolha" name="jsonUploadFolha" type="hidden" value="[]">
                                                                <div id="formUploadFolha" class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="table-responsive" style="min-height: 115px;max-height: 159px;width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                        <table id="tableUploadFolha" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th class="text-left" style="min-width: 100%;">Arquivo</th>
                                                                                    <th class="text-left">Tipo</th>
                                                                                    <th class="text-left">Mês referente</th>
                                                                                    <th class="text-left">Data de upload</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <input id="jsonVisualizarFolha" name="jsonVisualizarFolha" type="hidden" value="[]">
                                                                <div id="formVisualizarFolha" class="col col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                                    <div class="table-responsive" style="min-height: 115px;max-height: 159px;width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                        <table id="tableVisualizarFolha" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th class="text-left" style="min-width: 100%;">Arquivo</th>
                                                                                    <th class="text-left" style="min-width: 100%;">Ação</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <input id="jsonPontoMensal" name="jsonPontoMensal" type="hidden" value="[]">
                                                                <div id="formPontoMensal" class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                                    <div class="table-responsive" style="min-height: 115px;max-height: 318px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                        <table id="tablePontoMensal" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th>Dia</th>
                                                                                    <th class="text-left" style="min-width: 100%;">Entrada</th>
                                                                                    <th class="text-left">Almoço - Início</th>
                                                                                    <th class="text-left">Almoço - Saída</th>
                                                                                    <th class="text-left">Saída</th>
                                                                                    <th class="text-left">Extra</th>
                                                                                    <th class="text-left">Atraso</th>
                                                                                    <th class="text-left">Ocorrência</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                            </div>
                                        </div>
                                        <footer>
                                            <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleReabrir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                                <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                    <span id="ui-id-1" class="ui-dialog-title">
                                                    </span>
                                                </div>
                                                <div id="dlgSimpleReabrir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                    <h3 style="font-weight: 500">Insira as pendências:</h3>
                                                    <div class="form-group" id="pendingForm">
                                                        <section class="row">
                                                            <div class="col col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                                                <div style="margin-bottom:10px">
                                                                    <input type="text" class="form-control" name="pendencia" placeholder="Pendência">
                                                                </div>
                                                            </div>
                                                            <div class="col col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                                <button name="btnAddPendencia" type="button" class="btn btn-primary" onclick="addPendency(event)">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button name="btnRemoverPendencia" type="button" class="btn btn-danger" onclick="removePendency(event)">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </section>
                                                    </div>
                                                </div>
                                                <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                    <div class="ui-dialog-buttonset">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- --------------------------------------------- -->
                                            <button type="button" id="btnValidar" class="btn btn-success" aria-hidden="true" title="Validar">
                                                <i class="">Validar</i>
                                            </button>
                                            <button type="button" id="btnReabrir" class="btn btn-warning" aria-hidden="true" title="Reabrir com pendência">
                                                <i class="">Reabrir com pendência</i>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_funcionarioTriagemPontoMensalRecursosHumanos.js" type="text/javascript"></script>
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
    var jsonUploadFolhaArray = JSON.parse($("#jsonUploadFolha").val());
    var jsonVisualizarFolhaArray = JSON.parse($("#jsonVisualizarFolha").val());
    var jsonPontoMensalArray = JSON.parse($("#jsonPontoMensal").val());

    $(document).ready(function() {

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

        $('#dlgSimpleReabrir').dialog({
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
                    $('#dlgSimpleReabrir').css('display', 'none');
                    reabrir()
                    return;
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

        //Eventos

        $("#btnSearch").on('click', () => {
            carregaPagina();
        });

        $("#btnReabrir").on('click', () => {
            $('#dlgSimpleReabrir').dialog('open');
        });

        $("#btnValidar").on('click', () => {
            validar();
        });

        carregaPagina()
    })


    /* Função reponsável por passar os dados para o back-end para a gravação ou reescrita da folha */
    function validar() {
        const codigo = $("#codigo").val();
        validarRH(codigo, function(data) {

            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                    $("#btnValidar").prop('disabled', false);
                    return false;
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                    $("#btnValidar").prop('disabled', false);
                    return false;
                }
            } else {
                var piece = data.split("#");
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                const funcionario = $("#funcionario").val();
                let mesAno = $("#mesAno").val();
                mesAno = mesAno.split("/").reverse().join("-").concat("-01")
                $(location).attr('href', `funcionario_triagemPontoMensalRecursosHumanos.php?funcionario=${funcionario}&mesAno=${mesAno}`);
            }
        });
    }

    function reabrir() {

        const codigo = $("#codigo").val();
        const pendencia = new Array()
        $("[name=pendencia]").each((index,el)=>{
            pendencia.push(el.value)
        })

        if(pendencia.length == 0){
            smartAlert("Atenção","Não há pendências para a reabertura","error")
            return false
        }

        data = {
            codigo,
            pendencia
        }

        reabrirRH(data, function(data) {

            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                    $("#btnReabrir").prop('disabled', false);
                    return false;
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                    $("#btnReabrir").prop('disabled', false);
                    return false;
                }
            } else {
                var piece = data.split("#");
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                const funcionario = $("#funcionario").val();
                let mesAno = $("#mesAno").val();
                mesAno = mesAno.split("/").reverse().join("-").concat("-01")
                $(location).attr('href', `funcionario_triagemPontoMensalRecursosHumanos.php?funcionario=${funcionario}&mesAno=${mesAno}`);
            }
        });
    }

    /*Função reponsável por trazer os dados pessoais e configurações da folha*/
    function carregaPagina() {

        const funcionario = $("#funcionario").val();
        const mesAno = $("#mesAno").val();
        recuperaTriagem(funcionario, mesAno, function(data) {

            data = data.replace(/failed/gi, '');
            let piece = data.split("#");


            let mensagem = piece[0];
            let out = piece[1];
            let JsonPontoMensal = piece[2];
            let JsonUploadFile = piece[3];
            let JsonVisualiza = piece[4];

            $("#jsonPontoMensal").val(JsonPontoMensal);
            $("#jsonUploadFolha").val(JsonUploadFile);
            $("#jsonVisualizarFolha").val(JsonVisualiza);

            jsonUploadFolhaArray = JSON.parse($("#jsonUploadFolha").val());
            jsonVisualizarFolhaArray = JSON.parse($("#jsonVisualizarFolha").val());
            jsonPontoMensalArray = JSON.parse($("#jsonPontoMensal").val());

            piece = out.split("^");

            //funcionando
            let codigo = piece[0] || 0;

            $("#codigo").val(codigo);
            $("#showMesAno").text(mesAno);

            fillTableUploadFolha()
            fillTableVisualizar()
            fillTablePontoMensal()

            return;

        });

    }

    //====================================//
    //====================================//
    function fillTableUploadFolha() {
        $("#tableUploadFolha tbody").empty();
        for (let i = 0; i < jsonUploadFolhaArray.length; i++) {

            const row = $('<tr />');
            $("#tableUploadFolha tbody").append(row);

            const fileName = jsonUploadFolhaArray[i].fileName;
            row.append($('<td class="text-nowrap">' + fileName + '</td>'));

            const uploadType = jsonUploadFolhaArray[i].uploadType;
            row.append($('<td class="text-nowrap">' + uploadType + '</td>'));

            const dataReferente = jsonUploadFolhaArray[i].dataReferente.split("-").reverse().join("/");
            row.append($('<td class="text-nowrap">' + dataReferente + '</td>'));

            const dataUpload = jsonUploadFolhaArray[i].dataUpload.split("-").reverse().join("/");
            row.append($('<td class="text-nowrap">' + dataUpload + '</td>'));
        }
    }

    function fillTableVisualizar() {
        $("#tableVisualizarFolha tbody").empty();
        for (let i = 0; i < jsonVisualizarFolhaArray.length; i++) {

            const row = $('<tr />');
            $("#tableVisualizarFolha tbody").append(row);

            const fileName = jsonVisualizarFolhaArray[i].fileName;
            row.append($('<td class="text-nowrap">' + fileName + '</td>'));


            const path = jsonVisualizarFolhaArray[i].filePath.replaceAll("\\", "\/");
            row.append($('<td class="text-nowrap"><a href="' + path.concat(fileName) + '" target="_blank" rel="noopener noreferrer">Abrir <i class="fa fa-external-link" aria-hidden="true"></i></a></td>'));
        }
    }

    function fillTablePontoMensal() {
        $("#tablePontoMensal tbody").empty();
        for (let i = 0; i < jsonPontoMensalArray.length; i++) {

            const row = $('<tr />');
            $("#tablePontoMensal tbody").append(row);

            const dia = jsonPontoMensalArray[i].dia;
            row.append($('<td class="text-nowrap">' + dia + '</td>'));

            const entrada = jsonPontoMensalArray[i].entrada;
            row.append($('<td class="text-nowrap">' + entrada + '</td>'));

            const inicioAlmoco = jsonPontoMensalArray[i].inicioAlmoco;
            row.append($('<td class="text-nowrap">' + inicioAlmoco + '</td>'));

            const fimAlmoco = jsonPontoMensalArray[i].fimAlmoco;
            row.append($('<td class="text-nowrap">' + fimAlmoco + '</td>'));

            const saida = jsonPontoMensalArray[i].saida;
            row.append($('<td class="text-nowrap">' + saida + '</td>'));

            const extra = jsonPontoMensalArray[i].extra;
            row.append($('<td class="text-nowrap">' + extra + '</td>'));

            const atraso = jsonPontoMensalArray[i].atraso;
            row.append($('<td class="text-nowrap">' + atraso + '</td>'));

            const lancamento = jsonPontoMensalArray[i].lancamento;
            row.append($('<td class="text-nowrap">' + lancamento + '</td>'));
        }
    }

    //===================================//
    //===================================//
    function addPendency(event) {
        event.stopPropagation()
        const row = $("#pendingForm .row")[0].cloneNode(true)
        const parent = event.currentTarget.parentElement.parentElement
        $(row).insertAfter(parent)
        return true
    }

    function removePendency(event) {
        event.stopPropagation()
        const firstBtnRemove = document.getElementsByName("btnRemoverPendencia").item(0)
        const condition = event.currentTarget.isEqualNode(firstBtnRemove)
        const length = document.getElementsByName("btnRemoverPendencia").length
        if(condition && length == 1){
            smartAlert("Atenção","É obrigatório pelo menos uma pendência para que a folha seja reaberta.","warning")
            return false
        }
        const parent = event.currentTarget.parentElement.parentElement
        $(parent).remove()
        return true
    }

</script>