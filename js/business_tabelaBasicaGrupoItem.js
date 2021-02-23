function gravaGrupoItem(codigo, estoque, descricao, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaGrupoItem.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      descricao: descricao,
      estoque: estoque,
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaGrupoItem(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaGrupoItem.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

function excluirGrupoItem(id, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaGrupoItem.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}
