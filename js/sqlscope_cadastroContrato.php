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
    $codigo = +$contrato['codigo'];
    $projeto = +$contrato['projeto'];
    $numeroPregao  = "'" . $contrato['numeroPregao'] . "'";
    $numeroContrato = "'" . $contrato['numeroContrato'] . "'";
    $contaVinculada = +$contrato['contaVinculada'];
    $caucaoAtivo = +$contrato['caucaoAtivo'];
    $caucao = +$contrato['caucao'];
    if($caucao == 0){
        $caucao = 'NULL';
    }
    
    $percentualCaucao = +$contrato['percentualCaucao'];

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

    $renovacao = +$contrato['renovacao'];
    $vigencia = +$contrato['vigencia'];
    $lucratividade = +$contrato['lucratividade'];
    $outros =  +$contrato['outros'];
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

    $ultimaRenovacao     = $contrato['ultimaRenovacao'];
    $periodoRenovado = +$contrato['periodoRenovado'];

    if ($contrato['limiteInteresse'] != "") {
        $aux = explode('/', $contrato['limiteInteresse']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $limiteInteresse = $data;
    } else {
        $limiteInteresse = 'NULL';
    }

    if ($contrato['envioInteresse'] != "") {
        $aux = explode('/', $contrato['envioInteresse']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $envioInteresse = $data;
    } else {
        $envioInteresse = 'NULL';
    }

    $anotacoesRenovacao = "'" . $contrato['anotacoesRenovacao'] . "'";
    $tipoFaturamento = "'" . $contrato['tipoFaturamento'] . "'";
    $prazoPagamento = "'" . $contrato['prazoPagamento'] . "'";
    $condicoesPrazo = "'" . $contrato['condicoesPrazo'] . "'";
    $indiceReajuste = +$contrato['indiceReajuste'];
    if($indiceReajuste == 0){
        $indiceReajuste = 'NULL';
    }
    $inicioReajuste = +$contrato['inicioReajuste'];
    if($inicioReajuste == 0){
        $inicioReajuste = 'NULL';
    }
    if ($contrato['periodoComunicacao'] != "") {
        $aux = explode('/', $contrato['periodoComunicacao']);
        $dia = 01;
        $data =  $aux[1] . '-' . $aux[0] . '-' . $dia;
        $data = "'" . trim($data) . "'";
        $periodoComunicacao = $data;
    } else {
        $periodoComunicacao = 'NULL';
    }

    if ($contrato['envioComunicacao'] != "") {
        $aux = explode('/', $contrato['envioComunicacao']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $envioComunicacao = $data;
    } else {
        $envioComunicacao = 'NULL';
    }

    $anotacoesComunicacao = "'" . $contrato['anotacoesComunicacao'] . "'";

    if ($contrato['periodoSolicitacao'] != "") {
        $aux = explode('/', $contrato['periodoSolicitacao']);
        $dia = 01;
        $data = $aux[1] . '-' . $aux[0] . '-' . $dia;
        $data = "'" . trim($data) . "'";
        $periodoSolicitacao = $data;
    } else {
        $periodoSolicitacao = 'NULL';
    }

    if ($contrato['envioSolicitacao'] != "") {
        $aux = explode('/', $contrato['envioSolicitacao']);
        $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $data = "'" . trim($data) . "'";
        $envioSolicitacao = $data;
    } else {
        $envioSolicitacao = 'NULL';
    }

    $anotacoesSolicitacao = "'" . $contrato['anotacoesSolicitacao'] . "'";
    $decimoTerceiro = +$contrato['decimoTerceiro'];
    if($decimoTerceiro == 0){
        $decimoTerceiro = "NULL";
    }
    $multaFGTS = +$contrato['multaFGTS'];
    if($multaFGTS == 0){
        $multaFGTS = "NULL";
    }
    $ferias = +$contrato['ferias'];
    if($ferias == 0){
        $ferias = "NULL";
    }

    $ativo = +$contrato['ativo'];




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
                if($valor == 'Selecione'){
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
        $xmlJsonFaturamento = "'".$xmlJsonFaturamento . "</" . $nomeXml . ">"."'";
    }
    $xml = simplexml_load_string($xmlJsonFaturamento);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de vale transporte modal";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    
    //Fim do Json  Faturamento

    



    $sql = "Ntl.contrato_Atualiza(            
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
                $xmlJsonFaturamento          
                )";

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
                    anotacoesSolicitacao 
                    FROM Ntl.contrato
                    WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if (($row = odbc_fetch_array($result)))
        $row = array_map('utf8_encode', $row);

    $id = $row['codigo'];
    $ativo = +$row['ativo'];
    $projeto = +$row['projeto'];
    $numeroPregao = $row['numeroPregao'];
    $numeroContrato = $row['numeroContrato'];
    $contaVinculada = +$row['contaVinculada'];
    $caucaoAtivo = +$row['caucaoAtivo'];
    $caucao = +$row['caucao'];
    $percentualCaucao = +$row['percentualCaucao'];

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

    $renovacao = +$row['renovacao'];
    $vigencia = +$row['vigencia'];
    $lucratividade = +$row['lucratividade'];
    $outros = +$row['outros'];
    $valorInicial = +$row['valorInicial'];
    $valorInicial = preencherValor($valorInicial);
    
    $valorAtual = +$row['valorAtual'];
    $valorAtual = preencherValor($valorAtual);

    $objetoContrato = $row['objetoContrato'];

    $decimoTerceiro = +$row['decimoTerceiro'];
    $multaFGTS = +$row['multaFGTS'];
    $ferias = +$row['ferias'];

    if ($row['dataRenovacao'] != "") {
        $aux = explode(' ', $row['dataRenovacao']);
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
    $ultimaRenovacao = +$row['ultimaRenovacao'];
    $periodoRenovado = $row['periodoRenovado'];

    if ($row['limiteInteresse'] != "") {
        $aux = explode(' ', $row['limiteInteresse']);
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

    if ($row['envioInteresse'] != "") {
        $aux = explode(' ', $row['envioInteresse']);
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

    $anotacoesRenovacao = $row['anotacoesRenovacao'];
    $tipoFaturamento = $row['tipoFaturamento'];
    $prazoPagamento = $row['prazoPagamento'];
    $condicoesPrazo = $row['condicoesPrazo'];
    $indiceReajuste = +$row['indiceReajuste'];
    $inicioReajuste = +$row['inicioReajuste'];

    if ($row['periodoComunicacao'] != "") {
        $aux = explode(' ', $row['periodoComunicacao']);
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
    if ($row['envioComunicacao'] != "") {
        $aux = explode(' ', $row['envioComunicacao']);
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

    $anotacoesComunicacao = $row['anotacoesComunicacao'];

    if ($row['periodoSolicitacao'] != "") {
        $aux = explode(' ', $row['periodoSolicitacao']);
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
    $anotacoesSolicitacao = $row['anotacoesSolicitacao'];




    // //----------------------Montando o array de Faturamento

    $reposit = "";
    $result = "";
    $sql = "SELECT FA.contrato AS clienteFaturamento, FA.localizacao,LO.descricao AS descricaoLocalizacao, FA.cepFaturamento, FA.logradouroFaturamento, 
    FA.numeroFaturamento, FA.complementoFaturamento,FA.bairroFaturamento, FA.cidadeFaturamento, FA.ufFaturamento, 
    FA.iss, ISS.percentual AS issPercentual, FA.inss, INSS.percentual AS inssPercentual,FA.ir, IR.percentual AS irPercentual, FA.pisConfisCs, PIS.percentual AS pisConfisCsPercentual,
    FA.codigoServico, SE.descricaoCodigo AS codigoDescricao, FA.descricaoServico, SE.descricaoServico AS servicoDescricao, FA.aliquotaIss
          FROM Ntl.faturamento FA
          
          LEFT JOIN Ntl.localizacao LO ON localizacao = LO.codigo 
          LEFT JOIN Ntl.iss ISS ON iss = ISS.codigo
          LEFT JOIN Ntl.inss INSS ON inss = INSS.codigo
          LEFT JOIN Ntl.ir IR ON ir = IR.codigo
          LEFT JOIN Ntl.pisConfisCs PIS ON pisConfisCs = PIS.codigo
          LEFT JOIN Ntl.servico SE ON codigoServico = SE.codigo
          WHERE clienteFaturamento = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $contadorFaturamento = 0;
    $arrayFaturamento = array();
    while ($row = odbc_fetch_array($result)) {

        $localizacao = +$row['localizacao'];
        $localizacaoText = mb_convert_encoding($row['descricaoLocalizacao'], 'UTF-8', 'HTML-ENTITIES');
        $cepFaturamento = $row['cepFaturamento'];
        $logradouroFaturamento = mb_convert_encoding($row['logradouroFaturamento'], 'UTF-8', 'HTML-ENTITIES');
        $numeroFaturamento = $row['numeroFaturamento'];
        $complementoFaturamento = mb_convert_encoding($row['complementoFaturamento'], 'UTF-8', 'HTML-ENTITIES');
        $bairroFaturamento = mb_convert_encoding($row['bairroFaturamento'], 'UTF-8', 'HTML-ENTITIES');
        $cidadeFaturamento = mb_convert_encoding($row['cidadeFaturamento'], 'UTF-8', 'HTML-ENTITIES');
        $ufFaturamento = mb_convert_encoding($row['ufFaturamento'], 'UTF-8', 'HTML-ENTITIES');
        $iss = +$row['iss'];
        $issText = $row['issPercentual'];
        $inss = +$row['inss'];
        $inssText = $row['inssPercentual'];
        $ir = +$row['ir'];
        $irText = $row['irPercentual'];
        $pisConfisCs = +$row['pisConfisCs'];
        $pisConfisCsText = $row['pisConfisCsPercentual'];
        $codigoServico = +$row['codigoServico'];
        $codigoServicoText = $row['codigoDescricao'];
        $descricaoServico = +$row['descricaoServico'];
        $descricaoServicoText = mb_convert_encoding($row['servicoDescricao'], 'UTF-8', 'HTML-ENTITIES');
        $aliquotaIss = +$row['aliquotaIss'];




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
        $anotacoesSolicitacao;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $strArrayFaturamento;
    return;
}

function preencheProjeto()
{
    $projeto = +$_POST['projeto'];

    $reposit = new reposit();


    $sql = "SELECT codigo, cnpj, razaoSocial, cep, endereco, numeroEndereco, complemento, bairro, cidade, estado
    FROM Ntl.projeto WHERE codigo = $projeto";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    $out = "";

    if (($row = odbc_fetch_array($result))) {
        $row = array_map('utf8_encode', $row);

        $cnpj = $row['cnpj'];
        $razaoSocial = $row['razaoSocial'];
        $cep =  $row['cep'];
        $logradouro =  $row['endereco'];
        $numero =  $row['numeroEndereco'];
        $complemento =  $row['complemento'];
        $bairro =  $row['bairro'];
        $cidade =  $row['cidade'];
        $uf =  $row['estado'];
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

    if (($row = odbc_fetch_array($result))) {
        $row = array_map('utf8_encode', $row);

        $objetoLicitado = $row['objetoLicitado'];
        $out =  $objetoLicitado;
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

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Código de Servico.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "UPDATE Ntl.contrato SET ativo ='0' WHERE codigo=$id";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

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
    while (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $descricao = mb_convert_encoding($row["descricao"], 'UTF-8', 'HTML-ENTITIES');
        $numeroCentroCusto  = +$row['numeroCentroCusto'];
        $apelido = mb_convert_encoding($row["apelido"], 'UTF-8', 'HTML-ENTITIES');
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
    while (($row = odbc_fetch_array($result))) {
        $id = +$row['codigo'];
        $numeroPregao = mb_convert_encoding($row["numeroPregao"], 'UTF-8', 'HTML-ENTITIES');
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
    return +$string;
}

function preencherValor($string)
{
    // $string = preg_replace('/[^A-Za-z0-9,\-]/', '', $string);
    $string = str_replace('.', ',', $string);

    return $string;
}

