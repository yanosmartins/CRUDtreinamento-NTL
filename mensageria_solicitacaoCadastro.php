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

session_start();
$id = $_SESSION['funcionario'];




/* ---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Solicitação";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["operacao"]["sub"]["mensageria"]["sub"]["solicitacao"]["active"] = true;

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
                <form action="javascript:gravar()" class="smart-form client-form" id="formSolicitacao" method="post">
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
                              <input id="codigo" name="codigo" type="text" class="hidden" value="0">
                            </div>
                            <div class="row">
                              <section class="col col-6">
                                <label class="label">Funcionário</label>
                                <label class="input">
                                  <?php
                                  $sql = "SELECT nome FROM Ntl.funcionario WHERE codigo = " . $id;
                                  $result = $reposit->RunQuery($sql);
                                  if ($row = $result[0]) {
                                    $nome = "'" . $row['nome'] . "'";
                                    echo "<input id='funcionario' maxlength='255' name='funcionario' class='readonly' type='select' value=" . $nome . " readonly>";
                                  }
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
                                    . $hoje . " data-mask='99/99/9999' data-mask-placeholder='-' autocompvare='new-password' readonly>";
                                  ?>

                                </label>
                              </section>
                              <section class="col col-3">
                                <label class="label">Hora</label>
                                <label class="input">
                                  <i class="icon-append fa fa-clock-o"></i>
                                  <?php
                                  // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
                                  date_default_timezone_set('America/Sao_Paulo');
                                  // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
                                  $hora = date('H:i', time());
                                  $hora = "'" . $hora . "'";
                                  echo "<input id='hora' name='hora' class='readonly' type='text' autocompvare='new-password' value=" . $hora . " readonly>"
                                  ?>
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
                              <section class="col col-3">
                                <label class="label">Data Limite</label>
                                <label class="input">
                                  <i class="icon-append fa fa-calendar"></i>
                                  <input id="dataLimite" name="dataLimite" autocompvare="off" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocompvare="new-password">
                                </label>
                              </section>
                              <section class="col col-3">
                                <label class="label" for="condicao">Urgente</label>
                                <label class="select">
                                  <select id="urgente" name="urgente" class="required">
                                    <option></option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                  </select><i></i>
                              </section>
                            </div>
                            <div class="row">
                              <section class="col col-6">
                                <label class="label">Destino</label>
                                <label class="input">
                                  <input id="local" maxlength="255" autocompvare="off" name="local" type="text" value="">
                                </label>
                              </section>
                              <section class="col col-3">
                                <label class="label">Departamento</label>
                                <label class="select">
                                  <select id="departamento" name="departamento" class="readonly" readonly>
                                    <option></option>
                                    <?php
                                    $sql =  "SELECT departamento FROM Ntl.beneficioProjeto where ativo = 1 AND funcionario = " . $id;
                                    $result = $reposit->RunQuery($sql);
                                    if ($row = $result[0]) {
                                      $departamento = $row['departamento'];
                                    }

                                    $sql =  "SELECT codigo, descricao FROM Ntl.departamento where ativo = 1 order by descricao";
                                    $reposit = new reposit();
                                    $result = $reposit->RunQuery($sql);
                                    foreach ($result as $row) {
                                      $codigo = $row['codigo'];
                                      $descricao = ($row['descricao']);
                                      if ($codigo == $departamento) {
                                        echo '<option selected value=' . $codigo . '>  ' . $descricao . ' </option>';
                                      } else {
                                        echo '<option value=' . $codigo . '>  ' . $descricao . ' </option>';
                                      }
                                    }
                                    ?>
                                  </select><i></i>
                              </section>
                              <section class="col col-3" id="sectionRecurso">
                                <label class="label">Recursos Necessários</label>
                                <label class="input">
                                  <input id='recurso' maxlength='255' name='recurso' class='required text-center' type='text' data-mask="9">
                                </label>
                              </section>
                              <section class="col col-6" id="sectionResponsavel" hidden>
                                <label class="label">Responsável</label>
                                <label class="input">
                                  <input id="responsavelId" name="responsavelId" type="hidden" value="">
                                  <input id='responsavel' maxlength='255' name='responsavelFiltro' class='required' type='select'>
                                  <i class="icon-append fa fa-filter"></i>
                                </label>
                              </section>
                            </div>
                            <div class="row">
                              <section class="col col-12">
                                <label class="label">Observação</label>
                                <textarea id="observacao" name="observacao" class="form-control" rows="3" style="resize:vertical" autocompvare="off"></textarea>
                              </section>
                            </div>
                            <div class="row" id="divSolicitacao" hidden>
                              <section class="col col-12">
                                <legend><strong></strong></legend>
                              </section>
                              <section class="col col-6">
                                <label class="label">Quem Lancou</label>
                                <label class="input">
                                  <input id='funcionarioSolicitacao' maxlength='255' name='funcionarioSolicitacao' class='readonly' type='select' value='' readonly>
                                </label>
                              </section>
                              <section class="col col-2">
                                <label class="label">Data Solicitação</label>
                                <label class="input">
                                  <i class="icon-append fa fa-calendar"></i>
                                  <input id="dataSolicitacao" name="dataSolicitacao" type="text" data-dateformat="dd/mm/yy" class="readonly " style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocompvare="new-password" onchange="validaCampoData('#dataLancamento')" readonly>
                                </label>
                              </section>
                              <section class="col col-2">
                                <label class="label" for="hora">Hora Solicitacao</label>
                                <label class="input">
                                  <i class="icon-append fa fa-clock-o"></i>
                                  <input id="horaSolicitacao" name="horaSolicitacao" class="readonly" type="text" autocomplete="off" placeholder="hh:mm" readonly>
                                </label>
                              </section>
                              <section class="col col-2">
                                <label class="label" for="concluido">Concluido</label>
                                <label class="select">
                                  <select id="concluido" name="concluido" class="">
                                    <option></option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                  </select><i></i>
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

    $("#btnVoltar").on("click", function() {
      voltar();
    });

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


    $("#responsavel").autocomplete({
      source: function(request, response) {
        $.ajax({
          type: 'POST',
          url: 'js/sqlscope_mensageriaSolicitacao.php',
          cache: false,
          dataType: "json",
          data: {
            maxRows: 12,
            funcao: "listaNomeFuncionario",
            descricaoIniciaCom: request.term
          },
          success: function(data) {
            response($.map(data, function(item) {
              return {
                id: item.id,
                label: item.nome,
                value: item.nome
              };
            }));
          }
        });
      },
      minLength: 3,
      select: function(event, ui) {
        $("#responsavelId").val(ui.item.id);
        $("#responsavelFiltro").val(ui.item.nome);
        var responsavelId = $("#responsavelId").val();
        $("#responsavel").val(responsavelId)
        $("#responsavelFiltro").val('');
      },
      change: function(event, ui) {
        if (ui.item === null) {
          $("#responsavelId").val('');
          $("#responsavelFiltro").val('');
        }
      }
    }).data("ui-autocomplete")._renderItem = function(ul, item) {
      return $("<li>")
        .append("<a>" + highlight(item.label, this.term) + "</a>")
        .appendTo(ul);
    };
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
        recuperaSolicitacao(idd,
          function(data) {
            if (data.indexOf('failed') > -1) {} else {
              data = data.replace(/failed/g, '');
              var piece = data.split("#");
              var mensagem = piece[0];
              var out = piece[1];

              piece = out.split("^");
              codigo = piece[0];
              funcionario = piece[1];
              dataSolicitacao = piece[2];
              horaSolicitacao = piece[3];
              dataLimite = piece[4];
              urgente = piece[5];
              projeto = piece[6];
              local = piece[7];
              responsavel = piece[8];
              nomeResponsavel = piece[9];
              observacao = piece[10];
              funcionarioId = piece[11];
              concluido = piece[12];
              departamento = piece[13];
              recurso = +piece[14];
              usuarioCadastro = piece[15];
              dataCadastro = piece[16];


              //Arrumando o valor de dataLancamento e horaLancamento
              dataCadastro = dataCadastro.split(" ");
              dataLancamento = dataCadastro[0].split("-");
              dataLancamento = dataLancamento[2] + "/" + dataLancamento[1] + "/" + dataLancamento[0];
              horaLancamento = dataCadastro[1].split(":");
              horaLancamento = horaLancamento[0] + ":" + horaLancamento[1];

              $("#sectionResponsavel").removeAttr("hidden");
              $("#divSolicitacao").removeAttr("hidden");
              $("#divSolicitacao").removeAttr("readonly");

              $("#codigo").val(codigo);
              $("#funcionarioSolicitacao").val(usuarioCadastro);
              $("#dataSolicitacao").val(dataLancamento);
              $("#horaSolicitacao").val(horaLancamento);
              $("#dataLimite").val(dataLimite);
              $("#urgente").val(urgente);
              $("#projeto").val(projeto);
              $("#local").val(local);
              $("#observacao").val(observacao);
              $("#concluido").val(concluido);
              $("#departamento").val(departamento);
              $("#recurso").val(recurso);

              if (responsavel == '') {
                $("#responsavelId").val(funcionarioId);
              } else {
                $("#responsavelId").val(responsavel);
              }

              if (nomeResponsavel == '') {
                $("#responsavel").val(funcionario);
              } else {
                $("#responsavel").val(nomeResponsavel);
              }


            }
          }
        );
      }
    }
  }

  function gravar() {
    var codigo = $("#codigo").val();
    var projeto = $("#projeto").val();
    var responsavel = $("#responsavel").val();
    var dataLimite = $("#dataLimite").val();
    var urgente = $("#urgente").val();

    if (projeto === "") {
      smartAlert("Atenção", "Selecione um Projeto !", "error");
      $("#projeto").focus();
      return;
    }

    if (dataLimite === "") {
      smartAlert("Atenção", "Digite a Data Limite !", "error");
      $("#dataLimite").focus();
      return;
    }

    if (urgente === "") {
      smartAlert("Atenção", "Selecione se é Urgente !", "error");
      $("#urgente").focus();
      return;
    }

    if ((responsavel === "") && (codigo != 0)) {
      smartAlert("Atenção", "Selecione um Responsavel !", "error");
      $("#responsavel").focus();
      return;
    }

    var form = $('#formSolicitacao')[0];
    var formData = new FormData(form);
    gravaSolicitacao(formData);

  }

  function excluir() {
    var codigo = +$("#codigo").val();

    if (codigo === 0) {
      smartAlert("Atenção", "Selecione uma solicitacao para excluir!", "error");
      return;
    }

    excluirSolicitacao(codigo);
  }

  function recupera(callback) {
    recuperaSolicitacao(callback);
  }

  function voltar() {
    $(location).attr('href', 'mensageria_solicitacaoCadastro.php');
  }
</script>