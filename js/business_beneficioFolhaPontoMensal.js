function gravaFolhaPontoMensal(folhaPontoInfo,folhaPontoMensalTabela,callback) {
    debugger
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPontoMensal.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", folhaPontoInfo:folhaPontoInfo,folhaPontoMensalTabela:folhaPontoMensalTabela}, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
  }
  
  function recuperaFolhaPontoMensal(callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPontoMensal.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera'}, //valores enviados ao script     
              
        success: function (data) {
            callback(data); 
        }
            
    });
  
    return;
  }
  
  function  excluirFolhaPontoMensal(id, callback) {
    $.ajax({
        url: 'js/sqlscope_beneficioFolhaPontoMensal.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script     
      
        success: function (data) {
            callback(data); 
        }
        
    });
  }