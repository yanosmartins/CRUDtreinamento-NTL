<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('FUNCIONARIO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('FUNCIONARIO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('FUNCIONARIO_EXCLUIR', $arrayPermissao, true));

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
                            <h2>Funcionário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="" class="smart-form client-form" id="formUsuario">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden" value="">
                                                        <div class="row">

                                                            <input id="codigo" name="codigo" type="text" readonly class="hidden" value="">

                                                            <section class="col col-6">
                                                                <label class="label" for="nome">Nome do Funcionário</label>
                                                                <label class="input">
                                                                    <input id="nome" name="nome" autocomplete="off" class="required" maxlength="60">
                                                                </label>
                                                            </section>
                                                        </div>


                                                        <div class="row">

                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="sindicato">Sindicato</label>
                                                                <label class="select">
                                                                    <select id="sindicato" name="sindicato" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo, apelido  from Ntl.sindicato where situacao=1 order by descricao ";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $sindicato = $row['apelido'];

                                                                            echo '<option value=' . $codigo . '>' . $sindicato . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="cargo">Cargo</label>
                                                                <label class="select">
                                                                    <select id="cargo" name="cargo" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo, descricao  from Ntl.cargo where ativo=1 order by descricao";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $codigo = (int) $row['codigo'];
                                                                            $sindicato = $row['descricao'];

                                                                            echo '<option value=' . $codigo . '>' . $sindicato . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="cpf">CPF</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="cpf" name="cpf" placeholder="XXX.XXX.XXX-XX" autocomplete="off" class="required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="matricula">Matrícula</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="matricula" name="matricula" autocomplete="off" autocomplete="14" class="required">
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-3">
                                                                <label class="label" for="sexo">Sexo</label>
                                                                <label class="select">
                                                                    <select id="sexo" name="sexo" class="required">
                                                                        <?php
                                                                        include_once("populaTabela/popula.php");
                                                                        echo populaSexo();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label" for="dataNascimento">Data de Nascimento</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataAdmissao">Data de Admissão</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataAdmissao" name="dataAdmissao" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker required" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataDemissao">Data de Demissão</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataDemissao" name="dataDemissao" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataCancelamentoPlanoSaude">Cancelamento Plano</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataCancelamentoPlanoSaude" name="dataCancelamentoPlanoSaude" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
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
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCarteira" class="collapsed" id="accordionEndereco">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Documentos Pessoais
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCarteira" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <!-- Inserção de Dias Trabalhados -->

                                                        <br>
                                                        <div class="row" style="margin-top: -20px;">
                                                            <section class="col col-12">
                                                                <legend>Carteira de Trabalho</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">PIS/PASEP</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="pisPasep" name="pisPasep" autocomplete="off" placeholder="XXX.XXXX.XXX-X" class="required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="numeroCarteiraTrabalho">Número</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="numeroCarteiraTrabalho" name="numeroCarteiraTrabalho" placeholder="XXXXXXX" maxlength="7" autocomplete="off" class="required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="serieCarteiraTrabalho">Série</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="serieCarteiraTrabalho" name="serieCarteiraTrabalho" placeholder="XXX-X" autocomplete="off" class="required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" for="ufCarteiraTrabalho">UF</label>
                                                                <label class="select">
                                                                    <select id="ufCarteiraTrabalho" name="ufCarteiraTrabalho" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {

                                                                            $sigla = $row['sigla'];
                                                                            echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataExpedicaoCarteiraTrabalho">Data de Expedição</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataExpedicaoCarteiraTrabalho" name="dataExpedicaoCarteiraTrabalho" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <br>
                                                        <div class="row" style="margin-top: -20px;">
                                                            <section class="col col-12">
                                                                <legend>Identidade</legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-3">
                                                                <label class="label" for="rg">RG</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="rg" name="rg" autocomplete="off" placeholder="XX.XXX.XXX-X" class="required">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="dataEmissaoRG">Data de Emissão</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="dataEmissaoRG" name="dataEmissaoRG" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label" for="ufIdentidade">UF</label>
                                                                <label class="select">
                                                                    <select id="ufIdentidade" name="ufIdentidade" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {

                                                                            $sigla = $row['sigla'];
                                                                            echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="orgaoEmissorRG">Orgão Emissor</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="orgaoEmissorRG" name="orgaoEmissorRG" maxlength="25" autocomplete="off" class="required">
                                                                </label>
                                                            </section>



                                                        </div>
                                                        <div>
                                                            <br>
                                                            <div class="row" style="margin-top: -20px;">
                                                                <section class="col col-12">
                                                                    <legend>CNH</legend>
                                                                </section>
                                                            </div>

                                                            <div class="row">

                                                                <section class="col col-3">
                                                                    <label class="label" for="cnh">Número</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="cnh" name="cnh" maxlength="11" autocomplete="off">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="categoriaCNH">Categoria</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="categoriaCNH" placeholder="XXXXX" name="categoriaCNH" maxlength='5' autocomplete="off">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <label class="label" for="ufCNH">UF</label>
                                                                    <label class="select">
                                                                        <select id="ufCNH" name="ufCNH">
                                                                            <option></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach($result as $row) {

                                                                                $sigla = $row['sigla'];
                                                                                echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="dataEmissaoCNH">Data de Emissão</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataEmissaoCNH" name="dataEmissaoCNH" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="dataVencimentoCNH">Data de Vencimento</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataVencimentoCNH" name="dataVencimentoCNH" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="primeiraHabilitacaoCNH">1ª Habilitação</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="primeiraHabilitacaoCNH" name="primeiraHabilitacaoCNH" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                    </label>
                                                                </section>

                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
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

                                                    <fieldset autocomplete="off">

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="cep">CEP</label>
                                                                <label class="input">
                                                                    <input class="required" id="cep" name="cep" placeholder="XXXXX-XXX" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label" for="logradouro">Logradouro</label>
                                                                <label class="input">
                                                                    <input class="required" id="logradouro" name="logradouro" maxlength="255" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="numeroLogradouro">Número</label>
                                                                <label class="input">
                                                                    <input class="required" id="numeroLogradouro" name="numeroLogradouro" maxlength="20" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label" for="complemento">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" name="complemento" maxlength="50" autocomplete="off">
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="ufCarteiraTrabalho">UF</label>
                                                                <label class="select">
                                                                    <select id="ufLogradouro" name="ufLogradouro" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {

                                                                            $sigla = $row['sigla'];
                                                                            echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label" for="cidade">Cidade</label>
                                                                <label class="input">
                                                                    <input class="required" id="cidade" name="cidade" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="bairro">Bairro</label>
                                                                <label class="input">
                                                                    <input class="required" id="bairro" name="bairro" maxlength="30" autocomplete="off">
                                                                </label>
                                                            </section>
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

                                        <!-- DEPENDENTES -->

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDependentes" class="collapsed" id="accordionDependentes">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dependentes
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDependentes" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input id="jsonDependente" name="jsonDependente" type="hidden" value="[]">
                                                        <div id="formDependente">

                                                            <div class="row">
                                                                <input id="dependenteId" name="dependenteId" type="hidden" value="">
                                                                <input id="descricaoGrauParentesco" name="descricaoGrauParentesco" type="hidden" value="">
                                                                <input id="descricaoDataNascimentoDependente" name="descricaoDataNascimentoDependente" type="hidden" value="">
                                                                <input id="sequencialDependente" name="sequencialDependente" type="hidden" value="">

                                                                <section class="col col-6">
                                                                    <label class="label" for="nomeDependente">Nome do Dependente</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="nomeDependente" name="nomeDependente" maxlength="60" autocomplete="off">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="dataNascimentoDependente">Nascimento</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataNascimentoDependente" name="dataNascimentoDependente" autocomplete="off" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker " value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="grauParentescoDependente">Parentesco</label>
                                                                    <label class="select">
                                                                        <select id="grauParentescoDependente" name="grauParentescoDependente">
                                                                            <option value="0">Selecione</option>
                                                                            <option value="1">Pai</option>
                                                                            <option value="2">Mãe</option>
                                                                            <option value="3">Filho(a)</option>
                                                                            <option value="4">Enteado(a)</option>
                                                                            <option value="5">Esposo(a)</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="tipoDependente">Tipo Dependente</label>
                                                                    <label class="select">
                                                                        <select id="tipoDependente" name="tipoDependente">
                                                                            <option value="0">Selecione</option>
                                                                            <option value="1">Salário Família/IR</option>
                                                                            <option value="2">IR</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">

                                                                <section class="col col-2">
                                                                    <label class="label" for="cpfDependente">CPF</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="cpfDependente" name="cpfDependente" placeholder="XXX.XXX.XXX-XX" autocomplete="off">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2" for="rgDependente">
                                                                    <label class="label">RG</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="rgDependente" name="rgDependente" placeholder="XX.XXX.XXX-X" autocomplete="off">
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="orgaoEmissorDependente">Orgão Emissor</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="orgaoEmissorDependente" name="orgaoEmissorDependente" autocomplete="off">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="invalido">Inválido</label>
                                                                    <label class="select">
                                                                        <select id="invalido" name="invalido">
                                                                            <option value="0">Não</option>
                                                                            <option value="1">Sim</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                            </div>

                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnLimparDependente" type="button" class="btn btn-default" title="Limpar Endereço">
                                                                        <i class="fa fa-file-o"></i>
                                                                    </button>
                                                                    <button id="btnAddDependente" type="button" class="btn btn-primary" title="Adicionar Endereço">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverDependente" type="button" class="btn btn-danger" title="Remover Endereço">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>

                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableDependente" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">Nome</th>
                                                                            <th class="text-left" style="min-width: 10px;">Data de Nascimento</th>
                                                                            <th class="text-left" style="min-width: 10px;">Parentesco</th>
                                                                            <th class="text-left" style="min-width: 10px;">CPF</th>
                                                                            <th class="text-left" style="min-width: 10px;">RG</th>
                                                                            <th class="text-left" style="min-width: 10px;">Orgão Emissor</th>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroFuncionario.js" type="text/javascript"></script>

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




<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        //Jsons da página
        jsonDependenteArray = JSON.parse($("#jsonDependente").val());
        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($("#jsonEmail").val());


        carregaPagina();

        //Máscaras dos campos
        $("#cpf").mask("999.999.999-99");
        $("#cpfDependente").mask("999.999.999-99");
        $("#rgDependente").mask("99.999.999-9");
        $("#cep").mask("99999-999");
        $("#pisPasep").mask("999.9999.999-9");
      
        $("#serieCarteiraTrabalho").mask("999-9");
        $("#rg").mask("99.999.999-9");



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

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
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
                    $("#logradouro").val(piece[0] + " " + piece[1]);
                    $("#bairro").val(piece[2]);
                    $("#cidade").val(piece[3]);
                    $("#ufLogradouro").val(piece[4]);
                    return;
                }
            });
        });


        $("#cpf").on("change", function() {
            debugger;
            var val = $("#cpf").val();
            var retorno = validacao_cpf(val);
            var funcao = 'verificaCpf';

            if (retorno === false) {
                smartAlert("Atenção", "O cpf digitado é inválido.", "error");
                $("#cpf").val("");
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'js/sqlscope_cadastroFuncionario.php',
                data: {
                    funcao,
                    val
                },
                success: function(data) {
                    var status = data.split('#');
                    if (status[0] == 'failed') {
                        smartAlert("Atenção", "O cpf digitado já existe.", "error");
                        $("#cpf").val("");
                        return;
                    }
                }
            });

        });

        
        //   VALIDAÇÕES DOS NOMES 
        $("#nome").on("change", function() {
            verificaNome("#nome");
        });
        $("#nomeDependente").on("change", function() {
            verificaNome("#nomeDependente");
        });

        //   VALIDAÇÕES DAS DATAS 
        $("#dataNascimento").on("change", function() {
            validaCampoData("#dataNascimento");
            comparaDataHoje("#dataNascimento");
        });

        $("#dataAdmissao").on("change", function() {
            validaCampoData("#dataAdmissao");
            comparaDatas("#dataAdmissao", "#dataNascimento", "Insira a Data de Nascimento", "A Data de Admissão não pode ser menor do que a Data de Nascimento");
        });


        $("#dataDemissao").on("change", function() {
            validaCampoData("#dataDemissao");
            comparaDatas("#dataDemissao", "#dataNascimento", "Insira a Data de Nascimento", "A Data de Demissão não pode ser menor do que a Data de Nascimento");
            comparaDatas("#dataDemissao", "#dataAdmissao", "Insira a Data de Admissão", "A Data de Demissão não pode ser menor do que a Data de Admissão");
        });

        $("#dataCancelamentoPlanoSaude").on("change", function() {
            validaCampoData("#dataCancelamentoPlanoSaude");
            comparaDatas("#dataCancelamentoPlanoSaude", "#dataNascimento", "Insira a Data de Nascimento", "A Data de Cancelamento do Plano de Saúde não pode ser menor do que a Data de Nascimento");
            comparaDatas("#dataCancelamentoPlanoSaude", "#dataAdmissao", "Insira a Data de Admissão", "A Data de Cancelamento do Plano de Saúde não pode ser menor do que a Data de Admissão");
            comparaDatas("#dataCancelamentoPlanoSaude", "#dataDemissao", "Insira a Data de Demissão", "A Data de Cancelamento do Plano de Saúde não pode ser menor do que a Data de Demissão");
        });

        $("#dataExpedicaoCarteiraTrabalho").on("change", function() {
            validaCampoData("#dataExpedicaoCarteiraTrabalho");
            comparaDatas("#dataExpedicaoCarteiraTrabalho", "#dataNascimento", "Insira a Data de Nascimento", "A Data de Expedição não pode ser menor do que a Data de Nascimento");
            comparaDataHoje("#dataExpedicaoCarteiraTrabalho");
        });

        $("#dataEmissaoRG").on("change", function() {
            validaCampoData("#dataEmissaoRG");
            comparaDatas("#dataEmissaoRG", "#dataNascimento", "Insira a Data de Nascimento", "A Data de Emissão da Identidade não pode ser menor do que a Data de Nascimento");
            comparaDataHoje("#dataEmissaoRG");
        });

        $("#dataEmissaoCNH").on("change", function() {
            validaCampoData("#dataEmissaoCNH ");
            comparaDatas("#dataEmissaoCNH", "#dataNascimento", "Insira a Data de Nascimento", "A Data de Emissão da Carteira não pode ser menor do que a Data de Nascimento");
            comparaDataHoje("#dataEmissaoCNH");
        });

        $("#dataVencimentoCNH").on("change", function() {
            validaCampoData("#dataVencimentoCNH");
            comparaDatas("#dataVencimentoCNH", "#dataNascimento", "Insira a Data de Nascimento", "A Data de Emissão da Carteira não pode ser menor do que a Data de Nascimento");
            comparaDatas("#dataVencimentoCNH", "#dataEmissaoCNH", "Insira a Data de Emissão da Carteira", "A Data de Vencimento não pode ser menor do que a Data de Emissão da Carteira");

        });

        $("#primeiraHabilitacaoCNH").on("change", function() {
            validaCampoData("#primeiraHabilitacaoCNH");
            comparaDatas("#primeiraHabilitacaoCNH", "#dataNascimento", "Insira a Data de Nascimento", "A Data da Primeira Habilitação não pode ser menor do que a Data de Nascimento");

        });

        $("#dataNascimentoDependente").on("change", function() {
            validaCampoData("#dataNascimentoDependente");
            comparaDataHoje("#dataNascimentoDependente");
        });

        //Botões de Telefone
        $("#btnAddTelefone").on("click", function() {
            if (validaTelefone())
                addTelefone();
        });

        $("#btnRemoverTelefone").on("click", function() {
            excluirContato();
        });

        //Botões de Email
        $('#btnAddEmail').on("click", function() {
            if (validaEmail())
                addEmail();
        });

        $('#btnRemoverEmail').on("click", function() {
            excluirEmail();
        });

        //Botões de Dependente
        $("#btnAddDependente").on("click", function() {
            if (validaDependente())
                addDependente();
        });

        $("#btnRemoverDependente").on("click", function() {
            excluirDependente();
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });
        $("#telefone").mask("(99) 9999-9999?9").on("focusout", function() {
            var len = this.value.replace(/\D/g, '').length;
            $(this).mask(len > 10 ? "(99) 99999-999?9" : "(99) 9999-9999?9");
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
                recuperaFuncionario(idd,
                    function(data) {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        var out = piece[1];
                        var $strArrayTelefone = piece[2];
                        var $strArrayEmail = piece[3];
                        var $strArrayDependente = piece[4];

                        piece = out.split("^");
                        var codigo = +piece[0];
                        var ativo = piece[1];
                        var sindicato = piece[2];
                        var cargo = piece[3];
                        var nome = piece[4];
                        var cpf = piece[5];
                        var matricula = piece[6];
                        var sexo = piece[7];
                        var dataNascimento = piece[8];
                        var dataAdmissaoFuncionario = piece[9];
                        var dataDemissaoFuncionario = piece[10];
                        var dataCancelamentoPlanoSaude = piece[11];
                        var pisPasep = piece[12];
                        var numeroCarteiraTrabalho = piece[13];
                        var serieCarteiraTrabalho = piece[14];
                        var ufCarteiraTrabalho = piece[15];
                        var dataExpedicaoCarteiraTrabalho = piece[16];
                        var rg = piece[17];
                        var dataEmissaoRG = piece[18];
                        var orgaoEmissorRG = piece[19];
                        var cnh = piece[20];
                        var categoriaCNH = piece[21];
                        var ufCNH = piece[22];
                        var dataEmissaoCNH = piece[23];
                        var dataVencimentoCNH = piece[24];
                        var primeiraHabilitacaoCNH = piece[25];
                        var cep = piece[26];
                        var logradouro = piece[27];
                        var numeroLogradouro = piece[28];
                        var complemento = piece[29];
                        var ufLogradouro = piece[30];
                        var cidade = piece[31];
                        var bairro = piece[32];
                        var ufIdentidade = piece[33];

                        $("#codigo").val(codigo);
                        $("#ativo").val(ativo);
                        $("#sindicato").val(sindicato);
                        $("#cargo").val(cargo);
                        $("#nome").val(nome);
                        $("#cpf").val(cpf);
                        $("#matricula").val(matricula);
                        $("#sexo").val(sexo);
                        $("#dataNascimento").val(dataNascimento);
                        $("#dataAdmissao").val(dataAdmissaoFuncionario);
                        $("#dataDemissao").val(dataDemissaoFuncionario);
                        $("#dataCancelamentoPlanoSaude").val(dataCancelamentoPlanoSaude);
                        $("#pisPasep").val(pisPasep);
                        $("#numeroCarteiraTrabalho").val(numeroCarteiraTrabalho);
                        $("#serieCarteiraTrabalho").val(serieCarteiraTrabalho);
                        $("#ufCarteiraTrabalho").val(ufCarteiraTrabalho);
                        $("#dataExpedicaoCarteiraTrabalho").val(dataExpedicaoCarteiraTrabalho);
                        $("#rg").val(rg);
                        $("#dataEmissaoRG").val(dataEmissaoRG);
                        $("#orgaoEmissorRG").val(orgaoEmissorRG);
                        $("#cnh").val(cnh);
                        $("#categoriaCNH").val(categoriaCNH);
                        $("#ufCNH").val(ufCNH);
                        $("#dataEmissaoCNH").val(dataEmissaoCNH);
                        $("#dataVencimentoCNH").val(dataVencimentoCNH);
                        $("#primeiraHabilitacaoCNH").val(primeiraHabilitacaoCNH);
                        $("#cep").val(cep);
                        $("#logradouro").val(logradouro);
                        $("#numeroLogradouro").val(numeroLogradouro);
                        $("#complemento").val(complemento);
                        $("#ufLogradouro").val(ufLogradouro);
                        $("#bairro").val(bairro);
                        $("#cidade").val(cidade);
                        $("#ufIdentidade").val(ufIdentidade);
                        $("#verificaRecuperacao").val(1);

                        //Arrays  
                        $("#jsonTelefone").val($strArrayTelefone);
                        $("#jsonEmail").val($strArrayEmail);
                        $("#jsonDependente").val($strArrayDependente);

                        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                        jsonEmailArray = JSON.parse($("#jsonEmail").val());
                        jsonDependenteArray = JSON.parse($("#jsonDependente").val());

                        fillTableTelefone();
                        fillTableEmail();
                        fillTableDependente();
                        initializeDecimalBehaviour();


                    })
            }

        }
    }

    function verificaNome(campo) {
        var texto = $(campo).val();
        // var texto = document.getElementById(inputField.value);
        for (letra of texto) {
            if (!isNaN(texto)) {

                // alert("Não digite números");
                //  document.getElementById("entrada").value="";
                smartAlert("Erro", "Não digite caracteres que não sejam letras ou espaço", "error");
                $(campo).val("");
                return;
            }
            letraspermitidas = "ABCEDFGHIJKLMNOPQRSTUVXWYZ abcdefghijklmnopqrstuvxwyzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ-"
            var ok = false;
            for (letra2 of letraspermitidas) {

                if (letra == letra2) {

                    ok = true;
                }
            }
            if (!ok) {
                //                    alert("Não digite caracteres que não sejam letras ou espaços");
                smartAlert("Erro", "Não digite caracteres que não sejam letras ou espaços", "error");
                // document.getElementById("entrada").value="";
                $(campo).val("");
                return;

            }
        }
    }


    // Função que verifica se um campo é valido ou não. 
    function validaCampoData(campo) {
        var valor = $(campo).val();
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js

        if (validacao === false) {
            $(campo).val("");
        }
    }

    function buscaCep() {
        var cep = $("#cep").val();
        recuperaCep(cep);
    }


    function comparaDatas(primeiraData, segundaData, alertaDeCampoEmBranco, alertaDataInvalida) {

        var nomeCampoPrimeiraData = primeiraData;
        var valorPrimeiraData = $(primeiraData).val();
        var valorSegundaData = $(segundaData).val();

        if (valorSegundaData == "") {
            smartAlert("Erro", alertaDeCampoEmBranco, "error");
            $(nomeCampoPrimeiraData).val("");
        }

        if ((valorPrimeiraData != "") && (valorSegundaData != "")) {

            valorPrimeiraData = moment(valorPrimeiraData, "DD-MM-YYYY");
            valorSegundaData = moment(valorSegundaData, "DD-MM-YYYY");

            var diferencaEntreDatas = valorPrimeiraData.diff(valorSegundaData, 'days');

            if (diferencaEntreDatas < 0) {
                smartAlert("Erro", alertaDataInvalida, "error");
                $(nomeCampoPrimeiraData).val("");
            }
        }
    }

    function comparaDataHoje(primeiraData) {

        var nomeCampoPrimeiraData = primeiraData;
        var valorPrimeiraData = $(primeiraData).val();
        var valorSegundaData = new Date().toLocaleDateString();

        if ((valorPrimeiraData != "") && (valorSegundaData != "")) {

            valorPrimeiraData = moment(valorPrimeiraData, "DD-MM-YYYY");
            valorSegundaData = moment(valorSegundaData, "DD-MM-YYYY");

            var diferencaEntreDatas = valorPrimeiraData.diff(valorSegundaData, 'days');

            if (diferencaEntreDatas > 0) {
                smartAlert("Erro", "Data maior que hoje", "error");
                $(nomeCampoPrimeiraData).val("");
            }
        }
    }

    function novo() {
        $(location).attr('href', 'cadastro_funcionarioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'cadastro_funcionarioFiltro.php');
    }

    function excluir() {
        var id = $("#codigo").val();
        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }
        excluirFuncionario(id,
            function(data) {
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
            }
        );
    }


    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        //Dados 
        var id = +$("#codigo").val();
        var nome = $("#nome").val();
        var sindicato = $("#sindicato").val();
        var cargo = $("#cargo").val();
        var cpf = $("#cpf").val();
        var matricula = $("#matricula").val();
        var sexo = $("#sexo").val();
        var dataNascimento = $("#dataNascimento").val();
        var dataAdmissaoFuncionario = $("#dataAdmissao").val();
        var dataDemissaoFuncionario = $("#dataDemissao").val();
        var dataCancelamentoPlanoSaude = $("#dataCancelamentoPlanoSaude").val();

        //Documentos Pessoais
        var pisPasep = $("#pisPasep").val();
        var numeroCarteiraTrabalho = $("#numeroCarteiraTrabalho").val();
        var serieCarteiraTrabalho = $("#serieCarteiraTrabalho").val();
        var ufCarteiraTrabalho = $("#ufCarteiraTrabalho").val();
        var dataExpedicaoCarteiraTrabalho = $("#dataExpedicaoCarteiraTrabalho").val();

        //Identidade
        var rg = $("#rg").val();
        var dataEmissaoRG = $("#dataEmissaoRG").val();
        var orgaoEmissorRG = $("#orgaoEmissorRG").val();
        var ufIdentidade = $("#ufIdentidade").val();


        //CNH
        var cnh = $("#cnh").val();
        var categoriaCNH = $("#categoriaCNH").val();
        var ufCNH = $("#ufCNH").val();
        var dataEmissaoCNH = $("#dataEmissaoCNH").val();
        var dataVencimentoCNH = $("#dataVencimentoCNH").val();
        var primeiraHabilitacaoCNH = $("#primeiraHabilitacaoCNH").val();

        //Endereço
        var cep = $("#cep").val();
        var logradouro = $("#logradouro").val();
        var numeroLogradouro = $("#numeroLogradouro").val();
        var complemento = $("#complemento").val();
        var ufLogradouro = $("#ufLogradouro").val();
        var cidade = $("#cidade").val();
        var bairro = $("#bairro").val();

        //Jsons 
        var jsonTelefoneArray = $("#jsonTelefone").val();
        var jsonEmailArray = $("#jsonEmail").val();
        var jsonDependenteArray = $("#jsonDependente").val();

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        if (!nome) {
            smartAlert("Atenção", "Informe o Nome do Funcionário", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!sindicato) {
            smartAlert("Atenção", "Informe o Sindicato", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cargo) {
            smartAlert("Atenção", "Informe o Cargo", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cpf) {
            smartAlert("Atenção", "Informe o CPF", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!matricula) {
            smartAlert("Atenção", "Informe a Matricula", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!sexo) {
            smartAlert("Atenção", "Informe o Sexo", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!dataNascimento) {
            smartAlert("Atenção", "Informe a Data de Nascimento", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!dataAdmissaoFuncionario) {
            smartAlert("Atenção", "Informe a Data de Admissão", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!pisPasep) {
            smartAlert("Atenção", "Informe o PIS/PASEP", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!numeroCarteiraTrabalho) {
            smartAlert("Atenção", "Informe o Número da Carteira de Trabalho", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!serieCarteiraTrabalho) {
            smartAlert("Atenção", "Informe a Série", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!ufCarteiraTrabalho) {
            smartAlert("Atenção", "Informe a UF da Carteira de Trabalho", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!dataExpedicaoCarteiraTrabalho) {
            smartAlert("Atenção", "Informe a Data de Expedição", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!rg) {
            smartAlert("Atenção", "Informe o RG", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!dataEmissaoRG) {
            smartAlert("Atenção", "Informe a Data de Emissão do RG", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!orgaoEmissorRG) {
            smartAlert("Atenção", "Informe o Orgão Emissor do RG", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cep) {
            smartAlert("Atenção", "Informe o CEP", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!logradouro) {
            smartAlert("Atenção", "Informe o Logradouro", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!numeroLogradouro) {
            smartAlert("Atenção", "Informe o Número do Logradouro", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!ufLogradouro) {
            smartAlert("Atenção", "Informe a UF do Logradouro", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!cidade) {
            smartAlert("Atenção", "Informe a Cidade", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!bairro) {
            smartAlert("Atenção", "Informe o bairro", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        gravaFuncionario(id, nome, sindicato, cargo, cpf, matricula, sexo, dataNascimento, dataAdmissaoFuncionario,
            dataDemissaoFuncionario, dataCancelamentoPlanoSaude, pisPasep, numeroCarteiraTrabalho, serieCarteiraTrabalho, ufCarteiraTrabalho, dataExpedicaoCarteiraTrabalho,
            rg, dataEmissaoRG, orgaoEmissorRG, cnh, categoriaCNH, ufCNH, dataEmissaoCNH, dataVencimentoCNH, primeiraHabilitacaoCNH,
            cep, logradouro, numeroLogradouro, complemento, ufLogradouro, cidade, bairro, jsonTelefoneArray, jsonEmailArray,
            jsonDependenteArray, ufIdentidade,
            function(data) {
                if (data.indexOf('failed') > -1) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#btnGravar").prop('disabled', false);
                    } else {
                        smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                        $("#btnGravar").prop('disabled', false);
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



        if ($("#telefonePrincipal").is(':checked') === true) {
            telefonePrincipalMarcado = 1;
        }


        if (tel === '') {
            smartAlert("Erro", "Informe um telefone.", "error");
            return false;
        }

        if (!phonenumber(tel)) {
            smartAlert("Erro", "Informe um telefone correto.", "error");
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


        return true;
    }


    function phonenumber(inputtxt) {
        var phoneno = /(0?[1-9]{2})*\D*(9?)\D?(\d{4})+\D?(\d{4})\b/g;
        if ((inputtxt.match(phoneno))) {
            return true;
        } else {
            return false;
        }
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

    //############################################################################## LISTA DEPENDENTE INICIO ####################################################################################################################

    function fillTableDependente() {
        $("#tableDependente tbody").empty();
        for (var i = 0; i < jsonDependenteArray.length; i++) {
            var row = $('<tr />');
            $("#tableDependente tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonDependenteArray[i].sequencialDependente + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaDependente(' + jsonDependenteArray[i].sequencialDependente + ');">' + jsonDependenteArray[i].nomeDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].descricaoDataNascimentoDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].descricaoGrauParentesco + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].cpfDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].rgDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].orgaoEmissorDependente + '</td>'));
        }
    }

    function validaDependente() {
        var achouCPF = false;
        var achouRG = false;
        var cpfDependente = $('#cpfDependente').val();
        var rgDependente = $('#rgDependente').val();
        var sequencial = +$('#sequencialDependente').val();

        if (cpfDependente === '') {
            smartAlert("Erro", "Informe o CPF do Dependente", "error");
            return false;
        }


        for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
            if (cpfDependente !== "") {
                if ((jsonDependenteArray[i].cpfDependente === cpfDependente) && (jsonDependenteArray[i].sequencialDependente !== sequencial)) {
                    achouCPF = true;
                    break;
                }
            }

            if (rgDependente !== "") {
                if ((jsonDependenteArray[i].rgDependente === rgDependente) && (jsonDependenteArray[i].sequencialDependente !== sequencial)) {
                    achouRG = true;
                    break;
                }
            }

        }

        if (achouRG === true) {
            smartAlert("Erro", "Já existe o RG do Dependente na lista.", "error");
            return false;
        }

        if (achouCPF === true) {
            smartAlert("Erro", "Já existe o CPF do Dependente na lista.", "error");
            return false;
        }


        return true;
    }

    function addDependente() {
        var item = $("#formDependente").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataDependente
        });

        if (item["sequencialDependente"] === '') {
            if (jsonDependenteArray.length === 0) {
                item["sequencialDependente"] = 1;
            } else {
                item["sequencialDependente"] = Math.max.apply(Math, jsonDependenteArray.map(function(o) {
                    return o.sequencialDependente;
                })) + 1;
            }
            item["dependenteId"] = 0;
        } else {
            item["sequencialDependente"] = +item["sequencialDependente"];
        }

        var index = -1;
        $.each(jsonDependenteArray, function(i, obj) {
            if (+$('#sequencialDependente').val() === obj.sequencialDependente) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonDependenteArray.splice(index, 1, item);
        else
            jsonDependenteArray.push(item);

        $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
        fillTableDependente();
        clearFormDependente();

    }

    function processDataDependente(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "descricaoGrauParentesco")) {
            return {
                name: fieldName,
                value: $("#grauParentescoDependente option:selected").text()
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoDataNascimentoDependente")) {

            return {
                name: fieldName,
                value: $("#dataNascimentoDependente").val()
            };
        }

        if (fieldName !== '' && (fieldId === "dataNascimentoDependente")) {

            var dataNascimentoDependente = $('#dataNascimentoDependente').val();
            dataNascimentoDependente = dataNascimentoDependente.split("/");
            dataNascimentoDependente = dataNascimentoDependente[2] + "/" + dataNascimentoDependente[1] + "/" + dataNascimentoDependente[0];

            return {
                name: fieldName,
                value: dataNascimentoDependente
            };
        }

        return false;
    }

    function clearFormDependente() {
        $("#nomeDependente").val('');
        $("#dataNascimentoDependente").val('');
        $("#grauParentescoDependente").val('');
        $("#cpfDependente").val('');
        $("#rgDependente").val('');
        $("#orgaoEmissor").val('');
        $("#dependenteId").val('');
        $("#sequencialDependente").val('');
        $('#descricaoGrauParentesco').val('');
        $('#descricaoDataNascimentoDependente').val('');
        $('#orgaoEmissorDependente').val('');

    }

    function carregaDependente(sequencialDependente) {
        var arr = jQuery.grep(jsonDependenteArray, function(item, i) {
            return (item.sequencialDependente === sequencialDependente);
        });

        clearFormDependente();

        if (arr.length > 0) {
            var item = arr[0];
            $("#nomeDependente").val(item.nomeDependente);
            $("#dataNascimentoDependente").val(item.descricaoDataNascimentoDependente);
            $("#grauParentescoDependente").val(item.grauParentescoDependente);
            $("#cpfDependente").val(item.cpfDependente);
            $("#rgDependente").val(item.rgDependente);
            $("#orgaoEmissorDependente").val(item.orgaoEmissorDependente);
            $("#dependenteId").val(item.dependenteId);
            $("#sequencialDependente").val(item.sequencialDependente);
            $('#descricaoGrauParentesco').val(item.descricaoGrauParentesco);


        }
    }


    function excluirDependente() {
        var arrSequencial = [];
        $('#tableDependente input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
                var obj = jsonDependenteArray[i];
                if (jQuery.inArray(obj.sequencialDependente, arrSequencial) > -1) {
                    jsonDependenteArray.splice(i, 1);
                }
            }
            $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
            fillTableDependente();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 dependente para excluir.", "error");
    }

    //############################################################################## LISTA DEPENDENTE FIM #######################################################################################################################
</script>