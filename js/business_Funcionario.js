function gravaFuncionario(id, ativo, nome, cpf, dataNascimento, callback) {
    $.ajax({
        url: 'js/sqlscope_Funcionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "grava", id: id, ativo: ativo, nome: nome, cpf: cpf, dataNascimento: dataNascimento }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaCargo(id, callback) {
    $.ajax({
        url: 'js/sqlscope_Funcionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function excluirCargo(id, callback) {
    $.ajax({
        url: 'js/sqlscope_Funcionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     
        success: function (data) {
            callback(data);
        }
    });
}
function verificaDescricao(descricao, callback) {
    $.ajax({
        url: 'js/sqlscope_Funcionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'verificaDescricao', descricao: descricao }, //valores enviados ao script
        async: true,
        success: function (data) {
            callback(data);
        }
    });
}

