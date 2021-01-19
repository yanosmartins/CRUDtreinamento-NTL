<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'exportar') {
    call_user_func($funcao);
}

return;

function exportar()
{

    $reposit = new reposit(); //Abre a conexão.

    $arrayCandidatos = $_POST['checkboxComIdDosFuncionarios']; //Recupera os ids dos funcionários para a exportação.

    if ((empty($arrayCandidatos)) || (!isset($arrayCandidatos)) || (is_null($arrayCandidatos))) {
        echo "failed";
        return;
    }

    $nomeArquivo = 'SYSCCPARASCI_' . date("Ymd_is") . '.txt'; //Nome do arquivo;  

    /*Verifica se o diretório com o endereço especificado existe,
    se não, ele cria e atribui permissões de leitura e gravação. */

    $localExportacao = '../logs_exportacao_SCI/';
    if (!file_exists($localExportacao)) {
        mkdir($localExportacao, 0777, true);
        chmod($localExportacao, 0777);
    }

    $localExportacao .= $nomeArquivo;

    $handler = fopen($localExportacao, 'w');

    $arrayCandidatosExportacao = array();

    for ($i = 0; $i < count($arrayCandidatos); $i++) {

        gravarLogExportacao($arrayCandidatos[$i], $nomeArquivo);

        $sql = "SELECT  C.nomeCompleto,
		CC.matriculaSCI,
		CC.classe,
        C.paisNascimento,
		C.endereco,
		C.numero,
		C.bairro,
		C.complemento,
		C.estado,
		C.municipioNascimento,
		C.ufNascimento,
		C.sexo,
		C.estadoCivil,
		C.grauInstrucao, 
		C.telefoneResidencial,
		C.telefoneCelular, 
		C.email,
		B.codigoBanco,
		C.agenciaBanco,
		C.nomeConjuge,
		C.rg,
		C.localRg,
		C.emissorRg,
		C.cnh,
		C.categoriaCnh,
		C.dataEmissaoCnh,
		C.dataVencimentoCnh,
		C.primeiraCnh,
		C.carteiraTrabalhoSerie,
		C.localCarteiraTrabalho,
		C.cep,
		C.dataEmissaoRg,
		C.cpf,
		C.pis,
		C.tituloEleitor,
		C.secaoTituloEleitor,
		C.zonaTituloEleitor,
		C.cidade,
		C.estado,
	    C.nacionalidade,
		C.carteiraTrabalho,
		P.numeroCentroCusto, 
		C.dataNascimento,
		CC.dataAdmissao,
		CC.naturezaOcupacao,
		CC.sindicato, 
		CC.formaPagamento,
		CC.tipoCandidato,
		CC.horasMensais,
		CC.horasSemanais,
		CC.horasDiarias,
		CC.salarioBase,
		CC.quantidadeDiasExperiencia,
		CC.quantidadeDiasProrrogacao,
		CC.cbo,   
		CC.cargo
		AS cargoSelecionado,
		CC.tipoAdmissao, 
		CC.vinculoEmpregaticio, 
		C.nomePai, 
		C.nomeMae,
        C.logradouro,
        C.racaCor,
        CC.indicativoAdmissao, 
        CC.tipoContrato, 
        CC.dataFinal,
        C.ufCnh,
        CC.fgtsGpsCategoriaSefip, 
        C.ufNascimentoConjuge,
        C.dataNascimentoConjuge,
        CC.fgtsGpsCategoriaESocial, 
        C.contaCorrente, 
        C.digitoContaBanco, 
        C.tipoConta, 
        CC.regimeJornadaTrabalho, 
        CC.tipoEscala,
        CC.escalaHorario, 
        CC.descansoSemanal, 
        CC.tipoJornadaESocial, 
        C.dataExpedicaoCarteiraTrabalho,
        CC.dataInicioRevezamento, 
        CC.tipoRevezamento
        FROM Contratacao.candidato C
        LEFT JOIN Contratacao.controleCandidato CC ON CC.candidato = C.codigo 
		LEFT JOIN Ntl.projeto P ON CC.projeto = P.codigo
        LEFT JOIN Ntl.banco B ON C.fk_banco = B.codigo
        WHERE CF.verificadoPeloRh = 1
        AND (0=0) AND F.codigo = " . $arrayCandidatos[$i];

        $result = $reposit->RunQuery($sql);
        if (($row = odbc_fetch_array($result)))
            $row = array_map('utf8_encode', $row);

        //Recuperação do Banco..
        $nomeCompleto = $row['nomeCompleto'];
        $matricula = $row['matriculaSCI'];
        $classe = $row['classe'];
        $endereco = $row['endereco'];
        $numeroEndereco = $row['numero'];
        $bairro = $row['bairro'];
        $complemento = $row['complemento'];
        $uf = $row['estado'];
        $municipioNascimento = $row['municipioNascimento']; //Cidade de Nascimento -> É recuperado como código.
        $codigoMunicipioNascimento = $municipioNascimento;
        $ufNascimento = $row['ufNascimento']; //UfNascimento -> É recuperado como código primeiro. 
        $paisNascimento = $row['paisNascimento'];

        //Arruma os valores conectando com a API do IBGE
        $arrayIbge = conectarIbge($ufNascimento, $municipioNascimento);
        $ufNascimento = $arrayIbge[0];
        $naturalidade = $ufNascimento;
        $municipioNascimento = $arrayIbge[1];
        $sexo = $row['sexo'];
        $sexo = getSexo($sexo);
        $estadoCivil = $row['estadoCivil'];
        $grauInstrucao = $row['grauInstrucao'];
        $telefoneResidencial = $row['telefoneResidencial'];
        $dddTelefoneResidencial = explode(" ", $telefoneResidencial);
        $telefoneResidencial = $dddTelefoneResidencial[1];
        $dddTelefoneResidencial = $dddTelefoneResidencial[0];
        $telefoneCelular = $row['telefoneCelular'];
        $dddTelefoneCelular = explode(" ", $telefoneCelular);
        $telefoneCelular = $dddTelefoneCelular[1];
        $dddTelefoneCelular = $dddTelefoneCelular[0];
        $email = $row['email'];
        $codigoBanco = $row['codigoBanco'];
        $agenciaBanco = $row['agenciaBanco'];
        $agenciaJuntoComBanco = $codigoBanco . $agenciaBanco;
        $nomeConjuge = $row['nomeConjuge'];
        $rg = $row['rg'];
        $localRg = $row['localRg'];
        $emissorRg = $row['emissorRg'];
        $cnh = $row['cnh'];
        $categoriaCnh = +$row['categoriaCnh'];
        $dataEmissaoCnh = $row['dataEmissaoCnh'];
        $dataVencimentoCnh = $row['dataVencimentoCnh'];
        $primeiraCnh = $row['primeiraCnh'];
        $carteiraTrabalhoSerie = $row['carteiraTrabalhoSerie'];
        $localCarteiraTrabalho = $row['localCarteiraTrabalho'];
        $cep = $row['cep'];
        $cpf = $row['cpf'];
        $pis = $row['pis'];
        $tituloEleitor = $row['tituloEleitor'];
        $secaoTituloEleitor = $row['secaoTituloEleitor'];
        $zonaTituloEleitor = $row['zonaTituloEleitor'];
        $cidade = $row['cidade'];
        $estado = $row['estado'];
        $nacionalidade = $row['nacionalidade'];
        $dataChegadaBrasil = '';
        $carteiraTrabalho = $row['carteiraTrabalho'];
        $centroCusto = +$row['numeroCentroCusto'];
        $departamento = ""; //Fica vazio.
        $dataNascimento = $row['dataNascimento'];
        $dataNascimento = verificaDatetime($dataNascimento);
        $dataAdmissao = $row['dataAdmissao'];
        $naturezaOcupacao = $row['naturezaOcupacao'];
        $contaFgts = "";
        $sindicato = $row['sindicato'];
        $formaPagamento = $row['formaPagamento'];
        $tipoPagamento = $row['tipoCandidato'];
        $horasMensais = $row['horasMensais'];
        $horasSemanais = $row['horasSemanais'];
        $horasDiarias = $row['horasDiarias'];
        $salarioBase = $row['salarioBase'];
        $salarioBase = round($salarioBase, PHP_ROUND_HALF_EVEN);
        $quantidadeDiasExperiencia = $row['quantidadeDiasExperiencia'];
        $quantidadeDiasProrrogacao = $row['quantidadeDiasProrrogacao'];
        $cbo = $row['cbo'];
        $cargo = $row['cargoSelecionado'];
        $primeiroEmprego = +$row['tipoAdmissao'];
        $vinculoEmpregaticio = $row['vinculoEmpregaticio'];
        $nomePai = $row['nomePai'];
        $nomeMae = $row['nomeMae'];
        $nomeSocial = " ";
        $logradouro = $row['logradouro'];
        $racaCor = +$row['racaCor'];
        $indicativoAdmissao = +$row['indicativoAdmissao'];
        $tipoContrato = +$row['tipoContrato'];
        $dataFinal = $row['dataFinal'];
        $dataFinal = verificaDatetime($dataFinal);
        $dataEmissaoRg = $row['dataEmissaoRg'];
        $ufCnh = $row['ufCnh'];
        $municipioNascimentoConjuge = $row['municipioNascimentoConjuge'];
        $fgtsGpsCategoriaSefip = $row['fgtsGpsCategoriaSefip'];
        $ufNascimentoConjuge = $row['ufNascimentoConjuge'];
        $arrayIbgeConjuge = conectarIbge($ufNascimentoConjuge, $municipioNascimentoConjuge);
        $ufNascimentoConjuge = $arrayIbgeConjuge[0];
        $dataNascimentoConjuge = $row['dataNascimentoConjuge'];
        $dataNascimentoConjuge = verificaDatetime($dataNascimentoConjuge);
        $fgtsGpsCategoriaESocial = $row['fgtsGpsCategoriaESocial'];
        $contaCorrente = $row['contaCorrente'];
        $digitoContaBanco = +$row['digitoContaBanco'];
        $tipoConta = +$row['tipoConta'];
        $modoPagamento = "";
        $regimeJornadaTrabalho = $row['regimeJornadaTrabalho'];
        $tipoEscala = +$row['tipoEscala'];
        $escalaHorario = $row['escalaHorario'];
        $descansoSemanal = +$row['descansoSemanal'];
        $tipoJornadaESocial = +$row['tipoJornadaESocial'];
        $dataExpedicaoCarteiraTrabalho = $row['dataExpedicaoCarteiraTrabalho'];
        $dataEmissaoPis = "";
        $dataInicioRevezamento = $row['dataInicioRevezamento'];
        $tipoRevezamento = +$row['tipoRevezamento'];

        $arrayCandidatosExportacaoTemp = array(
            "nome" => $nomeCompleto,
            "sexo" => $sexo,
            "cpf" => $cpf,
            "pisPasep" => $pis,
            "rg" => $rg,
            "ufIdentidade" => $localRg,
            "orgaoEmissorRg" => $emissorRg,
            "dataEmissaoRG" => $dataEmissaoRg,
            "cnh" => $cnh,
            "categoriaCNH" => $categoriaCnh,
            "dataEmissaoCNH" => $dataEmissaoCnh,
            "dataVencimentoCNH" => $dataVencimentoCnh,
            "primeiraHabilitacaoCNH" => $primeiraCnh,
            "numeroCarteiraTrabalho" => $carteiraTrabalho,
            "serieCarteiraTrabalho" => $carteiraTrabalhoSerie,
            "ufCarteiraTrabalho" => $localCarteiraTrabalho,
            "cep" => $cep,
            "logradouro" => $endereco,
            "numeroLogradouro" => $numeroEndereco,
            "complemento" => $complemento,
            "ufLogradouro" => $uf,
            "cargo" => $cargo,
            "telefone" => $telefoneCelular,
            "email" => $email
        );


        $dataEmissaoRg = verificaDatetime($dataEmissaoRg);
        $dataEmissaoCnh = verificaDatetime($dataEmissaoCnh);
        $dataVencimentoCnh = verificaDatetime($dataVencimentoCnh);
        $primeiraCnh = verificaDatetime($primeiraCnh);
        $dataExpedicaoCarteiraTrabalho = verificaDatetime($dataExpedicaoCarteiraTrabalho);
        $dataInicioRevezamento = verificaDatetime($dataInicioRevezamento);

        array_push($arrayCandidatosExportacao, $arrayCandidatosExportacaoTemp);

        //Limpando máscaras e outros caracteres.   
        $telefoneResidencial = limparCaracteres($telefoneResidencial);
        $dddTelefoneResidencial = limparCaracteres($dddTelefoneResidencial);
        $telefoneCelular = limparCaracteres($telefoneCelular);
        $dddTelefoneCelular = limparCaracteres($dddTelefoneCelular);
        $rg = limparCaracteres($rg);
        $cpf = limparCaracteres($cpf);
        $pis = limparCaracteres($pis);
        $tituloEleitor = limparCaracteres($tituloEleitor);
        $secaoTituloEleitor = limparCaracteres($secaoTituloEleitor);
        $zonaTituloEleitor = limparCaracteres($zonaTituloEleitor);
        $carteiraTrabalho = limparCaracteres($carteiraTrabalho);
        $dataNascimento = limparCaracteres($dataNascimento);
        $dataAdmissao = limparCaracteres($dataAdmissao);
        $salarioBase = limparCaracteres($salarioBase);
        $cbo = limparCaracteres($cbo);
        $cep = limparCaracteres($cep);
        $horasDiarias = limparCaracteres($horasDiarias);
        $dataFinal = limparCaracteres($dataFinal);
        $dataEmissaoRg = limparCaracteres($dataEmissaoRg);
        $dataEmissaoCnh = limparCaracteres($dataEmissaoCnh);
        $dataVencimentoCnh = limparCaracteres($dataVencimentoCnh);
        $primeiraCnh = limparCaracteres($primeiraCnh);
        $dataNascimentoConjuge = limparCaracteres($dataNascimentoConjuge);
        $contaCorrente = limparCaracteres($contaCorrente);
        $dataExpedicaoCarteiraTrabalho = limparCaracteres($dataExpedicaoCarteiraTrabalho);
        $dataInicioRevezamento = limparCaracteres($dataInicioRevezamento);

        //Tirando todo os acentos.
        $nomeCompleto = tiraAcento($nomeCompleto);
        $endereco = tiraAcento($endereco);
        $bairro = tiraAcento($bairro);
        $complemento = tiraAcento($complemento);
        $cidade = tiraAcento($cidade);
        $municipioNascimento = tiraAcento($municipioNascimento);
        $uf = tiraAcento($uf);
        $email = tiraAcento($email);
        $nomeConjuge = tiraAcento($nomeConjuge);
        $secaoTituloEleitor = tiraAcento($secaoTituloEleitor);
        $zonaTituloEleitor = tiraAcento($zonaTituloEleitor);
        $naturezaOcupacao = tiraAcento($naturezaOcupacao);
        $formaPagamento = tiraAcento($formaPagamento);
        $tipoPagamento = tiraAcento($tipoPagamento);
        $nomePai = tiraAcento($nomePai);
        $nomeMae = tiraAcento($nomeMae);
        $emissorRg = tiraAcento($emissorRg);
        $localRg = tiraAcento($localRg);

        //Arrumando valores discrepantes com o layout.
        $horasDiarias = fixHorasDiarias($horasDiarias);
        $estadoCivil = fixEstadoCivil($estadoCivil);
        $horasSemanais = fixHoras($horasSemanais);
        $horasMensais = fixHoras($horasMensais);
        $formaPagamento = fixFormaPagamento($formaPagamento);
        $tipoPagamento = fixTipoPagamento($tipoPagamento);
        $nacionalidade = "";
        $digitoSerieCTPS = "";
        $numeroDepIR = "";
        $numeroDepSF = "";
        $primeiroEmprego = $primeiroEmprego == 1 ? $primeiroEmprego = 1 : $primeiroEmprego = 2;
        $logradouro = fixLogradouro($logradouro);
        $racaCor = fixRacaCor($racaCor);
        $indicativoAdmissao = fixIndicativoAdmissao($indicativoAdmissao);
        $tipoContrato = fixTipoContrato($tipoContrato);
        $fgtsGpsCategoriaSefip = fixSefip($fgtsGpsCategoriaSefip);
        $regimeJornadaTrabalho = fixRegime($regimeJornadaTrabalho);
        $tipoEscala = fixTipoEscala($tipoEscala);

        //Adicionando espaços do layout com adicionarEspaços..
        $nomeCompleto = adicionarEspacos($nomeCompleto, 50);
        $matricula = adicionarEspacosNumero($matricula, 6);
        $classe = adicionarEspacosNumero($classe, 2);
        $endereco = adicionarEspacos($endereco, 60);
        $numeroEndereco = adicionarEspacosNumero($numeroEndereco, 6);
        $bairro = adicionarEspacos($bairro, 30);
        $complemento = adicionarEspacos($complemento, 30);
        $cidade = adicionarEspacos($cidade, 30);
        $municipioNascimento = adicionarEspacos($municipioNascimento, 25);
        $uf = adicionarEspacos($uf, 2);
        $sexo = adicionarEspacosNumero($sexo, 1);
        $estadoCivil = adicionarEspacosNumero($estadoCivil, 2);
        $grauInstrucao = adicionarEspacosNumero($grauInstrucao, 2);
        $telefoneResidencial = adicionarEspacosNumero($telefoneResidencial, 20);
        $dddTelefoneResidencial = adicionarEspacosNumero($dddTelefoneResidencial, 2);
        $dddTelefoneCelular = adicionarEspacosNumero($dddTelefoneCelular, 2);
        $telefoneCelular = adicionarEspacosNumero($telefoneCelular, 20);
        $email = adicionarEspacos($email, 60);
        $agenciaJuntoComBanco = adicionarEspacosNumero($agenciaJuntoComBanco, 10);
        $nomeConjuge = adicionarEspacos($nomeConjuge, 60);
        $rg = adicionarEspacosNumero($rg, 12);
        $cpf = adicionarEspacosNumero($cpf, 11);
        $pis = adicionarEspacosNumero($pis, 11);
        $tituloEleitor = adicionarEspacosNumero($tituloEleitor, 13);
        $secaoTituloEleitor = adicionarEspacos($secaoTituloEleitor, 4);
        $zonaTituloEleitor = adicionarEspacos($zonaTituloEleitor, 3);
        $estado = adicionarEspacos($estado, 2);
        $nacionalidade = adicionarEspacos($nacionalidade, 2);
        $dataChegadaBrasil = adicionarEspacos($dataChegadaBrasil, 8);
        $carteiraTrabalho = adicionarEspacosNumero($carteiraTrabalho, 8); //CTPS
        $carteiraTrabalhoSerie = adicionarEspacos($carteiraTrabalhoSerie, 5);
        $digitoSerieCTPS = adicionarEspacos($digitoSerieCTPS, 1);
        $numeroDepIR = adicionarEspacos($numeroDepIR, 2);
        $numeroDepSF = adicionarEspacos($numeroDepSF, 2);
        $centroCusto = adicionarEspacosNumero($centroCusto, 10);
        $departamento = adicionarEspacosNumero($departamento, 10);
        $dataNascimento = adicionarEspacos($dataNascimento, 8);
        $dataAdmissao = adicionarEspacos($dataAdmissao, 8);
        $naturezaOcupacao = adicionarEspacos($naturezaOcupacao, 1);
        $contaFgts = adicionarEspacos($contaFgts, 6);
        $sindicato = adicionarEspacosNumero($sindicato, 3);
        $formaPagamento = adicionarEspacos($formaPagamento, 10);
        $tipoPagamento = adicionarEspacos($tipoPagamento, 10);
        $horasMensais = adicionarEspacosNumero($horasMensais, 3);
        $horasSemanais = adicionarEspacosNumero($horasSemanais, 2);
        $horasDiarias = adicionarZeros($horasDiarias, 6);
        $salarioBase = adicionarEspacosNumero($salarioBase, 10);
        $quantidadeDiasExperiencia = adicionarEspacosNumero($quantidadeDiasExperiencia, 2);
        $quantidadeDiasProrrogacao = adicionarEspacosNumero($quantidadeDiasProrrogacao, 2);
        $cbo = adicionarEspacosNumero($cbo, 6);
        $cargo = adicionarEspacosNumero($cargo, 5);
        $primeiroEmprego = adicionarEspacosNumero($primeiroEmprego, 2);
        $vinculoEmpregaticio = adicionarEspacosNumero($vinculoEmpregaticio, 2);
        $nomePai = adicionarEspacos($nomePai, 70);
        $nomeMae = adicionarEspacos($nomeMae, 70);
        $nomeSocial = adicionarEspacos($nomeSocial, 70);
        $paisNascimento = adicionarEspacosNumero($paisNascimento, 4);
        $codigoMunicipioNascimento = adicionarEspacosNumero($codigoMunicipioNascimento, 7);
        $naturalidade = adicionarEspacos($naturalidade, 2);
        $cep = adicionarEspacosNumero($cep, 9);
        $logradouro = adicionarEspacos($logradouro, 3);
        $racaCor = adicionarEspacosNumero($racaCor, 1);
        $indicativoAdmissao = adicionarEspacosNumero($indicativoAdmissao, 1);
        $tipoContrato = adicionarEspacosNumero($tipoContrato, 1);
        $dataFinal = adicionarEspacosNumero($dataFinal, 8);
        $dataEmissaoRg = adicionarEspacosNumero($dataEmissaoRg, 8);
        $emissorRg = adicionarEspacos($emissorRg, 20);
        $localRg = adicionarEspacosNumero($localRg, 2);
        $cnh = adicionarEspacosNumero($cnh, 11);
        $categoriaCnh = adicionarEspacosNumero($categoriaCnh, 2);
        $ufCnh = adicionarEspacos($ufCnh, 2);
        $dataEmissaoCnh = adicionarEspacosNumero($dataEmissaoCnh, 8);
        $dataVencimentoCnh = adicionarEspacosNumero($dataVencimentoCnh, 8);
        $primeiraCnh = adicionarEspacosNumero($primeiraCnh, 8);
        $municipioNascimentoConjuge = adicionarEspacosNumero($municipioNascimentoConjuge, 7);
        $fgtsGpsCategoriaSefip = adicionarEspacosNumero($fgtsGpsCategoriaSefip, 2);
        $ufNascimentoConjuge = adicionarEspacos($ufNascimentoConjuge, 2);
        $dataNascimentoConjuge = adicionarEspacosNumero($dataNascimentoConjuge, 8);
        $fgtsGpsCategoriaESocial = adicionarEspacosNumero($fgtsGpsCategoriaESocial, 3);
        $contaCorrente = adicionarEspacosNumero($contaCorrente, 12);
        $digitoContaBanco = adicionarEspacosNumero($digitoContaBanco, 2);
        $tipoConta = adicionarEspacosNumero($tipoConta, 1);
        $modoPagamento = adicionarEspacosNumero($modoPagamento, 1);
        $regimeJornadaTrabalho = adicionarEspacosNumero($regimeJornadaTrabalho, 1);
        $tipoEscala = adicionarEspacosNumero($tipoEscala, 1);
        $escalaHorario = adicionarEspacos($escalaHorario, 10);
        $descansoSemanal = adicionarEspacosNumero($descansoSemanal, 1);
        $tipoJornadaESocial = adicionarEspacosNumero($tipoJornadaESocial, 4);
        $dataExpedicaoCarteiraTrabalho = adicionarEspacosNumero($dataExpedicaoCarteiraTrabalho, 8);
        $dataEmissaoPis = adicionarEspacosNumero($dataEmissaoPis, 8);
        $dataInicioRevezamento = adicionarEspacosNumero($dataInicioRevezamento, 8);
        $tipoRevezamento = adicionarEspacosNumero($tipoRevezamento, 5);

        $mensagem =
            $nomeCompleto .
            $matricula .
            $classe .
            $endereco .
            $numeroEndereco .
            $bairro .
            $complemento .
            $cidade .
            $uf .
            $sexo .
            $estadoCivil .
            $grauInstrucao .
            $telefoneResidencial .
            $telefoneCelular .
            $email .
            $agenciaJuntoComBanco .
            $nomeConjuge .
            $rg .
            $cpf .
            $pis .
            $tituloEleitor .
            $secaoTituloEleitor .
            $zonaTituloEleitor .
            $municipioNascimento .
            $ufNascimento .
            $nacionalidade .
            $dataChegadaBrasil .
            $carteiraTrabalho .
            $carteiraTrabalhoSerie .
            $digitoSerieCTPS .
            $numeroDepIR .
            $numeroDepSF .
            $centroCusto .
            $departamento .
            $dataNascimento .
            $dataAdmissao .
            $naturezaOcupacao .
            $contaFgts .
            $sindicato .
            $formaPagamento .
            $tipoPagamento .
            $horasMensais .
            $horasSemanais .
            $horasDiarias .
            $salarioBase .
            $quantidadeDiasExperiencia .
            $quantidadeDiasProrrogacao .
            $cbo .
            $cargo .
            $primeiroEmprego .
            $vinculoEmpregaticio .
            $nomePai .
            $nomeMae .
            $dddTelefoneResidencial .
            $dddTelefoneCelular .
            $nomeSocial .
            $paisNascimento .
            $codigoMunicipioNascimento .
            $naturalidade .
            $cep .
            $logradouro .
            $racaCor .
            $indicativoAdmissao .
            $tipoContrato .
            $dataFinal .
            $dataEmissaoRg .
            $emissorRg .
            $localRg .
            $cnh .
            $categoriaCnh .
            $ufCnh .
            $dataEmissaoCnh .
            $dataVencimentoCnh .
            $primeiraCnh .
            $municipioNascimentoConjuge .
            $ufNascimentoConjuge .
            $dataNascimentoConjuge .
            $fgtsGpsCategoriaSefip .
            $fgtsGpsCategoriaESocial .
            $contaCorrente .
            $digitoContaBanco .
            $tipoConta .
            $modoPagamento .
            $regimeJornadaTrabalho .
            $tipoEscala .
            $escalaHorario .
            $descansoSemanal .
            $tipoJornadaESocial .
            $dataEmissaoPis .
            $dataExpedicaoCarteiraTrabalho .
            $dataInicioRevezamento .
            $tipoRevezamento .
            "\n";


        fwrite($handler, $mensagem); //Cria o txt. 

    }

    fclose($handler);

    $nomeXml =  "arrayCandidatosExportacao";
    $nomeTabela = "candidato";
    if (sizeof($arrayCandidatosExportacao) > 0) {
        $xmlCandidatosExportacao = '<?xml version="1.0"?>';
        $xmlCandidatosExportacao = $xmlCandidatosExportacao . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCandidatosExportacao as $chave) {
            $xmlCandidatosExportacao = $xmlCandidatosExportacao . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                $xmlCandidatosExportacao = $xmlCandidatosExportacao . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCandidatosExportacao = $xmlCandidatosExportacao . "</" . $nomeTabela . ">";
        }
        $xmlCandidatosExportacao = $xmlCandidatosExportacao . "</" . $nomeXml . ">";
    } else {
        $xmlCandidatosExportacao = '<?xml version="1.0"?>';
        $xmlCandidatosExportacao = $xmlCandidatosExportacao . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCandidatosExportacao = $xmlCandidatosExportacao . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCandidatosExportacao);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de certidões de nascimento ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCandidatosExportacao = "'" . $xmlCandidatosExportacao . "'";

    $sql = "Contratacao.exportacao_Atualiza(0,$xmlCandidatosExportacao)";
    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success';
    // if ($result < 1) {
    //     $ret = 'failed#';
    // }
    echo $ret . "^" . $nomeArquivo;
    return;
}



