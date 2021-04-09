<?php
//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PROCESSABENEFICIO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PROCESSABENEFICIO_GRAVAR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Afastamento do Funcionário";
/* ---------------- END PHP Custom Scripts ------------- */
//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["beneficio"]["sub"]["processaBeneficio"]["active"] = true;
include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Operação"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row" style="margin: 0 0 13px 0;">
            </div>
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Processa Benefício</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuarioFiltro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden" value="">
                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Mês/Ano</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="data" name="data" autocomplete="off" data-mask="99/9999" data-mask-placeholder="MM/AAAA" data-dateformat="mm/yy" placeholder="MM/AAAA" type="text" class="datepicker required" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Projeto</label>
                                                                <label class="input">
                                                                    <input id="projetoId" type="hidden" value="">
                                                                    <input id="projeto" name="projeto" autocomplete="off" class="form-control required" required placeholder="Digite o Projeto..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label " for="projeto">Projeto Pesquisa</label>
                                                                <label class="select">
                                                                    <select id="projetoFiltro" name="projetoFiltro" class="required" required>
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo,descricao FROM Ntl.projeto WHERE ativo = 1 ORDER BY descricao ";
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
                                                            <section class="col col-4">
                                                                <label class="label hidden">Funcionário</label>
                                                                <label class="hidden">
                                                                    <input id="funcionarioId" type="hidden" value="">
                                                                    <input id="funcionario" name="funcionarioFiltro" autocomplete="off" class="form-control" placeholder="Digite o nome do Funcionário..." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label hidden" for="funcionario">Funcionário Pesquisa</label>
                                                                <label class="select hidden">
                                                                    <select id="funcionarioFiltro" name="funcionario">
                                                                        \ <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo,nome 
                                                                                FROM Ntl.funcionario 
                                                                                WHERE ativo = 1 AND dataDemissaoFuncionario IS NULL ORDER BY nome ";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {

                                                                            $id = (int) $row['codigo'];
                                                                            $nome = $row['nome'];
                                                                            echo '<option value=' . $id . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
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
                                        <b>Legenda:   <b>
                                                <font color="red"> <b>Vale Refeicao/Alimentacao   <b></font>
                                                <font color="blueviolet"> <b>Bolsa Beneficio   <b></font>
                                                <font color="green"> <b>Cesta Basica   <b></font>
                                                <font color="blue"> <b>Plano Saúde   <b></font>
                                                <font color="darkorange"> <b>Vale Transporte   <b></font>
                                                <font color="violet"> <b>Férias/Afastamento<b></font>

                                                <button id="processa" type="button" class="btn btn-success" title="processa">
                                                    Processar
                                                </button>
                                                <button id="btnSearch" type="button" class="btn btn-primary" title="Buscar">
                                                    <i class="fa bg-red fa-search fa-lg  bg-blue-light text-magenta "></i>
                                                </button>
                                                <!-- <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                                    <span class="fa fa-floppy-o"></span>
                                                </button> -->
                                    </footer>
                                </form>
                            </div>
                            <div id="resultadoBusca"></div>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_operacaoProcessaBeneficio.js" type="text/javascript"></script>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script>
    $('body').addClass("minified");
    $(document).ready(function() {
        $('#btnSearch').on("click", function() {
            listarFiltro();
        });
        $('#projetoFiltro').on("change", function() {
            $("#projetoId").val('');
            $("#projeto").val('');
        });


        $("#projeto").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroProjeto.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaProjetoAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao
                            };
                        }));
                    },
                    // async: false,
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#projetoId").val(ui.item.id);
                $("#projeto").val(ui.item.descricao);
                var projetoId = $("#projetoId").val();
                $("#projetoFiltro").val(projetoId);
                $("#projetoFiltro").trigger('change');

            },

            change: function(event, ui) {

                if (ui.item === null) {
                    $("#projetoId").val('');
                    $("#projeto").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);

        };
        $("#funcionario").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroFuncionario.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaFuncionarioAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.nome,
                                value: item.nome
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#funcionarioId").val(ui.item.id);
                $("#funcionarioFiltro").val(ui.item.nome);
                var funcionarioId = $("#funcionarioId").val();
                $("#funcionario").val(funcionarioId)
                // $("#funcionarioId").val('');
                $("#funcionarioFiltro").val('');
            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#funcionarioId").val('');
                    $("#funcionarioFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };

        $("#projetoFiltro").on("change", function() {
            $("#projetoId").val(+$("#projetoFiltro").val());
            $("#projeto").val($("#projetoFiltro option:selected").text());
            $("#projetoFiltro").val('');
        });

        $("#funcionarioFiltro").on("change", function() {
            $("#funcionarioId").val(+$("#funcionarioFiltro").val());
            $("#funcionario").val($("#funcionarioFiltro option:selected").text());
            $("#funcionarioFiltro").val('');
        });

        $("#btnGravar").on("click", function() {
            gravar();
        });

    });

    function listarFiltro() {
        var projeto = +$("#projetoId").val();
        var projetoFiltro = $('#projetoFiltro').val();
        var data = $('#data').val();
        var funcionario = $("#funcionario").val();
        var funcionarioFiltro2 = $("#funcionarioFiltro").val();
        var funcionarioFiltro = $("#funcionarioId").val()

        if (!data) {
            smartAlert("Atenção", "Informe o Mês / Ano", "error");
            return;
        }
        if (!projetoFiltro && !funcionario && !projeto) {
            smartAlert("Atenção", "Informe o Projeto", "error");
            return;
        }
        if (projetoFiltro == "" && projeto != "") {
            projetoFiltro = projeto;
        }
        if (funcionario == "" && funcionarioFiltro != "") {
            funcionario = funcionarioFiltro;
        }

        var parametrosUrl = '&projetoFiltro=' + projetoFiltro + '&data=' + data + '&funcionarioFiltro=' + funcionarioFiltro;
        $('#resultadoBusca').load('beneficio_processaBeneficioFiltroListagem.php?' + parametrosUrl);
    }

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        // $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        var id = +$('#codigo').val();
        var mesAnoReferencia = $('#data').val();
        var projeto = +$("#projetoId").val();
        // var ativo = +$('#ativo').val();
        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        // if (!descricao) {
        //     smartAlert("Atenção", "Informe a descrição", "error");
        //     $("#btnGravar").prop('disabled', false);
        //     return;
        // }

        // if (!sigla) {
        //     smartAlert("Atenção", "Informe a Sigla", "error");
        //     $("#btnGravar").prop('disabled', false);
        //     return;
        // }

        //Chama a função de gravar do business de convênio de saúde.
        gravaProcessaBeneficio(id, mesAnoReferencia, projeto,
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
                    // if (verificaRecuperacao === 1) {
                    //     voltar();
                    // } else {
                    novo();
                    // }
                }
            }
        );
    }
</script>