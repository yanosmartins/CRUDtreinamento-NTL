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
if ($funcao == 'verificaMatricula') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

return;

function grava()
{

    $reposit = new reposit(); //Abre a conexão.   


    session_start();
    $usuario = validaString($_SESSION['login']);
    $codigo =  validaCodigo($_POST['codigo'] ?: 0);
    $ativo =  validaCodigo($_POST['ativo'] ?: 0);
    $candidato = validaString($_POST['funcionario']);
    if ($candidato != "") {

        $sql = "SELECT codigo FROM Contratacao.candidato WHERE (0=0) AND nomeCompleto = " . $candidato;

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        if (($row = odbc_fetch_array($result)))
            $row = array_map('utf8_encode', $row);
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
    $tipoAdmissao = validaNumero($_POST['tipoAdmissao']);
    $indicativoAdmissao = validaNumero($_POST['indicativoAdmissao']);
    $naturezaOcupacao = validaNumero($_POST['naturezaOcupacao']);
    $categoriaSefip = validaNumero($_POST['categoriaSefip']);
    $quantidadeDiasExperiencia = validaNumero($_POST['quantidadeDiasExperiencia']);
    $quantidadeDiasProrrogacao = validaNumero($_POST['quantidadeDiasProrrogacao']);
    $categoriaEsocial = validaNumero($_POST['categoriaEsocial']);
    $vinculoEmpregaticio = validaNumero($_POST['vinculoEmpregaticio']);
    $horasMensais = validaString($_POST['horasMensais']);
    $horasSemanais = validaString($_POST['horasSemanais']);
    $horasDiarias = validaString($_POST['horasDiarias']);
    $formaPagamento = validaNumero($_POST['formaPagamento']);
    $tipoCandidato = validaNumero($_POST['tipoFuncionario']);
    $modoPagamento = validaNumero($_POST['modoPagamento']);
    $regimeJornadaTrabalho = validaNumero($_POST['regimeJornadaTrabalho']);
    $descansoSemanal = validaNumero($_POST['descansoSemanal']);
    $tipoJornadaEsocial = validaNumero($_POST['tipoJornadaEsocial']);
    $verificadoPeloGestor =  trim($_POST['verificadoPeloGestor']); //Sinaliza se o Gestor preencheu ou não todos os campos respectivos á ele.
    $verificadoPeloRh =  trim($_POST['verificadoPeloGestor']);
    $matriculaSCI = validaString($_POST['matriculaSCI']);
    $classe = validaNumero($_POST['classe']);
    $prazoDeterminado = validaNumero($_POST['prazoDeterminado']);
    $dataFinal = validaData($_POST['dataFinal']);

    if ($verificadoPeloGestor == 'Sim') {
        $verificadoPeloGestor = 1;
    } else {
        $verificadoPeloGestor = 0;
    }
    if ($verificadoPeloRh == 'Sim') {
        $verificadoPeloRh = 1;
    } else {
        $verificadoPeloRh = 0;
    }
    $sql = "Contratacao.controleCandidato_Atualiza( 
        $codigo,
        $ativo,
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
        $tipoAdmissao,	
        $indicativoAdmissao,
        $naturezaOcupacao,
        $categoriaSefip,
        $quantidadeDiasExperiencia,
        $quantidadeDiasProrrogacao,
        $categoriaEsocial,
        $vinculoEmpregaticio,
        $horasMensais,
        $horasSemanais,
        $horasDiarias,
        $formaPagamento,
        $tipoCandidato,
        $modoPagamento,
        $regimeJornadaTrabalho,
        $descansoSemanal,
        $tipoJornadaEsocial, 
        $verificadoPeloGestor,
        $verificadoPeloRh,
        $matriculaSCI,
        $classe, 
        $prazoDeterminado, 
        $usuario, 
        $dataFinal
        )";

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
        $id = +$_POST["id"];
    }

    $sql = "SELECT  CC.prazoDeterminado, C.codigo as codigoCandidato,CC.codigo, C.nomeCompleto as nomeCandidato, 
    C.dataNascimento, C.estadoCivil,C.telefoneResidencial,C.telefoneCelular,C.outroTelefone,C.email,C.cep,
	C.endereco,C.bairro,C.numero,C.complemento,C.estado,C.cidade, C.logradouro,
	C.cpf,C.pis,C.carteiraTrabalho,C.carteiraTrabalhoSerie,C.dataExpedicaoCarteiraTrabalho,C.localCarteiraTrabalho,C.rg,C.emissorRg,C.localRg,C.dataEmissaoRg,
	C.cnh,C.categoriaCnh,C.ufCnh,C.dataEmissaoCnh,C.dataVencimentoCnh,C.primeiraCnh,C.tituloEleitor,C.zonaTituloEleitor,C.secaoTituloEleitor,C.certificadoReservista,
	C.grauInstrucao,C.atividadesExtracurriculares,C.nomeConjuge,C.dataNascimentoConjuge,
	C.trabalhaAtualmente,C.seguroDesemprego,C.desejaAssistenciaMedica,C.desejaAssistenciaOdontologica,C.valeRefeicaoValeAlimentacao,C.desejaVt,C.possuiVt,
	C.numeroCartaoVt,C.agenciaBanco,C.digitoAgenciaBanco,C.contaCorrente,C.digitoContaBanco,C.fk_banco,C.variacao,C.tipoConta, C.numeroCamisa,C.numeroCalca,C.numeroSaia,C.numeroSapato,
    CC.* 
    FROM Contratacao.candidato C
    LEFT JOIN Ntl.banco B ON C.digitoAgenciaBanco = B.codigo
    LEFT JOIN Contratacao.controleCandidato CC ON CC.candidato = C.codigo 
    WHERE (0=0) AND CC.codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);
    $codigoCandidato = $row['codigoCandidato']; //id candidato na tabela candidato
    $codigo = $row['codigo']; // id na tabela controle candidato cadastro
    $ativo = $row['ativo'];
    $candidato = $row['nomeCandidato'];
    $tipoContrato = $row['tipoContrato'];
    $dataAdmissao = validaDataRecupera($row['dataAdmissao']);
    $projeto = $row['projeto'];
    $cargo = $row['cargo'];
    $cbo = $row['cbo'];
    $experiencia = $row['experiencia'];
    $sindicato = $row['sindicato'];
    $salarioBase = $row['salarioBase'];
    $tipoEscala = $row['tipoEscala'];
    $tipoEscala = $row['tipoEscala'];
    $dataInicioRevezamento = validaDataRecupera($row['dataInicioRevezamento']);
    $tipoRevezamento = $row['tipoRevezamento'];
    $escalaHorario = $row['escalaHorario'];
    $tipoAdmissao = mb_convert_encoding($row['tipoAdmissao'], 'UTF-8', 'HTML-ENTITIES');
    $indicativoAdmissao = $row['indicativoAdmissao'];
    $naturezaOcupacao = $row['naturezaOcupacao'];
    $fgtsGpsCategoriaSefip = $row['fgtsGpsCategoriaSefip'];
    $quantidadeDiasExperiencia = $row['quantidadeDiasExperiencia'];
    $quantidadeDiasProrrogacao = $row['quantidadeDiasProrrogacao'];
    $fgtsGpsCategoriaESocial = $row['fgtsGpsCategoriaESocial'];
    $vinculoEmpregaticio = $row['vinculoEmpregaticio'];
    $horasMensais = $row['horasMensais'];
    $horasSemanais = $row['horasSemanais'];
    $horasDiarias = $row['horasDiarias'];
    $formaPagamento = $row['formaPagamento'];
    $tipoCandidato = $row['tipoCandidato'];
    $modoPagamento = $row['modoPagamento'];
    $regimeJornadaTrabalho = $row['regimeJornadaTrabalho'];
    $descansoSemanal = $row['descansoSemanal'];
    $tipoJornadaEsocial = $row['tipoJornadaESocial'];
    $verificadoPeloGestor = $row['verificadoPeloGestor'];
    $verificadoPeloRh = $row['verificadoPeloRh'];
    $agenciaBanco = $row['agenciaBanco'];
    $digitoAgenciaBanco = $row['digitoAgenciaBanco'];
    $contaCorrente = $row['contaCorrente'];
    $digitoContaBanco = $row['digitoContaBanco'];
    $fk_banco = $row['fk_banco'];
    $variacao = $row['variacao'];
    $dataNascimento = $row['dataNascimento'];
    $estadoCivil = $row['estadoCivil'];
    $telefoneResidencial = $row['telefoneResidencial'];
    $telefoneCelular = $row['telefoneCelular'];
    $outroTelefone = $row['outroTelefone'];
    $email = $row['email'];
    $matriculaSCI = $row['matriculaSCI'];
    $classe = $row['classe'];
    $dataNascimento = validaDataRecupera($row['dataNascimento']);
    $estadoCivil = $row['estadoCivil'];
    $telefoneResidencial = $row['telefoneResidencial'];
    $telefoneCelular = $row['telefoneCelular'];
    $outroTelefone = $row['outroTelefone'];
    $email = $row['email'];
    $cep = $row['cep'];
    $endereco = $row['endereco'];
    $bairro = $row['bairro'];
    $numero = $row['numero'];
    $complemento = $row['complemento'];
    $estado = $row['estado'];
    $cidade = $row['cidade'];
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
    $tipoConta = $row['tipoConta'];
    $numeroCamisa = $row['numeroCamisa'];
    $numeroCalca = $row['numeroCalca'];
    $numeroSaia = $row['numeroSaia'];
    $numeroSapato = $row['numeroSapato'];
    $prazoDeterminado = $row['prazoDeterminado'];
    $dataFinal = validaDataRecupera($row['dataFinal']);
    $logradouro = $row['logradouro'];

    // //----------------------Montando o array do Filho

    $reposit = "";
    $result = "";
    $sql = "SELECT CF.codigo, CF.candidato, CF.nomeCompleto, CF.cpf, CF.dataNascimento FROM Contratacao.candidatoFilho CF 
     INNER JOIN Contratacao.candidato C ON C.codigo = CF.candidato WHERE (0=0) AND C.codigo = " . $codigoCandidato;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorFilho = 0;
    $arrayFilho = array();
    while ($row = odbc_fetch_array($result)) {

        $nomeCompletoFilho = mb_convert_encoding($row['nomeCompleto'], 'UTF-8', 'HTML-ENTITIES');
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
    $sql = "SELECT CD.codigo, CD.candidato, CD.nomeCompleto, CD.cpf, CD.dataNascimento,CD.grauParentescoDependente FROM Contratacao.candidatoDependente CD 
     INNER JOIN Contratacao.candidato C ON C.codigo = CD.candidato WHERE (0=0) AND C.codigo = " . $codigoCandidato;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorDependente = 0;
    $arrayDependente = array();
    while ($row = odbc_fetch_array($result)) {
        $nomeCompletoDependente = mb_convert_encoding($row['nomeCompleto'], 'UTF-8', 'HTML-ENTITIES');
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
        $ativo . "^" .
        $candidato . "^" .
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
        $tipoAdmissao  . "^" .
        $indicativoAdmissao  . "^" .
        $naturezaOcupacao  . "^" .
        $fgtsGpsCategoriaSefip  . "^" .
        $quantidadeDiasExperiencia  . "^" .
        $quantidadeDiasProrrogacao  . "^" .
        $fgtsGpsCategoriaESocial  . "^" .
        $vinculoEmpregaticio  . "^" .
        $horasMensais  . "^" .
        $horasSemanais  . "^" .
        $horasDiarias  . "^" .
        $formaPagamento  . "^" .
        $tipoCandidato  . "^" .
        $modoPagamento  . "^" .
        $regimeJornadaTrabalho  . "^" .
        $descansoSemanal  . "^" .
        $tipoJornadaEsocial . "^" .
        $verificadoPeloGestor . "^" .
        $verificadoPeloRh . "^" .
        $agenciaBanco . "^" .
        $digitoAgenciaBanco . "^" .
        $contaCorrente . "^" .
        $digitoContaBanco . "^" .
        $fk_banco . "^" .
        $variacao . "^" .
        $matriculaSCI . "^" .
        $classe . "^" .
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
        $tipoConta . "^" .
        $numeroCamisa . "^" .
        $numeroCalca . "^" .
        $numeroSaia . "^" .
        $numeroSapato . "^" .
        $prazoDeterminado . "^" .
        $dataFinal . "^" .
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
        $id = +$_POST["id"];
    }

    $sql = "SELECT cbo FROM Ntl.cargo WHERE (0=0) AND codigoCargoSCI = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);
    $cbo = $row['cbo'];

    $out =   $cbo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function verificaMatricula()
{
    if ((empty($_POST["matriculaSCI"])) || (!isset($_POST["matriculaSCI"])) || (is_null($_POST["matriculaSCI"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $matriculaSCI = +$_POST["matriculaSCI"];
    }

    $id = +$_POST["id"];

    $sql = "SELECT matriculaSCI, codigo FROM Contratacao.controleCandidato WHERE matriculaSCI = " . $matriculaSCI;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (($row = odbc_fetch_array($result))) {
        $codigo = $row['codigo'];
        if ($id != $codigo) {
            echo "sucess";
            return;
        }
    }

    echo "failed";
    return;
}


function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CONTRATACOESRH_ACESSAR|CONTRATACOESRH_EXCLUIR");

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