//ATENÇÃO, AS FUNÇÕES ABAIXO SÃO BASEADAS NO LAYOUT DO SCI.  FAVOR CONSULTAR O DOCUMENTO ORIGINAL ANTES DE ALTERAR.


// Retorna o valor F ou M dependendo do valor do banco.
function getSexo($sexo)
{
    switch ($sexo) {
        default:
            return "";
        case 0:
            return "F";
        case 1:
            return "M";
    }
}

function fixRegime($regimeJornadaTrabalho)
{
    switch ($regimeJornadaTrabalho) {
        default:
            return "";
        case 1:
            return 0;
        case 2:
            return 1;
        case 3:
            return 2;
        case 4:
            return 3;
    }
}

/*Arruma do valor de Estado Civil de acordo com o layout do SCI.
* 1- Casado | 2 - Solteiro | 3-Viúvo | 4-Separado | 5- União Estável | 6-Outros.
*/
function fixEstadoCivil($valor)
{
    switch ($valor) {
        default:
            return "";

        case 0: //Solteiro
            return 2;
        case 1: //Casado
            return 1;
        case 2: //Separado Judicialmente
            return 4;
        case 3: //Divorciado
            return 6;
        case 4: //Viúvo 
            return 3;
        case 5: //União Estável
            return 5;
    }
}



