<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('FERIAS_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('FERIAS_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('FERIAS_EXCLUIR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Férias";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]["beneficio"]["sub"]["ferias"]["active"] = true;

include("inc/nav.php");
include_once("populaTabela/popula.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Departamento Pessoal"] = "";
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
                            <h2>Férias</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuario" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseRegistraFerias" class="" id="accordionRegistraFerias">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Registrar Férias
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseRegistraFerias" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden" value="">

                                                        <div class="row">
                                                            <input id="codigo" name="codigo" type="text" readonly class="hidden" value="">
                                                            <section class="col col-3">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo, descricao from Ntl.projeto where ativo = 1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4 ">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $codigo = +$row['codigo'];
                                                                            $nome = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');

                                                                            echo '<option value=' . $codigo . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="mesAno">Mês/Ano Referência</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesAno" name="mesAno" autocomplete="off" data-mask="99/9999" data-mask-placeholder="mm/aaaa" data-dateformat="mm/yy" placeholder="mm/aaaa" type="text" class="datepicker required" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="adiantaDecimoTerceiro">Adiantamento do 13º</label>
                                                                <label class="select">
                                                                    <select id="adiantaDecimoTerceiro" name="adiantaDecimoTerceiro" class="required">
                                                                        <option value="">Selecione</option>
                                                                        <option value="0">Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="abono">Tem Abono?</label>
                                                                <label class="select">
                                                                    <select id="abono" name="abono" class="required">
                                                                        <option value="">Selecione</option>
                                                                        <option value="0">Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="dataInicio">Data de Início</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataInicio" name="dataInicio" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker required" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" for="quantidadeDias">Dias</label>
                                                                <label class="select">
                                                                    <select id="quantidadeDias" name="quantidadeDias" class="required">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataFim">Data Fim </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataFim" name="dataFim" autocomplete="on" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="readonly" readonly value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" for="dataFim">Dias Uteis</label>
                                                                <label class="input">
                                                                    <i class=""></i>
                                                                    <input id="diaUtil" name="diaUtil" autocomplete="" type="text" class="readonly" readonly value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" for="diasDescontar">Dias de Feriado</label>
                                                                <label class="input">
                                                                    <i class=""></i>
                                                                    <input id="diasDescontar" name="diasDescontar" autocomplete="" type="text" class="readonly" readonly value="">
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="mesAnoInicio">Mês/Ano Início</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesAnoInicio" name="mesAnoInicio" autocomplete="off" data-mask="99/9999" data-mask-placeholder="mm/aaaa" data-dateformat="mm/yy" placeholder="mm/aaaa" type="text" class="datepicker readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="mesAnoFim">Mês/Ano Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesAnoFim" name="mesAnoFim" autocomplete="off" data-mask="99/9999" data-mask-placeholder="mm/aaaa" data-dateformat="mm/yy" placeholder="mm/aaaa" type="text" class="datepicker readonly" readonly value="">
                                                                </label>
                                                            </section>

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <footer>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?= $esconderBtnExcluir ?>">
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
                                        <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?= $esconderBtnGravar ?>">
                                            <span class="fa fa-floppy-o"></span>
                                        </button>
                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?= $esconderBtnGravar ?>">
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

<script src="<?php echo ASSETS_URL; ?>/js/business_beneficioFerias.js" type="text/javascript"></script>

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


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        //Aplicando máscaras
        // {placeholder: ""}
        $('#cpf').mask('999.999.999-99', {
            placeholder: "X"
        });
        $('#matricula').mask('?9999999999999999999999999999999999999999999999999999999999999999', {
            placeholder: ""
        });
        $('#pisPasep').mask('999.999999.99-99', {
            placeholder: "X"
        });
        $('#numero').mask('9999999', {
            placeholder: "X"
        });
        $('#serie').mask('9999', {
            placeholder: "X"
        });
        $('#uf').mask('aa', {
            placeholder: "X"
        });
        $('#cep').mask('999999-999', {
            placeholder: "X"
        });
        $('#estado').mask('aa', {
            placeholder: "X"
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

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#mesAno").on("change", function() {
            var mesAno = $("#mesAno").val();
            var mesAnoSeparado = mesAno.split("/");
            var mes = mesAnoSeparado[0];

            if (mes > 13) {
                smartAlert("Atenção", "Mês inválido!", "error");
                $("#mesAno").val("");
                return;
            }

        });

        $("#dataInicio").on("change", function() {
            validaCampoData("#dataInicio");

            var dataInicio = $("#dataInicio").val();

            if (dataInicio === "") {
                smartAlert("Atenção", "Escolha uma Data de Inicio!", "error");
                return;;

            } else {
                var quantidadeDias = $("#quantidadeDias").val();
                dataFim = moment(dataInicio, "DD-MM-YYYY").add((quantidadeDias || 1) - 1, 'days')
                dataFim = dataFim.format("DD/MM/YYYY");
                $("#dataFim").val(dataFim);

                preencheMesAno(0);
                contarFeriado();
            }
        });

        $("#quantidadeDias").on("change", function() {
            var dataInicio = $("#dataInicio").val();

            if (dataInicio === "") {
                smartAlert("Atenção", "Escolha uma Data de Inicio!", "error");
                $("#quantidadeDias").val(quantidadeDias);
                return;

            } else {

                var quantidadeDias = $("#quantidadeDias").val();

                dataFim = moment(dataInicio, "DD-MM-YYYY").add((quantidadeDias || 1) - 1, 'days')
                // dataFim = moment(dataFim, "DD-MM-YYYY").subtract(1, 'days')
                dataFim = dataFim.format("DD/MM/YYYY");
                $("#dataFim").val(dataFim);
                preencheMesAno(1)
                contarFeriado();
            }

        });

        //calcular dias uteis das ferias
        $("#dataInicio").on("change", function() {
            contaDiasuteis()
        });
        $("#quantidadeDias").on("change", function() {
            contaDiasuteis()
        });
        $("#projeto").on("change", function() {
            popularComboFuncionario()
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
                recuperaFerias(idd,
                    function(data) {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        var out = piece[1];

                        piece = out.split("^");
                        var codigo = +piece[0];
                        var ativo = piece[1];
                        var abono = piece[2];
                        var funcionario = piece[3];
                        var mesAno = piece[4];
                        var dataInicio = piece[5];
                        var dataFim = piece[6];
                        var quantidadeDias = piece[7];
                        var adiantaDecimoTerceiro = piece[8];
                        var diaUtil = piece[9];
                        var projeto = +piece[10];
                        var diaFeriado = +piece[11];

                        $("#codigo").val(codigo);
                        $("#ativo").val(ativo);
                        $("#abono").val(abono);
                        $("#funcionario").val(funcionario);
                        $("#mesAno").val(mesAno);
                        $("#dataInicio").val(dataInicio);
                        $("#dataFim").val(dataFim);
                        $("#quantidadeDias").val(quantidadeDias);
                        $("#adiantaDecimoTerceiro").val(adiantaDecimoTerceiro);
                        $("#verificaRecuperacao").val(1);
                        $("#diaUtil").val(diaUtil);
                        $("#projeto").val(projeto);
                        $("#diasDescontar").val(diaFeriado);
                        preencheMesAno(0)
                        preencheMesAno(1)

                    })
            }
        }
    }

    // Função que verifica se um campo é valido ou não. 
    function validaCampoData(campo) {
        var valor = $(campo).val();
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js

        if (validacao === false) {
            $(campo).val("");
        }
    }

    function novo() {
        $(location).attr('href', 'beneficio_feriasCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'beneficio_feriasFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();
        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }
        excluirFerias(id,
            function(data) {
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
            }
        );
    }

    function preencheMesAno(verificador) {
        switch (verificador) {
            case 0: // Data Inicio
                var dataFim = $("#dataFim").val()
                dataFim = dataFim.split("/");
                anoFim = dataFim[2];
                mesFim = dataFim[1];
                $("#mesAnoFim").val(mesFim + "/" + anoFim)
                var dataInicio = $("#dataInicio").val()
                dataInicio = dataInicio.split("/");
                anoInicio = dataInicio[2];
                mesInicio = dataInicio[1];
                $("#mesAnoInicio").val(mesInicio + "/" + anoInicio)
                break;
            case 1: //Qunatidade de Dias
                var dataFim = $("#dataFim").val()
                dataFim = dataFim.split("/");
                anoFim = dataFim[2];
                mesFim = dataFim[1];
                $("#mesAnoFim").val(mesFim + "/" + anoFim)
                break;
            default:
                break;
        }

    }



    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);
        setTimeout(() => {
            $("#btnGravar").prop('disabled', false);
        }, 4)

        //Dados 
        var id = +$("#codigo").val();
        var abono = +$("#abono").val();
        var funcionario = +$("#funcionario").val();
        var mesAno = $("#mesAno").val();
        var dataInicio = $("#dataInicio").val();
        var dataFim = $("#dataFim").val();
        var quantidadeDias = +$("#quantidadeDias").val();
        var adiantaDecimoTerceiro = +$("#adiantaDecimoTerceiro").val();
        var mesAnoInicio = $("#mesAnoInicio").val();
        var mesAnoFim = $("#mesAnoFim").val();
        var diaUtil = $("#diaUtil").val();
        var projeto = +$("#projeto").val();
        var diaFeriado = +$("#diasDescontar").val();

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (mesAno === "" || mesAno === " ") {
            smartAlert("Atenção", "Informe o Mês/Ano de Referência", "error");
            return;
        }

        if (projeto === "" || projeto === " ") {
            smartAlert("Atenção", "Informe o Projeto", "error");
            return;
        }

        if (funcionario === "" || funcionario === " ") {
            smartAlert("Atenção", "Informe o Funcionário", "error");
            return;
        }

        if (dataInicio === "" || dataInicio === " ") {
            smartAlert("Atenção", "Informe a Data de Início", "error");
            return;
        }

        if (quantidadeDias === "" || quantidadeDias === " ") {
            smartAlert("Atenção", "Informe os Dias", "error");
            return;
        }

        if (adiantaDecimoTerceiro === "" || adiantaDecimoTerceiro === " ") {
            smartAlert("Atenção", "Informe Adianta de Décimo Terceiro", "error");
            return;
        }

        if (abono === "" || abono === " ") {
            smartAlert("Atenção", "Informe o Abono", "error");
            return;
        }

        gravaFerias(id, abono, funcionario, mesAno, dataInicio, dataFim, quantidadeDias, adiantaDecimoTerceiro, mesAnoInicio, mesAnoFim, diaUtil, projeto, diaFeriado,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                    }
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

    function contaDiasuteis() {

        var dataInicio = $("#dataInicio").val();
        var dataFim = $("#dataFim").val();
        var diaUtil = 0;
        // Atributos de dias úteis do projeto que serão recuperados: 
        // se o 1 dia for sabado ou domingo não contam. 
        var dataInicioAux = dataInicio
        var dataInicioAux = dataInicioAux.split("/");
        var dataInicioAux = dataInicioAux[2] + "/" + dataInicioAux[1] + "/" + dataInicioAux[0];
        var testeFinalDeSemanaAux = new Date(dataInicioAux);
        testeFinalDeSemanaAux = testeFinalDeSemanaAux.getDay();

        diaUtil = moment(dataInicio, 'DD/MM/YYYY').businessDiff(moment(dataFim, 'DD/MM/YYYY'));
        if (diaUtil < 0) diaUtil *= -1;

        // + 1 Para contar também o primeiro dia das férias.
        if (testeFinalDeSemanaAux != 0 && testeFinalDeSemanaAux != 6) {
            diaUtil++;
        }
        $("#diaUtil").val(diaUtil);
        return;
    }

    function contarFeriado() {
        //Dados 
        var id = +$("#codigo").val();
        var abono = +$("#abono").val();
        var funcionario = +$("#funcionario").val();
        if (!funcionario) {
            smartAlert("Atenção", "Informe o Funcionário", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        var mesAno = $("#mesAno").val();
        var dataInicio = $("#dataInicio").val();
        var dataFim = $("#dataFim").val();
        var quantidadeDias = +$("#quantidadeDias").val();
        var adiantaDecimoTerceiro = +$("#adiantaDecimoTerceiro").val();
        var mesAnoInicio = $("#mesAnoInicio").val();
        var mesAnoFim = $("#mesAnoFim").val();
        var diaUtil = $("#diaUtil").val();

        contaFeriado(funcionario, mesAno, dataInicio, dataFim, quantidadeDias, adiantaDecimoTerceiro, mesAnoInicio, mesAnoFim, diaUtil,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "Erro ao calcular os dias úiteis!", "error");
                        $("#btnGravar").prop('disabled', false);
                    }
                } else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];
                    piece = out.split("^");

                    var contadorFeriado = +piece[0];

                    $("#diasDescontar").val(contadorFeriado);

                    var diaUtil = $("#diaUtil").val();
                    var diasDescontar = $("#diasDescontar").val();
                    diaUtil -= diasDescontar;

                    if (diaUtil < 0)

                        diautil = 0
                    $("#diaUtil").val(diaUtil);
                }
            }
        );
    }

    function popularComboFuncionario() {
        var projeto = $("#projeto").val()
        if (projeto != 0) {
            populaComboFuncionario(projeto,
                function(data) {
                    var atributoId = '#' + 'funcionario';
                    if (data.indexOf('failed') > -1) {
                        smartAlert("Aviso", "O Projeto informado não possui funcionários cadastrados em (Vínculos e Benefícios)!", "info");
                        $("#projeto").focus()
                        $("#funcionario").val("")
                        $("#funcionario").prop("disabled", true)
                        $("#funcionario").addClass("readonly")
                        return;
                    } else {
                        $("#funcionario").prop("disabled", false)
                        $("#funcionario").removeClass("readonly")
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");

                        var mensagem = piece[0];
                        var qtdRegs = piece[1];
                        var arrayRegistros = piece[2].split("|");
                        var registro = "";

                        $(atributoId).html('');
                        $(atributoId).append('<option></option>');

                        for (var i = 0; i < qtdRegs; i++) {
                            registro = arrayRegistros[i].split("^");
                            $(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
                        }
                    }
                }
            );
        }
    }
</script>