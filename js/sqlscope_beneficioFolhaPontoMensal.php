<?php

use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS\File;

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

$pattern = "/(consultarLancamento|grava|recupera|excluir|consultarPermissoes|enviarFolha|recuperaPDF|atualizarStatus)/i";

$condicao = preg_match($pattern, $funcao);

if ($condicao) {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PONTOELETRONICOMENSAL_ACESSAR|PONTOELETRONICOMENSAL_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" .  $_SESSION['login'] . "'";

    /* Objeto com os arrays de objetos com dias,horas e etc para montar o XML */


    /* Objeto com o informações que não pertencem ao array do XML */
    $folhaPontoInfo = $_POST['folhaPontoInfo'];

    $codigo = (int) $folhaPontoInfo['codigo'];
    $funcionario = (int) $folhaPontoInfo['funcionario'];
    $observacao = "'" . (string)$folhaPontoInfo['observacao'] . "'";
    $ativo = (int) $folhaPontoInfo['ativo'];
    $status = (int) $folhaPontoInfo['status'];
    $mesAno = (string) $folhaPontoInfo['mesAno'];
    $data = explode('-', $mesAno);
    $totalDiasMes = cal_days_in_month(CAL_GREGORIAN, $data[1], $data[0]);

    if ($funcionario == 0) {
        $funcionario = (int)$_SESSION["funcionario"];
        if ($funcionario == 0) {
            echo "failed#" . "Funcionário não encontrado";
            return;
        }
    }

    $sql =  "SELECT F.codigo, F.mesAno FROM Funcionario.folhaPontoMensal F 
    INNER JOIN Ntl.funcionario FU ON F.funcionario = FU.codigo 
    WHERE (0=0) 
    AND F.mesAno BETWEEN '$mesAno' AND '$data[0]-$data[1]-$totalDiasMes' 
    AND FU.codigo = $funcionario";

    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        if ($row)
            $codigo = $row["codigo"];
    }

    /* Objeto com o informações pertencentes ao array do XML */
    $folhaPontoMensal = $_POST['folhaPontoMensalTabela'];
    $arrayFolhaPontoMensal = $folhaPontoMensal;
    $xmlFolhaPontoMensal = "";
    $nomeXml = "ArrayOfPonto";
    $nomeTabela = "ponto";
    $xmlFolhaPontoMensal = "<?xml version=\"1.0\"?>";
    $xmlFolhaPontoMensal .= "<$nomeXml xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">";
    foreach ($arrayFolhaPontoMensal as $folha) {
        $xmlFolhaPontoMensal .= "<$nomeTabela>";
        foreach ($folha as $key => $value) {
            if (in_array($key, ['horaEntrada', 'horaSaida'])) {
                if ($value == '') {
                    $xmlFolhaPontoMensal .= "<$key>00:00:00</$key>";
                } else {
                    $xmlFolhaPontoMensal .= "<$key>$value</$key>";
                }
                continue;
            }
            if (in_array($key, ['inicioAlmoco', 'fimAlmoco', 'horaExtra', 'atraso'])) {
                if ($value == '') {
                    $xmlFolhaPontoMensal .= "<$key>00:00</$key>";
                } else {
                    $xmlFolhaPontoMensal .= "<$key>$value</$key>";
                }
                continue;
            }
            $xmlFolhaPontoMensal .= "<$key>$value</$key>";
        }
        $xmlFolhaPontoMensal .= "</$nomeTabela>";
    }
    $xmlFolhaPontoMensal .= "</$nomeXml>";
    $xml = simplexml_load_string($xmlFolhaPontoMensal);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Lançamento";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlFolhaPontoMensal = "'" . $xmlFolhaPontoMensal . "'";

    $sql =
        "Funcionario.folhaPontoMensal_Atualiza 
        $codigo,
        $funcionario,
        '$mesAno',
        $observacao,
        $status,
        $usuario,
        $xmlFolhaPontoMensal
    ";


    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#Ponto gravado com sucesso!';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera()
{
    session_start();

    $funcionario = (int)$_POST["funcionario"];

    if($funcionario != $_SESSION["funcionario"]){
        echo "failed#Não há permissão para acessar a folha de outro funcionário#";
        return;
    }

    $mesAno = $_POST["mesAno"];
    $mesAno = preg_replace("/\d{2}$/", "01", $mesAno);

    $data = explode('-', $mesAno);
    $totalDiasMes = cal_days_in_month(CAL_GREGORIAN, $data[1], $data[0]);
    $folha = "";

    if (!$funcionario) {
        $funcionario = (int)$_SESSION["funcionario"];
    }
    $sql = "SELECT F.codigo AS 'folha',FU.codigo AS 'funcionario' FROM Funcionario.folhaPontoMensal F
            INNER JOIN Ntl.funcionario FU ON F.funcionario = FU.codigo
            WHERE FU.codigo = $funcionario  AND F.mesAno BETWEEN '$mesAno' AND '$data[0]-$data[1]-$totalDiasMes'";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {
        $folha = $row['folha'];
    }

    $observacao = "";
    $toleranciaAtraso = "05:00";
    $toleranciaExtra = "05:00";
    $status = 0;

    if ($folha) {
        $sql =
            "SELECT F.codigo, FU.codigo AS 'funcionario', F.mesAno, F.status, F.observacao, P.limiteEntrada AS 'limiteAtraso', P.limiteSaida AS 'limiteExtra'
        FROM Funcionario.folhaPontoMensal F
        INNER JOIN Ntl.funcionario FU ON FU.codigo = F.funcionario
        LEFT JOIN Ntl.beneficioProjeto BP ON FU.codigo = BP.funcionario 
        LEFT JOIN Ntl.projeto P ON P.codigo = BP.projeto
        WHERE (0=0) AND F.codigo = " . $folha;

        $result = $reposit->RunQuery($sql);

        if ($row = $result[0]) {
            $mesAno = trim($row['mesAno']);

            if ($mesAno != "") {
                $data = explode(' ', $mesAno);
                $mesAno = $data[0];
            } else {
                $mesAno = "";
            }

            $observacao = trim($row['observacao']);
            $status = (int)trim($row['status']);
            $toleranciaAtraso = trim($row['limiteAtraso']);
            $toleranciaExtra = trim($row['limiteExtra']);
        }
    } else {
        $folha = 0;
    }

    $out = "";

    $out =
        $folha . "^" .
        $observacao . "^" .
        $toleranciaAtraso . "^" .
        $toleranciaExtra . "^" .
        $status;

    if ($out == "") {
        echo "failed#" . "$out#";
        return;
    }

    $sql =  "SELECT FD.dia,FD.horaEntrada,FD.horaSaida,FD.inicioAlmoco,FD.fimAlmoco,FD.horaExtra,FD.atraso,FD.lancamento 
    FROM Funcionario.folhaPontoMensalDetalheDiario FD 
    INNER JOIN Funcionario.folhaPontoMensal F ON F.codigo = FD.folhaPontoMensal
    WHERE (0=0) AND F.codigo = " . $folha;

    $result = $reposit->RunQuery($sql);

    $arrayPonto = array();

    foreach ($result as $row) {

        $dia = $row["dia"];
        if ($dia == "") {
            $dia = 1;
        }
        $horaEntrada = $row["horaEntrada"];
        if ($horaEntrada == "") {
            $horaEntrada = "00:00:00";
        }
        $inicioAlmoco = $row["inicioAlmoco"];
        if ($inicioAlmoco == "") {
            $inicioAlmoco = "00:00";
        }
        $fimAlmoco = $row["fimAlmoco"];
        if ($fimAlmoco == "") {
            $fimAlmoco = "00:00";
        }
        $horaSaida = $row["horaSaida"];
        if ($horaSaida == "") {
            $horaSaida = "00:00:00";
        }
        $horaExtra = $row["horaExtra"];
        if ($horaExtra == "") {
            $horaExtra = "00:00";
        }
        $atraso = $row["atraso"];
        if ($atraso == "") {
            $atraso = "00:00";
        }
        $lancamento = $row["lancamento"];
        if ($lancamento == "") {
            $lancamento = 0;
        }

        $arrayRow = array(
            "dia"           =>  $dia,
            "entrada"       =>  $horaEntrada,
            "inicioAlmoco"  =>  $inicioAlmoco,
            "fimAlmoco"     =>  $fimAlmoco,
            "saida"         =>  $horaSaida,
            "horaExtra"     =>  $horaExtra,
            "atraso"        =>  $atraso,
            "lancamento"    =>  $lancamento
        );

        array_push($arrayPonto, $arrayRow);
    }

    if (!$arrayPonto) {
        $arrayRow = array(
            "dia"           =>  1,
            "entrada"       =>  "00:00:00",
            "inicioAlmoco"  =>  "00:00",
            "fimAlmoco"     =>  "00:00",
            "saida"         =>  "00:00:00",
            "horaExtra"     =>  "00:00",
            "atraso"        =>  "00:00",
            "lancamento"    =>  0
        );

        array_push($arrayPonto, $arrayRow);
    }
    $jsonFolha = json_encode($arrayPonto);

    echo "sucess#" . "$out#" . $jsonFolha;
    return;
}

