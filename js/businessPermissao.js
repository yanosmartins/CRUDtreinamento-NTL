function gravaPermissoesUsuario(codigoUsuario, jsonFuncMarcadas, grupo) {
    $.ajax({
        url: 'js/sqlscopePermissao.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", codigoUsuario: codigoUsuario, jsonFuncMarcadas: jsonFuncMarcadas, grupo: grupo}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
                return '';
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';

}

function recuperaPermissaoUsuario(codigoUsuario) {
    $.ajax({
        url: 'js/sqlscopePermissao.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', codigoUsuario: codigoUsuario}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                return;
            } else {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var arrayFuncionalidade = piece[1];

                $("#JsonFuncionalidade").val(arrayFuncionalidade);

                jsonFuncionalidadeArray = JSON.parse($("#JsonFuncionalidade").val());

                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function excluirTodasPermissoesUsuario(codigoUsuario) {
    $.ajax({
        url: 'js/sqlscopePermissao.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', codigoUsuario: codigoUsuario}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com TI !", "error");
                }
                return '';
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso !", "success");
                novo();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

}


