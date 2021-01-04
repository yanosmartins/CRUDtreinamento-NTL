function gravaContrato(contrato ,callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroContrato.php',
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: "grava",  contrato:contrato}, //valores enviados ao script     
      success: function (data) {
          callback(data);
      }
  });
}
  
  function preencheProjeto(projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroContrato.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "preencheProjeto", projeto: projeto },

        success: function (data, textStatus) {
          if (data.indexOf("failed") > -1) {
            return;
          } else {
            callback(data);
          }
        },
        error: function (xhr, er) {
          //tratamento de erro
        },
    }); 
}

function preenchePregao(numeroPregao, callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroContrato.php',
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: "preenchePregao", numeroPregao: numeroPregao },

      success: function (data, textStatus) {
        if (data.indexOf("failed") > -1) {
          return;
        } else {
          callback(data);
        }
      },
      error: function (xhr, er) {
        //tratamento de erro
      },
  }); 
}
  
function recuperaContrato(id, callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroContrato.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'recupera', id: id}, //valores enviados ao script     
            
      success: function (data) {
          callback(data); 
      }
          
  });

  return;
}
  
function  excluirContrato(id, callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroContrato.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {funcao: 'excluir', id: id}, //valores enviados ao script     
    
      success: function (data) {
          callback(data); 
      }
      
  });
}
  