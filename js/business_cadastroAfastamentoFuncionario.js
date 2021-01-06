
function gravaAfastamentoFuncionario(id, funcionario,mesAno, motivoAfastamento, dataInicio, dataFim,
    quantidadeDias, diaUtil,mesAnoInicio, mesAnoFim,descontarVAVR,descontarTransporte,descontarCestaBasica,justificativa,diaFeriado,projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroAfastamentoFuncionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, funcionario:funcionario,mesAno:mesAno, motivoAfastamento:motivoAfastamento, dataInicio:dataInicio, dataFim:dataFim,
        quantidadeDias:quantidadeDias, diaUtil:diaUtil,mesAnoInicio:mesAnoInicio, mesAnoFim:mesAnoFim,descontarVAVR:descontarVAVR,descontarTransporte:descontarTransporte,
        descontarCestaBasica:descontarCestaBasica,justificativa:justificativa,diaFeriado:diaFeriado,projeto:projeto
        },   
        success: function (data) {
        callback(data);
        } 
    }); 
} 


function recuperaAfastamentoFuncionario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroAfastamentoFuncionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
} 

function excluirAfastamento(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroAfastamentoFuncionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}

function contaFeriado(funcionario, mesAno, dataInicio, dataFim, quantidadeDias, adiantaDecimoTerceiro, mesAnoInicio, mesAnoFim,diaUtil, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroAfastamentoFuncionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "contaFeriado",funcionario:funcionario, 
              mesAno:mesAno, dataInicio:dataInicio, dataFim:dataFim, quantidadeDias:quantidadeDias,
              adiantaDecimoTerceiro: adiantaDecimoTerceiro, mesAnoInicio:mesAnoInicio, mesAnoFim: mesAnoFim, diaUtil: diaUtil 
        },   
        success: function (data) {
        callback(data);
        } 
    }); 
}   

function populaComboFuncionario(projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_operacaoFolhaPonto.php', //caminho do arquivo a ser executado
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