function consultarLancamento()
{
    /*<-->Espaço destinada a variáveis ou funções utilitárias<-->*/
    session_start();
    $reposit = new reposit();
    $lancamento = $_POST['id'];

    $search = "abonaAtraso";
    $table = "Ntl.lancamento";
    $sql = "SELECT " . $search . " FROM " . $table . " WHERE codigo = " . $lancamento . "";
    $result = $reposit->RunQuery($sql);
    /* <-->Função destinada para consultar dados relacionados a página<--> */
    $row = $result[0];
    $abonaAtraso = (int)$row['abonaAtraso'];

    /*<-->Espaço destinado ao envio de dados<-->*/
    $out = $abonaAtraso;

    if ($out == "") {
        echo "failed#" . "$out#";
        return;
    }

    echo "sucess#" . "$out#";
    return;
}

function consultarPermissoes()
{
    session_start();
    $usuario = $_SESSION["login"];
    $reposit = new reposit();
    $sql =
        "SELECT F.nome FROM Ntl.funcionalidade F 
        INNER JOIN Ntl.usuarioFuncionalidade UF 
        ON F.codigo = UF.funcionalidade
        INNER JOIN Ntl.usuario U 
        ON U.codigo = UF.usuario 
        WHERE U.login = '" . $usuario . "' 
    UNION 
	SELECT F.nome FROM Ntl.funcionalidade F 
        INNER JOIN Ntl.usuarioGrupoFuncionalidade GF 
        ON F.codigo = GF.funcionalidade 
        INNER JOIN Ntl.usuario U ON U.grupo = GF.grupo";

    $result = $reposit->RunQuery($sql);
    $permissoes = array();
    $pattern = "/(PONTOELETRONICOMENSALMAXIMO_GRAVAR|PONTOELETRONICOMENSALMODERADO_GRAVAR|PONTOELETRONICOMENSALMINIMO_GRAVAR)/i";
    foreach ($result as $row) {
        if (preg_match($pattern, $row["nome"])) {
            array_push($permissoes, substr($row["nome"], 0, -7));
        }
    }

    $arrayPermissoes = array();
    foreach ($permissoes as $permissao) {
        switch ($permissao) {
            case 'PONTOELETRONICOMENSALMODERADO':
                $arrayPermissoes[$permissao] = [
                    "funcionario" => ["readonly" => true, "pointerEvents" => "none", "touchAction" => "none", "class" => "readonly"],
                    "mesAno" => ["readonly" => false, "class" => ""],
                    "status" => ["readonly" => false, "pointerEvents" => "auto", "touchAction" => "auto", "class" => "", "display" => "none"],
                    "dia" => ["readonly" => false, "class" => ""],
                    "entrada" => ["readonly" => false, "class" => ""],
                    "inicioAlmoco" => ["readonly" => false, "class" => ""],
                    "fimAlmoco" => ["readonly" => false, "class" => ""],
                    "saida" => ["readonly" => false, "class" => ""],
                    "extra" => ["readonly" => false, "class" => ""],
                    "atraso" => ["readonly" => false, "class" => ""],
                    "lancamento" => ["readonly" => false, "pointerEvents" => "auto", "touchAction" => "auto", "class" => ""],
                    "adicionarPonto" => ["disabled" => false],
                    "salvarAlteracoes" => ["disabled" => false],
                    "fechar" => ["disabled" => false]
                ];
                break;
            case 'PONTOELETRONICOMENSALMINIMO':
                $arrayPermissoes[$permissao] = [
                    "funcionario" => ["readonly" => true, "pointerEvents" => "none", "touchAction" => "none", "class" => "readonly"],
                    "mesAno" => ["readonly" => false, "class" => ""],
                    "status" => ["readonly" => true, "pointerEvents" => "auto", "touchAction" => "auto", "class" => "", "display" => "none"],
                    "dia" => ["readonly" => false, "class" => ""],
                    "entrada" => ["readonly" => true, "class" => ""],
                    "inicioAlmoco" => ["readonly" => true, "class" => ""],
                    "fimAlmoco" => ["readonly" => true, "class" => ""],
                    "saida" => ["readonly" => true, "class" => ""],
                    "extra" => ["readonly" => true, "class" => ""],
                    "atraso" => ["readonly" => true, "class" => ""],
                    "lancamento" => ["readonly" => false, "pointerEvents" => "auto", "touchAction" => "auto", "class" => ""],
                    "adicionarPonto" => ["disabled" => false],
                    "salvarAlteracoes" => ["disabled" => false],
                    "fechar" => ["disabled" => false]
                ];
                break;
        }
    }


    $out = json_encode($arrayPermissoes);

    if ($out == "") {
        echo "failed#" . "$out#";
        return;
    }

    echo "sucess#" . "$out#";
    return;
}

