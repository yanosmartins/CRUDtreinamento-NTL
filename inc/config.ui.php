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
$codigoLogin = $_SESSION['codigo'];
$funcionario = $_SESSION['funcionario'];
$login = "'" . $login . "'";

$arrayPermissao = array();

$reposit = new reposit();
$result = $reposit->SelectCondTrue("usuario| login = " . $login . " AND ativo = 1");
if ($row = $result[0]) {
    $codigoUsuario = (int)$row['codigo'];
    $tipoUsuario = $row['tipoUsuario'];
    $candidato = (int)$row['candidato'];
    $grupo = (int)$row['grupo'];


    if ($tipoUsuario === "C") {
        $sql = "SELECT FNC.nome FROM Ntl.usuarioFuncionalidade USUF
				INNER JOIN Ntl.funcionalidade FNC ON FNC.codigo = USUF.funcionalidade
                WHERE USUF.usuario = " . $codigoUsuario;
        $result = $reposit->RunQuery($sql);
        foreach ($result as $row) {
            array_push($arrayPermissao, $row["nome"]);
        }
    }

    if ($tipoUsuario === "S") {
        $sql = " SELECT nome FROM Ntl.funcionalidade";
        $result = $reposit->RunQuery($sql);
        foreach ($result as $row) {
            array_push($arrayPermissao, $row["nome"]);
        }
    }

    if ($grupo > 0) {
        $sql = "SELECT FNC.nome FROM Ntl.usuarioGrupoFuncionalidade USUGF
				INNER JOIN Ntl.funcionalidade FNC ON FNC.codigo = USUGF.funcionalidade
                WHERE USUGF.grupo = " . $grupo;
        $result = $reposit->RunQuery($sql);
        foreach ($result as $row) {
            array_push($arrayPermissao, $row["nome"]);
        }
    }
}

$page_nav = array("home" => array("title" => "Home", "icon" => "fa-home", "url" => APP_URL . "/index.php"));


//Configurações 
$condicaoConfiguracoesOK = (in_array('USUARIO_ACESSAR', $arrayPermissao, true));
$condicaoConfiguracoesOK = (($condicaoConfiguracoesOK) or in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true));
$condicaoConfiguracoesOK = (($condicaoConfiguracoesOK) or in_array('PARAMETRO_ACESSAR', $arrayPermissao, true));

