function gravaControleFuncionario(formData) {
    formData.append('funcao', 'grava');
    $.ajax({
        url: 'js/sqlscope_contratacaoControleCandidato.php',
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

function recuperaCadastroFuncionario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_contratacaoControleCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaCbo(id, callback) {
    $.ajax({
        url: 'js/sqlscope_contratacaoControleCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaCbo', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}
function verificaMatricula(matriculaSCI, id, callback) {
    $.ajax({
        url: 'js/sqlscope_contratacaoControleCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaMatricula', matriculaSCI: matriculaSCI, id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}

function excluirControleFuncionario(id, callback) {
    $.ajax({
        url: 'js/sqlscope_contratacaoControleCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function recuperaNomeCompleto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_contratacaoControleCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaNomeCompleto', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}