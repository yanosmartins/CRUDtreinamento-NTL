<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$funcionario = $_SESSION["funcionario"];

$condicaoAcessarOK = (in_array('TRIAGEMPONTOELETRONICOMENSALGESTOR_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('TRIAGEMPONTOELETRONICOMENSALGESTOR_GRAVAR', $arrayPermissao, true));

$condicaoAcessarOK = true;

if (($condicaoAcessarOK == false)) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Triagem ponto mensal";
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
                                                        Dados do Mês <span id="showMesAno"><?= date("m/Y") ?></span>
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
                                                                                echo "<option value=\"$codigo\">$nome</option>";
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2 col-auto">
                                                                    <label for="mesAno" class="label">Mês/Ano</label>
                                                                    <label class="input">
                                                                        <input id="mesAno" name="mesAno" type="text" data-dateformat="mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/9999" data-mask-placeholder="-" autocomplete="off">
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
                                                                    <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
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
                                                                    <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
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

                                                                    <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
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
                                                <div id="dlgSimplePoint" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                    <p>Insira as pendências.</p>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_funcionarioTriagemPontoMensalGestor.js" type="text/javascript"></script>
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
                    $('#dlgSimplePoint').css('display', 'none');
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
            $('#dlgSimplePoint').dialog('open');
        });

        $("#btnValidar").on('click', () => {
            validar();
        });

        carregaPagina()
    })


    /* Função reponsável por passar os dados para o back-end para a gravação ou reescrita da folha */
    function validar() {

        validarGestor(function(data) {

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
                const funcionario = $("#funcionariio").val();
                let mesAno = $("#mesAno").val();
                mesAno = mesAno.split("/").reverse().join("-")
                $(location).attr('href', `funcionario_triagemPontoMensalGestor?funcionario=${funcionario}&mesAno=${mesAno}.php`);
            }
        });
    }

    /*Função reponsável por trazer os dados pessoais e configurações da folha*/
    function carregaPagina() {

        recuperaTriagem(function(data) {

            data = data.replace(/failed/gi, '');
            let piece = data.split("#");


            let mensagem = piece[0];
            let out = piece[1];
            let JsonPontoMensal = piece[2];
            let JsonUploadFile = piece[3];
            let JsonVisualiza

            piece = out.split("^");

            //funcionando
            let codigo = piece[0] || 0;
            const funcionario = piece[1] || 0
            let mesAno = piece[2] || new Date().toDateString();

            $("#codigo").val(codigo);
            $("#funcionario").val(funcionario);
            $("#mesAno").val(mesAno);

            return;

        });

    }

    function atualizaPagina() {
        const funcionario = $("#funcionario").val()

        let mesAno = $("#mesAno").val()
        mesAno = mesAno.split("/").reverse().join("-")

        atualizaTriagem(funcionario, mesAno, function(data) {

            data = data.replace(/failed/gi, '');
            let piece = data.split("#");


            let mensagem = piece[0];
            let out = piece[1];
            let JsonPontoMensal = piece[2];
            let JsonUploadFile = piece[3];
            let JsonVisualiza

            piece = out.split("^");

            //funcionando
            let codigo = piece[0] || 0;
            const funcionario = piece[1] || 0
            let mesAno = piece[2] || new Date().toDateString();

            $("#codigo").val(codigo);
            $("#funcionario").val(funcionario);
            $("#mesAno").val(mesAno);

            return;

        });

    }

    //====================================//
    //====================================//
    function fillTableUploadFolha() {
        $("#tableUploadFolha tbody").empty();
        for (var i = 0; i < jsonUploadFolhaArray.length; i++) {

            var row = $('<tr />');
            $("#tableUploadFolha tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonUploadFolhaArray[i].sequencialUploadFolha + '"><i></i></label></td>'));

            var fileUploadFolha = jsonUploadFolhaArray[i].fileUploadFolha;

            row.append($('<td class="text-nowrap" onclick="carregaUploadFolha(' + jsonUploadFolhaArray[i].sequencialUploadFolha + ');">' + fileUploadFolha.name + '</td>'));

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

        if (dataReferenteUpload) {
            for (obj of jsonUploadFolhaArray) {
                if (dataReferenteUpload == obj.dataReferenteUpload) {
                    smartAlert("Erro", "Não é possível inserir dois documentos da mesma data no sistema!", "error");
                    return false;
                }
            }
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
                    sequencialUploadFolha: obj.sequencialUploadFolha,
                    fileUploadFolha: files[index]
                })
            })

            jsonUploadFolhaArray = jsonUploadFolha
            fillTableUploadFolha()
        })
    }
</script>