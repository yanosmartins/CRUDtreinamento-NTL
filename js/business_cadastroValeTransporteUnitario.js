function gravaValeTransporteUnitario(id, ativo, unidadeFederacao, descricao, valorUnitario, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaValeTransporteUnitario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, ativo:ativo, unidadeFederacao:unidadeFederacao, descricao:descricao, valorUnitario:valorUnitario},   
        success: function (data) {
        callback(data);
        } 
    }); 
}
 

function recuperaValeTransporteUnitario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaValeTransporteUnitario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function excluirValeTransporteUnitario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaValeTransporteUnitario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}

function verificaDescricao(descricao, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaValeTransporteUnitario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'verificaDescricao', descricao: descricao}, //valores enviados ao script
        async: true,     
        success: function (data) {
            callback(data);
        }
    });
}