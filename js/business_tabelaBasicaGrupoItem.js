function gravaGrupoItem(codigo, estoque, descricao, unidade, callback) {
  $.ajax({
    url: 'js/sqlscope_tabelaBasicaGrupoItem.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,
      descricao: descricao,
      estoque: estoque,
      unidade: unidade,
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

function populaComboEstoque(unidade, callback) {
  $.ajax({
      url: 'js/sqlscope_cadastroCodigoItem.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: { funcao: 'populaComboEstoque', unidade: unidade }, //valores enviados ao script     
      async: false,
      success: function (data) {
          callback(data);
      }
  });

  return;
}
