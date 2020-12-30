function gravaDiasUteisPorMunicipio(id, ativo, unidadeFederacao, municipio, cidade, qtdDiasJaneiro, qtdDiasFevereiro, qtdDiasMarco,
    qtdDiasAbril, qtdDiasMaio, qtdDiasJunho, qtdDiasJulho, qtdDiasAgosto, qtdDiasSetembro, qtdDiasOutubro, qtdDiasNovembro, qtdDiasDezembro, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroDiasUteisPorMunicipio.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "grava", id: id, ativo: ativo, unidadeFederacao: unidadeFederacao, municipio: municipio, cidade: cidade, qtdDiasJaneiro: qtdDiasJaneiro, qtdDiasFevereiro: qtdDiasFevereiro,
            qtdDiasMarco: qtdDiasMarco, qtdDiasAbril: qtdDiasAbril, qtdDiasMaio: qtdDiasMaio, qtdDiasJunho: qtdDiasJunho, qtdDiasJulho: qtdDiasJulho, qtdDiasAgosto: qtdDiasAgosto,
            qtdDiasSetembro: qtdDiasSetembro, qtdDiasOutubro: qtdDiasOutubro, qtdDiasNovembro: qtdDiasNovembro, qtdDiasDezembro: qtdDiasDezembro
        },
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaDiasUteisPorMunicipio(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroDiasUteisPorMunicipio.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

function excluirDiasUteisPorMunicipio(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroDiasUteisPorMunicipio.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function populaComboMunicipio(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroDiasUteisPorMunicipio.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'listaComboMunicipio', codigo: codigo }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }
    });
}