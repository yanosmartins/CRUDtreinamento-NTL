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

if ($funcao == 'contaFeriado') {
    call_user_func($funcao);
}

if ($funcao == 'populaComboFuncionario') {
    call_user_func($funcao);
}

return;

function grava()
{

    // Checa permissões
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("AFASTAMENTOFUNCIONARIO_ACESSAR|AFASTAMENTOFUNCIONARIO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    //Dados
    $id = (int) $_POST['id'];
    $ativo = 1;
    $funcionario = (int) $_POST['funcionario'];
    $mesAno = $_POST['mesAno'];
    $mesAnoAux = explode("/", $mesAno);
    $mesAno = "'" . $mesAnoAux[1] . "/" . $mesAnoAux[0] . "/" . "01'";
    $motivoAfastamento = (int) $_POST['motivoAfastamento'];
    $dataInicio = validaDataGrava($_POST['dataInicio']);
    $dataFim = validaDataGrava($_POST['dataFim']);
    $quantidadeDias = (int) $_POST['quantidadeDias'];
    $diaUtil = (int) $_POST['diaUtil'];
    $mesAnoInicio = $_POST['mesAnoInicio'];
    $mesAnoFim = $_POST['mesAnoFim'];
    $descontarVAVR = (int) $_POST['descontarVAVR'];
    $descontarTransporte = (int) $_POST['descontarTransporte'];
    $descontarCestaBasica = (int) $_POST['descontarCestaBasica'];
    $justificativa = "'" . $_POST['justificativa'] . "'";
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $diaFeriado = (int) $_POST['diaFeriado'];
    $projeto = (int) $_POST['projeto'];


    if ($mesAnoInicio != $mesAnoFim) {
        echo "failed#" . "Atualizações não podem ser feitas com Meses diferentes!";
        return;
    }

    $sql = 'Beneficio.afastamentoFuncionario_Atualiza ' .
        $id . ',' .
        $ativo . ',' .
        $funcionario . ',' .
        $mesAno . ',' .
        $motivoAfastamento . ',' .
        $dataInicio . ',' .
        $dataFim . ',' .
        $quantidadeDias . ',' .
        $diaUtil . ',' .
        $descontarVAVR . ',' .
        $descontarTransporte . ',' .
        $descontarCestaBasica . ',' .
        $justificativa . ',' .
        $usuario . ',' .
        $diaFeriado . ',' .
        $projeto . ' ';

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
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT * FROM Beneficio.afastamento WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if($row = $result[0]) {

        $codigo = +$row['codigo'];
        $ativo = +$row['ativo'];
        $funcionario = +$row['funcionario'];
        $mesAno = $row['mesAno'];
        $mesAno = explode("-", $mesAno);
        $mesAno = $mesAno[1] . "/" . $mesAno[0];
        $motivoAfastamento = +$row['motivoAfastamento'];
        $dataInicio = validaData($row['dataInicio']);
        $dataFim = validaData($row['dataFim']);
        $quantidadeDias = +$row['quantidadeDias'];
        $diaUtil = +$row['diaUtil'];
        $descontarVAVR = +$row['descontarVAVR'];
        $descontarTransporte = +$row['descontarTransporte'];
        $descontarCestaBasica = +$row['descontarCestaBasica'];
        $justificativa = $row['justificativa'];
        $diaFeriado = +$row['diaFeriado'];
        $projeto = +$row['projeto'];

        $out = $codigo . "^" .
            $ativo . "^" .
            $funcionario . "^" .
            $mesAno . "^" .
            $motivoAfastamento . "^" .
            $dataInicio . "^" .
            $dataFim . "^" .
            $quantidadeDias . "^" .
            $diaUtil . "^" .
            $descontarVAVR . "^" .
            $descontarTransporte . "^" .
            $descontarCestaBasica . "^" .
            $justificativa . "^" .
            $diaFeriado . "^" .
            $projeto;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out;
        }
        return;
    }
}

function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("AFASTAMENTOFUNCIONARIO_ACESSAR|AFASTAMENTOFUNCIONARIO_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um campo para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Beneficio.afastamento'.'|'.'ativo = 0' . '|'. 'codigo = '. $id); 
    //"UPDATE Beneficio.afastamento SET ativo = 0 WHERE codigo = $id"

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
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
    if (!$aux) {
        return 'NULL';
    }
    return $aux;
}


function validaString($value)
{
    $null = 'NULL';
    if ($value == '')
        return $null;
    return "'" . $value . "'";
}



function validaData($campo)
{
    $campo = explode("-", $campo);
    $campoAux = explode(" ", $campo[2]);
    $campo = $campoAux[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}
function validaDataGrava($campo)
{
    $campo = explode("/", $campo);
    $campo = $campo[2] . "/" . $campo[1] . "/" . $campo[0];
    return '\'' . $campo . '\'';
}

function validaNumero($value)
{
    return floatval($value);
}

function contaFeriado()
{
    $funcionario = validaNumero($_POST['funcionario']);
    $dataInicio = validaDataGrava($_POST['dataInicio']);
    $dataFim = validaDataGrava($_POST['dataFim']);
    $contadorFeriado = 0;

    $reposit = new reposit();

    $sqlProjeto = "SELECT BP.codigo,BP.funcionario,BP.projeto,P.apelido,P.estado,P.cidade,P.municipioFerias
    FROM Ntl.beneficioProjeto BP
    LEFT JOIN Ntl.projeto P ON P.codigo = BP.projeto WHERE BP.funcionario = $funcionario";

    $reposit = new reposit();
    $resultProjeto = $reposit->RunQuery($sqlProjeto);

    if($row = $resultProjeto[0]) {

        $estado = "'" . $row['estado'] . "'";
        $municipioFerias =  +$row['municipioFerias'];
    }
    $sql = "SELECT F.codigo,F.descricao,F.tipoFeriado,F.municipio,M.descricao,F.unidadeFederacao,F.data,F.sabado,F.domingo 
            FROM Ntl.feriado F 
            LEFT JOIN Ntl.municipio M ON M.codigo = F.municipio  
            WHERE F.ativo = 1 AND data BETWEEN $dataInicio AND $dataFim 
            AND (F.tipoFeriado = 3 OR (F.tipoFeriado = 1 and (F.unidadeFederacao = $estado)) OR F.tipoFeriado = 2 and M.codigo = $municipioFerias) 
            AND DATENAME(weekday,F.data) NOT IN ('Saturday', 'Sunday')";

    // $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    foreach($result as $row) {
        $feriadoNome = $row['descricao'];
        $contadorFeriado++;
    }
    $out = $contadorFeriado;
    if ($out != '' || $out == 0) {
        echo "sucess#" . $out;
    }
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
        foreach($result as $row) {
            $id = $row['funcionario'];
            $nomeFuncionario = $row['nome'];

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

// function temAfastamentoNasMesmasDatas($dataInicio,$dataFim) 
// {
//     $sql = "SELECT codigo,funcionario,dataInicio,dataFim,mesAno FROM Ntl.afastamento 
//     where (($dataInicio BETWEEN dataInicio AND dataFim) OR ($dataFim BETWEEN dataInicio AND dataFim)) AND funcionario = 13060" ;

//     $reposit = new reposit();
//     $result = $reposit->RunQuery($sql);

//     if ($result[0]) {
//         return true;
//     } else {
//         return false;
//     }
// }
