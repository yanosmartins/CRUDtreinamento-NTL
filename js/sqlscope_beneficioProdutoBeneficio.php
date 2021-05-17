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

if ($funcao == 'listaFornecedorAutoComplete') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("REMUNERACAO_ACESSAR|REMUNERACAO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.

    $codigo = (int)$_POST['id'];
    $fornecedor = (int)$_POST['fornecedor'];
    $codigoProduto = $_POST['codigoProduto'];
    $nome = "'" . $_POST['nome'] . "'";
    $ativo = (int)$_POST['ativo'];

    $sql = "Beneficio.produtoBeneficio_Atualiza
            $codigo,
            $fornecedor,
            $nome,
            $codigoProduto,
            $ativo,
            $usuario";

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
        $codigo = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT PB.codigo,PB.fornecedor,PB.nome,PB.codigoBeneficio,PB.ativo,F.apelido
            FROM Beneficio.produtoBeneficio PB 
            LEFT JOIN Ntl.Fornecedor F ON F.codigo = PB.fornecedor
            WHERE (0 = 0)";

    if ($condicaoId) {
        $sql = $sql . " AND PB.codigo = " . $codigo . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        $id = (int)$row['codigo'];
        $fornecedor = $row['fornecedor'];
        $fornecedorApelido = $row['apelido'];
        $nome = $row['nome'];
        $codigoBeneficio = $row['codigoBeneficio'];
        $ativo = (int)$row['ativo'];

        $out = $id . "^" . $fornecedor . "^" . $nome . "^" . $codigoBeneficio . "^" . $ativo . "^" . $fornecedorApelido;
 
        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . " ";
        }
        return;
    }
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("REMUNERACAO_ACESSAR|REMUNERACAO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione uma remuneração";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Beneficio.produtoBeneficio' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function listaFornecedorAutoComplete()
{
    $condicaoDescricao = !((empty($_POST["descricaoIniciaCom"])) || (!isset($_POST["descricaoIniciaCom"])) || (is_null($_POST["descricaoIniciaCom"])));

    if ($condicaoDescricao === false) {
        return;
    }

    if ($condicaoDescricao) {
        $descricaoPesquisa = $_POST["descricaoIniciaCom"];
    }

    if ($condicaoDescricao == "") {
        $id = 0;
    }

    $reposit = new reposit();
    $sql = "SELECT codigo,apelido FROM Ntl.fornecedor WHERE (0=0) AND ativo = 1 AND apelido LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY apelido";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach($result as $row) {
        $id = $row['codigo'];
        $descricao = $row["apelido"];
        $contador = $contador + 1;
        $array[] = array("id" => $id, "apelido" => $descricao);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}
