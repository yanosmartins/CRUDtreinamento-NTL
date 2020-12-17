<?php

//CONFIGURATION for SmartAdmin UI
//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
    "Home" => APP_URL . "/index.php"
);

include_once "js/repositorio.php";
session_start();
$login = $_SESSION['login'];
$login = "'" . $login . "'";

$arrayPermissao = array();

$reposit = new reposit();
$result = $reposit->SelectCondTrue("usuario| login = " . $login . " AND ativo = 1");
if ($row = $result) {
    $codigoUsuario = +$row['codigo'];
    $tipoUsuario = $row['tipoUsuario'];
    $funcionario = +$row['funcionario'];

    if ($tipoUsuario === "C") {
        $sql = "SELECT FNC.nome FROM dbo.usuarioFuncionalidade USUF
				INNER JOIN dbo.funcionalidade FNC ON FNC.codigo = USUF.funcionalidade
                WHERE USUF.usuario = " . $codigoUsuario;
        $result = $reposit->RunQuery($sql);
        while (($row = odbc_fetch_array($result))) {
            array_push($arrayPermissao, $row["nome"]);
        }
    }
    if ($tipoUsuario === "S") {
        $sql = " SELECT nome FROM dbo.funcionalidade";
        $result = $reposit->RunQuery($sql);
        while (($row = odbc_fetch_array($result))) {
            array_push($arrayPermissao, $row["nome"]);
        }
    }
}

$page_nav = array("home" => array("title" => "Home", "icon" => "fa-home", "url" => APP_URL . "/index.php"));
$condicaoConfiguracoesOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
$condicaoConfiguracoesOK = (($condicaoConfiguracoesOK) or in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true));
$condicaoConfiguracoesOK = (($condicaoConfiguracoesOK) or in_array('PARAMETRO_ACESSAR', $arrayPermissao, true));


$condicaoVersaoSistemaOk = true;
$condicaoTabelaBasicaOk =  true; //(in_array('TABELABASICA_ACESSAR', $arrayPermissao, true)); -> Descomentar quando houver banco.  
$condicaoCadastroOk = true;
$condicaoBeneficioOk = true;
$condicaoContratacaoOk = true;
$condicaoFaturamentoOk = true;
$condicaoLicitacaoOk = true;
$condicaoOperacoesEspeciaisoOk = true;

