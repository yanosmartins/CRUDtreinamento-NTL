<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PROJETO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PROJETO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('PROJETO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Projeto";
include("populaTabela/popula.php");
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["projeto"]["active"] = true;

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
                                <form class="smart-form client-form" id="formProjeto" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseRegistraFerias" class="" id="accordionRegistraFerias">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Projeto
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseRegistraFerias" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <div class="row">
                                                        
                                                               
                                                                <label class="hidden">
                                                                    <input id="codigo" name="codigo" type="text" readonly class="readonly" />
                                                                </label>
                                                           
                                                            <section class="col col-2">
                                                                <label class="label">CNPJ</label>
                                                                <label class="input">
                                                                    <input id="cnpj" name="cnpj" autocomplete="off" placeholder="XX.XXX.XXX/XXXX-XX" type="text" class=" required">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">N° Centro de Custo</label>
                                                                <label class="input">
                                                                    <input id="numeroCentroCusto" maxlength="20" name="numeroCentroCusto" autocomplete="off" placeholder="" type="text" class="numeric">
                                                                </label>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label">Descrição</label>
                                                                <label class="input">
                                                                    <input id="descricao" maxlength="70" name="descricao" autocomplete="off" placeholder="Digite a descrição do projeto" type="text" class=" required">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            

                                                            <section class="col col-2">
                                                                <label class="label">Apelido</label>
                                                                <label class="input">
                                                                    <input id="apelido" maxlength="50" name="apelido" autocomplete="off" placeholder="Digite o apelido" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Data de Assinatura</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataAssinatura" name="dataAssinatura" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker required" value="" onchange="validaData(this)">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Data de Renovação</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataRenovacao" name="dataRenovacao" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker required" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label">Razão Social</label>
                                                                <label class="input">
                                                                    <input id="razaoSocial" maxlength="70" name="razaoSocial" autocomplete="off" placeholder="Digite a Razao Social" type="text" class=" required">
                                                                </label>
                                                            </section>

                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- seguro de vida  -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeguroVida" class="collapsed" id="accordionSeguroVida">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Seguro de Vida
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseSeguroVida" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="seguroVida">Seguro de
                                                                    vida</label>
                                                                <label class="select">
                                                                    <select id="seguroVida" name="seguroVida" class="required">
                                                                        <option value="" style="display:none;"></option>
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

                                        <!-- Plano de Saúde -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapsePlanoSaude" class="collapsed" id="accordionPlanoSaude">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Plano de Saúde
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapsePlanoSaude" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Desconto em Folha</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input type="text" maxlength="5" placeholder="0,00" id="descontoFolhaPlanoSaude" style="text-align: right;" name="descontoFolhaPlanoSaude" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor do Desconto</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDescontoFolhaPlanoSaude" name="valorDescontoFolhaPlanoSaude" style="text-align: right;" class="decimal-2-casas " />
                                                                </label>
                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- ENDEREÇO -->
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
                                                                <label class="label" for="tipoLogradouro">Tipo de
                                                                    Logradouro</label>
                                                                <label class="input">
                                                                    <input placeholder="" id="tipoLogradouro" name="tipoLogradouro" maxlength="15" autocomplete="off">
                                                                </label>
                                                            </section> -->
                                                            <section class="col col-5">
                                                                <label class="label" for="logradouro">Logradouro</label>
                                                                <label class="input">
                                                                    <input placeholder="" id="logradouro" name="logradouro" maxlength="100" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="numero">Número</label>
                                                                <label class="input">
                                                                    <input placeholder="" id="numero" name="numero" maxlength="20" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="complemento">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" maxlength="255" rows='3'></input>
                                                                </label>
                                                            </section>


                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-2">
                                                                <label class="label" for="estado">UF</label>
                                                                <label class="select">
                                                                    <select id="estado" name="estado" class="required">
                                                                        <?php
                                                                        echo populaUf();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label" for="bairro">Bairro</label>
                                                                <label class="input">
                                                                    <input placeholder="" id="bairro" name="bairro" maxlength="30" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label" for="cidade">Cidade</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input placeholder="" id="cidade" name="cidade" autocomplete="off" class="required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label " for="funcionario">Município considerar Férias </label>
                                                                <label class="select">
                                                                    <select id="municipioFerias" name="municipioFerias" class="required">
                                                                        <option value=""></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo,descricao 
                                                                                FROM Ntl.municipio 
                                                                                WHERE ativo = 1 ORDER BY descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $id = +$row['codigo'];
                                                                            $nome = $row['descricao'];
                                                                            echo '<option value=' . $id . '>' . $nome . '</option>';
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
                                                                            <input id="telefone" name="telefone" type="text" class="form-control" value="" maxlength="14">
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
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseValeAlimentacao" class="collapsed" id="accordionValeAlimentacao" disabled>
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        VR e VA
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseValeAlimentacao" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">

                                                    <fieldset>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Dias Úteis</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJaneiro" name="mesUtilJaneiro" autocomplete="off" class="readonly" type="text" value="Janeiro" readonly disabled>
                                                                </label>


                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJaneiroVA" name="diaUtilJaneiroVA">
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
                                                                    <input id="mesUtilFevereiroVA" name="mesUtilFevereiroVA" autocomplete="on" class="readonly" readonly type="text" value="Fevereiro" disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilFevereiroVA" name="diaUtilFevereiroVA">
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
                                                                    <input id="mesUtilMarcoVA" name="mesUtilMarcoVA" autocomplete="on" class="readonly" type="text" value="Março" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Dias</label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilMarcoVA" name="diaUtilMarcoVA">
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
                                                                    <input id="mesUtilAbrilVA" name="mesUtilAbrilVA" autocomplete="on" class="readonly" type="text" value="Abril" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilAbrilVA" name="diaUtilAbrilVA">
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
                                                                    <input readonly id="mesUtilMaioVA" name="mesUtilMaioVA" autocomplete="on" class="readonly" type="text" value="Maio" disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilMaioVA" name="diaUtilMaioVA">
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
                                                                    <input id="mesUtilJunhoVA" name="mesUtilJunhoVA" autocomplete="on" class="readonly" type="text" value="Junho" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJunhoVA" name="diaUtilJunhoVA">
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
                                                                    <input id="mesUtilJulhoVA" name="mesUtilJulhoVA" autocomplete="on" class="readonly" type="text" value="Julho" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilJulhoVA" name="diaUtilJulhoVA">
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
                                                                    <input id="mesUtilAgostoVA" name="mesUtilAgostoVA" autocomplete="on" class="readonly" type="text" value="Agosto" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilAgostoVA" name="diaUtilAgostoVA">
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
                                                                    <input id="mesUtilSetembroVA" name="mesUtilSetembroVA" autocomplete="on" class="readonly" type="text" value="Setembro" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilSetembroVA" name="diaUtilSetembroVA">
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
                                                                    <input id="mesUtilOutubroVA" name="mesUtilOutubroVA" autocomplete="on" class="readonly" type="text" value="Outubro" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilOutubroVA" name="diaUtilOutubroVA">
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
                                                                    <input id="mesUtilNovembroVA" name="mesUtilNovembroVA" autocomplete="on" class="readonly" type="text" value="Novembro" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilNovembroVA" name="diaUtilNovembroVA">
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
                                                                    <input id="mesUtilDezembroVA" name="mesUtilDezembroVA" autocomplete="on" class="readonly" type="text" value="Dezembro" readonly disabled>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label"> </label>
                                                                <label class="select"><i class="icon-append fa fa-bars"></i>
                                                                    <select id="diaUtilDezembroVA" name="diaUtilDezembroVA">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaDiaUtilMes();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Desconto em Folha</legend>
                                                            </section>
                                                        </div>

                                                        <!-- TITULO DE DESCONTA VALE ALIMENTAÇÃO -->

                                                        <div class="row">
                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="mes">Desconto Vale Alimentação</label>
                                                                <label class="select">
                                                                    <select id="descontoVA" name="descontoVA">
                                                                        <?php
                                                                        echo populaVAVR();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Desconto Férias</label>
                                                                <label class="select">
                                                                    <select id="descontoFeriasVA" name="descontoFeriasVA">
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
                                                                    <input type="text" placeholder="0,00" maxlength="3" id="descontoFolhaVA" name="descontoFolhaVA" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor do Desconto</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDescontoFolhaVA" name="valorDescontoFolhaVA" style="text-align: right;" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- DIAS ÚTEIS - VALE TRANSPORTE -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDiaUtilVT" class="collapsed" id="accordionDiaUtilVT">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Vale Transporte
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDiaUtilVT" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Dias Úteis</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Mês</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="mesUtilJaneiroVT" name="mesUtilJaneiroVT" autocomplete="off" class="readonly" type="text" value="Janeiro" readonly disabled>
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
                                                                    <input id="mesUtilFevereiroVT" name="mesUtilFevereiroVT" autocomplete="on" class="readonly" readonly type="text" value="Fevereiro" disabled>
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
                                                                    <input id="mesUtilMarcoVT" name="mesUtilMarcoVT" autocomplete="on" class="readonly" type="text" value="Março" readonly disabled>
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
                                                                    <input id="mesUtilAbrilVT" name="mesUtilAbrilVT" autocomplete="on" class="readonly" type="text" value="Abril" readonly disabled>
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
                                                                    <input readonly id="mesUtilMaioVT" name="mesUtilMaioVT" autocomplete="on" class="readonly" type="text" value="Maio" disabled>
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
                                                                    <input id="mesUtilJunhoVT" name="mesUtilJunhoVT" autocomplete="on" class="readonly" type="text" value="Junho" readonly disabled>
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
                                                                    <input id="mesUtilJulhoVT" name="mesUtilJulhoVT" autocomplete="on" class="readonly" type="text" value="Julho" readonly disabled>
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
                                                                    <input id="mesUtilAgostoVT" name="mesUtilAgostoVT" autocomplete="on" class="readonly" type="text" value="Agosto" readonly disabled>
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
                                                                    <input id="mesUtilSetembroVT" name="mesUtilSetembroVT" autocomplete="on" class="readonly" type="text" value="Setembro" readonly disabled>
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
                                                                    <input id="mesUtilOutubroVT" name="mesUtilOutubroVT" autocomplete="on" class="readonly" type="text" value="Outubro" readonly disabled>
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
                                                                    <input id="mesUtilNovembroVT" name="mesUtilNovembroVT" autocomplete="on" class="readonly" type="text" value="Novembro" readonly disabled>
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
                                                                    <input id="mesUtilDezembroVT" name="mesUtilDezembroVT" autocomplete="on" class="readonly" type="text" value="Dezembro" readonly disabled>
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

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Desconto em Folha</legend>
                                                            </section>
                                                        </div>


                                                        <div class="row">

                                                            <section class="col col-4 col-auto">
                                                                <label class="label" for="descontoVT">Desconto Vale Transporte</label>
                                                                <label class="select">
                                                                    <select id="descontoVT" name="descontoVT">
                                                                        <?php
                                                                        echo populaVAVR();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="descontoFeriasVT">Desconto Férias</label>
                                                                <label class="select">
                                                                    <select id="descontoFeriasVT" name="descontoFeriasVT">
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
                                                                    <input type="text" placeholder="0,00" style="text-align: right;" id="valorDiarioVT" name="valorDiarioVT" class="decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor Mensal</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorMensalVT" style="text-align: right;" name="valorMensalVT" class="decimal-2-casas" />
                                                                </label>
                                                            </section>

                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Desconto em Folha</label>
                                                                <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                    <input type="text" maxlength="3" placeholder="0,00" id="descontoFolhaVT" style="text-align: right;" name="descontoFolhaVT" class=" decimal-2-casas" />
                                                                </label>
                                                            </section>
                                                            <section class="col col-2  col-auto">
                                                                <label class="label">Valor do Desconto</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input type="text" placeholder="0,00" id="valorDescontoFolhaVT" name="valorDescontoFolhaVT" style="text-align: right;" class="decimal-2-casas " />
                                                                </label>
                                                            </section>
                                                        </div>


                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FOLGA -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFeriado" class="collapsed" id="accordionFeriado">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Folga
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFeriado" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="jsonFolga" name="jsonFolga" type="hidden" value="[]">
                                                        <div id="formFolga">
                                                            <input id="sequencialFolga" name="sequencialFolga" type="hidden" value="">
                                                            <input id="folgaId" name="folgaId" type="hidden" value="">
                                                            <input id="descricaoDescontaVA" name="descricaoDescontaVA" type="hidden" value="">
                                                            <input id="descricaoDescontaVR" name="descricaoDescontaVR" type="hidden" value="">
                                                            <input id="descricaoDescontaVT" name="descricaoDescontaVT" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-6">
                                                                        <label class="label">Descrição</label>
                                                                        <label class="input"><i class="icon-append fa fa-bars"></i>
                                                                            <input id="descricaoFolga" name="descricaoFolga" placeholder="" autocomplete="off" maxlength="70">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Data Inicial</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="dataInicioFolga" name="dataInicioFolga" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="" onchange="validaData(this)">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Data Final</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="dataFimFolga" name="dataFimFolga" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Desconto
                                                                            VA</label>
                                                                        <label class="select">
                                                                            <select id="descontaVA" name="descontaVA">
                                                                                <option value="" style="display:none;">
                                                                                </option>
                                                                                <option value='1'>Sim</option>
                                                                                <option value='0'>Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Desconto
                                                                            VR</label>
                                                                        <label class="select">
                                                                            <select id="descontaVR" name="descontaVR">
                                                                                <option value="" style="display:none;">
                                                                                </option>
                                                                                <option value='1'>Sim</option>
                                                                                <option value='0'>Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2 col-auto">
                                                                        <label class="label">Desconto
                                                                            VT</label>
                                                                        <label class="select">
                                                                            <select id="descontaVT" name="descontaVT">
                                                                                <option value="" style="display:none;">
                                                                                </option>
                                                                                <option value='1'>Sim</option>
                                                                                <option value='0'>Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>


                                                                <div class="row">

                                                                    <section class="col col-4">

                                                                        <button id="btnAddFolga" type="button" class="btn btn-primary" title="Adicionar Folga">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverFolga" type="button" class="btn btn-danger" title="Remover Folga">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>

                                                                <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableFolga" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
                                                                                <th class="text-left" style="min-width: 10px;">
                                                                                    Descrição</th>
                                                                                <th class="text-left" style="min-width: 10px;">
                                                                                    Data início</th>
                                                                                <th class="text-left" style="min-width: 10px;">
                                                                                    Data fim</th>
                                                                                <th class="text-left" style="min-width: 10px;">
                                                                                    Desconto VA</th>
                                                                                <th class="text-left" style="min-width: 10px;">
                                                                                    Desconto VR</th>
                                                                                <th class="text-left" style="min-width: 10px;">
                                                                                    Desconto VT</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroProjeto.js" type="text/javascript"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {


        // $('.datepicker').change(function() {
        //     if (!moment($(this).datepicker("getDate")).isValid()) {
        //         $(this).val('');
        //     }
        // });


        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($(
            "#jsonEmail").val());
        jsonFolgaArray = JSON.parse($("#jsonFolga").val());

        $("#cnpj").mask("99.999.999/9999-99", {
            placeholder: "X"
        });
        $("#cep").mask("99999-999", {
            placeholder: "X"
        });

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

                    // $("#tipoLogradouro").val(piece[0]);
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

        $('#btnAddEmail').on("click", function() {
            if (validaEmail())
                addEmail();

        });
        $('#btnRemoverEmail').on("click", function() {
            excluirEmail();
        });

        $('#btnAddFolga').on("click", function() {
            if (validaFolga())
                addFolga();

        });
        $('#btnRemoverFolga').on("click", function() {
            sss
            excluirFolga();
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


        $("#dataRenovacao").on("change", function() {
            var valor = "#dataRenovacao";
            retorno = validaData(valor);
            if (retorno == false) {
                $("#dataRenovacao").val('');
            }
            if (retorno == true) {
                var dataAssinatura = $('#dataAssinatura').datepicker('getDate');
                var dataRenovacao = $('#dataRenovacao').datepicker('getDate');
                var retorno = calculaDifDatas(dataAssinatura, dataRenovacao, 'D');
                if (retorno < 0) {
                    smartAlert("Erro", "Data de desligamento não pode ser menor que a admissão.",
                        "error");
                    $("#dataRenovacao").val('');
                }
            }
        });

        $("#dataFimFolga").on("change", function() {
            var valor = "#dataFimFolga";
            retorno = validaData(valor);
            if (retorno == false) {
                $("#dataFimFolga").val('');
            }
            if (retorno == true) {

                var dataInicioRenovacao = $('#dataInicioFolga').datepicker('getDate');
                var dataFimRenovacao = $('#dataFimFolga').datepicker('getDate');
                var retorno = calculaDifDatas(dataInicioRenovacao, dataFimRenovacao, 'D');
                var retorno2 = retorno;
                if (retorno < 0) {
                    smartAlert("Erro", "Data de Inicio da Folga não pode ser maior do que a Final.",
                        "error");
                    $("#dataFimFolga").val('');
                    return;
                }
            }
            if (retorno > 0) {

                var dataAssinatura = $('#dataAssinatura').datepicker('getDate');
                var dataInicioFolga = $('#dataInicioFolga').datepicker('getDate');
                var retorno = calculaDifDatas(dataAssinatura, dataInicioFolga, 'D');
                if (retorno < 0) {
                    smartAlert("Erro", "Data de Inicio da Folga não pode ser menor do que a Data de Assinatura.",
                        "error");
                    $("#dataInicioFolga").val('');
                    $("#dataFimFolga").val('');
                    return;
                }
            }
            if (retorno > 0) {

                var dataRenovacao = $('#dataRenovacao').datepicker('getDate');
                var dataFimFolga = $('#dataFimFolga').datepicker('getDate');
                var retorno = calculaDifDatas(dataFimFolga, dataRenovacao, 'D');
                if (retorno < 0) {
                    smartAlert("Erro", "Data Fim da Folga não pode ser maior do que a data de Renovação.",
                        "error");

                    $("#dataFimFolga").val('');
                    return;
                }
            }
        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#dataAssinatura").on("change", function() {
            var dataAssinatura = $("#dataAssinatura").val();

            var dataFim = moment(dataAssinatura, "DD-MM-YYYY").add(1, 'year');
            dataFim = moment(dataFim, "DD-MM-YYYY").add(-1, 'days');
            dataFim = dataFim.format("DD/MM/YYYY");
            $("#dataRenovacao").val(dataFim);
        });
        $("#valorDiarioVR").on("change", function() {
            $("#valorMensalVR").val('');
        });
        $("#valorMensalVR").on("change", function() {
            $("#valorDiarioVR").val('');
        });
        $("#descontoFolhaVR").on("change", function() {
            $("#valorDescontoFolhaVR").val('');
        });
        $("#valorDescontoFolhaVR").on("change", function() {
            $("#descontoFolhaVR").val('');
        });
        $("#valorDiarioVA").on("change", function() {
            $("#valorMensalVA").val('');
        });
        $("#valorMensalVA").on("change", function() {
            $("#valorDiarioVA").val('');
        });
        $("#descontoFolhaVA").on("change", function() {
            $("#valorDescontoFolhaVA").val('');
        });
        $("#valorDescontoFolhaVA").on("change", function() {
            $("#descontoFolhaVA").val('');
        });
        $("#descontoFolhaPlanoSaude").on("change", function() {
            $("#valorDescontoFolhaPlanoSaude").val('');
        });
        $("#valorDescontoFolhaPlanoSaude").on("change", function() {
            $("#descontoFolhaPlanoSaude").val('');
        });

        carregaPagina();

    });

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaProjeto(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var $strArrayTelefone = piece[2];
                            var $strArrayEmail = piece[3];
                            var $strArrayFolga = piece[4];

                            piece = out.split("^");
                            var codigo = +piece[0];
                            var cnpj = piece[1];
                            var descricao = piece[2];
                            var apelido = piece[3];
                            var dataAssinatura = piece[4];
                            var dataRenovacao = piece[5];
                            var seguroVida = +piece[6];
                            var cep = piece[7];

                            var logradouro = piece[8];
                            var numeroEndereco = piece[9];
                            var complemento = piece[10];
                            var bairro = piece[11];
                            var cidade = piece[12];
                            var estado = piece[13];
                            var ativo = piece[14];
                            //Recuperando dias de VAVR
                            var diaUtilJaneiroVA = +piece[15];
                            var diaUtilFevereiroVA = +piece[16];
                            var diaUtilMarcoVA = +piece[17];
                            var diaUtilAbrilVA = +piece[18];
                            var diaUtilMaioVA = +piece[19];
                            var diaUtilJunhoVA = +piece[20];
                            var diaUtilJulhoVA = +piece[21];
                            var diaUtilAgostoVA = +piece[22];
                            var diaUtilSetembroVA = +piece[23];
                            var diaUtilOutubroVA = +piece[24];
                            var diaUtilNovembroVA = +piece[25];
                            var diaUtilDezembroVA = +piece[26];

                            var descontoVA = +piece[27]
                            var descontoFeriasVA = +piece[28];
                            var valorDiarioVA = piece[29];
                            var valorMensalVA = piece[30];
                            var descontoFolhaVA = piece[31];
                            var valorDescontoFolhaVA = piece[32];

                            var diaUtilJaneiroVT = +piece[33];
                            var diaUtilFevereiroVT = +piece[34];
                            var diaUtilMarcoVT = +piece[35];
                            var diaUtilAbrilVT = +piece[36];
                            var diaUtilMaioVT = +piece[37];
                            var diaUtilJunhoVT = +piece[38];
                            var diaUtilJulhoVT = +piece[39];
                            var diaUtilAgostoVT = +piece[40];
                            var diaUtilSetembroVT = +piece[41];
                            var diaUtilOutubroVT = +piece[42];
                            var diaUtilNovembroVT = +piece[43];
                            var diaUtilDezembroVT = +piece[44];

                            var descontoVT = piece[45]
                            var descontoFeriasVT = piece[46];
                            var valorDiarioVT = piece[47];
                            var valorMensalVT = piece[48];
                            var descontoFolhaVT = piece[49];

                            var valorDescontoFolhaVT = piece[50];
                            var numeroCentroCusto = piece[51];
                            var descontoFolhaPlanoSaude = piece[52];
                            var valorDescontoFolhaPlanoSaude = piece[53];
                            var municipioFerias = piece[54];
                            var razaoSocial = piece[55];

                            $("#codigo").val(codigo);
                            $("#cnpj").val(cnpj);
                            $("#descricao").val(descricao);
                            $("#apelido").val(apelido);
                            $("#dataAssinatura").val(dataAssinatura);
                            $("#dataRenovacao").val(dataRenovacao);
                            $("#seguroVida").val(seguroVida);
                            $("#cep").val(cep);
                            $("#logradouro").val(logradouro);
                            $("#numero").val(numeroEndereco);
                            $("#complemento").val(complemento);
                            $("#bairro").val(bairro);
                            $("#cidade").val(cidade);
                            $("#estado").val(estado);
                            $("#ativo").val(ativo);

                            $("#jsonTelefone").val($strArrayTelefone);
                            $("#jsonEmail").val($strArrayEmail);

                            // VAVR
                            $("#diaUtilJaneiroVA").val(diaUtilJaneiroVA);
                            $("#diaUtilFevereiroVA").val(diaUtilFevereiroVA);
                            $("#diaUtilMarcoVA").val(diaUtilMarcoVA);
                            $("#diaUtilAbrilVA").val(diaUtilAbrilVA);
                            $("#diaUtilMaioVA").val(diaUtilMaioVA);
                            $("#diaUtilJunhoVA").val(diaUtilJunhoVA);
                            $("#diaUtilJulhoVA").val(diaUtilJulhoVA);
                            $("#diaUtilAgostoVA").val(diaUtilAgostoVA);
                            $("#diaUtilSetembroVA").val(diaUtilSetembroVA);
                            $("#diaUtilOutubroVA").val(diaUtilOutubroVA);
                            $("#diaUtilNovembroVA").val(diaUtilNovembroVA);
                            $("#diaUtilDezembroVA").val(diaUtilDezembroVA);

                            $("#descontoVA").val(descontoVA);
                            $("#descontoFeriasVA").val(descontoFeriasVA);
                            $("#valorDiarioVA").val(valorDiarioVA);
                            $("#valorMensalVA").val(valorMensalVA);
                            $("#descontoFolhaVA").val(descontoFolhaVA);
                            $("#valorDescontoFolhaVA").val(valorDescontoFolhaVA);

                            $("#jsonFolga").val($strArrayFolga);
                            // VT
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

                            $("#descontoVT").val(descontoVT);
                            $("#descontoFeriasVT").val(descontoFeriasVT);
                            $("#valorDiarioVT").val(valorDiarioVT);
                            $("#valorMensalVT").val(valorMensalVT);
                            $("#descontoFolhaVT").val(descontoFolhaVT);
                            $("#valorDescontoFolhaVT").val(valorDescontoFolhaVT);
                            $("#numeroCentroCusto").val(numeroCentroCusto);

                            $("#descontoFolhaPlanoSaude").val(descontoFolhaPlanoSaude);
                            $("#valorDescontoFolhaPlanoSaude").val(valorDescontoFolhaPlanoSaude);
                            $("#municipioFerias").val(municipioFerias);
                            $("#razaoSocial").val(razaoSocial);
                            jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                            jsonEmailArray = JSON.parse($("#jsonEmail").val());
                            jsonFolgaArray = JSON.parse($("#jsonFolga").val());

                            fillTableTelefone();
                            fillTableEmail();
                            fillTableFolga();
                            initializeDecimalBehaviour();

                        }
                    }

                );
            }
        }
        $("#nome").focus();
    }

    function novo() {
        $(location).attr('href', 'cadastro_ProjetoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_projetoFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirProjeto(id, () => {
            smartAlert("Atenção", "Operação realizada com sucesso!", "success");
            setTimeout(function() {
                voltar();
            }, 1000);


        });
    }

    function gravar() {


        let projeto = $('#formProjeto').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        if (!$("#cnpj").val()) {
            smartAlert("Atenção", "Informe o CNPJ", "error");
            return;
        }

        if (!$("#descricao").val()) {
            smartAlert("Atenção", "Informe A Descrição", "error");

            return;
        }
        if (!$("#apelido").val()) {
            smartAlert("Atenção", "Informe o Apelido", "error");
            return;
        }
        if (!$("#dataAssinatura").val()) {
            smartAlert("Atenção", "Informe a Data da Assinatura", "error");
            return;
        }
        if (!$("#dataRenovacao").val()) {
            smartAlert("Atenção", "Informe a Data da renovção", "error");
            return;
        }
        if (!$("#razaoSocial").val()) {
            smartAlert("Atenção", "Informe a Razao Social ", "error");
            return;
        }
        if (!$("#seguroVida").val()) {
            smartAlert("Atenção", "Informe O Seguro de Vida", "error");
            return;
        }

        if (!$("#estado").val()) {
            smartAlert("Atenção", "Informe a UF", "error");
            return;
        }

        if (!$("#cidade").val()) {
            smartAlert("Atenção", "Informe a Cidade", "error");
            return;
        }

        if (!$("#municipioFerias").val()) {
            smartAlert("Atenção", "Informe a Município Ferias", "error");
            return;
        }

      

        gravaProjeto(projeto,
            function(data) {
                if (data.indexOf('sucess') < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                        $("#btnGravar").prop('disabled', false);
                    }
                    return '';
                } else {

                    $("#btnGravar").prop('disabled', true);

                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    voltar();


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
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' +
                jsonTelefoneArray[i]
                .sequencialTel + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTel +
                ');">' +
                jsonTelefoneArray[i].telefone + '</td>'));
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
                if ((jsonTelefoneArray[i].telefonePrincipal === 1) && (jsonTelefoneArray[i].sequencialTel !==
                        sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonTelefoneArray[i].telefone === tel) && (jsonTelefoneArray[i].sequencialTel !==
                        sequencial)) {
                    existe = true;
                    break;
                }
            }
        }

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefoneWhatsAppMarcado === 1) {
                if ((jsonTelefoneArray[i].telefoneWhatsApp === 1) && (jsonTelefoneArray[i].sequencialTel !==
                        sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonTelefoneArray[i].telefone === tel) && (jsonTelefoneArray[i].sequencialTel !==
                        sequencial)) {
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
            $("#telefonePrincipal").val(item.telefonePrincipal);
            $("#telefoneWhatsApp").val(item.telefoneWhatsApp);

            if (item.telefonePrincipal === 1) {
                $('#telefonePrincipal').prop('checked', true);
                $('#descricaoTelefonePrincipal').val("Sim");
            } else {
                $('#telefonePrincipal').prop('checked', false);
                $('#descricaoTelefonePrincipal').val("Não");
            }

            if (item.telefoneWhatsApp === 1) {
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
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' +
                jsonEmailArray[i]
                .sequencialEmail + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaEmail(' + jsonEmailArray[i].sequencialEmail +
                ');">' +
                jsonEmailArray[i].email + '</td>'));
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
                if ((jsonEmailArray[i].emailPrincipal === 1) && (jsonEmailArray[i].sequencialEmail !==
                        sequencial)) {
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
            $("#emailPrincipal").val(item.emailPrincipal);
            if (item.emailPrincipal === 1) {
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

    //############################################################################## LISTA FOLGA INICIO #######################################################################################################################

    function fillTableFolga() {
        $("#tableFolga tbody").empty();
        for (var i = 0; i < jsonFolgaArray.length; i++) {
            var row = $('<tr />');
            $("#tableFolga tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' +
                jsonFolgaArray[i]
                .sequencialFolga + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaFolga(' + jsonFolgaArray[i].sequencialFolga +
                ');">' +
                jsonFolgaArray[i].descricaoFolga + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFolgaArray[i].dataInicioFolga + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFolgaArray[i].dataFimFolga + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFolgaArray[i].descricaoDescontaVA + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFolgaArray[i].descricaoDescontaVR + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFolgaArray[i].descricaoDescontaVT + '</td>'));
        }
    }

    function addFolga() {
        var item = $("#formFolga").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataFolga
        });

        if (item["sequencialFolga"] === '') {
            if (jsonFolgaArray.length === 0) {
                item["sequencialFolga"] = 1;
            } else {
                item["sequencialFolga"] = Math.max.apply(Math, jsonFolgaArray.map(function(o) {
                    return o.sequencialFolga;
                })) + 1;
            }
            item["folgaId"] = 0;
        } else {
            item["sequencialFolga"] = +item["sequencialFolga"];
        }
        var index = -1;
        $.each(jsonFolgaArray, function(i, obj) {
            if (+$('#sequencialFolga').val() === obj.sequencialFolga) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonFolgaArray.splice(index, 1, item);
        else
            jsonFolgaArray.push(item);

        $("#jsonFolga").val(JSON.stringify(jsonFolgaArray));
        fillTableFolga();
        clearFormFolga();
    }

    function processDataFolga(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoDescontaVA")) {
            var descricaoDescontaVA = $("#descontaVA option:selected").text();
            return {
                name: fieldName,
                value: descricaoDescontaVA
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoDescontaVR")) {
            var descricaoDescontaVR = $("#descontaVR option:selected").text();
            return {
                name: fieldName,
                value: descricaoDescontaVR
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoDescontaVT")) {
            var descricaoDescontaVT = $("#descontaVT option:selected").text();
            return {
                name: fieldName,
                value: descricaoDescontaVT
            };
        }

        return false;
    }



    function clearFormFolga() {

        $("#folgaId").val('');
        $("#descontaVA").val('');
        $("#descontaVR").val('');
        $("#descontaVT").val('');
        $('#descricaoFolga').val('');
        $('#folgaPrincipal').prop('checked', false);
        $('#dataInicioFolga').val('');
        $('#dataFimFolga').val('');
        $('#sequencialFolga').val('');

    }

    function carregaFolga(sequencialFolga) {
        var arr = jQuery.grep(jsonFolgaArray, function(item, i) {
            return (item.sequencialFolga === sequencialFolga);
        });

        clearFormFolga();

        if (arr.length > 0) {
            var item = arr[0];
            $("#folgaId").val(item.folgaId);
            $("#sequencialFolga").val(item.sequencialFolga);
            $("#descricaoFolga").val(item.descricaoFolga);
            $("#dataInicioFolga").val(item.dataInicioFolga);
            $("#dataFimFolga").val(item.dataFimFolga);
            $("#descontaVA").val(item.descontaVA);
            $("#descontaVR").val(item.descontaVR);
            $("#descontaVT").val(item.descontaVT);
        }

    }

    function excluirFolga() {
        var arrSequencial = [];
        $('#tableFolga input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });

        if (arrSequencial.length > 0) {
            for (i = jsonFolgaArray.length - 1; i >= 0; i--) {
                var obj = jsonFolgaArray[i];
                if (jQuery.inArray(obj.sequencialFolga, arrSequencial) > -1) {
                    jsonFolgaArray.splice(i, 1);
                }
            }
            $("#jsonFolga").val(JSON.stringify(jsonFolgaArray));
            fillTableFolga();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 folga para excluir.", "error");
    }

    function validaFolga() {
        var existe = false;
        var achou = false;
        var descricaoFolga = $('#descricaoFolga').val();
        var dataInicioFolga = $('#dataInicioFolga').val();
        var dataFimFolga = $('#dataFimFolga').val();
        var descontaVA = $('#descontaVA').val();
        var descontaVR = $('#descontaVR').val();
        var descontaVT = $('#descontaVT').val();
        var sequencial = +$('#sequencialFolga').val();

        if (!descricaoFolga) {
            smartAlert("Atenção", "Informe a Descricao Folga ", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!dataInicioFolga) {
            smartAlert("Atenção", "Informe a data Inicial Folga ", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!dataFimFolga) {
            smartAlert("Atenção", "Informe a data Final Folga ", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!descontaVA) {
            smartAlert("Atenção", "Informe se desconta VA", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!descontaVR) {
            smartAlert("Atenção", "Informe se desconta VR Folga ", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!descontaVT) {
            smartAlert("Atenção", "Informe se descontaVT Folga ", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        return true;
    }

    //############################################################################## LISTA FOLGA FIM ##########################################################################################################################

    function validaData(valor) {
        var valor = valor;
        var date = $(valor).val();
        var ardt = new Array;
        var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
        ardt = date.split("/");
        erro = false;
        if (date.search(ExpReg) == -1) {
            erro = true;
        } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30))
            erro = true;
        else if (ardt[1] == 2) {
            if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                erro = true;
            if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                erro = true;
        }
        if (erro) {
            smartAlert("Erro", "Data incorreta.", "error");
            $(valor).val('');
            return false;
        }
        return true;
    }
</script>