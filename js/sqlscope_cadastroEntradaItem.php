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
if ($funcao == 'recuperaDescricaoCodigo') {
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
if ($funcao == 'recuperaFornecedorObrigatorio') {
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
    $clienteFornecedor = (int)$_POST['clienteFornecedorId'] ?: 0;
    $tipo = (int)$_POST['tipo'] ?: 0;
    $numero =  validaString($_POST['numero']);
    $dataEmissao = validaData($_POST['dataEmissao']);
    $dataEntrada = validaData($_POST['dataEntrega']);
    $observacao =  validaString($_POST['observacao']);
    $naturezaOperacao = (int)$_POST['naturezaOperacao'];

    if ($numero == "") {
        $numero = $codigo;
    }

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


    $sql = "Estoque.entradaMaterial_Atualiza
        $codigo,
        $dataMovimento,  
        $clienteFornecedor, 
        $tipo, 
        $numero,
        $dataEmissao,
        $dataEntrada,
        $observacao,
        $naturezaOperacao, 
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

    $sql = "SELECT EM.codigo, EM.fornecedor, F.apelido, EM.tipoDocumento , T.descricao AS descricaoTipoDocumento, 
    EM.numeroNF, EM.dataEntradaMaterial,EM.dataEntrega, EM.dataEmissaoNF, EM.observacao, EM.naturezaOperacao
    FROM Estoque.entradaMaterial EM
    LEFT JOIN Ntl.fornecedor F ON F.codigo = EM.fornecedor
    LEFT JOIN Estoque.tipoDocumento T ON T.codigo = EM.tipoDocumento
    WHERE (0=0) AND
    EM.codigo = " . $codigo;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0])
        $codigo = (int)$row['codigo'];
    $dataEntradaMaterial = $row['dataEntradaMaterial'];
    $fornecedorID = (int)$row['fornecedor'];
    $descricaoFornecedor = $row['apelido'];
    $tipoDocumento = (int)$row['tipoDocumento'];
    $numeroNF = $row['numeroNF'];
    $dataEntrada = $row['dataEntrega'];
    $dataEmissaoNF = $row['dataEmissaoNF'];
    $observacao = $row['observacao'];
    $naturezaOperacao = $row['naturezaOperacao'];

    $valorEstimado = number_format($row['valorEstimado'], 2, ',', '.');


    //Montando array de tarefas  
    $reposit = "";
    $result = "";
    $sql = "SELECT EMI.codigo,EMI.entradaMaterial, EMI.material, CI.codigoItem, EMI.estoque,
        E.descricao AS descricaoEstoque, EMI.quantidade,EMI.valorUnitario, EMI.valorDesconto, EMI.valorTotalItem,
        CI.descricaoItem, CI.unidade, U.descricao AS descricaoUnidade
        FROM Estoque.entradaMaterialItem EMI
        LEFT JOIN Estoque.codigoItem CI ON CI.codigo = EMI.material
        LEFT JOIN Estoque.estoque E ON E.codigo = EMI.estoque
        LEFT JOIN Ntl.unidade U ON U.codigo = CI.unidade
    WHERE (0=0) AND EMI.entradaMaterial = " . $codigo;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $valorFinalItemTable = 0;
    $valorTotalItemTable = 0;
    $contadorItem = 0;
    $arrayItem = array();
    foreach ($result as $row) {

        $material = (int)$row['material'];
        $codigoItem = $row['codigoItem'];
        $estoque = $row['estoque'];
        $descricaoEstoque = $row['descricaoEstoque'];
        $quantidade =  number_format($row['quantidade'], 0, '', '');
        $valorUnitario =  number_format($row['valorUnitario'], 2, ',', '');
        $valorDesconto = number_format($row['valorDesconto'], 2, ',', '');
        $valorFinalItem = number_format($row['valorTotalItem'], 2, ',', '');
        $descricaoItem = $row['descricaoItem'];
        $unidade = $row['unidade'];
        $descricaoUnidade = $row['descricaoUnidade'];

        $valorTotalItem = 0;
        $valorTotalItem = ($valorUnitario * $quantidade);
        $valorTotalItem = number_format($valorTotalItem, 2, '.', '');
        // $valorFinalItemTable = $valorFinalItemTable + $valorFinalItem;
        // $valorFinalItemTable = number_format($valorFinalItemTable, 2, '.', '');
        // $valorTotalItemTable = $valorTotalItemTable + $valorTotalItem;
        // $valorTotalItemTable = number_format($valorTotalItemTable, 2, '.', '');

        // if ($dataSolicitacao != "") {
        //     $horario = explode(" ", $dataSolicitacao);
        //     $horario = explode(":", $horario[1]);
        //     $dataSolicitacao = date("d-m-Y", strtotime($dataSolicitacao));
        //     $dataSolicitacao = str_replace('-', '/', $dataSolicitacao);
        //     $dataSolicitacao = $dataSolicitacao . " " . $horario[0] . ":" . $horario[1];
        // }


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
            "unitario" => $valorUnitario,
            "desconto" => $valorDesconto,
            "valorFinalItem" => $valorFinalItem,
            "valorTotalItem" => $valorTotalItem,
            "unidadeDestino" => $unidade,
            "descricaoUnidade" => $descricaoUnidade,
            "unidade" => $unidade
        );
    }

    $strArrayItem = json_encode($arrayItem);

    $out =   $codigo . "^" .
        $dataEntradaMaterial . "^" .
        $fornecedorID . "^" .
        $descricaoFornecedor . "^" .
        $tipoDocumento . "^" .
        $numeroNF . "^" .
        $dataEntrada . "^" .
        $dataEmissaoNF . "^" .
        $observacao . "^" .
        $naturezaOperacao;

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
        $contador = $contador + 1;
        $array[] = array(
            "id" => $id,
            "descricao" => $descricaoItem,
            "codigoItem" => $codigoItem,
            "unidade" => $unidade,
            "estoque" => $estoque,
            "unidadeItem" => $unidadeItem,
            "consumivel" => $consumivel,
            "autorizacao" => $autorizacao
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

function recuperaFornecedorObrigatorio()
{
    session_start();
    $id = $_SESSION['funcionario'];

    $sql = "SELECT BP.codigo, BP.projeto, P.fornecedorObrigatorio
    FROM Ntl.beneficioProjeto BP
	LEFT JOIN Ntl.projeto P ON P.codigo = BP.projeto 
    WHERE (0=0) AND
    BP.funcionario = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $fornecedorObrigatorio = $row['fornecedorObrigatorio'];
    }

    $out =  $fornecedorObrigatorio;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
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
