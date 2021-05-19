 function gravaFuncionario(id, nome, sindicato, cargo, cpf, matricula, sexo, dataNascimento, dataAdmissaoFuncionario, 
                dataDemissaoFuncionario, dataCancelamentoPlanoSaude, pisPasep, numeroCarteiraTrabalho, serieCarteiraTrabalho, ufCarteiraTrabalho,  
                dataExpedicaoCarteiraTrabalho, rg, dataEmissaoRG, orgaoEmissorRG, cnh, categoriaCNH, ufCNH, dataEmissaoCNH, 
                dataVencimentoCNH, primeiraHabilitacaoCNH, cep, logradouro, numeroLogradouro, complemento, 
                ufLogradouro, cidade, bairro, jsonTelefoneArray, jsonEmailArray, jsonDependenteArray, jsonEspecializacaoArray, ufIdentidade, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFuncionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, nome:nome, sindicato:sindicato, cargo:cargo, cpf:cpf, matricula:matricula,
            sexo:sexo, dataNascimento:dataNascimento, dataAdmissaoFuncionario: dataAdmissaoFuncionario,
            dataDemissaoFuncionario: dataDemissaoFuncionario, dataCancelamentoPlanoSaude: dataCancelamentoPlanoSaude, pisPasep:pisPasep, numeroCarteiraTrabalho:numeroCarteiraTrabalho,
            serieCarteiraTrabalho:serieCarteiraTrabalho, ufCarteiraTrabalho:ufCarteiraTrabalho, dataExpedicaoCarteiraTrabalho: dataExpedicaoCarteiraTrabalho, 
            rg:rg, dataEmissaoRG:dataEmissaoRG, orgaoEmissorRG:orgaoEmissorRG, cnh:cnh, categoriaCNH:categoriaCNH, ufCNH:ufCNH,
            dataEmissaoCNH:dataEmissaoCNH,dataVencimentoCNH:dataVencimentoCNH, primeiraHabilitacaoCNH:primeiraHabilitacaoCNH,
            cep:cep, logradouro:logradouro, numeroLogradouro:numeroLogradouro, 
            complemento:complemento,  ufLogradouro:ufLogradouro, cidade:cidade, bairro:bairro, jsonTelefoneArray:jsonTelefoneArray,
            jsonEmailArray:jsonEmailArray, jsonDependenteArray:jsonDependenteArray, jsonEspecializacaoArray:jsonEspecializacaoArray, ufIdentidade:ufIdentidade
        },   
        success: function (data) {
        callback(data);
        } 
    }); 
} 

function recuperaFuncionario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFuncionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function recuperaCep(cep, callback) {
    $.ajax({
        url: 'js/sqlscope.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recuperaCep', cep: cep}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}

function excluirFuncionario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFuncionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}