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

if ($funcao == 'verificaMunicipio') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("LANCAMENTO_ACESSAR|LANCAMENTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $codigo = $_POST['id'];
    $descricao = "'" . $_POST['descricao'] . "'";
    $sigla = "'" . $_POST['sigla'] . "'";
    $ativo = $_POST['ativo'];
    $faltaAusencia = "'" . $_POST['faltaAusencia'] . "'";
    $abonaAtraso = $_POST['abonaAtraso'];
    $imprimeFolha = $_POST['imprimeFolha'];
    $planilhaFaturamento = $_POST['planilhaFaturamento'];
    $strArrayProjeto = $_POST['jsonProjetoArray'];
    $arrayProjeto = $strArrayProjeto;
    if (!is_null($strArrayProjeto)) {
        $xmlProjeto = "";
        $nomeXml = "ArrayOfProjeto";
        $nomeTabela = "lancamentoProjeto";
        if (sizeof($arrayProjeto) > 0) {
            $xmlProjeto = '<?xml version="1.0"?>';
            $xmlProjeto = $xmlProjeto . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

            foreach ($arrayProjeto as $chave) {
                $xmlProjeto = $xmlProjeto . "<" . $nomeTabela . ">";
                foreach ($chave as $campo => $valor) {

                    if (($campo === "sequencialProjeto")) {
                        continue;
                    }
                    if (($campo === "descricaoProjeto")) {
                        continue;
                    }


                    $xmlProjeto = $xmlProjeto . "<" . $campo . ">" . $valor . "</" . $campo . ">";
                }
                $xmlProjeto = $xmlProjeto . "</" . $nomeTabela . ">";
            }
            $xmlProjeto = $xmlProjeto . "</" . $nomeXml . ">";
        } else {
            $xmlProjeto = '<?xml version="1.0"?>';
            $xmlProjeto = $xmlProjeto . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
            $xmlProjeto = $xmlProjeto . "</" . $nomeXml . ">";
        }

        $xml = simplexml_load_string($xmlProjeto);

        if ($xml === false) {
            $mensagem = "Erro na criação do XML de Vale Transporte";
            echo "failed#" . $mensagem . ' ';
            return;
        }
        $xmlProjeto = "'" . $xmlProjeto . "'";
    } else {

        $xmlProjeto = "'" . '<?xml version="1.0"?>' . '<' . "ArrayOfProjeto" . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' . "</ArrayOfTipoItem>" . "'";
    }

    $sql = "Ntl.lancamento_Atualiza
            $codigo,
            $ativo,
            $sigla,
            $descricao,
            $usuario,
            $faltaAusencia,
            $abonaAtraso,
            $imprimeFolha,
            $planilhaFaturamento,
            $xmlProjeto";

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

    $sql = "SELECT codigo,descricao,sigla,ativo,tipoDesconto, abonaAtraso, imprimeFolha, planilhaFaturamento
            FROM Ntl.lancamento WHERE (0 = 0)";

    if ($condicaoId) {
        $sql = $sql . " AND codigo = " . $codigo . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if($row = $result[0]) {

        $id = +$row['codigo'];
        $descricao = $row['descricao'];
        $sigla = $row['sigla'];
        $ativo = +$row['ativo'];
        $faltaAusencia = $row['tipoDesconto'];

        $abonaAtraso = +$row['abonaAtraso'];
        $imprimeFolha = +$row['imprimeFolha'];
        $planilhaFaturamento = +$row['planilhaFaturamento'];

        $reposit = "";
        $result = "";
        $sql = "SELECT LP.codigo,LP.lancamento,LP.projeto,P.descricao AS 'descricaoProjeto' , L.codigo FROM ntl.lancamentoProjeto LP
        INNER JOIN ntl.lancamento L ON LP.lancamento = L.codigo
        INNER JOIN ntl.projeto P ON LP.projeto = P.codigo
        WHERE L.ativo = 1 AND LP.lancamento = $codigo";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorProjeto = 0;
        $arrayProjeto = array();
        foreach ($result as $row) {
            $projetoDescricao = (string)$row['descricaoProjeto'];
            $projetoId = (int) $row['projeto'];

            $contadorProjeto = $contadorProjeto + 1;
            $arrayProjeto[] = array(
                "sequencialProjeto" => $contadorProjeto,
                "descricaoProjeto" => $projetoDescricao,
                "projeto" => $projetoId,
            );
        }

        $strArrayProjeto = json_encode($arrayProjeto);




        $out = $id . "^" . $descricao . "^" . $sigla .  "^" . $ativo .  "^" . $faltaAusencia 
                .  "^" . $abonaAtraso .  "^" . $imprimeFolha .  "^" . $planilhaFaturamento;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . "#" .  $strArrayProjeto;
        }
        return;
    }
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("LANCAMENTO_ACESSAR|LANCAMENTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um lancamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Ntl.lancamento' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
