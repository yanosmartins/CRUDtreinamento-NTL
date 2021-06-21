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

if ($funcao == 'pesquisaData') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosFuncionario') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosFuncionarioASO') {
    call_user_func($funcao);
}


return;


function recuperarDadosFuncionario()
{
    if ((empty($_POST["funcionario"])) || (!isset($_POST["funcionario"])) || (is_null($_POST["funcionario"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $funcionario = (int)$_POST["funcionario"];
    }

    $sql = "SELECT F.codigo AS 'codigoFuncionario',C.codigo AS 'codigoCargo',P.codigo AS 'codigoProjeto', F.matricula AS 'matricula',F.nome AS 'nome',F.sexo AS 'sexo',
    f.dataNascimento AS 'dataNascimento', C.descricao AS 'cargo', P.descricao AS 'projeto', F.dataAdmissaoFuncionario AS 'dataAdmissao', FO.apelido AS 'nomeClinica', F.clinica AS 'clinica'
    from ntl.beneficioProjeto BP
    INNER JOIN ntl.funcionario F ON F.codigo = BP.funcionario
    INNER JOIN ntl.projeto P ON P.codigo = BP.projeto
    INNER JOIN ntl.cargo C ON F.cargo = C.codigo
	LEFT JOIN ntl.clinica CLI ON CLI.codigo = F.clinica
    LEFT JOIN ntl.fornecedor FO ON FO.codigo = F.clinica
    where C.ativo=1 AND F.codigo = $funcionario AND F.ativo = 1 AND P.ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int) $row['codigoFuncionario'];
        $nome = $row['nome'];

        $reposit = "";
        $result = "";
        $sql = "SELECT codigo FROM Funcionario.atestadoSaudeOcupacional WHERE funcionario = " . $funcionario;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        if ((empty($result)) || ($result < 1)) {
            $matricula = $row['matricula'];
            $cargo = $row['cargo'];
            $projeto = $row['projeto'];
            $sexo = $row['sexo'];
            $dataNascimento = $row['dataNascimento'];
            $dataNascimentoTeste = new DateTime($dataNascimento);
            $dataAtual = new DateTime();
            $difData = date_diff($dataAtual, $dataNascimentoTeste);
            $idade = $difData->format('%y');
            $dataAdmissao = $row['dataAdmissao'];
            $cargoId = $row['codigoCargo'];
            $projetoId = $row['codigoProjeto'];
            $nomeClinica = $row['nomeClinica'];
            $clinica = $row['clinica'];
        } else {
            return;
        };
    }

    if ($dataNascimento != "") {
        $dataNascimentoFormatada = formataDataRecuperacao($dataNascimento);
    };
    if ($dataAdmissao != "") {
        $dataAdmissaoFormatada = formataDataRecuperacao($dataAdmissao);
    };

    $out = $codigo . "^" .
        $nome . "^" .
        $matricula . "^" .
        $cargo . "^" .
        $projeto . "^" .
        $sexo . "^" .
        $dataNascimentoFormatada . "^" .
        $idade . "^" .
        $dataAdmissaoFormatada . "^" .
        $cargoId . "^" .
        $projetoId ."^".
        $nomeClinica ."^".
        $clinica;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function recuperarDadosFuncionarioASO()
{
    if ((empty($_POST["funcionario"])) || (!isset($_POST["funcionario"])) || (is_null($_POST["funcionario"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $funcionario = (int)$_POST["funcionario"];
    }

    $sql = "SELECT F.codigo AS 'codigoFuncionario',C.codigo AS 'codigoCargo',P.codigo AS 'codigoProjeto', ASO.codigo,F.nome AS 'nome',ASO.matricula AS 'matricula',C.descricao AS 'cargo',P.descricao AS 'projeto',ASO.sexo AS 'sexo',
    ASO.dataNascimento AS 'dataNascimento',ASO.dataAdmissao AS 'dataAdmissao',ASO.dataUltimoAso AS 'dataUltimoAso',ASO.dataProximoAso AS 'dataValidadeAso',
    ASO.dataAgendamento AS 'dataAgendamento',ASOD.dataProximoAsoLista AS 'dataProximoAsoLista',ASOD.dataRealizacaoAso AS 'dataRealizacaoAso',
    ASOD.situacao AS 'situacao',ASOD.tipoExame AS 'tipoExame', ASO.ativo AS 'ativo' from funcionario.atestadoSaudeOcupacional ASO
    INNER JOIN funcionario.atestadoSaudeOcupacionalDetalhe ASOD ON ASO.codigo = ASOD.atestadoSaudeOcupacional
    INNER JOIN ntl.funcionario F ON ASO.funcionario = F.codigo
    INNER JOIN ntl.cargo C ON ASO.cargo = C.codigo
    INNER JOIN ntl.projeto P ON ASO.projeto = P.codigo
    WHERE C.ativo = 1 AND P.ativo = 1 AND F.codigo = $funcionario AND F.ativo = 1 AND ASO.ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int) $row['codigo'];
        $nome = $row['codigoFuncionario'];
        $matricula = $row['matricula'];
        $cargo = $row['cargo'];
        $projeto = $row['projeto'];
        $sexo = $row['sexo'];
        $dataNascimento = $row['dataNascimento'];
        $dataNascimentoTeste = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimentoTeste);
        $idade = $difData->format('%y');
        $dataAdmissao = $row['dataAdmissao'];
        $ativo = $row['ativo'];
        $cargoId = $row['codigoCargo'];
        $projetoId = $row['codigoProjeto'];
        $dataUltimoAso = $row['dataUltimoAso'];
        $dataValidadeAso = $row['dataValidadeAso'];
        $dataAgendamento = $row['dataAgendamento'];
    }

    if ($dataNascimento != "") {
        $dataNascimentoFormatada = formataDataRecuperacao($dataNascimento);
    };
    if ($dataAdmissao != "") {
        $dataAdmissaoFormatada = formataDataRecuperacao($dataAdmissao);
    };
    if ($dataUltimoAso != "") {
        $dataUltimoAsoFormatada = formataDataRecuperacao($dataUltimoAso);
    };
    if ($dataValidadeAso != "") {
        $dataValidadeAsoFormatada = formataDataRecuperacao($dataValidadeAso);
    };
    if ($dataAgendamento != "") {
        $dataAgendamentoFormatada = formataDataRecuperacao($dataAgendamento);
    };

    $reposit = new reposit();
    $sql = "SELECT ASOD.filePath AS 'path',ASOD.fileName AS 'name', ASOD.fileType AS 'type', ASOD.dataRealizacaoAso AS 'dataRealizacaoAso', ASOD.dataProximoAsoLista AS 'dataProximoAsoLista',ASOD.situacao AS 'situacao', ASOD.tipoExame AS 'tipoExame' FROM Funcionario.atestadoSaudeOcupacionalDetalhe ASOD
    INNER JOIN funcionario.atestadoSaudeOcupacional ASO ON ASO.codigo = atestadoSaudeOcupacional";
    $where = " WHERE (0=0) AND ";
    $where .= "ASO.funcionario = " . $funcionario;

    $sql .= $where;

    $result = $reposit->RunQuery($sql);
    $out = "";

    if ($result < 1) {
        echo "failed#" . "$out#";
        return;
    }

    $uploadArray = array();
    $pathArray = array();
    $i = 0;

    foreach ($result as $row) {
        $path = $row["path"];
        $name = $row["name"];
        $type = $row["type"];
        $dataRealizacaoAso = $row['dataRealizacaoAso'];
        $sequencialDataAso = $i + 1;
        $dataProximoAsoLista = $row['dataProximoAsoLista'];
        $situacao = $row['situacao'];
        $tipoExame = $row['tipoExame'];

        if ($tipoExame == 1) {
            $descricaoTipoExame = "Exame Admissional";
        }
        if ($tipoExame == 2) {
            $descricaoTipoExame = "Exame Periódico";
        }
        if ($tipoExame == 3) {
            $descricaoTipoExame = "Mudança de Risco Ocupacional";
        }
        if ($tipoExame == 4) {
            $descricaoTipoExame = "Retorno ao Trabalho";
        }

        if ($sexo == 'M') {
            $sexo = "Masculino";
        } else {
            $sexo = "Feminino";
        }


        array_push($pathArray, $path);
        array_push(
            $uploadArray,
            [
                "fileName" => $name,
                "fileType" => $type,
                "dataRealizacaoAso" => $dataRealizacaoAso,
                "dataProximoAsoLista" => $dataProximoAsoLista,
                "situacao" => $situacao,
                "tipoExame" => $tipoExame,
                "descricaoTipoExame" => $descricaoTipoExame,
                "sequencialDataAso" => $sequencialDataAso

            ]
        );
        $i++;
    }

    $i = 0;
    foreach ($pathArray as $path) {
        $path = dirname(__DIR__) . substr($path, 1);
        $content = file_get_contents($path . $uploadArray[$i]["fileName"]);
        $base64 = "data:application/pdf;base64," . base64_encode($content);

        $uploadArray[$i]["fileUploadAso"] = $base64;
        $i++;
    }

    $jsonUpload = json_encode($uploadArray);


    $out = $codigo . "^" .
        $nome . "^" .
        $matricula . "^" .
        $cargo . "^" .
        $projeto . "^" .
        $sexo . "^" .
        $dataNascimentoFormatada . "^" .
        $idade . "^" .
        $dataAdmissaoFormatada . "^" .
        $ativo . "^" .
        $dataUltimoAsoFormatada . "^" .
        $dataValidadeAsoFormatada . "^" .
        $dataAgendamentoFormatada  . "^" .
        $cargoId . "^" .
        $projetoId;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $jsonUpload;
    return;
}

function grava()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("ASO_ACESSAR|ASO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    //Variáveis
    if ((empty($_POST['id'])) || (!isset($_POST['id'])) || (is_null($_POST['id']))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = (int) $_POST["ativo"];
    }


    //Variáveis que estão sendo passadas.
    session_start();
    $usuario = $_SESSION['login'];  //Pegando o nome do usuário mantido pela sessão.
    $dataAso = $_POST['dataAso'];
    $funcionario = (int)$dataAso['funcionario'];
    $matricula = (int)$dataAso['matricula'];
    $cargo = (int)$dataAso['cargo'];
    $projeto = (int) $dataAso['projeto'];
    $sexo = (string) $dataAso['sexo'];
    $dataNascimento = formatarData($dataAso['dataNascimento']);
    $dataAdmissao = formatarData($dataAso['dataAdmissao']);
    $dataUltimoAso = formatarData($dataAso['dataUltimoAso']);
    $dataProximoAso = formatarData($dataAso['dataProximoAso']);
    $dataAgendamento = formatarData($dataAso['dataAgendamento']);
    $ativo =  $dataAso['ativo'];

    $reposit = "";
    $result = "";
    $sql = "SELECT codigo FROM Funcionario.atestadoSaudeOcupacional WHERE funcionario = " . $funcionario;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if ((empty($result)) || ($result < 1)) {
    } else {
        $row = $result[0];
        $codigoFolha = $row['codigo'];
        $id = $codigoFolha;
    };
    // INICIO UPLOAD //

    $jsonData = $_POST["jsonData"];

    if (!$funcionario) {
        $out = "failed#";
        return;
    }

    $uploadsPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . "uploads";
    $asoPath = $uploadsPath . DIRECTORY_SEPARATOR . "aso";
    $funcionarioPath = $asoPath . DIRECTORY_SEPARATOR . $funcionario;

    if (!is_dir($uploadsPath)) {
        mkdir($uploadsPath);
    }

    if (!is_dir($asoPath)) {
        mkdir($asoPath);
    }

    if (!is_dir($funcionarioPath)) {
        mkdir($funcionarioPath);
    }

    $dataRealizacaoAso = array();
    $dataProximoAsoLista = array();
    $tipoExame = array();
    $situacao = array();

    $filesContent = array();
    foreach ($jsonData as $array) {
        foreach ($array as $key => $value) {
            if ($key == "fileUploadAso") {
                if (strpos($value, ',') !== false) {
                    @list($encode, $value) = explode(',', $value);
                }
                array_push($filesContent, base64_decode($value, true));
            } else if ($key == "dataRealizacaoAso") {
                $aux = explode("/", $value);
                $value = $aux[2] . "-" . $aux[1] . "-" . $aux[0];
                array_push($dataRealizacaoAso, $value);
            } else if ($key == "dataProximoAsoLista") {
                $aux = explode("/", $value);
                $value = $aux[2] . "-" . $aux[1] . "-" . $aux[0];
                array_push($dataProximoAsoLista, $value);
            } else if ($key == "tipoExame") {
                array_push($tipoExame, $value);
            } else if ($key == "situacao") {
                array_push($situacao, $value);
            }
        }
    }

    $i = 0;
    $pathArray = array();

    $relativePathArray = array();
    $fileNameArray = array();

    foreach ($filesContent as $file) {

        //Passa o base64 decodificado para uma variavel que se refe ao conteudo
        $pdfContent = $file;

        $extension = ".pdf";
        $filename = $funcionario . "_" . str_replace("-", "", $dataRealizacaoAso[$i]) . $extension;
        $path = $funcionarioPath . DIRECTORY_SEPARATOR . $filename;

        array_push($pathArray, $path);

        $start = stripos($path, DIRECTORY_SEPARATOR . "uploads");
        $recorte = explode($filename, substr($path, $start));
        array_push($relativePathArray, "." . $recorte[0]);
        array_push($fileNameArray, $filename);

        //Cria um arquivo de escrita e leitura
        try {
            $pdf = fopen($path, 'w+');

            //Escreve no arquivo criado
            fwrite($pdf, $pdfContent);
        } catch (Exception $e) {
            $out = "Não foi possível realizar o upload.#";
            echo "failed#" . $out;
            return;
        } finally {
            if ($pdf)
                fclose($pdf);
        }

        $i++;
    }

    //FIM UPLOAD//

    // INICIO XML //
    $strArrayDataAso = $_POST['jsonData'];
    $arrayDataAso = $strArrayDataAso;
    if (!is_null($strArrayDataAso)) {
        $xmlDataAso = "";
        $nomeXml = "ArrayOfDataAso";
        $nomeTabela = "atestadoSaudeOcupacionalDetalhe";
        if (sizeof($pathArray) > 0) {
            $xmlDataAso = '<?xml version="1.0"?>';
            $xmlDataAso = $xmlDataAso . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema%22%3E">';
            $j = 0;
            foreach ($relativePathArray as $path) {
                $xmlDataAso = $xmlDataAso . "<" . $nomeTabela . ">";
                $xmlDataAso = $xmlDataAso . "<path>" . $path . "</path>";
                $xmlDataAso = $xmlDataAso . "<name>" . $fileNameArray[$j] . "</name>";
                $xmlDataAso = $xmlDataAso . "<type>" . "application/pdf" . "</type>";
                $xmlDataAso = $xmlDataAso . "<dataRealizacaoAso>" . $dataRealizacaoAso[$j] . "</dataRealizacaoAso>";
                $xmlDataAso = $xmlDataAso . "<dataProximoAsoLista>" . $dataProximoAsoLista[$j] . "</dataProximoAsoLista>";
                $xmlDataAso = $xmlDataAso . "<tipoExame>" . $tipoExame[$j] . "</tipoExame>";
                $xmlDataAso = $xmlDataAso . "<situacao>" . $situacao[$j] . "</situacao>";
                $xmlDataAso = $xmlDataAso . "</" . $nomeTabela . ">";
                $j++;
            }
            $xmlDataAso = $xmlDataAso . "</" . $nomeXml . ">";
        } else {
            $xmlDataAso = '<?xml version="1.0"?>';
            $xmlDataAso = $xmlDataAso . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema%22%3E';
            $xmlDataAso = $xmlDataAso . "</" . $nomeXml . ">";
        }
        $xml = simplexml_load_string($xmlDataAso);
        if ($xml === false) {
            $mensagem = "Erro na criação do XML de Aso";
            echo "failed#" . $mensagem . ' ';
            return;
        }
        $xmlDataAso = "'" . $xmlDataAso . "'";

        // FIM XML//



        if ($sexo == 'Masculino') {
            $sexo = 'M';
        } else {
            $sexo = 'F';
        }


        $sql = "Funcionario.atestadoSaudeOcupacional_Atualiza "
            . $id . ","
            . $funcionario . ","
            . $matricula . ","
            . $cargo . ","
            . $projeto . ","
            . $sexo . ","
            . $dataNascimento . ","
            . $dataAdmissao . ","
            . $dataUltimoAso . ","
            . $dataProximoAso . ","
            . $dataAgendamento  . ","
            . $ativo  . ","
            . $usuario . ","
            . $xmlDataAso . "";

        $result = $reposit->Execprocedure($sql);

        $ret = 'sucess#';
        if ($result < 1) {
            $ret = 'failed#';
        }
        echo $ret;
        return;
    }
}

function recupera()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int)$_POST["id"];
    }

    $sql = "SELECT ASO.codigo, ASO.funcionario,C.codigo AS 'cargoId',P.codigo AS 'projetoId', F.matricula,F.nome,P.descricao AS 'projetoNome',C.descricao AS 'cargoNome',F.sexo,
    ASO.dataAdmissao, ASO.dataNascimento, ASO.dataAgendamento, ASO.dataProximoAso, ASO.dataUltimoAso,ASO.ativo FROM funcionario.atestadoSaudeOcupacional ASO
        INNER JOIN ntl.funcionario F ON F.codigo = ASO.funcionario
        INNER JOIN ntl.cargo C ON C.codigo = ASO.cargo
        INNER JOIN ntl.projeto P ON P.codigo = ASO.projeto
    WHERE ASO.codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int) $row['codigo'];
        $matricula = $row['matricula'];
        $funcionario = $row['funcionario'];
        $cargo = $row['cargoNome'];
        $projeto = $row['projetoNome'];
        $sexo = $row['sexo'];
        $dataNascimento = $row['dataNascimento'];
        $dataNascimentoTeste = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimentoTeste);
        $idade = $difData->format('%y');
        $dataAdmissao = $row['dataAdmissao'];
        $ativo = $row['ativo'];
        $dataProximoAso = $row['dataProximoAso'];
        $dataUltimoAso = $row['dataUltimoAso'];
        $dataAgendamento = $row['dataAgendamento'];
        $cargoId = $row['cargoId'];
        $projetoId = $row['projetoId'];
    }

    if ($dataNascimento != "") {
        $dataNascimentoFormatada = formataDataRecuperacao($dataNascimento);
    };
    if ($dataAdmissao != "") {
        $dataAdmissaoFormatada = formataDataRecuperacao($dataAdmissao);
    };

    if ($dataProximoAso != "") {
        $dataProximoAsoFormatada = formataDataRecuperacao($dataProximoAso);
    };

    if ($dataUltimoAso != "") {
        $dataUltimoAsoFormatada = formataDataRecuperacao($dataUltimoAso);
    };


    if ($dataAgendamento != "") {
        $dataAgendamentoFormatada = formataDataRecuperacao($dataAgendamento);
    };

    if ($sexo == "M") {
        $sexo = "Masculino";
    } else {
        $sexo = "Feminino";
    }
    // XML UPLOAD

    $reposit = new reposit();
    $sql = "SELECT filePath AS 'path',fileName AS 'name', fileType AS 'type', dataRealizacaoAso AS 'dataRealizacaoAso', dataProximoAsoLista AS 'dataProximoAsoLista',situacao AS 'situacao', tipoExame AS 'tipoExame' FROM Funcionario.atestadoSaudeOcupacionalDetalhe";
    $where = " WHERE (0=0) AND ";
    $where .= "atestadoSaudeOcupacional = " . $id;

    $sql .= $where;

    $result = $reposit->RunQuery($sql);
    $out = "";

    if ($result < 1) {
        echo "failed#" . "$out#";
        return;
    }

    $uploadArray = array();
    $pathArray = array();
    $i = 0;

    foreach ($result as $row) {
        $path = $row["path"];
        $name = $row["name"];
        $type = $row["type"];
        $dataRealizacaoAso = $row['dataRealizacaoAso'];
        $sequencialDataAso = $i + 1;
        $dataProximoAsoLista = $row['dataProximoAsoLista'];
        $situacao = $row['situacao'];
        $tipoExame = $row['tipoExame'];

        if ($tipoExame == 1) {
            $descricaoTipoExame = "Exame Admissional";
        }
        if ($tipoExame == 2) {
            $descricaoTipoExame = "Exame Periódico";
        }
        if ($tipoExame == 3) {
            $descricaoTipoExame = "Mudança de Risco Ocupacional";
        }
        if ($tipoExame == 4) {
            $descricaoTipoExame = "Retorno ao Trabalho";
        }


        array_push($pathArray, $path);
        array_push(
            $uploadArray,
            [
                "path" => $path,
                "fileName" => $name,
                "fileType" => $type,
                "dataRealizacaoAso" => $dataRealizacaoAso,
                "dataProximoAsoLista" => $dataProximoAsoLista,
                "situacao" => $situacao,
                "tipoExame" => $tipoExame,
                "descricaoTipoExame" => $descricaoTipoExame,
                "sequencialDataAso" => $sequencialDataAso

            ]
        );
        $i++;
    }

    $i = 0;
    foreach ($pathArray as $path) {
        $path = dirname(__DIR__) . substr($path, 1);
        $content = file_get_contents($path . $uploadArray[$i]["fileName"]);
        $base64 = "data:application/pdf;base64," . base64_encode($content);

        $uploadArray[$i]["fileUploadAso"] = $base64;
        $i++;
    }

    $jsonUpload = json_encode($uploadArray);

    // FIM XML UPLOAD

    $out = $codigo . "^" .
        $funcionario . "^" .
        $matricula . "^" .
        $cargo . "^" .
        $projeto . "^" .
        $sexo . "^" .
        $dataNascimentoFormatada . "^" .
        $idade . "^" .
        $dataAdmissaoFormatada . "^" .
        $ativo  . "^" .
        $dataUltimoAsoFormatada . "^" .
        $dataProximoAsoFormatada . "^" .
        $dataAgendamentoFormatada . "^" .
        $cargoId . "^" .
        $projetoId;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "success#" . "$out#" . $jsonUpload;
    return;
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FERIADO_ACESSAR|FERIADO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('funcionario.atestadoSaudeOcupacional' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}



