<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

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

$page_title = "Lançamentos";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["tabelaBasica"]["sub"]["lancamento"]["active"] = true;

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
                                                            <section class="col col-5 col-auto">
                                                                <label class="label" for="descricao">Descrição</label>
                                                                <label class="input">
                                                                    <input id="descricao" name="descricao" type="text" class="required" maxlength="50" required autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="descricao">Sigla</label>
                                                                <label class="input">
                                                                    <input id="sigla" name="sigla" type="text" class="required" maxlength="5" required autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="faltaAusencia">Tipo de Desconto</label>
                                                                <label class="select">
                                                                    <select id="faltaAusencia" name="faltaAusencia" class="required" required>
                                                                        <option value='N'>Nenhum</option>
                                                                        <option value='F'>Falta</option>
                                                                        <option value='A'>Ausência</option>
                                                                        <option value='VT'>VT</option>
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
                                                        <div class="row">
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="ativo">Abona atraso</label>
                                                                <label class="select">
                                                                    <select id="abonaAtraso" name="abonaAtraso" class="required" required>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0' selected>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="ativo">Imprimir folha</label>
                                                                <label class="select">
                                                                    <select id="imprimeFolha" name="imprimeFolha" class="required" required>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0' selected>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="ativo">Planilha de Faturamento</label>
                                                                <label class="select">
                                                                    <select id="planilhaFaturamento" name="planilhaFaturamento" class="required" required>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0' selected>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <input id="jsonProjeto" name="jsonProjeto" type="hidden" value="[]">
                                                        <div id="formProjeto" class="col-sm-12">
                                                            <input id="projetoId" name="projetoId" type="hidden" value="">
                                                            <input id="sequencialProjeto" name="sequencialProjeto" type="hidden" value="">
                                                            <input id="descricaoProjeto" name="descricaoProjeto" type="hidden" value="">
                                                            <div class="form-group">
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao AS 'descricaoProjeto' FROM Ntl.projeto where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricaoProjeto = ($row['descricaoProjeto']);
                                                                            echo '<option value=' . $codigo . '>' . $descricaoProjeto . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-md-2">
                                                                <label class="label">&nbsp;</label>
                                                                <button id="btnAddProjeto" type="button" class="btn btn-primary">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverProjeto" type="button" class="btn btn-danger">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>

                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableProjeto" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center">Projeto</th>
                                                                        
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>

                                                            </div>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_tabelaBasicaLancamento.js" type="text/javascript"></script>


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
        jsonProjetoArray = JSON.parse($("#jsonProjeto").val());

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

        $("#btnAddProjeto").on("click", function() {
            var projeto = $("#projeto").val();

            if (!projeto) {
                smartAlert("Atenção", "Escolha um projeto", "error")
                return;
            }

            addProjeto();
        });

        $("#btnRemoverProjeto").on("click", function() {
            excluirProjeto();
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
    });

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaLancamento(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var $strArrayProjeto = piece[2];
                            piece = out.split("^");

                            // Atributos de vale transporte unitário que serão recuperados: 
                            var codigo = +piece[0];
                            var descricao = piece[1];
                            var sigla = piece[2];
                            var ativo = +piece[3];
                            var faltaAusencia = piece[4]

                            var abonaAtraso = +piece[5]
                            var imprimeFolha = +piece[6]
                            var planilhaFaturamento = +piece[7]


                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#descricao").val(descricao);
                            $("#sigla").val(sigla);
                            $("#ativo").val(ativo);
                            $("#faltaAusencia").val(faltaAusencia);

                            $("#abonaAtraso").val(abonaAtraso);
                            $("#imprimeFolha").val(imprimeFolha);
                            $("#planilhaFaturamento").val(planilhaFaturamento);
                            $("#jsonProjeto").val($strArrayProjeto);

                            jsonProjetoArray = JSON.parse($("#jsonProjeto").val());
                            fillTableProjeto();

                            return;

                        }
                    }
                );
            }
        }
        $("#descricao").focus();
    }



    function novo() {
        $(location).attr('href', 'tabelaBasica_lancamentoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'tabelaBasica_lancamentoFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirLancamento(id,
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

    function clearFormProjeto() {
        $("#projeto").val('');
    }

    function addProjeto() {
        var item = $("#formProjeto").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataProjeto
        });

        if (item["sequencialProjeto"] === '') {
            if (jsonProjetoArray.length === 0) {
                item["sequencialProjeto"] = 1;
            } else {
                item["sequencialProjeto"] = Math.max.apply(Math, jsonProjetoArray.map(function(o) {
                    return o.sequencialProjeto;
                })) + 1;
            }
            item["projetoId"] = 0;
        } else {
            item["sequencialProjeto"] = +item["sequencialProjeto"];
        }

        var index = -1;
        $.each(jsonProjetoArray, function(i, obj) {
            if (+$('#sequencialProjeto').val() === obj.sequencialProjeto) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonProjetoArray.splice(index, 1, item);
        else
            jsonProjetoArray.push(item);

        $("#jsonProjeto").val(JSON.stringify(jsonProjetoArray));
        fillTableProjeto();
        clearFormProjeto();

    }

    function fillTableProjeto() {
        $("#tableProjeto tbody").empty();
        for (var i = 0; i < jsonProjetoArray.length; i++) {
            var row = $('<tr />');
            $("#tableProjeto tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonProjetoArray[i].sequencialProjeto + '"><i></i></label></td>'));
            row.append($('<td class="text-center" onclick="carregaProjeto(' + jsonProjetoArray[i].sequencialProjeto + ');">' + jsonProjetoArray[i].descricaoProjeto + '</td>'));

          
        }
    }
    function processDataProjeto(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "projeto")) {
            var projeto = $("#projeto").val();
            if (projeto !== '') {
                fieldName = "projeto";
            }
            return {
                name: fieldName,
                value: projeto
            };
        }

          if (fieldName !== '' && (fieldId === "descricaoProjeto")) {
            return {
                name: fieldName,
                value: $("#projeto option:selected").text()
            };
        }

        return false;
    }

    function carregaProjeto(sequencialProjeto) {
        var arr = jQuery.grep(jsonProjetoArray, function(item, i) {
            return (item.sequencialProjeto === sequencialProjeto);
        });

        clearFormProjeto();

        if (arr.length > 0) {
            var item = arr[0];
            $("#projeto").val(item.projeto);
            
        }
    }

    function excluirProjeto() {
        var arrSequencial = [];
        $('#tableProjeto input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonProjetoArray.length - 1; i >= 0; i--) {
                var obj = jsonProjetoArray[i];
                if (jQuery.inArray(obj.sequencialProjeto, arrSequencial) > -1) {
                    jsonProjetoArray.splice(i, 1);
                }
            }
            $("#jsonProjeto").val(JSON.stringify(jsonProjetoArray));
            fillTableProjeto();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Projeto para excluir.", "error");
    }

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        var id = +$('#codigo').val();
        var descricao = $('#descricao').val().trim().replace(/'/g, " ");
        var sigla = $('#sigla').val().trim();
        var ativo = +$('#ativo').val();
        var faltaAusencia = $('#faltaAusencia').val();

        var abonaAtraso = +$('#abonaAtraso').val();
        var imprimeFolha = +$('#imprimeFolha').val();
        var planilhaFaturamento = +$('#planilhaFaturamento').val();
        var jsonProjetoArray =  JSON.parse($("#jsonProjeto").val());

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!descricao) {
            smartAlert("Atenção", "Informe a descrição", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!sigla) {
            smartAlert("Atenção", "Informe a Sigla", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        //Chama a função de gravar do business de convênio de saúde.
        gravaLancamento(id, ativo, descricao, sigla, faltaAusencia, abonaAtraso, imprimeFolha,
            planilhaFaturamento,jsonProjetoArray,
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
</script>