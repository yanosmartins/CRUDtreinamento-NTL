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
$page_nav["operacao"]["sub"]['faturamento']['sub']["projetoPosto"]["active"] = true;

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
                                <form class="smart-form client-form" id="formPosto" method="post">
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
                                                                    <select id="posto" name="posto" class="required">
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
                                                        </div>
                                                        <div class="row">
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
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Composição da remuneração</legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonRemuneracao" name="jsonRemuneracao" type="hidden" value="[]">
                                                        <div id="formRemuneracao" class="col-sm-12">
                                                            <input id="remuneracaoId" name="remuneracaoId" type="hidden" value="">
                                                            <input id="sequencialRemuneracao" name="sequencialRemuneracao" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label">Remuneracao</label>
                                                                        <label class="select">
                                                                            <select id="remuneracao">
                                                                                <option> </option>
                                                                                <option>Salário</option>
                                                                                <option>Bonus</option>
                                                                                <option>Beneficio do cargo</option>
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
                                                        <input id="jsonEncargoPercentual" name="jsonEncargoPercentual" type="hidden" value="[]">
                                                        <div id="formEncargoPercentual" class="col-sm-12">
                                                            <input id="encargoPercentualId" name="encargoPercentualId" type="hidden" value="">
                                                            <input id="sequencialEncargoPercentual" name="sequencialEncargoPercentual" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label">Encargo</label>
                                                                        <label class="select">
                                                                            <select id="encargo">
                                                                                <option> </option>
                                                                                <option>ISS</option>
                                                                                <option>FGTS</option>
                                                                                <option>Encargo governamental</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Percentual</label>
                                                                        <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                            <input id="percentual" name="percentual" style="text-align: right;" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-4">
                                                                        <label class="label">Grupo</label>
                                                                        <label class="select">
                                                                            <select id="encargoGrupo">
                                                                                <option></option>
                                                                                <option>Grupo A</option>
                                                                                <option>Grupo B</option>
                                                                                <option>Grupo C</option>
                                                                                <option>Grupo E</option>
                                                                                <option>Grupo F</option>
                                                                                <option>Grupo G</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddEncargoPercentual" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverEncargoPercentual" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableEncargoPercentual" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center" style="min-width: 500%;">Encargo</th>
                                                                            <th class="text-center">Percentual</th>
                                                                            <th class="text-center">Descrição</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="display:none">
                                                                        <?php
                                                                        echo '<tr >';
                                                                        echo '<td class="text-left"><a></a></td>';
                                                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">SENAC</a></td>';
                                                                        echo '<td class="text-left">2,0000%</td>';
                                                                        echo '<td class="text-left"> </td>';
                                                                        echo '</tr >';
                                                                        echo '<tr >';
                                                                        echo '<td class="text-left"><a></a></td>';
                                                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">INSS</a></td>';
                                                                        echo '<td class="text-left">7,799%</td>';
                                                                        echo '<td class="text-left"> </td>';
                                                                        echo '</tr >';
                                                                        echo '<tr >';
                                                                        echo '<td class="text-left"><a></a></td>';
                                                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">SESC</a></td>';
                                                                        echo '<td class="text-left">5,0000%</td>';
                                                                        echo '<td class="text-left"> </td>';
                                                                        echo '</tr >';
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend>Insumos</legend>
                                                            </section>
                                                        </div>
                                                        <input id="jsonInsumos" name="jsonInsumos" type="hidden" value="[]">
                                                        <div id="formInsumos" class="col-sm-12">
                                                            <input id="insumosId" name="insumosId" type="hidden" value="">
                                                            <input id="sequencialInsumos" name="sequencialInsumos" type="hidden" value="">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-4">
                                                                        <label class="label">Insumos</label>
                                                                        <label class="select">
                                                                            <select id="insumos">
                                                                                <option> </option>
                                                                                <option>Uniforme</option>
                                                                                <option>Capacete</option>
                                                                                <option>Computadores</option>
                                                                                <option>Ferramenta</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Valor</label>
                                                                        <label class="input"><i class="icon-append fa fa-money"></i>
                                                                            <input id="insumosValor" name="insumosValor" style="text-align: right;" type="text" autocomplete="off" maxlength="100">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-4">
                                                                        <label class="label">Grupo</label>
                                                                        <label class="select">
                                                                            <select id="insumosGrupo">
                                                                                <option></option>
                                                                                <option>Grupo A</option>
                                                                                <option>Grupo B</option>
                                                                                <option>Grupo C</option>
                                                                                <option>Grupo E</option>
                                                                                <option>Grupo F</option>
                                                                                <option>Grupo G</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-2">
                                                                        <label class="label">&nbsp;</label>
                                                                        <button id="btnAddInsumos" type="button" class="btn btn-primary">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                        <button id="btnRemoverInsumos" type="button" class="btn btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                        </button>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableInsumos" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th style="width: 2px"></th>
                                                                            <th class="text-center" style="min-width: 500%;">Despesa</th>
                                                                            <th class="text-center">Valor</th>
                                                                            <th class="text-center">Descrição</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="display:none">
                                                                        <?php
                                                                        echo '<tr >';
                                                                        echo '<td class="text-left"><a></a></td>';
                                                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">Uniforme</a></td>';
                                                                        echo '<td class="text-left">R$ 251,98</td>';
                                                                        echo '<td class="text-left"> </td>';
                                                                        echo '</tr >';
                                                                        echo '<tr >';
                                                                        echo '<td class="text-left"><a></a></td>';
                                                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">Capacete</a></td>';
                                                                        echo '<td class="text-left">R$ 198,88</td>';
                                                                        echo '<td class="text-left"> </td>';
                                                                        echo '</tr >';
                                                                        echo '<tr >';
                                                                        echo '<td class="text-left"><a></a></td>';
                                                                        echo '<td class="text-left"><a href="tabelaBasica_lancamentoCadastro.php?codigo=' . $id . '">Benefício Social Familiar - Cláusula 26º, parágrafo 2º da CCT</a></td>';
                                                                        echo '<td class="text-left">R$ 5,00</td>';
                                                                        echo '<td class="text-left"> </td>';
                                                                        echo '</tr >';
                                                                        ?>
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
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <section class="col col-md-6">
                                                                        <label class="label">Bdi</label>
                                                                        <label class="select">
                                                                            <select id="bdi">
                                                                                <option> </option>
                                                                                <option>Despesas Indiretas</option>
                                                                                <option>Lucro</option>
                                                                                <option>COFINS</option>
                                                                                <option>Ferramenta</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label">Percentual</label>
                                                                        <label class="input"><i class="icon-append fa fa-percent"></i>
                                                                            <input id="bdiValor" name="bdiValor" style="text-align: right;" type="text" autocomplete="off" maxlength="100">
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
                                                            <button type="button" id="btn" class="btn btn-info" aria-hidden="true" title="btn">
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

