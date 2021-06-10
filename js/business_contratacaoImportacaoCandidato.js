function gravaImportacaoCandidato(formData,callback) {
    formData.append('funcao', 'gravaImportacaoCandidato');
    $.ajax({ 
        url: 'js/sqlscope_contratacaoImportacaoCandidato.php',
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, textStatus) {
            data = data.split("#");
            let jsonArrayErros = JSON.parse(data[1]);
            if (data[0] == 'success') {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success"); 
                callback(jsonArrayErros); 
            } else {
                $("#btnGravar").attr('disabled', false);
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error"); 
            }
        }, error: function (xhr, er) {
            console.log(xhr, er);
        }
    }); 
}         