function gravarPonto(codigo,
     idFolha,
     dia,
     horaEntrada,
     inicioAlmoco,
     fimAlmoco,
     horaSaida,
     horaExtra,
     atraso,
     justificativaAtraso,
     justificativaExtra,
     atrasoAlmoco,
     callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php',

        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        async: false,
        data: {
            funcao: 'gravar',
            codigo: codigo,
            idFolha: idFolha,
            dia: dia,
            horaEntrada: horaEntrada,
            inicioAlmoco: inicioAlmoco,
            fimAlmoco: fimAlmoco,
            horaSaida: horaSaida,
            horaExtra: horaExtra,
            atraso: atraso,
            justificativaAtraso: justificativaAtraso,
            justificativaExtra: justificativaExtra,
            atrasoAlmoco: atrasoAlmoco,
        },

        success: function (data) {
            callback(data);
        }
    });
}

function gravaLancamento(codigo,
    idFolha,
    dia,
    lancamento,
    callback) {
   $.ajax({
       url: 'js/sqlscope_pontoEletronicoDiario.php',
       dataType: 'html', //tipo do retorno
       type: 'post', //metodo de envio
       async: false,
       data: {
           funcao: 'gravarLancamento',
           codigo: codigo,
           idFolha: idFolha,
           dia: dia,
           lancamento: lancamento,
       },

       success: function (data) {
           callback(data);
       }
   });
}


function recuperaPonto(funcionario, mesAno, dia, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        // async: false,
        data: { funcao: 'recupera', funcionario: funcionario, mesAno: mesAno, dia: dia }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function enviaEmail(codigoFuncionario, horaAtual, callback) {
    $.ajax({
        url: 'funcionario_enviarEmailPontoEletronicoDiario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { codigoFuncionario: codigoFuncionario, horaAtual: horaAtual }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function validaIp(ip, projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        async: false,
        data: { funcao: 'validarIp', ip: ip, projeto: projeto }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function verificaFeriado(mesAno, funcionario, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaFeriado', mesAno: mesAno, funcionario: funcionario }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })
}

function verificarAutorizacao(dia, mesAno, funcionario, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificarAutorizacao', dia: dia, mesAno: mesAno, funcionario: funcionario }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })
}

function selecionarHora(callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'selecionaHora' }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })
}

function consultarAbateBancoHoras(lancamento, atraso, horaEntrada, horaSaida, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: 'consultarAbateBancoHoras',
            lancamento: lancamento,
            atraso: atraso,
            horaEntrada: horaEntrada,
            horaSaida: horaSaida
        }, //valores enviados ao script
        success: function (data) {
            callback(data)
        },
    })
}

// Verifica se o lançamento é para compensação de falta
function verificaLancamento(lancamento, horaExtra, idFolha, dia, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaLancamento', lancamento: lancamento, horaExtra: horaExtra, idFolha: idFolha, dia: dia }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })
}

function confirmaRegistro(idFolha, dia, mesAno, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: 'confirmaRegistro',
            idFolha: idFolha,
            dia: dia,
            mesAno: mesAno
        }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })
}

function registrarPausa(idFolha, mesAno, dia, inicioPrimeiraPausa, fimPrimeiraPausa, inicioSegundaPausa, fimSegundaPausa, btnClicado, justificativaPausa, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: 'registrarPausa',
            idFolha: idFolha,
            mesAno: mesAno,
            dia: dia,
            inicioPrimeiraPausa: inicioPrimeiraPausa,
            fimPrimeiraPausa: fimPrimeiraPausa,
            inicioSegundaPausa: inicioSegundaPausa,
            fimSegundaPausa: fimSegundaPausa,
            btnClicado: btnClicado,
            justificativaPausa: justificativaPausa
        }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })
}