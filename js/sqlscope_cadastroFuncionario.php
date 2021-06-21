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
    $clinica = formatarNumero($_POST['clinica']);
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

    //------------------------Funcionário  Especializacao------------------
    $strArrayEspecializacao = $_POST['jsonEspecializacaoArray'];
    $arrayEspecializacao = json_decode($strArrayEspecializacao, true);
    $xmlEspecializacao = "";
    $nomeXml = "ArrayOfFuncionarioEspecializacao";
    $nomeTabela = "funcionarioEspecializacao";
    if (sizeof($arrayEspecializacao) > 0) {
        $xmlEspecializacao = '<?xml version="1.0"?>';
        $xmlEspecializacao = $xmlEspecializacao . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayEspecializacao as $chave) {
            $xmlEspecializacao = $xmlEspecializacao . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialEspecializacao")) {
                    continue;
                }
                if ($campo == "observacao") {
                    $xmlEspecializacao = $xmlEspecializacao . "<" . $campo . '>"' .$valor. '"</' . $campo . ">";
                } else {
                    $xmlEspecializacao = $xmlEspecializacao . "<" . $campo . ">" . $valor . "</" . $campo . ">";
                }
            }
            $xmlEspecializacao = $xmlEspecializacao . "</" . $nomeTabela . ">";
        }
        $xmlEspecializacao = $xmlEspecializacao . "</" . $nomeXml . ">";
    } else {
        $xmlEspecializacao = '<?xml version="1.0"?>';
        $xmlEspecializacao = $xmlEspecializacao . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlEspecializacao = $xmlEspecializacao . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlEspecializacao);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlEspecializacao = "'" . $xmlEspecializacao . "'";





    $sql = "Ntl.funcionario_Atualiza 
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
                        $xmlEspecializacao,
                        $usuario,
                        $clinica";

    // $sql = 'Ntl.funcionario_Atualiza ';
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
    // $sql .= "$xmlDependente";


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
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT * FROM Ntl.funcionario WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        //Accordion Dados
        $id = +$row['codigo'];
        $ativo = +$row['ativo'];
        $sindicato = +$row['sindicato'];
        $cargo = +$row['cargo'];
        $nome = $row['nome'];
        $cpf = $row['cpf'];
        $matricula = $row['matricula'];
        $clinica = $row['clinica'];
        $sexo = $row['sexo'];
        $dataNascimento =  $row['dataNascimento'];
        $dataAdmissaoFuncionario =  $row['dataAdmissaoFuncionario'];
        $dataDemissaoFuncionario =  $row['dataDemissaoFuncionario'];
        $dataCancelamentoPlanoSaude =  $row['dataCancelamentoPlanoSaude'];


        //Accordion de Documentos Pessoais
        //Carteira de Trabalho
        $pisPasep = $row['pisPasep'];
        $numeroCarteiraTrabalho = $row['numeroCarteiraTrabalho'];
        $serieCarteiraTrabalho = $row['serieCarteiraTrabalho'];
        $ufCarteiraTrabalho = $row['ufCarteiraTrabalho'];
        $dataExpedicaoCarteiraTrabalho = $row['dataExpedicaoCarteiraTrabalho'];

        //Identidade 
        $rg = $row['rg'];
        $dataEmissaoRG = $row['dataEmissaoRG'];
        $ufIdentidade = $row['ufIdentidade'];
        $orgaoEmissorRG =  $row['orgaoEmissorRG'];

        //CNH
        $cnh = $row['cnh'];
        $categoriaCNH = $row['categoriaCNH'];
        $ufCNH = $row['ufCNH'];
        $dataEmissaoCNH = $row['dataEmissaoCNH'];
        $dataVencimentoCNH = $row['dataVencimentoCNH'];
        $primeiraHabilitacaoCNH = $row['primeiraHabilitacaoCNH'];

        //Accordion de Endereço
        $cep = $row['cep'];
        $logradouro = $row['logradouro'];
        $numeroLogradouro = $row['numeroLogradouro'];
        $complemento = $row['complemento'];
        $ufLogradouro = $row['ufLogradouro'];
        $cidade = $row['cidade'];
        $bairro = $row['bairro'];



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
        foreach ($result as $row) {
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
        foreach ($result as $row) {
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
        foreach ($result as $row) {
            $dependenteId = $row['codigo'];
            $nomeDependente = $row['nomeDependente'];
            $dataNascimentoDependente = $row['dataNascimentoDependente'];
            $grauParentescoDependente = $row['grauParentescoDependente'];
            $cpfDependente = $row['cpfDependente'];
            $rgDependente = $row['rgDependente'];
            $orgaoEmissorDependente = $row['orgaoEmissorDependente'];
            $descricaoDataNascimentoDependente = formataDataRecuperacao($dataNascimentoDependente);
            $descricaoGrauParentesco =  $row['descricaoGrauParentesco'];


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


        //----------------------Montando o array do Especializacao

        $reposit = "";
        $result = "";
        $sql = "SELECT *,E.descricao, FE.observacao FROM Ntl.funcionario F 
        INNER JOIN Ntl.funcionarioEspecializacao FE ON F.codigo = FE.funcionario
        INNER JOIN Ntl.especializacao E ON FE.especializacao = E.codigo WHERE F.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorEspecializacao = 0;
        $arrayEspecializacao = array();
        foreach ($result as $row) {
            $especializacao = $row['codigo'];
            $especializacaoDescricao = $row['descricao'];
            $observacao = $row['observacao'];

            $contadorEspecializacao = $contadorEspecializacao + 1;
            $arrayEspecializacao[] = array(
                "sequencialEspecializacao" => $contadorEspecializacao,
                "especializacao" => $especializacao,
                "especializacaoDescricao" => $especializacaoDescricao,
                "observacao" => $observacao

            );
        }

        $strArrayEspecializacao = json_encode($arrayEspecializacao);


        $out = $id . "^" .
            $ativo . "^" .
            $sindicato . "^" .
            $cargo . "^" .
            $nome . "^" .
            $cpf . "^" .
            $matricula . "^" .
            $clinica ."^" .
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
            $strArrayEmail;



        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out . "#" . $strArrayTelefone  . "#" . $strArrayEmail . "#" . $strArrayDependente . "#" . $strArrayEspecializacao;
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
    $result = $reposit->update('Ntl.funcionario' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

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
    foreach ($result as $row) {
        $id = $row['codigo'];
        $descricao = $row["nome"];
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

    if ($result[0]) {
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
