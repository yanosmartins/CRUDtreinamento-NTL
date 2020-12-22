function gravaMotivoAfastamento(id, ativo, descricao,callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaMotivoAfastamento.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, ativo:ativo, descricao:descricao}, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaMotivoAfastamento(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaMotivoAfastamento.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script     
              
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function  excluirMotivoAfastamento(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaMotivoAfastamento.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script     
      
        success: function (data) {
            callback(data); 
        }
    });
}

