function gravaValorPosto(valorPosto, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaValorPosto', valorPosto: valorPosto },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaValorPosto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaValorPosto', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function excluirValorPosto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirValorPosto', id: id },
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaDadosBdi(bdi, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosBdi', bdi: bdi }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function recuperaDadosEncargo(encargo, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosEncargo', encargo: encargo }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function recuperaDadosInsumo(insumo, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosInsumo', insumo: insumo }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function recuperaTipoRemuneracao(remuneracao, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarTipoRemuneracao', remuneracao: remuneracao }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function fechaValorPosto(projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'fecharValorPosto', projeto: projeto }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });
    return;
}

function validaPostoProjeto(projeto,posto, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'validarPostoProjeto', projeto: projeto, posto: posto}, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });
    return;
}