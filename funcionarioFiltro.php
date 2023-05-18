<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
// $condicaoAcessarOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('USUARIO_GRAVAR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Funcionário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["funcionario"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Configurações"] = "";
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
                            <h2>Funcionário</h2>
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
                                                            <section class="col col-2">
                                                                <label class="label">Nome do funcionário:</label>
                                                                <label class="input">
                                                                    <input id="nome" maxlength="255" name="nome" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">RG:</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="rg" name="rg" class="rg-mask" type="text" value="" placeholder="XX.XXX.XXX-X">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Nascimento:</label>
                                                                <label class="input">
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" class="datepicker" data-dateformat="dd/mm/yy" value="" placeholder="XX/XX/XXXX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CPF:</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="cpf" name="cpf" cpf-mask" type="text" value="" placeholder="XXX.XXX.XXX-XX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="estadoCivil">Estado Civil:</label>
                                                                <label class="select">
                                                                    <select id="estadoCivil" name="estadoCivil">
                                                                        <option value="" selected>Todos</option>
                                                                        <option value="1">Solteiro</option>
                                                                        <option value="2">Casado</option>
                                                                        <option value="3">Separado</option>
                                                                        <option value="4">Divorciado</option>
                                                                        <option value="5">Viúvo</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="ativo">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option value="" selected>Todos</option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Gênero</label>
                                                                <label class="select">
                                                                    <select id="genero" name="genero">
                                                                        <option value="" selected>Todos</option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao 
                                                                        FROM dbo.generoFuncionario where generoAtivo = 1 ORDER BY codigo";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Nascimento - Início</label>
                                                                <label class="input">
                                                                    <input id="dataNascimentoInicio" name="dataNascimentoInicio" type="text" class="datepicker" data-dateformat="dd/mm/yy" value="" placeholder="XX/XX/XXXX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Nascimento - Fim</label>
                                                                <label class="input">
                                                                    <input id="dataNascimentoFim" name="dataNascimentoFim" type="text" class="datepicker" data-dateformat="dd/mm/yy" value="" placeholder="XX/XX/XXXX">
                                                                </label>

                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CEP:</label>
                                                                <label class="input">
                                                                    <input id="cep" name="cep" type="text" value="" placeholder="XXXXX-XXX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Primeiro Emprego:</label>
                                                                <label class="select">
                                                                    <select id="primeiroEmprego">
                                                                        <option value="" selected>Todos</option>
                                                                        <option value="0">Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2" id="pisSection">
                                                                <label class="label">PIS/PASEP:</label>
                                                                <label class="input">
                                                                    <input id="pispasep" type="text">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <footer>
                                                    <button id="btnSearch" name="btnSearch" type="button" class="btn btn-primary pull-right" title="Buscar">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <button id="btnNovo" name="btnNovo" type="button" class="btn btn-primary pull-right" title="Novo">
                                                        <span class="fa fa-file-o"></span>
                                                    </button>
                                                    <button id="btnPdfLista" type="button" class="btn btn-danger pull-right" title="Novo">
                                                        <span class="fa fa-file-pdf-o"></span>
                                                    </button>                                                  
                                                   
                                                    </footer>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="resultadoBusca">
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
    $("#cpf").mask('999.999.999-99');
    $("#rg").mask('99.999.999-9');
    $("#dataNascimento").mask('99/99/9999');
    $("#dataNascimentoInicio").mask('99/99/9999');
    $("#dataNascimentoFim").mask('99/99/9999');
    $("#pispasep").mask('999.99999.99-9');
    $("#cep").mask('99999-999');

    $(document).ready(function() {

        $("#dataNascimentoFim").on("change", function() {
            validarDataFim();
        });

        $("#primeiroEmprego").on("change", function() {
            let primeiroEmprego = ($("#primeiroEmprego").val())

            if (primeiroEmprego == 1) {
                $("#pispasep").addClass("readonly");
                $("#pispasep").prop("disabled", true);
                $("#pispasep").val('');
            } else if (primeiroEmprego == 0) {
                $("#pispasep").val('');
                $("#pispasep").prop("disabled", false);
                $("#pispasep").removeAttr("disabled");
                $("#pispasep").removeClass("readonly");

            }
        });



        $('#btnSearch').on("click", function() {
            // if(validarDataFim == true)
            listarFiltro();
        });

        $('#btnNovo').on("click", function() {
            novo();
        });
        $('#btnPdfLista').on("click", function() {
            pdfFuncionario();
        });

    })

    function validarDataFim() {
        var dataAgora = new Date();
        var dd = dataAgora.getDate();
        var mm = (dataAgora.getMonth() + 1);
        var yyyy = dataAgora.getFullYear();

        var dataHoje = dd + "/" + mm + "/" + yyyy;

        var dataNascimentoFim = $('#dataNascimentoFim').val();
        if (dataNascimentoFim > dataHoje) {
            $("#dataNascimentoFim").focus();
            $("#dataNascimentoFim").val('');
            smartAlert("Erro", "Data final inválida.", "error");
        }
    }

    function listarFiltro() {
        var nome = $('#nome').val();
        var cpf = $('#cpf').val();
        var dataNascimento = $('#dataNascimento').val();
        var rg = $('#rg').val();
        var estadoCivil = $('#estadoCivil').val();
        var ativo = $('#ativo').val();
        var dataNascimentoInicio = $('#dataNascimentoInicio').val();
        var dataNascimentoFim = $('#dataNascimentoFim').val();
        var genero = $('#genero').val();
        var cep = $('#cep').val();
        var primeiroEmprego = $('#primeiroEmprego').val();
        var pisPasep = $('#pispasep').val();

        $('#resultadoBusca').load('funcionarioFiltroListagem.php?', {
            nomeFiltro: nome,
            cpfFiltro: cpf,
            dataNascimentoFiltro: dataNascimento,
            dataNascimentoInicioFiltro: dataNascimentoInicio,
            dataNascimentoFimFiltro: dataNascimentoFim,
            rgFiltro: rg,
            estadoCivilFiltro: estadoCivil,
            generoFiltro: genero,
            ativoFiltro: ativo,
            cepFiltro: cep,
            primeiroEmpregoFiltro: primeiroEmprego,
            pisPasepFiltro: pisPasep
        });
    }

    function novo() {
        $(location).attr('href', 'cadastroFuncionario.php');
    }
    function pdfFuncionario() {
        // var id = id OU codigo
        $(location).attr('href', 'pdfColetivo.php');
    }
</script>