// TABELAS BÁSICAS
if ($condicaoTabelaBasicaOk) {
    $page_nav['tabelaBasica'] = array("title" => "Tabela Básica", "icon" => "fa fa-table");
    $page_nav['tabelaBasica']['sub'] = array();
    //if (in_array('USUARIO_ACESSAR', $arrayPermissao, true)) {
    $page_nav['tabelaBasica']['sub'] += array("banco" => array("title" => "Banco", "url" => APP_URL . "/index.php")); //SYSCC   
    $page_nav['tabelaBasica']['sub'] += array("beneficioIndireto" => array("title" => "Benefício Indireto", "url" => APP_URL . "/index.php")); //SYSCB  
    $page_nav['tabelaBasica']['sub'] += array("caucao" => array("title" => "Caução", "url" => APP_URL . "/index.php")); //SYSGEF
    $page_nav['tabelaBasica']['sub'] += array("classe" => array("title" => "Classe", "url" => APP_URL . "/index.php")); //SYSCC  
    $page_nav['tabelaBasica']['sub'] += array("dataInicioReajuste" => array("title" => "Data do Ínicio de Reajuste", "url" => APP_URL . "/index.php")); //SYSGEF
    $page_nav['tabelaBasica']['sub'] += array("escala" => array("title" => "Escalas", "url" => APP_URL . "/index.php")); //SYSCC  
    $page_nav['tabelaBasica']['sub'] += array("indiceReajuste" => array("title" => "Índice de Reajuste", "url" => APP_URL . "/index.php")); //SYSGEF 
    $page_nav['tabelaBasica']['sub'] += array("lancamento" => array("title" => "Lançamento", "url" => APP_URL . "/index.php")); //SYSCB
    $page_nav['tabelaBasica']['sub'] += array("motivoAfastamento" => array("title" => "Motivo do Afastamento", "url" => APP_URL . "/index.php")); //SYSCB
    $page_nav['tabelaBasica']['sub'] += array("municipio" => array("title" => "Município", "url" => APP_URL . "/index.php")); //SYSCB


    //SUBMENU FATURAMENTO MUDOU PARA -> OPERAÇÕES DO POSTO - SYSCB
    if (true) {
        $page_nav['tabelaBasica']['sub']['operacaoPosto'] = array("title" => "Operações de Posto");
        $page_nav['tabelaBasica']['sub']['operacaoPosto']['sub'] = array();

        if (true) { //in_array('LOCALIZACAO_ACESSAR', $arrayPermissao, true)
            $page_nav['tabelaBasica']['sub']['operacaoPosto']['sub'] += array("localizacao" => array("title" => "Localização", "url" => APP_URL . "/index.php"));
            $page_nav['tabelaBasica']['sub']['operacaoPosto']['sub'] += array("posto" => array("title" => "Posto", "url" => APP_URL . "/index.php"));
        }
    }

    $page_nav['tabelaBasica']['sub'] += array("periodoRenovacao" => array("title" => "Período de Renovação", "url" => APP_URL . "/index.php")); //SYSGEF
    $page_nav['tabelaBasica']['sub'] += array("periodoVigencia" => array("title" => "Período de Vigência", "url" => APP_URL . "/index.php")); //SYSGEF
    $page_nav['tabelaBasica']['sub'] += array("portal" => array("title" => "Portal", "url" => APP_URL . "/index.php")); //SYSGC 
    $page_nav['tabelaBasica']['sub'] += array("responsavel" => array("title" => "Responsável", "url" => APP_URL . "/index.php")); //SYSGC

    //SUBMENU RETENÇÃO CONTA VINCULADA - SYSGEF
    if (true) {
        $page_nav['tabelaBasica']['sub']['retencaoContaVinculada'] = array("title" => "Retenção Conta Vinculada");
        $page_nav['tabelaBasica']['sub']['retencaoContaVinculada']['sub'] = array();

        if (true) { //in_array('LOCALIZACAO_ACESSAR', $arrayPermissao, true)
            $page_nav['tabelaBasica']['sub']['retencaoContaVinculada']['sub'] += array("decimoTerceiro" => array("title" => "13º Salário", "url" => APP_URL . "/index.php"));
            $page_nav['tabelaBasica']['sub']['retencaoContaVinculada']['sub'] += array("feriasTercoConstitucional" => array("title" => "Férias e Terço Constitucional", "url" => APP_URL . "/index.php"));
            $page_nav['tabelaBasica']['sub']['retencaoContaVinculada']['sub'] += array("multaFGTS" => array("title" => "Multa FGTS por Dispensa sem Justa Causa", "url" => APP_URL . "/index.php"));
        }
    }

    //SUBMENU RETENÇÃO TRIBUTÁRIA - SYSGEF
    if (true) {
        $page_nav['tabelaBasica']['sub']['retencaoTributaria'] = array("title" => "Retenção Tributária");
        $page_nav['tabelaBasica']['sub']['retencaoTributaria']['sub'] = array();

        if (true) { //in_array('LOCALIZACAO_ACESSAR', $arrayPermissao, true)
            $page_nav['tabelaBasica']['sub']['retencaoTributaria']['sub'] += array("iss" => array("title" => "ISS", "url" => APP_URL . "/index.php"));
            $page_nav['tabelaBasica']['sub']['retencaoTributaria']['sub'] += array("inss" => array("title" => "INSS", "url" => APP_URL . "/index.php"));
            $page_nav['tabelaBasica']['sub']['retencaoTributaria']['sub'] += array("ir" => array("title" => "IR", "url" => APP_URL . "/index.php"));
            $page_nav['tabelaBasica']['sub']['retencaoTributaria']['sub'] += array("pisConfisCs" => array("title" => "PIS, CONFIS, CS", "url" => APP_URL . "/index.php"));
        }
    }

    $page_nav['tabelaBasica']['sub'] += array("municipio" => array("title" => "Município", "url" => APP_URL . "/index.php")); //SYSGEF
    $page_nav['tabelaBasica']['sub'] += array("serviço" => array("title" => "Serviço", "url" => APP_URL . "/index.php")); //SYSGEF
    $page_nav['tabelaBasica']['sub'] += array("situacao" => array("title" => "Situação", "url" => APP_URL . "/index.php")); //SYSGC 
    $page_nav['tabelaBasica']['sub'] += array("tarefa" => array("title" => "Tarefa", "url" => APP_URL . "/index.php")); //SYSGC   
    $page_nav['tabelaBasica']['sub'] += array("valeTransporteUnitario" => array("title" => "Vale Transporte Unitário", "url" => APP_URL . "/index.php")); //SYSGC 

}

