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

if ($funcao == 'populaDiasProjeto') {
    call_user_func($funcao);
}
if ($funcao == 'verificaFerias') {
    call_user_func($funcao);
}
if ($funcao == 'recuperaDiaUtil') {
    call_user_func($funcao);
}
if ($funcao == 'recuperaDiaUtilProjeto') {
    call_user_func($funcao);
}
if ($funcao == 'verificaFeriado') {
    call_user_func($funcao);
}
if ($funcao == 'populaComboFuncionario') {
    call_user_func($funcao);
}
if ($funcao == 'periodoAdicionalNoturno') {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FOLHAPONTO_ACESSAR|FOLHAPONTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    //Variáveis
    $id = +$_POST['id'];
    $ativo = 1;
    session_start();
    $usuario = formatarString($_SESSION['login']);  //Pegando o nome do usuário mantido pela sessão.
    $projeto = +$_POST['projeto'];
    $funcionario = +$_POST['funcionario'];
    $mesAnoFolhaPonto = formatarDataGrava('01/' . $_POST['mesAnoFolhaPonto']);

    //Verificando se existe um registro com o funcionário e o mês/ano cadastrados
    if ($id == 0) {
        $sqlFuncionario = "SELECT codigo,ativo FROM Beneficio.folhaPonto WHERE (0=0) AND ativo = 1 AND funcionario = " . $funcionario . " AND mesAnoFolhaPonto = " . $mesAnoFolhaPonto;
        $reposit = new reposit();
        $resultFuncionario = $reposit->RunQuery($sqlFuncionario);
        $rowFuncionario = odbc_fetch_array($resultFuncionario);
        if ($rowFuncionario > 0) {
            echo "#Já existe um registro com essas caracterásticas no sistema";
            return false;
        }
    }
    $justificativaFolhaPonto = formatarString($_POST['justificativaFolhaPonto']);
    $diasUteisProjetoVAVR = +$_POST['diasUteisVAVR'];
    $diasUteisProjetoVT = +$_POST['diasUteisVT'];

    // DIAS ÚTEIS - VALE ALIMENTAÇÃO
    $totalFaltasValeAlimentacao = formatarNumero(+$_POST['totalFaltasValeAlimentacao']);
    $totalAusenciasValeAlimentacao = formatarNumero(+$_POST['totalAusenciasValeAlimentacao']);
    $diasProjetoValeAlimentacao = formatarNumero(+$_POST['diasProjetoValeAlimentacao']);
    $totalDiasTrabalhadosValeAlimentacao = formatarNumero(+$_POST['totalDiasTrabalhadosValeAlimentacao']);

    // DIAS ÚTEIS - VALE REFEIÇÃO
    $totalFaltasValeTransporte = +$_POST['faltasValeTransporte'];
    $totalAusenciasValeTransporte = +$_POST['ausenciasValeTransporte'];
    $diasProjetoValeRefeicao = formatarNumero(+$_POST['diasProjetoValeRefeicao']);
    $totalDiasTrabalhadosValeRefeicao = formatarNumero(+$_POST['totalDiasTrabalhadosValeRefeicao']);
    $totalDiasTrabalhadosVT = formatarNumero(+$_POST['totalDiasTrabalhadosVT']);

    //------------------------ Accordion de Vale Alimentacao ------------------
    $strArrayValeAlimentacao = $_POST['jsonValeAlimentacaoArray'];
    $arrayValeAlimentacao = json_decode($strArrayValeAlimentacao, true);
    $xmlVAVR = "";
    $nomeXml = "ArrayOfFolhaPontoValeAlimentacao";
    $nomeTabela = "folhaPontoValeAlimentacao";
    if (sizeof($arrayValeAlimentacao) > 0) {
        $xmlVAVR = '<?xml version="1.0"?>';
        $xmlVAVR = $xmlVAVR . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayValeAlimentacao as $chave) {
            $xmlVAVR = $xmlVAVR . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "descricaoFaltasAusenciasValeAlimentacao")) {
                    continue;
                }
                if (($campo === "sequencialValeAlimentacao")) {
                    continue;
                }
                if (($campo === "totalFaltasValeAlimentacao")) {
                    continue;
                }
                if (($campo === "totalAusenciasValeAlimentacao")) {
                    continue;
                }
                if (($campo === "diasProjetoValeAlimentacao")) {
                    continue;
                }
                if (($campo === "totalDiasTrabalhadosValeAlimentacao")) {
                    continue;
                }
                if (($campo === "descricaoDataFaltaAusenciaValeAlimentacao")) {
                    continue;
                }
                if (($campo === "valeAlimentacaoId")) {
                    continue;
                }
                $xmlVAVR = $xmlVAVR . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlVAVR = $xmlVAVR . "</" . $nomeTabela . ">";
        }
        $xmlVAVR = $xmlVAVR . "</" . $nomeXml . ">";
    } else {
        $xmlVAVR = '<?xml version="1.0"?>';
        $xmlVAVR = $xmlVAVR . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlVAVR = $xmlVAVR . "</" . $nomeXml . ">";
    }

    $xml = simplexml_load_string($xmlVAVR);

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Vale Alimentação";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlVAVR = "'" . $xmlVAVR . "'";


    //------------------------ Accordion de Vale Transporte ------------------
    $strArrayValeTransporte = $_POST['jsonValeTransporteArray'];
    $arrayValeTransporte = json_decode($strArrayValeTransporte, true);
    $xmlValeTransporte = "";
    $nomeXml = "ArrayOfFolhaPontoValeTransporte";
    $nomeTabela = "folhaPontoValeTransporte";
    if (sizeof($arrayValeTransporte) > 0) {
        $xmlValeTransporte = '<?xml version="1.0"?>';
        $xmlValeTransporte = $xmlValeTransporte . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayValeTransporte as $chave) {
            $xmlValeTransporte = $xmlValeTransporte . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "descricaoFaltasAusenciasValeTransporte")) {
                    continue;
                }
                if (($campo === "sequencialValeTransporte")) {
                    continue;
                }
                if (($campo === "totalFaltasValeTransporte")) {
                    continue;
                }
                if (($campo === "dataFaltaAusenciaValeTransporte")) {
                    $data = $valor;
                    $data = explode("-", $data);
                    // $quantidadeData = count($data);
                    // if ($quantidadeData == 5) {
                    //     $valor = $data[2] . "-" . $data[3] . "-" . $data[4];
                    // } else {
                        $valor = $data[0] . "-" . $data[1] . "-" . $data[2];
                }
                // if (($campo === "totalAusenciasValeTransporte")) {
                //     continue;
                // }
                // if (($campo === "diasProjetoValeTransporte")) {
                //     continue;
                // }
                // if (($campo === "totalDiasTrabalhadosValeTransporte")) {
                //     continue;
                // }
                // if (($campo === "descricaoDataFaltaAusenciaValeTransporte")) {
                //     continue;
                // }
                if (($campo === "valeTransporteId")) {
                    continue;
                }

                $xmlValeTransporte = $xmlValeTransporte . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlValeTransporte = $xmlValeTransporte . "</" . $nomeTabela . ">";
        }
        $xmlValeTransporte = $xmlValeTransporte . "</" . $nomeXml . ">";
    } else {
        $xmlValeTransporte = '<?xml version="1.0"?>';
        $xmlValeTransporte = $xmlValeTransporte . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlValeTransporte = $xmlValeTransporte . "</" . $nomeXml . ">";
    }

    $xml = simplexml_load_string($xmlValeTransporte);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Vale Transporte";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlValeTransporte = "'" . $xmlValeTransporte . "'";

    $strArrayValorExtra = $_POST['jsonValorExtraArray'];
    $arrayValorExtra = json_decode($strArrayValorExtra, true);
    $xmlValorExtra = "";
    $nomeXml = "ArrayOfFolhaPontoValorExtra";
    $nomeTabela = "folhaPontoValorExtra";
    if (sizeof($arrayValorExtra) > 0) {
        $xmlValorExtra = '<?xml version="1.0"?>';
        $xmlValorExtra = $xmlValorExtra . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayValorExtra as $chave) {
            $xmlValorExtra = $xmlValorExtra . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                if (($campo === "sequencialValorExtra")) {
                    continue;
                }


                if (($campo === "valeTransporteId")) {
                    continue;
                }
                if (($campo === "valorExtra")) {
                    $valor = str_replace('.', '', $valor);
                    $valor = str_replace(',', '.', $valor);
                }

                $xmlValorExtra = $xmlValorExtra . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlValorExtra = $xmlValorExtra . "</" . $nomeTabela . ">";
        }
        $xmlValorExtra = $xmlValorExtra . "</" . $nomeXml . ">";
    } else {
        $xmlValorExtra = '<?xml version="1.0"?>';
        $xmlValorExtra = $xmlValorExtra . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlValorExtra = $xmlValorExtra . "</" . $nomeXml . ">";
    }

    $xml = simplexml_load_string($xmlValorExtra);

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Vale Transporte";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlValorExtra = "'" . $xmlValorExtra . "'";

    //Craiação do XML de Hora Extra
    $strArrayHoraExtra = $_POST['jsonHoraExtraArray'];
    $arrayHoraExtra = json_decode($strArrayHoraExtra, true);
    $xmlHoraExtra = "";
    $nomeXml = "ArrayOfFolhaPontoHoraExtra";
    $nomeTabela = "folhaPontoHoraExtra";
    if (sizeof($arrayHoraExtra) > 0) {
        $xmlHoraExtra = '<?xml version="1.0"?>';
        $xmlHoraExtra = $xmlHoraExtra . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayHoraExtra as $chave) {
            $xmlHoraExtra = $xmlHoraExtra . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                if (($campo === "sequencialHoraExtra")) {
                    continue;
                }
                if (($campo === "verificador")) {
                    continue;
                }

                if (($campo === "diaSemanaInicio")) {
                    continue;
                }
                if (($campo === "diaSemanaFim")) {
                    continue;
                }
                if (($campo === "horaExtraNoturna")) {
                    if ($valor == "Não Realizou") {
                        $valor = NULL;
                    }
                }
                if (($campo === "horaExtraId")) {
                    continue;
                }
                if (($campo === "dataHoraExtra")) {
                    $valor = formatarDataGravaXML($valor);
                }
                if (($campo === "dataHoraExtraFim")) {
                    $valor = formatarDataGravaXML($valor);
                }
               

                $xmlHoraExtra = $xmlHoraExtra . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlHoraExtra = $xmlHoraExtra . "</" . $nomeTabela . ">";
        }
        $xmlHoraExtra = $xmlHoraExtra . "</" . $nomeXml . ">";
    } else {
        $xmlHoraExtra = '<?xml version="1.0"?>';
        $xmlHoraExtra = $xmlHoraExtra . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlHoraExtra = $xmlHoraExtra . "</" . $nomeXml . ">";
    }

    $xml = simplexml_load_string($xmlHoraExtra);

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Vale Transporte";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlHoraExtra = "'" . $xmlHoraExtra . "'";


    $sql = "Beneficio.folhaPonto_Atualiza (" . $id . "," .
        $ativo . "," .
        $projeto . "," .
        $funcionario . "," .
        $mesAnoFolhaPonto . "," .
        $justificativaFolhaPonto . "," .
        $totalFaltasValeAlimentacao .  "," .
        $totalAusenciasValeAlimentacao .  "," .
        $diasProjetoValeAlimentacao .  "," .
        $totalDiasTrabalhadosValeAlimentacao .  "," .
        $totalFaltasValeTransporte .  "," .
        $totalAusenciasValeTransporte .  "," .
        $diasProjetoValeRefeicao .  "," .
        $totalDiasTrabalhadosValeRefeicao .  "," .
        $usuario . "," .
        $totalDiasTrabalhadosVT . "," .
        $diasUteisProjetoVT . "," .
        $diasUteisProjetoVAVR . "," .
        $xmlVAVR . "," .
        $xmlValeTransporte . "," .
        $xmlValorExtra . "," .
        $xmlHoraExtra .
        ") ";

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
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT codigo, ativo, projeto, funcionario, mesAnoFolhaPonto, justificativaFolhaPonto,
    totalFaltasVAVR, totalAusenciasVAVR, diasProjetoVAVR, totalDiasTrabalhadosVAVR,
    totalFaltasValeTransporte, totalAusenciasValeTransporte, diasProjetoValeRefeicao, totalDiasTrabalhadosValeRefeicao, totalDiasTrabalhadosVT
    FROM Beneficio.folhaPonto
    WHERE (0=0)
    AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $projeto = mb_convert_encoding($row['projeto'], 'UTF-8', 'HTML-ENTITIES');
        $funcionario = mb_convert_encoding($row['funcionario'], 'UTF-8', 'HTML-ENTITIES');
        $mesAnoFolhaPonto = formataDataRecuperacao($row['mesAnoFolhaPonto']);
        $mesAnoFolhaPonto = explode("/", $mesAnoFolhaPonto);
        $mesAnoFolhaPonto = $mesAnoFolhaPonto[1] . '/' . $mesAnoFolhaPonto[2];
        $justificativaFolhaPonto = mb_convert_encoding($row['justificativaFolhaPonto'], 'UTF-8', 'HTML-ENTITIES');

        // Accordion Dias Úteis - Vale Alimentação
        $totalFaltasValeAlimentacao = +$row['totalFaltasVAVR'];
        $totalAusenciasValeAlimentacao = +$row['totalAusenciasVAVR'];
        $diasProjetoValeAlimentacao = +$row['diasProjetoVAVR'];
        $totalDiasTrabalhadosValeAlimentacao = +$row['totalDiasTrabalhadosVAVR'];

        // Accordion Dias Úteis - Vale Refeição
        $totalFaltasValeTransporte = +$row['totalFaltasValeTransporte'];
        $totalAusenciasValeTransporte = +$row['totalAusenciasValeTransporte'];
        $diasProjetoValeRefeicao = +$row['diasProjetoValeRefeicao'];
        $totalDiasTrabalhadosValeRefeicao = +$row['totalDiasTrabalhadosValeRefeicao'];


        $totalDiasTrabalhadosVT = +$row['totalDiasTrabalhadosVT'];


        // Montando o array de Dias Úteis -> Vale Alimentação
        $reposit = "";
        $result = "";
        $sql = "SELECT FPDUVAVR.codigo, FPDUVAVR.faltaAusenciaValeAlimentacao, FPDUVAVR.dataFaltaAusenciaValeAlimentacao, FPDUVAVR.justificativaValeAlimentacao
        FROM Beneficio.folhaPontoDiasUteisVAVR FPDUVAVR
        INNER JOIN Beneficio.folhaPonto FP ON FP.codigo = FPDUVAVR.folhaPonto
        WHERE(0=0)
        AND FP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorValeAlimentacao = 0;
        $arrayValeAlimentacao = array();
        while ($row = odbc_fetch_array($result)) {
            $valeAlimentacaoId = $row['codigo'];
            $faltaAusenciaValeAlimentacao = $row['faltaAusenciaVAVR'];
            $dataFaltaAusenciaValeAlimentacao = $row['dataFaltaAusenciaVAVR'];
            $descricaoDataFaltaAusenciaValeAlimentacao = formataDataRecuperacao($dataFaltaAusenciaValeAlimentacao);
            $justificativaValeAlimentacao = mb_convert_encoding($row['justificativaVAVR'], 'UTF-8', 'HTML-ENTITIES');

            if ($faltaAusenciaValeAlimentacao === 'F') {
                $descricaoFaltasAusenciasValeAlimentacao = "Falta";
            } else {
                $descricaoFaltasAusenciasValeAlimentacao = "Ausência";
            }

            $contadorValeAlimentacao = $contadorValeAlimentacao + 1;
            $arrayValeAlimentacao[] = array(
                "sequencialValeAlimentacao" => $contadorValeAlimentacao,
                "valeAlimentacaoId" => $valeAlimentacaoId,
                "dataFaltaAusenciaValeAlimentacao" => $dataFaltaAusenciaValeAlimentacao,
                "faltaAusenciaValeAlimentacao" => $faltaAusenciaValeAlimentacao,
                "descricaoFaltasAusenciasValeAlimentacao" => $descricaoFaltasAusenciasValeAlimentacao,
                "descricaoDataFaltaAusenciaValeAlimentacao" => $descricaoDataFaltaAusenciaValeAlimentacao,
                "justificativaValeAlimentacao" => $justificativaValeAlimentacao
            );
        }

        $strArrayValeAlimentacao = json_encode($arrayValeAlimentacao);





        $reposit = "";
        $result = "";
        $sql = "SELECT VT.codigo, VT.faltaAusenciaValeTransporte, VT.dataFaltaAusenciaValeTransporte, VT.justificativaValeTransporte
        FROM Beneficio.folhaPontoDiasUteisVT VT 
        INNER JOIN Beneficio.folhaPonto FP ON FP.codigo = VT.folhaPonto
        WHERE(0=0)
        AND FP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorValeTransporte = 0;
        $arrayValeTransporte = array();
        while ($row = odbc_fetch_array($result)) {
            $valeTransporteId = $row['codigo'];
            $faltaAusenciaValeTransporte = $row['faltaAusenciaValeTransporte'];
            $dataFaltaAusenciaValeTransporte = $row['dataFaltaAusenciaValeTransporte'];
            $descricaoDataFaltaAusenciaValeTransporte = formataDataRecuperacao($dataFaltaAusenciaValeTransporte);
            $justificativaValeTransporte = mb_convert_encoding($row['justificativaValeTransporte'], 'UTF-8', 'HTML-ENTITIES');

            if ($faltaAusenciaValeTransporte === 'F') {
                $descricaoFaltasAusenciasValeTransporte = "Falta";
            } else {
                $descricaoFaltasAusenciasValeTransporte = "Ausência";
            }

            $contadorValeTransporte = $contadorValeTransporte + 1;
            $arrayValeTransporte[] = array(
                "sequencialValeTransporte" => $contadorValeTransporte,
                "valeTransporteId" => $valeTransporteId,
                "dataFaltaAusenciaValeTransporte" => $dataFaltaAusenciaValeTransporte,
                "faltaAusenciaValeTransporte" => $faltaAusenciaValeTransporte,
                "descricaoFaltasAusenciasValeTransporte" => $descricaoFaltasAusenciasValeTransporte,
                "descricaoDataFaltaAusenciaValeTransporte" => $descricaoDataFaltaAusenciaValeTransporte,
                "justificativaValeTransporte" => $justificativaValeTransporte
            );
        }

        $strArrayValeTransporte = json_encode($arrayValeTransporte);

        // Montando o array de Valor Extra
        $reposit = "";
        $result = "";
        $sql = "SELECT VE.codigo, FP.codigo AS fpCodigo, VE.folhaPonto, VE.beneficioExtra, VE.valor, VE.justificativa FROM Beneficio.folhaPontoValorExtra VE
        INNER JOIN  Beneficio.folhaPonto FP ON FP.codigo = VE.folhaPonto  WHERE (0=0)  AND FP.codigo =  " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorValorExtra = 0;
        $arrayValorExtra = array();
        while ($row = odbc_fetch_array($result)) {
            $row = array_map('utf8_encode', $row);
            $valorExtraId = $row['codigo'];
            $beneficioExtra = $row['beneficioExtra'];
            $valorExtra = $row['valor'];
            $valorExtra = str_replace('.', ',', $valorExtra);
            $justificativaValorExtra = $row['justificativa'];

            $contadorValorExtra = $contadorValorExtra + 1;
            $arrayValorExtra[] = array(
                "sequencialValorExtra" => $contadorValorExtra,
                "valorExtraId" => $valorExtraId,
                "beneficioExtra" => $beneficioExtra,
                "valorExtra" => $valorExtra,
                "justificativaValorExtra" => $justificativaValorExtra

            );
        }

        $strArrayValorExtra = json_encode($arrayValorExtra);



        // Montando o array de Dias Úteis -> Vale Alimentação
        $reposit = "";
        $result = "";
        $sql = "SELECT VAVR.codigo, VAVR.faltaAusenciaValeAlimentacao, VAVR.dataFaltaAusenciaValeAlimentacao, VAVR.justificativaValeAlimentacao
        FROM Beneficio.folhaPontoDiasUteisVAVR VAVR 
        INNER JOIN Beneficio.folhaPonto FP ON FP.codigo = VAVR.folhaPonto
        WHERE(0=0)
        AND FP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorValeAlimentacao = 0;
        $arrayValeAlimentacao = array();
        while ($row = odbc_fetch_array($result)) {
            $valeAlimentacaoId = $row['codigo'];
            $faltaAusenciaValeAlimentacao = $row['faltaAusenciaValeAlimentacao'];
            $dataFaltaAusenciaValeAlimentacao = $row['dataFaltaAusenciaValeAlimentacao'];
            $descricaoDataFaltaAusenciaValeAlimentacao = formataDataRecuperacao($dataFaltaAusenciaValeAlimentacao);
            $justificativaValeAlimentacao = mb_convert_encoding($row['justificativaValeAlimentacao'], 'UTF-8', 'HTML-ENTITIES');

            if ($faltaAusenciaValeAlimentacao === 'F') {
                $descricaoFaltasAusenciasValeAlimentacao = "Falta";
            } else {
                $descricaoFaltasAusenciasValeAlimentacao = "Ausência";
            }

            $contadorValeAlimentacao = $contadorValeAlimentacao + 1;
            $arrayValeAlimentacao[] = array(
                "sequencialValeAlimentacao" => $contadorValeAlimentacao,
                "valeAlimentacaoId" => $valeAlimentacaoId,
                "dataFaltaAusenciaValeAlimentacao" => $dataFaltaAusenciaValeAlimentacao,
                "faltaAusenciaValeAlimentacao" => $faltaAusenciaValeAlimentacao,
                "descricaoFaltasAusenciasValeAlimentacao" => $descricaoFaltasAusenciasValeAlimentacao,
                "descricaoDataFaltaAusenciaValeAlimentacao" => $descricaoDataFaltaAusenciaValeAlimentacao,
                "justificativaValeAlimentacao" => $justificativaValeAlimentacao
            );
        }

        $strArrayValeAlimentacao = json_encode($arrayValeAlimentacao);
        // Montando o array de Hora Extra
        $reposit = "";
        $result = "";
        $sql = "SELECT HE.* FROM Beneficio.folhaPontoHoraExtra HE INNER JOIN Beneficio.folhaPonto FP ON HE.folhaPonto = FP.codigo 
        WHERE (0=0) AND FP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorHoraExtra = 0;
        $arrayHoraExtra = array();

        while ($row = odbc_fetch_array($result)) {
            $dataInicio = formataDataRecuperacao($row['dataInicio']);
            $codigo = +$row['codigo'];
            $dataFim = formataDataRecuperacao($row['dataFim']);
            $horaInicio = validaHoraRecuperacao($row['horaInicio']);
            $horaFim = validaHoraRecuperacao($row['horaFim']);
            $qtdHoraExtra = validaHoraRecuperacao($row['qtdHoraExtra']);
            $horaExtraNoturna = validaHoraRecuperacao($row['horaExtraNoturna']);
            if ($horaExtraNoturna === 0) {
                $horaExtraNoturna = "Não Realizou";
            }
            $horaExtraDiurna = validaHoraRecuperacao($row['horaExtraDiurna']);
            $folhaPonto = $row['folhaPonto'];
            $justificativa = mb_convert_encoding($row['justificativa'], 'UTF-8', 'HTML-ENTITIES');

            $contadorHoraExtra = $contadorHoraExtra + 1;
            $arrayHoraExtra[] = array(
                "sequencialHoraExtra" => $contadorHoraExtra,
                "horaExtraId" => $codigo,
                "dataHoraExtra" => $dataInicio,
                "dataHoraExtraFim" => $dataFim,
                "horaInicioHoraExtra" => $horaInicio,
                "horaFimHoraExtra" => $horaFim,
                "horaTotalExtra" => $qtdHoraExtra,
                "horaExtraNoturna" => $horaExtraNoturna,
                "horaExtraDiurna" => $horaExtraDiurna,
                "justificativaHoraExtra" => $justificativa
            );
        }

        $strArrayHoraExtra = json_encode($arrayHoraExtra);


        $out = $id . "^" .
            $projeto . "^" .
            $funcionario . "^" .
            $mesAnoFolhaPonto . "^" .
            $justificativaFolhaPonto . "^" .
            $totalFaltasValeAlimentacao . "^" .
            $totalAusenciasValeAlimentacao . "^" .
            $diasProjetoValeAlimentacao . "^" .
            $totalDiasTrabalhadosValeAlimentacao . "^" .
            $totalFaltasValeTransporte . "^" .
            $totalAusenciasValeTransporte . "^" .
            $diasProjetoValeRefeicao . "^" .
            $totalDiasTrabalhadosValeRefeicao . "^" .
            $totalDiasTrabalhadosVT;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . "#" . $strArrayValeAlimentacao . "#" . $strArrayValeTransporte . "#" . $strArrayValorExtra . "#" . $strArrayHoraExtra;
        }
        return;
    }
}

