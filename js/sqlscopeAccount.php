<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];


if ($funcao == 'validaSenha') {
    call_user_func($funcao);
}
return;

function validaSenha()
{
    $login = $_POST["login"];
    $senha = $_POST["senha"];
    $comum = new comum();
    $senhaCript = $comum->criptografia($senha);
    $reposit = new reposit();
    $result = $reposit->SelectCondTrue("usuario| login='" . $login . "' AND CAST(login as varbinary(100)) = CAST('" . $login . "' as varbinary(100)) and ativo = 1");

    if ($row = $result[0]) {
        $codigo = $row['codigo'];
        $funcionario = $row['funcionario'];
        $nome = $row['nome'];
        $senhaBanco = $row['senha'];
        $reposit->FechaConexao();
        if ($funcionario) {
            $sql = " SELECT BP.codigo, BP.funcionario, BP.projeto
            FROM Ntl.beneficioProjeto BP WHERE BP.funcionario = $funcionario";
            $result = $reposit->RunQuery($sql);

            if ($row = $result[0]) {
                $projeto = $row['projeto'];
            }
        }


        if ($senhaCript == $senhaBanco) {
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['codigo'] = $codigo;
            $_SESSION['funcionario'] = $funcionario;
            $_SESSION['projeto'] = $projeto;

            define("login", $login);
            session_write_close();
            echo ('sucess#' . $nome . '#' . $login);
        } else {
            echo ('failed ') . $senha;
        }
    } else {
        echo ('failed ') . $senha;
    }
}
