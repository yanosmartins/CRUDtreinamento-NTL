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


return;

function grava()
{
    $codigo = $_POST['codigo'] ?: 0;
    $codigoFuncionario = $_POST['codigoFuncionario'] ?: 0;

    // Todos os endereços dos diretórios.
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

    // Aqui é definido quais tipos podem ser gravados no banco e na pasta
    $tipoArquivoPermitido = array(
        "pdf",
        "png",
        "jpg",
        "jpng",
        "zip"
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


    //Cria vários arrays baseados nos arquivos de upload.
    $certidaoNascimentoArray = $_FILES['certidaoNascimento'];
    $tamanho =  count($_FILES['certidaoNascimento']['name']);
    $uniqidCertidaoNascimento = md5(uniqid(rand(), true));
    for ($i = 0; $i < $tamanho; $i++) {
        str_replace("_", "-", $certidaoNascimentoArray["name"][$i]); //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $certidaoCasamentoArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $comprovanteResidenciaArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $cpfArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $pispasepArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $rgArray["name"][$i]);  //Substitui qualquer underline por traço. 
        $arrayCnh[$i] = array(
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
        str_replace("_", "-", $cnhArray["name"][$i]);  //Substitui qualquer underline por traço. 
        $arrayRg[$i] = array(
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
        str_replace("_", "-", $tituloEleitorArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $certificadoReservistaArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $comprovanteEscolaridadeArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $certificadoDiplomaArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $certidaoNascimentoFilhoArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $rgFilhoArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $cpfFilhoArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $certidaoNascimentoDependenteArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $rgDependenteArray["name"][$i]);  //Substitui qualquer underline por traço. 
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
        str_replace("_", "-", $cpfDependenteArray["name"][$i]);  //Substitui qualquer underline por traço. 
        $arrayCpfDependente[$i] = array(
            "nome" => $cpfDependenteArray["name"][$i],
            "tipo" => $cpfDependenteArray["type"][$i],
            "nomeTemporario" => $cpfDependenteArray["tmp_name"][$i],
            "enderecoDocumento" => "/uploads/cpfs-dos-dependentes/",
            "idCampo" => $idCpfDependente
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



    $reposit = new reposit();
    $sql = "Contratacao.upload_Atualiza(" . $codigo . ", " .
        $codigoFuncionario .  ", " .
        $xmlCertidaoNascimento .  ", " .
        $xmlCertidaoCasamento . ", " .
        $xmlComprovanteResidencia . ", " .
        $xmlCpf . ", " .
        $xmlPispasep . ", " .
        $xmlRg . ", " .
        $xmlCnh . ", " .
        $xmlTituloEleitor . ", " .
        $xmlCertificadoReservista . ", " .
        $xmlComprovanteEscolaridade . ", " .
        $xmlCertificadoDiploma . ", " .
        $xmlCertidaoNascimentoFilho . ", " .
        $xmlRgFilho . ", " .
        $xmlCpfFilho . ", " .
        $xmlCertidaoNascimentoDependente . ", " .
        $xmlRgDependente . ", " .
        $xmlCpfDependente . ")";
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

        str_replace("_", "-", $_FILES[$campo]['name'][$x]);  //Substitui qualquer underline por traço. 
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


// OBS: NECESSÁRIO REFAZER
function recupera()
{

    $id = +$_POST['id'] ?: 0;
    $diretorioAlvo = "../uploads/";

    $sql = "SELECT codigo, nomeArquivo, tipoArquivo, enderecoDocumento, funcionario, idCampo 
            FROM Ntl.candidatoDocumento 
            WHERE (0=0) AND funcionario = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorDocumento = 0;
    $arrayDocumentos = array();
    $out = "";
    while ($row = odbc_fetch_array($result)) {
        $row = array_map('utf8_encode', $row);
        $nomeArquivo = $row['nomeArquivo'];
        $tipoArquivo = $row['tipoArquivo'];
        $enderecoDocumento = $row['enderecoDocumento'];
        $idCampo = $row['idCampo'];


        $contadorDocumento = $contadorDocumento + 1;
        $arrayDocumentos[] = array(
            "nomeArquivo" => $nomeArquivo,
            "tipoArquivo" => $tipoArquivo,
            "enderecoDocumento" => $enderecoDocumento,
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
