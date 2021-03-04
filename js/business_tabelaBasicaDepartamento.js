function gravaDepartamento(codigo, descricao,projeto, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaDepartamento.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      descricao: descricao,
      projeto: projeto
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaDepartamento(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaDepartamento.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

function excluirDepartamento(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaDepartamento.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}
