function gravaSituacao(id, ativo, descricao, corFonte, corFundo, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaSituacao.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "grava", id: id, ativo: ativo, descricao: descricao, corFonte: corFonte, corFundo: corFundo },
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaSituacao(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaSItuacao.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

function excluirSituacao(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaSituacao.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}
