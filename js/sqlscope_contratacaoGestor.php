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

if ($funcao == 'recuperaCbo') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaValores') {
    call_user_func($funcao);
}
if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaUpload') {
    call_user_func($funcao);
}


return;

function grava()
{

    $reposit = new reposit(); //Abre a conexão.   
    session_start();
    $usuario = validaString($_SESSION['login']);
    $codigo =  validaCodigo($_POST['codigo'] ?: 0);
    $candidato = validaString($_POST['funcionario']);

    if ($candidato != "") {

        $sql = "SELECT codigo FROM Contratacao.candidato WHERE (0=0) AND nomeCompleto = " . $candidato;

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        if($row = $result[0])

        $candidato = validaNumero($row['codigo']);
    }

    $tipoContrato = validaNumero($_POST['tipoContrato']);
    $dataAdmissao = validaData($_POST['dataAdmissao']);
    $projeto = validaNumero($_POST['projeto']);
    $cargo = validaNumero($_POST['cargo']);
    $cbo = validaString($_POST['cbo']);
    $experiencia = validaNumero($_POST['experiencia']);
    $sindicato = validaNumero($_POST['sindicato']);
    $salarioBase = tofloat(validaNumero($_POST['salarioBase']));
    $tipoEscala = validaNumero($_POST['tipoEscala']);
    $dataInicioRevezamento = validaData($_POST['dataInicioRevezamento']);
    $tipoRevezamento = validaNumero($_POST['tipoRevezamento']);
    $escalaHorario = validaNumero($_POST['escalaHorario']);
    $verificadoPeloGestor =  trim($_POST['verificadoPeloGestor']); //Sinaliza se o Gestor preencheu ou não todos os campos respectivos á ele.
    $prazoDeterminado = validaNumero($_POST['prazoDeterminado']);
    $dataFinal = validaData($_POST['dataFinal']);
    $ativo = 1;

    // if ($verificadoPeloGestor == 'Sim') { //Desabilitei pois a logica não fez sentido algum e está prejudicando o andamento da tela 19/06/2020
    //     $verificadoPeloGestor = 1;
    // } else {
    //     $verificadoPeloGestor = 0;
    // }
    $verificadoPeloGestor = 1; // se ele gravou é por que preencheu todos os campos. sem necessidar da validacao acima

    $sql = "Contratacao.controleGestor_Atualiza 
        $codigo,
        $candidato,
        $tipoContrato,
        $dataAdmissao,
        $projeto,
        $cargo,
        $cbo,
        $experiencia,
        $sindicato, 
        $salarioBase,
        $tipoEscala,
        $dataInicioRevezamento,
        $tipoRevezamento,
        $escalaHorario,  
        $verificadoPeloGestor, 
        $prazoDeterminado, 
        $usuario,
        $dataFinal, 
        $ativo
        ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success';
    if ($result < 1) {
        $ret = 'failed';
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

    $sql = " SELECT F.codigo as codigoCandidato,CF.codigo, F.nomeCompleto as nomeCandidato, 
    F.dataNascimento, F.estadoCivil,F.telefoneResidencial,F.telefoneCelular,F.outroTelefone,F.email,F.cep,
	F.endereco,F.bairro,F.numero,F.complemento,F.estado,F.cidade,
	F.cpf,F.pis,F.carteiraTrabalho,F.carteiraTrabalhoSerie,F.dataExpedicaoCarteiraTrabalho,F.localCarteiraTrabalho,F.rg,F.emissorRg,F.localRg,F.dataEmissaoRg,
	F.cnh,F.categoriaCnh,F.ufCnh,F.dataEmissaoCnh,F.dataVencimentoCnh,F.primeiraCnh,F.tituloEleitor,F.zonaTituloEleitor,F.secaoTituloEleitor,F.certificadoReservista,
	F.grauInstrucao,F.atividadesExtracurriculares,F.nomeConjuge,F.dataNascimentoConjuge,
	F.trabalhaAtualmente,F.seguroDesemprego,F.desejaAssistenciaMedica,F.desejaAssistenciaOdontologica,F.valeRefeicaoValeAlimentacao,F.desejaVt,F.possuiVt,
	F.numeroCartaoVt,F.agenciaBanco,F.digitoAgenciaBanco,F.contaCorrente,F.digitoContaBanco,F.fk_banco,F.variacao,F.tipoConta,F.numeroCamisa,F.numeroCalca,F.numeroSaia,F.numeroSapato,
	CF.codigo, CF.tipoContrato, CF.dataAdmissao, 
    CF.projeto, CF.cargo, CF.cbo, CF.experiencia, CF.sindicato,
    CF.salarioBase, CF.tipoEscala, CF.dataInicioRevezamento,  CF.dataFinal,
    CF.tipoRevezamento, CF.escalaHorario, CF.verificadoPeloGestor AS verificado, CF.prazoDeterminado from Contratacao.controleCandidato CF
  INNER JOIN Contratacao.candidato F ON F.codigo = CF.candidato WHERE (0=0) AND CF.codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";
    if($row = $result[0])

    $codigoCandidato = $row['codigoCandidato']; //id Candidato na tabela Candidato
    $codigo = (int)$row['codigo']; // id na tabela controle Candidato cadastro
    $nomeCompleto = (string)$row['nomeCandidato'];
    $tipoContrato = $row['tipoContrato'];
    $dataAdmissao = validaDataRecupera($row['dataAdmissao']);
    $projeto = $row['projeto'];
    $cargo = $row['cargo'];
    $cbo = $row['cbo'];
    $experiencia = $row['experiencia'];
    $sindicato = $row['sindicato'];
    $salarioBase = $row['salarioBase'];
    $tipoEscala = $row['tipoEscala'];
    $dataInicioRevezamento = validaDataRecupera($row['dataInicioRevezamento']);
    $tipoRevezamento = $row['tipoRevezamento'];
    $escalaHorario = $row['escalaHorario'];
    $verificado = $row['verificado'];
    $dataNascimento = validaDataRecupera($row['dataNascimento']);
    $estadoCivil = $row['estadoCivil'];
    $telefoneResidencial = $row['telefoneResidencial'];
    $telefoneCelular = $row['telefoneCelular'];
    $outroTelefone = $row['outroTelefone'];
    $email = $row['email'];
    $cep = (string)$row['cep'];
    $endereco = (string)$row['endereco'];
    $bairro = (string)$row['bairro'];
    $numero = (string)$row['numero'];
    $complemento = (string)$row['complemento'];
    $estado = (string)$row['estado'];
    $cidade = (string)$row['cidade'];
    $cpf = (string)$row['cpf'];
    $pis = $row['pis'];
    $carteiraTrabalho = $row['carteiraTrabalho'];
    $carteiraTrabalhoSerie = $row['carteiraTrabalhoSerie'];
    $dataExpedicaoCarteiraTrabalho = validaDataRecupera($row['dataExpedicaoCarteiraTrabalho']);
    $localCarteiraTrabalho = $row['localCarteiraTrabalho'];
    $rg = $row['rg'];
    $emissorRg = $row['emissorRg'];
    $localRg = $row['localRg'];
    $dataEmissaoRg = validaDataRecupera($row['dataEmissaoRg']);

    $cnh = $row['cnh'];
    $categoriaCnh = $row['categoriaCnh'];
    $ufCnh = $row['ufCnh'];
    $dataEmissaoCnh = validaDataRecupera($row['dataEmissaoCnh']);
    $dataVencimentoCnh = validaDataRecupera($row['dataVencimentoCnh']);
    $primeiraCnh = validaDataRecupera($row['primeiraCnh']);
    $tituloEleitor = $row['tituloEleitor'];
    $zonaTituloEleitor = $row['zonaTituloEleitor'];
    $secaoTituloEleitor = $row['secaoTituloEleitor'];
    $certificadoReservista = $row['certificadoReservista'];
    $grauInstrucao = $row['grauInstrucao'];
    $atividadesExtracurriculares = $row['atividadesExtracurriculares'];
    $nomeConjuge = $row['nomeConjuge'];
    $dataNascimentoConjuge = validaDataRecupera($row['dataNascimentoConjuge']);
    $trabalhaAtualmente = $row['trabalhaAtualmente'];
    $seguroDesemprego = (int)$row['seguroDesemprego'];
    $desejaAssistenciaMedica = $row['desejaAssistenciaMedica'];
    $desejaAssistenciaOdontologica = $row['desejaAssistenciaOdontologica'];
    $valeRefeicaoValeAlimentacao = (int)$row['valeRefeicaoValeAlimentacao'];
    $desejaVt = $row['desejaVt'];
    $possuiVt = $row['possuiVt'];
    $numeroCartaoVt = $row['numeroCartaoVt'];
    $agenciaBanco = $row['agenciaBanco'];
    $digitoAgenciaBanco = $row['digitoAgenciaBanco'];
    $contaCorrente = $row['contaCorrente'];
    $digitoContaBanco = $row['digitoContaBanco'];
    $fk_banco = $row['fk_banco'];
    $variacao = $row['variacao'];
    $tipoConta = (int)$row['tipoConta'];

    $numeroCamisa = $row['numeroCamisa'];
    $numeroCalca = $row['numeroCalca'];
    $numeroSaia = $row['numeroSaia'];
    $numeroSapato = $row['numeroSapato'];
    $prazoDeterminado = $row['prazoDeterminado'];
    $dataFinal = validaDataRecupera($row['dataFinal']);


    // //----------------------Montando o array do Filho

    $reposit = "";
    $result = "";
    $sql = "SELECT FI.codigo, FI.candidato, FI.nomeCompleto, FI.cpf, FI.dataNascimento FROM Contratacao.candidatoFilho FI 
    INNER JOIN Contratacao.candidato F ON F.codigo = FI.candidato WHERE (0=0) AND F.codigo = " . $codigoCandidato;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorFilho = 0;
    $arrayFilho = array();
    foreach($result as $row) {

        $nomeCompletoFilho = $row['nomeCompleto'];
        $cpfFilho = $row['cpf'];
        $dataNascimentoFilho = validaDataRecupera($row['dataNascimento']);


        $contadorFilho = $contadorFilho + 1;
        $arrayFilho[] = array(
            "sequencialFilho" => $contadorFilho,
            "nomeFilho" => $nomeCompletoFilho,
            "cpfFilho" => $cpfFilho,
            "dataNascimentoFilho" => $dataNascimentoFilho

        );
    }

    $strArrayFilho = json_encode($arrayFilho);




    // //----------------------Montando o array do DEPENDENTE


    $reposit = "";
    $result = "";
    $sql = "SELECT FD.codigo, FD.candidato, FD.nomeCompleto, FD.cpf, FD.dataNascimento,FD.grauParentescoDependente FROM Contratacao.candidatoDependente FD 
    INNER JOIN Contratacao.candidato F ON F.codigo = FD.candidato WHERE (0=0) AND F.codigo = " . $codigoCandidato;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorDependente = 0;
    $arrayDependente = array();
    foreach($result as $row) {
        $nomeCompletoDependente = $row['nomeCompleto'];
        $cpfDependente = $row['cpf'];
        $dataNascimentoDependente = validaDataRecupera($row['dataNascimento']);
        $grauParentescoDependente = $row['grauParentescoDependente'];


        $contadorDependente = $contadorDependente + 1;
        $arrayDependente[] = array(
            "sequencialDependente" => $contadorDependente,
            "nomeDependente" => $nomeCompletoDependente,
            "cpfDependente" => $cpfDependente,
            "dataNascimentoDependente" => $dataNascimentoDependente,
            "grauParentescoDependente" => $grauParentescoDependente

        );
    }

    $strArrayDependente = json_encode($arrayDependente);


    $out =   $codigo . "^" .
        $nomeCompleto . "^" .
        $tipoContrato . "^" .
        $dataAdmissao  . "^" .
        $projeto  . "^" .
        $cargo  . "^" .
        $cbo  . "^" .
        $experiencia  . "^" .
        $sindicato  . "^" .
        $salarioBase  . "^" .
        $tipoEscala  . "^" .
        $dataInicioRevezamento  . "^" .
        $tipoRevezamento  . "^" .
        $escalaHorario  . "^" .
        $verificado . "^" .
        $dataNascimento . "^" .
        $estadoCivil . "^" .
        $telefoneResidencial . "^" .
        $telefoneCelular . "^" .
        $outroTelefone . "^" .
        $email . "^" .
        $cep . "^" .
        $endereco . "^" .
        $bairro . "^" .
        $numero . "^" .
        $complemento . "^" .
        $estado  . "^" .
        $cidade . "^" .
        $cpf . "^" .
        $pis . "^" .
        $carteiraTrabalho . "^" .
        $carteiraTrabalhoSerie . "^" .
        $dataExpedicaoCarteiraTrabalho . "^" .
        $localCarteiraTrabalho . "^" .
        $rg . "^" .
        $emissorRg . "^" .
        $localRg . "^" .
        $dataEmissaoRg . "^" .
        $cnh . "^" .
        $categoriaCnh . "^" .
        $ufCnh . "^" .
        $dataEmissaoCnh . "^" .
        $dataVencimentoCnh . "^" .
        $primeiraCnh . "^" .
        $tituloEleitor . "^" .
        $zonaTituloEleitor . "^" .
        $secaoTituloEleitor . "^" .
        $certificadoReservista . "^" .
        $grauInstrucao . "^" .
        $atividadesExtracurriculares  . "^" .
        $nomeConjuge . "^" .
        $dataNascimentoConjuge . "^" .
        $trabalhaAtualmente . "^" .
        $seguroDesemprego . "^" .
        $desejaAssistenciaMedica . "^" .
        $desejaAssistenciaOdontologica . "^" .
        $valeRefeicaoValeAlimentacao . "^" .
        $desejaVt . "^" .
        $possuiVt . "^" .
        $numeroCartaoVt . "^" .
        $agenciaBanco . "^" .
        $digitoAgenciaBanco . "^" .
        $contaCorrente . "^" .
        $digitoContaBanco . "^" .
        $fk_banco . "^" .
        $variacao . "^" .
        $tipoConta . "^" .
        $numeroCamisa . "^" .
        $numeroCalca . "^" .
        $numeroSaia . "^" .
        $numeroSapato . "^" .
        $prazoDeterminado . "^" .
        $dataFinal;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayFilho . "#" . $strArrayDependente;
    return;
}

function recuperaValores()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT * FROM Contratacao.candidato WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])


    $nomeCompleto = $row['nomeCompleto'];
    $dataNascimento = validaDataRecupera($row['dataNascimento']);
    $estadoCivil = $row['estadoCivil'];
    $telefoneResidencial = $row['telefoneResidencial'];
    $telefoneCelular = $row['telefoneCelular'];
    $outroTelefone = $row['outroTelefone'];
    $email = $row['email'];
    $cep = $row['cep'];
    $endereco = $row['endereco'];
    $bairro = $row['bairro'];
    $estado = $row['estado'];
    $cidade = $row['cidade'];
    $numero = $row['numero'];
    $complemento = $row['complemento'];
    $cpf = $row['cpf'];
    $pis = $row['pis'];
    $carteiraTrabalho = $row['carteiraTrabalho'];
    $carteiraTrabalhoSerie = $row['carteiraTrabalhoSerie'];
    $dataExpedicaoCarteiraTrabalho = validaDataRecupera($row['dataExpedicaoCarteiraTrabalho']);
    $localCarteiraTrabalho = $row['localCarteiraTrabalho'];
    $rg = $row['rg'];
    $emissorRg = $row['emissorRg'];
    $localRg = $row['localRg'];
    $dataEmissaoRg = validaDataRecupera($row['dataEmissaoRg']);
    $cnh = $row['cnh'];
    $categoriaCnh = $row['categoriaCnh'];
    $ufCnh = $row['ufCnh'];
    $dataVencimentoCnh = validaDataRecupera($row['dataVencimentoCnh']);
    $dataEmissaoCnh = validaDataRecupera($row['dataEmissaoCnh']);
    $dataVencimentoCnh = validaDataRecupera($row['dataVencimentoCnh']);
    $primeiraCnh = validaDataRecupera($row['primeiraCnh']);
    $tituloEleitor = $row['tituloEleitor'];
    $zonaTituloEleitor = $row['zonaTituloEleitor'];
    $secaoTituloEleitor = $row['secaoTituloEleitor'];
    $certificadoReservista = $row['certificadoReservista'];
    $grauInstrucao = $row['grauInstrucao'];
    $atividadesExtracurriculares = $row['atividadesExtracurriculares'];
    $nomeConjuge = $row['nomeConjuge'];
    $dataNascimentoConjuge = validaDataRecupera($row['dataNascimentoConjuge']);
    $trabalhaAtualmente = $row['trabalhaAtualmente'];
    $seguroDesemprego = $row['seguroDesemprego'];
    $desejaAssistenciaMedica = $row['desejaAssistenciaMedica'];
    $desejaAssistenciaOdontologica = $row['desejaAssistenciaOdontologica'];
    $valeRefeicaoValeAlimentacao = $row['valeRefeicaoValeAlimentacao'];
    $desejaVt = $row['desejaVt'];
    $possuiVt = $row['possuiVt'];
    $numeroCartaoVt = $row['numeroCartaoVt'];
    $agenciaBanco = $row['agenciaBanco'];
    $digitoAgenciaBanco = $row['digitoAgenciaBanco'];
    $contaCorrente = $row['contaCorrente'];
    $digitoContaBanco = $row['digitoContaBanco'];
    $fk_banco = $row['fk_banco'];
    $variacao = $row['variacao'];
    $tipoConta = $row['tipoConta'];

    $numeroCamisa = $row['numeroCamisa'];
    $numeroCalca = $row['numeroCalca'];
    $numeroSaia = $row['numeroSaia'];
    $numeroSapato = $row['numeroSapato'];
    $logradouro = $row['logradouro'];

    // //----------------------Montando o array do Filho

    $reposit = "";
    $result = "";
    $sql = "SELECT FI.codigo, FI.candidato, FI.nomeCompleto, FI.cpf, FI.dataNascimento FROM Contratacao.candidatoFilho FI 
    INNER JOIN Contratacao.candidato F ON F.codigo = FI.candidato WHERE (0=0) AND F.codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorFilho = 0;
    $arrayFilho = array();
    foreach($result as $row) {

        $nomeCompletoFilho = $row['nomeCompleto'];
        $cpfFilho = $row['cpf'];
        $dataNascimentoFilho = validaDataRecupera($row['dataNascimento']);


        $contadorFilho = $contadorFilho + 1;
        $arrayFilho[] = array(
            "sequencialFilho" => $contadorFilho,
            "nomeFilho" => $nomeCompletoFilho,
            "cpfFilho" => $cpfFilho,
            "dataNascimentoFilho" => $dataNascimentoFilho

        );
    }

    $strArrayFilho = json_encode($arrayFilho);


    // //----------------------Montando o array do DEPENDENTE


    $reposit = "";
    $result = "";
    $sql = "SELECT FD.codigo, FD.candidato, FD.nomeCompleto, FD.cpf, FD.dataNascimento,FD.grauParentescoDependente FROM Contratacao.candidatoDependente FD 
    INNER JOIN Contratacao.candidato F ON F.codigo = FD.candidato WHERE (0=0) AND F.codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorDependente = 0;
    $arrayDependente = array();
    foreach($result as $row) {
        $nomeCompletoDependente = $row['nomeCompleto'];
        $cpfDependente = $row['cpf'];
        $dataNascimentoDependente = validaDataRecupera($row['dataNascimento']);
        $grauParentescoDependente = $row['grauParentescoDependente'];


        $contadorDependente = $contadorDependente + 1;
        $arrayDependente[] = array(
            "sequencialDependente" => $contadorDependente,
            "nomeDependente" => $nomeCompletoDependente,
            "cpfDependente" => $cpfDependente,
            "dataNascimentoDependente" => $dataNascimentoDependente,
            "grauParentescoDependente" => $grauParentescoDependente

        );
    }

    $strArrayDependente = json_encode($arrayDependente);


    $out = $nomeCompleto . "^" .
        $dataNascimento . "^" .
        $estadoCivil . "^" .
        $telefoneResidencial . "^" .
        $telefoneCelular . "^" .
        $outroTelefone . "^" .
        $email  . "^" .
        $cep . "^" .
        $endereco . "^" .
        $bairro . "^" .
        $estado . "^" .
        $cidade . "^" .
        $numero . "^" .
        $complemento . "^" .
        $cpf . "^" .
        $pis . "^" .
        $carteiraTrabalho . "^" .
        $carteiraTrabalhoSerie . "^" .
        $dataExpedicaoCarteiraTrabalho . "^" .
        $localCarteiraTrabalho . "^" .
        $rg . "^" .
        $emissorRg . "^" .
        $localRg . "^" .
        $dataEmissaoRg . "^" .
        $cnh . "^" .
        $categoriaCnh . "^" .
        $ufCnh . "^" .
        $dataEmissaoCnh . "^" .
        $dataVencimentoCnh . "^" .
        $primeiraCnh . "^" .
        $tituloEleitor . "^" .
        $zonaTituloEleitor  . "^" .
        $secaoTituloEleitor  . "^" .
        $certificadoReservista . "^" .
        $grauInstrucao . "^" .
        $atividadesExtracurriculares . "^" .
        $nomeConjuge . "^" .
        $dataNascimentoConjuge . "^" .
        $trabalhaAtualmente . "^" .
        $seguroDesemprego . "^" .
        $desejaAssistenciaMedica . "^" .
        $desejaAssistenciaOdontologica . "^" .
        $valeRefeicaoValeAlimentacao . "^" .
        $desejaVt . "^" .
        $possuiVt . "^" .
        $numeroCartaoVt . "^" .
        $agenciaBanco . "^" .
        $digitoAgenciaBanco . "^" .
        $contaCorrente . "^" .
        $digitoContaBanco . "^" .
        $fk_banco . "^" .
        $variacao . "^" .
        $tipoConta . "^" .
        $numeroCamisa . "^" .
        $numeroCalca . "^" .
        $numeroSaia . "^" .
        $numeroSapato . "^" .
        $logradouro;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayFilho . "#" . $strArrayDependente;
    return;
}

function recuperaCbo()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT cbo FROM Ntl.cargo WHERE (0=0) AND codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])

    $cbo = $row['cbo'];

    $out =   $cbo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CONTRATACAO_ACESSAR|CONTRATACAO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um funcionário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Contratacao.controleCandidato' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}


function validaString($value)
{
    $null = 'NULL';
    if ($value == '')
        return $null;
    return '\'' . $value . '\'';
}

function validaNumero($value)
{
    if ($value == "") {
        $value = 'NULL';
    }
    return $value;
}
function validaCodigo($value)
{
    return $value;
}
function validaData($value)
{
    if ($value == "") {
        $value = 'NULL';
        return $value;
    }
    $value = str_replace('/', '-', $value);
    $value = date("Y-m-d", strtotime($value));
    $value = "'" . $value . "'";
    return $value;
}

function validaDataRecupera($value)
{
    if ($value == "") {
        $value = '';
        return $value;
    }
    $value = date('d/m/Y', strtotime($value));
    return $value;
}
function validaVerifica($value)
{
    if ($value == "") {
        $value = NULL;
    }
    return $value;
}

function tofloat($num)
{
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
    );
}