function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FOLHAPONTO_ACESSAR|FOLHAPONTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um registro para excluir.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Beneficio.folhaPonto'.'|'.'ativo = 0' . '|'. 'codigo = '. $id); 

    if ($result < 1) {
        echo('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}



function verificaFerias()
{
    $id = $_POST["funcionario"];
    $mesAno = formataMesAno($_POST["mesAno"]);

    $sql = "SELECT codigo, funcionario, mesAno, dataInicio, 
    dataFim, quantidadeDias FROM Beneficio.funcionarioFerias WHERE (0=0) AND funcionario = " . $id . "AND ativo = 1 AND mesAno = " . $mesAno;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorFerias = 0;
    $arrayFerias = array();
    while ($row = odbc_fetch_array($result)) {
        $feriasId = $row['codigo'];
        $dataInicio = formataDataRecuperacao($row['dataInicio']);
        $dataFim = formataDataRecuperacao($row['dataFim']);
        $diasCorridos = $row['quantidadeDias'];

        $dataInicioParaDiff = $row['dataInicio'];
        $dataInicioParaDiff = explode(" ", $dataInicioParaDiff);
        $dataInicioParaDiff = $dataInicioParaDiff[0];
        $dataFimParaDiff = $row['dataFim'];
        $dataFimParaDiff = explode(" ", $dataFimParaDiff);
        $dataFimParaDiff = $dataFimParaDiff[0];

        $contadorFerias = $contadorFerias + 1;
        $arrayFerias[] = array(
            "sequencialFerias" => $contadorFerias,
            "dataInicioFerias" => $dataInicio,
            "dataFimFerias" => $dataFim,
        );
    }


    $strArrayFerias = json_encode($arrayFerias);


    if ($strArrayFerias == "[]") {
        echo ('failed#');
        return;
    }

    $sql = "SELECT COUNT(descricao) AS qtdFeriado FROM Ntl.feriado WHERE (0=0) 
        AND data BETWEEN " . "'" . $dataInicioParaDiff .  "'" . " AND " . "'" . $dataFimParaDiff . "'" . "AND ativo = 1 AND domingo = 0 
        or domingo = NULL AND sabado = 0 or sabado = NULL";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if (($row = odbc_fetch_array($result))) {
        $qtdFeriado = +$row['qtdFeriado'];
    }
    echo 'sucess#' . $strArrayFerias . "#" . $diasCorridos . "#" . $dataInicioParaDiff . "#" .
        $dataFimParaDiff . "#" . $qtdFeriado;
    return;
}

function recuperaDiaUtil()
{
    $mesAnoFolhaPonto = $_POST["mesAno"];
    $funcionario = $_POST["funcionario"];
    $projeto = $_POST["projeto"];

    //Extraindo somente o mes
    $mesAno = explode("/", $mesAnoFolhaPonto);
    $mes = $mesAno[0];
    $ano = $mesAno[1];

    $sql = "SELECT codigo, tipoDiaUtilVAVR, tipoDiaUtilVT, sindicato, projeto,municipioDiasUteisVAVR,municipioDiasUteisVT 
            FROM Ntl.beneficioProjeto WHERE funcionario = " . $funcionario . " AND projeto = " . $projeto . " AND ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if (($row = odbc_fetch_array($result))) {
        $tipoDiaUtilVAVR = $row['tipoDiaUtilVAVR'];
        $tipoDiaUtilVT = $row['tipoDiaUtilVT'];
        $sindicato = $row['sindicato'];
        $projeto = $row['projeto'];
        $municipioDiasUteisVAVR = $row['municipioDiasUteisVAVR'];
        $municipioDiasUteisVT = $row['municipioDiasUteisVT'];
    }
    if ($tipoDiaUtilVAVR == 1) {
        $descricaoTipoDiaUtilVAVR = "Projeto";
    } else if ($tipoDiaUtilVAVR == 2) {
        $descricaoTipoDiaUtilVAVR = "Sindicato";
    } else if ($tipoDiaUtilVAVR == 3) {
        $descricaoTipoDiaUtilVAVR = "Funcionário";
    } else if ($tipoDiaUtilVAVR == 5) {
        $descricaoTipoDiaUtilVAVR = "Município";
    }

    if ($tipoDiaUtilVT == 1) {
        $descricaoTipoDiaUtilVT = "Projeto";
    } else if ($tipoDiaUtilVT == 2) {
        $descricaoTipoDiaUtilVT = "Sindicato";
    } else if ($tipoDiaUtilVT == 3) {
        $descricaoTipoDiaUtilVT = "Funcionário";
    } else if ($tipoDiaUtilVT == 5) {
        $descricaoTipoDiaUtilVT = "Município";
    }
    //VAVR
    switch ($tipoDiaUtilVAVR) {
        case 1:
            $sql = "SELECT codigo, diaUtilJaneiroVAVR, diaUtilFevereiroVAVR, diaUtilMarcoVAVR, diaUtilAbrilVAVR, diaUtilMaioVAVR, diaUtilJunhoVAVR, diaUtilJulhoVAVR
            , diaUtilAgostoVAVR, diaUtilSetembroVAVR, diaUtilOutubroVAVR, diaUtilNovembroVAVR, diaUtilDezembroVAVR 
            FROM Ntl.projeto WHERE codigo = " . $projeto;

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtil = +$row['diaUtilJaneiroVAVR'];
                } else if ($mes == 2) {
                    $diaUtil = +$row['diaUtilFevereiroVAVR'];
                } else if ($mes == 3) {
                    $diaUtil = +$row['diaUtilMarcoVAVR'];
                } else if ($mes == 4) {
                    $diaUtil = +$row['diaUtilAbrilVAVR'];
                } else if ($mes == 5) {
                    $diaUtil = +$row['diaUtilMaioVAVR'];
                } else if ($mes == 6) {
                    $diaUtil = +$row['diaUtilJunhoVAVR'];
                } else if ($mes == 7) {
                    $diaUtil = +$row['diaUtilJulhoVAVR'];
                } else if ($mes  == 8) {
                    $diaUtil = +$row['diaUtilAgostoVAVR'];
                } else if ($mes == 9) {
                    $diaUtil = +$row['diaUtilSetembroVAVR'];
                } else if ($mes == 10) {
                    $diaUtil = +$row['diaUtilOutubroVAVR'];
                } else if ($mes == 11) {
                    $diaUtil = +$row['diaUtilNovembroVAVR'];
                } else if ($mes == 12) {
                    $diaUtil = +$row['diaUtilDezembroVAVR'];
                }
            }
            if ($row != false) {
                $out =
                    $diaUtil;
            }
            break;
        case 2:
            $sql = "SELECT codigo, diaUtilJaneiroVAVR, diaUtilFevereiroVAVR, diaUtilMarcoVAVR, diaUtilAbrilVAVR, diaUtilMaioVAVR, diaUtilJunhoVAVR, diaUtilJulhoVAVR
            , diaUtilAgostoVAVR, diaUtilSetembroVAVR, diaUtilOutubroVAVR, diaUtilNovembroVAVR, diaUtilDezembroVAVR 
            FROM Ntl.sindicato WHERE codigo = " . $sindicato;

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtil = +$row['diaUtilJaneiroVAVR'];
                } else if ($mes == 2) {
                    $diaUtil = +$row['diaUtilFevereiroVAVR'];
                } else if ($mes == 3) {
                    $diaUtil = +$row['diaUtilMarcoVAVR'];
                } else if ($mes == 4) {
                    $diaUtil = +$row['diaUtilAbrilVAVR'];
                } else if ($mes == 5) {
                    $diaUtil = +$row['diaUtilMaioVAVR'];
                } else if ($mes == 6) {
                    $diaUtil = +$row['diaUtilJunhoVAVR'];
                } else if ($mes == 7) {
                    $diaUtil = +$row['diaUtilJulhoVAVR'];
                } else if ($mes  == 8) {
                    $diaUtil = +$row['diaUtilAgostoVAVR'];
                } else if ($mes == 9) {
                    $diaUtil = +$row['diaUtilSetembroVAVR'];
                } else if ($mes == 10) {
                    $diaUtil = +$row['diaUtilOutubroVAVR'];
                } else if ($mes == 11) {
                    $diaUtil = +$row['diaUtilNovembroVAVR'];
                } else if ($mes == 12) {
                    $diaUtil = +$row['diaUtilDezembroVAVR'];
                }
            }
            if ($row != false) {
                $out =
                    $diaUtil;
            }

            break;
        case 3:
            $sql = "SELECT codigo, diaUtilJaneiroVAVR, diaUtilFevereiroVAVR, diaUtilMarcoVAVR, diaUtilAbrilVAVR, diaUtilMaioVAVR, diaUtilJunhoVAVR, diaUtilJulhoVAVR
            , diaUtilAgostoVAVR, diaUtilSetembroVAVR, diaUtilOutubroVAVR, diaUtilNovembroVAVR, diaUtilDezembroVAVR  FROM Ntl.beneficioProjeto 
            WHERE (0=0) AND funcionario = " . $funcionario . " AND projeto = " . $projeto . "AND ativo = 1";
            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtil = +$row['diaUtilJaneiroVAVR'];
                } else if ($mes == 2) {
                    $diaUtil = +$row['diaUtilFevereiroVAVR'];
                } else if ($mes == 3) {
                    $diaUtil = +$row['diaUtilMarcoVAVR'];
                } else if ($mes == 4) {
                    $diaUtil = +$row['diaUtilAbrilVAVR'];
                } else if ($mes == 5) {
                    $diaUtil = +$row['diaUtilMaioVAVR'];
                } else if ($mes == 6) {
                    $diaUtil = +$row['diaUtilJunhoVAVR'];
                } else if ($mes == 7) {
                    $diaUtil = +$row['diaUtilJulhoVAVR'];
                } else if ($mes  == 8) {
                    $diaUtil = +$row['diaUtilAgostoVAVR'];
                } else if ($mes == 9) {
                    $diaUtil = +$row['diaUtilSetembroVAVR'];
                } else if ($mes == 10) {
                    $diaUtil = +$row['diaUtilOutubroVAVR'];
                } else if ($mes == 11) {
                    $diaUtil = +$row['diaUtilNovembroVAVR'];
                } else if ($mes == 12) {
                    $diaUtil = +$row['diaUtilDezembroVAVR'];
                }
            }
            if ($row != false) {
                $out =
                    $diaUtil;
            }
            break;
            // case 5:
            //     $diasUteisSemFeriado = diasUteisMesCorrente($mes, $ano);
            //     $dataInicial = "'" . $ano . "-" . $mes . "-01" . "'";
            //     $dataFinal = "'" . $ano . "-" . $mes . "-31" . "'";

            //     $sql = "SELECT COUNT(descricao) AS qtdFeriado FROM Ntl.feriado WHERE (0=0) 
            // AND data BETWEEN " . $dataInicial . " AND " . $dataFinal . "AND ativo = 1 AND domingo = 0 
            // or domingo = NULL AND sabado = 0 or sabado = NULL";

            //     $reposit = new reposit();
            //     $result = $reposit->RunQuery($sql);
            //     if (($row = odbc_fetch_array($result))) {
            //         $qtdFeriado = +$row['qtdFeriado'];
            //         $diasUteisComFeriado =  $diasUteisSemFeriado - $qtdFeriado;
            //     }
            //     if ($row != false) {
            //         $out = $diasUteisComFeriado;
            //     } else {
            //         $out = $diasUteisSemFeriado;
            //     }
            //     break;
        case 5:
            $sql = "SELECT codigo,municipio,unidadeFederacao,quantidadeDiaJaneiro,quantidadeDiaFevereiro,quantidadeDiaMarco,quantidadeDiaAbril,
            quantidadeDiaMaio,quantidadeDiaJunho,quantidadeDiaJulho,quantidadeDiaAgosto,quantidadeDiaSetembro,quantidadeDiaOutubro,
            quantidadeDiaNovembro,quantidadeDiaDezembro
            FROM Ntl.diasUteisPorMunicipio where municipio = $municipioDiasUteisVAVR";

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
        
            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtil = +$row['quantidadeDiaJaneiro'];
                } else if ($mes == 2) {
                    $diaUtil = +$row['quantidadeDiaFevereiro'];
                } else if ($mes == 3) {
                    $diaUtil = +$row['quantidadeDiaMarco'];
                } else if ($mes == 4) {
                    $diaUtil = +$row['quantidadeDiaAbril'];
                } else if ($mes == 5) {
                    $diaUtil = +$row['quantidadeDiaMaio'];
                } else if ($mes == 6) {
                    $diaUtil = +$row['quantidadeDiaJunho'];
                } else if ($mes == 7) {
                    $diaUtil = +$row['quantidadeDiaJulho'];
                } else if ($mes  == 8) {
                    $diaUtil = +$row['quantidadeDiaAgosto'];
                } else if ($mes == 9) {
                    $diaUtil = +$row['quantidadeDiaSetembro'];
                } else if ($mes == 10) {
                    $diaUtil = +$row['quantidadeDiaOutubro'];
                } else if ($mes == 11) {
                    $diaUtil = +$row['quantidadeDiaNovembro'];
                } else if ($mes == 12) {
                    $diaUtil = +$row['quantidadeDiaDezembro'];
                }
            }
            if ($row != false) {
                $out =
                    $diaUtil;
            }
            break;

        default:
            # code...
            break;
    }
    //VT
    switch ($tipoDiaUtilVT) {
        case 1:
            $sql = "SELECT codigo, diaUtilJaneiroVT, diaUtilFevereiroVT, diaUtilMarcoVT, diaUtilAbrilVT, diaUtilMaioVT, diaUtilJunhoVT, diaUtilJulhoVT
            , diaUtilAgostoVT, diaUtilSetembroVT, diaUtilOutubroVT, diaUtilNovembroVT, diaUtilDezembroVT 
            FROM Ntl.projeto WHERE codigo = " . $projeto;

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtilVT = +$row['diaUtilJaneiroVT'];
                } else if ($mes == 2) {
                    $diaUtilVT = +$row['diaUtilFevereiroVT'];
                } else if ($mes == 3) {
                    $diaUtilVT = +$row['diaUtilMarcoVT'];
                } else if ($mes == 4) {
                    $diaUtilVT = +$row['diaUtilAbrilVT'];
                } else if ($mes == 5) {
                    $diaUtilVT = +$row['diaUtilMaioVT'];
                } else if ($mes == 6) {
                    $diaUtilVT = +$row['diaUtilJunhoVT'];
                } else if ($mes == 7) {
                    $diaUtilVT = +$row['diaUtilJulhoVT'];
                } else if ($mes  == 8) {
                    $diaUtilVT = +$row['diaUtilAgostoVT'];
                } else if ($mes == 9) {
                    $diaUtilVT = +$row['diaUtilSetembroVT'];
                } else if ($mes == 10) {
                    $diaUtilVT = +$row['diaUtilOutubroVT'];
                } else if ($mes == 11) {
                    $diaUtilVT = +$row['diaUtilNovembroVT'];
                } else if ($mes == 12) {
                    $diaUtilVT = +$row['diaUtilDezembroVT'];
                }
            }
            if ($row != false) {
                $outVT =
                    $diaUtilVT;
            }
            break;
        case 2:
            $sql = "SELECT codigo, diaUtilJaneiroVT, diaUtilFevereiroVT, diaUtilMarcoVT, diaUtilAbrilVT, diaUtilMaioVT, diaUtilJunhoVT, diaUtilJulhoVT
            , diaUtilAgostoVT, diaUtilSetembroVT, diaUtilOutubroVT, diaUtilNovembroVT, diaUtilDezembroVT 
            FROM Ntl.sindicato WHERE codigo = " . $sindicato;

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtilVT = +$row['diaUtilJaneiroVT'];
                } else if ($mes == 2) {
                    $diaUtilVT = +$row['diaUtilFevereiroVT'];
                } else if ($mes == 3) {
                    $diaUtilVT = +$row['diaUtilMarcoVT'];
                } else if ($mes == 4) {
                    $diaUtilVT = +$row['diaUtilAbrilVT'];
                } else if ($mes == 5) {
                    $diaUtilVT = +$row['diaUtilMaioVT'];
                } else if ($mes == 6) {
                    $diaUtilVT = +$row['diaUtilJunhoVT'];
                } else if ($mes == 7) {
                    $diaUtilVT = +$row['diaUtilJulhoVT'];
                } else if ($mes  == 8) {
                    $diaUtilVT = +$row['diaUtilAgostoVT'];
                } else if ($mes == 9) {
                    $diaUtilVT = +$row['diaUtilSetembroVT'];
                } else if ($mes == 10) {
                    $diaUtilVT = +$row['diaUtilOutubroVT'];
                } else if ($mes == 11) {
                    $diaUtilVT = +$row['diaUtilNovembroVT'];
                } else if ($mes == 12) {
                    $diaUtilVT = +$row['diaUtilDezembroVT'];
                }
            }
            if ($row != false) {
                $outVT =
                    $diaUtilVT;
            }

            break;
        case 3:
            $sql = "SELECT codigo, diaUtilJaneiroVT, diaUtilFevereiroVT, diaUtilMarcoVT, diaUtilAbrilVT, diaUtilMaioVT, diaUtilJunhoVT, diaUtilJulhoVT
            , diaUtilAgostoVT, diaUtilSetembroVT, diaUtilOutubroVT, diaUtilNovembroVT, diaUtilDezembroVT  FROM Ntl.beneficioProjeto 
            WHERE (0=0) AND funcionario = " . $funcionario . " AND projeto = " . $projeto . "AND ativo = 1";
            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtilVT = +$row['diaUtilJaneiroVT'];
                } else if ($mes == 2) {
                    $diaUtilVT = +$row['diaUtilFevereiroVT'];
                } else if ($mes == 3) {
                    $diaUtilVT = +$row['diaUtilMarcoVT'];
                } else if ($mes == 4) {
                    $diaUtilVT = +$row['diaUtilAbrilVT'];
                } else if ($mes == 5) {
                    $diaUtilVT = +$row['diaUtilMaioVT'];
                } else if ($mes == 6) {
                    $diaUtilVT = +$row['diaUtilJunhoVT'];
                } else if ($mes == 7) {
                    $diaUtilVT = +$row['diaUtilJulhoVT'];
                } else if ($mes  == 8) {
                    $diaUtilVT = +$row['diaUtilAgostoVT'];
                } else if ($mes == 9) {
                    $diaUtilVT = +$row['diaUtilSetembroVT'];
                } else if ($mes == 10) {
                    $diaUtilVT = +$row['diaUtilOutubroVT'];
                } else if ($mes == 11) {
                    $diaUtilVT = +$row['diaUtilNovembroVT'];
                } else if ($mes == 12) {
                    $diaUtilVT = +$row['diaUtilDezembroVT'];
                }
            }
            if ($row != false) {
                $outVT =
                    $diaUtilVT;
            }
            break;
            // case 5:
            //     $diasUteisSemFeriado = diasUteisMesCorrente($mes, $ano);
            //     $dataInicial = "'" . $ano . "-" . $mes . "-01" . "'";
            //     $dataFinal = "'" . $ano . "-" . $mes . "-31" . "'";

            //     $sql = "SELECT COUNT(descricao) AS qtdFeriado FROM Ntl.feriado WHERE (0=0) 
            // AND data BETWEEN " . $dataInicial . " AND " . $dataFinal . "AND ativo = 1 AND domingo = 0 
            // or domingo = NULL AND sabado = 0 or sabado = NULL";

            //     $reposit = new reposit();
            //     $result = $reposit->RunQuery($sql);
            //     if (($row = odbc_fetch_array($result))) {
            //         $qtdFeriado = +$row['qtdFeriado'];
            //         $diasUteisComFeriado =  $diasUteisSemFeriado - $qtdFeriado;
            //     }
            //     if ($row != false) {
            //         $outVT = $diasUteisComFeriado;
            //     } else {
            //         $outVT = $diasUteisSemFeriado;
            //     }
            //     break;

        case 5:
            $sql = "SELECT codigo,municipio,unidadeFederacao,quantidadeDiaJaneiro,quantidadeDiaFevereiro,quantidadeDiaMarco,quantidadeDiaAbril,
            quantidadeDiaMaio,quantidadeDiaJunho,quantidadeDiaJulho,quantidadeDiaAgosto,quantidadeDiaSetembro,quantidadeDiaOutubro,
            quantidadeDiaNovembro,quantidadeDiaDezembro
            FROM Ntl.diasUteisPorMunicipio where municipio = $municipioDiasUteisVT";

            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);

            if (($row = odbc_fetch_array($result))) {
                if ($mes == 1) {
                    $diaUtilVT = +$row['quantidadeDiaJaneiro'];
                } else if ($mes == 2) {
                    $diaUtilVT = +$row['quantidadeDiaFevereiro'];
                } else if ($mes == 3) {
                    $diaUtilVT = +$row['quantidadeDiaMarco'];
                } else if ($mes == 4) {
                    $diaUtilVT = +$row['quantidadeDiaAbril'];
                } else if ($mes == 5) {
                    $diaUtilVT = +$row['quantidadeDiaMaio'];
                } else if ($mes == 6) {
                    $diaUtilVT = +$row['quantidadeDiaJunho'];
                } else if ($mes == 7) {
                    $diaUtilVT = +$row['quantidadeDiaJulho'];
                } else if ($mes  == 8) {
                    $diaUtilVT = +$row['quantidadeDiaAgosto'];
                } else if ($mes == 9) {
                    $diaUtilVT = +$row['quantidadeDiaSetembro'];
                } else if ($mes == 10) {
                    $diaUtilVT = +$row['quantidadeDiaOutubro'];
                } else if ($mes == 11) {
                    $diaUtilVT = +$row['quantidadeDiaNovembro'];
                } else if ($mes == 12) {
                    $diaUtilVT = +$row['quantidadeDiaDezembro'];
                }
            }
            if ($row != false) {
                $outVT = $diaUtilVT;
            }
            break;

        default:
            # code...
            break;
    }

    // if ($out == "") {
    //     echo ('failed#');
    //     return;
    // }
    echo 'sucess#' . $out . "^" . $descricaoTipoDiaUtilVAVR . "^" . $outVT . "^" . $descricaoTipoDiaUtilVT;
    return;
}

