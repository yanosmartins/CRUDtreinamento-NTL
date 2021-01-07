function gravaFolhaPonto(id, projeto, funcionario, mesAnoFolhaPonto, justificativaFolhaPonto,
    totalFaltasValeAlimentacao, totalAusenciasValeAlimentacao, diasProjetoValeAlimentacao,
    totalDiasTrabalhadosValeAlimentacao, faltasValeTransporte, ausenciasValeTransporte,
    diasProjetoValeRefeicao, totalDiasTrabalhadosValeRefeicao, jsonValeAlimentacaoArray, jsonValeRefeicaoArray,
    jsonValeTransporteArray, jsonValorExtraArray, totalDiasTrabalhadosVT, jsonHoraExtraArray, diasUteisVAVR, diasUteisVT, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "grava", id: id, projeto: projeto, funcionario: funcionario, mesAnoFolhaPonto: mesAnoFolhaPonto, justificativaFolhaPonto: justificativaFolhaPonto,
            totalFaltasValeAlimentacao: totalFaltasValeAlimentacao, totalAusenciasValeAlimentacao: totalAusenciasValeAlimentacao, diasProjetoValeAlimentacao: diasProjetoValeAlimentacao,
            totalDiasTrabalhadosValeAlimentacao: totalDiasTrabalhadosValeAlimentacao, faltasValeTransporte: faltasValeTransporte, ausenciasValeTransporte: ausenciasValeTransporte,
            diasProjetoValeRefeicao: diasProjetoValeRefeicao, totalDiasTrabalhadosValeRefeicao: totalDiasTrabalhadosValeRefeicao, jsonValeAlimentacaoArray: jsonValeAlimentacaoArray,
            jsonValeRefeicaoArray: jsonValeRefeicaoArray, jsonValeTransporteArray: jsonValeTransporteArray, jsonValorExtraArray: jsonValorExtraArray, 
            totalDiasTrabalhadosVT: totalDiasTrabalhadosVT, jsonHoraExtraArray: jsonHoraExtraArray, diasUteisVAVR: diasUteisVAVR, diasUteisVT:diasUteisVT
        }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaFolhaPonto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script     

        success: function (data) {
            callback(data);
        }

    });

    return;
}

function excluirFolhaPonto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     

        success: function (data) {
            callback(data);
        }

    });
}

function populaDiasProjeto(codigoProjeto, mesAnoFolhaPonto, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        async: 'false',
        data: { funcao: 'populaDiasProjeto', codigoProjeto: codigoProjeto, mesAnoFolhaPonto: mesAnoFolhaPonto }, //valores enviados ao script     

        success: function (data) {
            callback(data);
        }

    });
}
function verificaFerias(funcionario, mesAno, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        async: 'false',
        data: { funcao: 'verificaFerias', funcionario: funcionario, mesAno: mesAno }, //valores enviados ao script     

        success: function (data) {
            callback(data);
        }

    });
}
function recuperaDiaUtil(mesAno, funcionario, projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaDiaUtil', mesAno: mesAno, funcionario: funcionario, projeto: projeto }, //valores enviados ao script     

        success: function (data) {
            callback(data);
        }

    });

    return;
}
function recuperaDiaUtilProjeto(mesAno, funcionario, projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaDiaUtilProjeto', mesAno: mesAno, funcionario: funcionario, projeto: projeto }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}
function verificaFeriado(data, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaFeriado', data: data }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}
function populaComboFuncionario(projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
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
function periodoAdicionalNoturno(funcionario, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPonto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'periodoAdicionalNoturno', funcionario: funcionario }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }

    });

    return;
}

