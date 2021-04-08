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
if ($funcao == 'recuperaQuantidadeEstoque') {
    call_user_func($funcao);
}
if ($funcao == 'recuperaDescricaoCodigo') {
    call_user_func($funcao);
}
if ($funcao == 'listaSolicitanteAtivoAutoComplete') {
    call_user_func($funcao);
}
if ($funcao == 'listaDescricaoAtivoAutoComplete') {
    call_user_func($funcao);
}
if ($funcao == 'listaCodigoAtivoAutoComplete') {
    call_user_func($funcao);
}
if ($funcao == 'listaClienteFornecedorAtivoAutoComplete') {
    call_user_func($funcao);
}
if ($funcao == 'populaComboEstoque') {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit(); //Abre a conexão.  

    $possuiPermissao = $reposit->PossuiPermissao("ENTRADAITEM_ACESSAR|ENTRADAITEM_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";

    // Gravação do formulário no banco de dados. 
    $codigo =  (int)$_POST['codigo'] ?: 0;
    $dataMovimento = validaData($_POST['dataMovimento']);
    $horaMovimento = $_POST['horaMovimento'];
    $clienteFornecedor = (int)$_POST['clienteFornecedorId'] ?: 0;
    $solicitante = (int)$_POST['solicitanteId'] ?: 0;
    $aprovado = (int)$_POST['aprovado'] ?: 0;
    $responsavel = (int)$_SESSION['funcionario'] ?: 0;
    $projeto = (int)$_POST['projeto'] ?: 0;

    $strArrayItem = $_POST['jsonItem'];
    $arrayItem = json_decode($strArrayItem, true);
    $xmlItem = "";
    $nomeXml = "ArrayOfItem";
    $nomeTabela = "entradaMaterial";
    if (sizeof($arrayItem) > 0) {
        $xmlItem = '<?xml version="1.0"?>';
        $xmlItem = $xmlItem . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayItem as $chave) {
            $xmlItem = $xmlItem . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialItem" || $campo === "itemId")) {
                    continue;
                }
                if (($campo === "unitario") || ($campo === "desconto") || ($campo === "final")) {
                    $valor = str_replace(".", "", $valor);
                    $valor = str_replace(",", ".", $valor);
                }
                $xmlItem = $xmlItem . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlItem = $xmlItem . "</" . $nomeTabela . ">";
        }
        $xmlItem = $xmlItem . "</" . $nomeXml . ">";
    } else {
        $xmlItem = '<?xml version="1.0"?>';
        $xmlItem = $xmlItem . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlItem = $xmlItem . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlItem);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de tarefa!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlItem = "'" . $xmlItem . "'";


    $sql = "Estoque.pedidoMaterial_Atualiza
        $codigo,
        $dataMovimento,  
        $clienteFornecedor,
        $solicitante,
        $responsavel,
        $projeto,
        $aprovado,
        $usuario, 
        $xmlItem
        ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success';
    if ($result < 1) {
        $ret = 'failed';
    }
    echo $ret;
    return;
}

