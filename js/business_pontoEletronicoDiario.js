function gravarPonto(codigo, funcionario, mesAno, idFolha, dia, horaEntrada, horaSaida, inicioAlmoco, fimAlmoco, horaExtra, atraso, lancamento, observacao, status, diasAlterados,btnClicado, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        async: false,
        data: { funcao: 'gravar', 
                codigo: codigo, 
                funcionario: funcionario,
                mesAno: mesAno, 
                idFolha: idFolha, 
                horaSaida: horaSaida, 
                inicioAlmoco: inicioAlmoco, 
                fimAlmoco: fimAlmoco, 
                horaExtra: horaExtra, 
                atraso: atraso, 
                lancamento: lancamento, 
                horaEntrada: horaEntrada, 
                dia: dia, 
                observacao: observacao, 
                status: status, 
                diasAlterados: diasAlterados,
                btnClicado: btnClicado
            },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaPonto(funcionario, mesAno, dia, projeto, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        // async: false,
        data: { funcao: 'recupera', funcionario: funcionario, mesAno: mesAno, dia: dia, projeto: projeto }, //valores enviados ao script      
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

function confirmaRegistro(idFolha, dia,mesAno, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'confirmaRegistro',
                idFolha: idFolha,
                dia: dia,
                mesAno: mesAno
            }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })
}

function registrarPausa(idFolha, mesAno, dia, inicioPrimeiraPausa, fimPrimeiraPausa,inicioSegundaPausa, fimSegundaPausa,btnClicado, justificativaPausa, callback) {
    $.ajax({
        url: 'js/sqlscope_pontoEletronicoDiario.php', //caminho do arqivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'registrarPausa',
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