function verificaDatetime($data) //Apenas datetime. 
{

    if ((empty($data)) || (!isset($data)) || (is_null($data))) {
        return "";
    } else if (strpos($data, '/')) {
        $data = explode("/", $data);
        $data = $data[2] . '-' . $data[1] . '-' . $data[0];
        return $data;
    } else {
        $data = explode(" ", $data);
        $data = $data[0];
        return $data;
    }
}

/* Função que adiciona espaços
* de acordo com a variável do
* banco de dados e o tamanho
* do layout do SCI.
*/
function adicionarEspacos($campo, $tamanhoMaximo)
{
    if (mb_strlen($campo) > $tamanhoMaximo) {
        $campo = mb_substr($campo, 0, $tamanhoMaximo);
    } else {
        while (mb_strlen($campo) < $tamanhoMaximo) {


            $campo .= " ";
        }
    }

    return $campo;
}

function adicionarEspacosNumero($campo, $tamanhoMaximo)
{
    if (mb_strlen($campo) > $tamanhoMaximo) {
        $campo = mb_substr($campo, 0, $tamanhoMaximo);
    } else {
        while (mb_strlen($campo) < $tamanhoMaximo) {

            $campo = " " . $campo;
        }
    }

    return $campo;
}

function adicionarZeros($campo, $tamanhoMaximo)
{
    if (mb_strlen($campo) > $tamanhoMaximo) {
        $campo = mb_substr($campo, 0, $tamanhoMaximo);
    } else {
        while (mb_strlen($campo) < $tamanhoMaximo) {

            $valorFinal = mb_strlen($campo);
            $valorRepetir = $campo[$valorFinal - 1];

            $campo .= $valorRepetir;
        }
    }

    return $campo;
}

