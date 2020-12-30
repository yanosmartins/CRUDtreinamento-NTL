<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoAcessarOK = (in_array('SINDICATO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('SINDICATO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('SINDICATO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Sindicato";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");
include("populaTabela/popula.php");
include

    //include left panel (navigation)
    //follow the tree in inc/config.ui.php
    $page_nav["cadastro"]["sub"]["sindicato"]["active"] = true;

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
                            <h2>Sindicato</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" autocomplete="off" id="formSindicato" method="post">
                                    <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden">
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
                                                        <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input type="text" id="codigo" name="codigo" class="readonly" readonly />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="mes">Data Base</label>
                                                                <label class="select">
                                                                    <select id="dataBase" name="dataBase">
                                                                        <?php
                                                                        echo populaMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Descrição</label>
                                                                <label class="input">
                                                                    <input id="descricao" name="descricao" autocomplete="off" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Apelido</label>
                                                                <label class="input">
                                                                    <input id="apelido" name="apelido" autocomplete="off" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label">CNPJ</label>
                                                                <label class="input">
                                                                    <input class="required" id="cnpj" name="cnpj" type="text" placeholder="XX.XXX.XXX/XXXX-XX" value="" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Código SCI</label>
                                                                <label class="input">
                                                                    <input class="required" id="codigoSindicatoSCI" name="codigoSindicatoSCI" type="text" value="" autocomplete="new-password">
                                                                </label>
                                                            </section>


                                                        </div>

                                                        <!-- TITULO DE VALE REFEIÇÃO -->
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend> Vale Refeição & Vale Alimentação </legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="descontarValeRefeicao">Descontar Vale Refeição</label>
                                                                <label class="select">
                                                                    <select id="descontarValeRefeicao" name="descontarValeRefeicao">
                                                                        <?php
                                                                        echo populaVAVR();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="descontarFeriasVR">Descontar Férias</label>
                                                                <label class="select">
                                                                    <select id="descontarFeriasVR" name="descontarFeriasVR">
                                                                        <option value="" style="display:none;">Selecione</option>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Diário</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" style="text-align: right;" id="valorDiarioVR" name="valorDiarioVR" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Mensal</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorMensalVR" style="text-align: right;" name="valorMensalVR" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Desconto em Folha</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input type="text" maxlength="3" placeholder="0,00" id="descontoVRFolha" style="text-align: right;" name="descontoVRFolha" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor do Desconto</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDescontoVRFolha" name="valorDescontoVRFolha" style="text-align: right;" class="decimal-2-casas " />
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <!-- TITULO DE VALE ALIMENTAÇÃO -->
                                                        <!-- <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Vale Alimentação</legend>
                                                            </section>
                                                        </div> -->
                                            
                                                        <!-- <div class="row">
                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="mes">Descontar Vale Alimentação</label>
                                                                <label class="select">
                                                                    <select id="descontaVA" name="descontaVA">
                                                                        <?php
                                                                        echo populaVAVR();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Descontar Férias</label>
                                                                <label class="select">
                                                                    <select id="descontarFeriasVA" name="descontarFeriasVA">
                                                                        <option value="" style="display:none;">Selecione</option>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div> -->
                                                        <input type="hidden" placeholder="0,00" id="valorDiarioVA" style="text-align: right;" name="valorDiarioVA" class="decimal-2-casas" />
                                                        <input type="hidden" placeholder="0,00" id="valorMensalVA" name="valorMensalVA" style="text-align: right;" class=" decimal-2-casas" />
                                                        <input type="hidden" placeholder="0,00" maxlength="3" id="descontoVAFolha" name="descontoVAFolha" style="text-align: right;" class=" decimal-2-casas" />
                                                        <input type="hidden" placeholder="0,00" id="valorDescontoVAFolha" name="valorDescontoVAFolha" style="text-align: right;" class=" decimal-2-casas" />
                                                        
                                                        <!-- <div class="row">
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Diário</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDiarioVA" style="text-align: right;" name="valorDiarioVA" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Mensal</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorMensalVA" name="valorMensalVA" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Desconto em Folha</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input type="text" placeholder="0,00" maxlength="3" id="descontoVAFolha" name="descontoVAFolha" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor do Desconto</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDescontoVAFolha" name="valorDescontoVAFolha" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                        </div> -->

                                                        <!-- TITULO DE CESTA BÁSICA  -->
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Cesta Básica</legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <input id="perdaBeneficio" type="hidden" name="perdaBeneficio">
                                                            <section class="col col-2">
                                                                <label class="label" for="qtdDiaFalta">Qtd. Dias Falta</label>
                                                                <label class="select">
                                                                    <select id="qtdDiaFalta" name="qtdDiaFalta">
                                                                        <?php
                                                                        echo populaQtdDias();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="qtdDiaAusencia">Qtd. Dias Ausência</label>
                                                                <label class="select">
                                                                    <select id="qtdDiaAusencia" name="qtdDiaAusencia">
                                                                        <?php
                                                                        echo populaQtdDias();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="descontarFeriasVR">Descontar Férias</label>
                                                                <label class="select">
                                                                    <select id="descontarFeriasCestaBasica" name="descontarFeriasCestaBasica">
                                                                        <option value="" style="display:none;">Selecione</option>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <!-- <input type="hidden" placeholder="0,00" id="valorDiarioCestaBasica" name="valorDiarioCestaBasica" style="text-align: right;" class=" decimal-2-casas" /> -->
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Diário</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDiarioCestaBasica" style="text-align: right;" name="valorDiarioCestaBasica" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Mensal</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorMensalCestaBasica" name="valorMensalCestaBasica" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Desconto em Folha</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input type="text" placeholder="0,00" maxlength="3" id="descontoFolhaCestaBasica" name="descontoFolhaCestaBasica" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor do Desconto</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDescontoCestaBasica" name="valorDescontoCestaBasica" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Plano de Saúde</legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Desconto do Sindicato</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorBolsa" name="valorBolsa" style="text-align: right;" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Percentual Desconto do Sindicato</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input type="text" placeholder="0,00" id="percentualBolsa" name="percentualBolsa" style="text-align: right;" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Bolsa Benefício</legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Bolsa Benefício 8h</label>
                                                                <label class="input">
                                                                    <input id="valorBolsaBeneficio" name="valorBolsaBeneficio" type="text" class="decimal-2-casas " placeholder="0,00" style="text-align: right;" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Bolsa Benefício 6h</label>
                                                                <label class="input">
                                                                    <input id="valorBolsaBeneficio6h" name="valorBolsaBeneficio6h" type="text" class="decimal-2-casas " placeholder="0,00" style="text-align: right;" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Seguro de Vida</legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="seguroVida">Seguro de Vida</label>
                                                                <label class="select">
                                                                    <select id="seguroVida" name="seguroVida">
                                                                        <option value='' style="display:none;">Selecione</option>
                                                                        <option value='1'>Sim</option>
                                                                        <option value='0'>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ACCORDION DE HORA EXTRA  | MINIMIZE O CÓDIGO PARA TÊ-LO POR COMPLETO.-->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseHoraExtra" class="collapsed" id="accordionHoraExtra">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Hora Extra
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseHoraExtra" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="percentualHoraExtraSegundaSabado">Segunda a Sábado</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="percentualHoraExtraSegundaSabado" name="percentualHoraExtraSegundaSabado" placehoder="0,00" type="text" class="decimal-2-casas" style="text-align: right;" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Domingo e Feriado</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="percentualHoraExtraDomingoFeriado" name="percentualHoraExtraDomingoFeriado" placeholder="0,00" type="text" class="decimal-2-casas" style="text-align: right;" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <!-- LEGENDA : DIURNO -->
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Adicional Noturno</legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Hora Inicio</label>
                                                                <label class="input">
                                                                    <input id="horaInicialAidicionalNoturno" placeholder="HH:MM" name="horaInicialAidicionalNoturno" autocomplete="off" type="text" class="" onchange="validateHhMm(this)">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Hora Fim</label>
                                                                <label class="input">
                                                                    <input id="horaFinalAidicionalNoturno" placeholder="HH:MM" name="horaFinalAidicionalNoturno" autocomplete="off" type="text" class="" onchange="validateHhMm(this)">
                                                                </label>
                                                            </section>
                                                            <!-- <section class="col col-2">
                                                                <label>Clockpicker:</label>
                                                                <div class="input-group">
                                                                    <input class="form-control clop" id="clockpicker" type="text" placeholder="Select time" data-autoclose="true"> <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                </div>
                                                            </section> -->
                                                            <input id="adicionalNoturno" name="adicionalNoturno" placeholder="0,00" type="hidden" class=" decimal-2-casas" style="text-align: right;" maxlength="3" autocomplete="off">
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="percentualHoraExtraSegundaSabadoNoturno">Segunda a Sábado Noturno</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="percentualHoraExtraSegundaSabadoNoturno" name="percentualHoraExtraSegundaSabadoNoturno" placehoder="0,00" type="text" class="decimal-2-casas" style="text-align: right;" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Domingo e Feriado Noturno</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="percentualHoraExtraDomingoFeriadoNoturno" name="percentualHoraExtraDomingoFeriadoNoturno" placeholder="0,00" type="text" class="decimal-2-casas" style="text-align: right;" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ACCORDION DE ENDEREÇO  | MINIMIZE O CÓDIGO PARA TÊ-LO POR COMPLETO.-->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco" class="collapsed" id="accordionEndereco">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Endereço
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEndereco" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">

                                                            <section class="col col-2">
                                                                <label class="label" for="cep">CEP</label>
                                                                <label class="input">
                                                                    <input placeholder="XXXXX-XXX" id="cep" name="cep" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <!-- <section class="col col-2">
                                                                <label class="label" for="tipoLogradouro">Tipo de Logradouro</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="tipoLogradouro" name="tipoLogradouro" maxlength="15" autocomplete="off">
                                                                </label>
                                                            </section> -->
                                                            <section class="col col-5">
                                                                <label class="label" for="logradouro">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" maxlength="255" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="numero">Número</label>
                                                                <label class="input">
                                                                    <input id="numero" name="numero" maxlength="20" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="complemento">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" maxlength="100" rows='2'></input>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="estado">Estado</label>
                                                                <label class="select">
                                                                    <select id="estado" name="estado">
                                                                        <?php
                                                                        echo populaUf();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="bairro">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" name="bairro" maxlength="30" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="cidade">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" name="cidade" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CONTATO -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="collapsed" id="accordionContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Contato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="jsonTelefone" name="jsonTelefone" type="hidden" value="[]">
                                                        <input id="jsonEmail" name="jsonEmail" type="hidden" value="[]">
                                                        <div id="formTelefone" class="col-sm-6">
                                                            <input id="telefoneId" name="telefoneId" type="hidden" value="">
                                                            <input id="descricaoTelefonePrincipal" name="descricaoTelefonePrincipal" type="hidden" value="">
                                                            <input id="descricaoTelefoneWhatsApp" name="descricaoTelefoneWhatsApp" type="hidden" value="">
                                                            <input id="sequencialTel" name="sequencialTel" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label">Telefone</label>
                                                                        <label class="input"><i class="icon-prepend fa fa-phone"></i>
                                                                            <input id="telefone" name="telefone" type="text" class="form-control" value="">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <label id="labelTelefonePrincipal" class="checkbox ">
                                                                            <input id="telefonePrincipal" name="telefonePrincipal" type="checkbox" value="true" checked="checked"><i></i>
                                                                            Principal
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <label id="labelTelefoneWhatsApp" class="checkbox ">
                                                                            <input id="telefoneWhatsApp" name="telefoneWhatsApp" type="checkbox" value="true" checked="checked"><i></i>
                                                                            WhatsApp
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-4">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddTelefone" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverTelefone" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableTelefone" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 500%;">Telefone</th>
                                                                            <th class="text-left">Principal</th>
                                                                            <th class="text-left">WhatsApp</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div id="formEmail" class="col-sm-6">
                                                            <input id="emailId" name="emailId" type="hidden" value="">
                                                            <input id="descricaoEmailPrincipal" name="descricaoEmailPrincipal" type="hidden" value="">
                                                            <input id="sequencialEmail" name="sequencialEmail" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-7">
                                                                        <label class="label">Email</label>
                                                                        <label class="input"><i class="icon-prepend fa fa-at"></i>
                                                                            <input id="email" maxlength="50" name="email" type="text" value="">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <label id="labelEmailPrincipal" class="checkbox ">
                                                                            <input id="emailPrincipal" name="emailPrincipal" type="checkbox" value="true" checked="checked"><i></i>
                                                                            Principal
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-auto">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddEmail" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverEmail" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 100px;">Email</th>
                                                                            <th class="text-left">Principal</th>
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
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDiaUtil" class="collapsed" id="accordionDiaUtil">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dias Úteis
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDiaUtil" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                    <div class="row">
                                                            <section class="col col-12">
                                                                <legend>VA e VR</legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJaneiro" name="mesUtilJaneiro" autocomplete="off" class="readonly" type="text" value="Janeiro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJaneiro" name="diaUtilJaneiro">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilFevereiro" name="mesUtilFevereiro" autocomplete="on" class="readonly" readonly type="text" value="Fevereiro">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilFevereiro" name="diaUtilFevereiro">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilMarco" name="mesUtilMarco" autocomplete="on" class="readonly" type="text" value="Março" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilMarco" name="diaUtilMarco">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilAbril" name="mesUtilAbril" autocomplete="on" class="readonly" type="text" value="Abril" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilAbril" name="diaUtilAbril">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input readonly id="mesUtilMaio" name="mesUtilMaio" autocomplete="on" class="readonly" type="text" value="Maio">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilMaio" name="diaUtilMaio">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJunho" name="mesUtilJunho" autocomplete="on" class="readonly" type="text" value="Junho" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJunho" name="diaUtilJunho">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJulho" name="mesUtilJulho" autocomplete="on" class="readonly" type="text" value="Julho" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJulho" name="diaUtilJulho">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilAgosto" name="mesUtilAgosto" autocomplete="on" class="readonly" type="text" value="Agosto" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilAgosto" name="diaUtilAgosto">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilSetembro" name="mesUtilSetembro" autocomplete="on" class="readonly" type="text" value="Setembro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilSetembro" name="diaUtilSetembro">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilOutubro" name="mesUtilOutubro" autocomplete="on" class="readonly" type="text" value="Outubro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilOutubro" name="diaUtilOutubro">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilNovembro" name="mesUtilNovembro" autocomplete="on" class="readonly" type="text" value="Novembro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilNovembro" name="diaUtilNovembro">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilDezembro" name="mesUtilDezembro" autocomplete="on" class="readonly" type="text" value="Dezembro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilDezembro" name="diaUtilDezembro">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                         
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Vale Transporte</legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJaneiroVT" name="mesUtilJaneiroVT" autocomplete="off" class="readonly" type="text" value="Janeiro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJaneiroVT" name="diaUtilJaneiroVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilFevereiroVT" name="mesUtilFevereiroVT" autocomplete="on" class="readonly" readonly type="text" value="Fevereiro">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilFevereiroVT" name="diaUtilFevereiroVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilMarcoVT" name="mesUtilMarcoVT" autocomplete="on" class="readonly" type="text" value="Março" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilMarcoVT" name="diaUtilMarcoVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilAbrilVT" name="mesUtilAbrilVT" autocomplete="on" class="readonly" type="text" value="Abril" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilAbrilVT" name="diaUtilAbrilVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input readonly id="mesUtilMaioVT" name="mesUtilMaioVT" autocomplete="on" class="readonly" type="text" value="Maio">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilMaioVT" name="diaUtilMaioVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJunhoVT" name="mesUtilJunhoVT" autocomplete="on" class="readonly" type="text" value="Junho" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJunhoVT" name="diaUtilJunhoVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJulhoVT" name="mesUtilJulhoVT" autocomplete="on" class="readonly" type="text" value="Julho" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJulhoVT" name="diaUtilJulhoVT">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilAgostoVT" name="mesUtilAgostoVT" autocomplete="on" class="readonly" type="text" value="Agosto" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilAgostoVT" name="diaUtilAgostoVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilSetembroVT" name="mesUtilSetembroVT" autocomplete="on" class="readonly" type="text" value="Setembro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilSetembroVT" name="diaUtilSetembroVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilOutubroVT" name="mesUtilOutubroVT" autocomplete="on" class="readonly" type="text" value="Outubro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilOutubroVT" name="diaUtilOutubroVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilNovembroVT" name="mesUtilNovembroVT" autocomplete="on" class="readonly" type="text" value="Novembro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilNovembroVT" name="diaUtilNovembroVT">
                                                                        <?php
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label"> </label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilDezembroVT" name="mesUtilDezembroVT" autocomplete="on" class="readonly" type="text" value="Dezembro" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilDezembroVT" name="diaUtilDezembroVT">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
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
                                            <span class="fa fa-backward "></span>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroSindicato.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_URL; ?>/js/gir_script.js" type="text/javascript"></script>

<script src="js/plugin/clockpicker/clockpicker.min.js"></script>

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
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Validador de CPF -->
<script src="js/plugin/cpfcnpj/jquery.cpfcnpj.js"></script>


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($("#jsonEmail").val());
        $("#horaInicialAidicionalNoturno,#horaFinalAidicionalNoturno").mask("99:99", {
            placeholder: "HH:MM"
        })

        $("#cnpj").mask("99.999.999/9999-99", {
            placeholder: "X"
        });
        $("#cep").mask("99999-999", {
            placeholder: "X"
        });
        carregaPagina();

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "Atenção",
            buttons: [{
                html: "Excluir registro",
                "class": "btn btn-success",
                click: function() {
                    $(this).dialog("close");
                    excluir();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });
        $("#btnExcluir").on("click", function() {
            var id = parseInt($("#codigo").val());
            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');

            }
        });
        $("#btnNovo").on("click", function() {
            novo();
        });
        $("#cnpj").on("change", function() {
            var cnpj = $("#cnpj").val();
            if (!validacao_cnpj(cnpj)) {
                smartAlert("Atenção", "CNPJ inválido!", "error");
                $("#cnpj").val('');
            }
        });
        $("#cep").on("focusout", function() {
            var cep = $("#cep").val();
            var funcao = 'recuperaCep';

            $.ajax({
                method: 'POST',
                url: 'js/sqlscope.php',
                data: {
                    funcao,
                    cep
                },
                success: function(data) {
                    var status = data.split('#');
                    var piece = status[1].split('^');
                    debugger;
                    $("#logradouro").val(piece[0] + " " + piece[1]);
                    $("#bairro").val(piece[2]);
                    $("#cidade").val(piece[3]);
                    $("#estado").val(piece[4]);
                    return;
                }
            });
        });

        $("#btnAddTelefone").on("click", function() {
            if (validaTelefone())
                addTelefone();
        });
        $("#btnRemoverTelefone").on("click", function() {
            excluirContato();
        });
        $("#btnGravar").on("click", function() {
            var descricao = $("#descricao").val();
            var apelido = $("#apelido").val();
            var cnpj = $("#cnpj").val();
            if (descricao === "") {
                smartAlert("Erro", "Informe a Descrição", "error");
                $("#descricao").focus();
                return;
            }
            if (apelido === "") {
                smartAlert("Erro", "Informe o Apelido", "error");
                $("#apelido").focus();
                return;
            }
            if (cnpj === "") {
                smartAlert("Erro", "Informe o CNPJ", "error");
                $("#cnpj").focus();
                return;
            }

            gravarSindicato();

        });
        $('#btnAddEmail').on("click", function() {
            if (validaEmail())
                addEmail();

        });
        $('#btnRemoverEmail').on("click", function() {
            excluirEmail();
        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $('.dinheiro').mask('#.##9,99', {
            reverse: true
        });

        $("#cnpj").on("focusout", function() {
            var cnpj = $('#cnpj').val();
            var retorno = validacao_cnpj(cnpj)
            var idd = ($("#cnpj").val());
            pesquisaCnpj(idd,
                function(data) {
                    if (data.indexOf('failed') > -1) {
                        return;
                    } else {
                        data = data.replace(/failed/g, '');
                        if (data != "") {
                            smartAlert("Erro", "CNPJ já cadastrado.", "error");
                            $('#cnpj').val('');
                            return false;
                        }
                        return;

                    }
                });

        });
        $("#valorDiarioVR").on("change", function() {
            $("#valorMensalVR").val('');
        });
        $("#valorMensalVR").on("change", function() {
            $("#valorDiarioVR").val('');
        });
        $("#descontoVRFolha").on("change", function() {
            $("#valorDescontoVRFolha").val('');
        });
        $("#valorDescontoVRFolha").on("change", function() {
            $("#descontoVRFolha").val('');
        });
        $("#valorDiarioVA").on("change", function() {
            $("#valorMensalVA").val('');
        });
        $("#valorMensalVA").on("change", function() {
            $("#valorDiarioVA").val('');
        });
        $("#descontoVAFolha").on("change", function() {
            $("#valorDescontoVAFolha").val('');
        });
        $("#valorDescontoVAFolha").on("change", function() {
            $("#descontoVAFolha").val('');
        });
        $("#valorDiarioCestaBasica").on("change", function() {
            $("#valorMensalCestaBasica").val('');
        });
        $("#valorMensalCestaBasica").on("change", function() {
            $("#valorDiarioCestaBasica").val('');
        });
        $("#descontoFolhaCestaBasica").on("change", function() {
            $("#valorDescontoCestaBasica").val('');
        });
        $("#valorDescontoCestaBasica").on("change", function() {
            $("#descontoFolhaCestaBasica").val('');
        });
        $("#valorBolsa").on("change", function() {
            $("#percentualBolsa").val('');
        });
        $("#percentualBolsa").on("change", function() {
            $("#valorBolsa").val('');
        });
        $("#descontoVr").keyup(function() {
            //Obter o primeiro caractere digitado
            var temp = $(this).val().charAt(0);
            //Verificar se o primeiro caractere inserido é '-'
            if (temp == '-') {
                //Aplica a máscara para números negativos
                $("#edtPercentual").mask("-99,99%");
            }
            //Verificar se o primeiro caractere inserido é número
            else if (temp.charAt(0).match(/\d/)) {
                //Aplica a máscara para números positivos
                $("#descontoVr").mask("99,99%");
            }
            //Caso o primeiro caractere inserido seja um caractere inválido limpa o value do campo
            else {
                $("#descontoVr").val('');
            }
        });
        $('.clockpicker').clockpicker({
            placement: 'top',
            donetext: 'Done'
        });
    });



    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaSindicato(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var $strArrayTelefone = piece[2];
                            var $strArrayEmail = piece[3];


                            piece = out.split("^");
                            var codigo = +piece[0];
                            var mesBase = piece[1];
                            var descricao = piece[2];
                            var apelido = piece[3];
                            var cnpj = piece[4];
                            var valorBolsaBeneficio = piece[5];
                            var descontarValeRefeicao = piece[6];
                            var descontarFeriasRefeicao = piece[7];
                            var valorDiarioRefeicao = piece[8];
                            var valorMensalRefeicao = piece[9];
                            var descontoFolhaRefeicao = piece[10];
                            var valorDescontoRefeicao = piece[11];
                            var descontarValeAlimentacao = piece[12];
                            var descontarFeriasAlimentacao = piece[13];
                            var valorDiarioAlimentacao = piece[14];
                            var valorMensalAlimentacao = piece[15];
                            var descontoFolhaAlimentacao = piece[16];
                            var valorDescontoAlimentacao = piece[17];
                            var valorDiarioCestaBasica = piece[18];
                            var valorMensalCestaBasica = piece[19];
                            var descontoFolhaCestaBasica = piece[20];
                            var valorDescontoCestaBasica = piece[21];
                            var valorBolsaPlanoSaude = piece[22];
                            var percentualBolsaPlanoSaude = piece[23];
                            var seguroVida = piece[24];
                            var cep = piece[25];
                            // var tipoLogradouro = piece[26];
                            var logradouro = piece[26];
                            var numeroEndereco = piece[27];
                            var complemento = piece[28];
                            var bairro = piece[29];
                            var cidade = piece[30];
                            var estado = piece[31];
                            var percentualHoraExtraSegundaSabado = piece[32];
                            var percentualHoraExtraDomingoFeriado = piece[33];
                            var adicionalNoturno = piece[34];
                            var horaInicialAidicionalNoturno = piece[35];
                            var horaFinalAidicionalNoturno = piece[36];
                             //Recuperando os dias de VAVR
                            var diaUtilJaneiro = piece[39];
                            var diaUtilFevereiro = piece[40];
                            var diaUtilMarco = piece[41];
                            var diaUtilAbril = piece[42];
                            var diaUtilMaio = piece[43];
                            var diaUtilJunho = piece[44];
                            var diaUtilJulho = piece[45];
                            var diaUtilAgosto = piece[46];
                            var diaUtilSetembro = piece[47];
                            var diaUtilOutubro = piece[48];
                            var diaUtilNovembro = piece[49];
                            var diaUtilDezembro = piece[50];
                            var perdaBeneficio = piece[51];
                            var percentualHoraExtraSegundaSabadoNoturno = piece[52];
                            var percentualHoraExtraDomingoFeriadoNoturno = piece[53];
                            var valorBolsaBeneficio6h = piece[54];
                            var qtdDiaFalta = piece[55];
                            var qtdDiaAusencia = piece[56];
                            var diaUtilJaneiroVT = piece[57];
                            var diaUtilFevereiroVT = piece[58];
                            var diaUtilMarcoVT = piece[59];
                            var diaUtilAbrilVT = piece[60];
                            var diaUtilMaioVT = piece[61];
                            var diaUtilJunhoVT = piece[62];
                            var diaUtilJulhoVT = piece[63];
                            var diaUtilAgostoVT = piece[64];
                            var diaUtilSetembroVT = piece[65];
                            var diaUtilOutubroVT = piece[66];
                            var diaUtilNovembroVT = piece[67];
                            var diaUtilDezembroVT = piece[68];
                            var codigoSindicatoSCI  = piece[69];
                            var descontarFeriasCestaBasica  = piece[70];
                         

                            $("#codigo").val(codigo);
                            $("#dataBase").val(mesBase);
                            $("#descricao").val(descricao);
                            $("#apelido").val(apelido);
                            $("#cnpj").val(cnpj);
                            $("#codigoSindicatoSCI").val(codigoSindicatoSCI);

                            $("#valorBolsaBeneficio").val(valorBolsaBeneficio);
                            $("#descontarValeRefeicao").val(descontarValeRefeicao);
                            $("#descontarFeriasVR").val(descontarFeriasRefeicao);
                            $("#valorDiarioVR").val(valorDiarioRefeicao);
                            $("#valorMensalVR").val(valorMensalRefeicao);
                            $("#descontoVRFolha").val(descontoFolhaRefeicao);
                            $("#valorDescontoVRFolha").val(valorDescontoRefeicao);
                            $("#descontaVA").val(descontarValeAlimentacao);
                            $("#descontarFeriasVA").val(descontarFeriasAlimentacao);
                            $("#valorDiarioVA").val(valorDiarioAlimentacao);
                            $("#valorMensalVA").val(valorMensalAlimentacao);
                            $("#descontoVAFolha").val(descontoFolhaAlimentacao);
                            $("#valorDescontoVAFolha").val(valorDescontoAlimentacao);
                            $("#valorDiarioCestaBasica").val(valorDiarioCestaBasica);
                            $("#valorMensalCestaBasica").val(valorMensalCestaBasica);
                            $("#descontoFolhaCestaBasica").val(descontoFolhaCestaBasica);
                            $("#valorDescontoCestaBasica").val(valorDescontoCestaBasica);
                            $("#perdaBeneficio").val(perdaBeneficio);
                            $("#valorBolsa").val(valorBolsaPlanoSaude);
                            $("#percentualBolsa").val(percentualBolsaPlanoSaude);
                            $("#seguroVida").val(seguroVida);
                            $("#cep").val(cep);
                            // $("#tipoLogradouro").val(tipoLogradouro);
                            $("#logradouro").val(logradouro);
                            $("#numero").val(numeroEndereco);
                            $("#complemento").val(complemento);
                            $("#bairro").val(bairro);
                            $("#cidade").val(cidade);
                            $("#estado").val(estado);

                            $("#percentualHoraExtraSegundaSabado").val(percentualHoraExtraSegundaSabado);
                            $("#percentualHoraExtraDomingoFeriado").val(percentualHoraExtraDomingoFeriado);
                            $("#percentualHoraExtraSegundaSabadoNoturno").val(percentualHoraExtraSegundaSabadoNoturno);
                            $("#percentualHoraExtraDomingoFeriadoNoturno").val(percentualHoraExtraDomingoFeriadoNoturno);

                            $("#adicionalNoturno").val(adicionalNoturno);
                            $("#horaInicialAidicionalNoturno").val(horaInicialAidicionalNoturno);
                            $("#horaFinalAidicionalNoturno").val(horaFinalAidicionalNoturno);
                            //Dias Uteis VAVR
                            $("#diaUtilJaneiro").val(diaUtilJaneiro);
                            $("#diaUtilFevereiro").val(diaUtilFevereiro);
                            $("#diaUtilMarco").val(diaUtilMarco);
                            $("#diaUtilAbril").val(diaUtilAbril);
                            $("#diaUtilMaio").val(diaUtilMaio);
                            $("#diaUtilJunho").val(diaUtilJunho);
                            $("#diaUtilJulho").val(diaUtilJulho);
                            $("#diaUtilAgosto").val(diaUtilAgosto);
                            $("#diaUtilSetembro").val(diaUtilSetembro);
                            $("#diaUtilOutubro").val(diaUtilOutubro);
                            $("#diaUtilNovembro").val(diaUtilNovembro);
                            $("#diaUtilDezembro").val(diaUtilDezembro);
                            $("#valorBolsaBeneficio6h").val(valorBolsaBeneficio6h);
                            $("#verificaRecuperacao").val(1);
                            $("#qtdDiaFalta").val(qtdDiaFalta);
                            $("#qtdDiaAusencia").val(qtdDiaAusencia);
                            
                        
                            //Dias Uteis VT
                            $("#diaUtilJaneiroVT").val(diaUtilJaneiroVT);
                            $("#diaUtilFevereiroVT").val(diaUtilFevereiroVT);
                            $("#diaUtilMarcoVT").val(diaUtilMarcoVT);
                            $("#diaUtilAbrilVT").val(diaUtilAbrilVT);
                            $("#diaUtilMaioVT").val(diaUtilMaioVT);
                            $("#diaUtilJunhoVT").val(diaUtilJunhoVT);
                            $("#diaUtilJulhoVT").val(diaUtilJulhoVT);
                            $("#diaUtilAgostoVT").val(diaUtilAgostoVT);
                            $("#diaUtilSetembroVT").val(diaUtilSetembroVT);
                            $("#diaUtilOutubroVT").val(diaUtilOutubroVT);
                            $("#diaUtilNovembroVT").val(diaUtilNovembroVT);
                            $("#diaUtilDezembroVT").val(diaUtilDezembroVT);

                            $("#descontarFeriasCestaBasica").val(descontarFeriasCestaBasica);    

                            $("#jsonTelefone").val($strArrayTelefone);
                            $("#jsonEmail").val($strArrayEmail);

                            jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                            jsonEmailArray = JSON.parse($("#jsonEmail").val());

                            fillTableTelefone();
                            fillTableEmail();
                            initializeDecimalBehaviour();

                        }
                    }

                );
            }
        }
        $("#nome").focus();
    }


    function novo() {
        $(location).attr('href', 'cadastro_sindicatoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_sindicatoFiltro.php');
    }


    function excluir() {
        var id = +$("#codigo").val();
        excluirSindicato(id,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                        return false;
                    }
                } else {
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    setTimeout(() => {
                        voltar();
                    }, 1500)

                }
            }
        );
    }


    //############################################################################## LISTA TELEFONE INICIO ####################################################################################################################

    function fillTableTelefone() {
        $("#tableTelefone tbody").empty();
        for (var i = 0; i < jsonTelefoneArray.length; i++) {
            var row = $('<tr />');
            $("#tableTelefone tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelefoneArray[i].sequencialTel + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTel + ');">' + jsonTelefoneArray[i].telefone + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTelefoneArray[i].descricaoTelefonePrincipal + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTelefoneArray[i].descricaoTelefoneWhatsApp + '</td>'));
        }
    }

    function validaTelefone() {
        var existe = false;
        var achou = false;
        var tel = $('#telefone').val();
        var sequencial = +$('#sequencialTel').val();
        var telefonePrincipalMarcado = 0;
        var telefoneWhatsAppMarcado = 0;

        if ($("#telefonePrincipal").is(':checked') === true) {
            telefonePrincipalMarcado = 1;
        }

        if ($("#telefoneWhatsApp").is(':checked') === true) {
            telefoneWhatsAppMarcado = 1;
        }

        if (tel === '') {
            smartAlert("Erro", "Informe um telefone somente.", "error");
            return false;
        }

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefonePrincipalMarcado === 1) {
                if ((jsonTelefoneArray[i].telefonePrincipal === 1) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonTelefoneArray[i].telefone === tel) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    existe = true;
                    break;
                }
            }
        }

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefoneWhatsAppMarcado === 1) {
                if ((jsonTelefoneArray[i].telefoneWhatsApp === 1) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonTelefoneArray[i].telefone === tel) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    existe = true;
                    break;
                }
            }
        }

        if (existe === true) {
            smartAlert("Erro", "Telefone já cadastrado.", "error");
            return false;
        }

        if ((achou === true) && (telefonePrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um telefone principal na lista.", "error");
            return false;
        }

        if ((achou === true) && (telefoneWhatsAppMarcado === 1)) {
            smartAlert("Erro", "Já existe um telefone whatsApp na lista.", "error");
            return false;
        }
        return true;
    }

    function addTelefone() {
        var item = $("#formTelefone").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataTel
        });

        if (item["sequencialTel"] === '') {
            if (jsonTelefoneArray.length === 0) {
                item["sequencialTel"] = 1;
            } else {
                item["sequencialTel"] = Math.max.apply(Math, jsonTelefoneArray.map(function(o) {
                    return o.sequencialTel;
                })) + 1;
            }
            item["telefoneId"] = 0;
        } else {
            item["sequencialTel"] = +item["sequencialTel"];
        }

        var index = -1;
        $.each(jsonTelefoneArray, function(i, obj) {
            if (+$('#sequencialTel').val() === obj.sequencialTel) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTelefoneArray.splice(index, 1, item);
        else
            jsonTelefoneArray.push(item);

        $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
        fillTableTelefone();
        clearFormTelefone();

    }

    function processDataTel(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "telefone")) {
            var valorTel = $("#telefone").val();
            if (valorTel !== '') {
                fieldName = "telefone";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }
        if (fieldName !== '' && (fieldId === "telefonePrincipal")) {
            var telefonePrincipal = 0;
            if ($("#telefonePrincipal").is(':checked') === true) {
                telefonePrincipal = 1;
            }
            return {
                name: fieldName,
                value: telefonePrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "telefoneWhatsApp")) {
            var telefoneWhatsApp = 0;
            if ($("#telefoneWhatsApp").is(':checked') === true) {
                telefoneWhatsApp = 1;
            }
            return {
                name: fieldName,
                value: telefoneWhatsApp
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoTelefonePrincipal")) {
            var descricaoTelefonePrincipal = "Não";
            if ($("#telefonePrincipal").is(':checked') === true) {
                descricaoTelefonePrincipal = "Sim";
            }
            return {
                name: fieldName,
                value: descricaoTelefonePrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoTelefoneWhatsApp")) {
            var descricaoTelefoneWhatsApp = "Não";
            if ($("#telefoneWhatsApp").is(':checked') === true) {
                descricaoTelefoneWhatsApp = "Sim";
            }
            return {
                name: fieldName,
                value: descricaoTelefoneWhatsApp
            };
        }

        return false;
    }

    function clearFormTelefone() {
        $("#telefone").val('');
        $("#telefoneId").val('');
        $("#sequencialTel").val('');
        $('#telefonePrincipal').val(0);
        $('#telefonePrincipal').prop('checked', false);
        $('#telefoneWhatsApp').prop('checked', false);
        $('#descricaoTelefonePrincipal').val('');
        $('#descricaoTelefoneWhatsApp').val('');
    }

    function carregaTelefone(sequencialTel) {
        var arr = jQuery.grep(jsonTelefoneArray, function(item, i) {
            return (item.sequencialTel === sequencialTel);
        });

        clearFormTelefone();

        if (arr.length > 0) {
            var item = arr[0];
            $("#telefoneId").val(item.telefoneId);
            $("#telefone").val(item.telefone);
            $("#sequencialTel").val(item.sequencialTel);
            $("#telefonePrincipal").val(item.principal);
            $("#telefoneWhatsApp").val(item.whatsapp);

            if (item.principal === 1) {
                $('#telefonePrincipal').prop('checked', true);
                $('#descricaoTelefonePrincipal').val("Sim");
            } else {
                $('#telefonePrincipal').prop('checked', false);
                $('#descricaoTelefonePrincipal').val("Não");
            }

            if (item.whatsapp === 1) {
                $('#telefoneWhatsApp').prop('checked', true);
                $('#descricaoTelefoneWhatsApp').val("Sim");
            } else {
                $('#telefoneWhatsApp').prop('checked', false);
                $('#descricaoTelefoneWhatsApp').val("Não");
            }
        }
    }

    function excluirContato() {
        var arrSequencial = [];
        $('#tableTelefone input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
                var obj = jsonTelefoneArray[i];
                if (jQuery.inArray(obj.sequencialTel, arrSequencial) > -1) {
                    jsonTelefoneArray.splice(i, 1);
                }
            }
            $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
            fillTableTelefone();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 telefone para excluir.", "error");
    }

    //############################################################################## LISTA TELEFONE FIM #######################################################################################################################

    //############################################################################## LISTA EMAIL INICIO #######################################################################################################################

    function fillTableEmail() {
        $("#tableEmail tbody").empty();
        for (var i = 0; i < jsonEmailArray.length; i++) {
            var row = $('<tr />');
            $("#tableEmail tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEmailArray[i].sequencialEmail + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaEmail(' + jsonEmailArray[i].sequencialEmail + ');">' + jsonEmailArray[i].email + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonEmailArray[i].descricaoEmailPrincipal + '</td>'));
        }
    }

    function validaEmail() {
        var existe = false;
        var achou = false;
        var email = $('#email').val();
        var sequencial = +$('#sequencialEmail').val();
        var emailValido = false;
        var emailPrincipalMarcado = 0;

        if ($("#emailPrincipal").is(':checked') === true) {
            emailPrincipalMarcado = 1;
        }
        if (email === '') {
            smartAlert("Erro", "Informe um email.", "error");
            return false;
        }
        if (validateEmail(email)) {
            emailValido = true;
        }
        if (emailValido === false) {
            smartAlert("Erro", "Email inválido.", "error");
            return false;
        }
        for (i = jsonEmailArray.length - 1; i >= 0; i--) {
            if (emailPrincipalMarcado === 1) {
                if ((jsonEmailArray[i].emailPrincipal === 1) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if ((jsonEmailArray[i].email === email) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                existe = true;
                break;
            }
        }
        if (existe === true) {
            smartAlert("Erro", "Email já cadastrado.", "error");
            return false;
        }
        if ((achou === true) && (emailPrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um email principal na lista.", "error");
            return false;
        }
        return true;
    }

    function addEmail() {
        var item = $("#formEmail").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEmail
        });

        if (item["sequencialEmail"] === '') {
            if (jsonEmailArray.length === 0) {
                item["sequencialEmail"] = 1;
            } else {
                item["sequencialEmail"] = Math.max.apply(Math, jsonEmailArray.map(function(o) {
                    return o.sequencialEmail;
                })) + 1;
            }
            item["emailId"] = 0;
        } else {
            item["sequencialEmail"] = +item["sequencialEmail"];
        }
        var index = -1;
        $.each(jsonEmailArray, function(i, obj) {
            if (+$('#sequencialEmail').val() === obj.sequencialEmail) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEmailArray.splice(index, 1, item);
        else
            jsonEmailArray.push(item);

        $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
        fillTableEmail();
        clearFormEmail();
    }

    function processDataEmail(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "emailPrincipal")) {
            var valorEmailPrincipal = 0;
            if ($("#emailPrincipal").is(':checked') === true) {
                valorEmailPrincipal = 1;
            }
            return {
                name: fieldName,
                value: valorEmailPrincipal
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoEmailPrincipal")) {
            var valorDescricaoEmailPrincipal = "Não";
            if ($("#emailPrincipal").is(':checked') === true) {
                valorDescricaoEmailPrincipal = "Sim";
            }
            return {
                name: fieldName,
                value: valorDescricaoEmailPrincipal
            };
        }
        return false;
    }

    function clearFormEmail() {
        $("#email").val('');
        $("#emailId").val('');
        $("#sequencialEmail").val('');
        $('#emailPrincipal').val(0);
        $('#emailPrincipal').prop('checked', false);
        $('#descricaoEmailPrincipal').val('');
    }

    function carregaEmail(sequencialEmail) {
        var arr = jQuery.grep(jsonEmailArray, function(item, i) {
            return (item.sequencialEmail === sequencialEmail);
        });

        clearFormEmail();

        if (arr.length > 0) {
            var item = arr[0];
            $("#emailId").val(item.emailId);
            $("#email").val(item.email);
            $("#sequencialEmail").val(item.sequencialEmail);
            $("#emailPrincipal").val(item.principal);
            if (item.principal === 1) {
                $('#emailPrincipal').prop('checked', true);
                $('#descricaoEmailPrincipal').val("Sim");
            } else {
                $('#emailPrincipal').prop('checked', false);
                $('#descricaoEmailPrincipal').val("Não");
            }
        }

    }

    function excluirEmail() {
        var arrSequencial = [];
        $('#tableEmail input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonEmailArray.length - 1; i >= 0; i--) {
                var obj = jsonEmailArray[i];
                if (jQuery.inArray(obj.sequencialEmail, arrSequencial) > -1) {
                    jsonEmailArray.splice(i, 1);
                }
            }
            $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
            fillTableEmail();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 email para excluir.", "error");
    }

    //############################################################################## LISTA EMAIL FIM ##########################################################################################################################




    function gravarSindicato() {

        let sindicato = $('#formSindicato').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        sindicato.valorBolsaBeneficio = stringToFloat(sindicato.valorBolsaBeneficio);
        sindicato.valorDiarioVR = stringToFloat(sindicato.valorDiarioVR);
        sindicato.valorDescontoVAFolha = stringToFloat(sindicato.valorDescontoVAFolha);
        sindicato.valorMensalVR = stringToFloat(sindicato.valorMensalVR);
        sindicato.descontoVRFolha = stringToFloat(sindicato.descontoVRFolha);
        sindicato.valorDescontoVRFolha = stringToFloat(sindicato.valorDescontoVRFolha);
        sindicato.valorDiarioVA = stringToFloat(sindicato.valorDiarioVA);
        sindicato.valorMensalVA = stringToFloat(sindicato.valorMensalVA);
        sindicato.descontoVAFolha = stringToFloat(sindicato.descontoVAFolha);
        sindicato.valorDiarioCestaBasica = stringToFloat(sindicato.valorDiarioCestaBasica);
        sindicato.valorMensalCestaBasica = stringToFloat(sindicato.valorMensalCestaBasica);
        sindicato.descontoFolhaCestaBasica = stringToFloat(sindicato.descontoFolhaCestaBasica);
        sindicato.valorDescontoCestaBasica = stringToFloat(sindicato.valorDescontoCestaBasica);
        sindicato.valorBolsa = stringToFloat(sindicato.valorBolsa);
        sindicato.valorBolsaBeneficio6h = stringToFloat(sindicato.valorBolsaBeneficio6h);

        gravaSindicato(sindicato,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        return false;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                        novo();
                        return false;
                        //                                                            return;
                    }
                } else {
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");

                    if (verificaRecuperacao === 1) {
                        voltar();
                    } else {
                        novo();
                        return;
                    }
                }
            }
        );
    }

    function validateHhMm(inputField) {
        var isValid = /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);

        if (!isValid) {
            // inputField.style.backgroundColor = '#fba';
            smartAlert("Atenção", "Hora Inválida!", "error");
            $(inputField).val('');
        }
        return isValid;
    }
</script>