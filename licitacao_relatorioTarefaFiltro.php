<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('RELATORIOTAREFA_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('RELATORIOTAREFA_GRAVAR', $arrayPermissao, true));

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

$page_title = "Pregões Não Iniciados";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["licitacao"]["sub"]["operacao"]["sub"]["relatorioTarefas"]["active"] = true;

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
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Relatório de Tarefas</h2>
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
                                                        <div class="row" autocomplete="off">
                                                            <section class="col col-3 col-auto">
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
                                                            <section class="col col-3">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option></option>
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-6 col-auto">
                                                                <label class="label" for="orgaoLicitante">Nome do Orgão Licitante</label>
                                                                <label class="input">
                                                                    <input id="orgaoLicitanteId" type="hidden" value="">
                                                                    <input id="orgaoLicitante" name="orgaoLicitanteFiltro" autocomplete="off" class="form-control" placeholder="Digite o nome do orgão licitante.." type="text" value="">
                                                                    <i class="icon-append fa fa-filter"></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row"> 
                                                            <section class="col col-3 col-auto">
                                                            <label class="label" for="numeroPregao">Número do Pregão</label>
                                                                <label class="input">
                                                                    <input id="numeroPregao" name="numeroPregao" type="text" autocomplete="off" maxlength="30" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="situacao">Situação</label>
                                                                <label class="select">
                                                                    <select id="situacao" name="situacao">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM 
                                                                        Ntl.situacao WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section> 
                                                            <section class="col col-3 col-auto">
                                                            <label class="label" for="responsavel">Responsável</label>
                                                                <label class="select">
                                                                    <select id="responsavel" name="responsavel">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, nome FROM Ntl.responsavel where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $nome = ($row['nome']);
                                                                            echo '<option value=' . $codigo . '>  ' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="tarefaConcluida">Tarefa Concluída</label>
                                                                <label class="select">
                                                                    <select id="tarefaConcluida" name="tarefaConcluida">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0" selected>Não</option>
                                                                    </select><i></i>
                                                            </section> 
                                                            </div>
                                                            <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="dataReabertura">Data Reabertura do Pregão</label>
                                                                <label class="input">
                                                                    <input id="dataReabertura" name="dataReabertura" type="text" data-dateformat="dd/mm/yy" data-mask-placeholder="-" class="datepicker" style="text-align: center" data-mask="99/99/9999" placeholder="--/--/----" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="horaReabertura">Hora do Pregão</label>
                                                                <label class="input">
                                                                    <input id="horaReabertura" name="horaReabertura" type="text" autocomplete="off" placeholder="hh:mm">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                            <label class="label" for="tarefa">Tarefa</label>
                                                                <label class="select">
                                                                    <select id="tarefa" name="tarefa">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao FROM 
                                                                        Ntl.tarefa WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="tipoTarefa">Tipo Tarefa</label>
                                                                <label class="select">
                                                                    <select id="tipoTarefa" name="tipoTarefa">
                                                                        <option></option>
                                                                        <option value="0">Pré-Pregão</option> 
                                                                        <option value="1">Pós-Pregão</option>
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


        $('#horaReabertura').mask('99:99', {
            placeholder: "hh:mm"
        });

        $('#btnSearch').on("click", function() {
            listarFiltro();
        });

        //Pesquisa automática do orgão licitante.
        $("#orgaoLicitante").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroPregaoCadastro.php',
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

    function listarFiltro() { 
        
        var portal = $('#portal').val();
        var ativo = $('#ativo').val();
        var orgaoLicitante = $('#orgaoLicitante').val();   
        var numeroPregao = $('#numeroPregao').val(); 
        var situacao = $('#situacao').val();
        var responsavel = $('#responsavel').val();
        var tarefaConcluida = $('#tarefaConcluida').val();
        var dataReabertura = $('#dataReabertura').val();
        var horaReabertura = $('#horaReabertura').val();
        var tarefa = $('#tarefa').val();  
        var tipoTarefa = $('#tipoTarefa').val();

        $('#resultadoBusca').load('licitacao_relatorioTarefaFiltroListagem.php?', {
            portal: portal,
            ativo:ativo, 
            orgaoLicitante:orgaoLicitante,
            numeroPregao:numeroPregao,
            situacao:situacao,
            responsavel:responsavel,
            tarefaConcluida:tarefaConcluida,    
            dataReabertura:dataReabertura,
            horaReabertura:horaReabertura,
            tarefa:tarefa,
            tipoTarefa:tipoTarefa
        });

    }


    function novo() {
        $(location).attr('href', 'pregoesEmAndamentoCadastro.php');
    }
</script>