if ($condicaoConfiguracoesOK) {
    $page_nav['configuracao'] = array("title" => "Configurações", "icon" => "fa-gear");
    $page_nav['configuracao']['sub'] = array();

    if (in_array('USUARIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['configuracao']['sub'] += array("usuarios" => array("title" => "Usuário", "url" => APP_URL . "/usuarioFiltro.php"));
    }
    if (in_array('USUARIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['configuracao']['sub'] += array("grupo" => array("title" => "Grupo", "url" => APP_URL . "/usuarioGrupoFiltro.php"));
    }
    if (in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['configuracao']['sub'] += array("permissoesUsuarios" => array("title" => "Permissões do Usuário", "url" => APP_URL . "/usuarioFuncionalidadeFiltro.php"));
    }
    if (in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['configuracao']['sub'] += array("permissoesGrupoUsuarios" => array("title" => "Permissões do Grupo", "url" => APP_URL . "/usuarioGrupoFuncionalidadeFiltro.php"));
    }
    // if (in_array('PERMISSAOUSUARIO_ACESSAR', $arrayPermissao, true)) {
    //     $page_nav['configuracao']['sub'] += array("permissoesGrupoUsuarios" => array("title" => "Permissões do Grupo", "url" => APP_URL . "/usuarioGrupoFuncionalidadeFiltro.php"));
    // }
    if (in_array('PARAMETRO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['configuracao']['sub'] += array("parametro" => array("title" => "Parâmetros", "url" => APP_URL . "/parametros.php"));
    }
}


$condicaoFaturamentoOk = true;
$condicaoLicitacaoOk = true;
$condicaoOperacoesEspeciaisoOk = false;
$condicaoVersaoSistemaOk = true;
$condicaoTesteOk = true;
$condicaoOperacaoOk = true;

// TABELAS BÁSICAS
$condicaoTabelaBasicaOk = (in_array('TABELABASICA_ACESSAR', $arrayPermissao, true));

if ($condicaoTabelaBasicaOk) {
    $page_nav['tabelaBasica'] = array("title" => "Tabela Básica", "icon" => "fa fa-table");
    $page_nav['tabelaBasica']['sub'] = array();

    if (in_array('ESCALA_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelaBasica']['sub'] += array("escala" => array("title" => "Escala", "url" => APP_URL . "/tabelaBasica_escalaFiltro.php")); //SYSCC  
    }

    if (in_array('GRUPO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelaBasica']['sub'] += array("grupo" => array("title" => "Grupo", "url" => APP_URL . "/tabelaBasica_grupoFiltro.php")); //SYSGC //Faturamento
    }

    if (in_array('LANCAMENTO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelaBasica']['sub'] += array("lancamento" => array("title" => "Lançamento/Ocorrências", "url" => APP_URL . "/tabelaBasica_lancamentoFiltro.php")); //SYSCB
    }

    if (in_array('LOCALIZACAO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelaBasica']['sub'] += array("localizacao" => array("title" => "Localização", "url" => APP_URL . "/tabelaBasica_localizacaoFiltro.php"));
    }

    if (in_array('MUNICIPIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['tabelaBasica']['sub'] += array("municipio" => array("title" => "Município", "url" => APP_URL . "/tabelaBasica_municipioFiltro.php")); //SYSCB 
    }


}

$condicaoCadastroOk = (in_array('CADASTRO_ACESSAR', $arrayPermissao, true));

// CADASTROS
if ($condicaoCadastroOk) {
    $page_nav['cadastro'] = array("title" => "Cadastro", "icon" => "fa-pencil-square-o");
    $page_nav['cadastro']['sub'] = array();

    if (in_array('CARGO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("cargo" => array("title" => "Cargo", "url" => APP_URL . "/cadastro_cargoFiltro.php")); //SYSCB   
    }

    if (in_array('DIASUTEISMUNICIPIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("diasUteisPorMunicipio" => array("title" => "Dias Úteis por Município", "url" => APP_URL . "/cadastro_diasUteisPorMunicipioFiltro.php")); //SYSCB 
    }

    if (in_array('FERIADO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("feriado" => array("title" => "Feriado", "url" => APP_URL . "/cadastro_feriadoFiltro.php")); //SYSCB 
    }
    if (in_array('FORNECEDOR_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("fornecedor" => array("title" => "Fornecedor", "url" => APP_URL . "/cadastro_fornecedorFiltro.php")); //SYSCB
    }
    if (in_array('FUNCIONARIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("funcionario" => array("title" => "Funcionário", "url" => APP_URL . "/cadastro_funcionarioFiltro.php")); //SYSCB 
    }

    if (in_array('PROJETO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("projeto" => array("title" => "Projeto", "url" => APP_URL . "/cadastro_projetoFiltro.php")); //SYSCB
    }
    if (in_array('SINDICATO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("sindicato" => array("title" => "Sindicato", "url" => APP_URL . "/cadastro_sindicatoFiltro.php")); //SYSCB  
    }

    // if (in_array('VALORPOSTO_ACESSAR', $arrayPermissao, true)) {
    //     $page_nav['cadastro']['sub'] += array("valorPosto" => array("title" => "Valor do Posto", "url" => APP_URL . "/cadastro_valorPostoFiltro.php")); //SYSCB  
    // }
    if (in_array('BENEFICIOPROJETO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['cadastro']['sub'] += array("beneficioProjeto" => array("title" => "Vínculos e Benefícios", "url" => APP_URL . "/cadastro_beneficioPessoalPorProjetoFiltro.php")); //SYSCB 
    }
}

// OPERAÇÔES // A pedido do Márcio no dia 08/01/2020 foi pedido para colocar todos os módulos dentro de operação.
// if ($condicaoOperacaoOk) {
//     $page_nav['operacao'] = array("title" => "Operações", "icon" => "fa fa-wrench");
//     $page_nav['operacao']['sub'] = array();

$condicaoBeneficioOk = (in_array('BENEFICIO_ACESSAR', $arrayPermissao, true));
if ($condicaoBeneficioOk) {

    $page_nav['beneficio'] = array("title" => "Departamento Pessoal", "icon" => "fa fa-folder-open");
    $page_nav['beneficio']['sub'] = array();

    if (in_array('BENEFICIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['beneficio']['sub']['tabela'] = array("title" => "Tabelas");
        $page_nav['beneficio']['sub']['tabela']['sub'] = array();

        if (in_array('BENEFICIOINDIRETO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['tabela']['sub'] += array("beneficioIndireto" => array("title" => "Benefício Indireto", "url" => APP_URL . "/tabelaBasica_beneficioIndiretoFiltro.php")); //SYSCB 
        }

        if (in_array('DEPARTAMENTO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['tabela']['sub'] += array("departamento" => array("title" => "Departamento", "url" => APP_URL . "/tabelaBasica_departamentoFiltro.php")); //SYSGEF
        }

        if (in_array('MOTIVOAFASTAMENTO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['tabela']['sub'] += array("motivoAfastamento" => array("title" => "Motivo do Afastamento", "url" => APP_URL . "/tabelaBasica_motivoAfastamentoFiltro.php")); //SYSCB
        }
    }

    if (in_array('BENEFICIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['beneficio']['sub']['cadastro'] = array("title" => "Cadastros");
        $page_nav['beneficio']['sub']['cadastro']['sub'] = array();

        if (in_array('CONVENIOSAUDE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['cadastro']['sub'] += array("convenioSaude" => array("title" => "Convênio de Saúde", "url" => APP_URL . "/cadastro_convenioSaudeFiltro.php"));
        }
   

        if (in_array('PRODUTO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['cadastro']['sub'] += array("produto" => array("title" => "Produto", "url" => APP_URL . "/cadastro_produtoFiltro.php")); //SYSCB
        }

        if (in_array('VALETRANSPORTEUNITARIO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['cadastro']['sub'] += array("valeTransporteUnitario" => array("title" => "Vale Transporte Unitário", "url" => APP_URL . "/cadastro_valeTransporteUnitarioFiltro.php"));
        }
        if (in_array('VALETRANSPORTEMODAL_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['cadastro']['sub'] += array("valeTransporteModal" => array("title" => "Vale Transporte Modal", "url" => APP_URL . "/cadastro_valeTransporteModalFiltro.php")); //SYSCB
        }
    }

    if (in_array('BENEFICIO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['beneficio']['sub']['operacao'] = array("title" => "Operações");
        $page_nav['beneficio']['sub']['operacao']['sub'] = array();
        
        if (in_array('AFASTAMENTOFUNCIONARIO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['operacao']['sub'] += array("afastamentoFuncionario" => array("title" => "Afastamento do Funcionário", "url" => APP_URL . "/beneficio_afastamentoFuncionarioFiltro.php")); //SYSCB 
        }
    
        // if (in_array('CONSULTABENEFICIO_ACESSAR', $arrayPermissao, true)) {
        //     $page_nav['beneficio']['sub'] += array("consultaBenefício" => array("title" => "Consulta Benefício", "url" => APP_URL . "/beneficio_afastamentoFuncionarioFiltro.php"));
        // }
        if (in_array('FERIAS_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['operacao']['sub'] += array("ferias" => array("title" => "Férias", "url" => APP_URL . "/beneficio_feriasFiltro.php")); //SYSCB 
        }
        if (in_array('FECHAMENTOMES_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['operacao']['sub'] += array("fechamentoMes" => array("title" => "Fechamento do Mês", "url" => APP_URL . "/beneficio_fechamentoMesFiltro.php"));
        }
        if (in_array('FOLHAPONTO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['operacao']['sub'] += array("folhaPonto" => array("title" => "Folha de Ponto", "url" => APP_URL . "/beneficio_folhaPontoFiltro.php"));
        }
        if (in_array('PROCESSABENEFICIO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['beneficio']['sub']['operacao']['sub'] += array("processaBeneficio" => array("title" => "Processa Benefício", "url" => APP_URL . "/beneficio_processaBeneficioFiltro.php"));
        }
    }
}

$condicaoRHOk = (in_array('CONTRATACAO_ACESSAR', $arrayPermissao, true));
$condicaoContratacaoOk = false;
if ($condicaoRHOk) {
    $page_nav['recursoshumanos'] = array("title" => "Recursos Humanos", "icon" => "fa fa-fax");
    $page_nav['recursoshumanos']['sub'] = array();
    $condicaoContratacaoOk = true;

    if ($condicaoContratacaoOk) { // a pedido do marcio no dia 18/02/21 foi pedido para colocar tudo referente a contratacao dentro de rh em um "novo modulo"
        $page_nav['recursoshumanos']['sub']['tabela'] = array("title" => "Tabelas");
        $page_nav['recursoshumanos']['sub']['tabela']['sub'] = array();

        if (in_array('BANCO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['recursoshumanos']['sub']['tabela']['sub'] += array("banco" => array("title" => "Banco", "url" => APP_URL . "/tabelaBasica_bancoFiltro.php")); //SYSCC   
        }
    }

    if ($condicaoContratacaoOk) { // a pedido do marcio no dia 18/02/21 foi pedido para colocar tudo referente a contratacao dentro de rh em um "novo modulo"
        $page_nav['recursoshumanos']['sub']['contratacao'] = array("title" => "Contratação", "icon" => "fa fa-fax");
        $page_nav['recursoshumanos']['sub']['contratacao']['sub'] = array();
       
        if (in_array('CANDIDATO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['recursoshumanos']['sub']['contratacao']['sub'] += array("candidato" => array("title" => "Triagem", "url" => APP_URL . "/contratacao_candidatoFiltro.php"));
        }
        if (in_array('GESTOR_ACESSAR', $arrayPermissao, true)) {
            $page_nav['recursoshumanos']['sub']['contratacao']['sub'] += array("gestor" => array("title" => "Gestor", "url" => APP_URL . "/contratacao_gestorFiltro.php"));
        }

        if (in_array('CONTRATACAORH_ACESSAR', $arrayPermissao, true)) {
            $page_nav['recursoshumanos']['sub']['contratacao']['sub'] += array("rh" => array("title" => "RH", "url" => APP_URL . "/contratacao_rhFiltro.php"));
        }

        if (in_array('EXPORTACAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['recursoshumanos']['sub']['contratacao']['sub'] += array("exportacao" => array("title" => "Exportação", "url" => APP_URL . "/contratacao_exportacaoFiltro.php"));
        }
    }
} else if ($tipoUsuario == 'T') {
    $page_nav['candidato'] = array("title" => "Contratação", "icon" => "fa fa-folder-open");
    $page_nav['candidato']['sub'] = array();
    $page_nav['candidato']['sub'] += array("candidato" => array("title" => "Candidato", "url" => APP_URL . "/contratacao_candidatoCadastro.php?=" . $candidato));
}

if ($condicaoFaturamentoOk) {
    $page_nav['faturamento'] = array("title" => "Faturamento", "icon" => "fa fa-dollar");
    $page_nav['faturamento']['sub'] = array();

    if (in_array('CONTRATO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['faturamento']['sub']['tabela'] = array("title" => "Tabelas");
        $page_nav['faturamento']['sub']['tabela']['sub'] = array();

        if (in_array('BDI_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("bdi" => array("title" => "BDI", "url" => APP_URL . "/tabelaBasica_bdiFiltro.php"));
        }

        if (in_array('CAUCAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("caucao" => array("title" => "Caução", "url" => APP_URL . "/tabelaBasica_caucaoFiltro.php")); //SYSGEF
        }

        if (in_array('CLASSE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("classe" => array("title" => "Classe", "url" => APP_URL . "/tabelaBasica_classeFiltro.php")); //SYSGEF
        }

        if (in_array('ENCARGO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("encargo" => array("title" => "Encargo", "url" => APP_URL . "/tabelaBasica_encargoFiltro.php"));
        }

        if (in_array('FUNCAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("funcao" => array("title" => "Função", "url" => APP_URL . "/tabelaBasica_funcaoFiltro.php"));
        }

        if (in_array('INSUMO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("insumo" => array("title" => "Insumo", "url" => APP_URL . "/tabelaBasica_insumoFiltro.php"));
        }

        if (in_array('INDICEREAJUSTE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("indiceReajuste" => array("title" => "Índice de Reajuste", "url" => APP_URL . "/tabelaBasica_indiceReajusteFiltro.php")); //SYSGEF  
        }

        if (in_array('INICIOREAJUSTE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("inicioReajuste" => array("title" => "Ínicio de Reajuste", "url" => APP_URL . "/tabelaBasica_inicioReajusteFiltro.php")); //SYSGEF
        }

        if (in_array('PERIODORENOVACAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("periodoRenovacao" => array("title" => "Período de Renovação", "url" => APP_URL . "/tabelaBasica_periodoRenovacaoFiltro.php")); //SYSGEF
        }

        if (in_array('PERIODOVIGENCIA_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("periodoVigencia" => array("title" => "Período de Vigência", "url" => APP_URL . "/tabelaBasica_periodoVigenciaFiltro.php")); //SYSGEF
        }

        if (in_array('POSTO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("posto" => array("title" => "Posto", "url" => APP_URL . "/tabelaBasica_postoFiltro.php"));
        }

        if (in_array('REMUNERACAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("remuneracao" => array("title" => "Remuneração", "url" => APP_URL . "/tabelaBasica_remuneracaoFiltro.php"));
        }

        //SUBMENU RETENÇÃO CONTA VINCULADA - SYSGEF
        if (in_array('RETENCAOCONTAVINCULADA_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub']['retencaoContaVinculada'] = array("title" => "Retenção Conta Vinculada");
            $page_nav['faturamento']['sub']['tabela']['sub']['retencaoContaVinculada']['sub'] = array();

            if (in_array('DECIMOTERCEIRO_ACESSAR', $arrayPermissao, true)) {
                $page_nav['faturamento']['sub']['tabela']['sub']['retencaoContaVinculada']['sub'] += array("decimoTerceiro" => array("title" => "13º Salário", "url" => APP_URL . "/tabelaBasica_decimoTerceiroFiltro.php"));
            }
            if (in_array('FERIASTERCOCONSTITUCIONAL_ACESSAR', $arrayPermissao, true)) {
                $page_nav['faturamento']['sub']['tabela']['sub']['retencaoContaVinculada']['sub'] += array("feriasTercoConstitucional" => array("title" => "Férias e Terço Constitucional", "url" => APP_URL . "/tabelaBasica_feriasTercoConstitucionalFiltro.php"));
            }
            if (in_array('MULTAFGTS_ACESSAR', $arrayPermissao, true)) {
                $page_nav['faturamento']['sub']['tabela']['sub']['retencaoContaVinculada']['sub'] += array("multaFGTS" => array("title" => "Multa FGTS por Dispensa sem Justa Causa", "url" => APP_URL . "/tabelaBasica_multaFgtsFiltro.php"));
            }
        }

        //SUBMENU RETENÇÃO TRIBUTÁRIA - SYSGEF
        if (in_array('RETENCAOTRIBUTARIA_ACESSAR', $arrayPermissao, true)) {

            $page_nav['faturamento']['sub']['tabela']['sub']['retencaoTributaria'] = array("title" => "Retenção Tributária");
            $page_nav['faturamento']['sub']['tabela']['sub']['retencaoTributaria']['sub'] = array();

            if (in_array('ISS_ACESSAR', $arrayPermissao, true)) {
                $page_nav['faturamento']['sub']['tabela']['sub']['retencaoTributaria']['sub'] += array("iss" => array("title" => "ISS", "url" => APP_URL . "/tabelaBasica_issFiltro.php"));
            }
            if (in_array('INSS_ACESSAR', $arrayPermissao, true)) {
                $page_nav['faturamento']['sub']['tabela']['sub']['retencaoTributaria']['sub'] += array("inss" => array("title" => "INSS", "url" => APP_URL . "/tabelaBasica_inssFiltro.php"));
            }
            if (in_array('IR_ACESSAR', $arrayPermissao, true)) {
                $page_nav['faturamento']['sub']['tabela']['sub']['retencaoTributaria']['sub'] += array("ir" => array("title" => "IR", "url" => APP_URL . "/tabelaBasica_irFiltro.php"));
            }
            if (in_array('PISCONFISCS_ACESSAR', $arrayPermissao, true)) {
                $page_nav['faturamento']['sub']['tabela']['sub']['retencaoTributaria']['sub'] += array("pisConfisCs" => array("title" => "PIS, CONFIS, CS", "url" => APP_URL . "/tabelaBasica_pisConfisCsFiltro.php"));
            }
        }

        if (in_array('SERVICO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['tabela']['sub'] += array("servico" => array("title" => "Serviço", "url" => APP_URL . "/tabelaBasica_servicoFiltro.php")); //SYSGEF 
        }
    }

    if (in_array('CONTRATO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['faturamento']['sub']['cadastro'] = array("title" => "Cadastro");
        $page_nav['faturamento']['sub']['cadastro']['sub'] = array();

        if (in_array('CONTRATO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['cadastro']['sub'] += array("contrato" => array("title" => "Contrato", "url" => APP_URL . "/cadastro_contratoFiltro.php"));
        }

        if (in_array('VALORPOSTO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['faturamento']['sub']['cadastro']['sub'] += array("projetoPosto" => array("title" => "Valor Posto", "url" => APP_URL . "/Faturamento_valorPostoFiltro.php"));
        }
    }


    // if (in_array('FATURAMENTOMENULATERAL_ACESSAR', $arrayPermissao, true)) {
    //     $page_nav['faturamento']['sub'] += array("percentualPostoEncargo" => array("title" => "Percentual Posto Encargo", "url" => APP_URL . "/tabelaBasica_percentualCargoEncargoFiltro.php"));
    // }

}

// LICITAÇÕES - SYSGC
if ($condicaoLicitacaoOk) {
    $page_nav['licitacao'] = array("title" => "Licitação", "icon" => "fa fa-line-chart");
    $page_nav['licitacao']['sub'] = array();

    if (in_array('PREGAO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['licitacao']['sub']['tabela'] = array("title" => "Tabelas");
        $page_nav['licitacao']['sub']['tabela']['sub'] = array();

        if (in_array('PORTAL_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['tabela']['sub'] += array("portal" => array("title" => "Portal", "url" => APP_URL . "/tabelaBasica_portalFiltro.php")); //SYSGC 
        }

        if (in_array('SITUACAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['tabela']['sub'] += array("situacao" => array("title" => "Situação", "url" => APP_URL . "/tabelaBasica_situacaoFiltro.php")); //SYSGC 
        }
        if (in_array('TAREFA_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['tabela']['sub'] += array("tarefa" => array("title" => "Tarefa", "url" => APP_URL . "/tabelaBasica_tarefaFiltro.php")); //SYSGC    
        }

        if (in_array('RESPONSAVEL_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['tabela']['sub'] += array("responsavel" => array("title" => "Responsável", "url" => APP_URL . "/tabelaBasica_responsavelFiltro.php")); //SYSGC 
        }
    }

    if (in_array('PREGAO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['licitacao']['sub']['cadastro'] = array("title" => "Cadastro");
        $page_nav['licitacao']['sub']['cadastro']['sub'] = array();

        if (in_array('PREGAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['cadastro']['sub'] += array("pregao" => array("title" => "Pregão", "url" => APP_URL . "/cadastro_pregaoFiltro.php"));
        }
    }

    if (in_array('PREGAO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['licitacao']['sub']['operacao'] = array("title" => "Operações");
        $page_nav['licitacao']['sub']['operacao']['sub'] = array();

        if (in_array('PARTICIPARPREGAO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['operacao']['sub'] += array("participarPregao" => array("title" => "Participar Pregões", "url" => APP_URL . "/licitacao_participarPregaoFiltro.php"));
        }

        if (in_array('PREGAONAOINICIADO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['operacao']['sub'] += array("pregoesNaoIniciados" => array("title" => "Pregões Não Iniciados", "url" => APP_URL . "/licitacao_pregaoNaoIniciadoFiltro.php"));
        }

        if (in_array('PREGAOEMANDAMENTO_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['operacao']['sub'] += array("pregoesEmAndamento" => array("title" => "Pregões Em Andamento", "url" => APP_URL . "/licitacao_pregaoEmAndamentoFiltro.php"));
        }

        if (in_array('RELATORIOTAREFA_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['operacao']['sub'] += array("pregoesExtraProcesso" => array("title" => "Pregões Extra Processo", "url" => APP_URL . "/licitacao_pregaoExtraProcessoFiltro.php"));
        }

        if (in_array('RELATORIOTAREFA_ACESSAR', $arrayPermissao, true)) {
            $page_nav['licitacao']['sub']['operacao']['sub'] += array("relatorioTarefas" => array("title" => "Relatório de Tarefas", "url" => APP_URL . "/licitacao_relatorioTarefaFiltro.php"));
        }
    }
}
// Mensageria // a pedido do guinancio 24/02/21 colocar servico externo no nome
$condicaoMensageriaOk = true;
if ($condicaoMensageriaOk) {
    $page_nav['mensageria'] = array("title" => "Serviço Externo", "icon" => "fa fa-envelope-open-o ");
    $page_nav['mensageria']['sub'] = array();
    if (in_array('SOLICITACAO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['mensageria']['sub'] += array("solicitacao" => array("title" => "Solicitação", "url" => APP_URL . "/mensageria_solicitacaoCadastro.php"));
    }
    if (in_array('SOLICITACAO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['mensageria']['sub'] += array("solicitacaoEmAndamento" => array("title" => "Solicitação Em Andamento", "url" => APP_URL . "/mensageria_solicitacaoEmAndamentoFiltro.php"));
    }
}

$condicaoFuncionarioOk = true;
if ($condicaoFuncionarioOk) {
    $page_nav['funcionario'] = array("title" => "Área do Funcionário", "icon" => "fa fa-user");
    $page_nav['funcionario']['sub'] = array();
    if (in_array('FOLHAPONTOMENSAL_ACESSAR', $arrayPermissao, true)) {
        $page_nav['funcionario']['sub'] += array("contraChequeWeb" => array("title" => "Contra Cheque Web", "url" => "http://www.contrachequeweb.com.br/ntl/"));
    }
    if (in_array('FOLHAPONTOMENSAL_ACESSAR', $arrayPermissao, true)) {
        $page_nav['funcionario']['sub'] += array("emitirFolhaPonto" => array("title" => "Folha Mensal", "url" => APP_URL . "/funcionario_folhaDePontoPdf.php?id=" . $funcionario . "&pag=0"));
    }
    if (array_intersect(array('PONTOELETRONICOMENSALLEVE_ACESSAR', 'PONTOELETRONICOMENSALNORMAL_ACESSAR', 'PONTOELETRONICOMENSALPESADA_ACESSAR'), $arrayPermissao)) {
        $page_nav['funcionario']['sub'] += array("controlePonto" => array("title" => "Ponto Eletrônico Mensal", "url" => APP_URL . "/funcionario_folhaPontoMensalCadastro.php"));
    }
    if (in_array('GERADORFOLHAPONTO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['funcionario']['sub'] += array("geradorFolha" => array("title" => "Gerador Folha de Ponto", "url" => APP_URL . "/funcionario_gerandoFolhaDePonto.php"));
    }
    if (in_array('FOLHAPONTOPROJETO_ACESSAR', $arrayPermissao, true)) {
        $page_nav['funcionario']['sub'] += array("emitirFolhaPorProjeto" => array("title" => "Gerador Folha de Ponto por Projeto", "url" => APP_URL . "/funcionario_folhaDePontoPorProjeto.php"));
    }
}


$condicaoEstoqueOk = (in_array('ESTOQUE_ACESSAR', $arrayPermissao, true));
if ($condicaoEstoqueOk) {
    $page_nav['estoque'] = array("title" => "Estoque", "icon" => "fa fa-cubes");
    $page_nav['estoque']['sub'] = array();
    $condicaoContratacaoOk = true;
    if (in_array('ESTOQUE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['estoque']['sub']['tabela'] = array("title" => "Tabelas");
        $page_nav['estoque']['sub']['tabela']['sub'] = array();

        if (in_array('TIPOITEM_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['tabela']['sub'] += array("tipoItem" => array("title" => "Tipo Item", "url" => APP_URL . "/tabelaBasica_tipoItemFiltro.php"));
        }

        if (in_array('FABRICANTE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['tabela']['sub'] += array("fabricante" => array("title" => "Fabricante", "url" => APP_URL . "/tabelaBasica_fabricanteFiltro.php"));
        }

        if (in_array('LOCALIZACAOITEM_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['tabela']['sub'] += array("localizacaoItem" => array("title" => "Localização do Item", "url" => APP_URL . "/tabelaBasica_localizacaoItemFiltro.php"));
        }

        if (in_array('UNIDADE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['tabela']['sub'] += array("unidade" => array("title" => "Unidade", "url" => APP_URL . "/tabelaBasica_unidadeFiltro.php")); //SYSGC 
        }

        if (in_array('UNIDADEITEM_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['tabela']['sub'] += array("unidadeItem" => array("title" => "Unidade do item", "url" => APP_URL . "/tabelaBasica_unidadeItemFiltro.php"));
        }
    }

    if (in_array('ESTOQUE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['estoque']['sub']['cadastro'] = array("title" => "Cadastros");
        $page_nav['estoque']['sub']['cadastro']['sub'] = array();

        if (in_array('CODIGOITEM_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['cadastro']['sub'] += array("codigoItem" => array("title" => "Código Item", "url" => APP_URL . "/cadastro_codigoItemFiltro.php")); //SYSCB   
        }

        if (in_array('ESTOQUE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['cadastro']['sub'] += array("estoque" => array("title" => "Estoque", "url" => APP_URL . "/tabelaBasica_estoqueFiltro.php")); //SYSGC 
        }

        if (in_array('GRUPOITEM_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['cadastro']['sub'] += array("grupoItem" => array("title" => "Grupo de item", "url" => APP_URL . "/tabelaBasica_grupoItemFiltro.php")); //SYSGC 
        }
    }

    if (in_array('ESTOQUE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['estoque']['sub']['operacao'] = array("title" => "Operações");
        $page_nav['estoque']['sub']['operacao']['sub'] = array();

        if (in_array('ENTRADAITEM_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['operacao']['sub'] += array("entradaItem" => array("title" => "Entrada Item", "url" => APP_URL . "/estoque_entradaMaterialFiltro.php"));
        }
        if (in_array('PEDIDOMATERIAL_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['operacao']['sub'] += array("pedidoMaterial" => array("title" => "Pedido Material", "url" => APP_URL . "/estoque_pedidoMaterialCadastro.php"));
        }
        if (in_array('FORNECIMENTOMATERIAL_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['operacao']['sub'] += array("fornecimentoMaterial" => array("title" => "Fornecimento Material", "url" => APP_URL . "/estoque_fornecimentoMaterialFiltro.php"));
        }

    }

    if (in_array('ESTOQUE_ACESSAR', $arrayPermissao, true)) {
        $page_nav['estoque']['sub']['relatorio'] = array("title" => "Relatórios");
        $page_nav['estoque']['sub']['relatorio']['sub'] = array();

        if (in_array('ESTOQUE_ACESSAR', $arrayPermissao, true)) {
            $page_nav['estoque']['sub']['relatorio']['sub'] += array("consultaFornecedor" => array("title" => "Consulta Fornecedor", "url" => APP_URL . "/estoque_consultaFornecedorFiltro.php"));
        }
    }
}
// }

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
