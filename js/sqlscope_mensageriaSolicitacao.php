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

if ($funcao == 'listaNomeFuncionario') {
  call_user_func($funcao);
}

return;

function grava()
{
  session_start();
  $codigoFuncionario = "'" . $_SESSION['funcionario'] . "'";
  $codigo = validaString($_POST['codigo']);
  $data = validaData($_POST['data']);
  $hora = validaString($_POST['hora']);
  $projeto = (int)$_POST['projeto'];
  $dataLimite = validaData($_POST['dataLimite']);
  $urgente = (int)$_POST['urgente'];
  $local = validaString($_POST['local']);
  $departamento = validaNumero($_POST['departamento']);
  $responsavel = validaNumero($_POST['responsavelId']);
  $observacao = validaString($_POST['observacao']);
  $concluido = validaString($_POST['concluido']);
  $usuario = "'" . $_SESSION['login'] . "'";

  $sql = "Mensageria.solicitacao_Atualiza  
                $codigo,        
                $codigoFuncionario,
                $data,
                $hora,
                $projeto,
                $dataLimite,
                $urgente,
                $local,
                $responsavel,
                $observacao,
                $concluido,
                $usuario,
                $departamento";

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
    $codigo = (int)$_POST["codigo"];
  }

  $sql = "SELECT S.codigo, S.funcionario, F.nome, S.dataSolicitacao, S.horaSolicitacao, S.dataLimite,
  S.urgente, S.projeto, S.endereco, S.responsavel, FR.nome AS nomeResponsavel, S.observacao,S.concluido,
  S.departamento FROM Mensageria.solicitacao S
  LEFT JOIN Ntl.funcionario F ON F.codigo = S.funcionario
  LEFT JOIN Ntl.funcionario FR ON FR.codigo = S.responsavel
    WHERE (0=0) AND
    S.codigo = " . $codigo;

  $reposit = new reposit();
  $result = $reposit->RunQuery($sql);

  $out = "";
  if ($row = $result[0]) {
    $codigo = (int)$row['codigo'];
    $funcionario = $row['nome'];
    $dataSolicitacao = validaDataRecupera($row['dataSolicitacao']);
    $horaSolicitacao = $row['horaSolicitacao'];
    $dataLimite = validaDataRecupera($row['dataLimite']);
    $urgente = $row['urgente'];
    $projeto = $row['projeto'];
    $local = $row['endereco'];
    $responsavel = $row['responsavel'];
    $nomeResponsavel = $row['nomeResponsavel'];
    $observacao = $row['observacao'];
    $funcionarioId = $row['funcionario'];
    $concluido = $row['concluido'];
    $departamento = $row['departamento'];
  }

  $out =
    $codigo . "^" .
    $funcionario . "^" .
    $dataSolicitacao . "^" .
    $horaSolicitacao . "^" .
    $dataLimite . "^" .
    $urgente . "^" .
    $projeto . "^" .
    $local . "^" .
    $responsavel . "^" .
    $nomeResponsavel . "^" .
    $observacao . "^" .
    $funcionarioId . "^" .
    $concluido . "^" .
    $departamento;

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

function listaNomeFuncionario()
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
  $sql = "SELECT codigo, nome FROM Ntl.funcionario WHERE (0=0) AND ativo = 1 AND nome LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY nome";
  $result = $reposit->RunQuery($sql);
  $contador = 0;
  $array = array();
  foreach ($result as $row) {
    $id = $row['codigo'];
    $nome = $row["nome"];
    $contador = $contador + 1;
    $array[] = array("id" => $id, "nome" => $nome);
  }

  $strArray = json_encode($array);

  echo $strArray;

  return;
}

function validaString($value)
{
  $null = 'NULL';
  if ($value == '')
    return $null;
  return '\'' . $value . '\'';
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

function validaNumero($value)
{
  if ($value == "") {
    $value = 'NULL';
  }
  return $value;
}
