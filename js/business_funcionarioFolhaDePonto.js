function recuperaFuncionarioProjeto(projeto, mesAno, callback) {
    $.ajax({
        url: 'js/sqlscope_funcionarioFolhaDePonto.php',
        dataType: 'html', 
        type: 'post',
        data: {funcao: 'recupera',
         projeto: projeto,
         mesAno : mesAno},      
        success: function (data) {
            callback(data); 
        }
    });
}