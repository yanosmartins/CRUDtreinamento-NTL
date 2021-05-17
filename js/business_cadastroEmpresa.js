function gravaEmpresa(codigo,ativo,nome,codigoDepartamento,nomeDepartamento,responsavelRecebimento,
  cep,tipoLogradouro,logradouro,numero,complemento,uf,cidade,bairro, callback) {
  $.ajax({
    url: 'js/sqlscope_cadastroEmpresa.php',
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: {
      funcao: 'grava',
      codigo: codigo,ativo: ativo,nome: nome,codigoDepartamento: codigoDepartamento,nomeDepartamento: nomeDepartamento,responsavelRecebimento: responsavelRecebimento,
      cep: cep,tipoLogradouro: tipoLogradouro,logradouro: logradouro,numero: numero,complemento: complemento,uf: uf,cidade: cidade,bairro: bairro,
    }, //valores enviados ao script
    success: function (data) {
      callback(data)
    },
  })
}

function recuperaEmpresa(id, callback) {
  $.ajax({
    url: 'js/sqlscope_cadastroEmpresa.php', //caminho do arquivo a ser executado
    dataType: 'html', //tipo do retorno
    type: 'post', //metodo de envio
    data: { funcao: 'recupera', id: id }, //valores enviados ao script

    success: function (data) {
      callback(data)
    },
  })

  return
}

