function gravaRemuneracao(id, ativo, descricao, tipo, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaRemuneracao.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'grava', id: id, ativo: ativo, descricao: descricao, tipo: tipo },
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaRemuneracao(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaRemuneracao.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })

  return
}

function excluirRemuneracao(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaRemuneracao.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}
