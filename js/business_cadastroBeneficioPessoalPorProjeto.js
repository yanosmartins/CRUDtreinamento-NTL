function gravaBeneficio(beneficio, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaBeneficio', beneficio: beneficio },
        beforeSend: desabilitaBotoes(),
        success: function(data) {
            callback(data);
        }
    });
}


function recuperaBeneficio(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaBeneficio', id: id }, //valores enviados ao script      
        success: function(data) {
            callback(data);
        }
    });

    return;
}

function excluirBeneficio(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirBeneficio', id: id }, //valores enviados ao script      
        success: function(data) {
            callback(data);
        }
    });

    return;
}

function recuperaValeTransporteModal(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaValeTransporteModal', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
    return;
}

function recuperaValeTransporteUnitario(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaValeTransporteUnitario', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
    return;
}

function populaComboVT(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'listaComboVT', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function populaComboProdutoPlanoSaude(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaComboProdutoPlanoSaude', codigo: codigo }, //valores enviados ao script     
        async: false,
        success: function(data) {
            callback(data);
        }
    });
}

function populaCobrancaPlanoSaude(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaCobrancaPlanoSaude', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function populaComboNomeDependentePlanoSaude(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaComboNomeDependentePlanoSaude', codigo: codigo }, //valores enviados ao script     
        async: false,
        success: function(data) {
            callback(data);
        }
    });
}

function idadeFuncionario(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'calculaIdadeFuncionario', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function idadeFuncionarioDependente(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'calculaIdadeDependente', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function descontoTipoDiaUtilSindicato(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'descontoTipoDiaUtilSindicato', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function valorProdutoPlanoSaude(codigo, idade, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorProdutoPlanoSaude', codigo: codigo, idade: idade }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function valorDescontoProjetoValeRefeicao(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorDescontoProjetoValeRefeicao', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function valorDescontoSindicatoValeRefeicao(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorDescontoSindicatoValeRefeicao', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function valorDescontoSindicatoPlanoSaude(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorDescontoSindicatoPlanoSaude', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function valorDescontoProjetoPlanoSaude(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorDescontoProjetoPlanoSaude', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function valorDescontoProdutoPlanoSaude(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorDescontoProdutoPlanoSaude', codigo: codigo }, //valores enviados ao script  
        async: false,   
        success: function(data) {
            callback(data);
        }
    });
}

function valorBolsaBeneficioSindicato(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorBolsaBeneficioSindicato', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function descricaoSindicato(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'descricaoSindicato', codigo: codigo }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}
function recuperaDescontoVR(codigo, projeto, sindicato, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaDescontoVR', codigo: codigo, projeto : projeto, sindicato:sindicato }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}
function recuperaDescontoVA(codigo, projeto, sindicato, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaDescontoVA', codigo: codigo, projeto : projeto, sindicato:sindicato }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}
function valorCestaBasicaSindicato(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'valorCestaBasicaSindicato', codigo: codigo}, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}
function verificaFuncionarioProjeto(funcionario, projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaFuncionarioProjeto', funcionario: funcionario, projeto: projeto}, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function habilitaBotoes() {
    $('#btnGravar').attr('disabled', true);
    $('#btnExcluir').attr('disabled', true);
}

function desabilitaBotoes() {
    $('#btnGravar').attr('disabled', false);
    $('#btnExcluir').attr('disabled', false);
}

function preencheValorPosto(posto, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'preencheValorPosto', posto: posto }, //valores enviados ao script     
        success: function(data) {
            callback(data);
        }
    });
}

function populaComboDescricaoPosto(projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroBeneficioPessoalPorProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaComboDescricaoPosto', projeto: projeto }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }
    });
    return;
}