<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

// //colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PREGAOEMANDAMENTO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PREGAOEMANDAMENTO_GRAVAR', $arrayPermissao, true));

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Pregões em Andamento";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['licitacao']['sub']['operacao']['sub']["pregoesEmAndamento"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Operações"] = "";
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
                            <h2>Pregões em Andamento</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formPregoes" method="post">
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
                                                            <input id="codigo" name="codigo" type="text" class="hidden">
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-9">
                                                                <label class="label" for="portal">Portal</label>
                                                                <label class="select">
                                                                    <select id="portal" name="portal" class="readonly" disabled='true'>
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao, endereco FROM ntl.portal where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $nomePortal = ($row['descricao']);
                                                                            $enderecoPortal  = ($row['endereco']);
                                                                            echo '<option value=' . $codigo . '>  ' . $nomePortal . '&nbsp; - &nbsp;' . $enderecoPortal . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label" for="grupo">Grupo Responsável pelo Pregão</label>
                                                                <label class="select">
                                                                    <select id="grupo" name="grupo" class="readonly" disabled='true'>
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.grupo where ativo = 1 AND tipo ='L' order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-9">
                                                                <label class="label">Nome do Orgão Licitante</label>
                                                                <label class="input">
                                                                    <input id="nomeOrgaoLicitante" maxlength="255" name="nomeOrgaoLicitante" class="readonly" type="select" value="" disabled='true'>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="responsavelPregao"> Responsável pelo Pregão</label>
                                                                <label class="select">
                                                                    <select id="responsavelPregao" name="responsavelPregao" class="readonly" disabled='true'>
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, nome FROM ntl.responsavel where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $nome = ($row['nome']);
                                                                            echo '<option value=' . $codigo . '>  ' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Número do pregão</label>
                                                                <label class="input">
                                                                    <input id="numeroPregao" maxlength="255" name="numeroPregao" class="readonly" type="select" value="" disabled='true'>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data do pregão</label>
                                                                <label class="input">
                                                                    <input id="dataPregao" name="dataPregao" type="text" data-dateformat="dd/mm/yy" class="datepicker readonly" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="off" onchange="validaCampoData('#dataNascimento')" disabled='true'>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Hora do pregão</label>
                                                                <label class="input">
                                                                    <input id="horaPregao" name="horaPregao" class="readonly" type="text" autocomplete="off" placeholder="hh:mm" disabled='true'> </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Oportunidade de Compra</label>
                                                                <label class="input">
                                                                    <input id="oportunidadeCompra" autocomplete="off" maxlength="255" name="oportunidadeCompra" class="readonly" type="select" value="" disabled='true'>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Objeto do contrato</label>
                                                                <textarea id="objetoContrato" name="objetoContrato" class="form-control readonly" rows="3" style="resize:vertical" disabled='true'></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Resumo do Pregão</label>
                                                                <textarea id="resumoPregao" name="resumoPregao" class="form-control readonly" rows="3" maxlength="500" style="resize:vertical" disabled='true'></textarea>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="situacao">Situação</label>
                                                                <label class="select">
                                                                    <select id="situacao" name="situacao" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM ntl.situacao where ativo = 1 order by descricao";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $nomeSituacao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>  ' . $nomeSituacao  . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Posição</label>
                                                                <label class="input">
                                                                    <input id="posicao" maxlength="255" name="posicao" class="required" type="number" value="" min="0">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data Reabertura do pregão</label>
                                                                <label class="input">
                                                                    <input id="dataReaberturaPregao" name="dataReaberturaPregao" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="off" onchange="validaCampoData('#dataReaberturaPregao')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="horas">Hora Reabertura do pregão</label>
                                                                <label class="input">
                                                                    <input id="horaReaberturaPregao" name="horaReaberturaPregao" class="" type="text" autocomplete="off" placeholder="hh:mm">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Data do Alerta</label>
                                                                <label class="input">
                                                                    <input id="dataAlerta" name="dataAlerta" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="off" onchange="validaCampoData('#dataAlerta')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="horas">Hora do Alerta</label>
                                                                <label class="input">
                                                                    <input id="horaAlerta" name="horaAlerta" class="" type="text" autocomplete="off" placeholder="hh:mm">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label" for="condicao">Prioridade</label>
                                                                <label class="select">
                                                                    <select id="prioridade" name="prioridade" class="">
                                                                        <option value="0" selected>Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Observação</label>
                                                                <textarea id="observacao" name="observacao" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>

                                                        <br>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Tarefas Pós-Pregão</strong></legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonTarefa" name="jsonTarefa" type="hidden" value="[]">
                                                        <input id="jsonPrePregao" name="jsonPrePregao" type="hidden" value="[]">
                                                        <div id="formTarefa">
                                                            <input id="tarefaId" name="tarefaId" type="hidden" value="">
                                                            <input id="sequencialTarefa" name="sequencialTarefa" type="hidden" value="">
                                                            <input id="tipo" name="tipo" type="hidden" value="1">
                                                            <input id="dataSolicitacao" name="dataSolicitacao" type="hidden" value="">

                                                            <!-- LISTA DE TAREFAS PRÉ-PREGÃO -->
                                                            <div class="row">
                                                                <input id="tarefaId" name="tarefaId" type="hidden" value="">

                                                                <section class="col col-3">
                                                                    <label class="label" for="tarefa">Tarefa</label>
                                                                    <label class="select">
                                                                        <select id="tarefa" name="tarefa">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao, visivel  FROM ntl.tarefa  WHERE ativo = 1
                                                                            AND (visivel = 3 OR visivel = 1) ORDER BY descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $nomeTarefa = ($row['descricao']);
                                                                                echo '<option value=' . $codigo . '>  ' . $nomeTarefa . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-3">
                                                                    <label class="label">Data Final</label>
                                                                    <label class="input">
                                                                        <input id="dataFinal" name="dataFinal" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" placeholder="--/--/----" data-mask-placeholder="-" autocomplete="off" onchange="validaCampoData('#dataFinal')">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-3">
                                                                    <label class="label" for="responsavel">Responsável</label>
                                                                    <label class="select">
                                                                        <select id="responsavel" name="responsavel">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, nome FROM ntl.responsavel  where ativo = 1 order by nome;";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $nomeResponsavel = ($row['nome']);
                                                                                echo '<option value=' . $codigo . '>  ' . $nomeResponsavel . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-3">
                                                                    <label class="label" for="dataConclusao">Data da Conclusão</label>
                                                                    <label class="input">
                                                                        <input id="dataConclusao" name="dataConclusao" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" placeholder="--/--/----" data-mask-placeholder="-" autocomplete="off" onchange="validaCampoData('#dataConclusao')">
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <label class="label">Observação</label>
                                                                    <textarea id="observacaoPrePregao" name="observacaoPrePregao" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnAddTarefa" type="button" class="btn btn-primary" title="Adicionar Filho">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverTarefa" type="button" class="btn btn-danger" title="Remover Filho">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableTarefa" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Tarefa</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data Final</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Responsável</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data e Hora da Solicitação</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data de Conclusão</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Tarefas Pré-Pregão</strong></legend>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tablePrePregao" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Tarefa</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data Final</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Responsável</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data e Hora da Solicitação</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Data de Conclusão</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Condição do Pregão</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label" for="condicao">Condição</label>
                                                                <label class=" select">
                                                                    <select id="condicao" name="condicao" class="required">
                                                                        <option value="1">Adiado</option>
                                                                        <option value="2">Em Andamento</option>
                                                                        <option value="3">Cancelado</option>
                                                                        <option value="4">Fracassado</option>
                                                                        <option value="5">Desistência</option>
                                                                        <option value="6">Concluído</option>
                                                                    </select><i></i>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <label class="label">Observação</label>
                                                                <textarea id="observacaoCondicao" name="observacaoCondicao" class="form-control" rows="3" style="resize:vertical"></textarea>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong></strong></legend>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Quem Lançou</label>
                                                                <label class="input">
                                                                    <input id="quemLancou" maxlength="255" name="quemLancou" class="readonly" style="text-align: center" type="select" value="" disabled='true'>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="dataLancamento" name="dataLancamento" type="text" data-dateformat="dd/mm/yy" class="datepicker readonly" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="off" onchange="validaCampoData('#dataLancamento')" disabled='true'>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Hora do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="horaLancamento" name="horaLancamento" class="readonly" type="text" autocomplete="off" style="text-align: center" placeholder="hh:mm" disabled='true'> </label>
                                                            </section>
                                                        </div>
                                                        <div class="row" id="logUsuarioAtualizacao">

                                                            <section class="col col-12">
                                                                <legend><strong>Última Atualização</strong></legend>
                                                            </section>

                                                            <section class="col col-3">
                                                                <label class="label">Quem Lançou</label>
                                                                <label class="input">
                                                                    <input id="quemLancouAtualizacao" maxlength="255" name="quemLancouAtualizacao" style="text-align: center" class="readonly" type="select" value="" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="dataLancamentoAtualizacao" name="dataLancamentoAtualizacao" type="text" data-dateformat="dd/mm/yy" class="readonly " style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataLancamentoAtualizacao')" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Hora do Lançamento</label>
                                                                <label class="input">
                                                                    <input id="horaLancamentoAtualizacao" name="horaLancamentoAtualizacao" class="readonly" style="text-align: center" type="text" autocomplete="new-password" readonly> </label>
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
                                        <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-floppy-o"></span>
                                        </button>
                                        <!-- <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o"></span>
                                        </button> -->
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

