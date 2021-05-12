function gravarPonto(codigo,funcionario, mesAno, idFolha, dia, horaEntrada, horaSaida, inicioAlmoco, fimAlmoco, horaExtra, atraso, lancamento, observacao, status, callback) {
    $.ajax({
        url: 'js/sqlscope_prototipoPontoEletronicoDiario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravar', codigo: codigo,funcionario:funcionario,mesAno:mesAno,idFolha:idFolha,horaSaida:horaSaida,inicioAlmoco:inicioAlmoco,fimAlmoco:fimAlmoco,horaExtra:horaExtra,atraso:atraso,lancamento:lancamento, horaEntrada:horaEntrada, dia:dia, observacao:observacao, status:status },

        success: function (data) {
            callback(data);
        }
    });
}



function recuperaPonto(funcionario,mesAno,dia, callback) {
    $.ajax({
        url: 'js/sqlscope_prototipoPontoEletronicoDiario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', funcionario: funcionario, mesAno: mesAno, dia:dia }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

