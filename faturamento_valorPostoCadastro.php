<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
// $condicaoAcessarOK = (in_array('POSTO_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('POSTO_GRAVAR', $arrayPermissao, true));
// $condicaoExcluirOK = (in_array('POSTO_EXCLUIR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }

// $esconderBtnGravar = "";
// if ($condicaoGravarOK === false) {
//     $esconderBtnGravar = "none";
// }

// $esconderBtnExcluir = "";
// if ($condicaoExcluirOK === false) {
//     $esconderBtnExcluir = "none";
// }

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Posto";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['faturamento']['sub']['cadastro']['sub']["projetoPosto"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Tabela Básica"] = "";
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
                            <h2>Pojeto Encargo</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formValorPosto" method="post">
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
                                                            <section class="col col-5">
                                                                <label class="label">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.projeto where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-4">
                                                                <label class="label">Posto</label>
                                                                <label class="select">
                                                                    <select id="posto" name="posto" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, descricao FROM Ntl.posto where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Remuneração</label>
                                                                <label class="input"><i class="icon-append fa fa-money"></i>
                                                                    <input id="remuneracaoTotal" name="remuneracaoTotal" placeholder="0,00" style="text-align: right;" type="text" autocomplete="off" maxlength="100" class="readonly">
                                                                </label>
                                                            </section>
                                                            <section class="col col-md-2">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo" class="required">
                                                                        <option></option>
                                                                        <option value="1" selected>Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <!-- <div class="row">
                                                            <section class="col col-1">
                                                                <button type="button" id="btnRecuperaEncargo" class="btn btn-info" aria-hidden="true" title="btn">
                                                                    Recupera Encargo
                                                                </button>
                                                            </section>
                                                            <section class="col col-2">
                                                                <button type="button" id="btnRecuperaInsumo" class="btn btn-info" aria-hidden="true" title="btn">
                                                                    Recupera Insumo
                                                                </button>
                                                            </section>
                                                        </div> -->
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Composição da remuneração</legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonRemuneracao" name="jsonRemuneracao" type="hidden" value="[]">
                                                        <div id="formRemuneracao" class="col-sm-12">
                                                            <input id="remuneracaoId" name="remuneracaoId" type="hidden" value="">
                                                            <input id="sequencialRemuneracao" name="sequencialRemuneracao" type="hidden" value="">
                                                            <input id="descricaoRemuneracao" name="descricaoRemuneracao" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-4">
                                                                        <label class="label">Remuneração</label>
                                                                        <label class="select">
                                                                            <select id="remuneracao" name="remuneracao">
                                                                                <option></option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, descricao FROM Ntl.remuneracao where ativo = 1 order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricao = ($row['descricao']);
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Valor</label>
                                                                        <label class="input"><i class="icon-append fa fa-money"></i>
                                                                            <input id="remuneracaoValor" name="remuneracaoValor" style="text-align: right;" type="text" autocomplete="off" maxlength="100" placeholder="0,00">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddRemuneracao" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverRemuneracao" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>

                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableRemuneracao" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center" style="min-width: 500%;">Descrição</th>
                                                                            <th class="text-center">Valor</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Encargos Percentuais</legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonEncargo" name="jsonEncargo" type="hidden" value="[]">
                                                        <div id="formEncargo" class="col-sm-12">
                                                            <input id="encargoId" name="encargoId" type="hidden" value="">
                                                            <input id="sequencialEncargo" name="sequencialEncargo" type="hidden" value="">
                                                            <input id="encargoDescricao" name="encargoDescricao" type="hidden" value="">
                                                            <input id="encargoGrupoDescricao" name="encargoGrupoDescricao" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-4">
                                                                        <label class="label">Encargo</label>
                                                                        <label class="select">
                                                                            <select id="encargo" name="encargo">
                                                                                <option></option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, descricao FROM Ntl.encargo where ativo = 1 order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricao = ($row['descricao']);
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Percentual</label>
                                                                        <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                            <input id="percentual" name="percentual" style="text-align: right;" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-4">
                                                                        <label class="label">Grupo</label>
                                                                        <label class="select">
                                                                            <select id="encargoGrupo" name="encargoGrupo">
                                                                                <option></option>
                                                                                <?php
                                                                                $sql = "SELECT codigo, descricao FROM Ntl.grupo where ativo = 1 order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricao = ($row['descricao']);
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddEncargo" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverEncargo" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableEncargo" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center" style="min-width: 500%;">Encargo</th>
                                                                            <th class="text-center">Percentual</th>
                                                                            <th class="text-center">Descrição</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Insumos</legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonInsumo" name="jsonInsumo" type="hidden" value="[]">
                                                        <div id="formInsumo" class="col-sm-12">
                                                            <input id="insumoId" name="insumoId" type="hidden" value="">
                                                            <input id="sequencialInsumo" name="sequencialInsumo" type="hidden" value="">
                                                            <input id="insumoDescricao" name="insumoDescricao" type="hidden" value="">
                                                            <input id="insumoGrupoDescricao" name="insumoGrupoDescricao" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-4">
                                                                        <label class="label">Insumo</label>
                                                                        <label class="select">
                                                                            <select id="insumo" name="insumo">
                                                                                <option></option>
                                                                                <?php
                                                                                $sql =  "SELECT codigo, descricao FROM Ntl.insumo where ativo = 1 order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricao = ($row['descricao']);
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Valor</label>
                                                                        <label class="input"><i class="icon-append fa fa-money"></i>
                                                                            <input id="insumoValor" name="insumoValor" style="text-align: right;" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-4">
                                                                        <label class="label">Grupo</label>
                                                                        <label class="select">
                                                                            <select id="insumoGrupo" name="insumoGrupo">
                                                                                <option></option>
                                                                                <?php
                                                                                $sql = "SELECT codigo, descricao FROM Ntl.grupo where ativo = 1 order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricao = ($row['descricao']);
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddInsumo" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverInsumo" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableInsumo" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center" style="min-width: 500%;">Despesa</th>
                                                                            <th class="text-center">Valor</th>
                                                                            <th class="text-center">Descrição</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>BDI</legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonBdi" name="jsonBdi" type="hidden" value="[]">
                                                        <div id="formBdi" class="col-sm-12">
                                                            <input id="bdiId" name="bdiId" type="hidden" value="">
                                                            <input id="sequencialBdi" name="sequencialBdi" type="hidden" value="">
                                                            <input id="bdiDescricao" name="bdiDescricao" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-4">
                                                                        <label class="label">Bdi</label>
                                                                        <label class="select">
                                                                            <select id="bdi" name="bdi">
                                                                                <option></option>
                                                                                <?php
                                                                                $sql = "SELECT codigo, descricao FROM Ntl.bdi where ativo = 1 order by codigo";
                                                                                $reposit = new reposit();
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = $row['codigo'];
                                                                                    $descricao = ($row['descricao']);
                                                                                    echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Percentual</label>
                                                                        <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                            <input id="bdiPercentual" name="bdiPercentual" style="text-align: right;" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddBdi" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverBdi" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableBdi" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center" style="width: 750px">BDI</th>
                                                                            <th class="text-center">percentual</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend></legend>
                                                                </section>
                                                            </div>
                                                            <button id="calculaGrupoModal" type="button" class="btn btn-info" aria-hidden="true" title="btn">
                                                                Calcula Grupo
                                                            </button>
                                                            <button type="button" id="btn" class="btn btn-info" aria-hidden="true" title="btn">
                                                                Composição
                                                            </button>
                                                            <button type="button" id="btn" class="btn btn-warning" aria-hidden="true" title="btn">
                                                                Calcular Valor do Posto
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <!-- <div class="panel panel-default">
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
                                                            Inserção de Dias Trabalhados
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div> -->
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
                                <div class="modal fade" id="parametroLinkModalPanel" data-backdrop="static" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" style="width:75%;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    &times;
                                                </button>
                                                <h4 class="modal-title"> Calculo por grupo</h4>
                                            </div>
                                            <div id="parametroLinkModalBody" class="modal-body" style="min-height:290px;">
                                                <h4 class="modal-title">
                                                    <legend> Remuneracao</legend>
                                                </h4>
                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                    <input id="jsonRemuneracaoModal" name="jsonRemuneracaoModal" type="hidden" value="[]">
                                                    <table id="tableRemuneracaoModal" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                        <thead>
                                                            <tr role="row">
                                                                <th class="text-center" style="width: 750px">Descricao</th>
                                                                <th class="text-center">Valor</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <td>TOTAL</td>
                                                            <td class="text-right decimal-2-casas">0,00</td>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <h4 class="modal-title">
                                                    <legend> Total <b>Encargo</b> Grupo</legend>
                                                </h4>
                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                    <input id="jsonGrupoEncargoModal" name="jsonGrupoEncargoModal" type="hidden" value="[]">
                                                    <table id="tableEncargoGrupoModal" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                        <thead>
                                                            <tr role="row">
                                                                <th class="text-center" style="width: 750px">Grupo</th>
                                                                <th class="text-center">Total % </th>
                                                                <th class="text-center">Valor</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <td>TOTAL</td>
                                                            <td></td>
                                                            <td class="text-right decimal-2-casas">0,00</td>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <h4 class="modal-title">
                                                    <legend> Total <b>Insumo</b> Grupo</legend>
                                                </h4>
                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                    <input id="jsonGrupoInsumoModal" name="jsonGrupoInsumoModal" type="hidden" value="[]">
                                                    <table id="tableInsumoGrupoModal" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                        <thead>
                                                            <tr role="row">
                                                                <th class="text-center" style="width: 750px">Grupo</th>
                                                                <th class="text-center">Total R$ </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <h4 class="modal-title">
                                                    <legend><b>Resultado</b></legend>
                                                </h4>
                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                    <input id="jsonGrupoResultadoModal" name="jsonGrupoResultadoModal" type="hidden" value="[]">
                                                    <table id="tableResultadoGrupoModal" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                        <thead>
                                                            <tr role="row">
                                                                <!-- <th style="width: 2px"></th> -->
                                                                <th class="text-center" style="width: 750px">Total Categoria</th>
                                                                <th class="text-center">Valor</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- <td></td>
                                                            <td>TOTAL</td>
                                                            <td class="text-right decimal-2-casas">0,00</td> -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer"></div>
                                        </div>
                                    </div>
                                </div>
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

