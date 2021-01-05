function gravaValorPosto(valorPosto ,callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroValorPosto.php',
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: "grava", valorPosto:valorPosto}, //valores enviados ao script     
      success: function (data) {
          callback(data);
      }
  });
}

function recuperaValorPosto(id, callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroValorPosto.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'recupera', id: id}, //valores enviados ao script     
            
      success: function (data) {
          callback(data); 
      }
          
  });

  return;
}

function  excluirValorPosto(id, callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroValorPosto.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'excluir', id: id}, //valores enviados ao script     
    
      success: function (data) {
          callback(data); 
      }
      
  });
}