function limparCaracteres($string)
{
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    $string = str_replace('-', '', $string);
    return $string;
}


function conectarIbge($uf, $municipio)
{

    //Criando uma instância CURL  + Variáveis. 
    $curl = curl_init();
    $municipio = intval($municipio);
    $informacoesIbge = [];
    $nomeMunicipio = "";
    $siglaUf = "";

    //Setar as opções CURL
    /* Retorna a sigla da unidade federativa de acordo
    *  com o id de uf e municipio disponibilizados pelo IBGE.  
    */
    if ($uf != " ") {
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" . $uf,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        //Executa um requerimento HTTP:
        $resposta = curl_exec($curl);
        $resposta = json_decode($resposta, true);
        $erro = curl_error($curl);

        if ($erro == "") {
            $siglaUf = $resposta['sigla'];
        }
    }

    if (($uf != "") && ($municipio != "")) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" . $uf . "/municipios/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $resposta = curl_exec($curl);
        $resposta = json_decode($resposta, true);
        $erro = curl_error($curl);
        if ($erro == "") {
            foreach ($resposta as $key => $value) {
                if ($value['id'] == $municipio) {
                    $nomeMunicipio = $value['nome'];
                }
            }
        }
    }

    //Cria-se um array com as informações do IBGE
    array_push($informacoesIbge, $siglaUf);
    array_push($informacoesIbge, $nomeMunicipio);
    return $informacoesIbge;

    //Fecha o curl
    curl_close($curl);
}

