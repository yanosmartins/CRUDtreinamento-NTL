function gravaFuncionario(id, ativo, cpf, nome, dataNascimento, rg, estadoCivil, genero, jsonTelefoneArray, jsonEmailArray, jsonDependenteArray, cep, logradouro, uf, bairro, cidade, numero, complemento, primeiroEmprego, pispasep) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "gravar", id: id,
            ativo: ativo,
            cpf: cpf,
            nome: nome,
            dataNascimento: dataNascimento,
            rg: rg,
            estadoCivil: estadoCivil,
            genero: genero,
            jsonTelefoneArray: jsonTelefoneArray,
            jsonEmailArray: jsonEmailArray,
            jsonDependenteArray: jsonDependenteArray,
            cep: cep,
            logradouro: logradouro,
            uf: uf,
            bairro: bairro,
            cidade: cidade,
            numero: numero,
            complemento: complemento,
            primeiroEmprego: primeiroEmprego,
            pispasep: pispasep
        }, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            ss
            //função executada depois de terminar o ajax
        },
        ///////////////////////////////////////////////////
        success: function (data, textStatus) {
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
function cpfverificado(cpf) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "VerificaCPF", cpf: cpf }, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('success') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (piece[0] !== "success") {
                    //     smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    //     return;
                    // }
                    // else {
                    mensagem = "Opa! CPF já registrado.";
                    document.getElementById('cpf').value = "";
                    $("#cpf").focus();
                    smartAlert("Atenção", mensagem, "error");
                    return;
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
    return '';
}

function cpfvalidado(cpf) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php',
        type: 'post',
        dataType: "html",
        data: { funcao: "ValidaCPF", cpf: cpf },

        success: function (data) {
            if (data.trim() !== 'success') {
                //     smartAlert("Sucesso", "CPF válido!", "success");
                // } else {
                smartAlert("Atenção", "CPF Inválido!", "error");
                document.getElementById('cpf').value = "";
                $("#cpf").focus();
            }
        }, error: function (xhr, er) {
            console.log(xhr, er);
        }
    });
}

function cpfDependenteValidado(cpfDependente) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php',
        type: 'post',
        dataType: "html",
        data: { funcao: "validaCpfDependente", cpfDependente: cpfDependente },

        success: function (data) {
            if (data.trim() == "failed") {
                smartAlert("Atenção", "CPF do dependente é inválido!", "error");
                document.getElementById('cpfDependente').value = "";
                $("#cpfDependente").focus();

            }
            // else{
            //     smartAlert("SIMMMM", "Passoou!", "success");
            // }
        },
        error: function (xhr, er) {
            console.log(xhr, er);
        }
    });
}

function RGverificado(rg) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "VerificaRG", rg: rg }, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('success') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (piece[0] !== "success") {
                    //     smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    //     return;
                    // }
                    // else {
                    mensagem = "RG já registrado.";
                    smartAlert("Atenção", mensagem, "error");
                    document.getElementById('rg').value = "";
                    $("#rg").focus();
                    return;
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
    return '';
}
function pispasepVerificado(pispasep) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "verificaPispasep", pispasep: pispasep }, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('success') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (piece[0] !== "success") {
                    mensagem = "Pis/Pasep já registrado.";
                    smartAlert("Atenção", mensagem, "error");
                    document.getElementById('pispasep').value = "";
                    $("#pispasep").focus();
                    return;
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
    return '';
}



function excluirUsuario(id) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     
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

function recuperaUsuario(id, callback) {
    $.ajax({
        url: 'js/sqlscopeCadastroFuncionario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', codigo: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });

    return;
}

