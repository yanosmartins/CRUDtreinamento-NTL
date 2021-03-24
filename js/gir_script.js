pageSetUp();

$(function () {
    $(document).ajaxStart(function () {
        showLoading();
    });

    $(document).ajaxStop(function () {
        hideLoading();
    });
});

function showLoading() {
    $("#generalLoading").show();
    $("#overlay").show();
}

function hideLoading() {
    $("#generalLoading").hide();
    $("#overlay").hide();
}


$(document).ready(function () {
    jQuery.validator.addMethod(
            'date',
            function (value, element, params) {
                if (this.optional(element)) {
                    return true;
                }
                ;
                var result = false;
                try {
                    $.datepicker.parseDate('dd/mm/yy', value);
                    result = true;
                } catch (err) {
                    result = false;
                }
                return result;
            }
    );
});

(function (factory) {
    if (typeof define === "function" && define.amd) {
        // AMD. Register as an anonymous module.
        define(["../jquery.ui.datepicker"], factory);
    } else {
        // Browser globals
        factory(jQuery.datepicker);
    }
}
(function (datepicker) {
    datepicker.regional['pt-BR'] = {
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    };
    datepicker.setDefaults(datepicker.regional['pt-BR']);

    return datepicker.regional['pt-BR'];
}));


function smartAlert(title, message, type) {
    var color = "";
    var icon = "";
    switch (type.toLowerCase()) {
        case 'error':
            color = "#c26565";
            icon = "fa fa-times";
            break;
        case 'success':
            color = "#cde0c4";
            icon = "fa fa-check";
            break;
        case 'warning':
            color = "#efe1b3";
            icon = "fa fa-warning";
            break;
        case 'info':
        default:
            color = "#d6dde7";
            icon = "fa fa-info-circle";
            break;
    }

    $.smallBox({
        title: title,
        content: message.replace("\n", "<br />"),
        color: color,
        timeout: 5000,
        icon: icon
    });
    $('.SmallBox:has(i.fa-times)').addClass('text-color-error');
    $('.SmallBox:has(i.fa-check)').addClass('text-color-success');
    $('.SmallBox:has(i.fa-warning)').addClass('text-color-warning');
    $('.SmallBox:has(i.fa-info-circle)').addClass('text-color-info');
}

$(document).ready(function () {
    initializeDecimalBehaviour();
});

function initializeDecimalBehaviour() {
    formataValorComCasasDecimais('.decimal-2-casas', 14, 2);
    formataValorComCasasDecimais('.decimal-4-casas', 14, 4);
    formataValorComCasasDecimais('.decimal-5-casas', 14, 5);
    formataValorComCasasDecimais('.decimal-7-casas', 14, 7);

}

function formataValorComCasasDecimais(elemento, tamanho, casasDecimais) {
    if (tamanho === 'undefined') {
        tamanho = 14;
    }
    if (casasDecimais === 'undefined') {
        casasDecimais = 2;
    }

    $(elemento).priceFormat({
        limit: tamanho,
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.',
        centsLimit: casasDecimais,
        allowNegative: true
    });
}

function roundDecimal(value, precision) {
    var originalValue = 0 + value;
    var fatorDePrecisao = 1; //Para resolver problema de arredondamento do toFixed();
    for (i = 0; i < precision; i++)
        fatorDePrecisao *= 10;

    if (value !== null) {
        var sinal = value.toString().substring(0, 1);
        if (sinal === "-") {
            originalValue = sinal + 0 + value.toString().substring(1, value.length);
        }
    }
    originalValue = Math.round(parseFloat(stringToFloat(originalValue.toString())) * fatorDePrecisao) / fatorDePrecisao;

    var roundedValue = originalValue.toFixed(precision);
    return roundedValue.replace(".", ",");
}

function floatToString(value) {
    if (value !== null)
        value = value.toString().replace(".", ",");
    return value;
}

function stringToFloat(value) {
    return parseFloat(value.toString().replace(/\./g, "").replace(",", "."));
    ;
}

function isValidDate(format, value)
{
    var isValid = true;

    try {
        jQuery.datepicker.parseDate(format, value);
    } catch (error) {
        isValid = false;
    }

    return isValid;
}

