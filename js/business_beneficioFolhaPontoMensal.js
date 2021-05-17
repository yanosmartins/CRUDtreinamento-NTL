function gravaFolhaPontoMensal(
  folhaPontoInfo,
  folhaPontoMensalTabela,
  callback
) {
  $.ajax({
    url: 'js/sqlscope_beneficioFolhaPontoMensal.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      folhaPontoInfo: folhaPontoInfo,
      folhaPontoMensalTabela: folhaPontoMensalTabela,
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaFolhaPontoMensal(funcionario = 0, mesAno, callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioFolhaPontoMensal.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', funcionario: funcionario, mesAno: mesAno }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

function excluirFolhaPontoMensal(id, callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioFolhaPontoMensal.php', //caminho do arqivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'excluir', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}

function consultarLancamento(id, callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioFolhaPontoMensal.php', //caminho do arqivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'consultarLancamento', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}

function consultarPermissoes(callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioFolhaPontoMensal.php', //caminho do arqivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'consultarPermissoes' }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}

function enviarArquivo(file, callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioFolhaPontoMensal.php', //caminho do arqivo a ser executado
    contentType: false,
    processData: false,
    method:"POST",
    data: { fileUpload: file,funcao: 'enviarFolha' }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })
}
