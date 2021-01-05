function gravaProjeto(projeto, callback) {
    $.ajax({

        url: 'js/sqlscope_cadastroProjeto.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "gravaProjeto", projeto:projeto}, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaProjeto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recuperaProjeto', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function excluirProjeto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroProjeto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluirProjeto', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}



