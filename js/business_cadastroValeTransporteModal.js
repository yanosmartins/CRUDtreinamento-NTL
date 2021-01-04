function gravaValeTransporteModal(id, ativo, descricao, valorTotal, jsonValeTransporteModal, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroValeTransporteModal.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "grava", id: id, ativo: ativo, descricao: descricao, valorTotal: valorTotal, jsonValeTransporteModal: jsonValeTransporteModal
        },
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaValeTransporteModal(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroValeTransporteModal.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

function recuperaValorTransporteUnitario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroValeTransporteModal.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaValeTransporteUnitario', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

function excluirValeTransporte(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroValeTransporteModal.php', //caminho do arquivo a ser executado
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
        url: 'js/sqlscope_cadastroValeTransporteModal.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaDescricao', descricao: descricao }, //valores enviados ao script
        async: true,
        success: function (data) {
            callback(data);
        }
    });
}