function recupera()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $codigo = +$_POST["codigo"];
    }

    $sql = "SELECT PM.codigo, PM.fornecedor, F.apelido, PM.projeto, P.descricao AS descricaoProjeto, 
    PM.solicitante, FS.nome AS descricaoSolicitante, PM.responsavel, FR.nome AS descricaoResponsavel, PM.aprovado, PM.dataCadastramento
        FROM Estoque.pedidoMaterial PM
        LEFT JOIN Ntl.fornecedor F ON F.codigo = PM.fornecedor
        LEFT JOIN Ntl.projeto P ON P.codigo = PM.projeto
        LEFT JOIN Ntl.funcionario FS ON FS.codigo = PM.solicitante
        LEFT JOIN Ntl.funcionario FR ON FR.codigo = PM.responsavel
        WHERE (0=0) AND
        PM.codigo = " . $codigo;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0])
    $codigo = (int)$row['codigo'];
    $fornecedorID = (int)$row['fornecedor'];
    $descricaoFornecedor = $row['apelido'];
    $solicitanteID = (int)$row['solicitante'];
    $descricaoSolicitante = $row['descricaoSolicitante'];
    $responsavelID = (int)$row['responsavel'];
    $descricaoResponsavel = $row['descricaoResponsavel'];
    $aprovado = (int)$row['aprovado'];
    $projeto = (int)$row['projeto'];
    $dataCadastramento = $row['dataCadastramento'];


    //Montando array de itens  
    $reposit = "";
    $result = "";
    $sql = "SELECT PMI.codigo,PMI.pedidoMaterial, PMI.material, CI.codigoItem, PMI.estoque,
    E.descricao AS descricaoEstoque, PMI.quantidade, CI.descricaoItem, PMI.unidade,
    U.descricao AS descricaoUnidade, CI.unidadeItem, UI.descricao AS descricaoUnidadeItem,
    PMI.situacao
    FROM Estoque.pedidoMaterialItem PMI
    LEFT JOIN Estoque.codigoItem CI ON CI.codigo = PMI.material
    LEFT JOIN Estoque.estoque E ON E.codigo = PMI.estoque
    LEFT JOIN Ntl.unidade U ON U.codigo = PMI.unidade
    LEFT JOIN Estoque.unidadeItem UI ON UI.codigo = CI.unidadeItem
    WHERE (0=0) AND PMI.pedidoMaterial = " . $codigo;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorItem = 0;
    $arrayItem = array();
    foreach ($result as $row) {

        $material = (int)$row['material'];
        $codigoItem = $row['codigoItem'];
        $estoque = $row['estoque'];
        $descricaoEstoque = $row['descricaoEstoque'];
        $quantidade =  number_format($row['quantidade'], 0, '', '');
        $descricaoItem = $row['descricaoItem'];
        $unidade = $row['unidade'];
        $descricaoUnidade = $row['descricaoUnidade'];
        $descricaoUnidadeMedida = $row['descricaoUnidadeItem'];
        $situacao = $row['situacao'];
        
        $contadorItem = $contadorItem + 1;
        $arrayItem[] = array(
            "sequencialItem" => $contadorItem,
            "codigoItemId" => $material,
            "descricaoItemId" => $material,
            "codigoItemFiltro" => $codigoItem,
            "descricaoItemFiltro" => $descricaoItem,
            "estoqueDestino" => $estoque,
            "descricaoEstoque" => $descricaoEstoque,
            "quantidade" => $quantidade,
            "unidadeDestino" => $unidade,
            "descricaoUnidade" => $descricaoUnidade,
            "descricaoUnidadeMedida" => $descricaoUnidadeMedida,
            "situacao" => $situacao,
            "unidade" => $unidade
        );
    }

    $strArrayItem = json_encode($arrayItem);

    $out =   $codigo . "^" .
        $fornecedorID . "^" .
        $descricaoFornecedor . "^" .
        $solicitanteID . "^" .
        $descricaoSolicitante . "^" .
        $responsavelID . "^" .
        $descricaoResponsavel . "^" .
        $projeto . "^" .
        $aprovado . "^" .
        $dataCadastramento;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayItem;
    return;
}


function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("ENTRADAITEM_ACESSAR|ENTRADAITEM_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $codigo = $_POST["codigo"];

    if ((empty($_POST['codigo']) || (!isset($_POST['codigo'])) || (is_null($_POST['codigo'])))) {
        $mensagem = "Selecione uma entrada Material.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $sql = "Estoque.entradaMaterial_Deleta $codigo";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success';
    if ($result < 1) {
        $ret = 'failed';
    }
    echo $ret;
    return;
}


function recuperaQuantidadeEstoque()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int)$_POST["codigo"];
    }

    if ((empty($_POST["estoque"])) || (!isset($_POST["estoque"])) || (is_null($_POST["estoque"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $estoque = $_POST["estoque"];
    }


    $reposit = new reposit();

    $sql = "SELECT COUNT(codigo) AS quantidade FROM Estoque.estoqueMovimento WHERE situacaoItem = 1 AND material =" . $id . " AND estoque =" . $estoque;
    $result = $reposit->RunQuery($sql);
    if ($row = $result[0]) {
        $quantidade = (int)$row['quantidade'];
    }

    $out =   $quantidade;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function listaSolicitanteAtivoAutoComplete()
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
    $sql = "SELECT F.codigo, F.nome, U.login
    FROM Ntl.funcionario F
    LEFT JOIN NTL.usuario U ON U.funcionario = F.codigo
    WHERE (0=0) AND F.ativo = 1 AND U.login IS NOT NULL
    AND F.nome LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY F.nome";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach ($result as $row) {
        $id = $row['codigo'];
        $descricao = $row["nome"];
        $login = $row["login"];
        $contador = $contador + 1;
        $array[] = array("id" => $id, "descricao" => $descricao, "login" => $login);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}

function listaDescricaoAtivoAutoComplete()
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
    $sql = "SELECT * FROM Estoque.codigoItem WHERE (0=0) AND ativo = 1 
    AND descricaoItem LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY descricaoItem";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach ($result as $row) {
        $id = $row['codigo'];
        $codigoItem = $row['codigoItem'];
        $estoque = $row['estoque'];
        $unidade = $row['unidade'];
        $unidadeItem = $row['unidadeItem'];
        $consumivel = $row['consumivel'];
        $autorizacao = $row['autorizacao'];
        $descricaoItem = $row["descricaoItem"];
        $descricaoItem = $descricaoItem . " " . $row["indicador"];

        $sql = "SELECT SUM(quantidade) as quantidade FROM Estoque.entradaMaterialItem WHERE material =" . $id . "AND estoque =" . $estoque;
        $result = $reposit->RunQuery($sql);
        if ($row = $result[0]) {
            $quantidade = (int)$row['quantidade'];
        }

        $contador = $contador + 1;
        $array[] = array(
            "id" => $id,
            "descricao" => $descricaoItem,
            "codigoItem" => $codigoItem,
            "unidade" => $unidade,
            "estoque" => $estoque,
            "unidadeItem" => $unidadeItem,
            "consumivel" => $consumivel,
            "autorizacao" => $autorizacao,
            "quantidade" => $quantidade
        );
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}

function listaClienteFornecedorAtivoAutoComplete()
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
    $sql = "SELECT * FROM Ntl.fornecedor WHERE (0=0) AND ativo = 1 
    AND apelido LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY apelido";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach ($result as $row) {
        $id = $row['codigo'];
        $descricao = $row["apelido"];
        $contador = $contador + 1;
        $array[] = array("id" => $id, "descricao" => $descricao);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}

