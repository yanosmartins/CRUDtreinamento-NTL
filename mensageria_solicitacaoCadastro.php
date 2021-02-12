<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('SOLICITACAO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('SOLICITACAO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('SOLICITACAO_EXCLUIR', $arrayPermissao, true));

$condicaoAcessarOK = true;

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

$page_title = "Pregões Não Iniciados";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["mensageria"]["sub"]["solicitacao"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
  <?php
  //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
  //$breadcrumbs["New Crumb"] => "http://url.com"
  $breadcrumbs["Solicitações"] = "";
  include("inc/ribbon.php");
  ?>


  <!-- MAIN CONTENT -->
  <div id="content">
    <!-- widget grid -->
    <section id="widget-grid" class="">
      <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
          <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-devarebutton="false" data-widget-sortable="false" style="">
            <header>
              <span class="widget-icon"><i class="fa fa-cog"></i></span>
              <h2>Solicitações</h2>
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
                              <input id="codigoFuncionario" name="codigoFuncionario" type="text" class="hidden">
                            </div>
                            <div class="row">
                              <section class="col col-3">
                                <label class="label">Funcionário</label>
                                <label class="input">
                                  <?php
                                  session_start();
                                  $login = $_SESSION['login'];
                                  $login = "'" . $login . "'";
                                  echo "<input id='funcionario' maxlength='255' name='funcionario' class='readonly' type='select' value=" . $login . " readonly>"
                                  ?>
                                </label>
                              </section>
                              <section class="col col-3">
                                <label class="label">Data</label>
                                <label class="input">
                                <i class="icon-append fa fa-calendar"></i>
                                  <?php
                                  $hoje = date("d/m/Y");
                                  $hoje = "'" . $hoje . "'";
                                  echo "<input id='data' name='data' type='text' data-dateformat='dd/mm/yy' class='readonly' style='text-align: center' value="
                                    . $hoje . " data-mask='99/99/9999' data-mask-placeholder='-' autocompvare='new-password' readonly>"
                                  ?>

                                </label>
                              </section>
                              <section class="col col-3">
                                <label class="label">Hora</label>
                                <label class="input">
                                <i class="icon-append fa fa-clock-o"></i>
                                  <?php
                                  $hora = date("h:i");
                                  $hora = "'" . $hora . "'";
                                  echo "<input id='hora' name='hora' class='readonly' type='text' autocompvare='new-password' value=".$hora." readonly>"
                                  ?>
                                </label>
                              </section>
                              <section class="col col-3">
                                <label class="label">Data Limite</label>
                                <label class="input">
                                <i class="icon-append fa fa-calendar"></i>
                                  <input id="dataLimite" name="dataLimite" autocompvare="off" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocompvare="new-password">
                                </label>
                              </section>
                            </div>
                            <div class="row">
                              <section class="col col-6">
                                <label class="label" for="projeto">Projeto</label>
                                <label class="select">
                                  <select id="projeto" name="projeto" class="required">
                                    <option></option>
                                    <?php
                                    $sql =  "SELECT codigo, descricao FROM Ntl.projeto where ativo = 1 order by descricao";
                                    $reposit = new reposit();
                                    $result = $reposit->RunQuery($sql);
                                    foreach ($result as $row) {
                                      $codigo = $row['codigo'];
                                      $descricao = ($row['descricao']);
                                      echo '<option value=' . $codigo . '>  ' . $descricao . ' </option>';
                                    }
                                    ?>
                                  </select><i></i>
                              </section>
                              <section class="col col-6">
                                <label class="label">Local</label>
                                <label class="input">
                                  <input id="Local" maxlength="255" autocompvare="off" name="Local" class="required" type="select" value="">
                                </label>
                              </section>
                            </div>
                            <div class="row">
                              <section class="col col-12">
                                <label class="label">Observação</label>
                                <textarea id="observacao" name="observacao" class="form-control" rows="3" style="resize:vertical" autocompvare="off"></textarea>
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
include "inc/footer.php";
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include "inc/scripts.php";
?>

<script src="<?php echo ASSETS_URL; ?>/js/business_mensageriaSolicitacao.js" type="text/javascript"></script>
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

    $("#btnVoltar").on("click", function() {
      voltar();
    });

    //Botões de Tarefa
    $("#btnAddSolicitacao").on("click", function() {
      if (validaSolicitacao())
        addSolicitacao();
    });

    $("#btnRemoverSolicitacao").on("click", function() {
      excluirSolicitacao();
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
        recupera(idd,
          function(data) {
            if (data.indexOf('failed') > -1) {} else {
              data = data.replace(/failed/g, '');
              var piece = data.split("#");
              var mensagem = piece[0];
              var out = piece[1];
              var strArraySolicitacao = piece[2];

              piece = out.split("^");
              codigo = piece[0];
              portal = piece[1];
              ativo = piece[2];
              orgaoLicitante = piece[3];
              objetoLicitado = piece[4];

              $("#observacaoCondicao").val(observacaoCondicao);
              $("#jsonSolicitacao").val(strArraySolicitacao);

              jsonSolicitacaoArray = JSON.parse($("#jsonSolicitacao").val());
              fillTableSolicitacao();

            }
          }
        );
      }
    }
  }

  function gravar() {
    gravarSolicitacao(function() {

    })
  }

  function recupera(callback) {
    recuperaSolicitacao(callback);
  }

  function voltar() {
    $(location).attr('href', 'inddex.php');
  }
</script>