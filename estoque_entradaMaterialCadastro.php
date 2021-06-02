<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('ENTRADAITEM_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('ENTRADAITEM_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('ENTRADAITEM_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Entrada Material";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['estoque']['sub']['operacao']['sub']['entradaItem']["active"]  = true;

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
                            <h2>Entrada Item</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formEntradaItem" method="post">
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

                                                        <div id="formCadastro">
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label">Lançamento</label>
                                                                    <label class="input">
                                                                        <input id="codigo" name="codigo" autocomplete="off" class="form-control readonly" readonly type="text" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Data Movimento</label>
                                                                    <label class="input">
                                                                        <input id="dataMovimento" name="dataMovimento" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Dados NFe</strong></legend>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-6">
                                                                    <label class="label">Cliente/Fornecedor</label>
                                                                    <label class="input">
                                                                        <input id="clienteFornecedorId" name="clienteFornecedorId" type="hidden" value="">
                                                                        <input id="clienteFornecedor" name="clienteFornecedorFiltro" autocomplete="off" class="form-control" placeholder="Digite o codigo..." type="text" value="">
                                                                        <i class="icon-append fa fa-filter"></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="tipo">Tipo</label>
                                                                    <label class="select">
                                                                        <select id="tipo" name="tipo" class="required">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM Estoque.tipoDocumento where ativo = 1 order by descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Número</label>
                                                                    <label class="input">
                                                                        <input id="numero" name="numero" maxlength="255" autocomplete="off" class="readonly" disabled type="text" value="">
                                                                    </label>
                                                                </section>

                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label" for="naturezaOperacao">Natureza Operação</label>
                                                                    <label class="select">
                                                                        <input id="naturezaOperacaoId" name="naturezaOperacaoId" type="hidden" value="">
                                                                        <select id="naturezaOperacao" name="naturezaOperacao" class="required">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM Estoque.naturezaOperacao where ativo = 1 AND tipo = 1 order by descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Data Emissão</label>
                                                                    <label class="input">
                                                                        <input id="dataEmissao" name="dataEmissao" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Data Entrada</label>
                                                                    <label class="input">
                                                                        <input id="dataEntrega" name="dataEntrega" autocomplete="off" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                    </label>
                                                                </section>
                                                                <!-- XML DA NOTA -->

                                                                <section class="col col-4">
                                                                    <label class="label">XML da nota</label>
                                                                    <label class="input input-file">
                                                                        <span class="button"><input type="file" id="xmlNota" name="xmlNota[]">Selecione
                                                                            o arquivo</span><input id="xmlNotaText" type="text">
                                                                    </label>
                                                                </section>
                                                                <section id="xmlNotaLink" class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label class="input">
                                                                        <a href="" id="xmlNotaLink"></a>
                                                                    </label>
                                                                </section>

                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <label class="label">Observação</label>
                                                                    <textarea id="observacao" name="observacao" class="form-control" rows="3" style="resize:vertical" autocomplete="off"></textarea>
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
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseItemEntrada" class="" id="accordionItemEntrada">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        item Entrada Material
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseItemEntrada" class="panel-collapse collapse off">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <input id="jsonItem" name="jsonItem" type="hidden" value="[]">
                                                        <div id="formItem">
                                                            <div class="row">
                                                                <input id="ItemId" name="ItemId" type="hidden" value="">
                                                                <input id="sequencialItem" name="sequencialItem" type="hidden" value="">
                                                                <input id="valorTotalItem" name="valorTotalItem" type="hidden" value="0">
                                                                <input id="valorFinalItem" name="valorFinalItem" type="hidden" value="0">
                                                                <input id="valorTotalItemTable" name="valorTotalItemTable" type="hidden" value="0">
                                                                <input id="valorFinalItemTable" name="valorFinalItemTable" type="hidden" value="0">
                                                                <input id="descricaoEstoque" name="descricaoEstoque" type="hidden" value="0">
                                                                <input id="descricaoUnidade" name="descricaoUnidade" type="hidden" value="0">
                                                                <input id="unidadeMedidaId" name="unidadeMedidaId" type="hidden" value="0">
                                                                <!-- <section class="col col-2">
                                                                    <label class="label" for="codigoItem">Código Material</label>
                                                                    <label class="select">
                                                                        <select id="codigoItem" name="codigoItem" class="select required" required>
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, codigoItem FROM Estoque.codigoItem where ativo = 1 order by codigoItem";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['codigoItem']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section> -->
                                                                <section class="col col-2">
                                                                    <label class="label">Código Material</label>
                                                                    <label class="input">
                                                                        <input id="fornecedorObrigatorio" name="fornecedorObrigatorio" type="hidden" value="">
                                                                        <input id="codigoItemId" name="codigoItemId" type="hidden" value="">
                                                                        <input id="codigoItem" name="codigoItemFiltro" autocomplete="off" class="form-control required" placeholder="Digite o codigo..." type="text" value="">
                                                                        <i class="icon-append fa fa-filter"></i>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    <label class="label"> Descrição Item</label>
                                                                    <label class="input">
                                                                        <input id="descricaoItemId" name="descricaoItemId" type="hidden" value="">
                                                                        <input id="descricaoItem" name="descricaoItemFiltro" autocomplete="off" class="form-control required" placeholder="Digite a descrição..." type="text" value="">
                                                                        <i class="icon-append fa fa-filter"></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Informação Item</strong></legend>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label">Quantiidade</label>
                                                                    <label class="input">
                                                                        <input id="quantidade" name="quantidade" maxlength="255" min="0" autocomplete="off" class="required" type="number" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="unidade">Unidade Medida</label>
                                                                    <label class="select">
                                                                        <select id="unidade" name="unidade" class="readonly" disabled>
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao, sigla FROM Estoque.unidadeItem where ativo = 1 order by sigla";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                $sigla = ($row['sigla']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . ' - ' . $sigla . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-4">
                                                                    <label class="label" for="unidadeDestino">Unidade Destino</label>
                                                                    <label class="select">
                                                                        <select id="unidadeDestino" name="unidadeDestino" class="required">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM Ntl.unidade where ativo = 1 order by descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-4">
                                                                    <label class="label" for="estoqueDestino">Estoque Destino</label>
                                                                    <label class="select">
                                                                        <select id="estoqueDestino" name="estoqueDestino" class="required">
                                                                            <option></option>
                                                                            <?php
                                                                            $sql =  "SELECT codigo, descricao FROM Estoque.estoque where ativo = 1 order by descricao";
                                                                            $reposit = new reposit();
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = $row['codigo'];
                                                                                $descricao = ($row['descricao']);
                                                                                echo '<option value=' . $codigo . '>  ' . $descricao  . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label" for="consumivel">Consumível</label>
                                                                    <label class="select">
                                                                        <select id="consumivel" name="consumivel" class="readonly" disabled>
                                                                            <option></option>
                                                                            <option value="1">Sim</option>
                                                                            <option value="0">Não</option>
                                                                        </select><i></i>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="autorizacao">Assinatura Retirada</label>
                                                                    <label class="select">
                                                                        <select id="autorizacao" name="autorizacao" class="readonly" disabled>
                                                                            <option></option>
                                                                            <option value="1">Sim</option>
                                                                            <option value="0">Não</option>
                                                                        </select><i></i>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <legend><strong>Valores</strong></legend>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label">Unitário</label>
                                                                    <label class="input"><i class="icon-append fa fa-dollar"></i>
                                                                        <input id="unitario" name="unitario" class="decimal-2-casas required" type="text" autocomplete="off">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label">Desconto</label>
                                                                    <label class="input"><i class="icon-append fa fa-dollar"></i>
                                                                        <input id="desconto" name="desconto" class="decimal-2-casas" type="text" autocomplete="off">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2 col-auto">
                                                                    <label class="label">Final</label>
                                                                    <label class="input"><i class="icon-append fa fa-dollar"></i>
                                                                        <input id="final" name="final" class="decimal-2-casas readonly" readonly type="text" autocomplete="off">
                                                                    </label>
                                                                </section>
                                                            </div>

                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnAddItem" type="button" class="btn btn-primary" title="Adicionar Item">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverItem" type="button" class="btn btn-danger" title="Remover Item">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableItem" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Código Material</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Material</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Unidade Destino</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Estoque Destino</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Quantidade</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Vlr. Unitário</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Vlr. Total</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Vlr. Desconto</th>
                                                                            <th class="text-left" style="min-width: 10px;">
                                                                                Vlr. Final</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <td class="text-nowrap"></td>
                                                                        <td class="text-nowrap">TOTAL</td>
                                                                        <td class="text-nowrap"></td>
                                                                        <td class="text-nowrap"></td>
                                                                        <td class="text-nowrap"></td>
                                                                        <td class="text-nowrap"></td>
                                                                        <td class="text-nowrap"></td>
                                                                        <td class="text-nowrap">0,00</td>
                                                                        <td class="text-nowrap"></td>
                                                                        <td class="text-nowrap">0,00</td>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </fieldset>
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


<script src="<?php echo ASSETS_URL; ?>/js/business_estoqueEntradaItem.js" type="text/javascript"></script>

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
    jsonItemArray = JSON.parse($("#jsonItem").val());

    $(document).ready(function() {

        carregaPagina();
        recuperaFornecedor();

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '/' + mm + '/' + yyyy;
        $("#dataMovimento").val(today);


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


        $("#clienteFornecedor").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroEntradaItem.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaClienteFornecedorAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#clienteFornecedorId").val(ui.item.id);
                $("#clienteFornecedorFiltro").val(ui.item.nome);
                var descricaoId = $("#clienteFornecedorId").val();
                $("#clienteFornecedor").val(descricaoId)
                $("#clienteFornecedorFiltro").val('');

            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#clienteFornecedorId").val('');
                    $("#clienteFornecedorFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };

        $("#codigoItem").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroEntradaItem.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaCodigoAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                                descricaoItem: item.descricaoItem,
                                unidade: item.unidade,
                                estoque: item.estoque,
                                unidadeItem: item.unidadeItem,
                                consumivel: item.consumivel,
                                autorizacao: item.autorizacao
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#codigoItemId").val(ui.item.id);
                $("#codigoItemFiltro").val(ui.item.nome);
                var descricaoId = $("#codigoItemId").val();
                $("#codigoItem").val(descricaoId)
                $("#codigoItemFiltro").val('');

                var descricaoItem = ui.item.descricaoItem;
                $("#descricaoItemFiltro").val(descricaoItem);
                $("#descricaoItemId").val(descricaoId);
                $("#descricaoItem").val(descricaoItem);
                $("#descricaoItemFiltro").val('');


                $("#unidadeDestino").val(ui.item.unidade);
                popularComboEstoque();
                $("#estoqueDestino").val(ui.item.estoque);
                var descricaoUnidade = $("#unidadeDestino option:selected").text();
                var descricaoEstoque = $("#estoqueDestino option:selected").text();
                $("#descricaoEstoque").val(descricaoEstoque);
                $("#descricaoUnidade").val(descricaoUnidade);

                $("#unidade").val(ui.item.unidadeItem);
                $("#unidadeMedidaId").val(ui.item.unidadeItem);
                $("#consumivel").val(ui.item.consumivel);
                $("#autorizacao").val(ui.item.autorizacao);

            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#codigoItemId").val('');
                    $("#codigoItemFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };


        $("#descricaoItem").autocomplete({
            source: function(request, response) {
                $.ajax({
                    type: 'POST',
                    url: 'js/sqlscope_cadastroEntradaItem.php',
                    cache: false,
                    dataType: "json",
                    data: {
                        maxRows: 12,
                        funcao: "listaDescricaoAtivoAutoComplete",
                        descricaoIniciaCom: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                id: item.id,
                                label: item.descricao,
                                value: item.descricao,
                                codigoItem: item.codigoItem,
                                unidade: item.unidade,
                                estoque: item.estoque,
                                unidadeItem: item.unidadeItem,
                                consumivel: item.consumivel,
                                autorizacao: item.autorizacao
                            };
                        }));
                    }
                });
            },
            minLength: 3,

            select: function(event, ui) {
                $("#descricaoItemId").val(ui.item.id);
                $("#descricaoItemFiltro").val(ui.item.nome);
                var descricaoId = $("#descricaoItemId").val();
                $("#descricaoItem").val(descricaoId)
                $("#descricaoItemFiltro").val('');

                var codigoItem = ui.item.codigoItem;
                $("#codigoItemFiltro").val(codigoItem);
                $("#codigoItemId").val(descricaoId);
                $("#codigoItem").val(codigoItem);
                $("#codigoItemFiltro").val('');


                $("#unidadeDestino").val(ui.item.unidade);
                popularComboEstoque();
                $("#estoqueDestino").val(ui.item.estoque);
                var descricaoUnidade = $("#unidadeDestino option:selected").text();
                var descricaoEstoque = $("#estoqueDestino option:selected").text();
                $("#descricaoEstoque").val(descricaoEstoque);
                $("#descricaoUnidade").val(descricaoUnidade);

                $("#unidade").val(ui.item.unidadeItem);
                $("#unidadeMedidaId").val(ui.item.unidadeItem);
                $("#consumivel").val(ui.item.consumivel);
                $("#autorizacao").val(ui.item.autorizacao);
            },
            change: function(event, ui) {
                if (ui.item === null) {
                    $("#descricaoItemId").val('');
                    $("#descricaoItemsFiltro").val('');
                }
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<a>" + highlight(item.label, this.term) + "</a>")
                .appendTo(ul);
        };


        // $("#dataEntrega").on("change", function() {
        //     var dataAtual = moment().format("DD/MM/YYYY");
        //     var dataEntrega = $("#dataEntrega").val();

        //     //Transformando em um objeto usando moment -> Data Atual
        //     dataAtual = dataAtual.split("/");
        //     dataAtual[1] = dataAtual[1] - 1;
        //     dataAtual = moment([dataAtual[2], dataAtual[1], dataAtual[0]]);

        //     //ransformando em um objeto usando moment -> Data Pregão
        //     dataEntrega = dataEntrega.split("/");
        //     dataEntrega[1] = dataEntrega[1] - 1;
        //     dataEntrega = moment([dataEntrega[2], dataEntrega[1], dataEntrega[0]]);

        //     var diferenca = dataAtual.diff(dataEntrega, 'days');

        //     if (diferenca < 0) {
        //         smartAlert("Atenção", "A data do pregão não pode ser maior do que o dia de hoje !", "error");
        //         $("#dataEntrega").val(" ");
        //         return;
        //     }

        // });

        $("#tipo").on("change", function() {
            let tipo = $('#tipo option:selected').text().trim();
            if (tipo == 'NF') {
                $("#numero").removeClass('readonly');
                $("#numero").attr('disabled', false);
                $("#numero").addClass('required');
                $("#numero").attr('required', true);
            } else {
                $("#numero").removeClass('required');
                $("#numero").attr('required', false);
                $("#numero").addClass('readonly');
                $("#numero").attr('disabled', true);
            }
        });

        $("#unidadeDestino").on("change", function() {
            popularComboEstoque();
        });


        $("#quantidade").on("change", function() {
            var quantidade = $("#quantidade").val();
            var unitario = $("#unitario").val();
            var desconto = $("#desconto").val();

            if (unitario == "") {
                return;
            }
            if (desconto == "") {
                var desconto = '0';
                $("#desconto").val('0,00');
            }
            unitario = unitario.replace(/,/g, ".");
            desconto = desconto.replace(/,/g, ".");

            var total = (parseFloat(unitario) * parseFloat(quantidade)) - parseFloat(desconto);
            total = total.toFixed(2);
            total = total.toString();
            total = total.replace(".", ",");

            $("#final").val(total);
            $("#final").focusout();

        });

        $("#unitario").on("change", function() {
            var quantidade = $("#quantidade").val();
            var unitario = $("#unitario").val();
            var desconto = $("#desconto").val();

            if (quantidade == "") {
                return;
            }
            if (desconto == "") {
                var desconto = '0';
                $("#desconto").val('0,00');
            }
            unitario = unitario.replace(/,/g, ".");
            desconto = desconto.replace(/,/g, ".");

            var total = (parseFloat(unitario) * parseFloat(quantidade)) - parseFloat(desconto);
            total = total.toFixed(2);
            total = total.toString();
            total = total.replace(".", ",");

            $("#final").val(total);
            $("#final").focusout();

        });

        $("#desconto").on("change", function() {
            var quantidade = $("#quantidade").val();
            var unitario = $("#unitario").val();
            var desconto = $("#desconto").val();

            if (unitario == "") {
                return;
            }
            if (quantidade == "") {
                return;
            }
            unitario = unitario.replace(/,/g, ".");
            desconto = desconto.replace(/,/g, ".");

            var total = (parseFloat(unitario) * parseFloat(quantidade)) - parseFloat(desconto);
            total = total.toFixed(2);
            total = total.toString();
            total = total.replace(".", ",");

            $("#final").val(total);
            $("#final").focusout();

        });

        $("input[name='xmlNota[]']").change(function() {
            let files = document.getElementById("xmlNota").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#xmlNotaText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#xmlNotaText").val("");
                $("#xmlNota").val("");

            }

        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        //Botões de Item
        $("#btnAddItem").on("click", function() {
            if (validaItem())
                addItem();
        });

        $("#btnRemoverItem").on("click", function() {
            excluirItem();
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
                recuperaEntradaItem(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayItem = piece[2];

                            piece = out.split("^");
                            codigo = piece[0];
                            dataEntregaMaterial = piece[1];
                            fornecedorID = piece[2];
                            descricaoFornecedor = piece[3];
                            tipoDocumento = piece[4];
                            numeroNF = piece[5];
                            dataEntrega = piece[6];
                            dataEmissaoNF = piece[7];
                            observacao = piece[8];
                            naturezaOperacao = piece[9];
                            filePath = piece[10];
                            fileName = piece[11];
                            fileType = piece[12];

                            //Arrumando o valor de data 
                            dataEntregaMaterial = dataEntregaMaterial.split(" ");
                            dataEntregaMaterial = dataEntregaMaterial[0].split("-");
                            dataEntregaMaterial = dataEntregaMaterial[2] + "/" + dataEntregaMaterial[1] + "/" + dataEntregaMaterial[0];
                            // horaLancamento = dataCadastro[1].split(":");
                            // horaLancamento = horaLancamento[0] + ":" + horaLancamento[1];

                            if (dataEntrega != "") {
                                dataEntrega = dataEntrega.split(" ");
                                dataEntrega = dataEntrega[0].split("-");
                                dataEntrega = dataEntrega[2] + "/" + dataEntrega[1] + "/" + dataEntrega[0];
                            }

                            dataEmissaoNF = dataEmissaoNF.split(" ");
                            dataEmissaoNF = dataEmissaoNF[0].split("-");
                            dataEmissaoNF = dataEmissaoNF[2] + "/" + dataEmissaoNF[1] + "/" + dataEmissaoNF[0];



                            $("#codigo").val(codigo);
                            $("#dataMovimento").val(dataEntregaMaterial);
                            $("#clienteFornecedorId").val(fornecedorID);
                            $("#clienteFornecedor").val(descricaoFornecedor);
                            $("#tipo").val(tipoDocumento);
                            $("#numero").val(numeroNF);
                            $("#dataEntrega").val(dataEntrega);
                            $("#dataEmissao").val(dataEmissaoNF);
                            $("#observacao").val(observacao);
                            $("#naturezaOperacao").val(naturezaOperacao);

                            $("#dataMovimento").addClass('readonly');
                            $("#dataMovimento").attr('disabled', true);
                            $("#clienteFornecedor").addClass('readonly');
                            $("#clienteFornecedor").attr('disabled', true);
                            $("#tipo").addClass('readonly');
                            $("#tipo").attr('disabled', true);
                            $("#numero").addClass('readonly');
                            $("#numero").attr('disabled', true);
                            $("#dataEmissao").addClass('readonly');
                            $("#dataEmissao").attr('disabled', true);
                            $("#naturezaOperacao").addClass('readonly');
                            $("#naturezaOperacao").attr('disabled', true);

                            $("#xmlNota").addClass('readonly');
                            $("#xmlNotaText").addClass('readonly');
                            $("#xmlBtn").addClass('readonly');
                            $("#xmlNota").attr('disabled', true);
                            $("#xmlNotaText").attr('disabled', true);
                            $("#xmlBtn").attr('disabled', true);

                            $("#xmlNotaLink").append("<a href ='" + filePath + fileName + "' target='_blank'>" + fileName + "</a><br>");

                            $("#btnAddItem").attr('disabled', true);
                            $("#btnRemoverItem").attr('disabled', true);
                            $("#btnGravar").attr('disabled', true);

                            $("#jsonItem").val(strArrayItem);
                            jsonItemArray = JSON.parse($("#jsonItem").val());
                            fillTableItem();

                        }
                    }
                );
            }
        }
    }

    function voltar() {
        $(location).attr('href', 'estoque_entradaMaterialFiltro.php');
    }

    function novo() {
        $(location).attr('href', 'estoque_entradaMaterialCadastro.php');
    }

    function excluir() {
        var codigo = +$("#codigo").val();

        if (codigo === 0) {
            smartAlert("Atenção", "Selecione uma Entrada Material para excluir!", "error");
            return;
        }

        excluirEntradaItem(codigo);
    }

    function popularComboEstoque() {
        var unidadeDestino = $("#unidadeDestino").val()
        populaComboEstoque(unidadeDestino,
            function(data) {
                var atributoId = '#' + 'estoqueDestino';
                if (data.indexOf('failed') > -1) {
                    smartAlert("Aviso", "A unidade informada não possui estoques!", "info");
                    $("#unidade").focus()
                    $("#estoqueDestino").val("")
                    $("#estoqueDestino").prop("disabled", true)
                    $("#estoqueDestino").addClass("readonly")
                    return;
                } else {
                    $("#estoqueDestino").prop("disabled", false)
                    $("#estoqueDestino").removeClass("readonly")
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

    function recuperaDescricao() {
        var idd = $("#codigoItem").val();
        recuperaDescricaoCodigo(idd,
            function(data) {
                if (data.indexOf('failed') > -1) {} else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var out = piece[1];

                    piece = out.split("^");
                    codigo = piece[0];
                    descricao = piece[1];

                    $("#clienteFornecedorId").val(descricao);
                    $("#clienteFornecedorId").val(codigo);

                }
            }
        );
    }

    function recuperaFornecedor() {
        recuperaFornecedorObrigatorio(
            function(data) {
                if (data.indexOf('failed') > -1) {} else {
                    data = data.replace(/failed/g, '');
                    var piece = data.split("#");
                    var mensagem = piece[0];
                    var fornecedorObrigatorio = piece[1];

                    $("#fornecedorObrigatorio").val(fornecedorObrigatorio);

                    if (fornecedorObrigatorio == 1) {
                        $("#clienteFornecedor").addClass('required');
                        $("#clienteFornecedor").attr('required', true);
                    }

                }
            }
        );
    }

    //############################################################################## LISTA ITEM INICIO ####################################################################################################################

    function fillTableItem() {
        $("#tableItem tbody").empty();
        for (var i = 0; i < jsonItemArray.length; i++) {
            var row = $('<tr />');
            $("#tableItem tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonItemArray[i].sequencialItem + '"><i></i></label></td>'));

            var valorTotalItem = jsonItemArray[i].valorTotalItem;
            var valorFinalItem = jsonItemArray[i].valorFinalItem;

            var valorTotalItemTable = parseFloat($("#valorTotalItemTable").val());
            var valorFinalItemTable = parseFloat($("#valorFinalItemTable").val());
            var valorTotalItemTable = parseFloat(valorTotalItemTable) + parseFloat(valorTotalItem);
            var valorFinalItemTable = parseFloat(valorFinalItemTable) + parseFloat(valorFinalItem);
            $("#valorTotalItemTable").val(valorTotalItemTable.toFixed(2));
            $("#valorFinalItemTable").val(valorFinalItemTable.toFixed(2));


            var valorTotalItem = valorTotalItem.replace('.', ",");
            var valorFinalItem = valorFinalItem.replace('.', ",");
            var codigo = $("#codigo").val();

            if (codigo === "") {
                row.append($('<td class="text-nowrap" onclick="carregaItem(' + jsonItemArray[i].sequencialItem + ');">' +
                    jsonItemArray[i].codigoItemFiltro + '</td>'));
            } else {
                row.append($('<td class="text-nowrap">' +
                    jsonItemArray[i].codigoItemFiltro + '</td>'));
            }

            row.append($('<td class="text-nowrap">' + jsonItemArray[i].descricaoItemFiltro + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].descricaoUnidade + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].descricaoEstoque + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].quantidade + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].unitario + '</td>'));
            row.append($('<td class="text-nowrap">' + valorTotalItem + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonItemArray[i].desconto + '</td>'));
            row.append($('<td class="text-nowrap">' + valorFinalItem + '</td>'));
        }
        var row = $('<tr />');
        $("#tableItem tbody").append(row);
        row.append($('<td></td>'));
        row.append($('<td class="text-nowrap">TOTAL</td>'));
        row.append($('<td class="text-nowrap"></td>'));
        row.append($('<td class="text-nowrap"></td>'));
        row.append($('<td class="text-nowrap"></td>'));
        row.append($('<td class="text-nowrap"></td>'));
        row.append($('<td class="text-nowrap"></td>'));
        row.append($('<td class="text-nowrap">' + $("#valorTotalItemTable").val() + '</td>'));
        row.append($('<td class="text-nowrap"></td>'));
        row.append($('<td class="text-nowrap">' + $("#valorFinalItemTable").val() + '</td>'));

        var valorTotalItemTable = $("#valorTotalItemTable").val('0');
        var valorFinalItemTable = $("#valorFinalItemTable").val('0');

    }

    function validaItem() {

        var achouData = false;
        var codigoItem = $('#codigoItem').val();
        var descricaoItem = $('#descricaoItem').val();
        var quantidade = $('#quantidade').val();
        var unidade = $('#unidade').val();
        var unidadeDestino = $('#unidadeDestino').val();
        var estoqueDestino = $('#estoqueDestino').val();
        var unitario = $('#unitario').val();
        var desconto = $('#desconto').val();
        var final = $('#final').val();
        var sequencialItem = $('#sequencialItem').val();

        if (codigoItem === '') {
            smartAlert("Erro", "Informe o Código Material!", "error");
            return false;
        }
        if (descricaoItem === '') {
            smartAlert("Erro", "Informe a Descrição Material!", "error");
            return false;
        }
        if (quantidade === '') {
            smartAlert("Erro", "Informe a Quantidade!", "error");
            return false;
        }
        if (unidade === '') {
            smartAlert("Erro", "Informe a Unidade!", "error");
            return false;
        }
        if (unidadeDestino === '') {
            smartAlert("Erro", "Informe a Unidade Destino!", "error");
            return false;
        }
        if (estoqueDestino === '') {
            smartAlert("Erro", "Informe o Estoque Destino!", "error");
            return false;
        }
        if (unitario === '') {
            smartAlert("Erro", "Informe o Valor Unitário!", "error");
            return false;
        }
        if (desconto === '') {
            smartAlert("Erro", "Informe o Desconto!", "error");
            return false;
        }
        if (sequencialItem === '') {
            for (i = jsonItemArray.length - 1; i >= 0; i--) {
                if ((jsonItemArray[i].descricaoItemFiltro === descricaoItem) ||
                    (jsonItemArray[i].descricaoItemFiltro === descricaoItem)) {
                    achouData = true;
                    break;
                }
            }
        }
        if (achouData === true) {
            smartAlert("Erro", "Já existe este Item : (" + descricaoItem + ")", "error");
            return false;
        }

        return true;
    }

    function addItem() {

        validaItem();

        var itemRecuperado = $("#itemRecuperado").val();

        var quantidade = $("#quantidade").val();
        var unitario = parseFloat($("#unitario").val());
        var desconto = parseFloat($("#desconto").val());
        var valorTotalItem = parseFloat($("#valorTotalItem").val());
        var valorFinalItem = parseFloat($("#valorFinalItem").val());


        var valorTotal = parseFloat(quantidade) * parseFloat(unitario);
        var valorFinal = $("#final").val();
        valorFinal = valorFinal.replace(".", "");
        valorFinal = valorFinal.replace(",", ".");
        var valorFinal = parseFloat(valorFinal);
        $("#valorTotalItem").val(valorTotal.toFixed(2));
        $("#valorFinalItem").val(valorFinal.toFixed(2));


        var item = $("#formItem").toObject({
            mode: 'combine',
            skipEmpty: false
        });

        if (item["sequencialItem"] === '') {
            if (jsonItemArray.length === 0) {
                item["sequencialItem"] = 1;
            } else {
                item["sequencialItem"] = Math.max.apply(Math, jsonItemArray.map(function(o) {
                    return o.sequencialItem;
                })) + 1;
            }
            item["ItemId"] = 0;
        } else {
            item["sequencialItem"] = +item["sequencialItem"];
        }

        var index = -1;
        $.each(jsonItemArray, function(i, obj) {
            if (+$('#sequencialItem').val() === obj.sequencialItem) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonItemArray.splice(index, 1, item);
        else
            jsonItemArray.push(item);

        $("#jsonItem").val(JSON.stringify(jsonItemArray));
        fillTableItem();
        clearFormItem();

    }

    function processDataItem(node) {
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

    function clearFormItem() {
        $("#codigoItem").val('');
        $("#descricaoItem").val('');
        $("#quantidade").val('');
        // $("#unidadeDestino").val('');
        // $("#estoqueDestino").val('');
        $("#unidade").val('');
        $("#unitario").val('');
        $("#desconto").val('');
        $("#final").val('');
        $("#sequencialItem").val('');
    }

    function carregaItem(sequencialItem) {
        var arr = jQuery.grep(jsonItemArray, function(item, i) {
            return (item.sequencialItem === sequencialItem);
        });

        clearFormItem();

        if (arr.length > 0) {
            var item = arr[0];
            $("#codigoItem").val(item.codigoItemFiltro);
            $("#descricaoItem").val(item.descricaoItemFiltro);
            $("#codigoItemId").val(item.codigoItemId);
            $("#descricaoItemId").val(item.descricaoItemId);
            $("#quantidade").val(item.quantidade);
            $("#unidadeDestino").val(item.unidadeDestino);
            $("#estoqueDestino").val(item.estoqueDestino);
            $("#unidade").val(item.unidadeMedidaId);
            $("#unitario").val(item.unitario);
            $("#desconto").val(item.desconto);
            $("#final").val(item.final);
            $("#sequencialItem").val(item.sequencialItem);
        }
    }

    function excluirItem() {
        var arrSequencial = [];
        $('#tableItem input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonItemArray.length - 1; i >= 0; i--) {
                var obj = jsonItemArray[i];
                if (jQuery.inArray(obj.sequencialItem, arrSequencial) > -1) {
                    var valorTotal = $('#valorTotalItemTable').val();
                    var valorTotalItem = jsonItemArray[i].valorTotalItem;
                    var valorTotal = parseFloat(valorTotal) - parseFloat(valorTotalItem);
                    $('#valorTotalItemTable').val(valorTotal.toFixed(2));
                    var valorFinal = $('#valorFinalItemTable').val();
                    var valorFinalItem = jsonItemArray[i].valorFinalItem;
                    var valorFinal = parseFloat(valorFinal) - parseFloat(valorFinalItem);
                    $('#valorFinalItemTable').val(valorFinal.toFixed(2));
                    jsonItemArray.splice(i, 1);
                }
            }

            $("#jsonItem").val(JSON.stringify(jsonItemArray));
            fillTableItem();
        } else
            smartAlert("Erro", "Selecione pelo menos uma informação para excluir.", "error");
    }

    //############################################################################## LISTA Filho FIM #######################################################################################################################


    function validaCampoData(campo) {
        var valor = $(campo).val();
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js
        if (validacao === false) {
            $(campo).val("");
        }
    }

    function validaData(valor) {

        if ((valor == undefined) || (valor == " ")) {
            return;
        }

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

    function validaCampos() {

        var clienteFornecedorId = $('#clienteFornecedorId').val();
        var fornecedorObrigatorio = $('#fornecedorObrigatorio').val();
        var tipo = $('#tipo option:selected').val();
        var dataEmissao = $('#dataEmissao').val();
        var dataEntrega = $('#dataEntrega').val();
        var naturezaOperacao = $('#naturezaOperacao').val();


        if (fornecedorObrigatorio == 1 && clienteFornecedorId === '') {
            smartAlert("Erro", "Informe o Fornecedor!", "error");
            $('#clienteFornecedor').focus();
            return false;
        }
        if (tipo === '') {
            smartAlert("Erro", "Informe o Tipo!", "error");
            $('#tipo').focus();
            return false;
        }
        if (naturezaOperacao === '') {
            smartAlert("Erro", "Informe a Natureza da Operação!", "error");
            $('#naturezaOperacao').focus();
            return false;
        }
        if (dataEmissao === '') {
            smartAlert("Erro", "Informe o Data Emissão!", "error");
            $('#dataEmissao').focus();
            return false;
        }
        if (dataEntrega === '') {
            smartAlert("Erro", "Informe o Data Entrada!", "error");
            $('#dataEntrega').focus();
            return false;
        }
        if (jsonItemArray.length === 0) {
            smartAlert("Erro", "Nenhum item na lista!", "error");
            return false;
        }

        return true;
    }

    function gravar() {

        if (validaCampos()) {
            $("#btnGravar").attr('disabled', true);

            var form = $('#formEntradaItem')[0];
            var formData = new FormData(form);
            gravaEntradaItem(formData);
        }
    }
</script>