<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaFuncionario') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaFuncionario') {
    call_user_func($funcao);
}
 
if ($funcao == 'recuperaUpload') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}
   
if ($funcao == 'recuperaCpf') {
    call_user_func($funcao);
}

return;

function gravaFuncionario()
{

    session_start();
    $usuarioCadastro = validaString($_SESSION['login']);
    $codigo =  (int) $_POST['codigo'];
    $sexo = validaNumero($_POST['sexo']);
    $nomeCompleto = validaString($_POST['nomeCompleto']);
    $nomeCompleto = strtoupper(tiraAcento($nomeCompleto));

    $cpf = validaString($_POST['cpf']);
    $dataNascimento = validaData($_POST['dataNascimento']);
    $naturalidade = validaString($_POST['naturalidade']);
    $nacionalidade = validaString($_POST['nacionalidade']);
    $racaCor = validaNumero($_POST['racaCor']);
    $estadoCivil = validaNumero($_POST['estadoCivil']);
    $nomePai = validaString($_POST['nomePai']);
    $nomePai = strtoupper(tiraAcento($nomePai));
    $nomeMae = validaString($_POST['nomeMae']);
    $nomeMae = strtoupper(tiraAcento($nomeMae));
    $ctps = validaNumero($_POST['ctps']);
    $localCarteiraTrabalho = validaString($_POST['localCarteiraTrabalho']);
    $pis = validaString($_POST['pis']);
    $dataEmissaoCnh = validaData($_POST['dataEmissaoCnh']);
    $dataVencimentoCnh = validaData($_POST['dataVencimentoCnh']);
    $primeiraCnh = validaString($_POST['primeiraCnh']);

    $cnh = validaString($_POST['cnh']);
    $categoriaCnh = validaString($_POST['categoriaCnh']);
    $ufCnh = validaString($_POST['ufCnh']);

    $tituloEleitor = validaString($_POST['tituloEleitor']);
    $zonaTituloEleitor = validaString($_POST['zonaTituloEleitor']);
    $secaoTituloEleitor = validaString($_POST['secaoTituloEleitor']);
    $certificadoReservista = validaString($_POST['certificadoReservista']);
    $telefoneResidencial = validaString($_POST['telefoneResidencial']);
    $telefoneCelular = validaString($_POST['telefoneCelular']);
    $outroTelefone = validaString($_POST['outroTelefone']);
    $email = validaString($_POST['email']);
    $cep = validaString($_POST['cep']);
    $endereco = validaString($_POST['endereco']);
    $bairro = validaString($_POST['bairro']);
    $numero = validaString($_POST['numero']);
    $complemento = validaString($_POST['complemento']);
    $estado = validaNumero($_POST['estado']);
    $cidade = validaString($_POST['cidade']);
    $grauInstrucao = validaNumero($_POST['grauInstrucao']);
    $grauParou = validaString($_POST['grauParou']);
    $anoConclusao = validaString($_POST['anoConclusao']);
    $cursandoAtualmente = validaString($_POST['cursandoAtualmente']);
    $horarioEstudo = validaString($_POST['horarioEstudo']);
    $nomeEnderecoColegioUniversidade = validaString($_POST['nomeEnderecoColegioUniversidade']);
    $atividadesExtracurriculares = validaString($_POST['atividadesExtracurriculares']);
    $nomeConjuge               = validaString($_POST['nomeConjuge']);
    $naturalidadeConjuge       = validaString($_POST['naturalidadeConjuge']);
    $nacionalidadeConjuge      = validaString($_POST['nacionalidadeConjuge']);
    $dataNascimentoConjuge     = validaData($_POST['dataNascimentoConjuge']);
    $trabalhaAtualmente  = validaString($_POST['trabalhaAtualmente']);
    $desejaVt = validaNumero($_POST['desejaVt']);
    $possuiVt = validaNumero($_POST['possuiVt']);
    $numeroCartaoVt = validaString($_POST['numeroCartaoVt']);
    $seguroDesemprego    = validaNumero($_POST['seguroDesemprego']);
    $desejaAssistenciaMedica  = validaNumero($_POST['desejaAssistenciaMedica']);
    $desejaAssistenciaOdontologica  = validaNumero($_POST['desejaAssistenciaOdontologica']);
    $valeRefeicaoValeAlimentacao  = validaNumero($_POST['valeRefeicaoValeAlimentacao']);
    $possuiContaBancaria  = validaString($_POST['possuiContaBancaria']);
    $fk_banco  = validaString($_POST['fk_banco']);
    $agenciaBanco  = validaString($_POST['agenciaBanco']);
    $contaCorrente  = validaString($_POST['contaCorrente']);
    $numeroCamisa  = validaString($_POST['numeroCamisa']);
    $numeroCalca   = validaString($_POST['numeroCalca']);
    $numeroSaia  = validaString($_POST['numeroSaia']);
    $numeroSapato  = validaString($_POST['numeroSapato']);

    $rg  = validaString($_POST['rg']);
    $emissorRg   = validaString($_POST['emissorRg']);
    $localRg  = validaString($_POST['localRg']);
    $dataEmissaoRg  = validaData($_POST['dataEmissaoRg']);
    $primeiroEmprego = validaNumero($_POST['primeiroEmprego']);
    $cargo = validaString($_POST['cargo']);
    //verificacao de dados preenchidos corretamente pelo candidato
    $verificaDadoPessoal = (int) $_POST['verificaDadoPessoal'];
    $verificaDadoContato = (int) ['verificaDadoContato'];
    $verificaEndereco =  (int) $_POST['verificaEndereco'];
    $verificaDocumento =  (int) $_POST['verificaDocumento'];
    $verificaEscolaridade =  (int) $_POST['verificaEscolaridade'];
    $verificaDadoConjuge =  (int) $_POST['verificaDadoConjuge'];
    $verificaFilho =  (int) $_POST['verificaFilho'];
    $verificaDependente =  (int) $_POST['verificaDependente'];
    $verificaBeneficio =  (int) $_POST['verificaBeneficio'];
    $verificaVT =  (int) $_POST['verificaVT'];
    $verificaDadoBancario =  (int) $_POST['verificaDadoBancario'];
    $verificaCargo =  (int) $_POST['verificaCargo'];
    $verificaUniforme =  (int) $_POST['verificaUniforme'];
    $verificaAnexoDocumento =  (int) $_POST['verificaAnexoDocumento'];

    $carteiraTrabalho = validaString($_POST['carteiraTrabalho']);
    $carteiraTrabalhoSerie = validaString($_POST['carteiraTrabalhoSerie']);
    $dataExpedicaoCarteiraTrabalho = validaData($_POST['dataExpedicaoCarteiraTrabalho']);
    $numeroPais = validaNumero($_POST['numeroPais']);
    $paisNascimento = validaString($_POST['paisNascimento']);
    $ufNascimento = validaString($_POST['ufNascimento']);
    $numeroMunicipio = validaString($_POST['numeroMunicipio']);
    $municipioNascimento = validaString($_POST['municipioNascimento']);

    $numeroPaisConjuge = validaNumero($_POST['numeroPaisConjuge']);
    $paisNascimentoConjuge = validaString($_POST['paisNascimentoConjuge']);
    $ufNascimentoConjuge = validaString($_POST['ufNascimentoConjuge']);
    $numeroMunicipioConjuge = validaString($_POST['numeroMunicipioConjuge']);
    $municipioNascimentoConjuge = validaString($_POST['municipioNascimentoConjuge']);
    $possuiFilhoMenor14 = validaNumero($_POST['possuiFilhoMenor14']);
    $digitoAgenciaBanco = validaNumero($_POST['digitoAgenciaBanco']);
    $digitoContaBanco = validaNumero($_POST['digitoContaBanco']);

    $tipoConta = validaNumero($_POST['tipoConta']);
    $aprovado = validaNumero($_POST['aprovado']);
    $variacao = validaString($_POST['variacao']);
    $projeto = validaString($_POST['projeto']);
    $logradouro = validaString($_POST['logradouro']);
    $ativo = 1;
    $justificativaVt = validaString($_POST['justificativaVt']);
    $tipoCartaoVt = +validaNumero($_POST['tipoCartaoVt']);



    //#######################################INICIO LISTA FILHO#################################//
    $strArrayFilho = $_POST['jsonFilho'];
    $arrayFilho = json_decode($strArrayFilho, true);
    $xmlFilho = "";
    $nomeXml = "ArrayOfCandidatoFilho";
    $nomeTabela = "candidatoFilho";
    if (sizeof($arrayFilho) > 0) {
        $xmlFilho = '<?xml version="1.0"?><' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayFilho as $chave) {
            $xmlFilho = $xmlFilho . "<$nomeTabela>";
            foreach ($chave as $campo => $valor) {
                if ($campo === "dataNascimentoFilho") {
                    if ($valor == "") {
                        $valor = 'NULL';
                        return $valor;
                    }
                    $valor = str_replace('/', '-', $valor);
                    $valor = date("Y-m-d", strtotime($valor));
                }
                $xmlFilho = $xmlFilho . "<$campo>$valor</$campo>";
            }
            $xmlFilho = $xmlFilho . "</$nomeTabela>";
        }
        $xmlFilho = $xmlFilho . "</$nomeXml>";
    } else {
        $xmlFilho = '<?xml version="1.0"?><' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlFilho = $xmlFilho . "</$nomeXml>";
    }
    $xml = simplexml_load_string($xmlFilho);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlFilho = "'" . $xmlFilho . "'";
    //####################################################### FIM LISTA FILHO ##########################################
    //#######################################INICIO LISTA DEPENDENTE#################################//
    $strArrayDependente = $_POST['jsonDependente'];
    $arrayDependente = json_decode($strArrayDependente, true);
    $xmlDependente = "";
    $nomeXml = "ArrayOfCandidatoDependente";
    $nomeTabela = "candidatoDependente";
    if (sizeof($arrayDependente) > 0) {
        $xmlDependente = '<?xml version="1.0"?><' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayDependente as $chave) {
            $xmlDependente = $xmlDependente . "<$nomeTabela>";
            foreach ($chave as $campo => $valor) {
                if ($campo === "dataNascimentoDependente") {
                    if ($valor == "") {
                        $valor = 'NULL';
                        return $valor;
                    }
                    $valor = str_replace('/', '-', $valor);
                    $valor = date("Y-m-d", strtotime($valor));
                }
                $xmlDependente = $xmlDependente . "<$campo>$valor</$campo>";
            }
            $xmlDependente = $xmlDependente . "</$nomeTabela>";
        }
        $xmlDependente = $xmlDependente . "</$nomeXml>";
    } else {
        $xmlDependente = '<?xml version="1.0"?><' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlDependente = $xmlDependente . "</$nomeXml>";
    }
    $xml = simplexml_load_string($xmlDependente);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlDependente = "'" . $xmlDependente . "'";
    //####################################################### FIM LISTA DEPENDENTE ##########################################


    //#######################################INICIO LISTA TRANSPORTE#################################//
    $strArrayTransporte = $_POST['jsonTransporte'];
    $arrayTransporte = json_decode($strArrayTransporte, true);
    $xmlTransporte = "";
    $nomeXml = "ArrayOfCandidatoTransporte";
    $nomeTabela = "candidatoTransporte";
    if (sizeof($arrayTransporte) > 0) {
        $xmlTransporte = '<?xml version="1.0"?><' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTransporte as $chave) {
            $xmlTransporte = $xmlTransporte . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                $xmlTransporte = $xmlTransporte . "<$campo>$valor</$campo>";
            }
            $xmlTransporte = $xmlTransporte . "</$nomeTabela>";
        }
        $xmlTransporte = $xmlTransporte . "</$nomeXml>";
    } else {
        $xmlTransporte = '<?xml version="1.0"?><' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTransporte = $xmlTransporte . "</$nomeXml>";
    }
    $xml = simplexml_load_string($xmlTransporte);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlTransporte = "'" . $xmlTransporte . "'";
    //####################################################### FIM LISTA TRANSPORTE ##########################################

    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'" . $usuario . "'";

    $datahoje = new DateTime();
    $datahoje = $datahoje->format('Y-m-d');
    $datahoje = "'" . $datahoje . "'";


    $diretorioPai = "../uploads/";
    $diretorioFilhoCertidaoNascimento = "../uploads/certidoes_de_nascimentos/";
    $diretorioFilhoCertidaoCasamento = "../uploads/certidoes_de_casamentos/";
    $diretorioFilhoComprovanteResidencia = "../uploads/comprovantes_de_residencias/";
    $diretorioFilhoCpf = "../uploads/cpfs/";
    $diretorioFilhoPispasep = "../uploads/pispaseps/";
    $diretorioFilhoRg = "../uploads/rgs/";
    $diretorioFilhoCnh = "../uploads/cnhs/";
    $diretorioFilhoTituloEleitor = "../uploads/titulos-de-eleitores/";
    $diretorioFilhoCertificadoReservista = "../uploads/certificados-de-reservistas/";
    $diretorioFilhoComprovanteEscolaridade = "../uploads/comprovantes-de-escolaridade/";
    $diretorioFilhoCertificadoDiploma = "../uploads/certificados-e-diplomas/";
    $diretorioFilhoCertidaoNascimentoFilho = "../uploads/certidoes-de-nascimento-dos-filhos/";
    $diretorioFilhoRgFilho =  "../uploads/rgs-dos-filhos/";
    $diretorioFilhoCpfFilho = "../uploads/cpf-dos-filhos/";
    $diretorioFilhoCertidaoNascimentoDependente = "../uploads/certidoes_de_nascimentos_dos_dependentes/";
    $diretorioFilhoRgDependente = "../uploads/rgs-dos-dependentes/";
    $diretorioFilhoCpfDependente =  "../uploads/cpfs-dos-dependentes/";
    $diretorioFilhoFotoCandidato = "../uploads/foto_candidatos/";
    $diretorioFilhoCarteiraVacinacaoFilho = "../uploads/carteira_de_vacinacao_filho/";

    //Verifica a existência de todos os diretorios.
    verificaDiretorio($diretorioPai);
    verificaDiretorio($diretorioFilhoCertidaoNascimento);
    verificaDiretorio($diretorioFilhoCertidaoCasamento);
    verificaDiretorio($diretorioFilhoComprovanteResidencia);
    verificaDiretorio($diretorioFilhoCpf);
    verificaDiretorio($diretorioFilhoPispasep);
    verificaDiretorio($diretorioFilhoRg);
    verificaDiretorio($diretorioFilhoCnh);
    verificaDiretorio($diretorioFilhoTituloEleitor);
    verificaDiretorio($diretorioFilhoCertificadoReservista);
    verificaDiretorio($diretorioFilhoComprovanteEscolaridade);
    verificaDiretorio($diretorioFilhoCertificadoDiploma);
    verificaDiretorio($diretorioFilhoCertidaoNascimentoFilho);
    verificaDiretorio($diretorioFilhoRgFilho);
    verificaDiretorio($diretorioFilhoCpfFilho);
    verificaDiretorio($diretorioFilhoCertidaoNascimentoDependente);
    verificaDiretorio($diretorioFilhoRgDependente);
    verificaDiretorio($diretorioFilhoCpfDependente);
    verificaDiretorio($diretorioFilhoFotoCandidato);
    verificaDiretorio($diretorioFilhoCarteiraVacinacaoFilho);

    // Aqui é definido quais tipos podem ser gravados no banco e na pasta
    $tipoArquivoPermitido = array(
        "pdf",
        "png",
        "jpg",
        "jpeg"
    );

    //Nome dos campos em html:
    $idCertidaoNascimento  = "certidaoNascimento";
    $idCertidaoCasamento = "certidaoCasamentoArquivo";
    $idComprovanteResidencia = "comprovanteResidenciaArquivo";
    $idCpf = "cpfArquivo";
    $idPispasep = "pispasepArquivo";
    $idRg = "rgArquivo";
    $idCnh = "cnhArquivo";
    $idTituloEleitor = "tituloEleitorArquivo";
    $idCertificadoReservista = "certificadoReservistaArquivo";
    $idComprovanteEscolaridade = "comprovanteEscolaridadeFile";
    $idCertificadoDiploma = "certificadoDiplomaFile";
    $idCertidaoNascimentoFilho = "certidaoNascimentoFilhoFile";
    $idRgFilho = "rgFilhoFile";
    $idCpfFilho = "cpfFilhoFile";
    $idCertidaoNascimentoDependente = "certidaoNascimentoDependenteFile";
    $idRgDependente = "rgDependenteFile";
    $idCpfDependente = "cpfDependenteFile";
    $idFotoCandidato = "fotoCandidato";
    $idCarteiraVacinacaoFilho = "carteiraVacinacaoFilhoFile";


    //Cria vários arrays baseados nos arquivos de upload.

    $certidaoNascimentoArray = $_FILES['certidaoNascimento'];
    $tamanho =  count($_FILES['certidaoNascimento']['name']);
    $uniqidCertidaoNascimento = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $certidaoNascimentoArray["name"][$i] = str_replace("-", "_", $certidaoNascimentoArray["name"][$i]); //Substitui qualquer traço por underline. 
        $certidaoNascimentoArray["name"][$i] = tiraAcento($certidaoNascimentoArray["name"][$i]);
        $arrayCertidaoNascimento[$i] = array(
            "nome" => $certidaoNascimentoArray["name"][$i],
            "tipo" => $certidaoNascimentoArray["type"][$i],
            "nomeTemporario" => $certidaoNascimentoArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/certidoes_de_nascimentos/",
            "idCampo" => $idCertidaoNascimento
        );
    }

    $certidaoCasamentoArray = $_FILES['certidaoCasamentoArquivo'];
    $tamanho =  count($_FILES['certidaoCasamentoArquivo']['name']);
    $uniqidCertidaoCasamento = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $certidaoCasamentoArray["name"][$i] = str_replace("-", "_", $certidaoCasamentoArray["name"][$i]);  //Substitui qualquer underline por traço. 
        $certidaoCasamentoArray["name"][$i] = tiraAcento($certidaoCasamentoArray["name"][$i]);
        $arrayCertidaoCasamento[$i] = array(
            "nome" => $certidaoCasamentoArray["name"][$i],
            "tipo" => $certidaoCasamentoArray["type"][$i],
            "nomeTemporario" => $certidaoCasamentoArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/certidoes_de_casamentos/",
            "idCampo" => $idCertidaoCasamento
        );
    }

    $comprovanteResidenciaArray = $_FILES['comprovanteResidenciaArquivo'];
    $tamanho =  count($_FILES['comprovanteResidenciaArquivo']['name']);
    $uniqidComprovanteResidencia = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $comprovanteResidenciaArray["name"][$i] = str_replace("-", "_", $comprovanteResidenciaArray["name"][$i]);  //Substitui qualquer traço por underline.
        $comprovanteResidenciaArray["name"][$i] = tiraAcento($comprovanteResidenciaArray["name"][$i]);
        $arrayComprovanteResidencia[$i] = array(
            "nome" => $comprovanteResidenciaArray["name"][$i],
            "tipo" => $comprovanteResidenciaArray["type"][$i],
            "nomeTemporario" => $comprovanteResidenciaArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/comprovantes_de_residencias/",
            "idCampo" => $idComprovanteResidencia
        );
    }

    $cpfArray = $_FILES['cpfArquivo'];
    $tamanho =  count($_FILES['cpfArquivo']['name']);
    $uniqidCpf = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $cpfArray["name"][$i] = str_replace("-", "_", $cpfArray["name"][$i]);  //Substitui qualquer underline por traço.
        $cpfArray["name"][$i] = tiraAcento($cpfArray["name"][$i]);
        $arrayCpf[$i] = array(
            "nome" => $cpfArray["name"][$i],
            "tipo" => $cpfArray["type"][$i],
            "nomeTemporario" => $cpfArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/cpfs/",
            "idCampo" => $idCpf
        );
    }

    $pispasepArray = $_FILES['pispasepArquivo'];
    $tamanho =  count($_FILES['pispasepArquivo']['name']);
    $uniqidPispasep = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $pispasepArray["name"][$i] = str_replace("-", "_", $pispasepArray["name"][$i]);  //Substitui qualquer traço por underline.
        $pispasepArray["name"][$i] = tiraAcento($pispasepArray["name"][$i]);
        $arrayPispasep[$i] = array(
            "nome" => $pispasepArray["name"][$i],
            "tipo" => $pispasepArray["type"][$i],
            "nomeTemporario" => $pispasepArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/pispaseps/",
            "idCampo" => $idPispasep
        );
    }

    $rgArray = $_FILES['rgArquivo'];
    $tamanho =  count($_FILES['rgArquivo']['name']);
    $uniqidRg = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $rgArray["name"][$i] = str_replace("-", "_", $rgArray["name"][$i]);  //Substitui qualquer traço por underline.
        $rgArray["name"][$i] = tiraAcento($rgArray["name"][$i]);
        $arrayRg[$i] = array(
            "nome" => $rgArray["name"][$i],
            "tipo" => $rgArray["type"][$i],
            "nomeTemporario" => $rgArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/rgs/",
            "idCampo" => $idRg
        );
    }


    $cnhArray = $_FILES['cnhArquivo'];
    $tamanho =  count($_FILES['cnhArquivo']['name']);
    $uniqidCnh = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $cnhArray["name"][$i] = str_replace("-", "_", $cnhArray["name"][$i]);  //Substitui qualquer traço por underline. 
        $cnhArray["name"][$i] = tiraAcento($cnhArray["name"][$i]);
        $arrayCnh[$i] = array(
            "nome" => $cnhArray["name"][$i],
            "tipo" => $cnhArray["type"][$i],
            "nomeTemporario" => $cnhArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/cnhs/",
            "idCampo" => $idCnh
        );
    }


    $tituloEleitorArray = $_FILES['tituloEleitorArquivo'];
    $tamanho =  count($_FILES['tituloEleitorArquivo']['name']);
    $uniqidTituloEleitor = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $tituloEleitorArray["name"][$i] = str_replace("-", "_", $tituloEleitorArray["name"][$i]);  //Substitui qualquer traço por underline
        $tituloEleitorArray["name"][$i] = tiraAcento($tituloEleitorArray["name"][$i]);
        $arrayTituloEleitor[$i] = array(
            "nome" => $tituloEleitorArray["name"][$i],
            "tipo" => $tituloEleitorArray["type"][$i],
            "nomeTemporario" => $tituloEleitorArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/titulos-de-eleitores/",
            "idCampo" => $idTituloEleitor
        );
    }

    $certificadoReservistaArray = $_FILES['certificadoReservistaArquivo'];
    $tamanho =  count($_FILES['certificadoReservistaArquivo']['name']);
    $uniqidCertificadoReservista = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $certificadoReservistaArray["name"][$i] = str_replace("-", "_", $certificadoReservistaArray["name"][$i]);  //Substitui qualquer traço por underline. 
        $certificadoReservistaArray["name"][$i] = tiraAcento($certificadoReservistaArray["name"][$i]);
        $arrayCertificadoReservista[$i] = array(
            "nome" => $certificadoReservistaArray["name"][$i],
            "tipo" => $certificadoReservistaArray["type"][$i],
            "nomeTemporario" => $certificadoReservistaArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/certificados-de-reservistas/",
            "idCampo" => $idCertificadoReservista
        );
    }

    $comprovanteEscolaridadeArray = $_FILES['comprovanteEscolaridadeFile'];
    $tamanho =  count($_FILES['comprovanteEscolaridadeFile']['name']);
    $uniqidComprovanteEscolaridade = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $comprovanteEscolaridadeArray["name"][$i] = str_replace("-", "_", $comprovanteEscolaridadeArray["name"][$i]);  //Substitui qualquer underline por traço. 
        $comprovanteEscolaridadeArray["name"][$i] = tiraAcento($comprovanteEscolaridadeArray["name"][$i]);
        $arrayComprovanteEscolaridade[$i] = array(
            "nome" => $comprovanteEscolaridadeArray["name"][$i],
            "tipo" => $comprovanteEscolaridadeArray["type"][$i],
            "nomeTemporario" => $comprovanteEscolaridadeArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/comprovantes-de-escolaridade/",
            "idCampo" => $idComprovanteEscolaridade
        );
    }

    $certificadoDiplomaArray = $_FILES['certificadoDiplomaFile'];
    $tamanho =  count($_FILES['certificadoDiplomaFile']['name']);
    $uniqidCertificadoDiploma = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $certificadoDiplomaArray["name"][$i] = str_replace("-", "_", $certificadoDiplomaArray["name"][$i]);  //Substitui qualquer traço por underline. 
        $certificadoDiplomaArray["name"][$i] = tiraAcento($certificadoDiplomaArray["name"][$i]);
        $arrayCertificadoDiploma[$i] = array(
            "nome" => $certificadoDiplomaArray["name"][$i],
            "tipo" => $certificadoDiplomaArray["type"][$i],
            "nomeTemporario" => $certificadoDiplomaArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/certificados-e-diplomas/",
            "idCampo" => $idCertificadoDiploma
        );
    }

    $certidaoNascimentoFilhoArray = $_FILES['certidaoNascimentoFilhoFile'];
    $tamanho =  count($_FILES['certidaoNascimentoFilhoFile']['name']);
    $uniqidCertidaoNascimentoFilho = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $certidaoNascimentoFilhoArray["name"][$i] = str_replace("-", "_", $certidaoNascimentoFilhoArray["name"][$i]);
        $certidaoNascimentoFilhoArray["name"][$i] = tiraAcento($certidaoNascimentoFilhoArray["name"][$i]);
        $arrayCertidaoNascimentoFilho[$i] = array(
            "nome" => $certidaoNascimentoFilhoArray["name"][$i],
            "tipo" => $certidaoNascimentoFilhoArray["type"][$i],
            "nomeTemporario" => $certidaoNascimentoFilhoArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/certidoes-de-nascimento-dos-filhos/",
            "idCampo" => $idCertidaoNascimentoFilho
        );
    }

    $rgFilhoArray = $_FILES['rgFilhoFile'];
    $tamanho =  count($_FILES['rgFilhoFile']['name']);
    $uniqidRgFilho = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $rgFilhoArray["name"][$i] = str_replace("-", "_", $rgFilhoArray["name"][$i]);
        $rgFilhoArray["name"][$i] = tiraAcento($rgFilhoArray["name"][$i]);
        $arrayRgFilho[$i] = array(
            "nome" => $rgFilhoArray["name"][$i],
            "tipo" => $rgFilhoArray["type"][$i],
            "nomeTemporario" => $rgFilhoArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/rgs-dos-filhos/",
            "idCampo" => $idRgFilho
        );
    }

    $cpfFilhoArray = $_FILES['cpfFilhoFile'];
    $tamanho =  count($_FILES['cpfFilhoFile']['name']);
    $uniqidCpfFilho = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $cpfFilhoArray["name"][$i] = str_replace("-", "_", $cpfFilhoArray["name"][$i]);
        $cpfFilhoArray["name"][$i] = tiraAcento($cpfFilhoArray["name"][$i]);
        $arrayCpfFilho[$i] = array(
            "nome" => $cpfFilhoArray["name"][$i],
            "tipo" => $cpfFilhoArray["type"][$i],
            "nomeTemporario" => $cpfFilhoArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/cpf-dos-filhos/",
            "idCampo" => $idCpfFilho
        );
    }

    $certidaoNascimentoDependenteArray = $_FILES['certidaoNascimentoDependenteFile'];
    $tamanho =  count($_FILES['certidaoNascimentoDependenteFile']['name']);
    $uniqidCertidaoNascimentoDependente = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $certidaoNascimentoDependenteArray["name"][$i] = str_replace("-", "_", $certidaoNascimentoDependenteArray["name"][$i]);
        $certidaoNascimentoDependenteArray["name"][$i] = tiraAcento($certidaoNascimentoDependenteArray["name"][$i]);
        $arrayCertidaoNascimentoDependente[$i] = array(
            "nome" => $certidaoNascimentoDependenteArray["name"][$i],
            "tipo" => $certidaoNascimentoDependenteArray["type"][$i],
            "nomeTemporario" => $certidaoNascimentoDependenteArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/certidoes_de_nascimentos_dos_dependentes/",
            "idCampo" => $idCertidaoNascimentoDependente
        );
    }

    $rgDependenteArray = $_FILES['rgDependenteFile'];
    $tamanho =  count($_FILES['rgDependenteFile']['name']);
    $uniqidRgDependente = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $rgDependenteArray["name"][$i] = str_replace("-", "_", $rgDependenteArray["name"][$i]);
        $rgDependenteArray["name"][$i] = tiraAcento($rgDependenteArray["name"][$i]);
        $arrayRgDependente[$i] = array(
            "nome" => $rgDependenteArray["name"][$i],
            "tipo" => $rgDependenteArray["type"][$i],
            "nomeTemporario" => $rgDependenteArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/rgs-dos-dependentes/",
            "idCampo" => $idRgDependente
        );
    }


    $cpfDependenteArray = $_FILES['cpfDependenteFile'];
    $tamanho =  count($_FILES['cpfDependenteFile']['name']);
    $uniqidCpfDependente = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $cpfDependenteArray["name"][$i] = str_replace("-", "_", $cpfDependenteArray["name"][$i]);
        $cpfDependenteArray["name"][$i] = tiraAcento($cpfDependenteArray["name"][$i]);
        $arrayCpfDependente[$i] = array(
            "nome" => $cpfDependenteArray["name"][$i],
            "tipo" => $cpfDependenteArray["type"][$i],
            "nomeTemporario" => $cpfDependenteArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/cpfs-dos-dependentes/",
            "idCampo" => $idCpfDependente
        );
    }

    $fotoCandidatoArray = $_FILES['fotoCandidato'];
    $tamanho =  count($_FILES['fotoCandidato']['name']);
    $uniqidFotoCandidato = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $fotoCandidatoArray["name"][$i] = str_replace("-", "_", $fotoCandidatoArray["name"][$i]); //Substitui qualquer traço por underline.
        $fotoCandidatoArray["name"][$i] = tiraAcento($fotoCandidatoArray["name"][$i]);
        $arrayFotoCandidato[$i] = array(
            "nome" => $fotoCandidatoArray["name"][$i],
            "tipo" => $fotoCandidatoArray["type"][$i],
            "nomeTemporario" => $fotoCandidatoArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/foto_candidatos/",
            "idCampo" => $idFotoCandidato
        );
    }
    $carteiraVacinacaoFilhoArray = $_FILES['carteiraVacinacaoFilhoFile'];
    $tamanho =  count($_FILES['carteiraVacinacaoFilhoFile']['name']);
    $uniqidCarteiraVacinacaoFilho = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        $carteiraVacinacaoFilhoArray["name"][$i] = str_replace("-", "_", $carteiraVacinacaoFilhoArray["name"][$i]);
        $carteiraVacinacaoFilhoArray["name"][$i] = tiraAcento($carteiraVacinacaoFilhoArray["name"][$i]);
        $arrayCarteiraVacinacaoFilho[$i] = array(
            "nome" => $carteiraVacinacaoFilhoArray["name"][$i],
            "tipo" => $carteiraVacinacaoFilhoArray["type"][$i],
            "nomeTemporario" => $carteiraVacinacaoFilhoArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/carteira_de_vacinacao_filho/",
            "idCampo" => $idCarteiraVacinacaoFilho
        );
    }

    //Cria um xml baseado no arrays acima
    //CERTIDÃO DE NASCIMENTO:

    $nomeXml =  "ArrayOfCertidaoNascimento";
    $nomeTabela = "documentos";
    if (sizeof($arrayCertidaoNascimento) > 0) {
        $xmlCertidaoNascimento = '<?xml version="1.0"?>';
        $xmlCertidaoNascimento = $xmlCertidaoNascimento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCertidaoNascimento as $chave) {
            $xmlCertidaoNascimento = $xmlCertidaoNascimento . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCertidaoNascimento . "_" . $valor;
                }

                $xmlCertidaoNascimento = $xmlCertidaoNascimento . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCertidaoNascimento = $xmlCertidaoNascimento . "</" . $nomeTabela . ">";
        }
        $xmlCertidaoNascimento = $xmlCertidaoNascimento . "</" . $nomeXml . ">";
    } else {
        $xmlCertidaoNascimento = '<?xml version="1.0"?>';
        $xmlCertidaoNascimento = $xmlCertidaoNascimento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCertidaoNascimento = $xmlCertidaoNascimento . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCertidaoNascimento);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de certidões de nascimento ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCertidaoNascimento = "'" . $xmlCertidaoNascimento . "'";

    //CERTIDÃO DE CASAMENTO:
    $nomeXml =  "ArrayOfCertidaoCasamento";
    $nomeTabela = "documentos";
    if (sizeof($arrayCertidaoCasamento) > 0) {
        $xmlCertidaoCasamento = '<?xml version="1.0"?>';
        $xmlCertidaoCasamento = $xmlCertidaoCasamento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCertidaoCasamento as $chave) {
            $xmlCertidaoCasamento = $xmlCertidaoCasamento . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                 de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCertidaoCasamento . "_" . $valor;
                }

                $xmlCertidaoCasamento = $xmlCertidaoCasamento . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCertidaoCasamento = $xmlCertidaoCasamento . "</" . $nomeTabela . ">";
        }
        $xmlCertidaoCasamento = $xmlCertidaoCasamento . "</" . $nomeXml . ">";
    } else {
        $xmlCertidaoCasamento = '<?xml version="1.0"?>';
        $xmlCertidaoCasamento = $xmlCertidaoCasamento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCertidaoCasamento = $xmlCertidaoCasamento . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCertidaoCasamento);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de certidões de nascimento ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCertidaoCasamento = "'" . $xmlCertidaoCasamento . "'";

    //COMPROVANTE DE RESIDÊNCIA:
    $nomeXml =  "ArrayOfComprovanteResidencia";
    $nomeTabela = "documentos";
    if (sizeof($arrayComprovanteResidencia) > 0) {
        $xmlComprovanteResidencia = '<?xml version="1.0"?>';
        $xmlComprovanteResidencia = $xmlComprovanteResidencia . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayComprovanteResidencia as $chave) {
            $xmlComprovanteResidencia = $xmlComprovanteResidencia . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                 de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidComprovanteResidencia . "_" . $valor;
                }

                $xmlComprovanteResidencia = $xmlComprovanteResidencia . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlComprovanteResidencia = $xmlComprovanteResidencia . "</" . $nomeTabela . ">";
        }
        $xmlComprovanteResidencia = $xmlComprovanteResidencia . "</" . $nomeXml . ">";
    } else {
        $xmlComprovanteResidencia = '<?xml version="1.0"?>';
        $xmlComprovanteResidencia = $xmlComprovanteResidencia . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlComprovanteResidencia = $xmlComprovanteResidencia . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlComprovanteResidencia);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos comprovantes de residência ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlComprovanteResidencia = "'" . $xmlComprovanteResidencia . "'";

    //CPF
    $nomeXml =  "ArrayOfCpf";
    $nomeTabela = "documentos";
    if (sizeof($arrayCpf) > 0) {
        $xmlCpf = '<?xml version="1.0"?>';
        $xmlCpf = $xmlCpf . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCpf as $chave) {
            $xmlCpf = $xmlCpf . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                 de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCpf . "_" . $valor;
                }

                $xmlCpf = $xmlCpf . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCpf = $xmlCpf . "</" . $nomeTabela . ">";
        }
        $xmlCpf = $xmlCpf . "</" . $nomeXml . ">";
    } else {
        $xmlCpf = '<?xml version="1.0"?>';
        $xmlCpf = $xmlCpf . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCpf = $xmlCpf . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCpf);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos cpfs ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCpf = "'" . $xmlCpf . "'";

    //PISPASEP
    $nomeXml =  "ArrayOfPispasep";
    $nomeTabela = "documentos";
    if (sizeof($arrayPispasep) > 0) {
        $xmlPispasep = '<?xml version="1.0"?>';
        $xmlPispasep = $xmlPispasep . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayPispasep  as $chave) {
            $xmlPispasep = $xmlPispasep . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
              de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidPispasep . "_" . $valor;
                }

                $xmlPispasep = $xmlPispasep . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlPispasep = $xmlPispasep . "</" . $nomeTabela . ">";
        }
        $xmlPispasep = $xmlPispasep . "</" . $nomeXml . ">";
    } else {
        $xmlPispasep = '<?xml version="1.0"?>';
        $xmlPispasep = $xmlPispasep . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlPispasep = $xmlPispasep . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlPispasep);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos pispaseps ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlPispasep = "'" . $xmlPispasep . "'";

    //RG
    $nomeXml =  "ArrayOfRg";
    $nomeTabela = "documentos";
    if (sizeof($arrayRg) > 0) {
        $xmlRg = '<?xml version="1.0"?>';
        $xmlRg = $xmlRg . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayRg  as $chave) {
            $xmlRg = $xmlRg . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                 de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidRg . "_" . $valor;
                }

                $xmlRg = $xmlRg . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlRg = $xmlRg . "</" . $nomeTabela . ">";
        }
        $xmlRg = $xmlRg . "</" . $nomeXml . ">";
    } else {
        $xmlRg = '<?xml version="1.0"?>';
        $xmlRg = $xmlRg . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlRg = $xmlRg . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlRg);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML das identidades ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlRg = "'" . $xmlRg . "'";

    //CNH
    $nomeXml =  "ArrayOfCnh";
    $nomeTabela = "documentos";
    if (sizeof($arrayCnh) > 0) {
        $xmlCnh = '<?xml version="1.0"?>';
        $xmlCnh = $xmlCnh . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCnh  as $chave) {
            $xmlCnh = $xmlCnh . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                 de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCnh . "_" . $valor;
                }

                $xmlCnh = $xmlCnh . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCnh = $xmlCnh . "</" . $nomeTabela . ">";
        }
        $xmlCnh = $xmlCnh . "</" . $nomeXml . ">";
    } else {
        $xmlCnh = '<?xml version="1.0"?>';
        $xmlCnh = $xmlCnh . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCnh = $xmlCnh . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCnh);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos certificados de habilitações. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCnh = "'" . $xmlCnh . "'";

    //TITULO DE ELEITOR
    $nomeXml =  "ArrayOfTituloEleitor";
    $nomeTabela = "documentos";
    if (sizeof($arrayTituloEleitor) > 0) {
        $xmlTituloEleitor = '<?xml version="1.0"?>';
        $xmlTituloEleitor = $xmlTituloEleitor . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayTituloEleitor  as $chave) {
            $xmlTituloEleitor = $xmlTituloEleitor . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                  de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidTituloEleitor . "_" . $valor;
                }

                $xmlTituloEleitor = $xmlTituloEleitor . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlTituloEleitor = $xmlTituloEleitor . "</" . $nomeTabela . ">";
        }
        $xmlTituloEleitor = $xmlTituloEleitor . "</" . $nomeXml . ">";
    } else {
        $xmlTituloEleitor = '<?xml version="1.0"?>';
        $xmlTituloEleitor = $xmlTituloEleitor . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTituloEleitor = $xmlTituloEleitor . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlTituloEleitor);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos títulos de eleitores. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlTituloEleitor = "'" . $xmlTituloEleitor . "'";


    //CERTIFICADO DE RESERVISTA
    $nomeXml =  "ArrayOfCertificadoReservista";
    $nomeTabela = "documentos";
    if (sizeof($arrayCertificadoReservista) > 0) {
        $xmlCertificadoReservista = '<?xml version="1.0"?>';
        $xmlCertificadoReservista = $xmlCertificadoReservista . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCertificadoReservista  as $chave) {
            $xmlCertificadoReservista = $xmlCertificadoReservista . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                  de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCertificadoReservista . "_" . $valor;
                }

                $xmlCertificadoReservista = $xmlCertificadoReservista . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCertificadoReservista = $xmlCertificadoReservista . "</" . $nomeTabela . ">";
        }
        $xmlCertificadoReservista = $xmlCertificadoReservista . "</" . $nomeXml . ">";
    } else {
        $xmlCertificadoReservista = '<?xml version="1.0"?>';
        $xmlCertificadoReservista = $xmlCertificadoReservista . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCertificadoReservista = $xmlCertificadoReservista . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCertificadoReservista);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos certificados de reservista. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCertificadoReservista = "'" . $xmlCertificadoReservista . "'";

    //COMPROVANTE DE ESCOLARIDADE
    $nomeXml =  "ArrayOfComprovanteEscolaridade";
    $nomeTabela = "documentos";
    if (sizeof($arrayComprovanteEscolaridade) > 0) {
        $xmlComprovanteEscolaridade = '<?xml version="1.0"?>';
        $xmlComprovanteEscolaridade = $xmlComprovanteEscolaridade . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayComprovanteEscolaridade  as $chave) {
            $xmlComprovanteEscolaridade = $xmlComprovanteEscolaridade . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                  de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidComprovanteEscolaridade . "_" . $valor;
                }

                $xmlComprovanteEscolaridade = $xmlComprovanteEscolaridade . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlComprovanteEscolaridade = $xmlComprovanteEscolaridade . "</" . $nomeTabela . ">";
        }
        $xmlComprovanteEscolaridade = $xmlComprovanteEscolaridade . "</" . $nomeXml . ">";
    } else {
        $xmlComprovanteEscolaridade = '<?xml version="1.0"?>';
        $xmlComprovanteEscolaridade = $xmlComprovanteEscolaridade . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlComprovanteEscolaridade = $xmlComprovanteEscolaridade . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlComprovanteEscolaridade);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos comprovantes de escolaridade. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlComprovanteEscolaridade = "'" . $xmlComprovanteEscolaridade . "'";

    //CERTIFICADOS E DIPLOMAS
    $nomeXml =  "ArrayOfCertificadoDiploma";
    $nomeTabela = "documentos";
    if (sizeof($arrayCertificadoDiploma) > 0) {
        $xmlCertificadoDiploma = '<?xml version="1.0"?>';
        $xmlCertificadoDiploma = $xmlCertificadoDiploma . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCertificadoDiploma  as $chave) {
            $xmlCertificadoDiploma = $xmlCertificadoDiploma . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                   de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCertificadoDiploma . "_" . $valor;
                }

                $xmlCertificadoDiploma = $xmlCertificadoDiploma . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCertificadoDiploma = $xmlCertificadoDiploma . "</" . $nomeTabela . ">";
        }
        $xmlCertificadoDiploma = $xmlCertificadoDiploma . "</" . $nomeXml . ">";
    } else {
        $xmlCertificadoDiploma = '<?xml version="1.0"?>';
        $xmlCertificadoDiploma = $xmlCertificadoDiploma . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCertificadoDiploma = $xmlCertificadoDiploma . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCertificadoDiploma);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos certificados e diplomas. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCertificadoDiploma = "'" . $xmlCertificadoDiploma . "'";

    //CERTIFICADO DE NASCIMENTO DOS FILHOS
    $nomeXml =  "ArrayOfCertidaoNascimentoFilho";
    $nomeTabela = "documentos";
    if (sizeof($arrayCertidaoNascimentoFilho) > 0) {
        $xmlCertidaoNascimentoFilho = '<?xml version="1.0"?>';
        $xmlCertidaoNascimentoFilho = $xmlCertidaoNascimentoFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCertidaoNascimentoFilho  as $chave) {
            $xmlCertidaoNascimentoFilho = $xmlCertidaoNascimentoFilho . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                  de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCertidaoNascimentoFilho . "_" . $valor;
                }

                $xmlCertidaoNascimentoFilho = $xmlCertidaoNascimentoFilho . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCertidaoNascimentoFilho = $xmlCertidaoNascimentoFilho . "</" . $nomeTabela . ">";
        }
        $xmlCertidaoNascimentoFilho = $xmlCertidaoNascimentoFilho . "</" . $nomeXml . ">";
    } else {
        $xmlCertidaoNascimentoFilho = '<?xml version="1.0"?>';
        $xmlCertidaoNascimentoFilho = $xmlCertidaoNascimentoFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCertidaoNascimentoFilho = $xmlCertidaoNascimentoFilho . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCertidaoNascimentoFilho);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML da certidão de nascimento dos filhos. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCertidaoNascimentoFilho = "'" . $xmlCertidaoNascimentoFilho . "'";

    //RG DOS FILHOS 
    $nomeXml =  "ArrayOfRgFilho";
    $nomeTabela = "documentos";
    if (sizeof($arrayRgFilho) > 0) {
        $xmlRgFilho = '<?xml version="1.0"?>';
        $xmlRgFilho = $xmlRgFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayRgFilho  as $chave) {
            $xmlRgFilho = $xmlRgFilho . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                   de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidRgFilho . "_" . $valor;
                }

                $xmlRgFilho = $xmlRgFilho . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlRgFilho = $xmlRgFilho . "</" . $nomeTabela . ">";
        }
        $xmlRgFilho = $xmlRgFilho . "</" . $nomeXml . ">";
    } else {
        $xmlRgFilho = '<?xml version="1.0"?>';
        $xmlRgFilho = $xmlRgFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlRgFilho = $xmlRgFilho . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlRgFilho);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos rgs dos filhos. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlRgFilho = "'" . $xmlRgFilho . "'";

    //CPF DOS FILHOS
    $nomeXml =  "ArrayOfCpfFilho";
    $nomeTabela = "documentos";
    if (sizeof($arrayCpfFilho) > 0) {
        $xmlCpfFilho = '<?xml version="1.0"?>';
        $xmlCpfFilho = $xmlCpfFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCpfFilho  as $chave) {
            $xmlCpfFilho = $xmlCpfFilho . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                     de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCpfFilho . "_" . $valor;
                }

                $xmlCpfFilho = $xmlCpfFilho . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCpfFilho = $xmlCpfFilho . "</" . $nomeTabela . ">";
        }
        $xmlCpfFilho = $xmlCpfFilho . "</" . $nomeXml . ">";
    } else {
        $xmlCpfFilho = '<?xml version="1.0"?>';
        $xmlCpfFilho = $xmlCpfFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCpfFilho = $xmlCpfFilho . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCpfFilho);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos cpf dos filhos. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCpfFilho = "'" . $xmlCpfFilho . "'";

    //CERTIDÃO DE NASCIMENTO DOS DEPENDENTES
    $nomeXml =  "ArrayOfCertidaoNascimentoDependente";
    $nomeTabela = "documentos";
    if (sizeof($arrayCertidaoNascimentoDependente) > 0) {
        $xmlCertidaoNascimentoDependente = '<?xml version="1.0"?>';
        $xmlCertidaoNascimentoDependente = $xmlCertidaoNascimentoDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCertidaoNascimentoDependente  as $chave) {
            $xmlCertidaoNascimentoDependente = $xmlCertidaoNascimentoDependente . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                      de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCertidaoNascimentoDependente . "_" . $valor;
                }

                $xmlCertidaoNascimentoDependente = $xmlCertidaoNascimentoDependente . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCertidaoNascimentoDependente = $xmlCertidaoNascimentoDependente . "</" . $nomeTabela . ">";
        }
        $xmlCertidaoNascimentoDependente = $xmlCertidaoNascimentoDependente . "</" . $nomeXml . ">";
    } else {
        $xmlCertidaoNascimentoDependente = '<?xml version="1.0"?>';
        $xmlCertidaoNascimentoDependente = $xmlCertidaoNascimentoDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCertidaoNascimentoDependente = $xmlCertidaoNascimentoDependente . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCertidaoNascimentoDependente);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML da certidão de nascimentos dos dependentes. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCertidaoNascimentoDependente = "'" . $xmlCertidaoNascimentoDependente . "'";

    //RG DOS DEPENDENTES
    $nomeXml =  "ArrayOfRgDependente";
    $nomeTabela = "documentos";
    if (sizeof($arrayRgDependente) > 0) {
        $xmlRgDependente = '<?xml version="1.0"?>';
        $xmlRgDependente = $xmlRgDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayRgDependente  as $chave) {
            $xmlRgDependente = $xmlRgDependente . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                          de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidRgDependente . "_" . $valor;
                }

                $xmlRgDependente = $xmlRgDependente . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlRgDependente = $xmlRgDependente . "</" . $nomeTabela . ">";
        }
        $xmlRgDependente = $xmlRgDependente . "</" . $nomeXml . ">";
    } else {
        $xmlRgDependente = '<?xml version="1.0"?>';
        $xmlRgDependente = $xmlRgDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlRgDependente = $xmlRgDependente . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlRgDependente);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos rg dos dependentes. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlRgDependente = "'" . $xmlRgDependente . "'";


    //CPF DOS DEPENDENTES
    $nomeXml =  "ArrayOfCpfDependente";
    $nomeTabela = "documentos";
    if (sizeof($arrayCpfDependente) > 0) {
        $xmlCpfDependente = '<?xml version="1.0"?>';
        $xmlCpfDependente = $xmlCpfDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCpfDependente  as $chave) {
            $xmlCpfDependente = $xmlCpfDependente . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                          de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCpfDependente . "_" . $valor;
                }

                $xmlCpfDependente = $xmlCpfDependente . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCpfDependente = $xmlCpfDependente . "</" . $nomeTabela . ">";
        }
        $xmlCpfDependente = $xmlCpfDependente . "</" . $nomeXml . ">";
    } else {
        $xmlCpfDependente = '<?xml version="1.0"?>';
        $xmlCpfDependente = $xmlCpfDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCpfDependente = $xmlCpfDependente . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCpfDependente);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML dos cpf dos dependentes. ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCpfDependente = "'" . $xmlCpfDependente . "'";

    $nomeXml =  "ArrayOfFotoCandidato";
    $nomeTabela = "documentos";
    if (sizeof($arrayFotoCandidato) > 0) {
        $xmlFotoCandidato = '<?xml version="1.0"?>';
        $xmlFotoCandidato = $xmlFotoCandidato . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayFotoCandidato as $chave) {
            $xmlFotoCandidato = $xmlFotoCandidato . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidFotoCandidato . "_" . $valor;
                }

                $xmlFotoCandidato = $xmlFotoCandidato . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlFotoCandidato = $xmlFotoCandidato . "</" . $nomeTabela . ">";
        }
        $xmlFotoCandidato = $xmlFotoCandidato . "</" . $nomeXml . ">";
    } else {
        $xmlFotoCandidato = '<?xml version="1.0"?>';
        $xmlFotoCandidato = $xmlFotoCandidato . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlFotoCandidato = $xmlFotoCandidato . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlFotoCandidato);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de certidões de nascimento ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlFotoCandidato = "'" . $xmlFotoCandidato . "'";

    $nomeXml =  "ArrayOfCarteiraVacinacaoFilho";
    $nomeTabela = "documentos";
    if (sizeof($arrayCarteiraVacinacaoFilho) > 0) {
        $xmlCarteiraVacinacaoFilho = '<?xml version="1.0"?>';
        $xmlCarteiraVacinacaoFilho = $xmlCarteiraVacinacaoFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayCarteiraVacinacaoFilho as $chave) {
            $xmlCarteiraVacinacaoFilho = $xmlCarteiraVacinacaoFilho . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {

                /*Caso o campo seja 'Nome Temporario' ele retira do array e continua o processo
                de criacao do xml. */
                if ($campo === "nomeTemporario") {
                    continue;
                }

                if (($campo === "nome") && ($valor != "")) {
                    $valor =  $uniqidCarteiraVacinacaoFilho . "_" . $valor;
                }

                $xmlCarteiraVacinacaoFilho = $xmlCarteiraVacinacaoFilho . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlCarteiraVacinacaoFilho = $xmlCarteiraVacinacaoFilho . "</" . $nomeTabela . ">";
        }
        $xmlCarteiraVacinacaoFilho = $xmlCarteiraVacinacaoFilho . "</" . $nomeXml . ">";
    } else {
        $xmlCarteiraVacinacaoFilho = '<?xml version="1.0"?>';
        $xmlCarteiraVacinacaoFilho = $xmlCarteiraVacinacaoFilho . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlCarteiraVacinacaoFilho = $xmlCarteiraVacinacaoFilho . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlCarteiraVacinacaoFilho);  //Transforma o xml em uma string.

    if ($xml === false) {
        $mensagem = "Erro na criação do XML de certidões de nascimento ";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $xmlCarteiraVacinacaoFilho = "'" . $xmlCarteiraVacinacaoFilho . "'";



    moverArquivosParaPasta($idCertidaoNascimento, $uniqidCertidaoNascimento, $tipoArquivoPermitido, $diretorioFilhoCertidaoNascimento);
    moverArquivosParaPasta($idCertidaoCasamento, $uniqidCertidaoCasamento, $tipoArquivoPermitido, $diretorioFilhoCertidaoCasamento);
    moverArquivosParaPasta($idComprovanteResidencia, $uniqidComprovanteResidencia, $tipoArquivoPermitido, $diretorioFilhoComprovanteResidencia);
    moverArquivosParaPasta($idCpf, $uniqidCpf, $tipoArquivoPermitido, $diretorioFilhoCpf);
    moverArquivosParaPasta($idPispasep, $uniqidPispasep, $tipoArquivoPermitido, $diretorioFilhoPispasep);
    moverArquivosParaPasta($idRg, $uniqidRg, $tipoArquivoPermitido, $diretorioFilhoRg);
    moverArquivosParaPasta($idCnh, $uniqidCnh, $tipoArquivoPermitido, $diretorioFilhoCnh);
    moverArquivosParaPasta($idTituloEleitor, $uniqidTituloEleitor, $tipoArquivoPermitido, $diretorioFilhoTituloEleitor);
    moverArquivosParaPasta($idCertificadoReservista, $uniqidCertificadoReservista, $tipoArquivoPermitido, $diretorioFilhoCertificadoReservista);
    moverArquivosParaPasta($idComprovanteEscolaridade, $uniqidComprovanteEscolaridade, $tipoArquivoPermitido, $diretorioFilhoComprovanteEscolaridade);
    moverArquivosParaPasta($idCertificadoDiploma, $uniqidCertificadoDiploma, $tipoArquivoPermitido, $diretorioFilhoCertificadoDiploma);
    moverArquivosParaPasta($idCertidaoNascimentoFilho, $uniqidCertidaoNascimentoFilho, $tipoArquivoPermitido, $diretorioFilhoCertidaoNascimentoFilho);
    moverArquivosParaPasta($idRgFilho, $uniqidRgFilho, $tipoArquivoPermitido, $diretorioFilhoRgFilho);
    moverArquivosParaPasta($idCpfFilho, $uniqidCpfFilho, $tipoArquivoPermitido, $diretorioFilhoCpfFilho);
    moverArquivosParaPasta($idCertidaoNascimentoDependente, $uniqidCertidaoNascimentoDependente, $tipoArquivoPermitido, $diretorioFilhoCertidaoNascimentoDependente);
    moverArquivosParaPasta($idRgDependente, $uniqidRgDependente, $tipoArquivoPermitido, $diretorioFilhoRgDependente);
    moverArquivosParaPasta($idCpfDependente, $uniqidCpfDependente, $tipoArquivoPermitido, $diretorioFilhoCpfDependente);
    moverArquivosParaPasta($idFotoCandidato, $uniqidFotoCandidato, $tipoArquivoPermitido, $diretorioFilhoFotoCandidato);
    moverArquivosParaPasta($idCarteiraVacinacaoFilho, $uniqidCarteiraVacinacaoFilho, $tipoArquivoPermitido, $diretorioFilhoCarteiraVacinacaoFilho);



    $sql = "Contratacao.candidatoDocumento_Atualiza
        $codigo,							
        $nomeCompleto,						
        $cpf,								   
        $dataNascimento,						
        $naturalidade,						
        $nacionalidade,						
        $racaCor,							
        $estadoCivil,						
        $nomePai,    								
        $nomeMae,								
        $ctps,								
        $pis,									
        $dataEmissaoCnh,						
        $dataVencimentoCnh,					
        $primeiraCnh,							
        $tituloEleitor,						
        $zonaTituloEleitor,					
        $secaoTituloEleitor,					
        $certificadoReservista,				
        $telefoneResidencial,					
        $telefoneCelular,						
        $outroTelefone,						
        $email,								
        $cep,									
        $endereco,							
        $bairro,								
        $numero,								
        $complemento,							
        $estado,								
        $cidade,								
        $grauInstrucao,						
        $grauParou,							
        $anoConclusao,						
        $cursandoAtualmente,					
        $horarioEstudo,						
        $nomeEnderecoColegioUniversidade,		
        $atividadesExtracurriculares,			
        $nomeConjuge,							
        $naturalidadeConjuge,					
        $nacionalidadeConjuge,				
        $dataNascimentoConjuge,				
        $trabalhaAtualmente,			
        $desejaVt,							
        $possuiVt,							
        $numeroCartaoVt,						
        $seguroDesemprego,					    
        $desejaAssistenciaMedica,				
        $desejaAssistenciaOdontologica, 	 	
        $valeRefeicaoValeAlimentacao, 	 	
        $possuiContaBancaria,			 	 	
        $fk_banco,							
        $agenciaBanco,						
        $contaCorrente,						
        $numeroCamisa,						
        $numeroCalca,							
        $numeroSaia	,						
        $numeroSapato,
        $cnh,
        $categoriaCnh,
        $ufCnh,
        $rg,
        $emissorRg,
        $localRg ,
        $dataEmissaoRg,
        $sexo,
        $localCarteiraTrabalho,
        $primeiroEmprego,
        $cargo,
        $xmlFilho,
        $xmlDependente,
        $verificaDadoPessoal,
		$verificaDadoContato,
		$verificaEndereco,
		$verificaDocumento,
		$verificaEscolaridade,
		$verificaDadoConjuge,
		$verificaFilho,
		$verificaDependente,
		$verificaBeneficio,
		$verificaVT,
		$verificaDadoBancario,
		$verificaCargo,
		$verificaUniforme,
        $verificaAnexoDocumento	,
        $xmlCertidaoNascimento , 
        $xmlCertidaoCasamento ,
        $xmlComprovanteResidencia ,
        $xmlCpf ,
        $xmlPispasep ,
        $xmlRg ,
        $xmlCnh ,
        $xmlTituloEleitor ,
        $xmlCertificadoReservista ,
        $xmlComprovanteEscolaridade ,
        $xmlCertificadoDiploma ,
        $xmlCertidaoNascimentoFilho ,
        $xmlRgFilho ,
        $xmlCpfFilho ,   
        $xmlCertidaoNascimentoDependente ,
        $xmlRgDependente ,
        $xmlCpfDependente,
        $xmlFotoCandidato,
        $xmlCarteiraVacinacaoFilho,
        $carteiraTrabalho,
        $carteiraTrabalhoSerie,
        $dataExpedicaoCarteiraTrabalho,
        $numeroPais,
        $paisNascimento,
        $ufNascimento,
        $numeroMunicipio,
        $municipioNascimento,
        $numeroPaisConjuge,
        $paisNascimentoConjuge,
        $ufNascimentoConjuge,
        $numeroMunicipioConjuge,
        $municipioNascimentoConjuge,
        $possuiFilhoMenor14,
        $digitoAgenciaBanco,
        $digitoContaBanco,
        $tipoConta,
        $aprovado,
        $variacao,
        $projeto,
        $logradouro, 
        $xmlTransporte,
        $usuarioCadastro, 
        $ativo,
        $justificativaVt, 
        $tipoCartaoVt
        ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);
    if ($result != false) {
        echo ('success');
    } else {
        echo ('error');
    }
}

