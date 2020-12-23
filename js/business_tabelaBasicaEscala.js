function gravaEscala(codigo, descricao, codigoSCI, ativo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaEscala.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", codigo:codigo, 
        descricao:descricao, 
        codigoSCI:codigoSCI, 
        ativo:ativo},   
        success: function (data) {
        callback(data);
        } 
    }); 
}

function recuperaEscala(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaEscala.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', codigo: codigo}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    }); 
    return;
}

function excluirEscala(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaEscala.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', codigo: codigo}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}