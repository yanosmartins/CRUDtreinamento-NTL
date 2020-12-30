function gravaSindicato(sindicato, callback) {
    $.ajax({
        url: 'js/sqlscope_sindicato.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'gravaSindicato', sindicato:sindicato}, 
        beforeSend:desabilitaBotoes(),
        success: function (data) {
        habilitaBotoes(),
        callback(data);
        } 
    }); 
}


function recuperaSindicato(id, callback) {
    $.ajax({
        url: 'js/sqlscope_sindicato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recuperaSindicato', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}
 

function recuperaValeTransporteUnitario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaValeTransporteUnitario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function excluirValeTransporteUnitario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaValeTransporteUnitario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}
function excluirSindicato(id, callback) {
    $.ajax({
        url: 'js/sqlscope_sindicato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}

function pesquisaCnpj(cnpj, callback) {
    $.ajax({
        url: 'js/sqlscope_sindicato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'pesquisaCnpj', cnpj: cnpj}, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function habilitaBotoes () {
    $('#btnGravar').attr('disabled', true);
    $('#btnExcluir').attr('disabled', true);
}
function desabilitaBotoes () {
    $('#btnGravar').attr('disabled', false);
    $('#btnExcluir').attr('disabled', false);
}