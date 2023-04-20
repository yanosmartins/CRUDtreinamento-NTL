<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
//$condicaoAcessarOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
// $condicaoGravarOK = (in_array('USUARIO_GRAVAR', $arrayPermissao, true));
// $condicaoExcluirOK = (in_array('USUARIO_EXCLUIR', $arrayPermissao, true));

// if ($condicaoAcessarOK == false) {
//     unset($_SESSION['login']);
//     header("Location:login.php");
// }

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

// $esconderBtnExcluir = "";
// if ($condicaoExcluirOK === false) {
//     $esconderBtnExcluir = "none";
// }

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
//$page_nav["configuracao"]["sub"]["usuarios"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    $breadcrumbs["Configurações"] = "";
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
                            <h2>Funcionário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formUsuario" method="post">
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
                                                            <section id="condicaoCheck" class="col col-1 hidden">                                                             
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Nome do funcionário:</label>
                                                                <label class="input">
                                                                    <input id="nome" maxlength="255" name="nome" class="required" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CPF:</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="cpf" name="cpf" class="required cpf-mask" type="text" value="" placeholder="XXX.XXX.XXX-XX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">RG:</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="rg" name="rg" class="required rg-mask" type="text" value="" placeholder="XX.XXX.XXX-X">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Nascimento:</label>
                                                                <label class="input">
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" class="datepicker required" data-dateformat="dd/mm/yy" value="" placeholder="XX/XX/XXXX">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label">Idade:</label>
                                                                <label class="input">
                                                                    <input id="idade" name="idade" type="text" class="readonly">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="Sexo">Estado Civil</label>
                                                                <label class="select">
                                                                    <select id="estadoCivil" class="required" name="ativo">
                                                                        <option value="1" selected>Solteiro</option>
                                                                        <option value="2">Casado</option>
                                                                        <option value="3">Separado</option>
                                                                        <option value="4">Divorciado</option>
                                                                        <option value="5">Viúvo</option>
                                                                    </select><i></i>
                                                            </section>
                                                            <section class="col col-2 col-auto">
                                                                <label class="label">Gênero</label>
                                                                <label class="select">
                                                                    <select id="genero" class="required" name="genero">
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao 
                                                                        FROM dbo.generoFuncionario where generoAtivo = 1 ORDER BY codigo";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <!-- <section class="col col-2 ">
                                                                <label class="label">&nbsp;</label>
                                                                <label id="labelAtivo" class="checkbox ">
                                                                    <input checked="checked" id="ativo" name="ativo" type="checkbox" value="true"><i></i>
                                                                    Ativo
                                                                </label>
                                                            </section> -->
                                                        </div>
                                                        <!-- teste -->
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-body no-padding">
                                        <div class="panel-group smart-accordion-default" id="accordion">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="" id="accordionContato">
                                                            <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                            <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                            Contato
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseContato" class="panel-collapse collapse in">
                                                    <div class="panel-body no-padding">

                                                        <fieldset>
                                                            <input id="jsonTelefone" name="jsonTelefone" type="hidden" value="[]">
                                                            <div id="formTelefone" class="col-sm-6 required">
                                                                <input id="descricaoTelefonePrincipal" type="hidden" value="">
                                                                <input id="descricaoTelefoneWhatsApp" type="hidden" value="">
                                                                <input id="sequencialTelefone" type="hidden" value="">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <section class="col col-md-3">
                                                                            <label class="label">Telefone</label>
                                                                            <label class="input"><i class="icon-prepend fa fa-phone"></i>
                                                                                <input id="telefone" name="telefone" type="text" class="form-control" placeholder="(XX) XXXXX-XXXX" value="">
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-md-2">
                                                                            <label class="label">&nbsp;</label>
                                                                            <label class="checkbox">
                                                                                <input id="telefonePrincipal" name="telefonePrincipal" type="checkbox" value="true"><i></i>
                                                                                Principal
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-md-2">
                                                                            <label class="label">&nbsp;</label>
                                                                            <label class="checkbox ">
                                                                                <input id="telefoneWhatsApp" name="telefoneWhatsApp" type="checkbox" value="true"><i></i>
                                                                                WhatsApp
                                                                            </label>
                                                                        </section>

                                                                        <section class="col col-md-3">
                                                                            <label class="label">&nbsp;</label>
                                                                            <button id="btnAddTelefone" type="button" class="btn btn-primary">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                            <button id="btnRemoverTelefone" type="button" class="btn btn-danger">
                                                                                <i class="fa fa-minus"></i>
                                                                            </button>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableTelefone" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
                                                                                <th class="text-left" style="min-width: 500%;">Telefone</th>
                                                                                <th class="text-left">Principal</th>
                                                                                <th class="text-left">WhatsApp</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <input id="jsonEmail" name="jsonEmail" type="hidden" value="[]">
                                                            <div id="formEmail" class="col-sm-6">
                                                                <input id="EmailId" name="EmailId" type="hidden" value="">
                                                                <input id="descricaoEmailPrincipal" name="descricaoEmailPrincipal" type="hidden" value="">
                                                                <input id="sequencialEmail" name="sequencialEmail" type="hidden" value="">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <section class="col col-md-6">
                                                                            <label class="label">Email</label>
                                                                            <label class="input"><i class="icon-prepend fa fa-at"></i>
                                                                                <input id="Email" maxlength="50" name="Email" type="text" value="">
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-md-2">
                                                                            <label class="label">&nbsp;</label>
                                                                            <label class="checkbox ">
                                                                                <input id="EmailPrincipal" name="EmailPrincipal" type="checkbox" value="true" checked><i></i>
                                                                                Principal
                                                                            </label>
                                                                        </section>
                                                                        <section class="col col-auto">
                                                                            <label class="label">&nbsp;</label>
                                                                            <button id="btnAddEmail" type="button" class="btn btn-primary">
                                                                                <i class="fa fa-plus"></i>
                                                                            </button>
                                                                            <button id="btnRemoverEmail" type="button" class="btn btn-danger">
                                                                                <i class="fa fa-minus"></i>
                                                                            </button>
                                                                        </section>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive" style="min-height: 115px; width:95%; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                    <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th></th>
                                                                                <th class="text-left" style="min-width: 100px;">Email</th>
                                                                                <th class="text-left">Principal</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
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
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir">
                                            <span class="fa fa-trash"></span>
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
    </div>