<script src="<?php echo ASSETS_URL; ?>/js/business_licitacaoPregaoEmAndamento.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_URL; ?>/js/businessWhatsapp.js" type="text/javascript"></script>
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
        jsonTarefaArray = JSON.parse($("#jsonTarefa").val());
        jsonPrePregaoArray = JSON.parse($("#jsonPrePregao").val());

        $('#formUsuario').validate({
            // Rules for form validation
            rules: {
                'responsavel': {
                    required: true,
                    maxlength: 155
                }
            },

        });
        $('#horaAlerta').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaPregao').mask('99:99', {
            placeholder: "hh:mm"
        });
        $('#horaReaberturaPregao').mask('99:99', {
            placeholder: "hh:mm"
        });

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

        $("#btnVoltar").on("click", function() {
            voltar();
        });
        //Botões de Tarefa
        $("#btnAddTarefa").on("click", function() {
            if (validaTarefa())
                addTarefa();
        });

        $("#btnRemoverTarefa").on("click", function() {
            excluirTarefa();
        });

        $("#dataAlerta").on("change", function() {
            validaCampoData("#dataAlerta");
        });
        $("#dataPregao").on("change", function() {
            validaCampoData("#dataPregao");
        });
        $("#dataReaberturaPregao").on("change", function() {
            validaCampoData("#dataReaberturaPregao");
        });
        $("#horaReaberturaPregao").on("change", function() {
            validaHora("#horaReaberturaPregao");
        });
        $("#horaAlerta").on("change", function() {
            validaHora("#horaAlerta");
        });
        $("#condicao").on("change", function() {
            verificaCampoObservacao();

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
                recuperaPregoesEmAndamento(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayTarefa = piece[2];
                            var strArrayPrePregao = piece[3];

                            piece = out.split("^");
                            codigo = piece[0];
                            codigoPortal = piece[1];
                            ativo = piece[2];
                            nomeOrgaoLicitante = piece[3];
                            objetoLicitado = piece[4];
                            oportunidadeCompra = piece[5];
                            numeroPregao = piece[6];
                            dataPregao = piece[7];

                            //Arrumando o valor de dataPregao
                            dataPregao = dataPregao.split("-");
                            dataPregao = dataPregao[2] + "/" + dataPregao[1] + "/" + dataPregao[0];

                            horaPregao = piece[8];
                            usuarioCadastro = piece[9];
                            dataCadastro = piece[10];
                            observacao = piece[11];
                            situacao = +piece[12];
                            posicao = +piece[13];
                            dataReaberturaPregao = piece[14];
                            horaReaberturaPregao = piece[15];
                            dataAlerta = piece[16];
                            horaAlerta = piece[17];
                            prioridade = piece[18];
                            resumoPregao = piece[19];
                            condicao = piece[20];
                            observacaoCondicao = piece[21];
                            usuarioAlteracao = piece[22];
                            dataAlteracao = piece[23];
                            grupoResponsavel = piece[24];
                            responsavelPregao = piece[25];


                            if (dataReaberturaPregao != "") {
                                dataReaberturaPregao = dataReaberturaPregao.split("-");
                                dataReaberturaPregao = dataReaberturaPregao[2] + "/" + dataReaberturaPregao[1] + "/" + dataReaberturaPregao[0];
                            }
                            if (dataAlerta != "") {
                                dataAlerta = dataAlerta.split("-");
                                dataAlerta = dataAlerta[2] + "/" + dataAlerta[1] + "/" + dataAlerta[0];
                            }

                            //Arrumando o valor de dataLancamento e horaLancamento
                            dataCadastro = dataCadastro.split(" ");
                            dataLancamento = dataCadastro[0].split("-");
                            dataLancamento = dataLancamento[2] + "/" + dataLancamento[1] + "/" + dataLancamento[0];
                            horaLancamento = dataCadastro[1].split(":");
                            horaLancamento = horaLancamento[0] + ":" + horaLancamento[1];

                            //Arrumando o valor de dataLancamento e horaLancamento de Atualização
                            if (dataAlteracao != "") {
                                dataAlteracao = dataAlteracao.split(" ");
                                dataLancamentoAtualizacao = dataAlteracao[0].split("-");
                                dataLancamentoAtualizacao = dataLancamentoAtualizacao[2] + "/" + dataLancamentoAtualizacao[1] + "/" + dataLancamentoAtualizacao[0];
                                horaLancamentoAtualizacao = dataAlteracao[1].split(":");
                                horaLancamentoAtualizacao = horaLancamentoAtualizacao[0] + ":" + horaLancamentoAtualizacao[1];
                            }


                            $("#codigo").val(codigo);
                            $("#portal").val(codigoPortal);
                            $("#ativo").val(ativo);
                            $("#nomeOrgaoLicitante").val(nomeOrgaoLicitante);
                            $("#objetoLicitado").val(objetoLicitado);
                            $("#oportunidadeCompra").val(oportunidadeCompra);
                            $("#numeroPregao").val(numeroPregao);
                            $("#dataPregao").val(dataPregao);
                            $("#horaPregao").val(horaPregao);
                            $("#quemLancou").val(usuarioCadastro);
                            $("#dataLancamento").val(dataLancamento);
                            $("#horaLancamento").val(horaLancamento);
                            $("#quemLancouAtualizacao").val(usuarioAlteracao);
                            $("#dataLancamentoAtualizacao").val(dataLancamentoAtualizacao);
                            $("#horaLancamentoAtualizacao").val(horaLancamentoAtualizacao);
                            $("#observacao").val(observacao);
                            $("#situacao").val(situacao);
                            $("#posicao").val(posicao);
                            $("#dataReaberturaPregao").val(dataReaberturaPregao);
                            $("#horaReaberturaPregao").val(horaReaberturaPregao);
                            $("#dataAlerta").val(dataAlerta);
                            $("#horaAlerta").val(horaAlerta);
                            if (prioridade != "") {
                                $("#prioridade").val(prioridade);
                            }
                            $("#resumoPregao").val(resumoPregao);
                            $("#condicao").val(condicao);
                            $("#observacaoCondicao").val(observacaoCondicao);
                            $("#grupo").val(grupoResponsavel);
                            $("#responsavelPregao").val(responsavelPregao);

                            $("#jsonTarefa").val(strArrayTarefa);
                            $("#jsonPrePregao").val(strArrayPrePregao);

                            if (usuarioAlteracao != "" && dataAlteracao != "") {
                                document.getElementById("logUsuarioAtualizacao").style.display = "";
                            }

                            if (strArrayPrePregao != "") {
                                jsonPrePregaoArray = JSON.parse($("#jsonPrePregao").val());
                                fillTablePrePregao();
                            }

                            if (strArrayTarefa != "") {
                                jsonTarefaArray = JSON.parse($("#jsonTarefa").val());
                                fillTableTarefa();
                            }

                            verificaCampoObservacao();
                        }
                    }
                );
            }
        }
    }

    function voltar() {
        $(location).attr('href', 'licitacao_pregaoEmAndamentoFiltro.php');
    }

    function gravado() {

        // var codigoPregao = $("#codigo").val();
        // var prioridade = $("#prioridade").val();
        // var dataPregao = $("#dataPregao").val();
        // var horaPregao = $("#horaPregao").val();
        // var dataReabertura = $("#dataReaberturaPregao").val();
        // var horaReabertura = $("#horaReaberturaPregao").val();

        // /*Caso a lista de tarefas não esteja vazia, 
        //  * e a data de conclusão esteja como nula, uma mensagem
        //  * whatsapp é enviada para cada responsável por uma tarefa 
        //  * */
        // if (jsonTarefaArray != "") {

        //     //Filtro pra que os funcionários não se repitam. 
        //     var flags = [],
        //         output = [],
        //         l = jsonTarefaArray.length,
        //         i;

        //     for (i = 0; i < l; i++) {
        //         if (flags[jsonTarefaArray[i].responsavel])
        //             continue;
        //         flags[jsonTarefaArray[i].responsavel] = true;
        //         output.push(jsonTarefaArray[i].responsavel);
        //     }

        //     for (var i = 0; i < output.length; i++) {
        //         var codigoResponsavel = +output[i];
        //         var tipo = 1; //Sinaliza que o tipo do pregão é pós-pregão. 
        //         dispararMensagemTarefa(codigoPregao, codigoResponsavel, tipo);
        //     }
        // }

        // /* Caso o pregão seja marcado como prioridade, 
        // uma mensagem de whatsapp é disparada para todos os 
        // responsáveis. */
        // if (prioridade != "") {
        //     dispararMensagemPrioridade(codigoPregao);
        // }

        // /* Caso a data de reabertura ou a data de um pregão for
        // igual á data atual, dispara-se um alerta para todos da 
        // abertura do pregão. */

        // if ((dataReabertura != "") && (horaReabertura!= "")){ 
        //     if(verificaDataAlerta(dataReabertura, horaReabertura)){
        //         dispararAlertaPregao(codigoPregao); 
        //     } 

        // } else if((dataPregao != "") && (horaPregao != "")){ 
        //     if(verificaDataAlerta(dataPregao, horaPregao)){
        //         dispararAlertaPregao(codigoPregao); 
        //     }
        // }

    }

    //Funções do Whatsapp
    // function dispararMensagemTarefa(codigoPregao, codigoResponsavel, tipo) {
    //     recuperaTelefone(codigoPregao, codigoResponsavel, tipo,
    //         function(data) {
    //             if (data.indexOf('failed') > -1) {} else {
    //                 data = data.replace(/failed/g, '');

    //                 var piece = data.split("#");
    //                 var mensagem = piece[0];
    //                 var out = piece[1];
    //                 var strArrayTarefas = JSON.parse(piece[2]);

    //                 piece = out.split("^");
    //                 apiUrlWhatsApp = piece[0];
    //                 tokenWhatsApp = piece[1];
    //                 mensagemResponsavel = piece[2];

    //                 // Retornado de um array
    //                 for (var i = 0; i < strArrayTarefas.length; i++) {
    //                     telefone = strArrayTarefas[i].telefone;
    //                     pregao = strArrayTarefas[i].pregao;
    //                     numeroPregao = strArrayTarefas[i].numeroPregao;
    //                     tarefa = strArrayTarefas[i].tarefa;

    //                     var url = apiUrlWhatsApp + 'sendMessage?token=' + tokenWhatsApp;
    //                     var body = mensagemResponsavel + "\n" +
    //                         "Tarefa:" + tarefa + "\n" +
    //                         "Pregão: " + pregao + "\n" +
    //                         "Número do Pregão: " + numeroPregao;

    //                     var data = {
    //                         phone: telefone,
    //                         body: body
    //                     };

    //                     $.ajax(url, {
    //                         data: JSON.stringify(data),
    //                         contentType: 'application/json',
    //                         type: 'POST'
    //                     });
    //                 }

    //             }
    //         }
    //     );

    // }

    // function dispararMensagemPrioridade(codigoPregao) {
    //     recuperaPrioridade(codigoPregao,
    //         function(data) {
    //             if (data.indexOf('failed') > -1) {} else {
    //                 data = data.replace(/failed/g, '');
    //                 var piece = data.split("#");
    //                 var mensagem = piece[0];
    //                 var out = piece[1];
    //                 var strArrayTelefones = JSON.parse(piece[2]);

    //                 piece = out.split("^");
    //                 apiUrlWhatsApp = piece[0];
    //                 tokenWhatsApp = piece[1];
    //                 mensagemResponsavel = piece[2];
    //                 pregao = piece[3];
    //                 numeroPregao = piece[4];

    //                 // Retornado de um array
    //                 for (var i = 0; i < strArrayTelefones.length; i++) {
    //                     telefone = strArrayTelefones[i].telefone;

    //                     var url = apiUrlWhatsApp + 'sendMessage?token=' + tokenWhatsApp;
    //                     var body = mensagemResponsavel + "\n" +
    //                         "Pregão: " + pregao + "\n" +
    //                         "Número do Pregão: " + numeroPregao;

    //                     console.log(body);

    //                     var data = {
    //                         phone: telefone,
    //                         body: body
    //                     };

    //                     $.ajax(url, {
    //                         data: JSON.stringify(data),
    //                         contentType: 'application/json',
    //                         type: 'POST'
    //                     });
    //                 }

    //             }
    //         }
    //     );

    // }

    // function dispararAlertaPregao(codigoPregao) {
    //     recuperaAlerta(codigoPregao,
    //         function(data) {
    //             if (data.indexOf('failed') > -1) {} else {
    //                 data = data.replace(/failed/g, '');
    //                 var piece = data.split("#");

    //                 debugger;
    //                 var mensagem = piece[0];
    //                 var out = piece[1];
    //                 var strArrayTelefones = JSON.parse(piece[2]);

    //                 piece = out.split("^");
    //                 apiUrlWhatsApp = piece[0];
    //                 tokenWhatsApp = piece[1];
    //                 mensageAlerta = piece[2];
    //                 pregao = piece[3];
    //                 numeroPregao = piece[4];

    //                 // Retornado de um array
    //                 for (var i = 0; i < strArrayTelefones.length; i++) {
    //                     telefone = strArrayTelefones[i].telefone;

    //                     var url = apiUrlWhatsApp + 'sendMessage?token=' + tokenWhatsApp;
    //                     var body = mensageAlerta + "\n" +
    //                         "Pregão: " + pregao + "\n" +
    //                         "Número do Pregão: " + numeroPregao;

    //                     console.log(body);

    //                     var data = {
    //                         phone: telefone,
    //                         body: body
    //                     };

    //                     $.ajax(url, {
    //                         data: JSON.stringify(data),
    //                         contentType: 'application/json',
    //                         type: 'POST'
    //                     });
    //                 }

    //             }
    //         }
    //     );

    // }


    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirPregoesEmAndamento(id);
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

    function validaHora(campo) {
        var valor = $(campo).val();
        var valor = valor.split(":");
        var hr = valor[0];
        var min = valor[1];
        if (hr > "23" || min > "59") {
            smartAlert("Erro", "O valor inserido é inválido.", "error");
            $(campo).val("");
            return false;
        }
        return true;
    }




    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function fillTableTarefa() {
        $("#tableTarefa tbody").empty();
        for (var i = 0; i < jsonTarefaArray.length; i++) {
            var row = $('<tr />');
            $("#tableTarefa tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTarefaArray[i]
                .sequencialTarefa + '"><i></i></label></td>'));

            var tarefa = $("#tarefa option[value = '" + jsonTarefaArray[i].tarefa + "']").text();
            var responsavel = $("#responsavel option[value = '" + jsonTarefaArray[i].responsavel + "']").text();
            if (jsonTarefaArray[i].dataConclusao == undefined) {
                jsonTarefaArray[i].dataConclusao = "";
            }

            row.append($('<td class="text-nowrap" onclick="carregaTarefa(' + jsonTarefaArray[i].sequencialTarefa + ');">' +
                tarefa + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTarefaArray[i].dataFinal + '</td>'));
            row.append($('<td class="text-nowrap">' + responsavel + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTarefaArray[i].dataSolicitacao + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTarefaArray[i].dataConclusao + '</td>'));
        }
    }

    function validaTarefa() {
        var dataFinal = $('#dataFinal').val();
        var dataConclusao = $('#dataConclusao').val();

        //Cria-se uma variável para pegar o momento em que um registro foi criado na lista.
        var dataSolicitacao = moment().format("DD/MM/YYYY HH:mm");
        $("#dataSolicitacao").val(dataSolicitacao);

        var diferencaEmDias = comparaDataComDiaHoje(dataConclusao);

        if (diferencaEmDias < 0) {
            smartAlert("Erro", "Atenção, a Data Conclusão não pode ser maior do que a data de hoje", "error");
            $('#dataConclusao').val('');
            return false;
        }

        if (dataFinal === '') {
            smartAlert("Erro", "Informe a Data Final!", "error");
            return false;
        }

        return true;
    }

    function addTarefa() {

        var item = $("#formTarefa").toObject({
            mode: 'combine',
            skipEmpty: false
        });

        if (item["sequencialTarefa"] === '') {
            if (jsonTarefaArray.length === 0) {
                item["sequencialTarefa"] = 1;
            } else {
                item["sequencialTarefa"] = Math.max.apply(Math, jsonTarefaArray.map(function(o) {
                    return o.sequencialTarefa;
                })) + 1;
            }
            item["tarefaId"] = 0;
        } else {
            item["sequencialTarefa"] = +item["sequencialTarefa"];
        }

        var index = -1;
        $.each(jsonTarefaArray, function(i, obj) {
            if (+$('#sequencialTarefa').val() === obj.sequencialTarefa) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTarefaArray.splice(index, 1, item);
        else
            jsonTarefaArray.push(item);

        $("#jsonTarefa").val(JSON.stringify(jsonTarefaArray));
        fillTableTarefa();
        clearFormTarefa();

    }

    function processDataTarefa(node) {
        // var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        // var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        // if (fieldName !== '' && (fieldId === "dataNascimentoFilho")) {

        //     var dataNascimentoFilho = $('#dataNascimentoFilho').val();
        //     dataNascimentoFilho = dataNascimentoFilho.split("/");
        //     dataNascimentoFilho = dataNascimentoFilho[2] + "/" + dataNascimentoFilho[1] + "/" + dataNascimentoFilho[0];

        //     return {
        //         name: fieldName,
        //         value: dataNascimentoFilho
        //     };
        // }

        // return false;
    }

    function clearFormTarefa() {
        $("#tarefa").val('');
        $("#dataFinal").val('');
        $("#responsavel").val('');
        $("#observacaoPrePregao").val('');
        $("#sequencialTarefa").val('');
    }

    function carregaTarefa(sequencialTarefa) {
        var arr = jQuery.grep(jsonTarefaArray, function(item, i) {
            return (item.sequencialTarefa === sequencialTarefa);
        });

        clearFormTarefa();

        if (arr.length > 0) {
            var item = arr[0];
            $("#tarefa").val(item.tarefa);
            $("#dataFinal").val(item.dataFinal);
            $("#responsavel").val(item.responsavel);
            $("#observacaoPrePregao").val(item.observacaoPrePregao);
            $("#tarefaId").val(item.tarefaId);
            $("#sequencialTarefa").val(item.sequencialTarefa);
            $("#dataConclusao").val(item.dataConclusao);
        }
    }

    function excluirTarefa() {
        var arrSequencial = [];
        $('#tableTarefa input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTarefaArray.length - 1; i >= 0; i--) {
                var obj = jsonTarefaArray[i];
                if (jQuery.inArray(obj.sequencialTarefa, arrSequencial) > -1) {
                    jsonTarefaArray.splice(i, 1);
                }
            }
            $("#jsonTarefa").val(JSON.stringify(jsonTarefaArray));
            fillTableTarefa();
        } else
            smartAlert("Erro", "Selecione pelo menos uma informação para excluir.", "error");
    }


    function excluirPrePregao() {
        var arrSequencial = [];
        $('#tablePrePregao input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTarefaArray.length - 1; i >= 0; i--) {
                var obj = jsonTarefaArray[i];
                if (jQuery.inArray(obj.sequencialPrePregao, arrSequencial) > -1) {
                    jsonTarefaArray.splice(i, 1);
                }
            }
            $("#JsonPrePregao").val(JSON.stringify(jsonTarefaArray));
            fillTablePrePregao();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 pré-pregão para excluir.", "error");
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function fillTablePrePregao() {
        $("#tablePrePregao tbody").empty();
        for (var i = 0; i < jsonPrePregaoArray.length; i++) {
            var row = $('<tr />');
            $("#tablePrePregao tbody").append(row);


            var tarefa = $("#tarefa option[value = '" + jsonPrePregaoArray[i].tarefa + "']").text();
            var responsavel = $("#responsavel option[value = '" + jsonPrePregaoArray[i].responsavel + "']").text();
            if (jsonPrePregaoArray[i].dataConclusao == undefined) {
                jsonPrePregaoArray[i].dataConclusao = "";
            }

            row.append($('<td class="text-nowrap" ">' + tarefa + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonPrePregaoArray[i].dataFinal + '</td>'));
            row.append($('<td class="text-nowrap">' + responsavel + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonPrePregaoArray[i].dataSolicitacao + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonPrePregaoArray[i].dataConclusao + '</td>'));
        }
    }

    function validaGravar() {

        var situacao = $('#situacao').val();
        var posicao = $('#posicao').val();
        var prioridade = $('#prioridade').val();
        var condicao = +$('#condicao').val();
        var observacaoCondicao = $('#observacaoCondicao').val();

        if (situacao == "") {
            smartAlert("Erro", "Selecione a situação.", "error");
            $('#situacao').focus();
            return false;
        }
        if ((posicao == "") || (posicao == "0")) {
            smartAlert("Erro", "Selecione a posição.", "error");
            $('#posicao').focus();
            return false;
        }
        if (prioridade == "") {
            smartAlert("Erro", "Selecione a prioridade", "error");
            $('#prioridade').focus();
            return false;
        }

        if (((condicao == 1) || (condicao == 4)) && (observacaoCondicao == "")) {
            smartAlert("Erro", "Escreva uma observação sobre o porquê o pregão está nessa condição.", "error");
            $('#observacaoCondicao').focus();
            return false;
        }

        return true;

    }

    function gravar() {

        var valida = validaGravar();

        if (valida == true) {
            let form = $('#formPregoes')[0];
            let formData = new FormData(form);
            gravaPregoesEmAndamento(formData);
        }
    }

    function comparaDataComDiaHoje(dataDesejada) {
        var dataHoje = moment().format("DD/MM/YYYY");

        //Formata datas(string) para um objeto moment. 
        //Data Hoje
        dataHoje = dataHoje.split("/");
        dataHoje[1] = dataHoje[1] - 1;
        dataHoje = moment([dataHoje[2], dataHoje[1], dataHoje[0]]);

        // Data Desejada
        dataDesejada = dataDesejada.split("/");
        dataDesejada[1] = dataDesejada[1] - 1;
        dataDesejada = moment([dataDesejada[2], dataDesejada[1], dataDesejada[0]]);

        var diferencaEmDias = dataHoje.diff(dataDesejada, 'days');
        return diferencaEmDias;
    }

    /* Função que verifica a obrigatoriedade do campo observacaoCondicao
     *baseado na condicao do pregão.  Caso o pregão seja igual a adiado ou
     *fracassado, ele precisa ficar como OBRIGATORIO,  então, 
     *ele atribui a cor css respectiva.  | Adiado = 1 | Fracassado = 4. 
     */
    function verificaCampoObservacao() {
        var condicao = +$("#condicao").val();

        if ((condicao == 1) || (condicao == 4)) {
            $('#observacaoCondicao').css("backgroundColor", "#FFFFC0");
        } else {
            $('#observacaoCondicao').css("backgroundColor", "#FFF");
        }
    }


    function verificaDataAlerta(data, hora) {
        var dataAtual = moment(); //Contém também a hora.

        data = moment(data + " " + hora + ':00', "DD/MM/YYYY HH:mm:ss");

        var duracao = moment.duration(data.diff(dataAtual));
        var dias = duracao._data.days;
        var horas = duracao._data.hours;
        var minutos = duracao._data.minutes;

        if ((dias == 0) && (horas == 0)) {

            if ((minutos >= 0) && (minutos <= 30)) {
                return true;
            }

        }

        return false;
    }
</script>