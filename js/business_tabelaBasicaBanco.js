function gravaBanco(banco, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaBanco.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaBanco', banco: banco },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaBanco(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaBanco.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaBanco', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function excluirBanco(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaBanco.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirBanco', id: id },
        success: function (data) {
            callback(data);
        }
    });
}

