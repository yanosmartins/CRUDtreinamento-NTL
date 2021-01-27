function gravaGrupoLicitacao(id, ativo, descricao, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaGrupoLicitacao.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, ativo:ativo, descricao:descricao},   
        success: function (data) {
        callback(data);
        } 
    }); 
}
  
function recuperaGrupoLicitacao(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaGrupoLicitacao.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}
  
function excluirGrupoLicitacao(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaGrupoLicitacao.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}
