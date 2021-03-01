<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('LOCALIZACAO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('LOCALIZACAO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('LOCALIZACAO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Ponto Eletrônico";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["funcionario"]["sub"]["folhaPonto"]["active"] = true;
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
            <!-- <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/cadastroLocalizacao.php" style="float:right"></a>
                <?php } ?>
            </div> -->

            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Funcionário
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formLocalizacao" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Ponto Eletrônico
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden">
                                                        <div class="row ">
                                                            <section class=" row text-center" style="margin-bottom: 10px;">
                                                                <h2 style="font-weight:bold;">Ponto Eletrônico</h2>
                                                                <h5>
                                                                    <?php
                                                                    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese.utf-8');
                                                                    date_default_timezone_set('America/Sao_Paulo');
                                                                    echo utf8_encode(ucwords(strftime('%A, ', $var_DateTime->sec)));
                                                                    echo strftime('%d de %B de %Y.', strtotime('today'));
                                                                    ?>
                                                                </h5>
                                                                Horário de Brasília
                                                                <?php
                                                                $hora = date('H:i:s.');
                                                                echo $hora
                                                                ?>
                                                            </section>
                                                        </div>

                                                        <div class="primeirasessao">
                                                            <div class="col col-md-6" style=" height: 185px; background-color:#3A3633; color: #c4c4c4;"><br>
                                                                <h3>Login: <span id="#">NTL_FILLIPYMONTEIRO</span></h3><br>
                                                                <h3>Matricula: <span id="#">25936</span></h3><br>
                                                                <h3>Funcionario: <span id="#">Fillipy José Pessoa Ferreira Monteiro</span></h3><br>
                                                                <h3>Projeto: <span id="#">NTL - Nova Tecnologia</span></h3>
                                                            </div>
                                                            <div class="marcacao">
                                                                <section class="col col-1">
                                                                    <label class="input">
                                                                        <input class="hidden">
                                                                    </label>
                                                                </section>
                                                                <section class="col-xs-2">
                                                                    <button type="button" class="btn  btn-block botaoentrada" style="height: 80px; background-color:#4F8D4A;">
                                                                        <i class="fa fa-sign-in"></i><br>Entrada
                                                                    </button>


                                                                    <button type="button" class="btn  btn-block botaosaida" style="height: 85px;  margin-top:10px; background-color:#C32E2E;">
                                                                        <i class="fa fa-sign-out"></i><br>Saida
                                                                    </button>
                                                                </section>

                                                                <section class="col col-0">
                                                                    <label class="input">
                                                                        <input class="hidden">
                                                                    </label>
                                                                </section>

                                                                <section class="col-xs-2">
                                                                    <button type="button" class="btn  btn-block botaopausa" style=" background: #2386A6;border-radius: 5px; height:80px;color: white;font-size: 16px;font-weight: bold;">
                                                                        <i class="fa fa-cutlery"></i><br> Inicio almoço
                                                                    </button>

                                                                    <button type="button" class="btn  btn-block botaoretornopausa" style="background: #FDD033;border-radius: 5px; height:85px; color: white; font-size: 16px; font-weight: bold; margin-top:10px;">
                                                                        <i class="fa fa-cutlery"></i><br> Fim almoço
                                                                    </button>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6"><br>
                                                                <label class="label" for="lancamento">Ocorrência/Lançamento</label>
                                                                <label class="select">
                                                                    <select id="lancamento" name="lancamento" style="height: 40px;" class="" readonly>
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo, descricao from Ntl.lancamento where ativo = 1 order by descricao";
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
                                                            <section class="col col-1">
                                                                <label class="input">
                                                                    <input class="hidden">
                                                                </label>
                                                            </section>
                                                            <section class="col-md-2"><br>
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Atraso</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="horaAtraso" name="horaAtraso" type="text" class="text-center form-control" style="height: 40px;" placeholder="00:20:38" data-autoclose="true" value="" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </section>

                                                            <section class="col col-0">
                                                                    <label class="input">
                                                                        <input class="hidden">
                                                                    </label>
                                                                </section>

                                                            <section class="col-md-2"><br>
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Hora Extra</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="horaHoraExtra" name="horaHoraExtra" type="text" class="text-center form-control" style="height: 40px;" placeholder="00:20:38" data-autoclose="true" value="" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
<script src="<?php echo ASSETS_URL; ?>/js/business_tabelaBasicaLocalizacao.js" type="text/javascript"></script>
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


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $('#btnNovo').on("click", function() {
            novo();
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

        carregaLocalizacao();
    });

    function voltar() {
        $(location).attr('href', 'tabelaBasica_localizacaoFiltro.php');
    }

    function novo() {
        $(location).attr('href', 'tabelaBasica_localizacaoCadastro.php');
    }

    function gravar() {
        $("#btnGravar").prop('disabled', true);
        var descricao = $("#descricao").val();
        var id = +$('#codigo').val();
        var ativo = +$('#ativo').val();
        if (!descricao) {
            smartAlert("Erro", "Informe a Localização.", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        gravaLocalizacao(id, ativo, descricao,
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

        if (codigo === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirLocalizacao(id, function(data) {
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

    function carregaLocalizacao() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaLocalizacao(idd,
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
                        var descricao = piece[1];
                        var ativo = +piece[2];
                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#descricao").val(descricao);
                        $("#ativo").val(ativo);

                    }
                );
            }
        }
    }
</script>