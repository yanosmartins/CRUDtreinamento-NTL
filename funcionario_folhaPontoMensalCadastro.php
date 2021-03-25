<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");

$condicaoLeveAcessarOK = (in_array('PONTOELETRONICOMENSALLEVE_ACESSAR', $arrayPermissao, true));
$condicaoLeveGravarOK = (in_array('PONTOELETRONICOMENSALLEVE_GRAVAR', $arrayPermissao, true));
$condicaoLeveExcluirOK = (in_array('PONTOELETRONICOMENSALLEVE_EXCLUIR', $arrayPermissao, true));

$condicaoNormalAcessarOK = (in_array('PONTOELETRONICOMENSALNORMAL_ACESSAR', $arrayPermissao, true));
$condicaoNormalGravarOK = (in_array('PONTOELETRONICOMENSALNORMAL_GRAVAR', $arrayPermissao, true));
$condicaoNormalExcluirOK = (in_array('PONTOELETRONICOMENSALNORMAL_EXCLUIR', $arrayPermissao, true));

$condicaoPesadaAcessarOK = (in_array('PONTOELETRONICOMENSALPESADA_ACESSAR', $arrayPermissao, true));
$condicaoPesadaGravarOK = (in_array('PONTOELETRONICOMENSALPESADA_GRAVAR', $arrayPermissao, true));
$condicaoPesadaExcluirOK = (in_array('PONTOELETRONICOMENSALPESADA_EXCLUIR', $arrayPermissao, true));

$esconderCampo = "";
if ($condicaoPesadaGravarOK) {
    $esconderCampoPesado = ['display' => 'none', 'disabled' => 'disabled', 'readonly' => 'readonly', 'pointer-events' => 'none', 'touch-action' => 'none'];
}
    if ($condicaoNormalGravarOK) {
        $esconderCampoNormal = ['display' => 'none', 'disabled' => 'disabled', 'readonly' => 'readonly', 'pointer-events' => 'none', 'touch-action' => 'none'];
    }
if ($condicaoLeveGravarOK) {
    $esconderCampoPesado = ['display' => '', 'disabled' => '', 'readonly' => '', 'pointer-events' => 'auto', 'touch-action' => 'auto'];
    $esconderCampoNormal = ['display' => '', 'disabled' => '', 'readonly' => '', 'pointer-events' => 'auto', 'touch-action' => 'auto'];
}

if (($condicaoLeveAcessarOK == false) && ($condicaoNormalAcessarOK == false) && ($condicaoPesadaAcessarOK == false)) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnExcluir = "";
if (($condicaoLeveExcluirOK == false) && ($condicaoNormalExcluirOK == false) && ($condicaoPesadaExcluirOK == false)) {
    $esconderBtnExcluir = "none";
}

$esconderBtnGravar = "";
if (($condicaoNormalGravarOK == true) || ($condicaoPesadaGravarOK == true)) {
    $esconderBtnGravar = "none";
}

if ($condicaoLeveGravarOK == false) {
    $esconderBtnGravar = "none";
}