function fixHorasDiarias($campo)
{


    $valorDoPrimeiroCaractere = $campo[0];

    if ($valorDoPrimeiroCaractere == '0') {
        $campo[0] = str_replace('0', ' ', $campo[0]);
        return $campo;
    } else {
        return $campo;
    }
}

function fixTipoConta($tipoConta)
{
    switch ($tipoConta) {
        case 1:
            return $tipoConta = 0;
        case 2:
            return $tipoConta = 1;
        default:
            return $tipoConta = "";
    }
}

function fixLogradouro($logradouro)
{

    $logradouro = tiraAcento($logradouro);
    $logradouro = strtoupper($logradouro);

    switch ($logradouro) {
        case 'RUA':
            return $logradouro = 1;
        case 'AVENIDA':
            return $logradouro = 2;
        case 'ALAMEDA':
            return $logradouro = 3;
        case 'PRAIA':
            return $logradouro = 4;
        case 'RODOVIA':
            return $logradouro = 5;
        case 'CONDOMINIO':
            return $logradouro = 6;
        case 'CONJUNTO':
            return $logradouro = 7;
        case 'ESTRADA':
            return $logradouro = 8;
        case 'LOTE':
            return $logradouro = 9;
        case 'LOTEAMENTO':
            return $logradouro = 10;
        case 'RESIDENCIAL':
            return $logradouro = 11;
        case 'RUELA':
            return $logradouro = 12;
        case 'SEGUNDA AVENIDA':
            return $logradouro = 13;
        case 'SERVIDÃO':
            return $logradouro = 14;
        case 'VIELA':
            return $logradouro = 15;
        case 'ACAMPAMENTO':
            return $logradouro = 16;
        case 'ACESSO':
            return $logradouro = 17;
        case 'ACESSO LOCAL':
            return $logradouro = 18;
        case 'ADRO':
            return $logradouro = 19;
        case 'AEROPORTO':
            return $logradouro = 20;
        case 'AGRUPAMENTO':
            return $logradouro = 21;
        case 'ALTO':
            return $logradouro = 22;
        case 'ANEL AVIÁRIO':
            return $logradouro = 23;
        case 'ANTIGA ESTRADA':
            return $logradouro = 24;
        case 'ÁREA':
            return $logradouro = 25;
        case 'ÁREA ESPECIAL':
            return $logradouro = 26;
        case 'ÁREA VERDE':
            return $logradouro = 27;
        case 'ARTÉRIA':
            return $logradouro = 28;
        case 'ATALHO':
            return $logradouro = 29;
        case 'AVENIDA MARGINAL DIREITA':
            return $logradouro = 30;
        case 'AVENIDA MARGINAL ESQUERDA':
            return $logradouro = 31;
        case 'AVENIDA CONTORNO':
            return $logradouro = 32;
        case 'AVENIDA MARGINAL':
            return $logradouro = 33;
        case 'AVENIDA VELHA':
            return $logradouro = 34;
        case 'BAIXA':
            return $logradouro = 35;
        case 'BALÃO':
            return $logradouro = 36;
        case 'BALNEÁRIO':
            return $logradouro = 37;
        case 'BECO':
            return $logradouro = 38;
        case 'BELVEDERE':
            return $logradouro = 39;
        case 'BLOCO':
            return $logradouro = 40;
        case 'BOSQUE':
            return $logradouro = 41;
        case 'BOULEVARD':
            return $logradouro = 42;
        case 'BR':
            return $logradouro = 43;
        case 'BURACO':
            return $logradouro = 44;
        case 'CAIS':
            return $logradouro = 45;
        case 'CALÇADA':
            return $logradouro = 46;
        case 'CAMINHO':
            return $logradouro = 47;
        case 'CAMPO':
            return $logradouro = 48;
        case 'CANAL':
            return $logradouro = 49;
        case 'CHÁCARA':
            return $logradouro = 50;
        case 'CHAPADÃO':
            return $logradouro = 51;
        case 'CICLOVIA':
            return $logradouro = 52;
        case 'CIRCULAR':
            return $logradouro = 53;
        case 'COLÔNIA':
            return $logradouro = 54;
        case 'COMPLEXO VIÁRIO':
            return $logradouro = 55;
        case 'COMUNIDADE':
            return $logradouro = 56;
        case 'CONJUNTO MULTI':
            return $logradouro = 57;
        case 'CONTORNO':
            return $logradouro = 58;
        case 'CORREDOR':
            return $logradouro = 59;
        case 'CÁRREGO':
            return $logradouro = 60;
        case 'DESCIDA':
            return $logradouro = 61;
        case 'DESVIO':
            return $logradouro = 62;
        case 'DISTRITO':
            return $logradouro = 63;
        case 'EIXO INDUSTRIAL':
            return $logradouro = 64;
        case 'ELEVADA':
            return $logradouro = 65;
        case 'ENSEADA':
            return $logradouro = 66;
        case 'ENTRE BLOCO':
            return $logradouro = 67;
        case 'ENTRE QUADRA':
            return $logradouro = 68;
        case 'ESCADA':
            return $logradouro = 69;
        case 'ESCADARIA':
            return $logradouro = 70;
        case 'ESPLANADA':
            return $logradouro = 71;
        case 'ESTAÇÃO':
            return $logradouro = 72;
        case 'ESTACIONAMENTO':
            return $logradouro = 73;
        case 'ESTÁDIO':
            return $logradouro = 74;
        case 'ESTÂNCIA':
            return $logradouro = 75;
        case 'ESTRADA ANTIGA':
            return $logradouro = 76;
        case 'ESTRADA ESTADUAL':
            return $logradouro = 77;
        case 'ESTRADA INTERMEDIÁRIA':
            return $logradouro = 78;
        case 'ESTRADA LIGAÇÃO':
            return $logradouro = 79;
        case 'ESTRADA MUNICIPAL':
            return $logradouro = 80;
        case 'ESTRADA PARTICULAR':
            return $logradouro = 81;
        case 'ESTRADA SERVIDÃO':
            return $logradouro = 82;
        case 'ESTRADA VELHA':
            return $logradouro = 83;
        case 'ESTRADA VICINAL':
            return $logradouro = 84;
        case 'EVANGÉLICA':
            return $logradouro = 85;
        case 'FAVELA':
            return $logradouro = 86;
        case 'FAZENDA':
            return $logradouro = 87;
        case 'FEIRA':
            return $logradouro = 88;
        case 'FERROVIA':
            return $logradouro = 89;
        case 'FONTE':
            return $logradouro = 90;
        case 'FORTE':
            return $logradouro = 91;
        case 'GALERIA':
            return $logradouro = 92;
        case 'GRANJA':
            return $logradouro = 93;
        case 'ILHA':
            return $logradouro = 94;
        case 'ILHOTA':
            return $logradouro = 95;
        case 'INDETERMINADO':
            return $logradouro = 96;
        case 'JARDIM':
            return $logradouro = 97;
        case 'JARDINETE':
            return $logradouro = 98;
        case 'LADEIRA':
            return $logradouro = 99;
        case 'LAGO':
            return $logradouro = 100;
        case 'LAGOA':
            return $logradouro = 101;
        case 'LARGO':
            return $logradouro = 102;
        case 'MARGEM':
            return $logradouro = 103;
        case 'MARINA':
            return $logradouro = 104;
        case 'MERCADO':
            return $logradouro = 105;
        case 'MÓDULO':
            return $logradouro = 106;
        case 'MONTE':
            return $logradouro = 107;
        case 'MORRO':
            return $logradouro = 108;
        case 'NÚCLEO':
            return $logradouro = 109;
        case 'NÚCLEO HABITACIONAL':
            return $logradouro = 110;
        case 'NÚCLEO RURAL':
            return $logradouro = 111;
        case 'OUTEIRO':
            return $logradouro = 112;
        case 'OUTROS':
            return $logradouro = 113;
        case 'PARADA':
            return $logradouro = 114;
        case 'PARADOURO':
            return $logradouro = 115;
        case 'PARALELA':
            return $logradouro = 116;
        case 'PARQUE':
            return $logradouro = 117;
        case 'PARQUE MUNICIPAL':
            return $logradouro = 118;
        case 'PARQUE RESIDENCIAL':
            return $logradouro = 119;
        case 'PASSAGEM':
            return $logradouro = 120;
        case 'PASSAGEM DE PEDESTRE':
            return $logradouro = 121;
        case 'PASSAGEM SUBTERRÂNIA':
            return $logradouro = 122;
        case 'PASSARELA':
            return $logradouro = 123;
        case 'PASSEIO':
            return $logradouro = 124;
        case 'PÁTIO':
            return $logradouro = 125;
        case 'PONTA':
            return $logradouro = 126;
        case 'PONTE':
            return $logradouro = 127;
        case 'PORTO':
            return $logradouro = 128;
        case 'PRAÇA ESPORTES':
            return $logradouro = 129;
        case 'PRAIA':
            return $logradouro = 130;
        case 'PROJEÇÃO':
            return $logradouro = 131;
        case 'PROLONGAMENTO':
            return $logradouro = 132;
        case 'QUADRA':
            return $logradouro = 133;
        case 'QUINTA':
            return $logradouro = 134;
        case 'RAMAL':
            return $logradouro = 135;
        case 'RAMPA':
            return $logradouro = 136;
        case 'RECANTO':
            return $logradouro = 137;
        case 'RECREIO':
            return $logradouro = 138;
        case 'RETA':
            return $logradouro = 139;
        case 'RETIRO':
            return $logradouro = 140;
        case 'RETORNO':
            return $logradouro = 141;
        case 'RIO':
            return $logradouro = 142;
        case 'RODO ANEL':
            return $logradouro = 143;
        case 'ROTATÓRIA':
            return $logradouro = 144;
        case 'RÓTULA':
            return $logradouro = 145;
        case 'RUA DE LIGAÇÃO':
            return $logradouro = 146;
        case 'RUA DE PEDESTRE':
            return $logradouro = 147;
        case 'RUA INTEGRAÇÃO':
            return $logradouro = 148;
        case 'RUA PARTICULAR':
            return $logradouro = 149;
        case 'RUA VELHA':
            return $logradouro = 150;
        case 'SETOR':
            return $logradouro = 151;
        case 'SÍTIO':
            return $logradouro = 152;
        case 'SUBIDA':
            return $logradouro = 153;
        case 'SUPER QUADRA':
            return $logradouro = 154;
        case 'TERMINAL':
            return $logradouro = 155;
        case 'TRAVESSA':
            return $logradouro = 156;
        case 'TRAVESSA PARTICULAR':
            return $logradouro = 157;
        case 'TRAVESSA VELHA':
            return $logradouro = 158;
        case 'TRECHO':
            return $logradouro = 159;
        case 'TREVO':
            return $logradouro = 160;
        case 'TRINCHEIRA':
            return $logradouro = 161;
        case 'TÚNEL':
            return $logradouro = 162;
        case 'UNIDADE':
            return $logradouro = 163;
        case 'VALA':
            return $logradouro = 164;
        case 'VALE':
            return $logradouro = 165;
        case 'VARGEM':
            return $logradouro = 166;
        case 'VARIANTE':
            return $logradouro = 167;
        case 'VEREDA':
            return $logradouro = 168;
        case 'VIA':
            return $logradouro = 169;
        case 'VIA COLETORA':
            return $logradouro = 170;
        case 'VIA COSTEIRA':
            return $logradouro = 171;
        case 'VIA DE ACESSO':
            return $logradouro = 172;
        case 'VIA DE PEDESTRE':
            return $logradouro = 173;
        case 'VIA ELEVADA':
            return $logradouro = 174;
        case 'VIA EXPRESSA':
            return $logradouro = 175;
        case 'VIA LITORÂNEA':
            return $logradouro = 176;
        case 'VIA LOCAL':
            return $logradouro = 177;
        case 'VIADUTO':
            return $logradouro = 178;
        case 'VILA':
            return $logradouro = 179;
        case 'ZIGUE-ZAGUE':
            return $logradouro = 180;
        default:
            return $logradouro = "";
    }
}