function listaCodigoAtivoAutoComplete()
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
    $sql = "SELECT * FROM Estoque.codigoItem WHERE (0=0) AND ativo = 1 
    AND codigoItem LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY codigoItem";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach ($result as $row) {
        $id = (int)$row['codigo'];
        $estoque = $row['estoque'];
        $unidade = $row['unidade'];
        $unidadeItem = $row['unidadeItem'];
        $consumivel = $row['consumivel'];
        $autorizacao = $row['autorizacao'];
        $codigoItem = $row["codigoItem"];
        $descricaoItem = $row["descricaoItem"] . " " . $row["indicador"];

        $sql = "SELECT SUM(quantidade) as quantidade FROM Estoque.entradaMaterialItem WHERE material =" . $id . "AND estoque =" . $estoque;
        $result = $reposit->RunQuery($sql);
        if ($row = $result[0]) {
            $quantidade = (int)$row['quantidade'];
        }

        $contador = $contador + 1;
        $array[] = array(
            "id" => $id,
            "descricao" => $codigoItem,
            "descricaoItem" => $descricaoItem,
            "unidade" => $unidade,
            "estoque" => $estoque,
            "unidadeItem" => $unidadeItem,
            "consumivel" => $consumivel,
            "autorizacao" => $autorizacao,
            "quantidade" => $quantidade
        );
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}

function recuperaDescricaoCodigo()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $codigo = (int)$_POST["codigo"];
    }

    $sql = "SELECT codigo, descricaoItem
    FROM Estoque.codigoItem
    WHERE (0=0) AND
    codigo = " . $codigo;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int)$row['codigo'];
        $descricaoItem = $row['descricaoItem'];
    }

    $out =   $codigo . "^" .
        $descricaoItem;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function populaComboEstoque()
{
    $unidade = $_POST["unidadeDestino"];
    if ($unidade > 0) {
        $sql = "SELECT codigo, descricao, unidade FROM Estoque.estoque 
                WHERE ativo = 1 AND unidade = $unidade ORDER BY descricao";

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contador = 0;
        $out = "";
        foreach ($result as $row) {
            $id = $row['codigo'];
            $descricao = $row['descricao'];

            $out = $out . $id . "^" . $descricao . "|";

            $contador = $contador + 1;
        }
        if ($out != "") {
            echo "sucess#" . $contador . "#" . $out;
            return;
        }
        echo "failed#";
        return;
    }
}

function validaString($value)
{
    $null = 'NULL';
    if ($value == '')
        return $null;
    return '\'' . $value . '\'';
}

function validaNumero($value)
{
    if ($value == "") {
        $value = 'NULL';
    }
    return $value;
}

function validaData($value)
{
    if ($value == "") {
        $value = 'NULL';
        return $value;
    }
    $value = str_replace('/', '-', $value);
    $value = date("Y-m-d", strtotime($value));
    $value = "'" . $value . "'";
    return $value;
}

function validaDataRecupera($value)
{
    if ($value == "") {
        $value = '';
        return $value;
    }
    $value = date('d/m/Y', strtotime($value));
    return $value;
}

function validaVerifica($value)
{
    if ($value == "") {
        $value = NULL;
    }
    return $value;
}
