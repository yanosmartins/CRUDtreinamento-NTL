<?php
//initilize the page
require_once("inc/init.php");


//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

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
$page_nav["controle"]["sub"]["usuarios"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Controle de Permissão"] = "";
    include("inc/ribbon.php");
    ?>
    <div id="content">
        <div class=" row text-center" style="margin-bottom: 10px;">
            <h2 style="font-weight:bold;">Ponto Eletornico</h2>
            <h5>
                <?php
                setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese.utf-8');
                date_default_timezone_set('America/Sao_Paulo');
                echo utf8_encode(ucwords(strftime('%A, ', $var_DateTime->sec)));
                echo strftime('%d de %B de %Y.', strtotime('today'));
                ?>
            </h5>
            Horário de Brasília
            <?php
            $hora = date('H:i:s.');
            echo $hora
            ?>
        </div>
        <div class="primeirasessao">
            <div class="col-md-7 funcionario " style=" height: 170px; background-color:#3A3633; color: #c4c4c4;">
                <h3>Matricula: <span id="#"></span></h3>
                <h3>Funcionario: <span id="#">Fillipy José Pessoa Ferreira Monteiro</span></h3>
                <h3>Projeto: <span id="#">NTL - Nova Tecnologia</span></h3>
            </div>
            <div class="col-md-5 marcacao">
                <div class="col-xs-6">
                    <button type="button" class="btn  btn-block botaoentrada" style="height: 80px; background-color:#4F8D4A;">
                        <i class="fa fa-sign-in"></i><br>Entrada
                    </button>
                </div>
                <div class="col-xs-6">
                    <button type="button" class="btn  btn-block botaopausa" style=" background: #2386A6;border-radius: 5px; height:80px;color: white;font-size: 16px;font-weight: bold;">
                        <i class="fa fa-cutlery"></i><br> Inicio almoço
                    </button>
                </div>
                <div class="col-xs-6">
                    <button type="button" class="btn  btn-block botaoretornopausa" style="background: #FDD033;border-radius: 5px; height:80px; color: white; font-size: 16px; font-weight: bold; margin-top:10px;">
                        <i class="fa fa-cutlery"></i><br> Fim almoço
                    </button>
                </div>
                <div class=" col-xs-6">
                    <button type="button" class="btn  btn-block botaosaida" style="height: 80px;  margin-top:10px; background-color:#C32E2E;">
                        <i class="fa fa-sign-out"></i><br>Saida
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7" style="margin-top:30px">
                <p><i class="fa fa-address-book"></i> Ocorrências</p>
                <select class="form-control" id="#" style="height: 40px;">
                    <option>Ocorrencias</option>
                    <option>Home office</option>
                    <option>Atestado médico</option>
                </select>
            </div>
            <div class="col-md-5" style="margin-top: 30px;">
                <p><i class="fa fa-clock-o"></i> Atraso:</p>
                <input class="form-control text-center" id="#" style="height: 40px;" type="text" placeholder="00:20:36" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7" style="margin-top:30px">
                <p><i class="fa fa-address-book"></i> Calendario</p>
                <input class="datepicker form-control" data-dateformat="dd/mm/yy" data-mask="99/99/9999" placeholder="XX/XX/XXXX">
            </div>
            <div class="col-md-5" style="margin-top: 30px;">
                <p><i class="fa fa-clock-o"></i> Hora extra:</p>
                <input class="form-control text-center" id="#" style="height: 40px;" type="text" placeholder="00:20:36" readonly>
            </div>
        </div>

        <!-- end widget grid -->
    </div>
    <!-- end widget grid -->

</div>

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

<script src="<?php echo ASSETS_URL; ?>/js/businessCliente.js" type="text/javascript"></script>
<!-- <script src="<?php echo ASSETS_URL; ?>/js/girComum.php"></script> -->

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
    JsonEmailArray = JSON.parse($("#JsonEmail").val());
    jsonTelefoneArray = JSON.parse($("#JsonTelefone").val());
    jsonRedesSociaisArray = JSON.parse($("#JsonRedesSociais").val());

    $(document).ready(function() {
        fillTableEmails();
        fillTableTelefone();
        fillTableRedesSociais();
        carregaPagina();

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

        $("#btnRecuperar").on("click", function() {
            recuperar();
        });

        $("#btnExcluir").on("click", function() {
            excluir();
        });

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#btnGravar").on("click", function() {
            $("#btnGravar").prop('disabled', true);

            setTimeout(function() {
                $("#btnGravar").prop('disabled', false);
            }, 4000)
            let verificarEmail = false;

            if (JsonEmailArray.length < 1) {
                verificarEmail = true;
            }

            for (let e = 0; e < JsonEmailArray.length; e++) {
                if (JsonEmailArray[e].EmailsPrincipal == 1) {
                    verificarEmail = true;
                    break;
                }
            }

            if (verificarEmail == false) {
                smartAlert("Erro", "Selecione um email principal", "error");
                return false;
            }

            let verificarRedesSociais = false;

            if (jsonRedesSociaisArray.length < 1) {
                verificarRedesSociais = true;
            }

            for (let e = 0; e < jsonRedesSociaisArray.length; e++) {
                if (jsonRedesSociaisArray[e].redesSociaisPrincipal == 1) {
                    verificarRedesSociais = true;
                    break;
                }
            }

            if (verificarRedesSociais == false) {
                smartAlert("Erro", "Selecione uma rede social para principal", "error");
                return false;
            }

            let verificarTelefone = false;

            if (jsonTelefoneArray.length < 1) {
                verificarTelefone = true;
            }

            for (let e = 0; e < jsonTelefoneArray.length; e++) {
                if (jsonTelefoneArray[e].telefonePrincipal == 1) {
                    verificarTelefone = true;
                    break;
                }
            }

            if (verificarTelefone == false) {
                smartAlert("Erro", "Selecione um telefone para principal", "error");
                return false;
            }

            gravar();
        });
        // .one serve para impedir o duplo click
        $('#btnAddEmails').on("click", function() {
            if (validaEmails() === true) {
                addEmails();
            }
        });

        $('#btnRemoverEmails').on("click", function() {
            excluirEmails();
        });

        $('#btnAddTelefone').on("click", function() {
            if (validaTelefone() === true) {
                addTelefone();
            }
        });

        $('#btnRemoverTelefone').on("click", function() {
            excluirTelefone();
        });

        $('#btnAddRedesSociais').on("click", function() {
            if (validaRedesSociais() === true) {
                addRedesSociais();
            }
        });

        $('#btnRemoverRedesSociais').on("click", function() {
            excluirRedesSociais();
        });

        $("#cpf").on("change", function() {
            pesquisaCPF()
            validaCPF()
        });



        $("#dataNascimento").on("change", function() {

            var dataAtual = new Date();
            var dataNascimento = $("#dataNascimento").val();
            dataNascimento = dataNascimento.split("/");
            var idadetotal = dataAtual - dataNascimento
            dataNascimento = dataNascimento[2] + "/" + dataNascimento[1] + "/" + dataNascimento[0];
            var dataNascimento = new Date(dataNascimento);


            if (dataAtual < dataNascimento) {
                console.log(dataAtual > dataNascimento);
                smartAlert("Error", "A data informada é maior do que a data atual", "error");
                $('#dataNascimento').css({
                    'border-color': '#A94442'
                });
                $("#dataNascimento").val("");
                return;
            } else {
                $('#dataNascimento').css({
                    'border-color': '#CCC'
                });
            }
            var idade = calcularIdade(dataNascimento, dataAtual)
            $("#idade").val(`${idade.Anos}`)


        });

    });

    $("#dataAdmissao").on("change", function() {

        var data = new Date();

        dataNascimento = $("#dataNascimento").val();
        dataAdmissao = $("#dataAdmissao").val();
        var dataAtual = new Date();

        dataAdmissao = dataAdmissao.split("/");
        dataAdmissao = dataAdmissao[2] + "/" + dataAdmissao[1] + "/" + dataAdmissao[0];
        dataAdmissao = new Date(dataAdmissao);

        dataNascimento = dataNascimento.split("/");
        dataNascimento = dataNascimento[2] + "/" + dataNascimento[1] + "/" + dataNascimento[0];
        dataNascimento = new Date(dataNascimento);


        if (dataAdmissao <= dataNascimento) {
            smartAlert("Error", "Data de Admissão não pode ser menor ou igual que data de nascimento", "error");
            $('#dataAdmissao').css({
                'border-color': '#A94442'

            });
            $('#dataAdmissao').val("");
            return;
        } else {
            $('#dataAdmissao').css({
                'border-color': '#CCC'
            });
        }

        if (dataAdmissao > dataAtual) {
            smartAlert("Error", "Data de Admissão não pode ser maior do que a data atual", "error");
            $('#dataAdmissao').css({
                'border-color': '#A94442'

            });
            $('#dataAdmissao').val("");
            return;
        } else {
            $('#dataAdmissao').css({
                'border-color': '#CCC'
            });
        }
    });





    $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#logradouroResidencial").val("");
            $("#bairroResidencial").val("");
            $("#cidadeResidencial").val("");
            $("#ufResidencial").val("");
        }

        //Quando o campo cep perde o foco.
        $("#cepResidencial").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouroResidencial").val("...");
                    $("#bairroResidencial").val("...");
                    $("#cidadeResidencial").val("...");
                    $("#ufResidencial").val("...");


                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouroResidencial").val(dados.logradouro);
                            $("#bairroResidencial").val(dados.bairro);
                            $("#cidadeResidencial").val(dados.localidade);
                            $("#ufResidencial").val(dados.uf);

                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            smartAlert("Error", "Cep Residencial não encontrado", "error");

                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    smartAlert("Error", "Formato de Cep Comercial inválido", "error");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
    });


    $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#logradouroComercial").val("");
            $("#bairroComercial").val("");
            $("#cidadeComercial").val("");
            $("#ufComercial").val("");
        }

        //Quando o campo cep perde o foco.
        $("#cepComercial").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouroComercial").val("...");
                    $("#bairroComercial").val("...");
                    $("#cidadeComercial").val("...");
                    $("#ufComercial").val("...");


                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouroComercial").val(dados.logradouro);
                            $("#bairroComercial").val(dados.bairro);
                            $("#cidadeComercial").val(dados.localidade);
                            $("#ufComercial").val(dados.uf);

                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            smartAlert("Error", "Cep Comercial não encontrado", "error");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    smartAlert("Error", "Formato de Cep Comercial inválido", "error");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
    });






    function gravar() {
        var nome = $('#nome').val();

        if (nome === "") {
            smartAlert("Atenção", "informe o nome do usuario", "error");
            $('#nome').css({
                'border-color': '#A94442'
            });
            return;
        } else {
            $('#nome').css({
                'border-color': '#CCC'
            });
        }
        var cpf = $('#cpf').val();

        if (cpf === "") {
            smartAlert("Atenção", "informe o cpf do usuario", "error");
            $('#cpf').css({
                'border-color': '#A94442'
            });
            return;
        } else {
            $('#cpf').css({
                'border-color': '#CCC'
            });
        }


        let cliente = $('#formCliente').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        gravaCliente(cliente, function(data) {

            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                    return;
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error"); // <---  Reativa o botão de gravar
                    return;
                }
            } else {
                var piece = data.split("#");
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
        });
    }

    function recuperar() {
        $(location).attr('href', 'clienteFiltro.php');
    }

    function excluir() {

        // $("#btnExcuir").prop('disabled', true); // <---  Reativa o botão de gravar
        let cliente = $('#formCliente').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        excluirCliente(cliente, function(data) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                    // $("#btnExcuir").prop('disabled', false); // <---  Reativa o botão de gravar
                    return false;


                } else {
                    // smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
                    return false;
                }
            } else {
                var piece = data.split("#");
                // smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }

        });
    }

    function novo() {
        $(location).attr('href', 'clienteCadastro.php');

    }

    function voltar() {
        $(location).attr('href', 'clienteFiltro.php');
    }

    function carregaPagina() {

        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            id = idx[1];
            if (id) {
                recuperaCliente(id,
                    function(data) {



                        data = data.replace(/failed/g, '');
                        var piece = data.split("#");
                        console.table(piece)

                        //Atributos de Cliente
                        var mensagem = piece[0];
                        var out = piece[1];

                        var strArrayEmail = piece[2];
                        var strArrayTelefone = piece[3];
                        var strArrayRedesSociais = piece[4];
                        //recupera telefone  


                        piece = out.split("^");
                        console.table(piece);
                        //Atributos de cliente 

                        var codigo = +piece[0];

                        var nome = piece[1];
                        var cpf = piece[2];
                        var formatData = piece[3].substr(0, 10).split('-');
                        if (formatData != "") {
                            var dataNascimento = `${+formatData[2]}/${+formatData[1]}/${+formatData[0]}`;
                        }
                        var situacao = +piece[4];
                        var sexo = piece[5];
                        var obs = piece[6];
                        var logradouroComercial = piece[7];
                        var numeroComercial = piece[8];
                        var complementoComercial = piece[9];
                        var bairroComercial = piece[10];
                        var ufComercial = piece[11];
                        var cepComercial = piece[12];
                        var logradouroResidencial = piece[13];
                        var numeroResidencial = piece[14];
                        var complementoResidencial = piece[15];
                        var bairroResidencial = piece[16];
                        var ufResidencial = piece[17];
                        var cepResidencial = piece[18];
                        var formatdataAdmissao = piece[19].substr(0, 10).split('-');
                        if (formatdataAdmissao != "") {
                            var dataAdmissao = `${+formatdataAdmissao[2]}/${+formatdataAdmissao[1]}/${+formatdataAdmissao[0]}`;
                        }
                        var estadoCivil = piece[20];
                        var cargoFuncionario = piece[21];
                        var tempoContrato = piece[22];
                        var cidadeResidencial = piece[23];
                        var cidadeComercial = piece[24];



                        //Atributos de cliente        
                        $("#codigo").val(codigo);
                        $("#nome").val(nome);
                        $("#cpf").val(cpf);
                        $("#dataNascimento").val(dataNascimento);

                        if (situacao == 1) {
                            $('#cliente').prop("checked", true);
                        } else {
                            $('#prospect').prop("checked", true);
                        }

                        $("#situacao").val(situacao);
                        $("#sexo").val(sexo);
                        $("#obs").val(obs);
                        $("#logradouroComercial").val(logradouroComercial);
                        $("#numeroComercial").val(numeroComercial);
                        $("#complementoComercial").val(complementoComercial);
                        $("#bairroComercial").val(bairroComercial);
                        $("#ufComercial").val(ufComercial);
                        $("#cepComercial").val(cepComercial);
                        $("#logradouroResidencial").val(logradouroResidencial);
                        $("#numeroResidencial").val(numeroResidencial);
                        $("#complementoResidencial").val(complementoResidencial);
                        $("#bairroResidencial").val(bairroResidencial);
                        $("#ufResidencial").val(ufResidencial);
                        $("#cepResidencial").val(cepResidencial);
                        $("#dataAdmissao").val(dataAdmissao);
                        $("#JsonEmail").val(strArrayEmail);
                        $("#JsonTelefone").val(strArrayTelefone);
                        $("#JsonRedesSociais").val(strArrayRedesSociais);
                        JsonEmailArray = JSON.parse($("#JsonEmail").val());
                        fillTableEmails();

                        jsonTelefoneArray = JSON.parse($("#JsonTelefone").val());
                        fillTableTelefone();

                        jsonRedesSociaisArray = JSON.parse($("#JsonRedesSociais").val());
                        fillTableRedesSociais();

                        $("#estadoCivil").val(estadoCivil);
                        $("#cargoFuncionario").val(cargoFuncionario);
                        $("#tempoContrato").val(tempoContrato);
                        $("#cidadeResidencial").val(cidadeResidencial);
                        $("#cidadeComercial").val(cidadeComercial);

                        calcularIdade();
                    }


                );
            }
        }
    }

    function calcularIdade() {

        let dataNascimento = $("#dataNascimento").val();
        let formatDate = dataNascimento.split('/');

        dataNascimento = new Date("" + formatDate[2] + "-" + formatDate[1] + "-" + formatDate[0] + "");
        let data = new Date();
        let calcularAnos = parseInt(data.getFullYear() - dataNascimento.getFullYear());
        let calcularMeses = parseInt(data.getMonth() - dataNascimento.getMonth());

        if (calcularMeses < 0) {
            calcularAnos = calcularAnos - 1;
            calcularMeses = calcularMeses + 12;
        }

        let texto = calcularAnos;

        $("#idade").val(texto);

    }



    function clearFormEmails() {
        $("#Emails").val('');
        $("#EmailsId").val('');
        $("#sequencialEmails").val('');
        $('#EmailsPrincipal').val(0);
        $('#EmailsPrincipal').prop('checked', false);
    }


    function fillTableEmails() {
        $("#tableEmails tbody").empty();
        if (typeof(JsonEmailArray) != 'undefined') {
            for (var i = 0; i < JsonEmailArray.length; i++) {
                var row = $('<tr />');
                $("#tableEmails tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + JsonEmailArray[i].sequencialEmails + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaEmails(' + JsonEmailArray[i].sequencialEmails + ');">' + JsonEmailArray[i].Emails + '</td>'));

                if (JsonEmailArray[i].EmailsPrincipal == "1") {
                    row.append($('<td class="text-nowrap">Sim</td>'));
                } else {
                    row.append($('<td class="text-nowrap">Não</td>'));
                }


            }
            clearFormEmails();
        }


    }

    function validaEmails() {
        var existe = false;
        var achou = false;
        var tel = $('#Emails').val();


        var sequencial = parseInt($('#sequencialEmails').val());
        var EmailsPrincipalMarcado = 0;

        if ($("#EmailsPrincipal").is(':checked') === true) {
            EmailsPrincipalMarcado = 1;
        }
        if (!tel) {
            smartAlert("Erro", "Informe um email.", "error");
            return false;
        }

        if (tel.indexOf("@") < 0) {
            smartAlert("Erro", "Escreva um email valiido", "error")
            return false;
        }





        for (i = JsonEmailArray.length - 1; i >= 0; i--) {
            if (EmailsPrincipalMarcado === 1) {
                if ((JsonEmailArray[i].EmailsPrincipal == 1) && (JsonEmailArray[i].sequencialEmails !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((JsonEmailArray[i].Emails === tel) && (JsonEmailArray[i].sequencialEmails !== sequencial)) {
                    existe = true;
                    break;
                }
            }

        }
        if (existe === true) {
            smartAlert("Erro", "Email já cadastrado.", "error");
            return false;
        }
        if ((achou === true) && (EmailsPrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um Email principal na lista.", "error");
            return false;
        }


        return true;



    }


    function processDataEmails(node) {

        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';
        var value;

        if (fieldName !== '' && (fieldId === "Emails")) {
            var valorTel = $("#Emails").val().trim();
            if (valorTel !== '') {
                fieldName = "Emails";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }



        if (fieldName !== '' && (fieldId === "EmailsPrincipal")) {
            value = 0;
            if ($("#EmailsPrincipal").is(':checked') === true) {
                value = 1;
            }
            return {
                name: fieldName,
                value: value
            };
        }
        return false;
    }

    function addEmails() {
        var item = $("#FormEmails").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEmails
        });

        if (!item["sequencialEmails"]) {
            if (JsonEmailArray.length === 0) {
                item["sequencialEmails"] = 1;
            } else {
                item["sequencialEmails"] = Math.max.apply(Math, JsonEmailArray.map(function(o) {
                    return o.sequencialEmails;
                })) + 1;
            }
            item["EmailsId"] = 0;
        } else {
            item["sequencialEmails"] = +item["sequencialEmails"];
        }

        if (item["sequencialEmails"] > 3) {
            smartAlert("Erro", "numero maximo de email atingido", "Error")
            item["sequencialEmails"].val("");
        }



        var index = -1;
        $.each(JsonEmailArray, function(i, obj) {
            if (parseInt($('#sequencialEmails').val()) === obj.sequencialEmails) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            JsonEmailArray.splice(index, 1, item);
        else
            JsonEmailArray.push(item);

        $("#JsonEmail").val(JSON.stringify(JsonEmailArray));
        fillTableEmails();
        clearFormEmails();

    }

    function excluirEmails() {
        var arrSequencial = [];
        $('#tableEmails input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = JsonEmailArray.length - 1; i >= 0; i--) {
                var obj = JsonEmailArray[i];
                if (jQuery.inArray(obj.sequencialEmails, arrSequencial) > -1) {
                    JsonEmailArray.splice(i, 1);
                }
            }
            $("#JsonEmail").val(JSON.stringify(JsonEmailArray));
            fillTableEmails();
        } else
            smartAlert("Erro", "Selecione pelo menos um Email para excluir.", "error");
    }

    function carregaEmails(sequencialEmails) {
        var arr = jQuery.grep(JsonEmailArray, function(item, i) {
            return (item.sequencialEmails === sequencialEmails);
        });

        clearFormEmails();

        if (arr.length > 0) {
            var item = arr[0];
            $("#EmailsId").val(item.EmailsId);
            $("#Emails").val(item.Emails);
            $("#sequencialEmails").val(item.sequencialEmails);
            $("#EmailsPrincipal").val(item.EmailsPrincipal);
            if (item.EmailsPrincipal === 1) {
                $('#EmailsPrincipal').prop('checked', true);
            } else {
                $('#EmailsPrincipal').prop('checked', false);
            }
        }
    }


    function clearFormTelefone() {
        $("#Telefone").val('');
        $("#telefoneId").val('');
        $("#sequencialTelefone").val('');
        $('#telefonePrincipal').val(0);
        $('#telefonePrincipal').prop('checked', false);
    }

    function fillTableTelefone() {
        $("#tableTelefone tbody").empty();
        if (typeof(jsonTelefoneArray) != 'undefined') {
            for (var i = 0; i < jsonTelefoneArray.length; i++) {
                var row = $('<tr />');
                $("#tableTelefone tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelefoneArray[i].sequencialTelefone + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTelefone + ');">' + jsonTelefoneArray[i].Telefone + '</td>'));


                if (jsonTelefoneArray[i].telefonePrincipal == 1) {
                    row.append($('<td class="text-nowrap">Sim</td>'));

                } else {
                    row.append($('<td class="text-nowrap">Não</td>'));
                }

            }
            clearFormTelefone();
        }
    }

    function validaTelefone() {
        var existe = false;
        var achou = false;
        var tel = $('#Telefone').val();


        // if (!$('#telefone').val() && !$('#telefoneFixo').val()) {
        //     smartAlert("Erro", "Informe Somente UM telefone.", "error");
        //     clearFormTelefone();
        //     return false;
        // }

        var sequencial = parseInt($('#sequencialTelefone').val());
        var telefonePrincipalMarcado = 0;

        if ($("#telefonePrincipal").is(':checked') === true) {
            telefonePrincipalMarcado = 1;
        }
        if (!tel) {
            smartAlert("Erro", "Informe um telefone.", "error");
            return false;
        }
        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefonePrincipalMarcado === 1) {
                if ((jsonTelefoneArray[i].telefonePrincipal == 1) && (jsonTelefoneArray[i].sequencialTelefone !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonTelefoneArray[i].Telefone === tel) && (jsonTelefoneArray[i].sequencialTelefone !== sequencial)) {
                    existe = true;
                    break;
                }
            }

        }
        if (existe === true) {
            smartAlert("Erro", "Telefone já cadastrado.", "error");
            return false;
        }
        if ((achou === true) && (telefonePrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe um Telefone principal na lista.", "error");
            return false;
        }
        return true;
    }

    function processDataTelefone(node) {

        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';
        var value;

        if (fieldName !== '' && (fieldId === "Telefone")) {
            var valorTel = $("#Telefone").val().trim();
            if (valorTel !== '') {
                fieldName = "Telefone";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }



        if (fieldName !== '' && (fieldId === "telefonePrincipal")) {
            value = 0;
            if ($("#telefonePrincipal").is(':checked') === true) {
                value = 1;
            }
            return {
                name: fieldName,
                value: value
            };
        }
        return false;
    }

    function addTelefone() {
        var item = $("#formTelefone").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataTelefone
        });

        $("#telefone").mask("(99) 99999-999?9", {
            placeholder: 'X'
        });

        if (!item["sequencialTelefone"]) {
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

        if (item["sequencialTelefone"] > 3) {
            smartAlert("Erro", "numero maximo de Telefone atingido", "Error")
            item["sequencialTelefone"].val("");
        }


        var index = -1;
        $.each(jsonTelefoneArray, function(i, obj) {
            if (parseInt($('#sequencialTelefone').val()) === obj.sequencialTelefone) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTelefoneArray.splice(index, 1, item);
        else
            jsonTelefoneArray.push(item);

        $("#JsonTelefone").val(JSON.stringify(jsonTelefoneArray));
        fillTableTelefone();
        clearFormTelefone();
    }

    function excluirTelefone() {
        var arrSequencial = [];
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
            $("#JsonTelefone").val(JSON.stringify(jsonTelefoneArray));
            fillTableTelefone();
        } else
            smartAlert("Erro", "Selecione pelo menos um Telefone para excluir.", "error");
    }

    function carregaTelefone(sequencialTelefone) {
        var arr = jQuery.grep(jsonTelefoneArray, function(item, i) {
            return (item.sequencialTelefone === sequencialTelefone);
        });

        clearFormTelefone();

        if (arr.length > 0) {
            var item = arr[0];
            $("#telefoneId").val(item.telefoneId);
            $("#Telefone").val(item.Telefone);
            $("#sequencialTelefone").val(item.sequencialTelefone);
            $("#telefonePrincipal").val(item.telefonePrincipal);
            if (item.telefonePrincipal === 1) {
                $('#telefonePrincipal').prop('checked', true);
            } else {
                $('#telefonePrincipal').prop('checked', false);
            }
        }
    }

    function clearFormRedesSociais() {
        $("#redesSociais").val('');
        $("#redesSociaisId").val('');
        $("#sequencialRedesSociais").val('');
        $('#redesSociaisPrincipal').val(0);
        $('#redesSociaisPrincipal').prop('checked', false);
    }

    function fillTableRedesSociais() {
        $("#tableRedesSociais tbody").empty();
        if (typeof(jsonRedesSociaisArray) != 'undefined') {
            for (var i = 0; i < jsonRedesSociaisArray.length; i++) {
                var row = $('<tr />');
                $("#tableRedesSociais tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonRedesSociaisArray[i].sequencialRedesSociais + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaRedesSociais(' + jsonRedesSociaisArray[i].sequencialRedesSociais + ');">' + jsonRedesSociaisArray[i].redesSociais + '</td>'));

                if (jsonRedesSociaisArray[i].redesSociaisPrincipal == 1)
                    row.append($('<td class="text-nowrap">Sim</td>'));
                else if (jsonRedesSociaisArray[i].redesSociaisPrincipal == 0)
                    row.append($('<td class="text-nowrap">Não</td>'));

            }
            clearFormRedesSociais();
        }
    }

    function validaRedesSociais() {
        var existe = false;
        var achou = false;
        var tel = $('#redesSociais').val();


        // if (!$('#telefone').val() && !$('#telefoneFixo').val()) {
        //     smartAlert("Erro", "Informe Somente UM telefone.", "error");
        //     clearFormTelefone();
        //     return false;
        // }

        var sequencial = parseInt($('#sequencialRedesSociais').val());
        var redesSociaisPrincipalMarcado = 0;

        if ($("#redesSociaisPrincipal").is(':checked') === true) {
            redesSociaisPrincipalMarcado = 1;
        }
        if (!tel) {
            smartAlert("Erro", "Informe a Rede Social.", "error");
            return false;
        }
        for (i = jsonRedesSociaisArray.length - 1; i >= 0; i--) {
            if (redesSociaisPrincipalMarcado === 1) {
                if ((jsonRedesSociaisArray[i].redesSociaisPrincipal == 1) && (jsonRedesSociaisArray[i].sequencialRedesSociais !== sequencial)) {
                    achou = true;
                    break;
                }
            }
            if (tel !== "") {
                if ((jsonRedesSociaisArray[i].redesSociais === tel) && (jsonRedesSociaisArray[i].sequencialRedesSociais !== sequencial)) {
                    existe = true;
                    break;
                }
            }

        }
        if (existe === true) {
            smartAlert("Erro", "Rede Social já cadastrado.", "error");
            return false;
        }
        if ((achou === true) && (redesSociaisPrincipalMarcado === 1)) {
            smartAlert("Erro", "Já existe uma Rede Social principal na lista.", "error");
            return false;
        }
        return true;
    }

    function processDataRedesSociais(node) {

        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';
        var value;

        if (fieldName !== '' && (fieldId === "redesSociais")) {
            var valorTel = $("#redesSociais").val().trim();
            if (valorTel !== '') {
                fieldName = "redesSociais";
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }



        if (fieldName !== '' && (fieldId === "redesSociaisPrincipal")) {
            value = 0;
            if ($("#redesSociaisPrincipal").is(':checked') === true) {
                value = 1;
            }
            return {
                name: fieldName,
                value: value
            };
        }
        return false;
    }

    function addRedesSociais() {
        var item = $("#formRedesSociais").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataRedesSociais
        });

        if (!item["sequencialRedesSociais"]) {
            if (jsonRedesSociaisArray.length === 0) {
                item["sequencialRedesSociais"] = 1;
            } else {
                item["sequencialRedesSociais"] = Math.max.apply(Math, jsonRedesSociaisArray.map(function(o) {
                    return o.sequencialRedesSociais;
                })) + 1;
            }
            item["redesSociaisId"] = 0;
        } else {
            item["sequencialRedesSociais"] = +item["sequencialRedesSociais"];
        }

        if (item["sequencialRedesSociais"] > 3) {
            smartAlert("Erro", "numero maximo de Redes Sociais atingido", "Error")
            item["sequencialRedesSociais"].val("");
        }



        var index = -1;
        $.each(jsonRedesSociaisArray, function(i, obj) {
            if (parseInt($('#sequencialRedesSociais').val()) === obj.sequencialRedesSociais) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonRedesSociaisArray.splice(index, 1, item);
        else
            jsonRedesSociaisArray.push(item);

        $("#JsonRedesSociais").val(JSON.stringify(jsonRedesSociaisArray));
        fillTableRedesSociais();
        clearFormRedesSociais();
    }

    function excluirRedesSociais() {
        var arrSequencial = [];
        $('#tableRedesSociais input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonRedesSociaisArray.length - 1; i >= 0; i--) {
                var obj = jsonRedesSociaisArray[i];
                if (jQuery.inArray(obj.sequencialRedesSociais, arrSequencial) > -1) {
                    jsonRedesSociaisArray.splice(i, 1);
                }
            }
            $("#JsonRedesSociais").val(JSON.stringify(jsonRedesSociaisArray));
            fillTableRedesSociais();
        } else
            smartAlert("Erro", "Selecione pelo menos uma Rede Social para excluir.", "error");
    }

    function carregaRedesSociais(sequencialRedesSociais) {
        var arr = jQuery.grep(jsonRedesSociaisArray, function(item, i) {
            return (item.sequencialRedesSociais === sequencialRedesSociais);
        });

        clearFormRedesSociais();

        if (arr.length > 0) {
            var item = arr[0];
            $("#redesSociaisId").val(item.redesSociaisId);
            $("#redesSociais").val(item.redesSociais);
            $("#sequencialRedesSociais").val(item.sequencialRedesSociais);
            $("#redesSociaisPrincipal").val(item.redesSociaisPrincipal);
            if (item.redesSociaisPrincipal === 1) {
                $('#redesSociaisPrincipal').prop('checked', true);
            } else {
                $('#redesSociaisPrincipal').prop('checked', false);
            }
        }
    }

    function pesquisaCPF() {
        let codigo = $("#codigo").val();
        let cpf = $("#cpf").val();

        $.ajax({
            url: "js/sqlscopeCliente.php", //caminho do arquivo a ser executado
            dataType: "html", //tipo do retorno
            type: "post", //metodo de envio
            data: {
                funcao: "consultaCPF",
                codigo: codigo,
                cpf: cpf
            },
            success: function(data) {
                if (data.indexOf("success") < 0) {
                    var piece = data.split("#");
                    var mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                        $("#cpf").val("");
                    }
                }
            }
        })
    }


    function validaCPF() {
        var val = $("#cpf").val();
        var retorno = validacao_cpf(val);
        var funcao = 'verificaCpf';

        if (retorno === false) {
            smartAlert("Atenção", "O cpf digitado é inválido.", "error");
            $("#cpf").val("");
            return;
        }

        if (cpf.length == !11 ||
            cpf === "00000000000" ||
            cpf === "11111111111" ||
            cpf === "22222222222" ||
            cpf === "33333333333" ||
            cpf === "44444444444" ||
            cpf === "55555555555" ||
            cpf === "66666666666" ||
            cpf === "77777777777" ||
            cpf === "88888888888" ||
            cpf === "99999999999") {
            $("#cpf").val("");
            return smartAlert("Error", "Digite um CPF válido!", "error");
        }
        $.ajax({
            method: 'POST',
            url: 'js/sqlscope.php',
            data: {
                funcao,
                val
            },
            success: function(data) {
                var status = data.split('#');
                if (status[0] == 'failed') {
                    smartAlert("Atenção", "O cpf digitado já existe.", "error");
                    $("#cpf").val("");
                    return;
                }
            }
        });
    }
</script>