function doLogin() {
     var login=document.getElementById('login').value;
     var passwd=document.getElementById('password').value;
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
                    smartAlert("Erro", 'Senha ou login incorretos !', "error");
                    $('#login').val("");
                    $('#password').val("");
                    $('#login').focus(); 
                    return;
                } 
                else {
                    $(location).attr('href', 'index.php');
                }
              //retorno dos dados
           },
           error: function(xhr,er){
               //tratamento de erro
           }
    });
} 
