<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

// $condicaoAcessarOK = (in_array('CONTROLEFERIAS_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('CONTROLEFERIAS_GRAVAR', $arrayPermissao, true));
// $condicaoExcluirOK = (in_array('CONTROLEFERIAS_EXCLUIR', $arrayPermissao, true));
// $condicaoGestorOK = (in_array('CONTROLEFERIAS_GESTOR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }

// $esconderBtnExcluir = "";
// if ($condicaoExcluirOK === false) {
//     $esconderBtnExcluir = "none";
// }
// $esconderBtnGravar = "";
// if ($condicaoGravarOK === false) {
//     $esconderBtnGravar = "none";
// }
// $esconderGestor = "";
// $funcionario = "";
// if ($condicaoGestorOK === false) {
//     $esconderGestor = "none";
//     $funcionario = "readonly";
// }



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
$page_nav['estoque']['sub']['cadastro']['sub']['controleFerias']["active"] = true;

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

                                                            <section class="col col-4">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario" <?php echo $funcionario ?> class="required <?php echo $funcionario ?>">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        if (!$id) {
                                                                            echo '<option></option>';
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigoFuncionario = (int) $row['codigo'];
                                                                                $nome = $row['nome'];

                                                                                echo '<option value=' . $codigoFuncionario . '>' . $nome . '</option>';
                                                                            }
                                                                        }
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, nome  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL AND codigo =" . $id;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $nome = $row['nome'];
                                                                            echo '<option value=' . $codigoFuncionario . '>' . $nome . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1 col-auto">
                                                                <label class="label" for="matricula">Matrícula</label>
                                                                <label class="select">

                                                                    <select id="matricula" name="matricula" class="readonly">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        if (!$id) {
                                                                            echo '<option></option>';
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, nome, matricula  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigoFuncionario = (int) $row['codigo'];
                                                                                $matricula = $row['matricula'];

                                                                                echo '<option value=' . $matricula . '>' . $matricula . '</option>';
                                                                            }
                                                                        }
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, matricula  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL AND codigo =" . $id;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $matricula = $row['matricula'];
                                                                            echo '<option value=' . $matricula . '>' . $matricula . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="cargo">Cargo</label>
                                                                <label class="select">
                                                                    <select id="cargo" name="cargo" class="readonly">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        if (!$id) {
                                                                            echo '<option></option>';
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT F.codigo, F.cargo, C.descricao as cargoDescricao  from Ntl.funcionario F
                                                                            inner join Ntl.cargo C ON C.codigo = F.cargo
                                                                            where F.ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigoFuncionario = (int) $row['codigo'];
                                                                                $cargoId = $row['cargo'];
                                                                                $cargo = $row['descricao'];

                                                                                echo '<option value=' . $cargoId . '>' . $cargo . '</option>';
                                                                            }
                                                                        }
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT F.codigo, F.cargo, C.descricao as cargoDescricao  from Ntl.funcionario F
                                                                        inner join Ntl.cargo C ON C.codigo = F.cargo
                                                                        where F.ativo = 1 AND dataDemissaoFuncionario IS NULL AND F.codigo =" . $id;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigoFuncionario = (int) $row['codigo'];
                                                                            $cargoId = $row['cargo'];
                                                                            $cargo = $row['cargoDescricao'];
                                                                            echo '<option value=' . $cargoId . '>' . $cargo . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3 col-auto">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="readonly">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        if (!$id) {
                                                                            echo '<option></option>';
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT BP.codigo, BP.funcionario, BP.projeto, P.descricao as projetoDescricao from Ntl.beneficioProjeto BP
                                                                                    inner join Ntl.projeto P ON P.codigo = BP.projeto";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigoFuncionario = (int) $row['codigo'];
                                                                                $codigo = (int) $row['projeto'];
                                                                                $projeto = $row['projetoDescricao'];

                                                                                echo '<option value=' . $codigo . '>' . $projeto . '</option>';
                                                                            }
                                                                        }
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT BP.codigo, BP.funcionario, BP.projeto, P.descricao as projetoDescricao from Ntl.beneficioProjeto BP
                                                                        inner join Ntl.projeto P ON P.codigo = BP.projeto
                                                                                where BP.ativo = 1  AND BP.funcionario = " . $id;
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = (int) $row['projeto'];
                                                                            $projeto = $row['projetoDescricao'];

                                                                            echo '<option value=' . $codigo . '>' . $projeto . '</option>';
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
                                                                    <select id="dataAdmissaoFuncionario" name="dataAdmissaoFuncionario" class="readonly" style="text-align: center;">

                                                                        <?php

                                                                        session_start();
                                                                        $id = $_SESSION['funcionario'];
                                                                        if (!$id) {
                                                                            echo '<option></option>';
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, nome, dataAdmissaoFuncionario  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
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
                                                                        }
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, dataAdmissaoFuncionario  from Ntl.funcionario where ativo = 1 AND dataDemissaoFuncionario IS NULL AND codigo =" . $id;
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

                                                                            echo '<option value=' . $dataAdmissaoFuncionario . '>' . $dataAdmissaoFuncionario . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="periodoAquisitivoInicioLista">Período Aquisitivo</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoAquisitivoInicioLista" name="periodoAquisitivoInicioLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="periodoAquisitivoFimLista" name="periodoAquisitivoFimLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>



                                                            <section class="col col-1">
                                                                <label class="label" for="diasVencidos">Dias Vencidos</label>
                                                                <label class="input">
                                                                    <input type="number" id="diasVencidos" name="diasVencidos" autocomplete="off">
                                                                </label>
                                                            </section>



                                                            <section class="col col-2">
                                                                <label class="label" for="gozoFeriasInicioLista">Gozo de Férias</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="gozoFeriasInicioLista" name="gozoFeriasInicioLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input id="gozoFeriasFimLista" name="gozoFeriasFimLista" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
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
                                                                        <label class="label" for="dataInicioFerias">Data de Início</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="dataInicioFerias" name="dataInicioFerias" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-1">
                                                                        <label class="label" for="diasSolicitacao">Qtde. de dias</label>
                                                                        <label class="input">
                                                                            <input type="number" id="diasSolicitacao" name="diasSolicitacao" autocomplete="off">
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="label" for="dataFimFerias">Data Fim</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="dataFimFerias" name="dataFimFerias" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>


                                                                    <section class="col col-1">
                                                                        <label class="label" for="adiantamentoDecimo">Adiantamento 13º</label>
                                                                        <label class="select">
                                                                            <select name="adiantamentoDecimo" id="adiantamentoDecimo">
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
                                                                            <select name="abono" id="abono">
                                                                                <option value="1">Sim</option>
                                                                                <option value="0">Não</option>
                                                                            </select><i></i>
                                                                        </label>
                                                                    </section>



                                                                    <section class="col col-1">
                                                                        <label class="label" for="status">Status</label>
                                                                        <label class="select">
                                                                            <select id="status" name="status" class="required">
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
                                                                            </select><i></i>
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
                                                                        <label class="label" for="gozoFeriasInicio"></label>
                                                                        <label class="input">
                                                                            <input id="gozoFeriasInicio" name="gozoFeriasInicio" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required hidden" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-2">
                                                                        <label class="label" for="gozoFeriasFim"></label>
                                                                        <label class="input">
                                                                            <input id="gozoFeriasFim" name="gozoFeriasFim" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker required hidden" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" autocomplete="off">
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
                                                                <button id="btnRemoverControleFerias" type="button" class="btn btn-danger" style="display:<?php echo $esconderGestor ?>">
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
                                                                        <th class="text-center">Gozo de Férias - Inicio</th>
                                                                        <th class="text-center">Gozo de Férias - Fim</th>
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
        // $("#funcionario").on("change", function() {
        //     recuperarDadosFuncionario();
        // });

        // $("#dataProximoCONTROLEFERIAS").on("change", function() {
        //     recuperarValidadeCONTROLEFERIAS();
        // })

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
            if (validaControleFerias()) {
                addControleFerias();
            }
        });

        $("#btnRemoverControleFerias").on("click", function() {

            excluirControleFerias();

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

    function excluir() {
        var id = $("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirControleFerias(id,
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
        $("#periodoAquisitivoInicio").val('');
        $("#periodoAquisitivoFim").val('');
        $("#gozoFeriasInicio").val('');
        $("#gozoFeriasFim").val('');
        $("#diasSolicitacao").val('');
        $("#adiantamentoDecimo").val('');
        $("#abono").val('');
        $("#status").val('');
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
        item.gozoFeriasInicio = $("#gozoFeriasInicioLista").val()
        item.gozoFeriasFim = $("#gozoFeriasFimLista").val()

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
        for (var i = 0; i < jsonControleFeriasArray.length; i++) {
            var row = $('<tr />');
            $("#tableControleFerias tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox " value="' + jsonControleFeriasArray[i].sequencialControleFerias + '"><i></i></label></td>'));
            row.append($('<td class="text-center" onclick="carregaControleFerias(' + jsonControleFeriasArray[i].sequencialControleFerias + ');">' + jsonControleFeriasArray[i].periodoAquisitivoInicio + '</td>'));
            row.append($('<td class="text-center" >' + jsonControleFeriasArray[i].periodoAquisitivoFim + '</td>'));
            row.append($('<td class="text-center" >' + jsonControleFeriasArray[i].gozoFeriasInicio + '</td>'));
            row.append($('<td class="text-center" >' + jsonControleFeriasArray[i].gozoFeriasFim + '</td>'));
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

        if (fieldName !== '' && (fieldId === "gozoFeriasInicio")) {
            var gozoFeriasInicio = $("#gozoFeriasInicio").val();
            if (gozoFeriasInicio !== '') {
                fieldName = "gozoFeriasInicio";
            }
            return {
                name: fieldName,
                value: $("#gozoFeriasInicio").val()
            };
        }

        if (fieldName !== '' && (fieldId === "gozoFeriasFim")) {
            var gozoFeriasFim = $("#gozoFeriasFim").val();
            if (gozoFeriasFim !== '') {
                fieldName = "gozoFeriasFim";
            }
            return {
                name: fieldName,
                value: $("#gozoFeriasFim").val()
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
        return false;
    }

    function carregaControleFerias(sequencialControleFerias) {
        var arr = jQuery.grep(jsonControleFeriasArray, function(item, i) {
            return (item.sequencialControleFerias === sequencialControleFerias);
        });

        clearFormControleFerias();

        if (arr.length > 0) {
            var item = arr[0];
            $("#sequencialControleFerias").val(item.sequencialControleFerias);
            $("#periodoAquisitivoInicioLista").val(item.periodoAquisitivoInicio);
            $("#periodoAquisitivoFimLista").val(item.periodoAquisitivoFim);
            $("#gozoFeriasInicioLista").val(item.gozoFeriasInicio);
            $("#gozoFeriasFimLista").val(item.gozoFeriasFim);
            $("#diasSolicitacao").val(item.diasSolicitacao);
            $("#adiantamentoDecimo").val(item.adiantamentoDecimo);
            $("#abono").val(item.abono);
            $("#status").val(item.status);

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
        } else
            smartAlert("Erro", "Selecione pelo menos 1 data para excluir.", "error");
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
        // $("#btnGravar").prop('disabled', true);
        // Variáveis que vão ser gravadas no banco:
        var id = +$('#codigo').val();
        var funcionario = $('#funcionario').val();
        var matricula = $('#matricula').val();
        var cargo = $('#cargo').val();
        var projeto = $('#projeto').val();
        var dataAdmissao = $('#dataAdmissaoFuncionario').val();
        var ativo = $('#ativo').val();
        var jsonControleFeriasArray = JSON.parse($("#jsonControleFerias").val());

        // if (dataAgendamento) {
        //     smartAlert("Atenção", "Informe se o item precisa de assinatura", "error");
        //     $("#btnGravar").prop('disabled', false);
        //     return;
        // }



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
                    novo();
                }
            }
        );
    }
</script>