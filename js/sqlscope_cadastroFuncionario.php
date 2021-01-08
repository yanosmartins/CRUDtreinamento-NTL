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

if ($funcao == 'verificaCpf') {
    call_user_func($funcao);
}
if ($funcao == 'listaFuncionarioAtivoAutoComplete') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FUNCIONARIO_ACESSAR|FUNCIONARIO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.

    $id = $_POST['id'];
    $ativo = 1;
    $nome = formatarString($_POST['nome']);
    $sindicato = formatarNumero($_POST['sindicato']);
    $cargo = formatarNumero($_POST['cargo']);
    $cpf = formatarString($_POST['cpf']);
    $matricula = formatarString($_POST['matricula']);
    $sexo = formatarString($_POST['sexo']);

    $dataNascimento = formatarDATA($_POST['dataNascimento']);
    $dataAdmissaoFuncionario = formatarData($_POST['dataAdmissaoFuncionario']);
    $dataDemissaoFuncionario = formatarData($_POST['dataDemissaoFuncionario']);
    $dataCancelamentoPlanoSaude = formatarData($_POST['dataCancelamentoPlanoSaude']);

    // ACCORDION ─ DOCUMENTOS PESSOAIS:
    // CARTEIRA DE TRABALHO
    $pisPasep = formatarString($_POST['pisPasep']);
    $numeroCarteiraTrabalho = formatarString($_POST['numeroCarteiraTrabalho']);
    $serieCarteiraTrabalho = formatarString($_POST['serieCarteiraTrabalho']);
    $ufCarteiraTrabalho = formatarString($_POST['ufCarteiraTrabalho']);
    $dataExpedicaoCarteiraTrabalho = formatarData($_POST['dataExpedicaoCarteiraTrabalho']);

    //IDENTIDADE 
    $rg = formatarString($_POST['rg']);
    $dataEmissaoRG = formatarData($_POST['dataEmissaoRG']);
    $orgaoEmissorRG = formatarString($_POST['orgaoEmissorRG']);
    $ufIdentidade = formatarString($_POST['ufIdentidade']);

    //CARTEIRA NACIONAL DE HABILITAÇÃO (CNH)
    $cnh = formatarString($_POST['cnh']);
    $categoriaCNH = formatarString($_POST['categoriaCNH']);
    $ufCNH = formatarString($_POST['ufCNH']);
    $dataEmissaoCNH = formatarData($_POST['dataEmissaoCNH']);
    $dataVencimentoCNH = formatarData($_POST['dataVencimentoCNH']);
    $primeiraHabilitacaoCNH = formatarData($_POST['primeiraHabilitacaoCNH']);

    //ENDEREÇO
    $cep = formatarString($_POST['cep']);
    $logradouro = formatarString($_POST['logradouro']);
    $numeroLogradouro = formatarString($_POST['numeroLogradouro']);
    $complemento = formatarString($_POST['complemento']);
    $ufLogradouro = formatarString($_POST['ufLogradouro']);
    $cidade = formatarString($_POST['cidade']);
    $bairro = formatarString($_POST['bairro']);

    //------------------------Funcionário Telefone------------------
    $strArrayTelefone = $_POST['jsonTelefoneArray'];
    $arrayTelefone = json_decode($strArrayTelefone, true);
    $xmlTelefone = "";
    $nomeXml = "ArrayOfFuncionarioTelefone";
    $nomeTabela = "funcionarioTelefone";
    if (sizeof($arrayTelefone) > 0) {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTelefone as $chave) {
            $xmlTelefone = $xmlTelefone . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialTel")) {
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
    $arrayEmail = json_decode($strArrayEmail, true);
    $xmlEmail = "";
    $nomeXml = "ArrayOfFuncionarioEmail";
    $nomeTabela = "funcionarioEmail";
    if (sizeof($arrayEmail) > 0) {
        $xmlEmail = '<?xml version="1.0"?>';
        $xmlEmail = $xmlEmail . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayEmail as $chave) {
            $xmlEmail = $xmlEmail . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialEmail")) {
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

    //------------------------Funcionário  Dependente------------------
    $strArrayDependente = $_POST['jsonDependenteArray'];
    $arrayDependente = json_decode($strArrayDependente, true);
    $xmlDependente = "";
    $nomeXml = "ArrayOfFuncionarioDependente";
    $nomeTabela = "funcionarioDependente";
    if (sizeof($arrayDependente) > 0) {
        $xmlDependente = '<?xml version="1.0"?>';
        $xmlDependente = $xmlDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayDependente as $chave) {
            $xmlDependente = $xmlDependente . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialDependente")) {
                    continue;
                }
                if (($campo === "descricaoGrauParentesco")) {
                    continue;
                }
                if (($campo === "descricaoDataNascimentoDependente")) {
                    continue;
                }
                $xmlDependente = $xmlDependente . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlDependente = $xmlDependente . "</" . $nomeTabela . ">";
        }
        $xmlDependente = $xmlDependente . "</" . $nomeXml . ">";
    } else {
        $xmlDependente = '<?xml version="1.0"?>';
        $xmlDependente = $xmlDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlDependente = $xmlDependente . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlDependente);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Dependente";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlDependente = "'" . $xmlDependente . "'";

    // ',' .  $xmlDependente .

    $sql = "Ntl.funcionario_Atualiza (
                        $id,
                        $ativo,
                        $sindicato,
                        $cargo,
                        $nome,
                        $cpf,
                        $matricula,
                        $sexo,
                        $dataNascimento,
                        $dataAdmissaoFuncionario,
                        $dataDemissaoFuncionario,
                        $dataCancelamentoPlanoSaude,
                        $pisPasep,
                        $numeroCarteiraTrabalho,
                        $serieCarteiraTrabalho,
                        $ufCarteiraTrabalho,
                        $dataExpedicaoCarteiraTrabalho,
                        $rg,
                        $dataEmissaoRG,
                        $orgaoEmissorRG,
                        $cnh,
                        $categoriaCNH,
                        $ufCNH,
                        $dataEmissaoCNH,
                        $dataVencimentoCNH,
                        $primeiraHabilitacaoCNH,
                        $cep,
                        $logradouro,
                        $numeroLogradouro,
                        $complemento,
                        $ufLogradouro,
                        $cidade,
                        $bairro,
                        $ufIdentidade,
                        $xmlTelefone,
                        $xmlEmail,
                        $xmlDependente,
                        $usuario)";

    // $sql = 'Ntl.funcionario_Atualiza (';
    // $sql .= "$id,";
    // $sql .= "$ativo,";
    // $sql .= "$sindicato,";
    // $sql .= "$cargo,";
    // $sql .= "$nome,";
    // $sql .= "$cpf,";
    // $sql .= "$matricula,";
    // $sql .= "$sexo,";
    // $sql .= "$dataNascimento,";
    // $sql .= "$dataAdmissaoFuncionario,";
    // $sql .= "$dataDemissaoFuncionario,";
    // $sql .= "$dataCancelamentoPlanoSaude,";
    // $sql .= "$pisPasep,";
    // $sql .= "$numeroCarteiraTrabalho,";
    // $sql .= "$serieCarteiraTrabalho,";
    // $sql .= "$ufCarteiraTrabalho,";
    // $sql .= "$dataExpedicaoCarteiraTrabalho,";
    // $sql .= "$rg,";
    // $sql .= "$dataEmissaoRG,";
    // $sql .= "$orgaoEmissorRG,";
    // $sql .= "$cnh,";
    // $sql .= "$categoriaCNH,";
    // $sql .= "$ufCNH,";
    // $sql .= "$dataEmissaoCNH,";
    // $sql .= "$dataVencimentoCNH,";
    // $sql .= "$primeiraHabilitacaoCNH,";
    // $sql .= "$cep,";
    // $sql .= "$logradouro,";
    // $sql .= "$numeroLogradouro,";
    // $sql .= "$complemento,";
    // $sql .= "$ufLogradouro,";
    // $sql .= "$cidade,";
    // $sql .= "$bairro,";
    // $sql .= "$ufIdentidade,";
    // $sql .= "$xmlTelefone,";
    // $sql .= "$xmlEmail,";
    // $sql .= "$xmlDependente)";


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

    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT * FROM Ntl.funcionario WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if (($row = odbc_fetch_array($result))) {

        //Accordion Dados
        $id = +$row['codigo'];
        $ativo = +$row['ativo'];
        $sindicato = +$row['sindicato'];
        $cargo = +$row['cargo'];
        $nome = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');
        $cpf = mb_convert_encoding($row['cpf'], 'UTF-8', 'HTML-ENTITIES');
        $matricula = mb_convert_encoding($row['matricula'], 'UTF-8', 'HTML-ENTITIES');
        $sexo = mb_convert_encoding($row['sexo'], 'UTF-8', 'HTML-ENTITIES');
        $dataNascimento =  mb_convert_encoding($row['dataNascimento'], 'UTF-8', 'HTML-ENTITIES');
        $dataAdmissaoFuncionario =  mb_convert_encoding($row['dataAdmissaoFuncionario'], 'UTF-8', 'HTML-ENTITIES');
        $dataDemissaoFuncionario =  mb_convert_encoding($row['dataDemissaoFuncionario'], 'UTF-8', 'HTML-ENTITIES');
        $dataCancelamentoPlanoSaude =  mb_convert_encoding($row['dataCancelamentoPlanoSaude'], 'UTF-8', 'HTML-ENTITIES');


        //Accordion de Documentos Pessoais
        //Carteira de Trabalho
        $pisPasep = mb_convert_encoding($row['pisPasep'], 'UTF-8', 'HTML-ENTITIES');
        $numeroCarteiraTrabalho = mb_convert_encoding($row['numeroCarteiraTrabalho'], 'UTF-8', 'HTML-ENTITIES');
        $serieCarteiraTrabalho = mb_convert_encoding($row['serieCarteiraTrabalho'], 'UTF-8', 'HTML-ENTITIES');
        $ufCarteiraTrabalho = mb_convert_encoding($row['ufCarteiraTrabalho'], 'UTF-8', 'HTML-ENTITIES');
        $dataExpedicaoCarteiraTrabalho = mb_convert_encoding($row['dataExpedicaoCarteiraTrabalho'], 'UTF-8', 'HTML-ENTITIES');

        //Identidade 
        $rg = mb_convert_encoding($row['rg'], 'UTF-8', 'HTML-ENTITIES');
        $dataEmissaoRG = mb_convert_encoding($row['dataEmissaoRG'], 'UTF-8', 'HTML-ENTITIES');
        $ufIdentidade = mb_convert_encoding($row['ufIdentidade'], 'UTF-8', 'HTML-ENTITIES');
        $orgaoEmissorRG =  mb_convert_encoding($row['orgaoEmissorRG'], 'UTF-8', 'HTML-ENTITIES');

        //CNH
        $cnh = mb_convert_encoding($row['cnh'], 'UTF-8', 'HTML-ENTITIES');
        $categoriaCNH = mb_convert_encoding($row['categoriaCNH'], 'UTF-8', 'HTML-ENTITIES');
        $ufCNH = mb_convert_encoding($row['ufCNH'], 'UTF-8', 'HTML-ENTITIES');
        $dataEmissaoCNH = mb_convert_encoding($row['dataEmissaoCNH'], 'UTF-8', 'HTML-ENTITIES');
        $dataVencimentoCNH = mb_convert_encoding($row['dataVencimentoCNH'], 'UTF-8', 'HTML-ENTITIES');
        $primeiraHabilitacaoCNH = mb_convert_encoding($row['primeiraHabilitacaoCNH'], 'UTF-8', 'HTML-ENTITIES');

        //Accordion de Endereço
        $cep = mb_convert_encoding($row['cep'], 'UTF-8', 'HTML-ENTITIES');
        $logradouro = mb_convert_encoding($row['logradouro'], 'UTF-8', 'HTML-ENTITIES');
        $numeroLogradouro = mb_convert_encoding($row['numeroLogradouro'], 'UTF-8', 'HTML-ENTITIES');
        $complemento = mb_convert_encoding($row['complemento'], 'UTF-8', 'HTML-ENTITIES');
        $ufLogradouro = mb_convert_encoding($row['ufLogradouro'], 'UTF-8', 'HTML-ENTITIES');
        $cidade = mb_convert_encoding($row['cidade'], 'UTF-8', 'HTML-ENTITIES');
        $bairro = mb_convert_encoding($row['bairro'], 'UTF-8', 'HTML-ENTITIES');



        //Recupera datas formatadas:
        if ($dataNascimento != "") {
            $dataNascimentoFormatada = formataDataRecuperacao($dataNascimento);
        }

        if ($dataAdmissaoFuncionario != "") {
            $dataAdmissaoFuncionarioFormatada = formataDataRecuperacao($dataAdmissaoFuncionario);
        }

        if ($dataDemissaoFuncionario != "") {
            $dataDemissaoFuncionarioFormatada = formataDataRecuperacao($dataDemissaoFuncionario);
        }

        if ($dataCancelamentoPlanoSaude != "") {
            $dataCancelamentoPlanoSaudeFormatada = formataDataRecuperacao($dataCancelamentoPlanoSaude);
        }

        if ($dataExpedicaoCarteiraTrabalho != "") {
            $dataExpedicaoCarteiraTrabalhoFormatada = formataDataRecuperacao($dataExpedicaoCarteiraTrabalho);
        }

        if ($dataEmissaoRG != "") {
            $dataEmissaoRGFormatada = formataDataRecuperacao($dataEmissaoRG);
        }

        if ($dataEmissaoCNH != "") {
            $dataEmissaoCNHFormatada = formataDataRecuperacao($dataEmissaoCNH);
        }

        if ($dataVencimentoCNH != "") {
            $dataVencimentoCNHFormatada = formataDataRecuperacao($dataVencimentoCNH);
        }

        if ($primeiraHabilitacaoCNH != "") {
            $primeiraHabilitacaoCNHFormatada = formataDataRecuperacao($primeiraHabilitacaoCNH);
        }

        //----------------------Montando o array do Telefone

        $reposit = "";
        $result = "";
        $sql = "SELECT * FROM Ntl.funcionario F 
        INNER JOIN Ntl.funcionarioTelefone FT ON F.codigo = FT.funcionario WHERE F.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorTelefone = 0;
        $arrayTelefone = array();
        while ($row = odbc_fetch_array($result)) {
            $telefoneId = $row['codigo'];
            $telefone = $row['telefone'];
            $principal = +$row['principal'];
            $whatsapp = +$row['whatsapp'];

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
                "sequencialTel" => $contadorTelefone,
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

        $reposit = "";
        $result = "";
        $sql = "SELECT * FROM Ntl.funcionario F 
        INNER JOIN Ntl.funcionarioEmail FE ON F.codigo = FE.funcionario WHERE F.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorEmail = 0;
        $arrayEmail = array();
        while ($row = odbc_fetch_array($result)) {
            $emailId = $row['codigo'];
            $email = $row['email'];
            $principal = +$row['principal'];

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

        //----------------------Montando o array de Dependentes

        $reposit = "";
        $result = "";
        $sql = "SELECT *, GP.descricao as descricaoGrauParentesco FROM Ntl.funcionario F  
        INNER JOIN Ntl.funcionarioDependente FD ON F.codigo = FD.funcionario
        INNER JOIN Ntl.grauParentesco GP ON GP.codigo = FD.grauParentescoDependente
         WHERE F.codigo =" . $id;

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorDependente = 0;
        $arrayDependente = array();
        while ($row = odbc_fetch_array($result)) {
            $dependenteId = $row['codigo'];
            $nomeDependente = mb_convert_encoding($row['nomeDependente'], 'UTF-8', 'HTML-ENTITIES');
            $dataNascimentoDependente = $row['dataNascimentoDependente'];
            $grauParentescoDependente = $row['grauParentescoDependente'];
            $cpfDependente = mb_convert_encoding($row['cpfDependente'], 'UTF-8', 'HTML-ENTITIES');
            $rgDependente = mb_convert_encoding($row['rgDependente'], 'UTF-8', 'HTML-ENTITIES');
            $orgaoEmissorDependente = mb_convert_encoding($row['orgaoEmissorDependente'], 'UTF-8', 'HTML-ENTITIES');
            $descricaoDataNascimentoDependente = formataDataRecuperacao($dataNascimentoDependente);
            $descricaoGrauParentesco =  mb_convert_encoding($row['descricaoGrauParentesco'], 'UTF-8', 'HTML-ENTITIES');


            $contadorDependente = $contadorDependente + 1;
            $arrayDependente[] = array(
                "sequencialDependente" => $contadorDependente,
                "dependenteId" => $dependenteId,
                "nomeDependente" => $nomeDependente,
                "dataNascimentoDependente" => $dataNascimentoDependente,
                "grauParentescoDependente" => $grauParentescoDependente,
                "cpfDependente" => $cpfDependente,
                "rgDependente" => $rgDependente,
                "orgaoEmissorDependente" => $orgaoEmissorDependente,
                "descricaoDataNascimentoDependente" => $descricaoDataNascimentoDependente,
                "descricaoGrauParentesco" => $descricaoGrauParentesco
            );
        }


        $strArrayDependente = json_encode($arrayDependente);

        $out = $id . "^" .
            $ativo . "^" .
            $sindicato . "^" .
            $cargo . "^" .
            $nome . "^" .
            $cpf . "^" .
            $matricula . "^" .
            $sexo . "^" .
            $dataNascimentoFormatada . "^" .
            $dataAdmissaoFuncionarioFormatada . "^" .
            $dataDemissaoFuncionarioFormatada  . "^" .
            $dataCancelamentoPlanoSaudeFormatada . "^" .
            $pisPasep . "^" .
            $numeroCarteiraTrabalho . "^" .
            $serieCarteiraTrabalho . "^" .
            $ufCarteiraTrabalho . "^" .
            $dataExpedicaoCarteiraTrabalhoFormatada . "^" .
            $rg . "^" .
            $dataEmissaoRGFormatada . "^" .
            $orgaoEmissorRG . "^" .
            $cnh . "^" .
            $categoriaCNH . "^" .
            $ufCNH . "^" .
            $dataEmissaoCNHFormatada . "^" .
            $dataVencimentoCNHFormatada . "^" .
            $primeiraHabilitacaoCNHFormatada . "^" .
            $cep . "^" .
            $logradouro  . "^" .
            $numeroLogradouro  . "^" .
            $complemento  . "^" .
            $ufLogradouro  . "^" .
            $cidade  . "^" .
            $bairro . "^" .
            $ufIdentidade . "^" .
            $strArrayTelefone . "^" .
            $strArrayEmail;;



        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . "#" . $strArrayTelefone  . "#" . $strArrayEmail . "#" . $strArrayDependente;
        }
        return;
    }
}