$(document).on('input', '.numeric', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function calculaDifDatas(dataIni, dataFim, tipo) {
    //os parametros dataIni e dataFim devem ser do tipo data
    var diferenca = 0;

    if (Object.prototype.toString.call(dataIni) !== '[object Date]') {
        diferenca = -999;
        return diferenca;
    }

    if (Object.prototype.toString.call(dataFim) !== '[object Date]') {
        diferenca = -999;
        return diferenca;
    }

    dataIni.setHours(0);
    dataIni.setMinutes(0);
    dataIni.setSeconds(0);
    dataIni.setMilliseconds(0);

    dataFim.setHours(0);
    dataFim.setMinutes(0);
    dataFim.setSeconds(0);
    dataFim.setMilliseconds(0);

    switch (tipo) {
        case 'D': // diferença de dias
            diferenca = Math.floor((dataFim.getTime() - dataIni.getTime()) / (1000 * 60 * 60 * 24));
            break;
        case 'M': // diferença de meses
            diferenca = Math.floor((dataFim.getTime() - dataIni.getTime()) / (1000 * 60 * 60 * 24 * 30));
            break;
        case 'Y': // diferenca de anos
            diferenca = Math.floor((dataFim.getTime() - dataIni.getTime()) / (1000 * 60 * 60 * 24 * 365.25));
            break;
        default:
            diferenca = -999;
    }

    return diferenca;

}

function highlight(data, search) {
    return data.replace(new RegExp("(" + stringToRegExp(search) + ")", 'gi'), "<strong>$1</strong>");
}

function stringToRegExp(str) {
    return (str + '').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
}

function getTime() {
    var time = $('#time').val();
    return (time.indexOf(':') === 1 ? '0' + time : time) + ':00';
}

function formataDataCOMPARA(dataPar) {
    var data = dataPar;
    var dia = data.getDate();
    if (dia.toString().length === 1)
        dia = "0" + dia;
    var mes = data.getMonth() + 1;
    if (mes.toString().length === 1)
        mes = "0" + mes;
    var ano = data.getFullYear();
    dia = dia.toString();
    mes = mes.toString();
    ano = ano.toString();
    return ano + mes + dia;
}

function setarUnidadeClinicaPrincipal(codigoUnidade) {
    $.ajax({
        url: 'js/sqlscopeUsuario.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "alterarUnidadePrincipal", codigoUnidade: codigoUnidade}, //valores enviados ao script     
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
                    smartAlert("Atenção", "Ocorreu falha ao selecionar a unidade. Motivo:" + mensagem, "error");
                }
                return;
            } else {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");
                var mensagem = piece[1];

                var out = piece[1];
                piece = out.split("^");
                var nomeUnidade = piece[0];
                $("#project-selector").html("Unidade <b>" + nomeUnidade + "</b> <i class='fa fa-angle-down'></i>");
                //window.location.assign("index.php");

                $.event.trigger({
                    type: "unidadeClinicaModificada"
                });

                return;
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return;

}

function calculaIdadeAnoMesDia(dataNascimento, dataAtual) {

    var dia = dataNascimento.getDate();
    if (dia.toString().length === 1) {
        dia = "0" + dia;
    }
    var mes = dataNascimento.getMonth() + 1;
    if (mes.toString().length === 1) {
        mes = "0" + mes;
    }
    var ano = dataNascimento.getFullYear();
    dia = dia.toString();
    mes = mes.toString();
    ano = ano.toString();

    var dataNascStr = dia + '/' + mes + '/' + ano;

    var dia = dataAtual.getDate();
    if (dia.toString().length === 1) {
        dia = "0" + dia;
    }
    var mes = dataAtual.getMonth() + 1;
    if (mes.toString().length === 1) {
        mes = "0" + mes;
    }
    var ano = dataAtual.getFullYear();
    dia = dia.toString();
    mes = mes.toString();
    ano = ano.toString();

    var dataHojeStr = dia + '/' + mes + '/' + ano;

    var dataNasc = dataNascimento;
    var dataHoje = dataAtual;

    var diffAnos = calculaDifDatas(dataNasc, dataHoje, 'Y');

    var dataNascArray = dataNascStr.split("/");
    var diaNasc = dataNascArray[0];
    var mesNasc = dataNascArray[1];
    var anoNasc = dataNascArray[2];

    var dataHojeArray = dataHojeStr.split("/");
    var diaHoje = dataHojeArray[0];
    var mesHoje = dataHojeArray[1];
    var anoHoje = dataHojeArray[2];

    var format = "dd/mm/yy";

    var dataUltimoAniv = diaNasc + "/" + mesNasc + "/" + anoHoje;
    if (!(isValidDate(format, dataUltimoAniv))) {
        if ((diaNasc === '29') & (mesNasc === '02')) {
            dataUltimoAniv = '28' + "/" + mesNasc + "/" + anoHoje;
        } else {
            dataUltimoAniv = '30' + "/" + mesNasc + "/" + anoHoje;
        }
    }

    var dataUltimoAniversario;
    if (isValidDate(format, dataUltimoAniv)) {
        dataUltimoAniversario = jQuery.datepicker.parseDate(format, dataUltimoAniv);
        dataUltimoAniversario.setDate(dataUltimoAniversario.getDate(format) + 0);
    }

    var dia;
    var mes;
    var ano;
    if (dataUltimoAniversario > dataHoje) {
        dia = diaNasc;
        mes = mesNasc;
        ano = ((+anoHoje) - 1);

        if (mes.toString().length === 1) {
            mes = "0" + mes;
        }

        dataUltimoAniv = dia + "/" + mes + "/" + ano;
        if (!(isValidDate(format, dataUltimoAniv))) {
            if ((dia === '29') & (mes === '02')) {
                dataUltimoAniv = '28' + "/" + mes + "/" + ano;
            } else {
                dataUltimoAniv = '30' + "/" + mes + "/" + ano;
            }
        }

        if (isValidDate(format, dataUltimoAniv)) {
            dataUltimoAniversario = jQuery.datepicker.parseDate(format, dataUltimoAniv);
            dataUltimoAniversario.setDate(dataUltimoAniversario.getDate(format) + 0);
        }
    }

    var dataUltimoAnivMes = diaNasc + "/" + mesHoje + "/" + anoHoje;
    if (!(isValidDate(format, dataUltimoAnivMes))) {
        if ((diaNasc === '29') & (mesHoje === '02')) {
            dataUltimoAnivMes = '28' + "/" + mesHoje + "/" + anoHoje;
        } else {
            dataUltimoAnivMes = '30' + "/" + mesHoje + "/" + anoHoje;
        }
    }

    var dataUltimoAniversarioMes;
    if (isValidDate(format, dataUltimoAnivMes)) {
        dataUltimoAniversarioMes = jQuery.datepicker.parseDate(format, dataUltimoAnivMes);
        dataUltimoAniversarioMes.setDate(dataUltimoAniversarioMes.getDate(format) + 0);
    }

    var dia;
    var mes;
    var ano;
    if (dataUltimoAniversarioMes > dataHoje) {
        dia = diaNasc;
        if (mesHoje === '01') {
            ano = ((+anoHoje) - 1);
            mes = '12';
        } else {
            mes = ((+mesHoje) - 1);
            ano = anoHoje;
        }

        if (mes.toString().length === 1) {
            mes = "0" + mes;
        }

        dataUltimoAnivMes = dia + "/" + mes + "/" + ano;
        if (!(isValidDate(format, dataUltimoAnivMes))) {
            if ((dia === '29') & (mes === '02')) {
                dataUltimoAnivMes = '28' + "/" + mes + "/" + ano;
            } else {
                dataUltimoAnivMes = '30' + "/" + mes + "/" + ano;
            }
        }

        if (isValidDate(format, dataUltimoAnivMes)) {
            dataUltimoAniversarioMes = jQuery.datepicker.parseDate(format, dataUltimoAnivMes);
            dataUltimoAniversarioMes.setDate(dataUltimoAniversarioMes.getDate(format) + 0);
        }
    }

    var diffMeses = 0;
    var diffDias = 0;
    if (diffAnos === 0) {
        diffMeses = calculaDifDatas(dataNasc, dataHoje, 'M');
    } else {
        if (dataUltimoAniversario <= dataHoje) {
            diffMeses = calculaDifDatas(dataUltimoAniversario, dataUltimoAniversarioMes, 'M');
        } else {
            diffMeses = calculaDifDatas(dataUltimoAniversarioMes, dataHoje, 'M');
        }
    }

    diffDias = calculaDifDatas(dataUltimoAniversarioMes, dataHoje, 'D');

    return [diffAnos, diffMeses, diffDias];
}

function validacao_cpf(val) {

    if (val.match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) != null) {
        var val1 = val.substring(0, 3);
        var val2 = val.substring(4, 7);
        var val3 = val.substring(8, 11);
        var val4 = val.substring(12, 14);

        var i;
        var number;
        var result = true;

        number = (val1 + val2 + val3 + val4);

        s = number;
        c = s.substr(0, 9);
        var dv = s.substr(9, 2);
        var d1 = 0;

        for (i = 0; i < 9; i++) {
            d1 += c.charAt(i) * (10 - i);
        }

        if (d1 == 0)
            result = false;

        d1 = 11 - (d1 % 11);
        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(0) != d1)
            result = false;

        d1 *= 2;
        for (i = 0; i < 9; i++) {
            d1 += c.charAt(i) * (11 - i);
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(1) != d1)
            result = false;

        return result;
    }

    return false;
}

