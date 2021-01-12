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

return;

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
        $id = +$_POST["id"];
    }

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = +$_POST["ativo"];
    }

    //Variáveis que estão sendo passadas.
    session_start();
    $usuario = formatarString($_SESSION['login']);  //Pegando o nome do usuário mantido pela sessão.
    $descricao = formatarString($_POST['descricao']);
    $data = formatarData($_POST['data']);
    $tipoFeriado = formatarNumero(+$_POST['tipoFeriado']);
    $unidadeFederacao = formatarString($_POST['unidadeFederacao']);
    $municipio = formatarNumero(+$_POST['municipio']);
    $diaDaSemana = $_POST['diaDaSemana'];

    if ($diaDaSemana == "Sunday") {
        $domingo = 1;
    } else {
        $domingo = 0;
    }

    if ($diaDaSemana == "Saturday") {
        $sabado = 1;
    } else {
        $sabado = 0;
    }

    $sql = "Ntl.feriado_Atualiza (" . $id . "," . $ativo . "," . $descricao . "," .
        $data . "," . $tipoFeriado . "," . $unidadeFederacao . "," . $municipio . "," .
        $usuario . "," . $domingo . "," . $sabado . ")";

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

    $feriado = odbc_fetch_array($result);
    $feriado = array_map('utf8_encode', $feriado);
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

    while (($row = odbc_fetch_array($result))) {
        $id = $row['codigo'];
        $descricao = mb_convert_encoding($row['descricao'], 'UTF-8', 'HTML-ENTITIES');

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
    if (($row = odbc_fetch_array($result))) {
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
