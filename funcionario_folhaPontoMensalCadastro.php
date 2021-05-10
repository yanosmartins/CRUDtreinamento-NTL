<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");

$condicaoMaximaAcessarOK = (in_array('PONTOELETRONICOMENSALMAXIMO_ACESSAR', $arrayPermissao, true));

$condicaoModeradaAcessarOK = (in_array('PONTOELETRONICOMENSALMODERADO_ACESSAR', $arrayPermissao, true));

$condicaoMinimaAcessarOK = (in_array('PONTOELETRONICOMENSALMINIMO_ACESSAR', $arrayPermissao, true));

if (($condicaoMaximaAcessarOK == false) && ($condicaoModeradaAcessarOK == false) && ($condicaoMinimaAcessarOK == false)) {
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


                                                        <div id="formFolhaPontoMensal" class="col-sm-12">
                                                            <input id="codigo" name="codigo" type="hidden" value="0">

                                                            <div class="form-group">

                                                                <div class="row">

                                                                    <section class="col col-4">
                                                                        <label class="label " for="funcionario">Funcionário</label>
                                                                        <label class="select">
                                                                            <select id="funcionario" name="funcionario" class="readonly" readonly style="touch-action:none;pointer-events:none">
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "SELECT F.codigo, F.nome 
                                                                                FROM Ntl.funcionario F 
                                                                                WHERE F.dataDemissaoFuncionario IS NULL 
                                                                                AND F.ativo = 1 
                                                                                ORDER BY F.nome";
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

                                                                    <section class="col col-2">
                                                                        <label class="label" for="mesAno">Mês/Ano</label>
                                                                        <label class="input">
                                                                            <input id="mesAno" name="mesAno" style="text-align: center;" autocomplete="off" type="date" class="readonly" readonly style="pointer-events:none;touch-action:none">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label"> </label>
                                                                        <button type="button" id="btnPdf" class="btn btn-danger" aria-hidden="true">
                                                                            <i class="">Imprimir Folha</i>
                                                                        </button>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="select">
                                                                            <select id="ativo" name="ativo" class="hidden" required>
                                                                                <option value='1' selected>Sim</option>
                                                                            </select>
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <!-- <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong></strong></legend>
                                                                    </section>
                                                                </div> -->

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
                                                                                $funcionario = $row['funcionario'];
                                                                                echo '<option data-funcionario="' . $funcionario . '" value="' . $codigo . '">' . $horaEntrada . " - " . $horaSaida . '</option>';
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
                                                                                $horaFim = $row['horaFim'];
                                                                                $funcionario = $row['funcionario'];
                                                                                echo '<option data-funcionario="' . $funcionario . '" value="' . $codigo . '">' . $horaInicio . " - " . $horaFim . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                </section>
                                                                <section id="sectionStatus" class="col col-2">
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
                                                            </div>

                                                            <div class="row">

                                                                <section class="col col-1">
                                                                    <div class="form-group">
                                                                        <label class="label">Dia</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputDia" name="inputDia" type="text" class="text-center form-control readonly" readonly data-autoclose="true" maxlength="2">
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Entrada</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputHoraEntrada" name="inputHoraEntrada" type="text" class="text-center form-control readonly" placeholder="  00:00:00" data-autoclose="true" data-mask="99:99:99" readonly>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1 sectionAlmoco" style="display: block">
                                                                    <div class="form-group">
                                                                        <label class="label">Inicio/Almoço</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputInicioAlmoco" name="inputInicioAlmoco" type="text" class="text-center form-control 
                                                                            readonly" placeholder="00:00" data-autoclose="true" data-mask="99:99" readonly>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1 sectionAlmoco" style="display: block">
                                                                    <div class="form-group">
                                                                        <label class="label">Fim/Almoço</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputFimAlmoco" name="inputFimAlmoco" type="text" class="text-center form-control 
                                                                            readonly" placeholder="00:00" data-autoclose="true" data-mask="99:99" readonly>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Saída</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputHoraSaida" name="inputHoraSaida" type="text" class="text-center form-control 
                                                                            readonly" placeholder="  00:00:00" data-autoclose="true" data-mask="99:99:99" readonly>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">H.Extra</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputHoraExtra" name="inputHoraExtra" type="text" class="text-center form-control readonly" placeholder="00:00" readonly data-autoclose="true" data-mask="99:99">
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Atraso</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputAtraso" name="inputAtraso" type="text" class="text-center form-control readonly" placeholder="00:00" readonly data-autoclose="true" data-mask="99:99">
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
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

                                                                <section class="col col-4">
                                                                    <label class="label"> </label>
                                                                    </button>
                                                                </section>

                                                                <section class="col col-md-2">
                                                                    <label class="label"> </label>
                                                                    <button id="btnAddPonto" type="button" class="btn btn-primary" disabled>
                                                                        <i class="">Adicionar Ponto</i>
                                                                    </button>
                                                                </section>



                                                                <section class="col col-md-2">
                                                                    <label class=" label"> </label>
                                                                    <button id="btnGravar" type="button" class="btn btn-success" disabled>
                                                                        <i class="">Salvar alterações</i>
                                                                    </button>
                                                                </section>


                                                            </div>

                                                            <hr><br><br>

                                                            <div id="pointFieldGenerator">

                                                            </div>

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
                                        <footer>
                                            <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimplePoint" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                                <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                    <span id="ui-id-2" class="ui-dialog-title">
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

    const defaultDate = new Date();
    const formatedDate = defaultDate.toLocaleDateString('pt-BR');
    const cutout = formatedDate.split('/');
    const maxDay = cutout[0];
    const maxMonth = cutout[1];

    var minDay = '01';
    var minMonth = Number(maxMonth - 1);
    if (minMonth < 1) minMonth = 12;
    if (minMonth < 10) minMonth = '0'.concat(minMonth);

    const minDate = defaultDate.getFullYear() + '-' + minMonth + '-' + minDay;
    const maxDate = defaultDate.getFullYear() + '-' + maxMonth + '-' + maxDay;

    /*---------------/Variaveis e constantes globais-------------*/

    $(document).ready(function() {

        /* Eventos para a chamada da selecionaFolha() */
        $("#funcionario").on("change", function() {
            selecionaFolha();
        });

        $("#mesAno").attr('min', minDate);
        $("#mesAno").attr('max', maxDate);

        $("#mesAno").on("change", function() {
            selecionaFolha();
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

            let index = dia--;

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

        /* Eventos para chamar a gravar() */
        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#btnFechar").on("click", function() {
            fechar();
        });

        // $("#checkAlmoco").on("click", function() {
        //     var check = $(".sectionAlmoco")
        //     check.each((index, el) => {
        //         console.log(typeof el)
        //         console.log($(el))

        //         if ($(el).css('display') != 'block') {

        //             $(el).css('display', 'block')
        //         } else {
        //             $(el).css('display', 'none')
        //         }
        //     })
        // });

        /*Função responsavel pelo carregamento dos dados pessoais e configurações da tela*/
        carregaFolhaPontoMensal();

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

        var mesAno = String($("#mesAno").val()).replace(/\d\d$/g, 01);
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

        options.each((index,el)=>{
            const pattern = /^fechad(o|a)$/gi;
            const texto = $(el).text();
            if(pattern.test(texto)){
                status = $(el).val();
                return;
            } 
        });

        let mesAno = String($("#mesAno").val()).replace(/\d\d$/g, 01);
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
                    const mesAno = $("#mesAno").val();
                    $(location).attr('href', 'funcionario_folhaPontoMensalCadastro.php?funcionario='+funcionario+'mesAno='+mesAno);
                }
            }
        );
    }

    /*Função reponsável por trazer os dados pessoais e configurações da folha*/
    function carregaFolhaPontoMensal() {

        /*Pega a query da URL e separa seus devidos valores*/
        const search = window.location.search.substring(1, window.location.search.length);
        let [getFuncionario, getMesAno] = search.split('&');
        getFuncionario = getFuncionario.substring((getFuncionario.indexOf("=") + 1), getFuncionario.length);
        getMesAno = getMesAno.substring((getMesAno.indexOf("=") + 1), getMesAno.length);

        if (!getFuncionario || !getMesAno) {
            smartAlert("Atenção", "Não foi possível carregar a folha atual", "error");
            return;
        }

        const mesAno = getMesAno;
        const funcionario = getFuncionario;

        $('#funcionario').val(funcionario);
        $('#mesAno').val(mesAno);

        recuperaFolhaPontoMensal(funcionario, mesAno,
            function(data) {

                data = data.replace(/failed/gi, '');
                let piece = data.split("#");

                let mensagem = piece[0];
                let out = piece[1];
                let JsonFolha = piece[2];
                piece = out.split("^");

                //funcionando
                let codigo = piece[0] || 0;
                let funcionario = piece[1];
                let observacao = piece[2] || "";
                let mesAnoFolhaPonto = piece[3];
                toleranciaAtraso = piece[4] || '05:00';
                toleranciaExtra = piece[5] || '05:00';
                let status = piece[6] || 0;

                $("#codigo").val(codigo);
                $("#funcionario").val(funcionario);
                $("#observacaoFolhaPontoMensal").val(observacao);
                $("#mesAno").val(mesAnoFolhaPonto);
                $("#status").val(status);

                //funcionando
                let almoco = $('#almoco option[data-funcionario="' + funcionario + '"]').val();
                $('#almoco').val(almoco);
                let textoAlmoco = $('#almoco option:selected').text().trim();
                textoAlmoco = textoAlmoco.split("-");
                textoAlmoco[0] = textoAlmoco[0].trim();
                textoAlmoco[1] = textoAlmoco[1].trim();

                $("#inputInicioAlmoco").val(textoAlmoco[0]);
                $("#inputFimAlmoco").val(textoAlmoco[1]);

                let expediente = $('#expediente option[data-funcionario="' + funcionario + '"]').val();
                $('#expediente').val(expediente);

                /*Não mexer até a linha 840 ($('#pointFieldGenerator [name=lancamento]').append(options);)*/
                const totalDiasMes = diasMes($("#mesAno").val());
                for (let i = 0; i < totalDiasMes; i++) {
                    generateElements('div', '#pointFieldGenerator', '', '', ['row'], false, '', '', '', false, 'input');
                    $("#pointFieldGenerator").append('<hr/>');
                };

                for (let i = 0; i < 7; i++) {
                    const classList = ['col', 'col-2'];
                    if (/(^0$|^2$|^3$|^5$|^6$)/.test(i)) {
                        classList.pop();
                        classList.push('col-1');
                    }
                    generateElements('section', '#pointFieldGenerator .row', '', '', classList, false, '', '', '', false, 'input');
                }

                generateElements('div', '#pointFieldGenerator .row .col', '', '', ['form-group'], false, '', '', '', false, 'input');
                generateElements('label', '#pointFieldGenerator .row .col .form-group', '', '', ['label'], false, '', '--', '', false, 'input');
                generateElements('div', '#pointFieldGenerator .row .col .form-group', '', '', ['input-group'], false, '', '', 'top', true, 'input');
                generateInputElements('#pointFieldGenerator .row .col .form-group .input-group', '', '', ['text-center', 'form-control', 'readonly'], 'text', true, '', '', true);

                costumizeElements('#pointFieldGenerator .row .col .form-group[data-group=input] .label', [{
                    text: 'Dia'
                }, {
                    text: 'Entrada'
                }, {
                    text: 'Inicio/Almoco'
                }, {
                    text: 'Fim/Almoço'
                }, {
                    text: 'Saída'
                }, {
                    text: 'H.Extra'
                }, {
                    text: 'Atraso'
                }]);

                costumizeElements('#pointFieldGenerator .row .col .form-group .input-group input', [{
                    name: 'dia'
                }, {
                    name: 'horaEntrada'
                }, {
                    name: 'inicioAlmoco'
                }, {
                    name: 'fimAlmoco'
                }, {
                    name: 'horaSaida'
                }, {
                    name: 'extra'
                }, {
                    name: 'atraso'
                }]);

                generateElements('section', '#pointFieldGenerator .row', '', '', ['col', 'col-2'], false, '', '', '', false, 'select');
                generateElements('label', '#pointFieldGenerator .row .col[data-group=select]', '', '', ['label'], false, 'lancamento', 'Lançamento', '', false, 'select');
                generateElements('label', '#pointFieldGenerator .row .col[data-group=select]', '', '', ['select'], false, '', '', '', false, 'select');
                generateSelectElements('#pointFieldGenerator .row [data-group=select] .select', '', 'lancamento', ['readonly'], true, 'pointer-events:none;touch-action:none', '', '0', '', false, '-1');

                const options = $('#inputLancamento').children('option').clone(true);
                $('#pointFieldGenerator [name=lancamento]').append(options);

                /*Daqui para baixo pode mexer*/
                preencherPonto(JsonFolha);

                getPermissions();

                return;

            }
        );

    }

    function selecionaFolha() {

        const funcionario = $("#funcionario option:selected").val();
        const mesAno = $("#mesAno").val();

        recuperaFolhaPontoMensal(funcionario, mesAno,
            function(data) {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                //Atributos de Cliente
                var mensagem = piece[0];
                var out = piece[1];
                var JsonFolha = piece[2];

                piece = out.split("^");

                var codigo = +piece[0];
                var funcionario = piece[1];
                var observacao = piece[2];
                var mesAnoFolhaPonto = piece[3];
                toleranciaAtraso = piece[4] || '05:00';
                toleranciaExtra = piece[5] || '05:00';
                var status = piece[6];

                $("#codigo").val(codigo) || 0;
                $("#funcionario").val(funcionario);
                $("#observacaoFolhaPontoMensal").val(observacao) || "";
                $("#mesAno").val(mesAnoFolhaPonto);
                $("#status").val(status) || 0;

                let almoco = $('#almoco option[data-funcionario="' + funcionario + '"]').val();
                $('#almoco').val(almoco);
                let textoAlmoco = $('#almoco option:selected').text().trim();
                textoAlmoco = textoAlmoco.split("-");
                textoAlmoco[0] = textoAlmoco[0].trim();
                textoAlmoco[1] = textoAlmoco[1].trim();

                $("#inputInicioAlmoco").val(textoAlmoco[0]);
                $("#inputFimAlmoco").val(textoAlmoco[1]);

                let expediente = $('#expediente option[data-funcionario="' + funcionario + '"]').val();
                $('#expediente').val(expediente);

                /*Não mexer até a linha 955 ($('#pointFieldGenerator [name=lancamento]').append(options);)*/
                deleteElements('#pointFieldGenerator .row');
                deleteElements('#pointFieldGenerator hr');

                const totalDiasMes = diasMes($("#mesAno").val());
                for (let i = 0; i < totalDiasMes; i++) {
                    generateElements('div', '#pointFieldGenerator', '', '', ['row'], false, '', '', '', false, 'input');
                    $("#pointFieldGenerator").append('<hr/>');
                };


                for (let i = 0; i < 7; i++) {
                    const classList = ['col', 'col-2'];
                    if (/(^0$|^2$|^3$|^5$|^6$)/.test(i)) {
                        classList.pop();
                        classList.push('col-1');
                    }
                    generateElements('section', '#pointFieldGenerator .row', '', '', classList, false, '', '', '', false, 'input');
                }

                generateElements('div', '#pointFieldGenerator .row .col', '', '', ['form-group'], false, '', '', '', false, 'input');
                generateElements('label', '#pointFieldGenerator .row .col .form-group', '', '', ['label'], false, '', '--', '', false, 'input');
                generateElements('div', '#pointFieldGenerator .row .col .form-group', '', '', ['input-group'], false, '', '', 'top', true, 'input');
                generateInputElements('#pointFieldGenerator .row .col .form-group .input-group', '', '', ['text-center', 'form-control', 'readonly'], 'text', true, '', '', true);

                costumizeElements('#pointFieldGenerator .row .col .form-group[data-group=input] .label', [{
                    text: 'Dia'
                }, {
                    text: 'Entrada'
                }, {
                    text: 'Inicio/Almoco'
                }, {
                    text: 'Fim/Almoço'
                }, {
                    text: 'Saída'
                }, {
                    text: 'H.Extra'
                }, {
                    text: 'Atraso'
                }]);

                costumizeElements('#pointFieldGenerator .row .col .form-group .input-group input', [{
                    name: 'dia'
                }, {
                    name: 'horaEntrada'
                }, {
                    name: 'inicioAlmoco'
                }, {
                    name: 'fimAlmoco'
                }, {
                    name: 'horaSaida'
                }, {
                    name: 'extra'
                }, {
                    name: 'atraso'
                }]);

                generateElements('section', '#pointFieldGenerator .row', '', '', ['col', 'col-2'], false, '', '', '', false, 'select');
                generateElements('label', '#pointFieldGenerator .row .col[data-group=select]', '', '', ['label'], false, 'lancamento', 'Lançamento', '', false, 'select');
                generateElements('label', '#pointFieldGenerator .row .col[data-group=select]', '', '', ['select'], false, '', '', '', false, 'select');
                generateSelectElements('#pointFieldGenerator .row [data-group=select] .select', '', 'lancamento', ['readonly'], true, 'pointer-events:none;touch-action:none', '', '0', '', false, '-1');

                const options = $('#inputLancamento').children('option').clone(true);
                $('#pointFieldGenerator [name=lancamento]').append(options);

                /*Daqui para baixo pode mexer*/
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

        const mesAno = $('#mesAno').val();
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
            object.forEach((obj, index) => {
                dia.push(obj.dia);
                entrada.push(obj.entrada);
                inicioAlmoco.push(obj.inicioAlmoco);
                fimAlmoco.push(obj.fimAlmoco);
                saida.push(obj.saida);
                extra.push(obj.horaExtra);
                atraso.push(obj.atraso);
                lancamento.push(obj.lancamento);
            })

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
        let [hora, minuto] = horario.split(':').map(v => parseInt(v));
        if (!minuto) { // para o caso de não ter os minutos
            minuto = 00;
        }
        return minuto + (hora * 60);
    }

    function duracao(inicioExpediente, fimExpediente) {
        return (parse(fimExpediente) - parse(inicioExpediente));
    }

    function imprimir() {
        const id = $('#funcionario').val();
        const folha = $('#codigo').val();
        const mesAno = $('#mesAno').val();

        $(location).attr('href', `funcionario_folhaDePontoPdfPontoEletronico.php?id=${id}&folha=${folha}&data=${mesAno}`);
    }

    function generateElements(element = 'div', elementParent = 'body', id = '', name = '', classList, readOnly = false, forName = '', content = '', dataAlign = '', dataAutoclose = false, dataGroup = '') {
        pattern = /(^br$)/g

        if (!pattern.test(element)) {
            element = `<${element} [id=] [class=] [name=] [readonly=] [for=] [data-group=] [data-align=] [data-autoclose=] >[Content]</${element}>`;
        } else {
            element = `<${element} [id=] [class=] [name=] [readonly=] [for=] [data-group=] [data-align=] [data-autoclose=] />`;
        }

        if (id)
            element = element.replace("[id=]", `id="${id}"`);
        else
            element = element.replace("[id=]", "");

        if (name)
            element = element.replace("[name=]", `name="${name}"`);
        else
            element = element.replace("[name=]", "");

        if (classList)
            element = element.replace("[class=]", `class="${classList.join(' ')}"`);
        else
            element = element.replace("[class=]", "");

        if (readOnly)
            element = element.replace("[readonly=]", "readonly");
        else
            element = element.replace("[readonly=]", "");

        if (forName)
            element = element.replace("[for=]", `for="${forName}"`);
        else
            element = element.replace("[for=]", "");

        if (content)
            element = element.replace("[Content]", `${content}`);
        else
            element = element.replace("[Content]", "");

        if (dataAlign)
            element = element.replace("[data-align=]", `data-align="${dataAlign}"`);
        else
            element = element.replace("[data-align=]", "");

        if (dataAutoclose)
            element = element.replace("[data-autoclose=]", `data-autoclose="${dataAutoclose}"`);
        else
            element = element.replace("[data-autoclose=]", "");

        if (dataGroup)
            element = element.replace("[data-group=]", `data-group="${dataGroup}"`);
        else
            element = element.replace("[data-group=]", "");

        $(elementParent).append(element);
        return
    }

    function generateInputElements(elementParent = 'body', id = '', name = '', classList, type = '', readOnly = false, placeHolder = '', value = '', dataAlign = '', dataAutoclose = false) {

        element = `<input [id=] [class=] [name=] [readonly=] [type=] [placeholder=] [value=] [data-align=] [data-autoclose=] />`;

        if (id)
            element = element.replace("[id=]", `id="${id}"`);
        else
            element = element.replace("[id=]", "");

        if (name)
            element = element.replace("[name=]", `name="${name}"`);
        else
            element = element.replace("[name=]", "");

        if (classList)
            element = element.replace("[class=]", `class="${classList.join(' ')}"`);
        else
            element = element.replace("[class=]", "");

        if (readOnly)
            element = element.replace("[readonly=]", "readonly");
        else
            element = element.replace("[readonly=]", "");

        if (type)
            element = element.replace("[type=]", `type="${type}"`);
        else
            element = element.replace("[type=]", "");

        if (placeHolder)
            element = element.replace("[placeholder=]", `placeholder="${placeHolder}"`);
        else
            element = element.replace("[placeholder=]", "");

        if (value)
            element = element.replace("[value=]", `value="${value}"`);
        else
            element = element.replace("[value=]", "");

        if (dataAlign)
            element = element.replace("[data-align=]", `data-align="${dataAlign}"`);
        else
            element = element.replace("[data-align=]", "");

        if (dataAutoclose)
            element = element.replace("[data-autoclose=]", `data-autoclose="${dataAutoclose}"`);
        else
            element = element.replace("[data-autoclose=]", "");

        $(elementParent).append(element);
        return
    }

    function generateSelectElements(elementParent = 'body', id = '', name = '', classList, readOnly = false, style = '', placeHolder = '', value = '', dataAlign = '', dataAutoclose = false, tabIndex = '') {

        element = `<select [id=] [class=] [name=] [readonly=] [style=] [placeholder=] [value=] [data-align=] [data-autoclose=] [tabindex=]></select>`;

        if (id)
            element = element.replace("[id=]", `id="${id}"`);
        else
            element = element.replace("[id=]", "");

        if (name)
            element = element.replace("[name=]", `name="${name}"`);
        else
            element = element.replace("[name=]", "");

        if (classList)
            element = element.replace("[class=]", `class="${classList.join(' ')}"`);
        else
            element = element.replace("[class=]", "");

        if (readOnly)
            element = element.replace("[readonly=]", "readonly");
        else
            element = element.replace("[readonly=]", "");

        if (style)
            element = element.replace("[style=]", `style="${style}"`);
        else
            element = element.replace("[style=]", "");

        if (placeHolder)
            element = element.replace("[placeholder=]", `placeholder="${placeHolder}"`);
        else
            element = element.replace("[placeholder=]", "");

        if (value)
            element = element.replace("[value=]", `value="${value}"`);
        else
            element = element.replace("[value=]", "");

        if (dataAlign)
            element = element.replace("[data-align=]", `data-align="${dataAlign}"`);
        else
            element = element.replace("[data-align=]", "");

        if (dataAutoclose)
            element = element.replace("[data-autoclose=]", `data-autoclose="${dataAutoclose}"`);
        else
            element = element.replace("[data-autoclose=]", "");

        if (tabIndex)
            element = element.replace("[tabindex=]", `tabindex="${tabIndex}"`);
        else
            element = element.replace("[tabindex=]", "");

        $(elementParent).append(element);
        return
    }

    function deleteElements(element) {
        $(element).remove();
        return;
    }

    function costumizeElements(element = '', data = {
        text: '',
        name: ''
    }) {
        pattern = /^\#/

        if (pattern.test(element) && element.indexOf(' ') < 0) {
            $(element).text(data.text);
            $(element).attr(data.name);
        } else {
            let i;
            $(element).each((index, el) => {
                if (!data[i]) i = 0;
                if (data[i].text)
                    $(el).text(data[i].text);
                if (data[i].name)
                    $(el).attr('name', data[i].name);
                i++;

            })
        }
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

        let mesAno = $("#mesAno").val();
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

        var dia = $("#inputDia").val();

        if (!dia) {
            smartAlert("Atenção", "Insira um dia válido", "error");
            return;
        }

        var index = dia--;

        var entrada = $("#pointFieldGenerator [name=horaEntrada]")[index]
        var inputEntrada = $("#inputHoraEntrada").val() || '00:00:00'

        var inicioAlmoco = $("#pointFieldGenerator [name=inicioAlmoco]")[index]
        var inputInicioAlmoco = $("#inputInicioAlmoco").val() || '00:00:00'

        var fimAlmoco = $("#pointFieldGenerator [name=fimAlmoco]")[index]
        var inputFimAlmoco = $("#inputFimAlmoco").val() || '00:00:00'

        var saida = $("#pointFieldGenerator [name=horaSaida]")[index]
        var inputSaida = $("#inputHoraSaida").val() || '00:00:00'

        var extra = $("#pointFieldGenerator [name=extra]")[index]
        var inputExtra = $("#inputHoraExtra").val()

        var atraso = $("#pointFieldGenerator [name=atraso]")[index]
        var inputAtraso = $("#inputAtraso").val()

        var lancamento = $("#pointFieldGenerator select[name=lancamento]")[index]

        var inputLancamento = $("#inputLancamento").val()


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

        const inicioExpediente = separador[0];
        const fimExpediente = separador[1];

        const horaEntrada = aleatorizarTempo(inputEntrada, inicioExpediente);
        const horaSaida = aleatorizarTempo(inputSaida, fimExpediente)



        //Começo Cálculo de Hora Extra
        if (horaSaida != "00:00:00") {
            const parseHoraEntrada = parse(horaEntrada)
            const parseHoraSaida = parse(horaSaida)
            const parseHoraInicio = parse(inicioExpediente)
            const parseHoraFim = parse(fimExpediente)

            let jornadaModerada = duracao(inicioExpediente, fimExpediente);

            // quantidade de minutos efetivamente trabalhados
            let jornada = duracao(horaEntrada, horaSaida);

            // diferença entre as jornadas
            let diff = Math.abs(jornada - jornadaModerada);

            if (diff != 0) {
                let horas = Math.floor(diff / 60);
                let minutos = diff - (horas * 60);

                if (horas.toString().length < 2) horas = `0${horas}`;
                if (minutos.toString().length < 2) minutos = `0${minutos}`;

                if (jornada > jornadaModerada) {
                    inputExtra = (`${horas}:${minutos}`);
                } else {
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
            smartAlert("Atenção", "A HORA DE ENTRADA deve ser preenchida", "error");
            return
        }

        if (!inputExtra && horaSaida != "00:00:00") {
            smartAlert("Aviso", "O funcionário não tem horas extras", "info");
        }
        if (!inputAtraso && horaSaida != "00:00:00") {
            smartAlert("Aviso", "O funcionário não tem atrasos", "info");
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

            if (permissao == 'PONTOELETRONICOMENSALMAXIMO') {
                $("#funcionario").attr('readonly', obj[permissao].funcionario.readonly);
                $("#funcionario").removeAttr('style');
                if (!obj[permissao].funcionario.class)
                    $("#funcionario").removeClass('readonly');
                $("#funcionario").css('pointer-events', obj[permissao].funcionario.pointerEvents);
                $("#funcionario").css('touch-action', obj[permissao].funcionario.touchAction);

                $("#mesAno").attr('readonly', obj[permissao].mesAno.readonly);
                $("#mesAno").removeAttr('style');
                if (!obj[permissao].mesAno.class)
                    $("#mesAno").removeClass('readonly');

                $("#status").attr('readonly', obj[permissao].status.readonly);
                $("#status").removeAttr('style');
                if (!obj[permissao].status.class) {
                    $("#status").removeClass('readonly');
                }
                $("#sectionStatus").css('display', obj[permissao].status.display);
                $("#status").css('pointer-events', obj[permissao].status.pointerEvents);
                $("#status").css('touch-action', obj[permissao].status.touchAction);

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
                break;
            } else if (permissao == 'PONTOELETRONICOMENSALMODERADO') {
                $("#funcionario").attr('readonly', obj[permissao].funcionario.readonly);
                $("#funcionario").removeAttr('style');
                if (!obj[permissao].funcionario.class) {
                    $("#funcionario").removeClass('readonly');
                }
                $("#funcionario").css('pointer-events', obj[permissao].funcionario.pointerEvents);
                $("#funcionario").css('touch-action', obj[permissao].funcionario.touchAction);

                $("#mesAno").attr('readonly', obj[permissao].mesAno.readonly);
                $("#mesAno").removeAttr('style');
                if (!obj[permissao].mesAno.class)
                    $("#mesAno").removeClass('readonly');


                let status = $("#status option:selected").text();
                const pattern = /^fechad(o|a)$/gi;
                const condition = pattern.test(status);
                if (!condition) {
                    $("#status").attr('readonly', obj[permissao].status.readonly);
                    $("#status").removeAttr('style');
                    if (!obj[permissao].status.class) {
                        $("#status").removeClass('readonly');
                    }
                    $("#sectionStatus").css('display', obj[permissao].status.display);
                    $("#status").css('pointer-events', obj[permissao].status.pointerEvents);
                    $("#status").css('touch-action', obj[permissao].status.touchAction);

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
                    $("#status").attr('readonly', true);
                    $("#status").removeAttr('style');
                    if (!$("#status").hasClass('readonly')) {
                        $("#status").addClass('readonly');
                    }
                    $("#sectionStatus").css('display', 'none');
                    $("#status").css('pointer-events', 'none');
                    $("#status").css('touch-action', 'none');

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
                $("#funcionario").attr('readonly', obj[permissao].funcionario.readonly);
                $("#funcionario").removeAttr('style');
                if (!obj[permissao].funcionario.class)
                    $("#funcionario").removeClass('readonly');
                $("#funcionario").css('pointer-events', obj[permissao].funcionario.pointerEvents);
                $("#funcionario").css('touch-action', obj[permissao].funcionario.touchAction);

                $("#mesAno").attr('readonly', obj[permissao].mesAno.readonly);
                $("#mesAno").removeAttr('style');
                if (!obj[permissao].mesAno.class)
                    $("#mesAno").removeClass('readonly');


                let status = $("#status option:selected").text();
                const pattern = /^fechad(o|a)$/gi
                const condition = pattern.test(status);
                if (!condition) {
                    $("#status").attr('readonly', obj[permissao].status.readonly);
                    $("#status").removeAttr('style');
                    if (!obj[permissao].status.class) {
                        $("#status").removeClass('readonly');
                    }
                    $("#sectionStatus").css('display', obj[permissao].status.display);
                    $("#status").css('pointer-events', obj[permissao].status.pointerEvents);
                    $("#status").css('touch-action', obj[permissao].status.touchAction);


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
                    $("#status").attr('readonly', true);
                    $("#status").removeAttr('style');
                    if (!$("#status").hasClass('readonly')) {
                        $("#status").addClass('readonly');
                    }
                    $("#sectionStatus").css('display', 'none');
                    $("#status").css('pointer-events', 'none');
                    $("#status").css('touch-action', 'none');

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
</script>