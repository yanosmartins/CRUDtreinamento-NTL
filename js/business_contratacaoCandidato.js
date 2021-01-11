function gravaFuncionario(formData) {
    formData.append('funcao', 'gravaFuncionario');
    $.ajax({
        url: 'js/sqlscope_contratacaoCandidato.php',
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, textStatus) {
            if (data.trim() === 'success') {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                voltar();
            } else {
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
            }
        }, error: function (xhr, er) {
            console.log(xhr, er);
        }
    });
}

function recuperaFuncionario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_contratacaoCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaFuncionario', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function excluirCandidato(id) {
    $.ajax({
        url: 'js/sqlscope_contratacaoCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     
        success: function (data, textStatus) {
            if (textStatus === 'success') {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                voltar();
            } else {
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
            }
        }, error: function (xhr, er) {
            console.log(xhr, er);
        }
    });
}