<script src="<?php echo ASSETS_URL; ?>/js/business_faturamentoValorPosto.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_URL; ?>/js/gir_script.js" type="text/javascript"></script>
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

<script src="<?php echo ASSETS_URL; ?>/js/plugin/collect.min.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        jsonEncargoArray = JSON.parse($("#jsonEncargo").val());
        jsonInsumoArray = JSON.parse($("#jsonInsumo").val());
        jsonBdiArray = JSON.parse($("#jsonBdi").val());
        jsonRemuneracaoArray = JSON.parse($("#jsonRemuneracao").val());
        jsonRemuneracaoModalArray = JSON.parse($("#jsonRemuneracaoModal").val());
        jsonGrupoEncargoModalArray = JSON.parse($("#jsonGrupoEncargoModal").val());
        jsonGrupoInsumoModalArray = JSON.parse($("#jsonGrupoInsumoModal").val());
        jsonGrupoResultadoModalArray = JSON.parse($("#jsonGrupoResultadoModal").val());

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
        $('#percentual').focusout(function() {
            var percentual, element;
            element = $(this);
            element.unmask();
            percentual = element.val().replace(/\D/g, '');
            if (percentual.length > 3) {
                element.mask("99.99?9");
            } else {
                element.mask("9.99?9");
            }
        }).trigger('focusout');

        $("#btnAddEncargo").on("click", function() {
            var encargo = $("#encargo").val();
            var percentual = $("#percentual").val();
            var encargoGrupo = $("#encargoGrupo").val();

            if (!encargo) {
                smartAlert("Atenção", "Escolha um encargo", "error")
                return;
            }
            if (!percentual) {
                smartAlert("Atenção", "Coloque o percentual do encargo", "error")
                return;
            }
            if (!encargoGrupo) {
                smartAlert("Atenção", "Informe o grupo do encargo", "error")
                return;
            }

            addEncargo();
        });
        $("#btnRemoverEncargo").on("click", function() {
            excluirEncargo();
        });


        $("#btnAddInsumo").on("click", function() {
            var insumo = $("#insumo").val();
            var insumoValor = $("#insumoValor").val();
            var insumoGrupo = $("#insumoGrupo").val();

            if (!insumo) {
                smartAlert("Atenção", "Escolha um insumo", "error")
                return;
            }
            if (!insumoValor) {
                smartAlert("Atenção", "Coloque o valor do insumo", "error")
                return;
            }
            if (!insumoGrupo) {
                smartAlert("Atenção", "Informe o grupo do insumo", "error")
                return;
            }

            addInsumo();
        });
        $("#btnRemoverInsumo").on("click", function() {
            excluirInsumo();
        });

        $("#btnAddBdi").on("click", function() {

            var bdi = $("#bdi").val();
            var bdiPercentual = $("#bdiPercentual").val();

            if (!bdi) {
                smartAlert("Atenção", "Escolha um bdi", "error")
                return;
            }
            if (!bdiPercentual) {
                smartAlert("Atenção", "Coloque o percentual do bdi", "error")
                return;
            }

            addBdi();
        });
        $("#btnRemoverBdi").on("click", function() {
            excluirBdi();
        });

        $("#btnAddRemuneracao").on("click", function() {
            var remuneracao = $("#remuneracao").val();
            var remuneracaoValor = $("#remuneracaoValor").val();

            if (!remuneracao) {
                smartAlert("Atenção", "Escolha uma remuneração", "error")
                return;
            }

            if (!remuneracaoValor) {
                smartAlert("Atenção", "Coloque o valor da remuneração", "error")
                return;
            }
            addRemuneracao();
            calculaValorRemuneracao()
        });
        $("#btnRemoverRemuneracao").on("click", function() {
            excluirRemuneracao();
        });


        $("#btnRecuperaEncargo").on("click", function() {
            $("#tableEncargo tbody").css("display", "")
        });
        $("#btnRecuperaInsumo").on("click", function() {
            $("#tableInsumo tbody").css("display", "")
        });

        $("#calculaGrupoModal").on("click", function() {
            var valorTotalRemuneracao = $("#remuneracaoTotal").val();
            valorTotalRemuneracao = unparseBRL(valorTotalRemuneracao);
            var array = collect(jsonEncargoArray).groupBy("encargoGrupo").map(function(item) {
                var percentualEncargoGrupo = item.sum("percentual");
                var descricaoGrupoEncargoGrupo = item.first().encargoGrupoDescricao;
                var totalEncargoRemuneracao = valorTotalRemuneracao * (percentualEncargoGrupo / 100); // Calculo do percentual em cima do salário total (remuneração)
                totalEncargoRemuneracao = totalEncargoRemuneracao.toFixed([2]);
                return {
                    percentualEncargoGrupo,
                    descricaoGrupoEncargoGrupo,
                    totalEncargoRemuneracao
                }
            }).values().sortBy("descricaoGrupoEncargoGrupo");

            var arrayInsumo = collect(jsonInsumoArray).groupBy("insumoGrupo").map(function(item) {
                var insumoValor = item.first().insumoValor;
                // insumoValor = unparseBRL(insumoValor);
                insumoValor = item.sum(({
                    insumoValor
                }) => unparseBRL(insumoValor));
                var descricaoGrupoInsumoGrupo = item.first().insumoGrupoDescricao;
                return {
                    insumoValor,
                    descricaoGrupoInsumoGrupo
                }
            }).values().sortBy("descricaoGrupoInsumoGrupo");

            fillTableGrupoEncargoModal(array);
            fillTableGrupoInsumoModal(arrayInsumo);
            fillTableRemuneracaoModal();
            fillTableResultadoModal();
            $('#parametroLinkModalPanel').modal();
        });

        carregaPagina();
    });

    function gravar() {

        var descricao = $("#descricao").val();

        if (descricao == "" || descricao === " ") {
            smartAlert("Atenção", "Insira uma Descrição", "error")
            return false;
        }

        let valorPosto = $('#formValorPosto').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        gravaValorPosto(valorPosto,
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
                        //                                                            return;
                    }
                } else {
                    var piece = data.split("#");
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    voltar()
                }
            }
        );
    }


    function novo() {
        $(location).attr('href', 'faturamento_valorPostoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'faturamento_valorPostoFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirPosto(id, function(data) {
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
                recuperaValorPosto(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayRemuneracao = piece[2];
                            var strArrayEncargo = piece[3];
                            var strArrayInsumo = piece[4];
                            var strArrayBdi = piece[5];

                            piece = out.split("^");
                            codigo = +piece[0];
                            projeto = +piece[1];
                            posto = +piece[2];
                            ativo = +piece[3];

                            $("#codigo").val(codigo);
                            $("#projeto").val(projeto);
                            $("#posto").val(posto);
                            $("#ativo").val(ativo);

                            $("#jsonRemuneracao").val(strArrayRemuneracao);
                            jsonRemuneracaoArray = JSON.parse($("#jsonRemuneracao").val());
                            fillTableRemuneracao();
                            $("#jsonEncargo").val(strArrayEncargo);
                            jsonEncargoArray = JSON.parse($("#jsonEncargo").val());
                            fillTableEncargo();
                            $("#jsonInsumo").val(strArrayInsumo);
                            jsonInsumoArray = JSON.parse($("#jsonInsumo").val());
                            fillTableInsumo();
                            $("#jsonBdi").val(strArrayBdi);
                            jsonBdiArray = JSON.parse($("#jsonBdi").val());
                            fillTableBdi();
                            calculaValorRemuneracao();

                        }
                    }
                );
            }
        }
    }

    function addEncargo() {
        var item = $("#formEncargo").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEncargo
        });

        if (item["sequencialEncargo"] === '') {
            if (jsonEncargoArray.length === 0) {
                item["sequencialEncargo"] = 1;
            } else {
                item["sequencialEncargo"] = Math.max.apply(Math, jsonEncargoArray.map(function(o) {
                    return o.sequencialEncargo;
                })) + 1;
            }
            item["encargoId"] = 0;
        } else {
            item["sequencialEncargo"] = +item["sequencialEncargo"];
        }

        var index = -1;
        $.each(jsonEncargoArray, function(i, obj) {
            if (+$('#sequencialEncargo').val() === obj.sequencialEncargo) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEncargoArray.splice(index, 1, item);
        else
            jsonEncargoArray.push(item);

        $("#jsonEncargo").val(JSON.stringify(jsonEncargoArray));
        fillTableEncargo();
        clearFormEncargo();

    }

    function fillTableEncargo() {
        $("#tableEncargo tbody").empty();
        for (var i = 0; i < jsonEncargoArray.length; i++) {
            var row = $('<tr />');
            $("#tableEncargo tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEncargoArray[i].sequencialEncargo + '"><i></i></label></td>'));
            row.append($('<td class="text-left" onclick="carregaEncargo(' + jsonEncargoArray[i].sequencialEncargo + ');">' + jsonEncargoArray[i].encargoDescricao + '</td>'));
            row.append($('<td class="text-center">' + parseBRL(jsonEncargoArray[i].percentual) + ' %' + '</td>'));
            row.append($('<td class="text-center">' + jsonEncargoArray[i].encargoGrupoDescricao + '</td>'));
        }
    }

    function clearFormEncargo() {
        $("#encargo").val('');
        $("#encargoId").val('');
        $("#sequencialEncargo").val('');
        $('#percentual').val('');
        $('#encargoGrupo').val('');
    }

    function processDataEncargo(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "encargo")) {
            var encargo = $("#encargo").val();
            if (encargo !== '') {
                fieldName = "encargo";
            }
            return {
                name: fieldName,
                value: encargo
            };
        }
        if (fieldName !== '' && (fieldId === "percentual")) {
            var percentual = $("#percentual").val();
            if (percentual !== '') {
                fieldName = "percentual";
            }
            return {
                name: fieldName,
                value: percentual
            };
        }

        if (fieldName !== '' && (fieldId === "encargoDescricao")) {
            return {
                name: fieldName,
                value: $("#encargo option:selected").text()
            };
        }

        if (fieldName !== '' && (fieldId === "encargoGrupoDescricao")) {
            return {
                name: fieldName,
                value: $("#encargoGrupo option:selected").text()
            };
        }

        if (fieldName !== '' && (fieldId === "encargoGrupo")) {
            var encargoGrupo = $("#encargoGrupo").val();
            if (encargoGrupo !== '') {
                fieldName = "encargoGrupo";
            }
            return {
                name: fieldName,
                value: encargoGrupo
            };
        }

        return false;
    }

    function carregaEncargo(sequencialEncargo) {
        var arr = jQuery.grep(jsonEncargoArray, function(item, i) {
            return (item.sequencialEncargo === sequencialEncargo);
        });

        clearFormEncargo();

        if (arr.length > 0) {
            var item = arr[0];
            $("#encargo").val(item.encargo);
            $("#percentual").val(item.percentual);
            $("#encargoGrupo").val(item.encargoGrupo);
            $("#sequencialEncargo").val(item.sequencialEncargo);
        }
    }

    function excluirEncargo() {
        var arrSequencial = [];
        $('#tableEncargo input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonEncargoArray.length - 1; i >= 0; i--) {
                var obj = jsonEncargoArray[i];
                if (jQuery.inArray(obj.sequencialEncargo, arrSequencial) > -1) {
                    jsonEncargoArray.splice(i, 1);
                }
            }
            $("#jsonEncargo").val(JSON.stringify(jsonEncargoArray));
            fillTableEncargo();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Encargo para excluir.", "error");
    }


    // insumo
    function clearFormInsumo() {
        $("#insumo").val('');
        $("#insumoId").val('');
        $("#sequencialInsumo").val('');
        $('#insumoValor').val('');
        $('#insumoGrupo').val('');
    }

    function addInsumo() {
        var item = $("#formInsumo").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataInsumo
        });

        if (item["sequencialInsumo"] === '') {
            if (jsonInsumoArray.length === 0) {
                item["sequencialInsumo"] = 1;
            } else {
                item["sequencialInsumo"] = Math.max.apply(Math, jsonInsumoArray.map(function(o) {
                    return o.sequencialInsumo;
                })) + 1;
            }
            item["insumoId"] = 0;
        } else {
            item["sequencialInsumo"] = +item["sequencialInsumo"];
        }

        var index = -1;
        $.each(jsonInsumoArray, function(i, obj) {
            if (+$('#sequencialInsumo').val() === obj.sequencialInsumo) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonInsumoArray.splice(index, 1, item);
        else
            jsonInsumoArray.push(item);

        $("#jsonInsumo").val(JSON.stringify(jsonInsumoArray));
        fillTableInsumo();
        clearFormInsumo();

    }

    function fillTableInsumo() {
        $("#tableInsumo tbody").empty();
        for (var i = 0; i < jsonInsumoArray.length; i++) {
            var row = $('<tr />');
            $("#tableInsumo tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonInsumoArray[i].sequencialInsumo + '"><i></i></label></td>'));
            row.append($('<td class="text-left" onclick="carregaInsumo(' + jsonInsumoArray[i].sequencialInsumo + ');">' + jsonInsumoArray[i].insumoDescricao + '</td>'));
            row.append($('<td class="text-center">' + 'R$ ' + parseBRL(unparseBRL(jsonInsumoArray[i].insumoValor), 2) + '</td>'));
            row.append($('<td class="text-center">' + jsonInsumoArray[i].insumoGrupoDescricao + '</td>'));
        }
    }


    function processDataInsumo(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "insumo")) {
            var insumo = $("#insumo").val();
            if (insumo !== '') {
                fieldName = "insumo";
            }
            return {
                name: fieldName,
                value: insumo
            };
        }
        if (fieldName !== '' && (fieldId === "insumoValor")) {
            var insumoValor = $("#insumoValor").val();
            if (insumoValor !== '') {
                fieldName = "insumoValor";
            }
            return {
                name: fieldName,
                value: insumoValor
            };
        }

        if (fieldName !== '' && (fieldId === "insumoGrupoDescricao")) {
            return {
                name: fieldName,
                value: $("#insumoGrupo option:selected").text()
            };
        }

        if (fieldName !== '' && (fieldId === "insumoDescricao")) {
            return {
                name: fieldName,
                value: $("#insumo option:selected").text()
            };
        }



        if (fieldName !== '' && (fieldId === "insumoGrupo")) {
            var insumoGrupo = $("#insumoGrupo").val();
            if (insumoGrupo !== '') {
                fieldName = "insumoGrupo";
            }
            return {
                name: fieldName,
                value: insumoGrupo
            };
        }

        return false;
    }

    function carregaInsumo(sequencialInsumo) {
        var arr = jQuery.grep(jsonInsumoArray, function(item, i) {
            return (item.sequencialInsumo === sequencialInsumo);
        });

        clearFormInsumo();

        if (arr.length > 0) {
            var item = arr[0];
            $("#insumo").val(item.insumo);
            $("#insumoValor").val(item.insumoValor);
            $("#insumoGrupo").val(item.insumoGrupo);
            $("#sequencialInsumo").val(item.sequencialInsumo);
        }
    }


    function excluirInsumo() {
        var arrSequencial = [];
        $('#tableInsumo input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonInsumoArray.length - 1; i >= 0; i--) {
                var obj = jsonInsumoArray[i];
                if (jQuery.inArray(obj.sequencialInsumo, arrSequencial) > -1) {
                    jsonInsumoArray.splice(i, 1);
                }
            }
            $("#jsonInsumo").val(JSON.stringify(jsonInsumoArray));
            fillTableInsumo();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Insumo para excluir.", "error");
    }

    // bdi
    function clearFormBdi() {
        $("#bdi").val('');
        $("#bdiId").val('');
        $("#sequencialBdi").val('');
        $('#bdiPercentual').val('');
    }

    function addBdi() {
        var item = $("#formBdi").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataBdi
        });

        if (item["sequencialBdi"] === '') {
            if (jsonBdiArray.length === 0) {
                item["sequencialBdi"] = 1;
            } else {
                item["sequencialBdi"] = Math.max.apply(Math, jsonBdiArray.map(function(o) {
                    return o.sequencialBdi;
                })) + 1;
            }
            item["bdiId"] = 0;
        } else {
            item["sequencialBdi"] = +item["sequencialBdi"];
        }

        var index = -1;
        $.each(jsonBdiArray, function(i, obj) {
            if (+$('#sequencialBdi').val() === obj.sequencialBdi) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonBdiArray.splice(index, 1, item);
        else
            jsonBdiArray.push(item);

        $("#jsonBdi").val(JSON.stringify(jsonBdiArray));
        fillTableBdi();
        clearFormBdi();

    }
    var totalBdi;
    function fillTableBdi() {
        $("#tableBdi tbody").empty();
        totalBdi = 0;
        for (var i = 0; i < jsonBdiArray.length; i++) {
            var row = $('<tr />');
            $("#tableBdi tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonBdiArray[i].sequencialBdi + '"><i></i></label></td>'));
            row.append($('<td class="text-left" onclick="carregaBdi(' + jsonBdiArray[i].sequencialBdi + ');">' + jsonBdiArray[i].bdiDescricao + '</td>'));
            row.append($('<td class="text-center">' + parseBRL(jsonBdiArray[i].bdiPercentual) + ' %' + '</td>'));
            totalBdi += +jsonBdiArray[i].bdiPercentual;
        }
    }


    function processDataBdi(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "bdi")) {
            var bdi = $("#bdi").val();
            if (bdi !== '') {
                fieldName = "bdi";
            }
            return {
                name: fieldName,
                value: bdi
            };
        }

        if (fieldName !== '' && (fieldId === "bdiDescricao")) {
            return {
                name: fieldName,
                value: $("#bdi option:selected").text()
            };
        }
        if (fieldName !== '' && (fieldId === "bdiPercentual")) {
            var bdiPercentual = $("#bdiPercentual").val();

            if (insumoValor !== '') {
                fieldName = "bdiPercentual";
            }
            return {
                name: fieldName,
                value: unparseBRL(bdiPercentual)
            };
        }

        return false;
    }

    function excluirBdi() {
        var arrSequencial = [];
        $('#tableBdi input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonBdiArray.length - 1; i >= 0; i--) {
                var obj = jsonBdiArray[i];
                if (jQuery.inArray(obj.sequencialBdi, arrSequencial) > -1) {
                    jsonBdiArray.splice(i, 1);
                }
            }
            $("#jsonBdi").val(JSON.stringify(jsonBdiArray));
            fillTableBdi();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Bdi para excluir.", "error");
    }

    function carregaBdi(sequencialBdi) {
        var arr = jQuery.grep(jsonBdiArray, function(item, i) {
            return (item.sequencialBdi === sequencialBdi);
        });

        clearFormBdi();

        if (arr.length > 0) {
            var item = arr[0];
            $("#bdi").val(item.bdi);
            $("#bdiPercentual").val(item.bdiPercentual);
            $("#sequencialBdi").val(item.sequencialBdi);
        }
    }

    // remuneracao
    function clearFormRemuneracao() {
        $("#remuneracao").val('');
        $("#remuneracaoId").val('');
        $("#sequencialRemuneracao").val('');
        $('#remuneracaoValor').val('');
    }

    function addRemuneracao() {
        var item = $("#formRemuneracao").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataRemuneracao
        });

        if (item["sequencialRemuneracao"] === '') {
            if (jsonRemuneracaoArray.length === 0) {
                item["sequencialRemuneracao"] = 1;
            } else {
                item["sequencialRemuneracao"] = Math.max.apply(Math, jsonRemuneracaoArray.map(function(o) {
                    return o.sequencialRemuneracao;
                })) + 1;
            }
            item["remuneracaoId"] = 0;
        } else {
            item["sequencialRemuneracao"] = +item["sequencialRemuneracao"];
        }

        var index = -1;
        $.each(jsonRemuneracaoArray, function(i, obj) {
            if (+$('#sequencialRemuneracao').val() === obj.sequencialRemuneracao) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonRemuneracaoArray.splice(index, 1, item);
        else
            jsonRemuneracaoArray.push(item);

        $("#jsonRemuneracao").val(JSON.stringify(jsonRemuneracaoArray));
        fillTableRemuneracao();
        clearFormRemuneracao();

    }

    function fillTableRemuneracao() {
        $("#tableRemuneracao tbody").empty();
        for (var i = 0; i < jsonRemuneracaoArray.length; i++) {
            var row = $('<tr />');
            $("#tableRemuneracao tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonRemuneracaoArray[i].sequencialRemuneracao + '"><i></i></label></td>'));
            row.append($('<td class="text-left" onclick="carregaRemuneracao(' + jsonRemuneracaoArray[i].sequencialRemuneracao + ');">' + jsonRemuneracaoArray[i].descricaoRemuneracao + '</td>'));
            row.append($('<td class="text-center">' + 'R$ ' + parseBRL(unparseBRL(jsonRemuneracaoArray[i].remuneracaoValor), 2) + '</td>'));
        }
    }


    function processDataRemuneracao(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "remuneracao")) {
            var remuneracao = $("#remuneracao").val();
            if (remuneracao !== '') {
                fieldName = "remuneracao";
            }
            return {
                name: fieldName,
                value: remuneracao
            };
        }

        if (fieldName !== '' && (fieldId === "descricaoRemuneracao")) {
            return {
                name: fieldName,
                value: $("#remuneracao option:selected").text()
            };
        }

        if (fieldName !== '' && (fieldId === "remuneracaoValor")) {
            var remuneracaoValor = $("#remuneracaoValor").val();
            if (remuneracaoValor !== '') {
                fieldName = "remuneracaoValor";
            }
            return {
                name: fieldName,
                value: remuneracaoValor
            };
        }
        return false;
    }

    function calculaValorRemuneracao() {
        var valorTotalRemuneracao = 0;
        for (var i = 0; i < jsonRemuneracaoArray.length; i++) {
            var aux = jsonRemuneracaoArray[i].remuneracaoValor;
            aux = unparseBRL(aux);
            valorTotalRemuneracao += parseFloat(aux);
        }
        $('#remuneracaoTotal').val(valorTotalRemuneracao.toFixed(2).replace(".", ","));
    }

    function carregaRemuneracao(sequencialRemuneracao) {
        var arr = jQuery.grep(jsonRemuneracaoArray, function(item, i) {
            return (item.sequencialRemuneracao === sequencialRemuneracao);
        });

        clearFormRemuneracao();

        if (arr.length > 0) {
            var item = arr[0];
            $("#remuneracao").val(item.remuneracao);
            $("#remuneracaoValor").val(item.remuneracaoValor);
            $("#sequencialRemuneracao").val(item.sequencialRemuneracao);
        }
    }

    function excluirRemuneracao() {
        var arrSequencial = [];
        $('#tableRemuneracao input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonRemuneracaoArray.length - 1; i >= 0; i--) {
                var obj = jsonRemuneracaoArray[i];
                if (jQuery.inArray(obj.sequencialRemuneracao, arrSequencial) > -1) {
                    jsonRemuneracaoArray.splice(i, 1);
                }
            }
            $("#jsonRemuneracao").val(JSON.stringify(jsonRemuneracaoArray));
            fillTableRemuneracao();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Remuneracao para excluir.", "error");
    }
    // remuneracao fim

    // Modal inicio 
    function fillTableRemuneracaoModal() {
        $("#tableRemuneracaoModal tbody").empty();
        jsonRemuneracaoModalArray = jsonRemuneracaoArray;
        var remuneracaoTotal = $('#remuneracaoTotal').val();
        for (var i = 0; i < jsonRemuneracaoModalArray.length; i++) {
            var row = $('<tr/>');
            $("#tableRemuneracaoModal tbody").append(row);
            // row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonRemuneracaoModalArray[i].sequencialRemuneracao + '"><i></i></label></td>'));
            row.append($('<td class="text-left">' + jsonRemuneracaoModalArray[i].descricaoRemuneracao + '</td>'));
            row.append($('<td class="text-center">' + "R$ " + parseBRL(unparseBRL(jsonRemuneracaoModalArray[i].remuneracaoValor), 2) + '</td>'));
        }
        var row = $('<tr/>');
        $("#tableRemuneracaoModal tbody").append(row);
        row.append($('<td class="text-center"><b>' + "TOTAL: " + '</b></td>'));
        row.append($('<td class="text-center"><b>' + "R$ " + parseBRL(unparseBRL(remuneracaoTotal), 2) + '</b></td>'));
    }

    var totalEncargoRemuneracaoModal;
    function fillTableGrupoEncargoModal(array) {
        $("#tableEncargoGrupoModal tbody").empty();
        totalEncargoRemuneracaoModal = 0;
        jsonGrupoEncargoModalArray = array.items;
        for (var i = 0; i < jsonGrupoEncargoModalArray.length; i++) {
            var row = $('<tr/>');
            $("#tableEncargoGrupoModal tbody").append(row);
            // row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonRemuneracaoModalArray[i].sequencialRemuneracao + '"><i></i></label></td>'));
            row.append($('<td class="text-left">' + jsonGrupoEncargoModalArray[i].descricaoGrupoEncargoGrupo + '</td>'));
            row.append($('<td class="text-center">' + parseBRL(jsonGrupoEncargoModalArray[i].percentualEncargoGrupo) + " %" + '</td>'));
            row.append($('<td class="text-center">' + "R$ " + parseBRL(jsonGrupoEncargoModalArray[i].totalEncargoRemuneracao, 2) + '</td>'));
            var aux = +jsonGrupoEncargoModalArray[i].totalEncargoRemuneracao;
            totalEncargoRemuneracaoModal += aux;
        }
        var row = $('<tr/>');
        $("#tableEncargoGrupoModal tbody").append(row);
        row.append($('<td class="text-center"><b>' + "TOTAL: " + '</b></td>'));
        row.append($('<td class="text-center"></td>'));
        // row.append($('<td class="text-center"><b>' + "R$ " + totalEncargoRemuneracaoModal + '</b></td>'));
        row.append($('<td class="text-center"><b>' + "R$ " + parseBRL(totalEncargoRemuneracaoModal, 2) + '</b></td>'));
    }

    var totalInsumooModal;
    function fillTableGrupoInsumoModal(array) {
        $("#tableInsumoGrupoModal tbody").empty();
        totalInsumooModal = 0;
        jsonGrupoInsumoModalArray = array.items;
        for (var i = 0; i < jsonGrupoInsumoModalArray.length; i++) {
            var row = $('<tr/>');
            $("#tableInsumoGrupoModal tbody").append(row);
            // row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonRemuneracaoModalArray[i].sequencialRemuneracao + '"><i></i></label></td>'));
            row.append($('<td class="text-left">' + jsonGrupoInsumoModalArray[i].descricaoGrupoInsumoGrupo + '</td>'));
            row.append($('<td class="text-center">' + "R$ " + parseBRL(jsonGrupoInsumoModalArray[i].insumoValor, 2) + '</td>'));
            var aux = +jsonGrupoInsumoModalArray[i].insumoValor;
            totalInsumooModal += aux;
        }
        var row = $('<tr/>');
        $("#tableInsumoGrupoModal tbody").append(row);
        row.append($('<td class="text-center"><b>' + "TOTAL: " + '</b></td>'));
        // row.append($('<td class="text-center"><b>' + "R$ " + totalEncargoRemuneracaoModal + '</b></td>'));
        row.append($('<td class="text-center"><b>' + "R$ " + parseBRL(totalInsumooModal, 2) + '</b></td>'));
    }
    var resumoValorUnitarioCategoria = 0;
    function fillTableResultadoModal(array) {
        $("#tableResultadoGrupoModal tbody").empty();
        remuneracaoTotalResumo = unparseBRL(remuneracaoTotal = $('#remuneracaoTotal').val());
        
        jsonGrupoResultadoModalArray = [];
        var totalResultadooModal = 0;
        for (var i = 0; i < jsonGrupoResultadoModalArray.length; i++) {
            var row = $('<tr/>');
            $("#tableResultadoGrupoModal tbody").append(row);
            // row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonRemuneracaoModalArray[i].sequencialRemuneracao + '"><i></i></label></td>'));
            row.append($('<td class="text-left">' + jsonGrupoResultadoModalArray[i].descricaoGrupoResultadoGrupo + '</td>'));
            row.append($('<td class="text-center">' + "R$ " + parseBRL(jsonGrupoResultadoModalArray[i].insumoValor, 2) + '</td>'));
            var aux = +jsonGrupoResultadoModalArray[i].insumoValor;
            totalResultadooModal += aux;
        }
        //Contas para Resumo
        resumoValorUnitarioCategoria = totalEncargoRemuneracaoModal + totalInsumooModal + remuneracaoTotalResumo; // Valor Total Cat. = Todos insumos/encargos + remuneraçao
        percentualBdiTotal = (totalBdi/100)*resumoValorUnitarioCategoria // total do % bdi * resumoValorUnitarioCategoria
        valorUnitarioCategoria = (resumoValorUnitarioCategoria + percentualBdiTotal);
        var a = (valorUnitarioCategoria/remuneracaoTotalResumo) - (100/100) ;
        a = a * 100;

        contaMarcello =  (100 + jsonBdiArray[0].bdiPercentual) * (100 + jsonBdiArray[1].bdiPercentual)  
        / (100 - (jsonBdiArray[2].bdiPercentual + jsonBdiArray[3].bdiPercentual + jsonBdiArray[4].bdiPercentual)) - 100; //calculo tirado do excel 

        var row = $('<tr/>');
        $("#tableResultadoGrupoModal tbody").append(row);
        row.append($('<td class="text-left">' + "Total Categoria: " + '</td>'));
        row.append($('<td class="text-center">' + "R$ " + parseBRL(resumoValorUnitarioCategoria, 2) + '</td>'));
        var row = $('<tr/>');
        $("#tableResultadoGrupoModal tbody").append(row);
        row.append($('<td class="text-left">' + "BDI: " + totalBdi + " %" + "M:"+ contaMarcello + '</td>'));
        row.append($('<td class="text-center">' + "R$ " + parseBRL(percentualBdiTotal, 2)+'</td>'));
        var row = $('<tr/>');
        $("#tableResultadoGrupoModal tbody").append(row);
        row.append($('<td class="text-left"><b>' + "VALOR UNITARIO CATEGORIA: " + '</b></td>'));
        row.append($('<td class="text-center"><b>' + "R$ " + parseBRL(valorUnitarioCategoria, 2) + '</b></td>'));
        var row = $('<tr/>');
        $("#tableResultadoGrupoModal tbody").append(row);
        row.append($('<td class="text-left"><b>' + "PERCENTUAL SOBRE A MATRIZ REFERENCIAL: " + '</b></td>'));
        row.append($('<td class="text-center"><b>'  + parseBRL(a) + " %" + '</b></td>'));
    }
    
</script>