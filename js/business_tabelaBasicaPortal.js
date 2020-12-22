function gravaPortal(codigo, descricao, endereco, ativo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaPortal.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", codigo:codigo, 
        descricao:descricao, endereco:endereco, ativo:ativo},   
        success: function (data) {
        callback(data);
        } 
    }); 
}

function recuperaPortal(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaPortal.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', codigo: codigo}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    }); 
    return;
}

function excluirPortal(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaPortal.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', codigo: codigo}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}