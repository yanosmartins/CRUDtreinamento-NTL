function gravaLocalizacaoItem(codigo, estoque, localizacaoItem, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaLocalizacaoItem.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      localizacaoItem: localizacaoItem,
      estoque: estoque,
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaLocalizacaoItem(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaLocalizacaoItem.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

function excluirLocalizacaoItem(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaLocalizacaoItem.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}
