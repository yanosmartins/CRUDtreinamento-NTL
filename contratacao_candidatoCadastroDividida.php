<?php
//initilize the page
require_once("inc/init.php");
include("js/repositorio.php");
include("populaTabela/popula.php");

// require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

// colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('CANDIDATO_ACESSAR', $arrayPermissao, true)) || $tipoUsuario == 'T';
$condicaoGravarOK = (in_array('CANDIDATO_GRAVAR', $arrayPermissao, true) || in_array('TRIAGEM_GRAVAR', $arrayPermissao, true));
$condicaoTriagemAcessarOK = (in_array('TRIAGEM_ACESSAR', $arrayPermissao, true));

//REMOVER DEPOIS
$condicaoAcessarOK = true;
$condicaoTriagemAcessarOK = true;

if ($condicaoAcessarOK == false && $condicaoTriagemAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
} else if ($condicaoAcessarOK == true && $condicaoTriagemAcessarOK == false) {
    $esconderCandidato = "none";
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}

$sql = "SELECT * FROM Ntl.parametro";
$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$row = $result[0];
if ($row) {
    
    $linkUpload = $row['linkUpload'];
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Formulário NTL";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav['operacao']['sub']['contratacao']['sub']["candidato"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Recursos Humanos"] = "";
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
                            <h2>Formulário NTL</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form class="smart-form client-form" id="formFuncionario" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados Pessoais
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <input id="codigo" name="codigo" type="hidden">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <strong>ATENÇÃO: </strong> <br><br>
                                                                <strong>• O preenchimento incorreto e/ou incompleto das informações constantes no formulário, pode inviabilizar a sua contratação. Preencha com o máximo de atenção e faça a conferência antes de enviar<br>
                                                                    • Os itens em AMARELO são de preenchimento obrigatório;<br>
                                                                    • Conforme Portaria SEPRT Nº 1065 DE 23/09/2019, para os empregadores que têm a obrigação de uso do Sistema de Escrituração Digital das Obrigações Fiscais, Previdenciárias e Trabalhistas (E-Social),<br>
                                                                      a comunicação pelo trabalhador do número de inscrição no CPF ao empregador equivale à apresentação da Carteira de Trabalho e Previdência Social (CTPS) em meio digital, dispensando o empregador <br>
                                                                      da emissão de recibo e o trabalhador da apresentação da CTPS em meio físico;<br>
                                                                    • Os registros eletrônicos gerados pelo empregador nos sistemas informatizados da Carteira de Trabalho em meio digital equivalem às anotações a que se refere o Decreto-Lei nº 5.452/1943;<br>
                                                                    • O trabalhador deverá ter acesso às informações de seu contrato de trabalho na Carteira de Trabalho Digital após o processamento das respectivas anotações pelo sistema do E-social.<br>
                                                                    <p style="color:red"> • Após o cadastro,você poderá retornar para adicionar dados pendentes, o login deverá ser feito com seu email usado no primeiro cadastro como usuario e o CPF com a pontuação completa como senha. <br>
                                                                           Exemplo LOGIN: seuEmail@gmail.com SENHA: 999.999.999-99</p>
                                                                </strong> <br>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Dados Pessoais</strong></legend>
                                                            </section>

                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaDadoPessoal" id="verificaDadoPessoal" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Nome Completo</label>
                                                                <label class="input"><i></i>
                                                                    <input id="nomeCompleto" maxlength="255" name="nomeCompleto" class="required" autocomplete="new-password" type="text" value="" onchange="verificaNome('#nomeCompleto')">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Data Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" data-dateformat="dd/mm/yy" class="datepicker required" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataNascimento')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Sexo</label>
                                                                <label class="select">
                                                                    <select name="sexo" id="sexo" autocomplete="off" class="form-control required" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="0">Feminino</option>
                                                                        <option value="1">Masculino</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Nº do País</label>
                                                                <label class="input">
                                                                    <input id="numeroPais" name="numeroPais" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">País de Nascimento</label>
                                                                <label class="select">
                                                                    <select name="paisNascimento" id="paisNascimento" autocomplete="off" class="form-control required" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="105">Brasil</option>
                                                                        <option value="106">Fretado p/ Brasil</option>
                                                                        <option value="108">Brunei</option>
                                                                        <option value="111">Bulgária, República da</option>
                                                                        <option value="115">Burundi</option>
                                                                        <option value="119">Butão</option>
                                                                        <option value="127">Cabo Verde, República de</option>
                                                                        <option value="131">Cachemira</option>
                                                                        <option value="137">Cayman, Ilhas</option>
                                                                        <option value="141">Camboja</option>
                                                                        <option value="145">Camarões</option>
                                                                        <option value="149">Canadá</option>
                                                                        <option value="150">Jersey, Ilha do Canal</option>
                                                                        <option value="151">Canárias, Ilhas</option>
                                                                        <option value="152">Canal, Ilhas</option>
                                                                        <option value="153">Cazaquistão, República do</option>
                                                                        <option value="154">Catar</option>
                                                                        <option value="158">Chile</option>
                                                                        <option value="160">China, República Popular</option>
                                                                        <option value="161">Formosa (Taiwan)</option>
                                                                        <option value="163">Chipre</option>
                                                                        <option value="165">Cocos-Keeling, Ilhas</option>
                                                                        <option value="169">Colômbia</option>
                                                                        <option value="173">Comores, Ilhas</option>
                                                                        <option value="177">Congo</option>
                                                                        <option value="183">Cook, Ilhas</option>
                                                                        <option value="187">Coréia, República Popular Democrática</option>
                                                                        <option value="190">Coréia, República da</option>
                                                                        <option value="193">Costa do Marfim</option>
                                                                        <option value="195">Croácia, República da</option>
                                                                        <option value="196">Costa Rica</option>
                                                                        <option value="198">Coveite (kuwait)</option>
                                                                        <option value="199">Cuba</option>
                                                                        <option value="200">Curacao</option>
                                                                        <option value="229">Benin</option>
                                                                        <option value="229">Dinamarca</option>
                                                                        <option value="229">Dinamarca, Ilha</option>
                                                                        <option value="237">Dubai</option>
                                                                        <option value="239">Equador</option>
                                                                        <option value="240">Egito</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">UF de Nascimento</label>
                                                                <label class="select">
                                                                    <select name="ufNascimento" id="ufNascimento" autocomplete="off" class="form-control required" autocomplete="new-password">
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Nº da Cidade</label>
                                                                <label class="input">
                                                                    <input id="numeroMunicipio" name="numeroMunicipio" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Cidade de Nascimento</label>
                                                                <label class="select">
                                                                    <select name="municipioNascimento" id="municipioNascimento" autocomplete="off" class="form-control required" autocomplete="new-password">
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Naturalidade</label>
                                                                <label class="input">
                                                                    <input id="naturalidade" name="naturalidade" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Nacionalidade</label>
                                                                <label class="input">
                                                                    <input id="nacionalidade" name="nacionalidade" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Raça / Cor</label>
                                                                <label class="select">
                                                                    <select name="racaCor" id="racaCor" autocomplete="off" class="form-control required" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="0">Amarela</option>
                                                                        <option value="1">Branca</option>
                                                                        <option value="2">Parda</option>
                                                                        <option value="3">Indígena</option>
                                                                        <option value="4">Negro</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Estado Civíl</label>
                                                                <label class="select">
                                                                    <select name="estadoCivil" id="estadoCivil" autocomplete="off" class="form-control required" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="0">Solteiro</option>
                                                                        <option value="1">Casado</option>
                                                                        <option value="2">Separado Judicialmente</option>
                                                                        <option value="3">Divorciado</option>
                                                                        <option value="4">Viúvo</option>
                                                                        <option value="5">União Estável</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Nome do Pai</label>
                                                                <label class="input">
                                                                    <input id="nomePai" maxlength="64" name="nomePai" type="text" autocomplete="new-password" class="required" value="" onchange="verificaNome('#nomePai')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Nome da Mãe</label>
                                                                <label class="input">
                                                                    <input id="nomeMae" maxlength="64" name="nomeMae" type="text" autocomplete="new-password" class="required" value="" onchange="verificaNome('#nomeMae')">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Anexar Documentos</strong> </legend>
                                                            </section>

                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaAnexoDocumento" id="verificaAnexoDocumento" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <strong>ATENÇÃO: <br><br>
                                                                    • Em caso de mais de um documento conter o mesmo dado que o outro é necessario enviar somente um deles. Exemplo quem possuir CPF no RG Enviar somente a foto do RG. <br>
                                                                    • Em caso de mais de um documento do mesmo tipo, favor digitalizar em arquivo único. <br>
                                                                    • A digitalização dos documentos deve estar legível e de boa qualidade, pois pode inviabilizar a contratação
                                                                    <p style="color:red"> • RECOMENDAMOS o uso do aplicativo CamScanner para digitalizar todos os documentos. Você pode fazer download nos links abaixo: <br>
                                                                        <a href="https://play.google.com/store/apps/details?id=com.intsig.camscanner&hl=pt_BR">   - Play Store (android) </a> <br>
                                                                        <a href="https://apps.apple.com/br/app/camscanner-documento-scan/id388627783">   - Apple Store (iPhone) </a> <br>
                                                                          Caso o arquivo que você tente enviar fique muito grande mesmo com o CamScanner recomendamos que tire um print do seu celular ou computador do documento e envie o mesmo se estiver legivel; <br>
                                                                          Por questões de segurança temos um tamanho máximo para cada campo por isso evite mandar fotos em alta resolução e de preferencia para prints ou arquivos PDF em PRETO E BRANCO.<br>
                                                                    </p>
                                                                </strong>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos pessoais</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Foto</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="fotoCandidato" name="fotoCandidato[]" multiple>Selecionar
                                                                        documentos</span><input id="fotoCandidatoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="fotoCandidatoLink" class="col col-4">

                                                            </section>
                                                        </div>
                                                        <!-- CERTIDÃO DE NASCIMENTO -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Certidão de Nascimento</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="certidaoNascimento" name="certidaoNascimento[]" multiple>Selecionar
                                                                        documentos</span><input id="certidaoNascimentoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="certidaoNascimentoLink" class="col col-4">
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- DadosContato -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDadosContato" class="collapsed" id="accordionDadosContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dados Para Contato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDadosContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Dados Contato</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaDadoContato" id="verificaDadoContato" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Telefone Residêncial</label>
                                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                                    <input id="telefoneResidencial" maxlength="64" name="telefoneResidencial" type="text" autocomplete="new-password" data-mask-placeholder="X" data-mask="(99) 9999-9999" class="" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Telefone Celular</label>
                                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                                    <input id="telefoneCelular" maxlength="64" name="telefoneCelular" type="text" autocomplete="new-password" class="" value="" data-mask="(99) 99999-9999">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Celular Recado</label>
                                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                                    <input id="outroTelefone" maxlength="64" name="outroTelefone" type="text" autocomplete="new-password" class="" value="" data-mask="(99) 99999-9999">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">E-mail</label>
                                                                <label class="input"><i class="icon-append fa fa-envelope"></i>
                                                                    <input id="email" maxlength="64" name="email" type="text" autocomplete="new-password" class="required" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Endereco -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco" class="collapsed" id="accordionEndereco">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Endereço
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEndereco" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Endereço</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaEndereco" id="verificaEndereco" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="cep">CEP</label>
                                                                <label class="input">
                                                                    <input placeholder="XXXXX-XXX" id="cep" name="cep" class="required" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="cep">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" autocomplete="new-password" class="required">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Endereço</label>
                                                                <label class="input">
                                                                    <input id="endereco" maxlength="64" name="endereco" type="text" autocomplete="new-password" class="required" value="" onchange="verificaNome('#endereco')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input id="bairro" maxlength="64" name="bairro" type="text" autocomplete="new-password" class="required" value="" onchange="verificaNome('#bairro')">
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label" for="estado">Estado</label>
                                                                <label class="select">
                                                                    <select id="estado" name="estado">
                                                                        <?php
                                                                        echo populaUf();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input id="cidade" maxlength="64" name="cidade" type="text" autocomplete="new-password" class="required" value="" onchange="verificaNome('#cidade')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Numero</label>
                                                                <label class="input">
                                                                    <input id="numero" maxlength="10" name="numero" type="text" autocomplete="new-password" class="required" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input id="complemento" maxlength="64" name="complemento" type="text" autocomplete="new-password" class="" value="">
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Anexar Documentos</strong> </legend>
                                                            </section>
                                                        </div>

                                                        <!-- COMPROVANTE DE RESIDÊNCIA -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Comprovante de Residência</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="comprovanteResidenciaArquivo" name="comprovanteResidenciaArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="comprovanteResidenciaText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="comprovanteResidenciaArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>


                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Documentos -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDocumento" class="collapsed" id="accordionDocumento">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Documentos
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDocumento" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaDocumento" id="verificaDocumento" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" data-mask-placeholder="X" data-mask="999.999.999-99" name="cpf" type="text" class="required" autocomplete="off" onchange="verificaCpf('#cpf')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Primeiro Emprego</label>
                                                                <label class="select">
                                                                    <select name="primeiroEmprego" id="primeiroEmprego" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="0">Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Possui PIS</label>
                                                                <label class="select">
                                                                    <select name="ctps" id="ctps" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="0">Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">PIS</label>
                                                                <label class="input">
                                                                    <input id="pis" data-mask-placeholder="X" data-mask="999.99999.99-9" name="pis" type="text" class="required" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Carteira de Trabalho</label>
                                                                <label class="input">
                                                                    <input id="carteiraTrabalho" name="carteiraTrabalho" type="text" class="required" autocomplete="off" maxlength="10">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Serie</label>
                                                                <label class="input">
                                                                    <input id="carteiraTrabalhoSerie" name="carteiraTrabalhoSerie" type="text" class="required" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Expedição</label>
                                                                <label class="input">
                                                                    <input id="dataExpedicaoCarteiraTrabalho" name="dataExpedicaoCarteiraTrabalho" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataExpedicaoCarteiraTrabalho')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="estado">UF Emissão CTPS</label>
                                                                <label class="select">
                                                                    <select id="localCarteiraTrabalho" name="localCarteiraTrabalho">
                                                                        <?php
                                                                        echo populaUf();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">RG</label>
                                                                <label class="input">
                                                                    <input id="rg" name="rg" type="text" class="required" autocomplete="off" maxlength="13">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Orgão Emissor RG</label>
                                                                <label class="input">
                                                                    <input id="emissorRg" name="emissorRg" maxlength="25" type="text" class="required" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="estado">UF RG</label>
                                                                <label class="select">
                                                                    <select id="localRg" name="localRg">
                                                                        <?php
                                                                        echo populaUf();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Emissão RG</label>
                                                                <label class="input">
                                                                    <input id="dataEmissaoRg" name="dataEmissaoRg" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataEmissaoRg')">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">CNH</label>
                                                                <label class="input">
                                                                    <input id="cnh" name="cnh" type="text" data-mask="99999999999" class="" autocomplete="off">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Categoria CNH</label>
                                                                <label class="select">
                                                                    <select name="categoriaCnh" id="categoriaCnh" autocomplete="new-password" class="form-control">
                                                                        <option></option>
                                                                        <option value="0">Categoria A</option>
                                                                        <option value="1">Categoria B</option>
                                                                        <option value="2">Categoria C</option>
                                                                        <option value="3">Categoria E</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label" for="estado">UF CNH</label>
                                                                <label class="select">
                                                                    <select id="ufCnh" name="ufCnh">
                                                                        <?php
                                                                        echo populaUf();
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Emissão CNH</label>
                                                                <label class="input">
                                                                    <input id="dataEmissaoCnh" name="dataEmissaoCnh" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataEmissaoCnh')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Vencimento CNH</label>
                                                                <label class="input">
                                                                    <input id="dataVencimentoCnh" name="dataVencimentoCnh" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataVencimentoCnh')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Primeira CNH</label>
                                                                <label class="input">
                                                                    <input id="primeiraCnh" name="primeiraCnh" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#primeiraCnh')">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Titulo de eleitor</label>
                                                                <label class="input">
                                                                    <input id="tituloEleitor" maxlength="12" name="tituloEleitor" type="text" class="" autocomplete="off" onchange="verificaNumero('#tituloEleitor')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Zona</label>
                                                                <label class="input">
                                                                    <input id="zonaTituloEleitor" maxlength="3" name="zonaTituloEleitor" type="text" class="" autocomplete="off" onchange="verificaNumero('#zonaTituloEleitor')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Seção</label>
                                                                <label class="input">
                                                                    <input id="secaoTituloEleitor" maxlength="4" name="secaoTituloEleitor" type="text" class="" autocomplete="off" onchange="verificaNumero('#secaoTituloEleitor')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Certificado de reservista</label>
                                                                <label class="input">
                                                                    <input id="certificadoReservista" data-mask="999999999999" name="certificadoReservista" type="text" class="" autocomplete="off">
                                                                </label>
                                                            </section>
                                                        </div>


                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos Anexo</strong></legend>
                                                            </section>
                                                        </div>
                                                        <!-- CPF -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">CPF</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="cpfArquivo" name="cpfArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="cpfText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="cpfArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                        <!-- PISPASEP -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">PIS/PASEP - CTPS</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="pispasepArquivo" name="pispasepArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="pispasepText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="pispasepArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                        <!-- RG  - IDENTIDADE -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Identidade (RG)</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="rgArquivo" name="rgArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="rgText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="rgArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                        <!-- CARTEIRA NACIONAL DE HABILITAÇÃO -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Carteira Nacional de Habilitação (CNH)</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="cnhArquivo" name="cnhArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="cnhText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="cnhArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                        <!-- TITULO DE ELEITOR -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Titulo de Eleitor</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="tituloEleitorArquivo" name="tituloEleitorArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="tituloEleitorText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="tituloEleitorArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                        <!-- CERTIFICADO DE RESERVISTA -->
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Certificado de Reservista</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="certificadoReservistaArquivo" name="certificadoReservistaArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="certificadoReservistaText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="certificadoReservistaArquivoLink" class="col col-4">
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Escolariodade -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEscolaridade" class="collapsed" id="accordionEscolaridade">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Escolaridade
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEscolaridade" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Escolaridade</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaEscolaridade" id="verificaEscolaridade" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Grau de Instrução</label>
                                                                <label class="select">
                                                                    <select name="grauInstrucao" id="grauInstrucao" autocomplete="new-password" class="form-control">
                                                                        <option></option>
                                                                        <option value="1">1 - Analfabeto</option>
                                                                        <option value="2">2 - Ensino fundamental incompleto (1º - 5º Incompleto)</option>
                                                                        <option value="3">3 - Ensino fundamenta incompleto (5° Ano Completo)</option>
                                                                        <option value="4">4 - Ensino fundamental incompleto (6º - 9° Incompleto)</option>
                                                                        <option value="5">5 - Ensino fundamental completo</option>
                                                                        <option value="6">6 - Ensino médio incompleto</option>
                                                                        <option value="7">7 - Ensino médio completo</option>
                                                                        <option value="8">8 - Educação superior incompleta</option>
                                                                        <option value="9">9 - Educação superior completa</option>
                                                                        <option value="10">10 - Pós Graduação</option>
                                                                        <option value="11">11 - Mestrado completo</option>
                                                                        <option value="12">12 - Doutorado completo</option>
                                                                        <option value="13">13 - Pós-doutorado</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Em que Grau Parou</label>
                                                                <label class="input">
                                                                    <input id="grauParou" maxlength="64" name="grauParou" type="text" autocomplete="new-password" class="" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Ano de Conclusão</label>
                                                                <label class="input">
                                                                    <input id="anoConclusao" maxlength="64" name="anoConclusao" data-mask="9999" type="text" autocomplete="new-password" class="" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Está Cursando Atualmente</label>
                                                                <label class="select">
                                                                    <select name="cursandoAtualmente" id="cursandoAtualmente" autocomplete="new-password" class="form-control">
                                                                        <option></option>
                                                                        <option value="0">Não</option>
                                                                        <option value="1">Sim</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Hora Estudo</label>
                                                                <label class="input">
                                                                    <input id="horarioEstudo" placeholder="HH:MM" data-mask="99:99" name="horarioEstudo" autocomplete="off" type="text" class="" onchange="validateHhMm(this)">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-8">
                                                                <label class="label">Nome e Endereço Do Colégio ou Universidade</label>
                                                                <label class="input">
                                                                    <input id="nomeEnderecoColegioUniversidade" maxlength="64" name="nomeEnderecoColegioUniversidade" type="text" autocomplete="new-password" class="" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-8">
                                                                <label class="label">Atividades Extracurriculares (Cursos Realizados - Descrever)</label>
                                                                <label class="input">
                                                                    <textarea id="atividadesExtracurriculares" name="atividadesExtracurriculares" maxlength="2000" type="text" class="form-control" autocomplete="new-password" rows="4" style="resize:vertical"></textarea>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos de qualificação profissional</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Comprovante de escolaridade</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="comprovanteEscolaridadeFile" name="comprovanteEscolaridadeFile[]" multiple>Selecionar
                                                                        documentos</span><input id="comprovanteEscolaridadeText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="comprovanteEscolaridadeFileLink" class="col col-4">

                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Certificados / Diplomas</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="certificadoDiplomaFile" name="certificadoDiplomaFile[]" multiple>Selecionar
                                                                        documentos</span><input id="certificadoDiplomaText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="certificadoDiplomaFileLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Informações do Cônjuge -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseConjuge" class="collapsed" id="accordionConjuge">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Informações do Cônjuge
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseConjuge" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong> Informações do Cônjuge</strong></legend>
                                                            </section>
                                                        </div>

                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaDadoConjuge" id="verificaDadoConjuge" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-3">
                                                                <label class="label">Nome</label>
                                                                <label class="input">
                                                                    <input id="nomeConjuge" maxlength="64" name="nomeConjuge" type="text" autocomplete="new-password" class="" value="" onchange="verificaNome('#nomeConjuge')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNascimentoConjuge" name="dataNascimentoConjuge" type="text" data-dateformat="dd/mm/yy" class="datepicker" style="text-align: center" value="" data-mask="99/99/9999" data-mask-placeholder="-" autocomplete="new-password" onchange="validaCampoData('#dataNascimentoConjuge')">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Nº do País</label>
                                                                <label class="input">
                                                                    <input id="numeroPaisConjuge" name="numeroPaisConjuge" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">País de Nascimento</label>
                                                                <label class="select">
                                                                    <select name="paisNascimentoConjuge" id="paisNascimentoConjuge" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="105">Brasil</option>
                                                                        <option value="106">Fretado p/ Brasil</option>
                                                                        <option value="108">Brunei</option>
                                                                        <option value="111">Bulgária, República da</option>
                                                                        <option value="115">Burundi</option>
                                                                        <option value="119">Butão</option>
                                                                        <option value="127">Cabo Verde, República de</option>
                                                                        <option value="131">Cachemira</option>
                                                                        <option value="137">Cayman, Ilhas</option>
                                                                        <option value="141">Camboja</option>
                                                                        <option value="145">Camarões</option>
                                                                        <option value="149">Canadá</option>
                                                                        <option value="150">Jersey, Ilha do Canal</option>
                                                                        <option value="151">Canárias, Ilhas</option>
                                                                        <option value="152">Canal, Ilhas</option>
                                                                        <option value="153">Cazaquistão, República do</option>
                                                                        <option value="154">Catar</option>
                                                                        <option value="158">Chile</option>
                                                                        <option value="160">China, República Popular</option>
                                                                        <option value="161">Formosa (Taiwan)</option>
                                                                        <option value="163">Chipre</option>
                                                                        <option value="165">Cocos-Keeling, Ilhas</option>
                                                                        <option value="169">Colômbia</option>
                                                                        <option value="173">Comores, Ilhas</option>
                                                                        <option value="177">Congo</option>
                                                                        <option value="183">Cook, Ilhas</option>
                                                                        <option value="187">Coréia, República Popular Democrática</option>
                                                                        <option value="190">Coréia, República da</option>
                                                                        <option value="193">Costa do Marfim</option>
                                                                        <option value="195">Croácia, República da</option>
                                                                        <option value="196">Costa Rica</option>
                                                                        <option value="198">Coveite (kuwait)</option>
                                                                        <option value="199">Cuba</option>
                                                                        <option value="200">Curacao</option>
                                                                        <option value="229">Benin</option>
                                                                        <option value="229">Dinamarca</option>
                                                                        <option value="229">Dinamarca, Ilha</option>
                                                                        <option value="237">Dubai</option>
                                                                        <option value="239">Equador</option>
                                                                        <option value="240">Egito</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">UF de Nascimento</label>
                                                                <label class="select">
                                                                    <select name="ufNascimentoConjuge" id="ufNascimentoConjuge" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>

                                                        <div class="row">


                                                            <section class="col col-2">
                                                                <label class="label">Nº da Cidade</label>
                                                                <label class="input">
                                                                    <input id="numeroMunicipioConjuge" name="numeroMunicipioConjuge" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Cidade de Nascimento</label>
                                                                <label class="select">
                                                                    <select name="municipioNascimentoConjuge" id="municipioNascimentoConjuge" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Naturalidade</label>
                                                                <label class="input">
                                                                    <input id="naturalidadeConjuge" name="naturalidadeConjuge" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Nacionalidade</label>
                                                                <label class="input">
                                                                    <input id="nacionalidadeConjuge" name="nacionalidadeConjuge" type="text" autocomplete="new-password" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos </strong></legend>
                                                            </section>
                                                        </div>

                                                        <!-- CERTIDÃO DE CASAMENTO -->
                                                        <div class="row">

                                                            <section class="col col-6">
                                                                <label class="label">Certidão de Casamento</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="certidaoCasamentoArquivo" name="certidaoCasamentoArquivo[]" multiple>Selecionar
                                                                        documentos</span><input id="certidaoCasamentoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="certidaoCasamentoArquivoLink" class="col col-4">

                                                            </section>
                                                        </div>



                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Filho -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilho" class="collapsed" id="accordionFilho">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Informações do(s) Filho(s) até 14 anos
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFilho" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>

                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Informações do(s) Filho(s) até 14 anos</strong> </legend>
                                                            </section>


                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaFilho" id="verificaFilho" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <!--  LISTA DE FILHOS -->
                                                        <input id="jsonFilho" name="jsonFilho" type="hidden" value="[]">
                                                        <div id="formFilho">
                                                            <div class="row">
                                                                <section class="col col-2">
                                                                    <label class="label">Possui Filho Menor que 14 anos</label>
                                                                    <label class="select">
                                                                        <select name="possuiFilhoMenor14" id="possuiFilhoMenor14" autocomplete="new-password" class="form-control required" required>
                                                                            <option></option>
                                                                            <option value="1">Sim</option>
                                                                            <option value="0">Não</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <input id="filhoId" name="filhoId" type="hidden" value="">
                                                                <input id="descricaoDataNascimentoFilho" name="descricaoDataNascimentoFilho" type="hidden" value="">
                                                                <input id="sequencialFilho" name="sequencialFilho" type="hidden" value="">
                                                                <section class="col col-6">
                                                                    <label class="label" for="nomeFilho">Nome do Filhos</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="nomeFilho" name="nomeFilho" maxlength="60" autocomplete="new-password" onchange="verificaNome('#nomeFilho')">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="cpfFilho">CPF</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="cpfFilho" name="cpfFilho" placeholder="XXX.XXX.XXX-XX" autocomplete="new-password" data-mask="999.999.999-99" onchange="verificaCpf('#cpfFilho')">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="dataNascimentoFilho">Nascimento</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataNascimentoFilho" name="dataNascimentoFilho" autocomplete="new-password" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker " value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" onchange="validaCampoData('#dataNascimentoFilho')">
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnAddFilho" type="button" class="btn btn-primary" title="Adicionar Filho">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverFilho" type="button" class="btn btn-danger" title="Remover Filho">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableFilho" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">Nome</th>
                                                                            <th class="text-left" style="min-width: 10px;">CPF</th>
                                                                            <th class="text-left" style="min-width: 10px;">Data de Nascimento</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos dos filhos até 14 anos</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Certidão de nascimento</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="certidaoNascimentoFilhoFile" name="certidaoNascimentoFilhoFile[]" multiple>Selecionar
                                                                        documentos</span><input id="certidaoNascimentoFilhoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="certidaoNascimentoFilhoFileLink" class="col col-4">

                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Identidade (RG)</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="rgFilhoFile" name="rgFilhoFile[]" multiple>Selecionar
                                                                        documentos</span><input id="rgFilhoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="rgFilhoFileLink" class="col col-4">

                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Cpf</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="cpfFilhoFile" name="cpfFilhoFile[]" multiple>Selecionar
                                                                        documentos</span><input id="cpfFilhoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="cpfFilhoFileLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Carteira de vacinação (Para filhos com menos de 4 anos)</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="carteiraVacinacaoFilhoFile" name="carteiraVacinacaoFilhoFile[]" multiple>Selecionar
                                                                        documentos</span><input id="carteiraVacinacaoFilhoText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="carteiraVacinacaoFilhoFileLink" class="col col-4">

                                                            </section>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Informações de Dependente para IRRF -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseDependente" class="collapsed" id="accordionDependente">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Informações de Dependente para IRRF
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseDependente" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Informações de Dependente para IRRF</strong></legend>
                                                            </section>
                                                        </div>

                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaDependente" id="verificaDependente" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <input id="jsonDependente" name="jsonDependente" type="hidden" value="[]">
                                                        <div id="formDependente">
                                                            <div class="row">
                                                                <input id="DependenteId" name="DependenteId" type="hidden" value="">
                                                                <input id="descricaoDataNascimentoDependente" name="descricaoDataNascimentoDependente" type="hidden" value="">
                                                                <input id="sequencialDependente" name="sequencialDependente" type="hidden" value="">
                                                                <section class="col col-6">
                                                                    <label class="label" for="nomeDependente">Nome</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="nomeDependente" name="nomeDependente" maxlength="60" autocomplete="new-password" onchange="verificaNome('#nomeDependente')">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="cpfDependente">CPF</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="cpfDependente" name="cpfDependente" placeholder="XXX.XXX.XXX-XX" placeholder="XXX.XXX.XXX-XX" autocomplete="new-password" data-mask="999.999.999-99" onchange="verificaCpf('#cpfDependente')">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="dataNascimentoDependente">Nascimento</label>
                                                                    <label class="input">
                                                                        <i class="icon-append fa fa-calendar"></i>
                                                                        <input id="dataNascimentoDependente" name="dataNascimentoDependente" autocomplete="new-password" type="text" placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" class="datepicker " value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" onchange="validaCampoData('#dataNascimentoDependente')">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Tipo Dependente</label>
                                                                    <label class="select">
                                                                        <select name="grauParentescoDependente" id="grauParentescoDependente" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                            <option></option>
                                                                            <option value="1">01 - Cônjuge</option>
                                                                            <option value="2">02 - Companheiro(a) com o(a) qual tenha filho(s) ou viva há mais de 5 (cinco) anos ou possua declaração de união estável</option>
                                                                            <option value="3">03 - Filho(a) ou enteado(a)</option>
                                                                            <option value="4">04 - Filho(a) ou enteado(a) universitário(a) ou cursando escola técnica de 2º grau, até 24 (vinte e quatro) anos</option>
                                                                            <option value="6">06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial</option>
                                                                            <option value="9">09 - Pais, avós e bisavós</option>
                                                                            <option value="10">10 - Menor pobre do qual detenha a guarda judicial</option>
                                                                            <option value="11">11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador</option>
                                                                            <option value="12">12 - Ex-cônjuge</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnAddDependente" type="button" class="btn btn-primary" title="Adicionar Dependente">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverDependente" type="button" class="btn btn-danger" title="Remover Dependente">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableDependente" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">Nome</th>
                                                                            <th class="text-left" style="min-width: 10px;">CPF</th>
                                                                            <th class="text-left" style="min-width: 10px;">Data de Nascimento</th>
                                                                            <th class="text-left" style="min-width: 10px;">Parentesco</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Documentos dos dependentes</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Certidão de Nascimento</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="certidaoNascimentoDependenteFile" name="certidaoNascimentoDependenteFile[]" multiple>Selecionar
                                                                        documentos</span><input id="certidaoNascimentoDependenteText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="certidaoNascimentoDependenteFileLink" class="col col-4">

                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">RG</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="rgDependenteFile" name="rgDependenteFile[]" multiple>Selecionar
                                                                        documentos</span><input id="rgDependenteText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="rgDependenteFileLink" class="col col-4">

                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-6">
                                                                <label class="label">Cpf</label>
                                                                <label class="input input-file">
                                                                    <span class="button"><input type="file" id="cpfDependenteFile" name="cpfDependenteFile[]" multiple>Selecionar
                                                                        documentos</span><input id="cpfDependenteText" type="text">
                                                                </label>
                                                            </section>
                                                            <section id="cpfDependenteFileLink" class="col col-4">

                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Informações Adicionais -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseInformacaoAdicional" class="collapsed" id="accordionInformacaoAdicional">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Informações Adicionais & Benefícios
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseInformacaoAdicional" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong> Informações Adicionais</strong></legend>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Trabalha Atualmente</label>
                                                                <label class="select">
                                                                    <select name="trabalhaAtualmente" id="trabalhaAtualmente" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="0">Sim</option>
                                                                        <option value="1">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Está em Seguro Desemprego</label>
                                                                <label class="select">
                                                                    <select name="seguroDesemprego" id="seguroDesemprego" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="0">Sim</option>
                                                                        <option value="1">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Benefícios</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaBeneficio" id="verificaBeneficio" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <strong>ATENÇÃO: </strong> <br><br>
                                                                <strong>• A NTL possui convênio de Assistência Médica e Odontológica custeado integralmente pelo funcionário e descontado em folha de pagamento.<br>
                                                                      Você receberá em breve em seu e-mail as informações de valores, carências, coberturas e os formulários necessários para adesão.<br>
                                                                      Fique atento pois a sua inclusão deverá ser feita em até 30 dias após a sua admissão para isenção de carência. 
                                                                    <br>
                                                                    • <em> Indique abaixo a sua opção: </em>
                                                                </strong> <br>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Deseja Assistência Médica</label>
                                                                <label class="select">
                                                                    <select name="desejaAssistenciaMedica" id="desejaAssistenciaMedica" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Deseja Assistência Odontológica</label>
                                                                <label class="select">
                                                                    <select name="desejaAssistenciaOdontologica" id="desejaAssistenciaOdontologica" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <strong>ATENÇÃO: </strong> <br><br>
                                                                <strong>• A NTL oferece ao funcionário o Cartão de Alimentação ou Cartão de Refeição. <br>
                                                                      O Alimentação é aceito em Supermercados e Mercearias para compra de mantimentos.<br>
                                                                      O Refeição é aceito em Restaurantes e Lanchonetes para refeições e lanches. <br>
                                                                    • <em> Indique abaixo a sua opção: </em>
                                                                </strong> <br>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Vale Refeição / Vale Alimentação</label>
                                                                <label class="select">
                                                                    <select name="valeRefeicaoValeAlimentacao" id="valeRefeicaoValeAlimentacao" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="0">Vale Refeição</option>
                                                                        <option value="1">Vale Alimentação</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Vale Transporte</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaVT" id="verificaVT" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <strong>ATENÇÃO: </strong> <br><br>
                                                                <strong>• Verifique se o seu cartão está desvinculado através do seu CPF, acessando o endereço abaixo ou entrando em contato com a Riocard Mais. <br>
                                                                      Caso o status do cartão esteja “Associado ao Usuário”, solicite a liberação à sua última empresa ou à Riocard mais com urgência. <br>
                                                                    • Endereço: <a href="https://www.cartaoriocard.com.br/rcc/paraEmpresa/consultarCpf">https://www.cartaoriocard.com.br/rcc/paraEmpresa/consultarCpf</a>
                                                                </strong> <br>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Deseja Vale Transporte</label>
                                                                <label class="select">
                                                                    <select name="desejaVt" id="desejaVt" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Possui Cartão Transporte</label>
                                                                <label class="select">
                                                                    <select name="possuiVt" id="possuiVt" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Tipo do Cartão</label>
                                                                <label class="select">
                                                                    <select name="tipoCartaoVt" id="tipoCartaoVt" autocomplete="new-password" class="form-control required">
                                                                        <option value="1">Bilhete Único</option>
                                                                        <option value="2">Riocard</option>
                                                                        <option value="3">BU Carioca</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label" for="numeroCartaoVt">Nº Cartão Transporte</label>
                                                                <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                    <input id="numeroCartaoVt" name="numeroCartaoVt" data-mask="9999999999999" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                            <section class="col col-6">
                                                                <label class="label" for="justificativaVt">Justificativa</label>
                                                                <label class="input">
                                                                    <input id="justificativaVt" name="justificativaVt" autocomplete="off" type="text" maxlength="50" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                        </div>



                                                        <input id="jsonTransporte" name="jsonTransporte" type="hidden" value="[]">
                                                        <div id="formTransporte">
                                                            <div class="row">
                                                                <input id="TransporteId" name="TransporteId" type="hidden" value="">
                                                                <input id="descricaoTransporte" name="descricaoTransporte" type="hidden" value="">
                                                                <input id="sequencialTransporte" name="sequencialTransporte" type="hidden" value="">

                                                                <section class="col col-2">
                                                                    <label class="label">Trajeto</label>
                                                                    <label class="select">
                                                                        <select name="trajetoTransporte" id="trajetoTransporte" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                            <option></option>
                                                                            <option value="1">Ida</option>
                                                                            <option value="2">Volta</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label">Tipo Transporte</label>
                                                                    <label class="select">
                                                                        <select name="tipoTransporte" id="tipoTransporte" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                            <option></option>
                                                                            <option value="1">Barca</option>
                                                                            <option value="2">BRT</option>
                                                                            <option value="3">Metrô</option>
                                                                            <option value="4">Ônibus</option>
                                                                            <option value="5">Ônibus Intermunicipal</option>
                                                                            <option value="6">Trêm</option>
                                                                            <option value="7">Van</option>
                                                                            <option value="8">VLT</option>
                                                                        </select><i></i>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-2">
                                                                    <label class="label" for="linhaTransporte">Linha</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="linhaTransporte" name="linhaTransporte" maxlength="50" autocomplete="new-password">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label" for="valorTransporte">Valor</label>
                                                                    <label class="input"><i class="icon-append fa fa-id-card"></i>
                                                                        <input id="valorTransporte" name="valorTransporte" maxlength="20" autocomplete="new-password" class="decimal-2-casas" type="text">
                                                                    </label>
                                                                </section>

                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <button id="btnAddTransporte" type="button" class="btn btn-primary" title="Adicionar Transporte">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverTransporte" type="button" class="btn btn-danger" title="Remover Transporte">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
                                                                <table id="tableTransporte" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                    <thead>
                                                                        <tr role="row">
                                                                            <th></th>
                                                                            <th class="text-left" style="min-width: 10px;">Trajeto</th>
                                                                            <th class="text-left" style="min-width: 10px;">Tipo Transporte</th>
                                                                            <th class="text-left" style="min-width: 10px;">Linha</th>
                                                                            <th class="text-left" style="min-width: 10px;">Valor</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <a id="linkPdfTransporte" name="linkPdfTransporte">   - Baixar formulário de Vale transporte </a> <br>

                                                        </div>


                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Dados Bancários</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaDadoBancario" id="verificaDadoBancario" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Possui Conta Bancária</label>
                                                                <label class="select">
                                                                    <select name="possuiContaBancaria" id="possuiContaBancaria" autocomplete="new-password" class="form-control required">
                                                                        <option></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Tipo de conta</label>
                                                                <label class="select">
                                                                    <select name="tipoConta" id="tipoConta" autocomplete="new-password" class="form-control">
                                                                        <option value="0" selected></option>
                                                                        <option value="1">Corrente</option>
                                                                        <option value="2">Poupança</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>

                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label " for="fk_banco">Banco</label>
                                                                <label class="select">
                                                                    <select id="fk_banco" name="fk_banco">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "select codigo,codigoBanco,nomeBanco from Ntl.banco order by nomeBanco";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {

                                                                            $codigo = $row['codigo'];
                                                                            $codigoBanco = mb_convert_encoding($row['codigoBanco'], 'UTF-8', 'HTML-ENTITIES');
                                                                            $nomeBanco = mb_convert_encoding($row['nomeBanco'], 'UTF-8', 'HTML-ENTITIES');
                                                                            echo '<option value=' . $codigo . '>' . $codigoBanco . ' - ' . strtoupper($nomeBanco) . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Agência</label>
                                                                <label class="input">
                                                                    <input id="agenciaBanco" name="agenciaBanco" maxlength="5" type="text" class="" value="" autocomplete="new-password" onchange="verificaNumero('#agenciaBanco')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Digito Agência</label>
                                                                <label class="input">
                                                                    <input id="digitoAgenciaBanco" name="digitoAgenciaBanco" maxlength="2" type="text" class="" value="" autocomplete="new-password" onchange="verificaNumero('#digitoAgenciaBanco')">
                                                                </label>
                                                            </section>

                                                            <section class="col col-1">
                                                                <label class="label" id="labelVariacao">Variação</label>
                                                                <label class="select">
                                                                    <select name="variacao" id="variacao" autocomplete="new-password" class="form-control">
                                                                        <option value="0" selected></option>
                                                                        <option value="001">001</option>
                                                                        <option value="051">051</option>
                                                                        <option value="013">013</option>
                                                                        <option value="500">500</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                            <section class="col col-2">
                                                                <label class="label">Conta</label>
                                                                <label class="input">
                                                                    <input id="contaCorrente" name="contaCorrente" type="text" class="" maxlength="13" value="" autocomplete="new-password" onchange="verificaNumero('#contaCorrente')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Digito Conta</label>
                                                                <label class="input">
                                                                    <input id="digitoContaBanco" name="digitoContaBanco" maxlength="2" type="text" class="" value="" autocomplete="new-password" onchange="verificaNumero('#digitoContaBanco')">
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Cargo</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaCargo" id="verificaCargo" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-4">
                                                                <label class="label">Cargo Anterior</label>
                                                                <label class="input">
                                                                    <input id="cargo" name="cargo" maxlength="50" type="text" class="" value="" autocomplete="new-password" onchange="verificaNome('#cargo')">
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label" for="projeto">Projeto</label>
                                                                <label class="select">
                                                                    <select id="projeto" name="projeto" class="required">
                                                                        <option></option>
                                                                        <?php
                                                                        $sql =  "SELECT codigo, numeroCentroCusto, descricao, apelido FROM Ntl.projeto where ativo = 1 order by codigo";
                                                                        $reposit = new reposit();
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $row = array_map('mb_strtoupper', $row);
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ($row['descricao']);
                                                                            $numeroCentroCusto  = ($row['numeroCentroCusto']);
                                                                            $apelido = ($row['apelido']);
                                                                            echo '<option value=' . $codigo . '>  ' . $numeroCentroCusto . ' - ' . $apelido . ' - ' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>

                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-12">
                                                                <legend><strong>Tamanho do Uniforme</strong></legend>
                                                            </section>
                                                        </div>
                                                        <div class="row" style="display:<?php echo $esconderCandidato ?>">
                                                            <section class="col col-2">
                                                                <label class="label">STATUS</label>
                                                                <label class="select">
                                                                    <select name="verificaUniforme" id="verificaUniforme" autocomplete="off" class="form-control" autocomplete="new-password">
                                                                        <option></option>
                                                                        <option value="1">PENDENTE</option>
                                                                        <option value="2">VERIFICADO</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label">Camisa</label>
                                                                <label class="select">
                                                                    <select name="numeroCamisa" id="numeroCamisa" autocomplete="new-password" class="form-control">
                                                                        <option></option>
                                                                        <option value="1">PP</option>
                                                                        <option value="2">P</option>
                                                                        <option value="3">M</option>
                                                                        <option value="4">G</option>
                                                                        <option value="5">GG</option>
                                                                        <option value="6">XG</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Calça</label>
                                                                <label class="input">
                                                                    <input id="numeroCalca" name="numeroCalca" type="text" class="number" data-mask="99" value="" autocomplete="new-password" max="2">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Saia</label>
                                                                <label class="input">
                                                                    <input id="numeroSaia" name="numeroSaia" type="text" class="number" data-mask="99" value="" autocomplete="new-password" maxlength="2">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Sapato</label>
                                                                <label class="input">
                                                                    <input id="numeroSapato" name="numeroSapato" type="text" class="numeric" data-mask="99" maxlength="2" value="" autocomplete="new-password">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
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
                                        <section class="col col-2" style="margin-top: 15px; display:<?php echo $esconderCandidato ?>">
                                            <strong>Aprovado para Contratação:</strong>
                                        </section>
                                        <section class="col col-2" style="margin-top: 10px; display:<?php echo $esconderCandidato ?>">
                                            <label class="select">
                                                <select name="aprovado" id="aprovado" autocomplete="off" class="form-control" autocomplete="new-password">
                                                    <option></option>
                                                    <option value="1">SIM</option>
                                                    <option value="0">NÃO</option>
                                                </select><i></i>
                                            </label>
                                        </section>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                            <span class="fa fa-trash"></span>
                                            <button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar">
                                                <span class="fa fa-floppy-o"></span>
                                            </button>
                                            <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderCandidato ?>">
                                                <span class="fa fa-file-o"></span>
                                            </button>
                                            <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar" style="display:<?php echo $esconderCandidato ?>">
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


<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/gir_script.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_URL; ?>/js/business_contratacaoCandidato.js" type="text/javascript"></script> 
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>



<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    $('body').addClass("minified");
    jsonFilhoArray = JSON.parse($("#jsonFilho").val());
    jsonDependenteArray = JSON.parse($("#jsonDependente").val());
    jsonTransporteArray = JSON.parse($("#jsonTransporte").val());
    $(document).ready(function() {
        jQuery.validator.addMethod(
            "senhaRequerida",
            function(value, element, params) {
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
            function(value, element, params) {
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
            function(value, element, params) {
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
                    maxlength: 15
                },
                'senha': {
                    senhaRequerida: true,
                    minlength: 7,
                    maxlength: 10
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
                    maxlength: 'Digite no máximo de 15 caracteres.',
                    minlength: 'Digite no mínimo 7 caracteres'
                },
                'senha': {
                    maxlength: 'Digite no máximo de 10 caracteres.',
                    minlength: 'Digite no mínimo 7 caracteres',
                    senharequerida: 'Informe a senha.'
                },
                'senhaConfirma': {
                    confirmacaosenharequerida: 'Informe a senha mais uma vez.',
                    confirmacaosenhaequalto: 'Informe a mesma senha digitada no campo senha.'
                }
            },

            // Do not change code below
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
                //$("#accordionCadastro").click();
                $("#accordionCadastro").removeClass("collapsed");
            },
            highlight: function(element) {
                //$(element).parent().addClass('error');
            },
            unhighlight: function(element) {
                //$(element).parent().removeClass('error');
            }
        });

        carregaPagina();


        function displayHandlerPossuiVt(text) {
            if (text == 'Sim') {
                $("#tipoCartaoVt").removeClass('readonly');
                $("#tipoCartaoVt").removeAttr('disabled');
            } else {
                $("#tipoCartaoVt").addClass('readonly');
                $("#tipoCartaoVt").val('');
                $("#tipoCartaoVt").prop('disabled', true);
            }
        }

        // Show and Hide Possui Vt 
        var sel = document.getElementById("possuiVt");
        var possuiVt = sel.options[sel.selectedIndex].text;
        displayHandlerPossuiVt(possuiVt)

        sel.addEventListener("change", (event) => {
            var selp = document.getElementById("possuiVt");
            var text = selp.options[selp.selectedIndex].text;
            displayHandlerPossuiVt(text)
        })

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

        $("#btnVoltar").on("click", function() {
            voltar();
        });
        $("#btnGravar").on("click", function() {

            gravar();
        });

        $('#possuiContaBancaria').on('change',function() {
        verificaBanco();
        });

        $("#desejaVt").on("change", function() {
            var desejaVt = +$("#desejaVt").val();
            if (desejaVt == 0) {
                $("#justificativaVt").removeAttr("class");
                $("#justificativaVt").prop('readonly', false);
                $("#justificativaVt").addClass('required');
                $("#justificativaVt").prop('required', true);
            } else {
                $("#justificativaVt").addClass("readonly");
                $("#justificativaVt").val('');
                $("#justificativaVt").prop('readonly', true);
            }
        });



        $('#variacao, #fk_banco, #tipoConta').change(function() {

            let fk_banco = $("#fk_banco option:selected").text();
            fk_banco = fk_banco.split("-");
            fk_banco = fk_banco[0].trim();
            let variacao = $("#variacao").val();
            let tipoConta = $("#tipoConta").val(); //tipoConta:  1 - Corrente  2-Poupança

            //Muda o nome da label e o valor da variação dependendo do banco e tipo de conta selecionados.
            if (fk_banco == "104") { //Código da Caixa Econômica  
                if (tipoConta == "1") {
                    $("#variacao").val("001");
                    document.getElementById('labelVariacao').textContent = 'Tipo de Operação';
                } else if (tipoConta == "2") {
                    $("#variacao").val("013");
                    document.getElementById('labelVariacao').textContent = 'Tipo de Operação';
                }
            } else if (fk_banco == "341") {
                if (tipoConta == "2") {
                    $("#variacao").val("500");
                    document.getElementById('labelVariacao').textContent = 'Complemento';
                } else {
                    document.getElementById('labelVariacao').textContent = 'Variação';
                }
            } else if (fk_banco == "001") {
                if (tipoConta == "2") {
                    $("#variacao").val("051");
                    document.getElementById('labelVariacao').textContent = 'Variação';
                } else {
                    document.getElementById('labelVariacao').textContent = 'Variação';
                }
            } else {
                document.getElementById('labelVariacao').textContent = 'Variação';
            }
        });

        $('#anoConclusao').change(function() {
            var anoConclusao = +$('#anoConclusao').val();
            now = new Date
            now = now.getFullYear();
            now += 10
            // console.log(now); // ano atual + 10 anos futuros
            if (anoConclusao < 1930 || anoConclusao > now) {
                smartAlert("Erro", "O valor inserido é inválido.", "error");
                $("#anoConclusao").val('');
            }
        });
        $('#cursandoAtualmente').change(function() {
            var cursandoAtualmente = +$('#cursandoAtualmente').val();
            if (cursandoAtualmente == 1) {
                $("#horarioEstudo").removeClass('readonly');
                $("#horarioEstudo").addClass('required');
                $("#horarioEstudo").removeAttr('disabled');
            } else {
                $("#horarioEstudo").addClass('readonly');
                $("#horarioEstudo").removeClass('required');
                $("#horarioEstudo").val('');
                $("#horarioEstudo").prop('disabled', true);
            }
        });
        $('#ctps').change(function() {
            var tipoFeriado = +$('#ctps').val();
            if (tipoFeriado == 1) {
                $("#pis").removeClass('readonly');
                $("#pis").addClass('required');
                $("#pis").removeAttr('disabled');
            } else {
                $("#pis").addClass('readonly');
                $("#pis").removeClass('required');
                $("#pis").val('');
                $("#pis").prop('disabled', true);
            }
        });
        $('#possuiVt').change(function() {
            var possuiVt = +$('#possuiVt').val();
            if (possuiVt == 1) {
                $("#numeroCartaoVt").removeClass('readonly');
                $("#numeroCartaoVt").removeAttr('disabled');
            } else {
                $("#numeroCartaoVt").addClass('readonly');
                $("#numeroCartaoVt").val('');
                $("#numeroCartaoVt").prop('disabled', true);
            }
        });
        $("#cep").mask("99999-999", {
            placeholder: "X"
        });
        $("#cep").on("focusout", function() {
            var cep = $("#cep").val();
            var funcao = 'recuperaCep';

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
                    var endereco = piece[0];
                    var logradouro = endereco.substr(0, endereco.indexOf(' '));
                    endereco = endereco.split(/ (.+)/)[1];

                    $("#logradouro").val(logradouro);
                    $("#endereco").val(endereco);
                    $("#bairro").val(piece[1]);
                    $("#cidade").val(piece[2]);
                    $("#estado").val(piece[3]);
                    return;
                }
            })
        });

        // $("#cpf").on("focusout", function() {
        //     consultaCpf();
        // });

        //Botões de Dependente
        $("#btnAddDependente").on("click", function() {
            if (validaDependente())
                addDependente();
        });

        $("#btnRemoverDependente").on("click", function() {
            excluirDependente();
        });

        //Botões de Filhos
        $("#btnAddFilho").on("click", function() {
            if (validaFilho())
                addFilho();
        });

        $("#btnRemoverFilho").on("click", function() {
            excluirFilho();
        });

        //Botões de Transporte
        $("#btnAddTransporte").on("click", function() {
            if (validaTransporte())
                addTransporte();
        });

        $("#btnRemoverTransporte").on("click", function() {
            excluirTransporte();
        });

        // ON CHANGES DOCUMENTOS

        $("input[name='fotoCandidato[]']").change(function() {

            let files = document.getElementById("fotoCandidato").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;

            }

            let arrayString = array.toString();
            $("#fotoCandidatoText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#fotoCandidatoText").val("");
                $("#fotoCandidato").val("");

            }

        });



        $("input[name='carteiraVacinacaoFilhoFile[]']").change(function() {
            let files = document.getElementById("carteiraVacinacaoFilhoFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }

            let arrayString = array.toString();
            $("#carteiraVacinacaoFilhoText").val(arrayString);


            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#carteiraVacinacaoFilhoText").val("");
                $("#carteiraVacinacaoFilhoFile").val("");

            }

        });



        $("input[name='certidaoNascimento[]']").change(function() {
            let files = document.getElementById("certidaoNascimento").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#certidaoNascimentoText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#certidaoNascimentoText").val("");
                $("#certidaoNascimento").val("");

            }

        });


        $("input[name='certidaoCasamentoArquivo[]']").change(function() {
            let files = document.getElementById("certidaoCasamentoArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#certidaoCasamentoText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#certidaoCasamentoText").val("");
                $("#certidaoCasamentoArquivo").val("");

            }

        });


        $("input[name='comprovanteResidenciaArquivo[]']").change(function() {
            let files = document.getElementById("comprovanteResidenciaArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#comprovanteResidenciaText").val(arrayString);


            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#comprovanteResidenciaText").val("");
                $("#comprovanteResidenciaArquivo").val("");

            }

        });

        $("input[name='cpfArquivo[]']").change(function() {
            let files = document.getElementById("cpfArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 524288; //0.5MB = 524288 |1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#cpfText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 500KB", "error");
                $("#cpfText").val("");
                $("#cpfArquivo").val("");

            }

        });

        $("input[name='pispasepArquivo[]']").change(function() {
            let files = document.getElementById("pispasepArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1572864; //1.5MB = 1572864 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#pispasepText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1.5MB", "error");
                $("#pispasepText").val("");
                $("#pispasepArquivo").val("");

            }

        });

        $("input[name='rgArquivo[]']").change(function() {
            let files = document.getElementById("rgArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 524288; //0.5MB = 524288 |1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#rgText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 500KB", "error");
                $("#rgText").val("");
                $("#rgArquivo").val("");

            }

        });


        $("input[name='cnhArquivo[]']").change(function() {
            let files = document.getElementById("cnhArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 524288; //0.5MB = 524288 |1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#cnhText").val(arrayString);


            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 500KB", "error");
                $("#cnhText").val("");
                $("#cnhArquivo").val("");

            }

        });


        $("input[name='tituloEleitorArquivo[]']").change(function() {
            let files = document.getElementById("tituloEleitorArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 524288; //0.5MB = 524288 |1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#tituloEleitorText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 500KB", "error");
                $("#tituloEleitorText").val("");
                $("#tituloEleitorArquivo").val("");

            }

        });

        $("input[name='certificadoReservistaArquivo[]']").change(function() {
            let files = document.getElementById("certificadoReservistaArquivo").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 524288; //0.5MB = 524288 |1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#certificadoReservistaText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 500KB", "error");
                $("#certificadoReservistaText").val("");
                $("#certificadoReservistaArquivo").val("");

            }

        });

        $("input[name='comprovanteEscolaridadeFile[]']").change(function() {
            let files = document.getElementById("comprovanteEscolaridadeFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1572864; //1,5MB = 1572864 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#comprovanteEscolaridadeText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1.5MB", "error");
                $("#comprovanteEscolaridadeText").val("");
                $("#comprovanteEscolaridadeFile").val("");

            }

        });

        $("input[name='certificadoDiplomaFile[]']").change(function() {
            let files = document.getElementById("certificadoDiplomaFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 4194304; //1MB = 1048576 |  4MB = 4194304
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#certificadoDiplomaText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 4MB", "error");
                $("#certificadoDiplomaText").val("");
                $("#certificadoDiplomaFile").val("");

            }

        });

        $("input[name='certidaoNascimentoFilhoFile[]']").change(function() {
            let files = document.getElementById("certidaoNascimentoFilhoFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1258291.2; //1.2MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#certidaoNascimentoFilhoText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1.2MB", "error");
                $("#certidaoNascimentoFilhoText").val("");
                $("#certidaoNascimentoFilhoFile").val("");

            }

        });

        $("input[name='rgFilhoFile[]']").change(function() {
            let files = document.getElementById("rgFilhoFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1258291.2; //1.2MB = 1258291.2 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#rgFilhoText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1.2MB", "error");
                $("#rgFilhoText").val("");
                $("#rgFilhoFile").val("");

            }

        });

        $("input[name='cpfFilhoFile[]']").change(function() {
            let files = document.getElementById("cpfFilhoFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#cpfFilhoText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#cpfFilhoText").val("");
                $("#cpfFilhoFile").val("");

            }

        });

        $("input[name='certidaoNascimentoDependenteFile[]']").change(function() {
            let files = document.getElementById("certidaoNascimentoDependenteFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#certidaoNascimentoDependenteText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#certidaoNascimentoDependenteText").val("");
                $("#certidaoNascimentoDependenteFile").val("");

            }

        });

        $("input[name='rgDependenteFile[]']").change(function() {
            let files = document.getElementById("rgDependenteFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1153433.6; //1,1MB = 1153433.6 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#rgDependenteText").val(arrayString);

            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1.1MB", "error");
                $("#rgDependenteText").val("");
                $("#rgDependenteFile").val("");

            }

        });

        $("input[name='cpfDependenteFile[]']").change(function() {
            let files = document.getElementById("cpfDependenteFile").files;
            let array = [];
            let tamanhoTotal = 0;
            let tamanhoMaximoPorCampo = 1048576; //1MB = 1048576 | 2MB = 2097152
            for (let i = 0; i < files.length; i++) {
                array.push(files[i].name);
                tamanhoTotal += files[i].size;
            }
            let arrayString = array.toString();
            $("#cpfDependenteText").val(arrayString);


            if (tamanhoTotal > tamanhoMaximoPorCampo) {
                smartAlert("Atenção", "Estes arquivos ultrapassaram o valor máximo permitido! O total de arquivos não pode ser maior do que 1MB", "error");
                $("#rgDependenteText").val("");
                $("#rgDependenteFile").val("");

            }
        });

        /* ON CHANGE DE PAÍS/UF/MUNICÍPIO */

        $("#paisNascimento").on("change", function() {
            let valor = $("#paisNascimento").val();
            $("#numeroPais").val(valor);

            //Toda vez que país mudar, é necessário que as informações que dependam dela sejam limpas.
            limparCombo("ufNascimento");
            limparCombo("municipioNascimento");

            if (valor != 105) { //Código do Brasil 
                if (valor == "") {
                    $("#nacionalidade").val("");
                    $("#naturalidade").val("");
                    $("#numeroMunicipio").val("");
                } else {
                    //Como o país não é Brasil, ele recebe os valores EX.
                    $("#nacionalidade").val("EX.");
                    $("#naturalidade").val("EX.");
                    $("#numeroMunicipio").val("EX.");
                    //Adiciona o valor EX. de acordo com os ids das Combos. 
                    adicionarExCombo("municipioNascimento");
                    adicionarExCombo("ufNascimento");
                }
            } else { // O país selecionado é o Brasil: 
                $("#nacionalidade").val("Brasil");
                $("#naturalidade").val("");
                $("#municipioNascimento").val("");
                $("#numeroMunicipio").val("");

                removerCampoEx("ufNascimento");
                getUf(function() {});
            }
        });

        //Alerta caso pais Nascimento não tenha sido selecionado
        $("#ufNascimento").on("click", function() {
            let paisNascimento = $("#paisNascimento").val();
            if (paisNascimento == "") {
                smartAlert("Atenção", "Selecione um País de Nascimento antes de continuar!", "error");
                return;
            }
        });

        $("#ufNascimento").on("change", function() {


            let valor = $("#ufNascimento option:selected").text();
            if (valor != "EX.") {

                $("#numeroMunicipio").val(" ");
                $("#naturalidade").val(" ");
                limparCombo("municipioNascimento");
                //Cria uma opção em branco na combo de município.
                document.getElementById("municipioNascimento").add(document.createElement("option"));
                getMunicipioPorUf($("#ufNascimento option:selected").val(), function() {
                    $("#ufNascimento option:selected").val();
                });
                getSiglaUf();

            }
        });

        //Alertas caso Pais e Uf não tenham sido selecionados
        $("#municipioNascimento").on("click", function() {

            let paisNascimento = $("#paisNascimento").val();
            let ufNascimento = $("#ufNascimento").val();

            if (!paisNascimento) {
                smartAlert("Atenção", "Selecione um País de Nascimento antes de continuar!", "error");
                return;
            } else if (!ufNascimento) {
                smartAlert("Atenção", "Selecione a UF de Nascimento antes de continuar!", "error");
                return;
            }
        });

        $("#municipioNascimento").on("change", function() {
            let valor = $("#municipioNascimento option:selected").val();
            $("#numeroMunicipio").val(valor);
        });

        /* ON CHANGE DE PAÍS/UF/MUNICÍPIO DO CÔNJUGE*/

        $("#paisNascimentoConjuge").on("change", function() {

            let valor = $("#paisNascimentoConjuge").val();
            $("#numeroPaisConjuge").val(valor);

            //Toda vez que país mudar, é necessário que as informações que dependam dela sejam limpas.
            limparCombo("ufNascimentoConjuge");
            limparCombo("municipioNascimentoConjuge");

            if (valor != 105) { //Código do Brasil 
                if (valor == "") {
                    $("#nacionalidadeConjuge").val("");
                    $("#naturalidadeConjuge").val("");
                    $("#numeroMunicipioConjuge").val("");
                } else {
                    //Como o país não é Brasil, ele recebe os valores EX.
                    $("#nacionalidadeConjuge").val("EX.");
                    $("#naturalidadeConjuge").val("EX.");
                    $("#numeroMunicipioConjuge").val("EX.");
                    //Adiciona o valor EX. de acordo com os ids das Combos. 
                    adicionarExCombo("municipioNascimentoConjuge");
                    adicionarExCombo("ufNascimentoConjuge");
                }
            } else { // O país selecionado é o Brasil: 
                $("#nacionalidadeConjuge").val("Brasil");
                $("#naturalidadeConjuge").val("");
                $("#municipioNascimentoConjuge").val("");
                $("#numeroMunicipioConjuge").val("");

                removerCampoEx("ufNascimentoConjuge");
                getUfConjuge(function() {});
            }
        });

    });

    //Alertas caso Pais e Uf não tenham sido selecionados
    $("#municipioNascimentoConjuge").on("click", function() {

        let paisNascimentoConjuge = $("#paisNascimentoConjuge").val();
        let ufNascimentoConjuge = $("#ufNascimentoConjuge").val();

        if (!paisNascimentoConjuge) {
            smartAlert("Atenção", "Selecione um País de Nascimento do Cônjuge antes de continuar!", "error");
            return;
        } else if (!ufNascimentoConjuge) {
            smartAlert("Atenção", "Selecione a UF de Nascimento do Cônjuge antes de continuar!", "error");
            return;
        }
    });

    $("#municipioNascimentoConjuge").on("change", function() {
        let valor = $("#municipioNascimentoConjuge option:selected").val();
        $("#numeroMunicipioConjuge").val(valor);
    });


    //Alerta caso pais Nascimento não tenha sido selecionado
    $("#ufNascimentoConjuge").on("click", function() {
        let paisNascimentoConjuge = $("#paisNascimentoConjuge").val();
        if (paisNascimentoConjuge == "") {
            smartAlert("Atenção", "Selecione um País de Nascimento do Cônjuge antes de continuar!", "error");
            return;
        }
    });

    $("#ufNascimentoConjuge").on("change", function() {
        let valor = $("#ufNascimentoConjuge option:selected").text();
        if (valor != "EX.") {

            $("#numeroMunicipioConjuge").val(" ");
            $("#naturalidadeConjuge").val(" ");
            const comboMunicipio = document.getElementById("municipioNascimentoConjuge");
            let campoMunicipio = document.createElement("option");
            while (comboMunicipio.length > 0) {
                comboMunicipio.remove(0);
            }
            comboMunicipio.add(campoMunicipio);
            getMunicipioPorUfConjuge($("#ufNascimentoConjuge option:selected").val(), function() {
                $("#ufNascimentoConjuge option:selected").val();
            });
            getSiglaUfConjuge();

        }
       
    });

    $("#linkPdfTransporte").on("click", function() {
        abrePdfTransporte();
        });

    function verificaBanco(){
        
        var possuiContaBancaria = +$('#possuiContaBancaria').val();
        if (possuiContaBancaria == 1) {
            $("#tipoConta").removeClass('readonly');
            $("#tipoConta").addClass('required');
            $("#tipoConta").removeAttr('disabled');

            $("#fk_banco").removeClass('readonly');
            $("#fk_banco").addClass('required');
            $("#fk_banco").removeAttr('disabled');

            $("#agenciaBanco").removeClass('readonly');
            $("#agenciaBanco").addClass('required');
            $("#agenciaBanco").removeAttr('disabled');

            $("#digitoAgenciaBanco").removeClass('readonly');
            $("#digitoAgenciaBanco").addClass('required');
            $("#digitoAgenciaBanco").removeAttr('disabled');

            $("#contaCorrente").removeClass('readonly');
            $("#contaCorrente").addClass('required');
            $("#contaCorrente").removeAttr('disabled');

            $("#variacao").removeClass('readonly');
            $("#variacao").addClass('required');
            $("#variacao").removeAttr('disabled');

            $("#digitoContaBanco").removeClass('readonly');
            $("#digitoContaBanco").addClass('required');
            $("#digitoContaBanco").removeAttr('disabled');
        } else {
            $("#tipoConta").addClass('readonly');
            $("#tipoConta").removeClass('required');
            $("#tipoConta").val('');
            $("#tipoConta").prop('disabled', true);

            $("#fk_banco").addClass('readonly');
            $("#fk_banco").removeClass('required');
            $("#fk_banco").val('');
            $("#fk_banco").prop('disabled', true);

            $("#agenciaBanco").addClass('readonly');
            $("#agenciaBanco").removeClass('required');
            $("#agenciaBanco").val('');
            $("#agenciaBanco").prop('disabled', true);

            $("#digitoAgenciaBanco").addClass('readonly');
            $("#digitoAgenciaBanco").removeClass('required');
            $("#digitoAgenciaBanco").val('');
            $("#digitoAgenciaBanco").prop('disabled', true);

            $("#variacao").addClass('readonly');
            $("#variacao").removeClass('required');
            $("#variacao").val('');
            $("#variacao").prop('disabled', true);

            $("#contaCorrente").addClass('readonly');
            $("#contaCorrente").removeClass('required');
            $("#contaCorrente").val('');
            $("#contaCorrente").prop('disabled', true);

            $("#digitoContaBanco").addClass('readonly');
            $("#digitoContaBanco").removeClass('required');
            $("#digitoContaBanco").val('');
            $("#digitoContaBanco").prop('disabled', true);
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
                recuperaFuncionario(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var out = piece[1];
                            var strArrayFilho = piece[2];
                            var strArrayDependente = piece[3];
                            var strArrayTransporte = piece[4];

                            piece = out.split("^");
                            codigo = piece[0];
                            nomeCompleto = piece[1];
                            cpf = piece[2];
                            dataNascimento = piece[3];
                            naturalidade = piece[4];
                            nacionalidade = piece[5];
                            racaCor = piece[6];
                            estadoCivil = piece[7];
                            nomePai = piece[8];
                            nomeMae = piece[9];
                            ctps = piece[10];
                            pis = piece[11];
                            dataEmissaoCnh = piece[12];
                            dataVencimentoCnh = piece[13];
                            primeiraCnh = piece[14];
                            tituloEleitor = piece[15];
                            zonaTituloEleitor = piece[16];
                            secaoTituloEleitor = piece[17];
                            certificadoReservista = piece[18];
                            telefoneResidencial = piece[19];
                            telefoneCelular = piece[20];
                            outroTelefone = piece[21];
                            email = piece[22];
                            cep = piece[23];
                            endereco = piece[24];
                            bairro = piece[25];
                            numero = piece[26];
                            complemento = piece[27];
                            estado = piece[28];
                            cidade = piece[29];
                            grauInstrucao = piece[30];
                            grauParou = piece[31];
                            anoConclusao = piece[32];
                            cursandoAtualmente = piece[33];
                            horarioEstudo = piece[34];
                            nomeEnderecoColegioUniversidade = piece[35];
                            atividadesExtracurriculares = piece[36];
                            nomeConjuge = piece[37];
                            naturalidadeConjuge = piece[38];
                            nacionalidadeConjuge = piece[39];
                            dataNascimentoConjuge = piece[40];
                            trabalhaAtualmente = piece[41];
                            desejaVt = piece[42];
                            possuiVt = piece[43];
                            numeroCartaoVt = piece[44];
                            seguroDesemprego = piece[45];
                            desejaAssistenciaMedica = piece[46];
                            desejaAssistenciaOdontologica = piece[47];
                            valeRefeicaoValeAlimentacao = piece[48];
                            possuiContaBancaria = piece[49];
                            fk_banco = piece[50];
                            agenciaBanco = piece[51];
                            contaCorrente = piece[52];
                            numeroCamisa = piece[53];
                            numeroCalca = piece[54];
                            numeroSaia = piece[55];
                            numeroSapato = piece[56];
                            cnh = piece[57];
                            categoriaCnh = piece[58];
                            ufCnh = piece[59];
                            rg = piece[60];
                            emissorRg = piece[61];
                            localRg = piece[62];
                            dataEmissaoRg = piece[63];
                            sexo = piece[64];
                            localCarteiraTrabalho = piece[65];
                            primeiroEmprego = piece[66];
                            cargo = piece[67];
                            verificaDadoPessoal = piece[68];
                            verificaDadoContato = piece[69];
                            verificaEndereco = piece[70];
                            verificaDocumento = piece[71];
                            verificaEscolaridade = piece[72];
                            verificaDadoConjuge = piece[73];
                            verificaFilho = piece[74];
                            verificaDependente = piece[75];
                            verificaBeneficio = piece[76];
                            verificaVT = piece[77];
                            verificaDadoBancario = piece[78];
                            verificaCargo = piece[79];
                            verificaUniforme = piece[80];
                            verificaAnexoDocumento = piece[81];
                            carteiraTrabalho = piece[82];
                            carteiraTrabalhoSerie = piece[83];
                            dataExpedicaoCarteiraTrabalho = piece[84];
                            numeroPais = piece[85];
                            paisNascimento = piece[86];
                            ufNascimento = piece[87];
                            numeroMunicipio = piece[88];
                            municipioNascimento = piece[89];

                            numeroPaisConjuge = piece[90];
                            paisNascimentoConjuge = piece[91];
                            ufNascimentoConjuge = piece[92];
                            numeroMunicipioConjuge = piece[93];
                            municipioNascimentoConjuge = piece[94];
                            possuiFilhoMenor14 = piece[95]
                            digitoAgenciaBanco = piece[96];
                            digitoContaBanco = piece[97];
                            tipoConta = piece[98];
                            aprovado = piece[99];
                            variacao = piece[100];
                            codigoBanco = piece[101];
                            projeto = piece[102];
                            let banco = codigoBanco;
                            banco = banco.split("-");
                            banco = banco[0].trim();
                            var logradouro = piece[103];
                            var justificativaVt = piece[104];
                            var tipoCartaoVt = piece[105];

                            let conta = tipoConta //tipoConta:  1 - Corrente  2-Poupança

                            //Muda o nome da label e o valor da variação dependendo do banco e tipo de conta selecionados.
                            if (banco == "104") { //Código da Caixa Econômica  
                                if (conta == "1") {
                                    $("#variacao").val("001");
                                    document.getElementById('labelVariacao').textContent = 'Tipo de Operação';
                                } else if (conta == "2") {
                                    $("#variacao").val("013");
                                    document.getElementById('labelVariacao').textContent = 'Tipo de Operação';
                                }
                            } else if (banco == "341") {
                                if (conta == "2") {
                                    $("#variacao").val("500");
                                    document.getElementById('labelVariacao').textContent = 'Complemento';
                                } else {
                                    document.getElementById('labelVariacao').textContent = 'Variação';
                                }
                            } else if (banco == "001") {
                                if (conta == "2") {
                                    $("#variacao").val("051");
                                    document.getElementById('labelVariacao').textContent = 'Variação';
                                } else {
                                    document.getElementById('labelVariacao').textContent = 'Variação';
                                }
                            } else {
                                document.getElementById('labelVariacao').textContent = 'Variação';
                            }


                            $("#codigo").val(codigo);
                            $("#nomeCompleto").val(nomeCompleto);
                            $("#cpf").val(cpf);
                            $("#dataNascimento").val(dataNascimento);
                            $("#naturalidade").val(naturalidade);
                            $("#nacionalidade").val(nacionalidade);
                            $("#racaCor").val(racaCor);
                            $("#estadoCivil").val(estadoCivil);
                            $("#nomePai").val(nomePai);
                            $("#nomeMae").val(nomeMae);
                            $("#ctps").val(ctps);
                            $("#pis").val(pis);
                            $("#dataEmissaoCnh").val(dataEmissaoCnh);
                            $("#dataVencimentoCnh").val(dataVencimentoCnh);
                            $("#primeiraCnh").val(primeiraCnh);
                            $("#tituloEleitor").val(tituloEleitor);
                            $("#zonaTituloEleitor").val(zonaTituloEleitor);
                            $("#secaoTituloEleitor").val(secaoTituloEleitor);
                            $("#certificadoReservista").val(certificadoReservista);
                            $("#telefoneResidencial").val(telefoneResidencial);
                            $("#telefoneCelular").val(telefoneCelular);
                            $("#outroTelefone").val(outroTelefone);
                            $("#email").val(email);
                            $("#cep").val(cep);
                            $("#endereco").val(endereco);
                            $("#bairro").val(bairro);
                            $("#numero").val(numero);
                            $("#complemento").val(complemento);
                            $("#estado").val(estado)
                            $("#cidade").val(cidade)
                            $("#grauInstrucao").val(grauInstrucao)
                            $("#grauParou").val(grauParou)
                            $("#anoConclusao").val(anoConclusao)
                            $("#cursandoAtualmente").val(cursandoAtualmente)
                            $("#horarioEstudo").val(horarioEstudo)
                            $("#nomeEnderecoColegioUniversidade").val(nomeEnderecoColegioUniversidade)
                            $("#atividadesExtracurriculares").val(atividadesExtracurriculares)
                            $("#nomeConjuge").val(nomeConjuge)
                            $("#naturalidadeConjuge").val(naturalidadeConjuge)
                            $("#nacionalidadeConjuge").val(nacionalidadeConjuge)
                            $("#dataNascimentoConjuge").val(dataNascimentoConjuge)
                            $("#trabalhaAtualmente").val(trabalhaAtualmente)
                            $("#desejaVt").val(desejaVt)
                            $("#possuiVt").val(possuiVt)
                            $("#numeroCartaoVt").val(numeroCartaoVt)
                            $("#seguroDesemprego").val(seguroDesemprego)
                            $("#desejaAssistenciaMedica").val(desejaAssistenciaMedica)
                            $("#desejaAssistenciaOdontologica").val(desejaAssistenciaOdontologica)
                            $("#valeRefeicaoValeAlimentacao").val(valeRefeicaoValeAlimentacao)
                            $("#possuiContaBancaria").val(possuiContaBancaria)
                            $("#fk_banco").val(fk_banco)
                            $("#agenciaBanco").val(agenciaBanco)
                            $("#contaCorrente").val(contaCorrente)
                            $("#numeroCamisa").val(numeroCamisa)
                            $("#numeroCalca").val(numeroCalca)
                            $("#numeroSaia").val(numeroSaia)
                            $("#numeroSapato").val(numeroSapato)
                            $("#cnh").val(cnh)
                            $("#categoriaCnh").val(categoriaCnh)
                            $("#ufCnh").val(ufCnh)
                            $("#rg").val(rg)
                            $("#emissorRg").val(emissorRg)
                            $("#localRg").val(localRg)
                            $("#dataEmissaoRg").val(dataEmissaoRg)
                            $("#sexo").val(sexo)
                            $("#localCarteiraTrabalho").val(localCarteiraTrabalho);
                            $("#primeiroEmprego").val(primeiroEmprego);
                            $("#cargo").val(cargo);
                            $("#jsonFilho").val(strArrayFilho);
                            $("#jsonDependente").val(strArrayDependente);

                            $("#verificaDadoPessoal").val(verificaDadoPessoal)
                            $("#verificaDadoContato").val(verificaDadoContato)
                            $("#verificaEndereco").val(verificaEndereco)
                            $("#verificaDocumento").val(verificaDocumento);
                            $("#verificaEscolaridade").val(verificaEscolaridade);
                            $("#verificaDadoConjuge").val(verificaDadoConjuge);
                            $("#verificaFilho").val(verificaFilho);
                            $("#verificaDependente").val(verificaDependente);
                            $("#verificaBeneficio").val(verificaBeneficio)
                            $("#verificaVT").val(verificaVT);
                            $("#verificaDadoBancario").val(verificaDadoBancario);
                            $("#verificaCargo").val(verificaCargo);
                            $("#verificaUniforme").val(verificaUniforme);
                            $("#verificaAnexoDocumento").val(verificaAnexoDocumento);
                            $("#carteiraTrabalho").val(carteiraTrabalho);
                            $("#carteiraTrabalhoSerie").val(carteiraTrabalhoSerie);
                            $("#dataExpedicaoCarteiraTrabalho").val(dataExpedicaoCarteiraTrabalho);
                            // funcionario pais/estado/municipio
                            $("#numeroPais").val(numeroPais);
                            $("#paisNascimento").val(paisNascimento);
                            $("#logradouro").val(logradouro);
                            verificaBanco();


                            //funcionario EX.
                            let valor = $("#paisNascimento").val();
                            $("#numeroPais").val(valor);

                            if (valor) {
                                if (valor != 105) { //Código do Brasil

                                    $("#nacionalidade").val("EX.");
                                    $("#naturalidade").val("EX.");

                                    //Limpa tudo da combo de Município e atribui EX. pra ela.
                                    const comboMunicipio = document.getElementById("municipioNascimento");
                                    let campoMunicipio = document.createElement("option");
                                    while (comboMunicipio.length > 0) {
                                        comboMunicipio.remove(0);
                                    }
                                    campoMunicipio.text = "EX."
                                    campoMunicipio.value = "EX."
                                    comboMunicipio.add(campoMunicipio);
                                    comboMunicipio.selectedIndex = "0";
                                    $("#numeroMunicipio").val(campoMunicipio.value);

                                    const comboUf = document.getElementById("ufNascimento");
                                    let campoUf = document.createElement("option");
                                    while (comboUf.length > 0) {
                                        comboUf.remove(0);
                                    }
                                    campoUf.text = "EX."
                                    campoUf.value = "EX."
                                    comboUf.add(campoUf);
                                    comboUf.selectedIndex = "0";
                                } else {

                                    getUf(function() {
                                        $("#ufNascimento").val(ufNascimento);
                                    });

                                    getMunicipioPorUf(ufNascimento, function() {
                                        $("#municipioNascimento").val(municipioNascimento);
                                    });
                                    $("#numeroMunicipio").val(numeroMunicipio);
                                }
                            }
                            //fim funcionario pais nascimentndo 
                            //conjuge pais/estado/municipio
                            $("#numeroPaisConjuge").val(numeroPaisConjuge);
                            $("#paisNascimentoConjuge").val(paisNascimentoConjuge);
                            //conjuge ex
                            let valorConjuge = $("#paisNascimentoConjuge").val();
                            $("#numeroPaisConjuge").val(valorConjuge);

                            if (valorConjuge) {
                                if (valorConjuge != 105) { //Código do Brasil

                                    $("#nacionalidadeConjuge").val("EX.");
                                    $("#naturalidadeConjuge").val("EX.");

                                    //Limpa tudo da combo de Município e atribui EX. pra ela.
                                    const comboMunicipio = document.getElementById("municipioNascimentoConjuge");
                                    let campoMunicipio = document.createElement("option");
                                    while (comboMunicipio.length > 0) {
                                        comboMunicipio.remove(0);
                                    }
                                    campoMunicipio.text = "EX."
                                    campoMunicipio.value = "EX."
                                    comboMunicipio.add(campoMunicipio);
                                    comboMunicipio.selectedIndex = "0";
                                    $("#numeroMunicipioConjuge").val(campoMunicipio.value);

                                    const comboUf = document.getElementById("ufNascimentoConjuge");
                                    let campoUf = document.createElement("option");
                                    while (comboUf.length > 0) {
                                        comboUf.remove(0);
                                    }
                                    campoUf.text = "EX."
                                    campoUf.value = "EX."
                                    comboUf.add(campoUf);
                                    comboUf.selectedIndex = "0";
                                } else {

                                    getUfConjuge(function() {
                                        $("#ufNascimentoConjuge").val(ufNascimentoConjuge);
                                    });

                                    getMunicipioPorUfConjuge(ufNascimentoConjuge, function() {
                                        $("#municipioNascimentoConjuge").val(municipioNascimentoConjuge);
                                    });
                                    $("#numeroMunicipioConjuge").val(numeroMunicipioConjuge);
                                    $("#municipioNascimentoConjuge").val(municipioNascimentoConjuge);
                                }
                            }
                            $("#possuiFilhoMenor14").val(possuiFilhoMenor14);
                            $("#digitoAgenciaBanco").val(digitoAgenciaBanco);
                            $("#digitoContaBanco").val(digitoContaBanco);
                            $("#tipoConta").val(tipoConta);
                            $("#aprovado").val(aprovado);
                            $("#variacao").val(variacao);
                            $("#projeto").val(projeto);
                            $("#jsonTransporte").val(strArrayTransporte);

                            if (justificativaVt != "") {
                                $("#justificativaVt").removeAttr("class");
                                $("#justificativaVt").prop('readonly', false);
                                $("#justificativaVt").addClass('required');
                                $("#justificativaVt").prop('required', true);
                                $("#justificativaVt").val(justificativaVt);
                            } else {
                                $("#justificativaVt").addClass("readonly");
                                $("#justificativaVt").val('');
                                $("#justificativaVt").prop('readonly', true);
                            }

                            if (tipoCartaoVt != "") {

                                $("#tipoCartaoVt").val(tipoCartaoVt);
                                $("#tipoCartaoVt").removeClass('readonly');
                                $("#tipoCartaoVt").removeAttr('disabled');
                            }


                            jsonFilhoArray = JSON.parse($("#jsonFilho").val());
                            jsonDependenteArray = JSON.parse($("#jsonDependente").val());
                            jsonTransporteArray = JSON.parse($("#jsonTransporte").val());
                            fillTableFilho();
                            fillTableDependente();
                            fillTableTransporte();
                        }
                    }
                );
                recuperaUpload(idd,
                    function(data) {
                        if (data.indexOf('failed') > -1) {} else {
                            data = data.replace(/failed/g, '');
                            var piece = data.split("#");
                            var mensagem = piece[0];
                            var arrayDocumentos = JSON.parse(piece[1]);
                            for (let index = 0; index < arrayDocumentos.length; index++) {
                               
                                var nomeArquivo = arrayDocumentos[index].nomeArquivo;
                                var nomeVisualizacao = nomeArquivo.split("_");
                                var tipoArquivo = arrayDocumentos[index].tipoArquivo; 
                                var nomeCampo = arrayDocumentos[index].idCampo + "." + tipoArquivo;
                                var idCampo = arrayDocumentos[index].idCampo + "Link";
                                var endereco = arrayDocumentos[index].enderecoDocumento; 
                                var diretorio = "<?php echo $linkUpload ?>" + endereco + nomeArquivo;

                                $("#" + idCampo).append("<a href ='" + diretorio + "' target='_blank'>" + nomeVisualizacao[1] + "</a><br>");

                            } 
                        }
                    });
            }
        }
        $("#nome").focus();
    }

    function novo() {
        // $(location).attr('href', 'funcionarioCadastro.php');
        var candidato = "<?= $tipoUsuario ?>";
        candidato == 'T' ? $(location).attr('href', 'login.php') : $(location).attr('href', 'contratacao_candidatoCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'contratacao_candidatoFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirCandidato(id);
    }
    //############################################################################## DOCUMENTOS ####################################################################################################################

    function readURL(input) {
        var campo = input.name;
        campo = campo.replace("Arquivo", "Imagem");

        if (input.files && input.files[0]) {
            if (input.files[0].type != "application/pdf" && input.files[0].type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#' + campo).show();
                    $('#' + campo).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        } else {
            $('#' + campo).hide();
        }
    }

    //############################################################################## LISTA DEPENDENTE INICIO ####################################################################################################################

    function fillTableDependente() {
        $("#tableDependente tbody").empty();
        for (var i = 0; i < jsonDependenteArray.length; i++) {

            var row = $('<tr />');
            $("#tableDependente tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonDependenteArray[i].sequencialDependente + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaDependente(' + jsonDependenteArray[i].sequencialDependente + ');">' + jsonDependenteArray[i].nomeDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].cpfDependente + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonDependenteArray[i].dataNascimentoDependente + '</td>'));
            var grauParentescoDependente = $("#grauParentescoDependente option[value = '" + jsonDependenteArray[i].grauParentescoDependente + "']").text();
            row.append($('<td class="text-nowrap">' + grauParentescoDependente + '</td>'));
        }
    }

    function validaDependente() {
        var achouCPF = false;
        var achouRG = false;
        var cpfDependente = $('#cpfDependente').val();
        var nomeDependente = $('#nomeDependente').val();
        var dataNascimentoDependente = $('#dataNascimentoDependente').val();
        var grauParentescoDependente = $('#grauParentescoDependente').val();
        var sequencial = +$('#sequencialDependente').val();

        if (nomeDependente === '') {
            smartAlert("Erro", "Informe o Nome do Dependente", "error");
            return false;
        }
        if (cpfDependente === '') {
            smartAlert("Erro", "Informe o CPF do Dependente", "error");
            return false;
        }
        if (dataNascimentoDependente === '') {
            smartAlert("Erro", "Informe a Data de Nascimento do Dependente", "error");
            return false;
        }
        if (grauParentescoDependente === '') {
            smartAlert("Erro", "Informe o Parentesco do Depentende", "error");
            return false;
        }


        for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
            if (cpfDependente !== "") {
                if ((jsonDependenteArray[i].cpfDependente === cpfDependente) && (jsonDependenteArray[i].sequencialDependente !== sequencial)) {
                    achouCPF = true;
                    break;
                }
            }
        }

        if (achouCPF === true) {
            smartAlert("Erro", "Já existe o CPF do Dependente na lista.", "error");
            return false;
        }

        return true;
    }

    function addDependente() {

        var item = $("#formDependente").toObject({
            mode: 'combine',
            skipEmpty: false
            // nodeCallback: processDataDependente
        });

        if (item["sequencialDependente"] === '') {
            if (jsonDependenteArray.length === 0) {
                item["sequencialDependente"] = 1;
            } else {
                item["sequencialDependente"] = Math.max.apply(Math, jsonDependenteArray.map(function(o) {
                    return o.sequencialDependente;
                })) + 1;
            }
            item["dependenteId"] = 0;
        } else {
            item["sequencialDependente"] = +item["sequencialDependente"];
        }

        var index = -1;
        $.each(jsonDependenteArray, function(i, obj) {
            if (+$('#sequencialDependente').val() === obj.sequencialDependente) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonDependenteArray.splice(index, 1, item);
        else
            jsonDependenteArray.push(item);

        $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
        fillTableDependente();
        clearFormDependente();

    }

    function processDataDependente(node) {
        // var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        // var fieldName = node.getAttribute ? node.getAttribute('name') : '';


        // if (fieldName !== '' && (fieldId === "descricaoDataNascimentoDependente")) {

        //     return {
        //         name: fieldName,
        //         value: $("#dataNascimentoDependente").val()
        //     };
        // }


        // if (fieldName !== '' && (fieldId === "dataNascimentoDependente")) {

        //     var dataNascimentoDependente = $('#dataNascimentoDependente').val();
        //     dataNascimentoDependente = dataNascimentoDependente.split("/");
        //     dataNascimentoDependente = dataNascimentoDependente[2] + "/" + dataNascimentoDependente[1] + "/" + dataNascimentoDependente[0];

        //     return {
        //         name: fieldName,
        //         value: dataNascimentoDependente
        //     };
        // }

        // return false;
    }

    function clearFormDependente() {
        $("#nomeDependente").val('');
        $("#dataNascimentoDependente").val('');
        $("#cpfDependente").val('');
        $("grauParentescoDependente").val('');
        $("#dependenteId").val('');
        $("#sequencialDependente").val('');
        $('#dataNascimentoDependente').val('');
    }

    function carregaDependente(sequencialDependente) {
        var arr = jQuery.grep(jsonDependenteArray, function(item, i) {
            return (item.sequencialDependente === sequencialDependente);
        });

        clearFormDependente();

        if (arr.length > 0) {
            var item = arr[0];
            $("#nomeDependente").val(item.nomeDependente);
            $("#dataNascimentoDependente").val(item.dataNascimentoDependente);
            $("#cpfDependente").val(item.cpfDependente);
            $("#grauParentescoDependente").val(item.grauParentescoDependente);
            $("#dependenteId").val(item.dependenteId);
            $("#sequencialDependente").val(item.sequencialDependente);
        }
    }


    function excluirDependente() {
        var arrSequencial = [];
        $('#tableDependente input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
                var obj = jsonDependenteArray[i];
                if (jQuery.inArray(obj.sequencialDependente, arrSequencial) > -1) {
                    jsonDependenteArray.splice(i, 1);
                }
            }
            $("#jsonDependente").val(JSON.stringify(jsonDependenteArray));
            fillTableDependente();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 dependente para excluir.", "error");
    }


    //############################################################################## LISTA FILHO INICIO ####################################################################################################################

    function fillTableFilho() {
        $("#tableFilho tbody").empty();
        for (var i = 0; i < jsonFilhoArray.length; i++) {
            var row = $('<tr />');
            $("#tableFilho tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonFilhoArray[i].sequencialFilho + '"><i></i></label></td>'));
            row.append($('<td class="text-nowrap" onclick="carregaFilho(' + jsonFilhoArray[i].sequencialFilho + ');">' + jsonFilhoArray[i].nomeFilho + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFilhoArray[i].cpfFilho + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonFilhoArray[i].dataNascimentoFilho + '</td>'));
        }
    }

    function validaFilho() {
        var achouCPF = false;
        var achouRG = false;
        var nomeFilho = $('#nomeFilho').val();
        var cpfFilho = $('#cpfFilho').val();
        var dataNascimentoFilho = $('#dataNascimentoFilho').val();
        var sequencial = +$('#sequencialFilho').val();

        if (nomeFilho === '') {
            smartAlert("Erro", "Informe o Nome do Filho(a)", "error");
            return false;
        }
        if (cpfFilho === '') {
            smartAlert("Erro", "Informe o CPF do Filho", "error");
            return false;
        }
        if (dataNascimentoFilho === '') {
            smartAlert("Erro", "Informe a Data de Nascimento do Filho", "error");
            return false;
        }

        for (i = jsonFilhoArray.length - 1; i >= 0; i--) {
            if (cpfFilho !== "") {
                if ((jsonFilhoArray[i].cpfFilho === cpfFilho) && (jsonFilhoArray[i].sequencialFilho !== sequencial)) {
                    achouCPF = true;
                    break;
                }
            }
        }

        if (achouCPF === true) {
            smartAlert("Erro", "Já existe o CPF do Filho na lista.", "error");
            return false;
        }

        return true;
    }

    function addFilho() {

        var item = $("#formFilho").toObject({
            mode: 'combine',
            skipEmpty: false
            // nodeCallback: processDataFilho
        });

        if (item["sequencialFilho"] === '') {
            if (jsonFilhoArray.length === 0) {
                item["sequencialFilho"] = 1;
            } else {
                item["sequencialFilho"] = Math.max.apply(Math, jsonFilhoArray.map(function(o) {
                    return o.sequencialFilho;
                })) + 1;
            }
            item["filhoId"] = 0;
        } else {
            item["sequencialFilho"] = +item["sequencialFilho"];
        }

        var index = -1;
        $.each(jsonFilhoArray, function(i, obj) {
            if (+$('#sequencialFilho').val() === obj.sequencialFilho) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonFilhoArray.splice(index, 1, item);
        else
            jsonFilhoArray.push(item);

        $("#jsonFilho").val(JSON.stringify(jsonFilhoArray));
        fillTableFilho();
        clearFormFilho();

    }

    function processDataFilho(node) {
        // var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        // var fieldName = node.getAttribute ? node.getAttribute('name') : '';



        // if (fieldName !== '' && (fieldId === "dataNascimentoFilho")) {

        //     var dataNascimentoFilho = $('#dataNascimentoFilho').val();
        //     dataNascimentoFilho = dataNascimentoFilho.split("/");
        //     dataNascimentoFilho = dataNascimentoFilho[2] + "/" + dataNascimentoFilho[1] + "/" + dataNascimentoFilho[0];

        //     return {
        //         name: fieldName,
        //         value: dataNascimentoFilho
        //     };
        // }

        // return false;
    }

    function clearFormFilho() {
        $("#nomeFilho").val('');
        $("#dataNascimentoFilho").val('');
        $("#cpfFilho").val('');
        $("#filhoId").val('');
        $("#sequencialFilho").val('');
        $('#descricaoDataNascimentoFilho').val('');
    }

    function carregaFilho(sequencialFilho) {
        var arr = jQuery.grep(jsonFilhoArray, function(item, i) {
            return (item.sequencialFilho === sequencialFilho);
        });

        clearFormFilho();

        if (arr.length > 0) {
            var item = arr[0];
            $("#nomeFilho").val(item.nomeFilho);
            $("#dataNascimentoFilho").val(item.dataNascimentoFilho);
            $("#cpfFilho").val(item.cpfFilho);
            $("#filhoId").val(item.filhoId);
            $("#sequencialFilho").val(item.sequencialFilho);
        }
    }


    function excluirFilho() {
        var arrSequencial = [];
        $('#tableFilho input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonFilhoArray.length - 1; i >= 0; i--) {
                var obj = jsonFilhoArray[i];
                if (jQuery.inArray(obj.sequencialFilho, arrSequencial) > -1) {
                    jsonFilhoArray.splice(i, 1);
                }
            }
            $("#jsonFilho").val(JSON.stringify(jsonFilhoArray));
            fillTableFilho();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Filho para excluir.", "error");
    }

    //############################################################################## LISTA Filho FIM #######################################################################################################################


    //############################################################################## LISTA TRANSPORTE INICIO ####################################################################################################################

    function fillTableTransporte() {
        $("#tableTransporte tbody").empty();
        for (var i = 0; i < jsonTransporteArray.length; i++) {

            var row = $('<tr />');
            $("#tableTransporte tbody").append(row);
            row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTransporteArray[i].sequencialTransporte + '"><i></i></label></td>'));
            // row.append($('<td class="text-nowrap" onclick="carregaTransporte(' + jsonTransporteArray[i].sequencialTransporte + ');">' + jsonTransporteArray[i].trajetoTransporte + '</td>'));

            var trajetoTransporte = $("#trajetoTransporte option[value = '" + jsonTransporteArray[i].trajetoTransporte + "']").text();

            row.append($('<td class="text-nowrap" onclick="carregaTransporte(' + jsonTransporteArray[i].sequencialTransporte + ');">' + trajetoTransporte + '</td>'));


            var tipoTransporte = $("#tipoTransporte option[value = '" + jsonTransporteArray[i].tipoTransporte + "']").text();
            row.append($('<td class="text-nowrap">' + tipoTransporte + '</td>'));

            row.append($('<td class="text-nowrap">' + jsonTransporteArray[i].linhaTransporte + '</td>'));
            row.append($('<td class="text-nowrap">' + jsonTransporteArray[i].valorTransporte + '</td>'));
            // var grauParentescoTransporte = $("#grauParentescoTransporte option[value = '" + jsonTransporteArray[i].grauParentescoTransporte + "']").text();
            // row.append($('<td class="text-nowrap">' + grauParentescoTransporte + '</td>'));
        }
    }

    function validaTransporte() {

        var trajetoTransporte = $('#trajetoTransporte').val();
        var tipoTransporte = $('#tipoTransporte').val();
        var linhaTransporte = $('#linhaTransporte').val();
        var valorTransporte = $('#valorTransporte').val();
        var sequencial = +$('#sequencialTransporte').val();

        if (trajetoTransporte === '') {
            smartAlert("Erro", "Informe o Trajeto do Transporte", "error");
            return false;
        }
        if (tipoTransporte === '') {
            smartAlert("Erro", "Informe o Tipo do Transporte", "error");
            return false;
        }
        if (linhaTransporte === '') {
            smartAlert("Erro", "Informe a Linha do Transporte", "error");
            return false;
        }
        if (valorTransporte === '') {
            smartAlert("Erro", "Informe o Valor do Transporte", "error");
            return false;
        }

        return true;
    }

    function addTransporte() {

        var item = $("#formTransporte").toObject({
            mode: 'combine',
            skipEmpty: false
            // nodeCallback: processDataTransporte
        });

        if (item["sequencialTransporte"] === '') {
            if (jsonTransporteArray.length === 0) {
                item["sequencialTransporte"] = 1;
            } else {
                item["sequencialTransporte"] = Math.max.apply(Math, jsonTransporteArray.map(function(o) {
                    return o.sequencialTransporte;
                })) + 1;
            }
            item["transporteId"] = 0;
        } else {
            item["sequencialTransporte"] = +item["sequencialTransporte"];
        }

        var index = -1;
        $.each(jsonTransporteArray, function(i, obj) {
            if (+$('#sequencialTransporte').val() === obj.sequencialTransporte) {
                index = i;
                return false;
            }
        });

        if (index >= 0)
            jsonTransporteArray.splice(index, 1, item);
        else
            jsonTransporteArray.push(item);

        $("#jsonTransporte").val(JSON.stringify(jsonTransporteArray));
        fillTableTransporte();
        clearFormTransporte();

    }

    function clearFormTransporte() {
        $("#trajetoTransporte").val('');
        $("#tipoTransporte").val('');
        $("#linhaTransporte").val('');
        $("#valorTransporte").val('');
        $("#transporteId").val('');
        $("#sequencialTransporte").val('');
    }

    function carregaTransporte(sequencialTransporte) {
        var arr = jQuery.grep(jsonTransporteArray, function(item, i) {
            return (item.sequencialTransporte === sequencialTransporte);
        });

        clearFormTransporte();

        if (arr.length > 0) {
            var item = arr[0];
            $("#trajetoTransporte").val(item.trajetoTransporte);
            $("#tipoTransporte").val(item.tipoTransporte);
            $("#linhaTransporte").val(item.linhaTransporte);
            $("#valorTransporte").val(item.valorTransporte);
            $("#transporteId").val(item.transporteId);
            $("#sequencialTransporte").val(item.sequencialTransporte);
        }
    }


    function excluirTransporte() {
        var arrSequencial = [];
        $('#tableTransporte input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTransporteArray.length - 1; i >= 0; i--) {
                var obj = jsonTransporteArray[i];
                if (jQuery.inArray(obj.sequencialTransporte, arrSequencial) > -1) {
                    jsonTransporteArray.splice(i, 1);
                }
            }
            $("#jsonTransporte").val(JSON.stringify(jsonTransporteArray));
            fillTableTransporte();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 Transporte para excluir.", "error");
    }


    //############################################################################## LISTA TRANSPORTE FIM ####################################################################################################################




    function gravar() {

        let form = $('#formFuncionario')[0];
        let formData = new FormData(form);
        formData.append('funcao', 'gravaFuncionario');

        let nomeCompleto = $("#nomeCompleto").val();
        let dataNascimento = $("#dataNascimento").val();
        let sexo = $("#sexo").val();
        let paisNascimento = $("#paisNascimento").val();
        let ufNascimento = $("#ufNascimento").val();
        let municipioNascimento = $("#municipioNascimento").val();
        let racaCor = $("#racaCor").val();
        let estadoCivil = $("#estadoCivil").val();
        let nomePai = $("#nomePai").val();
        let nomeMae = $("#nomeMae").val();
        let cpf = $("#cpf").val();
        let possuiPIS = $("#ctps").val();
        let rg = $("#rg").val();
        let emissorRg = $("#emissorRg").val();
        let cep = $("#cep").val();
        let endereco = $("#endereco").val();
        let bairro = $("#bairro").val();
        let cidade = $("#cidade").val();
        let numero = $("#numero").val();
        let desejaVt = $("#desejaVt").val();
        let possuiFilhoMenor14 = $("#possuiFilhoMenor14").val();
        let possuiVt = $("#possuiVt").val();
        let trabalhaAtualmente = $("#trabalhaAtualmente").val();
        let seguroDesemprego = $("#seguroDesemprego").val();
        let desejaAssistenciaMedica = $("#desejaAssistenciaMedica").val();
        let valeRefeicaoValeAlimentacao = $("#valeRefeicaoValeAlimentacao").val();
        let possuiContaBancaria = $("#possuiContaBancaria").val();
        let email = $("#email").val();

        if (!nomeCompleto) {
            smartAlert("Atenção", "Digite o Nome Completo", "error");
            return;
        }

        if (!dataNascimento) {
            smartAlert("Atenção", "Selecione a Data de Nascimento", "error");
            return;
        }

        if (!sexo) {
            smartAlert("Atenção", "Selecione o Sexo", "error");
            return;
        }

        if (!paisNascimento) {
            smartAlert("Atenção", "Selecione o País de Nascimento", "error");
            return;
        }

        if (!ufNascimento) {
            smartAlert("Atenção", "Selecione a UF de Nascimento", "error");
            return;
        }

        if (!municipioNascimento) {
            smartAlert("Atenção", "Selecione a Cidade de Nascimento", "error");
            return;
        }

        if (!racaCor) {
            smartAlert("Atenção", "Selecione a Raça/Cor", "error");
            return;
        }

        if (!estadoCivil) {
            smartAlert("Atenção", "Selecione o Estado Civil", "error");
            return;
        }

        if (!nomePai) {
            smartAlert("Atenção", "Digite o Nome do Pai.  Se não tiver, digite 'Ausente'", "error");
            return;
        }

        if (!nomeMae) {
            smartAlert("Atenção", "Digite o Nome da Mae.  Se não tiver, digite 'Ausente'", "error");
            return;
        }

        if (!email) {
            smartAlert("Atenção", "Digite o email", "error");
            return;
        }

        if (!cpf) {
            smartAlert("Atenção", "Digite o CPF", "error");
            return;
        }

        if (possuiPIS == 1) {
            let pis = $("#pis").val();
            if (!pis) {
                smartAlert("Atenção", "Digite o PIS", "error");
                return;
            }

        } else if (!possuiPIS) {
            smartAlert("Atenção", "Selecione se possui PIS ou não", "error");
            return;
        }

        if (!rg) {
            smartAlert("Atenção", "Digite o RG", "error");
            return;
        }

        if (!emissorRg) {
            smartAlert("Atenção", "Digite o Emissor do RG", "error");
            return;
        }

        if (!cep) {
            smartAlert("Atenção", "Digite o CEP", "error");
            return;
        }

        if (!endereco) {
            smartAlert("Atenção", "Digite o Endereço", "error");
            return;
        }

        if (!bairro) {
            smartAlert("Atenção", "Digite o Bairro", "error");
            return;
        }

        if (!cidade) {
            smartAlert("Atenção", "Digite a Cidade", "error");
            return;
        }

        if (!numero) {
            smartAlert("Atenção", "Digite o Número", "error");
            return;
        }

        if (!possuiFilhoMenor14) {
            smartAlert("Atenção", "Selecione se possui filho menor de 14 anos ou não.", "error");
            return;
        }

        if (!desejaVt) {
            smartAlert("Atenção", "Selecione se deseja vale de transporte ou não.", "error");
            return;
        }

        if (!possuiVt) {
            smartAlert("Atenção", "Selecione se possui vale de transporte ou não.", "error");
            return;
        }

        if (!trabalhaAtualmente) {
            smartAlert("Atenção", "Selecione se trabalha atualmente.", "error");
            return;
        }

        if (!seguroDesemprego) {
            smartAlert("Atenção", "Selecione se está em seguro desemprego.", "error");
            return;
        }

        if (!desejaAssistenciaMedica) {
            smartAlert("Atenção", "Selecione deseja assistência médica.", "error");
            return;
        }

        if (!valeRefeicaoValeAlimentacao) {
            smartAlert("Atenção", "Selecione o que quiser receber: Vale Refeição ou Vale Alimentação.", "error");
            return;
        }

        if (!possuiContaBancaria) {
            smartAlert("Atenção", "Selecione se possui ou não conta bancária.", "error");
            return;
        }

        gravaFuncionario(formData);
    }

    function gravarDocumento(id) {

        codigoFuncionario = id;
        let form = $('#formFuncionario')[0];
        let formData = new FormData(form);
        formData.append('funcao', 'grava');
        formData.append('codigoFuncionario', codigoFuncionario);
        gravaUpload(formData);

    }

    function arrayArquivos(campo) {
        var files = document.getElementById(campo).files;
        var array = [];
        for (var i = 0; i < files.length; i++) {
            array.push(files[i].name);
        }
        return array;
    }

    function verificaNome(campo) {
        var texto = $(campo).val();
        // var texto = document.getElementById(inputField.value);
        for (letra of texto) {
            if (!isNaN(texto)) {

                // alert("Não digite números");
                //  document.getElementById("entrada").value="";
                smartAlert("Erro", "Não digite caracteres que não sejam letras ou espaço", "error");
                $(campo).val("");
                return;
            }
            letraspermitidas = "ABCEDFGHIJKLMNOPQRSTUVXWYZ abcdefghijklmnopqrstuvxwyzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ"
            var ok = false;
            for (letra2 of letraspermitidas) {

                if (letra == letra2) {

                    ok = true;
                }
            }
            if (!ok) {
                //                    alert("Não digite caracteres que não sejam letras ou espaços");
                smartAlert("Erro", "Não digite caracteres que não sejam letras ou espaços", "error");
                // document.getElementById("entrada").value="";
                $(campo).val("");
                return;

            }
        }
    }

    function verificaCelular($telefone) {
        $telefone = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

        $regexTelefone = "^[0-9]{11}$";

        //$regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
        if (preg_match($regexCel, $telefone)) {
            return true;
        } else {
            return false;
        }
    }


    function validaCampoData(campo) {
        var valor = $(campo).val();
        var validacao = validaData(valor); //Chama a função validaData dentro do gir_script.js
        if (validacao === false) {
            $(campo).val("");
        }
    }

    function validaData(valor) {
        var date = valor;
        var ardt = new Array;
        var ExpReg = new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
        ardt = date.split("/");
        erro = false;
        if (date.search(ExpReg) == -1) {
            erro = true;
        } else if (((ardt[1] == 4) || (ardt[1] == 6) || (ardt[1] == 9) || (ardt[1] == 11)) && (ardt[0] > 30))
            erro = true;
        else if (ardt[1] == 2) {
            if ((ardt[0] > 28) && ((ardt[2] % 4) != 0))
                erro = true;
            if ((ardt[0] > 29) && ((ardt[2] % 4) == 0))
                erro = true;
        }
        if (erro) {
            smartAlert("Erro", "O valor inserido é inválido.", "error");
            return false;
        }
        return true;
    }

    function validateHhMm(inputField) {
        var isValid = /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);
        if (!isValid) {
            // inputField.style.backgroundColor = '#fba';
            smartAlert("Atenção", "Hora Inválida!", "error");
            $(inputField).val('');
        }
        return isValid;
    }

    function verificaCpf(inputField) {
        var valor = $(inputField).val();
        var retorno = validacao_cpf(valor);
        if (retorno === false) {
            smartAlert("Atenção", "O cpf digitado é inválido.", "error");
            $(inputField).val('');
            return;
        }
    }

    /*Funções relacionadas a API do IBGE e Cidade */

    function limparCombo(idCampo) {
        const combo = document.getElementById(idCampo);
        while (combo.length > 0) {
            combo.remove(0);
        }
    }

    function removerCampoEx(idCampo) {
        const combo = document.getElementById(idCampo);
        let campo = document.createElement("option");
        for (var i = 0; i < combo.length; i++) {
            if (combo.options[i].value == 'EX.')
                combo.remove(i);
        }
        combo.add(campo);
    }

    function adicionarExCombo(idCampo) { //Adiciona o valor EX. a uma determinada combo
        const combo = document.getElementById(idCampo);
        let campo = document.createElement("option");
        campo.text = "EX."
        campo.value = "EX."
        combo.add(campo);
    }


    function getUf(callback) {
        $.ajax({
            method: 'GET',
            url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/',

            success: function(data) {
                const comboUf = document.getElementById("ufNascimento");

                for (let i in data) { // Para cada linha em JSON, é criado uma nova opção na combo ufNascimento.

                    let campoUf = document.createElement("option");
                    campoUf.text = data[i].nome;
                    campoUf.value = data[i].id;
                    comboUf.add(campoUf);
                }

                sortSelect(comboUf); //Arruma o select em ordem alfabética
                callback();
            }
        })
    }

    function getMunicipioPorUf(valor, callback) {

        $.ajax({
            method: 'GET',
            url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + valor + "/municipios",

            success: function(data) {
                const comboMunicipio = document.getElementById("municipioNascimento");

                for (let i in data) { // Para cada linha em JSON, é criado uma nova opção na combo municipioNascimento.

                    let campoMunicipio = document.createElement("option");
                    campoMunicipio.text = data[i].nome;
                    campoMunicipio.value = data[i].id;
                    comboMunicipio.add(campoMunicipio);
                }

                sortSelect(comboMunicipio); //Arruma o select em ordem alfabética
                callback();
            }
        })
    }


    async function getSiglaUf() {
        let valor = $("#ufNascimento option:selected").val();
        const api_ibge_url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + valor;
        const resposta = await fetch(api_ibge_url);
        const data = await resposta.json();
        let sigla = data.sigla;
        $("#naturalidade").val(sigla);

    }


    /*Funções que vão até o IBGE Conjuge */
    function getUfConjuge(callback) {
        $.ajax({
            method: 'GET',
            url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/',

            success: function(data) {
                const comboUfConjuge = document.getElementById("ufNascimentoConjuge");

                for (let i in data) { // Para cada linha em JSON, é criado uma nova opção na combo ufNascimento.

                    let campoUfConjuge = document.createElement("option");
                    campoUfConjuge.text = data[i].nome;
                    campoUfConjuge.value = data[i].id;
                    comboUfConjuge.add(campoUfConjuge);
                }

                sortSelect(comboUfConjuge); //Arruma o select em ordem alfabética
                callback();
            }
        })
    }

    function getMunicipioPorUfConjuge(valor, callback) {

        $.ajax({
            method: 'GET',
            url: "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + valor + "/municipios",

            success: function(data) {
                const comboMunicipio = document.getElementById("municipioNascimentoConjuge");

                for (let i in data) { // Para cada linha em JSON, é criado uma nova opção na combo municipioNascimento.

                    let campoMunicipio = document.createElement("option");
                    campoMunicipio.text = data[i].nome;
                    campoMunicipio.value = data[i].id;
                    comboMunicipio.add(campoMunicipio);
                }

                sortSelect(comboMunicipio); //Arruma o select em ordem alfabética
                callback();
            }
        })
    }


    async function getSiglaUfConjuge() {
        let valor = $("#ufNascimentoConjuge option:selected").val();
        const api_ibge_url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" + valor;
        const resposta = await fetch(api_ibge_url);
        const data = await resposta.json();
        let sigla = data.sigla;
        $("#naturalidadeConjuge").val(sigla);

    }


    function sortSelect(selElem) {
        var tmpAry = new Array();
        for (var i = 0; i < selElem.options.length; i++) {
            tmpAry[i] = new Array();
            tmpAry[i][0] = selElem.options[i].text;
            tmpAry[i][1] = selElem.options[i].value;
        }
        tmpAry.sort();
        while (selElem.options.length > 0) {
            selElem.options[0] = null;
        }
        for (var i = 0; i < tmpAry.length; i++) {
            var op = new Option(tmpAry[i][0], tmpAry[i][1]);
            selElem.options[i] = op;
        }
        return;
    }

    function verificaNumero(campo) {
        var texto = $(campo).val();
        // var texto = document.getElementById(inputField.value);
        for (letra of texto) {
            if (isNaN(texto)) {

                // alert("Não digite números");
                //  document.getElementById("entrada").value="";
                smartAlert("Erro", "Digite Somente numeros", "error");
                $(campo).val("");
                return;
            }
            letraspermitidas = "0123456789"
            var ok = false;
            for (letra2 of letraspermitidas) {

                if (letra == letra2) {

                    ok = true;
                }
            }
            if (!ok) {
                //                    alert("Não digite caracteres que não sejam letras ou espaços");
                smartAlert("Erro", "Não digite caracteres que não sejam letras ou espaços", "error");
                // document.getElementById("entrada").value="";
                $(campo).val("");
                return;

            }
        }
    }

    function consultaCpf() {

        let codigoFuncionario = $("#codigo").val();
        let cpf = $("#cpf").val();
        let funcao = 'recuperaCpf';

        $.ajax({
            method: 'POST',
            url: 'js/sqlscope_contratacaoCandidato.php',
            data: {
                funcao,
                codigoFuncionario,
                cpf

            },
            success: function(data) {
                debugger;
                var status = data.split('#');
                var piece = status[1].split('^');

                let codigoRecuperado = piece[0]; //Código recuperado do banco -> Pessoa cujo cpf ja foi cadastrado
                let codigoFuncionario = $("#codigo").val();
                let cpfRecuperado = piece[1];
                let cpfFuncionario = $("#cpf").val();


                if ((codigoFuncionario != codigoRecuperado) && (cpfFuncionario == cpfRecuperado)) {
                    smartAlert("Atenção", "Atenção este CPF já foi cadastrado por outro candidato, favor contactar a NTL!", "error");
                    $("#cpf").val("");
                }
                return;
            }
        })
    }

    function abrePdfTransporte() {
        let codigoFuncionario = $("#codigo").val();
        window.open("contratacao_relatorioTransporte.php?id=" + codigoFuncionario, '_blank');
    }
</script>