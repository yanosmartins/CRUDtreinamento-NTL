function exportarCandidato(arrayFuncionario) {
    $.ajax({
        url: 'js/sqlscope_exportacaoCandidato.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'exportarCandidato', arrayFuncionario: arrayFuncionario }, //valores enviados ao script     
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