function validacao_cnpj(val) {

    if (val.match(/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/) != null) {
        var val1 = val.substring(0, 2);
        var val2 = val.substring(3, 6);
        var val3 = val.substring(7, 10);
        var val4 = val.substring(11, 15);
        var val5 = val.substring(16, 18);

        var i;
        var number;
        var result = true;

        number = (val1 + val2 + val3 + val4 + val5);

        s = number;

        c = s.substr(0, 12);
        var dv = s.substr(12, 2);
        var d1 = 0;

        for (i = 0; i < 12; i++)
            d1 += c.charAt(11 - i) * (2 + (i % 8));

        if (d1 == 0)
            result = false;

        d1 = 11 - (d1 % 11);

        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(0) != d1)
            result = false;

        d1 *= 2;
        for (i = 0; i < 12; i++) {
            d1 += c.charAt(11 - i) * (2 + ((i + 1) % 8));
        }

        d1 = 11 - (d1 % 11);
        if (d1 > 9)
            d1 = 0;

        if (dv.charAt(1) != d1)
            result = false;

        return result;
    }
    return false;
}

function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for (var key in params) {
        if (params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}



function validaPlaca(placa) {
    //let plate = "ABC1234";
    //let plateMerc = "ABC1D23"
    const regexPlaca = /^[a-zA-Z]{3}[0-9]{4}$/;
    const regexPlacaMerc = /^[a-zA-Z]{3}[0-9]{1}[a-zA-Z]{1}[0-9]{2}$/;

    if (regexPlaca.test(placa)) {
        console.warn('Placa válida (padrão atual)');
        return true;
    } else if (regexPlacaMerc.test(placa)) {
        console.warn('Placa válida (padrão mercosul)');
        return true;
    } else {
        console.error('Placa inválida no padrão atual e mercosul');
        return false;
    }
}

//Função que quebra uma string e transforma ela em um valor.
    function formataData(valor){
        var y = (parseInt(valor.split('/')[2]));
        var m = (parseInt(valor.split('/')[1]) - 1);
        var d = (parseInt(valor.split('/')[0]));
        valor = new Date(y,m,d); 
        return valor;
    }
    
    //Função que valida todas as datas
    function validaData(valor){
        var date=valor;
	var ardt=new Array;
	var ExpReg=new RegExp("(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}");
	ardt=date.split("/");
	erro=false;
	if ( date.search(ExpReg)==-1){
		erro = true;
		}
	else if (((ardt[1]==4)||(ardt[1]==6)||(ardt[1]==9)||(ardt[1]==11))&&(ardt[0]>30))
		erro = true;
	else if ( ardt[1]==2) {
		if ((ardt[0]>28)&&((ardt[2]%4)!=0))
			erro = true;
		if ((ardt[0]>29)&&((ardt[2]%4)==0))
			erro = true;
	}
	if (erro) {
		smartAlert("Erro", "O valor inserido é inválido.", "error"); 
		return false;
	}
	return true;
    }
    
//Função que permite digitar apenas letras em um campo html 
    function validaCampoApenasLetras(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[a-zåäöëïüãõçÇãõáÁàÀéÉèÈíÍìÌóÓòÒúÚùÙ' ]/i);
    return pattern.test(value);
    }

//Função que permite digitar apenas números em um campo html 
    function validaCampoApenasNumeros(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[0123456789]/i);
    return pattern.test(value);
    }

    function marcarDesmarcarTodos(idTabela) {
        let desmarcados = $('#' + idTabela + ' input:checkbox:not(:checked)').length;
        let marcados = $('#' + idTabela + ' input:checkbox:checked').length;
        if (marcados > desmarcados) {
            $('#' + idTabela + ' input:checkbox').prop("checked", false);
        } else {
            $('#' + idTabela + ' input:checkbox ').prop("checked", true);
        }
    }