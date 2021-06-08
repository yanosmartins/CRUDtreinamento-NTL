function validarRH(codigo,callback) {
  $.ajax({
    url: 'js/sqlscope_funcionarioTriagemPontoMensalRecursosHumanos.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'valida',codigo
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function reabrirRH(data,callback) {
  $.ajax({
    url: 'js/sqlscope_funcionarioTriagemPontoMensalRecursosHumanos.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'reabrir',data
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaTriagem(funcionario, mesAno, callback) {
  $.ajax({
    url: 'js/sqlscope_funcionarioTriagemPontoMensalRecursosHumanos.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'get', //metodo de envio
    data: { funcao: 'recupera',funcionario,mesAno }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}
