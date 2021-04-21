function gravaLancamento(id, ativo, descricao, sigla,faltaAusencia,abonaAtraso,imprimeFolha,planilhaFaturamento, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaLancamento.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, ativo:ativo, descricao:descricao, sigla:sigla,
                faltaAusencia:faltaAusencia, abonaAtraso: abonaAtraso, 
                imprimeFolha: imprimeFolha, planilhaFaturamento: planilhaFaturamento},   
        success: function (data) {
        callback(data);
        } 
    }); 
}
  
function recuperaLancamento(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaLancamento.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}
  
function excluirLancamento(id, callback) {
    $.ajax({
        url: 'js/sqlscope_tabelaBasicaLancamento.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}
