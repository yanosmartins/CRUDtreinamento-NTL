function gravaProcessaBeneficio(mesAnoReferencia, projeto,JsonArrayProcessabeneficio, callback) {
  $.ajax({
    url: 'js/sqlscope_beneficioProcessaBeneficio.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      mesAnoReferencia: mesAnoReferencia,
      projeto: projeto,
      JsonArrayProcessabeneficio: JsonArrayProcessabeneficio,
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function validaProcessaBeneficio(projeto,mesAno, callback) {
  $.ajax({
      url: 'js/sqlscope_beneficioProcessaBeneficio.php', //caminho do arquivo a ser executado
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: { funcao: 'validarProcessaBeneficio', projeto: projeto, mesAno: mesAno}, //valores enviados ao script     
      async: false,
      success: function (data) {
          callback(data);
      }

  });
  return;
}