<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de perminssão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('EMPRESA_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('EMPRESA_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('EMPRESA_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Empresa";
/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['cadastro']["sub"]['empresa']["active"] = true;
include("inc/nav.php");
?>

<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
  <?php
  //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
  //$breadcrumbs["New Crumb"] => "http://url.com"
  $breadcrumbs["Empresa"] = "";
  include("inc/ribbon.php");
  ?>

  <!-- MAIN CONTENT -->
  <div id="content">

    <!-- widget grid -->
    <section id="widget-grid" class="">
      <!-- <div class="row" style="margin: 0 0 13px 0;">
                <?php if ($condicaoGravarOK) { ?>
                    <a class="btn btn-primary fa fa-file-o" aria-hidden="true" title="Novo" href="<?php echo APP_URL; ?>/cadastroInss.php" style="float:right"></a>
                <?php } ?>
            </div> -->

      <div class="row">
        <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
          <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
            <header>
              <span class="widget-icon"><i class="fa fa-cog"></i></span>
              <h2>Empresa
              </h2>
            </header>
            <div>
              <div class="widget-body no-padding">
                <form action="javascript:gravar()" class="smart-form client-form" id="formInss" method="post">
                  <div class="panel-group smart-accordion-default" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                            <i class="fa fa-lg fa-angle-up pull-right"></i>
                            Cadastro
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFiltro" class="panel-collapse collapse in">
                        <div class="panel-body no-padding">
                          <fieldset>
                            <input id="codigo" name="codigo" type="text" class="hidden" value="0">
                            <input id="ativo" name="ativo" type="text" class="hidden" value="0">
                            <div class="row ">
                              <section class="col col-4">
                                <label class="label">Nome</label>
                                <label class="input">
                                  <input id="nome" name="nome" style="text-align: left;" type="text" class="required" autocomplete="off" required>
                                </label>
                              </section>
                              <section class="col col-4">
                                <label class="label">Codigo Departamento</label>
                                <label class="input">
                                  <input id="codigoDepartamento" name="codigoDepartamento" style="text-align: left;" type="text" class="required" autocomplete="off" required>
                                </label>
                              </section>
                            </div>
                            <div class="row">
                              <section class="col col-4">
                                <label class="label">Nome Departamento</label>
                                <label class="input">
                                  <input id="nomeDepartamento" name="nomeDepartamento" style="text-align: left;" type="text" class="required" autocomplete="off" required>
                                </label>
                              </section>
                              <section class="col col-4">
                                <label class="label">Responsavel Recebimento</label>
                                <label class="input">
                                  <input id="responsavelRecebimento" name="responsavelRecebimento" style="text-align: left;" type="text" class="required" autocomplete="off" required>
                                </label>
                              </section>
                            </div>
                            <div class="row">
                              <section class="col col-2">
                                <label class="label" for="cep">CEP</label>
                                <label class="input">
                                  <input class="required" id="cep" name="cep" placeholder="XXXXX-XXX" autocomplete="off">
                                </label>
                              </section>
                            </div>
                            <div class="row">
                            <section class="col col-2">
                                <label class="label" for="tipoLogradouro">Tipo Logradouro</label>
                                <label class="input">
                                  <input class="required" id="tipoLogradouro" name="tipoLogradouro" maxlength="255" autocomplete="off">
                                </label>
                              </section>
                              <section class="col col-6">
                                <label class="label" for="logradouro">Logradouro</label>
                                <label class="input">
                                  <input class="required" id="logradouro" name="logradouro" maxlength="255" autocomplete="off">
                                </label>
                              </section>
                            </div>
                            <div class="row">
                              <section class="col col-2">
                                <label class="label" for="numeroLogradouro">Número</label>
                                <label class="input">
                                  <input class="required" id="numeroLogradouro" name="numeroLogradouro" maxlength="20" autocomplete="off">
                                </label>
                              </section>
                              <section class="col col-6">
                                <label class="label" for="complemento">Complemento</label>
                                <label class="input">
                                  <input id="complemento" name="complemento" maxlength="50" autocomplete="off">
                                </label>
                              </section>

                            </div>
                            <div class="row">
                              <section class="col col-2">
                                <label class="label" for="ufCarteiraTrabalho">UF</label>
                                <label class="select">
                                  <select id="ufLogradouro" name="ufLogradouro" class="required">
                                    <option></option>
                                    <?php
                                    $reposit = new reposit();
                                    $sql = "select * from Ntl.unidadeFederacao order by sigla";
                                    $result = $reposit->RunQuery($sql);
                                    foreach ($result as $row) {

                                      $sigla = $row['sigla'];
                                      echo '<option value=' . $sigla . '>' . $sigla . '</option>';
                                    }
                                    ?>
                                  </select><i></i>
                                </label>
                              </section>

                              <section class="col col-4">
                                <label class="label" for="cidade">Cidade</label>
                                <label class="input">
                                  <input class="required" id="cidade" name="cidade" autocomplete="off">
                                </label>
                              </section>

                              <section class="col col-2">
                                <label class="label" for="bairro">Bairro</label>
                                <label class="input">
                                  <input class="required" id="bairro" name="bairro" maxlength="30" autocomplete="off">
                                </label>
                              </section>
                          </fieldset>
                        </div>
                      </div>
                    </div>
                  </div>
                  <footer>
                    <!-- <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
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
                    </div> -->
                    <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                      <span class="fa fa-floppy-o"></span>
                    </button>
                    <!-- <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                      <span class="fa fa-file-o"></span>
                    </button> -->
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
<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroEmpresa.js" type="text/javascript"></script>
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script language="JavaScript" type="text/javascript">
  $(document).ready(function() {

    $("#cep").mask("99999-999");

    $("#cep").on("focusout", function() {
            var cep = $("#cep").val();
            var funcao = 'recuperaCepTipoLogradouro';

            $.ajax({
                method: 'POST',
                url: 'js/sqlscope.php',
                data: {
                    funcao,
                    cep
                },
                success: function(data) {
                    var status = data.split('#');
                    var piece = status[1].split('^');
                    $("#tipoLogradouro").val(piece[0]);
                    $("#logradouro").val(piece[1]);
                    $("#bairro").val(piece[2]);
                    $("#cidade").val(piece[3]);
                    $("#ufLogradouro").val(piece[4]);
                    return;
                }
            });
        });

    $("#btnGravar").on("click", function() {
      gravar();
    });
    $("#btnVoltar").on("click", function() {
      voltar();
    });
    carregaEncargo();
  });

  function voltar() {
    $(location).attr('href', 'index.php');
  }

  function gravar() {
    //Botão que desabilita a gravação até que ocorra uma mensagem de erro ou sucesso.
    $("#btnGravar").prop('disabled', true);

    var codigo = +$("#codigo").val();
    var ativo = $("#ativo").val();
    var nome = $("#nome").val();
    var codigoDepartamento = $("#codigoDepartamento").val();
    var nomeDepartamento = $("#nomeDepartamento").val();
    var responsavelRecebimento = $("#responsavelRecebimento").val();
    var cep = $("#cep").val();
    var tipoLogradouro = $("#tipoLogradouro").val();
    var logradouro = $("#logradouro").val();
    var numero = $("#numeroLogradouro").val();
    var complemento = $("#complemento").val();
    var uf = $("#ufLogradouro").val();
    var cidade = $("#cidade").val();
    var bairro = $("#bairro").val();

    // Mensagens de aviso caso o usuário deixe de digitar algum campo obrigatório:
    if (!nome) {
      smartAlert("Erro", "Informe o nome.", "error");
      return;
    }

    if (!codigoDepartamento) {
      smartAlert("Erro", "Informe o codigo Departamento.", "error");
      return;
    }

    if (!nomeDepartamento) {
      smartAlert("Erro", "Informe o nome Departamento.", "error");
      return;
    }
    
    if (!responsavelRecebimento) {
      smartAlert("Erro", "Informe o Responsavel Recebimento.", "error");
      return;
    }

    if (!cep) {
      smartAlert("Erro", "Informe o cep.", "error");
      return;
    }

    if (!tipoLogradouro) {
      smartAlert("Erro", "Informe o tipo Logradouro.", "error");
      return;
    }

    if (!logradouro) {
      smartAlert("Erro", "Informe o logradouro.", "error");
      return;
    }

    if (!numero) {
      smartAlert("Erro", "Informe o numero.", "error");
      return;
    }

    if (!uf) {
      smartAlert("Erro", "Informe o numero.", "error");
      return;
    }
    
    if (!cidade) {
      smartAlert("Erro", "Informe o cidade.", "error");
      return;
    }
       
    if (!bairro) {
      smartAlert("Erro", "Informe o bairro.", "error");
      return;
    }


    gravaEmpresa(codigo,ativo,nome,codigoDepartamento,nomeDepartamento,responsavelRecebimento,
     cep,tipoLogradouro,logradouro,numero,complemento,uf,cidade,bairro,
      function(data) {

        if (data.indexOf('sucess') < 0) {
          var piece = data.split("#");
          var mensagem = piece[1];
          if (mensagem !== "") {
            smartAlert("Atenção", mensagem, "error");
            return false;
          } else {
            smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
            $("#btnGravar").prop('disabled', false);
            return false;
          }
        } else {
          var piece = data.split("#");
          smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
          voltar();
        }
      }
    );
  }

  function carregaEncargo() {
    var urlx = window.document.URL.toString();
    var params = urlx.split("?");
    if (params.length === 2) {
      var id = params[1];
      var idx = id.split("=");
      var idd = idx[1];
      if (idd !== "") {
        recuperaEmpresa(idd,
          function(data) {
            data = data.replace(/failed/g, '');
            var piece = data.split("#");

            var mensagem = piece[0];
            var out = piece[1];

            piece = out.split("^");
            console.table(piece);

            var codigo = +piece[0];
            var ativo = piece[1];
            var nome = piece[2];
            var codigoDepartamento = piece[3];
            var nomeDepartamento = piece[4];
            var responsavelRecebimento = piece[5];
            var cep = piece[6];
            var tipoLogradouro = piece[7];
            var logradouro = piece[8];
            var numero = piece[9];
            var complemento = piece[10];
            var bairro = piece[11];
            var cidade = piece[12];
            var uf = piece[13];

            $("#codigo").val(codigo);
            $("#ativo").val(ativo);
            $("#nome").val(nome);
            $("#codigoDepartamento").val(codigoDepartamento);
            $("#nomeDepartamento").val(nomeDepartamento);
            $("#responsavelRecebimento").val(responsavelRecebimento);
            $("#cep").val(cep);
            $("#tipoLogradouro").val(tipoLogradouro);
            $("#logradouro").val(logradouro);
            $("#numeroLogradouro").val(numero);
            $("#complemento").val(complemento);
            $("#bairro").val(bairro);
            $("#cidade").val(cidade);
            $("#ufLogradouro").val(uf);
          }
        );
      }
    }
  }
</script>