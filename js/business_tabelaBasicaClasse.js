function gravaClasse(classe, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaClasse.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaClasse', classe: classe },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaClasse(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaClasse.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaClasse', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function excluirClasse(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaClasse.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirClasse', id: id },
        success: function (data) {
            callback(data);
        }
    });
}

