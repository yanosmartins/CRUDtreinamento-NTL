<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'grava') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosUsuario') {
    call_user_func($funcao);
}

if ($funcao == 'gravarNovaSenha') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("USUARIO_ACESSAR|USUARIO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    if ((empty($_POST['id'])) || (!isset($_POST['id'])) || (is_null($_POST['id']))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = (int) $_POST["ativo"];
    }

    $nome = $_POST['nome'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $tipoUsuario = "'" . $tipoUsuario . "'";
    $nome = "'" . $nome . "'";

    $funcionario = (int)$_POST['funcionario'];
    if ($funcionario == 0) {
        $funcionario = 'NULL';
    }

    $login = $_POST["login"];
    if ((empty($_POST['login'])) || (!isset($_POST['login'])) || (is_null($_POST['login']))) {
        $mensagem = "Informe o login.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $comum = new comum();
        $login = trim($login);
        $validouLogin = $comum->validaLogin($login);

        if ($validouLogin === 0) {
            $login = "'" . $login . "'";
        } else {
            switch ($validouLogin) {
                case 1:
                    $mensagem = "Login não pode conter espaços.";
                    break;
                case 2:
                    $mensagem = "Login deve possuir caracteres alfabéticos e não pode conter caracteres acentuados e/ou especiais.";
                    break;
                case 3:
                    $mensagem = "Login deve possuir no mínimo 5 caracter.";
                    break;
                case 4:
                    $mensagem = "Login ultrapassou de 15 caracteres.";
                    break;
            }
            echo "failed#" . $mensagem . ' ';
            return;
        }
    }

    $senhaConfirma = $_POST["senhaConfirma"];
    $senha = $_POST["senha"];

    if ($id === 0) {
        if ((empty($_POST['senhaConfirma'])) || (!isset($_POST['senhaConfirma'])) || (is_null($_POST['senhaConfirma']))) {
            $mensagem = "Informe a confirmação da senha.";
            echo "failed#" . $mensagem . ' ';
            return;
        }
        if ((empty($_POST['senha'])) || (!isset($_POST['senha'])) || (is_null($_POST['senha']))) {
            $mensagem = "Informe a senha.";
            echo "failed#" . $mensagem . ' ';
            return;
        }
    } else {
        if ((empty($_POST['senhaConfirma'])) || (!isset($_POST['senhaConfirma'])) || (is_null($_POST['senhaConfirma']))) {
            $senhaConfirma = null;
        }
        if ((empty($_POST['senha'])) || (!isset($_POST['senha'])) || (is_null($_POST['senha']))) {
            $senha = null;
        }
    }

    if ((!is_null($senhaConfirma)) or (!is_null($senha))) {
        $comum = new comum();
        $validouSenha = 1;
        if (!is_null($senha)) {
            $validouSenha = $comum->validaSenha($senha);
        }
        if ($validouSenha === 0) {
            if ($senhaConfirma !== $senha) {
                $mensagem = "A confirmação da senha deve ser igual a senha.";
                echo "failed#" . $mensagem . ' ';
                return;
            } else {
                $comum = new comum();
                $senhaCript = $comum->criptografia($senha);
                $senha = "'" . $senhaCript . "'";
            }
        } else {
            switch ($validouSenha) {
                case 1:
                    $mensagem = "Senha não pode conter espaços.";
                    break;
                case 2:
                    $mensagem = "Senha deve possuir no mínimo 7 caracter.";
                    break;
                case 3:
                    $mensagem = "Senha ultrapassou de 15 caracteres.";
                    break;
                case 4:
                    $mensagem = "Senha deve possuir no mínimo um caractér númerico.";
                    break;
                case 5:
                    $mensagem = "Senha deve possuir no mínimo um caractér alfabético.";
                    break;
                case 6:
                    $mensagem = "Senha deve possuir no mínimo um caracter especial.\nSão válidos : ! # $ & * - + ? . ; , : ] [ ( )";
                    break;
                case 7:
                    $mensagem = "Senha não pode ter caracteres acentuados.";
                    break;
            }
            echo "failed#" . $mensagem . ' ';
            return;
        }
    }

    if (is_null($senha)) {
        $senha = "NULL";
    }

    if ((empty($_POST['tipoUsuario'])) || (!isset($_POST['tipoUsuario'])) || (is_null($_POST['tipoUsuario']))) {
        $tipoUsuario = 'NULL';
    } else {
        $tipoUsuario = "'" . $_POST["tipoUsuario"] . "'";
    }

    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'" . $usuario . "'";
    // if (validaUsuario($login) && $id == 0) {
    //     echo "failed#" . "Usuário já cadastrado!";
    //     return;
    // }

    $restaurarSenha = (int)$_POST['restaurarSenha'];

    $sql = "Ntl.usuario_Atualiza " . $id . "," . $ativo . "," . $login . "," . $senha . "," . $tipoUsuario . "," . $usuario . "," . $funcionario . "," . $restaurarSenha . " ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera()
{
    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    if (($condicaoId === false) && ($condicaoLogin === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if (($condicaoId === true) && ($condicaoLogin === true)) {
        $mensagem = "Somente 1 parâmetro de pesquisa deve ser informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoId) {
        $usuarioIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT codigo, nome, ativo, cpf, dataNascimento
    FROM dbo.funcionario WHERE (0=0)";

    // $sql = " SELECT USU.codigo,USU.[login],USU.ativo,tipoUsuario,funcionario,restaurarSenha
    //          FROM Ntl.usuario USU WHERE (0 = 0) ";

    if ($condicaoId) {
        $sql = $sql . " AND USU.codigo = " . $usuarioIdPesquisa . " ";
    }

    if ($condicaoLogin) {
        $sql = $sql . " AND USU.login = '" . $loginPesquisa . "' ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $login = $row['login'];
        $ativo = +$row['ativo'];
        $tipoUsuario = $row['tipoUsuario'];
        $funcionario = +$row['funcionario'];
        $restaurarSenha = +$row['restaurarSenha'];

        $codigo = (int)$row['codigo'];
        $nome = $row['nome'];
        $ativo = $row['ativo'];
        $cpf = $row['cpf'];
        $dataNascimento = $row['dataNascimento'];

    }

    $out =   $id . "^" .
        $login . "^" .
        $ativo . "^" .
        $tipoUsuario . "^" .
        $funcionario . "^" .
        $restaurarSenha;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}




function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("USUARIO_ACESSAR|USUARIO_EXCLUIR");

    $id = $_POST["codigo"];

    if ((empty($_POST['id'])  (!isset($_POST['id']))  (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }


    $result = $reposit->update('dbo.funcionarios' .'|'.'ativo = 0'.'|'.'id ='.$id);

    $reposit = new reposit();

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}





// function excluir()
// {

//     $reposit = new reposit();
//     $possuiPermissao = $reposit->PossuiPermissao("USUARIO_ACESSAR|USUARIO_EXCLUIR");

//     if ($possuiPermissao === 0) {
//         $mensagem = "O usuário não tem permissão para excluir!";
//         echo "failed#" . $mensagem . ' ';
//         return;
//     }

//     $codigo = $_POST["codigo"];

//     if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
//         $mensagem = "Selecione um usuário.";
//         echo "failed#" . $mensagem . ' ';
//         return;
//     }

//     session_start();
//     $usuario = $_SESSION['login'];
//     $usuario = "'" . $usuario . "'";
//     $codigo = 'codigo';

//     $sql = "DELETE nome, cpf, dataNascimento, ativo FROM dbo.funcionario WHERE codigo = ". $codigo;
//     // $sql = "usuario_Deleta " . $id . "," . $usuario . " ";

//     $reposit = new reposit();
//     $result = $reposit->Execprocedure($sql);

//     if ($result < 1) {
//         echo ('failed#');
//         return;
//     }

//     echo 'sucess#' . $result;
//     return;
// }



// function validaUsuario($login)
// {
//     $sql = "SELECT codigo,[login],ativo FROM Ntl.usuario
//     WHERE [login] LIKE $login and ativo = 1";

//     $reposit = new reposit();
//     $result = $reposit->RunQuery($sql);

//     if ($result[0]) {
//         return true;
//     } else {
//         return false;
//     }
// }





function recuperarDadosUsuario()
{

    session_start();
    $codigolocalizar = $_SESSION['codigo'];

    $sql = "SELECT codigo, nome, ativo, cpf, dataNascimento
    FROM dbo.funcionario WHERE (0=0) AND codigo = " . $codigolocalizar;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int)$row['codigo'];
        $nome = $row['nome'];
        $ativo = $row['ativo'];
        $cpf = $row['cpf'];
        $dataNascimento = $row['dataNascimento'];

    }

    $out = $codigo . "^" ;
        

    if ($out == "") {
        echo "failed#";
        return;
    }

        echo $ativo;
        echo$cpf;
        echo $nome;
        echo $dataNascimento;
    echo "sucess#" . $out;
    return;
}




function gravarNovaSenha()
{
    $reposit = new reposit();
    $senhaConfirma = $_POST["senhaConfirma"];
    $senha = $_POST["senha"];

    if ((empty($_POST['senhaConfirma'])) || (!isset($_POST['senhaConfirma'])) || (is_null($_POST['senhaConfirma']))) {
        $senhaConfirma = null;
    }
    if ((empty($_POST['senha'])) || (!isset($_POST['senha'])) || (is_null($_POST['senha']))) {
        $senha = null;
    }

    if ((!is_null($senhaConfirma)) or (!is_null($senha))) {
        $comum = new comum();
        $validouSenha = 1;
        if (!is_null($senha)) {
            $validouSenha = $comum->validaSenha($senha);
        }
        if ($validouSenha === 0) {
            if ($senhaConfirma !== $senha) {
                $mensagem = "A confirmação da senha deve ser igual a senha.";
                echo "failed#" . $mensagem . ' ';
                return;
            } else {
                $comum = new comum();
                $senhaCript = $comum->criptografia($senha);
                $senha = "'" . $senhaCript . "'";
            }
        } else {
            switch ($validouSenha) {
                case 1:
                    $mensagem = "Senha não pode conter espaços.";
                    break;
                case 2:
                    $mensagem = "Senha deve possuir no mínimo 7 caracter.";
                    break;
                case 3:
                    $mensagem = "Senha ultrapassou de 15 caracteres.";
                    break;
                case 4:
                    $mensagem = "Senha deve possuir no mínimo um caractér númerico.";
                    break;
                case 5:
                    $mensagem = "Senha deve possuir no mínimo um caractér alfabético.";
                    break;
                case 6:
                    $mensagem = "Senha deve possuir no mínimo um caracter especial.\nSão válidos : ! # $ & * - + ? . ; , : ] [ ( )";
                    break;
                case 7:
                    $mensagem = "Senha não pode ter caracteres acentuados.";
                    break;
            }
            echo "failed#" . $mensagem . ' ';
            return;
        }
    }

    session_start();
    $login = "'" .  $_SESSION['login'] . "'";
    $usuario =  $login;

    $id = $_SESSION['codigo'];
    $funcionario = $_SESSION['funcionario'];
    if (!$funcionario) {
        $funcionario = 'NULL';
    }
    $ativo = 1;
    $tipoUsuario = 'C';
    $restaurarSenha = 0;

    $sql = "Ntl.usuario_Atualiza " . $id . "," . $ativo . "," . $login . "," . $senha . "," . $tipoUsuario . "," . $usuario . "," . $funcionario . "," . $restaurarSenha . " ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';

    if ($result < 1) {
        $ret = 'failed#';
    }

    echo $ret;
    return;
}
