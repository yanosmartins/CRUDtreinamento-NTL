function gravaIss(codigo,percentual,ativo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaIss.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'grava', codigo: codigo, percentual:percentual, ativo:ativo },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaIss(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaIss.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function excluirIss(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaIss.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id },
        success: function (data) {
            callback(data);
        }
    });
}

