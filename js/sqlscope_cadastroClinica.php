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

if ($funcao == 'recuperarDadosCnpj') {
    call_user_func($funcao);
}

return;


function recuperarDadosCnpj()
{
    if ((empty($_POST["cnpj"])) || (!isset($_POST["cnpj"])) || (is_null($_POST["cnpj"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $cnpj = (string)$_POST["cnpj"];
    }

    $sql = "SELECT F.codigo AS 'codigoFornecedor',cnpj,razaoSocial,apelido,cep,logradouro,endereco,numero,complemento,bairro,cidade,uf,telefone,email from ntl.fornecedor F 
    INNER JOIN ntl.fornecedorEmail FE ON FE.fornecedor = F.codigo 
    INNER JOIN ntl.fornecedorTelefone FT ON FT.fornecedor = F.codigo WHERE cnpj =" . "'" . $cnpj . "'";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int) $row['codigo'];
        $codigoFornecedor = (int)$row['codigoFornecedor'];
        $razaoSocial = (string) $row['razaoSocial'];
        $apelido = (string) $row['apelido'];
        $cep = (string) $row['cep'];
        $logradouro = (string) $row['logradouro'];
        $endereco = (string) $row['endereco'];
        $numero = (int) $row['numero'];
        $complemento = (string) $row['complemento'];
        $bairro = (string) $row['bairro'];
        $cidade = (string) $row['cidade'];
        $uf = (string) $row['uf'];
    }

    $out = $codigo . "^" .
        $codigoFornecedor . "^" .
        $razaoSocial . "^" .
        $apelido . "^" .
        $cep . "^" .
        $logradouro . "^" .
        $endereco . "^" .
        $numero . "^" .
        $complemento . "^" .
        $bairro . "^" .
        $cidade . "^" .
        $uf;

    //----------------------Montando o array do Telefone

    $sql = "SELECT telefone,telefonePrincipal,telefoneWpp FROM Ntl.fornecedorTelefone FT
    INNER JOIN Ntl.fornecedor F ON F.codigo = FT.fornecedor 
    WHERE F.cnpj =" . "'" . $cnpj . "'";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $contadorTelefone = 0;
    $arrayTelefone = array();
    foreach ($result as $row) {

        $telefoneId = $row['codigo'];
        $telefone = $row['telefone'];
        $principal = +$row['telefonePrincipal'];
        $whatsapp = +$row['telefoneWpp'];

        if ($principal === 1) {
            $descricaoPrincipal = "Sim";
        } else {
            $descricaoPrincipal = "Não";
        }
        if ($whatsapp === 1) {
            $descricaoWhatsapp = "Sim";
        } else {
            $descricaoWhatsapp = "Não";
        }

        $contadorTelefone = $contadorTelefone + 1;
        $arrayTelefone[] = array(
            "sequencialTelefone" => $contadorTelefone,
            "telefoneId" => $telefoneId,
            "telefone" => $telefone,
            "whatsapp" => $whatsapp,
            "descricaoTelefoneWhatsApp" => $descricaoWhatsapp,
            "principal" => $principal,
            "descricaoTelefonePrincipal" => $descricaoPrincipal
        );
    }
    $strArrayTelefone = json_encode($arrayTelefone);

    //----------------------Montando o array do Email
    $sql = "SELECT email,emailPrincipal FROM Ntl.fornecedorEmail FE
    INNER JOIN Ntl.fornecedor F ON F.codigo = FE.fornecedor 
    WHERE F.cnpj =" . "'" . $cnpj . "'";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $contadorEmail = 0;
    $arrayEmail = array();
    foreach ($result as $row) {

        $emailId = $row['codigo'];
        $email = $row['email'];
        $principal = +$row['emailPrincipal'];

        if ($principal === 1) {
            $descricaoEmailPrincipal = "Sim";
        } else {
            $descricaoEmailPrincipal = "Não";
        }

        $contadorEmail = $contadorEmail + 1;
        $arrayEmail[] = array(
            "sequencialEmail" => $contadorEmail,
            "emailId" => $emailId,
            "email" => $email,
            "principal" => $principal,
            "descricaoEmailPrincipal" => $descricaoEmailPrincipal
        );
    }
    $strArrayEmail = json_encode($arrayEmail);

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayTelefone . "#" .  $strArrayEmail;
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
    $clinica = $_POST['clinica'];
    $codigoFornecedor = (int)$clinica['codigoFornecedor'];
    $observacao =  "'" . (string)$clinica['observacao']  . "'";
    $agendamentoData = $clinica['agendamentoData'];
    $agendamentoHorario =  $clinica['agendamentoHorario'];
    $quantidadeDia =  $clinica['quantidadeDia'];
    $quantidade = (string) $clinica['quantidade'];
    $agendamentoEmail =  $clinica['agendamentoEmail'];
    $emailDeAgendamento = "'" . (string) $clinica['emailDeAgendamento'] . "'";
    $ativo =  $clinica['ativo'];

    
    $sql = "Ntl.clinica_Atualiza
    $id, 
    $codigoFornecedor,
    $observacao,
    $agendamentoData,
    $agendamentoHorario,
    $quantidadeDia,
    $quantidade,
    $agendamentoEmail,
    $emailDeAgendamento,
    $ativo,
    $usuario";

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
