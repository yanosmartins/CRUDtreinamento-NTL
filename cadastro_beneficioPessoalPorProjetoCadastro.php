<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
include_once("populaTabela/popula.php");


//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = (in_array('BENEFICIOPROJETO_ACESSAR', $arrayPermissao, true));
$condicaoGravarOK = (in_array('BENEFICIOPROJETO_GRAVAR', $arrayPermissao, true));
$condicaoExcluirOK = (in_array('BENEFICIOPROJETO_EXCLUIR', $arrayPermissao, true));

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

$page_title = " Vínculos e Benefícios";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["beneficioProjeto"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
	//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
	//$breadcrumbs["New Crumb"] => "http://url.com"
	$breadcrumbs["Cadastro"] = "";
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
							<h2>Cadastros</h2>
						</header>
						<div>
							<div class="widget-body no-padding">
								<form class="smart-form client-form" id="formBeneficio" method="post">
									<input id="verificaRecuperacao" name="verificaRecuperacao" type="text" readonly class="hidden">
									<div class="panel-group smart-accordion-default" id="accordion">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
														<i class="fa fa-lg fa-angle-down pull-right"></i>
														<i class="fa fa-lg fa-angle-up pull-right"></i>
														Projeto
													</a>
												</h4>
											</div>
											<div id="collapseCadastro" class="panel-collapse collapse in">
												<div class="panel-body no-padding">
													<fieldset>
														<input type="hidden" id="codigo" name="codigo">
														<div class="row">
															<section class="col col-4">
																<label class="label" for="funcionario">Funcionário</label>
																<label class="select">
																	<select id="funcionario" name="funcionario" class="required" required>
																		<option value="">Selecione</option>
																		<?php
																		$reposit = new reposit();
																		$sql = "SELECT codigo, nome FROM Ntl.funcionario WHERE ativo = 1 ORDER BY nome";
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {
																			$id = $row['codigo'];
																			$descricao = $row['nome'];
																			echo '<option value=' . $id . '>' . $descricao . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-4 ">
																<label class="label " for="projeto">Projeto</label>
																<label class="select">
																	<select id="projeto" name="projeto" class="required" required>
																		<option value="">Selecione</option>
																		<?php
																		$reposit = new reposit();
																		$sql = "SELECT codigo, descricao FROM Ntl.projeto WHERE ativo = 1 ORDER BY descricao";
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {
																			$id = $row['codigo'];
																			$descricao = $row['descricao'];
																			echo '<option value=' . $id . '>' . $descricao . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="salarioFuncionario">Salário do Funcionário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="salarioFuncionario" name="salarioFuncionario" style="text-align: right;" type="text" class="decimal-2-casas required">
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-4">
																<label class="label" for="sindicato">Sigla Sindicato</label>
																<label class="select">
																	<select id="sindicato" name="sindicato" class="required" required>
																		<option value="">Selecione</option>
																		<?php
																		$reposit = new reposit();
																		$sql = "SELECT codigo, apelido FROM Ntl.sindicato WHERE situacao = 1 ORDER BY apelido";
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {
																			$id = $row['codigo'];
																			$apelido = $row['apelido'];
																			echo '<option value=' . $id . '>' . $apelido . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-4">
																<label class="label" for="idadeTitular">Descrição Sindicato</label>
																<label class="input"><i class="icon-append fa fa-user-circle"></i>
																	<input type="text" maxlength="3" class="readonly text-center" readonly id="descricaoSindicato" name="descricaoSindicato" />
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-2">
																<label class="label">Localização</label>
																<label class="select">
																	<select id="localizacao" name="localizacao" class="form-control">
																		<option style="display:none;">Selecione</option>
																		<option></option>
																		<?php
																		$sql =  "SELECT codigo, descricao FROM Ntl.localizacao  where ativo = 1  order by codigo";
																		$reposit = new reposit();
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {

																			$row = array_map('mb_strtoupper', $row);
																			$codigo = $row['codigo'];
																			$descricao = ($row['descricao']);
																			echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-3">
																<label class="label">Descrição do Posto</label>
																<label class="select">
																	<select id="descricaoPosto" name="descricaoPosto" class="form-control">
																		<option style="display:none;">Selecione</option>
																		<option></option>
																		<?php
																		$sql =  "SELECT VP.codigo, VP.descricaoPosto,P.descricao AS nomePosto
																						FROM Ntl.valorPosto VP 
																						LEFT JOIN Ntl.posto P on P.codigo = VP.descricaoPosto
																						where VP.ativo = 1 order by nomePosto";
																		$reposit = new reposit();
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {

																			$row = array_map('mb_strtoupper', $row);
																			$codigo = $row['codigo'];
																			$descricao = ($row['nomePosto']);
																			echo '<option value=' . $codigo . '>  ' . $descricao . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2 col-auto">
																<label class="label">Valor do Posto</label>
																<label class="input"><i class="icon-append fa fa-money"></i>
																	<input type="text" placeholder="0,00" style="text-align: right;" id="valorPosto" name="valorPosto" class="readonly decimal-2-casas" readonly disabled />
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-1">
																<label id="labelHora" class="label">Hora Entrada</label>
																<div class="input-group" data-align="top" data-autoclose="true">
																	<input id="horaEntrada" name="horaEntrada" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="">
																	<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
																</div>
															</section>
															<section class="col col-1">
																<label id="labelHora" class="label">Inicio/Almoço</label>
																<div class="input-group" data-align="top" data-autoclose="true">
																	<input id="horaInicio" name="horaInicio" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="">
																	<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
																</div>
															</section>
															<section class="col col-1">
																<label id="labelHora" class="label">Fim/ALmoço</label>
																<div class="input-group" data-align="top" data-autoclose="true">
																	<input id="horaFim" name="horaFim" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="">
																	<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
																</div>
															</section>
															<section class="col col-1">
																<label id="labelHora" class="label">Saída</label>
																<div class="input-group" data-align="top" data-autoclose="true">
																	<input id="horaSaida" name="horaSaida" type="text" class="text-center form-control required" placeholder="  00:00" data-autoclose="true" value="">
																	<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
																</div>
															</section>
															<section class="col col-3">
																<label class="label" for="departamento">Departamento</label>
																<label class="select">
																	<select id="departamento" name="departamento" class="">
																		<option></option>
																		<?php
																		$sql =  "SELECT codigo, descricao FROM Ntl.departamento where ativo = 1 order by descricao";
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
														</div>
													</fieldset>
												</div>
											</div>
										</div>
										<!-- COMEÇO DO ACCORDION DE PLANO DE SAÚDE -->
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapsePlanoSaude" class="collapsed" id="accordionPlanoSaude">
														<i class="fa fa-lg fa-angle-down pull-right"></i>
														<i class="fa fa-lg fa-angle-up pull-right"></i>
														Produto Plano de Saúde
													</a>
												</h4>
											</div>
											<div id="collapsePlanoSaude" class="panel-collapse collapse">
												<div class="panel-body no-padding">
													<input id="jsonPlanoSaude" name="jsonPlanoSaude" type="hidden" value="[]">
													<input id="jsonPlanoSaudeDependente" name="jsonPlanoSaudeDependente" type="hidden" value="[]">
													<fieldset id="formPlanoSaude">
														<input id="descricaoConvenioTitular" name="descricaoConvenioTitular" type="hidden" value="">
														<input id="descricaoProdutoTitular" name="descricaoProdutoTitular" type="hidden" value="">
														<input id="descricaoFuncionarioTitular" name="descricaoFuncionarioTitular" type="hidden" value="">
														<input id="descricaoNomeDependente" name="descricaoNomeDependente" type="hidden" value="">
														<input id="sequencialPlanoSaude" name="sequencialPlanoSaude" type="hidden" value="">
														<input id="sequencialPlanoSaudeDependente" name="sequencialPlanoSaudeDependente" type="hidden" value="">
														<input id="descricaoConvenioDependente" name="descricaoConvenioDependente" type="hidden" value="">
														<input id="descricaoProdutoDependente" name="descricaoProdutoDependente" type="hidden" value="">
														<br>
														<div class="row">
															<section class="col col-12">
																<legend>Produto Titular</legend>
															</section>
														</div>
														<div class="row">


															<section class="col col-4">
																<label class="label" for="funcionarioTitular">Funcionário/Titular</label>
																<label class="select">
																	<!-- <select id="funcionarioTitular" name="funcionarioTitular" style=" pointer-events: none" tabindex="-1"  class="readonly" readonly> -->
																	<select id="funcionarioTitular" name="funcionarioTitular">
																		<option value="">Selecione</option>
																		<?php
																		$reposit = new reposit();
																		$sql = "SELECT codigo, nome FROM Ntl.funcionario WHERE ativo = 1 ORDER BY nome";
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {
																			$id = $row['codigo'];
																			$descricao = $row['nome'];
																			echo '<option value=' . $id . '>' . $descricao . '</option>';
																		}
																		?>
																	</select>
																</label>
															</section>

															<section class="col col-2">
																<label class="label" for="idadeTitular">Idade</label>
																<label class="input"><i class="icon-append fa fa-user-circle"></i>
																	<input type="text" maxlength="3" class="readonly text-center" readonly id="idadeTitular" name="idadeTitular" />
																</label>
															</section>


														</div>

														<div class="row">
															<section class="col col-6">
																<!--<label class="label" for="projeto">Operadora de saúde</label>-->
																<label class="label" for="convenioTitular">Convênio</label>
																<label class="select">

																	<select id="convenioTitular" name="convenioTitular">
																		<option value="0"></option>
																		<?php

																		//include "js/repositorio.php";        
																		$reposit = new reposit();
																		$sql = "SELECT codigo, apelido FROM Ntl.convenioSaude WHERE ativo = 1 ORDER BY apelido";
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {
																			$id = $row['codigo'];
																			$apelido = $row['apelido'];
																			echo '<option value=' . $id . '>' . $apelido . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="produtoTitular">Produto</label>
																<label class="select">
																	<select id="produtoTitular" name="produtoTitular">
																		<option value=""></option>
																		<?php
																		//include "js/repositorio.php";        
																		$reposit = new reposit();
																		$sql = "SELECT codigo, produto FROM Ntl.produto WHERE ativo = 1 ORDER BY produto";
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {
																			$id = $row['codigo'];
																			$descricao = $row['produto'];
																			echo '<option value=' . $id . '>' . $descricao . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-3">
																<label class="label">Cobrança</label>
																<label class="select">
																	<select id="cobrancaTitular" name="cobrancaTitular">
																		<option style="display:none"></option>
																		<option value="F">Fixo</option>
																		<option value="I">Por idade</option>
																	</select>
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-3">
																<label class="label">Base Desconto</label>
																<label class="select">
																	<select id="baseDescontoPlanoSaudeTitular" name="baseDescontoPlanoSaudeTitular">
																		<option></option>
																		<option value="1">Plano Saúde</option>
																		<option value="2">Sindicato</option>
																		<option value="3">Projeto</option>
																	</select><i></i>
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-3">
																<label class="label" for="descontoSindicatoTitular">Desconto Sindicato</label>
																<label class="input"><i class="icon-append fa fa-percent"></i>
																	<input type="text" class="decimal-2-casas text-right" id="descontoSindicatoTitular" name="descontoSindicatoTitular" />
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="valorDescontoSindicatoTitular">Valor desconto Sindicato</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" class="decimal-2-casas text-right" id="valorDescontoSindicatoTitular" name="valorDescontoSindicatoTitular" />
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-3">
																<label class="label" for="descontoProjetoTitular">Desconto Projeto</label>
																<label class="input"><i class="icon-append fa fa-percent"></i>
																	<input type="text" class="decimal-2-casas text-right" id="descontoProjetoTitular" name="descontoProjetoTitular" />
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="valorDescontoProjetoTitular">Valor desconto Projeto</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" class="decimal-2-casas text-right" id="valorDescontoProjetoTitular" name="valorDescontoProjetoTitular" />
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-3">
																<label class="label" for="descontoPlanoSaudeTitular">Desconto Plano Saúde</label>
																<label class="input"><i class="icon-append fa fa-percent"></i>
																	<input type="text" class="decimal-2-casas text-right" id="descontoPlanoSaudeTitular" name="descontoPlanoSaudeTitular" />
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="valorDescontoPlanoSaudeTitular">Valor desconto Plano Saúde</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" class="decimal-2-casas text-right" id="valorDescontoPlanoSaudeTitular" name="valorDescontoPlanoSaudeTitular" />
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-3">
																<label class="label" for="valorProdutoTitular">Valor Produto</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input class="decimal-2-casas readonly text-right" readonly id="valorProdutoTitular" name="valorProdutoTitular" type="text" />
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="valorFuncionarioTitular">Valor Funcionário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" class="decimal-2-casas readonly text-right" readonly id="valorFuncionarioTitular" name="valorFuncionarioTitular" />
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="valorEmpresaTitular">Valor Empresa</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" class="decimal-2-casas readonly text-right" readonly id="valorEmpresaTitular" name="valorEmpresaTitular" />
																</label>
															</section>
															<!-- <section class="col col-3">
                                                                <label class="label" for="valorTotalFuncionarioTitular">Valor Total Funcionário</label>
                                                                <label class="input"><i class="icon-append fa fa-usd"></i>
                                                                    <input type="text" class="decimal-2-casas" id="valorTotalFuncionarioTitular" name="valorTotalFuncionarioTitular" />
                                                                </label>
                                                            </section> -->
														</div>
														<div class="row">
															<section class="col col-4">

																<button id="btnAddPlanoSaude" type="button" class="btn btn-primary" title="Adicionar Endereço">
																	<i class="fa fa-plus"></i>
																</button>
																<button id="btnRemoverPlanoSaude" type="button" class="btn btn-danger" title="Remover Endereço">
																	<i class="fa fa-minus"></i>
																</button>
															</section>
														</div>
														<div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
															<table id="tablePlanoSaude" class="table table-bordered table-striped table-condensed table-hover dataTable">
																<thead>
																	<tr role="row">

																		<th class="text-left" style="min-width: 10px;"></th>
																		<th class="text-left" style="min-width: 10px;">Titular</th>
																		<th class="text-left" style="min-width: 10px;">Convênio</th>
																		<th class="text-left" style="min-width: 10px;">Produto</th>
																		<th class="text-left" style="min-width: 10px;">Valor Funcionário</th>
																		<th class="text-left" style="min-width: 10px;">Valor Empresa</th>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</div>


														<!--                                                        PLANO SAUDE DEPENDENTE-->

														<div id="divPossuiDependente">

															<br>
															<div class="row">
																<section class="col col-12">
																	<legend>Produto Dependente</legend>
																</section>
															</div>
															<!-- <div class="row">
                                                            <section class="col col-2 col-auto">
                                                                <label class="label" for="dependente">Dependente</label>
                                                                <label class="select">
                                                                    <select id="dependente" name="dependente">
                                                                        <option value='0'>Não</option>
                                                                        <option value='1'>Sim</option>
                                                                    </select><i></i>
                                                                </label>
                                                            </section>
															</div> -->
															<div class="row">
																<section class="col col-4">
																	<!--<label class="label" for="projeto">Operadora de saúde</label>-->
																	<label class="label" for="dependente">Nome Dependente</label>
																	<label class="select">
																		<select id="nomeDependente" name="nomeDependente">
																			<option value=""></option>
																			<?php
																			//include "js/repositorio.php";        
																			$reposit = new reposit();
																			$sql = "SELECT codigo, funcionario, nomeDependente FROM Ntl.funcionarioDependente ORDER BY nomeDependente";
																			$result = $reposit->RunQuery($sql);

																			foreach ($result as $row) {
																				$id = $row['codigo'];
																				$descricao = $row['nomeDependente'];
																				echo '<option value=' . $id . '>' . $descricao . '</option>';
																			}
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-2">
																	<label class="label" for="idadeDependente">Idade</label>
																	<label class="input"><i class="icon-append fa fa-user-circle"></i>
																		<input class="numeric readonly" readonly id="idadeDependente" maxlength="3" name="idadeDependente" type="text">
																	</label>
																</section>
															</div>
															<div class="row">

																<section class="col col-6">
																	<!--<label class="label" for="projeto">Operadora de saúde</label>-->
																	<label class="label" for="convenioDependente">Convênio</label>
																	<label class="select">
																		<select id="convenioDependente" name="convenioDependente">
																			<option value=""></option>
																			<?php
																			//include "js/repositorio.php";        
																			$reposit = new reposit();
																			$sql = "SELECT codigo, apelido FROM Ntl.convenioSaude WHERE ativo = 1 ORDER BY apelido";
																			$result = $reposit->RunQuery($sql);
																			foreach ($result as $row) {
																				$id = $row['codigo'];
																				$apelido = $row['apelido'];
																				echo '<option value=' . $id . '>' . $apelido . '</option>';
																			}
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-3">
																	<label class="label" for="produtoDependente">Produto</label>
																	<label class="select">
																		<select id="produtoDependente" name="produtoDependente">
																			<option value=""></option>
																			<?php
																			//include "js/repositorio.php";        
																			$reposit = new reposit();
																			$sql = "SELECT codigo, produto FROM Ntl.produto WHERE ativo = 1 ORDER BY produto";
																			$result = $reposit->RunQuery($sql);
																			foreach ($result as $row) {
																				$id = $row['codigo'];
																				$descricao = $row['produto'];
																				echo '<option value=' . $id . '>' . $descricao . '</option>';
																			}
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-3">
																	<label class="label">Cobrança</label>
																	<label class="select">
																		<select id="cobrancaDependente" name="cobrancaDependente">
																			<option style="display:none"></option>
																			<option value="F">Fixo</option>
																			<option value="I">Por idade</option>
																		</select>
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-3">
																	<label class="label">Base Desconto</label>
																	<label class="select">
																		<select id="baseDescontoPlanoSaudeDependente" name="baseDescontoPlanoSaudeDependente">
																			<option></option>
																			<option value="1">Plano Saúde</option>
																			<option value="2">Sindicato</option>
																			<option value="3">Projeto</option>
																		</select><i></i>
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-3">
																	<label class="label" for="descontoSindicatoDependente">Desconto Sindicato</label>
																	<label class="input"><i class="icon-append fa fa-percent"></i>
																		<input type="text" class="decimal-2-casas text-right" id="descontoSindicatoDependente" name="descontoSindicatoDependente" />
																	</label>
																</section>
																<section class="col col-3">
																	<label class="label" for="valorDescontoSindicatoDependente">Valor desconto Sindicato</label>
																	<label class="input"><i class="icon-append fa fa-usd"></i>
																		<input type="text" class="decimal-2-casas text-right" id="valorDescontoSindicatoDependente" name="valorDescontoSindicatoDependente" />
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-3">
																	<label class="label" for="descontoProjetoDependente">Desconto Projeto</label>
																	<label class="input"><i class="icon-append fa fa-percent"></i>
																		<input type="text" class="decimal-2-casas text-right" id="descontoProjetoDependente" name="descontoProjetoDependente" />
																	</label>
																</section>
																<section class="col col-3">
																	<label class="label" for="valorDescontoProjetoDependente">Valor desconto Projeto</label>
																	<label class="input"><i class="icon-append fa fa-usd"></i>
																		<input type="text" class="decimal-2-casas text-right" id="valorDescontoProjetoDependente" name="valorDescontoProjetoDependente" />
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-3">
																	<label class="label" for="descontoPlanoSaudeDependente">Desconto Plano Saúde</label>
																	<label class="input"><i class="icon-append fa fa-percent"></i>
																		<input type="text" class="decimal-2-casas text-right" id="descontoPlanoSaudeDependente" name="descontoPlanoSaudeDependente" />
																	</label>
																</section>
																<section class="col col-3">
																	<label class="label" for="valorDescontoPlanoSaudeDependente">Valor desconto Plano Saúde</label>
																	<label class="input"><i class="icon-append fa fa-usd"></i>
																		<input type="text" class="decimal-2-casas text-right" id="valorDescontoPlanoSaudeDependente" name="valorDescontoPlanoSaudeDependente" />
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-3">
																	<label class="label" for="valorProdutoDependente">Valor Produto</label>
																	<label class="input"><i class="icon-append fa fa-usd"></i>
																		<input class="decimal-2-casas readonly text-right" readonly id="valorProdutoDependente" name="valorProdutoDependente" type="text" />
																	</label>
																</section>

																<section class="col col-3">
																	<label class="label" for="valorDependente">Valor Dependente</label>
																	<label class="input"><i class="icon-append fa fa-usd"></i>
																		<input class="decimal-2-casas readonly" readonly id="valorDependente" name="valorDependente" type="text">
																	</label>
																</section>
																<section class="col col-3">
																	<label class="label" for="valorEmpresaDependente">Valor Empresa</label>
																	<label class="input"><i class="icon-append fa fa-usd"></i>
																		<input type="text" class="decimal-2-casas readonly text-right" readonly id="valorEmpresaDependente" name="valorEmpresaDependente" />
																	</label>
																</section>
															</div>



															<div class="row">
																<section class="col col-4">

																	<button id="btnAddPlanoSaudeDependente" type="button" class="btn btn-primary" title="Adicionar Endereço">
																		<i class="fa fa-plus"></i>
																	</button>
																	<button id="btnRemoverPlanoSaudeDependente" type="button" class="btn btn-danger" title="Remover Endereço">
																		<i class="fa fa-minus"></i>
																	</button>
																</section>
															</div>

															<div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
																<table id="tablePlanoSaudeDependente" class="table table-bordered table-striped table-condensed table-hover dataTable">
																	<thead>
																		<tr role="row">
																			<th class="text-left" style="min-width: 10px;"></th>
																			<th class="text-left" style="min-width: 10px;">Dependente</th>
																			<th class="text-left" style="min-width: 10px;">Convênio</th>
																			<th class="text-left" style="min-width: 10px;">Produto</th>
																			<th class="text-left" style="min-width: 10px;">Valor Dependente</th>
																			<th class="text-left" style="min-width: 10px;">Valor Empresa</th>


																		</tr>
																	</thead>
																	<tbody>
																	</tbody>
																</table>
															</div>
														</div>
														<br>
														<div class="row">
															<section class="col col-12">
																<legend>Total</legend>
															</section>
														</div>
														<div class="row">
															<section class="col col-4">
																<label class="label" for="valorTotalTitular">Total Funcionário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorTotalTitular" name="valorTotalTitular" type="text" class="readonly decimal-2-casas text-right" readonly value="">
																</label>
															</section>
															<section class="col col-4">
																<label class="label" for="valorTotalDependente">Total Dependente</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorTotalDependente" name="valorTotalDependente" type="text" class="readonly  decimal-2-casas" readonly>
																</label>
															</section>
															<section class="col col-4">
																<label class="label" for="valorTotalGeral">Total Funcionário + Dependente</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorTotalGeral" name="valorTotalGeral" type="text" class="readonly decimal-2-casas" readonly>
																</label>
															</section>
														</div>
														<!--         FINAL   PLANO SAUDE DEPENDENTE-->
													</fieldset>
												</div>
											</div>
										</div>
										<!-- COMEÇO DO ACCORDION DE VALE ALIMENTAÇÃO -->
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseValeAlimentacao" class="collapsed" id="accordionValeAlimentacao">
														<i class="fa fa-lg fa-angle-down pull-right"></i>
														<i class="fa fa-lg fa-angle-up pull-right"></i>
														VA e VR
													</a>
												</h4>
											</div>
											<div id="collapseValeAlimentacao" class="panel-collapse collapse">
												<div class="panel-body no-padding">
													<fieldset id="formValeAlimentacao">

														<div class="row">
															<section class="col col-2">
																<label class="label" for="tipoDescontoVA">Tipo Desconto</label>
																<label class="select">

																	<select id="tipoDescontoVA" name="tipoDescontoVA">
																		<option></option>
																		<option value='0'>Projeto</option>
																		<option value='1'>Sindicato</option>
																		<option value='2'>Funcionario</option>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="tipoBeneficio">Tipo Beneficio</label>
																<label class="select">

																	<select id="tipoBeneficio" name="tipoBeneficio">
																		<option></option>
																		<option value='VR'>Vale Refeição</option>
																		<option value='VA'>Vale Alimentação</option>
																	</select><i></i>
																</label>
															</section>
														</div>
														<div class="row">

															<!--INICIO ORIGEM VA-->
															<section class="col col-12">
																<legend>Projeto</legend>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor Diário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" placeholder="0,00" style="text-align: right;" id="valorDiarioProjetoVA" name="valorDiarioProjetoVA" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor Mensal</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" placeholder="0,00" style="text-align: right;" id="valorMensalProjetoVA" name="valorMensalProjetoVA" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Desconto Projeto</label>
																<label class="input"><i class="icon-append fa fa-percent"></i>
																	<input type="text" id="percentualDescontoProjetoVA" name="percentualDescontoProjetoVA" placeholder="0,00" style="text-align: right;" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor desconto Projeto</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorDescontoProjetoVA" name="valorDescontoProjetoVA" placeholder="0,00" class="decimal-2-casas" style="text-align: right;" type="text">
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-12">
																<legend>Sindicato</legend>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor Diário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" placeholder="0,00" style="text-align: right;" id="valorDiarioSindicatoVA" name="valorDiarioSindicatoVA" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor Mensal</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" placeholder="0,00" style="text-align: right;" id="valorMensalSindicatoVA" name="valorMensalSindicatoVA" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Desconto Sindicato</label>
																<label class="input"><i class="icon-append fa fa-percent"></i>
																	<input type="text" placeholder="0,00" style="text-align: right;" id="percentualDescontoSindicatoVA" name="percentualDescontoSindicatoVA" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor desconto Sindicato</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorDescontoSindicatoVA" name="valorDescontoSindicatoVA" placeholder="0,00" style="text-align: right;" class="decimal-2-casas" type="text">
																</label>
															</section>

														</div>
														<div class="row">
															<section class="col col-12">
																<legend>Funcionário</legend>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor Diário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" placeholder="0,00" style="text-align: right;" id="valorDiarioFuncionarioVA" name="valorDiarioFuncionarioVA" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor Mensal</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorMensalFuncionarioVA" name="valorMensalFuncionarioVA" placeholder="0,00" style="text-align: right;" class="decimal-2-casas" type="text">
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Desconto em Folha</label>
																<label class="input"><i class="icon-append fa fa-percent"></i>
																	<input type="text" id="percentualDescontoFolhaFuncionarioVA" placeholder="0,00" style="text-align: right;" name="percentualDescontoFolhaFuncionarioVA" class="decimal-2-casas" />
																</label>
															</section>
															<section class="col col-3 col-auto">
																<label class="label">Valor do Desconto</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorDescontoFolhaFuncionarioVA" placeholder="0,00" style="text-align: right;" name="valorDescontoFolhaFuncionarioVA" class="decimal-2-casas" type="text">
																</label>
															</section>
															<input type="hidden" placeholder="0,00" id="percentualDescontoMesCorrenteVA" name="percentualDescontoMesCorrenteVA" style="text-align: right;" class="decimal-2-casas" />
															<input id="valorDescontoMesCorrenteVA" name="valorDescontoMesCorrenteVA" placeholder="0,00" style="text-align: right;" class="decimal-2-casas" type="hidden">
													</fieldset>
												</div>
											</div>
										</div>

										<!-- FIM DO ACCORDION DE VALE ALIMENTAÇÃO-->

										<!-- INICIO ACORDION BENEFICIO -->
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseBeneficioCestaBasica" class="collapsed" id="accordionBeneficioCestaBasica">
														<i class="fa fa-lg fa-angle-down pull-right"></i>
														<i class="fa fa-lg fa-angle-up pull-right"></i>
														Cesta Básica
													</a>
												</h4>
											</div>
											<div id="collapseBeneficioCestaBasica" class="panel-collapse collapse">
												<div class="panel-body no-padding">
													<fieldset>

														<div class="row">
															<section class="col col-3">
																<label class="label" for="valorCestaBasica">Valor da cesta básica</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input type="text" id="valorCestaBasica" name="valorCestaBasica" placeholder="0,00" style="text-align: right;" class="decimal-2-casas " />
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="perdaBeneficio">Perda Do Benefício</label>
																<label class="select">
																	<select id="perdaBeneficio" name="perdaBeneficio">
																		<option value="" style="display:none;">Selecione</option>
																		<option value='0'>Falta Injustificada</option>
																		<option value='1'>Falta Injustificada e Ausência</option>
																		<option value='2'>Não Descontar</option>
																	</select><i></i>
																</label>
															</section>
														</div>
														<!-- <input type="text" placeholder="0,00" style="text-align: right;" id="valorMensalSindicatoCestaBasica" name="valorMensalSindicatoCestaBasica" class="decimal-2-casas hidden" />
														<input type="text" placeholder="0,00" style="text-align: right;" id="percentualDescontoSindicatoCestaBasica" name="percentualDescontoSindicatoCestaBasica" class="decimal-2-casas hidden" />
														<input id="valorDescontoSindicatoCestaBasica" name="valorDescontoSindicatoCestaBasica" placeholder="0,00" style="text-align: right;" class="decimal-2-casas hidden" type="text"> -->
													</fieldset>
												</div>
											</div>
										</div>
										<!-- FIM BENEFICIOS-->
										<!-- COMEÇO DO ACCORDION DE VALE TRANSPORTE -->
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseValeTransporte" class="collapsed" id="accordionValeTransporte">
														<i class="fa fa-lg fa-angle-down pull-right"></i>
														<i class="fa fa-lg fa-angle-up pull-right"></i>
														Vale Transporte
													</a>
												</h4>
											</div>
											<div id="collapseValeTransporte" class="panel-collapse collapse">
												<div class="panel-body no-padding">
													<input id="jsonValeTransporte" name="jsonValeTransporte" type="hidden" value="[]">
													<fieldset id="formValeTransporte">
														<input id="sequencialValeTransporte" name="sequencialValeTransporte" type="hidden" value="">
														<input id="descricaoTipoDesconto" name="descricaoTipoDesconto" type="hidden" value="">
														<input id="descricaoTipoVale" name="descricaoTipoVale" type="hidden" value="">
														<input id="descricaoVTUnitario" name="descricaoVTUnitario" type="hidden" value="">
														<input id="descricaoVT" name="descricaoVT" type="hidden" value="">
														<input id="descricaoTrajeto" name="descricaoTrajeto" type="hidden" value="">
														<input id="trajetoIdaVolta" name="trajetoIdaVolta" type="text" readonly class="hidden">

														<div class="row">
															<section class="col col-3">
																<label class="label" for="tipoDesconto">Tipo de desconto</label>
																<label class="select">
																	<select id="tipoDesconto" name="tipoDesconto">
																		<?php
																		echo populaCalculoTransporte();
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="tipoVale">Tipo Vale</label>
																<label class="select">

																	<select id="tipoVale" name="tipoVale">
																		<option value="">Selecione</option>
																		<option value='0'>Modal</option>
																		<option value='1'>Unitário</option>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="dataInativacao">Data de Inativação</label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="dataInativacao" name="dataInativacao" autocomplete="off" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
																</label>
															</section>

														</div>
														<div class="row">
															<section class="col col-3">
																<label class="label" for="valeTransporte">Vale Transporte</label>
																<label class="select">
																	<select id="valeTransporte" name="valeTransporte">
																		<option value="">Selecione</option>
																		<?php
																		//include "js/repositorio.php";        
																		$reposit = new reposit();
																		$sql = "SELECT codigo, descricao, valorUnitario FROM Ntl.valeTransporteUnitario WHERE ativo = 1 ORDER BY descricao";
																		$result = $reposit->RunQuery($sql);
																		foreach ($result as $row) {
																			$id = $row['codigo'];
																			$descricao = $row['descricao'];
																			echo '<option value=' . $id . '>' . $descricao . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="trajeto">Trajeto</label>
																<label class="select">
																	<select id="trajetoVT" name="trajetoVT">
																		<?php
																		echo populaOpcaoTrajetoVt();
																		?>
																	</select><i></i>
																</label>
															</section>

															<section class="col col-2">
																<label class="label" for="valorPassagem">Valor da passagem</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorPassagem" name="valorPassagem" style="text-align: right;" type="text" class="decimal-2-casas">
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="valorTotalVT">Valor total</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorTotalVT" name="valorTotalVT" style="text-align: right;" type="text" class="decimal-2-casas">
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="valorTotalFuncionarioVT">Valor total do Funcionário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorTotalFuncionarioVT" name="valorTotalFuncionarioVT" style="text-align: right;" type="text" readonly class="readonly decimal-2-casas">
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-12">
																<label class="label">Observação</label>
																<textarea id="observacaoVT" name="observacaoVT" class="form-control" rows="3" style="resize:vertical"></textarea>
															</section>
														</div>
														<div class="row">
															<section class="col col-4">

																<button id="btnAddValeTransporte" type="button" class="btn btn-primary" title="Adicionar Vale Transporte">
																	<i class="fa fa-plus"></i>
																</button>
																<button id="btnRemoverValeTransporte" type="button" class="btn btn-danger" title="Remover Vale Transporte">
																	<i class="fa fa-minus"></i>
																</button>
															</section>
														</div>
														<div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
															<table id="tableValeTransporte" class="table table-bordered table-striped table-condensed table-hover dataTable">
																<thead>
																	<tr role="row">
																		<th></th>
																		<th class="text-left" style="min-width: 10px;">Tipo de Desconto</th>
																		<th class="text-left" style="min-width: 10px;">Tipo Vale</th>
																		<th class="text-left" style="min-width: 10px;">Transporte</th>
																		<th class="text-left" style="min-width: 10px;">Trajeto</th>
																		<th class="text-left" style="min-width: 10px;">Valor</th>
																		<th class="text-left" style="min-width: 10px;">Observação</th>

																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</div>

													</fieldset>
												</div>
											</div>
										</div>

										<!-- FIM DO ACCORDION DE VALE TRANSPORTE-->
										<!-- INICIO DO ACCORDION DE BENFICIO DIRETO-->

										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseSaldoParcial" class="collapsed" id="accordionCollapseSaldoParcial">
														<i class="fa fa-lg fa-angle-down pull-right"></i>
														<i class="fa fa-lg fa-angle-up pull-right"></i>
														Benefício Indireto
													</a>
												</h4>
											</div>
											<div id="collapseSaldoParcial" class="panel-collapse collapse">
												<div class="panel-body no-padding">
													<input id="jsonBeneficioIndireto" name="jsonBeneficioIndireto" type="hidden" value="[]">
													<fieldset id="formBeneficioIndireto">
														<input id="sequencialBeneficioIndireto" name="sequencialBeneficioIndireto" type="hidden" value="">
														<input id="descricaoBeneficio" name="descricaoBeneficio" type="hidden" value="">

														<div class="row">
															<section class="col col-3">
																<label class="label" for="valorBolsaBeneficioSindicato">Valor Bolsa Benefício Sindicato</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorBolsaBeneficioSindicato" name="valorBolsaBeneficioSindicato" placeholder="R$ 0,00" class="decimal-2-casas readonly" readonly>
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="saldoDisponivel">Saldo Disponível</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="saldoDisponivel" name="saldoDisponivel" placeholder="R$ 0,00" class="decimal-2-casas readonly" readonly>
																</label>
															</section>
														</div>

														<div class="row">
															<section class="col col-3">
																<label class="label" for="beneficioIndireto">Bolsa Benefício</label>
																<label class="select">
																	<select id="beneficioIndireto" name="beneficioIndireto">
																		<?php
																		echo populaBeneficio();
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-3">
																<label class="label" for="valorBeneficioFuncionario">Valor Benefício Funcionário</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorBeneficioFuncionario" name="valorBeneficioFuncionario" placeholder="R$ 0,00" class="decimal-2-casas readonly" readonly>
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="valorAcrescimo">Valor Acréscimo</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorAcrescimo" name="valorAcrescimo" placeholder="0,00" class="decimal-2-casas">
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="valorAbater">Valor a Abater</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorAbater" name="valorAbater" placeholder="0,00" class="decimal-2-casas">
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="valorFinalBeneficio">Valor Final Benefício</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="valorFinalBeneficio" name="valorFinalBeneficio" placeholder="R$ 0,00" type="text" class="decimal-2-casas readonly" readonly>
																</label>
															</section>
														</div>

														<div class="row">
															<section class="col col-4">

																<button id="btnAddBeneficioIndireto" type="button" class="btn btn-primary" title="Adicionar Benefício Direto">
																	<i class="fa fa-plus"></i>
																</button>
																<button id="btnRemoverBeneficioIndireto" type="button" class="btn btn-danger" title="Remover Benefício Direto">
																	<i class="fa fa-minus"></i>
																</button>
															</section>
														</div>


														<div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
															<table id="tableBeneficioIndireto" class="table table-bordered table-striped table-condensed table-hover dataTable">
																<thead>
																	<tr role="row">
																		<th></th>
																		<th class="text-left" style="min-width: 10px;">Benefício</th>
																		<th class="text-left" style="min-width: 10px;">Valor Benefício Funcionário</th>
																		<th class="text-left" style="min-width: 10px;">Valor Acréscimo</th>
																		<th class="text-left" style="min-width: 10px;">Valor a Abater</th>
																		<th class="text-left" style="min-width: 10px;">Valor Final Benefício</th>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</div>

														<div class="row">
															<section class="col col-12">
																<legend>Total</legend>
															</section>
														</div>
														<div class="row">
															<section class="col col-2">
																<label class="label" for="valorTotalTitular">Total Acréscimo</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="totalValorAcrescimoBeneficioIndireto" name="totalValorAcrescimoBeneficioIndireto" type="text" class="readonly decimal-2-casas" readonly value="">
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="valorTotalDependente">Total a Abater</label>
																<label class="input"><i class="icon-append fa fa-usd"></i>
																	<input id="totalValorAbaterBeneficioIndireto" name="totalValorAbaterBeneficioIndireto" type="text" class="readonly  decimal-2-casas" readonly>
																</label>
															</section>
														</div>
													</fieldset>
												</div>
											</div>

										</div>
										<!-- FIM DO ACCORDION DE SALDO PARCIAL-->

										<!-- DIAS ÚTEIS -->
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapseDiaUtil" class="collapsed" id="accordionDiaUtil">
														<i class="fa fa-lg fa-angle-down pull-right"></i>
														<i class="fa fa-lg fa-angle-up pull-right"></i>
														Dias Úteis
													</a>
												</h4>
											</div>
											<div id="collapseDiaUtil" class="panel-collapse collapse">
												<div class="panel-body no-padding">
													<fieldset>
														<div class="row">
															<!-- <section class="col col-2">
																<label class="label" for="funcionario">Tipo Dia Útil</label>
																<label class="select">
																	<select id="tipoDiaUtil" name="tipoDiaUtil" class="required" required>
																		<?php
																		echo populaTipoDiaUtil();
																		?>
																	</select><i></i>
																</label>
															</section> -->
															<select id="consideraVa" name="consideraVa" class="hidden">
																<option value='0'>Não</option>
																<option value='1'>Sim</option>
															</select><i></i>
															<select id="consideraVt" name="consideraVt" class="hidden">
																<option value='0'>Não</option>
																<option value='1'>Sim</option>
															</select><i></i>
														</div>

														<div class="row">
															<section class="col col-12">
																<legend>VA/VR</legend>
															</section>
														</div>
														<div class="row">
															<section class="col col-2">
																<label class="label" for="tipoDiaUtilVAVR">Tipo Dia Útil VA/VR</label>
																<label class="select">
																	<select id="tipoDiaUtilVAVR" name="tipoDiaUtilVAVR" class="required" required>
																		<?php
																		echo populaTipoDiaUtil();
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label" for="municipio">Município</label>
																<label class="select">
																	<select id="municipioDiasUteis" name="municipioDiasUteis" class="required" required>
																		<option></option>
																		<?php
																		$reposit = new reposit();
																		$sql = "SELECT codigo, descricao FROM Ntl.municipio WHERE ativo = 1 ORDER BY descricao";
																		$result = $reposit->RunQuery($sql);

																		foreach ($result as $row) {
																			$id = (int) $row['codigo'];
																			$descricao = $row['descricao'];
																			echo '<option value=' . $id . '>' . $descricao . '</option>';
																		}
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label">Escala (Não descontar ferias)</label>
																<label class="select">
																	<select id="escalaFeriasVAVR" name="escalaFeriasVAVR">
																		<option></option>
																		<option value="0">Não</option>
																		<option value="1">Sim</option>
																	</select><i></i>
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-2">
																<label class="label">Mês</label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilJaneiro" name="mesUtilJaneiro" autocomplete="off" class="readonly" type="text" value="Janeiro" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label">Dias</label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilJaneiro" name="diaUtilJaneiro">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>

															<section class="col col-2">
																<label class="label">Mês</label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilFevereiro" name="mesUtilFevereiro" autocomplete="on" class="readonly" readonly type="text" value="Fevereiro">
																</label>
															</section>
															<section class="col col-1">
																<label class="label">Dias</label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilFevereiro" name="diaUtilFevereiro">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label">Mês</label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilMarco" name="mesUtilMarco" autocomplete="on" class="readonly" type="text" value="Março" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label">Dias</label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilMarco" name="diaUtilMarco">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilAbril" name="mesUtilAbril" autocomplete="on" class="readonly" type="text" value="Abril" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilAbril" name="diaUtilAbril">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>

															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input readonly id="mesUtilMaio" name="mesUtilMaio" autocomplete="on" class="readonly" type="text" value="Maio">
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilMaio" name="diaUtilMaio">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilJunho" name="mesUtilJunho" autocomplete="on" class="readonly" type="text" value="Junho" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilJunho" name="diaUtilJunho">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilJulho" name="mesUtilJulho" autocomplete="on" class="readonly" type="text" value="Julho" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilJulho" name="diaUtilJulho">
																		<?php
																		include_once("populaTabela/popula.php");
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>

															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilAgosto" name="mesUtilAgosto" autocomplete="on" class="readonly" type="text" value="Agosto" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilAgosto" name="diaUtilAgosto">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>

															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilSetembro" name="mesUtilSetembro" autocomplete="on" class="readonly" type="text" value="Setembro" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilSetembro" name="diaUtilSetembro">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
														</div>
														<div class="row">
															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilOutubro" name="mesUtilOutubro" autocomplete="on" class="readonly" type="text" value="Outubro" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilOutubro" name="diaUtilOutubro">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilNovembro" name="mesUtilNovembro" autocomplete="on" class="readonly" type="text" value="Novembro" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilNovembro" name="diaUtilNovembro">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
															<section class="col col-2">
																<label class="label"> </label>
																<label class="input">
																	<i class="icon-append fa fa-calendar"></i>
																	<input id="mesUtilDezembro" name="mesUtilDezembro" autocomplete="on" class="readonly" type="text" value="Dezembro" readonly>
																</label>
															</section>
															<section class="col col-1">
																<label class="label"> </label>
																<label class="select"><i class="icon-append fa fa-bars"></i>
																	<select id="diaUtilDezembro" name="diaUtilDezembro">
																		<?php
																		echo populaDiaUtilMes();
																		?>
																	</select><i></i>
																</label>
															</section>
														</div>

														<div class="panel-body no-padding">

															<div class="row">
																<section class="col col-12">
																	<legend>Vale Transporte</legend>
																</section>
															</div>
															<div class="row">
																<section class="col col-2">
																	<label class="label" for="tipoDiaUtilVT">Tipo Dia Útil VT</label>
																	<label class="select">
																		<select id="tipoDiaUtilVT" name="tipoDiaUtilVT" class="required" required>
																			<?php
																			echo populaTipoDiaUtil();
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-2">
																	<label class="label" for="municipio">Município</label>
																	<label class="select">
																		<select id="municipioDiasUteisVT" name="municipioDiasUteisVT" class="required" required>
																			<option></option>
																			<?php
																			$reposit = new reposit();
																			$sql = "SELECT codigo, descricao FROM Ntl.municipio WHERE ativo = 1 ORDER BY descricao";
																			$result = $reposit->RunQuery($sql);

																			foreach ($result as $row) {
																				$id = (int) $row['codigo'];
																				$descricao = $row['descricao'];

																				echo '<option value=' . $id . '>' . $descricao . '</option>';
																			}
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-2">
																	<label class="label">Escala (Não descontar ferias)</label>
																	<label class="select">
																		<select id="escalaFerias" name="escalaFerias">
																			<option></option>
																			<option value="0">Não</option>
																			<option value="1">Sim</option>
																		</select><i></i>
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-2">
																	<label class="label">Mês</label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilJaneiroVT" name="mesUtilJaneiroVT" autocomplete="off" class="readonly" type="text" value="Janeiro" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label">Dias</label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilJaneiroVT" name="diaUtilJaneiroVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>

																<section class="col col-2">
																	<label class="label">Mês</label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilFevereiroVT" name="mesUtilFevereiroVT" autocomplete="on" class="readonly" readonly type="text" value="Fevereiro">
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label">Dias</label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilFevereiroVT" name="diaUtilFevereiroVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-2">
																	<label class="label">Mês</label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilMarcoVT" name="mesUtilMarcoVT" autocomplete="on" class="readonly" type="text" value="Março" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label">Dias</label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilMarcoVT" name="diaUtilMarcoVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilAbrilVT" name="mesUtilAbrilVT" autocomplete="on" class="readonly" type="text" value="Abril" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilAbrilVT" name="diaUtilAbrilVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>

																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input readonly id="mesUtilMaioVT" name="mesUtilMaioVT" autocomplete="on" class="readonly" type="text" value="Maio">
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilMaioVT" name="diaUtilMaioVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilJunhoVT" name="mesUtilJunhoVT" autocomplete="on" class="readonly" type="text" value="Junho" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilJunhoVT" name="diaUtilJunhoVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilJulhoVT" name="mesUtilJulhoVT" autocomplete="on" class="readonly" type="text" value="Julho" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilJulhoVT" name="diaUtilJulhoVT">
																			<?php
																			include_once("populaTabela/popula.php");
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>

																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilAgostoVT" name="mesUtilAgostoVT" autocomplete="on" class="readonly" type="text" value="Agosto" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilAgostoVT" name="diaUtilAgostoVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>

																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilSetembroVT" name="mesUtilSetembroVT" autocomplete="on" class="readonly" type="text" value="Setembro" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilSetembroVT" name="diaUtilSetembroVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>
															</div>
															<div class="row">
																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilOutubroVT" name="mesUtilOutubroVT" autocomplete="on" class="readonly" type="text" value="Outubro" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilOutubroVT" name="diaUtilOutubroVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilNovembroVT" name="mesUtilNovembroVT" autocomplete="on" class="readonly" type="text" value="Novembro" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilNovembroVT" name="diaUtilNovembroVT">
																			<?php
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>
																<section class="col col-2">
																	<label class="label"> </label>
																	<label class="input">
																		<i class="icon-append fa fa-calendar"></i>
																		<input id="mesUtilDezembroVT" name="mesUtilDezembroVT" autocomplete="on" class="readonly" type="text" value="Dezembro" readonly>
																	</label>
																</section>
																<section class="col col-1">
																	<label class="label"> </label>
																	<label class="select"><i class="icon-append fa fa-bars"></i>
																		<select id="diaUtilDezembroVT" name="diaUtilDezembroVT">
																			<?php
																			include_once("populaTabela/popula.php");
																			echo populaDiaUtilMes();
																			?>
																		</select><i></i>
																	</label>
																</section>

															</div>

															<!-- <div class="row">
																	<section class="col col-12">
																		<legend>Dia Util a Considerar em Ferias</legend>
																	</section>
															</div>
															 -->
															<!-- <div class="row">
															<section class="col col-2">
																	<label class="label" for="municipio">Município</label>
																	<label class="select">
																		<select id="municipioFerias" name="municipioFerias" class="required" required>
																			<option></option>
																			<?php
																			$reposit = new reposit();
																			$sql = "SELECT codigo, descricao FROM Ntl.municipio WHERE ativo = 1 ORDER BY descricao";
																			$result = $reposit->RunQuery($sql);

																			foreach ($result as $row) {
																				$id = (int) $row['codigo'];
																				$descricao = $row['descricao'];

																				echo '<option value=' . $id . '>' . $descricao . '</option>';
																			}
																			?>
																		</select><i></i>
																	</label>
																</section>
															</div> -->

														</div>

													</fieldset>
												</div>
											</div>
										</div>

										<!-- DIAS ÚTEIS ─  -->
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
										<button type="button" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
											<span class="fa fa-floppy-o"></span>
										</button>
										<button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
											<span class="fa fa-file-o"></span>
										</button>
										<!-- <button type="button" id="btnPdf" class="btn btn-info" style="background-color:#735687" aria-hidden="true" title="PDF" style="display:<?php echo $esconderBtnGravar ?>">
											<span class="fa fa-file-pdf-o"></span>
										</button> -->
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
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>

<script src="<?php echo ASSETS_URL; ?>/js/businessUsuario.js" type="text/javascript"></script>
<script src="<?php echo ASSETS_URL; ?>/js/business_cadastroBeneficioPessoalPorProjeto.js" type="text/javascript"></script>

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

<script src="js/plugin/clockpicker/clockpicker.min.js"></script>


<script language="JavaScript" type="text/javascript">
	jsonPlanoSaudeArray = JSON.parse($("#jsonPlanoSaude").val());
	jsonPlanoSaudeDependenteArray = JSON.parse($("#jsonPlanoSaudeDependente").val());
	jsonValeTransporteArray = JSON.parse($("#jsonValeTransporte").val());
	jsonBeneficioIndiretoArray = JSON.parse($("#jsonBeneficioIndireto").val());
	populaComboNomeDependente();


	$("#nomeDependente").prop('disabled', true);
	$("#nomeDependente").addClass('readonly');

	municipio = ("#municipioDiasUteis");
	municipioVT = ("#municipioDiasUteisVT");
	habilitaDesabilitaCamposDiasUteisMunicipio(1, municipio)
	habilitaDesabilitaCamposDiasUteisMunicipio(1, municipioVT)

	desabilitaCampoDiaUtil()
	desabilitaCampoDiaUtilVT()

	$(document).ready(function() {
		desabilitaCampos();
		$("#valorTotalVT").focusout(() => {
			var valor = $(this).val();

		});

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
		validaValeTransporte();


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
		$("#btnPdf").on("click", function() {
			window.open('http://localhost/NTL/operacao_processaBeneficioRel.php?id=' + $("#codigo").val());
		});
		$("#btnAddPlanoSaude").on("click", function() {
			if (validaPlanoSaude()) {
				habilitaCampos();
				addPlanoSaude();
			}

		});
		$("#btnAddPlanoSaudeDependente").on("click", function() {
			if (validaPlanoSaudeDependente()) {
				habilitaCampos();
				addPlanoSaudeDependente();
			}
		});
		$("#btnAddValeTransporte").on("click", function() {
			var trajetoVT = $("#trajetoVT").val();

			if (trajetoVT == 3) {
				$("#trajetoIdaVolta").val(1);
				$("#trajetoVT").val(1);

				addValeTransporte();

				$("#trajetoVT").val(2);
				addValeTransporte();
			} else {
				$("#trajetoIdaVolta").val(0);
				addValeTransporte();
			}
			clearValeTransporte();

		});

		$("#btnRemoverValeTransporte").on("click", function() {
			excluirValeTransporte();
		});
		$("#btnRemoverPlanoSaude").on("click", function() {
			excluirPlanoSaude();
		});
		$("#btnRemoverPlanoSaudeDependente").on("click", function() {
			excluirPlanoSaudeDependente();
		});

		$("#btnAddBeneficioIndireto").on("click", function() {
			$("#valorAcrescimo").prop('disabled', false);
			$("#valorAbater").prop('disabled', false);
			var saldoDisponivel = $("#saldoDisponivel").val().replace(",", ".");

			if (saldoDisponivel > 0) {
				if (validaBeneficioIndireto()) {
					addBeneficioIndireto();
				}
			} else {
				smartAlert("Atenção", "Todo saldo disponível já foi utilizado!", "error");
			}


		});
		$("#btnRemoverBeneficioIndireto").on("click", function() {
			var saldo = jsonBeneficioIndiretoArray.valorAcrescimo;
			excluirBeneficioDireto();
		});

		$("#valeTransporte").on("change", function() {
			validaValeTransporte();
		});
		$("#tipoDiaUtilVAVR").on("change", function() {
			var tipoDiaUtilVAVR = +$("#tipoDiaUtilVAVR").val();
			if (tipoDiaUtilVAVR == 1 || tipoDiaUtilVAVR == 2 || tipoDiaUtilVAVR == 4) {
				desabilitaCampoDiaUtil();
				habilitaDesabilitaCamposDiasUteisMunicipio(1, ("#municipioDiasUteis"))
				$("#municipioDiasUteis").val("")
			} else if (tipoDiaUtilVAVR == 5) {
				desabilitaCampoDiaUtil();
				habilitaDesabilitaCamposDiasUteisMunicipio(2, ("#municipioDiasUteis"))
			} else {
				habilitaCampoDiaUtil();
				habilitaDesabilitaCamposDiasUteisMunicipio(1, ("#municipioDiasUteis"))
				$("#municipioDiasUteis").val("")

			}


		});
		$("#tipoDiaUtilVT").on("change", function() {
			var tipoDiaUtilVT = +$("#tipoDiaUtilVT").val();
			if (tipoDiaUtilVT == 1 || tipoDiaUtilVT == 2 || tipoDiaUtilVT == 4) {
				desabilitaCampoDiaUtilVT();
				habilitaDesabilitaCamposDiasUteisMunicipio(1, ("#municipioDiasUteisVT"));
				$("#municipioDiasUteisVT").val("")
			} else if (tipoDiaUtilVT == 5) {
				desabilitaCampoDiaUtilVT();
				habilitaDesabilitaCamposDiasUteisMunicipio(2, ("#municipioDiasUteisVT"));
			} else {
				habilitaCampoDiaUtilVT();
				habilitaDesabilitaCamposDiasUteisMunicipio(1, ("#municipioDiasUteisVT"));
				$("#municipioDiasUteisVT").val("")
			}

		});
		$("#trajetoVT").on("change", function() {
			calculaTrajetoValeTransporte();
		});
		$("#funcionario").on("change", function() {
			populaFuncionarioRecupera();
		});

		$("#horaEntrada").mask("99:99");
		$("#horaInicio").mask("99:99");
		$("#horaFim").mask("99:99");
		$("#horaSaida").mask("99:99");

		$('#horaEntrada').clockpicker({
			donetext: 'Done',
			default: 'now',
			use24hours: true,
		}).val(moment().format('HH:mm'));

		$('#horaInicio').clockpicker({
			donetext: 'Done',
			default: 'now',
			use24hours: true,
		}).val(moment().format('HH:mm'));

		$('#horaFim').clockpicker({
			donetext: 'Done',
			default: 'now',
			use24hours: true,
		}).val(moment().format('HH:mm'));

		$('#horaSaida').clockpicker({
			donetext: 'Done',
			default: 'now',
			use24hours: true,
		}).val(moment().format('HH:mm'));



		$("#baseDescontoPlanoSaudeTitular").on("focusout", function() {
			var projeto = +$("#projeto").val();
			var sindicato = +$("#sindicato").val();
			var produto = +$("#produtoTitular").val();
			var tipoDesconto = +$("#baseDescontoPlanoSaudeTitular").val();

			if (tipoDesconto == 1) {
				if (produto == 0) {
					smartAlert("Atenção", "Informe um Produto!", "error");
					return
				}
				limpaTodoCampoValorPlanoSaude()
				limpaCamposPlanoSaude(2);
				valorDescontoPlanoSaudeProduto(produto);
			} else if (tipoDesconto == 2) {
				if (sindicato == 0) {
					smartAlert("Atenção", "Informe um Sindicato!", "error");
					return
				}
				limpaTodoCampoValorPlanoSaude()
				limpaCamposSindicato(2);
				valorDescontoPlanoSaudeSindicato(sindicato);
			} else if (tipoDesconto == 3) {
				if (projeto == 0) {
					smartAlert("Atenção", "Informe um Projeto!", "error");
				}
				limpaTodoCampoValorPlanoSaude()
				limpaCamposProjeto(2)
				valorDescontoPlanoSaudeProjeto(projeto);
			}
		});
		$("#baseDescontoPlanoSaudeDependente").on("focusout", function() {
			var projeto = +$("#projeto").val();
			var sindicato = +$("#sindicato").val();
			var produto = +$("#produtoDependente").val();
			var tipoDesconto = +$("#baseDescontoPlanoSaudeDependente").val();

			if (tipoDesconto == 1) {
				if (produto == 0) {
					smartAlert("Atenção", "Informe um Produto!", "error");
					return
				}
				limpaTodoCampoValorPlanoSaudeDependente()
				limpaCamposPlanoSaudeDependente(2);
				valorDescontoPlanoSaudeDependente(produto);
			} else if (tipoDesconto == 2) {
				if (sindicato == 0) {
					smartAlert("Atenção", "Informe um Sindicato!", "error");
					return
				}
				limpaTodoCampoValorPlanoSaudeDependente()
				limpaCamposSindicatoDependente(2);
				valorDescontoPlanoSaudeSindicatoDependente(sindicato);
			} else if (tipoDesconto == 3) {
				if (projeto == 0) {
					smartAlert("Atenção", "Informe um Projeto!", "error");
				}
				limpaTodoCampoValorPlanoSaudeDependente();
				limpaCamposProjetoDependente(2);
				valorDescontoPlanoSaudeProjetoDependente(projeto);
			}
		});
		$("#sindicato").on("change", function() {
			var sindicato = +$("#sindicato").val();
			valorDescontoValeRefeicaoSindicato(sindicato);
			recuperaValorBolsaBeneficioSindicato(sindicato);
			populaDescricaoSindicato();

		});

		$("#tipoVale").on("change", function() {
			var id = +$("#tipoVale").val();
			if (id == 0 || id == 1) {
				populaComboVT(id,
					function(data) {
						var atributoId = '#' + 'valeTransporte';
						if (data.indexOf('failed') > -1) {
							return;
						} else {
							data = data.replace(/failed/g, '');
							var piece = data.split("#");

							var mensagem = piece[0];
							var qtdRegs = piece[1];
							var arrayRegistros = piece[2].split("|");
							var registro = "";

							$(atributoId).html('');
							$(atributoId).append('<option></option>');

							for (var i = 0; i < qtdRegs; i++) {
								registro = arrayRegistros[i].split("^");
								$(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
							}
						}
					}
				);
			}
		});

		$("#btnVoltar").on("click", function() {
			voltar();
		});
		$("#produtoTitular").on("change", function() {
			var produto = $("#produtoTitular").val();
			preencheProdutoCobranca();
			populaComboCobranca();
			limpaTodoCampoValorPlanoSaude()

		});
		$("#produtoDependente").on("change", function() {
			preencheProdutoCobrancaDependente();
			populaComboCobrancaDependente();
			limpaTodoCampoValorPlanoSaudeDependente()

		});

		$("#convenioTitular").on("change", function() {
			var convenio = $("#convenioTitular").val();
			if (convenio > 0) {
				limpaTodoCampoValorPlanoSaude();

				habilitaCampoProduto()
				populaComboProduto();
			}
		});

		$("#convenioDependente").on("change", function() {
			habilitaCampoProduto()
			populaComboProdutoDependente();
		});


		$("#descontoSindicatoTitular").on("change", function() {
			var descontoSindicatoTitular = $("#descontoSindicatoTitular").val();
			var codigoVerificador = 0;
			if (descontoSindicatoTitular != "") {
				limpaCamposSindicato(codigoVerificador);
				calculaValorFuncionarioTitularPlanoSaude();
				calculaValorEmpresa();
			}
		});


		$("#valorDescontoSindicatoTitular").on("change", function() {
			var valorDescontoSindicatoTitular = $("#valorDescontoSindicatoTitular").val();
			var codigoVerificador = 1
			if (valorDescontoSindicatoTitular != "") {
				limpaCamposSindicato(codigoVerificador);
				calculaValorFuncionarioTitularPlanoSaude();
				calculaValorEmpresa();

			}
		});


		$("#descontoProjetoTitular").on("change", function() {
			var descontoProjetoTitular = $("#descontoProjetoTitular").val();
			var codigoVerificador = 0;
			if (descontoProjetoTitular != "") {
				limpaCamposProjeto(codigoVerificador);
				calculaValorFuncionarioTitularPlanoSaude();
				calculaValorEmpresa();
			}
		});


		$("#valorDescontoProjetoTitular").on("change", function() {
			var valorDescontoProjetoTitular = $("#valorDescontoProjetoTitular").val();
			var codigoVerificador = 1;
			if (valorDescontoProjetoTitular != "") {
				limpaCamposProjeto(codigoVerificador);
				calculaValorFuncionarioTitularPlanoSaude();
				calculaValorEmpresa();

			}
		});
		$("#descontoPlanoSaudeTitular").on("change", function() {
			var descontoPlanoSaudeTitular = $("#descontoPlanoSaudeTitular").val();
			var codigoVerificador = 0;
			if (descontoSindicatoTitular != "") {
				limpaCamposPlanoSaude(codigoVerificador);
				calculaValorFuncionarioTitularPlanoSaude();
				calculaValorEmpresa();


			}
		});
		$("#valorDescontoPlanoSaudeTitular").on("change", function() {
			var valorDescontoPlanoSaudeTitular = $("#valorDescontoPlanoSaudeTitular").val();
			var codigoVerificador = 1;
			if (descontoSindicatoTitular != "") {
				limpaCamposPlanoSaude(codigoVerificador);
				calculaValorFuncionarioTitularPlanoSaude();
				calculaValorEmpresa();

			}
		});

		$("#btnGravar").on("click", function() {
			var projeto = +$("#projeto").val();
			var funcionario = +$("#funcionario").val();
			var tipoDiaUtil = +$("#tipoDiaUtil").val();
			var sindicato = +$("#sindicato").val();

			if (projeto == 0) {
				smartAlert("Atenção", "Informe o Projeto!", "error");
				$("#projeto").focus();
				return
			}
			if (funcionario == 0) {
				smartAlert("Atenção", "Informe o Funcionario!", "error");
				$("#funcionario").focus();
				return
			}
			if (tipoDiaUtil == 0) {
				smartAlert("Atenção", "Informe o Tipo de Dia Util!", "error");
				$("#tipoDiaUtil").focus();
				return
			}
			if (sindicato == 0) {
				smartAlert("Atenção", "Informe o Sindicato!", "error");
				$("#sindicato").focus();
				return
			}
			gravar();
		});




		$("#nomeDependente").on("change", function() {
			calculaIdadeFuncionarioDependente();

		});
		$("#descontoSindicatoDependente").on("change", function() {
			var descontoSindicatoDependente = $("#descontoSindicatoDependente").val();
			var codigoVerificador = 0;
			if (descontoSindicatoDependente !== "") {
				limpaCamposSindicatoDependente(codigoVerificador);
				calculaValorFuncionarioDependentePlanoSaude();
				calculaValorEmpresaDependente();
			}

		});

		$("#valorDescontoSindicatoDependente").on("change", function() {
			var valorDescontoSindicatoDependente = $("#valorDescontoSindicatoDependente").val();
			var codigoVerificador = 1;
			if (valorDescontoSindicatoDependente !== "") {
				limpaCamposSindicatoDependente(codigoVerificador);
				calculaValorFuncionarioDependentePlanoSaude();
				calculaValorEmpresaDependente();
			}

		});

		$("#descontoProjetoDependente").on("change", function() {
			var descontoProjetoDependente = $("#descontoProjetoDependente").val();
			var codigoVerificador = 0;
			if (descontoProjetoDependente !== "") {
				limpaCamposProjetoDependente(codigoVerificador);
				calculaValorFuncionarioDependentePlanoSaude();
				calculaValorEmpresaDependente();
			}
		});

		$("#valorDescontoProjetoDependente").on("change", function() {
			var valorDescontoProjetoDependente = $("#valorDescontoProjetoDependente").val();
			var codigoVerificador = 1;
			if (valorDescontoProjetoDependente !== "") {
				limpaCamposProjetoDependente(codigoVerificador)
				calculaValorFuncionarioDependentePlanoSaude();
				calculaValorEmpresaDependente();
			}
		});

		$("#descontoPlanoSaudeDependente").on("change", function() {
			var descontoPlanoSaudeDependente = $("#descontoPlanoSaudeDependente").val();
			var codigoVerificador = 0;
			if (descontoPlanoSaudeDependente !== "") {
				limpaCamposPlanoSaudeDependente(codigoVerificador);
				calculaValorFuncionarioDependentePlanoSaude();
				calculaValorEmpresaDependente();
			}

		});

		$("#valorDescontoPlanoSaudeDependente").on("change", function() {
			var valorDescontoPlanoSaudeDependente = $("#valorDescontoPlanoSaudeDependente").val();
			var codigoVerificador = 1;
			if (valorDescontoPlanoSaudeDependente !== "") {
				limpaCamposPlanoSaudeDependente(codigoVerificador);
				calculaValorFuncionarioDependentePlanoSaude();
				calculaValorEmpresaDependente();
			}
		});

		$("#valorAcrescimo").on("change", function() {
			var saldoDisponivel = $("#saldoDisponivel").val();
			var valorAcrescimo = $("#valorAcrescimo").val();
			saldoDisponivel = stringToFloat(saldoDisponivel);
			valorAcrescimo = stringToFloat(valorAcrescimo)
			if (valorAcrescimo > saldoDisponivel) {
				smartAlert("Atenção", "O Valor do Acréscimo é maior do que o saldo disponível!", 'error');
				$("#valorAcrescimo").val("");
				$("#valorAcrescimo").focus();
				return;
			}
			calculaValorFinalBeneficio();

		});
		$("#valorAbater").on("change", function() {
			var valorBeneficioFuncionario = $("#valorBeneficioFuncionario").val().replace(",", ".");
			var valorAbater = $("#valorAbater").val().toString().replace(",", ".");
			var valorFinalBeneficio = 0;
			var valorBeneficio = $("#valorBeneficioFuncionario").val().replace(",", ".");
			var beneficioIndireto = $("#beneficioIndireto").val();
			var valorFinalBeneficio = 0;
			//Ve se o valor informado é coerente com o saldo disponível
			var saldoDisponivel = $("#saldoDisponivel").val();
			var valorAbaterCalculo = $("#valorAbater").val();
			saldoDisponivel = stringToFloat(saldoDisponivel);
			valorAbaterCalculo = stringToFloat(valorAbaterCalculo);
			if (valorAbaterCalculo > saldoDisponivel) {
				smartAlert("Atenção", "O Valor do a abater é maior do que o saldo disponível!", 'error');
				$("#valorAbater").val("");
				$("#valorAbater").focus();
				return;
			}

			if (parseFloat(valorAbater) >= 0 && beneficioIndireto == 3) {
				valorFinalBeneficio = parseFloat(valorBeneficioFuncionario) - parseFloat(valorAbater);
				valorFinalBeneficio = valorFinalBeneficio.toFixed(2).toString().replace(".", ",");
				$("#valorFinalBeneficio").val(valorFinalBeneficio);
				initializeDecimalBehaviour();
			}
			if (beneficioIndireto != 3) {
				valorFinalBeneficio = parseFloat(valorBeneficio) + parseFloat(valorAbater);

			}
			initializeDecimalBehaviour();
			$("#valorFinalBeneficio").val(valorFinalBeneficio);

		});


		$("#beneficioIndireto").on("change", function() {
			var beneficioIndireto = +$("#beneficioIndireto").val();
			var tipoDescontoVA = +$("#tipoDescontoVA").val();
			var saldoDisponivel = $("#saldoDisponivel").val();
			var valorTotalGeral = $("#valorTotalGeral").val();
			switch (beneficioIndireto) {


				case 1:
					if (tipoDescontoVA == 1) {
						desabilitaCampoAbater();
						var valorMensalSindicatoVA = $("#valorMensalSindicatoVA").val();
						var valorDiarioSindicatoVA = $("#valorDiarioSindicatoVA").val();
						if (valorMensalSindicatoVA === "0,00") {
							$("#valorBeneficioFuncionario").val(valorDiarioSindicatoVA);
							$("#valorAcrescimo").val('');
							$("#valorAcrescimo").val(saldoDisponivel);
							$("#valorFinalBeneficio").val('');

							calculaValorFinalBeneficio();
						} else {
							$("#valorAcrescimo").val('');
							$("#valorBeneficioFuncionario").val(valorMensalSindicatoVA);
							$("#valorAcrescimo").val(saldoDisponivel);
							calculaValorFinalBeneficio();
						}
						break;
					} else if (tipoDescontoVA == 0) {
						desabilitaCampoAbater();
						var valorMensalProjetoVA = $("#valorMensalProjetoVA").val();
						var valorDiarioProjetoVA = $("#valorDiarioProjetoVA").val();
						if (valorMensalProjetoVA === "0,00") {
							$("#valorBeneficioFuncionario").val(valorDiarioProjetoVA);
							$("#valorAcrescimo").val(saldoDisponivel);
							$("#valorFinalBeneficio").val('');
							calculaValorFinalBeneficio();
						} else {
							$("#valorBeneficioFuncionario").val(valorMensalProjetoVA);
							$("#valorAcrescimo").val(saldoDisponivel);
							$("#valorFinalBeneficio").val('');
							calculaValorFinalBeneficio();
						}
						break;
					} else if (tipoDescontoVA == 2) {
						desabilitaCampoAbater();
						var valorMensalFuncionarioVA = $("#valorMensalFuncionarioVA").val();
						var valorDiarioFuncionarioVA = $("#valorDiarioFuncionarioVA").val();
						$("#valorAcrescimo").val(saldoDisponivel);
						$("#valorFinalBeneficio").val('');
						if (valorMensalFuncionarioVA === "0,00") {
							$("#valorBeneficioFuncionario").val(valorDiarioFuncionarioVA);
						} else {
							$("#valorBeneficioFuncionario").val(valorMensalFuncionarioVA);
						}
					}
					case 3:
						if (beneficioIndireto == 3) {
							desbilitaCampoAcrescimo();
							$("#valorBeneficioFuncionario").val(valorTotalGeral);
							$("#valorAbater").val('');
							$("#valorFinalBeneficio").val('');
						}

						break;
					default:
						break;
			}



		});


		$("#tipoDescontoVA").on("change", function() {

			if ($("#tipoDescontoVA").val() == "") {
				return
			} else {
				var tipoDesconto = +$("#tipoDescontoVA").val();
			}
			var projeto = $("#projeto").val();
			var sindicato = $("#sindicato").val();
			recuperaTipoDescontoVA(tipoDesconto, projeto, sindicato);
			switch (tipoDesconto) {
				case 0:
					limpaCampoVaProjeto();

					break;
				case 1:
					limpaCampoVaSindicato()
					break;
				case 2:
					limpaCampoVaFuncionario();
					break;
				default:
					break;
			}
		});
		$("#valorDiarioProjetoVR").on("change", function() {
			$("#valorMensalProjetoVR").val('');
		});
		$("#valorMensalProjetoVR").on("change", function() {
			$("#valorDiarioProjetoVR").val('');
		});
		$("#percentualDescontoProjetoVR").on("change", function() {
			$("#valorDescontoProjetoVR").val('');
		});
		$("#valorDescontoProjetoVR").on("change", function() {
			$("#percentualDescontoProjetoVR").val('');
		});
		$("#valorDiarioSindicatoVR").on("change", function() {
			$("#valorMensalSindicatoVR").val('');
		});
		$("#valorMensalSindicatoVR").on("change", function() {
			$("#valorDiarioSindicatoVR").val('');
		});
		$("#percentualDescontoSindicatoVR").on("change", function() {
			$("#valorDescontoSindicatoVR").val('');
		});
		$("#valorDescontoSindicatoVR").on("change", function() {
			$("#percentualDescontoSindicatoVR").val('');
		});
		$("#valorDiaFuncionarioVR").on("change", function() {
			$("#valorMensalFuncionarioVR").val('');
		});
		$("#valorMensalFuncionarioVR").on("change", function() {
			$("#valorDiaFuncionarioVR").val('');
		});
		$("#percentualDescontoFuncionarioVR").on("change", function() {
			$("#valorDescontoFuncionarioVR").val('');
		});
		$("#valorDescontoFuncionarioVR").on("change", function() {
			$("#percentualDescontoFuncionarioVR").val('');
		});
		$("#percentualDescontoMesCorrenteVR").on("change", function() {
			$("#valorDescontoMesCorrenteVR").val('');
		});
		$("#valorDescontoMesCorrenteVR").on("change", function() {
			$("#percentualDescontoMesCorrenteVR").val('');
		});

		$("#valorDiarioProjetoVA").on("change", function() {
			$("#valorMensalProjetoVA").val('');
		});
		$("#valorMensalProjetoVA").on("change", function() {
			$("#valorDiarioProjetoVA").val('');
		});
		$("#percentualDescontoProjetoVA").on("change", function() {
			$("#valorDescontoProjetoVA").val('');
		});
		$("#valorDiarioSindicatoVA").on("change", function() {
			$("#valorMensalSindicatoVA").val('');
		});
		$("#valorMensalSindicatoVA").on("change", function() {
			$("#valorDiarioSindicatoVA").val('');
		});
		$("#percentualDescontoSindicatoVA").on("change", function() {
			$("#valorDescontoSindicatoVA").val('');
		});
		$("#valorDescontoSindicatoVA").on("change", function() {
			$("#percentualDescontoSindicatoVA").val('');
		});
		$("#valorDiarioFuncionarioVA").on("change", function() {
			$("#valorMensalFuncionarioVA").val('');
		});
		$("#valorMensalFuncionarioVA").on("change", function() {
			$("#valorDiarioFuncionarioVA").val('');
		});
		$("#valorDiarioFuncionarioVA").on("change", function() {
			$("#valorMensalFuncionarioVA").val('');
		});
		$("#valorMensalFuncionarioVA").on("change", function() {
			$("#valorDiarioFuncionarioVA").val('');
		});
		$("#percentualDescontoMesCorrenteVA").on("change", function() {
			$("#valorDescontoMesCorrenteVA").val('');
		});
		$("#valorDescontoMesCorrenteVA").on("change", function() {
			$("#percentualDescontoMesCorrenteVA").val('');
		});
		$("#percentualDescontoSindicatoCestaBasica").on("change", function() {
			$("#valorDescontoSindicatoCestaBasica").val('');
		});
		$("#valorDescontoSindicatoCestaBasica").on("change", function() {
			$("#percentualDescontoSindicatoCestaBasica").val('');
		});
		$("#valorDescontoSindicatoCestaBasica").on("change", function() {
			$("#percentualDescontoSindicatoCestaBasica").val('');
		});
		$("#projeto").on("change", function() {
			verificaFuncionariEmProjeto();
			popularComboDescricaoPosto();
		});
		$("#descricaoPosto").on("change", function() {
			buscaValorPosto();
		});


		validaValeTransporte();
		calculaTrajetoValeTransporte();

	});

	function carregaPagina() {
		var urlx = window.document.URL.toString();
		var params = urlx.split("?");
		if (params.length === 2) {
			var id = params[1];
			var idx = id.split("=");
			var idd = idx[1];
			if (idd !== "") {
				recuperaBeneficio(idd,
					function(data) {
						if (data.indexOf('failed') > -1) {} else {
							data = data.replace(/failed/g, '');
							var piece = data.split("#");
							var mensagem = piece[0];
							var out = piece[1];
							var strArrayVT = piece[2];
							var strArrayPlanoSaude = piece[3];
							var strArrayPlanoSaudeDependente = piece[4];
							var strArrayBeneficioIndireto = piece[5];
							console.table(JSON.stringify(strArrayVT))

							piece = out.split("^");
							//console.table(piece);			
							var codigo = piece[0];
							var projeto = piece[1];
							var funcionario = piece[2];
							var tipoDiaUtil = piece[3];
							var sindicato = piece[4];
							var percentualDescontoProjetoVR = piece[5];
							var valorDescontoProjetoVR = piece[6];
							var percentualDescontoSindicatoVR = piece[7];
							var valorDescontoSindicatoVR = piece[8];
							var percentualDescontoFuncionarioVR = piece[9];
							var valorDescontoFuncionarioVR = piece[10];
							var percentualDescontoMesCorrenteVR = piece[11];
							var valorDescontoMesCorrenteVR = piece[12];
							var percentualDescontoProjetoVA = piece[13];
							var valorDescontoProjetoVA = piece[14];
							var percentualDescontoSindicatoVA = piece[15];
							var valorDescontoSindicatoVA = piece[16];
							var valorDiarioFuncionarioVA = piece[17];
							var valorMensalFuncionarioVA = piece[18];
							var percentualDescontoMesCorrenteVA = piece[19];
							var valorDescontoMesCorrenteVA = piece[20];
							var valorDiarioFuncionarioVA = piece[21];
							var valorCestaBasica = piece[22];
							//Recuperando os dias de VAVR
							var diaUtilJaneiro = piece[23];
							var diaUtilFevereiro = piece[24];
							var diaUtilMarco = piece[25];
							var diaUtilAbril = piece[26];
							var diaUtilMaio = piece[27];
							var diaUtilJunho = piece[28];
							var diaUtilJulho = piece[29];
							var diaUtilAgosto = piece[30];
							var diaUtilSetembro = piece[31];
							var diaUtilOutubro = piece[32];
							var diaUtilNovembro = piece[33];
							var diaUtilDezembro = piece[34]; //--

							var valorDiarioProjetoVA = piece[35];
							var valorMensalProjetoVA = piece[36];
							var valorDiarioSindicatoVA = piece[37];
							var valorMensalSindicatoVA = piece[38];
							var percentualFuncionarioFolhaVA = piece[39];
							var valorFuncionarioFolhaVA = piece[40];
							var valorProdutoVA = piece[41];
							var valorFuncionarioVA = piece[42];
							var valorEmpresaVA = piece[43];
							var valorDiarioSindicatoCestaBasica = piece[44];
							var valorMensalSindicatoCestaBasica = piece[45];
							var percentualDescontoSindicatoCestaBasica = piece[46];
							var valorDescontoSindicatoCestaBasica = piece[47];
							var valorProdutoCestaBasica = piece[48];
							var valorFuncionarioCestaBasica = piece[49];
							var valorEmpresaCestaBasica = piece[50];

							var tipoDescontoVA = piece[51];
							var perdaBeneficio = piece[52];
							var saldoDisponivel = piece[53];
							var salarioFuncionario = piece[54];
							var consideraVa = piece[55];
							var consideraVt = piece[56];
							var trajetoIdaVolta = piece[57]

							//Recuperando os dias de VT
							var diaUtilJaneiroVT = piece[58];
							var diaUtilFevereiroVT = piece[59];
							var diaUtilMarcoVT = piece[60];
							var diaUtilAbrilVT = piece[61];
							var diaUtilMaioVT = piece[62];
							var diaUtilJunhoVT = piece[63];
							var diaUtilJulhoVT = piece[64];
							var diaUtilAgostoVT = piece[65];
							var diaUtilSetembroVT = piece[66];
							var diaUtilOutubroVT = piece[67];
							var diaUtilNovembroVT = piece[68];
							var diaUtilDezembroVT = piece[69];
							var tipoDiaUtilVAVR = piece[70];
							var tipoDiaUtilVT = piece[71];

							var municipioDiasUteisVAVR = piece[72];
							var municipioDiasUteisVT = piece[73];
							var municipioFerias = piece[74];
							var tipoBeneficio = piece[75];
							var escalaFerias = piece[76];
							var escalaFeriasVAVR = piece[77];
							var localizacao = piece[78];
							var descricaoPosto = piece[79];
							var horaEntrada = piece[80];
							var horaInicio = piece[81];
							var horaFim = piece[82];
							var horaSaida = piece[83];
							var departamento = piece[84];


							$("#codigo").val(codigo);
							$("#projeto").val(projeto);
							$("#funcionario").val(funcionario);
							$("#tipoDiaUtil").val(tipoDiaUtil);
							$("#sindicato").val(sindicato);
							$("#salarioFuncionario").val(salarioFuncionario);


							//################# ACORDION DE VAVR ###############//
							$("#percentualDescontoProjetoVA").val(percentualDescontoProjetoVA);
							$("#valorDescontoProjetoVA").val(valorDescontoProjetoVA);
							$("#percentualDescontoSindicatoVA").val(percentualDescontoSindicatoVA);
							$("#valorDescontoSindicatoVA").val(valorDescontoSindicatoVA);
							$("#valorDiarioFuncionarioVA").val(valorDiarioFuncionarioVA);
							$("#valorMensalFuncionarioVA").val(valorMensalFuncionarioVA);
							$("#percentualDescontoMesCorrenteVA").val(percentualDescontoMesCorrenteVA);
							$("#valorDescontoMesCorrenteVA").val(valorDescontoMesCorrenteVA);
							$("#valorDiarioFuncionarioVA").val(valorDiarioFuncionarioVA);
							$("#valorDiarioProjetoVA").val(valorDiarioProjetoVA);
							$("#valorMensalProjetoVA").val(valorMensalProjetoVA);
							$("#valorDiarioSindicatoVA").val(valorDiarioSindicatoVA);
							$("#valorMensalSindicatoVA").val(valorMensalSindicatoVA);
							$("#percentualDescontoFolhaFuncionarioVA").val(percentualFuncionarioFolhaVA);
							$("#valorDescontoFolhaFuncionarioVA").val(valorFuncionarioFolhaVA);
							// $("#valorProdutoVA").val(valorProdutoVA);
							// $("#valorFuncionarioVA").val(valorFuncionarioVA);
							// $("#valorEmpresaVA").val(valorEmpresaVA);
							$("#tipoDescontoVA").val(tipoDescontoVA);

							//################# ACORDION DE  BENEFICIOS ###############//

							$("#valorCestaBasica").val(valorCestaBasica);
							// $("#valorDiarioSindicatoCestaBasica").val(valorDiarioSindicatoCestaBasica);
							$("#valorMensalSindicatoCestaBasica").val(valorMensalSindicatoCestaBasica);
							$("#percentualDescontoSindicatoCestaBasica").val(percentualDescontoSindicatoCestaBasica);
							$("#valorDescontoSindicatoCestaBasica").val(valorDescontoSindicatoCestaBasica);
							$("#perdaBeneficio").val(perdaBeneficio);

							//################# ACORDION DE DIAS UTEIS ###############//
							habilitaCampoDiaUtil();

							//Dias Uteis VAVR
							$("#diaUtilJaneiro").val(diaUtilJaneiro);
							$("#diaUtilFevereiro").val(diaUtilFevereiro);
							$("#diaUtilMarco").val(diaUtilMarco);
							$("#diaUtilAbril").val(diaUtilAbril);
							$("#diaUtilMaio").val(diaUtilMaio);
							$("#diaUtilJunho").val(diaUtilJunho);
							$("#diaUtilJulho").val(diaUtilJulho);
							$("#diaUtilAgosto").val(diaUtilAgosto);
							$("#diaUtilSetembro").val(diaUtilSetembro);
							$("#diaUtilOutubro").val(diaUtilOutubro);
							$("#diaUtilNovembro").val(diaUtilNovembro);
							$("#diaUtilDezembro").val(diaUtilDezembro);
							$("#consideraVa").val(consideraVa);
							$("#tipoDiaUtilVAVR").val(tipoDiaUtilVAVR);
							if (tipoDiaUtilVAVR == 5) {
								habilitaDesabilitaCamposDiasUteisMunicipio(2, ("#municipioDiasUteis"))
								$("#municipioDiasUteis").val(municipioDiasUteisVAVR);
							}

							$("#consideraVt").val(consideraVt);

							//Dias Uteis VT
							$("#diaUtilJaneiroVT").val(diaUtilJaneiroVT);
							$("#diaUtilFevereiroVT").val(diaUtilFevereiroVT);
							$("#diaUtilMarcoVT").val(diaUtilMarcoVT);
							$("#diaUtilAbrilVT").val(diaUtilAbrilVT);
							$("#diaUtilMaioVT").val(diaUtilMaioVT);
							$("#diaUtilJunhoVT").val(diaUtilJunhoVT);
							$("#diaUtilJulhoVT").val(diaUtilJulhoVT);
							$("#diaUtilAgostoVT").val(diaUtilAgostoVT);
							$("#diaUtilSetembroVT").val(diaUtilSetembroVT);
							$("#diaUtilOutubroVT").val(diaUtilOutubroVT);
							$("#diaUtilNovembroVT").val(diaUtilNovembroVT);
							$("#diaUtilDezembroVT").val(diaUtilDezembroVT);
							$("#tipoDiaUtilVT").val(tipoDiaUtilVT);
							if (tipoDiaUtilVT == 5) {
								habilitaDesabilitaCamposDiasUteisMunicipio(2, ("#municipioDiasUteisVT"))
								$("#municipioDiasUteisVT").val(municipioDiasUteisVT);
							}


							$("#jsonValeTransporte").val(strArrayVT);
							$("#jsonPlanoSaude").val(strArrayPlanoSaude);
							$("#jsonPlanoSaudeDependente").val(strArrayPlanoSaudeDependente);
							$("#jsonBeneficioIndireto").val(strArrayBeneficioIndireto);
							$("#verificaRecuperacao").val(1);
							$("#trajetoIdaVolta").val(trajetoIdaVolta);
							$("#municipioFerias").val(municipioFerias);
							$("#tipoBeneficio").val(tipoBeneficio);
							$("#escalaFerias").val(escalaFerias);
							$("#escalaFeriasVAVR").val(escalaFeriasVAVR);
							$("#localizacao").val(localizacao);
							$("#descricaoPosto").val(descricaoPosto);

							$("#horaEntrada").val(horaEntrada);
							$("#horaInicio").val(horaInicio);
							$("#horaFim").val(horaFim);
							$("#horaSaida").val(horaSaida);

							$("#departamento").val(departamento);

							jsonValeTransporteArray = JSON.parse($("#jsonValeTransporte").val());
							jsonPlanoSaudeArray = JSON.parse($("#jsonPlanoSaude").val());
							jsonPlanoSaudeDependenteArray = JSON.parse($("#jsonPlanoSaudeDependente").val());
							jsonBeneficioIndiretoArray = JSON.parse($("#jsonBeneficioIndireto").val());
							var sindicato = $("#sindicato").val();
							// var tipoDiaUtilVAVR = $("#tipoDiaUtil").val();
							var tipoDiaUtilVT = $("#tipoDiaUtilVT").val();




							// habilitaCampoProduto();
							fillTableValeTransporte();
							fillTablePlanoSaude();
							fillTablePlanoSaudeDependente();
							fillTableBeneficioIndireto();
							populaFuncionarioRecupera();
							populaDescricaoSindicato();
							initializeDecimalBehaviour();
							desabilitaCampoProduto();
							if (tipoDiaUtilVAVR == 3) {
								habilitaCampoDiaUtil();
							} else {
								desabilitaCampoDiaUtil();
							}
							if (tipoDiaUtilVT == 3) {
								habilitaCampoDiaUtilVT();
							} else {
								desabilitaCampoDiaUtilVT();
							}
							desabilitaCampoVaRecupera();
							$("#saldoDisponivel").val(saldoDisponivel);

							recuperaValorBolsaBeneficioSindicato(sindicato);
							buscaValorPosto(descricaoPosto);

						}
					}
				);

			}
		}
		$("#nome").focus();

	}

	function novo() {
		$(location).attr('href', 'cadastro_beneficioPessoalPorProjetoCadastro.php');
	}

	function voltar() {

		$(location).attr('href', 'cadastro_beneficioPessoalPorProjetoFiltro.php');
	}

	function excluir() {
		var id = +$("#codigo").val();

		if (id === 0) {
			smartAlert("Atenção", "Selecione um registro para excluir!", "error");
			return;
		}
		excluirBeneficio(id, () => {
			smartAlert("Atenção", "Operação Concluída!", "success");
			voltar();
		});
	}

	//############################################################################## LISTA DE PLANO SAUDE INICIO #######################################################################################################################

	function addPlanoSaude() {
		var item = $("#formPlanoSaude").toObject({
			mode: 'combine',
			skipEmpty: false,
			nodeCallback: processDataPlanoSaude
		});

		if (item["sequencialPlanoSaude"] === '') {
			if (jsonPlanoSaudeArray.length === 0) {
				item["sequencialPlanoSaude"] = 1;
			} else {
				item["sequencialPlanoSaude"] = Math.max.apply(Math, jsonPlanoSaudeArray.map(function(o) {
					return o.sequencialPlanoSaude;
				})) + 1;
			}
			item["planoSaudeId"] = 0;
		} else {
			item["sequencialPlanoSaude"] = +item["sequencialPlanoSaude"];
		}
		var index = -1;
		$.each(jsonPlanoSaudeArray, function(i, obj) {
			if (+$('#sequencialPlanoSaude').val() === obj.sequencialPlanoSaude) {
				index = i;
				return false;
			}
		});

		if (index >= 0)
			jsonPlanoSaudeArray.splice(index, 1, item);
		else
			jsonPlanoSaudeArray.push(item);

		$("#jsonPlanoSaude").val(JSON.stringify(jsonPlanoSaudeArray));
		fillTablePlanoSaude();

	}

	function processDataPlanoSaude(node) {
		var fieldId = node.getAttribute ? node.getAttribute('id') : '';
		var fieldName = node.getAttribute ? node.getAttribute('name') : '';

		if (fieldName === 'cobrancaTitular') {
			debugger;
		}

		if (fieldName !== '' && (fieldId === "descricaoFuncionarioTitular")) {
			return {
				name: fieldName,
				value: $("#funcionarioTitular option:selected").val()
			};
		}


		if (fieldName !== '' && (fieldId === "descricaoConvenioTitular")) {
			return {
				name: fieldName,
				value: $("#convenioTitular option:selected").val()
			};
		}


		if (fieldName !== '' && (fieldId === "descricaoProdutoTitular")) {
			return {
				name: fieldName,
				value: $("#produtoTitular option:selected").val()
			};
		}


		return false;
	}

	function fillTablePlanoSaude() {
		$("#tablePlanoSaude tbody").empty();
		var valorTotal = 0;
		var valorFinal = "";
		for (var i = 0; i < jsonPlanoSaudeArray.length; i++) {
			var row = $('<tr />');
			var descricaoFuncionario = $("#funcionarioTitular option[value = '" + jsonPlanoSaudeArray[i].descricaoFuncionarioTitular + "']").text();
			var descricaoConvenio = $("#convenioTitular option[value = '" + jsonPlanoSaudeArray[i].descricaoConvenioTitular + "']").text();
			var descricaoProduto = $("#produtoTitular option[value = '" + jsonPlanoSaudeArray[i].descricaoProdutoTitular + "']").text();
			var valorFuncionarioTitular = jsonPlanoSaudeArray[i].valorFuncionarioTitular;
			if (valorFuncionarioTitular == "") {
				valorFuncionarioTitular = 0;
			}
			var valorEmpresaTitular = jsonPlanoSaudeArray[i].valorEmpresaTitular;
			if (valorEmpresaTitular == "") {
				valorEmpresaTitular = 0;
			}
			$("#tablePlanoSaude tbody").append(row);
			row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonPlanoSaudeArray[i].sequencialPlanoSaude + '"><i></i></label></td>'));
			row.append($('<td class="text-nowrap" onclick="carregaPlanoSaude(' + jsonPlanoSaudeArray[i].sequencialPlanoSaude + ');">' + descricaoFuncionario + '</td>'));
			row.append($('<td class="text-nowrap">' + descricaoConvenio + '</td>'));
			row.append($('<td class="text-nowrap">' + descricaoProduto + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + valorFuncionarioTitular + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + valorEmpresaTitular + '</td>'));

			valorFinal = jsonPlanoSaudeArray[i].valorFuncionarioTitular;
			if (valorFinal === "") {
				valorFinal = 0;
			} else {
				valorFinal = parseFloat(valorFinal.toString().replace(".", "").replace(",", "."));
			}
			valorTotal += valorFinal;
		}
		valorTotal = roundDecimal(floatToString(valorTotal), 2);
		$("#valorTotalTitular").val(valorTotal);
		initializeDecimalBehaviour();
		calculaTotalGeral();
	}

	function validaPlanoSaude() {
		var existeFuncionario = false;
		var existeConvenio = false;
		var existeProduto = false;
		var achou = false;
		var funcionarioTitular = +$('#funcionarioTitular').val();
		var convenio = +$('#convenioTitular').val();
		var produto = +$('#produtoTitular').val();
		var sequencial = +$('#sequencialPlanoSaude').val();


		if (funcionarioTitular == 0) {
			smartAlert("Erro", "Informe um Funcionario.", "error");
			return false;
		}

		if (convenio == 0) {
			smartAlert("Erro", "Informe um Convenio.", "error");
			return false;
		}

		if (produto == 0) {
			smartAlert("Erro", "Informe um Produto.", "error");
			return false;
		}

		for (i = jsonPlanoSaudeArray.length - 1; i >= 0; i--) {
			if ((jsonPlanoSaudeArray[i].descricaoFuncionarioTitular == funcionarioTitular) && (jsonPlanoSaudeArray[i].sequencialPlanoSaude !== sequencial)) {
				existeFuncionario = true;

			}
			if ((jsonPlanoSaudeArray[i].descricaoConvenioTitular == convenio) && (jsonPlanoSaudeArray[i].sequencialPlanoSaude !== sequencial)) {
				existeConvenio = true;

			}
			if ((jsonPlanoSaudeArray[i].descricaoProdutoTitular == produto) && (jsonPlanoSaudeArray[i].sequencialPlanoSaude !== sequencial)) {
				existeProduto = true;

			}
			break;
		}
		if (existeFuncionario === true && existeConvenio == true && existeProduto == true) {
			smartAlert("Erro", "Funcionário não pode ter o mesmo Produto e Convênio.", "error");
			return false;
		}

		return true;
	}

	function clearPlanoSaude() {
		$('#convenioTitular').val("");
		$('#produtoTitular').val("");
		$('#cobrancaTitular').val('');
		$('#descontoSindicatoTitular').val('');
		$('#descontoProjetoTitular').val('');
		$('#valorDescontoSindicatoTitular').val('');
		$('#valorDescontoProjetoTitular').val('');
		$('#valorProdutoTitular').val('');
		$('#valorFuncionarioTitular').val('');
		$('#valorEmpresaTitular').val('');
		$('#valorTotalFuncionarioTitular').val('');
	}

	function carregaPlanoSaude(sequencialPlanoSaude) {
		// habilitaTodoCampoPlanoSaude()
		var arr = jQuery.grep(jsonPlanoSaudeArray, function(item, i) {
			return (item.sequencialPlanoSaude === sequencialPlanoSaude);
		});



		clearPlanoSaude();
		if (arr.length > 0) {
			var item = arr[0];
			limpaTodoCampoValorPlanoSaude()
			$('#convenioTitular').val(item.descricaoConvenioTitular);
			populaComboProduto();
			$('#produtoTitular').val(item.descricaoProdutoTitular);
			$('#cobrancaTitular').val(item.cobrancaTitular);
			$('#descontoSindicatoTitular').val(item.descontoSindicatoTitular);
			$('#descontoProjetoTitular').val(item.descontoProjetoTitular);
			$('#valorDescontoSindicatoTitular').val(item.valorDescontoSindicatoTitular);
			$('#valorDescontoProjetoTitular').val(item.valorDescontoProjetoTitular);
			$('#valorProdutoTitular').val(item.valorProdutoTitular);
			$('#valorFuncionarioTitular').val(item.valorFuncionarioTitular);
			$('#valorEmpresaTitular').val(item.valorEmpresaTitular);
			$('#sequencialPlanoSaude').val(item.sequencialPlanoSaude);
			$('#idadeTitular').val(item.idadeTitular);
			$('#funcionarioTitular').val(item.descricaoFuncionarioTitular);
			$('#baseDescontoPlanoSaudeTitular').val(item.baseDescontoPlanoSaudeTitular);
			var baseDesconto = $('#baseDescontoPlanoSaudeTitular').val();
			if (baseDesconto == 1) {
				limpaCamposPlanoSaude(2);
			} else if (baseDesconto == 2) {
				limpaCamposSindicato(2);
			} else if (baseDesconto == 3) {
				limpaCamposProjeto(2);
			}
			$('#valorDescontoPlanoSaudeTitular').val(item.valorDescontoPlanoSaudeTitular);
			$('#percentualDescontoPlanoSaudeTitular').val(item.percentualDescontoPlanoSaudeTitular);


			$("#produtoTitular").prop('disabled', false);
			$("#produtoTitular").removeClass('readonly');
			initializeDecimalBehaviour();

		}

	}

	function excluirPlanoSaude() {
		var arrSequencial = [];
		$('#tablePlanoSaude input[type=checkbox]:checked').each(function() {
			arrSequencial.push(parseInt($(this).val()));
		});

		if (arrSequencial.length > 0) {
			for (i = jsonPlanoSaudeArray.length - 1; i >= 0; i--) {
				var obj = jsonPlanoSaudeArray[i];
				if (jQuery.inArray(obj.sequencialPlanoSaude, arrSequencial) > -1) {
					jsonPlanoSaudeArray.splice(i, 1);
				}
			}

			$("#jsonPlanoSaude").val(JSON.stringify(jsonPlanoSaudeArray));
			fillTablePlanoSaude();
		} else
			smartAlert("Erro", "Selecione pelo menos 1 plano para excluir.", "error");
	}

	//############################################################################## LISTA PLANO SAUDE FIM ##########################################################################################################################


	//############################################################################## LISTA DE PLANO SAUDE INICIO #######################################################################################################################

	function addPlanoSaudeDependente() {
		var item = $("#formPlanoSaude").toObject({
			mode: 'combine',
			skipEmpty: false,
			nodeCallback: processDataPlanoSaudeDependente
		});

		if (item["sequencialPlanoSaudeDependente"] === '') {
			if (jsonPlanoSaudeDependenteArray.length === 0) {
				item["sequencialPlanoSaudeDependente"] = 1;
			} else {
				item["sequencialPlanoSaudeDependente"] = Math.max.apply(Math, jsonPlanoSaudeArray.map(function(o) {
					return o.sequencialPlanoSaudeDependente;
				})) + 1;
			}
			item["planoSaudeDependenteId"] = 0;
		} else {
			item["sequencialPlanoSaudeDependente"] = +item["sequencialPlanoSaudeDependente"];
		}
		var index = -1;
		$.each(jsonPlanoSaudeDependenteArray, function(i, obj) {
			if (+$('#sequencialPlanoSaudeDependente').val() === obj.sequencialPlanoSaudeDependente) {
				index = i;
				return false;
			}
		});

		if (index >= 0)
			jsonPlanoSaudeDependenteArray.splice(index, 1, item);
		else
			jsonPlanoSaudeDependenteArray.push(item);

		$("#jsonPlanoSaudeDependente").val(JSON.stringify(jsonPlanoSaudeDependenteArray));
		fillTablePlanoSaudeDependente();

	}

	function processDataPlanoSaudeDependente(node) {
		var fieldId = node.getAttribute ? node.getAttribute('id') : '';
		var fieldName = node.getAttribute ? node.getAttribute('name') : '';

		if (fieldName !== '' && (fieldId === "descricaoNomeDependente")) {
			return {
				name: fieldName,
				value: $("#nomeDependente option:selected").val()
			};
		}


		if (fieldName !== '' && (fieldId === "descricaoConvenioDependente")) {
			return {
				name: fieldName,
				value: $("#convenioDependente option:selected").val()
			};
		}


		if (fieldName !== '' && (fieldId === "descricaoProdutoDependente")) {
			return {
				name: fieldName,
				value: $("#produtoDependente option:selected").val()
			};
		}


		return false;
	}

	function fillTablePlanoSaudeDependente() {
		$("#tablePlanoSaudeDependente tbody").empty();
		var valorTotal = 0;
		var valorFinal = "";
		for (var i = 0; i < jsonPlanoSaudeDependenteArray.length; i++) {
			var row = $('<tr />');
			var descricaoDependente = $("#nomeDependente option[value = '" + jsonPlanoSaudeDependenteArray[i].descricaoNomeDependente + "']").text();
			var descricaoConvenio = $("#convenioDependente option[value = '" + jsonPlanoSaudeDependenteArray[i].descricaoConvenioDependente + "']").text();
			var descricaoProduto = $("#produtoDependente option[value = '" + jsonPlanoSaudeDependenteArray[i].descricaoProdutoDependente + "']").text();
			$("#tablePlanoSaudeDependente tbody").append(row);
			row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonPlanoSaudeDependenteArray[i].sequencialPlanoSaudeDependente + '"><i></i></label></td>'));
			row.append($('<td class="text-nowrap" onclick="carregaPlanoSaudeDependente(' + jsonPlanoSaudeDependenteArray[i].sequencialPlanoSaudeDependente + ');">' + descricaoDependente + '</td>'));
			row.append($('<td class="text-nowrap">' + descricaoConvenio + '</td>'));
			row.append($('<td class="text-nowrap">' + descricaoProduto + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + jsonPlanoSaudeDependenteArray[i].valorDependente + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + jsonPlanoSaudeDependenteArray[i].valorEmpresaDependente + '</td>'));


			valorFinal = jsonPlanoSaudeDependenteArray[i].valorDependente;
			if (valorFinal === "") {
				valorFinal = 0;
			} else {
				valorFinal = parseFloat(valorFinal.toString().replace(".", "").replace(",", "."));
			}
			valorTotal += valorFinal;
		}
		valorTotal = roundDecimal(floatToString(valorTotal), 2);
		$("#valorTotalDependente").val(valorTotal);
		initializeDecimalBehaviour();
		calculaTotalGeral();


	}

	function validaPlanoSaudeDependente() {
		var existeDependente = false;
		var existeConvenio = false;
		var existeProduto = false;
		var achou = false;
		var dependente = +$('#nomeDependente').val();
		var convenio = +$('#convenioDependente').val();
		var produto = +$('#produtoDependente').val();
		var sequencial = +$('#sequencialPlanoSaudeDependente').val();


		if (dependente == 0) {
			smartAlert("Erro", "Informe um Dependente.", "error");
			return false;
		}

		if (convenio == 0) {
			smartAlert("Erro", "Informe um Convenio.", "error");
			return false;
		}

		if (produto == 0) {
			smartAlert("Erro", "Informe um Produto.", "error");
			return false;
		}

		for (i = jsonPlanoSaudeDependenteArray.length - 1; i >= 0; i--) {
			if ((jsonPlanoSaudeDependenteArray[i].descricaoNomeDependente == dependente) && (jsonPlanoSaudeDependenteArray[i].sequencialPlanoSaudeDependente !== sequencial)) {
				existeDependente = true;

			}
			if ((jsonPlanoSaudeDependenteArray[i].descricaoConvenioDependente == convenio) && (jsonPlanoSaudeDependenteArray[i].sequencialPlanoSaudeDependente !== sequencial)) {
				existeConvenio = true;

			}
			if ((jsonPlanoSaudeDependenteArray[i].descricaoProdutoDependente == produto) && (jsonPlanoSaudeDependenteArray[i].sequencialPlanoSaudeDependente !== sequencial)) {
				existeProduto = true;

			}
			break;
		}
		if (existeDependente === true && existeConvenio == true && existeProduto == true) {
			smartAlert("Erro", "Dependente não pode ter o mesmo Produto e Convênio.", "error");
			return false;
		}

		return true;
	}


	function clearPlanoSaudeDependente() {
		$("#dependente").val("");
		$('#convenioTitular').val("");
		$('#produtoTitular').val("");
		$('#cobrancaTitular').val('');
		$('#descontoSindicatoTitular').val('');
		$('#descontoProjetoTitular').val('');
		$('#valorDescontoSindicatoTitular').val('');
		$('#valorDescontoProjetoTitular').val('');
		$('#valorProdutoTitular').val('');
		$('#valorFuncionarioTitular').val('');
		$('#valorEmpresaTitular').val('');
		$('#valorTotalFuncionarioTitular').val('');
	}

	function carregaPlanoSaudeDependente(sequencialPlanoSaudeDependente) {
		var arr = jQuery.grep(jsonPlanoSaudeDependenteArray, function(item, i) {
			return (item.sequencialPlanoSaudeDependente === sequencialPlanoSaudeDependente);
		});
		debugger;
		clearPlanoSaude();
		habilitaTodoCampoPlanoSaudeDependente();
		limpaTodoCampoValorPlanoSaudeDependente();

		if (arr.length > 0) {
			var item = arr[0];
			// populaComboNomeDependente();
			$('#nomeDependente').val(item.descricaoNomeDependente);
			$('#idadeDependente').val(item.idadeDependente);
			$('#convenioDependente').val(item.descricaoConvenioDependente);
			$('#produtoDependente').val(item.descricaoProdutoDependente);
			$('#cobrancaDependente').val(item.cobrancaDependente);
			$('#descontoSindicatoDependente').val(item.descontoSindicatoDependente);
			$('#valorDescontoSindicatoDependente').val(item.valorDescontoSindicatoDependente);
			$('#descontoProjetoDependente').val(item.descontoProjetoDependente);
			$('#valorDescontoProjetoDependente').val(item.valorDescontoProjetoDependente);
			$('#valorProdutoDependente').val(item.valorProdutoDependente);
			$('#valorEmpresaDependente').val(item.valorEmpresaDependente);
			$('#idadeTitular').val(item.idadeTitular);
			$('#valorDependente').val(item.valorDependente);
			$('#funcionarioTitular').val(item.descricaoFuncionarioTitular);
			$('#sequencialPlanoSaudeDependente').val(item.sequencialPlanoSaudeDependente);
			$('#baseDescontoPlanoSaudeDependente').val(item.baseDescontoPlanoSaudeDependente);
			var baseDesconto = $('#baseDescontoPlanoSaudeDependente').val();
			if (baseDesconto == 1) {
				limpaCamposPlanoSaudeDependente(2)
			} else if (baseDesconto == 2) {
				limpaCamposSindicatoDependente(2)
			} else if (baseDesconto == 3) {
				limpaCamposProjetoDependente(2);
			}


			$("#nomeDependente").prop('disabled', false);
			$("#nomeDependente").removeClass('readonly');
			initializeDecimalBehaviour();

		}

	}

	function excluirPlanoSaudeDependente() {
		var arrSequencial = [];
		$('#tablePlanoSaudeDependente input[type=checkbox]:checked').each(function() {
			arrSequencial.push(parseInt($(this).val()));
		});

		if (arrSequencial.length > 0) {
			for (i = jsonPlanoSaudeDependenteArray.length - 1; i >= 0; i--) {
				var obj = jsonPlanoSaudeDependenteArray[i];
				if (jQuery.inArray(obj.sequencialPlanoSaudeDependente, arrSequencial) > -1) {
					jsonPlanoSaudeDependenteArray.splice(i, 1);
				}
			}

			$("#jsonPlanoSaudeDependente").val(JSON.stringify(jsonPlanoSaudeDependenteArray));
			fillTablePlanoSaudeDependente();
		} else
			smartAlert("Erro", "Selecione pelo menos 1 plano para excluir.", "error");
	}

	//############################################################################## LISTA PLANO SAUDE FIM ##########################################################################################################################

	//############################################################################## LISTA DE VALE TRANSPORTE INICIO #######################################################################################################################

	function addValeTransporte() {
		var item = $("#formValeTransporte").toObject({
			mode: 'combine',
			skipEmpty: false,
			nodeCallback: processDataValeTransporte
		});

		var valeTransporte = +$("#valeTransporte").val();


		if (valeTransporte === 0) {
			smartAlert("Erro", "Informe um Vale Transporte!", "error");
			$("#valeTransporte").focus();
			return;
		}
		var trajeto = +$("#trajetoVT").val();
		if (trajeto === 0) {
			smartAlert("Erro", "Informe o Trajeto!", "error");
			$("#trajetoVT").focus();
			return;
		}

		if (item["sequencialValeTransporte"] === '') {
			if (jsonValeTransporteArray.length === 0) {
				item["sequencialValeTransporte"] = 1;
			} else {
				item["sequencialValeTransporte"] = Math.max.apply(Math, jsonValeTransporteArray.map(function(o) {
					return o.sequencialValeTransporte;
				})) + 1;
			}
			item["valeTransporteId"] = 0;
		} else {
			item["sequencialValeTransporte"] = +item["sequencialValeTransporte"];
		}
		var index = -1;
		$.each(jsonValeTransporteArray, function(i, obj) {
			if (+$('#sequencialValeTransporte').val() === obj.sequencialValeTransporte) {
				index = i;
				return false;
			}
		});

		if (index >= 0)
			jsonValeTransporteArray.splice(index, 1, item);
		else
			jsonValeTransporteArray.push(item);

		$("#jsonValeTransporte").val(JSON.stringify(jsonValeTransporteArray));
		initializeDecimalBehaviour();
		fillTableValeTransporte();

	}

	function processDataValeTransporte(node) {
		var fieldId = node.getAttribute ? node.getAttribute('id') : '';
		var fieldName = node.getAttribute ? node.getAttribute('name') : '';

		if (fieldName !== '' && (fieldId === "descricaoTipoDesconto")) {
			return {
				name: fieldName,
				value: $("#tipoDesconto option:selected").text()
			};
		}


		if (fieldName !== '' && (fieldId === "descricaoVT")) {
			if (($("#valeTransporteModal option:selected").text()) === "") {
				return {
					name: fieldName,
					value: $("#valeTransporte option:selected").text()
				};
			}
		}


		if (fieldName !== '' && (fieldId === "descricaoTrajeto")) {
			return {
				name: fieldName,
				value: $("#trajetoVT option:selected").text(),

			};
		}

		if (fieldName !== '' && (fieldId === "valeTransporteUnitario")) {
			if (+$(`#${fieldId} option:selected`).val())
				return {
					name: 'valeTransporte',
					value: $(`#${fieldId} option:selected`).val()
				};
		}

		if (fieldName !== '' && (fieldId === "valeTransporteModal")) {
			if (+$(`#${fieldId} option:selected`).val())
				return {
					name: 'valeTransporte',
					value: $(`#${fieldId} option:selected`).val()
				};
		}

		if (fieldName !== '' && (fieldId === "descricaoTipoDesconto")) {
			return {
				name: fieldName,
				value: $("#tipoDesconto option:selected").text()
			};
		}
		if (fieldName !== '' && (fieldId === "descricaoTipoVale")) {
			return {
				name: fieldName,
				value: $("#tipoVale option:selected").text()
			};
		}



		return false;
	}

	function fillTableValeTransporte() {
		$("#tableValeTransporte tbody").empty();
		var valorTotalFuncionarioVT = 0;
		for (var i = 0; i < jsonValeTransporteArray.length; i++) {
			var row = $('<tr />');
			$("#tableValeTransporte tbody").append(row);
			row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonValeTransporteArray[i].sequencialValeTransporte + '"><i></i></label></td>'));
			row.append($('<td class="text-nowrap" onclick="carregaValeTransporte(' + jsonValeTransporteArray[i].sequencialValeTransporte + ');">' + jsonValeTransporteArray[i].descricaoTipoDesconto + '</td>'));
			row.append($('<td class="text-nowrap">' + jsonValeTransporteArray[i].descricaoTipoVale + '</td>'));
			row.append($('<td class="text-nowrap">' + jsonValeTransporteArray[i].descricaoVT + '</td>'));
			row.append($('<td class="text-nowrap">' + jsonValeTransporteArray[i].descricaoTrajeto + '</td>'));
			// row.append($('<td class="text-nowrap decimal-2-casas">' + jsonValeTransporteArray[i].valorPassagem + '</td>'));
			// row.append($('<td class="text-nowrap">' + jsonValeTransporteArray[i].valorPassagem + '</td>'));
			row.append($('<td class="text-right"> R$ ' + roundDecimal(floatToString(jsonValeTransporteArray[i].valorPassagem), 2) + '</td>'));
			row.append($('<td class="text-nowrap">' + jsonValeTransporteArray[i].observacaoVT + '</td>'));

			//Transforma em float para ser somado. 
			valorPassagem = parseFloat(jsonValeTransporteArray[i].valorPassagem.toString().replace(",", "."));
			//  valorTotalFuncionarioVT = parseFloat(valorPassagem.toString().replace(".", ","));
			//  valorTotalFuncionarioVT.replace(".", ",")
			valorTotalFuncionarioVT += valorPassagem;


			// var valorPassagem = jsonValeTransporteArray.reduce((total, {
			// 	valorPassagem
			// }) => total + stringToFloat(valorPassagem), 0).toString().replace(".", ",")
			// // }) => total + (valorPassagem), 0).toString().replace(".", ",")
			// $("#valorTotalFuncionarioVT").val(valorPassagem).trigger("change");
			// row.append($('<td class="hidden">' + jsonValeTransporteArray[i].valorPassagem + '</td>'));
		}
		valorTotalFuncionarioVT = roundDecimal(floatToString(valorTotalFuncionarioVT), 2);
		$("#valorTotalFuncionarioVT").val(valorTotalFuncionarioVT);
		initializeDecimalBehaviour();

	}

	function validaEmail() {
		var existe = false;
		var achou = false;
		var email = $('#email').val();
		var sequencial = +$('#sequencialEmail').val();
		var emailValido = false;
		var emailPrincipalMarcado = 0;

		if ($("#emailPrincipal").is(':checked') === true) {
			emailPrincipalMarcado = 1;
		}
		if (email === '') {
			smartAlert("Erro", "Informe um email.", "error");
			return false;
		}
		if (validateEmail(email)) {
			emailValido = true;
		}
		if (emailValido === false) {
			smartAlert("Erro", "Email inválido.", "error");
			return false;
		}
		for (i = jsonEmailArray.length - 1; i >= 0; i--) {
			if (emailPrincipalMarcado === 1) {
				if ((jsonEmailArray[i].emailPrincipal === 1) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
					achou = true;
					break;
				}
			}
			if ((jsonEmailArray[i].email === email) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
				existe = true;
				break;
			}
		}
		if (existe === true) {
			smartAlert("Erro", "Email já cadastrado.", "error");
			return false;
		}
		if ((achou === true) && (emailPrincipalMarcado === 1)) {
			smartAlert("Erro", "Já existe um email principal na lista.", "error");
			return false;
		}
		return true;
	}

	function clearValeTransporte() {
		// $("#tipoDesconto").val('');
		$("#valeTransporte").val('');
		$('#trajetoVT').val("");
		$('#valorPassagem').val("");
		$('#valorTotalVT').val('');
		$('#observacaoVT').val('');
		$('#sequencialValeTransporte').val('');

	}

	function carregaValeTransporte(sequencialValeTransporte) {
		var arr = jQuery.grep(jsonValeTransporteArray, function(item, i) {
			return (item.sequencialValeTransporte === sequencialValeTransporte);
		});

		clearValeTransporte();

		if (arr.length > 0) {
			var item = arr[0];
			$("#tipoVale").val(item.tipoVale);
			$("#tipoDesconto").val(item.tipoDesconto);
			populaComboVT(item.tipoVale,
				function(data) {
					var atributoId = '#' + 'valeTransporte';
					if (data.indexOf('failed') > -1) {
						return;
					} else {
						data = data.replace(/failed/g, '');
						var piece = data.split("#");

						var mensagem = piece[0];
						var qtdRegs = piece[1];
						var arrayRegistros = piece[2].split("|");
						var registro = "";

						$(atributoId).html('');
						$(atributoId).append('<option></option>');

						for (var i = 0; i < qtdRegs; i++) {
							registro = arrayRegistros[i].split("^");
							$(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
						}
						$("#valeTransporte").val(item.valeTransporte);
					}
				}
			);

			$("#trajetoVT").val(item.trajetoVT);
			$("#valorPassagem").val(roundDecimal(floatToString(item.valorPassagem), 2));
			$("#valorTotalVT").val(roundDecimal(floatToString(item.valorTotalVT), 2));
			$("#observacaoVT").val(item.observacaoVT);
			$("#tipoVale").val(item.observacaoVT);
			$("#sequencialValeTransporte").val(item.sequencialValeTransporte);
			$("#tipoVale").val(item.tipoVale);
			$("#valeTransporte").val(item.valeTransporte);
			$("#valorTotalFuncionarioVT").val(item.valorTotalFuncionario);
			$("#dataInativacao").val(item.dataInativacao);

			var codigoValeTransporte = (item.valeTransporte);
			var codigoTipoTransporte = +$("#tipoVale").val();
			if (codigoTipoTransporte == 0) {
				if (codigoValeTransporte > 0) {
					$("#valorPassagem").val(0);
					initializeDecimalBehaviour();
					recuperaValeTransporteModal(codigoValeTransporte,
						function(data) {
							if (data.indexOf('failed') > -1) {} else {
								data = data.replace(/failed/g, '');
								var piece = data.split("#");
								var out = piece[1];
								piece = out.split("^");
								var valorPassagem = floatToString(+piece[1]);
								$("#valorPassagem").val(valorPassagem);
								initializeDecimalBehaviour();
							}
						}
					);
				}
			} else {
				if (codigoValeTransporte > 0) {
					$("#valorPassagem").val(0);
					initializeDecimalBehaviour();
					recuperaValeTransporteUnitario(codigoValeTransporte,
						function(data) {
							if (data.indexOf('failed') > -1) {} else {
								data = data.replace(/failed/g, '');
								var piece = data.split("#");
								var out = piece[1];
								piece = out.split("^");
								var valorPassagem = floatToString(+piece[1]);
								$("#valorPassagem").val(valorPassagem);
								initializeDecimalBehaviour();
							}
						}
					);
				}
			}

			initializeDecimalBehaviour();

		}

	}

	function excluirValeTransporte() {
		var arrSequencial = [];
		$('#tableValeTransporte input[type=checkbox]:checked').each(function() {
			arrSequencial.push(parseInt($(this).val()));
		});

		if (arrSequencial.length > 0) {
			for (i = jsonValeTransporteArray.length - 1; i >= 0; i--) {
				var obj = jsonValeTransporteArray[i];
				if (jQuery.inArray(obj.sequencialValeTransporte, arrSequencial) > -1) {
					jsonValeTransporteArray.splice(i, 1);
				}
			}
			$("#jsonValeTransporte").val(JSON.stringify(jsonValeTransporteArray));
			fillTableValeTransporte();
		} else
			smartAlert("Erro", "Selecione pelo menos 1 email para excluir.", "error");
	}

	//############################################################################## LISTA VALE TRANSPORTE FIM ##########################################################################################################################


	//############################################################################## LISTA DE BENEFICIO DIRETO INICIO #######################################################################################################################

	function addBeneficioIndireto() {
		var item = $("#formBeneficioIndireto").toObject({
			mode: 'combine',
			skipEmpty: false,
			nodeCallback: processDataBenficioIndireto
		});

		if (item["sequencialBeneficioIndireto"] === '') {
			if (jsonBeneficioIndiretoArray.length === 0) {
				item["sequencialBeneficioIndireto"] = 1;
			} else {
				item["sequencialBeneficioIndireto"] = Math.max.apply(Math, jsonBeneficioIndiretoArray.map(function(o) {
					return o.sequencialBeneficioIndireto;
				})) + 1;
			}
			item["beneficioIndiretoId"] = 0;
		} else {
			item["sequencialBeneficioIndireto"] = +item["sequencialBeneficioIndireto"];
		}
		var index = -1;
		$.each(jsonBeneficioIndiretoArray, function(i, obj) {
			if (+$('#sequencialBeneficioIndireto').val() === obj.sequencialBeneficioIndireto) {
				index = i;
				return false;
			}
		});

		if (index >= 0)
			jsonBeneficioIndiretoArray.splice(index, 1, item);
		else
			jsonBeneficioIndiretoArray.push(item);

		$("#jsonBeneficioIndireto").val(JSON.stringify(jsonBeneficioIndiretoArray));
		initializeDecimalBehaviour();
		fillTableBeneficioIndireto();
		clearFormBeneficioIndireto();
	}

	function processDataBenficioIndireto(node) {
		var fieldId = node.getAttribute ? node.getAttribute('id') : '';
		var fieldName = node.getAttribute ? node.getAttribute('name') : '';
		var valorAbater = $("#valorAbater").val();
		var valorFinalBeneficio = $("#valorFinalBeneficio").val();
		var valorAcrescimo = $("#valorAcrescimo").val();

		if (fieldName !== '' && (fieldId === "descricaoBeneficio")) {
			return {

				name: fieldName,
				value: $("#beneficioIndireto option:selected").val()
			};
		}

		if (valorAbater == "") {
			$("#valorAbater").val(0);
		}
		if (valorFinalBeneficio == "") {
			$("#valorFinalBeneficio").val(0);
		}
		if (valorAcrescimo == "") {
			$("#valorAcrescimo").val(0);
		}
		initializeDecimalBehaviour();
	}

	function fillTableBeneficioIndireto() {
		$("#tableBeneficioIndireto tbody").empty();
		for (var i = 0; i < jsonBeneficioIndiretoArray.length; i++) {
			var row = $('<tr/>');
			var descricaoBeneficio = $("#beneficioIndireto option[value = '" + jsonBeneficioIndiretoArray[i].descricaoBeneficio + "']").text();
			$("#tableBeneficioIndireto tbody").append(row);
			row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonBeneficioIndiretoArray[i].sequencialBeneficioIndireto + '"><i></i></label></td>'));
			row.append($('<td class="text-nowrap" onclick="carregaBeneficioDireto(' + jsonBeneficioIndiretoArray[i].sequencialBeneficioIndireto + ');">' + descricaoBeneficio + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + jsonBeneficioIndiretoArray[i].valorBeneficioFuncionario + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + jsonBeneficioIndiretoArray[i].valorAcrescimo + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + jsonBeneficioIndiretoArray[i].valorAbater + '</td>'));
			row.append($('<td class="text-nowrap decimal-2-casas">' + jsonBeneficioIndiretoArray[i].valorFinalBeneficio + '</td>'));
		}

		var desconto = jsonBeneficioIndiretoArray.reduce((total, {
			valorAcrescimo,
			valorAbater
		}) => total + (stringToFloat(valorAcrescimo) + stringToFloat(valorAbater)), 0);
		if (desconto) {
			var valorBolsaBeneficioSindicato = stringToFloat($("#valorBolsaBeneficioSindicato").val());
			var saldo = valorBolsaBeneficioSindicato - desconto;
			saldo = saldo.toString().replace(".", ",");
			$("#saldoDisponivel").val(saldo).trigger("change");
			debugger;
			var totalValorAcrescimoBeneficioIndireto = jsonBeneficioIndiretoArray.reduce((total, {
				valorAcrescimo
			}) => total + (stringToFloat(valorAcrescimo)), 0);

			var totalValorAbaterBeneficioIndireto = jsonBeneficioIndiretoArray.reduce((total, {
				valorAbater
			}) => total + (stringToFloat(valorAbater)), 0);



		} else {
			var valorBolsaBeneficioSindicato = $("#valorBolsaBeneficioSindicato").val();
			$("#saldoDisponivel").val(valorBolsaBeneficioSindicato).trigger("change");
		}


		totalValorAcrescimoBeneficioIndireto = roundDecimal(floatToString(totalValorAcrescimoBeneficioIndireto || 0), 2);
		$("#totalValorAcrescimoBeneficioIndireto").val(totalValorAcrescimoBeneficioIndireto);
		totalValorAbaterBeneficioIndireto = roundDecimal(floatToString(totalValorAbaterBeneficioIndireto || 0), 2);
		$("#totalValorAbaterBeneficioIndireto").val(totalValorAbaterBeneficioIndireto);

		initializeDecimalBehaviour();
	}

	function validaEmail() {
		var existe = false;
		var achou = false;
		var email = $('#email').val();
		var sequencial = +$('#sequencialEmail').val();
		var emailValido = false;
		var emailPrincipalMarcado = 0;

		if ($("#emailPrincipal").is(':checked') === true) {
			emailPrincipalMarcado = 1;
		}
		if (email === '') {
			smartAlert("Erro", "Informe um email.", "error");
			return false;
		}
		if (validateEmail(email)) {
			emailValido = true;
		}
		if (emailValido === false) {
			smartAlert("Erro", "Email inválido.", "error");
			return false;
		}
		for (i = jsonEmailArray.length - 1; i >= 0; i--) {
			if (emailPrincipalMarcado === 1) {
				if ((jsonEmailArray[i].emailPrincipal === 1) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
					achou = true;
					break;
				}
			}
			if ((jsonEmailArray[i].email === email) && (jsonEmailArray[i].sequencialEmail !== sequencial)) {
				existe = true;
				break;
			}
		}
		if (existe === true) {
			smartAlert("Erro", "Email já cadastrado.", "error");
			return false;
		}
		if ((achou === true) && (emailPrincipalMarcado === 1)) {
			smartAlert("Erro", "Já existe um email principal na lista.", "error");
			return false;
		}
		return true;
	}

	function clearBeneficioDireto() {
		$('#beneficioIndireto').val('');
		$('#valorBeneficioFuncionario').val('');
		$('#valorAcrescimo').val('');
		$('#valorAbater').val('');
		$('#valorFinalBeneficio').val('')
		$('#sequencialBeneficioIndireto').val('');

	}

	function carregaBeneficioDireto(sequencialBeneficioIndireto) {
		var arr = jQuery.grep(jsonBeneficioIndiretoArray, function(item, i) {
			return (item.sequencialBeneficioIndireto === sequencialBeneficioIndireto);
		});

		clearBeneficioDireto();

		if (arr.length > 0) {
			var item = arr[0];
			$('#beneficioIndireto').val(item.descricaoBeneficio);
			var beneficioIndireto = $('#beneficioIndireto').val();
			if (beneficioIndireto == 1 || beneficioIndireto == 2) {
				desabilitaCampoAbater();
			} else {
				desbilitaCampoAcrescimo();
			}
			$('#valorBeneficioFuncionario').val(item.valorBeneficioFuncionario);
			$('#valorAcrescimo').val(item.valorAcrescimo);
			$('#valorAbater').val(item.valorAbater);
			$('#valorFinalBeneficio').val(item.valorFinalBeneficio);
			$('#sequencialBeneficioIndireto').val(item.sequencialBeneficioIndireto);
			initializeDecimalBehaviour();

		}
	}

	function excluirBeneficioDireto() {
		var arrSequencial = [];
		$('#tableBeneficioIndireto input[type=checkbox]:checked').each(function() {
			arrSequencial.push(parseInt($(this).val()));
		});

		if (arrSequencial.length > 0) {
			for (i = jsonBeneficioIndiretoArray.length - 1; i >= 0; i--) {
				var obj = jsonBeneficioIndiretoArray[i];
				if (jQuery.inArray(obj.sequencialBeneficioIndireto, arrSequencial) > -1) {
					jsonBeneficioIndiretoArray.splice(i, 1);
				}
			}
			$("#jsonBeneficioIndireto").val(JSON.stringify(jsonBeneficioIndiretoArray));
			fillTableBeneficioIndireto();
		} else
			smartAlert("Erro", "Selecione pelo menos Beneficio para excluir.", "error");
	}

	//############################################################################## LISTA VALE TRANSPORTE FIM ##########################################################################################################################

	function validaValeTransporteUnitario() {
		$("#valeTransporteUnitario").on("change", function() {
			var codigoValeTransporteUnitario = +$("#valeTransporteUnitario").val();
			if (codigoValeTransporteUnitario > 0) {
				$("#valorPassagem").val(0);
				$("#valeTransporteModal").val("");
				initializeDecimalBehaviour();
				recuperaValeTransporteUnitario(codigoValeTransporteUnitario,
					function(data) {
						if (data.indexOf('failed') > -1) {} else {
							data = data.replace(/failed/g, '');
							var piece = data.split("#");
							var out = piece[1];
							piece = out.split("^");
							var valorPassagem = floatToString(+piece[1]);
							$("#valorPassagem").val(valorPassagem);
							initializeDecimalBehaviour();
						}
					}
				);
			}
		});
	}

	function validaValeTransporte() {

		var codigoValeTransporte = +$("#valeTransporte").val();
		var codigoTipoTransporte = +$("#tipoVale").val();
		if (codigoTipoTransporte == 0) {
			if (codigoValeTransporte > 0) {
				$("#valorPassagem").val(0);
				initializeDecimalBehaviour();
				recuperaValeTransporteModal(codigoValeTransporte,
					function(data) {
						if (data.indexOf('failed') > -1) {} else {
							data = data.replace(/failed/g, '');
							var piece = data.split("#");
							var out = piece[1];
							piece = out.split("^");
							var valorPassagem = floatToString(+piece[1]);
							$("#valorPassagem").val(valorPassagem);
							initializeDecimalBehaviour();
						}
					}
				);
			}
		} else {
			if (codigoValeTransporte > 0) {
				$("#valorPassagem").val(0);
				initializeDecimalBehaviour();
				recuperaValeTransporteUnitario(codigoValeTransporte,
					function(data) {
						if (data.indexOf('failed') > -1) {} else {
							data = data.replace(/failed/g, '');
							var piece = data.split("#");
							var out = piece[1];
							piece = out.split("^");
							var valorPassagem = floatToString(+piece[1]);
							$("#valorPassagem").val(valorPassagem);
							initializeDecimalBehaviour();
						}
					}
				);
			}
		}

	}

	function calculaTrajetoValeTransporte() {

		var trajetoVT = +$("#trajetoVT").val();
		var valorPassagem = $("#valorPassagem").val();
		var valorTotalPassagem = 0;

		if (valorPassagem === "") {
			valorPassagem = 0;
		} else {
			valorPassagem = parseFloat(valorPassagem.replace('.', '').replace(',', '.'))
		}
		if (+$("#trajetoVT").val() === 3) {
			valorTotalPassagem = valorPassagem * 2;
			$("#valorTotalVT").val(floatToString(valorTotalPassagem, 2));
			initializeDecimalBehaviour();
		} else {
			valorTotalPassagem = valorPassagem;
			$("#valorTotalVT").val(floatToString(valorTotalPassagem, 2));
			initializeDecimalBehaviour();
		}

	}

	function calculaIdadeFuncionario() {
		//######## O CHANGE É FEITO NO INPUT DE FUNCIONÁRIO A PARTIR DAÍ A COMBO DE IDADE É PREENCHIDA ########//
		var funcionario = +$("#funcionario").val();
		idadeFuncionario(funcionario,
			function(data) {
				if (data.indexOf('failed') > -1) {} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");
					var out = piece[1];
					piece = out.split("^");
					var idade = out;
					$("#idadeTitular").val(idade);

				}
			}
		);

	}

	function calculaIdadeFuncionarioDependente() {
		//######## O CHANGE É FEITO NO INPUT DE FUNCIONÁRIO A PARTIR DAÍ A COMBO DE IDADE É PREENCHIDA ########//
		var nomeDependente = +$("#nomeDependente").val();
		idadeFuncionarioDependente(nomeDependente,
			function(data) {
				if (data.indexOf('failed') > -1) {} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");
					var out = piece[1];
					piece = out.split("^");
					var idade = out;
					$("#idadeDependente").val(idade);

				}
			}
		);

	}


	function preencheProdutoCobranca() {
		var produto = +$("#produtoTitular").val();
		var idade = +$("#idadeTitular").val();
		valorProdutoPlanoSaude(produto, idade,
			function(data) {
				if (data.indexOf('failed') > -1) {
					smartAlert("Atenção", "Sua Idade não está contemplada neste Produto", "error")
					$("#produtoTitular").focus();
				} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");
					var out = piece[1];
					//piece = out.split("^");
					var valor = out;
					$("#valorProdutoTitular").val(valor.toString().replace('.', ','));
					$("#valorEmpresaTitular").val('');
					$("#valorFuncionarioTitular").val('');
					calculaValorFuncionarioTitularPlanoSaude();
					calculaValorEmpresa();
					initializeDecimalBehaviour()

				}
			}
		);

	}

	function preencheProdutoCobrancaDependente() {
		var produto = +$("#produtoDependente").val();
		var idade = +$("#idadeDependente").val();
		valorProdutoPlanoSaude(produto, idade,
			function(data) {
				if (data.indexOf('failed') > -1) {
					smartAlert("Atenção", "A idade do Dependente não está contemplada neste Produto", "error");
					$("#valorProdutoDependente").val('');
					$("#produtoDependente").focus();
				} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");
					var out = piece[1];
					piece = out.split("^");
					var cobranca = out;
					$("#valorProdutoDependente").val(cobranca.toString().replace('.', ','));
					calculaValorFuncionarioDependentePlanoSaude();
					calculaValorEmpresaDependente();
					initializeDecimalBehaviour()

				}
			}
		);

	}

	function populaComboProduto() {
		var id = +$("#convenioTitular").val();
		if (id > 0) {
			populaComboProdutoPlanoSaude(id,
				function(data) {
					var atributoId = '#' + 'produtoTitular';
					if (data.indexOf('failed') > -1) {
						smartAlert("Atenção", "Não existe Produto cadastrado para esse convênio", "error");

						$("#produtoTitular").empty();
						return;
					} else {
						data = data.replace(/failed/g, '');
						var piece = data.split("#");
						var mensagem = piece[0];
						var qtdRegs = piece[1];
						var arrayRegistros = piece[2].split("|");
						var registro = "";

						$(atributoId).html('');
						$(atributoId).append('<option></option>');

						for (var i = 0; i < qtdRegs; i++) {
							registro = arrayRegistros[i].split("^");
							$(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
						}
					}
				}
			);
		}
	}

	function populaComboProdutoDependente() {
		var id = +$("#convenioDependente").val();
		populaComboProdutoPlanoSaude(id,
			function(data) {
				var atributoId = '#' + 'produtoDependente';
				if (data.indexOf('failed') > -1) {
					smartAlert("Atenção", "Não existe Produto cadastrado para esse convênio", "error");
					$("#produtoDependente").empty();
					return;
				} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");

					var mensagem = piece[0];
					var qtdRegs = piece[1];
					var arrayRegistros = piece[2].split("|");
					var registro = "";

					$(atributoId).html('');
					$(atributoId).append('<option></option>');

					for (var i = 0; i < qtdRegs; i++) {
						registro = arrayRegistros[i].split("^");
						$(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
					}
				}
			}
		);
	}

	function populaComboCobranca() {
		var id = +$("#produtoTitular").val();
		populaCobrancaPlanoSaude(id,
			function(data) {
				var atributoId = '#' + 'cobrancaTitular';
				if (data.indexOf('failed') > -1) {
					return;
				} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");

					var mensagem = piece[0];
					var qtdRegs = piece[1];
					var arrayRegistros = piece[2];
					var registro = "";

					$("#cobrancaTitular").val(arrayRegistros);

				}
			}
		);
	}

	function populaComboCobrancaDependente() {
		var id = +$("#produtoDependente").val();
		populaCobrancaPlanoSaude(id,
			function(data) {
				var atributoId = '#' + 'cobrancaDependente';
				if (data.indexOf('failed') > -1) {
					return;
				} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");

					var mensagem = piece[0];
					var qtdRegs = piece[1];
					var arrayRegistros = piece[2];
					var registro = "";

					$("#cobrancaDependente").val(arrayRegistros);

				}
			}
		);
	}

	function calculaValorFuncionarioTitularPlanoSaude() {
		var valorDescontoSindicatoTitular = $("#valorDescontoSindicatoTitular").val();
		var descontoSindicatoTitular = $("#descontoSindicatoTitular").val();

		var valorDescontoProjetoTitular = $("#valorDescontoProjetoTitular").val();
		var descontoProjetoTitular = $("#descontoProjetoTitular").val();

		var valorDescontoProdutoTitular = $("#valorDescontoPlanoSaudeTitular").val();
		var descontoProdutoTitular = $("#descontoPlanoSaudeTitular").val();

		var valorProdutoTitular = $("#valorProdutoTitular").val();
		valorProdutoTitular = parseFloat(valorProdutoTitular.replace(',', '.'));
		var valorFuncionario = 0;

		//#################################### CALCULO COM BASE NO SINDICATO #####################################################################
		if (descontoSindicatoTitular !== '') {
			descontoSindicatoTitular = parseFloat(descontoSindicatoTitular.replace(',', '.'));
			descontoSindicatoTitular = (descontoSindicatoTitular) / 100;
			valorFuncionarioDesconto = descontoSindicatoTitular * valorProdutoTitular;
			valorFuncionario = valorProdutoTitular - valorFuncionarioDesconto;
			$("#valorFuncionarioTitular").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}

		if (valorDescontoSindicatoTitular !== '') {
			valorDescontoSindicatoTitular = parseFloat(valorDescontoSindicatoTitular.replace(',', '.'));
			valorFuncionario = 0;
			valorFuncionario = valorProdutoTitular - valorDescontoSindicatoTitular;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorFuncionarioTitular").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		//####################################### FIM CALCULO SINDICATO  #############################################################################
		//####################################### CALCULO COM BASE NO PROJETO ###########################################################################

		if (descontoProjetoTitular !== '') {
			descontoProjetoTitular = parseFloat(descontoProjetoTitular.replace(',', '.'));
			valorFuncionario = 0;
			descontoProjetoTitular = descontoProjetoTitular / 100;
			valorFuncionarioDesconto = descontoProjetoTitular * valorProdutoTitular;
			valorFuncionario = valorProdutoTitular - valorFuncionarioDesconto;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorFuncionarioTitular").val(valorFuncionario.toString().replace('.', ','));

			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		if (valorDescontoProjetoTitular !== '') {
			valorDescontoProjetoTitular = parseFloat(valorDescontoProjetoTitular.replace(',', '.'));
			valorFuncionario = 0;
			valorFuncionario = valorProdutoTitular - valorDescontoProjetoTitular;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorFuncionarioTitular").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		//##################################### FIM CALCULO PROJETO ##############################################################################
		//##################################### CALCULO COM BASE EM PRODUTO ##############################################################################

		if (descontoProdutoTitular !== '') {
			descontoProdutoTitular = parseFloat(descontoProdutoTitular.replace(',', '.'));
			valorFuncionario = 0;
			descontoProdutoTitular = descontoProdutoTitular / 100;
			valorFuncionarioDesconto = descontoProdutoTitular * valorProdutoTitular;
			valorFuncionario = valorProdutoTitular - valorFuncionarioDesconto;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorFuncionarioTitular").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}

		if (valorDescontoProdutoTitular !== '') {
			valorDescontoProdutoTitular = parseFloat(valorDescontoProdutoTitular.replace(',', '.'));
			valorFuncionario = 0;
			valorFuncionario = valorProdutoTitular - valorDescontoProdutoTitular;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorFuncionarioTitular").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		//##################################### FIM CALCULO PRODUTO ##############################################################################

	}


	function calculaValorFuncionarioDependentePlanoSaude() {
		//TODO ajustar os calculos principalmente os de porcentagem
		var descontoSindicatoDependente = $("#descontoSindicatoDependente").val();
		var descontoProjetoDependente = $("#descontoProjetoDependente").val();
		var valorDescontoSindicatoDependente = $("#valorDescontoSindicatoDependente").val();
		var valorDescontoProjetoDependente = $("#valorDescontoProjetoDependente").val();
		var valorProdutoDependente = $("#valorProdutoDependente").val();
		var valorDescontoProdutoDependente = $("#valorDescontoPlanoSaudeDependente").val();
		var descontoProdutoDependente = $("#descontoPlanoSaudeDependente").val();

		var valorProdutoDependente = parseFloat(valorProdutoDependente.replace(',', '.'));
		var valorFuncionario = 0;

		if (descontoSindicatoDependente !== '') {
			descontoSindicatoDependente = parseFloat(descontoSindicatoDependente.replace(',', '.'));
			descontoSindicatoDependente = (descontoSindicatoDependente) / 100;
			valorFuncionarioDesconto = descontoSindicatoDependente * valorProdutoDependente;
			valorFuncionario = valorProdutoDependente - valorFuncionarioDesconto;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorDependente").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		if (descontoProjetoDependente !== '') {
			descontoProjetoDependente = parseFloat(descontoProjetoDependente.replace(',', '.'));
			valorFuncionario = 0;
			descontoProjetoDependente = descontoProjetoDependente / 100;
			valorFuncionarioDesconto = descontoProjetoDependente * valorProdutoDependente;
			valorFuncionario = valorProdutoDependente - valorFuncionarioDesconto;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorDependente").val(valorFuncionario.toString().replace('.', ','));

			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		if (valorDescontoSindicatoDependente !== '') {
			valorDescontoSindicatoDependente = parseFloat(valorDescontoSindicatoDependente.replace(',', '.'));
			valorFuncionario = 0;
			valorFuncionario = valorProdutoDependente - valorDescontoSindicatoDependente;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorDependente").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		if (valorDescontoProjetoDependente !== '') {
			valorDescontoProjetoDependente = parseFloat(valorDescontoProjetoDependente.replace(',', '.'));
			valorFuncionario = 0;
			valorFuncionario = valorProdutoDependente - valorDescontoProjetoDependente;
			if (valorFuncionario < 0) {
				valorFuncionario = 0;
			}
			$("#valorDependente").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}

		//##################################### CALCULO COM BASE EM PRODUTO ##############################################################################

		if (descontoProdutoDependente !== '') {
			descontoProdutoDependente = parseFloat(descontoProdutoDependente.replace(',', '.'));
			valorFuncionario = 0;
			descontoProdutoDependente = descontoProdutoDependente / 100;
			valorFuncionarioDesconto = descontoProdutoDependente * valorProdutoDependente;
			valorFuncionario = valorProdutoDependente - valorFuncionarioDesconto;
			$("#valorDependente").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}

		if (valorDescontoProdutoDependente !== '') {
			valorDescontoProdutoDependente = parseFloat(valorDescontoProdutoDependente.replace(',', '.'));
			valorFuncionario = 0;
			valorFuncionario = valorProdutoDependente - valorDescontoProdutoDependente;
			$("#valorDependente").val(valorFuncionario.toString().replace('.', ','));
			initializeDecimalBehaviour();
			return valorFuncionario;
		}
		//##################################### FIM CALCULO PRODUTO ##############################################################################

	}

	function calculaValorEmpresa() {
		var valorEmpresa = 0;
		var valorProdutoTitular = $("#valorProdutoTitular").val();
		valorProdutoTitular = parseFloat(valorProdutoTitular.replace(',', '.'));
		var valorFuncionarioTitular = calculaValorFuncionarioTitularPlanoSaude();

		valorEmpresa = valorProdutoTitular - calculaValorFuncionarioTitularPlanoSaude();
		$("#valorEmpresaTitular").val(valorEmpresa.toString().replace('.', ','));
		initializeDecimalBehaviour();
	}

	function calculaValorEmpresaDependente() {
		var valorEmpresa = 0;
		var valorFuncionarioTitular = 0;
		var valorProduto = $("#valorProdutoDependente").val();
		valorProduto = parseFloat(valorProduto.replace(',', '.'));
		var valorFuncionarioTitular = calculaValorFuncionarioDependentePlanoSaude();
		valorEmpresa = parseFloat(valorProduto) - parseFloat(valorFuncionarioTitular);
		$("#valorEmpresaDependente").val(valorEmpresa.toString().replace('.', ','));
		initializeDecimalBehaviour();
	}

	function calculaTotalGeral() {
		var valorTotalGeral = 0;
		var valorTotalTitular = $("#valorTotalTitular").val();
		if (valorTotalTitular !== "") {
			valorTotalTitular = parseFloat(valorTotalTitular.replace(',', '.'));
		} else {
			valorTotalTitular = 0;
		}
		var valorTotalDependente = $("#valorTotalDependente").val();
		if (valorTotalDependente == "") {
			valorTotalDependente = 0;
		} else {
			valorTotalDependente = parseFloat(valorTotalDependente.replace(',', '.'));
		}
		valorTotalGeral = valorTotalTitular + valorTotalDependente;


		$("#valorTotalGeral").val(valorTotalGeral.toString().replace('.', ','));
		initializeDecimalBehaviour();

	}


	function desabilitaCampos() {
		$("#funcionarioTitular").prop('disabled', true);
		$("#funcionarioTitular").addClass('readonly');

		$("#cobrancaTitular").prop('disabled', true);
		$("#cobrancaTitular").addClass('readonly');

		$("#cobrancaDependente").prop('disabled', true);
		$("#cobrancaDependente").addClass('readonly');
	}

	function habilitaCampos() {

		$("#funcionarioTitular").prop('disabled', false);
		$("#funcionarioTitular").addClass('readonly');

		$("#cobrancaTitular").prop('disabled', false);
		$("#cobrancaTitular").addClass('readonly');

		$("#cobrancaDependente").prop('disabled', false);
		$("#cobrancaDependente").addClass('readonly');
	}

	function populaComboNomeDependente() {
		var funcionario = +$("#funcionario").val();
		if (funcionario > 0) {
			populaComboNomeDependentePlanoSaude(funcionario,
				function(data) {
					var atributoId = '#' + 'nomeDependente';

					if (data.indexOf('failed') > -1) {
						return;
					} else {
						data = data.replace(/failed/g, '');
						var piece = data.split("#");

						$("#nomeDependente").prop('disabled', false);
						$("#nomeDependente").removeClass('readonly');

						var mensagem = piece[0];
						var qtdRegs = piece[1];
						var arrayRegistros = piece[2].split("|");
						var registro = "";

						$(atributoId).html('');
						$(atributoId).append('<option></option>');

						for (var i = 0; i < qtdRegs; i++) {
							registro = arrayRegistros[i].split("^");
							$(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
						}
					}
				}
			);
		}
	}

	function valorDescontoValeRefeicaoSindicato(sindicato) {
		if (sindicato > 0) {
			valorDescontoSindicatoValeRefeicao(sindicato,
				function(data) {
					if (data.indexOf('failed') > -1) {

					} else {
						data = data.replace(/failed/g, '');

						var piece = data.split("#");
						var out = piece[1];
						var outValorDescontoFolhaVRSindicato = piece[2];
						piece = out.split("^");
						var percentualDescontoSindicato = out;
						var valorDescontoValeRefeicaoSindicato = outValorDescontoFolhaVRSindicato;

						if (valorDescontoValeRefeicaoSindicato !== 0) {
							$("#valorDescontoProjetoTitular").val(0);
							$("#valorDescontoSindicatoVR").val(valorDescontoValeRefeicaoSindicato.replace('.', ','));
							initializeDecimalBehaviour();
							return;
						}
						if (percentualDescontoSindicato !== 0) {
							$("#descontoProjetoTitular").val(0);
							$("#percentualDescontoSindicatoVR").val(percentualDescontoSindicato.replace('.', ','));
							initializeDecimalBehaviour();
							return;
						}


					}
				}
			);
		}
	}

	function valorDescontoPlanoSaudeDependente(produto) {
		if (produto > 0) {
			valorDescontoProdutoPlanoSaude(produto,
				function(data) {
					if (data.indexOf('failed') > -1) {
						var valorProduto = $("#valorProdutoTitular").val();
						if (valorProduto == "") {
							valorProduto = 0;
						}
						$("#valorFuncionarioTitular").val(valorProduto);
						return;
					} else {
						data = data.replace(/failed/g, '');

						var piece = data.split("#");
						var outValorDescontoPlanoSaude = piece[1];
						var out = piece[2];
						piece = out.split("^");
						var percentualDescontoProjetoPlanoSaude = out;
						var valorDescontoPlanoSaudeProduto = outValorDescontoPlanoSaude;

						if (valorDescontoPlanoSaudeProduto != 0) {
							limpaCamposPlanoSaudeDependente(1);
							$("#valorDescontoPlanoSaudeDependente").val(valorDescontoPlanoSaudeProduto.replace('.', ','));
							// initializeDecimalBehaviour();
							calculaValorFuncionarioDependentePlanoSaude();
							calculaValorEmpresaDependente();
							return;
						}
						if (percentualDescontoProjetoPlanoSaude != 0) {
							limpaCamposPlanoSaudeDependente(0);
							$("#descontoPlanoSaudeDependente").val(percentualDescontoProjetoPlanoSaude.replace('.', ','));
							// initializeDecimalBehaviour();
							calculaValorFuncionarioDependentePlanoSaude();
							calculaValorEmpresaDependente();
							return;
						}


					}
				}
			);
		}
	}

	function valorDescontoPlanoSaudeProduto(produto) {
		if (produto > 0) {
			valorDescontoProdutoPlanoSaude(produto,
				function(data) {
					if (data.indexOf('failed') > -1) {
						var valorProduto = $("#valorProdutoTitular").val();
						if (valorProduto == "") {
							valorProduto = 0;
						}
						$("#valorFuncionarioTitular").val(valorProduto);
						return;
					} else {
						data = data.replace(/failed/g, '');

						var piece = data.split("#");
						var outValorDescontoPlanoSaude = piece[1];
						var out = piece[2];
						piece = out.split("^");
						var percentualDescontoProjetoPlanoSaude = out;
						var valorDescontoPlanoSaudeProduto = outValorDescontoPlanoSaude;
						initializeDecimalBehaviour()

						if (valorDescontoPlanoSaudeProduto != 0) {
							limpaCamposPlanoSaude(1);
							$("#valorDescontoPlanoSaudeTitular").val(valorDescontoPlanoSaudeProduto.replace('.', ','));
							// initializeDecimalBehaviour();
							calculaValorFuncionarioTitularPlanoSaude();
							calculaValorEmpresa();
							return;
						}
						if (percentualDescontoProjetoPlanoSaude != 0) {
							limpaCamposPlanoSaude(0)
							$("#descontoPlanoSaudeTitular").val(percentualDescontoProjetoPlanoSaude.replace('.', ','));
							// initializeDecimalBehaviour();
							calculaValorFuncionarioTitularPlanoSaude();
							calculaValorEmpresa();
							return;
						}


					}
				}
			);
		}
	}

	function valorDescontoPlanoSaudeProjeto(projeto) {
		if (projeto > 0) {
			valorDescontoProjetoPlanoSaude(projeto,
				function(data) {
					if (data.indexOf('failed') > -1) {
						var valorProduto = $("#valorProdutoTitular").val();
						if (valorProduto == "") {
							valorProduto = 0;
						}
						$("#valorFuncionarioTitular").val(valorProduto);
						return;
					} else {
						data = data.replace(/failed/g, '');

						var piece = data.split("#");
						var out = piece[2];
						var outValorDescontoPlanoSaude = piece[1];
						piece = out.split("^");
						var percentualDescontoProjetoPlanoSaude = out;
						var valorDescontoPlanoSaudeProjeto = outValorDescontoPlanoSaude;

						if (valorDescontoPlanoSaudeProjeto != 0) {
							limpaCamposProjeto(1);
							$("#valorDescontoProjetoTitular").val(valorDescontoPlanoSaudeProjeto.replace('.', ','));
							// initializeDecimalBehaviour();
							calculaValorFuncionarioTitularPlanoSaude();
							calculaValorEmpresa();
							return;
						}
						if (percentualDescontoProjetoPlanoSaude != 0) {
							limpaCamposProjeto(0);
							$("#descontoProjetoTitular").val(percentualDescontoProjetoPlanoSaude.replace('.', ','));
							// initializeDecimalBehaviour();
							calculaValorFuncionarioTitularPlanoSaude();
							calculaValorEmpresa();
							return;
						}


					}
				}
			);
		}
	}

	function valorDescontoPlanoSaudeSindicato(sindicato) {
		if (sindicato > 0) {
			valorDescontoSindicatoPlanoSaude(sindicato,
				function(data) {
					if (data.indexOf('failed') > -1) {
						var valorProduto = $("#valorProdutoTitular").val();
						smartAlert("Atenção", "O Sindicato informado não tem Desconto cadastrado!", "error");
						if (valorProduto == "") {
							valorProduto = 0;
						}
						$("#valorFuncionarioTitular").val(valorProduto);
						return;
					} else {
						data = data.replace(/failed/g, '');
						//debugger
						var piece = data.split("#");
						var outValorDescontoPlanoSaude = piece[2];
						var out = piece[1];
						piece = out.split("^");
						var percentualDescontoSindicatoPlanoSaude = out;
						var valorDescontoPlanoSaudeSindicato = outValorDescontoPlanoSaude;

						if (valorDescontoPlanoSaudeSindicato != 0) {
							limpaCamposSindicato(1);
							$("#valorDescontoSindicatoTitular").val(valorDescontoPlanoSaudeSindicato.replace('.', ','));
							calculaValorFuncionarioTitularPlanoSaude();
							calculaValorEmpresa();
							// initializeDecimalBehaviour();
							return;
						}
						if (percentualDescontoSindicatoPlanoSaude != 0) {
							limpaCamposSindicato(0);
							$("#descontoSindicatoTitular").val(percentualDescontoSindicatoPlanoSaude.replace('.', ','));
							calculaValorFuncionarioTitularPlanoSaude();
							calculaValorEmpresa();
							// initializeDecimalBehaviour();
							return;
						}


					}
				}
			);
		}
	}

	function valorDescontoPlanoSaudeProjetoDependente(projeto) {
		if (projeto > 0) {
			valorDescontoProjetoPlanoSaude(projeto,
				function(data) {
					if (data.indexOf('failed') > -1) {
						var valorProduto = $("#valorProdutoTitular").val();
						smartAlert("Atenção", "O projeto informado não tem Desconto cadastrado!", "error");
						if (valorProduto == "") {
							valorProduto = 0;
						}
						$("#valorFuncionarioTitular").val(valorProduto);
						return;
					} else {
						data = data.replace(/failed/g, '');
						//debugger
						var piece = data.split("#");
						var outValorDescontoPlanoSaude = piece[1];
						var out = piece[2];
						piece = out.split("^");
						var percentualDescontoProjetoPlanoSaude = out;
						var valorDescontoPlanoSaudeProjeto = outValorDescontoPlanoSaude;

						if (valorDescontoPlanoSaudeProjeto != 0) {
							limpaCamposProjetoDependente(1);
							$("#valorDescontoProjetoDependente").val(valorDescontoPlanoSaudeProjeto.replace('.', ','));
							calculaValorFuncionarioDependentePlanoSaude();
							calculaValorEmpresaDependente();
							initializeDecimalBehaviour();
							return;
						}
						if (percentualDescontoProjetoPlanoSaude != 0) {
							limpaCamposProjetoDependente(0);
							$("#descontoProjetoDependente").val(percentualDescontoProjetoPlanoSaude.replace('.', ','));
							calculaValorFuncionarioDependentePlanoSaude();
							calculaValorEmpresaDependente();
							initializeDecimalBehaviour();
							return;
						}


					}
				}
			);
		}
	}

	function valorDescontoPlanoSaudeSindicatoDependente(sindicato) {
		if (sindicato > 0) {
			valorDescontoSindicatoPlanoSaude(sindicato,
				function(data) {
					if (data.indexOf('failed') > -1) {
						var valorProduto = $("#valorProdutoTitular").val();
						smartAlert("Atenção", "O Sindicato informado não tem Desconto cadastrado!", "error");
						if (valorProduto == "") {
							valorProduto = 0;
						}
						$("#valorDependente").val(valorProduto);
						return;
					} else {
						data = data.replace(/failed/g, '');
						//debugger
						var piece = data.split("#");
						var outValorDescontoPlanoSaude = piece[2];
						var out = piece[1];
						piece = out.split("^");
						var percentualDescontoSindicatoPlanoSaude = out;
						var valorDescontoPlanoSaudeSindicato = outValorDescontoPlanoSaude;

						if (valorDescontoPlanoSaudeSindicato != 0) {
							limpaCamposSindicatoDependente(1);
							$("#valorDescontoSindicatoDependente").val(valorDescontoPlanoSaudeSindicato.replace('.', '.'));
							calculaValorFuncionarioDependentePlanoSaude();
							calculaValorEmpresaDependente();
							initializeDecimalBehaviour();
							return;
						}
						if (percentualDescontoSindicatoPlanoSaude != 0) {
							limpaCamposSindicatoDependente(0);
							$("#descontoSindicatoDependente").val(parseFloat(percentualDescontoSindicatoPlanoSaude.replace('.', '.')));
							calculaValorFuncionarioDependentePlanoSaude();
							calculaValorEmpresaDependente();
							initializeDecimalBehaviour();
							return;
						}


					}
				}
			);
		}
	}


	function recuperaValorBolsaBeneficioSindicato(sindicato) {
		if (sindicato > 0) {
			valorBolsaBeneficioSindicato(sindicato,
				function(data) {
					if (data.indexOf('failed') > -1) {

					} else {
						data = data.replace(/failed/g, '');
						//debugger
						var piece = data.split("#");
						var out = piece[1];
						piece = out.split("^");
						var valorBolsaBeneficioSindicato = out;
						var saldoDisponivel = $("#saldoDisponivel").val();
						var verificaRecuperacao = $("#verificaRecuperacao").val();
						saldoDisponivel = saldoDisponivel.toString().replace(",", ".");
						$("#valorBolsaBeneficioSindicato").val(valorBolsaBeneficioSindicato.replace('.', ','));
						if (verificaRecuperacao == 0) {
							$("#saldoDisponivel").val(valorBolsaBeneficioSindicato.replace('.', ','));
						}
						initializeDecimalBehaviour();
					}
				}
			);
		}
	}

	function populaFuncionarioRecupera() {
		var funcionario = +$("#funcionario").val();
		$("#funcionarioTitular").val(funcionario);
		calculaIdadeFuncionario();
		populaComboNomeDependente();
	}

	function populaDescricaoSindicato() {
		var codigoSindicato = $("#sindicato").val();
		if (codigoSindicato > 0) {
			descricaoSindicato(codigoSindicato,
				function(data) {
					if (data.indexOf('failed') > -1) {

					} else {
						data = data.replace(/failed/g, '');
						//debugger
						var piece = data.split("#");
						var out = piece[1];
						piece = out.split("^");
						var descricao = out;
						$("#descricaoSindicato").val(descricao);
					}
				}
			);
		}
	}



	function recuperaTipoDescontoVA(tipoDesconto, projeto, sindicato) {

		recuperaDescontoVA(tipoDesconto, projeto, sindicato,
			function(data) {
				if (data.indexOf('failed') > -1) {
					smartAlert("Atenção", "Informe os Descontos Manualmente!", "info");
					$("#valorDiarioProjetoVA").val('');
					$("#valorMensalProjetoVA").val('');
					$("#percentualDescontoProjetoVA").val('');
					$("#valorDescontoProjetoVA").val('');
					$("#valorDiarioSindicatoVA").val('');
					$("#valorMensalSindicatoVA").val('');
					$("#percentualDescontoSindicatoVA").val('');
					$("#valorDescontoSindicatoVA").val('');

					return false;
				} else {
					data = data.replace(/failed/g, '');
					//debugger
					var piece = data.split("#");
					var out = piece[1];
					var verificacao = piece[2];
					piece = out.split("^");
					var valorDiarioRefeicao = piece[0]
					var valorMensalRefeicao = piece[1]
					var descontoFolhaRefeicao = piece[2]
					var valorDescontoRefeicao = piece[3]

					if (verificacao == 0) {
						$("#valorDiarioSindicatoVA").val('');
						$("#valorMensalSindicatoVA").val('');
						$("#percentualDescontoSindicatoVA").val('');
						$("#valorDescontoSindicatoVA").val('');
						$("#valorDiarioFuncionarioVA").val('');
						$("#valorMensalFuncionarioVA").val('');
						$("#percentualDescontoFolhaFuncionarioVA").val('');
						$("#valorDescontoFolhaFuncionarioVA").val('');
						$("#percentualDescontoMesCorrenteVA").val('');
						$("#valorDescontoMesCorrenteVA").val('');

						$("#valorDiarioProjetoVA").val(valorDiarioRefeicao);
						$("#valorMensalProjetoVA").val(valorMensalRefeicao);
						$("#percentualDescontoProjetoVA").val(descontoFolhaRefeicao);
						$("#valorDescontoProjetoVA").val(valorDescontoRefeicao);
						initializeDecimalBehaviour();
						return
					}

					if (verificacao == 1) {
						$("#valorDiarioProjetoVA").val('');
						$("#valorMensalProjetoVA").val('');
						$("#percentualDescontoProjetoVA").val('');
						$("#valorDiarioFuncionarioVA").val('');
						$("#valorMensalFuncionarioVA").val('');
						$("#valorMensalFuncionarioVA").val('');
						$("#percentualDescontoFolhaFuncionarioVA").val('');
						$("#valorDescontoFolhaFuncionarioVA").val('');
						$("#percentualDescontoMesCorrenteVA").val('');
						$("#valorDescontoMesCorrenteVA").val('');

						$("#valorDiarioSindicatoVA").val(valorDiarioRefeicao);
						$("#valorMensalSindicatoVA").val(valorMensalRefeicao);
						$("#percentualDescontoSindicatoVA").val(descontoFolhaRefeicao);
						$("#valorDescontoSindicatoVA").val(valorDescontoRefeicao);
						initializeDecimalBehaviour();
						return
					}
				}
			}
		);

	}


	function limpaCamposProjeto(codigo) {
		switch (codigo) {
			case 0:
				$("#descontoSindicatoTitular").val('');
				$("#valorDescontoSindicatoTitular").val('');
				$("#valorDescontoProjetoTitular").val('');
				$("#descontoPlanoSaudeTitular").val('');
				$("#valorDescontoPlanoSaudeTitular").val('');

				break;
			case 1:
				$("#descontoSindicatoTitular").val('');
				$("#valorDescontoSindicatoTitular").val('');
				$("#descontoProjetoTitular").val('');
				$("#descontoPlanoSaudeTitular").val('');
				$("#valorDescontoPlanoSaudeTitular").val('');
				break;

			case 2:
				$("#descontoProjetoTitular").removeClass('readonly');
				$("#descontoProjetoTitular").prop('disabled', false);
				$("#valorDescontoProjetoTitular").removeClass('readonly');
				$("#valorDescontoProjetoTitular").prop('disabled', false);
				$("#descontoPlanoSaudeTitular").addClass('readonly');
				$("#descontoPlanoSaudeTitular").prop('disabled', true);
				$("#valorDescontoPlanoSaudeTitular").addClass('readonly');
				$("#valorDescontoPlanoSaudeTitular").prop('disabled', true);
				$("#descontoSindicatoTitular").addClass('readonly');
				$("#descontoSindicatoTitular").prop('disabled', true);
				$("#valorDescontoSindicatoTitular").addClass('readonly');
				$("#valorDescontoSindicatoTitular").prop('disabled', true);
				break;
			default:
				break;
		}

	}

	function limpaCamposSindicato(codigo) {
		switch (codigo) {
			case 0:
				$("#valorDescontoSindicatoTitular").val('');
				$("#descontoProjetoTitular").val('');
				$("#valorDescontoProjetoTitular").val('');
				$("#descontoPlanoSaudeTitular").val('');
				$("#valorDescontoPlanoSaudeTitular").val('');



				break;
			case 1:
				$("#descontoSindicatoTitular").val('');
				$("#descontoProjetoTitular").val('');
				$("#valorDescontoProjetoTitular").val('');
				$("#descontoPlanoSaudeTitular").val('');
				$("#valorDescontoPlanoSaudeTitular").val('');

				break;
			case 2:
				$("#descontoSindicatoTitular").removeClass('readonly');
				$("#descontoSindicatoTitular").prop('disabled', false);
				$("#valorDescontoSindicatoTitular").removeClass('readonly');
				$("#valorDescontoSindicatoTitular").prop('disabled', false);
				$("#descontoProjetoTitular").addClass('readonly');
				$("#descontoProjetoTitular").prop('disabled', true);
				$("#descontoProjetoTitular").addClass('readonly');
				$("#descontoProjetoTitular").prop('disabled', true);
				$("#valorDescontoProjetoTitular").addClass('readonly');
				$("#valorDescontoProjetoTitular").prop('disabled', true);
				$("#descontoPlanoSaudeTitular").addClass('readonly');
				$("#descontoPlanoSaudeTitular").prop('disabled', true);
				$("#valorDescontoPlanoSaudeTitular").addClass('readonly');
				$("#valorDescontoPlanoSaudeTitular").prop('disabled', true);
				break;
			default:
				break;
		}

	}

	function limpaCamposPlanoSaude(codigo) {
		switch (codigo) {
			case 0:
				$("#valorDescontoPlanoSaudeTitular").val('');
				$("#valorDescontoProjetoTitular").val('');
				$("#descontoProjetoTitular").val('');
				$("#valorDescontoSindicatoTitular").val('');
				$("#descontoSindicatoTitular").val('');
				break;
			case 1:
				$("#descontoPlanoSaudeTitular").val('');
				$("#valorDescontoProjetoTitular").val('');
				$("#descontoProjetoTitular").val('');
				$("#valorDescontoSindicatoTitular").val('');
				$("#descontoSindicatoTitular").val('');
				break;
			case 2:
				$("#descontoPlanoSaudeTitular").removeClass('readonly');
				$("#descontoPlanoSaudeTitular").prop('disabled', false);
				$("#valorDescontoPlanoSaudeTitular").removeClass('readonly');
				$("#valorDescontoPlanoSaudeTitular").prop('disabled', false);
				$("#descontoProjetoTitular").addClass('readonly');
				$("#descontoProjetoTitular").prop('disabled', true);
				$("#valorDescontoProjetoTitular").addClass('readonly');
				$("#valorDescontoProjetoTitular").prop('disabled', true);
				$("#valorDescontoSindicatoTitular").addClass('readonly');
				$("#valorDescontoSindicatoTitular").prop('disabled', true);
				$("#descontoSindicatoTitular").addClass('readonly');
				$("#descontoSindicatoTitular").prop('disabled', true);

				break;
			default:
				break;
		}

	}

	function limpaTodoCampoValorPlanoSaude() {
		$("#valorDescontoPlanoSaudeTitular").val('');
		$("#valorDescontoProjetoTitular").val('');
		$("#descontoProjetoTitular").val('');
		$("#valorDescontoSindicatoTitular").val('');
		$("#descontoSindicatoTitular").val('');
		$("#descontoPlanoSaudeTitular").val('');

	}


	//#################################### DEPENDENTE ###############################################
	function limpaCamposProjetoDependente(codigo) {
		switch (codigo) {
			case 0:
				$("#descontoSindicatoDependente").val('');
				$("#valorDescontoSindicatoDependente").val('');
				$("#valorDescontoProjetoDependente").val('');
				$("#descontoPlanoSaudeDependente").val('');
				$("#valorDescontoPlanoSaudeDependente").val('');
				break;
			case 1:
				$("#descontoSindicatoDependente").val('');
				$("#valorDescontoSindicatoDependente").val('');
				$("#descontoProjetoDependente").val('');
				$("#descontoPlanoSaudeDependente").val('');
				$("#valorDescontoPlanoSaudeDependente").val('');
				break;

			case 2:
				$("#descontoProjetoDependente").removeClass('readonly');
				$("#descontoProjetoDependente").prop('disabled', false);
				$("#valorDescontoProjetoDependente").removeClass('readonly');
				$("#valorDescontoProjetoDependente").prop('disabled', false);
				$("#descontoPlanoSaudeDependente").addClass('readonly');
				$("#descontoPlanoSaudeDependente").prop('disabled', true);
				$("#valorDescontoPlanoSaudeDependente").addClass('readonly');
				$("#valorDescontoPlanoSaudeDependente").prop('disabled', true);
				$("#descontoSindicatoDependente").addClass('readonly');
				$("#descontoSindicatoDependente").prop('disabled', true);
				$("#valorDescontoSindicatoDependente").addClass('readonly');
				$("#valorDescontoSindicatoDependente").prop('disabled', true);
				break;
			default:
				break;
		}

	}

	function limpaCamposSindicatoDependente(codigo) {
		switch (codigo) {
			case 0:
				$("#valorDescontoSindicatoDependente").val('');
				$("#descontoProjetoDependente").val('');
				$("#valorDescontoProjetoDependente").val('');
				$("#descontoPlanoSaudeDependente").val('');
				$("#valorDescontoPlanoSaudeDependente").val('');
				break;
			case 1:
				$("#descontoSindicatoDependente").val('');
				$("#descontoProjetoDependente").val('');
				$("#valorDescontoProjetoDependente").val('');
				$("#descontoPlanoSaudeDependente").val('');
				$("#valorDescontoPlanoSaudeDependente").val('');
				break;
			case 2:
				$("#descontoSindicatoDependente").removeClass('readonly');
				$("#descontoSindicatoDependente").prop('disabled', false);
				$("#valorDescontoSindicatoDependente").removeClass('readonly');
				$("#valorDescontoSindicatoDependente").prop('disabled', false);
				$("#descontoProjetoDependente").addClass('readonly');
				$("#descontoProjetoDependente").prop('disabled', true);
				$("#descontoProjetoDependente").addClass('readonly');
				$("#descontoProjetoDependente").prop('disabled', true);
				$("#valorDescontoProjetoDependente").addClass('readonly');
				$("#valorDescontoProjetoDependente").prop('disabled', true);
				$("#descontoPlanoSaudeDependente").addClass('readonly');
				$("#descontoPlanoSaudeDependente").prop('disabled', true);
				$("#valorDescontoPlanoSaudeDependente").addClass('readonly');
				$("#valorDescontoPlanoSaudeDependente").prop('disabled', true);
				break;
			default:
				break;
		}

	}

	function limpaCamposPlanoSaudeDependente(codigo) {
		switch (codigo) {
			case 0:
				$("#valorDescontoPlanoSaudeDependente").val('');
				$("#valorDescontoProjetoDependente").val('');
				$("#descontoProjetoDependente").val('');
				$("#valorDescontoSindicatoDependente").val('');
				$("#descontoSindicatoDependente").val('');
				break;
			case 1:
				$("#descontoPlanoSaudeDependente").val('');
				$("#valorDescontoProjetoDependente").val('');
				$("#descontoProjetoDependente").val('');
				$("#valorDescontoSindicatoDependente").val('');
				$("#descontoSindicatoDependente").val('');
				break;
			case 2:
				$("#descontoPlanoSaudeDependente").removeClass('readonly');
				$("#descontoPlanoSaudeDependente").prop('disabled', false);
				$("#valorDescontoPlanoSaudeDependente").removeClass('readonly');
				$("#valorDescontoPlanoSaudeDependente").prop('disabled', false);
				$("#descontoProjetoDependente").addClass('readonly');
				$("#descontoProjetoDependente").prop('disabled', true);
				$("#valorDescontoProjetoDependente").addClass('readonly');
				$("#valorDescontoProjetoDependente").prop('disabled', true);
				$("#valorDescontoSindicatoDependente").addClass('readonly');
				$("#valorDescontoSindicatoDependente").prop('disabled', true);
				$("#descontoSindicatoDependente").addClass('readonly');
				$("#descontoSindicatoDependente").prop('disabled', true);

				break;
			default:
				break;
		}

	}

	function limpaTodoCampoValorPlanoSaudeDependente() {
		$("#valorDescontoPlanoSaudeDependente").val('');
		$("#valorDescontoProjetoDependente").val('');
		$("#descontoProjetoDependente").val('');
		$("#valorDescontoSindicatoDependente").val('');
		$("#descontoSindicatoDependente").val('');
		$("#descontoPlanoSaudeDependente").val('');

	}

	function habilitaTodoCampoPlanoSaude() {
		$("#descontoSindicatoTitular").prop('disabled', true);
		$("#valorDescontoSindicatoTitular").prop('disabled', true);
		$("#descontoProjetoTitular").prop('disabled', true);
		$("#valorDescontoProjetoTitular").prop('disabled', true);
		$("#descontoPlanoSaudeTitular").prop('disabled', true);
		$("#valorDescontoPlanoSaudeTitular").prop('disabled', true);
	}

	function habilitaTodoCampoPlanoSaudeDependente() {
		$("#descontoSindicatoDependente").prop('disabled', true);
		$("#valorDescontoSindicatoDependente").prop('disabled', true);
		$("#descontoProjetoDependente").prop('disabled', true);
		$("#valorDescontoProjetoDependente").prop('disabled', true);
		$("#descontoPlanoSaudeDependente").prop('disabled', true);
		$("#valorDescontoPlanoSaudeDependente").prop('disabled', true);
	}

	function habilitaCampoProduto() {
		$("#produtoDependente").prop('disabled', false);
		$("#produtoDependente").removeClass('readonly');
		$("#produtoTitular").prop('disabled', false);
		$("#produtoTitular").removeClass('readonly');

	}

	function desabilitaCampoProduto() {
		$("#produtoDependente").prop('disabled', true);
		$("#produtoDependente").addClass('readonly');
		$("#produtoTitular").prop('disabled', true);
		$("#produtoTitular").addClass('readonly');

	}

	function desabilitaCampoDiaUtil() {
		$('#diaUtilJaneiro').addClass('readonly');
		$('#diaUtilJaneiro').val('');
		$("#diaUtilJaneiro").prop('disabled', true);

		$('#diaUtilFevereiro').addClass('readonly');
		$('#diaUtilFevereiro').val('');
		$("#diaUtilFevereiro").prop('disabled', true);

		$('#diaUtilMarco').addClass('readonly');
		$('#diaUtilMarco').val('');
		$("#diaUtilMarco").prop('disabled', true);

		$('#diaUtilAbril').addClass('readonly');
		$('#diaUtilAbril').val('');
		$("#diaUtilAbril").prop('disabled', true);

		$('#diaUtilMaio').addClass('readonly');
		$('#diaUtilMaio').val('');
		$("#diaUtilMaio").prop('disabled', true);

		$('#diaUtilJunho').addClass('readonly');
		$('#diaUtilJunho').val('');
		$("#diaUtilJunho").prop('disabled', true);

		$('#diaUtilJulho').addClass('readonly');
		$('#diaUtilJulho').val('');
		$("#diaUtilJulho").prop('disabled', true);

		$('#diaUtilAgosto').addClass('readonly');
		$('#diaUtilAgosto').val('');
		$("#diaUtilAgosto").prop('disabled', true);

		$('#diaUtilSetembro').addClass('readonly');
		$('#diaUtilSetembro').val('');
		$("#diaUtilSetembro").prop('disabled', true);

		$('#diaUtilOutubro').addClass('readonly');
		$('#diaUtilOutubro').val('');
		$("#diaUtilOutubro").prop('disabled', true);

		$('#diaUtilNovembro').addClass('readonly');
		$('#diaUtilNovembro').val('');
		$("#diaUtilNovembro").prop('disabled', true);

		$('#diaUtilDezembro').addClass('readonly');
		$('#diaUtilDezembro').val('');
		$("#diaUtilDezembro").prop('disabled', true);

		$('#escalaFeriasVAVR').addClass('readonly');
		$('#escalaFeriasVAVR').val('');
		$("#escalaFeriasVAVR").prop('disabled', true);

	}

	function desabilitaCampoDiaUtilVT() {
		$('#diaUtilJaneiroVT').addClass('readonly');
		$('#diaUtilJaneiroVT').val('');
		$("#diaUtilJaneiroVT").prop('disabled', true);

		$('#diaUtilFevereiroVT').addClass('readonly');
		$('#diaUtilFevereiroVT').val('');
		$("#diaUtilFevereiroVT").prop('disabled', true);

		$('#diaUtilMarcoVT').addClass('readonly');
		$('#diaUtilMarcoVT').val('');
		$("#diaUtilMarcoVT").prop('disabled', true);

		$('#diaUtilAbrilVT').addClass('readonly');
		$('#diaUtilAbrilVT').val('');
		$("#diaUtilAbrilVT").prop('disabled', true);

		$('#diaUtilMaioVT').addClass('readonly');
		$('#diaUtilMaioVT').val('');
		$("#diaUtilMaioVT").prop('disabled', true);

		$('#diaUtilJunhoVT').addClass('readonly');
		$('#diaUtilJunhoVT').val('');
		$("#diaUtilJunhoVT").prop('disabled', true);

		$('#diaUtilJulhoVT').addClass('readonly');
		$('#diaUtilJulhoVT').val('');
		$("#diaUtilJulhoVT").prop('disabled', true);

		$('#diaUtilAgostoVT').addClass('readonly');
		$('#diaUtilAgostoVT').val('');
		$("#diaUtilAgostoVT").prop('disabled', true);

		$('#diaUtilSetembroVT').addClass('readonly');
		$('#diaUtilSetembroVT').val('');
		$("#diaUtilSetembroVT").prop('disabled', true);

		$('#diaUtilOutubroVT').addClass('readonly');
		$('#diaUtilOutubroVT').val('');
		$("#diaUtilOutubroVT").prop('disabled', true);

		$('#diaUtilNovembroVT').addClass('readonly');
		$('#diaUtilNovembroVT').val('');
		$("#diaUtilNovembroVT").prop('disabled', true);

		$('#diaUtilDezembroVT').addClass('readonly');
		$('#diaUtilDezembroVT').val('');
		$("#diaUtilDezembroVT").prop('disabled', true);

		$('#escalaFerias').addClass('readonly');
		$('#escalaFerias').val('');
		$("#escalaFerias").prop('disabled', true);

	}

	function habilitaCampoDiaUtil() {
		$('#diaUtilJaneiro').removeClass('readonly');
		$("#diaUtilJaneiro").prop('disabled', false);

		$('#diaUtilFevereiro').removeClass('readonly');
		$("#diaUtilFevereiro").prop('disabled', false);

		$('#diaUtilMarco').removeClass('readonly');
		$("#diaUtilMarco").prop('disabled', false);

		$('#diaUtilAbril').removeClass('readonly');
		$("#diaUtilAbril").prop('disabled', false);

		$('#diaUtilMaio').removeClass('readonly');
		$("#diaUtilMaio").prop('disabled', false);

		$('#diaUtilJunho').removeClass('readonly');
		$("#diaUtilJunho").prop('disabled', false);

		$('#diaUtilJulho').removeClass('readonly');
		$("#diaUtilJulho").prop('disabled', false);

		$('#diaUtilAgosto').removeClass('readonly');
		$("#diaUtilAgosto").prop('disabled', false);

		$('#diaUtilSetembro').removeClass('readonly');
		$("#diaUtilSetembro").prop('disabled', false);

		$('#diaUtilOutubro').removeClass('readonly');
		$("#diaUtilOutubro").prop('disabled', false);

		$('#diaUtilNovembro').removeClass('readonly');
		$("#diaUtilNovembro").prop('disabled', false);

		$('#diaUtilDezembro').removeClass('readonly');
		$("#diaUtilDezembro").prop('disabled', false);

		$('#escalaFeriasVAVR').removeClass('readonly');
		$("#escalaFeriasVAVR").prop('disabled', false);

	}

	function habilitaCampoDiaUtilVT() {
		$('#diaUtilJaneiroVT').removeClass('readonly');
		$("#diaUtilJaneiroVT").prop('disabled', false);

		$('#diaUtilFevereiroVT').removeClass('readonly');
		$("#diaUtilFevereiroVT").prop('disabled', false);

		$('#diaUtilMarcoVT').removeClass('readonly');
		$("#diaUtilMarcoVT").prop('disabled', false);

		$('#diaUtilAbrilVT').removeClass('readonly');
		$("#diaUtilAbrilVT").prop('disabled', false);

		$('#diaUtilMaioVT').removeClass('readonly');
		$("#diaUtilMaioVT").prop('disabled', false);

		$('#diaUtilJunhoVT').removeClass('readonly');
		$("#diaUtilJunhoVT").prop('disabled', false);

		$('#diaUtilJulhoVT').removeClass('readonly');
		$("#diaUtilJulhoVT").prop('disabled', false);

		$('#diaUtilAgostoVT').removeClass('readonly');
		$("#diaUtilAgostoVT").prop('disabled', false);

		$('#diaUtilSetembroVT').removeClass('readonly');
		$("#diaUtilSetembroVT").prop('disabled', false);

		$('#diaUtilOutubroVT').removeClass('readonly');
		$("#diaUtilOutubroVT").prop('disabled', false);

		$('#diaUtilNovembroVT').removeClass('readonly');
		$("#diaUtilNovembroVT").prop('disabled', false);

		$('#diaUtilDezembroVT').removeClass('readonly');
		$("#diaUtilDezembroVT").prop('disabled', false);

		$('#escalaFerias').removeClass('readonly');
		$("#escalaFerias").prop('disabled', false);
	}


	function limpaCampoVaProjeto() {
		$("#valorDiarioProjetoVA").prop("disabled", false);
		$("#valorDiarioProjetoVA").removeClass("readonly");
		$("#valorMensalProjetoVA").prop("disabled", false);
		$("#valorMensalProjetoVA").removeClass("readonly");
		$("#percentualDescontoProjetoVA").prop("disabled", false);
		$("#percentualDescontoProjetoVA").removeClass("readonly");
		$("#valorDescontoProjetoVA").prop("disabled", false);
		$("#valorDescontoProjetoVA").removeClass("readonly");

		$("#valorDiarioSindicatoVA").prop("disabled", true);
		$("#valorDiarioSindicatoVA").addClass("readonly");
		$("#valorMensalSindicatoVA").prop("disabled", true);
		$("#valorMensalSindicatoVA").addClass("readonly");

		$("#percentualDescontoSindicatoVA").prop("disabled", true);
		$("#percentualDescontoSindicatoVA").addClass("readonly");
		$("#valorDescontoSindicatoVA").prop("disabled", true);
		$("#valorDescontoSindicatoVA").addClass("readonly");

		$("#valorDiarioFuncionarioVA").prop("disabled", true);
		$("#valorDiarioFuncionarioVA").addClass("readonly");
		$("#valorMensalFuncionarioVA").prop("disabled", true);
		$("#valorMensalFuncionarioVA").addClass("readonly");

		$("#percentualDescontoFolhaFuncionarioVA").prop("disabled", true);
		$("#percentualDescontoFolhaFuncionarioVA").addClass("readonly");
		$("#valorDescontoFolhaFuncionarioVA").prop("disabled", true);
		$("#valorDescontoFolhaFuncionarioVA").addClass("readonly");


	}


	function limpaCampoVaSindicato() {
		$("#valorDiarioSindicatoVA").prop("disabled", false);
		$("#valorDiarioSindicatoVA").removeClass("readonly");
		$("#valorMensalSindicatoVA").prop("disabled", false);
		$("#valorMensalSindicatoVA").removeClass("readonly");
		$("#percentualDescontoSindicatoVA").prop("disabled", false);
		$("#percentualDescontoSindicatoVA").removeClass("readonly");
		$("#valorDescontoSindicatoVA").prop("disabled", false);
		$("#valorDescontoSindicatoVA").removeClass("readonly");

		$("#valorDiarioProjetoVA").prop("disabled", true);
		$("#valorDiarioProjetoVA").addClass("readonly");
		$("#valorMensalProjetoVA").prop("disabled", true);
		$("#valorMensalProjetoVA").addClass("readonly");

		$("#percentualDescontoProjetoVA").prop("disabled", true);
		$("#percentualDescontoProjetoVA").addClass("readonly");
		$("#valorDescontoProjetoVA").prop("disabled", true);
		$("#valorDescontoProjetoVA").addClass("readonly");

		$("#valorDiarioFuncionarioVA").prop("disabled", true);
		$("#valorDiarioFuncionarioVA").addClass("readonly");
		$("#valorMensalFuncionarioVA").prop("disabled", true);
		$("#valorMensalFuncionarioVA").addClass("readonly");

		$("#percentualDescontoFolhaFuncionarioVA").prop("disabled", true);
		$("#percentualDescontoFolhaFuncionarioVA").addClass("readonly");
		$("#valorDescontoFolhaFuncionarioVA").prop("disabled", true);
		$("#valorDescontoFolhaFuncionarioVA").addClass("readonly");
	}


	function limpaCampoVaFuncionario() {
		$("#valorDiarioFuncionarioVA").prop("disabled", false);
		$("#valorDiarioFuncionarioVA").removeClass("readonly");
		$("#valorMensalFuncionarioVA").prop("disabled", false);
		$("#valorMensalFuncionarioVA").removeClass("readonly");
		$("#percentualDescontoFolhaFuncionarioVA").prop("disabled", false);
		$("#percentualDescontoFolhaFuncionarioVA").removeClass("readonly");
		$("#valorDescontoFolhaFuncionarioVA").prop("disabled", false);
		$("#valorDescontoFolhaFuncionarioVA").removeClass("readonly");

		$("#valorDiarioProjetoVA").prop("disabled", true);
		$("#valorDiarioProjetoVA").addClass("readonly");
		$("#valorMensalProjetoVA").prop("disabled", true);
		$("#valorMensalProjetoVA").addClass("readonly");

		$("#percentualDescontoProjetoVA").prop("disabled", true);
		$("#percentualDescontoProjetoVA").addClass("readonly");
		$("#valorDescontoProjetoVA").prop("disabled", true);
		$("#valorDescontoProjetoVA").addClass("readonly");

		$("#valorDiarioSindicatoVA").prop("disabled", true);
		$("#valorDiarioSindicatoVA").addClass("readonly");
		$("#valorMensalSindicatoVA").prop("disabled", true);
		$("#valorMensalSindicatoVA").addClass("readonly");

		$("#percentualDescontoSindicatoVA").prop("disabled", true);
		$("#percentualDescontoSindicatoVA").addClass("readonly");
		$("#valorDescontoSindicatoVA").prop("disabled", true);
		$("#valorDescontoSindicatoVA").addClass("readonly");
	}



	function desabilitaCampoVaRecupera() {
		var valorDiarioProjeto = $("#valorDiarioProjetoVA").val();
		valorDiarioProjeto = valorDiarioProjeto.toString().replace(",", ".");
		var valorMensalProjeto = $("#valorMensalProjetoVA").val();
		valorMensalProjeto = valorMensalProjeto.toString().replace(",", ".");
		var percentualDescontoProjeto = $("#percentualDescontoProjetoVA").val();
		percentualDescontoProjeto = percentualDescontoProjeto.toString().replace(",", ".");
		var valorDescontoProjeto = $("#valorDescontoProjetoVA").val();
		valorDescontoProjeto = valorDescontoProjeto.toString().replace(",", ".");


		var valorDiarioSindicatoVA = $("#valorDiarioSindicatoVA").val();
		valorDiarioSindicatoVA = valorDiarioSindicatoVA.toString().replace(",", ".");
		var valorMensalSindicatoVA = $("#valorMensalSindicatoVA").val();
		valorMensalSindicatoVA = valorMensalSindicatoVA.toString().replace(",", ".");
		var percentualDescontoSindicatoVA = $("#percentualDescontoSindicatoVA").val();
		percentualDescontoSindicatoVA = percentualDescontoSindicatoVA.toString().replace(",", ".");
		var valorDescontoSindicatoVA = $("#valorDescontoSindicatoVA").val();
		valorDescontoSindicatoVA = valorDescontoSindicatoVA.toString().replace(",", ".");


		var valorDiarioFuncionarioVA = $("#valorDiarioFuncionarioVA").val();
		valorDiarioFuncionarioVA = valorDiarioFuncionarioVA.toString().replace(",", ".");
		var valorMensalFuncionarioVA = $("#valorMensalFuncionarioVA").val()
		valorMensalFuncionarioVA = valorMensalFuncionarioVA.toString().replace(",", ".");
		var percentualDescontoFolhaFuncionarioVA = $("#percentualDescontoFolhaFuncionarioVA").val();
		percentualDescontoFolhaFuncionarioVA = percentualDescontoFolhaFuncionarioVA.toString().replace(",", ".")
		var valorDescontoFolhaFuncionarioVA = $("#valorDescontoFolhaFuncionarioVA").val();
		valorDescontoFolhaFuncionarioVA = valorDescontoFolhaFuncionarioVA.toString().replace(",", ".");

		if (valorDiarioProjeto > 0 || valorMensalProjeto > 0 ||
			percentualDescontoProjeto > 0 || valorDiarioProjeto > 0) {
			limpaCampoVaProjeto();
		}

		if (valorDiarioSindicatoVA > 0 || valorMensalSindicatoVA > 0 ||
			percentualDescontoSindicatoVA > 0 || valorDescontoSindicatoVA > 0) {
			limpaCampoVaSindicato();
		}

		if (valorDiarioFuncionarioVA > 0 || valorMensalFuncionarioVA > 0 ||
			percentualDescontoFolhaFuncionarioVA > 0 || valorDescontoFolhaFuncionarioVA > 0) {
			limpaCampoVaFuncionario();
		}


	}



	function desbilitaCampoAcrescimo() {
		$("#valorAcrescimo").addClass('readonly');
		$("#valorAcrescimo").prop('disabled', true);
		$("#valorAcrescimo").val(0);
		initializeDecimalBehaviour()
		$("#valorAbater").removeClass('readonly');
		$("#valorAbater").prop('disabled', false);
	}

	function desabilitaCampoAbater() {
		$("#valorAbater").addClass('readonly');
		$("#valorAbater").prop('disabled', true);
		$("#valorAbater").val(0);
		initializeDecimalBehaviour()
		$("#valorAcrescimo").removeClass('readonly');
		$("#valorAcrescimo").prop('disabled', false);
	}

	function calculaValorFinalBeneficio() {
		var valorBeneficioFuncionario = $("#valorBeneficioFuncionario").val().toString().replace(",", ".");
		var valorAcrescimo = $("#valorAcrescimo").val().toString().replace(",", ".");

		var valorFinalBeneficio = 0;
		if (parseFloat(valorAcrescimo) >= 0) {
			valorFinalBeneficio = parseFloat(valorBeneficioFuncionario) + parseFloat(valorAcrescimo);
			$("#valorFinalBeneficio").val(valorFinalBeneficio.toString().replace(".", ","));

			initializeDecimalBehaviour();
		}
	}

	function verificaFuncionariEmProjeto() {
		var funcionario = $("#funcionario").val();
		var projeto = $("#projeto").val();

		verificaFuncionarioProjeto(funcionario, projeto,
			function(data) {
				if (data.indexOf('sucess') < 0) {
					var piece = data.split("#");
					var mensagem = piece[1];
					if (mensagem !== "") {
						smartAlert("Atenção", mensagem, "error");
						return false;
					} else {
						$('#btnGravar').attr('disabled', false);
						return;
					}
				} else {
					smartAlert("ERRO", "Este funcionário já está cadastrado neste Projeto!", "error");
					$("#funcionario").val(0)
					$("#projeto").val(0)
					$('#btnGravar').attr('disabled', true);
				}
			}
		);
	}

	function habilitaDesabilitaCamposDiasUteisMunicipio(verificador, campoDesejado) {
		//se for 1 vai desabilitar os municipios
		switch (verificador) {
			case 1:
				$(campoDesejado).attr("readonly", "readonly");
				$(campoDesejado).addClass("readonly");
				break;
				//se for 2 vai habilitar os municipios
			case 2:
				$(campoDesejado).attr("readonly", false);
				$(campoDesejado).removeClass("readonly");
				break;
			default:
				break;
		}

	}

	function gravar() {
		let beneficio = $('#formBeneficio').serializeArray().reduce(function(obj, item) {
			obj[item.name] = item.value;
			return obj;
		}, {});


		gravaBeneficio(beneficio,
			function(data) {
				if (data.indexOf('sucess') < 0) {
					var piece = data.split("#");
					var mensagem = piece[1];
					if (mensagem !== "") {
						smartAlert("Atenção", mensagem, "error");
						return false;
					} else {
						smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR !", "error");
						return false;
						//                                                            return;
					}
				} else {
					var verificaRecuperacao = +$("#verificaRecuperacao").val();
					smartAlert("Sucesso", "Operação realizada com sucesso!", "success");

					if (verificaRecuperacao === 1) {
						voltar();
					} else {
						novo();
						return;
					}
				}
			}
		);
	}

	//form Beneficio Indireto
	function clearFormBeneficioIndireto() {

		$("#beneficioIndireto").val('');
		$("#valorBeneficioFuncionario").val('');
		$("#valorAcrescimo").val('');
		$("#valorAbater").val('');
		$('#valorFinalBeneficio').val('');
		$('#sequencialBeneficioIndireto').val('');
	}


	function validaBeneficioIndireto() {
		var achouBeneficioIndireto = false;
		var beneficioIndireto = $('#beneficioIndireto').val();
		var sequencial = +$('#sequencialBeneficioIndireto').val();
		if (beneficioIndireto === '') {
			smartAlert("Erro", "Informe o Benefício Indireto", "error");
			return false;
		}
		for (i = jsonBeneficioIndiretoArray.length - 1; i >= 0; i--) {
			if (beneficioIndireto !== "") {
				if ((jsonBeneficioIndiretoArray[i].beneficioIndireto === beneficioIndireto) && (jsonBeneficioIndiretoArray[i].sequencialBeneficioIndireto !== sequencial)) {
					achouBeneficioIndireto = true;
					break;
				}
			}
		}

		if (achouBeneficioIndireto === true) {
			smartAlert("Erro", "Já existe o Benefício Indireto na lista.", "error");
			return false;
		}

		return true;
	}

	function buscaValorPosto() {
		var posto = $("#descricaoPosto").val();
		preencheValorPosto(posto,
			function(data) {
				if (data.indexOf('failed') > -1) {
					var piece = data.split("#");
					var mensagem = piece[1];
					if (mensagem !== "") {
						smartAlert("Atenção", mensagem, "error");
						$("#btnGravar").prop('disabled', false);
					} else {
						smartAlert("Atenção", "Erro ao calcular os dias úiteis!", "error");
						$("#btnGravar").prop('disabled', false);
					}
				} else {
					data = data.replace(/failed/g, '');
					var piece = data.split("#");
					var mensagem = piece[0];
					var out = piece[1];

					piece = out.split("^");
					var valorPosto = +piece[0];
					$("#valorPosto").val(valorPosto);
				}
			}
		);
	}

	function popularComboDescricaoPosto() {
		var projeto = $("#projeto").val()
		if (projeto != 0) {
			populaComboDescricaoPosto(projeto,
				function(data) {
					var atributoId = '#' + 'descricaoPosto';
					if (data.indexOf('failed') > -1) {
						smartAlert("Aviso", "O Projeto informado não possui postos com valor atribuido!", "info");
						$("#projeto").focus()
						$("#descricaoPosto").val("")
						$("#descricaoPosto").prop("disabled", true)
						$("#descricaoPosto").addClass("readonly")
						return;
					} else {
						$("#descricaoPosto").prop("disabled", false)
						$("#descricaoPosto").removeClass("readonly")
						data = data.replace(/failed/g, '');
						var piece = data.split("#");

						var mensagem = piece[0];
						var qtdRegs = piece[1];
						var arrayRegistros = piece[2].split("|");
						var registro = "";

						$(atributoId).html('');
						$(atributoId).append('<option></option>');

						for (var i = 0; i < qtdRegs; i++) {
							registro = arrayRegistros[i].split("^");
							$(atributoId).append('<option value=' + registro[0] + '>' + registro[1] + '</option>');
						}
					}
				}
			);
		}
	}
</script>