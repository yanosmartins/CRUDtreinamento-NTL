<?php
//initilize the page
require_once("inc/init.php");


//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");


//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PONTOELETRONICODIARIO_ACESSAR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Ponto Eletrônico Diário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$page_css[] = "style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['funcionario']['sub']["controlePontoDiario"]["active"] = true;

include("inc/nav.php");
?>
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Área do Funcionário"] = "";
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
                                                        Ponto Eletrônico
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
                                                                <h2 style="font-weight:bold;">Ponto Eletrônico</h2>
                                                                <h5>
                                                                    <?php
                                                                    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese.utf-8');
                                                                    date_default_timezone_set('America/Sao_Paulo');
                                                                    echo ucwords(strftime('%A, '));
                                                                    $data = strftime('%d de %B de %Y.', strtotime('today'));

                                                                    $dia = date("d");
                                                                    echo $data . " <input id=\"dia\" name=\"dia\" type=\"text\" class=\"text-center form-control readonly hidden\" readonly data-autoclose=\"true\" value=\"" . $dia . "\">";


                                                                    ?>
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
                                                                    <h4>Funcionário: <span id="#"><?php
                                                                                                    $reposit = new reposit();


                                                                                                    $sql = "select F.codigo, F.nome from Ntl.funcionario F where F.dataDemissaoFuncionario IS NULL AND F.ativo = 1 AND F.codigo = " . $_SESSION['funcionario'];
                                                                                                    $result = $reposit->RunQuery($sql);
                                                                                                    if ($row = $result[0]) {

                                                                                                        $codigo = (int) $row['codigo'];
                                                                                                        $nome = $row['nome'];
                                                                                                        echo '<option id="funcionario" name="funcionario" value= ' . $codigo . ' selected>' . $nome . '</option>';
                                                                                                    }
                                                                                                    ?></span></h4>
                                                                </div>
                                                                <h4>Expediente: <span id="#">
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, funcionario,horaEntrada,horaSaida from Ntl.beneficioProjeto where ativo = 1 AND funcionario = " . $_SESSION['funcionario'];
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $horaEntrada = $row['horaEntrada'];
                                                                            $horaSaida = $row['horaSaida'];
                                                                            $funcionario = $row['funcionario'];
                                                                            if ($funcionario == $_SESSION['funcionario']) {
                                                                                echo '<option id="expediente" name="expediente" data-funcionario="' . $funcionario . '" value="' . $codigo . '" selected>' . $horaEntrada . " - " . $horaSaida . '</option>';
                                                                            } else {
                                                                                echo '<option id="expediente" name="expediente" data-funcionario="' . $funcionario . '" value="' . $codigo . '">' . $horaEntrada . " - " . $horaSaida . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </span></h4>

                                                            </div>

                                                        </div>

                                                        <div class="col col-xs-12" style="margin-top: 15px;">

                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnEntrada" name="btnEntrada" id="btnEntrada" style="height: 100px; background-color:#05ad4f;">
                                                                    <span class="fa fa-sign-in"></span><br>Entrada
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnInicioAlmoco" id="btnInicioAlmoco" style=" background: #29c4e3; height:100px;">
                                                                    <span class="fa fa-cutlery "></span><br> Inicio almoço
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnFimAlmoco" id="btnFimAlmoco" style="background: #d9d216; height:100px; ">
                                                                    <span class="fa fa-cutlery"></span><br> Fim almoço
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnSaida" id="btnSaida" style="height: 100px;  background-color:#c42121;">
                                                                    <span class="fa fa-sign-out"></span><br>Saida
                                                                </button><br>
                                                            </div>


                                                        </div>

                                                        <div class="col col-xs-12">
                                                            <div class="col col-md-6"><br>
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
                                                            </div>
                                                            <div class="col col-md-6">
                                                                <div class="col col-md-6"><br>
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Atraso</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="atraso" name="atraso" type="text" class="text-center form-control" style="height: 40px; border-radius: 0px !important;" placeholder="00:20:38" data-autoclose="true" value="" readonly>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-md-6"><br>
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Hora Extra</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="horaExtra" name="horaExtra" type="text" class="text-center form-control" style="height: 40px; border-radius: 0px !important;" placeholder="00:20:38" data-autoclose="true" value="" readonly>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input id="mesAno" name="mesAno" type="text" class="hidden">
                                                                <input id="horaAtual" name="horaAtual" type="text" class="hidden">
                                                                <input id="horaEntrada" name="horaEntrada" type="text" class="hidden">
                                                                <input id="horaSaida" name="horaSaida" type="text" class="hidden">
                                                                <input id="inicioAlmoco" name="inicioAlmoco" type="text" class="hidden">
                                                                <input id="fimAlmoco" name="fimAlmoco" type="text" class="hidden">
                                                                <input id="status" name="status" type="text" class="hidden">
                                                            </div>
                                                        </div>
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
    </div>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_prototipoPontoEletronicoDiario.js" type="text/javascript"></script>
<!-- <script src="<?php echo ASSETS_URL; ?>/js/girComum.php"></script> -->

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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/momentjs-business.js"></script>

<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>




<script language="JavaScript" type="text/javascript">
    var toleranciaExtra = '05:00';
    var toleranciaAtraso = '05:00';
    $(document).ready(function() {

        $("#btnEntrada").on("click", function() {
            var horaAtual = $("#horaAtual").val()
            $("#horaEntrada").val(horaAtual)
            gravar()
        });

        $("#btnSaida").on("click", function() {
            var horaAtual = $("#horaAtual").val()
            $("#horaSaida").val(horaAtual)
            gravar()
        });

        $("#btnInicioAlmoco").on("click", function() {
            var horaAtual = $("#horaAtual").val()
            let separador = horaAtual.split(':');
            let h = separador[0];
            let m = separador[1];
            let s = separador[2];

            var hora = `${h}:${m}`;
            $("#inicioAlmoco").val(hora)
            gravar()
        });

        $("#btnFimAlmoco").on("click", function() {
            var horaAtual = $("#horaAtual").val()

            let separador = horaAtual.split(':');
            let h = separador[0];
            let m = separador[1];
            let s = separador[2];

            var hora = `${h}:${m}`;
            $("#fimAlmoco").val(hora)
            gravar()
        });

        carregaPonto();
    });

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnEntrada").prop('disabled', true);
        $("#btnSaida").prop('disabled', true);
        $("#btnInicioAlmoco").prop('disabled', true);
        $("#btnFimAlmoco").prop('disabled', true);

        var codigo = $("#codigo").val();
        var funcionario = $("#funcionario").val();
        var mesAno = $("#mesAno").val();
        var idFolha = $("#idFolha").val();
        var dia = $("#dia").val();
        var horaEntrada = $("#horaEntrada").val();
        var horaSaida = $("#horaSaida").val();
        var inicioAlmoco = $("#inicioAlmoco").val();
        var fimAlmoco = $("#fimAlmoco").val();
        var horaExtra = $("#horaExtra").val();
        var atraso = $("#atraso").val();
        var lancamento = $("#lancamento").val() || 0;
        var status = 1;





        let separador = $("#expediente").text();
        if (!separador) {
            separador = '00:00 - 00:00';
        }
        separador = separador.split("-");
        separador[0] = separador[0].trim();
        separador[1] = separador[1].trim();

        if (separador[0].toString().length <= 5) separador[0] = separador[0].concat(':00');
        if (separador[1].toString().length <= 5) separador[1] = separador[1].concat(':00');

        const inicioExpediente = separador[0];
        const fimExpediente = separador[1];

        const inputHoraEntrada = aleatorizarTempo(horaEntrada, inicioExpediente);
        const inputHoraSaida = aleatorizarTempo(horaSaida, fimExpediente)

        //Começo Cálculo de Hora Extra
        if (inputHoraSaida != "00:00:00") {
            const parseHoraEntrada = parse(inputHoraEntrada)
            const parseHoraSaida = parse(inputHoraSaida)
            const parseHoraInicio = parse(inicioExpediente)
            const parseHoraFim = parse(fimExpediente)

            let jornadaNormal = duracao(inicioExpediente, fimExpediente);

            // quantidade de minutos efetivamente trabalhados
            let jornada = duracao(inputHoraEntrada, inputHoraSaida);

            // diferença entre as jornadas
            let diff = Math.abs(jornada - jornadaNormal);

            if (diff != 0) {
                let horas = Math.floor(diff / 60);
                let minutos = diff - (horas * 60);

                if (horas.toString().length < 2) horas = `0${horas}`;
                if (minutos.toString().length < 2) minutos = `0${minutos}`;

                if (jornada > jornadaNormal) {
                    horaExtra = (`${horas}:${minutos}`);
                } else {
                    atraso = (`${horas}:${minutos}`)
                }

            }
        }
        //Fim Cálculo de Hora Extra
        //Verificação de Atraso

        separador = atraso.split(':');
        let h = Number(separador[0]);
        let m = Number(separador[1]);

        let separadorTolerancia = toleranciaAtraso.split(':');
        let hTolerancia = Number(separadorTolerancia[0]);
        let mTolerancia = Number(separadorTolerancia[1]);


        //m <= tolerancia Atraso
        if (m < mTolerancia && h == 0) {
            atraso = ""
        }

        //Fim da Verificação de Atraso

        //Verificação de Extra
        separador = horaExtra.split(':');
        h = Number(separador[0]);
        m = Number(separador[1]);

        separadorTolerancia = toleranciaExtra.split(':');
        hTolerancia = Number(separadorTolerancia[0]);
        mTolerancia = Number(separadorTolerancia[1]);

        //m <= tolerancia Extra
        if (m <= mTolerancia && h == 0) {
            horaExtra = ""
        }

        //Fim da Verificação de Extra




        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:

        gravarPonto(codigo, funcionario, mesAno, idFolha, dia, horaEntrada, horaSaida, inicioAlmoco, fimAlmoco, horaExtra, atraso, lancamento, status,
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
                    smartAlert("Sucesso", "Entrada marcada com sucesso!", "success");
                    voltar();
                }
            }
        );
    }

    function voltar() {
        $(location).attr('href', 'prototipo_pontoEletronicoDiario.php');

    }

    function aleatorizarTempo(hora, expediente) {
        let separador = hora.split(':');
        let h = Number(separador[0]);
        let m = Number(separador[1]);
        let s = Number(separador[2]);

        separador = expediente.split(':');
        const eh = Number(separador[0]);
        const em = Number(separador[1]);
        let es = Number(separador[2]);
        if (isNaN(es)) es = Number('00');

        if ((h == eh) && (m == em)) {
            s = Math.floor(Math.random() * 50);
        }

        if (h.toString().length < 2) h = `0${h}`;
        if (m.toString().length < 2) m = `0${m}`;
        if (s.toString().length < 2) s = `0${s}`;

        const result = `${h}:${m}:${s}`;
        return result;
    }

    function parse(horario) {
        // divide a string em duas partes, separado por dois-pontos, e transforma em número
        let [hora, minuto] = horario.split(':').map(v => parseInt(v));
        if (!minuto) { // para o caso de não ter os minutos
            minuto = 00;
        }
        return minuto + (hora * 60);
    }

    function duracao(inicioExpediente, fimExpediente) {
        return (parse(fimExpediente) - parse(inicioExpediente));
    }

    function carregaPonto() {
        const mesAno = new Date().toJSON().slice(0, 10).replace(/[0-9]$/g, 01);
        const funcionario = $("#funcionario").val();
        const dia = $("#dia").val();

        $('#mesAno').val(mesAno);
        recuperaPonto(funcionario, mesAno, dia,
            function(data) {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                //Atributos de Cliente
                var mensagem = piece[0];
                var out = piece[1];

                piece = out.split("^");
                console.table(piece);
                //Atributos de cliente
                var idFolha = piece[0];
                var codigoDetalhe = piece[1];
                var horaEntrada = piece[2] || '00:00:00';
                var horaSaida = piece[3] || '00:00:00';
                var inicioAlmoco = piece[4] || '00:00';
                var fimAlmoco = piece[5] || '00:00';
                var horaExtra = piece[6] || '00:00:00';
                var atraso = piece[7] || '00:00:00';
                var lancamento = piece[8];
                var status = piece[9];


                if (horaEntrada != "00:00:00") {
                    $("#btnEntrada").prop('disabled', true);
                }
                if (horaSaida != "00:00:00") {
                    $("#btnSaida").prop('disabled', true);
                }
                if (inicioAlmoco != "00:00") {
                    $("#btnInicioAlmoco").prop('disabled', true);
                }
                if (fimAlmoco != "00:00") {
                    $("#btnFimAlmoco").prop('disabled', true);
                }


                //Atributos de cliente        
                $("#idFolha").val(idFolha);
                $("#codigo").val(codigoDetalhe);
                $("#horaEntrada").val(horaEntrada);
                $("#horaSaida").val(horaSaida);
                $("#inicioAlmoco").val(inicioAlmoco);
                $("#fimAlmoco").val(fimAlmoco);
                $("#horaExtra").val(horaExtra);
                $("#atraso").val(atraso);
                $("#lancamento").val(lancamento);
                $("#status").val(status);




            }

        );
    }
</script>