<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('USUARIO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('USUARIO_EXCLUIR', $arrayPermissao, true));

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

$page_title = "Usuário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["configuracao"]["sub"]["usuarios"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Configurações"] = "";
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
                            <h2>Usuário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuario" method="post">    
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
                                                            <section class="col col-1">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">&nbsp;</label>
                                                                <label id="labelAtivo" class="checkbox ">
                                                                    <input checked="checked" id="ativo" name="ativo" type="checkbox" value="true"><i></i>
                                                                    Ativo 
                                                                </label>                                                                                    
                                                            </section>                                                                                                                                            
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Login</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="login" maxlength="255" name="login" class="required" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Senha</label>
                                                                <label class="input">
                                                                    <input id="senha" maxlength="20" name="senha" type="password" class="required" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Confirma Senha</label>
                                                                <label class="input">
                                                                    <input id="senhaConfirma" maxlength="20" name="senhaConfirma" type="password" class="required" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4 col-auto">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, nome 
                                                                        FROM Ntl.funcionario 
                                                                        WHERE ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['nome'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Restaurar senha</label>
                                                                <label class="select">
                                                                    <select id="restaurarSenha" name="restaurarSenha">
                                                                        <option value="1" >Sim</option> 
                                                                        <option value="0">Não</option> 
                                                                    </select><i></i> 
                                                                </label> 
                                                            </section> 
                                                        </div>
                                                    </fieldset>
                                                </div>                                                        
                                            </div>
                                        </div>
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

<script src="<?php echo ASSETS_URL; ?>/js/businessUsuario.js" type="text/javascript"></script> 

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
    $(document).ready(function () {
        jQuery.validator.addMethod(
                "senhaRequerida",
                function (value, element, params) {
                    var senha = $("#senha").val();
                    var codigo = +$("#codigo").val();
                    var senhaConfirma = $("#senhaConfirma").val();

                    if (codigo === 0) {
                        if (senha === "") {
                            return false;
                        }
                    } else {
                        if ((senha === "") & (senhaConfirma !== "")) {
                            return false;
                        }
                    }

                    return true;
                }, ''
                );

        jQuery.validator.addMethod(
                "confirmaSenhaRequerida",
                function (value, element, params) {
                    var senha = $("#senha").val();
                    var senhaConfirma = $("#senhaConfirma").val();
                    var codigo = +$("#codigo").val();

                    if (codigo === 0) {
                        if (senhaConfirma === "") {
                            return false;
                        }
                    } else {
                        if ((senha !== "") & (senhaConfirma === "")) {
                            return false;
                        }
                    }

                    return true;
                }, ''
                );

        jQuery.validator.addMethod(
                "confirmaSenhaequalto",
                function (value, element, params) {
                    var senha = $("#senha").val();
                    var senhaConfirma = $("#senhaConfirma").val();

                    if ((senha !== "") | (senhaConfirma !== "")) {
                        if (senha !== senhaConfirma) {
                            return false;
                        }
                    }
                    return true;
                }, ''
                );

        $('#formUsuario').validate({
            // Rules for form validation
            rules: {
                'login': {
                    required: true,
                    maxlength: 35
                },
                'senha': {
                    senhaRequerida: true,
                    minlength: 7,
                    maxlength: 20
                },
                'senhaConfirma': {
                    confirmaSenhaRequerida: true,
                    confirmaSenhaequalto: true
                }
            },


            // Messages for form validation
            messages: {
                'login': {
                    required: 'Informe o Login.',
                    maxlength: 'Digite no máximo de 35 caracteres.',
                    minlength: 'Digite no mínimo 7 caracteres'
                },
                'senha': {
                    maxlength: 'Digite no máximo de 20 caracteres.',
                    minlength: 'Digite no mínimo 7 caracteres',
                    senharequerida: 'Informe a senha.'
                },
                'senhaConfirma': {
                    confirmacaosenharequerida: 'Informe a senha mais uma vez.',
                    confirmacaosenhaequalto: 'Informe a mesma senha digitada no campo senha.'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
                //$("#accordionCadastro").click();
                $("#accordionCadastro").removeClass("collapsed");
            },
            highlight: function (element) {
                //$(element).parent().addClass('error');
            },
            unhighlight: function (element) {
                //$(element).parent().removeClass('error');
            }
        });

        carregaPagina();

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

        $("#btnNovo").on("click", function () {
            novo();
        });

        $("#btnVoltar").on("click", function () {
            voltar();
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
                recuperaUsuario(idd);
            }
        }
        $("#nome").focus();

    }
    
    function novo() {
        $(location).attr('href', 'usuarioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'usuarioFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirUsuario(id);
    }

    function gravar() {
        var id = +($("#codigo").val());
        var ativo = 0;
        if ($("#ativo").is(':checked')) {
            ativo = 1;
        }
        var login = $("#login").val();
        var senha = $("#senha").val();
        var funcionario = $("#funcionario").val();
        var senhaConfirma = $("#senhaConfirma").val();
        var tipoUsuario = "C";
        var restaurarSenha = $("#restaurarSenha").val();
        if (login === "") {
            smartAlert("Atenção", "Informe o login !", "error");
            $("#login").focus();
            return;
        }

        if (/^[a-zA-Z]*$/.test(login) === false) {
            smartAlert("Atenção", "O login não pode conter caracteres acentuados, numéricos e especiais.", "error");
            $("#login").focus();
            return;
        }

        if (id === 0) {
            if (senha === "") {
                smartAlert("Atenção", "Informe a senha.", "error");
                $("#senha").focus();
                return;
            }

            if (/^[a-zA-Z0-9\!\#\$\&\*\-\+\?\.\;\,\:\]\[\(\)]*$/.test(senha) === false) {
                smartAlert("Atenção", "A senha não pode conter caracteres acentuados.", "error");
                $("#senha").focus();
                return;
            }

            if (senhaConfirma === "") {
                smartAlert("Atenção", "Informe a confirmação de senha.", "error");
                $("#senhaConfirma").focus();
                return;
            }

            if (senha !== senhaConfirma) {
                smartAlert("Atenção", "Informe a confirmação de senha igual a senha.", "error");
                $("#senhaConfirma").focus();
                return;
            }
        } else {
            if ((senha !== "") | (senhaConfirma !== "")) {
                if (senha !== senhaConfirma) {
                    smartAlert("Atenção", "Informe a confirmação de senha igual a senha.", "error");
                    $("#senhaConfirma").focus();
                    return;
                }
                if (/^[a-zA-Z0-9\!\#\$\&\*\-\+\?\.\;\,\:\]\[\(\)]*$/.test(senha) === false) {
                    smartAlert("Atenção", "A senha não pode conter caracteres acentuados.", "error");
                    $("#senha").focus();
                    return;
                }
            }
        }
        gravaUsuario(id, ativo, login, senha, senhaConfirma, tipoUsuario,funcionario,restaurarSenha);
    }
</script>

