function gravaResponsavel(codigo, nome, telefone, ativo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaResponsavel.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", 
        codigo:codigo, 
        nome:nome, 
        telefone:telefone,
        ativo:ativo},   
        success: function (data) {
        callback(data);
        } 
    }); 
}

function recuperaResponsavel(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaResponsavel.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', codigo: codigo}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function excluirResponsavel(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaResponsavel.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', codigo: codigo}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}