/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Controle de Ponto";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['operacao']['sub']['funcionario']['sub']["controlePonto"]["active"] = true;
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
                            <h2>Controle de Ponto
                            </h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formFolhaPontoMensalCadastro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFolhaPontoMensal" class="collapsed" id="accordionFolhaPontoMensal">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Ponto Mensal
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFolhaPontoMensal" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>


                                                        <div id="formFolhaPontoMensal" class="col-sm-12">
                                                            <input id="codigo" name="codigo" type="hidden" value="0">

                                                            <div class="form-group">

                                                                <div class="row">

                                                                    <section class="col col-4">
                                                                        <label class="label " for="funcionario">Funcionário</label>
                                                                        <label class="select">
                                                                            <select id="funcionario" name="funcionario" class="readonly" readonly style="touch-action:<?php if($esconderCampoPesado){echo $esconderCampoPesado['touch-action'];}else if($esconderCampoNormal){echo $esconderCampoNormal['touch-action'];} ?>;pointer-events:<?php if($esconderCampoPesado){echo $esconderCampoPesado['pointer-events'];}else if($esconderCampoNormal){echo $esconderCampoNormal['pointer-events'];} ?>">
                                                                                <option></option>
                                                                                <?php
                                                                                $reposit = new reposit();
                                                                                $sql = "select F.codigo, F.nome from Ntl.funcionario F where F.dataDemissaoFuncionario IS NULL AND F.ativo = 1 AND F.codigo != " . $_SESSION['funcionario'] . " order by nome";
                                                                                $result = $reposit->RunQuery($sql);
                                                                                foreach ($result as $row) {
                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $nome = $row['nome'];
                                                                                    echo '<option value= ' . $codigo . '>' . $nome . '</option>';
                                                                                }
                                                                                $sql = "select F.codigo, F.nome from Ntl.funcionario F where F.dataDemissaoFuncionario IS NULL AND F.ativo = 1 AND F.codigo = " . $_SESSION['funcionario'];

                                                                                $result = $reposit->RunQuery($sql);
                                                                                if ($row = $result[0]) {

                                                                                    $codigo = (int) $row['codigo'];
                                                                                    $nome = $row['nome'];
                                                                                    echo '<option value= ' . $codigo . ' selected>' . $nome . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>

                                                                        </label>
                                                                    </section>


                                                                    <?php
                                                                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                                    date_default_timezone_set('America/Sao_Paulo');
                                                                    $dataAtual = strftime('%m/%Y', strtotime('today'));
                                                                    ?>
                                                                    <section class="col col-2">
                                                                        <label class="label" for="mesAno">Mês/Ano</label>
                                                                        <label class="input">
                                                                            <i class="icon-append fa fa-calendar"></i>
                                                                            <input id="mesAno" name="mesAno" style="text-align: center;" autocomplete="off" type="text" class="readonly" readonly value="<?= $dataAtual  ?>">
                                                                        </label>
                                                                    </section>
                                                                    <section class="col col-md-1">
                                                                        <label class="label">&nbsp;</label>
                                                                        <label id="labelCheckAlmoco" class="checkbox hidden">
                                                                            <input id="checkAlmoco" name="checkAlmoco" type="checkbox" value="true">
                                                                            Habilitar Almoço
                                                                        </label>
                                                                    </section>

                                                                    <section class="col col-2">
                                                                        <label class="select">
                                                                            <select id="ativo" name="ativo" class="hidden" required>
                                                                                <option value='1' selected>Sim</option>
                                                                            </select>
                                                                        </label>
                                                                    </section>
                                                                </div>

                                                                <div class="row">
                                                                    <section class="col col-12">
                                                                        <legend><strong></strong></legend>
                                                                    </section>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label" for="expediente">Expediente</label>
                                                                    <label class="select">
                                                                        <select id="expediente" name="expediente" class="readonly" readonly style="pointer-events: none; touch-action: none">
                                                                            <option></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, funcionario,horaEntrada,horaSaida from Ntl.beneficioProjeto where ativo = 1 order by codigo";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $horaEntrada = $row['horaEntrada'];
                                                                                $horaSaida = $row['horaSaida'];
                                                                                $funcionario = $row['funcionario'];
                                                                                if ($funcionario == $_SESSION['funcionario']) {
                                                                                    echo '<option data-funcionario="' . $funcionario . '" value="' . $codigo . '" selected>' . $horaEntrada . " - " . $horaSaida . '</option>';
                                                                                } else {
                                                                                    echo '<option data-funcionario="' . $funcionario . '" value="' . $codigo . '">' . $horaEntrada . " - " . $horaSaida . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="almoco">Almoço</label>
                                                                    <label class="select">
                                                                        <select id="almoco" name="almoco" class="readonly" readonly style="pointer-events: none; touch-action: none">
                                                                            <option></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, funcionario,horaInicio,horaFim from Ntl.beneficioProjeto where ativo = 1 order by codigo";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $horaInicio = $row['horaInicio'];
                                                                                $horaFim = $row['horaFim'];
                                                                                $funcionario = $row['funcionario'];
                                                                                if ($funcionario == $_SESSION['funcionario']) {
                                                                                    echo '<option data-funcionario="' . $funcionario . '" value="' . $codigo . '" selected>' . $horaInicio . " - " . $horaFim . '</option>';
                                                                                } else {
                                                                                    echo '<option data-funcionario="' . $funcionario . '" value="' . $codigo . '">' . $horaInicio . " - " . $horaFim . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                </section>
                                                            </div>

                                                            <div class="row">

                                                                <section class="col col-1">
                                                                    <div class="form-group">
                                                                        <label class="label">Dia</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputDia" name="inputDia" type="text" class="text-center form-control required <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];}?>" required data-autoclose="true" <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Entrada</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputHoraEntrada" name="inputHoraEntrada" type="text" class="text-center form-control <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>" placeholder="  00:00:00" data-autoclose="true" data-mask="99:99:99" <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1 sectionAlmoco" style="display: block">
                                                                    <div class="form-group">
                                                                        <label class="label">Inicio/Almoço</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputInicioAlmoco" name="inputInicioAlmoco" type="text" class="text-center form-control <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>" placeholder="00:00" data-autoclose="true" data-mask="99:99" <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1 sectionAlmoco" style="display: block">
                                                                    <div class="form-group">
                                                                        <label class="label">Fim/Almoço</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputFimAlmoco" name="inputFimAlmoco" type="text" class="text-center form-control <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>" placeholder="00:00" data-autoclose="true" data-mask="99:99" <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Saída</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputHoraSaida" name="inputHoraSaida" type="text" class="text-center form-control <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>" placeholder="  00:00:00" data-autoclose="true" data-mask="99:99:99" <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">H.Extra</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputHoraExtra" name="inputHoraExtra" type="text" class="text-center form-control <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>" placeholder="00:00" data-autoclose="true" data-mask="99:99" <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-1">
                                                                    <div class="form-group">
                                                                        <label id="labelHora" class="label">Atraso</label>
                                                                        <div class="input-group" data-align="top" data-autoclose="true">
                                                                            <input id="inputAtraso" name="inputAtraso" type="text" class="text-center form-control <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>" placeholder="00:00" data-autoclose="true" data-mask="99:99" <?php if($esconderCampoPesado){echo $esconderCampoPesado['readonly'];} ?>>
                                                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="lancamento">Lançamento/Ocorrência</label>
                                                                    <label class="select">
                                                                        <select id="inputLancamento" name="inputLancamento" style="touch-action:<?php if($esconderCampoPesado){echo $esconderCampoPesado['touch-action'];} ?>;pointer-events:<?php if($esconderCampoPesado){echo $esconderCampoPesado['pointer-events'];} ?>">
                                                                            <option selected value="0"></option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "select codigo, descricao from Ntl.lancamento where ativo = 1 order by descricao";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = (int) $row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>


                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-md-2">
                                                                    <label class="label"> </label>
                                                                    <button id="btnAddPonto" type="button" class="btn btn-primary">
                                                                        <i class="">Adicionar Ponto</i>
                                                                    </button>
                                                                </section>
                                                                <section class="col col-8">
                                                                    <label class="label"> </label>
                                                                    </button>
                                                                </section>
                                                                <section class="col col-md-1">
                                                                    <label class=" label"> </label>
                                                                    <button id="btnGravar" type="button" class="btn btn-success">
                                                                        <i class="">Salvar alterações</i>
                                                                    </button>
                                                                </section>

                                                            </div>

                                                            <hr><br><br>

                                                            <?php
                                                            $i = 0;
                                                            $days = date("t");
                                                            while ($i  < $days) {
                                                                $i = $i + 1;
                                                                echo "<div class=\"row\">

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Dia</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"dia-$i\" name=\"dia\" type=\"text\" class=\"text-center form-control readonly\" readonly data-autoclose=\"true\" value=\"" . $i . "\">
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Entrada</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaEntrada-$i\" name=\"horaEntrada\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1 sectionAlmoco\" style=\" display:block\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Inicio/Almoço</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"inicioAlmoco-$i\" name=\"inicioAlmoco\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1 sectionAlmoco\" style=\"display:block\">
                                                                        <div class=\"form-group\">
                                                                            <label class=\"label\">Fim/Almoço</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"fimAlmoco-$i\" name=\"fimAlmoco\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Saída</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaSaida-$i\" name=\"horaSaida\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"00:00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">H.Extra</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"horaExtra-$i\" name=\"horaExtra\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-1\">
                                                                        <div class=\"form-group\">
                                                                            <label id=\"labelHora\" class=\"label\">Atraso</label>
                                                                            <div class=\"input-group\" data-align=\"top\" data-autoclose=\"true\">
                                                                                <input id=\"atraso-$i\" name=\"atraso\" type=\"text\" class=\"text-center form-control readonly\" readonly desabled placeholder=\"  00:00\" data-autoclose=\"true\" value=\"\">
                                                                                <span class=\"input-group-addon\"><i class=\"fa fa-clock-o\"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </section>

                                                                    <section class=\"col col-2\">
                                                                        <label class=\"label\" for=\"lancamento\">Lançamento/Ocorrência</label>
                                                                        <label class=\"select\">
                                                                            <select id=\"lancamento-$i\" name=\"lancamento\" class=\" readonly\" readonly style= \"pointer-events: none; touch-action: none\" tabindex=\"-1\">
                                                                                <option value=\"0\" selected></option>";

                                                                $reposit = new reposit();
                                                                $sql = "select codigo, sigla, descricao from Ntl.lancamento where ativo = 1 order by descricao";
                                                                $result = $reposit->RunQuery($sql);
                                                                foreach ($result as $row) {
                                                                    $codigo = (int) $row['codigo'];
                                                                    $descricao = $row['descricao'];
                                                                    echo "<option value='$codigo'>$descricao</option>";
                                                                }
                                                                echo " </select>
                                                                        </label>
                                                                    </section>
                                                                </div>
                                                                ";
                                                            }
                                                            ?>

                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <label class="label">Observações</label>
                                                                    <textarea maxlength="500" id="observacaoFolhaPontoMensal" name="observacaoFolhaPontoMensal" class="form-control" rows="3" value="" style="resize:vertical"></textarea>
                                                                </section>
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

                                            <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                                <span class="fa fa-file-o"></span>
                                            </button>

                                            <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                                <span class="fa fa-backward"></span>
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
<script src="<?php echo ASSETS_URL; ?>/js/business_beneficioFolhaPontoMensal.js" type="text/javascript"></script>
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/momentjs-business.js"></script>

<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->

<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>

<script src="js/plugin/clockpicker/clockpicker.min.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {

        $("#funcionario").on("change", function() {
            var funcionario = $("#funcionario").val();
            var codigo = $("#expediente option[data-funcionario ='" + funcionario + "']").val();
            $("#expediente").val(codigo);
            selecionaFolha();
        });

        $('#inputDia').on('keydown', () => {
            const dia = $("#inputDia").val();
            const mask = /\D/.test(dia);
            if (mask) {   
                return $("#inputDia").val('');
            }
            return $("#inputDia").val(dia.slice(0,1));
        });

        $('#inputDia').on('change', function() {
            var dia = $("#inputDia").val();

            var entrada = $("#horaEntrada-" + dia).val()
            var inputEntrada = $("#inputHoraEntrada")

            var inicioAlmoco = $("#inicioAlmoco-" + dia).val()
            var inputInicioAlmoco = $("#inputInicioAlmoco")

            var fimAlmoco = $("#fimAlmoco-" + dia).val()
            var inputFimAlmoco = $("#inputFimAlmoco")

            var saida = $("#horaSaida-" + dia).val()
            var inputSaida = $("#inputHoraSaida")

            var extra = $("#horaExtra-" + dia).val()
            var inputExtra = $("#inputHoraExtra")

            var atraso = $("#atraso-" + dia).val()
            var inputAtraso = $("#inputAtraso")

            var lancamento = $("#lancamento-" + dia).val()
            var inputLancamento = $("#inputLancamento")

            inputEntrada.val(entrada)
            inputInicioAlmoco.val(inicioAlmoco)
            inputFimAlmoco.val(fimAlmoco)
            inputSaida.val(saida)
            inputExtra.val(extra)
            inputAtraso.val(atraso)
            inputLancamento.val(lancamento)

        });

        $("#btnAddPonto").on("click", function() {

            var dia = $("#inputDia").val()

            if (!dia) {
                smartAlert('Atenção', 'Insira um dia para a inserção das horas', 'error')
                return
            }

            var entrada = $("#horaEntrada-" + dia)
            var inputEntrada = $("#inputHoraEntrada").val()

            var inicioAlmoco = $("#inicioAlmoco-" + dia)
            var inputInicioAlmoco = $("#inputInicioAlmoco").val()

            var fimAlmoco = $("#fimAlmoco-" + dia)
            var inputFimAlmoco = $("#inputFimAlmoco").val()

            var saida = $("#horaSaida-" + dia)
            var inputSaida = $("#inputHoraSaida").val()
            if(!inputSaida) inputSaida = '00:00:00';

            var extra = $("#horaExtra-" + dia)
            var inputExtra = $("#inputHoraExtra").val()

            var atraso = $("#atraso-" + dia)
            var inputAtraso = $("#inputAtraso").val()

            var lancamento = $("#lancamento-" + dia)
            var inputLancamento = $("#inputLancamento").val()



            // if ((!inputEntrada || inputEntrada == "00:00:00") && !inputLancamento) {
            //     smartAlert("Atenção", "A HORA DE ENTRADA deve ser preenchida", "error");
            //     return
            // }

            // if (inputSaida == "00:00:00" && (inputExtra != "00:00:00")) {
            //     smartAlert("Atenção", "Preencha a HORA DE SAÍDA para preencher a HORA EXTRA", "error");
            //     return
            // }

            let separador = $("#expediente option:selected").text();
            if (!separador) {
                separador = '00:00 - 00:00';
            }
            separador = separador.split("-");
            separador[0] = separador[0].trim();
            separador[1] = separador[1].trim();

            if (separador[0].toString().length <= 5) separador[0] = separador[0].concat(':00');
            if (separador[1].toString().length <= 5) separador[1] = separador[1].concat(':00');

            const inicioExpediente = separador[0];
            const fimExpediente = separador[1];

            const horaEntrada = aleatorizarTempo(inputEntrada, inicioExpediente);
            const horaSaida = aleatorizarTempo(inputSaida, fimExpediente);

            console.table({
                'Hora entrada': horaEntrada,
                'Hora saída': horaSaida
            })
            console.log('')
            console.table({
                'Hora expediente: Inicio': inicioExpediente,
                'Hora expediente: Fim': fimExpediente
            })

            // if (!horaExtra) {
            //     smartAlert("Atenção", "Não foi possível calcular as horas extras trabalhadas", "error");
            //     return
            // }
            // if (!horaAtraso) {
            //     smartAlert("Atenção", "Não foi possível calcular as horas de atraso", "error");
            //     return
            // }

            entrada.val(horaEntrada);
            inicioAlmoco.val(inputInicioAlmoco);
            fimAlmoco.val(inputFimAlmoco);
            extra.val(inputExtra);
            atraso.val(inputAtraso);
            saida.val(horaSaida);
            lancamento.val(inputLancamento);

            return;
        });

        $('#btnNovo').on("click", function() {
            novo()
        });
        $("#btnGravar").on("click", function() {
            gravar();
        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#btnExcluir").on("click", function() {
            excluir();
        });
        $("#checkAlmoco").on("click", function() {
            var check = $(".sectionAlmoco")
            check.each((index, el) => {
                console.log(typeof el)
                console.log($(el))

                if ($(el).css('display') != 'block') {

                    $(el).css('display', 'block')
                } else {
                    $(el).css('display', 'none')
                }
            })
        });

        carregaFolhaPontoMensal();

    });

    function voltar() {
        $(location).attr('href', 'funcionario_folhaPontoMensalFiltro.php');

    }

    function novo() {
        $(location).attr('href', 'funcionario_folhaPontoMensalCadastro.php');

    }

    function gravar() {

        //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
        $("#btnGravar").prop('disabled', true);

        var arrayFolha = $("input[name='dia']").serializeArray()

        var arrayDia = arrayFolha.map(folha => {
            return {
                dia: Number(folha.value)
            }
        })

        arrayFolha = $("input[name='horaEntrada']").serializeArray()
        var arrayHoraEntrada = arrayFolha.map(folha => {
            return {
                horaEntrada: String(folha.value)
            }
        })

        arrayFolha = $("input[name='inicioAlmoco']").serializeArray()
        var arrayInicioAlmoco = arrayFolha.map(folha => {
            return {
                inicioAlmoco: String(folha.value)
            }
        })

        arrayFolha = $("input[name='fimAlmoco']").serializeArray()
        var arrayFimAlmoco = arrayFolha.map(folha => {
            return {
                fimAlmoco: String(folha.value)
            }
        })

        arrayFolha = $("input[name='horaSaida']").serializeArray()
        var arrayHoraSaida = arrayFolha.map(folha => {
            return {
                horaSaida: String(folha.value)
            }
        })

        arrayFolha = $("input[name='horaExtra']").serializeArray()
        var arrayHoraExtra = arrayFolha.map(folha => {
            return {
                horaExtra: String(folha.value)
            }
        })

        arrayFolha = $("input[name='atraso']").serializeArray()
        var arrayAtraso = arrayFolha.map(folha => {
            return {
                atraso: String(folha.value)
            }
        })

        arrayFolha = $("select[name=\"lancamento\"] option[selected]")
        var arrayLancamento = new Array()
        arrayFolha.each((index, el) => {
            let value = Number($(el).val())
                arrayLancamento.push({
                    lancamento: Number(value)
                })

        })

        var codigo = Number($("#codigo").val())
        var ativo = Number($("#ativo").val())
        var funcionario = Number($("#funcionario").val());
        var mesAno = String($("#mesAno").val());
        var observacaoFolhaPontoMensal = String($("#observacaoFolhaPontoMensal").val());

        // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
        var folhaPontoMensalTabela = arrayDia.map((array, index) => {
            return {
                dia: array.dia,
                horaEntrada: arrayHoraEntrada[index].horaEntrada,
                horaSaida: arrayHoraSaida[index].horaSaida,
                inicioAlmoco: arrayInicioAlmoco[index].inicioAlmoco,
                fimAlmoco: arrayFimAlmoco[index].fimAlmoco,
                horaExtra: arrayHoraExtra[index].horaExtra,
                atraso: arrayAtraso[index].atraso,
                lancamento: arrayLancamento[index].lancamento
            }

        })

        var folhaPontoInfo = {
            codigo: Number(codigo),
            ativo: Number(ativo),
            funcionario: Number(funcionario),
            mesAno: String(mesAno),
            observacao: String(observacaoFolhaPontoMensal)
        }

        gravaFolhaPontoMensal(folhaPontoInfo, folhaPontoMensalTabela,
            function(data) {

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
                    var piece = data.split("#");
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    novo();
                }
            }
        );
    }

    function excluir() {
        debugger;
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFolhaPontoMensal(id, function(data) {
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

    function carregaFolhaPontoMensal() {

        const data = new Date().toLocaleDateString();
        const mesAno = data.slice(3, data.length);
        const funcionario = $("#funcionario option:selected").val();

        $('#mesAno').val(mesAno);


        recuperaFolhaPontoMensal(funcionario, mesAno,
            function(data) {
                data = data.replace(/failed/gi, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];
                var JsonFolha = piece[2];
                piece = out.split("^");

                //funcionando
                if (out.length >= 0 && out != "") {
                    var codigo = piece[0];
                    var funcionario = piece[1];
                    var observacao = piece[2];
                    var mesAnoFolhaPonto = piece[3];

                    $("#codigo").val(codigo);
                    $("#funcionario").val(funcionario);
                    $("#obvercao").val(observacao);
                    $("#mesAno").val(mesAnoFolhaPonto);
                } else {
                    $("#codigo").val(0);
                    $("#obvercao").val("");
                }

                //funcionando
                try {
                    preencherPonto(JsonFolha);
                } catch (e) {
                    limparPonto();
                    
                    smartAlert("Aviso", "O usuário não possui uma folha registrada desse mês!", "info");
                    // throw new Error("O usuário não possui uma folha registrada desse mês!");
                    return
                }

            }
        );

    }

    function selecionaFolha() {

        const funcionario = $("#funcionario option:selected").val();
        const mesAno = $("#mesAno").val();

        recuperaFolhaPontoMensal(funcionario, mesAno,
            function(data) {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                //Atributos de Cliente
                var mensagem = piece[0];
                var out = piece[1];
                var JsonFolha = piece[2];

                piece = out.split("^");

                if (out.length >= 0 && out != "") {
                    var codigo = +piece[0];
                    var funcionario = piece[1];
                    var observacao = piece[2];
                    var mesAnoFolhaPonto = piece[3];

                    $("#codigo").val(codigo);
                    $("#funcionario").val(funcionario);
                    $("#obvercao").val(observacao);
                    $("#mesAno").val(mesAnoFolhaPonto);
                } else {
                    $("#codigo").val(0);
                    $("#obvercao").val("");
                }

                //funcionando
                try {
                    preencherPonto(JsonFolha);
                } catch (e) {
                    limparPonto();
                    smartAlert("Atenção", "O usuário não possui uma folha registrada desse mês!", "error");
                    // throw new Error("O usuário não possui uma folha registrada desse mês!");
                    return
                }
            }
        );

    }

    //funcionando
    function preencherPonto(object) {
        object = JSON.parse(object);
        object.forEach((obj, index) => {

            $(`#horaEntrada-${Number(index) + 1}`).val(obj.entrada);
            $(`#inicioAlmoco-${Number(index)+1}`).val(obj.inicioAlmoco);
            $(`#fimAlmoco-${Number(index) + 1}`).val(obj.fimAlmoco);
            $(`#horaSaida-${Number(index) + 1}`).val(obj.saida);
            $(`#horaExtra-${Number(index) + 1}`).val(obj.horaExtra);
            $(`#atraso-${Number(index) + 1}`).val(obj.atraso);
            $(`#lancamento-${Number(index) + 1}`).val(obj.lancamento);
        })
    }

    function limparPonto() {
        const pontos = $("[name=\"dia\"]").serializeArray()
        pontos.forEach((_, index) => {

            $(`#horaEntrada-${Number(index) + 1}`).val('');
            $(`#inicioAlmoco-${Number(index)+1}`).val('');
            $(`#fimAlmoco-${Number(index) + 1}`).val('');
            $(`#horaSaida-${Number(index) + 1}`).val('');
            $(`#horaExtra-${Number(index) + 1}`).val('');
            $(`#atraso-${Number(index) + 1}`).val('');
            $(`#lancamento-${Number(index) + 1}`).val('');
        })
    }

    function aleatorizarTempo(hora, expediente) {
        let separador = hora.split(':');
        let h = Number(separador[0]);
        let m = Number(separador[1]);
        let s = Number(separador[2]);

        separador = expediente.split(':');
        const eh = Number(separador[0]);
        const em = Number(separador[1]);
        let es = Number(separador[2]);
        if (isNaN(es)) es = Number('00');

        if ((h == eh) && (m == em)) {
            m = Math.floor(Math.random() * (3 - 0)) + 0;
            s = Math.floor(Math.random() * 60);
        }

        if (h.toString().length < 2) h = `0${h}`;
        if (m.toString().length < 2) m = `0${m}`;
        if (s.toString().length < 2) s = `0${s}`;

        const result = `${h}:${m}:${s}`;
        return result;
    }
</script>