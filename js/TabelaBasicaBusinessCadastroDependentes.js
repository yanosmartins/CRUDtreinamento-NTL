function gravaDependentes(codigo, descricao, ativo) {
    $.ajax({
        url: 'js/TabelaBasicaSqlscopeCadastroDependentes.php',
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

function excluiDependentes(codigo) {
    $.ajax({
        url: 'js/TabelaBasicaSqlscopeCadastroDependentes.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', codigo: codigo }, //valores enviados ao script     
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
               
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function recuperaDependentes(id, callback) {
    $.ajax({
        url: 'js/TabelaBasicaSqlscopeCadastroDependentes.php', //caminho do arquivo a ser executado
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
function dependenteVerificado(codigo, descricao) {
    $.ajax({
        url: 'js/TabelaBasicaSqlscopeCadastroDependentes.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificaDependente", codigo: codigo, descricao: descricao }, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('success') < 0) {
                var piece = data.split("#");
                if (piece[0] != "success") {
                    mensagem = "Tipo de dependente já registrado.";
                    smartAlert("Atenção", mensagem, "error");
                    document.getElementById('descricao').value = "";
                    $("#descricao").focus();
                }
            }
            ////////////////////////////////////////
            //retorno dos dados
        },
        
        error: function (xhr, er) {
            //tratamento de erro
            console.log(xhr, er)
        }
    });
}
