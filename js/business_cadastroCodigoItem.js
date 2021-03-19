
function gravaCodigoItem(id, codigoItem, codigoFabricante, descricaoItem, estoque, grupoItem, localizacaoItem, ativo, 
                        unidade, indicador, unidadeItem, consumivel, autorizacao,callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCodigoItem.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "grava", id: id, codigoItem: codigoItem, codigoFabricante: codigoFabricante, 
            descricaoItem: descricaoItem, estoque: estoque, grupoItem: grupoItem, localizacaoItem: localizacaoItem, 
            ativo: ativo, unidade: unidade, indicador: indicador, unidadeItem:unidadeItem, consumivel:consumivel, autorizacao:autorizacao
        },
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaCodigoItem(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCodigoItem.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

function excluirCodigoItem(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCodigoItem.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function populaComboGrupoItem(estoque, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCodigoItem.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaComboGrupoItem', estoque: estoque }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function populaComboEstoque(unidade, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroCodigoItem.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaComboEstoque', unidade: unidade }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }
    });

    return;
}