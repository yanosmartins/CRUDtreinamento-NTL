<?php
//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('VALETRANSPORTEMODAL_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('VALETRANSPORTEMODAL_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('VALETRANSPORTEMODAL_EXCLUIR', $arrayPermissao, true));

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
$page_title = "Vale Transporte Modal";
/* ---------------- END PHP Custom Scripts ------------- */
//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["valeTransporteModal"]["active"] = true;
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
                            <h2>Vale Transporte Modal</h2>
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
                                                    <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden" value="">

                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Informações do Modal</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <input id="codigo" name="codigo" type="text" class="hidden" value="">

                                                            <section class="col col-6 col-auto">
                                                                <label class="label" for="descricao">Descrição</label>
                                                                <label class="input">
                                                                    <input id="descricao" name="descricao" type="text" maxlength="50" autocomplete="off" class="required" required>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required" required>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="valorTotal">Valor Total</label>
                                                                <label class="input"><i class="icon-append fa fa-usd"></i>
                                                                    <input type="text" id="valorTotal" placeholder="0,00" name="valorTotal" class="readonly decimal-2-casas text-right" disabled>
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Itens do modal</legend>
                                                            </section>
                                                        </div>

                                                        <input id="JsonValeTransporteModal" name="JsonValeTransporteModal" type="hidden" value="[]">


                                                        <div class="row" id="formValeTransporteModal" name="formValeTransporteModal">
                                                            <input id="valeTransporteModalDetalheId" name="valeTransporteModalDetalheId" type="hidden" value="">
                                                            <input id="sequencialValeTransporteModal" name="sequencialValeTransporteModal" type="hidden" value="">
                                                            <input id="descricaoValeTransporteModal" name="descricaoValeTransporteModal" type="hidden" value="">

                                                            <section class="col col-6 col-auto">
                                                                <label class="label" for="valeTransporteUnitario">Transporte Unitário</label>
                                                                <label class="select">
                                                                    <select id="valeTransporteUnitario" name="valeTransporteUnitario" class="required" required>
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select VTU.codigo, VTU.descricao  from Ntl.valeTransporteUnitario VTU order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $id = +$row['codigo'];
                                                                            $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="unidadeFederacao">UF</label>
                                                                <label class="select">
                                                                    <select id="unidadeFederacao" name="unidadeFederacao" class="readonly" disabled>
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select sigla  from Ntl.unidadeFederacao order by sigla";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $sigla = mb_convert_encoding($row['sigla'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="valorUnitario">Valor Unitário</label>
                                                                <label class="input"><i class="icon-append fa fa-usd"></i>
                                                                    <input type="text" id="valorUnitario" name="valorUnitario" placeholder="0,00" class="readonly decimal-2-casas text-right" readonly>
                                                                </label>
                                                            </section>


                                                        </div>

                                                        <div class="row">
                                                            <!-- Botões da lista -->
                                                            <section class="col col-12">

                                                                <button id="btnAddValeTransporteModal" type="button" class="btn btn-primary" title="Adicionar vale de transporte modal">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverValeTransporteModal" type="button" class="btn btn-danger" title="Remover vale de transporte modal">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>
                                                        </div>

                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableValeTransporteModal" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left" style="min-width: 10px;">Transporte Unitário</th>
                                                                        <th class="text-left" style="min-width: 10px;">Valor</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroValeTransporteModal.js" type="text/javascript"></script>


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


<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>



