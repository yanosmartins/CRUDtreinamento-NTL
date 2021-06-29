 function gravaClinica(clinica, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroClinica.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        cache: false, 
        data: {funcao: "grava",clinica:clinica,
        },   
        success: function (data) {
        callback(data);
        } 
    }); 
} 

function recuperaClinica(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroClinica.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}


function excluirClinica(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroClinica.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}

function recuperaDadosCnpj(cnpj, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroClinica.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosCnpj', cnpj: cnpj }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function recuperaSolicitante(solicitante, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroClinica.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarSolicitante', solicitante: solicitante }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }
    });
    return;
}


