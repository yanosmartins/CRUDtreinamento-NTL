function gravaFornecedor(id, ativo, descricao, cnpj, unidadeFederacao, municipio, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFornecedor.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, ativo:ativo, cnpj:cnpj, descricao:descricao, unidadeFederacao:unidadeFederacao, municipio:municipio}, //valores enviados ao script     
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

function populaComboMunicipio(codigo, callback){
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaDiasUteisPorMunicipio.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'listaComboMunicipio', codigo: codigo}, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}
