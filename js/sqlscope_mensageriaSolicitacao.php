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
  session_start();
  $usuario = "'" . $_SESSION['login'] . "'";
  $solicitacao = $_POST['solicitacao'];
  $codigoFuncionario = (int)$solicitacao[''];
  $nomeFuncionario = $solicitacao['nomeFuncionario'];
  $projeto = (int)$solicitacao[''];

  //Inicio do Json
  $strJson = $solicitacao[''];
  $arrayJson = json_decode($strJson, true);
  $xmlJson = "";
  $nomeXml = "ArrayOf";
  $nomeTabela = "";
  if (sizeof($arrayJson) > 0) {
    $xmlJson = '<?xml version="1.0"?>';
    $xmlJson = $xmlJson . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
    foreach ($arrayJson as $chave) {
      $xmlJson = $xmlJson . "<" . $nomeTabela . ">";
      foreach ($chave as $campo => $valor) {
        if (($campo === "sequencial")) {
          continue;
        }
        if ($valor == 'Selecione') {
          $valor = NULL;
        }
        $xmlJson = $xmlJson . "<" . $campo . ">" . $valor . "</" . $campo . ">";
      }
      $xmlJson = $xmlJson . "</" . $nomeTabela . ">";
    }
    $xmlJson = $xmlJson . "</" . $nomeXml . ">";
  } else {
    $xmlJson = '<?xml version="1.0"?>';
    $xmlJson = $xmlJson . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
    $xmlJson = $xmlJson . "</" . $nomeXml . ">";
  }
  $xml = simplexml_load_string($xmlJson);
  if ($xml === false) {
    $mensagem = "Erro na criação do XML de ";
    echo "failed#" . $mensagem . ' ';
    return;
  }
  $xmlJson = "'" . $xmlJson . "'";

  //Fim do Json 

  $sql = "Ntl.solicitacao_Atualiza          
                $codigoFuncionario,
                $projeto,
                $xmlJson)";

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

  $reposit = new reposit();
  $usuario = $_SESSION['login'];
  $sql = "SELECT F.codigo AS 'codigoFuncionario' FROM ntl.funcionario F INNER JOIN ntl.usuario U ON F.codigo = U.funcionario WHERE U.usuario = $usuario";

  $result = $reposit->RunQuery($sql);

  $out = "";
  $row = $result[0];
  $codigoFuncionario = (int)$row['codigoFuncionaro'];
  $nomeFuncionario = (int)$row[''];
  $projeto = (int)$row['projeto'];

  $sql = "SELECT  FROM  INNER JOIN  ON  WHERE ";

  $result = $reposit->RunQuery($sql);

  $contador = 0;
  $array = array();
  foreach ($result as $row) {
    $variavel = (string)$row[''];

    $contador = $contador + 1;
    $array[] = array(
      "sequencial" => $contador,
      "variavel" => $variavel
    );
  }

  $strArray = json_encode($array);
  //------------------------Fim do Array 

  $out =
    $codigoFuncionario . "^" .
    $nomeFuncionario . "^" .
    $projeto;

  if ($out == "") {
    echo "failed#";
    return;
  }

  echo "sucess#" . $out . "#" . $strArray;
  return;
}

function excluir()
{
  $reposit = new reposit();
  $possuiPermissao = $reposit->PossuiPermissao("SOLICITACAO_ACESSAR|SOLICITACAO_EXCLUIR");
  if ($possuiPermissao === 0) {
    $mensagem = "O usuário não tem permissão para excluir!";
    echo "failed#" . $mensagem . ' ';
    return;
  }
  $id = $_POST["id"];
  if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
    $mensagem = "Selecione um contrato para ser excluído";
    echo "failed#" . $mensagem . ' ';
    return;
  }

  $reposit = new reposit();

  $result = $reposit->update('Ntl.solicitacao' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

  if ($result < 1) {
    echo ('failed#');
    return;
  }
  echo 'sucess#' . $result;
  return;
}