</div>

<!-- end widget grid -->

<!-- </div> -->
<!-- END MAIN CONTENT -->

<!-- </div> -->
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

<script src="<?php echo ASSETS_URL; ?>/js/businessCadastroFuncionario.js" type="text/javascript"></script>

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
        //EVENTO CONSTANTE
        // $("#cpf").mask('999.999.999-99', {
        //     reverse: true
        // });


        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($("#jsonEmail").val());

        $("#cpf").mask('999.999.999-99');
        $("#rg").mask('99.999.999-9');
        $("#dataNascimento").mask('99/99/9999');
        $("#telefone").mask('(99) 99999-9999');
        // $("#Email").mask('AZaz@az.com');
        
        $("#dataNascimento").on("change", function() {
            let data = $("#dataNascimento").val()
            if (validaData(data) == false) {
                smartAlert("Atenção", "Data inválida ", "error");
                $("#idade").val("");
                document.getElementById('dataNascimento').value = '';
                $("#dataNascimento").focus();
                // disableButton();
            }
        });

        $("#cpf").on("change", function() {
            let data = $("#cpf").val()
            VerificaCPF()
            ValidaCPF()

        });

        $("#rg").on("change", function() {
            VerificaRG()
        });


        $("#btnAddTelefone").on("click", function() {
            if (validaTelefone())
                addTelefone();
        });
        $("#btnRemoverTelefone").on("click", function() {
            excluiTelefoneTabela();
        });
        $("#btnAddEmail").on("click", function() {
            if (validaEmail())
                addEmail();
        });
        $("#btnRemoverEmail").on("click", function() {
            excluiEmailTabela();
        });




        carregaPagina();
        carregaTelefone();
        carregaEmail();


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
        $("#btnNovo").on("click", function() {
            novo();
        });
        $("#btnGravar").on("click", function() {
            gravar();

        });
        $("#btnVoltar").on("click", function() {
            voltar();
        });
    });
    /////////////////////fim dos eventos



    function VerificaCPF() {
        var cpf = $("#cpf").val();
        cpfverificado(cpf);
        return;
    }

    function ValidaCPF() {
        var cpf = $("#cpf").val();
        cpfvalidado(cpf);
        return;
    }

    function VerificaRG() {
        var rg = $("#rg").val();
        RGverificado(rg);
        return;
    }

    function carregaTelefone(sequencialTelefone) {
        var arr = jQuery.grep(jsonTelefoneArray, function(item, i) {
            return (item.sequencialTelefone === sequencialTelefone);
        });
        if (arr.length > 0) {
            var item = arr[0];
            $("#telefone").val(item.telefone);
            $("#sequencialTelefone").val(item.sequencialTelefone);
            if (item.telefonePrincipal == true) {
                $("#telefonePrincipal").prop("checked", true);
            }
            if (item.telefoneWhatsApp == true) {
                $("#telefoneWhatsApp").prop("checked", true);
            }
        }
    }

    function carregaEmail(sequencialEmail) {
        var arr = jQuery.grep(jsonEmailArray, function(item, i) {
            return (item.sequencialEmail === sequencialEmail);
        });
        if (arr.length > 0) {
            var item = arr[0];
            $("#Email").val(item.Email);
            $("#sequencialEmail").val(item.sequencialEmail);
            if (item.EmailPrincipal == true) {
                $("#EmailPrincipal").prop("checked", true);
            }
        }
    }

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaUsuario(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {
                            return;
                        } else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayTelefone = piece[2];
                            var strArrayEmail = piece[3];
                            var strArrayDependente = piece[4];
                            piece = out.split("^");
                            // Atributos de vale transporte unitário que serão recuperados: 
                            var id = piece[0];
                            var ativo = piece[1];
                            var nome = piece[2];
                            var cpf = piece[3];
                            var rg = piece[4];
                            var dataNascimento = piece[5];
                            var estadoCivil = piece[6];
                            var genero = piece[7];
                            // var dataNascimento = piece[5];
                            //Associa as varíaveis recuperadas pelo javascript com seus respectivos campos html.
                            $("#codigo").val(id);
                            $("#ativo").val(ativo);
                            $("#nome").val(nome);
                            $("#cpf").val(cpf);
                            $("#rg").val(rg);
                            $("#estadoCivil").val(estadoCivil);
                            $("#dataNascimento").val(dataNascimento);
                            $("#genero").val(genero);
                            ///////////////////////////////////////////////////////////////////////////////
                            var dataagora = new Date()
                            var anoAtual = dataagora.getFullYear();
                            var dataNascimento = $("#dataNascimento").val();
                            var dataNascimento = dataNascimento.split("/")[2];
                            var idade = (anoAtual - dataNascimento);
                            $("#idade").val(idade);
                            return;
                        }
                    }

                );
            }
        }
        $("#nome").focus();
    }
    $("#nome").focus();

    function novo() {
        $(location).attr('href', 'cadastroFuncionario.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }
        excluirUsuario(id);
    }

    function voltar() {
        $(location).attr('href', 'funcionarioFiltro.php');
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function VerificaCPF() {
        var cpf = $("#cpf").val();
        cpfverificado(cpf);
        return;
    }

    function gravar() {
        var id = +($("#codigo").val());
        var ativo = 1;
        // if ($("#ativo").is(':checked')) {
        //     ativo = 1;
        // }
        var nome = $("#nome").val();
        var cpf = $("#cpf").val();
        var dataNascimento = $("#dataNascimento").val();
        var rg = $("#rg").val();
        var estadoCivil = $("#estadoCivil").val();
        var genero = $("#genero").val();
        var jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        var jsonEmailArray = JSON.parse($("#jsonEmail").val());


        if (cpf === "") {
            smartAlert("Atenção", "Informe o cpf !", "error");
            $("#cpf").focus();
            return;
        }
        // || (nome=="") || (dataNascimento=="")
        if (nome == "") {
            smartAlert("Atenção", "Informe o nome!", "error");
            $("#nome").focus();
            return;
        }
        if (dataNascimento == "") {
            smartAlert("Atenção", "Informe a data de nascimento!", "error");
            $("#dataNascimento").focus();
            return;
        }
        if (rg == "") {
            smartAlert("Atenção", "Informe o seu RG!", "error");
            $("#rg").focus();
            return;
        }
        if (estadoCivil == "") {
            smartAlert("Atenção", "Informe o seu Estado Civil!", "error");
            $("#estadoCivil").focus();
            return;
        }



        gravaFuncionario(id, ativo, cpf, nome, dataNascimento, rg, estadoCivil, genero, jsonTelefoneArray);
    }


    /////////////////////////////////

    function validaData(data) {
        var data = document.getElementById("dataNascimento").value; // pega o valor do input
        data = data.replace(/\//g, "-"); // substitui eventuais barras (ex. IE) "/" por hífen "-"
        var data_array = data.split("-"); // quebra a data em array

        // para o IE onde será inserido no formato dd/MM/yyyy
        if (data_array[0].length != 4) {
            data = data_array[2] + "-" + data_array[1] + "-" + data_array[0];
        }

        // compara as datas e calcula a idade
        var hoje = new Date();
        var nasc = new Date(data);
        var idade = hoje.getFullYear() - nasc.getFullYear();
        var m = hoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) idade--;

        if (idade < 14) {
            // alert("Pessoas menores de 14 não podem se cadastrar.");
            $("#idade").val(idade)
            $("#btnGravar").prop('disabled', false);
            return false;

        }

        if (idade >= 18 && idade <= 95) {
            // alert("Maior de 18, pode se cadastrar.");
            $("#idade").val(idade)
            $("#btnGravar").prop('disabled', false);
            return;
        }
        if (hoje)
            // se for maior que 60 não vai acontecer nada!
            return false;

    }

    function addTelefone() {
        var telefone = $("#telefone").val();
        if (telefone === "") {
            smartAlert("Atenção", "Informe o Telefone !", "error");
            $("#telefone").focus();
            return;
        }

        var item = $("#formTelefone").toObject({
            mode: 'combine',
            skipEmpty: false
        });

        item["sequencialTelefone"] = $("#sequencialTelefone").val();

        if (item["sequencialTelefone"] === '') {
            if (jsonTelefoneArray.length === 0) {
                item["sequencialTelefone"] = 1;
            } else {
                item["sequencialTelefone"] = Math.max.apply(Math, jsonTelefoneArray.map(function(o) {
                    return o.sequencialTelefone;
                })) + 1;
            }
            item["telefoneId"] = 0;
        } else {
            item["sequencialTelefone"] = +item["sequencialTelefone"];
        }

        var index = -1;
        $.each(jsonTelefoneArray, function(i, obj) {
            if (+$('#sequencialTelefone').val() === obj.sequencialTelefone) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTelefoneArray.splice(index, 1, item);
        else
            jsonTelefoneArray.push(item);

        $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));


        if (item["telefonePrincipal"]) {
            item["descricaoTelefonePrincipal"] = "Sim";
        } else {
            item["descricaoTelefonePrincipal"] = "Não";
        }
        if (item["telefoneWhatsApp"]) {
            item["descricaoTelefoneWhatsApp"] = "Sim";
        } else {
            item["descricaoTelefoneWhatsApp"] = "Não";
        }
        fillTableTelefone();
        clearFormTelefone();
    }

    function fillTableTelefone() {
        $("#tableTelefone tbody").empty();
        for (var i = 0; i < jsonTelefoneArray.length; i++) {
            var row = $('<tr />');

            $("#tableTelefone tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelefoneArray[i].sequencialTelefone + '"><i></i></label></td>'));

            if (jsonTelefoneArray[i].telefone != undefined) {
                clearFormTelefone();
                // <a href="cadastroFuncionario.php">' </a>
                row.append($('<td class="text-left" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTelefone + ');">' + jsonTelefoneArray[i].telefone + '</td>'));
                row.append($('<td class="text-left" >' + jsonTelefoneArray[i].descricaoTelefonePrincipal + '</td>'));
                row.append($('<td class="text-left" >' + jsonTelefoneArray[i].descricaoTelefoneWhatsApp + '</td>'));
            } else {
                row.append($('<td class="text-left" >' + jsonTelefoneArray[i].descricaoTelefoneWhatsApp + '</td>'));
                row.append($('<td class="text-left" >' + jsonTelefoneArray[i].descricaoTelefonePrincipal + '</td>'));
            }
        }

    }

    function clearFormTelefone() {
        $("#telefone").focus();
        $("#telefone").val('');
        $("#sequencialTelefone").val('');
        $("#telefonePrincipal").prop('checked', false);
        $("#telefoneWhatsApp").prop('checked', false);

    }

    function excluiTelefoneTabela() {
        var arrSequencial = [];
        // $('#tableTelefone input[type=checkbox]:checked').each(function() {
        $('#tableTelefone input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
                var obj = jsonTelefoneArray[i];
                if (jQuery.inArray(obj.sequencialTelefone, arrSequencial) > -1) {
                    jsonTelefoneArray.splice(i, 1);
                }
            }
            $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
            fillTableTelefone();
        } else
            smartAlert("Erro", "Selecione pelo menos um Projeto para excluir.", "error");
        clearFormTelefone();
    }

    function validaTelefone() {
        var achouTelefone = false;
        var achouTelefonePrincipal = false;
        var telefonePrincipal = '';

        if ($('#telefonePrincipal').is(':checked')) {
            telefonePrincipal = true;
        } else {
            telefonePrincipal = false;
        }

        var sequencial = +$('#sequencialTelefone').val();
        var telefone = $('#telefone').val();

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefonePrincipal == true) {
                if ((jsonTelefoneArray[i].telefonePrincipal == telefonePrincipal) && (jsonTelefoneArray[i].sequencialTelefone !== sequencial)) {
                    achouTelefonePrincipal = true;
                    break;
                }
            }
            if (telefone !== "") {
                if ((jsonTelefoneArray[i].telefone === telefone) && (jsonTelefoneArray[i].sequencialTelefone !== sequencial)) {
                    achouTelefonePrincipal = true;
                    break;
                }
            }
        }
        if (achouTelefone === true) {
            smartAlert("Erro", "Este número já está na lista.", "error");
            clearFormTelefone();
            return false;
        }
        if (achouTelefonePrincipal === true) {
            smartAlert("Erro", "Já existe um Telefone Principal na lista.", "error");
            clearFormTelefone();
            return false;
        }
        return true;
    }


    function addEmail() {
        var Email = $("#Email").val();
        if (Email === "") {
            smartAlert("Atenção", "Informe o Email !", "error");
            $("#Email").focus();
            return;
        }

        var item = $("#formEmail").toObject({
            mode: 'combine',
            skipEmpty: false
        });

        item["sequencialEmail"] = $("#sequencialEmail").val();

        if (item["sequencialEmail"] === '') {
            if (jsonEmailArray.length === 0) {
                item["sequencialEmail"] = 1;
            } else {
                item["sequencialEmail"] = Math.max.apply(Math, jsonEmailArray.map(function(o) {
                    return o.sequencialEmail;
                })) + 1;
            }
            item["EmailId"] = 0;
        } else {
            item["sequencialEmail"] = +item["sequencialEmail"];
        }

        var index = -1;
        $.each(jsonEmailArray, function(i, obj) {
            if (+$('#sequencialEmail').val() === obj.sequencialEmail) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonEmailArray.splice(index, 1, item);
        else
            jsonEmailArray.push(item);

        $("#jsonEmail").val(JSON.stringify(jsonEmailArray));


        if (item["EmailPrincipal"]) {
            item["descricaoEmailPrincipal"] = "Sim";
        } else {
            item["descricaoEmailPrincipal"] = "Não";
        }
        if (item["EmailWhatsApp"]) {
            item["descricaoEmailWhatsApp"] = "Sim";
        } else {
            item["descricaoEmailWhatsApp"] = "Não";
        }
        fillTableEmail();
        clearFormEmail();
    }
    function fillTableEmail() {
        $("#tableEmail tbody").empty();
        for (var i = 0; i < jsonEmailArray.length; i++) {
            var row = $('<tr />');

            $("#tableEmail tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEmailArray[i].sequencialEmail + '"><i></i></label></td>'));

            if (jsonEmailArray[i].Email != undefined) {
                clearFormEmail();
                // <a href="cadastroFuncionario.php">' </a>
                row.append($('<td class="text-left" onclick="carregaEmail(' + jsonEmailArray[i].sequencialEmail + ');">' + jsonEmailArray[i].Email + '</td>'));
                row.append($('<td class="text-left" >' + jsonEmailArray[i].descricaoEmailPrincipal + '</td>'));
            } else {
                row.append($('<td class="text-left" >' + jsonEmailArray[i].descricaoEmailPrincipal + '</td>'));
            }
        }
    }

    function clearFormEmail() {
        $("#Email").focus();
        $("#Email").val('');
        $("#sequencialEmail").val('');
        $("#EmailPrincipal").prop('checked', false);
    }

    function excluiEmailTabela() {
        var arrSequencial = [];
        $('#tableEmail input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonEmailArray.length - 1; i >= 0; i--) {
                var obj = jsonEmailArray[i];
                if (jQuery.inArray(obj.sequencialEmail, arrSequencial) > -1) {
                    jsonEmailArray.splice(i, 1);
                }
            }
            $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
            fillTableEmail();
        } else
            smartAlert("Erro", "Selecione pelo menos um Email para excluir.", "error");
        clearFormEmail();
    }

    function validaEmail() {
        var achouEmail = false;
        var achouEmailPrincipal = false;
        var EmailPrincipal = '';

        if ($('#EmailPrincipal').is(':checked')) {
            EmailPrincipal = true;
        } else {
            EmailPrincipal = false;
        }

        var sequencial = +$('#sequencialEmail').val();
        var Email = $('#Email').val();

        for (i = jsonEmailArray.length - 1; i >= 0; i--) {
            if (EmailPrincipal == true) {
                if ((jsonEmailArray[i].EmailPrincipal == EmailPrincipal) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                    achouEmailPrincipal = true;
                    break;
                }
            }
            if (Email !== "") {
                if ((jsonEmailArray[i].Email === Email) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
                    achouEmailPrincipal = true;
                    break;
                }
            }
        }
        if (achouEmail === true) {
            smartAlert("Erro", "Este número já está na lista.", "error");
            clearFormEmail();
            return false;
        }
        if (achouEmailPrincipal === true) {
            smartAlert("Erro", "Já existe um Email Principal na lista.", "error");
            clearFormEmail();
            return false;
        }
        return true;
    }
</script>