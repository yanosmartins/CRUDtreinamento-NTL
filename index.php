<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */
session_start();
$id = $_SESSION['funcionario'];

$page_title = "Home";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$page_css[] = "style_index.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["home"]["active"] = true;
include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="">
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
                                                        Home
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="codigo" name="codigo" type="text" class="hidden">
                                                        <input id="idFolha" name="idFolha" type="text" class="hidden">
                                                        <div class="row ">
                                                            <div class=" row text-center" style="margin-bottom: 10px;">
                                                                <h2 style="font-weight:bold;">Área do Funcionário</h2>
                                                                <h5>
                                                                    <div id="diaAtual" name="diaAtual" style="font-size: 17px;">
                                                                    </div>
                                                                    <script>
                                                                        dataAtual()

                                                                        function dataAtual() {
                                                                            meses = new Array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
                                                                            semana = new Array("Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado");

                                                                            var dataAtual = new Date(),
                                                                                diaext;
                                                                            var dia = dataAtual.getDate();
                                                                            var dias = dataAtual.getDay();
                                                                            var mes = dataAtual.getMonth();
                                                                            var ano = dataAtual.getFullYear();

                                                                            diaext = semana[dias] + ", " + dia + " de " + meses[mes] + " de " + ano;
                                                                            document.getElementById("diaAtual").innerHTML = diaext;


                                                                        }
                                                                    </script>

                                                                </h5>
                                                                <script>
                                                                    var myVar = setInterval(myTimer, 1000);

                                                                    function myTimer() {
                                                                        var d = new Date(),
                                                                            displayDate;
                                                                        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
                                                                            displayDate = d.toLocaleTimeString('pt-BR');
                                                                        } else {
                                                                            displayDate = d.toLocaleTimeString('pt-BR', {
                                                                                timeZone: 'America/Sao_Paulo'
                                                                            });
                                                                        }
                                                                        document.getElementById("hora").innerHTML = displayDate;
                                                                        $("#horaAtual").val(displayDate);
                                                                    }
                                                                </script>
                                                                <div id="hora" style="font-size: 17px;">
                                                                </div>
                                                                <div class="#"><br>
                                                                    <h4>Bem vindo, <span id="#"><?php
                                                                                                $reposit = new reposit();

                                                                                                $mesAtual = strftime('%Y-%m-01', strtotime('today'));

                                                                                                $sql = "SELECT dataUltimoAso,codigo,funcionario FROM Funcionario.atestadoSaudeOcupacional WHERE funcionario = " . $_SESSION['funcionario'] . "";
                                                                                                $result = $reposit->RunQuery($sql);
                                                                                                if ($row = $result[0]) {;
                                                                                                    $codigoAso = $row['codigo'];
                                                                                                    $ultimoAso = $row['dataUltimoAso'];
                                                                                                    $funcionarioAso = $row['funcionario'];
                                                                                                    echo "<input id=\"ultimoAso\" name=\"ultimoAso\" value =\"" . $ultimoAso  . "\"  class=\"hidden\">";
                                                                                                    echo "<input id=\"codigoAso\" name=\"codigoAso\" value =\"" . $codigoAso  . "\"  class=\"hidden\">";
                                                                                                    echo "<input id=\"funcionarioAso\" name=\"funcionarioAso\" value =\"" . $funcionarioAso  . "\"  class=\"hidden\">";
                                                                                                }



                                                                                                $sql = "SELECT F.codigo, F.nome, FO.mesAno,FO.codigo as codigoFolha, FO.funcionario
                                                                                                FROM Ntl.funcionario F
                                                                                                LEFT JOIN Funcionario.folhaPontoMensal FO ON FO.funcionario = F.codigo
                                                                                                WHERE F.dataDemissaoFuncionario IS NULL AND F.ativo = 1 AND F.codigo = " . $_SESSION['funcionario'] . " AND FO.mesAno = '$mesAtual'";
                                                                                                $result = $reposit->RunQuery($sql);

                                                                                                if ($row != $result[0]) {
                                                                                                    $sql = "SELECT codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL AND codigo = " . $_SESSION['funcionario'];
                                                                                                    $result = $reposit->RunQuery($sql);
                                                                                                }


                                                                                                if ($row = $result[0]) {

                                                                                                    $codigoFolha = $row['codigoFolha'];

                                                                                                    $codigo = $row['codigo'];
                                                                                                    $nome = $row['nome'];
                                                                                                    echo "<input id=\"mesAno\" name=\"mesAno\" value =\"" . $mesAtual  . "\"  class=\"hidden\">" .
                                                                                                        "<input id=\"codigoFolha\" name=\"codigoFolha\" value =\"" . $codigoFolha  . "\"  class=\"hidden\">";
                                                                                                }
                                                                                                echo "<option id=\"funcionario\" name=\"funcionario\" value= \"" . $codigo . "\" selected>" . $nome . "</option>";

                                                                                                ?>
                                                                        </span></h4>
                                                                </div>


                                                            </div>

                                                        </div>

                                                        <div class="col col-md-1"><br>
                                                            <div class="form-group">
                                                                <div class="input-group" data-align="top" data-autoclose="true">
                                                                    <input id="xx" name="xx" type="text" class="hidden" style="height: 40px; border-radius: 0px !important;" data-autoclose="true" value="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col col-md-10">

                                                            <div class="col col-md-2">
                                                                <button type="button" class="btn  btnBaterPonto" name="btnBaterPonto" id="btnBaterPonto">
                                                                    <span class="fa fa-clock-o fa-2x"></span><br>Bater Ponto
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-md-2">
                                                                <button type="button" class="btn  btnPontoMensal" id="btnPontoMensal">
                                                                    <span class="fa fa-calendar fa-2x"></span><br> Ponto Mensal
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-md-2">
                                                                <button type="button" class="btn  btnFolhaMensal" id="btnFolhaMensal">
                                                                    <span class="fa fa-file fa-2x"></span><br> Folha Mensal
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-md-2">
                                                                <button type="button" class="btn  btnFolhaPreenchida" disabled="disabled" id="btnFolhaPreenchida">
                                                                    <span class="fa fa-file-text fa-2x"></span><br>Folha Mensal <br> Preenchida
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-md-2">
                                                                <button type="button" class="btn  btnContracheque" id="btnContracheque">
                                                                    <span class="fa fa-money fa-2x"></span><br>Contracheque
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-md-2">
                                                                <button type="button" class="btn  btnAso" id="btnAso">
                                                                    <span class="fa fa fa-stethoscope fa-2x"></span><br>Consulta ASO
                                                                </button><br>
                                                            </div>

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
    <div class="modal fade" id="parametroLinkModalPanel" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" style="height:90%; ">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button> -->
                    <h4 class="modal-title"> Alterar senha</h4>
                </div>
                <div id="parametroLinkModalBody" class="modal-body smart-form" style="min-height:350px;">
                    <section class="col col-auto">
                        <p>-Senha não pode conter espaços.</p>
                        <p>-Senha deve possuir no mínimo 7 e no máximo 15.</p>
                        <p>-Senha deve possuir caracter especial ! # $ & * - + ? . ; , : ] [ ( )</p>
                        <p>-Senha deve possuir no mínimo um caractér númerico e um caractér alfabético.</p>
                        <p>-Senha não pode ter caracteres acentuados.</p>
                    </section>
                    <section class="col col-12">
                        <label class="label">Senha</label>
                        <label class="input">
                            <input id="senha" maxlength="20" name="senha" type="password" class="required" value="">
                        </label>
                    </section>
                    <section class="col col-12">
                        <label class="label">Confirma Senha</label>
                        <label class="input">
                            <input id="senhaConfirma" maxlength="20" name="senhaConfirma" type="password" class="required" value="">
                        </label>
                    </section>
                    <section class="col col-12">
                        <button type="button" id="btnAlterarSenha" class="btn btn-success" aria-hidden="true" title="btnAlterarSenha" style="display:<?php echo $esconderBtnGravar ?>">
                            <b>ALTERAR SENHA</b>
                        </button>
                    </section>
                </div>


                <!-- <div class="modal-footer">
                   
                </div> -->
            </div>
        </div>
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

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/businessUsuario.js" type="text/javascript"></script>
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
        $('span.minifyme').trigger("click");



        $("#btnBaterPonto").on("click", function() {
            $(location).attr('href', 'prototipo_pontoEletronicoDiario.php');
        });

        $("#btnPontoMensal").on("click", function() {
            const id = $('#funcionario').val();
            const folha = $('#codigoFolha').val();
            const mesAno = $('#mesAno').val();
            $(location).attr('href', `funcionario_folhaPontoMensalCadastro.php`);
        });
        $("#btnAso").on("click", function() {
            const id = $('#funcionarioAso').val();
            const asoId = $('#codigoAso').val();
            const ultimoAso = $('#ultimoAso').val();
            if (!ultimoAso) {
                smartAlert("Atenção", "O Funcionário não tem data de último ASO", "error");
                return
            }
            $(location).attr('href', `funcionario_atestadoSaudeOcupacional.php?aso=${asoId}&id=${id}&ultimoAso=${ultimoAso}`);
        });
        

        $("#btnFolhaMensal").on("click", function() {
            $(location).attr('href', 'funcionario_folhaDePontoPdf.php?id=<?php echo $id ?>');

        });

        $("#btnFolhaPreenchida").on("click", function() {
            const id = $('#funcionario').val();
            const folha = $('#codigoFolha').val();
            const mesAno = $('#mesAno').val();
            if (!folha) {
                smartAlert("Atenção", "Funcionário não tem folha Preenchida deste Mês", "error");
                return
            }
            $(location).attr('href', `funcionario_folhaDePontoPdfPontoEletronico.php?id=${id}&folha=${folha}&data=${mesAno}`);
        });

        $("#btnContracheque").on("click", function() {
            $(location).attr('href', 'http://www.contrachequeweb.com.br/ntl/');
        });

        $('#parametroLinkModalPanel').on('hide.bs.modal', (e) => {
            e.preventDefault();
            e.stopPropagation();
        });

        $("#btnAlterarSenha").on("click", function() {
            var senha = $('#senha').val();
            var senhaConfirma = $('#senhaConfirma').val();
            if (!senha || !senhaConfirma) {
                smartAlert("Atenção", "Informe sua senha", "error");
                return;
            }
            gravarNovaSenha();
        });

        carregaPagina();
    });

    function carregaPagina() {
        recuperaDadosUsuario(
            function(data) {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                //Atributos de Cliente
                var mensagem = piece[0];
                var out = piece[1];

                piece = out.split("^");
                console.table(piece);
                //Atributos de cliente 
                var codigo = parseInt(piece[0]);
                var restaurarSenha = +piece[1];

                if (restaurarSenha) {
                    $('#parametroLinkModalPanel').modal();
                }

                //Atributos de cliente        
                // $("#codigo").val(codigo);
                // $("#descricao").val(descricao);
            }
        );
    }

    function gravarNovaSenha() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#gravarNovaSenha").prop('disabled', true);
        var senhaConfirma = $("#senhaConfirma").val();
        var senha = $("#senha").val();

        gravaNovaSenha(senha, senhaConfirma,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#senha").val('');
                        $("#senhaConfirma").val('');
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    $(location).attr('href', 'login.php');
                }
            }
        );
    }
</script>