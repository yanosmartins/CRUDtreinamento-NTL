function gravaDevolucaoMaterial(formData) {
    formData.append('funcao', 'grava');
    $.ajax({ 
        url: 'js/sqlscope_cadastroDevolucaoMaterial.php',
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

function recuperaDevolucaoItem(codigo, callback) {
    $.ajax({
        url: 'js/sqlscope_cadastroDevolucaoMaterial.php',
        dataType: 'html', 
        type: 'post',
        data: {funcao: 'recupera', codigo: codigo},      
        success: function (data) {
            callback(data); 
        }
    });
}