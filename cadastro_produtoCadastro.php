<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PRODUTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PRODUTO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('PRODUTO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Produto";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["produto"]["active"] = true;

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
                            <h2>Produto</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formProdutoCadastro" method="post" enctype="multipart/form-data">
                                    <input id="codigo" name="codigo" type="text" readonly class="hidden" />

                                    <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden">
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
                                                    <input id="JsonIdade" name="JsonIdade" type="hidden" value="[]">

                                                    <fieldset>

                                                        <div class="row">

                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="produto">Descrição</label>
                                                                <label class="input">
                                                                    <input id="produto" maxlength="50" name="produto" class="required" value="" placeholder="" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="transporteUnitario"> Convênio de Saúde</label>
                                                                <label class="select">
                                                                    <select id="convenioSaude" name="convenioSaude" class="required" required>
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select CS.codigo, CS.apelido  from Ntl.convenioSaude CS where ativo = 1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = +$row['codigo'];
                                                                            $descricao = mb_convert_encoding($row['apelido'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Mês Aniversário</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="mesAniversario" name="mesAniversario" class="required">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Cobrança</label>
                                                                <label class="select">
                                                                    <select id="cobranca" name="cobranca" class="required" required>
                                                                        <option style="display:none"></option>
                                                                        <option value="F">Fixo</option>
                                                                        <option value="I">Por idade</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="seguroVida">Seguro de Vida</label>
                                                                <label class="select">
                                                                    <select id="seguroDeVida" name="seguroDeVida" class="required">
                                                                        <option style="display:none"></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <div class="row">
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label">Valor do Produto</label>
                                                                    <label class="input"><i class="icon-append fa fa-dollar"></i>
                                                                        <input type="text" id="valorProduto" name="valorProduto" class="required decimal-2-casas readonly" autocomplete="off" disabled />
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2 col-auto">
                                                                    <label class="label" for="seguroVida">Ativo</label>
                                                                    <label class="select">
                                                                        <select id="ativo" name="ativo" class="required">
                                                                            <option value="1">Sim</option>
                                                                            <option value="0">Não</option>

                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Percentual Desconto em Folha</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="descontoFolha" name="descontoFolha" class="required decimal-2-casas" type="text" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Valor Desconto em Folha</label>
                                                                <label class="input"><i class="icon-append fa fa-dollar"></i>
                                                                    <input id="valorDescontoFolha" name="valorDescontoFolha" class="decimal-2-casas required" type="text" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">

                                                            <fieldset id="formIdade">
                                                                <div class="row">
                                                                    <input id="produtoIdadeId" name="produtoIdadeId" type="hidden" value="">
                                                                    <input id="sequencialIdade" name="sequencialIdade" type="hidden" value="">
                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Idade Inicial</label>
                                                                        <label class="input">
                                                                            <input type="text" maxlenght="3" id="idadeInicial" name="idadeInicial" maxlength="2" autocomplete="off" class="required numeric readonly" disabled />
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Idade Final</label>
                                                                        <label class="input">
                                                                            <input type="text" maxlength="3" id="idadeFinal" name="idadeFinal" maxlength="3" autocomplete="off" class="required numeric readonly" disabled />
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Valor do Produto</label>
                                                                        <label class="input"><i class="icon-append fa fa-dollar"></i>
                                                                            <input type="text" maxlength="10" id="valorIdade" name="valorIdade" autocomplete="off" class="required decimal-2-casas readonly" disabled />
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-12">

                                                                        <button id="btnAddIdadeProduto" type="button" class="btn btn-primary" title="Adicionar idade">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverIdadeProduto" type="button" class="btn btn-danger" title="Remover idade">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                                <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableIdadeProduto" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
                                                                                <th class="text-left" style="min-width: 10px;">Idade Inicial</th>
                                                                                <th class="text-left" style="min-width: 10px;">Idade Final</th>
                                                                                <th class="text-left" style="min-width: 10px;">Valor</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </fieldset>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroProduto.js" type="text/javascript"></script>


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
    jsonIdadeArray = JSON.parse($("#JsonIdade").val());

    $(document).ready(function() {

        fillTableIdade();



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

        $('.dinheiro').mask('#.##9,99', {
            reverse: true
        });

        $("#descontoVr").keyup(function() {
            //Obter o primeiro caractere digitado
            var temp = $(this).val().charAt(0);
            //Verificar se o primeiro caractere inserido é '-'
            if (temp == '-') {
                //Aplica a máscara para números negativos
                $("#edtPercentual").mask("-99,99%");
            }
            //Verificar se o primeiro caractere inserido é número
            else if (temp.charAt(0).match(/\d/)) {
                //Aplica a máscara para números positivos
                $("#descontoVr").mask("99,99%");
            }
            //Caso o primeiro caractere inserido seja um caractere inválido limpa o value do campo
            else {
                $("#descontoVr").val('');
            }
        });

        $('#btnAddIdadeProduto').on("click", function() {
            if (validaIdade() === true) {
                addIdade();
                $("#idadeInicial").focus()
            } else {
                $("#idadeInicial").focus()
            }
        });

        $('#btnRemoverIdadeProduto').on("click", function() {
            excluirIdade();
        });

        carregaPagina();

        $('#cobranca').on("change", function() {
            verificaCobranca()
        });
        $('#descontoFolha').on("change", function() {
            $("#valorDescontoFolha").val('');
        });
        $('#valorDescontoFolha').on("change", function() {
            $("#descontoFolha").val('');
        });

    });

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        verificaCobranca();
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaProduto(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var arrayIdadeProduto = piece[2];
                            var outValorIdade = piece[3];

                            //CADASTRO
                            piece = out.split("^");
                            var codigo = +piece[0];
                            var produtoSaude = piece[1];
                            var convenioSaude = +piece[2];
                            var mesAniversario = piece[3];
                            var cobranca = piece[4];
                            var seguroDeVida = +piece[5];
                            var valorProduto = floatToString(piece[6]);
                            var descontoFolha = floatToString(piece[7]);
                            var ativo = +piece[8];
                            var valorDescontoFolha = piece[9];


                            $("#codigo").val(codigo);
                            $("#convenioSaude").val(convenioSaude);
                            $("#produto").val(produtoSaude);
                            $("#cobranca").val(cobranca);
                            $("#mesAniversario").val(mesAniversario);
                            $("#seguroDeVida").val(seguroDeVida);
                            $("#valorProduto").val(valorProduto);
                            $("#descontoFolha").val(descontoFolha);
                            $("#ativo").val(ativo);
                            $("#verificaRecuperacao").val(1);
                            $("#valorDescontoFolha").val(valorDescontoFolha);
                            $("#valorIdade").val(outValorIdade);
                            verificaCobranca();

                            $("#JsonIdade").val(arrayIdadeProduto);
                            jsonIdadeArray = JSON.parse($("#JsonIdade").val());
                            fillTableIdade();
                            initializeDecimalBehaviour();




                            return;
                        }
                    }

                );

            }
        }

    }

    function novo() {
        $(location).attr('href', 'cadastro_produtoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_produtoFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }
        excluirProduto(id,
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
        // $("#btnGravar").prop('disabled', true);

        var id = +$("#codigo").val();
        var ativo = +$("#ativo").val();
        var convenioSaude = $("#convenioSaude").val();
        var produto = $("#produto").val().trim().replace(/'/g, " ");
        var mesAniversario = $("#mesAniversario").val();
        var cobranca = $("#cobranca").val();
        var seguroDeVida = $('#seguroDeVida').val();
        var valorProduto = $('#valorProduto').val().replace(/'/g, " ");
        var descontoFolha = $('#descontoFolha').val().replace(/'/g, " ");
        var jsonIdade = $("#JsonIdade").val();
        var valorDescontoFolha = $("#valorDescontoFolha").val();



        if (!produto) {
            smartAlert("Atenção", "Informe a Descrição", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!convenioSaude) {
            smartAlert("Atenção", "Informe o Convênio de Saúde", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!mesAniversario) {
            smartAlert("Atenção", "Informe o Mês de Aniversário", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!cobranca) {
            smartAlert("Atenção", "Informe a Cobrança", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!seguroDeVida) {
            smartAlert("Atenção", "Informe o Seguro de Vida", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (cobranca == 'F') {

            if (!valorProduto || valorProduto == '0,00') {
                smartAlert("Atenção", "Informe o valor do Produto", "error");
                $("#btnGravar").prop('disabled', false);
                $("#valorProduto").val('');
                return;
            }


        } else {
            if (jsonIdadeArray == 0) {

                smartAlert("Atenção", "Informe uma Idade", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }

        }

        gravaProduto(id, ativo, convenioSaude, produto, mesAniversario, cobranca, seguroDeVida,
            valorProduto, descontoFolha, jsonIdade, valorDescontoFolha,
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

    function validaIdade() {
        var existe = false;
        var achou = false;
        var idadeInicial = $('#idadeInicial').val();
        var idadeFinal = $('#idadeFinal').val();
        var valorIdade = $('#valorIdade').val();
        var sequencial = +$('#sequencialIdade').val();
        if (!idadeInicial) {
            smartAlert("Atenção", "Informe a idade inicial", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!idadeFinal) {
            smartAlert("Atenção", "Informe a idade Final", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (idadeFinal < idadeInicial) {
            smartAlert("Atenção", "A Idade Inicial não pode ser maior do que a Final", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (idadeFinal > 120) {
            smartAlert("Atenção", "A Idade Final não pode ser maior do que 120 anos", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (valorIdade == '0,00') {

            smartAlert("Atenção", "Informe o Valor", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        return true;
    }

    // Função que preenche as tabelas com os valores dos formulários
    function fillTableIdade() {

        $("#tableIdadeProduto tbody").empty();
        for (var i = 0; i < jsonIdadeArray.length; i++) {
            var row = $('<tr />');
            $("#tableIdadeProduto tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonIdadeArray[i].sequencialIdade + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaIdade(' + jsonIdadeArray[i].sequencialIdade + ');">' + jsonIdadeArray[i].idadeInicial + '</td>'));
            row.append($('<td class="text-nowrap"> ' + jsonIdadeArray[i].idadeFinal + '</td>'));
            row.append($('<td class="text-nowrap"> R$ ' + roundDecimal(floatToString(jsonIdadeArray[i].valorIdade), 2) + '</td>'));

        }
    }

    function carregaIdade(sequencialIdade) {
        var arr = jQuery.grep(jsonIdadeArray, function(item, i) {
            return (item.sequencialIdade === sequencialIdade);
        });
        clearFormIdade();
        if (arr.length > 0) {
            var item = arr[0];
            $("#produtoIdadeId").val(item.idadeId);
            $("#idadeInicial").val(item.idadeInicial);
            $("#idadeFinal").val(item.idadeFinal);
            $("#valorIdade").val(roundDecimal(floatToString(item.valorIdade), 2));
            $("#sequencialIdade").val(item.sequencialIdade);
        }
    }

    function clearFormIdade() {
        $("#produtoIdadeId").val('');
        $("#sequencialIdade").val('');
        $("#idadeInicial").val('');
        $("#idadeFinal").val('');
        $("#valorIdade").val('');
    }

    function addIdade() {

        var item = $("#formIdade").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processData
        });
        if (item["sequencialIdade"] === '') {
            if (jsonIdadeArray.length === 0) {
                item["sequencialIdade"] = 1;
            } else {
                item["sequencialIdade"] = Math.max.apply(Math, jsonIdadeArray.map(function(o) {
                    return o.sequencialIdade;
                })) + 1;
            }
            item["produtoIdadeId"] = 0;
        } else {
            item["sequencialIdade"] = +item["sequencialIdade"];
        }
        var index = -1;
        $.each(jsonIdadeArray, function(i, obj) {
            if (+$('#sequencialIdade').val() === obj.sequencialIdade) {
                index = i;
                return false;
            }
        });
        if (index >= 0)
            jsonIdadeArray.splice(index, 3, item);
        else
            jsonIdadeArray.push(item);
        $("#JsonIdade").val(JSON.stringify(jsonIdadeArray));
        fillTableIdade();
        clearFormIdade();
    }

    function processData(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        //Retorna o valor correto do valor unitário
        if ((fieldName !== '') && (fieldId === "valorIdade")) {
            var value = $("#" + fieldId).val();
            return {
                name: fieldName,
                value: parseFloat(value.toString().replace(".", "").replace(",", "."))
            };
        }
        return false;
    }


    function excluirIdade() {
        var arrSequencial = [];
        $('#tableIdadeProduto input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonIdadeArray.length - 1; i >= 0; i--) {
                var obj = jsonIdadeArray[i];
                if (jQuery.inArray(obj.sequencialIdade, arrSequencial) > -1) {
                    jsonIdadeArray.splice(i, 1);
                }
            }
            $("#JsonIdade").val(JSON.stringify(jsonIdadeArray));
            fillTableIdade();
        } else {
            smartAlert("Erro", "Selecione pelo menos 1 produto por idade para excluir.", "error");
        }
    }

    function excluirTodaIdade() {
        var arrSequencial = [];
        $('#tableIdadeProduto input').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonIdadeArray.length - 1; i >= 0; i--) {
                var obj = jsonIdadeArray[i];
                if (jQuery.inArray(obj.sequencialIdade, arrSequencial) > -1) {
                    jsonIdadeArray.splice(i, 1);
                }
            }
            $("#JsonIdade").val(JSON.stringify(jsonIdadeArray));
            fillTableIdade();
        } else {
            smartAlert("Erro", "Selecione pelo menos 1 produto por idade para excluir.", "error");
        }
    }

    function verificaCobranca() {
        if ($("#cobranca").val() === 'F') {
            $("#valorProduto").removeAttr('disabled');
            $("#valorProduto").removeClass('readonly');
            $("#valorProduto").addClass('required');
            $("#idadeInicial").removeClass('required');
            $("#idadeInicial").prop('disabled', true);
            $("#idadeInicial").addClass('readonly');
            $("#idadeInicial").val('');

            $("#idadeFinal").removeClass('required');
            $("#idadeFinal").prop('disabled', true);
            $("#idadeFinal").addClass('readonly');
            $("#idadeFinal").val('');
            $("#valorIdade").removeClass('required');
            $("#valorIdade").prop('disabled', true);
            $("#valorIdade").addClass('readonly');
            $("#valorIdade").val('');

            $("#btnAddIdadeProduto").prop('disabled', true);
            $("#btnAddIdadeProduto").addClass('readonly');
            $("#btnRemoverIdadeProduto").prop('disabled', true);
            $("#btnRemoverIdadeProduto").addClass('readonly');

            $("#JsonIdade").val('');
            jsonIdadeArray = [];
            fillTableIdade();
        } else if ($("#cobranca").val() === 'I') {

            $("#valorProduto").removeClass('required');
            $("#valorProduto").prop('disabled', true);
            $("#valorProduto").addClass('readonly');
            $("#valorProduto").val('');

            $("#idadeInicial").removeAttr('disabled');
            $("#idadeInicial").removeClass('readonly');
            $("#idadeInicial").addClass('required');

            $("#idadeFinal").removeAttr('disabled');
            $("#idadeFinal").removeClass('readonly');
            $("#idadeFinal").addClass('required');

            $("#valorIdade").removeAttr('disabled');
            $("#valorIdade").removeClass('readonly');
            $("#valorIdade").addClass('required');

            $("#btnAddIdadeProduto").prop('disabled', false);
            $("#btnRemoverIdadeProduto").prop('disabled', false);
        } else {

            $("#valorProduto").removeClass('required');
            $("#valorProduto").prop('disabled', true);
            $("#valorProduto").addClass('readonly');
            $("#valorProduto").val('');

            $("#btnAddIdadeProduto").prop('disabled', true);
            $("#btnAddIdadeProduto").addClass('readonly');
            $("#btnRemoverIdadeProduto").prop('disabled', true);
            $("#btnRemoverIdadeProduto").addClass('readonly');
        }
    }
</script>