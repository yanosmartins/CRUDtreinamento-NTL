function gravaPosto(posto, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaPosto.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaPosto', posto: posto },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaPosto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaPosto', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function excluirPosto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirPosto', id: id },
        success: function (data) {
            callback(data);
        }
    });
}

