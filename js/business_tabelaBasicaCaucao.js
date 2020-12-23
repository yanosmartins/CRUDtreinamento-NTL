function gravaTipoCaucao(codigo, ativo, descricao ,callback) {
  $.ajax({
      url: 'js/sqlscope_tabelaBasicaCaucao.php',
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: "grava", codigo:codigo, ativo:ativo, descricao:descricao}, //valores enviados ao script     
      success: function (data) {
          callback(data);
      }
  });
}

function recuperaTipoCaucao(id, callback) {
  $.ajax({
      url: 'js/sqlscope_tabelaBasicaCaucao.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'recupera', id: id}, //valores enviados ao script     
            
      success: function (data) {
          callback(data); 
      }
          
  });

  return;
}

function  excluirTipoCaucao(id, callback) {
  $.ajax({
      url: 'js/sqlscope_tabelaBasicaCaucao.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'excluir', id: id}, //valores enviados ao script     
    
      success: function (data) {
          callback(data); 
      }
      
  });
}