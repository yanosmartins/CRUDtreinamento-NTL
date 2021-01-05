<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('VALORPOSTO_ACESSAR', $arrayPermissao, true));


if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Valor do Posto";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['cadastro']['sub']['valorPosto']['active'] = true;
// $page_nav["cadastrar"]["sub"]["Lista de Clientes"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Controle de Permissão"] = "";
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
                            <h2>Valor do Posto</h2>
                        </header>

                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formValorPosto" method="post">
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
                                                        <input id="codigo" name="codigo" type="text" class="hidden">

                                                        <div class="row">

                                                            <section class="col col-4">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="">
                                                                    <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT P.codigo, P.numeroCentroCusto, P.descricao, P.apelido, C.projeto
                                                                        FROM Ntl.projeto P 
                                                                        LEFT JOIN Ntl.contrato C ON projeto = P.codigo 
                                                                        order by codigo ";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            $numeroCentroCusto  = ($row['numeroCentroCusto']);
                                                                            $apelido = ($row['apelido']);
                                                                            echo '<option value=' . $codigo . '>  ' . $numeroCentroCusto . ' - ' . $apelido . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Descrição do Posto</label>
                                                                <label class="select">
                                                                    <select id="descricaoPosto" name="descricaoPosto" class="">
                                                                    <option style="display:none;">Selecione</option>
                                                                        <?php                                                                
                                                                        $sql =  "SELECT codigo, descricao
                                                                        FROM Ntl.posto 
                                                                        order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  '.$descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Valor do Posto</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" style="text-align: right;" id="valor" name="valor" class="decimal-2-casas" />
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Hora Extra Seg/Sab</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="horaExtraSegSab" name="horaExtraSegSab" style="text-align: right;" type="text" autocomplete="off">
                                                                </label>
                                                            </section> 
                                                            <section class="col col-2">
                                                                <label class="label">Hora Extra Dom/Fer</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="horaExtraDomFer" name="horaExtraDomFer" style="text-align: right;" type="text" autocomplete="off">

                                                                </label>
                                                            </section> 

                                                            <section class="col col-2">
                                                                <label class="label">Adicional Noturno</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="adicionalNoturno" name="adicionalNoturno" style="text-align: right;" type="text" autocomplete="off">

                                                                </label>
                                                            </section> 

                                                            <section class="col col-2">
                                                                <label class = "label">Atrasos (Incidência)</label>
                                                                <label class = "select">
                                                                    <select id="atrasos" name="atrasos" type="text" autocomplete="off">
                                                                    <option style="display:none;">Selecione</option>
                                                                        <option value="1">Salario</option>
                                                                        <option value="0">Valor do Posto</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="select">
                                                                    <select name="ativo" id="ativo" class="hidden" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option value="1" selected>Sim</option>
                                                                    </select>
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

                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" >
                                            <span class="fa fa-file-o"></span>
                                        </button>
                                        <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                            <span class="fa fa-backward "></span>
                                        </button>

                                        
                                    </footer>
                                </form>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroValorPosto.js" type="text/javascript"></script>

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
            $(location).attr('href', 'cadastro_valorPostoCadastro.php');
        });
        $('#btnVoltar').on("click", function() {
            $(location).attr('href', 'cadastro_valorPostoFiltro.php');
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#btnExcluir").on("click", function() {
            excluir();
        });
        carregaPagina();
       
        $('#horaExtraSegSab').focusout(function() {
            var horaExtraSegSab, element;
            element = $(this);
            element.unmask();
            horaExtraSegSab = element.val().replace(/\D/g, '');
            if (horaExtraSegSab.length > 4) {
                element.mask("999.99");
            } else {
                element.mask("99.99?9");
            }
        }).trigger('focusout');

        $('#horaExtraDomFer').focusout(function() {
            var horaExtraDomFer, element;
            element = $(this);
            element.unmask();
            horaExtraDomFer = element.val().replace(/\D/g, '');
            if (horaExtraDomFer.length > 4) {
                element.mask("999.99");
            } else {
                element.mask("99.99?9");
            }
        }).trigger('focusout');
        $('#adicionalNoturno').focusout(function() {
            var adicionalNoturno, element;
            element = $(this);
            element.unmask();
            adicionalNoturno = element.val().replace(/\D/g, '');
            if (adicionalNoturno.length > 4) {
                element.mask("999.99");
            } else {
                element.mask("99.99?9");
            }
        }).trigger('focusout');

    });

    function novo() {
        $(location).attr('href', 'cadastro_valorPostoCadastro.php');
    }

    


    function gravar() {
        $("#btnGravar").prop('disabled', true);
        $("#ativo").val(1);

        let valorPosto = $('#formValorPosto').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        gravaValorPosto(valorPosto,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
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
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirValorPosto(id, function(data) {
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
        });
    }

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaValorPosto(idd,
                    function(data) {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");

                        //Atributos de Contrato
                        var mensagem = piece[0];
                        var out = piece[1];


                        piece = out.split("^");
                        console.table(piece);
                        //Atributos de cliente 
                        debugger;
                        var codigo = +piece[0];
                        var projeto = piece[1];
                        var descricaoPosto = piece[2];
                        var valor = piece[3];
                        var horaExtraSegSab = piece[4];
                        var horaExtraDomFer = piece[5];
                        var adicionalNoturno = piece[6];
                        var atrasos = piece[7];
                        var ativo = piece[8];
                        



                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#projeto").val(projeto);
                        $("#descricaoPosto").val(descricaoPosto);
                        $("#valor").val(valor);
                        $("#horaExtraSegSab").val(horaExtraSegSab);
                        $("#horaExtraDomFer").val(horaExtraDomFer);
                        $("#adicionalNoturno").val(adicionalNoturno);
                        $("#atrasos").val(atrasos);
                        $("#ativo").val(ativo);
                       

                    }

                );
            }
        }


    }
</script>