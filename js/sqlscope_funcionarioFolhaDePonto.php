<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];


if ($funcao == 'recupera') {
    call_user_func($funcao);
}

return;

function recupera()
{
    if ((empty($_POST["projeto"])) || (!isset($_POST["projeto"])) || (is_null($_POST["projeto"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $projeto = (int)$_POST["projeto"];
    }

    //Montando array de tarefas  
    $reposit = "";
    $result = "";
    $sql = "SELECT B.funcionario FROM ntl.beneficioProjeto AS B 
    LEFT JOIN ntl.funcionario F ON F.codigo =  B.funcionario
    WHERE (0=0) AND B.ativo = 1 AND F.ativo = 1 AND B.projeto =" . $projeto;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorProjeto = 0;
    $arrayProjeto = array();
    foreach($result as $row) {

        $funcionario = (int)$row['funcionario'];

        $contadorProjeto = $contadorProjeto + 1;
        $arrayProjeto[] = array(
            $funcionario
        );
    }

    $strArrayProjeto = json_encode($arrayProjeto);

    if ($strArrayProjeto == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $strArrayProjeto;
    return;
}

