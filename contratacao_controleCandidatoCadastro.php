<?php
//initilize the page
include("js/repositorio.php");
require_once("inc/init.php");


//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('CONTRATACAORH_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CONTRATACAORH_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CONTRATACAORH_EXCLUIR', $arrayPermissao, true));

$condicaoAcessarOK = true;
if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$condicaoGravarOK = true;
$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$condicaoExcluirOK = true;
$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}

$sql = "SELECT * FROM Ntl.parametro";
$reposit = new reposit();
$result = $reposit->RunQuery($sql);

if (($row = odbc_fetch_array($result))) {
    $row = array_map('utf8_encode', $row);
    $linkUpload = $row['linkUpload'];
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Tela para uso do RH";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['operacao']['sub']['contratacao']['sub']["rh"]["active"] = true;

include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Recursos Humanos"] = "";
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
                            <h2>Tela para uso do RH</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formControleFuncionario" method="post">
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
                                                            <section class="col col-1">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select name="ativo" id="ativo" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Admissão ─ Preenchimento Exclusivo do
                                                                        Gestor</strong></legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Candidato</label>
                                                                <label class="input">
                                                                    <input id="funcionario" name="funcionario" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-6">
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
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Data admissão</label>
                                                                <label class="input">
                                                                    <input id="dataAdmissao" name="dataAdmissao" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataInicioRevezamento')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, numeroCentroCusto, descricao, apelido FROM syscbNtl.syscb.projeto where ativo = 1 order by descricao";
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
                                                            <section class="col col-4">
                                                                <label class="label" for="cargo">Cargo</label>
                                                                <label class="select">
                                                                    <select id="cargo" name="cargo" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigoCargoSCI AS codigo, descricao  FROM syscbNtl.syscb.cargo where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $codigo . ' - ' . $descricao . '</option>';
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
                                                                    <select id="experiencia" name="experiencia" class="">
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
                                                                    <select id="sindicato" name="sindicato">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigoSindicatoSCI AS codigo, descricao, apelido FROM syscbNtl.syscb.sindicato where situacao = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
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
                                                                    <input id="salarioBase" name="salarioBase" class="decimal-2-casas" autocomplete="new-password" type="text" value="">
                                                                </label>
                                                            </section>


                                                            <section class="col col-2">
                                                                <label class="label" for="tipoEscala">Tipo de
                                                                    escala</label>
                                                                <label class="select">
                                                                    <select id="tipoEscala" name="tipoEscala" class="">
                                                                        <option></option>
                                                                        <option value="1">Normal</option>
                                                                        <option value="2">Revezamento</option>
                                                                        <option value="3">Nenhum</option>
                                                                    </select><i></i>
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
                                                                <label class="label">Data início revezamento</label>
                                                                <label class="input">
                                                                    <input id="dataInicioRevezamento" name="dataInicioRevezamento" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataInicioRevezamento')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="tipoRevezamento">Tipo de
                                                                    revezamento</label>
                                                                <label class="select">
                                                                    <select id="tipoRevezamento" name="tipoRevezamento" class="">
                                                                        <option></option>
                                                                        <option value="0">12 x 36</option>
                                                                        <option value="1">24 x 48</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="escalaHorario">Escala/Horário</label>
                                                                <label class="select">
                                                                    <select id="escalaHorario" name="escalaHorario">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM syscc.dbo.escalas order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
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
                                                                <label class="label">Prazo Determinado(dias)</label>
                                                                <label class="input"><i></i>
                                                                    <input id="prazoDeterminado" name="prazoDeterminado" class="number" value="" autocomplete="new-password" maxlength="3">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Final</label>
                                                                <label class="input">
                                                                    <input id="dataFinal" name="dataFinal" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataFinal')">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Controle do RH ─ Preenchimento Exclusivo
                                                                        do Rh</strong></legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-2">
                                                                <label class="label">Matrícula SCI</label>
                                                                <label class="input">
                                                                    <input id="matriculaSCI" name="matriculaSCI" maxlength="6" type="text" autocomplete="new-password" class="required">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="classe">Classe</label>
                                                                <label class="select">
                                                                    <select id="classe" name="classe" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM syscc.dbo.classe order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {
                                                                            $row = array_map('utf8_encode', $row);
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $codigo . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>


                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Tipo de Admissão</label>
                                                                <label class="select">
                                                                    <select name="tipoAdmissao" id="tipoAdmissao" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">1 – Admissão - Primeiro
                                                                            Emprego</option>
                                                                        <option value="2">1 – Admissão - Reemprego
                                                                        </option>
                                                                        <option value="3">2 – Transferência de empresa
                                                                            do mesmo grupo econômico</option>
                                                                        <option value="4">3 – Transferência de empresa
                                                                            consorciada ou de consórcio</option>
                                                                        <option value="5">4 – Transferência por motivo
                                                                            de sucessão, incorporação ou fusão</option>
                                                                        <option value="6">5 – Reintegração</option>
                                                                        <option value="7">6 – Transferência entre matriz
                                                                            e filial</option>
                                                                        <option value="8">9 – Outros casos não previstos
                                                                        </option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Indicativo de Admissão</label>
                                                                <label class="select">
                                                                    <select name="indicativoAdmissao" id="indicativoAdmissao" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">1 – Normal</option>
                                                                        <option value="2">2 – Decorrente de ação
                                                                            fiscal</option>
                                                                        <option value="3">3 – Decorrente de decisão
                                                                            judicial</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Natureza de Ocupação</label>
                                                                <label class="select">
                                                                    <select name="naturezaOcupacao" id="naturezaOcupacao" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">1 – Empregado em empresa do
                                                                            setor privado</option>
                                                                        <option value="2">2 – Profissional liberal ou
                                                                            Trabalhador sem vínculo empregatício
                                                                        </option>
                                                                        <option value="3">3 – Empregador titular ou
                                                                            proprietário de empresa</option>
                                                                        <option value="4">4 – Servidor público da
                                                                            administração direta</option>
                                                                        <option value="5">5 - Servidor público de
                                                                            autarquia e fundação</option>
                                                                        <option value="6">6 – Funcionário de empresa
                                                                            pública de economia mista</option>
                                                                        <option value="7">7 – Declarante auferiu rend.
                                                                            Capital, inclusive aluguel</option>
                                                                        <option value="8">8 – Aposentado ou pensionista
                                                                        </option>
                                                                        <option value="9">9 – Outros</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <div class="row">

                                                            <section class="col col-8">
                                                                <label class="label">FGTS/GPS - Categoria SEFIP</label>
                                                                <label class="select">
                                                                    <select name="categoriaSefip" id="categoriaSefip" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">01 – Empregado</option>
                                                                        <option value="2">02 – Trabalhador avulso
                                                                        </option>
                                                                        <option value="3">03 – Trabalhador não vinculado
                                                                            ao RGPS, mas com direito ao FGTS</option>
                                                                        <option value="4">04 – Empregado prazo
                                                                            Determinado/Intermitente</option>
                                                                        <option value="5">05 – Contribuinte individual –
                                                                            Diretor não empregado com FGTS (Lei n°
                                                                            8.036/90, Art. 16)</option>
                                                                        <option value="6">07 – Aprendiz -Lei n°
                                                                            10.097/2000 / Contrato Verde e Amarelo – MP
                                                                            905/2019</option>
                                                                        <option value="7">11 – Contribuinte individual –
                                                                            Diretor não empregado e demais empresários
                                                                            sem FGTS</option>
                                                                        <option value="8">12 – Demais agentes públicos
                                                                        </option>
                                                                        <option value="9">13 – Contribuinte individual –
                                                                            Trabalhador autônomo ou a este equiparado,
                                                                            inclusive o
                                                                            operador de máquina, contribuição sobre
                                                                            remuneração</option>
                                                                        <option value="10">14 - Contribuinte individual
                                                                            – Trabalhador autônomo ou a este equiparado,
                                                                            inclusive o operador
                                                                            de máquina, contribuição sobre o salário
                                                                            base</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Experiência (em dias)</label>
                                                                <label class="input">
                                                                    <input id="quantidadeDiasExperiencia" name="quantidadeDiasExperiencia" type="text" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Prorrogação (em dias)</label>
                                                                <label class="input">
                                                                    <input id="quantidadeDiasProrrogacao" name="quantidadeDiasProrrogacao" type="text" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">FGTS/GPS - Categoria
                                                                    E-social</label>
                                                                <label class="select">
                                                                    <select name="categoriaEsocial" id="categoriaEsocial" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">101 – Empregado – Geral
                                                                        </option>
                                                                        <option value="2">103 – Empregado Aprendiz
                                                                        </option>
                                                                        <option value="3">105 – Empregado – Contrato a
                                                                            termo firmado nos termos da lei 9.601/98
                                                                        </option>
                                                                        <option value="4">106 – Trabalhador Temporário –
                                                                            Contrato nos termos da Lei 6.019/74</option>
                                                                        <option value="5">107 – Empregado – Contrato de
                                                                            trabalho Verde e Amarelo – Sem acordo para
                                                                            antecipação
                                                                            mensal da multa rescisória do FGTS</option>
                                                                        <option value="6">108 - Empregado – Contrato de
                                                                            trabalho Verde e Amarelo – Com acordo para
                                                                            antecipação
                                                                            mensal da multa rescisória do FGTS</option>
                                                                        <option value="7">111 – Empregado - Contrato de
                                                                            trabalho Intermitente</option>
                                                                        <option value="8">701 – Contribuinte Individual
                                                                            – Autônomo contratado por empresas em geral
                                                                        </option>
                                                                        <option value="9">721 – Contribuinte Individual
                                                                            – Diretor não empregado com FGTS</option>
                                                                        <option value="10">722 - Contribuinte Individual
                                                                            – Diretor não empregado sem FGTS</option>
                                                                        <option value="11">741 – Contribuinte Individual
                                                                            – Micro Empreendedor Individual</option>
                                                                        <option value="12">901 – Estagiário</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label">Vínculo Empregatício</label>
                                                                <label class="select">
                                                                    <select name="vinculoEmpregaticio" id="vinculoEmpregaticio" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="10">10 – Trabalhador urbano
                                                                            vinculado a empregador pessoa jurídica por
                                                                            contrato de trabalho
                                                                            regido pela CLT, por prazo indeterminado;
                                                                        </option>
                                                                        <option value="40">40 – Trabalhador avulso
                                                                            (trabalho administrado pelo sindicato da
                                                                            categoria ou pelo órgão gestor
                                                                            de mão de obra) para o qual é devido de FGTS
                                                                            – CF 88, art 7, inciso III;</option>
                                                                        <option value="50">50 – Trabalhador temporário,
                                                                            regido pela Lei 6.019, de 3 de janeiro de
                                                                            1974;</option>
                                                                        <option value="55">55 – Aprendiz contratado na
                                                                            forma dos artigos 429 ou 430 da CLT, com
                                                                            redações dadas pela Lei
                                                                            10.097 de 19 de dezembro de 2000;</option>
                                                                        <option value="60">60 - Trabalhador urbano
                                                                            vinculado a empregador pessoa jurídica por
                                                                            contrato de trabalho
                                                                            regido pela CLT, por prazo determinado ou
                                                                            obra certa;</option>
                                                                        <option value="80">80 – Diretor sem vínculo
                                                                            empregatício para o qual a empresa/entidade
                                                                            tenha optado por
                                                                            recolhimento ao FGTS;</option>
                                                                        <option value="90">90 – Contrato de Trabalho por
                                                                            Prazo Determinado, regido pela Lei 9.601, de
                                                                            21 de janeiro de
                                                                            1998;</option>
                                                                        <option value="95">95 – Contrato de Trabalho por
                                                                            Tempo Determinado, regido pela Lei 8.745 de
                                                                            9 de dezembro de
                                                                            1993, com redação dada pela Lei 9.849, de 26
                                                                            de outubro de 1999;</option>
                                                                        <option value="96">96 – Contrato de Trabalho por
                                                                            Prazo Determinado, regido por Lei Estadual;
                                                                        </option>
                                                                        <option value="97">97 – Contrato de Trabalho por
                                                                            Prazo Determinado, regido por Lei Municipal.
                                                                        </option>

                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Horas Mensais</label>
                                                                <label class="input">
                                                                    <input id="horasMensais" name="horasMensais" type="text" autocomplete="new-password" maxlength="6">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Horas Semanais</label>
                                                                <label class="input">
                                                                    <input id="horasSemanais" name="horasSemanais" type="text" autocomplete="new-password" placeholder="hh:mm">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Horas Diárias</label>
                                                                <label class="input">
                                                                    <input id="horasDiarias" name="horasDiarias" type="text" autocomplete="new-password">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Forma de Pagamento</label>
                                                                <label class="select">
                                                                    <select name="formaPagamento" id="formaPagamento" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">Mensal</option>
                                                                        <option value="2">Quinzenal</option>
                                                                        <option value="3">Diário</option>
                                                                        <option value="4">Semanal</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Tipo de Funcionário</label>
                                                                <label class="select">
                                                                    <select name="tipoFuncionario" id="tipoFuncionario" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">Mensalista</option>
                                                                        <option value="2">Diarista</option>
                                                                        <option value="3">Horista</option>
                                                                        <option value="4">Comissionado</option>
                                                                        <option value="5">Horista Especial</option>
                                                                        <option value="6">Tarefeiro</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Modo de Pagamento</label>
                                                                <label class="select">
                                                                    <select name="modoPagamento" id="modoPagamento" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">Crédito em Conta</option>
                                                                        <option value="2">Dinheiro</option>
                                                                        <option value="3">Cheque</option>
                                                                        <option value="4">Ordem de Pagamento</option>
                                                                        <option value="5">Conta Corrente</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <!-- <div class="row">

                                                            <section class="col col-4">
                                                                <label class="label " for="fk_banco">Banco</label>
                                                                <label class="select">
                                                                    <select id="fk_banco" name="fk_banco" class="readonly" readonly>
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select * from dbo.banco order by nomeBanco";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        while (($row = odbc_fetch_array($result))) {

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
                                                                <label class="label">Digito Conta</label>
                                                                <label class="input">
                                                                    <input id="digitoContaBanco" name="digitoContaBanco" maxlength="2" type="text" class="readonly" readonly value="" autocomplete="new-password" onchange="verificaNumero('#digitoContaBanco')">
                                                                </label>
                                                            </section>

                                                        </div> -->

                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Regime de Jornada de
                                                                    Trabalho</label>
                                                                <label class="select">
                                                                    <select name="regimeJornadaTrabalho" id="regimeJornadaTrabalho" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">Submetidos a horário de
                                                                            trabalho (Cap. II da CLT)</option>
                                                                        <option value="2">Atividade externa especificada
                                                                            no Inciso I do Art. 62 da CLT</option>
                                                                        <option value="3">Funções especificadas no
                                                                            Inciso II do Art. 62 da CLT</option>
                                                                        <option value="4">Teletrabalho, previsto no
                                                                            Inciso III do Art. 62 da CLT</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label">Descanso Semanal</label>
                                                                <label class="select">
                                                                    <select name="descansoSemanal" id="descansoSemanal" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">Domingo</option>
                                                                        <option value="2">Segunda</option>
                                                                        <option value="3">Terça</option>
                                                                        <option value="4">Quarta</option>
                                                                        <option value="5">Quinta</option>
                                                                        <option value="6">Sexta</option>
                                                                        <option value="7">Sábado</option>
                                                                        <option value="8">Conforme Escala</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label">Tipo de Jornada E-Social</label>
                                                                <label class="select">
                                                                    <select name="tipoJornadaEsocial" id="tipoJornadaEsocial" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">1 – Jornada com horário diário
                                                                            e folga fixos </option>
                                                                        <option value="2">2 – Jornada 12 x 36 (12 horas
                                                                            de trabalho seguidas de 36 horas
                                                                            ininterruptas de descanso)</option>
                                                                        <option value="3">3 – Jornada com horário diário
                                                                            fixo e folga variável</option>
                                                                        <option value="4">9 – Demais tipos de jornada
                                                                        </option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Verificado pelo RH</label>
                                                                <label class="input"><i></i>
                                                                    <input id="verificadoPeloRh" name="verificadoPeloRh" class="readonly" autocomplete="new-password" type="text" value="" readonly>
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
                                                        Dados do candidato para consulta
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
                                                                    <input id="localRg" name="localRg" type="text" data-dateformat="dd/mm/yy" class="readonly" readonly style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataEmissaoRg')">
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
                                                                                $sql = "select * from dbo.banco order by nomeBanco";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                while (($row = odbc_fetch_array($result))) {

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
                                                                    <!-- <section class="col col-6">
                                                                        <label class="label">Comprovante de escolaridade</label>
                                                                        <label class="input input-file">
                                                                            <span class="button"><input type="file" id="comprovanteEscolaridadeFile" name="comprovanteEscolaridadeFile[]" multiple>Selecionar
                                                                                documentos</span><input id="comprovanteEscolaridadeText" type="text">
                                                                        </label>
                                                                    </section> -->
                                                                    <section id="comprovanteEscolaridadeFileLink" class="col col-4">

                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <label class="label">            Certificados /
                                                                        Diplomas</label>
                                                                    <!-- <section class="col col-6">
                                                                        <label class="label">Certificados / Diplomas</label>
                                                                        <label class="input input-file">
                                                                            <span class="button"><input type="file" id="certificadoDiplomaFile" name="certificadoDiplomaFile[]" multiple>Selecionar
                                                                                documentos</span><input id="certificadoDiplomaText" type="text">
                                                                        </label>
                                                                    </section> -->
                                                                    <section id="certificadoDiplomaFileLink" class="col col-4">

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

<script src="<?php echo ASSETS_URL; ?>/js/business_contratacaoControleCandidado.js" type="text/javascript"></script>
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


        $('#horasSemanais').mask('99:99', {
            placeholder: "hh:mm"
        });


        $('#horasDiarias').mask('99,9999');

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
            var id = $("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });


        $("#btnGravar").on("click", function() {
            $("#verificadoPeloRh").val("Sim");
            gravar();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
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
                debugger;
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

        $("#matriculaSCI").on("change", function() {

            let matriculaSCI = $("#matriculaSCI").val();
            let id = $("#codigo").val();
            verificaMatricula(matriculaSCI, id, function(data) {
                if (data.indexOf('failed') > -1) {} else {
                    smartAlert("Atenção", "Já existe um funcionário com esta matrícula", "error");
                    $("#matriculaSCI").val('');
                    return;

                }
            });
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


    });


    function carregaPagina() {


        //Ao carregar a página, as seguintes variaveis não podem ser alteradas: 
        let camposDesabilitados = ['#experiencia', '#prazoDeterminado', '#tipoRevezamento', '#dataInicioRevezamento', '#dataFinal'];
        desabilitarCampos(camposDesabilitados);

        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {

            var variaveisUrl = params[1];
            variaveisUrl = variaveisUrl.split("&");

            //Recupera o código
            var id = variaveisUrl[0];
            var idx = id.split("=");
            //Primeiro parametro
            var idd = idx[1];

            //Recupera o código do  funcionário
            var func = variaveisUrl[1];
            var codigoFunc = func.split("=");
            //Segundo parametro
            var codigoFuncionario = codigoFunc[1];

            if (codigoFuncionario !== "") {
                //Recupera no banco o nome completo de acordo com o código do filtro. 
                let id = codigoFuncionario;
                recuperaNomeCompleto(id, function(data) {
                    if (data.indexOf('failed') > -1) {} else {
                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        var mensagem = piece[0];
                        var out = piece[1];

                        $("#funcionario").val(out);
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

                        let condicaoTipoContrato = ((tipoContrato == "2") ||
                            (tipoContrato == "4") ||
                            (tipoContrato == "5"));

                        piece = out.split("^");
                        codigo = piece[0];
                        ativo = piece[1];
                        funcionario = piece[2];
                        tipoContrato = piece[3];
                        dataAdmissao = piece[4];
                        projeto = piece[5];
                        cargo = piece[6];
                        cbo = piece[7];
                        experiencia = piece[8];
                        sindicato = piece[9];
                        salarioBase = piece[10];

                        //Mostra apenas dois pontos decimais para o usuário, e com vírgula.
                        salarioBase = roundDecimal(floatToString(salarioBase), 2);

                        tipoEscala = piece[11];

                        //Desbloqueia e bloqueia campos de acordo com o tipo Escala
                        let valorTipoEscala = tipoEscala
                        if (valorTipoEscala == 2) {
                            $("#dataInicioRevezamento").removeClass('readonly');
                            $("#dataInicioRevezamento").addClass('required');
                            $('#dataInicioRevezamento').removeAttr('disabled');

                            $("#tipoRevezamento").removeClass('readonly');
                            $("#tipoRevezamento").addClass('required');
                            $("#tipoRevezamento").removeAttr('disabled');
                        } else {
                            $('#dataInicioRevezamento').prop('disabled', true);
                            $('#dataInicioRevezamento').removeClass('required');
                            $('#dataInicioRevezamento').val('');
                            $('#dataInicioRevezamento').addClass('readonly');

                            $('#tipoRevezamento').prop('disabled', true);
                            $('#tipoRevezamento').removeClass('required');
                            $('#tipoRevezamento').val('');
                            $('#tipoRevezamento').addClass('readonly');
                        }

                        dataInicioRevezamento = piece[12];
                        tipoRevezamento = piece[13];
                        escalaHorario = piece[14];
                        tipoAdmissao = piece[15];
                        indicativoAdmissao = piece[16];
                        naturezaOcupacao = piece[17];
                        fgtsGpsCategoriaSefip = piece[18];
                        quantidadeDiasExperiencia = piece[19];
                        quantidadeDiasProrrogacao = piece[20];
                        fgtsGpsCategoriaESocial = piece[21];
                        vinculoEmpregaticio = piece[22];
                        horasMensais = piece[23];
                        horasSemanais = piece[24];
                        horasDiarias = piece[25];
                        formaPagamento = piece[26];
                        tipoFuncionario = piece[27];
                        modoPagamento = piece[28];
                        regimeJornadaTrabalho = piece[29];
                        descansoSemanal = piece[30];
                        tipoJornadaESocial = piece[31];
                        verificado = piece[32];
                        let verificadoPeloGestor = "";
                        if (verificado == 1) {
                            verificadoPeloGestor = 'Sim';
                        } else {
                            verificadoPeloGestor = 'Não';
                        }

                        verificadoPeloRh = piece[33];
                        if (verificadoPeloRh == 1) {
                            verificadoPeloRh = 'Sim';
                        } else {
                            verificadoPeloRh = 'Não';
                        }

                        agenciaBanco = piece[34];
                        digitoAgenciaBanco = piece[35];
                        contaCorrente = piece[36];
                        digitoContaBanco = piece[37];
                        fk_banco = piece[38];
                        variacao = piece[39];
                        matriculaSCI = piece[40];
                        classe = piece[41];

                        // dados para consulta
                        dataNascimento = piece[42];
                        estadoCivil = piece[43];
                        telefoneResidencial = piece[44];
                        telefoneCelular = piece[45];
                        outroTelefone = piece[46];
                        email = piece[47];
                        cep = piece[48];
                        endereco = piece[49];
                        bairro = piece[50];
                        numero = piece[51];
                        complemento = piece[52];
                        estado = piece[53];
                        cidade = piece[54];
                        cpf = piece[55];
                        pis = piece[56];
                        carteiraTrabalho = piece[57];
                        carteiraTrabalhoSerie = piece[58];
                        dataExpedicaoCarteiraTrabalho = piece[59];
                        localCarteiraTrabalho = piece[60];
                        rg = piece[61];
                        emissorRg = piece[62];
                        localRg = piece[63];
                        dataEmissaoRg = piece[64];
                        cnh = piece[65];
                        categoriaCnh = piece[66];
                        ufCnh = piece[67];
                        dataEmissaoCnh = piece[68];
                        dataVencimentoCnh = piece[69];
                        primeiraCnh = piece[70];
                        tituloEleitor = piece[71];
                        zonaTituloEleitor = piece[72];
                        secaoTituloEleitor = piece[73];
                        certificadoReservista = piece[74];
                        grauInstrucao = piece[75];
                        atividadesExtracurriculares = piece[76];
                        nomeConjuge = piece[77];
                        dataNascimentoConjuge = piece[78];
                        trabalhaAtualmente = piece[79];
                        seguroDesemprego = piece[80];
                        desejaAssistenciaMedica = piece[81];
                        desejaAssistenciaOdontologica = piece[82];
                        valeRefeicaoValeAlimentacao = piece[83];
                        desejaVt = piece[84];
                        possuiVt = piece[85];
                        numeroCartaoVt = piece[86];
                        tipoConta = piece[87];
                        numeroCamisa = piece[88];
                        numeroCalca = piece[89];
                        numeroSaia = piece[90];
                        numeroSapato = piece[91];
                        prazoDeterminado = piece[92];
                        dataFinal = piece[93];
                        logradouro = piece[94];

                        $("#codigo").val(codigo);
                        $("#ativo").val(ativo);
                        $("#funcionario").val(funcionario);
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
                        $("#tipoAdmissao").val(tipoAdmissao);
                        $("#indicativoAdmissao").val(indicativoAdmissao);
                        $("#naturezaOcupacao").val(naturezaOcupacao);
                        $("#categoriaSefip").val(fgtsGpsCategoriaSefip);
                        $("#quantidadeDiasExperiencia").val(quantidadeDiasExperiencia);
                        $("#quantidadeDiasProrrogacao").val(quantidadeDiasProrrogacao);
                        $("#categoriaEsocial").val(fgtsGpsCategoriaESocial);
                        $("#vinculoEmpregaticio").val(vinculoEmpregaticio);
                        $("#horasMensais").val(horasMensais);
                        $("#horasSemanais").val(horasSemanais);
                        $("#horasDiarias").val(horasDiarias);

                        if (horasMensais == "") {
                            $('#horasMensais').val(220);
                        }
                        if (horasSemanais == "") {
                            $('#horasSemanais').val('44:00');
                        }
                        if (horasDiarias == "") {
                            $('#horasDiarias').val('07,3333');
                        }

                        $("#formaPagamento").val(formaPagamento);
                        $("#tipoFuncionario").val(tipoFuncionario);
                        $("#modoPagamento").val(modoPagamento);
                        $("#regimeJornadaTrabalho").val(regimeJornadaTrabalho)
                        $("#descansoSemanal").val(descansoSemanal)
                        $("#tipoJornadaEsocial").val(tipoJornadaESocial)
                        $("#verificadoPeloGestor").val(verificadoPeloGestor);
                        $("#verificadoPeloRh").val(verificadoPeloRh);
                        $("#agenciaBanco").val(agenciaBanco)
                        $("#digitoAgenciaBanco").val(digitoAgenciaBanco)
                        $("#contaCorrente").val(contaCorrente);
                        $("#digitoContaBanco").val(digitoContaBanco);
                        $("#fk_banco").val(fk_banco);
                        $("#variacao").val(variacao);
                        $("#matriculaSCI").val(matriculaSCI);
                        $("#classe").val(classe);
                        $('#nomeCompleto').val(funcionario)
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
                        $("#tipoConta").val(tipoConta);
                        $("#numeroCamisa").val(numeroCamisa);
                        $("#numeroCalca").val(numeroCalca);
                        $("#numeroSaia").val(numeroSaia);
                        $("#numeroSapato").val(numeroSapato);
                        $("#prazoDeterminado").val(prazoDeterminado);
                        $("#dataFinal").val(dataFinal);
                        debugger;
                        $("#logradouro").val(logradouro);
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
                        var campoDataFinal = ['#dataFinal'];

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
                            habilitarCampos(campoDataFinal);
                        } else {
                            desabilitarCampos(campoDataFinal);
                        }
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
        }
    }

    function gravar() {

        let matriculaSCI = $("#matriculaSCI").val();
        let classe = $("#classe").val();
        let cargo = $("#cargo").val();

        if (!matriculaSCI) {
            smartAlert("Atenção", "A matrícula SCI não pode ficar em branco!", "error");
            return;
        }
        if (!classe) {
            smartAlert("Atenção", "A classe não pode ficar em branco!", "error");
            return;
        }
        if (!cargo) {
            smartAlert("Atenção", "O cargo não pode ficar em branco!", "error");
            return;
        }
        let form = $('#formControleFuncionario')[0];
        let formData = new FormData(form);
        gravaControleFuncionario(formData);

    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirControleFuncionario(id, function(data) {
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




    function voltar() {
        $(location).attr('href', 'contratacao_rhFiltro.php');
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

    function cbo(valor) {
        let id = valor;
        recuperaCbo(id, function(data) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                    $("#btnGravar").prop('disabled', false);
                    return false;
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                    $("#btnGravar").prop('disabled', false);
                    return false;
                }
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                var piece = data.split("#");
                var cbo = piece[1];
                $('#cbo').val(cbo);
            }
        });

    }


    function fillTableFilho() {
        $("#tableFilho tbody").empty();
        for (var i = 0; i < jsonFilhoArray.length; i++) {
            var row = $('<tr />');
            $("#tableFilho tbody").append(row);
            // row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonFilhoArray[i].sequencialFilho + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaFilho(' + jsonFilhoArray[i].sequencialFilho + ');">' +
                jsonFilhoArray[i].nomeFilho + '</td>'));
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
            row.append($('<td class="text-nowrap" onclick="carregaDependente(' + jsonDependenteArray[i]
                .sequencialDependente + ');">' + jsonDependenteArray[i].nomeDependente + '</td>'));
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
        }
    }

    /* Verifica se Experiência ou Prazo Determinado foram selecionados.
     *  Assim que um campo é escolhido, o outro é desabilitado caso 
     * tipoContrato seja 2, 4 ou 5. 
     */
    function alternarEntreExperienciaEPrazoDeterminado() {
        let prazoDeterminado = $("#prazoDeterminado").val();
        let experiencia = $("#experiencia").val();
        let tipoContrato = $("#tipoContrato").val();
        let campoExperiencia = ['#experiencia'];
        let campoPrazoDeterminado = ['#prazoDeterminado'];
        let condicaoTipoContrato =
            (tipoContrato == "4") ||
            (tipoContrato == "5");

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