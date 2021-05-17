function gravaProdutoBeneficio(id, fornecedor, nome,codigoProduto, ativo, callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioProdutoBeneficio.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'grava', id: id,fornecedor: fornecedor,nome: nome,codigoProduto: codigoProduto, ativo: ativo},
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaProdutoBeneficio(id, callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioProdutoBeneficio.php', //caminho do arquivo a ser executado
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
    url: 'js/sqlscope_beneficioProdutoBeneficio.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}