function verificaFeriado()
{
    $data = formatarDataGrava($_POST['data']);
    $sql = "SELECT * FROM Ntl.feriado WHERE (0=0) AND data = " . $data;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if (($row = odbc_fetch_array($result))) {
        echo 'sucess#';
        return true;
    }
    echo ('failed#');
    return false;
}

function recuperaDiaUtilProjeto()
{
    $mesAnoFolhaPonto = $_POST["mesAno"];
    $projeto = $_POST["projeto"];

    //Extraindo somente o mes
    $mesAno = explode("/", $mesAnoFolhaPonto);
    $mes = $mesAno[0];
    $ano = $mesAno[1];


    $sql = "SELECT codigo, diaUtilJaneiroVAVR, diaUtilFevereiroVAVR, diaUtilMarcoVAVR, diaUtilAbrilVAVR, diaUtilMaioVAVR, diaUtilJunhoVAVR, diaUtilJulhoVAVR
            , diaUtilAgostoVAVR, diaUtilSetembroVAVR, diaUtilOutubroVAVR, diaUtilNovembroVAVR, diaUtilDezembroVAVR, diaUtilJaneiroVT, diaUtilFevereiroVT, diaUtilMarcoVT,
            diaUtilAbrilVT, diaUtilMaioVT, diaUtilJunhoVT, diaUtilJulhoVT, diaUtilAgostoVT, diaUtilSetembroVT, diaUtilOutubroVT, diaUtilNovembroVT, diaUtilDezembroVT 
            FROM Ntl.projeto WHERE codigo = " . $projeto;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if (($row = odbc_fetch_array($result))) {
        if ($mes == 1) {
            $diaUtil = +$row['diaUtilJaneiroVAVR'];
            $diaUtilVT = +$row['diaUtilJaneiroVT'];
        } else if ($mes == 2) {
            $diaUtil = +$row['diaUtilFevereiroVAVR'];
            $diaUtilVT = +$row['diaUtilFevereiroVT'];
        } else if ($mes == 3) {
            $diaUtil = +$row['diaUtilMarcoVAVR'];
            $diaUtilVT = +$row['diaUtilMarcoVT'];
        } else if ($mes == 4) {
            $diaUtil = +$row['diaUtilAbrilVAVR'];
            $diaUtilVT = +$row['diaUtilAbrilVT'];
        } else if ($mes == 5) {
            $diaUtil = +$row['diaUtilMaioVAVR'];
            $diaUtilVT = +$row['diaUtilMaioVT'];
        } else if ($mes == 6) {
            $diaUtil = +$row['diaUtilJunhoVAVR'];
            $diaUtilVT = +$row['diaUtilJunhoVT'];
        } else if ($mes == 7) {
            $diaUtil = +$row['diaUtilJulhoVAVR'];
            $diaUtilVT = +$row['diaUtilJulhoVT'];
        } else if ($mes  == 8) {
            $diaUtil = +$row['diaUtilAgostoVAVR'];
            $diaUtilVT = +$row['diaUtilAgostoVT'];
        } else if ($mes == 9) {
            $diaUtil = +$row['diaUtilSetembroVAVR'];
            $diaUtilVT = +$row['diaUtilSetembroVT'];
        } else if ($mes == 10) {
            $diaUtil = +$row['diaUtilOutubroVAVR'];
            $diaUtilVT = +$row['diaUtilOutubroVT'];
        } else if ($mes == 11) {
            $diaUtil = +$row['diaUtilNovembroVAVR'];
            $diaUtilVT = +$row['diaUtilNovembroVT'];
        } else if ($mes == 12) {
            $diaUtil = +$row['diaUtilDezembroVAVR'];
            $diaUtilVT = +$row['diaUtilDezembroVT'];
        }
    }
    if ($row != false) {
        $out =
            $diaUtil . "^" . $diaUtilVT;
    } else {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function populaComboFuncionario()
{
    $projeto = $_POST["projeto"];
    if ($projeto > 0) {
        $sql = "SELECT BP.codigo, BP.funcionario, F.nome FROM Ntl.beneficioProjeto BP INNER JOIN Ntl.funcionario F ON BP.funcionario = F.codigo WHERE (0=0) 
        AND projeto = " . $projeto . " AND BP.ativo = 1 AND F.dataDemissaoFuncionario IS NULL";

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contador = 0;
        $out = "";
        while (($row = odbc_fetch_array($result))) {
            $id = $row['funcionario'];
            $nomeFuncionario = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');

            $out = $out . $id . "^" . $nomeFuncionario . "|";

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

function periodoAdicionalNoturno()
{
    $funcionario = $_POST["funcionario"];
    if ($funcionario > 0) {
        $sql = "SELECT S.codigo, S.horaInicialAdicionalNoturno, S.horaFinalAdicionalNoturno FROM Ntl.sindicato S INNER JOIN Ntl.beneficioProjeto 
        BP ON BP.sindicato = S.codigo WHERE (0=0) AND ativo = 1 AND BP.funcionario = " . $funcionario;

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $out = "";
        if (($row = odbc_fetch_array($result))) {
            $id = $row['codigo'];
            $horaInicialAdicionalNoturno = $row['horaInicialAdicionalNoturno'];
            $horaFinalAdicionalNoturno = $row['horaFinalAdicionalNoturno'];

            $out = $horaInicialAdicionalNoturno . "^" . $horaFinalAdicionalNoturno;
        }
        if ($out != "") {
            echo "sucess#" . $out;
            return;
        }
        echo "failed#";
        return;
    }
}

function formatarNumero($value)
{
    $aux = $value;
    $aux = str_replace('.', '', $aux);
    $aux = str_replace(',', '.', $aux);
    $aux = floatval($aux);
    if (!$aux) {
        $aux = 'null';
    }
    return $aux;
}

function formatarString($value)
{
    $aux = $value;
    $aux = str_replace("'", " ", $aux);
    if (!$aux) {
        return 'null';
    }
    $aux = '\'' . trim($aux) . '\'';
    return $aux;
}


function formatarDataGrava($value)
{
    $aux = $value;
    if (!$aux) {
        return 'null';
    }
    $aux = explode('/', $value);
    $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
    $data = '\'' . trim($data) . '\'';
    return $data;
}

function formatarDataGravaXML($value)
{
    $aux = $value;
    if (!$aux) {
        return 'null';
    }
    $aux = explode('/', $value);
    $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
    $data = trim($data);
    return $data;
}

//Transforma uma data Y-M-D para D-M-Y. 
function formataDataRecuperacao($campo)
{
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}

function formataMesAno($value)
{
    $campo = explode("/", $value);
    $campoFormatado = $campo[1] . "-" . $campo[0] . "-01";
    return "'" . $campoFormatado . "'";
}

function diasUteisMesCorrente($mes, $ano)
{
    $uteis = 0;
    $diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    for ($dia = 1; $dia <= $diasMes; $dia++) {
        $timeStamp = mktime(0, 0, 0, $mes, $dia, $ano);
        $diaSemana = date("N", $timeStamp);
        if ($diaSemana < 6) $uteis++;
    }

    return $uteis;
}

function validaHoraRecuperacao($value)
{
    $aux = explode(":", $value);
    $horaFormatada = $aux[0] . ":" . $aux[1];
    return $horaFormatada;
}