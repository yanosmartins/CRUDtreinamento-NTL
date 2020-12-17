<?php
//include "js/repositorio.php";
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('PERMISSAOUSUARIO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('PERMISSAOUSUARIO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Permissões do Usuário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["controle"]["sub"]["permissoesUsuarios"]["active"] = true;


include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
<?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
$breadcrumbs["Consultorio"] = "";
include("inc/ribbon.php");
?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" role="widget" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Permissões do Usuário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formCadastro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-5">
                                                                <label class="label">Usuário</label>
                                                                <label class="select">
                                                                    <select id="usuario" name="usuario">
                                                                        <option></option>
                                                                    <?php
                                                                    $sql = " SELECT USU.codigo, USU.[login] FROM dbo.usuario USU
                                                                             WHERE USU.tipoUsuario IN ('C','T') AND USU.ativo = 1 ";
                                                                    $reposit = new reposit();
                                                                    $result = $reposit->RunQuery($sql);

                                                                    while (($row = odbc_fetch_array($result))) {
                                                                        $id = +$row['codigo'];
                                                                        $login = mb_convert_encoding($row['login'], 'UTF-8', 'HTML-ENTITIES');

                                                                        echo '<option value=' . $id . '>' . $login . '</option>';
                                                                    }
                                                                    ?>                                                                                
                                                                    </select><i></i>
                                                                </label>                                                                                                                                
                                                            </section>
                                                            <section class="col col-5">
                                                                <label class="label">Escolha de Permissão por Menu</label>
                                                                <label class="select">
                                                                    <select id="menuItem" name="menuItem">
                                                                        <option></option>
                                                                    <?php
                                                                    $tabela1 = "menuItem";
                                                                    $arg = " (0=0) ORDER BY ordem ";

                                                                    $reposit = new reposit();
                                                                    $result = $reposit->SelectCond($tabela1 . "|" . $arg . "");

                                                                    while (($row = odbc_fetch_array($result))) {
                                                                        $id = +$row['codigo'];
                                                                        $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');
                                                                        echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                    }
                                                                    ?>                                                                                
                                                                    </select><i></i>
                                                                </label>                                                                                                                                
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">&nbsp;</label>
                                                                <button id="btnSearch" type="button" class="btn btn-primary" title="Buscar">
                                                                    <i class="fa fa-search fa-lg"></i>
                                                                </button>
                                                            </section>                                                                    
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>   
                                        </div>
                                    </div>
                                    <div id="resultadoBusca" >
                                        <input id="JsonFuncionalidade" name="JsonFuncionalidade" type="hidden" value="[]">
                                        <input id="JsonFuncionalidadeMarcada" name="JsonFuncionalidadeMarcada" type="hidden" value="[]">
                                        <input id="marcarDesmarcarTodos" name="marcarDesmarcarTodos" type="hidden" value="0">
                                        <fieldset id="formPermissao">
                                            <button id="btnMarcarDesmarcarTodos" type="button" class="btn btn-success" title="Marca/Desmarca Todos">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <label class="label">&nbsp;</label>
                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                <table id="tablePermissao" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                    <thead>
                                                        <tr role="row">
                                                            <th style="width: 10px;"></th>
                                                            <th class="text-left" style="min-width: 10px;">Funcionalidade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <footer>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                            <span class="fa fa-trash" ></span>
                                        </button>
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" 
                                             tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" 
                                             style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
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
                                            <span class="fa fa-floppy-o" ></span>
                                        </button>
                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o" ></span>
                                        </button>
                                        <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                            <span class="fa fa-backward " ></span>
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

<script src="<?php echo ASSETS_URL; ?>/js/businessPermissao.js" type="text/javascript"></script>

<script>
    jsonFuncionalidadeArray = JSON.parse($("#JsonFuncionalidade").val());
    jsonFuncionalidadeMarcadaArray = JSON.parse($("#JsonFuncionalidadeMarcada").val());

    $(document).ready(function () {

        $("#usuario").on("change", function () {
            carregarFuncionalidade();
        });

        $("#btnSearch").on("click", function () {
            listarFuncionalidadePorItemMenu();
        });


        $('#btnMarcarDesmarcarTodos').on("click", function () {
            marcarDesmarcarTodos();
        });

        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function (title) {
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
                    click: function () {
                        $(this).dialog("close");
                        excluir();
                    }
                }, {
                    html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                    "class": "btn btn-default",
                    click: function () {
                        $(this).dialog("close");
                    }
                }]
        });

        $("#btnExcluir").on("click", function () {
            var idUsuario = $("#permissaoCadastro_Usuario").val();

            if (idUsuario === "") {
                smartAlert("Atenção", "Selecione um usuário para excluir !", "error");
                return;
            }

            if (idUsuario !== "") {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#btnNovo").on("click", function () {
            novo();
        });

        $("#btnVoltar").on("click", function () {
            voltar();
        });

        habilitaCamposPermissao();
        carregaPagina();
    });

    function carregarFuncionalidade() {
        var usuarioIdFiltro = +$('#usuario').val();

        if (usuarioIdFiltro === 0) {
            smartAlert("Atenção", "Informe o usuário!", "error");
            return;
        }
        recuperaPermissaoUsuario(usuarioIdFiltro);
        desabilitaCamposPermissao();
    }

    function listarFuncionalidadePorItemMenu() {
        var usuarioIdFiltro = +$('#usuario').val();
        var menuItemIdFiltro = +$('#menuItem').val();
        
        if (usuarioIdFiltro === 0) {
            smartAlert("Atenção", "Informe o usuário!", "error");
            return;
        }

        if (menuItemIdFiltro === 0) {
            smartAlert("Atenção", "Informe o menu!", "error");
            $('#menuItem').focus();
            return;
        }


        var arrPermissoesMarcadas = [];
        $('#tablePermissao input[type=checkbox]:checked').each(function () {
            arrPermissoesMarcadas.push(parseInt($(this).val()));
        });

        var arrPermissoesDesmarcadas = [];
        $('#tablePermissao input[type=checkbox]:not(:checked)').each(function () {
            arrPermissoesDesmarcadas.push(parseInt($(this).val()));
        });

        var possuiMarcacao = 0;
        if ((arrPermissoesMarcadas.length > 0) | (arrPermissoesDesmarcadas.length > 0)) {
            for (i = jsonFuncionalidadeArray.length - 1; i >= 0; i--) {
                var obj = jsonFuncionalidadeArray[i];
                if (jQuery.inArray(obj.idFuncionalidade, arrPermissoesMarcadas) > -1) {
                    jsonFuncionalidadeArray[i].marcado = 1;
                }
                if (jQuery.inArray(obj.idFuncionalidade, arrPermissoesDesmarcadas) > -1) {
                    jsonFuncionalidadeArray[i].marcado = 0;
                }
            }
        }
        $("#JsonFuncionalidade").val(JSON.stringify(jsonFuncionalidadeArray));
        fillTablePermissaoUsuario(menuItemIdFiltro);
    }

    function desabilitaCamposPermissao() {
        $('#usuario').prop('disabled', 'disabled');
        $('#usuario').addClass('readonly');
    }

    function habilitaCamposPermissao() {
        $('#usuario').prop('disabled', false);
        $('#usuario').removeClass('readonly');
    }

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var iddUsuario = idx[1];
            if (iddUsuario !== "") {
                $('#usuario').val(iddUsuario);
                carregarFuncionalidade();
            }
        }
        $("#menuItem").focus();

    }

    function fillTablePermissaoUsuario(idMenuItem) {
        $("#tablePermissao tbody").empty();
        var possuiMarcacao = 0;
        for (var i = 0; i < jsonFuncionalidadeArray.length; i++) {
            var row = $('<tr />');
            $("#tablePermissao tbody").append(row);

            idMenuItem = +idMenuItem;
            if (idMenuItem === jsonFuncionalidadeArray[i].idMenuItem) {
                if (jsonFuncionalidadeArray[i].marcado === 1) {
                    possuiMarcacao = 1;
                    row.append($('<td class="text-right"><label class="checkbox"><input type="checkbox" checked name="checkbox" value="' + jsonFuncionalidadeArray[i].idFuncionalidade + '"><i></i></label></td>'));
                } else {
                    row.append($('<td class="text-right"><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonFuncionalidadeArray[i].idFuncionalidade + '"><i></i></label></td>'));
                }
                if (jsonFuncionalidadeArray[i].nomeCompleto === "") {
                    row.append($('<td class="text-nowrap">' + jsonFuncionalidadeArray[i].descricaoFuncionalidade + '</td>'));
                } else {
                    row.append($('<td class="text-nowrap">' + jsonFuncionalidadeArray[i].nomeCompleto + '</td>'));
                }
            }
        }

        if (possuiMarcacao === 1) {
            $('#marcarDesmarcarTodos').val(1);
            //$("#btnMarcarDesmarcarTodos").html('Desmarcar Todos');
        } else {
            $('#marcarDesmarcarTodos').val(0);
            //$("#btnMarcarDesmarcarTodos").html('Marcar Todos');
        }

    }

    function marcarDesmarcarTodos() {
        var marcarDesmarcarTodos = +$('#marcarDesmarcarTodos').val();
        if (marcarDesmarcarTodos === 0) {
            $('#tablePermissao input[type=checkbox]').each(function () {
                $('#tablePermissao input[type=checkbox]').prop("checked", true);
            });
            $('#marcarDesmarcarTodos').val(1);
            //$("#btnMarcarDesmarcarTodos").html('Desmarcar Todos');
        } else {
            $('#tablePermissao input[type=checkbox]').each(function () {
                $('#tablePermissao input[type=checkbox]').prop("checked", false);
            });
            $('#marcarDesmarcarTodos').val(0);
            //$("#btnMarcarDesmarcarTodos").html('Marcar Todos');
        }
    }

    function voltar() {
        $(location).attr('href', 'usuarioFuncionalidadeFiltro.php');
    }

    function excluir() {
        var idUsuario = $("#usuario").val();

        if (idUsuario === "") {
            smartAlert("Atenção", "Selecione um usuário para excluir !", "error");
            return;
        }

        excTodasPermissoesUsuario(idUsuario);
    }


    function gravar() {

        var usuarioId = $('#usuario').val();

        if (usuarioId === "") {
            smartAlert("Atenção", "Informe o usuário !", "error");
            return;
        }

        var arrPermissoesMarcadas = [];
        $('#tablePermissao input[type=checkbox]:checked').each(function () {
            arrPermissoesMarcadas.push(parseInt($(this).val()));
        });

        var arrPermissoesDesmarcadas = [];
        $('#tablePermissao input[type=checkbox]:not(:checked)').each(function () {
            arrPermissoesDesmarcadas.push(parseInt($(this).val()));
        });

        if ((arrPermissoesMarcadas.length > 0) | (arrPermissoesDesmarcadas.length > 0)) {
            for (i = jsonFuncionalidadeArray.length - 1; i >= 0; i--) {
                var obj = jsonFuncionalidadeArray[i];
                if (jQuery.inArray(obj.idFuncionalidade, arrPermissoesMarcadas) > -1) {
                    jsonFuncionalidadeArray[i].marcado = 1;
                }
                if (jQuery.inArray(obj.idFuncionalidade, arrPermissoesDesmarcadas) > -1) {
                    jsonFuncionalidadeArray[i].marcado = 0;
                }
            }
        }

        var arrFuncionalidadeMarcada = jQuery.grep(jsonFuncionalidadeArray, function (item, i) {
            return (item.marcado === 1);
        });

        if (arrFuncionalidadeMarcada.length > 0) {
            $("#JsonFuncionalidadeMarcada").val(JSON.stringify(arrFuncionalidadeMarcada));
            var jsonFuncMarcadas = $('#JsonFuncionalidadeMarcada').val();

            gravaPermissoesUsuario(usuarioId, jsonFuncMarcadas);
        } else {
            smartAlert("Erro", "Selecione pelo menos uma funcionalidade permitida para o usuário.", "error");
        }

    }

    function novo() {
        $(location).attr('href', 'usuarioFuncionalidadeCadastro.php');
    }

</script>    


//<?php
//	//include footer
//	include("inc/google-analytics.php"); 
//?>