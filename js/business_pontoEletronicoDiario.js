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
     horaTotalDia,
     horasPositivasDia,
     horasNegativasDia,
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
            horaTotalDia:horaTotalDia,
            horasPositivasDia:horasPositivasDia,
            horasNegativasDia:horasNegativasDia,
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