// CADASTROS
if ($condicaoCadastroOk) {
    $page_nav['cadastro'] = array("title" => "Cadastro", "icon" => "fa-pencil-square-o");
    $page_nav['cadastro']['sub'] = array();
    //if (in_array('USUARIO_ACESSAR', $arrayPermissao, true)) {
    $page_nav['cadastro']['sub'] += array("afastamentoFuncionario" => array("title" => "Afastamento do Funcionário", "url" => APP_URL . "/index.php")); //SYSCB 
    $page_nav['cadastro']['sub'] += array("candidato" => array("title" => "Candidato", "url" => APP_URL . "/index.php")); //SYSCB 
    $page_nav['cadastro']['sub'] += array("cargo" => array("title" => "Cargo", "url" => APP_URL . "/index.php")); //SYSCB 
    $page_nav['cadastro']['sub'] += array("convenioSaude" => array("title" => "Convênio de Saúde", "url" => APP_URL . "/index.php")); //SYSGC 
    $page_nav['cadastro']['sub'] += array("diasUteisPorMunicipio" => array("title" => "Dias Úteis por Município", "url" => APP_URL . "/index.php")); //SYSCB
    $page_nav['cadastro']['sub'] += array("feriado" => array("title" => "Feriado", "url" => APP_URL . "/index.php")); //SYSCB  
    $page_nav['cadastro']['sub'] += array("ferias" => array("title" => "Férias", "url" => APP_URL . "/index.php")); //SYSCB  
    $page_nav['cadastro']['sub'] += array("fornecedor" => array("title" => "Fornecedor", "url" => APP_URL . "/index.php")); //SYSCB
    $page_nav['cadastro']['sub'] += array("funcionario" => array("title" => "Funcionário", "url" => APP_URL . "/index.php")); //SYSCB 
    $page_nav['cadastro']['sub'] += array("produto" => array("title" => "Produto", "url" => APP_URL . "/index.php")); //SYSCB
    $page_nav['cadastro']['sub'] += array("projeto" => array("title" => "Projeto", "url" => APP_URL . "/index.php")); //SYSCB
    $page_nav['cadastro']['sub'] += array("sindicato" => array("title" => "Sindicato", "url" => APP_URL . "/index.php")); //SYSCB 
    $page_nav['cadastro']['sub'] += array("valeTransporteModal" => array("title" => "Vale Transporte Modal", "url" => APP_URL . "/index.php")); //SYSCB
    $page_nav['cadastro']['sub'] += array("valorPosto" => array("title" => "Valor do Posto", "url" => APP_URL . "/index.php")); //SYSCB 
    $page_nav['cadastro']['sub'] += array("vinculosBeneficios" => array("title" => "Vínculos e Benefícios", "url" => APP_URL . "/index.php")); //SYSCB 
     
}
// BENEFÍCIOS - SYSCB 
if ($condicaoBeneficioOk) {
    $page_nav['beneficio'] = array("title" => "Benefício", "icon" => "fa fa-folder-open");
    $page_nav['beneficio']['sub'] = array();

    $page_nav['beneficio']['sub'] += array("folhaPonto" => array("title" => "Folha de Ponto", "url" => APP_URL . "/index.php")); 
    $page_nav['beneficio']['sub'] += array("processaBeneficio" => array("title" => "Processa Benefício", "url" => APP_URL . "/index.php"));
    $page_nav['beneficio']['sub'] += array("consultaBenefício" => array("title" => "Consulta Benefício", "url" => APP_URL . "/index.php"));
    $page_nav['beneficio']['sub'] += array("fechamentoMes" => array("title" => "Fechamento do Mês", "url" => APP_URL . "/index.php"));
}

// CONTRATAÇÕES
if ($condicaoContratacaoOk) {
    $page_nav['contratacao'] = array("title" => "Contratação", "icon" => "fa fa-fax");
    $page_nav['contratacao']['sub'] = array();

    //SUBMENU OPERAÇÕES MENSAIS
    if (true) {
        $page_nav['contratacao']['sub']['operacoesMensais'] = array("title" => "Operações Mensais");
        $page_nav['contratacao']['sub']['operacoesMensais']['sub'] = array();

        if (true) { //in_array('LOCALIZACAO_ACESSAR', $arrayPermissao, true)
            $page_nav['contratacao']['sub']['operacoesMensais']['sub'] += array("localizacao" => array("title" => "Localização", "url" => APP_URL . "/index.php"));
        }
    }
}


// FATURAMENTOS
if ($condicaoFaturamentoOk) {
    $page_nav['faturamento'] = array("title" => "Faturamento", "icon" => "fa fa-dollar");
    $page_nav['faturamento']['sub'] = array();

    //SUBMENU OPERAÇÕES MENSAIS
    if (true) {
        $page_nav['faturamento']['sub']['operacoesMensais'] = array("title" => "Operações Mensais");
        $page_nav['faturamento']['sub']['operacoesMensais']['sub'] = array();

        if (true) { //in_array('LOCALIZACAO_ACESSAR', $arrayPermissao, true)
            $page_nav['faturamento']['sub']['operacoesMensais']['sub'] += array("localizacao" => array("title" => "Localização", "url" => APP_URL . "/index.php"));
        }
    }
}

// LICITAÇÕES - SYSGC
if ($condicaoLicitacaoOk) {
    $page_nav['licitacao'] = array("title" => "Licitação", "icon" => "fa fa-line-chart");
    $page_nav['licitacao']['sub'] = array();

    $page_nav['licitacao']['sub'] += array("garimparPregoes" => array("title" => "Garimpar Pregões", "url" => APP_URL . "/index.php"));  
    $page_nav['licitacao']['sub'] += array("participarPregoes" => array("title" => "Participar Pregões", "url" => APP_URL . "/index.php")); 
    $page_nav['licitacao']['sub'] += array("pregoesNaoIniciados" => array("title" => "Pregões Não Iniciados", "url" => APP_URL . "/index.php"));  
    $page_nav['licitacao']['sub'] += array("pregoesEmAndamento" => array("title" => "Pregões Em Andamento", "url" => APP_URL . "/index.php"));
    $page_nav['licitacao']['sub'] += array("relatorioTarefas" => array("title" => "Relatório de Tarefas", "url" => APP_URL . "/index.php"));
}


//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