<script language="JavaScript" type="text/javascript">
    //Transforma  os atributos das listas em JSON
    jsonValeTransporteModalArray = JSON.parse($("#JsonValeTransporteModal").val());
    $(document).ready(function() {
        carregaPagina();
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
        //Ações dos botões de vale transporte modal
        //Adicionar um registro na lista.
        $('#btnAddValeTransporteModal').on("click", function() {

            if (validaValeTransporteModal() === true) {
                addValeTransporteModal();
            }
        });


        $('#btnRemoverValeTransporteModal').on("click", function() {
            excluirValeTransporteModal();
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
            var verifica = $("#verificaRecuperacao").val();
            if (verifica == 1) {
                gravar();
            } else {
                verificaDescricaoExistente();
            }
        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $('.dinheiro').mask('#.##9,99', {
            reverse: true
        });
        $("#valeTransporteUnitario").on("change", function() {
            var id = $("#valeTransporteUnitario").val();


            if (id > 0) {
                recuperaValorTransporteUnitario(id,
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

                            var valorUnitario = piece[0];
                            var unidadeFederacao = piece[1];

                            //Mostra apenas dois pontos decimais para o usuário, e com vírgula.
                            valorUnitario = (Math.round(valorUnitario * 100) / 100).toFixed(2);
                            valorUnitario = valorUnitario.replace('.', ',');
                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#valorUnitario").val(valorUnitario);
                            $("#unidadeFederacao").val(unidadeFederacao);
                            return;
                        }
                    }
                );

            } else {
                //Limpa caso seja selecionado em branco
                $("#valorUnitario").val("");
                $("#unidadeFederacao").val("");
            }

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
                recuperaValeTransporteModal(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];

                            var strArrayValeTransporteModal = piece[2];
                            piece = out.split("^");

                            var codigo = +piece[0];
                            var descricao = piece[1];
                            var ativo = piece[2];

                            $("#codigo").val(codigo);
                            $("#descricao").val(descricao);
                            $("#ativo").val(ativo);
                            $("#verificaRecuperacao").val(1);


                            $("#JsonValeTransporteModal").val(strArrayValeTransporteModal);
                            jsonValeTransporteModalArray = JSON.parse($("#JsonValeTransporteModal").val());
                            fillTableValeTransporteModal();
                            return;
                        }
                    }
                );
            }
        }
        $("#descricao").focus();
    }

    function novo() {
        $(location).attr('href', 'cadastro_valeTransporteModalCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_valeTransporteModalFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();
        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }
        excluirValeTransporte(id,
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

    function verificaDescricaoExistente() {
        var descricao = $("#descricao").val();
        verificaDescricao(descricao,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    smartAlert("Atenção", "Já existe um Vale Transporte com essa descrição no Sistema!", "error");
                    $("#descricao").focus();
                    return false;
                } else {
                    gravar();
                    return true;
                }
            }

        );
    }

    function gravar() {

        $("#btnGravar").prop('disabled', true);

        var id = +$("#codigo").val();
        var ativo = +$("#ativo").val();
        var descricao = $("#descricao").val().trim().replace(/'/g, " ");
        var valorTotal = $("#valorTotal").val();

        var jsonValeTransporteModal = $("#JsonValeTransporteModal").val();

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!descricao) {
            smartAlert("Atenção", "Informe a Descrição", "error");
            $("#btnGravar").prop('disabled', false);

            return;
        }

        if (jsonValeTransporteModal === "[]") {
            smartAlert("Atenção", "Informe o Transporte Unitário", "error");
            $("#btnGravar").prop('disabled', false);

            return;
        }


        gravaValeTransporteModal(id, ativo, descricao, valorTotal, jsonValeTransporteModal,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                        $("#btnGravar").prop('disabled', false);
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

    function processData(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';
        if (fieldName !== '' && (fieldId === "descricaoValeTransporteModal")) {
            return {
                name: fieldName,
                value: $("#valeTransporteUnitario option:selected").text()
            };
        }
        //Retorna o valor correto do valor unitário
        if ((fieldName !== '') && (fieldId === "valorUnitario")) {
            var value = $("#" + fieldId).val();
            return {
                name: fieldName,
                value: parseFloat(value.toString().replace(".", "").replace(",", "."))
            };
        }
        return false;
    }

    //Função que valida os campos:
    function validaValeTransporteModal() {
        var existe = false;
        var achou = false;
        var valeTransporteUnitario = $('#valeTransporteUnitario').val();
        var unidadeFederacao = $('#unidadeFederacao').val();
        var sequencial = +$('#sequencialValeTransporteModal').val();

        if (valeTransporteUnitario === '') {
            smartAlert("Erro", "Informe o Transporte Unitário", "error");
            return false;
        }

        for (i = jsonValeTransporteModalArray.length - 1; i >= 0; i--) {
            if (valeTransporteUnitario > 0) {
                if ((jsonValeTransporteModalArray[i].valeTransporteUnitario === valeTransporteUnitario) && (jsonValeTransporteModalArray[i].sequencialValeTransporteModal !== sequencial)) {
                    achou = true;
                    break;
                }
            }
        }

        if (achou === true) {
            smartAlert("Erro", "Já existe o Transporte Unitário na lista.", "error");
            return false;
        }


        return true;
    }

    function addValeTransporteModal() {
        var item = $("#formValeTransporteModal").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processData
        });

        if (item["sequencialValeTransporteModal"] === '') {
            if (jsonValeTransporteModalArray.length === 0) {
                item["sequencialValeTransporteModal"] = 1;
            } else {
                item["sequencialValeTransporteModal"] = Math.max.apply(Math, jsonValeTransporteModalArray.map(function(o) {
                    return o.sequencialValeTransporteModal;
                })) + 1;
            }
            item["valeTransporteModalDetalheId"] = 0;
        } else {
            item["sequencialValeTransporteModal"] = +item["sequencialValeTransporteModal"];
        }

        var index = -1;
        $.each(jsonValeTransporteModalArray, function(i, obj) {
            if (+$('#sequencialValeTransporteModal').val() === obj.sequencialValeTransporteModal) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonValeTransporteModalArray.splice(index, 1, item);
        else
            jsonValeTransporteModalArray.push(item);

        $("#JsonValeTransporteModal").val(JSON.stringify(jsonValeTransporteModalArray));
        fillTableValeTransporteModal();
        clearFormValeTransporteModal();

    }

    function excluirValeTransporteModal() {
        var arrSequencial = [];
        $('#tableValeTransporteModal input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonValeTransporteModalArray.length - 1; i >= 0; i--) {
                var obj = jsonValeTransporteModalArray[i];
                if (jQuery.inArray(obj.sequencialValeTransporteModal, arrSequencial) > -1) {
                    jsonValeTransporteModalArray.splice(i, 1);
                }
            }
            $("#JsonValeTransporteModal").val(JSON.stringify(jsonValeTransporteModalArray));
            fillTableValeTransporteModal();
        } else {
            smartAlert("Erro", "Selecione pelo menos 1 modal para excluir.", "error");
        }
    }

    function carregaValeTransporteModal(sequencialValeTransporteModal) {
        var arr = jQuery.grep(jsonValeTransporteModalArray, function(item, i) {
            return (item.sequencialValeTransporteModal === sequencialValeTransporteModal);
        });
        clearFormValeTransporteModal();
        if (arr.length > 0) {
            var item = arr[0];
            $("#valeTransporteModalDetalheId").val(item.valeTransporteModalDetalheId);
            $("#valeTransporteUnitario").val(item.valeTransporteUnitario);
            $("#valorUnitario").val(roundDecimal(floatToString(item.valorUnitario), 2));
            $("#unidadeFederacao").val(item.unidadeFederacao);
            $("#sequencialValeTransporteModal").val(item.sequencialValeTransporteModal);
            $("#descricaoValeTransporteModal").val(item.descricaoValeTransporteModal);
        }
    }

    // Função que preenche as tabelas com os valores dos formulários
    function fillTableValeTransporteModal() {

        //Verifica se o valor é nulo ou inexistente, e transforma ele em 0. 
        if (($("#valorTotal").val() === "")) {
            var valorTotal = 0;
        }

        valorTotal = parseFloat(valorTotal);
        if (isNaN(valorTotal)) {
            valorTotal = 0;
        }

        $("#tableValeTransporteModal tbody").empty();
        for (var i = 0; i < jsonValeTransporteModalArray.length; i++) {

            var row = $('<tr />');
            $("#tableValeTransporteModal tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonValeTransporteModalArray[i].sequencialValeTransporteModal + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaValeTransporteModal(' + jsonValeTransporteModalArray[i].sequencialValeTransporteModal + ');">' + jsonValeTransporteModalArray[i].descricaoValeTransporteModal + '</td>'));
            row.append($('<td class="text-right"> R$ ' + roundDecimal(floatToString(jsonValeTransporteModalArray[i].valorUnitario), 2) + '</td>'));

            //Transforma em float para ser somado. 
            valorTotal += parseFloat(jsonValeTransporteModalArray[i].valorUnitario);

        }

        //Retorna o valorTotal certo formatado para visualização.
        valorTotal = roundDecimal(floatToString(valorTotal), 2);
        $("#valorTotal").val(valorTotal);
        initializeDecimalBehaviour();

    }

    function clearFormValeTransporteModal() {
        $("#valeTransporteModalDetalheId").val('');
        $("#sequencialValeTransporteModal").val('');
        $("#valeTransporteUnitario").val('');
        $("#valorUnitario").val('');
        $("#unidadeFederacao").val('');
    }
</script>