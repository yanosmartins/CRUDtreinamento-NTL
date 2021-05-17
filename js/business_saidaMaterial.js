function gravaSaidaMaterial(formData) {
    formData.append('funcao', 'grava');
    $.ajax({ 
        url: 'js/sqlscope_cadastroSaidaMaterial.php',
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

function recuperaSaidaMarterial(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroSaidaMaterial.php',
        dataType: 'html', 
        type: 'post',
        data: {funcao: 'recupera', codigo: codigo},      
        success: function (data) {
            callback(data); 
        }
    });
}

function recuperaQuantidadeEstoque(codigo, estoque, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroPedidoMaterial.php',
        dataType: 'html', 
        type: 'post',
        data: {funcao: 'recuperaQuantidadeEstoque', codigo: codigo, estoque:estoque},      
        success: function (data) {
            callback(data); 
        }
    });
}


function recuperaDescricaoCodigo(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroPedidoMaterial.php',
        dataType: 'html', 
        type: 'post',
        data: {funcao: 'recuperaDescricaoCodigo', codigo: codigo},      
        success: function (data) {
            callback(data); 
        }
    });
}

function populaComboEstoque(unidadeDestino, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroPedidoMaterial.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'populaComboEstoque', unidadeDestino: unidadeDestino }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}


function excluirSaidaItem(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroSaidaMaterial.php', 
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', codigo: codigo}, //valores enviados ao script   
        success: function (data, textStatus) {
            debugger; 
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

function doLogin() {
    var login=document.getElementById('login').value;
    var passwd=document.getElementById('senha').value;
    doPostLogin(login, passwd);
}

function doPostLogin(login, passwd){         
    $.ajax({
            url: 'js/sqlscopeAccount.php', //caminho do arquivo a ser executado
            dataType: 'html', //tipo do retorno
            type: 'post', //metodo de envio
            data: {funcao: 'validaSenha', login: login, senha: passwd}, //valores enviados ao script     
            beforeSend: function(){                             
              //função chamada antes de realizar o ajax
            },
            complete: function(){
             //função executada depois de terminar o ajax
            },
            success: function(data, textStatus){

                if (data.indexOf('failed')>-1) {
                    smartAlert("Erro", 'Senha incorreta !', "error");
                    return;
                } 
                else {
                    gravar();
                }
              //retorno dos dados
           },
           error: function(xhr,er){
               //tratamento de erro
           }
    });
} 