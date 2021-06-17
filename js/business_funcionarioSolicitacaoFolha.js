function grava(json, callback) {
  $.ajax({
    url: 'js/sqlscope_funcionarioSolicitacaoFolha.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'gravaSolicitante',
      json: json
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recupera(callback) {
  $.ajax({
    url: 'js/sqlscope_funcionarioSolicitacaoFolha.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recuperaSolicitante'}, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

function recuperaGestao(callback) {
  $.ajax({
    url: 'js/sqlscope_funcionarioSolicitacaoFolha.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recuperaSolicitado'}, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}
