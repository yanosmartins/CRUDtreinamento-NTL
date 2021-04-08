<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('CODIGOITEM_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CODIGOITEM_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CODIGOITEM_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Lançamentos";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['estoque']['sub']['cadastro']['sub']['codigoItem']["active"] = true;

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
                            <h2>Lançamento</h2>
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
                                                        <div class="row">
                                                            <input id="codigo" name="codigo" type="text" class="hidden" value="">
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="codigoItem">Código</label>
                                                                <label class="input">
                                                                    <input id="codigoItem" name="codigoItem" type="text" class="required" maxlength="50" required autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="codigoFabricante">Código Fabricante</label>
                                                                <label class="input">
                                                                    <input id="codigoFabricante" name="codigoFabricante" type="text" class="" maxlength="50"  autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-5 col-auto">
                                                                <label class="label" for="descricaoItem">Descrição do item</label>
                                                                <label class="input">
                                                                    <input id="descricaoItem" name="descricaoItem" type="text" class="required" maxlength="255" required autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="indicador">Indicador</label>
                                                                <label class="input">
                                                                    <input id="indicador" name="indicador" type="text" class="" maxlength="5" autocomplete="off">
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="localizacaoItem">Unidade</label>
                                                                <label class="select">
                                                                    <select id="unidade" name="unidade" class="required">
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM Ntl.unidade WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="estoque">Estoque</label>
                                                                <label class="select">
                                                                    <select id="estoque" name="estoque" class="required readonly" required disabled>
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM Estoque.estoque WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="grupoItem">Grupo item</label>
                                                                <label class="select">
                                                                    <select id="grupoItem" name="grupoItem" class="required readonly" required disabled>
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM Estoque.grupoItem WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="localizacaoItem">Localização do item</label>
                                                                <label class="select">
                                                                    <select id="localizacaoItem" name="localizacaoItem" class="required" required>
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, localizacaoItem FROM Estoque.localizacaoItem WHERE ativo = 1 ORDER BY localizacaoItem";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['localizacaoItem'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="grupoItem">Unidade Medida</label>
                                                                <label class="select">
                                                                    <select id="unidadeItem" name="unidadeItem" class="required">
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao, sigla FROM Estoque.unidadeItem WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['sigla'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="ativo">Consumivel</label>
                                                                <label class="select">
                                                                    <select id="consumivel" name="consumivel" class="required">
                                                                        <option></option>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="ativo">Assinatura retirada</label>
                                                                <label class="select">
                                                                    <select id="autorizacao" name="autorizacao" class="required">
                                                                        <option></option>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required" required>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroCodigoItem.js" type="text/javascript"></script>

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
            var id = $("#codigo").val();

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
            gravar()
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#estoque").on("change", function() {
            popularComboGrupoItem()
        });
        $("#unidade").on("change", function() {
            popularComboEstoque()
        });

        carregaPagina();
    });

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaCodigoItem(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            piece = out.split("^");

                            // Atributos de vale transporte unitário que serão recuperados: 
                            var codigo = +piece[0];
                            var codigoItem = piece[1];
                            var codigoFabricante = piece[2];
                            var descricaoItem = piece[3];
                            var estoque = piece[4];
                            var grupoItem = piece[5];
                            var localizacaoItem = piece[6];
                            var unidade = piece[7];
                            var indicador = piece[8];
                            var ativo = piece[9];
                            var unidadeItem = piece[10];
                            var consumivel = piece[11];
                            var autorizacao = piece[12];

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#codigoItem").val(codigoItem);
                            $("#codigoFabricante").val(codigoFabricante);
                            $("#descricaoItem").val(descricaoItem);

                            $("#estoque").val(estoque);
                            popularComboGrupoItem();
                            $("#grupoItem").val(grupoItem);
                            $("#localizacaoItem").val(localizacaoItem);
                            $("#unidade").val(unidade);
                            $("#indicador").val(indicador);
                            $("#ativo").val(ativo);
                            $("#unidadeItem").val(unidadeItem);
                            $("#consumivel").val(consumivel);
                            $("#autorizacao").val(autorizacao);

                            return;
                        }
                    }
                );
            }
        }
    }

    function novo() {
        $(location).attr('href', 'cadastro_codigoItemCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_codigoItemFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirCodigoItem(id,
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

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        var id = +$('#codigo').val();
        var codigoItem = $('#codigoItem').val();
        var codigoFabricante = $('#codigoFabricante').val();
        var descricaoItem = $('#descricaoItem').val();
        var estoque = $('#estoque').val();
        var grupoItem = $('#grupoItem').val();
        var localizacaoItem = $('#localizacaoItem').val();
        var ativo = +$('#ativo').val();
        var unidade = +$('#unidade').val();
        var indicador = $('#indicador').val();
        var unidadeItem = +$('#unidadeItem').val();
        var consumivel = $('#consumivel').val();
        var autorizacao = $('#autorizacao').val();


        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!codigoItem) {
            smartAlert("Atenção", "Informe codigo do item", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        // if (!codigoFabricante) {
        //     smartAlert("Atenção", "Informe codigo do fabricante", "error");
        //     $("#btnGravar").prop('disabled', false);
        //     return;
        // }

        if (!descricaoItem) {
            smartAlert("Atenção", "Informe a descricao do item", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!unidade) {
            smartAlert("Atenção", "Informe a unidade", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!estoque) {
            smartAlert("Atenção", "Informe o estoque", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!grupoItem) {
            smartAlert("Atenção", "Informe o grupo", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!localizacaoItem) {
            smartAlert("Atenção", "Informe a localizacao", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!unidadeItem) {
            smartAlert("Atenção", "Informe a Unidade Medida", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!consumivel) {
            smartAlert("Atenção", "Informe se o item é consumivel", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!autorizacao) {
            smartAlert("Atenção", "Informe se o item precisa de assinatura", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }



        //Chama a função de gravar do business de convênio de saúde.
        gravaCodigoItem(id, codigoItem, codigoFabricante, descricaoItem, estoque, grupoItem, localizacaoItem, ativo, unidade, 
                        indicador, unidadeItem, consumivel, autorizacao,
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
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    novo();
                }
            }
        );
    }

    function popularComboGrupoItem() {
        var estoque = $("#estoque").val()
        if (estoque != 0) {
            populaComboGrupoItem(estoque,
                function(data) {
                    var atributoId = '#' + 'grupoItem';
                    if (data.indexOf('failed') > -1) {
                        smartAlert("Aviso", "O estoque informado não possui grupos!", "info");
                        $("#estoque").focus()
                        $("#grupoItem").val("")
                        $("#grupoItem").prop("disabled", true)
                        $("#grupoItem").addClass("readonly")
                        return;
                    } else {
                        $("#grupoItem").prop("disabled", false)
                        $("#grupoItem").removeClass("readonly")
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

    function popularComboEstoque() {
        var unidade = +$("#unidade").val()
        $("#grupoItem").val("")
        $("#grupoItem").prop("disabled", true)
        $("#grupoItem").addClass("readonly")
        if (unidade != 0) {
            populaComboEstoque(unidade,
                function(data) {
                    var atributoId = '#' + 'estoque';
                    if (data.indexOf('failed') > -1) {
                        smartAlert("Aviso", "A unidade informada não possui estoques!", "info");
                        $("#unidade").focus()
                        $("#estoque").val("")
                        $("#estoque").prop("disabled", true)
                        $("#estoque").addClass("readonly")
                        return;
                    } else {
                        $("#estoque").prop("disabled", false)
                        $("#estoque").removeClass("readonly")
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