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

if ($funcao == 'listaComboMunicipio') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FORNECEDOR_ACESSAR|FORNECEDOR_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    //Variáveis
    session_start();
    $usuario = $_SESSION['login'];
    $id =  $_POST['id'];
    $cnpj = "'" . $_POST['cnpj'] . "'";
    $razaoSocial = $_POST['razaoSocial'];
    $apelido = $_POST['apelido'];
    $ativo = $_POST['ativo'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $notaFiscal = $_POST['notaFiscal'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $codigoCliente = "'" . $_POST['codigoCliente'] . "'";

    $strArrayTipoItem = $_POST['jsonTipoItemArray'];
    $arrayTipoItem = $strArrayTipoItem;
    if (!is_null($strArrayTipoItem)) {
        $xmlTipoItem = "";
        $nomeXml = "ArrayOfTipoItem";
        $nomeTabela = "fornecedorTipoItem";
        if (sizeof($arrayTipoItem) > 0) {
            $xmlTipoItem = '<?xml version="1.0"?>';
            $xmlTipoItem = $xmlTipoItem . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

            foreach ($arrayTipoItem as $chave) {
                $xmlTipoItem = $xmlTipoItem . "<" . $nomeTabela . ">";
                foreach ($chave as $campo => $valor) {

                    if (($campo === "sequencialTipoItem")) {
                        continue;
                    }


                    $xmlTipoItem = $xmlTipoItem . "<" . $campo . ">" . $valor . "</" . $campo . ">";
                }
                $xmlTipoItem = $xmlTipoItem . "</" . $nomeTabela . ">";
            }
            $xmlTipoItem = $xmlTipoItem . "</" . $nomeXml . ">";
        } else {
            $xmlTipoItem = '<?xml version="1.0"?>';
            $xmlTipoItem = $xmlTipoItem . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
            $xmlTipoItem = $xmlTipoItem . "</" . $nomeXml . ">";
        }

        $xml = simplexml_load_string($xmlTipoItem);

        if ($xml === false) {
            $mensagem = "Erro na criação do XML de Vale Transporte";
            echo "failed#" . $mensagem . ' ';
            return;
        }
        $xmlTipoItem = "'" . $xmlTipoItem . "'";
    } else {

        $xmlTipoItem = "'" . '<?xml version="1.0"?>' . '<' . "ArrayOfTipoItem" . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' . "</ArrayOfTipoItem>" . "'";
    }

    $strArrayTelefone = $_POST['jsonTelefoneArray'];
    $arrayTelefone = $strArrayTelefone;
    $xmlTelefone = "";
    $nomeXml = "ArrayOfFuncionarioTelefone";
    $nomeTabela = "fornecedorTelefone";
    if (sizeof($arrayTelefone) > 0) {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTelefone as $chave) {
            $xmlTelefone = $xmlTelefone . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialTel")) {
                    continue;
                }
                if (($campo === "telefoneId")) {
                    continue;
                }
                $xmlTelefone = $xmlTelefone . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlTelefone = $xmlTelefone . "</" . $nomeTabela . ">";
        }
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    } else {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlTelefone);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlTelefone = "'" . $xmlTelefone . "'";

    //------------------------- Funcionário Email---------------------
    $strArrayEmail = $_POST['jsonEmailArray'];
    $arrayEmail = $strArrayEmail;
    $xmlEmail = "";
    $nomeXml = "ArrayOfFuncionarioEmail";
    $nomeTabela = "fornecedorEmail";
    if (sizeof($arrayEmail) > 0) {
        $xmlEmail = '<?xml version="1.0"?>';
        $xmlEmail = $xmlEmail . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayEmail as $chave) {
            $xmlEmail = $xmlEmail . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialEmail")) {
                    continue;
                }
                if (($campo === "emailId")) {
                    continue;
                }
                $xmlEmail = $xmlEmail . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlEmail = $xmlEmail . "</" . $nomeTabela . ">";
        }
        $xmlEmail = $xmlEmail . "</" . $nomeXml . ">";
    } else {
        $xmlEmail = '<?xml version="1.0"?>';
        $xmlEmail = $xmlEmail . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlEmail = $xmlEmail . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlEmail);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlEmail = "'" . $xmlEmail . "'";

    $ativo = 1;

    $sql = "Ntl.fornecedor_Atualiza " .
        $id . "," .
        $cnpj . "," .
        "'" . $razaoSocial . "'" . "," .
        "'" . $apelido . "'"  . "," .
        $ativo . "," .
        "'" . $logradouro . "'"  . "," .
        $numero  . "," .
        "'" . $complemento . "'"  . "," .
        "'" . $bairro . "'"  . "," .
        "'" . $cidade . "'"  . "," .
        "'" . $uf . "'" . "," .
        $notaFiscal . "," .
        "'" .   $cep . "'" . "," .
        "'" .   $endereco . "'"  . "," .
        "'" .   $usuario . "'"  . "," .
        $codigoCliente . "," .
        $xmlTipoItem . "," .
        $xmlTelefone . "," .
        $xmlEmail;
       
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
        $fornecedorIdPesquisa = $_POST["id"];
    }

    if ($condicaoLogin) {
        $loginPesquisa = $_POST["loginPesquisa"];
    }

    $sql = "SELECT FO.[codigo], FO.[cnpj], FO.[razaoSocial], FO.[apelido], FO.[ativo], FO.[cep],FO.[logradouro], FO.[numero], FO.[complemento], FO.[bairro], FO.[cidade], FO.[uf], FO.[notaFiscal],
                   FO.[endereco],FO.[codigoCliente]
                    FROM Ntl.fornecedor FO
                    WHERE (0=0)";

    if ($condicaoId) {
        $sql = $sql . " AND FO.[codigo] = " . $fornecedorIdPesquisa . " ";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $cnpj = $row['cnpj'];
        $razaoSocial = $row['razaoSocial'];
        $apelido = $row['apelido'];
        $ativo = $row['ativo'];
        $logradouro = $row['logradouro'];
        $numero = $row['numero'];
        $complemento =  $row['complemento'];
        $bairro = $row['bairro'];
        $cidade = $row['cidade'];
        $uf =  $row['uf'];
        $notaFiscal = $row['notaFiscal'];
        $cep =  $row['cep'];
        $endereco =  $row['endereco'];
        $codigoCliente =  $row['codigoCliente'];

        // ARRAY TIPO ITEM // 
        $reposit = "";
        $result = "";
        $sql = "SELECT  F.codigo,FTI.codigo,FTI.tipoItem,FTI.fabricante,FTI.observacao,FA.codigo,FA.descricao AS fabricanteText,TI.codigo,TI.descricao AS tipoItemText FROM ntl.fornecedor F
        INNER JOIN ntl.fornecedorTipoItem FTI ON F.codigo = FTI.fornecedor 
        INNER JOIN estoque.fabricante FA ON FTI.fabricante = FA.codigo
		INNER JOIN estoque.tipoItem TI ON FTI.tipoItem = TI.codigo
        WHERE F.codigo = $id";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorTipoItem = 0;
        $arrayTipoItem = array();
        foreach ($result as $row) {
            $fabricante = (string)$row['fabricanteText'];
            $tipoItem = (string)$row['tipoItemText'];
            $observacao = (string)$row['observacao'];
            $fabricanteId = (int) $row['fabricante'];
            $tipoItemId = (int) $row['tipoItem'];

            $contadorTipoItem = $contadorTipoItem + 1;
            $arrayTipoItem[] = array(
                "sequencialTipoItem" => $contadorTipoItem,
                "fabricanteText" => $fabricante,
                "tipoItemText" => $tipoItem,
                "observacao" => $observacao,
                "fabricante" => $fabricanteId,
                "tipoItem" => $tipoItemId
            );
        }

        $strArrayTipoItem = json_encode($arrayTipoItem);

        // ARRAY TELEFONE // 
        $reposit = "";
        $result = "";
        $sql = "SELECT FT.fornecedor,FT.telefone,FT.telefonePrincipal,FT.telefoneWpp,F.codigo
    FROM ntl.fornecedorTelefone FT INNER JOIN ntl.fornecedor F ON F.codigo = FT.fornecedor
    WHERE F.codigo = $id";

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorTelefone = 0;
        $arrayTelefone = array();
        foreach ($result as $row) {
            $telefonePrincipalText = (string)$row['descricaoTelefonePrincipal'];
            $telefoneWppText = (string)$row['descricaoTelefoneWhatsApp'];
            $telefone = (string)$row['telefone'];
            $telefonePrincipal = (int)$row['telefonePrincipal'];
            $telefoneWpp = (int)$row['telefoneWpp'];

            if ($telefoneWpp == 1) {
                $telefoneWppText = "Sim";
            } else {
                $telefoneWppText = "Não";
            }
            if ($telefonePrincipal == 1) {
                $telefonePrincipalText = "Sim";
            } else {
                $telefonePrincipalText = "Não";
            }
            
            $contadorTelefone = $contadorTelefone + 1;
            $arrayTelefone[] = array(
                "sequencialTel" => $contadorTelefone,
                "descricaoTelefonePrincipal" => $telefonePrincipalText,
                "descricaoTelefoneWhatsApp" => $telefoneWppText,
                "telefone" => $telefone,
                "telefonePrincipal" => $telefonePrincipal,
                "telefoneWpp" => $telefoneWpp
            );
        }
   
        $strArrayTelefone = json_encode($arrayTelefone);


        // ARRAY EMAIL //

        $reposit = "";
        $result = "";
        $sql = "SELECT FE.fornecedor,FE.email,FE.emailPrincipal,F.codigo
    FROM ntl.fornecedorEmail FE INNER JOIN ntl.fornecedor F ON F.codigo = FE.fornecedor
    WHERE F.codigo = $id";

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorEmail = 0;
        $arrayEmail = array();
        foreach ($result as $row) {
            $emailPrincipalText = (string)$row['descricaoEmailPrincipal'];
            $email = (string)$row['email'];
            $emailPrincipal = (string)$row['emailPrincipal'];

            
        if ($emailPrincipal == 1) {
            $emailPrincipalText = "Sim";
        } else {
            $emailPrincipalText = "Não";
        }

            $contadorEmail = $contadorEmail + 1;
            $arrayEmail[] = array(
                "descricaoEmailPrincipal" => $emailPrincipalText,
                "sequencialEmail" => $contadorEmail,
                "email" => $email,
                "emailPrincipal" => $emailPrincipal
            );
        }
        $strArrayEmail = json_encode($arrayEmail);

        $out = $id . "^" .
            $cnpj . "^" .
            $razaoSocial . "^" .
            $apelido  . "^" .
            $ativo . "^" .
            $logradouro . "^" .
            $numero . "^" .
            $complemento  . "^" .
            $bairro . "^" .
            $cidade . "^" .
            $uf . "^" .
            $notaFiscal . "^" .
            $cep . "^" .
            $endereco ."^".
            $codigoCliente;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . "#" . $strArrayTipoItem . "#" . $strArrayTelefone . "#" . $strArrayEmail;
        }

        return;
    }
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FORNECEDOR_ACESSAR|FORNECEDOR_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um fornecedor.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $result = $reposit->update('Ntl.fornecedor' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function listaComboMunicipio()
{

    $id = $_POST["codigo"];

    if ($id != "") {
        $sql = "SELECT * FROM Ntl.municipio WHERE (0 =0) AND  unidadeFederacao = '" . $id . "' AND ativo = 1";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $contador = 0;

    foreach ($result as $row) {
        $id = $row['codigo'];
        $municipio = $row['descricao'];

        $out = $out . $id . "^" . $municipio . "|";
        $contador = $contador + 1;
    }
    if ($out == "") {
        echo "failed#0 ";
    }
    if ($out != '') {
        echo "sucess#" . $contador . "#" . $out;
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
