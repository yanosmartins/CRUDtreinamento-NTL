
function gravaServico(id, descricaoCodigo, descricaoServico, ativo, callback) {
  $.ajax({
      url: 'js/sqlscope_tabelaBasicaServico.php',
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: "grava", id:id, descricaoCodigo:descricaoCodigo, descricaoServico:descricaoServico, ativo:ativo},   
      success: function (data) {
      callback(data);
      } 
  }); 
}

function recuperaServico(id, callback) {
  $.ajax({
      url: 'js/sqlscope_tabelaBasicaServico.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'recupera', id: id}, //valores enviados ao script      
    success: function (data) {
          callback(data); 
      }
  });

  return;
}

function excluiServico(id, callback) {
  $.ajax({
      url: 'js/sqlscope_tabelaBasicaServico.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'excluir', id: id}, //valores enviados ao script      
      success: function (data) {
          callback(data); 
      }
  });
}

