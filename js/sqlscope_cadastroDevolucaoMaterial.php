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
    $responsavel = (int)$_SESSION['funcionario'] ?: 'NULL';

    $strArrayItem = $_POST['jsonItemDevolucaoNovo'];
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


    $sql = "Estoque.devolucaoMaterial_Atualiza
        $codigo,
        $responsavel,
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
    PM.solicitante, FS.nome AS descricaoSolicitante, PM.responsavel, FR.nome AS descricaoResponsavel,
	PM.aprovado, PM.dataCadastramento, U.login
        FROM Estoque.pedidoMaterial PM
        LEFT JOIN Ntl.fornecedor F ON F.codigo = PM.fornecedor
        LEFT JOIN Ntl.projeto P ON P.codigo = PM.projeto
        LEFT JOIN Ntl.funcionario FS ON FS.codigo = PM.solicitante
        LEFT JOIN Ntl.funcionario FR ON FR.codigo = PM.responsavel
        LEFT JOIN Ntl.usuario U ON U.funcionario = PM.solicitante

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
    $login = $row['login'];
    $aprovado = $row['aprovado'];
    $projeto = (int)$row['projeto'];
    $dataCadastramento = $row['dataCadastramento'];


    //Montando array de itens 
    $reposit = "";
    $result = "";
    $sql = "SELECT PMI.codigo,PMI.pedidoMaterial, PMI.material, CI.codigoItem, PMI.estoque,
    E.descricao AS descricaoEstoque, PMI.quantidade, CI.descricaoItem, PMI.unidade,
    U.descricao AS descricaoUnidade, CI.unidadeItem, UI.descricao AS descricaoUnidadeItem,
    PMI.situacao, saldo = (SELECT  count(material) 
                    FROM Estoque.estoqueMovimento EM
                    WHERE EM.pedidoMaterial = PMI.pedidoMaterial AND EM.situacaoItem = 4 AND EM.material = PMI.material)
    FROM Estoque.pedidoMaterialItem PMI
    LEFT JOIN Estoque.codigoItem CI ON CI.codigo = PMI.material
    LEFT JOIN Estoque.estoque E ON E.codigo = PMI.estoque
    LEFT JOIN Ntl.unidade U ON U.codigo = PMI.unidade
    LEFT JOIN Estoque.unidadeItem UI ON UI.codigo = CI.unidadeItem
    WHERE (0=0) AND PMI.pedidoMaterial =  " . $codigo;
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

    //Montando array de itens Devolvidos
    $reposit = "";
    $result = "";
    $sql = "SELECT DMI.codigo,DMI.pedidoMaterial, DMI.material, CI.codigoItem,
    DMI.quantidade, CI.descricaoItem, CI.unidadeItem, UI.descricao AS descricaoUnidadeItem,
    DMI.dataCadastramento, DMI.responsavel, DMI.situacao, F.nome ,DMI.dataCadastramento
    FROM Estoque.devolucaoMaterialItem DMI
    LEFT JOIN Estoque.codigoItem CI ON CI.codigo = DMI.material
    LEFT JOIN Estoque.unidadeItem UI ON UI.codigo = CI.unidadeItem
    LEFT JOIN Ntl.funcionario F ON F.codigo = DMI.responsavel
    WHERE (0=0) AND DMI.pedidoMaterial =" . $codigo;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorItem = 0;
    $arrayItemDevolucao = array();
    foreach ($result as $row) {

        $material = (int)$row['material'];
        $codigoItem = $row['codigoItem'];
        $quantidade =  number_format($row['quantidade'], 0, '', '');
        $descricaoItem = $row['descricaoItem'];
        $descricaoUnidadeMedida = $row['descricaoUnidadeItem'];
        $dataDevolucao = validaData($row['dataCadastramento']);
        $horaDevolucao = validaHora($row['dataCadastramento']);
        $situacao = $row['situacao'];

        $contadorItem = $contadorItem + 1;
        $arrayItemDevolucao[] = array(
            "sequencialItem" => $contadorItem,
            "codigoItemId" => $material,
            "descricaoItemId" => $material,
            "codigoItemFiltro" => $codigoItem,
            "descricaoItemFiltro" => $descricaoItem,
            "quantidade" => $quantidade,
            "descricaoUnidadeMedida" => $descricaoUnidadeMedida,
            "situacao" => $situacao,
            "data" => $dataDevolucao,
            "hora" => $horaDevolucao,
            "recuperado" => '1'
        );
    }

    $strArrayItemDevolucao = json_encode($arrayItemDevolucao);

    $out =   $codigo . "^" .
        $fornecedorID . "^" .
        $descricaoFornecedor . "^" .
        $solicitanteID . "^" .
        $descricaoSolicitante . "^" .
        $responsavelID . "^" .
        $descricaoResponsavel . "^" .
        $projeto . "^" .
        $aprovado . "^" .
        $dataCadastramento . "^" .
        $login;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayItem . "#" . $strArrayItemDevolucao;
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
    $piece = explode(" ", $value);
    $value = date("d/m/Y", strtotime($piece[0]));
    // $value = str_replace('-', '/', $piece[0]);
    // $value = "'" . $value . "'";
    return $value;
}

function validaHora($value)
{
    if ($value == "") {
        $value = 'NULL';
        return $value;
    }
    $piece = explode(" ", $value);
    $value = $piece[1];
    $value = date("H:i:s", strtotime($value));
    // $value = "'" . $value . "'";
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
