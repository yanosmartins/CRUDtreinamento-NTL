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
if ($funcao == 'recuperaValeTransporteUnitario') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}
if ($funcao == 'verificaDescricao') {
    call_user_func($funcao);
}

return;
function grava()
{
    $reposit = new reposit(); //Abre a conexão. 

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("VALETRANSPORTEMODAL_ACESSAR|VALETRANSPORTEMODAL_GRAVAR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    //Atributos de dias úteis por município
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
    $usuario = formatarString($_SESSION['login']);  //Pegando o nome do usuário mantido pela sessão.
    $descricao = formatarString($_POST['descricao']);
    $valorTotal = formatarNumero($_POST['valorTotal']);

    //Início do Json
    $strValeTransporteModal = $_POST["jsonValeTransporteModal"];
    $arrayValeTransporteModal = json_decode($strValeTransporteModal, true);
    $xmlValeTransporteModal = "";
    $nomeXml = "ArrayOfValeTransporteModalDetalhe";
    $nomeTabela = "valeTransporteModalDetalhe";
    if (sizeof($arrayValeTransporteModal) > 0) {
        $xmlValeTransporteModal = '<?xml version="1.0"?>';
        $xmlValeTransporteModal = $xmlValeTransporteModal . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayValeTransporteModal as $chave) {
            $xmlValeTransporteModal = $xmlValeTransporteModal . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialValeTransporteModal")) {
                    continue;
                }
                if (($campo === "unidadeFederacao")) {
                    continue;
                }
                if (($campo === "descricaoValeTransporteModal")) {
                    continue;
                }
                $xmlValeTransporteModal = $xmlValeTransporteModal . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlValeTransporteModal = $xmlValeTransporteModal . "</" . $nomeTabela . ">";
        }
        $xmlValeTransporteModal = $xmlValeTransporteModal . "</" . $nomeXml . ">";
    } else {
        $xmlValeTransporteModal = '<?xml version="1.0"?>';
        $xmlValeTransporteModal = $xmlValeTransporteModal . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlValeTransporteModal = $xmlValeTransporteModal . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlValeTransporteModal);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de vale transporte modal";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlValeTransporteModal = "'" . $xmlValeTransporteModal . "'";
    //Fim do Json
    $sql = "Ntl.valeTransporteModal_Atualiza " . $id . "," . $ativo . "," . $descricao . "," . $valorTotal . "," . $usuario . "," . $xmlValeTransporteModal . " ";
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
        $valeTransporteModalIdPesquisa = $_POST["id"];
    }
    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }
    $sql = "SELECT * FROM Ntl.valeTransporteModal  VTM WHERE (0=0)";
    if ($condicaoId) {
        $sql = $sql . " AND VTM.codigo = " . $valeTransporteModalIdPesquisa . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";

    if($row = $result[0]) {
        $id = +$row['codigo'];
        $ativo = +$row['ativo'];
        $descricao = $row['descricao'];
        $valorTotal = $row['valorTotal'];

        $out = $id . "^" . $descricao . "^" . $ativo . "^" .  $valorTotal;

        // Recupera JSON de transporte modal
        $sqlValeTransporteModal = "SELECT VTMD.codigo, VTMD.valeTransporteModal, VTU.descricao, VTMD.valeTransporteUnitario, VTMD.valorUnitario
        FROM Ntl.valeTransporteModalDetalhe VTMD
        INNER JOIN Ntl.valeTransporteUnitario VTU ON VTU.codigo = VTMD.valeTransporteUnitario
        WHERE (0=0) AND VTMD.valeTransporteModal =" . $id;
        $repositValeTransporteModal = new reposit();
        $resultValeTransporteModal = $repositValeTransporteModal->RunQuery($sqlValeTransporteModal);
        $contadorValeTransporteModal = 0;
        $arrayValeTransporteModal = array();
        foreach ($resultValeTransporteModal as $row){

            $valeTransporteUnitarioId = $row['codigo'];
            $descricaoValeTransporteModal =  $row["descricao"];
            $valeTransporteUnitario = $row['valeTransporteUnitario'];
            $valorUnitario = $row["valorUnitario"];


            $contadorValeTransporteModal = $contadorValeTransporteModal + 1;
            $arrayValeTransporteModal[] = array(
                "valeTransporteUnitarioId" => $valeTransporteUnitarioId,
                "sequencialValeTransporteModal" => $contadorValeTransporteModal,
                "descricaoValeTransporteModal" => $descricaoValeTransporteModal,
                "valeTransporteUnitario" => $valeTransporteUnitario,
                "valorUnitario" => $valorUnitario,
            );
        }
        $strArrayValeTransporteModal = json_encode($arrayValeTransporteModal);

        if ($out == "") {
            echo "failed|";
        }
        if ($out != '') {
            echo "sucess#" . $out . "#" . $strArrayValeTransporteModal;
        }
        return;
    }
}

function recuperaValeTransporteUnitario()
{
    $id = $_POST['id'];

    $sql = "SELECT VTU.valorUnitario, VTU.unidadeFederacao FROM Ntl.valeTransporteUnitario VTU WHERE (0=0) AND VTU.codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";
    if($row = $result[0]) {
        $valorUnitario = $row['valorUnitario'];
        $unidadeFederacao = $row['unidadeFederacao'];
        $out = $valorUnitario . '^' . $unidadeFederacao;
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
    $possuiPermissao = $reposit->PossuiPermissao("VALETRANSPORTEMODAL_ACESSAR|VALETRANSPORTEMODAL_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um modal para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $result = $reposit->update('Ntl.valeTransporteModal' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function verificaDescricao()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CARGO_ACESSAR|CARGO_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $descricao = "'" . $_POST["descricao"] . "'";

    $sql = "SELECT * FROM Ntl.valeTransporteModal WHERE (0=0) AND descricao = " . $descricao;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $row = $result[0];
    if ($row == false) {
        echo ('sucess#');
        return;
    }
    echo 'failed#';
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