function enviarFolha()
{

    session_start();
    $usuario = $_SESSION['login'];
    $funcionario = $_SESSION["funcionario"];
    $jsonData = $_POST["jsonData"];

    if (!$funcionario) {
        $out = "failed#";
        return;
    }

    $uploadsPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . "uploads";
    $pontosEletronicosPath = $uploadsPath . DIRECTORY_SEPARATOR . "pontos_eletronicos";
    $funcionarioPath = $pontosEletronicosPath . DIRECTORY_SEPARATOR . $funcionario;

    if (!is_dir($uploadsPath)) {
        mkdir($uploadsPath);
    }

    if (!is_dir($pontosEletronicosPath)) {
        mkdir($pontosEletronicosPath);
    }

    if (!is_dir($funcionarioPath)) {
        mkdir($funcionarioPath);
    }

    $datasReferentes = array();
    $datasUploads = array();

    $filesContent = array();
    foreach ($jsonData as $array) {
        foreach ($array as $key => $value) {
            if ($key == "fileUploadFolha") {
                if (strpos($value, ',') !== false) {
                    @list($encode, $value) = explode(',', $value);
                }
                array_push($filesContent, base64_decode($value, true));
            } else if ($key == "dataReferenteUpload") {
                $aux = explode("/", $value);
                $value = $aux[2] . "-" . $aux[1] . "-" . $aux[0];
                array_push($datasReferentes, $value);
            } else if ($key == "dataUpload") {
                $aux = explode("/", $value);
                $value = $aux[2] . "-" . $aux[1] . "-" . $aux[0];
                array_push($datasUploads, $value);
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
        $filename = $funcionario . "_" . str_replace("-", "", $datasReferentes[$i]) . $extension;
        $path = $funcionarioPath . DIRECTORY_SEPARATOR . $filename;

        array_push($pathArray, $path);

        $start = stripos($path, DIRECTORY_SEPARATOR . "uploads");
        $recorte = explode($filename,substr($path, $start));
        array_push($relativePathArray,"." . $recorte[0]);
        array_push($fileNameArray, $filename);

        //Cria um arquivo de escrita e leitura
        try {
            $pdf = fopen($path, 'w+');

            //Escreve no arquivo criado
            fwrite($pdf, $pdfContent);
        } catch (Exception $e) {
            $out = "Não foi possível realizar o upload.#";
            echo "failed#".$out;
            return;
        } finally {
            if ($pdf)
                fclose($pdf);
        }

        $i++;
    }

    //=========XML=========//
    $xmlUploadFolha = "";
    $nomeXml = "ArrayOfUploadFolha";
    $nomeTabela = "folha";
    $j = 0;

    if (sizeof($pathArray) > 0) {
        $xmlUploadFolha = '<?xml version="1.0"?>';
        $xmlUploadFolha = $xmlUploadFolha . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($relativePathArray as $path) {
            $xmlUploadFolha = $xmlUploadFolha . "<" . $nomeTabela . ">";
            $xmlUploadFolha = $xmlUploadFolha . "<path>" . $path . "</path>";
            $xmlUploadFolha = $xmlUploadFolha . "<name>" . $fileNameArray[$j] . "</name>";
            $xmlUploadFolha = $xmlUploadFolha . "<type>" . "application/pdf" . "</type>";
            $xmlUploadFolha = $xmlUploadFolha . "<dataReferente>" . $datasReferentes[$j] . "</dataReferente>";
            $xmlUploadFolha = $xmlUploadFolha . "<dataUpload>" . $datasUploads[$j] . "</dataUpload>";
            $xmlUploadFolha = $xmlUploadFolha . "<usuarioCadastro>" . $usuario . "</usuarioCadastro>";
            $xmlUploadFolha = $xmlUploadFolha . "</" . $nomeTabela . ">";
            $j++;
        }
        $xmlUploadFolha = $xmlUploadFolha . "</" . $nomeXml . ">";
    } else {
        $xmlUploadFolha = '<?xml version="1.0"?>';
        $xmlUploadFolha = $xmlUploadFolha . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlUploadFolha = $xmlUploadFolha . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlUploadFolha);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlUploadFolha = "'" . $xmlUploadFolha . "'";

    //=========SQL=========//

    $reposit = new reposit();

    $sql = "Funcionario.logUploadFolhaPonto_Atualiza
        $funcionario,
        $xmlUploadFolha";

    $result = $reposit->Execprocedure($sql);

    if ($result < 1) {
        foreach ($pathArray as $delete) {
            unlink($delete);
        }

        $out = "Não foi possível realizar o upload.#";
        echo "failed#" . $out;
        return;
    } else {
        echo "sucess#" . $out;
        return;
    }
}

function recuperaPDF()
{
    session_start();

    $funcionario = $_SESSION['funcionario'];

    $reposit = new reposit();
    $sql = "SELECT filePath AS 'path',fileName AS 'name', fileType AS 'type', dataReferente AS 'dataReferenteUpload', dataCadastro AS 'dataUpload' FROM Funcionario.logUploadFolhaPonto";
    $where = " WHERE (0=0) AND ";
    $where .= "funcionario = " . $funcionario;

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
        $dataReferenteUpload = $row['dataReferenteUpload'];
        $sequencialUploadFolha = $i + 1;
        $dataUpload = $row['dataUpload'];

        array_push($pathArray, $path);
        array_push(
            $uploadArray,
            [
                "fileName" => $name,
                "fileType" => $type,
                "dataReferenteUpload" => $dataReferenteUpload,
                "dataUpload" => $dataUpload,
                "sequencialUploadFolha" => $sequencialUploadFolha

            ]
        );
        $i++;
    }

    $i = 0;
    foreach ($pathArray as $path) {
        $path = dirname(__DIR__) . substr($path,1);
        $content = file_get_contents($path . $uploadArray[$i]["fileName"]);
        $base64 = "data:application/pdf;base64," . base64_encode($content);

        $uploadArray[$i]["fileUploadFolha"] = $base64;
        $i++;
    }

    $jsonUpload = json_encode($uploadArray);

    $out = "Operação realizada com sucesso!";

    echo "success#" . "$out#" . $jsonUpload;
    return;
}

function atualizarStatus()
{
    session_start();
    $usuario = $_SESSION['login'];

    $codigo = $_POST["codigo"];
    $status = $_POST["status"];

    $reposit = new reposit();

    $result = $reposit->Update("Funcionario.folhaPontoMensal " . "|" .
        " status = " . $status . " , " . " usuarioAlteracao = '" . $usuario . "' , " . " dataAlteracao = GETDATE() " . "|" . " codigo = " . $codigo);

    $out = " #";
    if ($result < 1) {
        $out = "Erro ao efetuar a operação";
        echo "failed#" . "$out#";
        return;
    } else {
        $out = "Operação bem sucedida";
        echo "sucess#" . "$out#";
        return;
    }
}