function fixRacaCor($racaCor)
{

    /* Código do SCI: 
    * AMARELA = 0, BRANCA = 1, INDIGENA = 2, PARDA=3, NEGRO =4 */
    switch ($racaCor) {
        case 0:  //Amarela
            return $racaCor = 0;
        case 1: //Branca
            return $racaCor = 1;
        case 2: //Parda
            return $racaCor = 3;
        case 3: //Indigena
            return $racaCor = 2;
        case 4: //Negro
            return $racaCor = 4;
        default:
            return $racaCor = "";
    }
}

function fixIndicativoAdmissao($indicativoAdmissao)
{
    /*Código: 
    * Normal = 0, Decorrente de Ação Fiscal = 1, Decorrente de Decisão Judicial = 2 */
    switch ($indicativoAdmissao) {
        case 1:
            return $indicativoAdmissao = 0;
        case 2:
            return $indicativoAdmissao = 1;
        case 3:
            return $indicativoAdmissao = 2;
        default:
            return $indicativoAdmissao = "";
    }
}

function fixTipoContrato($tipoContrato)
{
    switch ($tipoContrato) {
        case 1:
            return $tipoContrato = 0;
        case 2:
            return $tipoContrato = 1;
        case 3:
            return $tipoContrato = 2;
        case 4:
            return $tipoContrato = 3;
        case 5:
            return $tipoContrato = 4;
        default:
            return $tipoContrato = "";
    }
}

