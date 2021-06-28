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

if ($funcao == 'recuperarSolicitante') {
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
    LEFT JOIN ntl.fornecedorEmail FE ON FE.fornecedor = F.codigo 
    LEFT JOIN ntl.fornecedorTelefone FT ON FT.fornecedor = F.codigo WHERE cnpj =" . "'" . $cnpj . "'";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int) $row['codigo'];
        $codigoFornecedor = (int)$row['codigoFornecedor'];
        $reposit = "";
        $result = "";
        $sql = "SELECT c.codigo,c.fornecedor FROM ntl.clinica c
        INNER JOIN ntl.fornecedor f ON f.codigo = c.fornecedor  WHERE f.cnpj = " . "'" . $cnpj . "'";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        if ((empty($result)) || ($result < 1)) {
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
        } else {
            return;
        };
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

function recuperarSolicitante()
{

    $solicitante = (int)$_POST["solicitante"];
    SESSION_START();
    $logado = $_SESSION['funcionario'];

    if ($solicitante == 0) {

        $sql = "SELECT F.codigo, F.nome from ntl.funcionario F
        WHERE F.ativo = 1  AND F.codigo=" . $logado;
    
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
    
        $out = "";
        if ($row = $result[0]) {
            $codigo = (int) $row['codigo'];
            $solicitanteNome = $row['nome'];
        }
    } else {
        
        $sql = "SELECT F.codigo, F.nome from ntl.funcionario F
        WHERE F.ativo = 1 AND F.codigo" . $solicitante;
    
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
    
        $out = "";
        if ($row = $result[0]) {
            $codigo = (int) $row['codigo'];
            $solicitanteNome = $row['nome'];
        }
    }


    $out = $codigo . "^" .
        $solicitanteNome;

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
    $codigoClinica = (int)$clinica['id'];
    $codigoFornecedor = (int)$clinica['codigoFornecedor'];
    $observacao =  "'" . (string)$clinica['observacao']  . "'";
    $agendamentoData = $clinica['agendamentoData'];
    $agendamentoHorario =  $clinica['agendamentoHorario'];
    $quantidadeDia =  $clinica['quantidadeDia'];
    $quantidade = "'" . (string) $clinica['quantidade']  . "'";
    $agendamentoEmail =  $clinica['agendamentoEmail'];
    $emailDeAgendamento = "'" . (string) $clinica['emailDeAgendamento'] . "'";
    $modeloProprio = (int) $clinica['modeloProprio'];
    $solicitante = (int)$clinica['solicitante'];
    $ativo =  $clinica['ativo'];


    $sql = "Ntl.clinica_Atualiza
    $codigoClinica, 
    $codigoFornecedor,
    $observacao,
    $agendamentoData,
    $agendamentoHorario,
    $quantidadeDia,
    $quantidade,
    $agendamentoEmail,
    $emailDeAgendamento,
    $ativo,
    $usuario,
    $modeloProprio,
    $solicitante";

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

    $sql = "SELECT C.codigo AS 'codigoClinica',F.codigo AS 'codigoFornecedor', F.razaoSocial AS 'nome',F.apelido AS 'apelido',C.ativo AS 'ativo',F.uf AS 'uf', F.cnpj AS 'cnpj',F.cep,F.logradouro,F.endereco,F.numero,F.complemento,F.bairro,
    F.cidade,F.uf,C.observacao,C.agendamentoData,C.agendamentoHorario,C.quantidade,C.quantidadeDia,C.agendamentoEmail,C.emailDeAgendamento,C.modeloProprio,C.solicitante
    from ntl.clinica C INNER JOIN ntl.fornecedor F ON F.codigo = C.fornecedor 
	LEFT JOIN ntl.funcionario FC ON C.solicitante = FC.codigo
	WHERE (0=0)  AND C.codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigoClinica = (int) $row['codigoClinica'];
        $codigoFornecedor = (int) $row['codigoFornecedor'];
        $cnpj = $row['cnpj'];
        $nome = $row['nome'];
        $apelido = $row['apelido'];
        $cep = $row['cep'];
        $logradouro = $row['logradouro'];
        $endereco = $row['endereco'];
        $numero = $row['numero'];
        $complemento = $row['complemento'];
        $bairro = $row['bairro'];
        $cidade = $row['cidade'];
        $uf = $row['uf'];
        $observacao = $row['observacao'];
        $agendamentoData = $row['agendamentoData'];
        $agendamentoHorario = $row['agendamentoHorario'];
        $quantidadeDia = $row['quantidadeDia'];
        $quantidade = $row['quantidade'];
        $agendamentoEmail = $row['agendamentoEmail'];
        $emailDeAgendamento = $row['emailDeAgendamento'];
        $modeloProprio = $row['modeloProprio'];
        $solicitante = $row['solicitante'];
        $ativo = $row['ativo'];
    }
    $out = $codigoClinica . "^" .
        $codigoFornecedor . "^" .
        $cnpj . "^" .
        $nome . "^" .
        $apelido . "^" .
        $cep . "^" .
        $logradouro . "^" .
        $endereco . "^" .
        $numero . "^" .
        $complemento  . "^" .
        $bairro . "^" .
        $cidade . "^" .
        $uf . "^" .
        $observacao . "^" .
        $agendamentoData . "^" .
        $agendamentoHorario . "^" .
        $quantidadeDia . "^" .
        $quantidade . "^" .
        $agendamentoEmail . "^" .
        $emailDeAgendamento . "^" .
        $modeloProprio . "^" .
        $solicitante . "^" .
        $ativo;


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

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CLINICA_ACESSAR|CLINICA_EXCLUIR");

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

    $result = $reposit->update('ntl.clinica' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

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