/* Esta função verifica no banco se uma data já existe. 
    *  Se existir, ela gera um painel de alerta que pergunta
    *  se o usuário quer continuar a gravar mesmo com a data já existente.
    *  Essa função pode acabar mudando de acordo com a regra de negócio.
    */

function pesquisaData()
{
    $condicaoData = !((empty($_POST["dataFeriado"])) || (!isset($_POST["dataFeriado"])) || (is_null($_POST["dataFeriado"])));

    if ($condicaoData) {
        $condicaoData = formatarData($_POST["dataFeriado"]);
    }

    $sql = "SELECT codigo, data AS dataFeriado FROM Ntl.feriado WHERE data = " . $condicaoData;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $dataFeriado = $row['dataFeriado'];
        //manda os dados pra piece e depois são explodidos
        $out = $dataFeriado;
    }

    if ($out == "") {
        echo "failed#";
    }
    if ($out != '') {
        echo "sucess#" . $out;
    }
    return;
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


function formatarData($value)
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

//Transforma uma data Y-M-D para D-M-Y. 
function formataDataRecuperacao($campo)
{
    $campo = explode(" ", $campo);
    $diaCampo = explode("-", $campo[0]);
    $campo = $diaCampo[2] . "/" . $diaCampo[1] . "/" . $diaCampo[0];
    return $campo;
}
