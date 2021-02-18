function gravaEncargo(codigo, descricao, percentual, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaEncargo.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      descricao: descricao,
      percentual: percentual,
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaEncargo(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaEncargo.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

function excluirEncargo(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaEncargo.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}
