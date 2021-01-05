function gravaProduto(id, ativo, convenioSaude, produto, mesAniversario, cobranca, seguroDeVida,
    valorProduto, descontoFolha, jsonIdade, valorDescontoFolha, callback) {
    $.ajax({

        url: 'js/sqlscope_cadastroProduto.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "grava", id: id, ativo: ativo, convenioSaude: convenioSaude, produto: produto, mesAniversario: mesAniversario,
            cobranca: cobranca, seguroDeVida: seguroDeVida, valorProduto: valorProduto, descontoFolha: descontoFolha, jsonIdade: jsonIdade
            , valorDescontoFolha: valorDescontoFolha
        }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaProduto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroProduto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script     

        success: function (data) {

            callback(data);
        }

    });

    return;
}

function excluirProduto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroProduto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     

        success: function (data) {
            callback(data);
        }

    });
}



