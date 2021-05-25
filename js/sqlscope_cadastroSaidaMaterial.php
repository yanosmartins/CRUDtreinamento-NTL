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

return;

function grava()
{
    $reposit = new reposit(); //Abre a conexão.  

    $possuiPermissao = $reposit->PossuiPermissao("FORNECIMENTOMATERIAL_ACESSAR|FORNECIMENTOMATERIAL_GRAVAR|PEDIDOMATERIAL_ACESSAR|PEDIDOMATERIAL_GRAVAR");

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
    $clienteFornecedor = (int)$_POST['clienteFornecedorId'] ?: 'NULL';
    $solicitante = (int)$_POST['solicitanteId'] ?: 'NULL';
    $projeto = (int)$_POST['projeto'] ?: 'NULL';
    $notaFiscal = validaString($_POST['notaFiscal']) ?: 'NULL';
    $dataEmissaoNF = validaData($_POST['dataEmissaoNF']);
    $motivo = validaString($_POST['motivo']);

    if ($codigo != 0) {
        $naturezaOperacao = $_POST['naturezaOperacaoId'];
    } else {
        $naturezaOperacao = $_POST['naturezaOperacao'];
    }


    $strArrayItem = $_POST['jsonItem'];
    $arrayItem = json_decode($strArrayItem, true);
    $xmlItem = "";
    $nomeXml = "ArrayOfItem";
    $nomeTabela = "saidaMaterial";
    if (sizeof($arrayItem) > 0) {
        $xmlItem = '<?xml version="1.0"?>';
        $xmlItem = $xmlItem . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayItem as $chave) {
            $xmlItem = $xmlItem . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialItem" || $campo === "itemId")) {
                    continue;
                }
                if ($campo === "situacaoItem") {
                    $valor = 'NULL';
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

    $pagina = $_POST['pagina'];

    switch ($pagina) {
        case 'SAIDA':
            $sql = "Estoque.saidaMaterial_Atualiza
            $codigo,
            $dataMovimento,  
            $clienteFornecedor,
            $solicitante,
            $projeto,
            $notaFiscal,
            $dataEmissaoNF,
            $naturezaOperacao,
            $motivo,
            $usuario, 
            $xmlItem
            ";
            break;

        case 'SAIDASELECIONADO':
            $sql = "Estoque.saidaMaterialSelecionado_Atualiza
            $codigo,
            $dataMovimento,  
            $clienteFornecedor,
            $solicitante,
            $projeto,
            $notaFiscal,
            $dataEmissaoNF,
            $naturezaOperacao,
            $motivo,
            $usuario, 
            $xmlItem
            ";
            break;
    }


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

    $sql = "SELECT SM.codigo, SM.fornecedor, F.apelido, SM.projeto, P.descricao AS descricaoProjeto, 
    SM.solicitante, FS.nome AS descricaoSolicitante, SM.dataCadastramento, U.login, SM.notaFiscal, SM.fechado, SM.dataEmissaoNF, SM.motivo, SM.naturezaOperacao
        FROM Estoque.saidaMaterial SM
        LEFT JOIN Ntl.fornecedor F ON F.codigo = SM.fornecedor
        LEFT JOIN Ntl.projeto P ON P.codigo = SM.projeto
        LEFT JOIN Ntl.funcionario FS ON FS.codigo = SM.solicitante
        LEFT JOIN Ntl.usuario U ON U.funcionario = SM.solicitante

        WHERE (0=0) AND
        SM.codigo = " . $codigo;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0])
        $codigo = (int)$row['codigo'];
    $fornecedorID = (int)$row['fornecedor'];
    $descricaoFornecedor = $row['apelido'];
    $solicitanteID = (int)$row['solicitante'];
    $descricaoSolicitante = $row['descricaoSolicitante'];
    $projeto = (int)$row['projeto'];
    $dataCadastramento = $row['dataCadastramento'];
    $notaFiscal = $row['notaFiscal'];
    $fechado = $row['fechado'];
    $dataEmissaoNF = $row['dataEmissaoNF'];
    $motivo = $row['motivo'];
    $naturezaOperacao = $row['naturezaOperacao'];


    if (!$notaFiscal) {
        //Montando array de itens 
        $reposit = "";
        $result = "";
        $sql = "SELECT DISTINCT SMI.codigo,SMI.saidaMaterial, SMI.material, CI.codigoItem, SMI.estoque,
                E.descricao AS descricaoEstoque, SMI.quantidade, CI.descricaoItem, SMI.unidade,
                U.descricao AS descricaoUnidade, CI.unidadeItem, UI.descricao AS descricaoUnidadeItem,
                saldo = (SELECT  count(material) 
                                FROM Estoque.estoqueMovimento EM
                                WHERE EM.pedidoMaterial = SMI.saidaMaterial AND EM.situacaoItem = 4 AND EM.material = SMI.material)
                FROM Estoque.saidaMaterialItem SMI
                LEFT JOIN Estoque.codigoItem CI ON CI.codigo = SMI.material
                LEFT JOIN Estoque.estoque E ON E.codigo = SMI.estoque
                LEFT JOIN Ntl.unidade U ON U.codigo = SMI.unidade
                LEFT JOIN Estoque.unidadeItem UI ON UI.codigo = CI.unidadeItem
                LEFT JOIN Estoque.estoqueMovimento EM ON EM.saidaMaterial = SMI.saidaMaterial
                WHERE (0=0) AND EM.situacao IN (1, 4, 6) AND SMI.saidaMaterial = " . $codigo;
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
            $situacao = 3;
            $saldo = $row['saldo'];


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
                "situacaoId" => $situacao,
                "unidade" => $unidade,
                "saldo" => $saldo
            );
        }

        $strArrayItem = json_encode($arrayItem);
    } else {
        //Montando array de itens 
        $reposit = "";
        $result = "";
        $sql = "SELECT DISTINCT SMI.codigo,SMI.saidaMaterial, SMI.material, CI.codigoItem, SMI.estoque,
                E.descricao AS descricaoEstoque, SMI.quantidade, CI.descricaoItem, SMI.unidade,
                U.descricao AS descricaoUnidade, CI.unidadeItem, UI.descricao AS descricaoUnidadeItem,
                saldo = (SELECT  count(material) 
                                FROM Estoque.estoqueMovimento EM
                                WHERE EM.pedidoMaterial = SMI.saidaMaterial AND EM.situacaoItem = 4 AND EM.material = SMI.material)
                FROM Estoque.saidaMaterialItem SMI
                LEFT JOIN Estoque.codigoItem CI ON CI.codigo = SMI.material
                LEFT JOIN Estoque.estoque E ON E.codigo = SMI.estoque
                LEFT JOIN Ntl.unidade U ON U.codigo = SMI.unidade
                LEFT JOIN Estoque.unidadeItem UI ON UI.codigo = CI.unidadeItem
                LEFT JOIN Estoque.estoqueMovimento EM ON EM.saidaMaterial = SMI.saidaMaterial
                WHERE (0=0) AND EM.situacao IN (2, 3, 5) AND SMI.saidaMaterial = " . $codigo;
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
            $situacao = 5;
            $saldo = $row['saldo'];


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
                "situacaoId" => $situacao,
                "unidade" => $unidade,
                "saldo" => $saldo
            );
        }

        $strArrayItem = json_encode($arrayItem);
    }


    $out =   $codigo . "^" .
        $fornecedorID . "^" .
        $descricaoFornecedor . "^" .
        $solicitanteID . "^" .
        $descricaoSolicitante . "^" .
        $projeto . "^" .
        $dataCadastramento . "^" .
        $notaFiscal . "^" .
        $fechado . "^" .
        $dataEmissaoNF . "^" .
        $motivo . "^" .
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
    $possuiPermissao = $reposit->PossuiPermissao("FORNECIMENTOMATERIAL_ACESSAR|FORNECIMENTOMATERIAL_EXCLUIR|PEDIDOMATERIAL_ACESSAR|PEDIDOMATERIAL_EXCLUIR");

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