function verificaDiretorio($enderecoPasta)
{

    /*Verifica se o diretório com o endereço especificado existe,
    se não, ele cria e atribui permissões de leitura e gravação. */

    if (!file_exists($enderecoPasta)) {
        mkdir($enderecoPasta, 0777, true);
        chmod($enderecoPasta, 0777);
    }
}

function moverArquivosParaPasta($campo, $uniqId, $tipoArquivoPermitido, $diretorioAlvo)
{


    /* Verifica a quantidade de imagens a serem upadas. E atribui as caracteristicas dessas 
    imagens através de um loop. */

    for ($x = 0; $x < count($_FILES[$campo]['name']); $x++) {

        $_FILES[$campo]['name'][$x] = str_replace("-", "_", $_FILES[$campo]['name'][$x]);  //Substitui qualquer traço por underline.
        $_FILES[$campo]['name'][$x] = tiraAcento($_FILES[$campo]['name'][$x]); //Retira qualquer acento.
        $nome = $uniqId . "_" . $_FILES[$campo]['name'][$x];
        $tamanho = $_FILES[$campo]['size'][$x];
        $nomeTemporario = $_FILES[$campo]['tmp_name'][$x];

        /* Caso a extensão da imagem esteja no array de tipos de arquivo permitidos ele
        executa a função de mover os arquivos para a pasta designada. */
        if ((in_array(pathinfo($nome, PATHINFO_EXTENSION), $tipoArquivoPermitido))) {
            move_uploaded_file($nomeTemporario, $diretorioAlvo . $nome);
        }
    }
}


