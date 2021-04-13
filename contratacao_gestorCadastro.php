<?php
//initilize the page
include("js/repositorio.php");
require_once("inc/init.php");


//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('GESTOR_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('GESTOR_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('GESTOR_EXCLUIR', $arrayPermissao, true));

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

$sql = "SELECT * FROM Ntl.parametro";
$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$row = $result[0];
if ($row) {

    $linkUpload = $row['linkUpload'];
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Recursos Humanos";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['recursoshumanos']['sub']["contratacao"]['sub']["gestor"]["active"] = true;

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
                            <h2>Tela para uso do Gestor</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formControleGestor" method="post">
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
                                                            <section class="col col-6">
                                                                <label class="label">Funcionário</label>
                                                                <label class="input">
                                                                    <input id="funcionario" name="funcionario" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-10">
                                                                <label class="label" for="tipoContrato">Tipo de Contrato
                                                                    de Trabalho</label>
                                                                <label class="select">
                                                                    <select id="tipoContrato" name="tipoContrato" class="required">
                                                                        <option></option>
                                                                        <option value="1">1 - Prazo Indeterminado
                                                                        </option>
                                                                        <option value="2">2 - Prazo Determinado,
                                                                            definido em dias, COM cláusula assecuratória
                                                                            de direito recíproco de rescisão antecipada
                                                                        </option>
                                                                        <option value="3">3 - Prazo Determinado,
                                                                            definido em dias, SEM cláusula assecuratória
                                                                            de direito recíproco de rescisão antecipada
                                                                            (EXPERIÊNCIA)</option>
                                                                        <option value="4">4 - Prazo Determinado,
                                                                            vinculado a ocorrência de um fato, COM
                                                                            cláusula assecuratória de direito recíproco
                                                                            de rescisão antecipada</option>
                                                                        <option value="5">5 - Prazo Determinado,
                                                                            vinculado a ocorrência de um fato, SEM
                                                                            cláusula assecuratória de direito recíproco
                                                                            de rescisão antecipada</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Prazo Determinado(dias)</label>
                                                                <label class="input"><i></i>
                                                                    <input id="prazoDeterminado" name="prazoDeterminado" class="number required" value="" autocomplete="new-password" maxlength="3">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Data admissão</label>
                                                                <label class="input">
                                                                    <input id="dataAdmissao" name="dataAdmissao" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataAdmissao')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, numeroCentroCusto, descricao, apelido FROM Ntl.projeto where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
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
                                                            <section class="col col-4">
                                                                <label class="label" for="cargo">Cargo</label>
                                                                <label class="select">
                                                                    <select id="cargo" name="cargo" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, codigoCargoSCI, descricao  FROM Ntl.cargo where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $codigoCargoSCI = $row['codigoCargoSCI'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $codigoCargoSCI . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CBO</label>
                                                                <label class="input"><i></i>
                                                                    <input id="cbo" name="cbo" class="readonly" autocomplete="new-password" type="text" value="" readonly>
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">

                                                            <section class="col col-2">
                                                                <label class="label" for="experiencia">Experiência</label>
                                                                <label class="select">
                                                                    <select id="experiencia" name="experiencia" class="required">
                                                                        <option></option>
                                                                        <option value="0">45 x 45</option>
                                                                        <option value="1">30 x 60</option>
                                                                        <option value="2">60 x 30</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="sindicato">Sindicato</label>
                                                                <label class="select">
                                                                    <select id="sindicato" name="sindicato" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigoSindicatoSCI AS codigo, descricao, apelido FROM Ntl.sindicato where situacao = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            $apelido = ($row['apelido']);
                                                                            echo '<option value=' . $codigo . '> ' . $codigo . ' - ' . $apelido . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Salário base</label>
                                                                <label class="input"><i></i>
                                                                    <input id="salarioBase" name="salarioBase" class="decimal-2-casas required text-right" autocomplete="new-password" type="text" value="">
                                                                </label>
                                                            </section>



                                                            <section class="col col-2">
                                                                <label class="label">Verificado pelo Gestor</label>
                                                                <label class="input"><i></i>
                                                                    <input id="verificadoPeloGestor" name="verificadoPeloGestor" class="readonly" autocomplete="new-password" type="text" value="" readonly>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="tipoEscala">Tipo de
                                                                    escala</label>
                                                                <label class="select">
                                                                    <select id="tipoEscala" name="tipoEscala" class="required">
                                                                        <option></option>
                                                                        <option value="1">Normal</option>
                                                                        <option value="2">Revezamento</option>
                                                                        <option value="3">Nenhum</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data início revezamento</label>
                                                                <label class="input">
                                                                    <input id="dataInicioRevezamento" name="dataInicioRevezamento" type="text" data-dateformat="dd/mm/yy" class="readonly" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataInicioRevezamento')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="tipoRevezamento">Tipo de
                                                                    revezamento</label>
                                                                <label class="select">
                                                                    <select id="tipoRevezamento" name="tipoRevezamento" class="readonly">
                                                                        <option></option>
                                                                        <option value="1">12 x 36</option>
                                                                        <option value="2">24 x 48</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="escalaHorario">Escala/Horário</label>
                                                                <label class="select">
                                                                    <select id="escalaHorario" name="escalaHorario" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.escala order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $codigo . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

  
                                                            <section class="col col-2">
                                                                <label class="label">Data Final</label>
                                                                <label class="input">
                                                                    <input id="dataFinal" name="dataFinal" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataFinal')">
                                                                </label>
                                                            </section>

                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Dados Funcionario Consulta -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapsePlanoSaude" class="collapsed" id="accordionPlanoSaude">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados do funcionario para consulta
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapsePlanoSaude" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Dados Pessoais</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Nome Completo</label>
                                                                <label class="input"><i></i>
                                                                    <input id="nomeCompleto" maxlength="255" name="nomeCompleto" class="readonly" readonly autocomplete="new-password" type="text" value="" onchange="verificaNome('#nomeCompleto')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataNascimento')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Estado Civíl</label>
                                                                <label class="select">
                                                                    <select name="estadoCivil" id="estadoCivil" autocomplete="off" class="form-control readonly" readonly autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="0">Solteiro</option>
                                                                        <option value="1">Casado</option>
                                                                        <option value="2">Separado Judicialmente
                                                                        </option>
                                                                        <option value="3">Divorciado</option>
                                                                        <option value="4">Viúvo</option>
                                                                        <option value="5">União Estável</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Contato</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Telefone Residêncial</label>
                                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                                    <input id="telefoneResidencial" maxlength="64" name="telefoneResidencial" type="text" autocomplete="new-password" class="readonly" readonly data-mask-placeholder="X" data-mask="(99) 9999-9999" class="" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Telefone Celular</label>
                                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                                    <input id="telefoneCelular" maxlength="64" name="telefoneCelular" type="text" autocomplete="new-password" class="readonly" readonly value="" data-mask="(99) 99999-9999">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Celular Recado</label>
                                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                                    <input id="outroTelefone" maxlength="64" name="outroTelefone" type="text" autocomplete="new-password" class="readonly" readonly value="" data-mask="(99) 99999-9999">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">E-mail</label>
                                                                <label class="input"><i class="icon-append fa fa-envelope"></i>
                                                                    <input id="email" maxlength="64" name="email" type="text" autocomplete="new-password" class="readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Endereço</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="cep">CEP</label>
                                                                <label class="input">
                                                                    <input placeholder="XXXXX-XXX" id="cep" name="cep" class="readonly" readonly autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="cep">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Endereço</label>
                                                                <label class="input">
                                                                    <input id="endereco" maxlength="64" name="endereco" type="text" autocomplete="new-password" class="readonly" readonly value="" onchange="verificaNome('#endereco')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" maxlength="64" name="bairro" type="text" autocomplete="new-password" class="readonly" readonly value="" onchange="verificaNome('#bairro')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Estado</label>
                                                                <label class="input">
                                                                    <input id="estado" maxlength="3" name="estado" type="text" autocomplete="new-password" class="readonly" readonly value="" onchange="verificaNome('#bairro')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" maxlength="64" name="cidade" type="text" autocomplete="new-password" class="readonly" readonly value="" onchange="verificaNome('#cidade')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Numero</label>
                                                                <label class="input">
                                                                    <input id="numero" maxlength="10" name="numero" type="text" autocomplete="new-password" class="readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" maxlength="64" name="complemento" type="text" autocomplete="new-password" class="readonly" readonly value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" data-mask-placeholder="X" data-mask="999.999.999-99" name="cpf" type="text" class="readonly" readonly autocomplete="off" onchange="verificaCpf('#cpf')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">PIS</label>
                                                                <label class="input">
                                                                    <input id="pis" data-mask-placeholder="X" data-mask="999.99999.99-9" name="pis" type="text" class="readonly" readonly autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Carteira de Trabalho</label>
                                                                <label class="input">
                                                                    <input id="carteiraTrabalho" name="carteiraTrabalho" type="text" class="readonly" readonly autocomplete="off" maxlength="10">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Serie</label>
                                                                <label class="input">
                                                                    <input id="carteiraTrabalhoSerie" name="carteiraTrabalhoSerie" type="text" class="readonly" readonly autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Expedição</label>
                                                                <label class="input">
                                                                    <input id="dataExpedicaoCarteiraTrabalho" name="dataExpedicaoCarteiraTrabalho" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataExpedicaoCarteiraTrabalho')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="estado">UF Emissão
                                                                    CTPS</label>
                                                                <label class="input">
                                                                    <input id="localCarteiraTrabalho" name="localCarteiraTrabalho" type="text" class="readonly" readonly autocomplete="off" maxlength="13">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">RG</label>
                                                                <label class="input">
                                                                    <input id="rg" name="rg" type="text" class="readonly" readonly autocomplete="off" maxlength="13">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Orgão Emissor RG</label>
                                                                <label class="input">
                                                                    <input id="emissorRg" name="emissorRg" maxlength="25" type="text" class="readonly" readonly autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">UF RG</label>
                                                                <label class="input">
                                                                    <input id="localRg" name="localRg" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: left" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataEmissaoRg')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Emissão RG</label>
                                                                <label class="input">
                                                                    <input id="dataEmissaoRg" name="dataEmissaoRg" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataEmissaoRg')">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CNH</label>
                                                                <label class="input">
                                                                    <input id="cnh" name="cnh" type="text" data-mask="99999999999" class="readonly" readonly autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Categoria CNH</label>
                                                                <label class="select">
                                                                    <select name="categoriaCnh" id="categoriaCnh" autocomplete="new-password" class="form-control readonly">
                                                                        <option></option>
                                                                        <option value="0">Categoria A</option>
                                                                        <option value="1">Categoria B</option>
                                                                        <option value="2">Categoria C</option>
                                                                        <option value="3">Categoria E</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="estado">UF CNH</label>
                                                                <label class="input">
                                                                    <input id="ufCnh" name="ufCnh" type="text" class="readonly" readonly style="text-align: center" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Emissão CNH</label>
                                                                <label class="input">
                                                                    <input id="dataEmissaoCnh" name="dataEmissaoCnh" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataEmissaoCnh')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Vencimento CNH</label>
                                                                <label class="input">
                                                                    <input id="dataVencimentoCnh" name="dataVencimentoCnh" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataVencimentoCnh')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Primeira CNH</label>
                                                                <label class="input">
                                                                    <input id="primeiraCnh" name="primeiraCnh" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#primeiraCnh')">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Titulo de eleitor</label>
                                                                <label class="input">
                                                                    <input id="tituloEleitor" maxlength="12" name="tituloEleitor" type="text" class="readonly" readonly autocomplete="off" onchange="verificaNumero('#tituloEleitor')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Zona</label>
                                                                <label class="input">
                                                                    <input id="zonaTituloEleitor" maxlength="3" name="zonaTituloEleitor" type="text" class="readonly" readonly autocomplete="off" onchange="verificaNumero('#zonaTituloEleitor')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Seção</label>
                                                                <label class="input">
                                                                    <input id="secaoTituloEleitor" maxlength="4" name="secaoTituloEleitor" type="text" class="readonly" readonly autocomplete="off" onchange="verificaNumero('#secaoTituloEleitor')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Certificado de reservista</label>
                                                                <label class="input">
                                                                    <input id="certificadoReservista" data-mask="999999999999" name="certificadoReservista" type="text" class="readonly" readonly autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Escolaridade</strong></legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Grau de Instrução</label>
                                                                <label class="select">
                                                                    <select name="grauInstrucao" id="grauInstrucao" autocomplete="new-password" class="form-control readonly">
                                                                        <option></option>
                                                                        <option value="1">1 - Analfabeto</option>
                                                                        <option value="2">2 - Ensino fundamental
                                                                            incompleto (1º - 5º Incompleto)</option>
                                                                        <option value="3">3 - Ensino fundamenta
                                                                            incompleto (5° Ano Completo)</option>
                                                                        <option value="4">4 - Ensino fundamental
                                                                            incompleto (6º - 9° Incompleto)</option>
                                                                        <option value="5">5 - Ensino fundamental
                                                                            completo</option>
                                                                        <option value="6">6 - Ensino médio incompleto
                                                                        </option>
                                                                        <option value="7">7 - Ensino médio completo
                                                                        </option>
                                                                        <option value="8">8 - Educação superior
                                                                            incompleta</option>
                                                                        <option value="9">9 - Educação superior completa
                                                                        </option>
                                                                        <option value="10">10 - Pós Graduação</option>
                                                                        <option value="11">11 - Mestrado completo
                                                                        </option>
                                                                        <option value="12">12 - Doutorado completo
                                                                        </option>
                                                                        <option value="13">13 - Pós-doutorado</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-8">
                                                                <label class="label">Atividades Extracurriculares
                                                                    (Cursos Realizados - Descrever)</label>
                                                                <label class="input">
                                                                    <textarea id="atividadesExtracurriculares" name="atividadesExtracurriculares" maxlength="2000" type="text" class="form-control readonly" readonly autocomplete="new-password" rows="4" style="resize:vertical"></textarea>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Informações do Cônjuge</strong>
                                                                </legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Nome</label>
                                                                <label class="input">
                                                                    <input id="nomeConjuge" maxlength="64" name="nomeConjuge" type="text" autocomplete="new-password" class="readonly" readonly value="" onchange="verificaNome('#nomeConjuge')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNascimentoConjuge" name="dataNascimentoConjuge" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataNascimentoConjuge')">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <!--  LISTA DE FILHOS -->
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Dado dos Filhos até 14 anos</strong>
                                                                </legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonFilho" name="jsonFilho" type="hidden" value="[]">
                                                        <div id="formFilho">
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableFilho" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <!-- <th></th> -->
                                                                            <th class="text-left" style="min-width: 10px;">Nome</th>
                                                                            <th class="text-left" style="min-width: 10px;">CPF</th>
                                                                            <th class="text-left" style="min-width: 10px;">Data de
                                                                                Nascimento</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>




                                                            <!--  LISTA DE DEPENDENTES -->
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Informações de Dependente para
                                                                            IRRF</strong></legend>
                                                                </section>
                                                            </div>
                                                            <input id="jsonDependente" name="jsonDependente" type="hidden" value="[]">
                                                            <div id="formDependente">
                                                                <div class="row">
                                                                    <input id="DependenteId" name="DependenteId" type="hidden" value="">
                                                                    <input id="descricaoDataNascimentoDependente" name="descricaoDataNascimentoDependente" type="hidden" value="">
                                                                    <input id="sequencialDependente" name="sequencialDependente" type="hidden" value="">

                                                                    <section class="col col-2">
                                                                        <label class="label"></label>
                                                                        <label class="select hidden">
                                                                            <select name="grauParentescoDependente" id="grauParentescoDependente" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                                <option></option>
                                                                                <option value="1">01 - Cônjuge</option>
                                                                                <option value="2">02 - Companheiro(a)
                                                                                    com o(a) qual tenha filho(s) ou viva
                                                                                    há mais de 5 (cinco) anos ou possua
                                                                                    declaração de união estável</option>
                                                                                <option value="3">03 - Filho(a) ou
                                                                                    enteado(a)</option>
                                                                                <option value="4">04 - Filho(a) ou
                                                                                    enteado(a) universitário(a) ou
                                                                                    cursando escola técnica de 2º grau,
                                                                                    até 24 (vinte e quatro) anos
                                                                                </option>
                                                                                <option value="6">06 - Irmão(ã), neto(a)
                                                                                    ou bisneto(a) sem arrimo dos pais,
                                                                                    do(a) qual detenha a guarda judicial
                                                                                </option>
                                                                                <option value="9">09 - Pais, avós e
                                                                                    bisavós</option>
                                                                                <option value="10">10 - Menor pobre do
                                                                                    qual detenha a guarda judicial
                                                                                </option>
                                                                                <option value="11">11 - A pessoa
                                                                                    absolutamente incapaz, da qual seja
                                                                                    tutor ou curador</option>
                                                                                <option value="12">12 - Ex-cônjuge
                                                                                </option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableDependente" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <!-- <th></th> -->
                                                                                <th class="text-left" style="min-width: 10px;">Nome</th>
                                                                                <th class="text-left" style="min-width: 10px;">CPF</th>
                                                                                <th class="text-left" style="min-width: 10px;">Data de
                                                                                    Nascimento</th>
                                                                                <th class="text-left" style="min-width: 10px;">Parentesco
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong>Informações Adicionais</strong>
                                                                        </legend>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label">Trabalha Atualmente</label>
                                                                        <label class="select">
                                                                            <select name="trabalhaAtualmente" id="trabalhaAtualmente" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="0">Sim</option>
                                                                                <option value="1">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Está em Seguro
                                                                            Desemprego</label>
                                                                        <label class="select">
                                                                            <select name="seguroDesemprego" id="seguroDesemprego" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="0">Sim</option>
                                                                                <option value="1">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong>Benefícios</strong></legend>
                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label">Deseja Assistência
                                                                            Médica</label>
                                                                        <label class="select">
                                                                            <select name="desejaAssistenciaMedica" id="desejaAssistenciaMedica" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="1">Sim</option>
                                                                                <option value="0">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Deseja Assistência
                                                                            Odontológica</label>
                                                                        <label class="select">
                                                                            <select name="desejaAssistenciaOdontologica" id="desejaAssistenciaOdontologica" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="1">Sim</option>
                                                                                <option value="0">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label">Vale Refeição / Vale
                                                                            Alimentação</label>
                                                                        <label class="select">
                                                                            <select name="valeRefeicaoValeAlimentacao" id="valeRefeicaoValeAlimentacao" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="0">Vale Refeição</option>
                                                                                <option value="1">Vale Alimentação
                                                                                </option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-2">
                                                                        <label class="label">Deseja Vale
                                                                            Transporte</label>
                                                                        <label class="select">
                                                                            <select name="desejaVt" id="desejaVt" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="1">Sim</option>
                                                                                <option value="0">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Possui Cartão
                                                                            Transporte</label>
                                                                        <label class="select">
                                                                            <select name="possuiVt" id="possuiVt" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="1">Sim</option>
                                                                                <option value="0">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label" for="numeroCartaoVt">Numero Cartão Transporte</label>
                                                                        <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                            <input id="numeroCartaoVt" name="numeroCartaoVt" data-mask="9999999999999" autocomplete="new-password" class="readonly" readonly>
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong>Dados Bancários</strong>
                                                                        </legend>
                                                                    </section>
                                                                </div>

                                                                <div class=row>
                                                                    <section class="col col-2">
                                                                        <label class="label">Tipo de conta</label>
                                                                        <label class="select">
                                                                            <select name="tipoConta" id="tipoConta" autocomplete="new-password" class="form-control readonly">
                                                                                <option value="0" selected></option>
                                                                                <option value="1">Corrente</option>
                                                                                <option value="2">Poupança</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <div class="row">

                                                                    <section class="col col-4">
                                                                        <label class="label " for="fk_banco">Banco</label>
                                                                        <label class="select">
                                                                            <select id="fk_banco" name="fk_banco" class="readonly" readonly>
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select codigo,codigoBanco,nomeBanco from Ntl.banco order by nomeBanco";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {

                                                                                    $codigo = $row['codigo'];
                                                                                    $codigoBanco = mb_convert_encoding($row['codigoBanco'], 'UTF-8', 'HTML-ENTITIES');
                                                                                    $nomeBanco = mb_convert_encoding($row['nomeBanco'], 'UTF-8', 'HTML-ENTITIES');
                                                                                    echo '<option value=' . $codigo . '>' . $codigoBanco . ' - ' . strtoupper($nomeBanco) . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label">Agência</label>
                                                                        <label class="input">
                                                                            <input id="agenciaBanco" name="agenciaBanco" maxlength="5" type="text" class="readonly" readonly value="" autocomplete="new-password" onchange="verificaNumero('#agenciaBanco')">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">Digito Agência</label>
                                                                        <label class="input">
                                                                            <input id="digitoAgenciaBanco" name="digitoAgenciaBanco" maxlength="2" type="text" class="readonly" readonly value="" autocomplete="new-password" onchange="verificaNumero('#digitoAgenciaBanco')">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">Variação</label>
                                                                        <label class="input">
                                                                            <input id="variacao" name="variacao" type="text" class="readonly" readonly autocomplete="new-password" maxlength="5">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">C/C</label>
                                                                        <label class="input">
                                                                            <input id="contaCorrente" name="contaCorrente" type="text" class="readonly" readonly maxlength="13" value="" autocomplete="new-password" onchange="verificaNumero('#contaCorrente')">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">Digito Conta</label>
                                                                        <label class="input">
                                                                            <input id="digitoContaBanco" name="digitoContaBanco" maxlength="2" type="text" class="readonly" readonly value="" autocomplete="new-password" onchange="verificaNumero('#digitoContaBanco')">
                                                                        </label>
                                                                    </section>

                                                                </div>

                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong>Tamanho do Uniforme</strong>
                                                                        </legend>
                                                                    </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col col-1">
                                                                        <label class="label">Camisa</label>
                                                                        <label class="select">
                                                                            <select name="numeroCamisa" id="numeroCamisa" autocomplete="new-password" class="form-control readonly" readonly>
                                                                                <option></option>
                                                                                <option value="1">PP</option>
                                                                                <option value="2">P</option>
                                                                                <option value="3">M</option>
                                                                                <option value="4">G</option>
                                                                                <option value="5">GG</option>
                                                                                <option value="6">XG</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">Calça</label>
                                                                        <label class="input">
                                                                            <input id="numeroCalca" name="numeroCalca" type="text" class="number readonly" readonly data-mask="99" value="" autocomplete="new-password" max="2">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">Saia</label>
                                                                        <label class="input">
                                                                            <input id="numeroSaia" name="numeroSaia" type="text" class="number readonly" readonly data-mask="99" value="" autocomplete="new-password" maxlength="2">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-1">
                                                                        <label class="label">Sapato</label>
                                                                        <label class="input">
                                                                            <input id="numeroSapato" name="numeroSapato" type="text" class="numeric readonly" readonly data-mask="99" maxlength="2" value="" autocomplete="new-password">
                                                                        </label>
                                                                    </section>
                                                                </div>


                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong>Documentos de qualificação
                                                                                profissional</strong></legend>
                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <label class="label">            Comprovante de
                                                                        escolaridade</label>

                                                                    <section id="comprovanteEscolaridadeFileLink" class="col col-4">

                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <label class="label">            Certificados /
                                                                        Diplomas</label>

                                                                    <section id="certificadoDiplomaFileLink" class="col col-4">

                                                                    </section>
                                                                </div>


                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <footer>

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
                                            <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                                <span class="fa fa-trash"></span>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_contratacaoGestor.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_URL; ?>/js/businessUpload.js" type="text/javascript"></script>
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
        carregaPagina();

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

        // Máscara de campos:
        $('#horasMensais').mask('99:99', {
            placeholder: "hh:mm"
        });

        $('#horasSemanais').mask('99:99', {
            placeholder: "hh:mm"
        });

        $('#horasDiarias').mask('99:99', {
            placeholder: "hh:mm"
        });

        $("#btnGravar").on("click", function() {
            gravar();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
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


        $("#prazoDeterminado,#tipoContrato,#dataAdmissao,#projeto,#cargo,#cbo,#experiencia,#sindicato,#salarioBase,#tipoEscala,#dataInicioRevezamento,#tipoRevezamento,#escalaHorario")
            .on("change", function() {
                verificaCamposGestor();
            });




        $("#dataFinal, #dataAdmissao").on("change", function() {
            var dataAdmissao = $("#dataAdmissao").val();
            var dataFinal = $("#dataFinal").val();
            var condicaoDataFinal = (dataAdmissao != "") && (dataFinal != "");

            if (dataFinal == "") {
                $("#prazoDeterminado").val("");
            }

            if (dataAdmissao == "") {
                $("#prazoDeterminado").val("");
                $("#dataFinal").val("");
            }

            if (dataAdmissao == "") {
                smartAlert("Atenção", "Digite primeiro a data de admissão do candidato!", "error");
                $("#prazoDeterminado").val("");
                $("#dataFinal").val("");
                return;
            }

            if (condicaoDataFinal) {
                if (moment.isMoment(dataAdmissao) == false) {
                    dataAdmissao = formataDataObjetoMoment(dataAdmissao);
                }
                if (moment.isMoment(dataFinal) == false) {
                    dataFinal = formataDataObjetoMoment(dataFinal);
                }
                var diferenca = (dataFinal.diff(dataAdmissao, 'days')) + 1;
                verificaDiferencaDias(diferenca);
                if (diferenca > 1) {
                    $("#prazoDeterminado").val(diferenca);
                }
            }

        });

        $("#prazoDeterminado, #dataAdmissao").on("change", function() {
            var dataAdmissao = $("#dataAdmissao").val();
            var prazoDeterminado = $("#prazoDeterminado").val();
            var condicaoDias = (prazoDeterminado != "") && (dataAdmissao != "");

            if (prazoDeterminado == "") {
                $("#dataFinal").val("");
            }

            if (dataAdmissao == "") {
                smartAlert("Atenção", "Digite primeiro a data de admissão do candidato!", "error");
                $("#prazoDeterminado").val("");
                $("#dataFinal").val("");
                return;
            }

            if (condicaoDias) {
                if (moment.isMoment(dataAdmissao) == false) {
                    dataAdmissao = formataDataObjetoMoment(dataAdmissao);
                }
                dataAdmissao = dataAdmissao.add(prazoDeterminado - 1, 'days');
                dataFinal = dataAdmissao.format("DD/MM/YYYY");
                $("#dataFinal").val(dataFinal);
            }

        });

        $("#tipoContrato").on("change", function() {
            let tipoContrato = $("#tipoContrato").val();
            let camposDesabilitados = [];
            let camposHabilitados = [];

            switch (tipoContrato) {

                default:
                    camposHabilitados = ['#experiencia', '#prazoDeterminado'];
                    habilitarCampos(camposHabilitados);
                    break;

                case "1":
                    camposDesabilitados = ['#experiencia', '#prazoDeterminado', '#dataFinal'];
                    desabilitarCampos(camposDesabilitados);
                    break;

                case "2":
                    camposHabilitados = ['#prazoDeterminado', '#dataFinal'];
                    camposDesabilitados = ['#experiencia'];
                    habilitarCampos(camposHabilitados);
                    desabilitarCampos(camposDesabilitados);
                    break;

                case "3":
                    camposHabilitados = ['#experiencia'];
                    camposDesabilitados = ['#prazoDeterminado', '#dataFinal'];
                    habilitarCampos(camposHabilitados);
                    desabilitarCampos(camposDesabilitados);
                    break;

            }
        });


        $("#cargo").on("change", function() {

            let id = $("#cargo").val();

            if (!id) {
                smartAlert("Atenção", "Selecione um cargo com código válido.", "error");
                $("#cbo").val(" ");
                return;
            }

            recuperaCbo(id, function(data) {
                if (data.indexOf('failed') > -1) {} else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];

                    $("#cbo").val(out);
                }
            });
        });

        $('#prazoDeterminado').change(function() {

            let prazoDeterminado = $("#prazoDeterminado").val();

            if (prazoDeterminado > 750) {
                smartAlert("Atenção",
                    "O limite do prazo determinado é 750 dias! (2 anos).  Favor incluir uma quantidade de dias válida.",
                    "error");
                $("#prazoDeterminado").val("");
            }
            alternarEntreExperienciaEPrazoDeterminado();

        });

        $('#experiencia').change(function() {
            alternarEntreExperienciaEPrazoDeterminado();
        });

        $('#tipoEscala').change(function() {
            let tipoEscala = +$('#tipoEscala').val();
            if (tipoEscala == 2) {

                let camposHabilitados = ['#dataInicioRevezamento', '#tipoRevezamento'];
                habilitarCampos(camposHabilitados);

            } else {

                let camposDesabilitados = ['#dataInicioRevezamento', '#tipoRevezamento'];
                desabilitarCampos(camposDesabilitados);
            }
        });

        $('#tipoConta').prop('disabled', true);
        $('#fk_banco').prop('disabled', true);
        $('#possuiVt').prop('disabled', true);
        $('#desejaVt').prop('disabled', true);
        $('#valeRefeicaoValeAlimentacao').prop('disabled', true);
        $('#desejaAssistenciaOdontologica').prop('disabled', true);
        $('#desejaAssistenciaMedica').prop('disabled', true);
        $('#seguroDesemprego').prop('disabled', true);
        $('#trabalhaAtualmente').prop('disabled', true);
        $('#grauParentescoDependente').prop('disabled', true);
        $('#grauInstrucao').prop('disabled', true);
        $('#ufCnh').prop('disabled', true);
        $('#categoriaCnh').prop('disabled', true);
        $('#localRg').prop('disabled', true);
        $('#estadoCivil').prop('disabled', true);
        $('#numeroCamisa').prop('disabled', true);



        $("input[name='certificadoDiplomaFile[]']").change(function() {
            let files = document.getElementById("certificadoDiplomaFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 4718592; //1MB = 1048576 | 4,5MB = 4718592
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#certificadoDiplomaText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção",
                    "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 4.5MB",
                    "error");
                $("#certificadoDiplomaText").val("");
                $("#certificadoDiplomaFile").val("");

            }

        });

    });

    function carregaPagina() {

        //Ao carregar a página, as seguintes variaveis não podem ser alteradas: 
        let camposDesabilitados = ['#experiencia', '#prazoDeterminado', '#tipoRevezamento', '#dataInicioRevezamento',
            '#dataFinal'
        ];
        desabilitarCampos(camposDesabilitados);

        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {

            var variaveisUrl = params[1];
            variaveisUrl = variaveisUrl.split("&");

            //Recupera o código
            var id = variaveisUrl[0];
            var idx = id.split("=");
            var idd = idx[1];

            //Recupera o código do  funcionário
            var func = variaveisUrl[1];
            var codigoFunc = func.split("=");
            var codigoFuncionario = codigoFunc[1];

            if (codigoFuncionario !== "") {
                //Recupera no banco o nome completo de acordo com o código do filtro. 
                let id = codigoFuncionario;
                recuperaValores(id, function(data) {
                    if (data.indexOf('failed') > -1) {} else {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        var out = piece[1];
                        var strArrayFilho = piece[2];
                        var strArrayDependente = piece[3];

                        piece = out.split("^");

                        $("#nomeCompleto, #funcionario").val(piece[0]);
                        $("#dataNascimento").val(piece[1]);
                        $("#estadoCivil").val(piece[2]);
                        $("#telefoneResidencial").val(piece[3]);
                        $("#telefoneCelular").val(piece[4]);
                        $("#outroTelefone").val(piece[5]);
                        $("#email").val(piece[6]);
                        $("#cep").val(piece[7]);
                        $("#endereco").val(piece[8]);
                        $("#bairro").val(piece[9]);
                        $("#estado").val(piece[10]);
                        $("#cidade").val(piece[11]);
                        $("#numero").val(piece[12]);
                        $("#complemento").val(piece[13]);
                        $("#cpf").val(piece[14]);
                        $("#pis").val(piece[15]);
                        $("#carteiraTrabalho").val(piece[16]);
                        $("#carteiraTrabalhoSerie").val(piece[17]);
                        $("#dataExpedicaoCarteiraTrabalho").val(piece[18]);
                        $("#localCarteiraTrabalho").val(piece[19]);
                        $("#rg").val(piece[20]);
                        $("#emissorRg").val(piece[21]);
                        $("#localRg").val(piece[22]);
                        $("#dataEmissaoRg").val(piece[23]);
                        $("#cnh").val(piece[24]);
                        $("#categoriaCnh").val(piece[25]);
                        $("#ufCnh").val(piece[26]);
                        $("#dataEmissaoCnh").val(piece[27]);
                        $("#dataVencimentoCnh").val(piece[28]);
                        $("#primeiraCnh").val(piece[29]);
                        $("#tituloEleitor").val(piece[30]);
                        $("#zonaTituloEleitor").val(piece[31]);
                        $("#secaoTituloEleitor").val(piece[32]);
                        $("#certificadoReservista").val(piece[33]);
                        $("#grauInstrucao").val(piece[34]);
                        $("#atividadesExtracurriculares").val(piece[35]);
                        $("#nomeConjuge").val(piece[36]);
                        $("#dataNascimentoConjuge").val(piece[37]);
                        $("#trabalhaAtualmente").val(piece[38]);
                        $("#seguroDesemprego").val(piece[39]);
                        $("#desejaAssistenciaMedica").val(piece[40]);
                        $("#desejaAssistenciaOdontologica").val(piece[41]);
                        $("#valeRefeicaoValeAlimentacao").val(piece[42]);
                        $("#desejaVt").val(piece[43]);
                        $("#possuiVt").val(piece[44]);
                        $("#numeroCartaoVt").val(piece[45]);
                        $("#agenciaBanco").val(piece[46]);
                        $("#digitoAgenciaBanco").val(piece[47]);
                        $("#contaCorrente").val(piece[48]);
                        $("#digitoContaBanco").val(piece[49]);
                        $("#fk_banco").val(piece[50]);
                        $("#variacao").val(piece[51]);
                        $("#tipoConta").val(piece[52]);
                        $("#numeroCamisa").val(piece[53]);
                        $("#numeroCalca").val(piece[54]);
                        $("#numeroSaia").val(piece[55]);
                        $("#numeroSapato").val(piece[56]);
                        $("#logradouro").val(piece[57]);


                        $("#jsonFilho").val(strArrayFilho);
                        $("#jsonDependente").val(strArrayDependente);
                        jsonFilhoArray = JSON.parse($("#jsonFilho").val());
                        jsonDependenteArray = JSON.parse($("#jsonDependente").val());
                        fillTableFilho();
                        fillTableDependente();

                    }
                });

                recuperaUpload(codigoFuncionario,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var arrayDocumentos = JSON.parse(piece[1]);
                            for (let index = 0; index < arrayDocumentos.length; index++) {
                                let nomeArquivo = arrayDocumentos[index].nomeArquivo;
                                let tipoArquivo = arrayDocumentos[index].tipoArquivo;
                                let enderecoDocumento = arrayDocumentos[index].enderecoDocumento;
                                let nomeCampo = arrayDocumentos[index].idCampo + "." + tipoArquivo;
                                let idCampo = arrayDocumentos[index].idCampo + "Link";
                                let diretorio = "<?php echo $linkUpload ?>" + enderecoDocumento + nomeArquivo;

                                $("#" + idCampo).append("<a href ='" + diretorio + "' target='_blank'>" + nomeCampo +
                                    "</a><br>");

                            }
                        }
                    });
            }

            if (idd !== "") {
                recuperaCadastroFuncionario(idd, function(data) {
                    if (data.indexOf('failed') > -1) {} else {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        var out = piece[1];
                        var strArrayFilho = piece[2];
                        var strArrayDependente = piece[3];
                        let verificadoPeloGestor = "";

                        piece = out.split("^");

                        codigo = piece[0];
                        nomeCompleto = piece[1];
                        tipoContrato = piece[2];
                        dataAdmissao = piece[3];
                        projeto = piece[4];
                        cargo = piece[5];
                        cbo = piece[6];
                        experiencia = piece[7];
                        sindicato = piece[8];
                        salarioBase = piece[9];
                        //Mostra apenas dois pontos decimais para o usuário, e com vírgula.
                        salarioBase = roundDecimal(floatToString(salarioBase), 2);
                        tipoEscala = piece[10];
                        dataInicioRevezamento = piece[11];
                        tipoRevezamento = piece[12];
                        escalaHorario = piece[13];
                        verificado = piece[14];
                        dataNascimento = piece[15];
                        estadoCivil = piece[16];
                        telefoneResidencial = piece[17];
                        telefoneCelular = piece[18];
                        outroTelefone = piece[19];
                        email = piece[20];
                        cep = piece[21];
                        endereco = piece[22];
                        bairro = piece[23];
                        numero = piece[24];
                        complemento = piece[25];
                        estado = piece[26];
                        cidade = piece[27];
                        cpf = piece[28];
                        pis = piece[29];
                        carteiraTrabalho = piece[30];
                        carteiraTrabalhoSerie = piece[31];
                        dataExpedicaoCarteiraTrabalho = piece[32];
                        localCarteiraTrabalho = piece[33];
                        rg = piece[34];
                        emissorRg = piece[35];
                        localRg = piece[36];
                        dataEmissaoRg = piece[37];
                        cnh = piece[38];
                        categoriaCnh = piece[39];
                        ufCnh = piece[40];
                        dataEmissaoCnh = piece[41];
                        dataVencimentoCnh = piece[42];
                        primeiraCnh = piece[43];
                        tituloEleitor = piece[44];
                        zonaTituloEleitor = piece[45];
                        secaoTituloEleitor = piece[46];
                        certificadoReservista = piece[47];
                        grauInstrucao = piece[48];
                        atividadesExtracurriculares = piece[49];
                        nomeConjuge = piece[50];
                        dataNascimentoConjuge = piece[51];
                        trabalhaAtualmente = piece[52];
                        seguroDesemprego = piece[53];
                        desejaAssistenciaMedica = piece[54];
                        desejaAssistenciaOdontologica = piece[55];
                        valeRefeicaoValeAlimentacao = piece[56];
                        desejaVt = piece[57];
                        possuiVt = piece[58];
                        numeroCartaoVt = piece[59];
                        agenciaBanco = piece[60];
                        digitoAgenciaBanco = piece[61];
                        contaCorrente = piece[62];
                        digitoContaBanco = piece[63];
                        fk_banco = piece[64];
                        variacao = piece[65];
                        tipoConta = piece[66];
                        numeroCamisa = piece[67];
                        numeroCalca = piece[68];
                        numeroSaia = piece[69];
                        numeroSapato = piece[70];
                        prazoDeterminado = piece[71];
                        dataFinal = piece[72];

                        $("#codigo").val(codigo);
                        $("#funcionario").val(nomeCompleto);
                        $("#tipoContrato").val(tipoContrato);
                        $("#dataAdmissao").val(dataAdmissao);
                        $("#projeto").val(projeto);
                        $("#cargo").val(cargo);
                        $("#cbo").val(cbo);
                        $("#experiencia").val(experiencia);
                        $("#sindicato").val(sindicato);
                        $("#salarioBase").val(salarioBase);
                        $("#tipoEscala").val(tipoEscala);
                        $("#dataInicioRevezamento").val(dataInicioRevezamento);
                        $("#tipoRevezamento").val(tipoRevezamento);
                        $("#escalaHorario").val(parseFloat(escalaHorario));

                        if (verificado == 1) {
                            verificadoPeloGestor = 'Sim';
                        } else {
                            verificadoPeloGestor = 'Não';
                        }

                        $("#verificadoPeloGestor").val(verificadoPeloGestor);
                        $('#nomeCompleto').val(nomeCompleto)
                        $("#dataNascimento").val(dataNascimento);
                        $("#estadoCivil").val(estadoCivil);
                        $("#telefoneResidencial").val(telefoneResidencial);
                        $('#telefoneCelular').val(telefoneCelular)
                        $("#outroTelefone").val(outroTelefone);
                        $("#email").val(email);
                        $("#cep").val(cep);
                        $("#endereco").val(endereco);
                        $('#bairro').val(bairro)
                        $("#numero").val(numero);
                        $("#complemento").val(complemento);
                        $("#estado").val(estado);
                        $("#cidade").val(cidade);
                        $("#cpf").val(cpf);
                        $('#pis').val(pis)
                        $("#carteiraTrabalho").val(carteiraTrabalho);
                        $("#carteiraTrabalhoSerie").val(carteiraTrabalhoSerie);
                        $("#dataExpedicaoCarteiraTrabalho").val(dataExpedicaoCarteiraTrabalho);
                        $("#localCarteiraTrabalho").val(localCarteiraTrabalho);
                        $("#rg").val(rg);
                        $("#localRg").val(localRg);
                        $("#emissorRg").val(emissorRg);
                        $("#dataEmissaoRg").val(dataEmissaoRg);
                        $("#cnh").val(cnh);
                        $("#categoriaCnh").val(categoriaCnh);
                        $("#ufCnh").val(ufCnh);
                        $("#dataEmissaoCnh").val(dataEmissaoCnh);
                        $("#dataVencimentoCnh").val(dataVencimentoCnh);
                        $("#primeiraCnh").val(primeiraCnh);
                        $("#tituloEleitor").val(tituloEleitor);
                        $("#zonaTituloEleitor").val(zonaTituloEleitor);
                        $("#secaoTituloEleitor").val(secaoTituloEleitor);
                        $("#certificadoReservista").val(certificadoReservista);
                        $("#grauInstrucao").val(grauInstrucao);
                        $("#atividadesExtracurriculares").val(atividadesExtracurriculares);
                        $("#nomeConjuge").val(nomeConjuge);
                        $("#dataNascimentoConjuge").val(dataNascimentoConjuge);
                        $("#trabalhaAtualmente").val(trabalhaAtualmente);;
                        $("#seguroDesemprego").val(seguroDesemprego);
                        $("#desejaAssistenciaMedica").val(desejaAssistenciaMedica);
                        $("#desejaAssistenciaOdontologica").val(desejaAssistenciaOdontologica);
                        $("#valeRefeicaoValeAlimentacao").val(valeRefeicaoValeAlimentacao);
                        $("#desejaVt").val(desejaVt);
                        $("#possuiVt").val(possuiVt);
                        $("#numeroCartaoVt").val(numeroCartaoVt);
                        $("#agenciaBanco").val(agenciaBanco);
                        $("#digitoAgenciaBanco").val(digitoAgenciaBanco);
                        $("#contaCorrente").val(contaCorrente);
                        $("#digitoContaBanco").val(digitoContaBanco);
                        $("#fk_banco").val(fk_banco);
                        $("#variacao").val(variacao);
                        $("#tipoConta").val(tipoConta);
                        $("#numeroCamisa").val(numeroCamisa);
                        $("#numeroCalca").val(numeroCalca);
                        $("#numeroSaia").val(numeroSaia);
                        $("#numeroSapato").val(numeroSapato);
                        $("#prazoDeterminado").val(prazoDeterminado);
                        $("#dataFinal").val(dataFinal);
                        $("#jsonFilho").val(strArrayFilho);
                        $("#jsonDependente").val(strArrayDependente);
                        jsonFilhoArray = JSON.parse($("#jsonFilho").val());
                        jsonDependenteArray = JSON.parse($("#jsonDependente").val());

                        fillTableFilho();
                        fillTableDependente();

                        //Desbloqueia e bloqueia campos de acordo com o tipo Escala
                        if (tipoEscala == 2) {
                            let camposHabilitados = ['#dataInicioRevezamento', '#tipoRevezamento'];
                            habilitarCampos(camposHabilitados);
                        } else {
                            let camposDesabilitados = ['#dataInicioRevezamento', '#tipoRevezamento'];
                            desabilitarCampos(camposDesabilitados);
                        }

                        var campoExperiencia = ['#experiencia'];
                        var campoPrazoDeterminado = ['#prazoDeterminado'];
                        var dataFinal = ['#dataFinal'];

                        if (experiencia != "") {
                            habilitarCampos(campoExperiencia);
                        } else {
                            desabilitarCampos(experiencia);
                        }

                        if (prazoDeterminado != "") {
                            habilitarCampos(campoPrazoDeterminado);
                        } else {
                            desabilitarCampos(campoPrazoDeterminado);
                        }

                        if (dataFinal != "") {
                            habilitarCampos(dataFinal);
                        } else {
                            desabilitarCampos(dataFinal);
                        }
                    }
                });


            }
        }
    }

    function gravar() {

        $("#btnGravar").prop('disabled', true);

        let form = $('#formControleGestor')[0];
        let formData = new FormData(form);
        let funcionario = $("#funcionario").val();
        let tipoContrato = $("#tipoContrato").val();
        let dataAdmissao = $("#dataAdmissao").val();
        let projeto = $("#projeto").val();
        let cargo = $("#cargo").val();
        let cbo = $("#cbo").val();
        let experiencia = $("#experiencia").val();
        let sindicato = $("#sindicato").val();
        let salarioBase = $("#salarioBase").val();
        let tipoEscala = $("#tipoEscala").val();
        let dataInicioRevezamento = $("#dataInicioRevezamento").val();
        let tipoRevezamento = $("#tipoRevezamento").val();
        let escalaHorario = $("#escalaHorario").val();
        let prazoDeterminado = $("#prazoDeterminado").val();


        //Verifica se os campos estão como required para validar os alertas. 
        let classeExperiencia = document.getElementById("experiencia").classList.contains('required');
        let classePrazoDeterminado = document.getElementById("prazoDeterminado").classList.contains('required');

        if (classeExperiencia) {
            if (experiencia == "") {
                smartAlert("Atenção", "Selecione uma Experiência", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }
        }

        if (classePrazoDeterminado) {
            if (prazoDeterminado == "") {
                smartAlert("Atenção", "Selecione uma Prazo Determinado(dias)", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }
        }


        if (!funcionario) {
            smartAlert("Atenção", "Selecione um funcionário no filtro", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!tipoContrato) {
            smartAlert("Atenção", "Selecione um Tipo de Contrato", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!dataAdmissao) {
            smartAlert("Atenção", "Selecione uma Data de Admissão", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!projeto) {
            smartAlert("Atenção", "Selecione um Projeto", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (!cargo) {
            smartAlert("Atenção", "Selecione um Cargo", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!sindicato) {
            smartAlert("Atenção", "Selecione um Sindicato", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!salarioBase) {
            smartAlert("Atenção", "Digite um Salário Base", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!tipoEscala) {
            smartAlert("Atenção", "Selecione um Tipo de Escala", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        } else if (tipoEscala == 2) {
            if (!dataInicioRevezamento) {
                smartAlert("Atenção", "Selecione uma Data de Inicio do Revezamento", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }

            if (!tipoRevezamento) {
                smartAlert("Atenção", "Selecione um Tipo de Revezamento", "error");
                $("#btnGravar").prop('disabled', false);
                return;
            }
        }

        if (!escalaHorario) {
            smartAlert("Atenção", "Selecione uma Escala/Horário", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        gravaControleGestor(formData);

    }

    function novo() {
        $(location).attr('href', 'contratacao_gestorCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'contratacao_gestorFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirCandidato(id);
    }


    function validaCampoData(campo) {
        var valor = $(campo).val();
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js
        if (validacao === false) {
            $(campo).val("");
        }
    }

    function validaData(valor) {
        var date = valor;
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
            smartAlert("Erro", "O valor inserido é inválido.", "error");
            return false;
        }
        return true;
    }


    function verificaCamposGestor() {
        let arrayCamposGestor = [
            $("#funcionario").val(),
            $("#tipoContrato").val(),
            $("#dataAdmissao").val(),
            $("#projeto").val(),
            $("#cargo").val(),
            $("#cbo").val(),
            $("#sindicato").val(),
            $("#salarioBase").val(),
            $("#tipoEscala").val(),
            $("#escalaHorario").val(),
        ]

        let experiencia = $("#experiencia").val();
        let prazoDeterminado = $("#prazoDeterminado").val();
        let tipoContrato = $("#tipoContrato").val();
        let dataInicioRevezamento = $("#dataInicioRevezamento").val();
        let tipoRevezamento = $("#tipoRevezamento").val();
        let tipoEscala = $("#tipoEscala").val();

        let condicaoTipoContrato =
            ((tipoContrato == "2") ||
                (tipoContrato == "4") ||
                (tipoContrato == "5"));

        if (condicaoTipoContrato) {
            if (experiencia != "") {
                arrayCamposGestor.push(experiencia);
            } else if (prazoDeterminado != "") {
                arrayCamposGestor.push(prazoDeterminado);
            } else {
                let classeExperiencia = document.getElementById("experiencia");
                let classePrazoDeterminado = document.getElementById("prazoDeterminado");

                if (classeExperiencia) {
                    arrayCamposGestor.push(experiencia);
                }

                if (classePrazoDeterminado) {
                    arrayCamposGestor.push(prazoDeterminado);
                }
            }

        }

        if (tipoEscala == 2) {
            arrayCamposGestor.push(dataInicioRevezamento);
            arrayCamposGestor.push(tipoRevezamento);
        }

        var verificadoPeloGestor = !arrayCamposGestor.find(value => value === '' || stringToFloat(value) <= 0);
        $('#verificadoPeloGestor').val(verificadoPeloGestor ? 'Sim' : 'Não');

        // for (let i = 0; i < arrayCamposGestor.length; i++) {
        //     if (arrayCamposGestor[i] === "") {

        //         $("#verificadoPeloGestor").val("Não");
        //         break;
        //     } else {

        //         if ((i == arrayCamposGestor.length - 1)) { // Se todo o array for percorrido e não há nada em branco 
        //             if (arrayCamposGestor[8] != "0,00") {
        //                 $("#verificadoPeloGestor").val("Sim");
        //             }
        //         }
        //     }
        // }

    }


    function fillTableFilho() {
        $("#tableFilho tbody").empty();
        for (var i = 0; i < jsonFilhoArray.length; i++) {
            var row = $('<tr />');
            $("#tableFilho tbody").append(row);
            // row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonFilhoArray[i].sequencialFilho + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap"' + jsonFilhoArray[i].sequencialFilho + '">' + jsonFilhoArray[i]
                .nomeFilho + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFilhoArray[i].cpfFilho + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFilhoArray[i].dataNascimentoFilho + '</td>'));
        }
    }

    function fillTableDependente() {
        $("#tableDependente tbody").empty();
        for (var i = 0; i < jsonDependenteArray.length; i++) {

            var row = $('<tr />');
            $("#tableDependente tbody").append(row);
            // row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonDependenteArray[i].sequencialDependente + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap"' + jsonDependenteArray[i].sequencialDependente + '">' +
                jsonDependenteArray[i].nomeDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].cpfDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].dataNascimentoDependente + '</td>'));
            var grauParentescoDependente = $("#grauParentescoDependente option[value = '" + jsonDependenteArray[i]
                .grauParentescoDependente + "']").text();
            row.append($('<td class="text-nowrap">' + grauParentescoDependente + '</td>'));
        }
    }

    /*Função está limpando os valores,
     * retirando o required,
     * desabilitando o campo(pois pode ser uma combo)
     * e adicionando o readonly. */

    function desabilitarCampos(campos) {
        for (let i = 0; i < campos.length; i++) {
            $(campos[i]).val("");
            $(campos[i]).removeClass('required');
            $(campos[i]).prop('disabled', true);
            $(campos[i]).addClass('readonly');
        }
    }

    // Faz a função inversa de desabilitar campos.   
    function habilitarCampos(campos) {
        for (let i = 0; i < campos.length; i++) {
            $(campos[i]).prop('disabled', false);
            $(campos[i]).removeClass('readonly');
            $(campos[i]).addClass('required');
        }
    }

    /* Verifica se Experiência ou Prazo Determinado foram selecionados.
     *  Assim que um campo é escolhido, o outro é desabilitado caso 
     * tipoContrato seja 2, 4 ou 5. 
     */
    function alternarEntreExperienciaEPrazoDeterminado() {
        var prazoDeterminado = $("#prazoDeterminado").val();
        var experiencia = $("#experiencia").val();
        var tipoContrato = $("#tipoContrato").val();
        var campoExperiencia = ['#experiencia'];
        var campoPrazoDeterminado = ['#prazoDeterminado'];
        var condicaoTipoContrato =
            ((tipoContrato == "4") ||
                (tipoContrato == "5"));

        //Caso a pessoa apague o que escreveu, reabre os campos para ela escolher o campo certo. 
        if (experiencia == "") {
            habilitarCampos(campoPrazoDeterminado)
        }

        if (prazoDeterminado == "") {
            habilitarCampos(campoExperiencia);
        }

        if (condicaoTipoContrato) {
            //Limpa as variaveis se por algum motivo no banco tenha sido cadastrado errado. 
            if ((experiencia != "") && (prazoDeterminado != "")) {
                $("#experiencia").val("");
                $("#prazoDeterminado").val("");
            } else {
                if (experiencia != "") {
                    smartAlert("Atenção",
                        "Neste tipo de contrato, você pode escolher entre Experiência e Prazo Determinado.  Você escolheu preencher 'Experiência'. 'Prazo Determinado' foi desabilitado.",
                        "success", "8000");
                    desabilitarCampos(campoPrazoDeterminado);
                }
                if (prazoDeterminado != "") {
                    smartAlert("Atenção",
                        "Neste tipo de contrato, você pode escolher entre Experiência e Prazo Determinado.  Você escolheu preencher 'Prazo Determinado'. 'Experiência' foi desabilitada.",
                        "success", "8000");
                    desabilitarCampos(campoExperiencia);
                }
            }
        }
    }

    function formataDataObjetoMoment(valor) {
        //Formata a data recuperada em um campo para um objeto do moment.
        valor = valor.split("/");
        valor[1] = valor[1] - 1;
        valor = moment([valor[2], valor[1], valor[0]]);
        return valor;
    }

    function verificaDiferencaDias(diferenca) {
        if (diferenca <= 1) {
            smartAlert("Atenção", "A data final não pode ser maior ou igual a data de admissão do candidato!", "error");
            $("#dataFinal").val("");
            $("#prazoDeterminado").val("");
            return;
        }
    }
</script>