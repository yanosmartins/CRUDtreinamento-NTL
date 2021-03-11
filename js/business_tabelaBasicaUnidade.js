function gravaUnidade(codigo, descricao, ativo, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaUnidade.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      descricao: descricao,
      ativo: ativo,
    },
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaUnidade(codigo, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaUnidade.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', codigo: codigo }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
  return
}

function excluirUnidade(codigo, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaUnidade.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', codigo: codigo }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}
