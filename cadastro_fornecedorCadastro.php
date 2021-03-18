<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Fornecedor";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["fornecedor"]["active"] = true;

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
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Fornecedor</h2>
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

                                                            <input id="codigo" name="codigo" type="text" readonly class="hidden" value="">

                                                            <section class="col col-3">
                                                                <label class="label">CNPJ</label>
                                                                <label class="input">
                                                                    <input id="cnpj" name="cnpj" autocomplete="off" placeholder="XX.XXX.XXX/XXXX-XX" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Razão Social</label>
                                                                <label class="input">
                                                                    <input id="razaoSocial" maxlength="70" name="razaoSocial" autocomplete="off" placeholder="Digite a Razao Social" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label">Apelido</label>
                                                                <label class="input">
                                                                    <input id="apelido" maxlength="70" name="apelido" autocomplete="off" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 ">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">CEP</label>
                                                                <label class="input">
                                                        <input id="cep" name="cep" type="text" autocomplete="off" maxlength="100" class="required">

                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label">Endereço</label>
                                                                <label class="input">
                                                                    <input id="endereco" name="endereco" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Número</label>
                                                                <label class="input">
                                             <input id="numero" name="numero" type="text" autocomplete="off" maxlength="100" class="required">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" name="bairro" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" name="cidade" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">UF</label>
                                                                <label class="input">
                                                                    <input id="uf" name="uf" type="text" autocomplete="off" cmaxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">NF</label>
                                                                <label class="select">
                                                                    <select id="notaFiscal" name="notaFiscal" class="required">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>



                                                </div>
                                                </fieldset>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseGrupoDeItem" class="collapsed" id="accordionDadosContrato">
                                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                            <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                            Grupo de Item
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseGrupoDeItem" class="panel-collapse collapse">
                                                    <div class="panel-body no-padding">
                                                        <input id="jsonGrupoItem" name="jsonGrupoItem" type="hidden" value="[]">
                                                        <fieldset id="formGrupoDeItem">
                                                            <input id="sequencialGrupoDeItem" name="sequencialGrupoDeItem" type="hidden" value="">

                                                            <br>
                                                            <div class="row">
                                                                <section class="col col-3">
                                                                    <label class="label">Estoque</label>
                                                                    <label class="select">
                                                                        <select id="estoque" name="estoque" class="form-control">
                                                                            <option style="display:none;" value="">Selecione</option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM estoque.estoque  where ativo = 1  order by codigo";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {

                                                                                $row = array_map('mb_strtoupper', $row);
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-3">
                                                                    <label class="label">Grupo Item</label>
                                                                    <label class="select">
                                                                        <select id="grupoItem" name="grupoItem" class="form-control">
                                                                            <option style="display:none;" value="">Selecione</option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM estoque.grupoItem  where ativo = 1  order by codigo";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {

                                                                                $row = array_map('mb_strtoupper', $row);
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-5">
                                                                    <label class="label">Observação</label>
                                                                    <label class="input">
                                                                        <input id="observacao" name="observacao" type="text" autocomplete="off" maxlength="100">

                                                                    </label>
                                                                </section>

                                                                
                                                                    <section class="col col-4" >

                                                                        <button id="btnAddGrupoDeItem" type="button" class="btn btn-primary" title="Adicionar Item">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverGrupoDeItem" type="button" class="btn btn-danger" title="Remover Item">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableGrupoDeItem" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">

                                                                            <th class="text-left" style="min-width: 10px;"></th>
                                                                            <th class="text-left" style="min-width: 10px;">Estoque</th>
                                                                            <th class="text-left" style="min-width: 10px;">Grupo de Item</th>
                                                                            <th class="text-left" style="min-width: 30px;">Observacao</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </fieldset>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroFornecedor.js" type="text/javascript"></script>


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
    jsonGrupoItemArray = JSON.parse($("#jsonGrupoItem").val());
    $(document).ready(function() {

        $("#cnpj").mask("99.999.999/9999-99", {
            placeholder: "X"
        });

        $("#cep").mask("99999-999", {
            placeholder: 'X'
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
            $ativo = 1;
            gravar();

        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#btnRemoverGrupoDeItem").on("click", function() {
            excluirGrupoDeItem();
        });

        $("#btnAddGrupoDeItem").on("click", function() {
            addGrupoDeItem();
        });

        $("#cnpj").on("focusout", function() {
            var cnpj = $("#cnpj").val();
            if (!validacao_cnpj(cnpj)) {
                smartAlert("Atenção", "CNPJ inválido!", "error");
                $("#cnpj").val('');
            }
        });


        $("#cep").on("change", function() {
            var cep = $("#cep").val().replace(/\D/g, '');
            buscaCep(cep);
        });

        carregaPagina();

    });

    // ############## COMEÇO LISTA ESTOQUE ###################

    function addGrupoDeItem() {
        var item = $("#formGrupoDeItem").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataGrupoDeItem
        });

        if (item["sequencialGrupoDeItem"] === '') {
            if (jsonGrupoItemArray.length === 0) {
                item["sequencialGrupoDeItem"] = 1;
            } else {
                item["sequencialGrupoDeItem"] = Math.max.apply(Math, jsonGrupoItemArray.map(function(o) {
                    return o.sequencialGrupoDeItem;
                })) + 1;
            }

        } else {
            item["sequencialGrupoDeItem"] = +item["sequencialGrupoDeItem"];
        }

        item.estoqueText = $('#estoque option:selected').text().trim();
        item.grupoItemText = $('#grupoItem option:selected').text().trim();

        var index = -1;
        $.each(jsonGrupoItemArray, function(i, obj) {
            if (+$('#sequencialGrupoDeItem').val() === obj.sequencialGrupoDeItem) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonGrupoItemArray.splice(index, 1, item);
        else
            jsonGrupoItemArray.push(item);

        $("#jsonGrupoItem").val(JSON.stringify(jsonGrupoItemArray));
        fillTableGrupoDeItem();

    }

    function processDataGrupoDeItem(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "Estoque")) {
            return {
                name: fieldName,
                value: $("#estoque option:selected").val()
            };
        }


        if (fieldName !== '' && (fieldId === "GrupoItem")) {
            return {
                name: fieldName,
                value: $("#grupoItem option:selected").val()
            };
        }


        if (fieldName !== '' && (fieldId === "observacao")) {
            return {
                name: fieldName,
                value: $("#observacao").val()
            };
        }


        return false;
    }

    function fillTableGrupoDeItem() {
        $("#tableGrupoDeItem tbody").empty();
        if (typeof(jsonGrupoItemArray) != 'undefined') {
            for (var i = 0; i < jsonGrupoItemArray.length; i++) {
                var row = $('<tr />');
                $("#tableGrupoDeItem tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonGrupoItemArray[i].sequencialGrupoDeItem + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaGrupoDeItem(' + jsonGrupoItemArray[i].sequencialGrupoDeItem + ');">' + jsonGrupoItemArray[i].estoqueText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonGrupoItemArray[i].sequencialGrupoDeItem + ');">' + jsonGrupoItemArray[i].grupoItemText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonGrupoItemArray[i].sequencialGrupoDeItem + ');">' + jsonGrupoItemArray[i].observacao + '</td>'));


            }
            clearFormGrupoDeItem();
        }
    }

    // function validaGrupoDeItem
    //     // var existeFuncionario = false;
    //     // var existeConvenio = false;
    //     // var existeProduto = false;
    //     // var achou = false;
    //     // var funcionarioTitular = +$('#funcionarioTitular').val();
    //     // var convenio = +$('#convenioTitular').val();
    //     // var produto = +$('#produtoTitular').val();
    //     // var sequencial = +$('#sequencialPlanoSaude').val();


    //     // if (funcionarioTitular == 0) {
    //     //     smartAlert("Erro", "Informe um Funcionario.", "error");
    //     //     return false;
    //     // }

    //     // if (convenio == 0) {
    //     //     smartAlert("Erro", "Informe um Convenio.", "error");
    //     //     return false;
    //     // }

    //     // if (produto == 0) {
    //     //     smartAlert("Erro", "Informe um Produto.", "error");
    //     //     return false;
    //     // }

    //     // for (i = jsonPlanoSaudeArray.length - 1; i >= 0; i--) {
    //     //     if ((jsonPlanoSaudeArray[i].descricaoFuncionarioTitular == funcionarioTitular) && (jsonPlanoSaudeArray[i].sequencialPlanoSaude !== sequencial)) {
    //     //         existeFuncionario = true;

    //     //     }
    //     //     if ((jsonPlanoSaudeArray[i].descricaoConvenioTitular == convenio) && (jsonPlanoSaudeArray[i].sequencialPlanoSaude !== sequencial)) {
    //     //         existeConvenio = true;

    //     //     }
    //     //     if ((jsonPlanoSaudeArray[i].descricaoProdutoTitular == produto) && (jsonPlanoSaudeArray[i].sequencialPlanoSaude !== sequencial)) {
    //     //         existeProduto = true;

    //     //     }
    //     //     break;
    //     // }
    //     // if (existeFuncionario === true && existeConvenio == true && existeProduto == true) {
    //     //     smartAlert("Erro", "Funcionário não pode ter o mesmo Produto e Convênio.", "error");
    //     //     return false;
    //     // }

    //     // return true;
    // }

    function clearFormGrupoDeItem() {
        $('#estoque').val("");
        $('#grupoItem').val("");
        $('#observacao').val('');
    }

    function carregaGrupoDeItem(sequencialGrupoDeItem) {
        // habilitaTodoCampoGrupoDeItem()
        var arr = jQuery.grep(jsonGrupoItemArray, function(item, i) {
            return (item.sequencialGrupoDeItem === sequencialGrupoDeItem);
        });



        clearFormGrupoDeItem();
        if (arr.length > 0) {
            var item = arr[0];
            $('#sequencialGrupoDeItem').val(item.sequencialGrupoDeItem);
            $('#estoque').val(item.estoque);
            $('#grupoItem').val(item.grupoItem);
            $('#observacao').val(item.observacao);
        }
    }

    function excluirGrupoDeItem() {
        var arrSequencial = [];
        $('#tableGrupoDeItem input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonGrupoItemArray.length - 1; i >= 0; i--) {
                var obj = jsonGrupoItemArray[i];
                if (jQuery.inArray(obj.sequencialGrupoDeItem, arrSequencial) > -1) {
                    jsonGrupoItemArray.splice(i, 1);
                }
            }

            $("#jsonGrupoItem").val(JSON.stringify(jsonGrupoItemArray));
            fillTableGrupoDeItem();
        } else {
            smartAlert("Erro", "Selecione pelo menos 1 grupo de item para excluir.", "error");
        }
    }





    function buscaCep(cep) {
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        var ocorrencia = dados.logradouro.indexOf(" ")
                        var recorte = dados.logradouro.slice(0, ocorrencia)
                        var endereco = dados.logradouro.slice((dados.logradouro.length * (-1)) + ocorrencia).trim()
                        $("#endereco").val(endereco);
                        $("#logradouro").val(recorte);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } else {

                        smartAlert("Erro", "CEP não encontrado.", "error");
                    }
                });
            } else {
                smartAlert("Erro", "Formato do CEP inválido.", "error");
            }
        }
    }

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFornecedor(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var $strArrayGrupoItem = piece[2];
                            piece = out.split("^");

                            var codigo = +piece[0];
                            var cnpj = piece[1];
                            var razaoSocial = piece[2];
                            var apelido = piece[3];
                            var ativo = piece[4];
                            var logradouro = piece[5];
                            var numero = piece[6];
                            var complemento = piece[7];
                            var bairro = piece[8];
                            var cidade = piece[9];
                            var uf = piece[10];
                            var notaFiscal = piece[11];
                            var cep = piece[12];
                            var endereco = piece[13];


                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.

                            $("#codigo").val(codigo);
                            $("#cnpj").val(cnpj);
                            $("#razaoSocial").val(razaoSocial);
                            $("#apelido").val(apelido);
                            $("#ativo").val(ativo);
                            $("#logradouro").val(logradouro);
                            $("#numero").val(numero);
                            $("#complemento").val(complemento);
                            $("#bairro").val(bairro);
                            $("#cidade").val(cidade);
                            $("#uf").val(uf);
                            $("#notaFiscal").val(notaFiscal);
                            $("#cep").val(cep);
                            $("#endereco").val(endereco);
                            $("#jsonGrupoItem").val($strArrayGrupoItem);

                            jsonGrupoItemArray = JSON.parse($("#jsonGrupoItem").val());
                            fillTableGrupoDeItem();

                            return;

                        }
                    }
                );
            }

        }

    }

    function novo() {
        $(location).attr('href', 'cadastro_fornecedorCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_fornecedorFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFornecedor(id,
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
        var cnpj = $("#cnpj").val();
        var razaoSocial = $("#razaoSocial").val();
        var apelido = $("#apelido").val();
        var ativo = $("#ativo").val();
        var logradouro = $("#logradouro").val();
        var numero = $("#numero").val();
        var complemento = $("#complemento").val();
        var bairro = $("#bairro").val();
        var cidade = $("#cidade").val();
        var uf = $("#uf").val();
        var notaFiscal = $("#notaFiscal").val();
        var cep = $("#cep").val();
        var endereco = $("#endereco").val();
        var jsonGrupoItemArray = JSON.parse($("#jsonGrupoItem").val());

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!cnpj) {
            smartAlert("Atenção", "Informe o CNPJ", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!razaoSocial) {
            smartAlert("Atenção", "Informe o Razao Social", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!apelido) {
            smartAlert("Atenção", "Informe o Apelido", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cep) {
            smartAlert("Atenção", "Informe o Cep", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!numero) {
            smartAlert("Atenção", "Informe o numero", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        gravaFornecedor(id, cnpj, razaoSocial, apelido, ativo, logradouro, numero, complemento, bairro, cidade, uf, notaFiscal, cep, endereco, jsonGrupoItemArray,
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
</script>