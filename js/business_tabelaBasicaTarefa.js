function gravaTarefa(tarefa, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaTarefa.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaTarefa', tarefa: tarefa },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaTarefa(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaTarefa.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaTarefa', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function excluirTarefa(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaTarefa.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirTarefa', id: id },
        success: function (data) {
            callback(data);
        }
    });
}

