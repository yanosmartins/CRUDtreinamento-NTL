<?php

include "repositorio.php";

$funcao = $_POST["funcao"];

if ($funcao == 'recuperaCep') {
    call_user_func($funcao);
}

return;

function recuperaCep() {

    if (empty($_POST["cep"])) {
//        $mensagem = "Selecione uma registro.";
//        echo "failed#".$mensagem.' ';
//        echo "failed#";
        return;
    }

    $cep = $_POST["cep"];

    $out = '';
    $resultado_busca = busca_cep($cep);

    switch ($resultado_busca['resultado']) {
        case '2':
            //somente traz cidade e uf
            $out = "^^^^";
            break;
        case '1':
            $tipoLogradouro = $resultado_busca['tipo_logradouro'];
            $logradouro = $resultado_busca['logradouro'];
            $endereco = $tipoLogradouro . " " . $logradouro;
            $bairro = $resultado_busca['bairro'];
            $bairro = str_replace("'", " ", $bairro);
            $cidade = $resultado_busca['cidade'];
            $uf = mb_convert_encoding(trim($resultado_busca['uf']), 'UTF-8', 'HTML-ENTITIES');

            $out = $endereco . "^" . $bairro . "^" . $cidade . "^" . $uf;
            break;
        default:
            $out = "^^^^";
            break;
    }
    if ($out == "") {
        echo "failed#";
    }
    if ($out != '') {
        echo "sucess#" . $out . "";
    }
    return;
}

function busca_cep($cep) {
    $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep=' . urlencode($cep) . '&formato=query_string');
    if (!$resultado) {
        $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
    }
    parse_str($resultado, $retorno);
    return $retorno;
}