function recuperaFuncionario()
{

    $reposit = new reposit();

    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT * FROM Contratacao.candidato WHERE (0=0) AND codigo = " . $id;

    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])

    $codigo = $row['codigo'];
    $nomeCompleto = $row['nomeCompleto'];
    $cpf = $row['cpf'];
    $dataNascimento = validaDataRecupera($row['dataNascimento']);
    $naturalidade = $row['naturalidade'];
    $nacionalidade = $row['nacionalidade'];
    $racaCor = $row['racaCor'];
    $estadoCivil = $row['estadoCivil'];
    $nomePai = $row['nomePai'];
    $nomeMae = $row['nomeMae'];
    $ctps = $row['ctps'];
    $pis = $row['pis'];
    $dataEmissaoCnh = validaDataRecupera($row['dataEmissaoCnh']);
    $dataVencimentoCnh = validaDataRecupera($row['dataVencimentoCnh']);
    $primeiraCnh = $row['primeiraCnh'];
    $tituloEleitor = $row['tituloEleitor'];
    $zonaTituloEleitor = $row['zonaTituloEleitor'];
    $secaoTituloEleitor = $row['secaoTituloEleitor'];
    $certificadoReservista = $row['certificadoReservista'];
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
    $grauInstrucao = $row['grauInstrucao'];
    $grauParou = $row['grauParou'];
    $anoConclusao = $row['anoConclusao'];
    $cursandoAtualmente = $row['cursandoAtualmente'];
    $horarioEstudo = $row['horarioEstudo'];
    $nomeEnderecoColegioUniversidade = $row['nomeEnderecoColegioUniversidade'];
    $atividadesExtracurriculares = $row['atividadesExtracurriculares'];
    $nomeConjuge = $row['nomeConjuge'];
    $naturalidadeConjuge = $row['naturalidadeConjuge'];
    $nacionalidadeConjuge = $row['nacionalidadeConjuge'];
    $dataNascimentoConjuge = validaDataRecupera($row['dataNascimentoConjuge']);
    $trabalhaAtualmente = $row['trabalhaAtualmente'];
    $desejaVt = $row['desejaVt'];
    $possuiVt = $row['possuiVt'];
    $numeroCartaoVt = $row['numeroCartaoVt'];
    $seguroDesemprego = $row['seguroDesemprego'];
    $desejaAssistenciaMedica = $row['desejaAssistenciaMedica'];
    $desejaAssistenciaOdontologica = $row['desejaAssistenciaOdontologica'];
    $valeRefeicaoValeAlimentacao = $row['valeRefeicaoValeAlimentacao'];
    $possuiContaBancaria = $row['possuiContaBancaria'];
    $fk_banco = $row['fk_banco'];
    $agenciaBanco = $row['agenciaBanco'];
    $contaCorrente = $row['contaCorrente'];
    $numeroCamisa = $row['numeroCamisa'];
    $numeroCalca = $row['numeroCalca'];
    $numeroSaia = $row['numeroSaia'];
    $numeroSapato = $row['numeroSapato'];
    $cnh = $row['cnh'];
    $categoriaCnh = $row['categoriaCnh'];
    $ufCnh = $row['ufCnh'];
    $rg = $row['rg'];
    $emissorRg = $row['emissorRg'];
    $localRg = $row['localRg'];
    $dataEmissaoRg = validaDataRecupera($row['dataEmissaoRg']);
    $sexo = $row['sexo'];
    $localCarteiraTrabalho = $row['localCarteiraTrabalho'];
    $primeiroEmprego = $row['primeiroEmprego'];
    $cargo = $row['cargo'];

    $verificaDadoPessoal = +$row['verificaDadoPessoal'];
    $verificaDadoContato = +$row['verificaDadoContato'];
    $verificaEndereco = +$row['verificaEndereco'];
    $verificaDocumento = +$row['verificaDocumento'];
    $verificaEscolaridade = +$row['verificaEscolaridade'];
    $verificaDadoConjuge = +$row['verificaDadoConjuge'];
    $verificaFilho = +$row['verificaFilho'];
    $verificaDependente = +$row['verificaDependente'];
    $verificaBeneficio = +$row['verificaBeneficio'];
    $verificaVT = +$row['verificaVT'];
    $verificaDadoBancario = +$row['verificaDadoBancario'];
    $verificaCargo = +$row['verificaCargo'];
    $verificaUniforme = +$row['verificaUniforme'];
    $verificaAnexoDocumento = +$row['verificaAnexoDocumento'];
    $carteiraTrabalho = $row['carteiraTrabalho'];
    $carteiraTrabalhoSerie = $row['carteiraTrabalhoSerie'];
    $dataExpedicaoCarteiraTrabalho = validaDataRecupera($row['dataExpedicaoCarteiraTrabalho']);
    $numeroPais = +$row['numeroPais'];
    $paisNascimento = $row['paisNascimento'];
    $ufNascimento = $row['ufNascimento'];
    $numeroMunicipio = $row['numeroMunicipio'];
    $municipioNascimento = $row['municipioNascimento'];

    $numeroPaisConjuge = +$row['numeroPaisConjuge'];
    $paisNascimentoConjuge = $row['paisNascimentoConjuge'];
    $ufNascimentoConjuge = $row['ufNascimentoConjuge'];
    $numeroMunicipioConjuge = $row['numeroMunicipioConjuge'];
    $municipioNascimentoConjuge = $row['municipioNascimentoConjuge'];
    $possuiFilhoMenor14 = +$row['possuiFilhoMenor14'];

    $digitoAgenciaBanco = +$row['digitoAgenciaBanco'];
    $digitoContaBanco = +$row['digitoContaBanco'];
    $tipoConta = +$row['tipoConta'];
    $aprovado = +$row['aprovado'];
    $variacao = $row['variacao'];
    $codigoBanco = $row['codigoBanco'];
    $projeto = $row['projeto'];
    $logradouro = $row['logradouro'];
    $justificativaVt = $row['justificativaVt'];
    $tipoCartaoVt = $row['tipoCartaoVt'];

    /*------- Lista de Filhos -------*/
    $sql = "SELECT CF.codigo, CF.candidato, CF.nomeCompleto, CF.cpf, CF.dataNascimento FROM Contratacao.candidatoFilho CF 
    INNER JOIN Contratacao.candidato C ON C.codigo = CF.candidato WHERE (0=0) AND C.codigo = " . $id;

    $result = $reposit->RunQuery($sql);

    $contadorFilho = 0;
    $arrayFilho = array();
    foreach($result as $row) {

        $nomeCompletoFilho = $row['nomeCompleto'];
        $cpfFilho = $row['cpf'];
        $dataNascimentoFilho = validaDataRecupera($row['dataNascimento']);

        $contadorFilho = $contadorFilho + 1;
        array_push(
            $arrayFilho,
            [
                "sequencialFilho" => $contadorFilho,
                "nomeFilho" => $nomeCompletoFilho,
                "cpfFilho" => $cpfFilho,
                "dataNascimentoFilho" => $dataNascimentoFilho
            ]
        );
    }

    $strArrayFilho = json_encode($arrayFilho);

    /*------- Lista de Dependentes -------*/
    $sql = "SELECT CD.codigo, CD.candidato, CD.nomeCompleto, CD.cpf, CD.dataNascimento,CD.grauParentescoDependente FROM Contratacao.candidatoDependente CD 
    INNER JOIN Contratacao.candidato C ON C.codigo = CD.candidato WHERE (0=0) AND C.codigo = " . $id;

    $result = $reposit->RunQuery($sql);

    $contadorDependente = 0;
    $arrayDependente = array();
    foreach($result as $row) {
        $nomeCompletoDependente = $row['nomeCompleto'];
        $cpfDependente = $row['cpf'];
        $dataNascimentoDependente = validaDataRecupera($row['dataNascimento']);
        $grauParentescoDependente = $row['grauParentescoDependente'];


        $contadorDependente = $contadorDependente + 1;
        array_push(
            $arrayDependente,
            [
                "sequencialDependente" => $contadorDependente,
                "nomeDependente" => $nomeCompletoDependente,
                "cpfDependente" => $cpfDependente,
                "dataNascimentoDependente" => $dataNascimentoDependente,
                "grauParentescoDependente" => $grauParentescoDependente
            ]
        );
    }
    $strArrayDependente = json_encode($arrayDependente);

    /*------- Lista de Vale transporte -------*/
    $sql = "SELECT CT.codigo, CT.candidato, CT.trajeto, CT.tipo, CT.linha,CT.valor FROM Contratacao.candidatoTransporte CT 
    INNER JOIN Contratacao.candidato C ON C.codigo = CT.candidato WHERE (0=0) AND C.codigo = " . $id;

    $result = $reposit->RunQuery($sql);

    $contadorTransporte = 0;
    $arrayTransporte = array();
    foreach($result as $row) {
        $trajetoTransporte = $row['trajeto'];
        $tipoTransporte = $row['tipo'];
        $linhaTransporte = $row['linha'];
        $valorTransporte = $row['valor'];

        $contadorTransporte = $contadorTransporte + 1;
        array_push(
            $arrayTransporte,
            [
                "sequencialTransporte" => $contadorTransporte,
                "trajetoTransporte" => $trajetoTransporte,
                "tipoTransporte" => $tipoTransporte,
                "linhaTransporte" => $linhaTransporte,
                "valorTransporte" => $valorTransporte
            ]

        );
    }

    $strArrayTransporte = json_encode($arrayTransporte);

    /*------- Saída de dados -------*/
    $out =   $codigo . "^" .
        $nomeCompleto . "^" .
        $cpf . "^" .
        $dataNascimento . "^" .
        $naturalidade . "^" .
        $nacionalidade . "^" .
        $racaCor . "^" .
        $estadoCivil . "^" .
        $nomePai . "^" .
        $nomeMae . "^" .
        $ctps . "^" .
        $pis . "^" .
        $dataEmissaoCnh . "^" .
        $dataVencimentoCnh . "^" .
        $primeiraCnh . "^" .
        $tituloEleitor . "^" .
        $zonaTituloEleitor . "^" .
        $secaoTituloEleitor . "^" .
        $certificadoReservista . "^" .
        $telefoneResidencial . "^" .
        $telefoneCelular . "^" .
        $outroTelefone . "^" .
        $email . "^" .
        $cep . "^" .
        $endereco . "^" .
        $bairro . "^" .
        $numero . "^" .
        $complemento . "^" .
        $estado . "^" .
        $cidade . "^" .
        $grauInstrucao . "^" .
        $grauParou . "^" .
        $anoConclusao . "^" .
        $cursandoAtualmente . "^" .
        $horarioEstudo . "^" .
        $nomeEnderecoColegioUniversidade . "^" .
        $atividadesExtracurriculares . "^" .
        $nomeConjuge . "^" .
        $naturalidadeConjuge . "^" .
        $nacionalidadeConjuge . "^" .
        $dataNascimentoConjuge . "^" .
        $trabalhaAtualmente . "^" .
        $desejaVt . "^" .
        $possuiVt . "^" .
        $numeroCartaoVt . "^" .
        $seguroDesemprego . "^" .
        $desejaAssistenciaMedica . "^" .
        $desejaAssistenciaOdontologica . "^" .
        $valeRefeicaoValeAlimentacao . "^" .
        $possuiContaBancaria . "^" .
        $fk_banco . "^" .
        $agenciaBanco . "^" .
        $contaCorrente . "^" .
        $numeroCamisa . "^" .
        $numeroCalca . "^" .
        $numeroSaia . "^" .
        $numeroSapato . "^" .
        $cnh . "^" .
        $categoriaCnh . "^" .
        $ufCnh . "^" .
        $rg . "^" .
        $emissorRg . "^" .
        $localRg . "^" .
        $dataEmissaoRg . "^" .
        $sexo . "^" .
        $localCarteiraTrabalho . "^" .
        $primeiroEmprego . "^" .
        $cargo . "^" .
        $verificaDadoPessoal . "^" .
        $verificaDadoContato . "^" .
        $verificaEndereco . "^" .
        $verificaDocumento . "^" .
        $verificaEscolaridade . "^" .
        $verificaDadoConjuge . "^" .
        $verificaFilho . "^" .
        $verificaDependente . "^" .
        $verificaBeneficio . "^" .
        $verificaVT . "^" .
        $verificaDadoBancario . "^" .
        $verificaCargo . "^" .
        $verificaUniforme . "^" .
        $verificaAnexoDocumento . "^" .
        $carteiraTrabalho . "^" .
        $carteiraTrabalhoSerie . "^" .
        $dataExpedicaoCarteiraTrabalho . "^" .
        $numeroPais . "^" .
        $paisNascimento . "^" .
        $ufNascimento . "^" .
        $numeroMunicipio . "^" .
        $municipioNascimento . "^" .
        $numeroPaisConjuge . "^" .
        $paisNascimentoConjuge . "^" .
        $ufNascimentoConjuge . "^" .
        $numeroMunicipioConjuge . "^" .
        $municipioNascimentoConjuge . "^" .
        $possuiFilhoMenor14  . "^" .
        $digitoAgenciaBanco . "^" .
        $digitoContaBanco . "^" .
        $tipoConta . "^" .
        $aprovado . "^" .
        $variacao . "^" .
        $codigoBanco . "^" .
        $projeto . "^" .
        $logradouro . "^" .
        $justificativaVt . "^" .
        $tipoCartaoVt;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayFilho . "#" . $strArrayDependente . "#" . $strArrayTransporte;
    return;
}

