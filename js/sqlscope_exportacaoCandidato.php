<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'exportarCandidatos') {
    call_user_func($funcao);
}

return;

function exportarCandidatos()
{
    $reposit = new reposit();
    $girComum = new comum();

    $possuiPermissao = $reposit->PossuiPermissao("CANDIDATO_ACESSAR|CANDIDATO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }


    //XML TITULO PAGAR
    $arrayFuncionario = $_POST["arrayFuncionario"];
    // $arrayFuncionario = json_decode($arrayFuncionario, true);
    $xmlFuncionario = new \FluidXml\FluidXml('ArrayOfFuncionario', ['encoding' => '']);
    foreach ($arrayFuncionario as $item) {
        $xmlFuncionario->addChild('funcionario', true)
            ->add('codigo', (int) $item['id']);
    }
    $xmlFuncionario = $girComum->formatarString($xmlFuncionario);


    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}
