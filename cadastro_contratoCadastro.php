<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('CONTRATO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CONTRATO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CONTRATO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Contrato";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['cadastro']['sub']['contrato']['active'] = true;
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
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Projeto</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formContrato" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="collapsed" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados do Cliente
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
                                                                    <select id="projeto" name="projeto" class="required">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, numeroCentroCusto, descricao, apelido FROM Ntl.projeto where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            $numeroCentroCusto  = ($row['numeroCentroCusto']);
                                                                            $apelido = ($row['apelido']);
                                                                            echo '<option value=' . $codigo . '>  ' . $apelido . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">CNPJ</label>
                                                                <label class="input">
                                                                    <input id="cnpj" name="cnpj" type="text" autocomplete="off" maxlength="100" readonly class="readonly">

                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Número do Pregão</label>
                                                                <label class="input">
                                                                    <input id="numeroPregao" name="numeroPregao" type="text" autocomplete="off" maxlength="100" class="required">

                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Razão Social</label>
                                                                <label class="input">
                                                                    <input id="razaoSocial" name="razaoSocial" type="text" autocomplete="off" maxlength="100" readonly class="readonly">

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

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CEP</label>
                                                                <label class="input">
                                                                    <input id="cep" name="cep" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Número</label>
                                                                <label class="input">
                                                                    <input id="numero" name="numero" type="text" readonly class="readonly" autocomplete="off" maxlength="100">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" type="text" readonly class="readonly" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" name="bairro" type="text" autocomplete="off" readonly class="readonly" maxlength="100">

                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" name="cidade" type="text" autocomplete="off" readonly class="readonly" maxlength="100">

                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">UF</label>
                                                                <label class="input">
                                                                    <input id="uf" name="uf" type="text" autocomplete="off" readonly class="readonly" cmaxlength="100">

                                                                </label>
                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDadosContrato" class="collapsed" id="accordionDadosContrato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados do Contrato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDadosContrato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Número do Contrato</label>
                                                                <label class="input">
                                                                    <input id="numeroContrato" name="numeroContrato" type="text" autocomplete="off" class="">

                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="contaVinculada">Conta Vinculada</label>
                                                                <label class="select">
                                                                    <select id="contaVinculada" name="contaVinculada" class="">
                                                                        <option></option>
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="input">
                                                                    <input class="hidden">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" for="caucaoAtivo">Caução</label>
                                                                <label class="select">
                                                                    <select id="caucaoAtivo" name="caucaoAtivo" class="">
                                                                        <option></option>
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="input">
                                                                    <input class="hidden">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Tipo de Caução</label>
                                                                <label class="select">
                                                                    <select id="caucao" name="caucao" class="form-control">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.caucao  where ativo = 1  order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>


                                                            <section class="col col-2">
                                                                <label class="label">% Caução</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="percentualCaucao" name="percentualCaucao" style="text-align: right;" type="text" autocomplete="off">

                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Data da Assinatura</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataAssinatura" name="dataAssinatura" autocomplete="off" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="-" data-dateformat="dd/mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data do Início</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataInicio" name="dataInicio" autocomplete="off" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="-" data-dateformat="dd/mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Vigência (Em meses)</label>
                                                                <label class="input">
                                                                    <input id="vigencia" name="vigencia" type="number" autocomplete="off" maxlength="100">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="input">
                                                                    <input class="hidden">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">

                                                                <label class="label" for="renovacao">Data de Renovação</label>
                                                                <label class="select">
                                                                    <select id="renovacao" name="renovacao" class="">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <option value="1">Assinatura do Contrato</option>
                                                                        <option value="0">Início do Contrato</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Lucratividade da Proposta</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="lucratividade" name="lucratividade" style="text-align: right;" type="text" autocomplete="off" maxlength="100">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Outros</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input id="outros" name="outros" style="text-align: right;" type="text" autocomplete="off" maxlength="100">

                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Valor Inicial</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" style="text-align: right;" id="valorInicial" name="valorInicial" class="decimal-2-casas" />
                                                                </label>
                                                            </section>


                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Valor Atual</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" style="text-align: right;" id="valorAtual" name="valorAtual" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Objeto do Contrato</label>
                                                                <textarea maxlength="500" id="objetoContrato" name="objetoContrato" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>


                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContaVinculada" class="collapsed" id="accordionContaVinculada">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados Retenção Conta Vinculada
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContaVinculada" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Vinc. 13º Salário</label>
                                                                <label class="select">
                                                                    <select id="decimoTerceiro" name="decimoTerceiro" class="form-control">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, percentual FROM Ntl.decimoTerceiro  where ativo = 1  order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $percentual = (float) $row['percentual'];
                                                                            echo '<option value=' . $codigo . '>  ' . $percentual . "%" . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1"></section>

                                                            <section class="col col-2">
                                                                <label class="label">Vinc. Férias e Terço Constitucional</label>
                                                                <label class="select">
                                                                    <select id="ferias" name="ferias" class="form-control">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, percentual FROM Ntl.feriasTercoConstitucional  where ativo = 1  order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $percentual = (float) $row['percentual'];
                                                                            echo '<option value=' . $codigo . '>  ' . $percentual . "%" . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1"></section>

                                                            <section class="col col-2">
                                                                <label class="label">Vinc. Multa FGTS por Dispensa sem Justa Causa</label>
                                                                <label class="select">
                                                                    <select id="multaFGTS" name="multaFGTS" class="form-control">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, percentual FROM Ntl.multaFGTS  where ativo = 1  order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $percentual = (float) $row['percentual'];
                                                                            echo '<option value=' . $codigo . '>  ' . $percentual . "%" . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseRenovacaoContrato" class="collapsed" id="accordionRenovacaoContrato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados da Renovação do Contrato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseRenovacaoContrato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Data da Renovação</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataRenovacao" name="dataRenovacao" autocomplete="off" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="-" data-dateformat="dd/mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Período Renovado (Meses)</label>
                                                                <label class="input">
                                                                    <input id="periodoRenovado" name="periodoRenovado" type="number" autocomplete="off" maxlength="100">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="input">
                                                                    <input class="hidden">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" for="ultimaRenovacao">Última Renovação</label>
                                                                <label class="select">
                                                                    <select id="ultimaRenovacao" name="ultimaRenovacao" class="">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0" selected>Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Período Limite p/ Envio do Interesse</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="limiteInteresse" name="limiteInteresse" autocomplete="off" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="-" data-dateformat="dd/mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Envio do Interesse</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="envioInteresse" name="envioInteresse" autocomplete="off" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="-" data-dateformat="dd/mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Anotações</label>
                                                                <textarea maxlength="500" id="anotacoesRenovacao" name="anotacoesRenovacao" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFaturamento" class="collapsed" id="accordionFaturamento">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados do Faturamento
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFaturamento" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="JsonFaturamento" name="JsonFaturamento" type="hidden" value="[]">
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Tipo de Faturamento</label>
                                                                <label class="input">
                                                                    <input id="tipoFaturamento" name="tipoFaturamento" autocomplete="off" type="text">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Prazo de Pagamento</label>
                                                                <label class="input">
                                                                    <input id="prazoPagamento" name="prazoPagamento" type="text" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Condições p/ Prazo de Pagamento</label>
                                                                <label class="input">
                                                                    <input id="condicoesPrazo" name="condicoesPrazo" type="text" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-md-3">
                                                                <label class="label"> </label>
                                                                <button id="btnAddFaturar" type="button" class="btn btn-primary">
                                                                    <i class="">Recupera Cliente</i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend> </legend>
                                                            </section>
                                                        </div>
                                                        <div id="formFaturamento" name="formFaturamento" class="col-sm-12">
                                                            <input id="faturamentoId" name="faturamentoId" type="hidden" value="">
                                                            <input id="sequencialFaturamento" name="sequencialFaturamento" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label">Localização</label>
                                                                        <label class="select">
                                                                            <select id="localizacao" name="localizacao" class="form-control">
                                                                                <option style="display:none;" value="">Selecione</option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, descricao FROM Ntl.localizacao  where ativo = 1  order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $row = array_map('mb_strtoupper', $row);
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricao = ($row['descricao']);
                                                                                    echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">CEP</label>
                                                                        <label class="input">
                                                                            <input id="cepFaturamento" name="cepFaturamento" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-3">
                                                                        <label class="label">Logradouro</label>
                                                                        <label class="input">
                                                                            <input id="logradouroFaturamento" name="logradouroFaturamento" type="text" autocomplete="off" maxlength="100">

                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">Número</label>
                                                                        <label class="input">
                                                                            <input id="numeroFaturamento" name="numeroFaturamento" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-3">
                                                                        <label class="label">Complemento</label>
                                                                        <label class="input">
                                                                            <input id="complementoFaturamento" name="complementoFaturamento" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Bairro</label>
                                                                        <label class="input">
                                                                            <input id="bairroFaturamento" name="bairroFaturamento" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Cidade</label>
                                                                        <label class="input">
                                                                            <input id="cidadeFaturamento" name="cidadeFaturamento" type="text" class="form-control" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">UF</label>
                                                                        <label class="input">
                                                                            <input id="ufFaturamento" name="ufFaturamento" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label">Ret. ISS</label>
                                                                        <label class="select">
                                                                            <select id="iss" name="iss" class="form-control">
                                                                                <option style="display:none;" value="">Selecione</option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, percentual FROM Ntl.iss  where ativo = 1  order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $row = array_map('mb_strtoupper', $row);
                                                                                    $codigo = $row['codigo'];
                                                                                    $percentual = (float) $row['percentual'];
                                                                                    echo '<option value=' . $codigo . '>  ' . $percentual . "%" . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Ret. INSS</label>
                                                                        <label class="select">
                                                                            <select id="inss" name="inss" class="form-control">
                                                                                <option style="display:none;"value="">Selecione</option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, percentual FROM Ntl.inss  where ativo = 1  order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $row = array_map('mb_strtoupper', $row);
                                                                                    $codigo = $row['codigo'];
                                                                                    $percentual = (float) $row['percentual'];
                                                                                    echo '<option value=' . $codigo . '>  ' . $percentual . "%" . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Ret. IR</label>
                                                                        <label class="select">
                                                                            <select id="ir" name="ir" class="form-control">
                                                                                <option style="display:none;"value="">Selecione</option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, percentual FROM Ntl.ir  where ativo = 1  order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $row = array_map('mb_strtoupper', $row);
                                                                                    $codigo = $row['codigo'];
                                                                                    $percentual = (float) $row['percentual'];
                                                                                    echo '<option value=' . $codigo . '>  ' . $percentual . "%" . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Ret. PIS,CONFIS,CS</label>
                                                                        <label class="select">
                                                                            <select id="pisConfisCs" name="pisConfisCs" class="form-control">
                                                                                <option style="display:none;"value="">Selecione</option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, percentual FROM Ntl.pisConfisCs  where ativo = 1  order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $row = array_map('mb_strtoupper', $row);
                                                                                    $codigo = $row['codigo'];
                                                                                    $percentual = (float) $row['percentual'];
                                                                                    echo '<option value=' . $codigo . '>  ' . $percentual . "%" . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label">Código de Serviço</label>
                                                                        <label class="select">
                                                                            <select id="codigoServico" name="codigoServico" class="form-control">
                                                                                <option style="display:none;"value="">Selecione</option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, descricaoCodigo, descricaoServico FROM Ntl.servico  where ativo = 1  order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $row = array_map('mb_strtoupper', $row);
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricaoCodigo = ($row['descricaoCodigo']);
                                                                                    echo '<option value=' . $codigo . '>  ' . $descricaoCodigo . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-6">
                                                                        <label class="label">Descrição do Serviço</label>
                                                                        <label class="select">
                                                                            <select id="descricaoServico" name="descricaoServico" class="form-control">
                                                                                <option></option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, descricaoServico FROM Ntl.servico  where ativo = 1  order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $row = array_map('mb_strtoupper', $row);
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricaoServico = ($row['descricaoServico']);
                                                                                    echo '<option value=' . $codigo . '>  ' . $descricaoServico . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Alíquota de ISS</label>
                                                                        <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                            <input id="aliquotaIss" name="aliquotaIss" style="text-align: right;" type="text" autocomplete="off" maxlength="100">

                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-4">
                                                                        <label class="label"> </label>
                                                                        <button id="btnAddFaturamento" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverFaturamento" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableFaturamento" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 500%;">Localização</th>
                                                                            <th class="text-left">Cidade</th>
                                                                            <th class="text-left">Código de Serviço</th>
                                                                            <th class="text-left">Descrição do Serviço</th>
                                                                            <th class="text-left">Alíquota de ISS</th>
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
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDadosReajuste" class="collapsed" id="accordionDadosReajuste">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados do Reajuste
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDadosReajuste" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Índice de Reajuste</label>
                                                                <label class="select">
                                                                    <select id="indiceReajuste" name="indiceReajuste" class="form-control">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.indiceReajuste  where ativo = 1  order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data do Início</label>
                                                                <label class="select">
                                                                    <select id="inicioReajuste" name="inicioReajuste" class="form-control">
                                                                        <option style="display:none;">Selecione</option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.inicioReajuste  where ativo = 1  order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Período p/ Envio da Comunicação</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoComunicacao" name="periodoComunicacao" autocomplete="off" class="datepicker" data-mask="99/9999" data-mask-placeholder="-" data-dateformat="mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1"></section>
                                                            <section class="col col-2">
                                                                <label class="label"> Envio da Comunicação</label>

                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="envioComunicacao" name="envioComunicacao" autocomplete="off" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="-" data-dateformat="dd/mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Anotações</label>
                                                                <textarea maxlength="500" id="anotacoesComunicacao" name="anotacoesComunicacao" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCapacidadeTecnica" class="collapsed" id="accordionCapacidadeTecnica">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados do Atestado de Capacidade Técnica
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCapacidadeTecnica" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Período p/ Envio da Solicitação</label>
                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoSolicitacao" name="periodoSolicitacao" autocomplete="off" class="datepicker" data-mask="99/9999" data-mask-placeholder="-" data-dateformat="mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label"> Envio da Solicitação</label>

                                                                <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input id="envioSolicitacao" name="envioSolicitacao" autocomplete="off" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="-" data-dateformat="dd/mm/yy" type="text">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Anotações</label>
                                                                <textarea maxlength="500" id="anotacoesSolicitacao" name="anotacoesSolicitacao" class="form-control" rows="3" style="resize:vertical"></textarea>
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

                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo">
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroContrato.js" type="text/javascript"></script>

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
<script src="<?php echo ASSETS_URL; ?>/js/gir_script.js" type="text/javascript"></script>
<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>


<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->

<!-- Validador de CNPJ -->
<script src="js/plugin/cpfcnpj/jquery.cpfcnpj.js"></script>

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>



<script language="JavaScript" type="text/javascript">
    var jsonFaturamentoArray = [];
    $(document).ready(function() {

        $('#cnpj').mask('99.999.999/9999-99', {
            placeholder: 'X'
        });
        $('#percentualCaucao').focusout(function() {
            var percentualCaucao, element;
            element = $(this);
            element.unmask();
            percentualCaucao = element.val().replace(/\D/g, '');
            if (percentualCaucao.length > 3) {
                element.mask("99.99?9");
            } else {
                element.mask("9.99?9");
            }
        }).trigger('focusout');

        $('#lucratividade').focusout(function() {
            var lucratividade, element;
            element = $(this);
            element.unmask();
            lucratividade = element.val().replace(/\D/g, '');
            if (lucratividade.length > 3) {
                element.mask("99.99?9");
            } else {
                element.mask("9.99?9");
            }
        }).trigger('focusout');

        $('#outros').focusout(function() {
            var outros, element;
            element = $(this);
            element.unmask();
            outros = element.val().replace(/\D/g, '');
            if (outros.length > 3) {
                element.mask("99.99?9");
            } else {
                element.mask("9.99?9");
            }
        }).trigger('focusout');

        $('#aliquotaIss').focusout(function() {
            var aliquotaIss, element;
            element = $(this);
            element.unmask();
            aliquotaIss = element.val().replace(/\D/g, '');
            if (aliquotaIss.length > 3) {
                element.mask("99.99?9");
            } else {
                element.mask("9.99?9");
            }
        }).trigger('focusout');

        $("#cep").mask("99999-999", {
            placeholder: 'X'
        });
        $("#cepFaturamento").mask("99999-999", {
            placeholder: 'X'
        });
        $("#btnAddFaturar").on("click", function() {
            $("#cepFaturamento").val($("#cep").val())
            $("#logradouroFaturamento").val($("#logradouro").val())
            $("#numeroFaturamento").val($("#numero").val())
            $("#complementoFaturamento").val($("#complemento").val())
            $("#bairroFaturamento").val($("#bairro").val())
            $("#cidadeFaturamento").val($("#cidade").val())
            $("#ufFaturamento").val($("#uf").val())
        });

        $("#btnGravar").on("click", function() {
            gravar();
        });
        $("#btnBuscar").on("click", function() {
            buscar();
        });

        $("#btnExcluir").on("click", function() {
            excluir();
        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#btnNovo").on("click", function() {
            novo();
        });
        $('#btnAddFaturamento').on("click", function() {
            if(validaFaturamento()){
                addFaturamento();
            }
        });
        $('#btnRemoverFaturamento').on("click", function() {
            excluirFaturamento();
        });
        fillTableFaturamento();


        $("#cepFaturamento").on("change", function() {
            var cep = $("#cepFaturamento").val().replace(/\D/g, '');
            buscaCep(cep);
        });


        $("#codigoServico").on("change", function() {
            var codigoServico = $("#codigoServico").val();
            $("#descricaoServico").val(codigoServico);

        });
        $("#projeto").on("change", function() {
            preencherProjeto();
        });

        $("#renovacao").on("change", function() {
            var renovacao = $("#renovacao").val()
            if (renovacao == 1) {
                preencheAssinatura();
            } else {
                preencheInicio();
            }
        });

        $("#periodoRenovado").on("change", function() {
            preenchePeriodoRenovado();
        });

        $("#numeroPregao").on("change", function() {
            preencherPregao();
        });

        $('.valorInicial').mask('#.##9,99', {
            reverse: true
        });

        $("#numeroPregao").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroContrato.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaNumeroPregaoAutoComplete",
                        descricaoIniciaCom: request.term,
                        seguradora: 0,
                        ativo: 0
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.numeroPregao,
                                value: item.numeroPregao
                            };
                        }));
                    }
                });
            },
            minLength: 1,
            select: function(event, ui) {
                $("#numeroPregaoID").val(+ui.item.id);
                $("#numeroPregao").val(ui.item.numeroPregao);
            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#numeroPregaoID").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };




        $(function() {
            $("#cep").on("change", function() {

                var cepR = $("#cep").val().replace(/\D/g, '');
                if (cepR != "") {
                    var validacepR = /^[0-9]{8}$/;
                    if (validacepR.test(cepR)) {

                        $.getJSON("//viacep.com.br/ws/" + cepR + "/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {

                                $("#logradouro").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                            } else {
                                smartAlert("Erro", "CEP não encontrado.", "error");
                            }
                        });
                    } else {
                        smartAlert("Erro", "Formato do CEP inválido.", "error");
                    }
                }
            });
        });

        carregaPagina();
    });

    function clearFormFaturamento() {
        $("#faturamentoId,#sequencialFaturamento,#cepFaturamento,#logradouroFaturamento,#numeroFaturamento,#complementoFaturamento," +
            "#bairroFaturamento,#cidadeFaturamento,#ufFaturamento,#descricaoServico,#aliquotaIss").val('');
        $("#localizacao,#iss,#inss,#ir,#pisConfisCs,#codigoServico").val('Selecione');

    }

    function fillTableFaturamento() {
        $("#tableFaturamento tbody").empty();
        if (typeof(jsonFaturamentoArray) != 'undefined') {
            for (var i = 0; i < jsonFaturamentoArray.length; i++) {
                var row = $('<tr />');
                $("#tableFaturamento tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonFaturamentoArray[i].sequencialFaturamento + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaFaturamento(' + jsonFaturamentoArray[i].sequencialFaturamento + ');">' + jsonFaturamentoArray[i].localizacaoText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonFaturamentoArray[i].sequencialFaturamento + ');">' + jsonFaturamentoArray[i].cidadeFaturamento + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonFaturamentoArray[i].sequencialFaturamento + ');">' + jsonFaturamentoArray[i].codigoServicoText + '</td>'));
                row.append($('<td class="" (' + jsonFaturamentoArray[i].sequencialFaturamento + ');">' + jsonFaturamentoArray[i].descricaoServicoText + '</td>'));
                row.append($('<td class="text-nowrap" (' + jsonFaturamentoArray[i].sequencialFaturamento + ');">' + jsonFaturamentoArray[i].aliquotaIss + "%" + '</td>'));

            }
            clearFormFaturamento();
        }
    }

    function validaFaturamento() {
        var existe = false;
        var achou = false;
        var localizacao = $('#localizacao').val();
        var cep = $("#cepFaturamento").val();
        var logradouro = $('#logradouroFaturamento').val();
        var numero = $('#numeroFaturamento').val();
        var complemento = $('#complementoFaturamento').val();
        var bairro = $('#bairroFaturamento').val();
        var cidade = $('#cidadeFaturamento').val();
        var uf = $('#ufFaturamento').val();
        var iss = $('#iss').val();
        var inss = $('#inss').val();
        var ir = $('#ir').val();
        var pisConfisCs = $('#pisConfisCs').val();
        var codigoServico = $('#codigoServico').val();
        var descricao = $('#descricaoServico').val();
        var aliquotaIss = $('#aliquotaIss').val();

        var sequencial = +$('#sequencialFaturamento').val();
        var correspondenciaMarcado = 1;

        if (!localizacao) {
            smartAlert("Erro", "Informe a Localização.", "error");
            return false;
        }

        if (!logradouro) {
            smartAlert("Erro", "Informe o Logradouro.", "error");
            return false;
        }

        if (!cep) {
            smartAlert("Erro", "Informe o CEP.", "error");
            return false;
        }

        if (!numero) {
            smartAlert("Erro", "Informe o Numero.", "error");
            return false;
        }

        if (!complemento) {
            smartAlert("Erro", "Informe o Complemento.", "error");
            return false;
        }

        if (!bairro) {
            smartAlert("Erro", "Informe o Bairro.", "error");
            return false;
        }

        if (!cidade) {
            smartAlert("Erro", "Informe a Cidade.", "error");
            return false;
        }

        if (!uf) {
            smartAlert("Erro", "Informe a Unidade Federativa.", "error");
            return false;
        }

        if (!iss) {
            smartAlert("Erro", "Informe o ISS.", "error");
            return false;
        }

        if (!inss) {
            smartAlert("Erro", "Informe o INSS.", "error");
            return false;
        }

        if (!ir) {
            smartAlert("Erro", "Informe o IR.", "error");
            return false;
        }

        if (!pisConfisCs) {
            smartAlert("Erro", "Informe o PisConfisCis.", "error");
            return false;
        }

        if (!codigoServico) {
            smartAlert("Erro", "Informe o Codigo Serviço.", "error");
            return false;
        }

        if (!descricao) {
            smartAlert("Erro", "Informe a Descrição.", "error");
            return false;
        }

        if (!aliquotaIss) {
            smartAlert("Erro", "Informe a aliquota Iss.", "error");
            return false;
        }

       
        for (i = jsonFaturamentoArray.length - 1; i >= 0; i--) {
            if (correspondenciaMarcado === 1) {
                if ((jsonFaturamentoArray[i].correspondencia == 1) && (jsonFaturamentoArray[i].sequencialFaturamento !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (!localizacao) {
                if ((jsonFaturamentoArray[i].logradouro === localizacao) && (jsonFaturamentoArray[i].sequencialFaturamento !== sequencial)) {
                    existe = true;
                    break;
                }
            }

        }
        if (existe === true) {
            smartAlert("Erro", "Faturamento já cadastrado.", "error");
            return false;
        }
        if ((achou === true) && (correspondenciaMarcado === 1)) {
            smartAlert("Erro", "Você já marcou pra receber Correspondencia.", "error");
            return false;
        }
        return true;
    }

    function processDataFaturamento(node) {

        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';
        var value;

        if (fieldName !== '' && (fieldId === "localizacao")) {
            var valorTel = $("#localizacao").val().trim();
            if (valorTel !== '') {
                fieldName = "localizacao";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }

        return false;
    }

    function addFaturamento() {
        var item = $("#formFaturamento").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataFaturamento
        });

        if (!item["sequencialFaturamento"]) {
            if (jsonFaturamentoArray.length === 0) {
                item["sequencialFaturamento"] = 1;
            } else {
                item["sequencialFaturamento"] = Math.max.apply(Math, jsonFaturamentoArray.map(function(o) {
                    return o.sequencialTel;
                })) + 1;
            }
            item["faturamentoId"] = 0;
        } else {
            item["sequencialFaturamento"] = +item["sequencialFaturamento"];
        }


        item.localizacaoText = $('#localizacao option:selected').text().trim();
        item.descricaoServicoText = $('#descricaoServico option:selected').text().trim();
        item.codigoServicoText = $('#codigoServico option:selected').text().trim();

        var index = -1;
        $.each(jsonFaturamentoArray, function(i, obj) {
            if (parseInt($('#sequencialFaturamento').val()) === obj.sequencialFaturamento) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonFaturamentoArray.splice(index, 1, item);
        else
            jsonFaturamentoArray.push(item);

        $("#JsonFaturamento").val(JSON.stringify(jsonFaturamentoArray));
        fillTableFaturamento();
        clearFormFaturamento();
    }

    function excluirFaturamento() {
        var arrSequencial = [];
        $('#tableFaturamento input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonFaturamentoArray.length - 1; i >= 0; i--) {
                var obj = jsonFaturamentoArray[i];
                if (jQuery.inArray(obj.sequencialFaturamento, arrSequencial) > -1) {
                    jsonFaturamentoArray.splice(i, 1);
                }
            }
            $("#JsonFaturamento").val(JSON.stringify(jsonFaturamentoArray));
            fillTableFaturamento();
        } else {
            smartAlert("Erro", "Selecione pelo menos um faturamento para excluir.", "error");
        }
    }

    function carregaFaturamento(sequencialFaturamento) {
        var arr = jQuery.grep(jsonFaturamentoArray, function(item, i) {
            return (item.sequencialFaturamento === sequencialFaturamento);
        });

        clearFormFaturamento();

        if (arr.length > 0) {
            var item = arr[0];
            $("#faturamentoId").val(item.faturamentoId);
            $("#localizacao").val(item.localizacao);
            $("#cepFaturamento").val(item.cepFaturamento);
            $("#logradouroFaturamento").val(item.logradouroFaturamento);
            $("#numeroFaturamento").val(item.numeroFaturamento);
            $("#complementoFaturamento").val(item.complementoFaturamento);
            $("#bairroFaturamento").val(item.bairroFaturamento);
            $("#cidadeFaturamento").val(item.cidadeFaturamento);
            $("#ufFaturamento").val(item.ufFaturamento);
            $("#iss").val(item.iss);
            $("#inss").val(item.inss);
            $("#ir").val(item.ir);
            $("#pisConfisCs").val(item.pisConfisCs);
            $("#codigoServico").val(item.codigoServico);
            $("#descricaoServico").val(item.descricaoServico);
            $("#sequencialFaturamento").val(item.sequencialFaturamento);
            $("#aliquotaIss").val(item.aliquotaIss);


        }
    }

    function preencheInicio() {

        var dataInicio = $("#dataInicio").val();
        var renovacao = $("#renovacao").val();

        if (renovacao != 1 && dataInicio === "") {
            smartAlert("Atenção", "Escolha uma Data de Inicio!", "error");
            return;

        } else {
            var vigencia = $("#vigencia").val();
            dataFim = moment(dataInicio, "DD-MM-YYYY").add((vigencia || 1), 'months')
            dataFim = dataFim.format("DD/MM/YYYY");
            $("#dataRenovacao").val(dataFim);

            dataFimLimite = moment(dataInicio, "DD-MM-YYYY").add((vigencia || 1) - 3, 'months')
            dataFimLimite = dataFimLimite.format("DD/MM/YYYY");
            $("#limiteInteresse").val(dataFimLimite);

        }
    }

    function preencheAssinatura() {


        var dataAssinatura = $("#dataAssinatura").val();
        var renovacao = $("#renovacao").val();

        if (renovacao != 1 && dataAssinatura === "") {
            smartAlert("Atenção", "Escolha uma Data de Assinatura!", "error");
            return;

        } else {
            var vigencia = $("#vigencia").val();
            dataFim = moment(dataAssinatura, "DD-MM-YYYY").add((vigencia || 1), 'months')
            dataFim = dataFim.format("DD/MM/YYYY");
            $("#dataRenovacao").val(dataFim);

            dataFimLimite = moment(dataAssinatura, "DD-MM-YYYY").add((vigencia || 1) - 3, 'months')
            dataFimLimite = dataFimLimite.format("DD/MM/YYYY");
            $("#limiteInteresse").val(dataFimLimite);
        }

    }

    function preenchePeriodoRenovado() {
        var periodoRenovado = $("#periodoRenovado").val();
        var dataRenovacao = $("#dataRenovacao").val();
        var limiteInteresse = $("#limiteInteresse").val();

        dataFim = moment(dataRenovacao, "DD-MM-YYYY").add((periodoRenovado || 1), 'months')
        dataFim = dataFim.format("DD/MM/YYYY");
        $("#dataRenovacao").val(dataFim);

        dataFimLimite = moment(dataRenovacao, "DD-MM-YYYY").add((periodoRenovado || 1) - 3, 'months')
        dataFimLimite = dataFimLimite.format("DD/MM/YYYY");
        $("#limiteInteresse").val(dataFimLimite);

    }

    function preencherProjeto() {
        //Dados 
        var projeto = +$("#projeto").val();
        if (projeto !== "") {
            preencheProjeto(projeto,
                function(data) {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");

                    //Atributos de Contrato
                    var mensagem = piece[0];
                    var out = piece[1];


                    piece = out.split("^");
                    console.table(piece);
                    //Atributos de cliente 

                    var cnpj = piece[0];
                    var razaoSocial = piece[1];
                    var cep = piece[2];
                    var logradouro = piece[3];
                    var numero = piece[4];
                    var complemento = piece[5];
                    var bairro = piece[6];
                    var cidade = piece[7];
                    var uf = piece[8];

                    $("#cnpj").val(cnpj);
                    $("#razaoSocial").val(razaoSocial);
                    $("#cep").val(cep);
                    $("#logradouro").val(logradouro);
                    $("#numero").val(numero);
                    $("#complemento").val(complemento);
                    $("#bairro").val(bairro);
                    $("#cidade").val(cidade);
                    $("#uf").val(uf);

                }
            );
        }
    }

    function preencherPregao() {
        //Dados 
        var numeroPregao = $("#numeroPregao").val();
        if (numeroPregao !== "") {

            preenchePregao(numeroPregao,
                function(data) {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");

                    //Atributos de Contrato
                    var mensagem = piece[0];
                    var out = piece[1];

                    piece = out.split("^");
                    console.table(piece);
                    //Atributos de cliente 

                    var objetoContrato = piece[0];

                    $("#objetoContrato").val(objetoContrato);
                }
            );
        }
    }

    function buscaCep(cep) {
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {

                        $("#logradouroFaturamento").val(dados.logradouro);
                        $("#bairroFaturamento").val(dados.bairro);
                        $("#cidadeFaturamento").val(dados.localidade);
                        $("#ufFaturamento").val(dados.uf);
                    } else {

                        smartAlert("Erro", "CEP não encontrado.", "error");
                    }
                });
            } else {
                smartAlert("Erro", "Formato do CEP inválido.", "error");
            }
        }
    }

    function voltar() {
        $(location).attr('href', 'cadastro_contratoFiltro.php');
    }


    function gravar() {
        var projeto = $("#projeto").val();
        var numeroPregao = $("#numeroPregao").val();

        // $("#btnGravar").prop('disabled', true);

        if (projeto == 'Selecione' || projeto == '') {
            smartAlert("Erro", "Digite o projeto.", "error");
            $("#btnGravar").prop('disabled', false);

            return;
        }
        if (!numeroPregao) {
            smartAlert("Erro", "Digite o número do pregão.", "error");
            $("#btnGravar").prop('disabled', false);

            return;
        }


        $("#ativo").val(1);

        let contrato = $('#formContrato').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        gravaContrato(contrato,
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

    function novo() {
        $(location).attr('href', 'cadastro_contratoCadastro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirContrato(id, function(data) {
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
                recuperaContrato(idd,
                    function(data) {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");

                        //Atributos de Contrato
                        var mensagem = piece[0];
                        var out = piece[1];

                        var strArrayFaturamento = piece[2];

                        piece = out.split("^");
                        console.table(piece);
                        //Atributos de cliente 
                        var codigo = +piece[0];
                        var ativo = piece[1];
                        var projeto = piece[2];
                        var numeroPregao = piece[3];
                        var numeroContrato = piece[4];
                        var contaVinculada = piece[5];
                        var caucaoAtivo = piece[6];
                        var caucao = piece[7];
                        var percentualCaucao = piece[8];
                        var dataAssinatura = piece[9];
                        var dataInicio = piece[10];
                        var renovacao = piece[11];
                        var vigencia = piece[12];
                        var lucratividade = piece[13];
                        var outros = piece[14];
                        var valorInicial = piece[15];
                        var valorAtual = piece[16];
                        var objetoContrato = piece[17];
                        var decimoTerceiro = piece[18];
                        var ferias = piece[19];
                        var multaFGTS = piece[20];
                        var dataRenovacao = piece[21];
                        var ultimaRenovacao = piece[22];
                        var periodoRenovado = piece[23];
                        var limiteInteresse = piece[24];
                        var envioInteresse = piece[25];
                        var anotacoesRenovacao = piece[26];
                        var tipoFaturamento = piece[27];
                        var prazoPagamento = piece[28];
                        var condicoesPrazo = piece[29];
                        var indiceReajuste = piece[30];
                        var inicioReajuste = piece[31];
                        var periodoComunicacao = piece[32];
                        var envioComunicacao = piece[33];
                        var anotacoesComunicacao = piece[34];
                        var periodoSolicitacao = piece[35];
                        var envioSolicitacao = piece[36];
                        var anotacoesSolicitacao = piece[37];



                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#ativo").val(ativo);
                        $("#projeto").val(projeto);
                        $("#numeroPregao").val(numeroPregao);
                        $("#numeroContrato").val(numeroContrato);
                        $("#contaVinculada").val(contaVinculada);
                        $("#caucaoAtivo").val(caucaoAtivo);
                        $("#caucao").val(caucao);
                        $("#percentualCaucao").val(percentualCaucao);
                        $("#dataAssinatura").val(dataAssinatura);
                        $("#dataInicio").val(dataInicio);
                        $("#renovacao").val(renovacao);
                        $("#vigencia").val(vigencia);
                        $("#lucratividade").val(lucratividade);
                        $("#outros").val(outros);
                        $("#valorInicial").val(valorInicial);
                        $("#valorAtual").val(valorAtual);
                        $("#objetoContrato").val(objetoContrato);
                        $("#decimoTerceiro").val(decimoTerceiro);
                        $("#multaFGTS").val(multaFGTS);
                        $("#ferias").val(ferias);
                        $("#dataRenovacao").val(dataRenovacao);
                        $("#ultimaRenovacao").val(ultimaRenovacao);
                        $("#periodoRenovado").val(periodoRenovado);
                        $("#limiteInteresse").val(limiteInteresse);
                        $("#envioInteresse").val(envioInteresse);
                        $("#anotacoesRenovacao").val(anotacoesRenovacao);
                        $("#tipoFaturamento").val(tipoFaturamento);
                        $("#prazoPagamento").val(prazoPagamento);
                        $("#condicoesPrazo").val(condicoesPrazo);
                        $("#indiceReajuste").val(indiceReajuste);
                        $("#inicioReajuste").val(inicioReajuste);
                        $("#periodoComunicacao").val(periodoComunicacao);
                        $("#envioComunicacao").val(envioComunicacao);
                        $("#anotacoesComunicacao").val(anotacoesComunicacao);
                        $("#periodoSolicitacao").val(periodoSolicitacao);
                        $("#envioSolicitacao").val(envioSolicitacao);
                        $("#anotacoesSolicitacao").val(anotacoesSolicitacao);

                        $("#JsonFaturamento").val(strArrayFaturamento);
                        jsonFaturamentoArray = JSON.parse($("#JsonFaturamento").val());
                        preencherProjeto()
                        fillTableFaturamento();
                    }
                );
            }
        }
    }

</script>