<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];


if ($funcao == 'validaSenha') {
    call_user_func($funcao);
}
return;

function validaSenha() {
    $login = $_POST["login"];
    $senha = $_POST["senha"];
    $comum = new comum();
    $senhaCript = $comum->criptografia($senha);
    $reposit = new reposit();
    $result = $reposit->SelectCondTrue("usuario| login='" . $login . "' AND CAST(login as varbinary(100)) = CAST('" . $login . "' as varbinary(100)) and ativo = 1");
    if ($row = $result) {
        $nome = $row['nome'];
        $senhaBanco = mb_convert_encoding($row['senha'], 'UTF-8', 'HTML-ENTITIES');
        $reposit->FechaConexao();
        if ($senhaCript == $senhaBanco) {
            session_start();
            $_SESSION['login'] = $login;
            define("login", $login);
            session_write_close();
            echo('sucess#' . $nome . '#' . $login);
        } else {
            echo('failed ') . $senha;
        }
    } else {
        echo('failed ') . $senha;
    }
}

