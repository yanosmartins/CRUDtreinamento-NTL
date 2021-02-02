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
if ($funcao == 'preencheProjeto') {
    call_user_func($funcao);
}
if ($funcao == 'preenchePregao') {
    call_user_func($funcao);
}
if ($funcao == 'listaNumeroPregaoAutoComplete') {
    call_user_func($funcao);
}


if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'listaProjetoAutoComplete') {
    call_user_func($funcao);
}
return;

function grava()
{
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";
    $contrato = $_POST['contrato'];
    $codigo = (int)$contrato['codigo'];
    $projeto = (int)$contrato['projeto'];
    $numeroPregao  = "'" . $contrato['numeroPregao'] . "'";
    $numeroContrato = "'" . $contrato['numeroContrato'] . "'";
    $contaVinculada = (int)$contrato['contaVinculada'];
    $caucaoAtivo = (int)$contrato['caucaoAtivo'];
    $caucao = (int)$contrato['caucao'];
    if ($caucao == 0) {
        $caucao = 'NULL';
    }

    $percentualCaucao = (float)$contrato['percentualCaucao'];

    if ($contrato['dataAssinatura'] != "") {
        $aux = explode('/', $contrato['dataAssinatura']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $dataAssinatura = $data;
    } else {
        $dataAssinatura = 'NULL';
    }

    if ($contrato['dataInicio'] != "") {
        $aux = explode('/', $contrato['dataInicio']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $dataInicio = $data;
    } else {
        $dataInicio = 'NULL';
    }

    $renovacao = (int)$contrato['renovacao'];
    $vigencia = (int)$contrato['vigencia'];
    $lucratividade = (float)$contrato['lucratividade'];
    $outros =  (float)$contrato['outros'];
    $valorInicial =  $contrato['valorInicial'];
    $valorInicial = limparValor($valorInicial);
    $valorAtual =  $contrato['valorAtual'];
    $valorAtual = limparValor($valorAtual);
    $objetoContrato = "'" . $contrato['objetoContrato'] . "'";



    if ($contrato['dataRenovacao'] != "") {
        $aux = explode('/', $contrato['dataRenovacao']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $dataRenovacao = $data;
    } else {
        $dataRenovacao = 'NULL';
    }

    $ultimaRenovacao = (int)$contrato['ultimaRenovacao'];
    $periodoRenovado = (int)$contrato['periodoRenovado'];

    if ($contrato['limiteInteresse'] != "") {
        $aux = explode('/', $contrato['limiteInteresse']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $limiteInteresse = (string)$data;
    } else {
        $limiteInteresse = 'NULL';
    }

    if ($contrato['envioInteresse'] != "") {
        $aux = explode('/', $contrato['envioInteresse']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $envioInteresse = (string)$data;
    } else {
        $envioInteresse = 'NULL';
    }

    $anotacoesRenovacao = "'" . $contrato['anotacoesRenovacao'] . "'";
    $tipoFaturamento = "'" . $contrato['tipoFaturamento'] . "'";
    $prazoPagamento = "'" . $contrato['prazoPagamento'] . "'";
    $condicoesPrazo = "'" . $contrato['condicoesPrazo'] . "'";
    $indiceReajuste = (int)$contrato['indiceReajuste'];
    if ($indiceReajuste == 0) {
        $indiceReajuste = 'NULL';
    }
    $inicioReajuste = (int)$contrato['inicioReajuste'];
    if ($inicioReajuste == 0) {
        $inicioReajuste = 'NULL';
    }
    if ($contrato['periodoComunicacao'] != "") {
        $aux = explode('/', $contrato['periodoComunicacao']);
        $dia = 01;
        $data =  $aux[1] . '-' . $aux[0] . '-' . $dia;
        $data = "'" . trim($data) . "'";
        $periodoComunicacao = (string)$data;
    } else {
        $periodoComunicacao = 'NULL';
    }

    if ($contrato['envioComunicacao'] != "") {
        $aux = explode('/', $contrato['envioComunicacao']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $envioComunicacao = (string)$data;
    } else {
        $envioComunicacao = 'NULL';
    }

    $anotacoesComunicacao = "'" . $contrato['anotacoesComunicacao'] . "'";

    if ($contrato['periodoSolicitacao'] != "") {
        $aux = explode('/', $contrato['periodoSolicitacao']);
        $dia = 01;
        $data = $aux[1] . '-' . $aux[0] . '-' . $dia;
        $data = "'" . trim($data) . "'";
        $periodoSolicitacao = (string)$data;
    } else {
        $periodoSolicitacao = 'NULL';
    }

    if ($contrato['envioSolicitacao'] != "") {
        $aux = explode('/', $contrato['envioSolicitacao']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $envioSolicitacao = (string)$data;
    } else {
        $envioSolicitacao = 'NULL';
    }

    $anotacoesSolicitacao = "'" . $contrato['anotacoesSolicitacao'] . "'";
    $decimoTerceiro = (int)$contrato['decimoTerceiro'];
    if ($decimoTerceiro == 0) {
        $decimoTerceiro = "NULL";
    }
    $multaFGTS = (int)$contrato['multaFGTS'];
    if ($multaFGTS == 0) {
        $multaFGTS = "NULL";
    }
    $ferias = (int)$contrato['ferias'];
    if ($ferias == 0) {
        $ferias = "NULL";
    }

    $ativo = (int)$contrato['ativo'];

    $nomeContato = $contrato['nomeContato'];
    $funcaoContrato = $contrato['funcao'];
    $setor = $contrato['setor'];
    $telefone = $contrato['telefone'];
    $celular = $contrato['celular'];
    $email = $contrato['email'];
    $autorizaNF = $contrato['autorizaNF'];

    //Inicio do Json Faturamento
    $strJsonFaturamento = $contrato["JsonFaturamento"];
    $arrayJsonFaturamento = json_decode($strJsonFaturamento, true);
    $xmlJsonFaturamento = "";
    $nomeXml = "ArrayOfContratoFaturamento";
    $nomeTabela = "contratoFaturamento";
    if (sizeof($arrayJsonFaturamento) > 0) {
        $xmlJsonFaturamento = '<?xml version="1.0"?>';
        $xmlJsonFaturamento = $xmlJsonFaturamento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonFaturamento as $chave) {
            $xmlJsonFaturamento = $xmlJsonFaturamento . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialFaturamento")) {
                    continue;
                }
                if ($valor == 'Selecione') {
                    $valor = NULL;
                }
                $xmlJsonFaturamento = $xmlJsonFaturamento . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonFaturamento = $xmlJsonFaturamento . "</" . $nomeTabela . ">";
        }
        $xmlJsonFaturamento = $xmlJsonFaturamento . "</" . $nomeXml . ">";
    } else {
        $xmlJsonFaturamento = '<?xml version="1.0"?>';
        $xmlJsonFaturamento = $xmlJsonFaturamento . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonFaturamento = $xmlJsonFaturamento . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonFaturamento);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonFaturamento = "'" . $xmlJsonFaturamento . "'";


    //Fim do Json  Faturamento
    $sql = "Ntl.contrato_Atualiza          
                $codigo,
                $ativo,
                $projeto,
                $numeroPregao,
                $numeroContrato,
                $contaVinculada,			
                $caucaoAtivo,
                $caucao,
                $percentualCaucao,				              		 
                $dataAssinatura,		
                $dataInicio,			
                $renovacao,			
                $vigencia,
                $lucratividade,	
                $outros,
                $valorInicial,			
                $valorAtual,			               				
                $objetoContrato,
                $decimoTerceiro,
                $ferias,
                $multaFGTS,
                $dataRenovacao,				
                $periodoRenovado,
                $ultimaRenovacao, 
				$limiteInteresse,
				$envioInteresse,
				$anotacoesRenovacao,
				$tipoFaturamento,
				$prazoPagamento,
				$condicoesPrazo,
				$indiceReajuste,
                $inicioReajuste,
                $periodoComunicacao,
                $envioComunicacao,              
                $anotacoesComunicacao,
                $periodoSolicitacao,
                $envioSolicitacao,               
                $anotacoesSolicitacao, 
                $usuario,
                $nomeContato,
                $funcaoContrato,
                $setor,
                $telefone,
                $celular,
                $email,
                $autorizaNF,
                $xmlJsonFaturamento          
                ";

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

    $sql = "SELECT  codigo,
                    ativo,
                    projeto,
                    numeroPregao,
                    numeroContrato,
                    contaVinculada,			
                    caucaoAtivo,
                    caucao,
                    percentualCaucao,				              		 
                    dataAssinatura,		
                    dataInicio,			
                    renovacao,			
                    vigencia,
                    lucratividade,	
                    outros,
                    valorInicial,			
                    valorAtual,			               				
                    objetoContrato,
                    decimoTerceiro,
                    ferias,
                    multaFGTS,
                    dataRenovacao,
                    ultimaRenovacao,
                    periodoRenovado, 
                    limiteInteresse,
                    envioInteresse,
                    anotacoesRenovacao,
                    tipoFaturamento,
                    prazoPagamento,
                    condicoesPrazo,
                    indiceReajuste,
                    inicioReajuste,
                    periodoComunicacao,
                    envioComunicacao,              
                    anotacoesComunicacao,
                    periodoSolicitacao,
                    envioSolicitacao,               
                    anotacoesSolicitacao,
                    contato AS 'nomeContato',
                    funcao AS 'funcaoContrato',
                    setor,
                    email,
                    telefone,
                    celular,
                    autorizaNF 
                    FROM Ntl.contrato
                    WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0])


        $id = (int)$row['codigo'];
    $ativo = (int)$row['ativo'];
    $projeto = (int)$row['projeto'];
    $numeroPregao = (string)$row['numeroPregao'];
    $numeroContrato = (string)$row['numeroContrato'];
    $contaVinculada = (int)$row['contaVinculada'];
    $caucaoAtivo = (int)$row['caucaoAtivo'];
    $caucao = (int)$row['caucao'];
    $percentualCaucao = (float)$row['percentualCaucao'];

    if ($row['dataAssinatura'] != "") {
        $aux = explode(' ', $row['dataAssinatura']);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $dataAssinatura = $data;
    } else {
        $dataAssinatura = '';
    }

    if ($row['dataInicio'] != "") {
        $aux = explode(' ', $row['dataInicio']);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $dataInicio = $data;
    } else {
        $dataInicio = '';
    }

    $renovacao = (int)$row['renovacao'];
    $vigencia = (int)$row['vigencia'];
    $lucratividade = (float)$row['lucratividade'];
    $outros = (float)$row['outros'];
    $valorInicial = (float)$row['valorInicial'];
    $valorInicial = preencherValor($valorInicial);

    $valorAtual = (float)$row['valorAtual'];
    $valorAtual = preencherValor($valorAtual);

    $objetoContrato = (string)$row['objetoContrato'];

    $decimoTerceiro = (int)$row['decimoTerceiro'];
    $multaFGTS = (int)$row['multaFGTS'];
    $ferias = (int)$row['ferias'];

    $dataRenovacao = (string)$row['dataRenovacao'];
    if ($dataRenovacao != "") {
        $aux = explode(' ', $dataRenovacao);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $dataRenovacao = $data;
    } else {
        $dataRenovacao = '';
    }

    $ultimaRenovacao = (int)$row['ultimaRenovacao'];
    $periodoRenovado = (string)$row['periodoRenovado'];

    $limiteInteresse = (string)$row['limiteInteresse'];
    if ($limiteInteresse != "") {
        $aux = explode(' ', $limiteInteresse);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $limiteInteresse = $data;
    } else {
        $limiteInteresse = '';
    }

    $envioInteresse = (string)$row['envioInteresse'];
    if ($envioInteresse != "") {
        $aux = explode(' ', $envioInteresse);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $envioInteresse = $data;
    } else {
        $envioInteresse = '';
    }

    $anotacoesRenovacao = (string)$row['anotacoesRenovacao'];
    $tipoFaturamento = (string)$row['tipoFaturamento'];
    $prazoPagamento = (string)$row['prazoPagamento'];
    $condicoesPrazo = (string)$row['condicoesPrazo'];
    $indiceReajuste = (int)$row['indiceReajuste'];
    $inicioReajuste = (int)$row['inicioReajuste'];

    $periodoComunicacao = (string)$row['periodoComunicacao'];
    if ($periodoComunicacao != "") {
        $aux = explode(' ', $periodoComunicacao);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $periodoComunicacao = $data;
    } else {
        $periodoComunicacao = '';
    }

    $envioComunicacao = (string)$row['envioComunicacao'];
    if ($envioComunicacao != "") {
        $aux = explode(' ', $envioComunicacao);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $envioComunicacao = $data;
    } else {
        $envioComunicacao = '';
    }

    $anotacoesComunicacao = (string)$row['anotacoesComunicacao'];

    $periodoSolicitacao = (string)$row['periodoSolicitacao'];
    if ($periodoSolicitacao != "") {
        $aux = explode(' ', $periodoSolicitacao);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data = $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $periodoSolicitacao = $data;
    } else {
        $periodoSolicitacao = '';
    }
    if ($row['envioSolicitacao'] != "") {
        $aux = explode(' ', $row['envioSolicitacao']);
        $data = $aux[1] . ' ' . $aux[0];
        $data = $aux[0];
        $data =  trim($data);
        $aux = explode('-', $data);
        $data =  $aux[2] . '/' . $aux[1] . '/' . $aux[0];
        $data =  trim($data);
        $envioSolicitacao = $data;
    } else {
        $envioSolicitacao = '';
    }
    $anotacoesSolicitacao = (string)$row['anotacoesSolicitacao'];
    $nomeContato = $row['nomeContato'];
    $funcaoContrato = (int)$row['funcaoContrato'];
    $setor = $row['setor'];
    $email = $row['email'];
    $telefone = $row['telefone'];
    $celular = $row['celular'];
    $autorizaNF = (int)$row['autorizaNF'];

    // //----------------------Montando o array de Faturamento

    $reposit = "";
    $result = "";
    $sql = "SELECT FA.contrato AS contrato, FA.localizacao,LO.descricao AS descricaoLocalizacao, FA.cepFaturamento, FA.logradouroFaturamento, 
    FA.numeroFaturamento, FA.complementoFaturamento,FA.bairroFaturamento, FA.cidadeFaturamento, FA.ufFaturamento, 
    FA.iss, ISS.percentual AS issPercentual, FA.inss, INSS.percentual AS inssPercentual,FA.ir, IR.percentual AS irPercentual, FA.pisConfisCs, PIS.percentual AS pisConfisCsPercentual,
    FA.codigoServico, SE.descricaoCodigo AS codigoDescricao, FA.descricaoServico, SE.descricaoServico AS servicoDescricao, FA.aliquotaIss
          FROM Ntl.contratoFaturamento FA
          
          LEFT JOIN Ntl.localizacao LO ON localizacao = LO.codigo 
          LEFT JOIN Ntl.iss ISS ON iss = ISS.codigo
          LEFT JOIN Ntl.inss INSS ON inss = INSS.codigo
          LEFT JOIN Ntl.ir IR ON ir = IR.codigo
          LEFT JOIN Ntl.pisConfisCs PIS ON pisConfisCs = PIS.codigo
          LEFT JOIN Ntl.servico SE ON codigoServico = SE.codigo
          WHERE contrato = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorFaturamento = 0;
    $arrayFaturamento = array();
    foreach ($result as $row) {

        $localizacao = (int)$row['localizacao'];
        $localizacaoText = (string)$row['descricaoLocalizacao'];
        $cepFaturamento = (string)$row['cepFaturamento'];
        $logradouroFaturamento = $row['logradouroFaturamento'];
        $numeroFaturamento = (string)$row['numeroFaturamento'];
        $complementoFaturamento = (string)$row['complementoFaturamento'];
        $bairroFaturamento = (string)$row['bairroFaturamento'];
        $cidadeFaturamento = (string)$row['cidadeFaturamento'];
        $ufFaturamento = (string)$row['ufFaturamento'];
        $iss = (int)$row['iss'];
        $issText = (string)$row['issPercentual'];
        $inss = (int)$row['inss'];
        $inssText = (string)$row['inssPercentual'];
        $ir = (int)$row['ir'];
        $irText = (string)$row['irPercentual'];
        $pisConfisCs = (int)$row['pisConfisCs'];
        $pisConfisCsText = (string)$row['pisConfisCsPercentual'];
        $codigoServico = (int)$row['codigoServico'];
        $codigoServicoText = (string)$row['codigoDescricao'];
        $descricaoServico = (int)$row['descricaoServico'];
        $descricaoServicoText = (string)$row['servicoDescricao'];
        $aliquotaIss = (int)$row['aliquotaIss'];

        $contadorFaturamento = $contadorFaturamento + 1;
        $arrayFaturamento[] = array(
            "sequencialFaturamento" => $contadorFaturamento,
            "localizacao" => $localizacao,
            "localizacaoText" => $localizacaoText,
            "cepFaturamento" => $cepFaturamento,
            "logradouroFaturamento" => $logradouroFaturamento,
            "numeroFaturamento" => $numeroFaturamento,
            "complementoFaturamento" => $complementoFaturamento,
            "bairroFaturamento" => $bairroFaturamento,
            "cidadeFaturamento" => $cidadeFaturamento,
            "ufFaturamento" => $ufFaturamento,
            "iss" => $iss,
            "issText" => $issText,
            "inss" => $inss,
            "inssText" => $inssText,
            "ir" => $ir,
            "irText" => $irText,
            "pisConfisCs" => $pisConfisCs,
            "pisConfisCsText" => $pisConfisCsText,
            "codigoServico" => $codigoServico,
            "codigoServicoText" => $codigoServicoText,
            "descricaoServico" => $descricaoServico,
            "descricaoServicoText" => $descricaoServicoText,
            "aliquotaIss" => $aliquotaIss
        );
    }

    $strArrayFaturamento = json_encode($arrayFaturamento);
    //------------------------Fim do Array Faturamento

    $out =
        $id . "^" .
        $ativo . "^" .
        $projeto . "^" .
        $numeroPregao . "^" .
        $numeroContrato . "^" .
        $contaVinculada . "^" .
        $caucaoAtivo . "^" .
        $caucao . "^" .
        $percentualCaucao . "^" .
        $dataAssinatura . "^" .
        $dataInicio . "^" .
        $renovacao . "^" .
        $vigencia . "^" .
        $lucratividade . "^" .
        $outros . "^" .
        $valorInicial . "^" .
        $valorAtual . "^" .
        $objetoContrato . "^" .
        $decimoTerceiro . "^" .
        $ferias . "^" .
        $multaFGTS . "^" .
        $dataRenovacao . "^" .
        $ultimaRenovacao . "^" .
        $periodoRenovado . "^" .
        $limiteInteresse . "^" .
        $envioInteresse . "^" .
        $anotacoesRenovacao . "^" .
        $tipoFaturamento . "^" .
        $prazoPagamento . "^" .
        $condicoesPrazo . "^" .
        $indiceReajuste . "^" .
        $inicioReajuste . "^" .
        $periodoComunicacao . "^" .
        $envioComunicacao . "^" .
        $anotacoesComunicacao . "^" .
        $periodoSolicitacao . "^" .
        $envioSolicitacao . "^" .
        $anotacoesSolicitacao . "^" .
        $nomeContato . "^" .
        $funcaoContrato . "^" .
        $setor . "^" .
        $email . "^" .
        $telefone . "^" .
        $celular . "^" .
        $autorizaNF;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayFaturamento;
    return;
}

function preencheProjeto()
{
    $projeto = (int) $_POST['projeto'];

    $reposit = new reposit();


    $sql = "SELECT codigo, cnpj, razaoSocial, cep, endereco, numeroEndereco, complemento, bairro, cidade, estado
    FROM Ntl.projeto WHERE codigo = $projeto";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";

    if ($row = $result[0]) {
        $cnpj = (string)$row['cnpj'];
        $razaoSocial = (string)$row['razaoSocial'];
        $cep = (string)$row['cep'];
        $logradouro = (string)$row['endereco'];
        $numero = (string)$row['numeroEndereco'];
        $complemento = (string)$row['complemento'];
        $bairro = (string)$row['bairro'];
        $cidade = (string)$row['cidade'];
        $uf = (string)$row['estado'];
    }

    $out =  $cnpj . "^" .
        $razaoSocial . "^" .
        $cep . "^" .
        $logradouro . "^" .
        $numero . "^" .
        $complemento . "^" .
        $bairro  . "^" .
        $cidade  . "^" .
        $uf;

    if ($out != '' || $out == 0) {
        echo "sucess#" . $out;
    }
    return;
}

function preenchePregao()
{
    $numeroPregao = $_POST['numeroPregao'];

    $reposit = new reposit();

    $sql = "SELECT objetoLicitado
    FROM Ntl.garimpaPregao WHERE numeroPregao = '$numeroPregao'";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";

    if ($row = $result[0]) {


        $objetoLicitado = (string)$row['objetoLicitado'];
        $out = $objetoLicitado;
    }
    // nao considerar vazio pois pode ter um pregao nao cadastrado no sisgc e sera
    //cadastrado na hora
    if ($out == 0) {
        echo "sucess#" . $out;
    }
    return;
}


function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CONTRATO_ACESSAR|CONTRATO_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um contrato para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    $result = $reposit->update('Ntl.contrato' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function listaProjetoAutoComplete()
{
    $condicaoDescricao = !((empty($_POST["descricaoIniciaCom"])) || (!isset($_POST["descricaoIniciaCom"])) || (is_null($_POST["descricaoIniciaCom"])));

    if ($condicaoDescricao === false) {
        return;
    }

    if ($condicaoDescricao) {
        $descricaoPesquisa = $_POST["descricaoIniciaCom"];
    }


    $reposit = new reposit();
    $sql = "SELECT C.codigo, C.projeto, P.numeroCentroCusto, P.descricao, P.apelido
     FROM Ntl.contrato C
     LEFT JOIN syscbNtl.syscb.projeto P ON projeto = P.numeroCentroCusto 
      WHERE apelido LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY apelido";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach ($result as $row) {
        $id = (int)$row['codigo'];
        $descricao = (string)$row["descricao"];
        $numeroCentroCusto = (string)$row['numeroCentroCusto'];
        $apelido = (string)$row["apelido"];
        $contador = $contador + 1;
        $array[] = array("id" => $id, "numeroCentroCusto" => $numeroCentroCusto, "apelido" => $apelido, "descricao" => $descricao);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}
function listaNumeroPregaoAutoComplete()
{
    $condicaoDescricao = !((empty($_POST["descricaoIniciaCom"])) || (!isset($_POST["descricaoIniciaCom"])) || (is_null($_POST["descricaoIniciaCom"])));

    if ($condicaoDescricao === false) {
        return;
    }

    if ($condicaoDescricao) {
        $descricaoPesquisa = $_POST["descricaoIniciaCom"];
    }


    $reposit = new reposit();
    $sql = "SELECT codigo, numeroPregao
     FROM Ntl.garimpaPregao
      WHERE numeroPregao LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY numeroPregao";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach ($result as $row) {
        $id = (int)$row['codigo'];
        $numeroPregao = (string)$row["numeroPregao"];
        $contador = $contador + 1;
        $array[] = array("id" => $id, "numeroPregao" => $numeroPregao);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}

function limparValor($string)
{
    $string = preg_replace('/[^A-Za-z0-9,\-]/', '', $string);
    $string = str_replace(',', '.', $string);
    return (int)$string;
}

function preencherValor($string)
{
    // $string = preg_replace('/[^A-Za-z0-9,\-]/', '', $string);
    $string = str_replace('.', ',', $string);

    return $string;
}
