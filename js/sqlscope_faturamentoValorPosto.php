<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaValorPosto') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaValorPosto') {
    call_user_func($funcao);
}

if ($funcao == 'excluirValorPosto') {
    call_user_func($funcao);
}

return;

function gravaValorPosto()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("POSTO_ACESSAR|POSTO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    session_start();

    $usuario = "'" . $_SESSION['login'] . "'";
    $valorPosto = $_POST['valorPosto'];
    $codigo =  (int)$valorPosto['codigo'];
    $projeto =  (int)$valorPosto['projeto'];
    $posto = (int)$valorPosto['posto'];
    $ativo = (int)$valorPosto['ativo'];

    //Inicio do Json Remuneracao
    $strJsonRemuneracao = $valorPosto["jsonRemuneracao"];
    $arrayJsonRemuneracao = json_decode($strJsonRemuneracao, true);
    $xmlJsonRemuneracao = "";
    $nomeXml = "ArrayOfRemuneracao";
    $nomeTabela = "valorPostoRemuneracao";
    if (sizeof($arrayJsonRemuneracao) > 0) {
        $xmlJsonRemuneracao = '<?xml version="1.0"?>';
        $xmlJsonRemuneracao = $xmlJsonRemuneracao . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonRemuneracao as $chave) {
            $xmlJsonRemuneracao = $xmlJsonRemuneracao . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialRemuneracao")) {
                    continue;
                }
                if (($campo === "remuneracaoValor")) {
                    $valor = virgulaParaPonto($valor);
                }
                $xmlJsonRemuneracao = $xmlJsonRemuneracao . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonRemuneracao = $xmlJsonRemuneracao . "</" . $nomeTabela . ">";
        }
        $xmlJsonRemuneracao = $xmlJsonRemuneracao . "</" . $nomeXml . ">";
    } else {
        $xmlJsonRemuneracao = '<?xml version="1.0"?>';
        $xmlJsonRemuneracao = $xmlJsonRemuneracao . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonRemuneracao = $xmlJsonRemuneracao . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonRemuneracao);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonRemuneracao = "'" . $xmlJsonRemuneracao . "'";
    //Fim do Json Remuneracao

    //Inicio do Json Encargo
    $strJsonEncargo = $valorPosto["jsonEncargo"];
    $arrayJsonEncargo = json_decode($strJsonEncargo, true);
    $xmlJsonEncargo = "";
    $nomeXml = "ArrayOfEncargo";
    $nomeTabela = "valorPostoEncargo";
    if (sizeof($arrayJsonEncargo) > 0) {
        $xmlJsonEncargo = '<?xml version="1.0"?>';
        $xmlJsonEncargo = $xmlJsonEncargo . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonEncargo as $chave) {
            $xmlJsonEncargo = $xmlJsonEncargo . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialEncargo")) {
                    continue;
                }
                $xmlJsonEncargo = $xmlJsonEncargo . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonEncargo = $xmlJsonEncargo . "</" . $nomeTabela . ">";
        }
        $xmlJsonEncargo = $xmlJsonEncargo . "</" . $nomeXml . ">";
    } else {
        $xmlJsonEncargo = '<?xml version="1.0"?>';
        $xmlJsonEncargo = $xmlJsonEncargo . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonEncargo = $xmlJsonEncargo . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonEncargo);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonEncargo = "'" . $xmlJsonEncargo . "'";
    //Fim do Json Encargo

    //Inicio do Json Insumo
    $strJsonInsumo = $valorPosto["jsonInsumo"];
    $arrayJsonInsumo = json_decode($strJsonInsumo, true);
    $xmlJsonInsumo = "";
    $nomeXml = "ArrayOfInsumo";
    $nomeTabela = "valorPostoInsumo";
    if (sizeof($arrayJsonInsumo) > 0) {
        $xmlJsonInsumo = '<?xml version="1.0"?>';
        $xmlJsonInsumo = $xmlJsonInsumo . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonInsumo as $chave) {
            $xmlJsonInsumo = $xmlJsonInsumo . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialInsumo")) {
                    continue;
                }
                if (($campo === "insumoValor")) {
                    $valor = virgulaParaPonto($valor);
                }
                $xmlJsonInsumo = $xmlJsonInsumo . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonInsumo = $xmlJsonInsumo . "</" . $nomeTabela . ">";
        }
        $xmlJsonInsumo = $xmlJsonInsumo . "</" . $nomeXml . ">";
    } else {
        $xmlJsonInsumo = '<?xml version="1.0"?>';
        $xmlJsonInsumo = $xmlJsonInsumo . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonInsumo = $xmlJsonInsumo . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonInsumo);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonInsumo = "'" . $xmlJsonInsumo . "'";
    //Fim do Json Insumo

    //Inicio do Json Bdi
    $strJsonBdi = $valorPosto["jsonBdi"];
    $arrayJsonBdi = json_decode($strJsonBdi, true);
    $xmlJsonBdi = "";
    $nomeXml = "ArrayOfBdi";
    $nomeTabela = "valorPostoBdi";
    if (sizeof($arrayJsonBdi) > 0) {
        $xmlJsonBdi = '<?xml version="1.0"?>';
        $xmlJsonBdi = $xmlJsonBdi . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonBdi as $chave) {
            $xmlJsonBdi = $xmlJsonBdi . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialBdi")) {
                    continue;
                }
                $xmlJsonBdi = $xmlJsonBdi . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonBdi = $xmlJsonBdi . "</" . $nomeTabela . ">";
        }
        $xmlJsonBdi = $xmlJsonBdi . "</" . $nomeXml . ">";
    } else {
        $xmlJsonBdi = '<?xml version="1.0"?>';
        $xmlJsonBdi = $xmlJsonBdi . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonBdi = $xmlJsonBdi . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonBdi);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonBdi = "'" . $xmlJsonBdi . "'";
    //Fim do Json Bdi

    $sql = "Faturamento.valorPosto_Atualiza
        $codigo,
        $projeto,
        $posto,
        $ativo,
        $usuario,
        $xmlJsonRemuneracao,
        $xmlJsonEncargo,
        $xmlJsonInsumo,
        $xmlJsonBdi";

    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}


