function gravaControleFerias(id, funcionario, matricula, cargo, projeto,  dataAdmissao, ativo, jsonControleFeriasArray, callback) {
    $.ajax({
        url: 'js/sqlscope_funcionarioControleFerias.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", id:id, funcionario:funcionario, matricula:matricula, cargo:cargo, projeto:projeto, dataAdmissao:dataAdmissao,
         ativo:ativo, jsonControleFeriasArray:jsonControleFeriasArray},   
        success: function (data) {
        callback(data);
        } 
    }); 
  }
  
  function recuperaControleFerias(id, callback) {
    $.ajax({
        url: 'js/sqlscope_funcionarioControleFerias.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
  
    return;
  }
  
  function excluirControle(id, callback) {
    $.ajax({
        url: 'js/sqlscope_funcionarioControleFerias.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
  }
  