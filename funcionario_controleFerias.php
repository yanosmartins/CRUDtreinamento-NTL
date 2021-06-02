<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

$condicaoGestorOK = (in_array('CONTROLEFERIAS_MENUGESTOR', $arrayPermissao, true));
$condicaoFuncionarioOK = (in_array('CONTROLEFERIAS_MENUFUNCIONARIO', $arrayPermissao, true));
$condicaoGravarOK = (in_array('CONTROLEFERIAS_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('CONTROLEFERIAS_EXCLUIR', $arrayPermissao, true));

if ($condicaoGestorOK == false && $condicaoFuncionarioOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}
$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$gestor =  "order by nome";
$funcionario = "";
if ($condicaoGestorOK === false) {
    $id = $_SESSION['funcionario'];
    $funcionario = "hidden";
    $gestor = "AND codigo =  $id";
    $gestorProjeto =  "where BP.ativo = 1  AND BP.funcionario =  $id";
    $gestorCargo ="AND F.codigo =  $id"; ;
}


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Controle de Férias";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['funcionario']['sub']['cadastro']['sub']['controleFerias']["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Área do Funcionário"] = "";
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
                            <h2>Controle de Férias</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formCliente" method="post" enctype="multipart/form-data">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDados" class="" id="accordionDados">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDados" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <input id="codigo" name="codigo" type="text" class="hidden" value="">
                                                            <input id="cargoId" name="cargoId" type="text" class="hidden" value="">
                                                            <input id="projetoId" name="projetoId" type="text" class="hidden" value="">

                                                            <section class="col col-3">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario" class="required ">
                                                                        <option></option>
                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];

                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL " . $gestor;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $nome = $row['nome'];
                                                                            echo '<option value=' . $codigoFuncionario . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="matricula">Matrícula</label>
                                                                <label class="select">

                                                                    <select id="matricula" name="matricula" class="readonly" style="touch-action:none;pointer-events:none">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, matricula  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL " . $gestor;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $matricula = $row['matricula'];
                                                                            echo '<option value=' . $codigoFuncionario . '>' . $matricula . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="cargo">Cargo</label>
                                                                <label class="select">
                                                                    <select id="cargo" name="cargo" class="readonly" style="touch-action:none;pointer-events:none">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT F.codigo, F.cargo, C.descricao as cargoDescricao  from Ntl.funcionario F
                                                                        inner join Ntl.cargo C ON C.codigo = F.cargo
                                                                        where F.ativo = 1 AND dataDemissaoFuncionario IS NULL "  . $gestorCargo;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $codigo = $row['cargo'];
                                                                            $cargo = $row['cargoDescricao'];
                                                                            echo '<option value=' . $codigoFuncionario . '>' . $cargo . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="readonly" style="touch-action:none;pointer-events:none">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                       
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT BP.codigo, BP.funcionario, BP.projeto, P.descricao as projetoDescricao from Ntl.beneficioProjeto BP
                                                                        inner join Ntl.projeto P ON P.codigo = BP.projeto ".$gestorProjeto;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['funcionario'];
                                                                            $codigo = (int) $row['projeto'];
                                                                            $projeto = $row['projetoDescricao'];

                                                                            echo '<option value=' . $codigoFuncionario . '>' . $projeto . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">

                                                            <section class="col col-2">
                                                                <label class="label" for="dataAdmissao">Data de admissao</label>
                                                                <label class="select">
                                                                    <select id="dataAdmissao" name="dataAdmissao" class="readonly" style="touch-action:none;pointer-events:none">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, dataAdmissaoFuncionario  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL ". $gestor;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $dataAdmissaoFuncionario = $row['dataAdmissaoFuncionario'];

                                                                            $aux = explode(' ', $row['dataAdmissaoFuncionario']);
                                                                            $data = $aux[1] . ' ' . $aux[0];
                                                                            $data = $aux[0];
                                                                            $data =  trim($data);
                                                                            $aux = explode('-', $data);
                                                                            $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                                                                            $data =  trim($data);
                                                                            $dataAdmissaoFuncionario = $data;

                                                                            echo '<option value=' . $codigoFuncionario . '>' . $dataAdmissaoFuncionario . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="periodoAquisitivoInicioLista">Período Aquisitivo - Início</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoAquisitivoInicioLista" name="periodoAquisitivoInicioLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Período Aquisitivo - Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoAquisitivoFimLista" name="periodoAquisitivoFimLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>



                                                            <section class="col col-1">
                                                                <label class="label" for="diasVencidos">Dias Vencidos</label>
                                                                <label class="input">
                                                                    <input type="number" id="diasVencidos" readonly class="readonly" name="diasVencidos" autocomplete="off">
                                                                </label>
                                                            </section>



                                                            <section class="col col-2">
                                                                <label class="label <?php echo $funcionario ?>" for="periodoFeriasInicioLista">Período de Férias - Início</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar <?php echo $funcionario ?>"></i>
                                                                    <input id="periodoFeriasInicioLista" name="periodoFeriasInicioLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker <?php echo $funcionario ?>" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label <?php echo $funcionario ?>">Período de Férias - Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar <?php echo $funcionario ?>"></i>
                                                                    <input id="periodoFeriasFimLista" name="periodoFeriasFimLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker <?php echo $funcionario ?>" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="select">
                                                                    <select name="ativo" id="ativo" class="hidden">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFerias" class="" id="accordionFerias">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Solicitação
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFerias" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <input id="jsonControleFerias" name="jsonControleFerias" type="hidden" value="[]">
                                                            <div id="formControleFerias" class="col-sm-12">
                                                                <input id="controleFeriasId" name="controleFeriasId" type="hidden" value="">
                                                                <input id="sequencialControleFerias" name="sequencialControleFerias" type="hidden" value="">

                                                                <div class="col col-10">
                                                                    <section class="col col-2">
                                                                        <label class="label" for="solicitacaoInicioFerias">Data de Início</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="solicitacaoInicioFerias" name="solicitacaoInicioFerias" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-1">
                                                                        <label class="label" for="diasSolicitacao">Qtde. de dias</label>
                                                                        <label class="input">
                                                                            <input type="number" id="diasSolicitacao" name="diasSolicitacao" class="required" autocomplete="off">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="solicitacaoFimFerias">Data Fim</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="solicitacaoFimFerias" name="solicitacaoFimFerias" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class=" readonly" readonly value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>


                                                                    <section class="col col-1">
                                                                        <label class="label" for="adiantamentoDecimo">Adiantamento 13º</label>
                                                                        <label class="select">
                                                                            <select name="adiantamentoDecimo" id="adiantamentoDecimo" class="required">
                                                                                <option value="1">Sim</option>
                                                                                <option value="0">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                <div class="col col-10">
                                                                    <section class="col col-1">
                                                                        <label class="label" for="abono">Tem Abono</label>
                                                                        <label class="select">
                                                                            <select name="abono" id="abono" class="required">
                                                                                <option value="1">Sim</option>
                                                                                <option value="0">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>



                                                                    <section class="col col-1">
                                                                        <label class="label <?php echo $funcionario ?>" for="status">Status</label>
                                                                        <label class="select">
                                                                            <select id="status" name="status" class="required <?php echo $funcionario ?>">
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "SELECT S.codigo,S.descricao FROM Ntl.status S  WHERE S.ativo = 1 ORDER BY S.codigo";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $descricao = $row['descricao'];
                                                                                    $pattern = "/^aberto$/i";
                                                                                    if (preg_match($pattern, $descricao)) {
                                                                                        echo '<option value="' . $codigo . '" selected>' . $descricao . '</option>';
                                                                                    } else {
                                                                                        echo '<option value="' . $codigo . '">' . $descricao . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select><i class="<?php echo $funcionario ?>"></i>
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="periodoAquisitivoInicio"></label>
                                                                        <label class="input">
                                                                            <input id="periodoAquisitivoInicio" name="periodoAquisitivoInicio" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required hidden" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label" for="periodoAquisitivoFim"></label>
                                                                        <label class="input">
                                                                            <input id="periodoAquisitivoFim" name="periodoAquisitivoFim" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required hidden" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label" for="periodoFeriasInicio"></label>
                                                                        <label class="input">
                                                                            <input id="periodoFeriasInicio" name="periodoFeriasInicio" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required hidden" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label" for="periodoFeriasFim"></label>
                                                                        <label class="input">
                                                                            <input id="periodoFeriasFim" name="periodoFeriasFim" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required hidden" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>
                                                                </div>



                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-md-2">
                                                                <label class="label">&nbsp;</label>
                                                                <button id="btnAddControleFerias" type="button" class="btn btn-primary">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button id="btnRemoverControleFerias" type="button" class="btn btn-danger">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </section>
                                                        </div>
                                                        <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                            <table id="tableControleFerias" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                <thead>
                                                                    <tr role="row">
                                                                        <th style="width: 2px"></th>
                                                                        <th class="text-center">Periodo Aquisitivo - Início</th>
                                                                        <th class="text-center">Período Aquisitivo - Fim</th>
                                                                        <th class="text-center">Periodo de Férias - Inicio</th>
                                                                        <th class="text-center">Periodo de Férias - Fim</th>
                                                                        <th class="text-center">Qtde de Dias</th>
                                                                        <th class="text-center">Adiantamento 13º Salário</th>
                                                                        <th class="text-center">Abono</th>




                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                        <div class="row">

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

<script src="<?php echo ASSETS_URL; ?>/js/business_funcionarioControleFerias.js" type="text/javascript"></script>

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

<!-- Validador de CPF -->
<script src="js/plugin/cpfcnpj/jquery.cpfcnpj.js"></script>

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        jsonControleFeriasArray = JSON.parse($("#jsonControleFerias").val());

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



        $('#btnAddControleFerias').on("click", function() {

            var solicitacaoInicioFerias = $("#solicitacaoInicioFerias").val()
            var diasSolicitacao = $("#diasSolicitacao").val()
            var periodoFeriasInicioLista = $("#periodoFeriasInicioLista").val()
            var periodoFeriasFimLista = $("#periodoFeriasFimLista").val()

            if (!solicitacaoInicioFerias) {
                smartAlert("Atenção", "Informe uma Data de Inicio", "error");
                return;
            }
             if (!diasSolicitacao) {
                smartAlert("Atenção", "Informe a quantidade de Dias", "error");
                return;
            }
            if (!periodoFeriasInicioLista) {
                $("#periodoFeriasInicioLista").val("")
            }
            if (!periodoFeriasFimLista) {
                $("#periodoFeriasFimLista").val("")
            }
            if (validaControleFerias()) {
                addControleFerias();
            }
        });

        $("#btnRemoverControleFerias").on("click", function() {

            excluirControleFerias();

        });

        $("#periodoAquisitivoFimLista").on("change", function() {
            verificaValidade();
        });

        $("#funcionario").on("change", function() {
            var id = $("#funcionario").val()
            $("#matricula").val(id);
            $("#projeto").val(id);
            $("#cargo").val(id);
            $("#dataAdmissao").val(id);
        });


        $("#diasSolicitacao").on("change", function() {
            verificaDias();
        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnGravar").on("click", function() {
            gravar()
        });

        $("#btnVoltar").on("click", function() {
            voltar();
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
                recuperaControleFerias(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var $strArrayControleFerias = piece[2];
                            piece = out.split("^");

                            // Atributos de vale transporte unitário que serão recuperados: 
                            var codigo = +piece[0];
                            var funcionario = piece[1];
                            var matricula = piece[2];
                            var cargo = piece[3];
                            var projeto = piece[4];
                            var dataAdmissao = piece[5]
                            var ativo = piece[6]

                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(codigo);
                            $("#matricula").val(matricula);
                            $("#funcionario").val(funcionario);
                            $("#cargo").val(cargo);
                            $("#projeto").val(projeto);
                            $("#dataAdmissao").val(dataAdmissao);
                            $("#ativo").val(ativo);

                            $("#jsonControleFerias").val($strArrayControleFerias);

                            jsonControleFeriasArray = JSON.parse($("#jsonControleFerias").val());
                            fillTableControleFerias();

                            return;
                        }
                    }
                );
            }
        }
    }

    function novo() {
        $(location).attr('href', 'funcionario_controleFerias.php');
    }

    function voltar() {
        $(location).attr('href', 'funcionario_controleFeriasFiltro.php');
    }

    function verificaValidade() {
        let dataInicio = $("#periodoAquisitivoInicioLista").val()
        let dataFim = $("#periodoAquisitivoFimLista").val()
        let validade = 0

        let separador = dataInicio.split('/');
        let d = Number(separador[0]);
        let m = Number(separador[1]);
        let y = Number(separador[2]);

        if (d.toString().length < 2) d = `0${d}`;
        if (m.toString().length < 2) m = `0${m}`;
        if (y.toString().length < 2) y = `0${y}`;

        dataInicio = new Date(y + "-" + m + "-" + d)

        separador = dataFim.split('/');
        d = Number(separador[0]);
        m = Number(separador[1]);
        y = Number(separador[2]);

        if (d.toString().length < 2) d = `0${d}`;
        if (m.toString().length < 2) m = `0${m}`;
        if (y.toString().length < 2) y = `0${y}`;

        dataFim = new Date(y + "-" + m + "-" + d)

        const diff = Math.abs(dataInicio.getTime() - dataFim.getTime()); // Subtrai uma data pela outra
        const dias = Math.ceil(diff / (1000 * 60 * 60 * 24));
        if (dias > 365) {
            validade = dias - 365
        }

        $("#diasVencidos").val(validade)
    }

    function verificaDias() {
        let dataInicio = $("#solicitacaoInicioFerias").val()
        let dias = +$("#diasSolicitacao").val()


        let separador = dataInicio.split('/');
        let d = Number(separador[0]);
        let m = Number(separador[1]);
        let y = Number(separador[2]);

        dataInicio = new Date(y + "-" + m + "-" + d)

        var dataFim = new Date();
        dataFim.setDate(dataInicio.getDate() + dias)


        d = dataFim.getDate();
        m = dataFim.getMonth();
        m++
        y = dataFim.getFullYear();

        if (d.toString().length < 2) d = `0${d}`;
        if (m.toString().length < 2) m = `0${m}`;
        if (y.toString().length < 2) y = `0${y}`;

        dataFim = (d + "/" + m + "/" + y)

        $("#solicitacaoFimFerias").val(dataFim)
    }

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }



        excluirControle(id,
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



    function clearFormControleFerias() {
        $("#controleFeriasId").val('');
        $("#sequencialControleFerias").val('');
        $("#periodoAquisitivoInicio").val('');
        $("#periodoAquisitivoFim").val('');
        $("#periodoFeriasInicio").val('');
        $("#periodoFeriasFim").val('');
        $("#diasSolicitacao").val('');
        $("#adiantamentoDecimo").val('');
        $("#abono").val('');
        $("#status").val('');
        $("#solicitacaoInicioFerias").val('');
        $("#solicitacaoFimFerias").val('');
    }

    function addControleFerias() {
        var item = $("#formControleFerias").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processControleFerias
        });

        if (item["sequencialControleFerias"] === '') {
            if (jsonControleFeriasArray.length === 0) {
                item["sequencialControleFerias"] = 1;
            } else {
                item["sequencialControleFerias"] = Math.max.apply(Math, jsonControleFeriasArray.map(function(o) {
                    return o.sequencialControleFerias;
                })) + 1;
            }
            item["controleFeriasId"] = 0;
        } else {
            item["sequencialControleFerias"] = +item["sequencialControleFerias"];
        }

        item.periodoAquisitivoInicio = $("#periodoAquisitivoInicioLista").val()
        item.periodoAquisitivoFim = $("#periodoAquisitivoFimLista").val()
        item.periodoFeriasInicio = $("#periodoFeriasInicioLista").val()
        item.periodoFeriasFim = $("#periodoFeriasFimLista").val()

        var index = -1;
        $.each(jsonControleFeriasArray, function(i, obj) {
            if (+$('#sequencialControleFerias').val() === obj.sequencialControleFerias) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonControleFeriasArray.splice(index, 1, item);
        else
            jsonControleFeriasArray.push(item);

        $("#jsonControleFerias").val(JSON.stringify(jsonControleFeriasArray));
        fillTableControleFerias();
        clearFormControleFerias();

    }



    function fillTableControleFerias() {
        $("#tableControleFerias tbody").empty();
        if (typeof(jsonControleFeriasArray) != 'undefined') {
            for (var i = 0; i < jsonControleFeriasArray.length; i++) {
                var row = $('<tr />');
                $("#tableControleFerias tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox " value="' + jsonControleFeriasArray[i].sequencialControleFerias + '"><i></i></label></td>'));
                row.append($('<td class="text-center" onclick="carregaControleFerias(' + jsonControleFeriasArray[i].sequencialControleFerias + ');">' + jsonControleFeriasArray[i].periodoAquisitivoInicio + '</td>'));
                row.append($('<td class="text-center" >' + jsonControleFeriasArray[i].periodoAquisitivoFim + '</td>'));
                row.append($('<td class="text-center" >' + jsonControleFeriasArray[i].periodoFeriasInicio + '</td>'));
                row.append($('<td class="text-center" >' + jsonControleFeriasArray[i].periodoFeriasFim + '</td>'));
                row.append($('<td class="text-center" >' + jsonControleFeriasArray[i].diasSolicitacao + '</td>'));
                if ((adiantamentoDecimo == '1') || (jsonControleFeriasArray[i].adiantamentoDecimo == '1')) {
                    row.append($('<td class="text-center" >' + 'Sim' + '</td>'));
                } else {
                    row.append($('<td class="text-center" >' + 'Não' + '</td>'));
                }
                if ((abono == '1') || (jsonControleFeriasArray[i].abono == '1')) {
                    row.append($('<td class="text-center" >' + 'Sim' + '</td>'));
                } else {
                    row.append($('<td class="text-center" >' + 'Não' + '</td>'));
                }

            }
            clearFormControleFerias()
        }
    }

    function processControleFerias(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "periodoAquisitivoInicio")) {
            var periodoAquisitivoInicio = $("#periodoAquisitivoInicio").val();
            if (periodoAquisitivoInicio !== '') {
                fieldName = "periodoAquisitivoInicio";
            }
            return {
                name: fieldName,
                value: $("#periodoAquisitivoInicio").val()
            };
        }

        if (fieldName !== '' && (fieldId === "periodoAquisitivoFim")) {
            var periodoAquisitivoFim = $("#periodoAquisitivoFim").val();
            if (periodoAquisitivoFim !== '') {
                fieldName = "periodoAquisitivoFim";
            }
            return {
                name: fieldName,
                value: $("#periodoAquisitivoFim").val()
            };
        }

        if (fieldName !== '' && (fieldId === "periodoFeriasInicio")) {
            var periodoFeriasInicio = $("#periodoFeriasInicio").val();
            if (periodoFeriasInicio !== '') {
                fieldName = "periodoFeriasInicio";
            }
            return {
                name: fieldName,
                value: $("#periodoFeriasInicio").val()
            };
        }

        if (fieldName !== '' && (fieldId === "periodoFeriasFim")) {
            var periodoFeriasFim = $("#periodoFeriasFim").val();
            if (periodoFeriasFim !== '') {
                fieldName = "periodoFeriasFim";
            }
            return {
                name: fieldName,
                value: $("#periodoFeriasFim").val()
            };
        }

        if (fieldName !== '' && (fieldId === "diasSolicitacao")) {
            var diasSolicitacao = $("#diasSolicitacao").val();
            if (diasSolicitacao !== '') {
                fieldName = "diasSolicitacao";
            }
            return {
                name: fieldName,
                value: $("#diasSolicitacao").val()
            };
        }

        if (fieldName !== '' && (fieldId === "adiantamentoDecimo")) {
            var adiantamentoDecimo = $("#adiantamentoDecimo").val();
            if (adiantamentoDecimo !== '') {
                fieldName = "adiantamentoDecimo";
            }
            return {
                name: fieldName,
                value: $("#adiantamentoDecimo").val()
            };
        }
        if (fieldName !== '' && (fieldId === "abono")) {
            var abono = $("#abono").val();
            if (abono !== '') {
                fieldName = "abono";
            }
            return {
                name: fieldName,
                value: $("#abono").val()
            };
        }
        if (fieldName !== '' && (fieldId === "status")) {
            var status = $("#status").val();
            if (status !== '') {
                fieldName = "status";
            }
            return {
                name: fieldName,
                value: $("#status").val()
            };
        }
        if (fieldName !== '' && (fieldId === "solicitacaoInicioFerias")) {
            var solicitacaoInicioFerias = $("#solicitacaoInicioFerias").val();
            if (solicitacaoInicioFerias !== '') {
                fieldName = "solicitacaoInicioFerias";
            }
            return {
                name: fieldName,
                value: $("#solicitacaoInicioFerias").val()
            };
        }
        if (fieldName !== '' && (fieldId === "solicitacaoFimFerias")) {
            var solicitacaoFimFerias = $("#solicitacaoFimFerias").val();
            if (solicitacaoFimFerias !== '') {
                fieldName = "solicitacaoFimFerias";
            }
            return {
                name: fieldName,
                value: $("#solicitacaoFimFerias").val()
            };
        }
        return false;
    }

    function carregaControleFerias(sequencialControleFerias) {
        var arr = jQuery.grep(jsonControleFeriasArray, function(item, i) {
            return (item.sequencialControleFerias === sequencialControleFerias);
        });

        clearFormControleFerias();

        if (arr.length > 0) {
            var item = arr[0];
            $("#controleFeriasId").val(item.controleFeriasId);
            $("#sequencialControleFerias").val(item.sequencialControleFerias);
            $("#periodoAquisitivoInicioLista").val(item.periodoAquisitivoInicio);
            $("#periodoAquisitivoFimLista").val(item.periodoAquisitivoFim);
            $("#periodoFeriasInicioLista").val(item.periodoFeriasInicio);
            $("#periodoFeriasFimLista").val(item.periodoFeriasFim);
            $("#diasSolicitacao").val(item.diasSolicitacao);
            $("#adiantamentoDecimo").val(item.adiantamentoDecimo);
            $("#abono").val(item.abono);
            $("#status").val(item.status);
            $("#solicitacaoInicioFerias").val(item.solicitacaoInicioFerias);
            $("#solicitacaoFimFerias").val(item.solicitacaoFimFerias);
        }
    }

    function excluirControleFerias() {
        var arrSequencial = [];
        $('#tableControleFerias input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonControleFeriasArray.length - 1; i >= 0; i--) {
                var obj = jsonControleFeriasArray[i];
                if (jQuery.inArray(obj.sequencialControleFerias, arrSequencial) > -1) {
                    jsonControleFeriasArray.splice(i, 1);
                }
            }
            $("#jsonControleFerias").val(JSON.stringify(jsonControleFeriasArray));
            fillTableControleFerias();
        } else {
            smartAlert("Erro", "Selecione pelo menos 1 data para excluir.", "error");
        }
    }

    function validaControleFerias() {
        var existeControleFerias = false;
        var achou = false;
        var sequencial = +$('#sequencialControleFerias').val();
        var ControleFerias = $('#jsonControleFerias').val();
        for (i = jsonControleFeriasArray.length - 1; i >= 0; i--) {
            if ((jsonControleFeriasArray[i].ControleFerias === ControleFerias) && (jsonControleFeriasArray[i].sequencialControleFerias !== sequencial)) {
                existeControleFerias = true;
                break;
            }

        }
        if (existeControleFerias === true) {
            smartAlert("Erro", "Esta Data ja existe!", "error");
            return false;
        }
        return true;
    }

    function gravar() {
        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        var id = +$('#codigo').val();
        var funcionario = $('#funcionario').val();
        var matricula = $('#matricula').val();
        var cargo = $('#cargo').val();
        var projeto = $('#projeto').val();
        var dataAdmissao = $('#dataAdmissao').val();
        var ativo = $('#ativo').val();
        var jsonControleFeriasArray = JSON.parse($("#jsonControleFerias").val());
        var periodoAquisitivo = $('#periodoAquisitivoInicioLista').val()

        if (!funcionario) {
            smartAlert("Atenção", "Informe um Funcionário", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }

        if (!periodoAquisitivo) {
            smartAlert("Atenção", "Preencha uma solicitação para Gravar", "error");
            $("#btnGravar").prop('disabled', false);
            return;
        }



        //Chama a função de gravar do business de convênio de saúde.
        gravaControleFerias(id, funcionario, matricula, cargo, projeto, dataAdmissao, ativo, jsonControleFeriasArray,
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
                    var verificaRecuperacao = +$("#verificaRecuperacao").val();
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    voltar();
                }
            }
        );
    }
</script>