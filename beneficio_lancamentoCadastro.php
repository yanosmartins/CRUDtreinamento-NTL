<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
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

$page_title = "Lançamento";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]["lancamento"]["active"] = true;
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
                            <h2>Lançamento
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formLancamentoCadastro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseLancamento" class="collapsed" id="accordionLancamento">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Lançamento Folha de Ponto
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseLancamento" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <input id="JsonLancamento" name="JsonLancamento" type="hidden" value="[]">
                                                        <div id="formLancamento" class="col-sm-12">
                                                            <input id="lancamentoId" name="lancamentoId" type="hidden" value="">
                                                            <input id="sequencialLancamento" name="sequencialLancamento" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">

                                                                    <section class="col col-5">
                                                                        <label class="label " for="funcionario">Funcionário</label>
                                                                        <label class="select">
                                                                            <select id="funcionario" name="funcionario" class="required">
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, nome from Ntl.funcionario where dataDemissaoFuncionario IS NULL AND ativo = 1 order by nome";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $nome = $row['nome'];
                                                                                    echo '<option value=' . $codigo . '>' . $nome . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-3">
                                                                        <label class="label" for="projeto">Projeto</label>
                                                                        <label class="select">
                                                                            <select id="projeto" name="projeto" class="required">
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, descricao from Ntl.projeto where ativo = 1 order by descricao";
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

                                                                    <section class="col col-3">
                                                                        <label class="label" for="lancamento">Lançamento</label>
                                                                        <label class="select">
                                                                            <select id="lancamento" name="lancamento" class="required">
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo, sigla, descricao from Ntl.lancamento where ativo = 1 order by descricao";
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
                                                                    <section class="col col-2">
                                                                        <label class="label" for="mesAnoFolhaPonto">Mês/Ano</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="mesAnoFolhaPonto" name="mesAnoFolhaPonto" style="text-align: center;" autocomplete="off" data-mask="99/9999" data-mask-placeholder="mm/aaaa" data-dateformat="mm/yy" placeholder="mm/aaaa" type="text" class="datepicker required" value="">
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label"> </label>
                                                                        <button id="btnAddLancamento" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverLancamento" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>

                                                            <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableLancamento" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-left" style="min-width: 500%;">Funcionário</th>
                                                                            <th class="text-left">Projeto</th>
                                                                            <th class="text-left">Mês/Ano</th>
                                                                            <th class="text-left">Lançamento</th>
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
                                                <span class="fa fa-backward"></span>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_beneficioLancamento.js" type="text/javascript"></script>
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script language="JavaScript" type="text/javascript">
    var jsonLancamentoArray = [];
    $(document).ready(function() {



        $('#btnNovo').on("click", function() {
            novo()
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#btnExcluir").on("click", function() {
            excluir();
        });
        $('#btnAddLancamento').on("click", function() {
            if (validaLancamento()) {
                addLancamento();
            }
        });
        $('#btnRemoverLancamento').on("click", function() {
            excluirLancamento();
        });
        fillTableLancamento();
        carregaLancamento();


    });

    function clearFormLancamento() {
        $("#lancamentoId, #sequencialLancamento, #funcionario, #mesAnoFolhaPonto ,#projeto").val('');
        $("#lancamento").val('Selecione');

    }

    function fillTableLancamento() {
        $("#tableLancamento tbody").empty();
        if (typeof(jsonLancamentoArray) != 'undefined') {
            for (var i = 0; i < jsonLancamentoArray.length; i++) {
                var row = $('<tr />');
                $("#tableLancamento tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonLancamentoArray[i].sequencialLancamento + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaLancamento(' + jsonLancamentoArray[i].sequencialLancamento + ');">' + jsonLancamentoArray[i].funcionarioText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonLancamentoArray[i].sequencialLancamento + ');">' + jsonLancamentoArray[i].projetoText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonLancamentoArray[i].sequencialLancamento + ');">' + jsonLancamentoArray[i].mesAnoFolhaPonto + '</td>'));
                row.append($('<td class="" (' + jsonLancamentoArray[i].sequencialLancamento + ');">' + jsonLancamentoArray[i].lancamentoText + '</td>'));


            }
            clearFormLancamento();
        }
    }


    function validaLancamento() {
        var existe = false;
        var achou = false;
        var funcionario = $('#funcionario').val();
        var projeto = $("#projeto").val();
        var mesAnoFolhaPonto = $('#mesAnoFolhaPonto').val();
        var lancamento = $('#lancamento').val();


        var sequencial = +$('#sequencialLancamento').val();
        var correspondenciaMarcado = 1;

        if (!funcionario) {
            smartAlert("Erro", "Informe o Funcionário.", "error");
            return false;
        }

        if (!mesAnoFolhaPonto) {
            smartAlert("Erro", "Informe o Mês/Ano.", "error");
            return false;
        }

        if (!projeto) {
            smartAlert("Erro", "Informe o Projeto", "error");
            return false;
        }

        if (!lancamento) {
            smartAlert("Erro", "Informe o Lançamento.", "error");
            return false;
        }



        for (i = jsonLancamentoArray.length - 1; i >= 0; i--) {
            if (correspondenciaMarcado === 1) {
                if ((jsonLancamentoArray[i].correspondencia == 1) && (jsonLancamentoArray[i].sequencialLancamento !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (!funcionario) {
                if ((jsonLancamentoArray[i].lancamento === funcionario) && (jsonLancamentoArray[i].sequencialLancamento !== sequencial)) {
                    existe = true;
                    break;
                }
            }

        }
        if (existe === true) {
            smartAlert("Erro", "Lancamento já cadastrado.", "error");
            return false;
        }
        if ((achou === true) && (correspondenciaMarcado === 1)) {
            smartAlert("Erro", "Você já marcou pra receber Correspondencia.", "error");
            return false;
        }
        return true;
    }

    function processDataLancamento(node) {

        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';
        var value;

        if (fieldName !== '' && (fieldId === "funcionario")) {
            var valorTel = $("#funcionario").val().trim();
            if (valorTel !== '') {
                fieldName = "funcionario";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }

        return false;
    }

    function addLancamento() {
        var item = $("#formLancamento").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataLancamento
        });

        if (item["sequencialLancamento"] === '') {
            if (jsonLancamentoArray.length === 0) {
                item["sequencialLancamento"] = 1;
            } else {
                item["sequencialLancamento"] = Math.max.apply(Math, jsonLancamentoArray.map(function(o) {
                    return o.sequencialLancamento;
                })) + 1;
            }
            item["encargoPercentualId"] = 0;
        } else {
            item["sequencialLancamento"] = +item["sequencialLancamento"];
        }

        item.funcionarioText = $('#funcionario option:selected').text().trim();
        item.projetoText = $('#projeto option:selected').text().trim();
        item.lancamentoText = $('#lancamento option:selected').text().trim();

        var index = -1;
        $.each(jsonLancamentoArray, function(i, obj) {
            if (+$('#sequencialLancamento').val() === obj.sequencialLancamento) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonLancamentoArray.splice(index, 1, item);
        else
            jsonLancamentoArray.push(item);

        $("#jsonLancamento").val(JSON.stringify(jsonLancamentoArray));
        fillTableLancamento();
        clearFormLancamento();

    }

    function excluirLancamento() {
        var arrSequencial = [];
        $('#tableLancamento input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonLancamentoArray.length - 1; i >= 0; i--) {
                var obj = jsonLancamentoArray[i];
                if (jQuery.inArray(obj.sequencialLancamento, arrSequencial) > -1) {
                    jsonLancamentoArray.splice(i, 1);
                }
            }
            $("#JsonLancamento").val(JSON.stringify(jsonLancamentoArray));
            fillTableLancamento();
        } else {
            smartAlert("Erro", "Selecione pelo menos um Lancamento para excluir.", "error");
        }
    }

    function carregaLancamento(sequencialLancamento) {
        var arr = jQuery.grep(jsonLancamentoArray, function(item, i) {
            return (item.sequencialLancamento === sequencialLancamento);
        });

        clearFormLancamento();

        if (arr.length > 0) {
            var item = arr[0];
            $("#lancamentoId").val(item.lancamentoId);
            $("#sequencialLancamento").val(item.sequencialLancamento);
            $("#funcionario").val(item.funcionario);
            $("#projeto").val(item.projeto);
            $("#mesAnoFolhaPonto").val(item.mesAnoFolhaPonto);
            $("#lancamento").val(item.lancamento);



        }
    }







    function voltar() {
        $(location).attr('href', 'beneficio_lancamentoFiltro.php');

    }

    function novo() {
        $(location).attr('href', 'beneficio_lancamentoCadastro.php');

    }

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        var codigo = +$("#codigo").val();
        var ativo = $("#ativo").val();
        var funcionario = $("#funcionario").val();
        var mesAnoFolhaPonto = $("#mesAnoFolhaPonto").val();
        var observacaoLancamento = $("#observacaoLancamento").val();

        let lancamentoTabela = $('#formLancamentoCadastro').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        

        gravaLancamento(lancamentoTabela,
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
                    novo();
                }
            }
        );
    }


    function excluir() {
        debugger;
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirLancamento(id, function(data) {
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
        });
    }


    function carregaLancamento() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaLancamento(idd,
                    function(data) {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");

                        //Atributos de Cliente
                        var mensagem = piece[0];
                        var out = piece[1];

                        piece = out.split("^");
                        console.table(piece);
                        //Atributos de cliente 
                        var codigo = +piece[0];
                        var funcionario = piece[1];
                        var projeto = piece[2];
                        var mesAnoFolhaPonto = piece[3];



                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#funcionario").val(funcionario);
                        $("#projeto").val(projeto);
                        $("#mesAnoFolhaPonto").val(mesAnoFolhaPonto);





                    }
                );
            }
        }
    }
</script>