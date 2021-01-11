<?php

class comum {

    function validaCPF($cpf = null) {

        // Verifica se um número foi informado
        if(empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $caracterMascara = array(".", "-");
        $cpf = str_replace($caracterMascara, '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
            return false;
         // Calcula os digitos verificadores para verificar se o
         // CPF é válido
         } else {   

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    function validaCNPJ($cnpj)
    {
        $caracterMascara = array(".", "-","/");
        $cnpj = str_replace($caracterMascara, '', $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
                return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
                return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }
    
    function ValidaLogin($login){
        if (preg_match('/\s/',$login)){
            return 1;
        }
        
        //Padrão para string com as seguintes regras
        //-iniciados por caracter alfabetico minusculo ou maiusculo
        //-não podendo haver caracteres especiais , acentuados e númericos
        $pattern = '/^[a-zA-Z]*$/';
        
        if (! preg_match($pattern, $login)){
            return 2;
        }
        
        if (strlen($login)<5){
            return 3;
        }

        if (strlen($login)>15){
            return 4;
        }
                
        return 0;
    }
    
    function ValidaSenha($senha){
        if (preg_match('/\s/',$senha)){
            return 1;
        }
        
        $pattern = '/^[a-zA-Z0-9\!\#\$\&\*\-\+\?\.\;\,\:\]\[\(\)]*$/';
        if (!preg_match($pattern, $senha)){
            return 7;
        }
        
        
        if (strlen($senha)<7){
            return 2;
        }

        if (strlen($senha)>15){
            return 3;
        }
        
        $arrayNumerico=array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $arrayAlfabetico=array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
                               "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $arrayEspeciais=array("!", "#", "$", "&", "*", "-", "+", "?", ".", ";", ",", ":", "]", "[", "(", ")");
        $caracter = "";
        $achouCaracterAcentuado = false;
        $achouCaracterNumerico = false;
        $achouCaracterAlfabetico = false;
        $achouCaracterEspecial = false;
        $podeExecutar = false;
        
        $palavra = $senha;
        for ($i = 0; $i <= (strlen($palavra)-1); $i++) {
            $podeExecutar = true;
            $caracter = $palavra[$i];
            
            $pattern = '/^[a-zA-Z0-9\!\#\$\&\*\-\+\?\.\;\,\:\]\[\(\)]*$/';
            if ((!preg_match($pattern, $caracter)) && ($podeExecutar)){
              $achouCaracterAcentuado = true;  
              $podeExecutar = false;
            }
            if ((in_array($caracter,$arrayNumerico)) && ($podeExecutar)){
              $achouCaracterNumerico = true;  
              $podeExecutar = false;
            }
            if ((in_array($caracter,$arrayAlfabetico)) && ($podeExecutar)){
              $achouCaracterAlfabetico = true;  
              $podeExecutar = false;
            }
            if ((in_array($caracter,$arrayEspeciais)) && ($podeExecutar)){
              $achouCaracterEspecial = true;  
              $podeExecutar = false;
            }
        }
        if ((!$achouCaracterNumerico) or (!$achouCaracterAlfabetico) or (!$achouCaracterEspecial) or ($achouCaracterAcentuado)){
            if (!$achouCaracterNumerico){
                return 4;
            }
            if (!$achouCaracterAlfabetico){
                return 5;
            }
            if (!$achouCaracterEspecial){
                return 6;
            }
            if ($achouCaracterAcentuado){
                return 7;
            }
        }
                
        return 0;
    }
    
//    function criptografia($cadeiaCaracter)
//    {
//        $cripto= "";
//        for($i=0; $i<strlen($cadeiaCaracter) ; $i++){
//            //Comentado pois é o mesmo calculo abaixo
//            //$wcaracter = substr($cadeiaCaracter,$i,1);
//            //$wascii= ord($wcaracter);
//            //$wxor = $wascii ^ 127;
//            //$wor = $wxor | 128;
//            //$wchr = chr($zxxx);      
//            //$wcaraccripto = mb_convert_encoding($wchr, 'UTF-8', 'HTML-ENTITIES');
//            //        
//            //$cripto .= $wcaraccripto;
//
//            $cripto = $cripto.mb_convert_encoding(chr((ord(substr($cadeiaCaracter,$i,1)) ^ 127) | 128), 'UTF-8', 'HTML-ENTITIES') ;
//        }   
//        return $cripto;
//    }
    
    function criptografia($cadeiaCaracter)
    {
        $cripto= md5($cadeiaCaracter);
        return $cripto;
    }
    
    function validaNumero($value)
{
    return floatval($value);
}

function validaString($value)
{
    if ($value == '')
        return NULL;
    return '\'' . $value . '\'';
}

function validaData($value)
{
    $value = explode("/", $value);
    $value = $value[2] . "/" . $value[1] . "/" . $value[0];
    $value = "'" . $value . "'";
    return $value;
}

function validaDataXML($value)
{
    $value = explode("/", $value);
    $value = $value[2] . "/" . $value[1] . "/" . $value[0];

    return $value;
}

function validaDataInversa($campo)
{
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}

}
