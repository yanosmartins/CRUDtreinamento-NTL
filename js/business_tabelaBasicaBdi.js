function gravaBdi(codigo, descricao, percentual, tipo, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaBdi.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      descricao: descricao,
      percentual: percentual,
      tipo: tipo
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaBdi(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaBdi.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

function excluirBdi(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaBdi.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}
