function gravaUpload(formData) {
    formData.append('funcao', 'grava');
    $.ajax({ 
        url: 'js/sqlscopeUpload.php',
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, textStatus) {
            if (data === 'success') {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success"); 
                novo();
            } else {
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
            }
        }, error: function (xhr, er) {
            console.log(xhr, er);
        }
    });
}

function recuperaUpload(id, callback) {
    $.ajax({
        url: 'js/sqlscopeUpload.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id }, //valores enviados ao script     
        success: function (data) {
            callback(data); 
        }
    });
    
}

function excluirUsuario(id) {
    $.ajax({
        url: 'js/sqlscopeUsuario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script     
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
                novo();
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}