function fixFormaPagamento($formaPagamento)
{
    switch ($formaPagamento) {
        case 1:
            return $formaPagamento = "Mensal";
        case 2:
            return $formaPagamento = "Quinzenal";
        case 3:
            return $formaPagamento = "Diário";
        case 4:
            return $formaPagamento = "Semanal";
        default:
            return $formaPagamento = "";
    }
}

function fixTipoEscala($tipoEscala)
{
    switch ($tipoEscala) {
        case 1:
            return $formaPagamento = 0;
        case 2:
            return $formaPagamento = 1;
        case 3:
            return $formaPagamento = 2;
        default:
            return $formaPagamento = "";
    }
}

function fixTipoPagamento($tipoPagamento)
{
    switch ($tipoPagamento) {
        case 1:
            return $tipoPagamento = "Mensalista";
        case 2:
            return $tipoPagamento = "Diarista";
        case 3:
            return $tipoPagamento = "Horista";
        case 4:
            return $tipoPagamento = "Comissionado";
        case 5:
            return $tipoPagamento = "Horista Especial";
        case 5:
            return $tipoPagamento = "Tarefeiro";
        default:
            return $tipoPagamento = "";
    }
}

function fixHoras($campo)
{
    $pedacos = explode(":", $campo);
    $campo = $pedacos[0] . $pedacos[1];
    return $campo;
}