function recuperaUpload()
{

    $id = +$_POST['id'] ?: 0;
    $diretorioAlvo = "../uploads/";

    $sql = "SELECT codigo, nomeArquivo, enderecoDocumento, tipoArquivo, idCampo, candidato 
    FROM Contratacao.candidatoDocumento 
    WHERE (0=0) AND candidato = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorDocumento = 0;
    $arrayDocumentos = array();
    $out = "";
    while ($row = odbc_fetch_array($result)) {
        $row = array_map('utf8_encode', $row);
        $nomeArquivo = $row['nomeArquivo'];
        $enderecoDocumento = $row['enderecoDocumento'];
        $tipoArquivo = $row['tipoArquivo']; 
        $idCampo = $row['idCampo'];
 
        $contadorDocumento = $contadorDocumento + 1;
        $arrayDocumentos[] = array(
            "nomeArquivo" => $nomeArquivo,
            "enderecoDocumento" => $enderecoDocumento,
            "tipoArquivo" => $tipoArquivo, 
            "idCampo" => $idCampo
        );
    }
 
    $strArrayDocumentos = json_encode($arrayDocumentos);

    if ($strArrayDocumentos == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $strArrayDocumentos;
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
        $value = "0";
    }
    return $value;
}


function recuperaCpf()
{
    $id = (int) $_POST["codigoFuncionario"] ?: 0;
    $cpf = validaString($_POST["cpf"]);

    $sql = "SELECT codigo, cpf FROM Contratacao.candidato WHERE (0=0) AND cpf = " . $cpf;

    if ($id != 0) {
        $sql = $sql . " AND codigo =" . $id;
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])


    $codigo = $row['codigo'];
    $cpf = $row['cpf'];

    $out =   $codigo  . "^" . $cpf;

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
    $possuiPermissao = $reposit->PossuiPermissao("CANDIDATO_ACESSAR|CANDIDATO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = (int) $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um candidato.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Contratacao.candidato' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}



function tiraAcento($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
}
