function gravaFornecedor(id,cnpj,razaoSocial,apelido,ativo,logradouro,numero,complemento,bairro,cidade,uf,notaFiscal,cep,endereco,jsonTipoItemArray,jsonTelefoneArray,jsonEmailArray, callback) {
    $.ajax({    
        url: 'js/sqlscope_cadastroFornecedor.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id,cnpj:cnpj,razaoSocial:razaoSocial,apelido:apelido,ativo:ativo,logradouro:logradouro,numero:numero,complemento:complemento,bairro:bairro,cidade:cidade,uf:uf,notaFiscal:notaFiscal,cep:cep,endereco:endereco,jsonTipoItemArray:jsonTipoItemArray,jsonTelefoneArray:jsonTelefoneArray,jsonEmailArray:jsonEmailArray}, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaFornecedor(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFornecedor.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script     
              
        success: function (data) {
            callback(data); 
        }
            
    });

    return;
}

function  excluirFornecedor(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFornecedor.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script     
      
        success: function (data) {
            callback(data); 
        }
        
    });
}