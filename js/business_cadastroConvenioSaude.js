function gravaConvenioDeSaude(id, ativo, apelido, cnpj, descricao, registroAns, seguroVida, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroConvenioSaude.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, ativo:ativo, apelido:apelido, cnpj:cnpj, descricao:descricao, registroAns:registroAns, seguroVida:seguroVida},   
        success: function (data) {
        callback(data);
        } 
    }); 
}
  
function recuperaConvenioSaude(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroConvenioSaude.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}

function excluirConvenioSaude(id, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroConvenioSaude.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}