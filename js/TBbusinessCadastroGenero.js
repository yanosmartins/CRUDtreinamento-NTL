function gravaGenero(codigo, descricao, ativo) {
    $.ajax({
        url: 'js/TBsqlscopeCadastroGenero.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "gravar", codigo:codigo, descricao: descricao, ativo: ativo}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        ///////////////////////////////////////////////////
        success: function (data) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    novo();
                }

                return '';
            }
            ////////////////////////////////////////
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';

}

function excluiGenero(codigo) {
    $.ajax({
        url: 'js/TBsqlscopeCadastroGenero.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', codigo:codigo }, //valores enviados ao script     
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
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
                location.reload();
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                location.reload();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}


// function excluirGenero(id) {
//     $.ajax({
//         url: 'js/sqlscopeTabelaBasicaGenero.php', //caminho do arquivo a ser executado
//         dataType: 'html', //tipo do retorno
//         type: 'post', //metodo de envio
//         data: { funcao: 'excluir', id: id }, //valores enviados ao script
//         success: function (data, textStatus) {
//             if (textStatus === 'success') {
//                 smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
//                 voltar();
//             } else {
//                 smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
//             }
//         }, error: function (xhr, er) {
//             console.log(xhr, er);
//         }
//     });
// }



function recuperaGenero(id, callback) {
    $.ajax({
        url: 'js/TBsqlscopeCadastroGenero.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: 'recupera',
            codigo: id,
            

        }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
        
    });

    return;
}