<script src="<?php echo ASSETS_URL; ?>/js/business_tabelaBasicaPosto.js" type="text/javascript"></script>

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
        jsonEncargoPercentualArray = JSON.parse($("#jsonEncargoPercentual").val());
        jsonInsumosArray = JSON.parse($("#jsonInsumos").val());
        jsonBdiArray = JSON.parse($("#jsonBdi").val());
        jsonRemuneracaoArray = JSON.parse($("#jsonRemuneracao").val());


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

        $("#btnAddEncargoPercentual").on("click", function() {
            addEncargoPercentual();
        });

        $("#btnAddInsumos").on("click", function() {
            addInsumos();
        });

        $("#btnAddBdi").on("click", function() {
            addBdi();
        });
        
        $("#btnAddRemuneracao").on("click", function() {
            addRemuneracao();
            calculaValorRemuneracao()
        });


        $("#btnRecuperaEncargo").on("click", function() {
            $("#tableEncargoPercentual tbody").css("display", "")
        });
        $("#btnRecuperaInsumo").on("click", function() {
            $("#tableInsumos tbody").css("display", "")
        });
        

        carregaPagina();
    });

    function gravar() {

        var descricao = $("#descricao").val();

        if (descricao == "" || descricao === " ") {
            smartAlert("Atenção", "Insira uma Descrição", "error")
            return false;
        }

        let posto = $('#formPosto').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        gravaPosto(posto,
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
                    novo();
                }
            }
        );
    }


    function novo() {
        $(location).attr('href', 'tabelaBasica_postoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'tabelaBasica_projetoEncargoFiltro.php');
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
                recuperaPosto(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];

                            piece = out.split("^");
                            codigo = piece[0];
                            descricao = piece[1];
                            ativo = piece[2];

                            $("#codigo").val(codigo);
                            $("#descricao").val(descricao);
                            $("#ativo").val(ativo);

                        }
                    }
                );
            }
        }
    }

    function addEncargoPercentual() {
        var item = $("#formEncargoPercentual").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEncargoPercentual
        });

        if (item["sequencialEncargoPercentual"] === '') {
            if (jsonEncargoPercentualArray.length === 0) {
                item["sequencialEncargoPercentual"] = 1;
            } else {
                item["sequencialEncargoPercentual"] = Math.max.apply(Math, jsonEncargoPercentualArray.map(function(o) {
                    return o.sequencialEncargoPercentual;
                })) + 1;
            }
            item["encargoPercentualId"] = 0;
        } else {
            item["sequencialEncargoPercentual"] = +item["sequencialEncargoPercentual"];
        }

        var index = -1;
        $.each(jsonEncargoPercentualArray, function(i, obj) {
            if (+$('#sequencialEncargoPercentual').val() === obj.sequencialEncargoPercentual) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEncargoPercentualArray.splice(index, 1, item);
        else
            jsonEncargoPercentualArray.push(item);

        $("#jsonEncargoPercentual").val(JSON.stringify(jsonEncargoPercentualArray));
        fillTableEncargoPercentual();
        clearFormEncargoPercentual();

    }

    function fillTableEncargoPercentual() {
        $("#tableEncargoPercentual tbody").empty();
        for (var i = 0; i < jsonEncargoPercentualArray.length; i++) {
            var row = $('<tr />');
            $("#tableEncargoPercentual tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEncargoPercentualArray[i].sequencialEncargoPercentual + '"><i></i></label></td>'));
            row.append($('<td class="text-center" onclick="carregaEncargoPercentual(' + jsonEncargoPercentualArray[i].sequencialEncargoPercentual + ');">' + jsonEncargoPercentualArray[i].encargo + '</td>'));
            row.append($('<td class="text-center">' + jsonEncargoPercentualArray[i].percentual + '</td>'));
            row.append($('<td class="text-center">' + jsonEncargoPercentualArray[i].encargoGrupo + '</td>'));
        }
    }

    function clearFormEncargoPercentual() {
        $("#encargo").val('');
        $("#encargoPercentualId").val('');
        $("#sequencialEncargoPercentual").val('');
        $('#percentual').val('');
        $('#encargoGrupo').val('');
    }

    function processDataEncargoPercentual(node) {
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

    function carregaEncargoPercentual(sequencialEncargoPercentual) {
        var arr = jQuery.grep(jsonEncargoPercentualArray, function(item, i) {
            return (item.sequencialEncargoPercentual === sequencialEncargoPercentual);
        });

        clearFormEncargoPercentual();

        if (arr.length > 0) {
            var item = arr[0];
            $("#encargo").val(item.encargo);
            $("#percentual").val(item.percentual);
            $("#sequencialEncargoPercentual").val(item.sequencialEncargoPercentual);
        }
    }


    // insumos
    function clearFormInsumos() {
        $("#insumos").val('');
        $("#insumosId").val('');
        $("#sequencialInsumos").val('');
        $('#insumosValor').val('');
    }

    function addInsumos() {
        var item = $("#formInsumos").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataInsumos
        });

        if (item["sequencialInsumos"] === '') {
            if (jsonInsumosArray.length === 0) {
                item["sequencialInsumos"] = 1;
            } else {
                item["sequencialInsumos"] = Math.max.apply(Math, jsonInsumosArray.map(function(o) {
                    return o.sequencialInsumos;
                })) + 1;
            }
            item["encargoPercentualId"] = 0;
        } else {
            item["sequencialInsumos"] = +item["sequencialInsumos"];
        }

        var index = -1;
        $.each(jsonInsumosArray, function(i, obj) {
            if (+$('#sequencialInsumos').val() === obj.sequencialInsumos) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonInsumosArray.splice(index, 1, item);
        else
            jsonInsumosArray.push(item);

        $("#jsonInsumos").val(JSON.stringify(jsonInsumosArray));
        fillTableInsumos();
        clearFormInsumos();

    }

    function fillTableInsumos() {
        $("#tableInsumos tbody").empty();
        for (var i = 0; i < jsonInsumosArray.length; i++) {
            var row = $('<tr />');
            $("#tableInsumos tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonInsumosArray[i].sequencialInsumos + '"><i></i></label></td>'));
            row.append($('<td class="text-center" onclick="carregaInsumos(' + jsonInsumosArray[i].sequencialInsumos + ');">' + jsonInsumosArray[i].insumos + '</td>'));
            row.append($('<td class="text-center">' + jsonInsumosArray[i].insumosValor + '</td>'));
            row.append($('<td class="text-center">' + jsonInsumosArray[i].insumosGrupo + '</td>'));
        }
    }


    function processDataInsumos(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "insumos")) {
            var insumos = $("#insumos").val();
            if (insumos !== '') {
                fieldName = "insumos";
            }
            return {
                name: fieldName,
                value: insumos
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
        if (fieldName !== '' && (fieldId === "insumosGrupo")) {
            var insumosGrupo = $("#insumosGrupo").val();
            if (insumosGrupo !== '') {
                fieldName = "insumosGrupo";
            }
            return {
                name: fieldName,
                value: insumosGrupo
            };
        }

        return false;
    }

    // bdi
    function clearFormBdi() {
        $("#bdi").val('');
        $("#bdiId").val('');
        $("#sequencialBdi").val('');
        $('#bdiValor').val('');
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
            item["encargoPercentualId"] = 0;
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

    function fillTableBdi() {
        $("#tableBdi tbody").empty();
        for (var i = 0; i < jsonBdiArray.length; i++) {
            var row = $('<tr />');
            $("#tableBdi tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonBdiArray[i].sequencialBdi + '"><i></i></label></td>'));
            row.append($('<td class="text-center" onclick="carregaBdi(' + jsonBdiArray[i].sequencialBdi + ');">' + jsonBdiArray[i].bdi + '</td>'));
            row.append($('<td class="text-center">' + jsonBdiArray[i].bdiValor + '</td>'));
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

        return false;
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
            item["encargoPercentualId"] = 0;
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
            row.append($('<td class="text-center" onclick="carregaRemuneracao(' + jsonRemuneracaoArray[i].sequencialRemuneracao + ');">' + jsonRemuneracaoArray[i].remuneracao + '</td>'));
            row.append($('<td class="text-center">' + 'R$ '+ jsonRemuneracaoArray[i].remuneracaoValor + '</td>'));
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

    function calculaValorRemuneracao(){
        var valorTotalRemuneracao = 0
        for (var i = 0; i < jsonRemuneracaoArray.length; i++){
            valorTotalRemuneracao += +jsonRemuneracaoArray[i].remuneracaoValor.replace(",", ".")
        }
        $('#remuneracaoTotal').val(valorTotalRemuneracao.toFixed(2).replace(".", ","));
    }

</script>