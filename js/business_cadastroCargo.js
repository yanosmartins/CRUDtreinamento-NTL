function gravaCargo(id, ativo, descricao, cboNumero, cboDescricao, codigoCargoSCI, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCargo.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "grava", id: id, ativo: ativo, descricao: descricao, cboNumero: cboNumero, cboDescricao: cboDescricao, codigoCargoSCI: codigoCargoSCI }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaCargo(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCargo.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function excluirCargo(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCargo.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}
function verificaDescricao(descricao, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCargo.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaDescricao', descricao: descricao }, //valores enviados ao script
        async: true,
        success: function (data) {
            callback(data);
        }
    });
}

