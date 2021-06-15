<?php
//Inicializa a página
require_once("inc/init.php");

//Requer a configuração de UI (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$funcionario = $_SESSION["funcionario"];

$condicaoAcessarOK = (in_array('PONTOELETRONICOMENSALMODERADO_ACESSAR', $arrayPermissao, true));
$condicaoAcessarOK = true;

if (($condicaoAcessarOK == false)) {
  unset($_SESSION['login']);
  header("Location:login.php");
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
$page_css[] = "ponto_mensal.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['funcionario']['sub']["controlePonto"]["active"] = true;
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
              <h2>Correção da folha
              </h2>
            </header>
            <div>
              <div class="widget-body no-padding">
                <form class="smart-form client-form" id="formSolicitacao" method="post">
                  <div class="panel-group smart-accordion-default" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseSolicitante" class="collapsed" id="accordionSolicitante">
                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                            <i class="fa fa-lg fa-angle-up pull-right"></i>
                            Solicitar alteração na folha
                          </a>
                        </h4>
                      </div>
                      <div id="collapseSolicitante" class="panel-collapse collapse in">
                        <div class="panel-body no-padding">
                          <fieldset>
                            <input id="jsonSolicitante" name="jsonSolicitante" type="hidden" value="[]">
                            <div id="formSolicitante" class="col col-sm-12">
                              <input id="solicitanteId" name="solicitanteId" type="hidden" value="">
                              <input id="sequencialSolicitante" name="sequencialSolicitante" type="hidden" value="">
                              <div class="form-group">
                                <div class="row">
                                  <section class="col col-sm-1 col-md-1 col-lg-1">
                                    <label class="label">Dia</label>
                                    <div class="form-control input">
                                      <input type="text" name="dia" id="dia" class="text-center form-control datepicker" readonly data-autoclose="true" maxlength="2" data-dateformat="d">
                                    </div>
                                  </section>
                                  <section class="col col-sm-2 col-md-2 col-lg-2">
                                    <label class="label" for="campo">Campo</label>
                                    <label class="select">
                                      <select id="campo" name="campo">
                                        <option value=""> -- </option>
                                        <option value="Entrada">Entrada</option>
                                        <option value="Início do almoço">Início do almoço</option>
                                        <option value="Fim do almoço">Fim do almoço</option>
                                        <option value="Saída">Saída</option>
                                        <option value="Extra">Extra</option>
                                        <option value="Atraso">Atraso</option>
                                      </select><i></i>
                                    </label>
                                  </section>
                                  <section class="col col-sm-2 col-md-2 col-lg-2">
                                    <label class="label" for="horas">Horas</label>
                                    <div class="form-control input">
                                      <input type="text" name="horas" id="horas" class="text-center">
                                    </div>
                                  </section>
                                  <section class="col col-md-2">
                                    <label class="label" for="dataReferente">Data referente</label>
                                    <label class="input">
                                      <i class="icon-append fa fa-calendar"></i>
                                      <input id="dataReferente" name="dataReferente" autocomplete="new-password" type="text" placeholder="mm/aaaa" data-dateformat="mm/yy" class="datepicker text-center" value="" data-mask="99/9999" data-mask-placeholder="mm/aaaa">
                                    </label>
                                  </section>
                                  <section class="col col-md-2">
                                    <label class="label">&nbsp;</label>
                                    <button id="btnAddSolicitacao" type="button" class="btn btn-primary">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                    <button id="btnRemoverSolicitacao" type="button" class="btn btn-danger">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </section>
                                </div>
                                <div class="row">
                                  <section class="col col-sm-5 col-md-5 col-lg-5">
                                    <label class="label" for="justificativa">Justificativa</label>
                                    <label class="textarea">
                                      <textarea name="justificativa" id="justificativa" rows="2" style="resize: none"></textarea>
                                    </label>
                                  </section>
                                </div>
                              </div>
                              <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                <table id="tableSolicitante" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                  <thead>
                                    <tr role="row">
                                      <th></th>
                                      <th>Dia</th>
                                      <th>Campo</th>
                                      <th>Horas</th>
                                      <th>Data referente</th>
                                      <th>Justificativa</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <section class="col col-md-4">
                                    <button id="enviarSolicitacao" type="button" class="btn btn-primary">Enviar Solicitações
                                    </button>
                                  </section>
                                </div>
                              </div>
                            </div>

                          </fieldset>
                        </div>

                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseSolicitado" class="collapsed" id="accordionSolicitado">
                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                            <i class="fa fa-lg fa-angle-up pull-right"></i>
                            Gerenciar solicitações
                          </a>
                        </h4>
                      </div>
                      <div id="collapseSolicitado" class="panel-collapse collapse in">
                        <div class="panel-body no-padding">
                          <fieldset>
                            <input id="jsonSolicitado" name="jsonSolicitado" type="hidden" value="[]">
                            <div id="formSolicitado" class="col col-sm-12">
                              <input id="solicitadoId" name="solicitadoId" type="hidden" value="">
                              <input id="sequencialSolicitado" name="sequencialSolicitado" type="hidden" value="">
                              <div class="table-responsive" style="min-height: 115px; width:100%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                <table id="tableSolicitado" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                  <thead>
                                    <tr role="row">
                                      <th><input type="checkbox" name="checkbox "></th>
                                      <th>Funcionário</th>
                                      <th>Dia</th>
                                      <th>Campo</th>
                                      <th>Horas</th>
                                      <th>Data referente</th>
                                      <th>Justificativa</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <section class="col">
                                    <button id="enviarUploads" type="button" class="btn btn-primary">Aceitar solicitações selecionadas
                                    </button>
                                  </section>
                                  <section class="col">
                                    <button id="enviarUploads" type="button" class="btn btn-danger">Recusar solicitações selecionadas
                                    </button>
                                  </section>
                                </div>
                              </div>
                            </div>

                          </fieldset>
                        </div>

                      </div>
                    </div>
                    <footer>

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
  var jsonSolicitanteArray = JSON.parse($("#jsonSolicitante").val());
  var jsonSolicitadoArray = JSON.parse($("#jsonSolicitado").val());

  $(document).ready(function() {

    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
      _title: function(title) {
        if (!this.options.title) {
          title.html("&#160;");
        } else {
          title.html(this.options.title);
        }
      }
    }));

    $("#btnAddSolicitacao").on("click", addSolicitante);
    $("#btnRemoverSolicitacao").on("click", excluirSolicitante);

    $("#campo").on("change", () => {
      const val = $("#campo").val();
      const pattern = /^(Entrada|Saída)$/gi

      if (pattern.test(val)) {
        $("#horas").mask("99:99:99");
      } else {
        $("#horas").mask("99:99");
      }
    })

  });

  //============ TABLE SOLICITANTE ===================

  function clearFormSolicitante() {
    $("#dia").val('');
    $("#campo").val('');
    $("#horas").val('');
    $("#dataReferente").val('');
    $("#justificativa").val('');
  }

  function addSolicitante() {
    var item = $("#formSolicitante").toObject({
      mode: 'combine',
      skipEmpty: false,
      nodeCallback: processSolicitante
    });

    if (item["sequencialSolicitante"] === '') {
      if (jsonSolicitanteArray.length === 0) {
        item["sequencialSolicitante"] = 1;
      } else {
        item["sequencialSolicitante"] = Math.max.apply(Math, jsonSolicitanteArray.map(function(o) {
          return o.sequencialSolicitante;
        })) + 1;
      }
      item["solicitanteId"] = 0;
    } else {
      item["sequencialSolicitante"] = +item["sequencialSolicitante"];
    }

    item.dia = $("#dia").val()
    item.campo = $("#campo").val()
    item.horas = $("#horas").val()
    item.dataReferente = $("#dataReferente").val()
    item.justificativa = $("#justificativa").val()

    var index = -1;
    $.each(jsonSolicitanteArray, function(i, obj) {
      if (+$('#sequencialSolicitante').val() === obj.sequencialSolicitante) {
        index = i;
        return false;
      }
    });

    if (index >= 0)
      jsonSolicitanteArray.splice(index, 1, item);
    else
      jsonSolicitanteArray.push(item);

    $("#jsonSolicitante").val(JSON.stringify(jsonSolicitanteArray));
    fillTableSolicitante();
    clearFormSolicitante();

  }

  function fillTableSolicitante() {
    $("#tableSolicitante tbody").empty();
    if (typeof(jsonSolicitanteArray) != 'undefined') {
      for (var i = 0; i < jsonSolicitanteArray.length; i++) {
        var row = $('<tr />');
        $("#tableSolicitante tbody").append(row);
        row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox " value="' + jsonSolicitanteArray[i].sequencialSolicitante + '"><i></i></label></td>'));
        row.append($('<td class="text-center" onclick="carregaSolicitante(' + jsonSolicitanteArray[i].sequencialSolicitante + ');">' + jsonSolicitanteArray[i].dia + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitanteArray[i].campo + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitanteArray[i].horas + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitanteArray[i].dataReferente + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitanteArray[i].justificativa + '</td>'));
      }
      clearFormSolicitante()
    }
  }

  function processSolicitante(node) {
    var fieldId = node.getAttribute ? node.getAttribute('id') : '';
    var fieldName = node.getAttribute ? node.getAttribute('name') : '';

    if (fieldName !== '' && (fieldId === "dia")) {
      const dia = $("#dia").val();
      if (dia !== '') {
        fieldName = "dia";
      }
      return {
        name: fieldName,
        value: $("#dia").val()
      };
    }

    if (fieldName !== '' && (fieldId === "campo")) {
      var campo = $("#campo").val();
      if (campo !== '') {
        fieldName = "campo";
      }
      return {
        name: fieldName,
        value: $("#campo").val()
      };
    }

    if (fieldName !== '' && (fieldId === "horas")) {
      var horas = $("#horas").val();
      if (horas !== '') {
        fieldName = "horas";
      }
      return {
        name: fieldName,
        value: $("#horas").val()
      };
    }

    if (fieldName !== '' && (fieldId === "dataReferente")) {
      var dataReferente = $("#dataReferente").val();
      if (dataReferente !== '') {
        fieldName = "dataReferente";
      }
      return {
        name: fieldName,
        value: $("#dataReferente").val()
      };
    }

    if (fieldName !== '' && (fieldId === "justificativa")) {
      var justificativa = $("#justificativa").val();
      if (justificativa !== '') {
        fieldName = "justificativa";
      }
      return {
        name: fieldName,
        value: $("#justificativa").val()
      };
    }

    return false;
  }

  function carregaSolicitante(sequencialSolicitante) {
    var arr = jQuery.grep(jsonSolicitanteArray, function(item, i) {
      return (item.sequencialSolicitante === sequencialSolicitante);
    });

    clearFormSolicitante();

    if (arr.length > 0) {
      var item = arr[0];
      $("#dia").val(item.dia);
      $("#campo").val(item.campo);
      $("#horas").val(item.horas);
      $("#dataReferente").val(item.dataReferente);
      $("#justificativa").val(item.justificativa);
    }
  }

  function excluirSolicitante() {
    var arrSequencial = [];
    $('#tableSolicitante input[type=checkbox]:checked').each(function() {
      arrSequencial.push(parseInt($(this).val()));
    });
    if (arrSequencial.length > 0) {
      for (i = jsonSolicitanteArray.length - 1; i >= 0; i--) {
        var obj = jsonSolicitanteArray[i];
        if (jQuery.inArray(obj.sequencialSolicitante, arrSequencial) > -1) {
          jsonSolicitanteArray.splice(i, 1);
        }
      }
      $("#jsonSolicitante").val(JSON.stringify(jsonSolicitanteArray));
      fillTableSolicitante();
    } else {
      smartAlert("Erro", "Selecione pelo menos uma solicitação para excluir.", "error");
    }
  }

  //==================================================================
  //============ TABLE SOLICITADO ===================
  function fillTableSolicitado() {
    $("#tableSolicitado tbody").empty();
    if (typeof(jsonSolicitadoArray) != 'undefined') {
      for (var i = 0; i < jsonSolicitadoArray.length; i++) {
        var row = $('<tr />');
        $("#tableSolicitado tbody").append(row);
        row.append($('<td><input type="checkbox" name="checkbox " value="' + jsonSolicitadoArray[i].sequencialSolicitado + '"></td>'));
        row.append($('<td class="text-center">' + jsonSolicitadoArray[i].dia + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitadoArray[i].campo + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitadoArray[i].horas + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitadoArray[i].dataReferente + '</td>'));
        row.append($('<td class="text-center" >' + jsonSolicitadoArray[i].justificativa + '</td>'));
      }
      clearFormSolicitante()
    }
  }

  //==================================================================
</script>