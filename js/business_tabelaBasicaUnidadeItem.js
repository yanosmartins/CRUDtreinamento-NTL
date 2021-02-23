function gravaUnidadeItem(form, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaUnidadeItem.php',
    dataType: 'html', //tipo do retorno
    type: 'POST', //metodo de envio
    data: { funcao: 'grava', form: form },

    success: function (data) {
      callback(data)
    },
  })
}

function recuperaUnidadeItem(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaUnidadeItem.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'POST', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function excluirUnidadeItem(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaUnidadeItem.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'POST', //metodo de envio
    data: { funcao: 'excluir', id: id },
    success: function (data) {
      callback(data)
    },
  })
}