function recuperaValorPosto()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT codigo, projeto, posto,ativo FROM Faturamento.valorPosto WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0])

        $codigo = $row['codigo'];
    $projeto = $row['projeto'];
    $posto = $row['posto'];
    $ativo = $row['ativo'];

    // //----------------------Montando o array de remuneracao

    $reposit = "";
    $result = "";
    $sql = "SELECT VP.codigo,VP.valorPosto,VP.remuneracao, R.descricao AS remuneracaoDescricao,VP.valor
    FROM faturamento.valorPostoRemuneracao VP  
    LEFT JOIN Ntl.remuneracao R ON R.codigo = VP.remuneracao
    WHERE VP.valorPosto = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorRemuneracao = 0;
    $arrayRemuneracao = array();
    foreach ($result as $row) {
        $remuneracaoId = (int)$row['codigo'];
        $remuneracao = (int)$row['remuneracao'];
        $remuneracaoDescricao = (string)$row['remuneracaoDescricao'];
        $valor = number_format((float)$row['valor'], 2, ',', '.');


        $contadorRemuneracao = $contadorRemuneracao + 1;
        $arrayRemuneracao[] = array(
            "sequencialRemuneracao" => $contadorRemuneracao,
            "remuneracaoId" => $remuneracaoId,
            "remuneracao" => $remuneracao,
            "descricaoRemuneracao" => $remuneracaoDescricao,
            "remuneracaoValor" => $valor,
        );
    }

    $strArrayRemuneracao = json_encode($arrayRemuneracao);
    //------------------------Fim do Array remuneracao

    // //----------------------Montando o array de Encargo

    $reposit = "";
    $result = "";
    $sql = "SELECT VP.codigo,VP.valorPosto,VP.encargo, E.descricao AS encargoDescricao,VP.percentual,VP.grupo, G.descricao AS encargoGrupoDescricao
       FROM faturamento.valorPostoEncargo VP  
       LEFT JOIN Ntl.encargo E ON E.codigo = VP.encargo
       LEFT JOIN Ntl.grupo G ON G.codigo = VP.grupo
       WHERE VP.valorPosto = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorEncargo = 0;
    $arrayEncargo = array();
    foreach ($result as $row) {
        $encargoId = (int)$row['codigo'];
        $encargo = (int)$row['encargo'];
        $encargoDescricao = (string)$row['encargoDescricao'];
        $percentual = (float)$row['percentual'];
        $grupo = (int)$row['grupo'];    
        $encargoGrupoDescricao = (string)$row['encargoGrupoDescricao'];


        $contadorEncargo = $contadorEncargo + 1;
        $arrayEncargo[] = array(
            "sequencialEncargo" => $contadorEncargo,
            "encargoId" => $encargoId,
            "encargo" => $encargo,
            "encargoDescricao" => $encargoDescricao,
            "percentual" => $percentual,
            "encargoGrupo" => $grupo,
            "encargoGrupoDescricao" => $encargoGrupoDescricao,
        );
    }

    $strArrayEncargo = json_encode($arrayEncargo);
    //------------------------Fim do Array encargo

    // //----------------------Montando o array de Insumo

    $reposit = "";
    $result = "";
    $sql = "SELECT VP.codigo,VP.valorPosto,VP.insumo, I.descricao AS insumoDescricao,VP.valor,VP.grupo, G.descricao AS insumoGrupoDescricao
            FROM Faturamento.valorPostoInsumo VP  
            LEFT JOIN Ntl.insumo I ON I.codigo = VP.insumo
            LEFT JOIN Ntl.grupo G ON G.codigo = VP.grupo
            WHERE VP.valorPosto = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorInsumo = 0;
    $arrayInsumo = array();
    foreach ($result as $row) {
        $insumoId = (int)$row['codigo'];
        $insumo = (int)$row['insumo'];
        $insumoDescricao = (string)$row['insumoDescricao'];
        $valor = number_format((float)$row['valor'], 2, ',', '.');
        // $percentual = (float)$row['percentual'];
        $grupo = (int)$row['grupo'];
        $insumoGrupoDescricao = (string)$row['insumoGrupoDescricao'];


        $contadorInsumo = $contadorInsumo + 1;
        $arrayInsumo[] = array(
            "sequencialInsumo" => $contadorInsumo,
            "insumoId" => $insumoId,
            "insumo" => $insumo,
            "insumoDescricao" => $insumoDescricao,
            "insumoValor" => $valor,
            "insumoGrupo" => $grupo,
            "insumoGrupoDescricao" => $insumoGrupoDescricao,
        );
    }

    $strArrayInsumo = json_encode($arrayInsumo);
    //------------------------Fim do Array Insumo

    // //----------------------Montando o array de bdi

    $reposit = "";
    $result = "";
    $sql = "SELECT VP.codigo,VP.valorPosto,VP.bdi, R.descricao AS bdiDescricao,VP.percentual
            FROM faturamento.valorPostoBdi VP  
            LEFT JOIN Ntl.bdi R ON R.codigo = VP.bdi
            WHERE VP.valorPosto = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorBdi = 0;
    $arrayBdi = array();
    foreach ($result as $row) {
        $bdiId = (int)$row['codigo'];
        $bdi = (int)$row['bdi'];
        $bdiDescricao = (string)$row['bdiDescricao'];
        $percentual = (float)$row['percentual'];


        $contadorBdi = $contadorBdi + 1;
        $arrayBdi[] = array(
            "sequencialBdi" => $contadorBdi,
            "bdiId" => $bdiId,
            "bdi" => $bdi,
            "bdiDescricao" => $bdiDescricao,
            "bdiPercentual" => $percentual,
        );
    }

    $strArrayBdi = json_encode($arrayBdi);
    //------------------------Fim do Array bdi



    $out =   $codigo . "^" .
        $projeto . "^" .
        $posto . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayRemuneracao . "#" . $strArrayEncargo . "#" . $strArrayInsumo . "#" . $strArrayBdi;
    return;
}


function excluirValorPosto()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("POSTO_ACESSAR|POSTO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um banco.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Faturamento.valorPosto' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function virgulaParaPonto($value)
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

