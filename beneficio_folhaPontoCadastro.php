<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('FOLHAPONTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('FOLHAPONTO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('FOLHAPONTO_EXCLUIR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}

/* ---------------- PHP Custom Scripts ---------
  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Folha de Ponto";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]["beneficio"]["sub"]["folhaPonto"]["active"] = true;

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
                            <h2>Folha de Ponto</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formUsuario" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFolhaPonto" class="" id="accordionFolhaPonto">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFolhaPonto" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">

                                                            <input id="codigo" name="codigo" autocomplete="off" class="hidden">
                                                            <input id="verificaVale" name="verificaVale" autocomplete="off" class="hidden">
                                                            <input id="horaInicioANSindicato" name="horaInicioANSindicato" autocomplete="off" class="hidden">
                                                            <input id="horaFimANSindicato" name="horaFimANSindicato" autocomplete="off" class="hidden">
                                                            <input id="funcionarioCodigo" name="funcionarioCodigo" autocomplete="off" class="hidden">

                                                            <section class="col col-3">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo, descricao from Ntl.projeto where ativo = 1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-5">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo, nome from Ntl.funcionario where dataDemissaoFuncionario IS NULL AND ativo = 1 order by nome";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $nome = $row['nome'];
                                                                            echo '<option value=' . $codigo . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="mesAnoFolhaPonto">Mês/Ano</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesAnoFolhaPonto" name="mesAnoFolhaPonto" style="text-align: center;" autocomplete="off" data-mask="99/9999" data-mask-placeholder="mm/aaaa" data-dateformat="mm/yy" placeholder="mm/aaaa" type="text" class="datepicker required" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="verificaFerias">&nbsp;</label>
                                                                <button id="verificaFerias" type="button" class="btn btn-success" title="verificaFerias">
                                                                    Verifica Férias
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="tipoDiaUtilVAVR">Tipo dia útil VAVR</label>
                                                                <label class="input">
                                                                    <input id="tipoDiaUtilVAVR" name="tipoDiaUtilVAVR" autocomplete="off" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="diaUtilContratadoMes">Dias úteis VA/VR</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="diaUtilNoMesVAVR" name="diaUtilNoMesVAVR" autocomplete="off" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="tipoDiaUtilVT">Tipo dia útil VT</label>
                                                                <label class="input">
                                                                    <input id="tipoDiaUtilVT" name="tipoDiaUtilVT" autocomplete="off" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="diaUtilContratadoMes">Dias úteis VT</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="diaUtilNoMesVT" name="diaUtilNoMesVT" autocomplete="off" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label" for="justificativaFolhaPonto">Observação ou pendência</label>
                                                                <label class="textarea textarea-resizable">
                                                                    <textarea id="justificativaFolhaPonto" name="justificativaFolhaPonto" class="custom-scroll" rows="3" style="resize:vertical "></textarea>
                                                                </label>
                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- COMEÇO DO ACCORDION DE VA-->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseValeAlimentacao" class="collapsed" id="accordionValeAlimentacao">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dias Trabalhados - VA e VR
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseValeAlimentacao" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">

                                                    <input id="jsonValeAlimentacao" name="jsonValeAlimentacao" type="hidden" value="[]">
                                                    <fieldset id="formValeAlimentacao">

                                                        <div class="row">
                                                            <input id="valeAlimentacaoId" name="valeAlimentacaoId" type="hidden" value="">
                                                            <input id="sequencialValeAlimentacao" name="sequencialValeAlimentacao" type="hidden" value="">
                                                            <input id="descricaoFaltasAusenciasValeAlimentacao" name="descricaoFaltasAusenciasValeAlimentacao" type="hidden" value="">
                                                            <input id="descricaoDataFaltaAusenciaValeAlimentacao" name="descricaoDataFaltaAusenciaValeAlimentacao" type="hidden" value="">
                                                            <input id="dataFaltaAusenciaValeAlimentacao" name="dataFaltaAusenciaValeAlimentacao" type="hidden" value="">

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="faltaAusenciaValeAlimentacao">Falta / Ausência</label>
                                                                <label class="select">
                                                                    <select id="faltaAusenciaValeAlimentacao" name="faltaAusenciaValeAlimentacao">
                                                                        <option></option>
                                                                        <option value='F'>Falta</option>
                                                                        <option value='A'>Ausência</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataFaltaAusenciaValeAlimentacaoInicio">Data inicio</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input id="dataFaltaAusenciaValeAlimentacaoInicio" style="text-align: center;" name="dataFaltaAusenciaValeAlimentacaoInicio" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="dataFaltaAusenciaValeAlimentacaoFim">Data fim</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input id="dataFaltaAusenciaValeAlimentacaoFim" style="text-align: center;" name="dataFaltaAusenciaValeAlimentacaoFim" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="diasDeVAVR">Dias</label>
                                                                <label class="input">
                                                                    <i class=""></i>
                                                                    <input id="diasDeVAVR" name="diasDeVAVR" autocomplete="" type="text" class="readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">&nbsp;</label>
                                                                <label id="labelIndeterminado" class="checkbox">
                                                                    <input id="copiarVT" name="copiarVT" type="checkbox"><i></i>
                                                                    Copiar para VT
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label" for="justificativaValeAlimentacao">Justificativa</label>
                                                                <label class="textarea textarea-resizable">
                                                                    <textarea id="justificativaValeAlimentacao" name="justificativaValeAlimentacao" class="custom-scroll" rows="3" style="resize:vertical "></textarea>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <button id="btnAddValeAlimentacao" type="button" class="btn btn-primary" title="Adicionar Falta/Ausência">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverValeAlimentacao" type="button" class="btn btn-danger" title="Remover Falta/Ausência">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                                <button id="btnMarcarDesmarcarTodosValeAlimentacao" type="button" class="btn btn-success" title="Marca/Desmarca Todos">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </section>
                                                        </div>

                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableValeAlimentacao" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left" style="min-width: 10px;">Falta/Ausência</th>
                                                                        <th class="text-center" style="min-width: 10px;">Data</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Total</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-2">
                                                                <label class="label" for="totalFaltasValeAlimentacao">Faltas</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="totalFaltasValeAlimentacao" name="totalFaltasValeAlimentacao" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="totalAusenciasValeAlimentacao">Ausências</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="totalAusenciasValeAlimentacao" name="totalAusenciasValeAlimentacao" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="diasProjetoValeAlimentacao">Dias Projeto</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="diasProjetoValeAlimentacao" name="diasProjetoValeAlimentacao" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="totalDiasTrabalhadosValeAlimentacao">Dias Trabalhados</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="totalDiasTrabalhadosValeAlimentacao" name="totalDiasTrabalhadosValeAlimentacao" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- COMEÇO DO ACCORDION DE VT-->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseValeTransporte" class="collapsed" id="accordionValeTransporte">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dias Trabalhados - Vale Transporte
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseValeTransporte" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <input id="jsonValeTransporte" name="jsonValeTransporte" type="hidden" value="[]">
                                                    <fieldset id="formValeTransporte">
                                                        <div class="row">
                                                            <input id="valeTransporteId" name="valeTransporteId" type="hidden" value="">
                                                            <input id="sequencialValeTransporte" name="sequencialValeTransporte" type="hidden" value="">
                                                            <input id="descricaoFaltasAusenciasValeTransporte" name="descricaoFaltasAusenciasValeTransporte" type="hidden" value="">
                                                            <input id="descricaoDataFaltaAusenciaValeTransporte" name="descricaoDataFaltaAusenciaValeTransporte" type="hidden" value="">
                                                            <input id="dataFaltaAusenciaValeTransporte" name="dataFaltaAusenciaValeTransporte" type="hidden" value="">

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="faltaAusenciaValeTransporte">Falta / Ausência</label>
                                                                <label class="select">
                                                                    <select id="faltaAusenciaValeTransporte" name="faltaAusenciaValeTransporte">
                                                                        <option></option>
                                                                        <option value='F'>Falta</option>
                                                                        <option value='A'>Ausência</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataFaltaAusenciaValeTransporteInicio">Data inicio</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="dataFaltaAusenciaValeTransporteInicio" style="text-align: center;" name="dataFaltaAusenciaValeTransporteInicio" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="dataFaltaAusenciaValeTransporteFim">Data fim</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="dataFaltaAusenciaValeTransporteFim" style="text-align: center;" name="dataFaltaAusenciaValeTransporteFim" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="diasDeVT">Dias</label>
                                                                <label class="input">
                                                                    <i class=""></i>
                                                                    <input id="diasDeVT" name="diasDeVT" autocomplete="" type="text" class="readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label" for="justificativaValeTransporte">Justificativa</label>
                                                                <label class="textarea textarea-resizable">
                                                                    <textarea id="justificativaValeTransporte" name="justificativaValeTransporte" class="custom-scroll" rows="3" style="resize:vertical "></textarea>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <button id="btnAddValeTransporte" type="button" class="btn btn-primary" title="Adicionar Falta/Ausência">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverValeTransporte" type="button" class="btn btn-danger" title="Remover Falta/Ausência">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                                <button id="btnMarcarDesmarcarTodosValeTransporte" type="button" class="btn btn-success" title="Marca/Desmarca Todos">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableValeTransporte" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left" style="min-width: 10px;">Falta/Ausência</th>
                                                                        <th class="text-center" style="min-width: 10px;">Data</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Total</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-2">
                                                                <label class="label" for="faltasValeTransporte">Faltas</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="faltasValeTransporte" name="faltasValeTransporte" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="ausenciasValeTransporte">Ausências</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="ausenciasValeTransporte" name="ausenciasValeTransporte" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="diasProjetoValeTransporte">Dias Projeto</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="diasProjetoValeTransporte" name="diasProjetoValeTransporte" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="totalDiasTrabalhadosValeTransporte">Dias Trabalhados</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="totalDiasTrabalhadosValeTransporte" name="totalDiasTrabalhadosValeTransporte" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                        </div>


                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIM DO ACCORDION DE VT -->

                                        <!-- COMEÇO DO ACCORDION DE HORA EXTRA -->
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
                                                <input type="hidden" id="jsonHoraExtra" name="jsonHoraExtra" value="[]" />

                                                <div class="panel-body no-padding">
                                                    <fieldset id="formHoraExtra">
                                                        <input type="hidden" id="verificador" name="verificador" value="1" />
                                                        <input type="hidden" id="sequencialHoraExtra" name="sequencialHoraExtra" value="" />
                                                        <input type="hidden" id="horaExtraId" name="horaExtraId" value="" />
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="dataHoraExtra">Data Inicio</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" autocomplete="off" id="dataHoraExtra" style="text-align: center;" name="dataHoraExtra" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Hora Inicio</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="horaInicioHoraExtra" name="horaInicioHoraExtra" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="" style="background-color: #ffffc0">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="diaSemanaInicio">Dia da Semana</label>
                                                                <label class="input">
                                                                    <input type="text" id="diaSemanaInicio" name="diaSemanaInicio" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="feriado">Feriado</label>
                                                                <label class="select" style="text-align: center;">
                                                                    <select id="feriado" name="feriado" style="text-align: center;" class="readonly" readonly>
                                                                        <option value="0">Não</option>
                                                                        <option value='1'>Sim</option>
                                                                    </select>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="dataHoraExtraFim">Data Fim</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="dataHoraExtraFim" style="text-align: center;" name="dataHoraExtraFim" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required new-password" autocomplete="off" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Hora Fim</label>
                                                                    <div class="input-group " data-placement="left" data-align="top" data-autoclose="true">
                                                                        <input id="horaFimHoraExtra" name="horaFimHoraExtra" autocomplete="off" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="" style="background-color: #ffffc0">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="diaSemanaFim">Dia da Semana</label>
                                                                <label class="input">
                                                                    <input type="text" id="diaSemanaFim" name="diaSemanaFim" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="feriado">Feriado</label>
                                                                <label class="select" style="text-align: center;">
                                                                    <select id="feriadoDataFim" name="feriadoDataFim" style="text-align: center;" class="readonly" readonly>
                                                                        <option value="0">Não</option>
                                                                        <option value='1'>Sim</option>
                                                                    </select>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="horaTotalExtra">Hora Extra Total</label>
                                                                <label class="input"><i class="icon-append fa fa-clock-o"></i>
                                                                    <input type="text" id="horaTotalExtra" name="horaTotalExtra" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="horaTotalExtra">Hora Extra Noturna</label>
                                                                <label class="input"><i class="icon-append fa fa-clock-o"></i>
                                                                    <input type="text" id="horaExtraNoturna" name="horaExtraNoturna" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="horaTotalExtra">Hora Extra Diurna</label>
                                                                <label class="input"><i class="icon-append fa fa-clock-o"></i>
                                                                    <input type="text" id="horaExtraDiurna" name="horaExtraDiurna" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="calculaHoraExtra">&nbsp;</label>
                                                                <button id="calculaHoraExtra" type="button" class="btn btn-success" title="calculaHoraExtra">
                                                                    Calcular
                                                                </button>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Justificativa</label>
                                                                <textarea id="justificativaHoraExtra" name="justificativaHoraExtra" maxlength="255" class="form-control" placeholder=" Digite uma justificativa..." rows="1" style="resize:vertical; height: 70px;"></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <button id="btnAddHoraExtra" type="button" class="btn btn-primary" title="Adicionar Endereço">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverHoraExtra" type="button" class="btn btn-danger" title="Remover Endereço">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableHoraExtra" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left">Data Inicio</th>
                                                                        <th class="text-left">Data Fim</th>
                                                                        <th class="text-left">Hora Inicio</th>
                                                                        <th class="text-left">Hora Fim</th>
                                                                        <th class="text-left">Hora Extra Total</th>
                                                                        <th class="text-left">Hora Extra Noturna</th>
                                                                        <th class="text-left">Hora Extra Diurna</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIM DO ACCORDION DE hORA eXTRA -->


                                        <!-- COMEÇO DO ACCORDION DE HORA ATRASO -->
                                        <!-- <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseHoraAtraso" class="collapsed" id="accordionHoraAtraso">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Hora Atraso
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseHoraAtraso" class="panel-collapse collapse">
                                                <input type="hidden" id="jsonHoraAtraso" name="jsonHoraAtraso" value="[]" />

                                                <div class="panel-body no-padding">
                                                    <fieldset id="formHoraAtraso">
                                                        <input type="hidden" id="verificador" name="verificador" value="1" />
                                                        <input type="hidden" id="sequencialHoraAtraso" name="sequencialHoraAtraso" value="" />
                                                        <input type="hidden" id="horaAtrasoId" name="horaAtrasoId" value="" />
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="dataHoraAtraso">Data Inicio</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" autocomplete="off" id="dataHoraAtraso" style="text-align: center;" name="dataHoraAtraso" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Hora Inicio</label>
                                                                    <div class="input-group" data-align="top" data-autoclose="true">
                                                                        <input id="horaInicioHoraAtraso" name="horaInicioHoraAtraso" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="" style="background-color: #ffffc0">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="diaSemanaInicioAtraso">Dia da Semana</label>
                                                                <label class="input">
                                                                    <input type="text" id="diaSemanaInicioAtraso" name="diaSemanaInicioAtraso" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="feriadoAtraso">Feriado</label>
                                                                <label class="select" style="text-align: center;">
                                                                    <select id="feriadoAtraso" name="feriado" style="text-align: center;" class="readonly" readonly>
                                                                        <option value="0">Não</option>
                                                                        <option value='1'>Sim</option>
                                                                    </select>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="dataHoraAtrasoFim">Data Fim</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="dataHoraAtrasoFim" style="text-align: center;" name="dataHoraAtrasoFim" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required new-password" autocomplete="off" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <div class="form-group">
                                                                    <label id="labelHora" class="label">Hora Fim</label>
                                                                    <div class="input-group " data-placement="left" data-align="top" data-autoclose="true">
                                                                        <input id="horaFimHoraAtraso" name="horaFimHoraAtraso" autocomplete="off" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="" style="background-color: #ffffc0">
                                                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="diaSemanaFimAtraso">Dia da Semana</label>
                                                                <label class="input">
                                                                    <input type="text" id="diaSemanaFimAtraso" name="diaSemanaFimAtraso" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="feriadoAtraso">Feriado</label>
                                                                <label class="select" style="text-align: center;">
                                                                    <select id="feriadoDataFimAtraso" name="feriadoDataFimAtraso" style="text-align: center;" class="readonly" readonly>
                                                                        <option value="0">Não</option>
                                                                        <option value='1'>Sim</option>
                                                                    </select>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="horaTotalAtraso">Hora Atraso Total</label>
                                                                <label class="input"><i class="icon-append fa fa-clock-o"></i>
                                                                    <input type="text" id="horaTotalAtraso" name="horaTotalAtraso" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="horaTotalAtraso">Hora Atraso Noturna</label>
                                                                <label class="input"><i class="icon-append fa fa-clock-o"></i>
                                                                    <input type="text" id="horaAtrasoNoturna" name="horaAtrasoNoturna" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="horaTotalAtraso">Hora Atraso Diurna</label>
                                                                <label class="input"><i class="icon-append fa fa-clock-o"></i>
                                                                    <input type="text" id="horaAtrasoDiurna" name="horaAtrasoDiurna" style="text-align: center;" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="calculaHoraAtraso">&nbsp;</label>
                                                                <button id="calculaHoraAtraso" type="button" class="btn btn-success" title="calculaHoraAtraso">
                                                                    Calcular
                                                                </button>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Justificativa</label>
                                                                <textarea id="justificativaHoraAtraso" name="justificativaHoraAtraso" maxlength="255" class="form-control" placeholder=" Digite uma justificativa..." rows="1" style="resize:vertical; height: 70px;"></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <button id="btnAddHoraAtraso" type="button" class="btn btn-primary" title="Adicionar Endereço">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverHoraAtraso" type="button" class="btn btn-danger" title="Remover Endereço">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableHoraAtraso" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left">Data Inicio</th>
                                                                        <th class="text-left">Data Fim</th>
                                                                        <th class="text-left">Hora Inicio</th>
                                                                        <th class="text-left">Hora Fim</th>
                                                                        <th class="text-left">Hora Extra Total</th>
                                                                        <th class="text-left">Hora Extra Noturna</th>
                                                                        <th class="text-left">Hora Extra Diurna</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- FIM DO ACCORDION DE hORA eXTRA -->


                                        <!-- COMEÇO DO ACCORDION DE VALORES EXTRA-->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseValorExtra" class="collapsed" id="accordionValorExtra">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Valor Extra
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseValorExtra" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset id="formValorExtra">
                                                        <input id="jsonValorExtra" name="jsonValorExtra" type="hidden" value="[]">

                                                        <div class="row">
                                                            <input id="valorExtraId" name="valorExtraId" type="hidden" value="">
                                                            <input id="sequencialValorExtra" name="sequencialValorExtra" type="hidden" value="">
                                                            <input id="descricaoExtra" name="descricaoExtra" type="hidden" value="">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="beneficioExtra">Extra</label>
                                                                <label class="select">
                                                                    <select id="beneficioExtra" name="beneficioExtra" class="required">
                                                                        <option> </option>
                                                                        <option value='1'>VA/VR Extra</option>
                                                                        <option value='2'>VT Extra</option>
                                                                        <option value='3'>Cesta Básica</option>
                                                                        <option value='4'>Bolsa Benefício</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="valorExtra">Valor</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input id="valorExtra" name="valorExtra" autocomplete="off" class="decimal-2-casas required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-8">
                                                                <label class="label">Justificativa</label>
                                                                <textarea id="justificativaValorExtra" name="justificativaValorExtra" class="form-control" rows="1" style="resize:vertical; height: 30px;"></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="totalAusenciasValorExtra">Ausências</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="totalAusenciasValorExtra" name="totalAusenciasValorExtra" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="diasProjetoValeRefeicao">Dias Projeto</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar-check-o"></i>
                                                                    <input type="text" id="diasProjetoValorExtra" name="diasProjetoValorExtra" readonly class="readonly" />
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">

                                                                <button id="btnAddValorExtra" type="button" class="btn btn-primary" title="Adicionar Endereço">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverValorExtra" type="button" class="btn btn-danger" title="Remover Endereço">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>
                                                        </div>

                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableValorExtra" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th></th>
                                                                        <th class="text-left" style="min-width: 10px;">Extra</th>
                                                                        <th class="text-left" style="min-width: 10px;">Valor</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIM DO ACCORDION DE VALORES ATRASO -->

                                        <!-- COMEÇO DO ACCORDION DE FERIAS -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFerias" class="collapsed" id="accordionFerias">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Férias
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFerias" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset id="formFerias">
                                                        <input id="jsonFerias" name="jsonFerias" type="hidden" value="[]">
                                                        <div class="row">
                                                            <input id="sequencialFerias" name="sequencialFerias" type="hidden" value="">

                                                            <section class="col col-3">
                                                                <label class="label" for="feriasTotalDia">Dias corridos</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="feriasTotalDia" name="feriasTotalDia" autocomplete="off" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="feriasDiaUtil">Dias úteis</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="feriasDiaUtil" name="feriasDiaUtil" autocomplete="off" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <!-- <section class="col col-3"> -->
                                                            <!-- <label class="label" for="feriasDataInicial" >Início das férias</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i> -->
                                                            <input id="feriasDataInicial" name="feriasDataInicial" class="readonly" type="hidden" readonly>
                                                            <!-- </label> -->
                                                            <!-- </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="feriasDataFinal">Fim das férias</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i> -->
                                                            <input id="feriasDataFinal" name="feriasDataFinal" class="readonly" type="hidden" readonly>
                                                            <!-- </label>
                                                            </section> -->
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableFerias" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th class="text-center" style="min-width: 10px;">Início Férias</th>
                                                                        <th class="text-center" style="min-width: 10px;">Fim Férias</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIM DO ACCORDION DE FERIAS -->



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
                                        <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
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

<script src="<?php echo ASSETS_URL; ?>/js/business_beneficioFolhaPonto.js" type="text/javascript"></script>

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

<script src="js/plugin/clockpicker/clockpicker.min.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        $("input").attr('autocomplete', 'nope');
        //Jsons da página
        jsonValeAlimentacaoArray = JSON.parse($("#jsonValeAlimentacao").val());
        jsonValeTransporteArray = JSON.parse($("#jsonValeTransporte").val());
        jsonValorExtraArray = JSON.parse($("#jsonValorExtra").val());
        jsonFeriasArray = JSON.parse($("#jsonFerias").val());
        jsonHoraExtraArray = JSON.parse($("#jsonHoraExtra").val());

        $('#tempoAtrasoMes').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaExtra50Noturno').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaExtra50Diurno').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaExtra100Diurno').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaExtra100Noturno').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#adicionalNoturno').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horasSobreaviso').mask('99:99', {
            placeholder: "hh:mm"
        });

        $("#horaInicioHoraExtra").mask("99:99");
        $("#horaFimHoraExtra").mask("99:99");
        $("#feriado").prop('disabled', true);


        carregaPagina();
        // $("#funcionario").prop("disabled", true)
        // $("#funcionario").addClass("readonly")


        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
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
            var id = +$("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#projeto").on("change", function() {
            recuperaDiasUteis()
            recuperaDiasUteisProjeto()
            popularComboFuncionario()
            $("#tipoDiaUtil").val('')
            $("#diaUtilNoMesVAVR").val(0)
            $("#diaUtilNoMesVT").val(0)
        });
        $("#funcionario").on("change", function() {
            recuperaDiasUteis()
            verificaPeriodoAdicionalNoturno()
            limpaCamposHoraExtra()
        });

        $("#mesAnoFolhaPonto").on("change", function() {
            recuperaDiasUteisProjeto();
        });

        $("#dataFaltaAusenciaValeAlimentacaoInicio").on("change", function() {
            $("#dataFaltaAusenciaValeAlimentacaoFim").val($("#dataFaltaAusenciaValeAlimentacaoInicio").val());
        });

        $("#dataFaltaAusenciaValeAlimentacaoFim").on("change", function() {
            let dataInico = FormataStringData($("#dataFaltaAusenciaValeAlimentacaoInicio").val());
            let dataFim = FormataStringData($("#dataFaltaAusenciaValeAlimentacaoFim").val());
            let comparacao = dates.compare(dataInico, dataFim);
            if (comparacao == "1") {
                smartAlert("error", "Data fim menor que a data inicio", "error");
                $("#dataFaltaAusenciaValeAlimentacaoFim").val($("#dataFaltaAusenciaValeAlimentacaoInicio").val());
                return;
            }

        });

        $("#dataFaltaAusenciaValeTransporteInicio").on("change", function() {
            $("#dataFaltaAusenciaValeTransporteFim").val($("#dataFaltaAusenciaValeTransporteInicio").val());
        });

        $("#dataFaltaAusenciaValeTransporteFim").on("change", function() {
            let dataInico = FormataStringData($("#dataFaltaAusenciaValeTransporteInicio").val());
            let dataFim = FormataStringData($("#dataFaltaAusenciaValeTransporteFim").val());
            let comparacao = dates.compare(dataInico, dataFim);
            if (comparacao == "1") {
                smartAlert("error", "Data fim menor que a data inicio", "error");
                $("#dataFaltaAusenciaValeTransporteFim").val($("#dataFaltaAusenciaValeTransporteInicio").val());
                return;
            }

        });

        // ----------------- BOTÕES DE VALE ALIMENTAÇÃO ----------------
        //Adicionar
        $("#btnAddValeAlimentacao").on("click", function() {
            $("#verificaVale").val(0);
            var datasArray = [];
            let dataInico = FormataStringData($("#dataFaltaAusenciaValeAlimentacaoInicio").val());
            let dataFim = FormataStringData($("#dataFaltaAusenciaValeAlimentacaoFim").val());
            var diasProjetoValeAlimentacao = $("#diasProjetoValeAlimentacao").val()
            if (validaValeAlimentacao()) {
                if (dataInico != dataFim) {
                    datasArray = getDates(dataInico, dataFim);
                    if (datasArray.length > diasProjetoValeAlimentacao) {
                        smartAlert("Erro", "Quantidade de Faltas/Aunsências maiores do que os Dias Uteis de Vale Alimentação", "error");
                        return;
                    }
                    if ($("#copiarVT").is(':checked') === false) {
                        for (iva = 0; iva < datasArray.length; iva++) {
                            $("#dataFaltaAusenciaValeAlimentacao").val(datasArray[iva])
                            addValeAlimentacao();
                        }
                    } else {
                        if (validaValeTransporte(1)) {
                            $("#faltaAusenciaValeTransporte").val($("#faltaAusenciaValeAlimentacao").val());
                            $("#dataFaltaAusenciaValeTransporteInicio").val($("#dataFaltaAusenciaValeAlimentacaoInicio").val());
                            $("#dataFaltaAusenciaValeTransporteFim").val($("#dataFaltaAusenciaValeTransporteFim").val());
                            for (iva = 0; iva < datasArray.length; iva++) {
                                $("#dataFaltaAusenciaValeAlimentacao").val(datasArray[iva])
                                $("#dataFaltaAusenciaValeTransporte").val(datasArray[iva])
                                $("#verificaVale").val(0);

                                addValeAlimentacao();

                                $("#verificaVale").val(2);

                                addValeTransporte();
                            }
                        }
                    }
                } else {
                    if ($("#copiarVT").is(':checked') === false) {
                        $("#dataFaltaAusenciaValeAlimentacao").val(dataInico);

                        addValeAlimentacao();
                    } else {
                        if (validaValeTransporte(1)) {
                            $("#faltaAusenciaValeTransporte").val($("#faltaAusenciaValeAlimentacao").val());
                            $("#dataFaltaAusenciaValeTransporteInicio").val($("#dataFaltaAusenciaValeAlimentacaoInicio").val());
                            $("#dataFaltaAusenciaValeTransporteFim").val($("#dataFaltaAusenciaValeTransporteFim").val());
                            $("#dataFaltaAusenciaValeAlimentacao").val(dataInico)
                            $("#dataFaltaAusenciaValeTransporte").val(dataInico)

                            addValeAlimentacao();

                            $("#verificaVale").val(2);
                            addValeTransporte();
                        }
                    }
                }

                clearFormValeAlimentacao();
                clearFormValeTransporte();
            }
        });

        //Remover
        $("#btnRemoverValeAlimentacao").on("click", function() {
            $("#verificaVale").val(0);
            calcularTotal(2)
            excluirValeAlimentacao();
        });


        // ----------------- BOTÕES DE VALE TRANSPORTE ----------------
        //Adicionar
        $("#btnAddValeTransporte").on("click", function() {
            $("#verificaVale").val(2);
            var datasArray = [];
            let dataInico = FormataStringData($("#dataFaltaAusenciaValeTransporteInicio").val());
            let dataFim = FormataStringData($("#dataFaltaAusenciaValeTransporteFim").val());
            var diasProjetoValeTransporte = $("#diasProjetoValeTransporte").val();
            if (validaValeTransporte()) {
                if (dataInico != dataFim) {
                    datasArray = getDates(dataInico, dataFim);
                    if (datasArray.length > diasProjetoValeTransporte) {
                        smartAlert("Erro", "Quantidade de Faltas/Aunsências maiores do que os Dias Uteis de Vale Transporte", "error");
                        return;
                    }
                    for (ivt = 0; ivt < datasArray.length; ivt++) {
                        $("#dataFaltaAusenciaValeTransporte").val(datasArray[ivt]);
                        addValeTransporte();
                    }
                } else {
                    $("#dataFaltaAusenciaValeTransporte").val(dataInico);
                    addValeTransporte();
                }

                clearFormValeAlimentacao();
                clearFormValeTransporte();
            }
        });

        //Remover
        $("#btnRemoverValeTransporte").on("click", function() {
            $("#verificaVale").val(2);
            calcularTotal(2)
            excluirValeTransporte();
        });
        // ----------------- BOTÕES DE VALOR EXTRA----------------
        //Adicionar
        $("#btnAddValorExtra").on("click", function() {
            if (validaValorExtra()) {
                addValorExtra();
            }
        });

        //Remover
        $("#btnRemoverValorExtra").on("click", function() {
            excluirValorExtra();
        });

        $("#mesAnoFolhaPonto").on("change", function() {
            recuperaDiasUteis()
            recuperaDiasUteisProjeto()

        });
        $("#verificaFerias").on("click", function() {
            verificaFeriasFuncionario()
        });

        $("#dataHoraExtra").on("change", function() {
            $("#horaInicioHoraExtra").val('')
            $("#horaFimHoraExtra").val('')

            dataInicio = $("#dataHoraExtra").val()
            $("#dataHoraExtraFim").val(dataInicio).trigger('change')
            verificaDiaSemana(dataInicio, 0)
            verificaFeriadoData(0)
        });
        $("#dataHoraExtraFim").on("change", function() {
            dataFim = $("#dataHoraExtraFim").val()
            if (verificaDatas() == true) {
                verificaDiaSemana(dataFim, 1)
            }
            verificaFeriadoData(1)

        });
        $("#horaFimHoraExtra").on("change", function() {
            var dataInicio = $("#dataHoraExtra").val()
            var dataFim = $("#dataHoraExtraFim").val()
            var horaInicio = $("#horaInicioHoraExtra").val()
            var horaFim = $("#horaFimHoraExtra").val()
            incrementaData()
            var comparaHoras = comparaHora(horaInicio, horaFim, dataInicio, dataFim)
            if ((dataInicio != dataFim) && comparaHoras == true) {
                verificaHoraIncrementaData()
                if (horaFim > "00:00") {
                    incrementaData()
                }
            }

        });
        $("#calculaHoraExtra").on("click", function() {
            calculaItensHoraExtra()
            var horaExtraTotal = $("#horaTotalExtra").val();
            var horaExtraNoturna = $("#horaExtraNoturna").val();
            //A hora extra diurna é a diferença entre horaExtraTotal e HoraExtraNoturna
            var horaExtraDiurna = subtraiHora(horaExtraTotal, horaExtraNoturna);
            $("#horaExtraDiurna").val(horaExtraDiurna);
        });

        $("#beneficioExtra").on("change", function() {
            populaDiasProjetoValorExtra()
        });
        $("#btnAddHoraExtra").on("click", function() {
            var dataHoraExtra = $('#dataHoraExtra').val();

            if (dataHoraExtra === '') {
                smartAlert("Erro", "Informe a Data Inicial", "error");
                return false;
            }
            addHoraExtra()
        });
        $("#btnRemoverHoraExtra").on("click", function() {
            excluirHoraExtra()
        });

        $('#horaInicioHoraExtra').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true,
        }).val(moment().format('HH:mm'));

        $('#horaFimHoraExtra').clockpicker({
            donetext: 'Done',
            default: 'now',
            use24hours: true
        }).val(moment().format('HH:mm'));


        $("#dataFaltaAusenciaValeAlimentacaoInicio").on("change", function() {
            var dataFaltaAusenciaValeAlimentacaoInicio = $("#dataFaltaAusenciaValeAlimentacaoInicio").val();
            var dataFaltaAusenciaValeAlimentacaoFim = $("#dataFaltaAusenciaValeAlimentacaoFim").val();
            var resultado = diferencaDatas(dataFaltaAusenciaValeAlimentacaoInicio, dataFaltaAusenciaValeAlimentacaoFim);
            $("#diasDeVAVR").val(resultado + 1);
        });
        $("#dataFaltaAusenciaValeAlimentacaoFim").on("change", function() {
            var dataFaltaAusenciaValeAlimentacaoInicio = $("#dataFaltaAusenciaValeAlimentacaoInicio").val();
            var dataFaltaAusenciaValeAlimentacaoFim = $("#dataFaltaAusenciaValeAlimentacaoFim").val();
            var resultado = diferencaDatas(dataFaltaAusenciaValeAlimentacaoInicio, dataFaltaAusenciaValeAlimentacaoFim);
            $("#diasDeVAVR").val(resultado + 1);
        });

        $("#dataFaltaAusenciaValeTransporteInicio").on("change", function() {
            var dataFaltaAusenciaValeTransporteInicio = $("#dataFaltaAusenciaValeTransporteInicio").val();
            var dataFaltaAusenciaValeTransporteFim = $("#dataFaltaAusenciaValeTransporteFim").val();
            var resultado = diferencaDatas(dataFaltaAusenciaValeTransporteInicio, dataFaltaAusenciaValeTransporteFim);
            $("#diasDeVT").val(resultado + 1);
        });
        $("#dataFaltaAusenciaValeTransporteFim").on("change", function() {
            var dataFaltaAusenciaValeTransporteInicio = $("#dataFaltaAusenciaValeTransporteInicio").val();
            var dataFaltaAusenciaValeTransporteFim = $("#dataFaltaAusenciaValeTransporteFim").val();
            var resultado = diferencaDatas(dataFaltaAusenciaValeTransporteInicio, dataFaltaAusenciaValeTransporteFim);
            $("#diasDeVT").val(resultado + 1);
        });

        $("#btnMarcarDesmarcarTodosValeTransporte").on("click", function() {
            marcarDesmarcarTodos('tableValeTransporte');
        });
        $("#btnMarcarDesmarcarTodosValeAlimentacao").on("click", function() {
            marcarDesmarcarTodos('tableValeAlimentacao');
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
                recuperaFolhaPonto(idd,
                    function(data) {

                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        var out = piece[1];
                        var $strArrayValeAlimentacao = piece[2];
                        var strArrayValeTransporte = piece[3];
                        var strArrayValorExtra = piece[4];
                        var strArrayHoraExtra = piece[5];

                        piece = out.split("^");
                        // Atributos de vale transporte unitário que serão recuperados: 
                        var codigo = +piece[0];
                        var projeto = +piece[1];
                        var funcionario = +piece[2];
                        var mesAnoFolhaPonto = piece[3];
                        var justificativaFolhaPonto = piece[4];

                        //Accordion Dias Úteis -> Vale Alimentação
                        var totalFaltasValeAlimentacao = +piece[5];
                        var totalAusenciasValeAlimentacao = +piece[6];
                        var diasProjetoValeAlimentacao = +piece[7];
                        var totalDiasTrabalhadosValeAlimentacao = +piece[8];

                        //Accordion Dias Úteis -> Vale Refeição 
                        var totalFaltasValeRefeicao = +piece[9];
                        var totalAusenciasValeRefeicao = +piece[10];
                        var diasProjetoValeRefeicao = +piece[11];
                        var totalDiasTrabalhadosValeRefeicao = +piece[12];
                        var totalDiasTrabalhadosVT = +piece[13];
                        //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                        $("#codigo").val(codigo);
                        $("#projeto").val(projeto);
                        $("#funcionario").val(funcionario);

                        $("#funcionarioCodigo").val(funcionario);
                        $("#mesAnoFolhaPonto").val(mesAnoFolhaPonto);
                        $("#justificativaFolhaPonto").val(justificativaFolhaPonto);

                        //Accordion Dias Úteis -> Vale Alimentação
                        $("#totalFaltasValeAlimentacao").val(totalFaltasValeAlimentacao);
                        $("#totalAusenciasValeAlimentacao").val(totalAusenciasValeAlimentacao);
                        $("#diasProjetoValeAlimentacao").val(diasProjetoValeAlimentacao);
                        $("#totalDiasTrabalhadosValeAlimentacao").val(totalDiasTrabalhadosValeAlimentacao);

                        //Accordion Dias Úteis -> Vale Refeição
                        $("#totalFaltasValeRefeicao").val(totalFaltasValeRefeicao);
                        $("#totalAusenciasValeRefeicao").val(totalAusenciasValeRefeicao);
                        $("#diasProjetoValeRefeicao").val(diasProjetoValeRefeicao);
                        $("#totalDiasTrabalhadosValeRefeicao").val(totalDiasTrabalhadosValeRefeicao);

                        $("#totalDiasTrabalhadosValeTransporte").val(totalDiasTrabalhadosVT);

                        //Arrays
                        $("#jsonValeAlimentacao").val($strArrayValeAlimentacao);
                        $("#jsonValeTransporte").val(strArrayValeTransporte);
                        $("#jsonValorExtra").val(strArrayValorExtra);
                        $("#jsonHoraExtra").val(strArrayHoraExtra);

                        jsonValeAlimentacaoArray = JSON.parse($("#jsonValeAlimentacao").val());
                        jsonValeTransporteArray = JSON.parse($("#jsonValeTransporte").val());
                        jsonValorExtraArray = JSON.parse($("#jsonValorExtra").val());
                        jsonHoraExtraArray = JSON.parse($("#jsonHoraExtra").val());
                        recuperaDiasUteisProjeto();
                        fillTableValeAlimentacao();
                        fillTableValeTransporte();
                        fillTableValorExtra();
                        fillTableHoraExtra();
                        verificaFeriasFuncionario()
                        initializeDecimalBehaviour();
                        recuperaDiasUteis()

                        $("#verificaRecuperacao").val(1);

                        fillTableFerias()
                        calcularTotal(1);
                        verificaPeriodoAdicionalNoturno()
                        // popularComboFuncionario()




                        return;

                    })
            }

        }
    }

    function novo() {
        $(location).attr('href', 'beneficio_folhaPontoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'beneficio_folhaPontoFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFolhaPonto(id,
            function(data) {
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
            }
        );
    }


    /* Calcula o total de faltas e ausências baseado em uma consulta dos dias úteis de Projeto Benefício.
     *  Soma-se a diferença em referência aos dias totais. 
     */
    function calcularTotal(verificador) {
        var diaUtilValeAlimentacao = +$("#diasProjetoValeAlimentacao").val();
        var diaUtilValeTransporte = +$("#diasProjetoValeTransporte").val();

        var totalFaltasValeAlimentacao = +$("#totalFaltasValeAlimentacao").val();
        var faltasValeTransporte = +$("#faltasValeTransporte").val();

        var totalAusenciasValeAlimentacao = +$("#totalAusenciasValeAlimentacao").val();
        var ausenciasValeTransporte = +$("#ausenciasValeTransporte").val();
        var totalDiasTrabalhadosValeAlimentacao = +$("#totalDiasTrabalhadosValeAlimentacao").val()
        var totalDiasTrabalhadosValeTransporte = +$("#totalDiasTrabalhadosValeTransporte").val()

        var verificaVale = +$("#verificaVale").val();

        var diferencaValoresValeAlimentacao = totalFaltasValeAlimentacao + totalAusenciasValeAlimentacao;
        var diferencaValoresValeTransporte = faltasValeTransporte + ausenciasValeTransporte;

        switch (verificador) {
            case 1:
                if (verificaVale == 0) {
                    $("#totalDiasTrabalhadosValeAlimentacao").val(diaUtilValeAlimentacao - diferencaValoresValeAlimentacao);
                } else if (verificaVale == 1) {
                    $("#totalDiasTrabalhadosValeRefeicao").val(diaUtilValeRefeicao - diferencaValoresValeRefeicao);
                } else if (verificaVale == 2) {
                    $("#totalDiasTrabalhadosValeTransporte").val(diaUtilValeTransporte - diferencaValoresValeTransporte);
                }
                break;
            case 2:
                if (verificaVale == 0) {
                    if (jsonValeAlimentacaoArray.filter((item) => item.faltaAusenciaValeAlimentacao === "F")) {
                        $("#totalDiasTrabalhadosValeAlimentacao").val(totalDiasTrabalhadosValeAlimentacao + totalFaltasValeAlimentacao);
                    }
                    if (jsonValeAlimentacaoArray.filter((item) => item.faltaAusenciaValeAlimentacao === "A")) {
                        $("#totalDiasTrabalhadosValeAlimentacao").val(totalDiasTrabalhadosValeAlimentacao + totalAusenciasValeAlimentacao);
                    }
                } else if (verificaVale == 2) {
                    if (jsonValeTransporteArray.filter((item) => item.faltaAusenciaValeTransporte === "F")) {
                        $("#totalDiasTrabalhadosValeTransporte").val(totalDiasTrabalhadosValeTransporte + faltasValeTransporte);
                    }
                    if (jsonValeTransporteArray.filter((item) => item.faltaAusenciaValeTransporte === "A")) {
                        $("#totalDiasTrabalhadosValeTransporte").val(totalDiasTrabalhadosValeTransporte + ausenciasValeTransporte);
                    }
                }
                break;
            default:
                break;
        }




    }



    // ---------------------------------------------------------  Dias Trabalhados - Vale Alimentação -----------------------------------------------------------

    function validaValeAlimentacao() {
        var achouData = false;
        var dataFaltaAusenciaValeAlimentacao = $('#dataFaltaAusenciaValeAlimentacao').val();
        var faltaAusenciaValeAlimentacao = $('#faltaAusenciaValeAlimentacao').val();
        var dataFaltaAusenciaValeAlimentacaoInicio = $('#dataFaltaAusenciaValeAlimentacaoInicio').val();
        var dataFaltaAusenciaValeAlimentacaoFim = $('#dataFaltaAusenciaValeAlimentacaoFim').val();
        var sequencial = +$('#sequencialValeAlimentacao').val();

        if (faltaAusenciaValeAlimentacao === '') {
            smartAlert("Erro", "Informe se há alguma Falta/Ausência", "error");
            return false;
        }

        if (dataFaltaAusenciaValeAlimentacaoInicio === '') {
            smartAlert("Erro", "Informe a Data inicio", "error");
            return false;
        }
        if (dataFaltaAusenciaValeAlimentacaoFim === '') {
            smartAlert("Erro", "Informe a Data fim", "error");
            return false;
        }
        for (i = jsonValeAlimentacaoArray.length - 1; i >= 0; i--) {
            if ((jsonValeAlimentacaoArray[i].descricaoDataFaltaAusenciaValeAlimentacao === dataFaltaAusenciaValeAlimentacaoInicio) ||
                (jsonValeAlimentacaoArray[i].descricaoDataFaltaAusenciaValeAlimentacao === dataFaltaAusenciaValeAlimentacaoFim)) {
                achouData = true;
                break;
            }
        }
        if (achouData === true) {
            smartAlert("Erro", "Já existe esta data em falta/ausência no VA e VR ,no periodo: (" + dataFaltaAusenciaValeAlimentacaoInicio + "  " + dataFaltaAusenciaValeAlimentacaoFim + ")", "error");
            return false;
        }

        return true;
    }

    function processDataValeAlimentacao(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoFaltasAusenciasValeAlimentacao")) {
            var faltasAusencias = $("#faltaAusenciaValeAlimentacao").val();
            if (faltasAusencias === 'F') {
                return {
                    name: fieldName,
                    value: 'Falta'
                };
            } else if (faltasAusencias === 'A') {
                return {
                    name: fieldName,
                    value: 'Ausência'
                };
            }
        }
        if (fieldName !== '' && (fieldId === "dataFaltaAusenciaValeAlimentacaoInicio")) {
            var dataCertaInicio = $("#dataFaltaAusenciaValeAlimentacaoInicio").val();
            dataCertaInicio = dataCertaInicio.split('/');
            dataCertaInicio = dataCertaInicio[2] + '-' + dataCertaInicio[1] + '-' + dataCertaInicio[0];
            return {
                name: fieldName,
                value: dataCertaInicio
            }
        }
        if (fieldName !== '' && (fieldId === "dataFaltaAusenciaValeAlimentacaoFim")) {
            var dataCertaFim = $("#dataFaltaAusenciaValeAlimentacaoFim").val();
            dataCertaFim = dataCertaFim.split('/');
            dataCertaFim = dataCertaFim[2] + '-' + dataCertaFim[1] + '-' + dataCertaFim[0];
            return {
                name: fieldName,
                value: dataCertaFim
            }
        }
        if (fieldName !== '' && (fieldId === "descricaoDataFaltaAusenciaValeAlimentacao")) {
            var dataFaltaAusencia = $("#dataFaltaAusenciaValeAlimentacao").val();
            dataFaltaAusencia = dataFaltaAusencia.split("-");
            dataFaltaAusencia = dataFaltaAusencia[2] + "/" + dataFaltaAusencia[1] + "/" + dataFaltaAusencia[0];
            return {
                name: fieldName,
                value: dataFaltaAusencia
            };
        }

        return false;
    }

    function addValeAlimentacao() {
        var totalFaltasValeAlimentacao = +$("#totalFaltasValeAlimentacao").val();
        var totalAusenciasValeAlimentacao = +$("#totalAusenciasValeAlimentacao").val();
        var diasProjetoValeAlimentacao = +$("#diasProjetoValeAlimentacao").val();
        var totalFaltasAusenciasValeAlimentacao = totalFaltasValeAlimentacao + totalAusenciasValeAlimentacao;

        if (totalFaltasAusenciasValeAlimentacao > diasProjetoValeAlimentacao) {
            smartAlert("Erro", "A lista não pode ser maior que a quantidade de dias do projeto.", "error");
            clearFormValeAlimentacao();
            return false;
        }

        if (($("#projeto").val() === "") && ($("#mesAnoFolhaPonto").val() === "")) {
            smartAlert("Erro", "Escolha o Projeto e Mês/Ano da Folha de Ponto primeiro!", "error");
            return false;
        }



        var item = $("#formValeAlimentacao").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataValeAlimentacao
        });

        if (item["sequencialValeAlimentacao"] === '') {
            if (jsonValeAlimentacaoArray.length === 0) {
                item["sequencialValeAlimentacao"] = 1;
            } else {
                item["sequencialValeAlimentacao"] = Math.max.apply(Math, jsonValeAlimentacaoArray.map(function(o) {
                    return o.sequencialValeAlimentacao;
                })) + 1;
            }
            item["valeAlimentacaoId"] = 0;
        } else {
            item["sequencialValeAlimentacao"] = +item["sequencialValeAlimentacao"];
        }

        var index = -1;
        $.each(jsonValeAlimentacaoArray, function(i, obj) {
            if (+$('#sequencialValeAlimentacao').val() === obj.sequencialValeAlimentacao) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonValeAlimentacaoArray.splice(index, 1, item);
        else
            jsonValeAlimentacaoArray.push(item);
        $("#jsonValeAlimentacao").val(JSON.stringify(jsonValeAlimentacaoArray));
        fillTableValeAlimentacao();

        calcularTotal(1);
    }

    function fillTableValeAlimentacao() {
        $("#tableValeAlimentacao tbody").empty();
        for (var i = 0; i < jsonValeAlimentacaoArray.length; i++) {
            var row = $('<tr />');

            $("#tableValeAlimentacao tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonValeAlimentacaoArray[i].sequencialValeAlimentacao + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaValeAlimentacao(' + jsonValeAlimentacaoArray[i].sequencialValeAlimentacao + ');">' + jsonValeAlimentacaoArray[i].descricaoFaltasAusenciasValeAlimentacao + '</td>'));
            row.append($('<td class="text-center">' + jsonValeAlimentacaoArray[i].descricaoDataFaltaAusenciaValeAlimentacao + '</td>'));

        }

        //Calcula a quantidade de faltas e ausências baseadas no array JSON e popula elas no HTML.
        var totalFaltas = jsonValeAlimentacaoArray.filter((item) => item.faltaAusenciaValeAlimentacao === "F").length; +
        $("#totalFaltasValeAlimentacao").val(totalFaltas);
        var totalAusencias = jsonValeAlimentacaoArray.filter((item) => item.faltaAusenciaValeAlimentacao === "A").length; +
        $("#totalAusenciasValeAlimentacao").val(totalAusencias);
        calculaTotalAusencias(0);
    }

    function clearFormValeAlimentacao() {
        $("#valeAlimentacaoId").val('');
        $("#sequencialValeAlimentacao").val('');
        $('#descricaoFaltasAusenciasValeAlimentacao').val('');
        $("#faltaAusenciaValeAlimentacao").val('');
        $("#dataFaltaAusenciaValeAlimentacaoInicio").val('');
        $("#dataFaltaAusenciaValeAlimentacaoFim").val('');
        $('#descricaoDataFaltaAusenciaValeAlimentacao').val('');
        $("#faltaAusenciaValeAlimentacao").val('');
        $('#justificativaValeAlimentacao').val('');
        $('#diasDeVAVR').val('');
    }

    function carregaValeAlimentacao(sequencialValeAlimentacao) {
        var arr = jQuery.grep(jsonValeAlimentacaoArray, function(item, i) {
            return (item.sequencialValeAlimentacao === sequencialValeAlimentacao);
        });

        clearFormValeAlimentacao();

        if (arr.length > 0) {
            var item = arr[0];
            $("#faltaAusenciaValeAlimentacao").val(item.faltaAusenciaValeAlimentacao);
            $("#dataFaltaAusenciaValeAlimentacaoInicio").val(item.descricaoDataFaltaAusenciaValeAlimentacao);
            // $("#dataFaltaAusenciaValeAlimentacaoFim").val(FormataStringDataBarra(item.descricaoDataFaltaAusenciaValeAlimentacao));
            $("#dataFaltaAusenciaValeAlimentacaoFim").val(item.descricaoDataFaltaAusenciaValeAlimentacao);
            $("#justificativaValeAlimentacao").val(item.justificativaValeAlimentacao);
            $("#valeAlimentacaoId").val(item.valeAlimentacaoId);
            $("#sequencialValeAlimentacao").val(item.sequencialValeAlimentacao);
            $('#justificativaValeAlimentacao').val(item.justificativaValeAlimentacao);
        }
    }

    function excluirValeAlimentacao() {
        var arrSequencial = [];
        $('#tableValeAlimentacao input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonValeAlimentacaoArray.length - 1; i >= 0; i--) {
                var obj = jsonValeAlimentacaoArray[i];
                if (jQuery.inArray(obj.sequencialValeAlimentacao, arrSequencial) > -1) {
                    jsonValeAlimentacaoArray.splice(i, 1);
                }
            }
            $("#jsonValeAlimentacao").val(JSON.stringify(jsonValeAlimentacaoArray));
            fillTableValeAlimentacao();
            calculaTotalAusencias(1)
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Falta/Ausência para excluir.", "error");
    }




    // ---------------------------------------------------------  Dias Trabalhados - Vale Transporte -----------------------------------------------------------

    function validaValeTransporte(copiadoVT) {
        var copiado = copiadoVT;
        var achouData = false;
        // var dataFaltaAusenciaValeTransporte = $('#dataFaltaAusenciaValeTransporte').val();

        var faltaAusenciaValeTransporte = $('#faltaAusenciaValeTransporte').val();
        if (copiado != 1) {
            var dataInico = FormataStringData($("#dataFaltaAusenciaValeTransporteInicio").val());
            var dataFim = FormataStringData($("#dataFaltaAusenciaValeTransporteFim").val());
        } else {
            var dataInico =  FormataStringData($('#dataFaltaAusenciaValeAlimentacaoInicio').val()); // se for copiado do VA compara com as datas do campo de va
            var dataFim = FormataStringData($('#dataFaltaAusenciaValeAlimentacaoFim').val());
        }
        var sequencial = +$('#sequencialValeTransporte').val();
        if (copiado != 1) {
            if (faltaAusenciaValeTransporte === '') {
                smartAlert("Erro", "Informe se há alguma Falta/Ausência", "error");
                return false;
            }

            if (dataInico === '') {
                smartAlert("Erro", "Informe a Data Incíco", "error");
                return false;
            }

            if (dataFim === '') {
                smartAlert("Erro", "Informe a Data Fim", "error");
                return false;
            }
        }

        for (i = jsonValeTransporteArray.length - 1; i >= 0; i--) {
            var dataFaltaAusenciaValeTransporte = jsonValeTransporteArray[i].dataFaltaAusenciaValeTransporte
            // dataInico,dataFim
            if(moment(dataFaltaAusenciaValeTransporte).isSame(moment(dataInico)) || moment(dataFaltaAusenciaValeTransporte).isSame(moment(dataFim)) ){
                achouData = true;
                break;
            }
        }
    // for (i = jsonValeTransporteArray.length - 1; i >= 0; i--) {
    //     if ((jsonValeTransporteArray[i].dataFaltaAusenciaValeTransporte === dataInico)
    //          || ( jsonValeTransporteArray[i].dataFaltaAusenciaValeTransporte === dataFim)) {
    //         achouData = true;
    //         break;
    //     }
    // }
    if (achouData === true) {
        smartAlert("Erro", "Já existe esta data em falta/ausência no VT ,no periodo: (" + dataInico + "  " + dataFim + ")", "error");
        return false;
    }
    return true;
    }

    function processDataValeTransporte(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoFaltasAusenciasValeTransporte")) {
            var faltasAusencias = $("#faltaAusenciaValeTransporte").val();
            if (faltasAusencias === 'F') {
                return {
                    name: fieldName,
                    value: 'Falta'
                };
            } else if (faltasAusencias === 'A') {
                return {
                    name: fieldName,
                    value: 'Ausência'
                };
            }
        }
        if (fieldName !== '' && (fieldId === "dataFaltaAusenciaValeTransporte")) {
            var dataCerta = $("#dataFaltaAusenciaValeTransporte").val();
            return {
                name: fieldName,
                value: dataCerta
            }
        }
        if (fieldName !== '' && (fieldId === "descricaoDataFaltaAusenciaValeTransporte")) {
            var dataFaltaAusencia = $("#dataFaltaAusenciaValeTransporte").val();
            dataFaltaAusencia = dataFaltaAusencia.split("-");
            dataFaltaAusencia = dataFaltaAusencia[2] + "/" + dataFaltaAusencia[1] + "/" + dataFaltaAusencia[0];
            return {
                name: fieldName,
                value: dataFaltaAusencia
            };
        }

        return false;
    }

    function addValeTransporte() {
        var faltasValeTransporte = +$("#faltasValeTransporte").val();
        var ausenciasValeTransporte = +$("#ausenciasValeTransporte").val();
        var diasProjetoValeTransporte = +$("#diasProjetoValeTransporte").val();
        var totalFaltasAusenciasValeTransporte = faltasValeTransporte + ausenciasValeTransporte;

        if (totalFaltasAusenciasValeTransporte > diasProjetoValeTransporte) {
            smartAlert("Erro", "A lista não pode ser maior que a quantidade de dias do projeto.", "error");
            clearFormValeTransporte();
            return false;
        }

        if (($("#projeto").val() === "") && ($("#mesAnoFolhaPonto").val() === "")) {
            smartAlert("Erro", "Escolha o Projeto e Mês/Ano da Folha de Ponto primeiro!", "error");
            return false;
        }



        var item = $("#formValeTransporte").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataValeTransporte
        });

        if (item["sequencialValeTransporte"] === '') {
            if (jsonValeTransporteArray.length === 0) {
                item["sequencialValeTransporte"] = 1;
            } else {
                item["sequencialValeTransporte"] = Math.max.apply(Math, jsonValeTransporteArray.map(function(o) {
                    return o.sequencialValeTransporte;
                })) + 1;
            }
            item["valeTransporteId"] = 0;
        } else {
            item["sequencialValeTransporte"] = +item["sequencialValeTransporte"];
        }

        var index = -1;
        $.each(jsonValeTransporteArray, function(i, obj) {
            if (+$('#sequencialValeTransporte').val() === obj.sequencialValeTransporte) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonValeTransporteArray.splice(index, 1, item);
        else
            jsonValeTransporteArray.push(item);
        $("#jsonValeTransporte").val(JSON.stringify(jsonValeTransporteArray));
        fillTableValeTransporte();

        calcularTotal(1);
    }

    function fillTableValeTransporte() {
        $("#tableValeTransporte tbody").empty();

        for (var i = 0; i < jsonValeTransporteArray.length; i++) {
            var row = $('<tr />');

            $("#tableValeTransporte tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonValeTransporteArray[i].sequencialValeTransporte + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaValeTransporte(' + jsonValeTransporteArray[i].sequencialValeTransporte + ');">' + jsonValeTransporteArray[i].descricaoFaltasAusenciasValeTransporte + '</td>'));
            row.append($('<td class="text-center">' + jsonValeTransporteArray[i].descricaoDataFaltaAusenciaValeTransporte + '</td>'));

        }

        //Calcula a quantidade de faltas e ausências baseadas no array JSON e popula elas no HTML.
        var totalFaltas = jsonValeTransporteArray.filter((item) => item.faltaAusenciaValeTransporte === "F").length; +
        $("#faltasValeTransporte").val(totalFaltas);
        var totalAusencias = jsonValeTransporteArray.filter((item) => item.faltaAusenciaValeTransporte === "A").length; +
        $("#ausenciasValeTransporte").val(totalAusencias);
        calculaTotalAusencias(0);

    }


    function clearFormValeTransporte() {
        $("#valeTransporteId").val('');
        $("#sequencialValeTransporte").val('');
        $('#descricaoFaltasAusenciasValeTransporte').val('');
        $("#faltaAusenciaValeTransporte").val('');
        $("#dataFaltaAusenciaValeTransporteInicio").val('');
        $("#dataFaltaAusenciaValeTransporteFim").val('');
        $('#descricaoDataFaltaAusenciaValeTransporte').val('');
        $("#faltaAusenciaValeTransporte").val('');
        $('#justificativaValeTransporte').val('');
    }

    function carregaValeTransporte(sequencialValeTransporte) {
        var arr = jQuery.grep(jsonValeTransporteArray, function(item, i) {
            return (item.sequencialValeTransporte === sequencialValeTransporte);
        });

        clearFormValeTransporte();

        if (arr.length > 0) {
            var item = arr[0];
            $("#faltaAusenciaValeTransporte").val(item.faltaAusenciaValeTransporte);
            $("#dataFaltaAusenciaValeTransporteInicio").val(item.descricaoDataFaltaAusenciaValeTransporte);
            $("#dataFaltaAusenciaValeTransporteFim").val(item.descricaoDataFaltaAusenciaValeTransporte);
            $("#justificativaValeTransporte").val(item.justificativaValeTransporte);
            $("#valeTransporteId").val(item.valeTransporteId);
            $("#sequencialValeTransporte").val(item.sequencialValeTransporte);
            $('#justificativaValeTransporte').val(item.justificativaValeTransporte);
        }
    }

    function excluirValeTransporte() {
        var arrSequencial = [];
        $('#tableValeTransporte input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonValeTransporteArray.length - 1; i >= 0; i--) {
                var obj = jsonValeTransporteArray[i];
                if (jQuery.inArray(obj.sequencialValeTransporte, arrSequencial) > -1) {
                    jsonValeTransporteArray.splice(i, 1);
                }
            }
            $("#jsonValeTransporte").val(JSON.stringify(jsonValeTransporteArray));
            fillTableValeTransporte();
            calculaTotalAusencias(1);

        } else
            smartAlert("Erro", "Selecione pelo menos 1 Falta/Ausência para excluir.", "error");
    }
    // ---------------------------------------------------------  Hora Extra -----------------------------------------------------------

    function validaHoraExtra() {
        var achouData = false;
        var faltaAusenciaHoraExtra = $('#faltaAusenciaValeTransporte').val();
        var dataFaltaAusenciaValeTransporte = $('#dataFaltaAusenciaValeTransporte').val();
        var sequencial = +$('#sequencialValeTransporte').val();

        if (faltaAusenciaValeTransporte === '') {
            smartAlert("Erro", "Informe se há alguma Falta/Ausência", "error");
            return false;
        }

        if (dataFaltaAusenciaValeTransporte === '') {
            smartAlert("Erro", "Informe a Data", "error");
            return false;
        }

        return true;
    }

    function processDataHoraExtra(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoFaltasAusenciasValeTransporte")) {
            var faltasAusencias = $("#faltaAusenciaValeTransporte").val();
            if (faltasAusencias === 'F') {
                return {
                    name: fieldName,
                    value: 'Falta'
                };
            } else if (faltasAusencias === 'A') {
                return {
                    name: fieldName,
                    value: 'Ausência'
                };
            }
        }
        if (fieldName !== '' && (fieldId === "dataFaltaAusenciaValeTransporte")) {
            var dataCerta = $("#dataFaltaAusenciaValeTransporte").val();
            dataCerta = dataCerta.split('/');
            dataCerta = dataCerta[2] + '-' + dataCerta[1] + '-' + dataCerta[0];
            return {
                name: fieldName,
                value: dataCerta
            }
        }
        if (fieldName !== '' && (fieldId === "descricaoDataFaltaAusenciaValeTransporte")) {
            var dataFaltaAusencia = $("#dataFaltaAusenciaValeTransporte").val();
            return {
                name: fieldName,
                value: dataFaltaAusencia
            };
        }

        return false;
    }

    function addHoraExtra() {
        var item = $("#formHoraExtra").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataHoraExtra
        });

        if (item["sequencialHoraExtra"] === '') {
            if (jsonHoraExtraArray.length === 0) {
                item["sequencialHoraExtra"] = 1;
            } else {
                item["sequencialHoraExtra"] = Math.max.apply(Math, jsonHoraExtraArray.map(function(o) {
                    return o.sequencialHoraExtra;
                })) + 1;
            }
            item["horaExtraId"] = 0;
        } else {
            item["sequencialHoraExtra"] = +item["sequencialHoraExtra"];
        }

        var index = -1;
        $.each(jsonHoraExtraArray, function(i, obj) {
            if (+$('#sequencialHoraExtra').val() === obj.sequencialHoraExtra) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonHoraExtraArray.splice(index, 1, item);
        else
            jsonHoraExtraArray.push(item);
        $("#jsonHoraExtra").val(JSON.stringify(jsonHoraExtraArray));
        fillTableHoraExtra();
        clearFormHoraExtra();
    }

    function fillTableHoraExtra() {
        $("#tableHoraExtra tbody").empty();

        for (var i = 0; i < jsonHoraExtraArray.length; i++) {
            var row = $('<tr />');

            $("#tableHoraExtra tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonHoraExtraArray[i].sequencialHoraExtra + '"><i></i></label></td>'));
            row.append($('<td class="text-center" onclick="carregaHoraExtra(' + jsonHoraExtraArray[i].sequencialHoraExtra + ');">' + jsonHoraExtraArray[i].dataHoraExtra + '</td>'));
            row.append($('<td class="text-center">' + jsonHoraExtraArray[i].dataHoraExtraFim + '</td>'));
            row.append($('<td class="text-center">' + jsonHoraExtraArray[i].horaInicioHoraExtra + '</td>'));
            row.append($('<td class="text-center">' + jsonHoraExtraArray[i].horaFimHoraExtra + '</td>'));
            row.append($('<td class="text-center">' + jsonHoraExtraArray[i].horaTotalExtra + '</td>'));
            row.append($('<td class="text-center">' + jsonHoraExtraArray[i].horaExtraNoturna + '</td>'));
            row.append($('<td class="text-center">' + jsonHoraExtraArray[i].horaExtraDiurna + '</td>'));
        }
    }


    function clearFormHoraExtra() {
        $("#horaExtraId").val('');
        $("#sequencialHoraExtra").val('');
        $('#dataHoraExtra').val('');
        $("#dataHoraExtraFim").val('');
        $("#horaFimHoraExtra").val('');
        $('#horaInicioHoraExtra').val('');
        $("#justificativaHoraExtra").val('');
        $("#horaTotalExtra").val('');
        $("#horaExtraNoturna").val('');


    }

    function carregaHoraExtra(sequencialHoraExtra) {
        var arr = jQuery.grep(jsonHoraExtraArray, function(item, i) {
            return (item.sequencialHoraExtra === sequencialHoraExtra);
        });

        clearFormHoraExtra();

        if (arr.length > 0) {
            var item = arr[0];
            $("#horaExtraId").val(item.horaExtraId);
            $("#sequencialHoraExtra").val(item.sequencialHoraExtra);
            $('#dataHoraExtra').val(item.dataHoraExtra);
            $("#dataHoraExtraFim").val(item.dataHoraExtraFim);
            $("#horaFimHoraExtra").val(item.horaFimHoraExtra);
            $('#horaInicioHoraExtra').val(item.horaInicioHoraExtra);
            $("#justificativaHoraExtra").val(item.justificativaHoraExtra);
            $("#horaTotalExtra").val(item.horaTotalExtra);
            $("#horaExtraNoturna").val(item.horaExtraNoturna);
            $("#horaExtraDiurna").val(item.horaExtraDiurna);
            var dataInicio = $("#dataHoraExtra").val();
            var dataFim = $("#dataHoraExtraFim").val();
            verificaDiaSemana(dataInicio, 0);
            verificaDiaSemana(dataFim, 1);
            verificaFeriadoData(0);
            verificaFeriadoData(1);

        }
    }

    function excluirHoraExtra() {
        var arrSequencial = [];
        $('#tableHoraExtra input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonHoraExtraArray.length - 1; i >= 0; i--) {
                var obj = jsonHoraExtraArray[i];
                if (jQuery.inArray(obj.sequencialHoraExtra, arrSequencial) > -1) {
                    jsonHoraExtraArray.splice(i, 1);
                }
            }
            $("#jsonHoraExtra").val(JSON.stringify(jsonHoraExtraArray));
            fillTableHoraExtra();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Registro para excluir.", "error");
    }
    //Fim Array Hora Extra

    function addValorExtra() {

        var item = $("#formValorExtra").toObject({
            mode: 'combine',
            skipEmpty: false

        });

        if (item["sequencialValorExtra"] === '') {
            if (jsonValorExtraArray.length === 0) {
                item["sequencialValorExtra"] = 1;
            } else {
                item["sequencialValorExtra"] = Math.max.apply(Math, jsonValorExtraArray.map(function(o) {
                    return o.sequencialValorExtra;
                })) + 1;
            }
            item["valorExtraId"] = 0;
        } else {
            item["sequencialValorExtra"] = +item["sequencialValorExtra"];
        }

        var index = -1;
        $.each(jsonValorExtraArray, function(i, obj) {
            if (+$('#sequencialValorExtra').val() === obj.sequencialValorExtra) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonValorExtraArray.splice(index, 1, item);
        else
            jsonValorExtraArray.push(item);
        $("#jsonValorExtra").val(JSON.stringify(jsonValorExtraArray));
        fillTableValorExtra();
        clearFormValorExtra();

    }

    function fillTableValorExtra() {
        $("#tableValorExtra tbody").empty();

        for (var i = 0; i < jsonValorExtraArray.length; i++) {
            var row = $('<tr />');
            var descricaoBeneficioExtra = $("#beneficioExtra option[value = '" + jsonValorExtraArray[i].beneficioExtra + "']").text();

            $("#tableValorExtra tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonValorExtraArray[i].sequencialValorExtra + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaValorExtra(' + jsonValorExtraArray[i].sequencialValorExtra + ');">' + descricaoBeneficioExtra + '</td>'));
            row.append($('<td class="decimal-2-casas">' + jsonValorExtraArray[i].valorExtra + '</td>'));

        }
    }


    function clearFormValorExtra() {
        $("#valorExtraId").val('');
        $("#sequencialValorExtra").val('');
        $('#descricaoExtra').val('');
        $("#beneficioExtra").val('');
        $("#valorExtra").val('');
        $('#justificativaValorExtra').val('');

    }

    function carregaValorExtra(sequencialValorExtra) {
        var arr = jQuery.grep(jsonValorExtraArray, function(item, i) {
            return (item.sequencialValorExtra === sequencialValorExtra);
        });

        clearFormValorExtra();

        if (arr.length > 0) {
            var item = arr[0];
            $("#sequencialValorExtra").val(item.sequencialValorExtra);
            $("#descricaoExtra").val(item.descricaoExtra);
            $("#beneficioExtra").val(item.beneficioExtra);
            $("#valorExtra").val(item.valorExtra);
            $("#justificativaValorExtra").val(item.justificativaValorExtra);
            initializeDecimalBehaviour()
            populaDiasProjetoValorExtra()

        }
    }

    function excluirValorExtra() {
        var arrSequencial = [];
        $('#tableValorExtra input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonValorExtraArray.length - 1; i >= 0; i--) {
                var obj = jsonValorExtraArray[i];
                if (jQuery.inArray(obj.sequencialValorExtra, arrSequencial) > -1) {
                    jsonValorExtraArray.splice(i, 1);
                }
            }
            $("#jsonValorExtra").val(JSON.stringify(jsonValorExtraArray));
            fillTableValorExtra();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 item para excluir.", "error");
    }

    function verificaFeriasFuncionario() {
        var funcionario = $("#funcionario").val();
        if (funcionario == "") {
            funcionario = $("#funcionarioCodigo").val();
        }
        var mesAno = $("#mesAnoFolhaPonto").val();
        verificaFerias(funcionario, mesAno,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    $("#tableFerias").empty();
                    smartAlert("Aviso", "O funcionário não possui férias cadastradas no período informado!", "info");
                    return;
                } else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];
                    var diasCorridos = piece[2];
                    var dataInicio = piece[3];
                    var dataFim = piece[4];
                    var qtdFeriado = +piece[5];
                    var diasUteis;
                    piece = out.split("^");

                    // Atributos de dias úteis do projeto que serão recuperados:  
                    var strFerias = piece[0];
                    diasUteis = moment(dataInicio, 'YYYY/MM/DD').businessDiff(moment(dataFim, 'YYYY/MM/DD'));
                    if (diasUteis < 0) diasUteis *= -1;
                    diasUteis = diasUteis - parseInt(qtdFeriado);

                    //+1 dia para contar o dia inicial de feiras 
                    diasUteis++;

                    //Arrays
                    $("#jsonFerias").val(strFerias);
                    $("#feriasTotalDia").val(diasCorridos);
                    $("#feriasDiaUtil").val(diasUteis);

                    jsonFeriasArray = JSON.parse($("#jsonFerias").val());
                    fillTableFerias()
                    return;
                }
            }
        );
    }

    function recuperaDiasUteis() {
        var mesAno = $("#mesAnoFolhaPonto").val();
        var funcionario = $("#funcionario").val();
        if (funcionario == "") {
            var funcionario = $("#funcionarioCodigo").val();
        }
        var projeto = $("#projeto").val();
        recuperaDiaUtil(mesAno, funcionario, projeto,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    return;
                } else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];
                    var diasUteis = out.split("^");
                    var diasUteisVAVR = diasUteis[0];
                    var diasUteisVT = diasUteis[2];
                    var descricaoDiaUtilVAVR = diasUteis[1];
                    var descricaoDiaUtilVT = diasUteis[3];
                    // if (descricaoDiaUtil == "Mês Corrente") {
                    //     $("#diaUtilNoMesVAVR").val(diasUteisVAVR)
                    //     $("#diaUtilNoMesVT").val(diasUteisVAVR)
                    //     $("#tipoDiaUtil").val(descricaoDiaUtil)
                    //     $("#diasProjetoValeAlimentacao").val(diasUteisVAVR)
                    //     $("#totalDiasTrabalhadosValeAlimentacao").val(diasUteisVAVR)
                    //     $("#diasProjetoValeTransporte").val(diasUteisVAVR)
                    //     $("#totalDiasTrabalhadosValeTransporte").val(diasUteisVAVR)

                    //     return
                    // }
                    $("#diaUtilNoMesVAVR").val(diasUteisVAVR)
                    $("#diaUtilNoMesVT").val(diasUteisVT)
                    $("#tipoDiaUtilVAVR").val(descricaoDiaUtilVAVR)
                    $("#tipoDiaUtilVT").val(descricaoDiaUtilVT)
                    $("#diasProjetoValeAlimentacao").val(diasUteisVAVR)
                    $("#totalDiasTrabalhadosValeAlimentacao").val(diasUteisVAVR)
                    $("#diasProjetoValeTransporte").val(diasUteisVT)
                    $("#totalDiasTrabalhadosValeTransporte").val(diasUteisVT)
                    return;
                }
            }
        );
    }

    function calculaTotalAusencias(verificador) {
        switch (verificador) {
            case 0:
                var ausenciaVA = +$("#totalAusenciasValeAlimentacao").val();
                var ausenciaVR = +$("#totalAusenciasValeRefeicao").val();
                var ausenciaVT = +$("#ausenciasValeTransporte").val();
                var totalAusenciaGeral = ausenciaVA + ausenciaVR + ausenciaVT;
                $("#totalAusenciasValorExtra").val(totalAusenciaGeral);
                break;
            case 1:
                var ausenciaVA = +$("#totalAusenciasValeAlimentacao").val();
                var ausenciaVR = +$("#totalAusenciasValeRefeicao").val();
                var ausenciaVT = +$("#ausenciasValeTransporte").val();
                var totalAusenciaGeral = ausenciaVA - ausenciaVR - ausenciaVT;
                if (totalAusenciaGeral < 0) {
                    totalAusenciaGeral *= -1;
                }
                $("#totalAusenciasValorExtra").val(totalAusenciaGeral);
                break;
            default:
                break;
        }


    }

    //Listagem de Férias
    function fillTableFerias() {
        $("#tableFerias tbody").empty();
        for (var i = 0; i < jsonFeriasArray.length; i++) {
            var row = $('<tr />');
            $("#tableFerias tbody").append(row);
            row.append($('<td class="text-center">' + jsonFeriasArray[i].dataInicioFerias + '</td>'));
            row.append($('<td class="text-center">' + jsonFeriasArray[i].dataFimFerias + '</td>'));
        }
    }

    function verificaDiaSemana(data, verificador) {
        var data = data.split("/");
        data = data[2] + "/" + data[1] + "/" + data[0]
        //Formata da data com o moment colocando o dia da semana
        var dataAux = moment(data);
        dataAux = dataAux.format("LLLL")
        //Extrai somente o dia da semana
        dataAux = dataAux.split(",");
        dataAux = dataAux[0];
        if (dataAux == "Sunday") {
            dataAux = "Domingo"
        } else if (dataAux == "Monday") {
            dataAux = "Segunda-Feira"
        } else if (dataAux == "Tuesday") {
            dataAux = "Terça-Feira"
        } else if (dataAux == "Wednesday") {
            dataAux = "Quarta-Feira"
        } else if (dataAux == "Thursday") {
            dataAux = "Quinta-Feira"
        } else if (dataAux == "Friday") {
            dataAux = "Sexta-Feira"
        } else {
            dataAux = "Sábado"
        }
        //Verifica em qual campo preencher o valor
        switch (verificador) {
            case 0:
                $("#diaSemanaInicio").val(dataAux);
                break;
            case 1:
                $("#diaSemanaFim").val(dataAux);
                break;
            default:
                break;
        }
    }

    function verificaFeriadoData(verificador) {
        var dataInicio = $("#dataHoraExtra").val()
        var dataFim = $("#dataHoraExtraFim").val()
        var data = 0
        if (verificador == 0) {
            data = dataInicio
        } else {
            data = dataFim
        }
        verificaFeriado(data,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    switch (verificador) {
                        case 0:
                            $("#feriado").prop('disabled', false);
                            $("#feriado").val(0);
                            $("#feriado").prop('disabled', true);
                            break;
                        case 1:
                            $("#feriadoDataFim").prop('disabled', false);
                            $("#feriadoDataFim").val(0);
                            $("#feriadoDataFim").prop('disabled', true);
                            break;
                        default:
                            break;
                    }

                } else {
                    data = data.replace(/failed/g, '');
                    switch (verificador) {
                        case 0:
                            $("#feriado").prop('disabled', false);
                            $("#feriado").val(1);
                            $("#feriado").prop('disabled', true);
                            break;
                        case 1:
                            $("#feriadoDataFim").prop('disabled', false);
                            $("#feriadoDataFim").val(1);
                            $("#feriadoDataFim").prop('disabled', true);
                            break;
                        default:
                            break;

                    }
                }
            }
        );
    }

    //Incrementa a data com um dia se a hora Inicio for maior que a hora Fim
    function incrementaData() {
        //Verificador serve para que a incrementação seja feita apenas uma vez
        var verificador = $("#verificador").val()
        var horaInicio = $("#horaInicioHoraExtra").val()
        var horaFim = $("#horaFimHoraExtra").val()
        var dataFimHoraExtra = $("#dataHoraExtraFim").val()
        var dataInicioHoraExtra = $("#dataHoraExtra").val()
        dataInicioHoraExtra = dataInicioHoraExtra.split("/")
        dataFimHoraExtra = dataFimHoraExtra.split("/");
        var mesReferencia = dataFimHoraExtra[1];
        var mesSomado = 0
        var dataSomada = 0
        var anoSomado = 0
        var diaArmazenado = 0

        var dataAux = 0;

        //Compara as datas aqui
        horaInicio = horaInicio.split(":")
        horaFim = horaFim.split(":")
        if (horaInicio[0] > horaFim[0]) {
            //Armazena o dia da primeira passagem pelo condicional
            diaArmazenado = +dataInicioHoraExtra[0]
            dataSomada = (parseInt(dataFimHoraExtra[0]) + 1)

            if (dataSomada >= (diaArmazenado + 2)) {
                dataSomada = dataFimHoraExtra[0]
            }


            //Verifica quais são os meses com 31 dias
            if (mesReferencia == '01' || mesReferencia == '03' || mesReferencia == '05' ||
                mesReferencia == '07' || mesReferencia == '10' || mesReferencia == '12') {
                if (dataSomada > 31) {
                    dataSomada = '01';
                    mesSomado = (parseInt(dataFimHoraExtra[1]) + 1)
                    if (mesSomado < 10) {
                        mesSomado = '0' + mesSomado
                        //Verifica se mes é maior do que 12 se for ele incrementa mais 1 ao ano
                    } else if (mesSomado > 12) {
                        mesSomado = "01"
                        diaSomado = "01"
                        anoSomado = (parseInt(dataFimHoraExtra[2]) + 1);

                        dataAux = diaSomado + "/" + mesSomado + "/" + anoSomado
                    } else {
                        dataAux = dataSomada + "/" + mesSomado + "/" + dataFimHoraExtra[2]
                    }
                } else {
                    dataAux = dataSomada + "/" + dataFimHoraExtra[1] + "/" + dataFimHoraExtra[2]
                }
            } else if (mesReferencia == '02') {
                //Verifica queis são os meses com 28 dias ou 29
                if (dataSomada > 28 || dataSomada > 29) {
                    dataSomada = '01';
                    mesSomado = (parseInt(dataFimHoraExtra[1]) + 1)
                    if (mesSomado < 10) {
                        mesSomado = '0' + mesSomado
                        dataAux = dataSomada + "/" + mesSomado + "/" + dataFimHoraExtra[2]
                        //Verifica se mes é maior do que 12 se for ele incrementa mais 1 ao ano
                    } else if (mesSomado > 12) {
                        mesSomado = "01"
                        diaSomado = "01"
                        anoSomado = (parseInt(dataFimHoraExtra[2]) + 1);

                        dataAux = diaSomado + "/" + mesSomado + "/" + anoSomado
                    }
                } else {
                    dataAux = dataSomada + "/" + dataFimHoraExtra[1] + "/" + dataFimHoraExtra[2]
                }
                //Verifica queis são os meses com 30 dias
            } else if (mesReferencia == '04' || mesReferencia == '06' || mesReferencia == '09' || mesReferencia == '11')
                if (dataSomada > 30) {
                    dataSomada = '01';
                    mesSomado = (parseInt(dataFimHoraExtra[1]) + 1)
                    if (mesSomado < 10) {
                        mesSomado = '0' + mesSomado
                        dataAux = dataSomada + "/" + mesSomado + "/" + dataFimHoraExtra[2]
                        //Verifica se mes é maior do que 12 se for ele incrementa 1 ao ano
                    } else if (mesSomado > 12) {
                        mesSomado = "01"
                        diaSomado = "01"
                        anoSomado = (parseInt(dataFimHoraExtra[2]) + 1);

                        dataAux = diaSomado + "/" + mesSomado + "/" + anoSomado
                    }
                } else {
                    dataAux = dataSomada + "/" + dataFimHoraExtra[1] + "/" + dataFimHoraExtra[2]
                }
            dataAux = dataAux.toString()
            $("#dataHoraExtraFim").val(dataAux).trigger('change')
            // $("#verificador").val(verificador + 1)
        }

    }

    function verificaDatas() {
        var dataFimHoraExtra = $("#dataHoraExtraFim").val()
        var dataInicioHoraExtra = $("#dataHoraExtra").val()

        dataInicioHoraExtra = dataInicioHoraExtra.split("/")
        dataFimHoraExtra = dataFimHoraExtra.split("/");
        if (dataInicioHoraExtra[0] > dataFimHoraExtra[0] && dataInicioHoraExtra[1] == dataFimHoraExtra[1] &&
            dataInicioHoraExtra[2] == dataFimHoraExtra[2]) {
            smartAlert("Erro", "A Data Fim não pode ser menor que a Data Incial", "error")
            $("#dataHoraExtraFim").val('')
            $("#horaInicioHoraExtra").val('')
            $("#horaFimHoraExtra").val('')
            $("#diaSemanaFim").val('')
            $("#horaTotalExtra").val('')
            $("#horaExtraNoturna").val('')
            $("#dataHoraExtraFim").focus()
            return false
        } else if (dataInicioHoraExtra[2] > dataFimHoraExtra[2]) {
            smartAlert("Erro", "A Data Fim não pode ser menor que a Data Incial", "error")
            $("#dataHoraExtraFim").val('')
            $("#horaInicioHoraExtra").val('')
            $("#horaFimHoraExtra").val('')
            $("#diaSemanaFim").val('')
            $("#horaTotalExtra").val('')
            $("#horaExtraNoturna").val('')
            $("#dataHoraExtraFim").focus()
            return false
        }
        return true
    }

    function recuperaDiasUteisProjeto() {
        var mesAno = $("#mesAnoFolhaPonto").val();
        var funcionario = $("#funcionarioCodigo").val();
        var projeto = $("#projeto").val();
        recuperaDiaUtilProjeto(mesAno, funcionario, projeto,
            function(data) {
                if (data.indexOf('failed') > -1) {} else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];
                    var diasUteis = out.split("^");
                    var diasUteisVAVR = diasUteis[0];
                    var diasUteisVT = diasUteis[1];
                    $("#diasProjetoValeAlimentacao").val(diasUteisVAVR)
                    $("#diasProjetoValeTransporte").val(diasUteisVT)
                    return;
                }
            }
        );
    }


    //------------------------------------------------- Começo dos calculos de Hora Extra ---------------------------------------

    function getDates(startDate, stopDate) {
        var dateArray = [];
        var currentDate = moment(startDate);
        var stopDate = moment(stopDate);
        while (currentDate <= stopDate) {
            dateArray.push(moment(currentDate).format('YYYY-MM-DD'))
            currentDate = moment(currentDate).add(1, 'days');
        }
        return dateArray;
    }

    function FormataStringData(data) {
        var dia = data.split("/")[0];
        var mes = data.split("/")[1];
        var ano = data.split("/")[2];

        return ano + '-' + ("0" + mes).slice(-2) + '-' + ("0" + dia).slice(-2);
        // Utilizo o .slice(-2) para garantir o formato com 2 digitos.
    }

    function FormataStringDataBarra(data) {
        var ano = data.split("-")[0];
        var mes = data.split("-")[1];
        var dia = data.split("-")[2];

        return ("0" + dia).slice(-2) + '/' + ("0" + mes).slice(-2) + '/' + ano;
        // Utilizo o .slice(-2) para garantir o formato com 2 digitos.
    }
    var dates = {
        convert: function(d) {
            // Converts the date in d to a date-object. The input can be:
            //   a date object: returned without modification
            //  an array      : Interpreted as [year,month,day]. NOTE: month is 0-11.
            //   a number     : Interpreted as number of milliseconds
            //                  since 1 Jan 1970 (a timestamp) 
            //   a string     : Any format supported by the javascript engine, like
            //                  "YYYY/MM/DD", "MM/DD/YYYY", "Jan 31 2009" etc.
            //  an object     : Interpreted as an object with year, month and date
            //                  attributes.  **NOTE** month is 0-11.
            return (
                d.constructor === Date ? d :
                d.constructor === Array ? new Date(d[0], d[1], d[2]) :
                d.constructor === Number ? new Date(d) :
                d.constructor === String ? new Date(d) :
                typeof d === "object" ? new Date(d.year, d.month, d.date) :
                NaN
            );
        },
        compare: function(a, b) {
            // Compare two dates (could be of any type supported by the convert
            // function above) and returns:
            //   1 : if a < b
            //   0 : if a = b
            //  -1 : if a > b
            // NaN : if a or b is an illegal date
            // NOTE: The code inside isFinite does an assignment (=).
            return (
                isFinite(a = this.convert(a).valueOf()) &&
                isFinite(b = this.convert(b).valueOf()) ?
                (a > b) - (a < b) :
                NaN
            );
        },
        inRange: function(d, start, end) {
            // Checks if date in d is between dates in start and end.
            // Returns a boolean or NaN:
            //    true  : if d is between start and end (inclusive)
            //    false : if d is before start or after end
            //    NaN   : if one or more of the dates is illegal.
            // NOTE: The code inside isFinite does an assignment (=).
            return (
                isFinite(d = this.convert(d).valueOf()) &&
                isFinite(start = this.convert(start).valueOf()) &&
                isFinite(end = this.convert(end).valueOf()) ?
                start <= d && d <= end :
                NaN
            );
        }
    }



    function calculaHoraExtra(horaInicial, horaFinal) {

        // Limpa os campos calculados
        $("#horaTotalExtra").val('');

        if (horaInicial !== "" && horaFinal !== "") {

            diffHoras = diferencaHoras(horaInicial, horaFinal);
            // somaHoras = somaHora( horaInicial, horaFinal );
            // convDiasHoras = converteEmDiasHoras(somaHoras) 

            $("#horaTotalExtra").val(diffHoras);

        }
    }

    function calculaAdicionalNoturno(horaInicial, horaFinal) {
        // Limpa os campos calculados
        $("#horaExtraNoturna").val('');

        if (horaInicial !== "" && horaFinal !== "") {

            diffHoras = diferencaHoras(horaInicial, horaFinal);
            // somaHoras = somaHora( horaInicial, horaFinal );
            // convDiasHoras = converteEmDiasHoras(somaHoras) ;

            $("#horaExtraNoturna").val(diffHoras);
            return diffHoras;
        }
    }

    function diferencaHoras(horaInicial, horaFinal) {

        // Se a hora inicial é menor que a final, faça a diferença tranquilamente	
        if (isHoraInicialMenorHoraFinal(horaInicial, horaFinal)) {
            aux = horaInicial;
            horaInicial = horaFinal;
            horaInicial = aux;

            hIni = horaInicial.split(':');
            hFim = horaFinal.split(':');

            horasTotal = parseInt(hFim[0], 10) - parseInt(hIni[0], 10);
            minutosTotal = parseInt(hFim[1], 10) - parseInt(hIni[1], 10);

            if (minutosTotal < 0) {
                minutosTotal += 60;
                horasTotal -= 1;
            }

            horaInicial = completaZeroEsquerda(horasTotal) + ":" + completaZeroEsquerda(minutosTotal);
            return horaInicial;
        }

        // Aqui fica a gosto de quem for programar: se forem iguais, vc pode assumir que 
        // o intervalo é 24h ou zero. Depende de vc! Eu escolhi assumir que é 24h
        else if (horaInicial == horaFinal) {
            return "24:00";
        }

        // Se a hora inicial é maior que a final, então vou assumir que o 
        // horário inicial é de um dia e o final é do dia seguinte
        else {
            horasQueFaltamPraMeiaNoite = diferencaHoras(horaInicial, "24:00"); // chamada recursiva, há há!
            totalHoras = somaHora(horasQueFaltamPraMeiaNoite, horaFinal);
            return totalHoras;
        }
    }

    function somaHora(horaInicio, horaSomada) {

        horaIni = horaInicio.split(':');
        horaSom = horaSomada.split(':');

        horasTotal = parseInt(horaIni[0], 10) + parseInt(horaSom[0], 10);
        minutosTotal = parseInt(horaIni[1], 10) + parseInt(horaSom[1], 10);

        if (minutosTotal >= 60) {
            minutosTotal -= 60;
            horasTotal += 1;
        }

        horaTotal = completaZeroEsquerda(horasTotal) + ":" + completaZeroEsquerda(minutosTotal);
        return horaTotal;
    }

    function isHoraInicialMenorHoraFinal(horaInicial, horaFinal) {
        horaIni = horaInicial.split(':');
        horaFim = horaFinal.split(':');

        // Verifica as horas. Se forem diferentes, é só ver se a inicial 
        // é menor que a final.
        hIni = parseInt(horaIni[0], 10);
        hFim = parseInt(horaFim[0], 10);
        if (hIni != hFim)
            return hIni < hFim;

        // Se as horas são iguais, verifica os minutos então.
        mIni = parseInt(horaIni[1], 10);
        mFim = parseInt(horaFim[1], 10);
        if (mIni != mFim)
            return mIni < mFim;
    }

    function isHoraInicialMaiorHoraFinal(horaInicial, horaFinal) {
        horaIni = horaInicial.split(':');
        horaFim = horaFinal.split(':');

        // Verifica as horas. Se forem diferentes, é só ver se a inicial 
        // é menor que a final.
        hIni = parseInt(horaIni[0], 10);
        hFim = parseInt(horaFim[0], 10);
        if (hIni != hFim)
            return hIni > hFim;

        // Se as horas são iguais, verifica os minutos então.
        mIni = parseInt(horaIni[1], 10);
        mFim = parseInt(horaFim[1], 10);
        if (mIni != mFim)
            return mIni > mFim;
    }

    function comparaHora(horaInicial, horaFinal, dataInicio, dataFim) {

        var hora1 = horaInicial.split(":");
        var hora2 = horaFinal.split(":");
        var dataInicio = formataDataAmericana(dataInicio)
        var dataFim = formataDataAmericana(dataFim)
        var dataInicio = new Date(dataInicio);
        var dataFim = new Date(dataFim);
        var data1 = new Date(dataInicio.getFullYear(), dataInicio.getMonth(), dataInicio.getDate(), hora1[0], hora1[1]);
        var data2 = new Date(dataFim.getFullYear(), dataFim.getMonth(), dataFim.getDate(), hora2[0], hora2[1]);

        return data1 < data2;

    }

    function completaZeroEsquerda(numero) {
        return (numero < 10 ? "0" + numero : numero);
    }

    //----------------------------------------------- Fim do Calculo de Hora Extra ------------------------------------

    function populaDiasProjetoValorExtra() {
        var beneficioExtra = +$("#beneficioExtra").val()
        switch (beneficioExtra) {
            case 1:
                var totalAusenciasVAVR = $("#totalAusenciasValeAlimentacao").val()
                var diasProjetoVAVR = $("#diasProjetoValeAlimentacao").val()
                $("#totalAusenciasValorExtra").val('')
                $("#totalAusenciasValorExtra").val(totalAusenciasVAVR)
                $("#diasProjetoValorExtra").val(diasProjetoVAVR)
                break;
            case 2:
                var totalAusenciasVT = $("#ausenciasValeTransporte").val()
                var diasProjetoVT = $("#diasProjetoValeTransporte").val()
                $("#totalAusenciasValorExtra").val(totalAusenciasVT)
                $("#diasProjetoValorExtra").val(diasProjetoVT)
                break;
            default:
                $("#totalAusenciasValorExtra").val('')
                $("#diasProjetoValorExtra").val('')
        }
    }

    function popularComboFuncionario() {
        var projeto = $("#projeto").val()
        if (projeto != 0) {
            populaComboFuncionario(projeto,
                function(data) {
                    var atributoId = '#' + 'funcionario';
                    if (data.indexOf('failed') > -1) {
                        smartAlert("Aviso", "O Projeto informado não possui funcionários cadastrados em (Vínculos e Benefícios)!", "info");
                        $("#projeto").focus()
                        $("#funcionario").val("")
                        $("#funcionario").prop("disabled", true)
                        $("#funcionario").addClass("readonly")
                        return;
                    } else {
                        $("#funcionario").prop("disabled", false)
                        $("#funcionario").removeClass("readonly")
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");

                        var mensagem = piece[0];
                        var qtdRegs = piece[1];
                        var arrayRegistros = piece[2].split("|");
                        var registro = "";

                        $(atributoId).html('');
                        $(atributoId).append('<option></option>');

                        for (var i = 0; i < qtdRegs; i++) {
                            registro = arrayRegistros[i].split("^");
                            $(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
                        }
                    }
                }
            );
        }
    }

    function verificaPeriodoAdicionalNoturno() {
        var funcionario = $("#funcionario").val()
        if (funcionario != 0) {
            periodoAdicionalNoturno(funcionario,
                function(data) {
                    var atributoId = '#' + 'funcionario';
                    if (data.indexOf('failed') > -1) {
                        return;
                    } else {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");

                        var mensagem = piece[0];
                        var horarios = piece[1];
                        var piece = horarios.split("^");
                        var horaInicio = piece[0];
                        var horaFim = piece[1];


                        $("#horaInicioANSindicato").val(horaInicio);
                        $("#horaFimANSindicato").val(horaFim);

                    }
                }
            );
        }
    }


    function calculaItensHoraExtra() {
        // valores inseridos
        var horaInicial = $("#horaInicioHoraExtra").val();
        var horaFinal = $("#horaFimHoraExtra").val();
        var dataInicio = $("#dataHoraExtra").val()
        var dataFim = $("#dataHoraExtraFim").val()
        var horaFinalAdicionalNoturno = 0
        var comparaHoraInicialMenor = 0
        var horaInicialAdicionalNoturno = 0
        var comparaHoraInicioHoraFimSindicato = 0
        calculaHoraExtra(horaInicial, horaFinal, 1)

        var horaInicialAdicionalNoturnoSindicato = $("#horaInicioANSindicato").val()
        var horaFinalAdicionalNoturnoSindicato = $("#horaFimANSindicato").val()
        //Compara as duas horas e verifica se a hora informada pelo usuário é maior do que a cadastrada no sindicato
        //Calcula Adicional Noturno se as Datas forem iguais
        if (dataInicio === dataFim) {
            var comparaHoraInicialMenor = isHoraInicialMenorHoraFinal(horaInicial, horaInicialAdicionalNoturnoSindicato)

            if (comparaHoraInicialMenor == true) {
                horaInicialAdicionalNoturno = horaInicialAdicionalNoturnoSindicato;
            } else {
                horaInicialAdicionalNoturno = horaInicial;
            }

            var comparaHoraInicialMaior = isHoraInicialMaiorHoraFinal(horaInicial, horaInicialAdicionalNoturnoSindicato)

            //Se a hora informada for menor que a do sindicato utilizo a hora do Sindicato para calculo
            //Se a hora informada for maior que a do sindicato utilizo a hora do Informada pelo usuário para calculo
            var comparaHoraFinalMenor = isHoraInicialMenorHoraFinal(horaFinal, horaFinalAdicionalNoturnoSindicato)
            var comparaHoraFinalMaior = isHoraInicialMaiorHoraFinal(horaFinal, horaFinalAdicionalNoturnoSindicato)
            var comparaHoraInicioHoraFimSindicato = comparaHora(horaInicialAdicionalNoturnoSindicato, horaFinal, dataInicio, dataFim)
            if (comparaHoraInicioHoraFimSindicato == false) {
                var mensagem = "Não Realizou"
                $("#horaExtraNoturna").val(mensagem)
                return
            }

            if (comparaHoraInicialMaior == true) {
                horaFinalAdicionalNoturno = horaFinalAdicionalNoturnoSindicato;
            } else {
                horaFinalAdicionalNoturno = horaFinal;
            }
            calculaAdicionalNoturno(horaInicialAdicionalNoturno, horaFinalAdicionalNoturno)
            return;
        }

        if (dataInicio !== dataFim) {
            //Compara se a hora informada pelo usuário é menor do que a do Sindicato, se for utiliza a hora do Sindicato para cálculo
            comparaHoraInicialMenor = isHoraInicialMenorHoraFinal(horaInicial, horaInicialAdicionalNoturnoSindicato)


            if (comparaHoraInicialMenor == true) {
                horaInicialAdicionalNoturno = horaInicialAdicionalNoturnoSindicato;
            } else {
                horaInicialAdicionalNoturno = horaInicial;
            }



            //Se a hora informada for menor que a do sindicato utilizo a hora do Sindicato para calculo
            //Se a hora informada for maior que a do sindicato utilizo a hora do Informada pelo usuário para calculo
            comparaHoraFinalMenor = isHoraInicialMenorHoraFinal(horaFinal, horaFinalAdicionalNoturnoSindicato)
            // var comparaHoraFinalMaior = isHoraInicialMaiorHoraFinal(horaFinal, horaFinalAdicionalNoturnoSindicato)
            if (comparaHoraFinalMenor == true) {
                horaFinalAdicionalNoturno = horaFinal;
            } else {
                horaFinalAdicionalNoturno = horaFinalAdicionalNoturnoSindicato;
            }
            // var horaAdicionalNoturno1 = calculaAdicionalNoturno(horaInicialAdicionalNoturno, "23:59")
            // var horaAdicionalNoturno2 = calculaAdicionalNoturno("00:00", horaFinalAdicionalNoturno)

            // var horaFinalAdicionalNoturno = somaHora(horaAdicionalNoturno1, horaAdicionalNoturno2, true);
            comparaHoraInicioHoraFimSindicato = comparaHora(horaInicialAdicionalNoturnoSindicato, horaFinal, dataInicio, dataFim)
            if (comparaHoraInicioHoraFimSindicato == false) {
                var mensagem = "Não Realizou"
                $("#horaExtraNoturna").val(mensagem)
                return
            }
            calculaAdicionalNoturno(horaInicialAdicionalNoturno, horaFinalAdicionalNoturno)
            return;
        }



    }

    function limpaCamposHoraExtra() {
        $("#dataHoraExtra").val('')
        $("#diaSemanaInicio").val('')
        $("#feriado").val('')
        $("#horaInicioHoraExtra").val('')
        $("#horaFimHoraExtra").val('')
        $("#dataHoraExtraFim").val('')
        $("#diaSemanaFim").val('')
        $("#horaTotalExtra").val('')
        $("#horaExtraNoturna").val('')
        $("#justificativaHoraExtra").val('')
    }

    function somaHora(hrA, hrB, zerarHora) {
        if (hrA.length != 5 || hrB.length != 5) return "00:00";

        temp = 0;
        nova_h = 0;
        novo_m = 0;

        hora1 = hrA.substr(0, 2) * 1;
        hora2 = hrB.substr(0, 2) * 1;
        minu1 = hrA.substr(3, 2) * 1;
        minu2 = hrB.substr(3, 2) * 1;

        temp = minu1 + minu2;
        while (temp > 59) {
            nova_h++;
            temp = temp - 60;
        }
        novo_m = temp.toString().length == 2 ? temp : ("0" + temp);

        temp = hora1 + hora2 + nova_h;
        while (temp > 23 && zerarHora) {
            temp = temp - 24;
        }
        nova_h = temp.toString().length == 2 ? temp : ("0" + temp);

        return nova_h + ':' + novo_m;
    }

    function formataDataAmericana(data) {
        var dataAux = data.split("/")
        dataAux = dataAux[2] + "/" + dataAux[1] + "/" + dataAux[0]
        return dataAux
    }

    function verificaHoraIncrementaData() {
        //Função que verificva a hora informada pelo usuário, caso a mesma seja menor que 00:00, a mesma iguala a data fim com a data inicio
        var dataInicio = $("#dataHoraExtra").val()
        var dataFim = $("#dataHoraExtraFim").val()
        //Pega a hora fim informada pelo usuario
        var horaInicio = $("#horaFimHoraExtra").val()
        var horaFim = "00:00"
        if ((horaInicio < "23:59")) {
            $("#dataHoraExtraFim").val(dataInicio)
            $("#dataHoraExtraFim").trigger('change')
            return
        }

    }

    function subtraiHora(hrA, hrB) {
        if (hrA.length != 5 || hrB.length != 5) return "00:00";

        temp = 0;
        nova_h = 0;
        novo_m = 0;

        hora1 = hrA.substr(0, 2) * 1;
        hora2 = hrB.substr(0, 2) * 1;
        minu1 = hrA.substr(3, 2) * 1;
        minu2 = hrB.substr(3, 2) * 1;

        temp = minu1 - minu2;
        while (temp < 0) {
            nova_h++;
            temp = temp + 60;
        }
        novo_m = temp.toString().length == 2 ? temp : ("0" + temp);

        temp = hora1 - hora2 - nova_h;
        while (temp < 0) {
            temp = temp + 24;
        }
        nova_h = temp.toString().length == 2 ? temp : ("0" + temp);

        return nova_h + ':' + novo_m;
    }

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        // Variáveis que vão ser gravadas no banco: 
        var id = +$("#codigo").val();
        var projeto = +$("#projeto").val();
        var funcionario = +$("#funcionario").val();
        var mesAnoFolhaPonto = $("#mesAnoFolhaPonto").val();
        var justificativaFolhaPonto = $("#justificativaFolhaPonto").val().trim().replace(/'/g, " ");
        var diasUteisVAVR = $("#diaUtilNoMesVAVR").val();
        var diasUteisVT = $("#diaUtilNoMesVT").val();
        // Dados de Dias Úteis - Vale Alimentação
        var totalFaltasValeAlimentacao = +$("#totalFaltasValeAlimentacao").val();
        var totalAusenciasValeAlimentacao = +$("#totalAusenciasValeAlimentacao").val();
        var diasProjetoValeAlimentacao = +$("#diasProjetoValeAlimentacao").val();
        var totalDiasTrabalhadosValeAlimentacao = +$("#totalDiasTrabalhadosValeAlimentacao").val();
        var jsonValeAlimentacaoArray = $("#jsonValeAlimentacao").val();

        // Dados de Dias Úteis - Vale Refeição
        var faltasValeTransporte = +$("#faltasValeTransporte").val();
        var ausenciasValeTransporte = +$("#ausenciasValeTransporte").val();
        var diasProjetoValeRefeicao = +$("#diasProjetoValeRefeicao").val();
        var totalDiasTrabalhadosValeRefeicao = +$("#totalDiasTrabalhadosValeRefeicao").val();
        //Dados Referentes as Listas
        var jsonValeRefeicaoArray = $("#jsonValeRefeicao").val();
        var jsonValeTransporteArray = $("#jsonValeTransporte").val();
        var jsonValorExtraArray = $("#jsonValorExtra").val();
        var jsonHoraExtraArray = $("#jsonHoraExtra").val();

        var totalDiasTrabalhadosVT = $("#totalDiasTrabalhadosValeTransporte").val()

        gravaFolhaPonto(id, projeto, funcionario, mesAnoFolhaPonto, justificativaFolhaPonto,
            totalFaltasValeAlimentacao, totalAusenciasValeAlimentacao, diasProjetoValeAlimentacao,
            totalDiasTrabalhadosValeAlimentacao, faltasValeTransporte, ausenciasValeTransporte,
            diasProjetoValeRefeicao, totalDiasTrabalhadosValeRefeicao, jsonValeAlimentacaoArray, jsonValeRefeicaoArray, jsonValeTransporteArray,
            jsonValorExtraArray, totalDiasTrabalhadosVT, jsonHoraExtraArray, diasUteisVAVR, diasUteisVT,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                        return;
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                        $("#btnGravar").prop('disabled', false);
                        return;
                    }

                } else {
                    //Verifica se a função de recuperar os campos foi executada.
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");

                    if (verificaRecuperacao === 1) {
                        voltar();
                    } else {
                        novo();
                    }
                }
            }
        );

    }


    function validaValorExtra() {
        var achouValorExtra = false;
        var beneficioExtra = $('#beneficioExtra').val();
        var valorExtra = $('#valorExtra').val();
        var sequencial = +$('#sequencialValorExtra').val();

        if (beneficioExtra === '') {
            smartAlert("Erro", "Informe o Beneficio Extra", "error");
            return false;
        }

        if (valorExtra === '') {
            smartAlert("Erro", "Informe o Valor Extra", "error");
            return false;
        }
        for (i = jsonValorExtraArray.length - 1; i >= 0; i--) {
            if (beneficioExtra !== "") {
                if ((jsonValorExtraArray[i].beneficioExtra === beneficioExtra) && (jsonValorExtraArray[i].sequencialValorExtra !== sequencial)) {
                    achouValorExtra = true;
                    break;
                }
            }
        }

        if (achouValorExtra === true) {
            smartAlert("Erro", "Já existe o Benefício na lista.", "error");
            return false;
        }

        return true;
    }


    function diferencaDatas(data1, data2, tipo = 'D') {
        switch (tipo.toUpperCase()) {
            case 'D':
                return moment(data2, 'DD/MM/YYYY').diff(moment(data1, 'DD/MM/YYYY'), 'days')
            case 'M':
                return moment(data1, 'DD/MM/YYYY').diff(moment(data2, 'DD/MM/YYYY'), 'months')
            case 'A':
                return moment(data1, 'DD/MM/YYYY').diff(moment(data2, 'DD/MM/YYYY'), 'years')
            default:
                return null;
        }
    }

 
</script>