function fixSefip($fgtsGpsCategoriaSefip)
{
    switch ($fgtsGpsCategoriaSefip) {
        case 1:
            return $fgtsGpsCategoriaSefip = "1";
        case 2:
            return $fgtsGpsCategoriaSefip = "2";
        case 3:
            return $fgtsGpsCategoriaSefip = "3";
        case 4:
            return $fgtsGpsCategoriaSefip = "4";
        case 5:
            return $fgtsGpsCategoriaSefip = "5";
        case 6:
            return $fgtsGpsCategoriaSefip = "7";
        case 7:
            return $fgtsGpsCategoriaSefip = "11";
        case 8:
            return $fgtsGpsCategoriaSefip = "12";
        case 9:
            return $fgtsGpsCategoriaSefip = "13";
        case 10:
            return $fgtsGpsCategoriaSefip = "14";
        default:
            return $fgtsGpsCategoriaSefip = "";
    }
}

function gravarLogExportacao($candidato, $nomeTxtGerado)
{

    session_start();
    $usuario = $_SESSION['login'];
    $out = consultaLogExportacao($candidato);
    $out = explode("^", $out);
    $codigo = (int) $out[0];
    $situacao = (int) $out[1];
    $usuario = "'" . $usuario . "'";
    $nomeTxtGerado = "'" . $nomeTxtGerado . "'";


    $sql = "Contratacao.logExportacao_Atualiza(
        $codigo, 
        $candidato,
        $nomeTxtGerado, 
        $situacao,
        $usuario
        )";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);
    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed';
    }

    return $ret;
}

function consultaLogExportacao($candidato)
{
    $reposit = new reposit();
    $sql = " SELECT codigo, situacao FROM Contratacao.exportacao WHERE candidato = " . $candidato;
    $result = $reposit->RunQuery($sql);
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);
    $codigo = $row['codigo'];
    $situacao = $row['situacao'];

    if (is_null($codigo)) {
        $codigo = 0;
    }

    if (is_null($situacao)) {
        $situacao = 0;
    }

    $out = $codigo . "^" . $situacao;
    return $out;
}

function tiraAcento($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
}
