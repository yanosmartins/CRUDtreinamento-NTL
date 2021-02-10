function gravaLancamento(lancamentoTabela,callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioLancamento.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", lancamentoTabela:lancamentoTabela}, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
  }
  
  function recuperaLancamento(id, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioLancamento.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script     
              
        success: function (data) {
            callback(data); 
        }
            
    });
  
    return;
  }
  
  function  excluirLancamento(id, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioLancamento.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script     
      
        success: function (data) {
            callback(data); 
        }
        
    });
  }