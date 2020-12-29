function gravaFeriado(id, ativo, descricao, data, tipoFeriado, unidadeFederacao, municipio, diaDaSemana, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFeriado.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "grava", id: id, ativo: ativo, descricao: descricao, data: data,
            tipoFeriado: tipoFeriado, unidadeFederacao: unidadeFederacao, municipio: municipio,
            diaDaSemana: diaDaSemana
        }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaFeriado(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFeriado.php', //caminho do arquivo a ser executado
        dataType: 'json', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script     

        success: function (data) {
            callback(data);
        }

    });

    return;
}

function excluirFeriado(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFeriado.php', //caminho do arquivo a ser executado
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
        url: 'js/sqlscope_tabelaBasicaFeriado.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'popularComboMunicipio', codigo: codigo }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function pesquisaData(dataFeriado, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroFeriado.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'pesquisaData', dataFeriado: dataFeriado }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}