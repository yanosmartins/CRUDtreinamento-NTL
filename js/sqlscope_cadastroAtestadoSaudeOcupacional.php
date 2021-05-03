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
if ($funcao == 'popularComboMunicipio') {
    call_user_func($funcao);
}

if ($funcao == 'pesquisaData') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosFuncionario') {
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
    f.dataNascimento AS 'dataNascimento', C.descricao AS 'cargo', P.descricao AS 'projeto', F.dataAdmissaoFuncionario AS 'dataAdmissao'
    from ntl.beneficioProjeto BP
    INNER JOIN ntl.funcionario F ON F.codigo = BP.funcionario
    INNER JOIN ntl.projeto P ON P.codigo = BP.projeto
    INNER JOIN ntl.cargo C ON F.cargo = C.codigo
    where C.ativo=1 AND F.codigo = $funcionario AND F.ativo = 1 AND P.ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int) $row['codigoFuncionario'];
        $nome = $row['nome'];
        $matricula = $row['matricula'];
        $cargo = $row['cargo'];
        $projeto = $row['projeto'];
        $sexo = $row['sexo'];
        $dataNascimento = $row['dataNascimento'];
        $dataAdmissao = $row['dataAdmissao'];
        $dataNascimentoTeste = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimentoTeste);
        $idade = $difData->format('%y');
        $cargoId = $row['codigoCargo'];
        $projetoId = $row['codigoProjeto'];
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
        $dataAdmissaoFormatada . "^" .
        $idade. "^" .
        $cargoId . "^" .
        $projetoId;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function grava()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FERIADO_ACESSAR|FERIADO_GRAVAR");

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
    $funcionario = (int)$_POST['funcionario'];
    $matricula = (int)$_POST['matricula'];
    $cargo = (int)$_POST['cargo'];
    $projeto = (int) $_POST['projeto'];
    $sexo = (string) $_POST['sexo'];
    $dataNascimento = formatarData($_POST['dataNascimento']);
    $dataAdmissao = formatarData($_POST['dataAdmissao']);
    $dataUltimoAso = formatarData($_POST['dataUltimoAso']);
    $dataProximoAso = formatarData($_POST['dataProximoAso']);
    $dataAgendamento = formatarData($_POST['dataAgendamento']);
    $ativo =  $_POST['ativo'];

    $strArrayDataAso = $_POST['jsonDataAsoArray'];
    $arrayDataAso = $strArrayDataAso;
    if (!is_null($strArrayDataAso)) {
        $xmlDataAso = "";
        $nomeXml = "ArrayOfDataAso";
        $nomeTabela = "atestadoSaudeOcupacionalDetalhe";
        if (sizeof($arrayDataAso) > 0) {
            $xmlDataAso = '<?xml version="1.0"?>';
            $xmlDataAso = $xmlDataAso . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

            foreach ($arrayDataAso as $chave) {
                $xmlDataAso = $xmlDataAso . "<" . $nomeTabela . ">";
                foreach ($chave as $campo => $valor) {

                    if (($campo === "sequencialDataAso")) {
                        continue;
                    }

                    $xmlDataAso = $xmlDataAso . "<" . $campo . ">" . $valor . "</" . $campo . ">";
                }
                $xmlDataAso = $xmlDataAso . "</" . $nomeTabela . ">";
            }
            $xmlDataAso = $xmlDataAso . "</" . $nomeXml . ">";
        } else {
            $xmlDataAso = '<?xml version="1.0"?>';
            $xmlDataAso = $xmlDataAso . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
            $xmlDataAso = $xmlDataAso . "</" . $nomeXml . ">";
        }

        $xml = simplexml_load_string($xmlDataAso);

        if ($xml === false) {
            $mensagem = "Erro na criação do XML de Data ASO";
            echo "failed#" . $mensagem . ' ';
            return;
        }
        $xmlDataAso = "'" . $xmlDataAso . "'";
    } else {

        $xmlDataAso = "'" . '<?xml version="1.0"?>' . '<' . "ArrayOfDataAso" . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' . "</ArrayOfDataAso>" . "'";
    }



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
        .$xmlDataAso . "";

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
        $usuarioIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql =  "SELECT F.codigo, F.tipoFeriado , F.ativo, F.descricao,M.codigo as codigoMunicipio, M.descricao as municipio, F.unidadeFederacao, F.data FROM Ntl.feriado F
                LEFT JOIN Ntl.municipio M ON M.codigo = F.municipio  WHERE (0=0)";

    if ($condicaoId) {
        $sql = $sql . " AND F.codigo = " . $usuarioIdPesquisa . " ";
    }


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $feriado = $result[0];
    echo json_encode($feriado);
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

    $result = $reposit->update('Ntl.feriado' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}


function popularComboMunicipio()
{
    $id = filter_input(INPUT_POST, 'codigo');

    $reposit = new reposit();
    $sql = "SELECT codigo, descricao FROM Ntl.municipio WHERE (0=0) AND unidadeFederacao = '$id' AND ativo = 1";
    $result = $reposit->RunQuery($sql);
    $out = "";
    $contador = 0;

    foreach ($result as $row) {
        $id = $row['codigo'];
        $descricao = $row['descricao'];

        $out .=  $id . "^" . $descricao . "|";

        $contador = $contador + 1;
    }

    if ($out == "") {
        echo "failed#";
        return;
    }
    echo "sucess#" . $contador . "#" . $out;
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
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}
