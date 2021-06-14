<?php

use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS\File;

include "repositorio.php";
include "girComum.php";

$funcao = $_REQUEST["funcao"];

$pattern = "/(valida|recupera|reabrir)/i";

$condicao = preg_match($pattern, $funcao);

if ($condicao) {
  call_user_func($funcao);
}

return;

function valida()
{
  $reposit = new reposit();
  $possuiPermissao = $reposit->PossuiPermissao("TRIAGEMPONTOELETRONICOMENSALGESTOR_GRAVAR");

  if ($possuiPermissao === 0) {
    $mensagem = "O usuário não tem permissão para gravar!";
    echo "failed#" . $mensagem . ' ';
    return;
  }

  session_start();
  $usuario = "'" .  $_SESSION['login'] . "'";
  $codigo = $_POST["codigo"];

  $sql = "select codigo as 'status' from Ntl.status where descricao LIKE 'Validado pelo gestor'";

  $result = $reposit->RunQuery($sql);

  if ($row = $result[0]) {
    $status = $row["status"];
  } else {
    $ret = 'failed#Falha ao validar!';
    echo $ret;
    return;
  }

  $result = $reposit->Update("Funcionario.folhaPontoMensal|status = $status , usuarioAlteracao = $usuario,dataAlteracao = '" . date("Y/m/d") . "'|codigo = $codigo");

  $ret = 'sucess#Validado com sucesso!';
  if ($result < 1) {
    $ret = 'failed#Falha ao validar!';
  }
  echo $ret;
  return;
}

function reabrir()
{
  $reposit = new reposit();
  $possuiPermissao = $reposit->PossuiPermissao("TRIAGEMPONTOELETRONICOMENSALGESTOR_GRAVAR");

  if ($possuiPermissao === 0) {
    $mensagem = "O usuário não tem permissão para gravar!";
    echo "failed#" . $mensagem . ' ';
    return;
  }

  session_start();
  $usuario = "'" .  $_SESSION['login'] . "'";
  $data = $_POST["data"];

  $codigo = $data["codigo"];
  $pendenciaArray = $data["pendencia"];

  //===XML===//
  $xmlPendencia = "";
  $nomeXml = "ArrayOfPendencia";
  $nomeTabela = "pendencia";
  $j = 0;

  if (sizeof($pendenciaArray) > 0) {
    $xmlPendencia = '<?xml version="1.0"?>';
    $xmlPendencia = $xmlPendencia . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
    foreach ($pendenciaArray as $pendencia) {
      $xmlPendencia = $xmlPendencia . "<" . $nomeTabela . ">";
      $xmlPendencia = $xmlPendencia . "<descricao>" . $pendencia . "</descricao>";
      $xmlPendencia = $xmlPendencia . "</" . $nomeTabela . ">";
    }
    $xmlPendencia = $xmlPendencia . "</" . $nomeXml . ">";
  } else {
    $xmlPendencia = '<?xml version="1.0"?>';
    $xmlPendencia = $xmlPendencia . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
    $xmlPendencia = $xmlPendencia . "</" . $nomeXml . ">";
  }

  $xml = simplexml_load_string($xmlPendencia);
  if ($xml === false) {
    $mensagem = "Erro na criação do XML de pendência";
    echo "failed#" . $mensagem . ' ';
    return;
  }
  $xmlPendencia = "'" . $xmlPendencia . "'";

  //===SQL===//
  $result = $reposit->Execprocedure("funcionario.pendencia_Atualiza $codigo,$xmlPendencia,$usuario");

  $ret = 'sucess#Validado com sucesso!';
  if ($result < 1) {
    $ret = 'failed#Falha ao reabrir!';
  }
  echo $ret;
  return;
}

function recupera()
{
  session_start();

  $funcionario = (int)$_GET["funcionario"];
  $mesAno = $_GET["mesAno"];
  @list($mes, $ano) = explode("/", $mesAno);
  $mesAno = $ano . "-" . $mes . "-" . "01";

  //FOLHA
  $sql = "SELECT F.codigo as 'folha' FROM Funcionario.folhaPontoMensal F
            INNER JOIN Ntl.funcionario FU ON F.funcionario = FU.codigo
            WHERE FU.codigo = $funcionario  AND F.mesAno = '$mesAno'";

  $reposit = new reposit();
  $result = $reposit->RunQuery($sql);

  $out = "";

  if ($result < 1) {
    echo "failed#" . "$out#";
    return;
  }

  $row = $result[0];

  $folha = $row["folha"];


  $out = "$folha";

  //PONTOS
  $sql =  "SELECT FD.dia,FD.horaEntrada,FD.horaSaida,FD.inicioAlmoco,FD.fimAlmoco,FD.horaExtra,FD.atraso,L.descricao as 'lancamento' 
    FROM Funcionario.folhaPontoMensalDetalheDiario FD 
    INNER JOIN Funcionario.folhaPontoMensal F ON F.codigo = FD.folhaPontoMensal
    LEFT JOIN Ntl.lancamento L ON FD.lancamento = L.codigo
    WHERE (0=0) AND F.codigo = " . $folha;

  $result = $reposit->RunQuery($sql);

  $arrayPonto = array();

  foreach ($result as $row) {

    $dia = $row["dia"];
    $horaEntrada = $row["horaEntrada"];
    $inicioAlmoco = $row["inicioAlmoco"];
    $fimAlmoco = $row["fimAlmoco"];
    $horaSaida = $row["horaSaida"];
    $horaExtra = $row["horaExtra"];
    $atraso = $row["atraso"];
    $lancamento = $row["lancamento"];

    if ($lancamento == null) {
      $lancamento = "";
    }


    $arrayRow = array(
      "dia"           =>  $dia,
      "entrada"       =>  $horaEntrada,
      "inicioAlmoco"  =>  $inicioAlmoco,
      "fimAlmoco"     =>  $fimAlmoco,
      "saida"         =>  $horaSaida,
      "extra"     =>  $horaExtra,
      "atraso"        =>  $atraso,
      "lancamento"    =>  $lancamento
    );

    array_push($arrayPonto, $arrayRow);
  }

  $jsonFolha = json_encode($arrayPonto);

  //ARQUIVOS
  $sql =  "SELECT L.fileName,L.filePath,L.fileType,L.uploadType,L.dataReferente,L.dataCadastro FROM Funcionario.logUploadFolhaPonto L
  INNER JOIN Ntl.funcionario F ON F.codigo = L.funcionario
  WHERE (0=0) AND F.codigo = " . $funcionario . " AND L.dataReferente = '$mesAno'";

  $result = $reposit->RunQuery($sql);

  $uploadArray = array();
  $visualizaArray = array();
  foreach ($result as $row) {
    $filePath = $row["filePath"];
    $fileName = $row["fileName"];
    $fileType = $row["fileType"];
    $uploadType = $row["uploadType"];
    @list($dataReferente, $trash) = explode(" ", $row["dataReferente"]);
    @list($dataCadastro, $trash) = explode(" ", $row["dataCadastro"]);

    array_push(
      $uploadArray,
      [
        "fileName" => $fileName,
        "uploadType" => str_replace("_", " ", $uploadType),
        "dataReferente" => $dataReferente,
        "dataUpload" => $dataCadastro,
      ]
    );

    array_push(
      $visualizaArray,
      [
        "filePath" => $filePath,
        "fileName" => $fileName
      ]
    );
  }

  $jsonUpload = json_encode($uploadArray);
  $jsonVisualiza = json_encode($visualizaArray);

  echo "sucess#" . "$out#" . "$jsonFolha#" . "$jsonUpload#" . "$jsonVisualiza#";
  return;
}
