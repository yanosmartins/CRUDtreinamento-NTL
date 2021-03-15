function gravaEstoque(codigo, descricao, ativo, unidade, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaEstoque.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      descricao: descricao,
      ativo: ativo,
      unidade : unidade,
    },
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaEstoque(codigo, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaEstoque.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', codigo: codigo }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
  return
}

function excluirEstoque(codigo, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaEstoque.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', codigo: codigo }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}