function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FUNCIONARIO_ACESSAR|FUNCIONARIO_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um funcionário para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $result = $reposit->update('funcionario' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function listaFuncionarioAtivoAutoComplete()
{
    $condicaoDescricao = !((empty($_POST["descricaoIniciaCom"])) || (!isset($_POST["descricaoIniciaCom"])) || (is_null($_POST["descricaoIniciaCom"])));

    if ($condicaoDescricao === false) {
        return;
    }

    if ($condicaoDescricao) {
        $descricaoPesquisa = $_POST["descricaoIniciaCom"];
    }

    if ($condicaoDescricao == "") {
        $id = 0;
    }

    $reposit = new reposit();
    $sql = "SELECT * FROM Ntl.funcionario WHERE (0=0) AND ativo = 1 AND nome LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY nome";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    while (($row = odbc_fetch_array($result))) {
        $id = $row['codigo'];
        $descricao = mb_convert_encoding($row["nome"], 'UTF-8', 'HTML-ENTITIES');
        $contador = $contador + 1;
        $array[] = array("id" => $id, "nome" => $descricao);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}

function verificaCpf()
{
    $cpf = "'" . $_POST["val"] . "'";
    $sql = "SELECT cpf FROM Ntl.funcionario WHERE cpf = " . $cpf;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (odbc_fetch_array($result)) {
        echo "failed#";
        return;
    } else {
        echo 'sucess#';
    }
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
