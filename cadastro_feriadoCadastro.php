<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('FERIADO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('FERIADO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('FERIADO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Feriado";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["feriado"]["active"] = true;

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
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Feriado</h2>
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
                                                        <input id="verificaDiaSemana" name="verificaDiaSemana" type="text" readonly class="hidden" value="">
                                                        <input type="hidden" id="codigo" name="codigo">
                                                        <div class="row">
                                                            <section class="col col-6 col-auto">
                                                                <label class="label">Descrição</label>
                                                                <label class="input">
                                                                    <input id="descricao" name="nome" class="required" type="text" value="" autocomplete="off" maxlength="50">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Data</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataFeriado" name="dataFeriado" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker required" value="" onchange="validaData(this)">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Tipo de Feriado</label>
                                                                <label class="select">
                                                                    <select id="tipoFeriado" name="tipoferiado" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.tipoFeriado where ativo = 1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $id = (int) $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>


                                                            <section class="col col-2 col-auto" id='sectionUFFeriado'>
                                                                <label class="label" for="uf">UF</label>
                                                                <label class="select">
                                                                    <select id="unidadeFederacao" name="unidadeFederacao" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {

                                                                            $sigla = $row['sigla'];
                                                                            echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>



                                                            <section class="col col-2" id="sectionLocalFeriado">
                                                                <label class="label" for="municipio">Município</label>
                                                                <label class="select">
                                                                    <select id="municipio" name="municipio" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.municipio where ativo = 1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $id = (int) $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>


                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Dia da Semana</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="diaSemana" name="diaSemana" class="readonly" readonly>
                                                                </label>
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
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleData" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-2" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleData" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <p>ESTA DATA JÁ ESTÁ CADASTRADA NO BANCO.
                                                    DESEJA CONTINUAR MESMO ASSIM?
                                                </p>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroFeriado.js" type="text/javascript"></script>


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


        $('#tipoFeriado').change(function() {
            var tipoFeriado = +$('#tipoFeriado').val();

            validaTipoFeriado(tipoFeriado);

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

        $('#dlgSimpleData').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "Atenção",
            buttons: [{
                html: "Continuar cadastro",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $("#dataFeriado").val("");
                    $(this).dialog("close");
                }
            }]
        });


        $("#btnExcluir").on("click", function() {
            var id = parseInt($("#codigo").val());

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
            gravar();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#unidadeFederacao").on("change", function() {

            var id = $("#unidadeFederacao").val();
            var tipoFeriado = $("#tipoFeriado").val();

            if (tipoFeriado == 2) {
                populaComboMunicipio(id,
                    function(data) {
                        var atributoId = '#' + 'municipio';
                        if (data.indexOf('failed') > -1) {

                            smartAlert("Atenção", "A UF informada não possui Município cadastrado no Sistema!", "info");
                            $(atributoId).append('');
                            $("#municipio").empty();
                            $("#unidadeFederacao").focus();
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");

                            // var mensagem = piece[0].split(",");
                            var arrayRegistro = piece[2].split("|");
                            var qtdRegs = piece[1];
                            // var arrayRegistros = piece[2].split(",");
                            var registro = "";

                            $(atributoId).html('');
                            $(atributoId).append('<option></option>');

                            for (var i = 0; i < qtdRegs; i++) {
                                registro = arrayRegistro[i].split("^");
                                $(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
                            }
                        }
                    }
                );
            }

        });

        $("#dataFeriado").on("change", function() {
            preencheDiaSemana()
            if (dataFeriado != "dd/mm/aaaa") {
                var idd = dataFeriado;
                pesquisaData(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            if (data != "") {
                                $('#dlgSimpleData').dialog('open');
                            }
                            return;

                        }
                    });
            }

        });



        carregaPagina();

    });

    function carregaPagina() {

        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        var verificaRecupera = 0;
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFeriado(idd,
                    function(data) {
                        // data = feriado.replace(/failed/g, '');
                        // Atributos de Feriado que serão recuperados: 
                        let codigo = data.codigo;
                        let ativo = data.ativo;
                        let descricao = data.descricao;
                        let dataFeriado = new Date(data.data);

                        let municipio = data.codigoMunicipio;
                        let municipioDescricao = data.municipio;
                        let unidadeFederacao = data.unidadeFederacao;
                        //            let unidadeFederacaoDescricao = feriado.unidadeFederacaoDescricao;
                        let tipoFeriado = data.tipoFeriado;


                        //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                        $("#codigo").val(codigo);
                        $("#ativo").val(ativo);
                        $("#descricao").val(descricao);
                        $("#dataFeriado").datepicker("setDate", dataFeriado);
                        verficaDiaDaSemana()
                        preencheDiaSemana()

                        $("#unidadeFederacao").val(unidadeFederacao);
                        $("#tipoFeriado").val(tipoFeriado);
                        $("#municipio").val(municipio);
                        $("#verificaRecuperacao").val(1);

                        let optionMunicipio = new Option(municipioDescricao, municipio, true, true);
                        $("#municipio").val(municipioDescricao);
                        $("#municipio").append(optionMunicipio);

                        if (unidadeFederacao == "") {
                            habilitaDesabilitaUf(0);
                            habilitaDesabilitaMunicipio(0);
                        } else if (municipio == "") {
                            habilitaDesabilitaUf(1);
                            habilitaDesabilitaMunicipio(0);
                        }

                        var verificaRecupera = 1;
                    })
            }

        }

        if (verificaRecupera != 1) {
            validaTipoFeriado(0);
        }


    }

    function novo() {
        $(location).attr('href', 'cadastro_feriadoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_feriadoFiltro.php');
    }

    function excluir() {
        var id = parseInt($("#codigo").val());

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFeriado(id,
            function(data) {
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
            }
        );
    }

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        var id = +$("#codigo").val();
        var ativo = +$("#ativo").val();
        var descricao = $("#descricao").val().trim().replace(/'/g, " ");
        var data = $("#dataFeriado").val();
        var tipoFeriado = +$("#tipoFeriado").val();
        var unidadeFederacao = $("#unidadeFederacao").val().trim();
        var municipio = +$("#municipio").val();
        diaDaSemana = verficaDiaDaSemana();


        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!descricao) {
            smartAlert("Atenção", "Informe a Descrição", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!data) {
            smartAlert("Atenção", "Informe a Data", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!tipoFeriado) {
            smartAlert("Atenção", "Informe o Tipo do Feriado", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (tipoFeriado === 1) {
            if (!unidadeFederacao) {
                smartAlert("Atenção", "Informe a Unidade Federativa", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }
        }

        if (tipoFeriado === 2) {
            if (!unidadeFederacao) {
                smartAlert("Atenção", "Informe a Unidade Federativa", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }

            if (!municipio) {
                smartAlert("Atenção", "Informe o Município", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }
        }


        gravaFeriado(id, ativo, descricao, data, tipoFeriado, unidadeFederacao, municipio, diaDaSemana,
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

    function validaTipoFeriado(tipoFeriado) {
        if (tipoFeriado === 1) {
            habilitaDesabilitaUf(1);
            habilitaDesabilitaMunicipio(0);
        }
        if (tipoFeriado === 2) {
            habilitaDesabilitaUf(1);
            habilitaDesabilitaMunicipio(1);
        }
        if (tipoFeriado === 3) {
            habilitaDesabilitaUf(0);
            habilitaDesabilitaMunicipio(0);
        }
        if (tipoFeriado === 0) {
            habilitaDesabilitaUf(0);
            habilitaDesabilitaMunicipio(0);
        }

    }

    function habilitaDesabilitaUf(habilita) {
        if (habilita === 0) {
            $("#unidadeFederacao").val('');
            $("#unidadeFederacao").prop('disabled', true);
            $("#unidadeFederacao").addClass('readonly');
        }

        if (habilita === 1) {
            $("#unidadeFederacao").removeAttr('disabled');
            $("#unidadeFederacao").removeClass('readonly');
        }
    }

    function habilitaDesabilitaMunicipio(habilita) {
        if (habilita === 0) {
            $("#municipio").val('');
            $("#municipio").prop('disabled', true);
            $("#municipio").addClass('readonly');
        }

        if (habilita === 1) {
            //$("#convenio").val('');
            $("#municipio").removeAttr('disabled');
            $("#municipio").removeClass('readonly');
        }
    }

    function validaData(valor) {
        var valor = valor;
        var date = $(valor).val();
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
            smartAlert("Erro", "Data incorreta.", "error");
            $(valor).val('');
            return false;
        }
        return true;
    }

    function verficaDiaDaSemana() {
        var data = $("#dataFeriado").val()
        var dataAjustada = data.split("/");
        var dataAux = dataAjustada[2] + "/" + dataAjustada[1] + "/" + dataAjustada[0];
        var diaDaSemana = moment(dataAux).format('LLLL');
        diaDaSemana = diaDaSemana.split(",");
        diaDaSemana = diaDaSemana[0];
        diaDaSemana = diaDaSemana.toString();

        return diaDaSemana;
    }

    function preencheDiaSemana() {
        var dataFeriado = $("#dataFeriado").val();
        var dataAux = verficaDiaDaSemana();
        if (dataAux == "Sunday") {
            dataAux = "Domingo"
        } else if (dataAux == "Monday") {
            dataAux = "Segunda-Feira"
        } else if (dataAux == "Tuesday") {
            dataAux = "Terça-Feira"
        } else if (dataAux == "Wednesday") {
            dataAux = "Quarta-Feira"
        } else if (dataAux == "Thursday") {
            dataAux = "Quinta-Feira"
        } else if (dataAux == "Friday") {
            dataAux = "Sexta-Feira"
        } else {
            dataAux = "Sábado"
        }

        $("#diaSemana").val(dataAux);

    }
</script>