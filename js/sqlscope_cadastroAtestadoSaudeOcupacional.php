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
        $dataNascimentoTeste = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimentoTeste);
        $idade = $difData->format('%y');
        $dataAdmissao = $row['dataAdmissao'];
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
        $idade . "^" .
        $dataAdmissaoFormatada . "^" .
        $cargoId . "^" .
        $projetoId;

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
    ASOD.situacao AS 'situacao' from funcionario.atestadoSaudeOcupacional ASO
    INNER JOIN funcionario.atestadoSaudeOcupacionalDetalhe ASOD ON ASO.codigo = ASOD.atestadoSaudeOcupacional
    INNER JOIN ntl.funcionario F ON ASO.funcionario = F.codigo
    INNER JOIN ntl.cargo C ON ASO.cargo = C.codigo
    INNER JOIN ntl.projeto P ON ASO.projeto = P.codigo
    WHERE C.ativo = 1 AND P.ativo = 1 AND F.codigo = $funcionario AND F.ativo = 1 AND ASO.ativo = 1";

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
        $dataNascimentoTeste = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimentoTeste);
        $idade = $difData->format('%y');
        $dataAdmissao = $row['dataAdmissao'];
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

    $reposit = "";
    $result = "";
    $sql = "SELECT ASOD.dataProximoAsoLista, ASOD.dataRealizacaoAso, ASOD.situacao FROM funcionario.atestadoSaudeOcupacionalDetalhe ASOD
INNER JOIN  funcionario.atestadoSaudeOcupacional ASO ON ASOD.atestadoSaudeOcupacional = ASO.codigo
WHERE ASO.funcionario = $funcionario";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorDataAso = 0;
    $arrayDataAso = array();
    foreach ($result as $row) {
        $dataProximoAsoLista = $row['dataProximoAsoLista'];
        $dataRealizacaoAso = (string)$row['dataRealizacaoAso'];
        $situacao = (string)$row['situacao'];

        $dataProximoAsoLista = explode("-", $dataProximoAsoLista);
        $diadataProximoAsoLista = explode(" ", $dataProximoAsoLista[2]);
        $dataProximoAsoLista = $diadataProximoAsoLista[0] . "/" . $dataProximoAsoLista[1] . "/" . $dataProximoAsoLista[0];

        $dataRealizacaoAso = explode("-", $dataRealizacaoAso);
        $diadataRealizacaoAso = explode(" ", $dataRealizacaoAso[2]);
        $dataRealizacaoAso = $diadataRealizacaoAso[0] . "/" . $dataRealizacaoAso[1] . "/" . $dataRealizacaoAso[0];

        $contadorDataAso = $contadorDataAso + 1;
        $arrayDataAso[] = array(
            "sequencialDataAso" => $contadorDataAso,
            "dataProximoAsoLista" => $dataProximoAsoLista,
            "dataRealizacaoAso" => $dataRealizacaoAso,
            "situacao" => $situacao
        );
    }

    $strArrayDataAso = json_encode($arrayDataAso);


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
        $projetoId . "^" .
        $dataUltimoAsoFormatada . "^" .
        $dataValidadeAsoFormatada . "^" .
        $dataAgendamentoFormatada;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayDataAso;
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


    $reposit = "";
    $result = "";
    $sql = "SELECT codigo FROM Funcionario.atestadoSaudeOcupacional WHERE funcionario = " . $funcionario;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if((empty($result))|| ($result < 1)) {
    } else {
        $row = $result[0];
        $codigoFolha = $row['codigo'];
       $id = $codigoFolha;
    };
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


                    if ($campo === "dataProximoAsoLista") {
                        if ($valor == "") {
                            $valor = 'NULL';
                            return $valor;
                        }
                        $valor = str_replace('/', '-', $valor);
                        $valor = date("Y-m-d", strtotime($valor));
                    }
                    if ($campo === "dataRealizacaoAso") {
                        if ($valor == "") {
                            $valor = 'NULL';
                            return $valor;
                        }
                        $valor = str_replace('/', '-', $valor);
                        $valor = date("Y-m-d", strtotime($valor));
                    }
                    if (($campo === "sequencialDataAso")) {
                        continue;
                    }
                    if (($campo === "descricaoTipoExame")) {
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
        . $xmlDataAso . "";

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


    // XML DATA ASO
    $reposit = "";
    $result = "";
    $sql = "SELECT ASOD.dataProximoAsoLista, ASOD.dataRealizacaoAso, ASOD.tipoExame,ASOD.situacao FROM funcionario.atestadoSaudeOcupacionalDetalhe ASOD
INNER JOIN  funcionario.atestadoSaudeOcupacional ASO ON ASOD.atestadoSaudeOcupacional = ASO.codigo
WHERE ASO.codigo = $id";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorDataAso = 0;
    $arrayDataAso = array();
    foreach ($result as $row) {
        $dataProximoAsoLista = $row['dataProximoAsoLista'];
        $dataRealizacaoAso = (string)$row['dataRealizacaoAso'];
        $situacao = (string)$row['situacao'];
        $tipoExame = (int) $row['tipoExame'];

        if ($dataProximoAsoLista != "") {
            $dataProximoAsoLista = formataDataRecuperacao($dataProximoAsoLista);
        };

        if ($dataRealizacaoAso != "") {
            $dataRealizacaoAso = formataDataRecuperacao($dataRealizacaoAso);
        };
        if ($tipoExame == 1) {
            $descricaoTipoExame = 'Exame Admissional';
        }
        if ($tipoExame == 2) {
            $descricaoTipoExame = 'Exame Periódico';
        }
        if ($tipoExame == 3) {
            $descricaoTipoExame = 'Mudança de Risco Ocupacional';
        }
        if ($tipoExame == 4) {
            $descricaoTipoExame = 'Retorno ao trabalho';
        }

        $contadorDataAso = $contadorDataAso + 1;
        $arrayDataAso[] = array(
            "sequencialDataAso" => $contadorDataAso,
            "dataProximoAsoLista" => $dataProximoAsoLista,
            "dataRealizacaoAso" => $dataRealizacaoAso,
            "descricaoTipoExame" => $tipoExame,
            "descricaoTipoExame" => $descricaoTipoExame,
            "situacao" => $situacao
        );
    }



    $strArrayDataAso = json_encode($arrayDataAso);



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

    echo "sucess#" . $out . "#" . $strArrayDataAso;
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
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}
