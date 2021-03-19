<?php
include "repositorio.php";

$funcao  = $_POST["funcao"];

if ($funcao == 'grava') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PERMISSAOUSUARIO_ACESSAR|PERMISSAOUSUARIO_GRAVAR|PERMISSAOCADASTRO_ACESSAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $condicaoIdUsuario = !((empty($_POST["codigoGrupoUsuario"])) || (!isset($_POST["codigoGrupoUsuario"])) || (is_null($_POST["codigoGrupoUsuario"])));

    if ($condicaoIdUsuario === false) {
        $mensagem = "Informe o usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoIdUsuario) {
        $idUsuarioGrupo = (int) $_POST["codigoGrupoUsuario"];
    }


    $strArrayFuncionalidade = $_POST["jsonFuncMarcadas"];
    if ((empty($_POST['jsonFuncMarcadas'])) || (!isset($_POST['jsonFuncMarcadas'])) || (is_null($_POST['jsonFuncMarcadas']))) {
        $mensagem = "Informe pelo menos uma funcionalidade permitida para o usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $arrayFuncionalidade = json_decode($strArrayFuncionalidade, true);

    $xmlFuncionalidade = "";
    $nomeXml = "ArrayOfUsuarioGrupoFuncionalidade";
    $nomeTabela = "usuarioGrupoFuncionalidade";
    if (sizeof($arrayFuncionalidade) > 0) {
        $xmlFuncionalidade = '<?xml version="1.0"?>';
        $xmlFuncionalidade = $xmlFuncionalidade . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayFuncionalidade as $chave) {
            $xmlFuncionalidade = $xmlFuncionalidade . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if ($campo === "idFuncionalidade") {
                    $xmlFuncionalidade = $xmlFuncionalidade . "<" . $campo . ">" . $valor . "</" . $campo . ">";
                }
            }
            $xmlFuncionalidade = $xmlFuncionalidade . "</" . $nomeTabela . ">";
        }
        $xmlFuncionalidade = $xmlFuncionalidade . "</" . $nomeXml . ">";
    } else {
        $xmlFuncionalidade = '<?xml version="1.0"?>';
        $xmlFuncionalidade = $xmlFuncionalidade . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlFuncionalidade = $xmlFuncionalidade . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlFuncionalidade);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de usuario funcionalidade";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlFuncionalidade = "'" . $xmlFuncionalidade . "'";


    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'" . $usuario . "'";

    $sql = "Ntl.usuarioGrupoFuncionalidade_AtualizaPermissoesUsuario " . $idUsuarioGrupo . "," . $usuario . "," . $xmlFuncionalidade . " ";
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
    $condicaoIdUsuario = !((empty($_POST["codigoGrupoUsuario"])) || (!isset($_POST["codigoGrupoUsuario"])) || (is_null($_POST["codigoGrupoUsuario"])));

    if ($condicaoIdUsuario === false) {
        $mensagem = "Informe o usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoIdUsuario) {
        $idUsuario = (int) $_POST["codigoGrupoUsuario"];
    }

    $sql = " SELECT USUF.codigo,USUF.funcionalidade
           FROM Ntl.usuarioGrupoFuncionalidade USUF
           INNER JOIN Ntl.usuarioGrupo USU on USU.codigo = USUF.grupo
           INNER JOIN Ntl.funcionalidade FNC on FNC.codigo = USUF.funcionalidade ";
    $sql = $sql . " WHERE (0=0) AND USU.ativo = 1 AND USUF.grupo = " . $idUsuario;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $arrayPermissao = array();
    foreach($result as $row) {
        array_push($arrayPermissao, +$row["funcionalidade"]);
    }

    $sql = " SELECT FNC.codigo,FNC.nome,FNC.nomeCompleto,FNC.menuItem
           FROM Ntl.funcionalidade FNC
           INNER JOIN Ntl.menuItem SMI ON SMI.codigo = FNC.menuItem ";
    $where = "WHERE (0=0) ";

    $orderby = " ORDER BY SMI.codigo, FNC.codigo ";

    $sql = $sql . $where . $orderby;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $arrayFuncionalidade = array();
    foreach($result as $row) {
        $idFuncionalidade = +$row['codigo'];

        $marcado = 0;
        if (in_array($idFuncionalidade, $arrayPermissao, true)) {
            $marcado = 1;
        }

        $idMenuItem = +$row['menuItem'];
        $nomeCompleto = $row['nomeCompleto'];
        $nome = $row['nome'];
        $arrayFuncionalidade[] = array(
            "idFuncionalidade" => $idFuncionalidade,
            "nome" => $nome,
            "nomeCompleto" => $nomeCompleto,
            "idMenuItem" => $idMenuItem,
            "marcado" => $marcado
        );
    }

    $strArrayFuncionalidade = json_encode($arrayFuncionalidade);

    echo "sucess#" . $strArrayFuncionalidade . " ";

    return;
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PERMISSAOUSUARIO_ACESSAR|PERMISSAOUSUARIO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }


    $condicaoIdUsuario = !((empty($_POST["codigoUsuario"])) || (!isset($_POST["codigoUsuario"])) || (is_null($_POST["codigoUsuario"])));

    if ($condicaoIdUsuario === false) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoIdUsuario) {
        $idUsuario = (int) $_POST["codigoUsuario"];
    }

    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'" . $usuario . "'";

    $sql = "usuarioGrupoFuncionalidade_DeletaTodasPermissoesUsuario " . $idUsuario . "," . $usuario . " ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    if ($result < 1) {
        echo ('failed');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
