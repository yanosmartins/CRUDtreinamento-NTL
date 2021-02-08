<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PARTICIPARPREGAO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PARTICIPARPREGAO_GRAVAR', $arrayPermissao, true));

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

$page_title = "Participar de Pregões";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['operacao']['sub']['licitacao']['sub']["participarPregao"]["active"] = true;

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
                            <h2>Participar de Pregões</h2>
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
                                                        <div class="row">
                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="portal">Portal</label>
                                                                <label class="select">
                                                                    <select id="portal" name="portal">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM 
                                                                        Ntl.portal WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data</label>
                                                                <label class="input">
                                                                    <input id="dataPregao" name="dataPregao" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Quem Lançou</label>
                                                                <label class="input">
                                                                    <input id="quemLancou" maxlength="255" name="quemLancou" class="" type="select" value="" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option></option>
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="participar">Participar</label>
                                                                <label class="select">
                                                                    <select id="participar" name="participar">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="2">Não</option>
                                                                    </select><i></i>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6 col-auto">
                                                                <label class="label" for="orgaoLicitante">Nome do Orgão Licitante</label>
                                                                <label class="input">
                                                                    <input id="orgaoLicitanteId" type="hidden" value="">
                                                                    <input id="orgaoLicitante" name="orgaoLicitanteFiltro" autocomplete="off" class="form-control" placeholder="Digite o nome do orgão licitante.." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-6 col-auto">
                                                                <label class="label" for="resumoPregao">Resumo do pregão</label>
                                                                <label class="input">
                                                                    <input id="resumoPregao" name="resumoPregao" type="text" autocomplete="on" onkeyup="contaPalavra()">
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label" for="grupo">Grupo Responsável pelo Pregão</label>
                                                                <label class="select">
                                                                    <select id="grupo" name="grupo">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.grupoLicitacao where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label" for="responsavelPregao"> Responsável pelo Pregão</label>
                                                                <label class="select">
                                                                    <select id="responsavelPregao" name="responsavelPregao">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, nome FROM Ntl.responsavel where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $nome = ($row['nome']);
                                                                            echo '<option value=' . $codigo . '>  ' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button id="btnSearch" type="button" class="btn btn-primary pull-right" title="Buscar">
                                            <span class="fa fa-search"></span>
                                        </button>

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
<!--script src="<?php echo ASSETS_URL; ?>/js/businessTabelaBasica.js" type="text/javascript"></script-->
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


<script>
    $(document).ready(function() {

        listarFiltro();

        $('#btnSearch').on("click", function() {
            listarFiltro();
        });

        $("#data").on("change", function() {
            validaCampoData("#data");
        });

        $("#orgaoLicitante").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_licitacaoParticiparPregao.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaNomeOrgaoLicitante",
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
                $("#orgaoLicitanteId").val(ui.item.id);
                $("#orgaoLicitanteFiltro").val(ui.item.nome);
                var orgaoLicitanteId = $("#orgaoLicitanteId").val();
                $("#orgaoLicitante").val(orgaoLicitanteId)
                $("#orgaoLicitanteFiltro").val('');
            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#orgaoLicitanteId").val('');
                    $("#orgaoLicitanteFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };

    });

    function contaPalavra() {
        var resumoPregao = $('#resumoPregao').val();
        var total = resumoPregao.split(' ').length;
        if (total == 21) {
            smartAlert("Atenção", "Máximo de 20 palavras!", "error");
        }
    }


    function listarFiltro() {
        var portal = $('#portal').val();
        var dataPregao = $('#dataPregao').val();
        var quemLancou = $('#quemLancou').val();
        var participar = $('#participar').val();
        var ativo = $('#ativo').val();
        var resumoPregao = $('#resumoPregao').val();
        var orgaoLicitante = $('#orgaoLicitante').val();
        var grupo = $('#grupo').val();
        var responsavel = $('#responsavelPregao').val();

        $('#resultadoBusca').load('licitacao_participarPregaoFiltroListagem.php?', {
            portal: portal,
            dataPregao: dataPregao,
            quemLancou: quemLancou,
            ativo: ativo,
            participar: participar,
            resumoPregao: resumoPregao,
            orgaoLicitante: orgaoLicitante,
            grupo: grupo,
            responsavel: responsavel
        });
    }
</script>