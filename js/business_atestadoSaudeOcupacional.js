 function gravaASO(id,funcionario, matricula,cargo,projeto,sexo,dataNascimento,dataAdmissao,dataAgendamento,
    dataUltimoAso,dataProximoAso,ativo,jsonDataAsoArray, callback) {
    $.ajax({
        url: 'js/sqlscope_atestadoSaudeOcupacional.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava",id:id,funcionario:funcionario,matricula:matricula,cargo:cargo,projeto:projeto,sexo:sexo,dataNascimento:dataNascimento,
        dataAdmissao:dataAdmissao,dataAgendamento:dataAgendamento,dataUltimoAso:dataUltimoAso,dataProximoAso:dataProximoAso,ativo:ativo,jsonDataAsoArray:jsonDataAsoArray,
        },   
        success: function (data) {
        callback(data);
        } 
    }); 
} 

function recuperaASO(id, callback) {
    $.ajax({
        url: 'js/sqlscope_atestadoSaudeOcupacional.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });

    return;
}


function excluirASO(id, callback) {
    $.ajax({
        url: 'js/sqlscope_atestadoSaudeOcupacional.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script      
        success: function (data) {
            callback(data); 
        }
    });
}

function recuperaDadosFuncionario(funcionario, callback) {
    $.ajax({
        url: 'js/sqlscope_atestadoSaudeOcupacional.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosFuncionario', funcionario: funcionario }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}



function recuperaDadosFuncionarioASO(funcionario, callback) {
    $.ajax({
        url: 'js/sqlscope_atestadoSaudeOcupacional.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosFuncionarioASO', funcionario: funcionario }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}