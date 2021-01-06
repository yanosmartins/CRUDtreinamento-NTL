
function gravaFerias(id, abono, funcionario, mesAno, dataInicio, dataFim, quantidadeDias, adiantaDecimoTerceiro, mesAnoInicio, mesAnoFim, diaUtil, projeto, diaFeriado, callback) {
    $.ajax({
        url: 'sqlscope_beneficioFerias.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "grava", id: id, abono: abono, funcionario: funcionario,
            mesAno: mesAno, dataInicio: dataInicio, dataFim: dataFim, quantidadeDias: quantidadeDias,
            adiantaDecimoTerceiro: adiantaDecimoTerceiro, mesAnoInicio: mesAnoInicio, mesAnoFim: mesAnoFim, diaUtil: diaUtil, projeto: projeto, diaFeriado: diaFeriado
        },
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaFerias(id, callback) {
    $.ajax({
        url: 'sqlscope_beneficioFerias.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

function excluirFerias(id, callback) {
    $.ajax({
        url: 'sqlscope_beneficioFerias.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function contaFeriado(funcionario, mesAno, dataInicio, dataFim, quantidadeDias, adiantaDecimoTerceiro, mesAnoInicio, mesAnoFim, diaUtil, callback) {
    $.ajax({
        url: 'sqlscope_beneficioFerias.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "contaFeriado", funcionario: funcionario,
            mesAno: mesAno, dataInicio: dataInicio, dataFim: dataFim, quantidadeDias: quantidadeDias,
            adiantaDecimoTerceiro: adiantaDecimoTerceiro, mesAnoInicio: mesAnoInicio, mesAnoFim: mesAnoFim, diaUtil: diaUtil
        },
        success: function (data) {
            callback(data);
        }
    });
}

function populaComboFuncionario(projeto, callback) {
    $.ajax({
        url: 'sqlscope_beneficioFerias.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaComboFuncionario', projeto: projeto }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}