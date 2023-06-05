<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");


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
$page_nav['funcionario']['sub']['ponto']['sub']["controlePontoDiario"]["active"] = true;

include("inc/nav.php");
?>
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Área do Funcionário"] = "";
    $breadcrumbs["Ponto"] = "";
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
                                                        <input id="ip" name="ip" type="text" class="hidden">

                                                        <div class="row ">
                                                            <div class=" row text-center" style="margin-bottom: 10px;">
                                                                <h2 style="font-weight:bold;">Ponto Eletrônico</h2>
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

                                                                            $("#dia").val(dia);

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
                                                                    <h4>Funcionário: <span id="#"><?php
                                                                                                    $reposit = new reposit();

                                                                                                    $sql = "SELECT F.codigo, F.nome 
                                                                                                            FROM Ntl.funcionario F 
                                                                                                            INNER JOIN Ntl.beneficioProjeto BP ON BP.funcionario = F.codigo
                                                                                                            WHERE BP.dataDemissaoFuncionario IS NULL AND F.ativo = 1 AND F.codigo = " . $_SESSION['funcionario'];
                                                                                                    $result = $reposit->RunQuery($sql);
                                                                                                    ?></span>
                                                                        <?php
                                                                        if ($row = $result[0]) {

                                                                            $codigo = (int) $row['codigo'];
                                                                            $nome = $row['nome'];
                                                                            // echo '<option id="funcionario" name="funcionario" value= ' . $codigo . ' selected>' . $nome . '</option>';

                                                                            echo "<input type='hidden' name='funcionario' id='funcionario' value='$codigo'";
                                                                            echo "<br>";
                                                                            echo "<p>$nome</p>";
                                                                        }
                                                                        ?>
                                                                    </h4>
                                                                </div>
                                                                <div class="row" style="display: inline-flex;">
                                                                    <div class="col col-2" style="width:150px;">
                                                                        <h4>Expediente: <span id="#">
                                                                                <?php
                                                                                $hoje = getdate();
                                                                                $diaSemana = $hoje["wday"];

                                                                                $reposit = new reposit();
                                                                                $sqlExpediente = "SELECT codigo, funcionario,horaEntrada,horaSaida,horaEntradaSabado,horaSaidaSabado,horaEntradaDomingo,horaSaidaDomingo,tipoEscala, escalaDia
                                                                                                    FROM Ntl.beneficioProjeto where ativo = 1 AND funcionario = " . $_SESSION['funcionario'];
                                                                                $resultExpediente = $reposit->RunQuery($sqlExpediente);
                                                                                foreach ($resultExpediente as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $horaEntrada = $row['horaEntrada'];
                                                                                    $horaSaida = $row['horaSaida'];
                                                                                    $tipoEscala = $row['tipoEscala'];
                                                                                    $escalaDia = $row['escalaDia'];
                                                                                    if ($tipoEscala == 1) {
                                                                                        if ($escalaDia == 2) {
                                                                                            if ($diaSemana == 6) {
                                                                                                $horaEntrada = $row['horaEntradaSabado'];
                                                                                                $horaSaida = $row['horaSaidaSabado'];
                                                                                            }
                                                                                        } else if ($escalaDia == 3) {
                                                                                            if ($diaSemana == 6) {
                                                                                                $horaEntrada = $row['horaEntradaSabado'];
                                                                                                $horaSaida = $row['horaSaidaSabado'];
                                                                                            }
                                                                                            if ($diaSemana == 0) {
                                                                                                $horaEntrada = $row['horaEntradaDomingo'];
                                                                                                $horaSaida = $row['horaSaidaDomingo'];
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    $funcionario = $row['funcionario'];
                                                                                    $expediente = true;
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                            <?php
                                                                            if ($funcionario == $_SESSION['funcionario']) {
                                                                                echo "<p id='expediente' name='expediente' data-funcionario='$funcionario' value='$codigo'>$horaEntrada-$horaSaida</p>";
                                                                            }
                                                                            ?>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col col-2" style="width:150px;">
                                                                        <h4>Intervalo: <span id="#">
                                                                                <?php
                                                                                $hoje = getdate();
                                                                                $diaSemana = $hoje["wday"];

                                                                                $reposit = new reposit();
                                                                                $sqlIntervalo = "SELECT funcionario, horaInicio, horafim, horaInicioSabado, horaFimSabado, horaInicioDomingo, horaFimDomingo,tipoEscala, escalaDia
                                                                                                    FROM ntl.beneficioProjeto WHERE ativo = 1 AND funcionario = " . $_SESSION['funcionario'];
                                                                                $resultIntervalo = $reposit->RunQuery($sqlIntervalo);
                                                                                foreach ($resultIntervalo as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $horaInicio = $row['horaInicio'];
                                                                                    $horafim = $row['horafim'];
                                                                                    $tipoEscala = $row['tipoEscala'];
                                                                                    $escalaDia = $row['escalaDia'];
                                                                                    if ($tipoEscala == 1) {
                                                                                        if ($escalaDia == 2) {
                                                                                            if ($diaSemana == 6) {
                                                                                                $horaInicio = $row['horaInicioSabado'];
                                                                                                $horafim = $row['horaFimSabado'];
                                                                                            }
                                                                                        } else if ($escalaDia == 3) {
                                                                                            if ($diaSemana == 6) {
                                                                                                $horaInicio = $row['horaInicioSabado'];
                                                                                                $horafim = $row['horaFimSabado'];
                                                                                            }
                                                                                            if ($diaSemana == 0) {
                                                                                                $horaInicio = $row['horaInicioDomingo'];
                                                                                                $horafim = $row['horaFimDomingo'];
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    $funcionario = $row['funcionario'];
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                            <?php
                                                                            if ($funcionario == $_SESSION['funcionario']) {
                                                                                echo "<p id='intervalo' name='intervalo' data-funcionario='$funcionario' value='$codigo'>$horaInicio-$horafim</p>";
                                                                            }
                                                                            ?>
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                                <h4 id="horarioPausa" class="hidden">Horários Previstos para Pausa: <span id="#">
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, inicioPrimeiraPausa, fimPrimeiraPausa, inicioSegundaPausa, fimSegundaPausa
                                                                                FROM Ntl.beneficioProjeto
                                                                                WHERE ativo = 1 AND funcionario = " . $_SESSION['funcionario'];
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $inicioPrimeiraPausa = $row['inicioPrimeiraPausa'];
                                                                            $fimPrimeiraPausa = $row['fimPrimeiraPausa'];
                                                                            $inicioSegundaPausa = $row['inicioSegundaPausa'];
                                                                            $fimSegundaPausa = $row['fimSegundaPausa'];

                                                                            $funcionario = $row['funcionario'];
                                                                        }

                                                                        // echo '<option id="horarioPausa" name="horarioPausa" data-funcionario="' . $funcionario . '" value="' . $codigo . '" selected>' . $inicioPrimeiraPausa . " - " . $fimPrimeiraPausa . ' | ' . $inicioSegundaPausa . " - " . $fimSegundaPausa . '</option>';

                                                                        echo "<input type='hidden' name='horarioPausa' id='horarioPausa' data-funcionario='$funcionario' value='$codigo'";
                                                                        echo "<br>";
                                                                        echo "<p id='pausa'>$inicioPrimeiraPausa - $fimPrimeiraPausa | $inicioSegundaPausa - $fimSegundaPausa</p>";
                                                                        ?>
                                                                    </span>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <center>
                                                                O horário será registrado de acordo com o horário do servidor <br> (UTC/GMT -03:00) - Horario de Brasília
                                                            </center>
                                                        </div>
                                                        <div class="col col-xs-12 hidden" style="margin-top: 15px;" id="btnPausas">
                                                            <div class="col col-md-1"></div>
                                                            <div class="col col-md-5">
                                                                <h4 style="text-align: center;"> Primeira Pausa </h4>
                                                                <div style="display: flex;justify-content: space-evenly;align-items: center;">
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnInicioPrimeiraPausa" id="btnInicioPrimeiraPausa" style="background-color: #546e7a;width: 115px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-pause"></span><br>Inicio Pausa
                                                                        </button>
                                                                    </div>
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnFimPrimeiraPausa" id="btnFimPrimeiraPausa" style="background-color: #546e7a;width: 110px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-play"></span><br>Fim Pausa
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-5">
                                                                <h4 style="text-align: center;"> Segunda Pausa </h4>
                                                                <div style="display: flex;justify-content: space-evenly;align-items: center;">
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnInicioSegundaPausa" id="btnInicioSegundaPausa" style="background-color: #546e7a;width: 115px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-pause"></span><br>Inicio Pausa
                                                                        </button>
                                                                    </div>
                                                                    <div class="col col-md-2">
                                                                        <button type="button" class="btn  btn-block btnEntrada" name="btnFimSegundaPausa" id="btnFimSegundaPausa" style="background-color: #546e7a;width: 110px;height: 60px;margin: 0 0 20px;">
                                                                            <span class="fa fa-play"></span><br>Fim Pausa
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col col-1"></div> -->
                                                        </div>
                                                        <div class="col col-xs-12" style="margin-top: 15px;">
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnEntrada" name="btnEntrada" id="btnEntrada" style="height: 100px; background-color:#05ad4f;" disabled>
                                                                    <span class="fa fa-sign-in"></span><br>Entrada
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnInicioAlmoco" id="btnInicioAlmoco" style=" background: #29c4e3; height:100px;" disabled>
                                                                    <span class="fa fa-cutlery "></span><br> Inicio Intervalo
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnFimAlmoco" id="btnFimAlmoco" style="background: #d9d216; height:100px; " disabled>
                                                                    <span class="fa fa-cutlery"></span><br> Fim Intervalo
                                                                </button><br>
                                                            </div>
                                                            <div class="col col-xs-3">
                                                                <button type="button" class="btn  btn-block btnSaida" id="btnSaida" style="height: 100px;  background-color:#c42121;" disabled>
                                                                    <span class="fa fa-sign-out"></span><br>Saida
                                                                </button><br>
                                                            </div>
                                                        </div>

                                                        <div class="col col-xs-10">
                                                            <div class="col col-md-2"><br>
                                                                <div class="form-group">
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="xx" name="xx" type="text" class="hidden" style="height: 40px; border-radius: 0px !important;" data-autoclose="true" value="" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-2"><br>
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Atraso</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="atraso" name="atraso" type="text" class="text-center form-control" placeholder="00:00:00" style="height: 40px; border-radius: 0px !important;" data-autoclose="true" data-mask="99:99:99" value="" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-2"><br>
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Hora Extra</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="horaExtra" name="horaExtra" type="text" class="text-center form-control" placeholder="00:00:00" style="height: 40px; border-radius: 0px !important;" data-autoclose="true" data-mask="99:99:99" value="" readonly>
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-3"><br>
                                                                <label class="label" for="lancamento">Ocorrência/Lançamento</label>
                                                                <label class="select">
                                                                    <select id="lancamento" name="lancamento" style="height: 40px; border-radius: 0px !important;">
                                                                        <option selected value="0"></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $projeto = $_SESSION['projeto'];
                                                                        $sql = "SELECT L.codigo, L.descricao FROM Ntl.lancamento L 
                                                                            LEFT JOIN 
                                                                            Ntl.lancamentoProjeto LP 
                                                                            ON L.codigo = LP.lancamento
                                                                            LEFT JOIN 
                                                                            Ntl.projeto P 
                                                                            ON P.codigo = LP.projeto
                                                                            where L.ativo = 1 AND (P.codigo = " . $projeto . " OR P.codigo IS NULL) order by L.descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            if ($descricao == 'Atraso Abonado' || $descricao == "Hora Extra" || $descricao == "Atraso") {
                                                                                echo '<option hidden value=' . $codigo . '>' . $descricao . '</option>';
                                                                            } else {
                                                                                echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </div>
                                                            <div class="col col-3"> 
                                                                <label class="label" for="lancamento"></label>
                                                                <button type="button" class="btn  btn-block btnLancamento" id="btnLancamento" style="height: 50px;  background-color:#8B0000;">
                                                                    <span class="">Lançar Ocorrência</span><br>
                                                                </button><br>
                                                            </div>
                                                        </div>

                                                        <input id="mesAno" name="mesAno" type="text" class="hidden">
                                                        <input id="horaAtual" name="horaAtual" type="text" class="hidden">
                                                        <input id="horaEntrada" name="horaEntrada" type="text" class="hidden">
                                                        <input id="horaSaida" name="horaSaida" type="text" class="hidden">
                                                        <input id="inicioAlmoco" name="inicioAlmoco" type="text" class="hidden">
                                                        <input id="fimAlmoco" name="fimAlmoco" type="text" class="hidden">
                                                        <input id="status" name="status" type="text" class="hidden">
                                                        <input id="registraAlmoco" name="registraAlmoco" type="text" class="hidden">
                                                        <input id="tipoEscala" name="tipoEscala" type="text" class="hidden">
                                                        <input id="escalaDia" name="escalaDia" type="text" class="hidden">
                                                        <input id="layoutFolhaPonto" name="layoutFolhaPonto" type="text" class="hidden">
                                                        <!-- <input id="verificaIp" name="verificaIp" type="text" class="hidden"> -->
                                                        <input id="registraPausa" name="registraPausa" type="text" class="hidden">
                                                        <!-- <input id="codigoPausa" name="codigoPausa" type="text" class="hidden"> -->
                                                        <input id="inicioPrimeiraPausa" name="inicioPrimeiraPausa" type="text" class="hidden">
                                                        <input id="fimPrimeiraPausa" name="fimPrimeiraPausa" type="text" class="hidden">
                                                        <input id="inicioSegundaPausa" name="inicioSegundaPausa" type="text" class="hidden">
                                                        <input id="fimSegundaPausa" name="fimSegundaPausa" type="text" class="hidden">

                                                        <input id="feriado" name="feriado" type="text" class="hidden">

                                                        <div class="row hidden">
                                                            <section class="col col-12">
                                                                <label class="label">Observações</label>
                                                                <textarea maxlength="500" id="observacao" name="observacao" class="form-control" rows="3" value="" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button id="btnPdf" type="button" class="btn btn-primary" title="Gerar Pdf">
                                            <span class="fa fa-file-pdf-o"></span>
                                        </button>
                                        <a href="https://meuip.com.br" target="_blank"> <button id="btnVerificarIp" type="button" class="btn btn-success" title="Verificar Ip">
                                                Verificar meu Ip
                                            </button></a>
                                        <!-- Modal para quando der erro por não ter carregado a pagina por completo -->
                                        <div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="modalErro" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="modalErro"><i class='fa fa-warning'></i> Atenção
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5>Ponto não registrado! <br> Por favor tente novamente.</h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MODAL FERIADO -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleFeriado" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleFeriado" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p>Hoje é feriado. <br> Deseja confirmar o registro do ponto?</p>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MODAL REGISTRAR PONTO -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimplePonto" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimplePonto" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="alerta"></p>
                                                    <p>Deseja registrar ponto?</p>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal para aviso de hora extra sem autorização -->
                                        <div class="modal fade" id="modalAutorizacao" tabindex="-1" role="dialog" aria-labelledby="modalAutorizacao" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="modalAutorizacao"><i class='fa fa-warning'></i> Atenção
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5>Hora extra sem autorização</h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal comprovante registro de ponto -->
                                        <div class="modal fade" id="comprovanteRegistro" tabindex="-1" role="dialog" aria-labelledby="comprovanteRegistro" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="comprovanteRegistro">Comprovante de Registro de Ponto do Trabalhador
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5 id='dataComprovante'></h5>
                                                            <br>
                                                            <h5 id='horaComprovante'></h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MODAL JUSTIFICATIVA ATRASO -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleJustificativa" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleJustificativa" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="titulo">Justificativa de Atraso</p>
                                                    <textarea maxlength="500" id="justificativa" name="justificativa" class="form-control" rows="3" value="" style="resize:vertical" required></textarea>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL JUSTIFICATIVA PAUSA FORA DO LIMITE -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleJustificativaPausa" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleJustificativaPausa" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="tituloPausa"></p>
                                                    <textarea maxlength="500" id="justificativaPausa" name="justificativaPausa" class="form-control" rows="3" value="" style="resize:vertical" required></textarea>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL REGISTRAR PAUSA -->
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimplePausa" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-1" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimplePausa" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <center>
                                                    <p id="alertaPausa"></p>
                                                    <p>Deseja registrar pausa?</p>
                                                </center>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal IP -->
                                        <div class="modal fade bd-example-modal-sm" id="modalIp" tabindex="-1" role="dialog" aria-labelledby="modalIp" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" align="center" id="modalIp"><i class='fa fa-warning'></i> Atenção
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <center>
                                                            <h5 id="ipInvalido"></h5>
                                                        </center>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </footer>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_pontoEletronicoDiario.js" type="text/javascript"></script>

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

<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script language="JavaScript" type="text/javascript">
    var toleranciaExtra = "";
    var toleranciaAtraso = "";
    var toleranciaDia = "";
    var btnClicado = "";
    var horaRetorno = "";
    var folgaCobertura = "";
    var modalHoraExtra = "";
    var verificaIp = "";
    var autorizacaoExtra = '';

    var arrDiasAlterados = [];
    $(document).ready(function() {
        resetaTempo();
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $("#btnEntrada").on("click", function() {
            resetaTempo();
            var campo = 'Entrada';
            btnClicado = 'entrada';
            getHora(campo);
        });

        $("#btnSaida").on("click", function() {
            var inicioAlmoco = $("#inicioAlmoco").val();
            var fimAlmoco = $("#fimAlmoco").val();
            btnClicado = 'saida';
            resetaTempo();
            if ((inicioAlmoco != "00:00") && (fimAlmoco == "00:00")) {
                $("#horaSaida").val('00:00:00');
                smartAlert("Atenção", "Registre primeiro o fim do Intervalo!", "error");
                return false;
            }

            var campo = 'Saida';
            getHora(campo);
        });

        $("#btnInicioAlmoco").on("click", function() {
            resetaTempo();
            var entrada = $("#horaEntrada").val();
            if (entrada == "00:00:00") {
                $("#inicioAlmoco").val('00:00');
                smartAlert("Atenção", "Registre primeiro a hora de entrada!", "error");
                return false;
            }
            var campo = 'Inicio Almoço';
            btnClicado = 'inicioAlmoco';
            getHora(campo);
        });

        $("#btnFimAlmoco").on("click", function() {
            resetaTempo();
            var inicioAlmoco = $("#inicioAlmoco").val();
            if (inicioAlmoco == "00:00") {
                $("#fimAlmoco").val('00:00');
                smartAlert("Atenção", "Registre primeiro o inicio do Intervalo!", "error");
                return false;
            }
            var campo = 'Fim Almoço';
            btnClicado = 'fimAlmoco';
            getHora(campo);
        });

        $("#btnLancamento").on("click", function() {
            resetaTempo();
            var lancamento = $("#lancamento").val()
            var dataAtual = new Date();
            var dia = dataAtual.getDate();
            var horaEntrada = $("#horaEntrada").val();
            var horaSaida = $("#horaSaida").val();
            var atraso = $("#atraso").val();
            var extra = $("#horaExtra").val();
            btnClicado = 'lancamento';

            if (lancamento == 0) {
                smartAlert("Atenção", "Selecione um lançamento!", "error");
                return;
            }

            if (atraso != '00:00:00') {
                abonarAtraso();
                abateBancoHoras(lancamento, dia, horaEntrada, horaSaida, atraso);
            }
            if (extra != '00:00:00') {
                compensarFalta(extra, dia, lancamento);
            }
            if ((atraso == '00:00:00') && (extra == '00:00:00')) {
                gravar();
            }
        });

        $('#btnVerificarIp').on("click", function() {
            resetaTempo();
        });

        $('#btnPdf').on("click", function() {
            resetaTempo();
            imprimir();
        });

        $('#dlgSimpleFeriado').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimpleFeriado').css('display', 'none');
                    $("#feriado").val(1);
                    gravar();
                    enviarEmail();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    return;
                }
            }]
        });

        $('#dlgSimplePonto').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimplePonto').css('display', 'none');
                    let expediente = $("#expediente").text();
                    if (!expediente) {
                        expediente = '00:00 - 00:00';
                    }
                    expediente = expediente.split("-");
                    inicioExpediente = parse(expediente[0].trim());
                    fimExpediente = parse(expediente[1].trim());

                    var entrada = parse($("#horaEntrada").val());
                    var saida = parse($("#horaSaida").val());
                    var tolerancia = toleranciaAtraso || toleranciaDia;
                    toleranciaEntrada = inicioExpediente + parse(tolerancia);
                    toleranciaSaida = fimExpediente + parse(tolerancia);
                    if ((btnClicado == 'entrada') && (entrada > toleranciaEntrada)) {
                        justificar(btnClicado);
                    } else if ((btnClicado == 'saida') && (saida > toleranciaSaida)) {
                        justificar(btnClicado);
                    } else {
                        gravar();
                        enviarEmail();
                    }
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    location.reload();
                }
            }]
        });

        $("#dlgSimplePonto").dialog("widget").find(".ui-dialog-titlebar-close").hide();


        $('#dlgSimplePausa').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Confirmar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimplePausa').css('display', 'none');
                    registraPausa(btnClicado);
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    location.reload();
                }
            }]
        });

        $("#dlgSimplePausa").dialog("widget").find(".ui-dialog-titlebar-close").hide();

        $('#comprovanteRegistro').on('hide.bs.modal', (e) => {
            // e.preventDefault();
            e.stopPropagation();

            if(modalHoraExtra != 1){
                voltar();
            }
        });

        $('#modalAutorizacao').on('hide.bs.modal', (e) => {
            e.stopPropagation();
            voltar();
        });

        $('#modalIp').on('hide.bs.modal', (e) => {
            e.stopPropagation();
            $("#ipInvalido").val('');
            // voltar();
        });

        $('#modalAutorizacao').on('show.bs.modal', (e) => {
            modalHoraExtra = 1;
        });

        $("#btnInicioPrimeiraPausa").on("click", function() {
            resetaTempo();
            var horaEntrada = $("#horaEntrada").val();
            var saida = $("#horaSaida").val();
            if (horaEntrada == '00:00:00') {
                $("#inicioPrimeiraPausa").val('')
                smartAlert("Atenção", "Registre primeiro a hora de entrada!", "error");
                return;
            }
            if (saida != '00:00:00') {
                $("#inicioPrimeiraPausa").val('')
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'inicioPrimeiraPausa';
            getHora(btnClicado);
        });

        $("#btnFimPrimeiraPausa").on('click', function() {
            resetaTempo();
            var inicioPrimeiraPausa = $("#inicioPrimeiraPausa").val();
            var saida = $("#horaSaida").val();
            if (!inicioPrimeiraPausa) {
                $("#fimPrimeiraPausa").val('');
                smartAlert("Atenção", "Registre primeiro o inicio da pausa!", "error");
                return;
            }

            if (saida != '00:00:00') {
                $("#fimPrimeiraPausa").val('');
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'fimPrimeiraPausa';
            getHora(btnClicado);
        });

        $("#btnInicioSegundaPausa").on("click", function() {
            resetaTempo();
            var inicioPrimeiraPausa = $("#inicioPrimeiraPausa").val();
            var fimPrimeiraPausa = $("#fimPrimeiraPausa").val();
            var inicioAlmoco = $("#inicioAlmoco").val();
            var fimAlmoco = $("#fimAlmoco").val();
            var saida = $("#horaSaida").val();

            // if ((!inicioPrimeiraPausa) || (!fimPrimeiraPausa)) {
            //     $("#inicioSegundaPausa").val('');
            //     smartAlert("Atenção", "Registre a primeira pausa!", "error");
            //     return;
            // }
            // if ((inicioAlmoco == '00:00') || (fimAlmoco == '00:00')) {
            //     $("#inicioSegundaPausa").val('');
            //     smartAlert("Atenção", "A segunda pausa não pode ser registrada antes do intervalo!", "error");
            //     return;
            // }

            if (saida != '00:00:00') {
                $("#inicioSegundaPausa").val('');
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'inicioSegundaPausa';
            getHora(btnClicado);
        });

        $("#btnFimSegundaPausa").on('click', function() {
            resetaTempo();
            var inicioSegundaPausa = $("#inicioSegundaPausa").val();
            var saida = $("#horaSaida").val();
            if (!inicioSegundaPausa) {
                $("#fimSegundaPausa").val('');
                smartAlert("Atenção", "Registre primeiro o inicio da pausa!", "error");
                return;
            }

            if (saida != '00:00:00') {
                $("#fimSegundaPausa").val('');
                smartAlert("Atenção", "Não é possivel registrar pausa após a saida!", "error");
                return;
            }

            btnClicado = 'fimSegundaPausa';
            getHora(btnClicado);
        });

        $('#dlgSimpleJustificativa').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Gravar",
                "class": "btn btn-success",
                click: function() {
                    var justificativa = $("#justificativa").val();
                    $("#observacao").val(justificativa);
                    $(this).dialog("close");
                    $('#dlgSimpleJustificativa').css('display', 'none');
                    gravar();
                    enviarEmail();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    location.reload();
                }
            }]
        });
        $("#dlgSimpleJustificativa").dialog("widget").find(".ui-dialog-titlebar-close").hide();

        $('#dlgSimpleJustificativaPausa').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                html: "Gravar",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    $('#dlgSimpleJustificativaPausa').css('display', 'none');
                    registraPausa(btnClicado);
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                    location.reload();
                }
            }]
        });
        $("#dlgSimpleJustificativaPausa").dialog("widget").find(".ui-dialog-titlebar-close").hide();

        getIpClient();
        carregaPonto();
        recuperaDados();
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
        var dataAtual = new Date();
        var dia = dataAtual.getDate();
        var horaEntrada = $("#horaEntrada").val();
        var horaSaida = $("#horaSaida").val();
        var inicioAlmoco = $("#inicioAlmoco").val();
        var fimAlmoco = $("#fimAlmoco").val();
        var horaExtra = $("#horaExtra").val();
        var atraso = $("#atraso").val();
        var lancamento = $("#lancamento").val();
        var observacao = $("#observacao").val();
        var status = $('#status').val();
        if (status == 0) {
            status = 2;
        }

        var tipoEscala = $("#tipoEscala").val();
        var escalaDia = $("#escalaDia").val();

        var feriado = $("#feriado").val();

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

        let intervalo = $("#intervalo").text();
        if (!intervalo) {
            intervalo = '00:00 - 00:00';
        }
        intervalo = intervalo.split("-");
        let inicioIntervalo = intervalo[0].trim();
        let fimIntervalo = intervalo[1].trim();

        // if (escalaDia == 2) {
        //     var data = mesAno.split("-");
        //     var date = new Date(data[0], data[1] - 1, dia);
        //     var weekday = date.getDay();

        //     if (weekday == 6) {
        //         // Expediente Sabado
        //         var inicioExpedienteSabado = $("#expedienteSabado option:selected").text() || '00:00 - 00:00';

        //         separador = inicioExpedienteSabado.split("-");
        //         inicioExpediente = separador[0].trim();
        //         fimExpediente = separador[1].trim();

        //         if (inicioExpediente.toString().length <= 5) inicioExpediente = inicioExpediente.concat(':00');
        //         if (fimExpediente.toString().length <= 5) fimExpediente = fimExpediente.concat(':00');
        //         parseHoraFim = parse(fimExpediente);
        //         parseHoraInicio = parse(inicioExpedienteSabado);
        //     }
        // } else if (escalaDia == 3) {
        //     var data = mesAno.split("-");
        //     var date = new Date(data[0], data[1] - 1, dia);
        //     var weekday = date.getDay();
        //     if (weekday == 0) {
        //         // Expediente Segunda a Domingo
        //         var inicioExpedienteDomingo = $("#expedienteDomingo option:selected").text() || '00:00 - 00:00';

        //         separador = inicioExpedienteDomingo.split("-");
        //         inicioExpediente = separador[0].trim();
        //         fimExpediente = separador[1].trim();

        //         if (inicioExpediente.toString().length <= 5) inicioExpediente = inicioExpediente.concat(':00');
        //         if (fimExpediente.toString().length <= 5) fimExpediente = fimExpediente.concat(':00');
        //         parseHoraFim = parse(fimExpediente);
        //         parseHoraInicio = parse(inicioExpedienteDomingo);
        //     }

        //     // if (weekday == 6) {
        //     //     // Expediente Segunda a Sabado
        //     //     var inicioExpedienteSabado = $("#expediente").text() || '00:00 - 00:00';

        //     //     separador = inicioExpedienteSabado.split("-");
        //     //     inicioExpediente = separador[0].trim();
        //     //     fimExpediente = separador[1].trim();

        //     //     if (inicioExpediente.toString().length <= 5) inicioExpediente = inicioExpediente.concat(':00');
        //     //     if (fimExpediente.toString().length <= 5) fimExpediente = fimExpediente.concat(':00');
        //     //     parseHoraFim = parse(fimExpediente);
        //     //     parseHoraInicio = parse(inicioExpedienteSabado);
        //     // }
        // }

        const inputHoraEntrada = aleatorizarTempo(horaEntrada, inicioExpediente);
        const inputHoraSaida = aleatorizarTempo(horaSaida, fimExpediente)

        //Escala normal
        if (tipoEscala == 1) {
            //Começo Cálculo de Hora Extra
            if (toleranciaExtra || toleranciaAtraso) {
                var parseToleranciaExtra = parse(toleranciaExtra)
                parseToleranciaAtraso = parse(toleranciaAtraso)
            } else if (toleranciaDia) {
                var parseToleranciaExtra = parse(toleranciaDia)
                parseToleranciaAtraso = parse(toleranciaDia)
            }

            atraso = "00:00:00";
            horaExtra = "00:00:00";

            if (inputHoraSaida != "00:00:00") {

                var entrada = horaEntrada.split(':');
                entrada = entrada[0] + ":" + entrada[1];

                if ((entrada > inicioAlmoco) && (entrada > fimAlmoco)) {
                    inicioAlmoco = "00:00";
                    fimAlmoco = "00:00";
                }

                if ((horaSaida <= inicioAlmoco) || (horaSaida <= fimAlmoco)) {
                    inicioAlmoco = "00:00";
                    fimAlmoco = "00:00";
                }

                const parseHoraEntrada = parse(inputHoraEntrada)
                const parseHoraSaida = parse(inputHoraSaida)
                const parseHoraInicio = parse(inicioExpediente)
                const parseHoraFim = parse(fimExpediente)

                let jornadaNormal = duracao(inicioExpediente, fimExpediente);

                var almoco = parse(fimIntervalo) - parse(inicioIntervalo);
                jornadaNormal = jornadaNormal - almoco;

                const jornadaNormalToleranteExtra = jornadaNormal + parseToleranciaExtra
                const jornadaNormalToleranteAtraso = jornadaNormal - parseToleranciaExtra
                // quantidade de minutos efetivamente trabalhados
                let jornada = duracao(inputHoraEntrada, inputHoraSaida);

                if (inicioAlmoco != '00:00' && fimAlmoco != '00:00') {
                    var almoco = parse(fimAlmoco) - parse(inicioAlmoco);
                    jornada = jornada - almoco;
                }

                // diferença entre as jornadas
                let diff = Math.abs(jornada - jornadaNormal);

                var weekday = dataAtual.getDay();

                if ((feriado == 1 || weekday == 0 || folgaCobertura == 1) && escalaDia != 3) {
                    let horas = Math.floor(jornada / Math.pow(60, 2));
                    jornada = jornada - (horas * 3600);
                    let minutos = Math.floor(jornada / 60);
                    let segundos = jornada - (minutos * 60);

                    if (horas.toString().length < 2) horas = `0${horas}`;
                    if (minutos.toString().length < 2) minutos = `0${minutos}`;
                    if (segundos.toString().length < 2) segundos = `0${segundos}`;

                    horaExtra = (`${horas}:${minutos}:${segundos}`);
                } else {
                    if (diff != 0 && folgaCobertura != 1) {
                        let horas = Math.floor(diff / Math.pow(60, 2));
                        diff = diff - (horas * 3600);
                        let minutos = Math.floor(diff / 60);
                        let segundos = diff - (minutos * 60);

                        if (horas.toString().length < 2) horas = `0${horas}`;
                        if (minutos.toString().length < 2) minutos = `0${minutos}`;
                        if (segundos.toString().length < 2) segundos = `0${segundos}`;

                        if (jornada > jornadaNormalToleranteExtra) {
                            horaExtra = (`${horas}:${minutos}:${segundos}`);
                        } else if (jornada < jornadaNormalToleranteAtraso) {
                            atraso = (`${horas}:${minutos}:${segundos}`)
                        }
                    }else if(folgaCobertura == 1){
                        let horas = Math.floor(jornada / Math.pow(60, 2));
                        jornada = jornada - (horas * 3600);
                        let minutos = Math.floor(jornada / 60);
                        let segundos = jornada - (minutos * 60);

                        if (horas.toString().length < 2) horas = `0${horas}`;
                        if (minutos.toString().length < 2) minutos = `0${minutos}`;
                        if (segundos.toString().length < 2) segundos = `0${segundos}`;

                        horaExtra = (`${horas}:${minutos}:${segundos}`);
                    }
                }
            }
            //Fim Cálculo de Hora Extra
        }

        //Revezamento
        if (tipoEscala == 2) {
            if (inicioExpediente < fimExpediente) {
                //Começo Cálculo de Hora Extra
                if (toleranciaExtra || toleranciaAtraso) {
                    var parseToleranciaExtra = parse(toleranciaExtra)
                    parseToleranciaAtraso = parse(toleranciaAtraso)
                } else if (toleranciaDia) {
                    var parseToleranciaExtra = parse(toleranciaDia)
                    parseToleranciaAtraso = parse(toleranciaDia)
                }

                atraso = "00:00:00";
                horaExtra = "00:00:00";

                if (horaSaida != "00:00:00") {
                    //valor em segundos
                    const parseHoraEntrada = parse(inputHoraEntrada)
                    const parseHoraSaida = parse(inputHoraSaida)
                    const parseHoraInicio = parse(inicioExpediente)
                    const parseHoraFim = parse(fimExpediente)

                    //calculo

                    let jornadaNormal = duracao(inicioExpediente, fimExpediente);

                    var almoco = parse(fimIntervalo) - parse(inicioIntervalo);
                    jornadaNormal = jornadaNormal - almoco;

                    const jornadaNormalToleranteExtra = jornadaNormal + parseToleranciaExtra
                    const jornadaNormalToleranteAtraso = jornadaNormal - parseToleranciaExtra
                    // quantidade de minutos efetivamente trabalhados
                    let jornada = duracao(inputHoraEntrada, inputHoraSaida);

                    if (inicioAlmoco != '00:00' && fimAlmoco != '00:00') {
                        var almoco = parse(fimAlmoco) - parse(inicioAlmoco);
                        jornada = jornada - almoco;
                    }

                    // diferença entre as jornadas
                    let diff = Math.abs(jornada - jornadaNormal);

                    if (diff != 0 && folgaCobertura != 1) {
                        let horas = Math.floor(diff / Math.pow(60, 2));
                        diff = diff - (horas * 3600);
                        let minutos = Math.floor(diff / 60);
                        let segundos = diff - (minutos * 60);

                        if (horas.toString().length < 2) horas = `0${horas}`;
                        if (minutos.toString().length < 2) minutos = `0${minutos}`;
                        if (segundos.toString().length < 2) segundos = `0${segundos}`;

                        if (jornada > jornadaNormalToleranteExtra) {
                            horaExtra = (`${horas}:${minutos}:${segundos}`);
                        } else if (jornada < jornadaNormalToleranteAtraso) {
                            atraso = (`${horas}:${minutos}:${segundos}`)
                        }
                    }else if(folgaCobertura == 1){
                        let horas = Math.floor(jornada / Math.pow(60, 2));
                        jornada = jornada - (horas * 3600);
                        let minutos = Math.floor(jornada / 60);
                        let segundos = jornada - (minutos * 60);

                        if (horas.toString().length < 2) horas = `0${horas}`;
                        if (minutos.toString().length < 2) minutos = `0${minutos}`;
                        if (segundos.toString().length < 2) segundos = `0${segundos}`;

                        horaExtra = (`${horas}:${minutos}:${segundos}`);
                    }
                }
                //Fim Cálculo de Hora Extra
            }
        }
        //Verificação de Atraso

        separador = atraso.split(':');
        let h = Number(separador[0]);
        let m = Number(separador[1]);

        if (toleranciaAtraso) {
            var separadorTolerancia = toleranciaAtraso.split(':');
        } else if (toleranciaDia) {
            var separadorTolerancia = toleranciaDia.split(':');
        }
        let hTolerancia = Number(separadorTolerancia[0]);
        let mTolerancia = Number(separadorTolerancia[1]);

        if (m < mTolerancia && h == 0) {
            atraso = "00:00:00"
        }

        //Fim da Verificação de Atraso

        //Verificação de Extra
        separador = horaExtra.split(':');
        h = Number(separador[0]);
        m = Number(separador[1]);

        if (toleranciaExtra) {
            separadorTolerancia = toleranciaExtra.split(':');
        } else if (toleranciaDia) {
            separadorTolerancia = toleranciaDia.split(':');
        }
        hTolerancia = Number(separadorTolerancia[0]);
        mTolerancia = Number(separadorTolerancia[1]);

        if (m <= mTolerancia && h == 0) {
            horaExtra = "00:00:00"
        }

        if (horaExtra != "00:00:00" && horaExtra != "" && inputHoraSaida != "00:00:00") {
            smartAlert("Aviso", "O funcionário possui horas extras", "info");
            verificaAutorizacao(dia);
        }
        // if (atraso != "00:00:00" && atraso != "" && inputHoraSaida != "00:00:00") {
        //     smartAlert("Aviso", "O funcionário possui atrasos", "info");
        // }

        //Fim da Verificação de Extra

        var ipEntrada = "";
        var ipSaida = "";
        var registraAlmoco = $("#registraAlmoco").val();

        if (registraAlmoco == 1) {
            if ((horaEntrada != '00:00:00') && (inicioAlmoco == '00:00') && (fimAlmoco == '00:00') && (horaSaida == '00:00:00')) {
                var ipEntrada = $('#ip').val();
                if (ipEntrada == "") {
                    smartAlert("Atenção", "Não foi possível registrar o ponto, tente novamente!", "error");
                    voltar();
                }
            }
        } else {
            if ((horaEntrada != '00:00:00') && (horaSaida == '00:00:00')) {
                var ipEntrada = $('#ip').val();
                if (ipEntrada == "") {
                    smartAlert("Atenção", "Não foi possível registrar o ponto, tente novamente!", "error");
                    voltar();
                }
            }
            if ((inicioAlmoco == '00:00') || (fimAlmoco == '00:00')) {
                $('#modalErro').modal('show');
                return;
            }
        }

        if (horaSaida != '00:00:00') {
            var ipSaida = $('#ip').val();
            if (ipSaida == "") {
                smartAlert("Atenção", "Não foi possível registrar o ponto, tente novamente!", "error");
                voltar();
            }
        }

        if (btnClicado != 'lancamento') {
            arrDiasAlterados.push({
                dia: dia,
                horaEntrada: horaEntrada,
                horaSaida: horaSaida,
                inicioAlmoco: inicioAlmoco,
                fimAlmoco: fimAlmoco,
                ipEntrada: ipEntrada,
                ipSaida: ipSaida,
            });
        }
        var diasAlterados = arrDiasAlterados;

        gravarPonto(codigo, funcionario, mesAno, idFolha, dia, horaEntrada, horaSaida, inicioAlmoco, fimAlmoco, horaExtra, atraso, lancamento, observacao, status, diasAlterados, btnClicado,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com o suporte!", "error");
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    var mensagem = piece[2];
                    if (!mensagem) {
                        smartAlert("Sucesso", "Ponto marcado com sucesso!", "success");

                    } else {
                        out = mensagem.split("#");
                        mensagem = out[0];
                        autorizacaoExtra = out[1];

                        smartAlert("Sucesso", "Ponto marcado com sucesso!", "success");

                        // smartAlert("Aviso", mensagem, "info");

                    }

                    if (btnClicado != 'lancamento') {
                        confirmarRegistro(idFolha, dia, btnClicado, mesAno);
                        if (autorizacaoExtra == 1) {
                            $('#modalAutorizacao').modal('show');
                        }
                    } else {
                        voltar();
                    }
                }
            }
        );
    }

    function voltar() {
        $(location).attr('href', 'funcionario_pontoEletronicoDiario.php');
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

        if ((h != 0) || (m != 0)) {
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
        let [hora, minuto, segundos] = horario.split(':').map(v => parseInt(v));
        if (!minuto) { // para o caso de não ter os minutos
            minuto = 00;
        }

        if (!segundos) { // para o caso de não ter os segundos
            segundos = 0;
        }
        return segundos + (minuto * 60) + (hora * Math.pow(60, 2));
    }

    function duracao(inicioExpediente, fimExpediente) {
        return (parse(fimExpediente) - parse(inicioExpediente));
    }

    function carregaPonto() {
        const mesAno = moment().format('YYYY-MM-DD');

        const funcionario = $("#funcionario").val();
        const dataAtual = new Date();
        const dia = dataAtual.getDate();
        const projeto = <?php echo $_SESSION['projeto']; ?>

        $('#mesAno').val(mesAno);
        recuperaPonto(funcionario, mesAno, dia, projeto,
            function(data) {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];

                piece = out.split("^");

                //Atributos do funcionário
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
                var descricaoStatus = piece[10];
                var registraAlmoco = piece[11];
                var registraPonto = piece[12];
                var tipoEscala = piece[13];
                var layoutFolhaPonto = piece[14] || 1;
                toleranciaAtraso = piece[15];
                toleranciaExtra = piece[16];
                toleranciaDia = piece[17];
                // var verificaIp = piece[18];
                var ferias = piece[19];
                var escalaDia = piece[20];
                var intervaloSabado = piece[21];
                var intervaloDomingo = piece[22];
                var registraPausa = piece[23];

                if (registraPausa == 1) {
                    $("#horarioPausa, #btnPausas").removeClass("hidden");
                    $("#horarioPausa, #btnPausas").addClass("show");
                } else {
                    $("#horarioPausa, #btnPausas").removeClass("show");
                    $("#horarioPausa, #btnPausas").addClass("hidden");
                }

                var inicioPrimeiraPausa = piece[24];
                var fimPrimeiraPausa = piece[25];
                var inicioSegundaPausa = piece[26];
                var fimSegundaPausa = piece[27];
                var folga = piece[28];
                var documento = piece[29];
                folgaCobertura = piece[30];

                //Atributos do funcionário    
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
                $("#registraAlmoco").val(registraAlmoco);
                $("#tipoEscala").val(tipoEscala);
                $("#layoutFolhaPonto").val(layoutFolhaPonto);
                // $("#verificaIp").val(verificaIp);
                $("#escalaDia").val(escalaDia);
                // Pausas
                $("#inicioPrimeiraPausa").val(inicioPrimeiraPausa);
                $("#fimPrimeiraPausa").val(fimPrimeiraPausa);
                $("#inicioSegundaPausa").val(inicioSegundaPausa);
                $("#fimSegundaPausa").val(fimSegundaPausa);

                habilitaBotões();

                if ((registraPonto == 0) || (ferias == 1) || (folga == 1 && folgaCobertura != 1) || (documento == 1)) {
                    desabilitaBotões();
                } else {
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
                    if (descricaoStatus == "Fechado" || (folga == 1 && folgaCobertura == 1)) {
                        $("#lancamento").prop('disabled', true);
                        $("#btnLancamento").prop('disabled', true);
                    }
                    // var data = mesAno.split("-");
                    // var date = new Date(data[0] + "-" + data[1] + "-" + dia);
                    var weekday = dataAtual.getDay();

                    if (tipoEscala == 1) {
                        // Se for sabado e não tiver intervalo
                        if ((weekday == 6) && (intervaloSabado == 0)) {
                            $("#btnInicioAlmoco").prop('disabled', true);
                            $("#btnFimAlmoco").prop('disabled', true);
                        }

                        // Se for domingo e não tiver intervalo
                        if ((weekday == 0) && (intervaloDomingo == 0)) {
                            $("#btnInicioAlmoco").prop('disabled', true);
                            $("#btnFimAlmoco").prop('disabled', true);
                        }
                    }

                    if (inicioPrimeiraPausa) {
                        $("#btnInicioPrimeiraPausa").prop('disabled', true);
                    }
                    if (fimPrimeiraPausa) {
                        $("#btnFimPrimeiraPausa").prop('disabled', true);
                    }
                    if (inicioSegundaPausa) {
                        $("#btnInicioSegundaPausa").prop('disabled', true);
                    }
                    if (fimSegundaPausa) {
                        $("#btnFimSegundaPausa").prop('disabled', true);
                    }
                }

            }
        );
    }

    function enviarEmail() {
        var codigoFuncionario = $("#funcionario").val();
        var horaAtual = $("#horaAtual").val();

        enviaEmail(codigoFuncionario, horaAtual,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        return false;
                    } else {
                        return false;
                    }
                }
            }
        );
    }

    async function getIpClient() {
        try {
            const response = await axios.get('https://api.ipify.org?format=json');
            if(verificaIp == 1){
                $('#ip').val(response.data['ip']);
                validarIp(response.data['ip']);
            }else{
                $('#ip').val(response.data['ip']);
                carregaPonto();
            }

        } catch (error) {
            if(verificaIp == 1){
                $("#ipInvalido").html("Não foi possivel verificar o IP!");
                $("#modalIp").modal('show');
            }else{
                carregaPonto();
            }
           
        }
    }

    function validaHoraAtual(horaAtual) {
        if ((horaAtual == "") || (horaAtual == " ") || (!horaAtual) || (horaAtual == '00:00:00')) {
            return false;
        }
        return true;
    }

    // function validarIp(ip) {

    //     // var ip = $("#ip").val();
    //     var projeto = <?php echo $_SESSION['projeto']; ?>

    //     validaIp(ip, projeto,
    //         function(data) {
    //             if (data.indexOf('sucess') < 0) {
    //                 var piece = data.split("#");
    //                 var mensagem = piece[1];
    //                 if (mensagem !== "") {
    //                     smartAlert("Atenção", mensagem, "error");
    //                     $("#ipInvalido").html("O IP "+ip+" não é permitido para registro de ponto!");
    //                     $("#modalIp").modal('show');
    //                     return false;
    //                 } else {
    //                     smartAlert("Atenção", "Operação não realizada - entre em contato com o suporte!", "error");
    //                     return false;
    //                 }
    //             } else {
    //                 carregaPonto()

    //                 // if (tipoEscala == 1) {
    //                 //     verificarFeriado();
    //                 // } else {
    //                 //     $('#dlgSimplePonto').dialog('open');

    //                 //     if (horaRetorno) {
    //                 //         $("#alerta").html("O retorno do seu intervalo é as " + horaRetorno).css('color', 'red');
    //                 //     }
    //                 // }
    //             }
    //         }
    //     );
    // }

    function imprimir() {
        const id = $('#funcionario').val();
        const folha = $('#idFolha').val();
        const mesAno = moment().startOf('month').format('YYYY-MM-DD');
        const tipoEscala = $("#tipoEscala").val();
        const layoutFolhaPonto = $("#layoutFolhaPonto").val();

        // if (tipoEscala == 1) {
            if (layoutFolhaPonto == 1) {
                window.open(`funcionario_folhaDePontoPdfPontoEletronico.php?data=${mesAno}`); // Analitica/Detalhada
            } else if (layoutFolhaPonto == 2) {
                window.open(`prototipo_folhaDePontoPdfPontoEletronico.php?data=${mesAno}`); // Sintética/Simples
            } else if(layoutFolhaPonto == 3){
                window.open(`funcionario_folhaPontoPdfPontoEletronico.php?data=${mesAno}`); // Híbrida(Antiga)
            }
        // } else {
        //     window.open(`funcionario_folhaPontoRevezamentoPdf.php?data=${mesAno}`);
        // }
    }

    function verificarFeriado() {
        var mesAno = $("#mesAno").val();
        const funcionario = $("#funcionario").val()

        verificaFeriado(mesAno, funcionario, function(data) {
            if (data.indexOf('failed') > -1) {
                // if (horaRetorno) {
                //     horaRetorno = converteHora(horaRetorno)
                // }
                $('#dlgSimplePonto').dialog('open');

                if (horaRetorno) {
                    $("#alerta").html("O retorno do seu intervalo é as " + horaRetorno).css('color', 'red');
                }
            } else {
                data = data.replace(/failed/g, '');
                $('#dlgSimpleFeriado').dialog('open');
            }
        });
    }

    function desabilitaBotões() {
        $("#btnEntrada").prop('disabled', true);
        $("#btnSaida").prop('disabled', true);
        $("#btnInicioAlmoco").prop('disabled', true);
        $("#btnFimAlmoco").prop('disabled', true);
        $("#lancamento").prop('disabled', true);
        $("#btnLancamento").prop('disabled', true);

        $("#btnInicioPrimeiraPausa").prop('disabled', true);
        $("#btnFimPrimeiraPausa").prop('disabled', true);
        $("#btnInicioSegundaPausa").prop('disabled', true);
        $("#btnFimSegundaPausa").prop('disabled', true);

    }

    function habilitaBotões() {
        $("#btnEntrada").prop('disabled', false);
        $("#btnSaida").prop('disabled', false);
        $("#btnInicioAlmoco").prop('disabled', false);
        $("#btnFimAlmoco").prop('disabled', false);
        $("#lancamento").prop('disabled', false);
        $("#btnLancamento").prop('disabled', false);

        $("#btnInicioPrimeiraPausa").prop('disabled', false);
        $("#btnFimPrimeiraPausa").prop('disabled', false);
        $("#btnInicioSegundaPausa").prop('disabled', false);
        $("#btnFimSegundaPausa").prop('disabled', false);
    }

    function verificaAutorizacao(dia) {
        var dia = dia;
        var mesAno = $("#mesAno").val();
        var funcionario = $("#funcionario").val();

        verificarAutorizacao(dia, mesAno, funcionario, function(data) {

            if (data.indexOf('failed') > -1) {
                $('#modalAutorizacao').modal('show');
            }
        });
    }

    function getHora(campo) {
        var campo = campo;

        selecionarHora(function(data) {

            if (data.indexOf('sucess') > -1) {
                var piece = data.split("#");
                var hora = piece[1];
                // var verificaIp = $("#verificaIp").val();
                var tipoEscala = $("#tipoEscala").val();

                let expediente = $("#expediente").text();
                if (!expediente) {
                    expediente = '00:00 - 00:00';
                }
                expediente = expediente.split("-");
                inicioExpediente = parse(expediente[0].trim());
                fimExpediente = parse(expediente[1].trim());

                let intervalo = $("#intervalo").text();
                if (!intervalo) {
                    intervalo = '00:00 - 00:00';
                }
                intervalo = intervalo.split("-");
                inicioIntervalo = parse(intervalo[0].trim());
                fimIntervalo = parse(intervalo[1].trim());

                let horarioPausa = $("#pausa").text();
                if (!horarioPausa) {
                    horarioPausa = '00:00 - 00:00';
                }
                horarioPausa = horarioPausa.split("|");
                horarioPrimeiraPausa = horarioPausa[0].split("-");
                horarioSegundaPausa = horarioPausa[1].split("-");

                inicioPrimeiraPausa = parse(horarioPrimeiraPausa[0].trim());
                fimPrimeiraPausa = parse(horarioPrimeiraPausa[1].trim());
                inicioSegundaPausa = parse(horarioSegundaPausa[0].trim());
                fimSegundaPausa = parse(horarioSegundaPausa[1].trim());

                totalHorasIntervalo = fimIntervalo - inicioIntervalo;
                totalHorasPrimeiraPausa = fimPrimeiraPausa - inicioPrimeiraPausa;
                totalHorasSegundaPausa = fimSegundaPausa - inicioSegundaPausa;

                if (campo == 'Entrada') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#horaEntrada").val(hora)
                    campo = 'horaEntrada';
                }
                if (campo == 'Saida') {
                    var horaEntrada = $("#horaEntrada").val();

                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#horaSaida").val(hora)

                    if (tipoEscala == 1) {
                        if (horaEntrada == '00:00:00') {
                            $("#horaSaida").val('00:00:00');
                            smartAlert("Atenção", "Registre primeiro a hora de entrada!", "error");
                            return false;
                        }
                    }
                    campo = 'horaSaida';
                }
                if (campo == 'Inicio Almoço') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    let separador = hora.split(':');
                    let h = separador[0];
                    let m = separador[1];
                    let s = separador[2];

                    var hora = `${h}:${m}`;
                    $("#inicioAlmoco").val(hora)

                    campo = 'inicioAlmoco';
                }
                if (campo == 'Fim Almoço') {
                    if (validaHoraAtual(horaAtual) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }

                    let separador = hora.split(':');
                    let h = separador[0];
                    let m = separador[1];
                    let s = separador[2];

                    var hora = `${h}:${m}`;
                    $("#fimAlmoco").val(hora)
                    campo = 'fimAlmoco';

                    var inicioIntervalo = $("#inicioAlmoco").val()
                    horaRetorno = converteHora(parse(inicioIntervalo) + totalHorasIntervalo);

                }
                if (campo == 'inicioPrimeiraPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#inicioPrimeiraPausa").val(hora)

                    var horaEntrada = $("#horaEntrada").val();
                    if (parse(hora) < (parse(horaEntrada) + parse('01:00:00'))) {
                        $("#inicioPrimeiraPausa").val('')
                        smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h da entrada!", "error");
                        return;
                    }

                    if(inicioExpediente < fimExpediente){
                        if (parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    }else{
                        if (horaEntrada == '00:00:00' && parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    }

                    $('#dlgSimplePausa').dialog('open');

                    return;
                }
                if (campo == 'fimPrimeiraPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#fimPrimeiraPausa").val(hora)

                    $('#dlgSimplePausa').dialog('open');

                    var inicioPausa = $("#inicioPrimeiraPausa").val()
                    horaRetorno = converteHora(parse(inicioPausa) + totalHorasPrimeiraPausa);

                    if (horaRetorno) {
                        $("#alertaPausa").html("O retorno da sua pausa é as " + horaRetorno).css('color', 'red');
                    }
                    return;
                }
                if (campo == 'inicioSegundaPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#inicioSegundaPausa").val(hora)

                    var horaEntrada = $("#horaEntrada").val();

                    if (horaEntrada != '00:00:00' && (parse(hora) < (parse(horaEntrada) + parse('01:00:00')))) {
                        $("#inicioSegundaPausa").val('')
                        smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h da entrada!", "error");
                        return;
                    }

                    if(inicioExpediente < fimExpediente){
                        if (parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    }else{
                        if (horaEntrada == '00:00:00' && parse(hora) > (fimExpediente - parse('01:00:00'))) {
                            $("#inicioPrimeiraPausa").val('')
                            smartAlert("Atenção", "A pausa não pode ser registrada com menos de 1h para o fim do expediente!", "error");
                            return;
                        }
                    }
                    $('#dlgSimplePausa').dialog('open');

                    // registraPausa(btnClicado);

                    return;
                }
                if (campo == 'fimSegundaPausa') {
                    if (validaHoraAtual(hora) == false) {
                        $('#modalErro').modal('show');
                        return;
                    }
                    $("#fimSegundaPausa").val(hora)

                    $('#dlgSimplePausa').dialog('open');

                    var inicioPausa = $("#inicioSegundaPausa").val()
                    horaRetorno = converteHora(parse(inicioPausa) + totalHorasSegundaPausa);

                    if (horaRetorno) {
                        $("#alertaPausa").html("O retorno da sua pausa é as " + horaRetorno).css('color', 'red');
                    }

                    return;
                }

                // if (verificaIp == 1) {
                //     var ip = $("#ip").val();

                //     if (ip) {
                //         validarIp();
                //     } else {
                //         campo = '#' + campo;
                //         $(campo).val("");
                //         smartAlert("Atenção", "Não foi possivel verificar o IP!", "error");
                //         return;
                //     }
                // } else {
                    if (tipoEscala == 1) {
                        verificarFeriado();
                    } else {
                        $('#dlgSimplePonto').dialog('open');

                        if (horaRetorno) {
                            $("#alerta").html("O retorno do seu intervalo é as " + horaRetorno).css('color', 'red');
                        }
                    }
                // }
            }
        });
    }

    function abateBancoHoras(lancamento, dia, horaEntrada, horaSaida, atraso) {
        let abateBancoHoras = 0;

        consultarAbateBancoHoras(lancamento, atraso, horaEntrada, horaSaida, function(data) {

            data = data.replace(/failed/gi, '');
            var piece = data.split("#");

            var out = piece[1];
            var mensagem = piece[2];

            piece = out.split("^");

            abateBancoHoras = piece[0];

            if (abateBancoHoras == 1) {
                $("#atraso").val("00:00:00");
            }

            if (mensagem != '') {
                smartAlert("Atenção", mensagem, "error");

                $("#lancamento").val("");

                return false;
            }

            gravar();
            return;
        })

    }

    function compensarFalta(horaExtra, dia, lancamento) {
        const idFolha = $('#idFolha').val();
        let compensaFalta = 0;

        verificaLancamento(lancamento, horaExtra, idFolha, dia, function(data) {

            data = data.replace(/failed/gi, '');
            var piece = data.split("#");

            var out = piece[1];
            var mensagem = piece[2];
            piece = out.split("^");

            compensaFalta = piece[0];

            if (compensaFalta == 1) {
                $("#horaExtra").val("00:00:00");
            }

            if (mensagem) {
                smartAlert("Atenção", mensagem, "error");

                $("#lancamento").val("");
                return false;
            }

            gravar();
            return;
        })
    }

    function confirmarRegistro(idFolha, dia, btnClicado, mesAno) {
        confirmaRegistro(idFolha, dia, mesAno, function(data) {

            data = data.replace(/failed/gi, '');
            var piece = data.split("#");

            var horaEntrada = piece[1];
            var inicioAlmoco = piece[2];
            var fimAlmoco = piece[3];
            var horaSaida = piece[4];
            var inicioPrimeiraPausa = piece[5];
            var fimPrimeiraPausa = piece[6];
            var inicioSegundaPausa = piece[7];
            var fimSegundaPausa = piece[8];
            var dataRegistro = piece[9];

            $("#dataComprovante").html('Data: ' + dataRegistro);
            if (btnClicado == 'entrada') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Hora Entrada: ' + horaEntrada);
            } else if (btnClicado == 'inicioAlmoco') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Inicio Intervalo: ' + inicioAlmoco);
            } else if (btnClicado == 'fimAlmoco') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Fim Intervalo: ' + fimAlmoco);
            } else if (btnClicado == 'saida') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Hora Saida: ' + horaSaida);
            } else if (btnClicado == 'inicioPrimeiraPausa') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Inicio Primeira Pausa: ' + inicioPrimeiraPausa);
            } else if (btnClicado == 'fimPrimeiraPausa') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Fim Primeira Pausa: ' + fimPrimeiraPausa);
            } else if (btnClicado == 'inicioSegundaPausa') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Inicio Segunda Pausa: ' + inicioSegundaPausa);
            } else if (btnClicado == 'fimSegundaPausa') {
                $("#comprovanteRegistro").modal('show');
                $("#horaComprovante").html('Fim Segunda Pausa: ' + fimSegundaPausa);
            }

            return;
        })
    }

    function registraPausa(btnClicado) {

        // var codigoPausa = $("#codigoPausa").val();
        var inicioPrimeiraPausa = $("#inicioPrimeiraPausa").val();
        var fimPrimeiraPausa = $("#fimPrimeiraPausa").val();
        var inicioSegundaPausa = $("#inicioSegundaPausa").val();
        var fimSegundaPausa = $("#fimSegundaPausa").val();
        var idFolha = $("#idFolha").val();
        var mesAno = $("#mesAno").val();
        var dataAtual = new Date();
        var dia = dataAtual.getDate();
        var justificativaPausa = $("#justificativaPausa").val();

        registrarPausa(idFolha, mesAno, dia, inicioPrimeiraPausa, fimPrimeiraPausa, inicioSegundaPausa, fimSegundaPausa, btnClicado, justificativaPausa,
            function(data) {

                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com o suporte!", "error");
                        return false;
                    }
                } else {
                    var piece = data.split("#");
                    var mensagem = piece[2];
                    if (!mensagem) {
                        smartAlert("Sucesso", "Pausa marcada com sucesso!", "success");
                    }
                    confirmarRegistro(idFolha, dia, btnClicado, mesAno);
                    // voltar()
                }
            }
        );
    }

    function justificar(btnClicado) {

        $('#dlgSimpleJustificativa').dialog('open');
        if (btnClicado == 'entrada') {
            $("#titulo").html("Justificativa de Atraso");
        } else if (btnClicado == 'saida') {
            $("#titulo").html("Justificativa de Hora Extra");
        }
    }

    function abonarAtraso() {
        const lancamento = $("#inputLancamento").val();
        let abonarAtraso = 0;

        $.ajax({
            url: 'js/sqlscope_pontoEletronicoDiario.php',
            dataType: 'html', //tipo do retorno
            type: 'post', //metodo de envio
            data: {
                funcao: 'consultaLancamentoAbono',
                lancamento: lancamento
            },
            success: function(data) {
                data = data.replace(/failed/gi, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];
                piece = out.split("^");

                abonarAtraso = piece[0];

                if (abonarAtraso == 1) {
                    $("#inputLancamento").val("00:00:00");
                }

                return;
            },
            error: function(xhr, er) {
                console.log(xhr, er);
            }
        });
    }

    function converteHora(segundos) {
        let horas = Math.floor(segundos / Math.pow(60, 2));
        segundos = segundos - (horas * 3600);
        let minutos = Math.floor(segundos / 60);
        segundos = segundos - (minutos * 60);

        if (horas.toString().length < 2) horas = `0${horas}`;
        if (minutos.toString().length < 2) minutos = `0${minutos}`;
        if (segundos.toString().length < 2) segundos = `0${segundos}`;

        return `${horas}:${minutos}:${segundos}`;
    }
    
    function recuperaDados() {
        const funcionario = $("#funcionario").val();
        $.ajax({
            url: 'js/sqlscope_pontoEletronicoDiario.php',
            dataType: 'html', //tipo do retorno
            type: 'post', //metodo de envio
            data: {
                funcao: 'recuperaDados',
                funcionario: funcionario
            },
            //essa é a function success, será executada se a requisição obtiver exito
            success: function(data) {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];

                piece = out.split("^");

                //Atributos do funcionário
                verificaIp = piece[0];

                // if(verificaIp == 1){
                    getIpClient();
                // }else{
                //     carregaPonto();
                // }
            }
        });
    }

    function resetaTempo() {
        clearInterval(intervalo);
        tempo = 300000;
        intervalo = setInterval(() => {
            $(location).attr('href', 'index.php');
        }, (tempo));
    }
</script>