<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaBeneficio') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaBeneficio') {
    call_user_func($funcao);
}
if ($funcao == 'recuperaValeTransporteModal') {
    call_user_func($funcao);
}
if ($funcao == 'recuperaValeTransporteUnitario') {
    call_user_func($funcao);
}
if ($funcao == 'listaComboVT') {
    call_user_func($funcao);
}
if ($funcao == 'populaComboProdutoPlanoSaude') {
    call_user_func($funcao);
}
if ($funcao == 'listaComboVT') {
    call_user_func($funcao);
}

if ($funcao == 'excluirBeneficio') {
    call_user_func($funcao);
}
if ($funcao == 'calculaIdadeFuncionario') {
    call_user_func($funcao);
}
if ($funcao == 'calculaIdadeDependente') {
    call_user_func($funcao);
}
if ($funcao == 'valorProdutoPlanoSaude') {
    call_user_func($funcao);
}
if ($funcao == 'populaCobrancaPlanoSaude') {
    call_user_func($funcao);
}
if ($funcao == 'populaComboNomeDependentePlanoSaude') {
    call_user_func($funcao);
}
if ($funcao == 'descontoTipoDiaUtilSindicato') {
    call_user_func($funcao);
}
if ($funcao == 'valorDescontoProjetoValeRefeicao') {
    call_user_func($funcao);
}
if ($funcao == 'valorDescontoSindicatoValeRefeicao') {
    call_user_func($funcao);
}
if ($funcao == 'valorDescontoSindicatoPlanoSaude') {
    call_user_func($funcao);
}
if ($funcao == 'valorDescontoProjetoPlanoSaude') {
    call_user_func($funcao);
}
if ($funcao == 'valorDescontoProdutoPlanoSaude') {
    call_user_func($funcao);
}
if ($funcao == 'valorBolsaBeneficioSindicato') {
    call_user_func($funcao);
}
if ($funcao == 'descricaoSindicato') {
    call_user_func($funcao);
}
if ($funcao == 'recuperaDescontoVR') {
    call_user_func($funcao);
}
if ($funcao == 'recuperaDescontoVA') {
    call_user_func($funcao);
}
if ($funcao == 'valorCestaBasicaSindicato') {
    call_user_func($funcao);
}
if ($funcao == 'verificaFuncionarioProjeto') {
    call_user_func($funcao);
}
if ($funcao == 'preencheValorPosto') {
    call_user_func($funcao);
}
if ($funcao == 'populaComboDescricaoPosto') {
    call_user_func($funcao);
}

return;

function gravaBeneficio()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("VALETRANSPORTEUNITARIO_ACESSAR|VALETRANSPORTEUNITARIO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.

    $beneficio = $_POST['beneficio'];
    $codigo =  validaNumero($beneficio['codigo']);
    $projeto = validaNumero($beneficio['projeto']);
    $funcionario = validaNumero($beneficio['funcionario']);
    $tipoDiaUtil = validaNumero($beneficio['tipoDiaUtil']);
    $sindicato = validaNumero($beneficio['sindicato']);
    $municipioDiasUteisVAVR = $beneficio['municipioDiasUteis'] ?: 'null';
    $municipioDiasUteisVT = validaNumero($beneficio['municipioDiasUteisVT']);

    //###########       VAVR      ###############//
    $percentualDescontoProjetoVAVR = validaNumero($beneficio['percentualDescontoProjetoVA']);
    $valorDescontoProjetoVAVR = validaNumero($beneficio['valorDescontoProjetoVA']);
    $percentualDescontoSindicatoVAVR = validaNumero($beneficio['percentualDescontoSindicatoVA']);
    $valorDescontoSindicatoVAVR = validaNumero($beneficio['valorDescontoSindicatoVA']);
    $valorDiarioFuncionarioVAVR = validaNumero($beneficio['valorDiarioFuncionarioVA']);
    $valorMensalFuncionarioVAVR = validaNumero($beneficio['valorMensalFuncionarioVA']);
    $percentualDescontoMesCorrenteVAVR = validaNumero($beneficio['percentualDescontoMesCorrenteVA']);
    $valorDescontoMesCorrenteVAVR = validaNumero($beneficio['valorDescontoMesCorrenteVA']);
    $valorDiarioFuncionarioVAVR = validaNumero($beneficio['valorDiarioFuncionarioVA']);
    $valorDiarioProjetoVAVR = validaNumero($beneficio['valorDiarioProjetoVA']);
    $valorMensalProjetoVAVR = validaNumero($beneficio['valorMensalProjetoVA']);
    $valorDiarioSindicatoVAVR = validaNumero($beneficio['valorDiarioSindicatoVA']);
    $valorMensalSindicatoVAVR = validaNumero($beneficio['valorMensalSindicatoVA']);
    $percentualDescontoFolhaFuncionarioVAVR = validaNumero($beneficio['percentualDescontoFolhaFuncionarioVA']);
    $valorDescontoFolhaFuncionarioVAVR = validaNumero($beneficio['valorDescontoFolhaFuncionarioVA']);
    $valorProdutoVAVR = validaNumero($beneficio['valorProdutoVAVR']);
    $valorFuncionarioVAVR = validaNumero($beneficio['valorFuncionarioVAVR']);
    $valorEmpresaVAVR = validaNumero($beneficio['valorEmpresaVAVR']);
    $tipoDescontoVAVR = validaNumero($beneficio['tipoDescontoVA']);




    //##########    BENEFICIO/ CESTA BÁSICA    ###########//
    $valorCestaBasica = validaNumero($beneficio['valorCestaBasica']);
    $valorMensalSindicatoCestaBasica = validaNumero($beneficio['valorMensalSindicatoCestaBasica']);
    $percentualDescontoSindicatoCestaBasica = validaNumero($beneficio['percentualDescontoSindicatoCestaBasica']);
    $valorDescontoSindicatoCestaBasica = validaNumero($beneficio['valorDescontoSindicatoCestaBasica']);
    $perdaBeneficio = validaNumero($beneficio['perdaBeneficio']);

    //#########     DIAS ÚTEIS VAVR ##########//
    $diaUtilJaneiro        = validaNumero($beneficio['diaUtilJaneiro']);
    $diaUtilFevereiro    = validaNumero($beneficio['diaUtilFevereiro']);
    $diaUtilMarco        = validaNumero($beneficio['diaUtilMarco']);
    $diaUtilAbril        = validaNumero($beneficio['diaUtilAbril']);
    $diaUtilMaio        = validaNumero($beneficio['diaUtilMaio']);
    $diaUtilJunho        = validaNumero($beneficio['diaUtilJunho']);
    $diaUtilJulho        = validaNumero($beneficio['diaUtilJulho']);
    $diaUtilAgosto        = validaNumero($beneficio['diaUtilAgosto']);
    $diaUtilSetembro    = validaNumero($beneficio['diaUtilSetembro']);
    $diaUtilOutubro     = validaNumero($beneficio['diaUtilOutubro']);
    $diaUtilNovembro    = validaNumero($beneficio['diaUtilNovembro']);
    $diaUtilDezembro    = validaNumero($beneficio['diaUtilDezembro']);
    $valorTotalPlanoSaude = validaNumero($beneficio['valorTotalGeral']);
    $valorTotalTitularPlanoSaude = validaNumero($beneficio['valorTotalTitular']);
    $valorTotalDependentePlanoSaude = validaNumero($beneficio['valorTotalDependente']);
    $consideraVAVR = validaNumero($beneficio['consideraVa']);
    $consideraVr = validaNumero($beneficio['consideraVr']);
    $consideraVt = validaNumero($beneficio['consideraVt']);
    $tipoDiaUtilVAVR = validaNumero($beneficio['tipoDiaUtilVAVR']);

    // $valorTotalFuncionarioVT = $beneficio['valorTotalFuncionarioVT'];
    $valorTotalFuncionarioVT = (float)(str_replace(',', '.', $beneficio['valorTotalFuncionarioVT']));
    //Dias Uteis VT
    $diaUtilJaneiroVT        = validaNumero($beneficio['diaUtilJaneiroVT']);
    $diaUtilFevereiroVT    = validaNumero($beneficio['diaUtilFevereiroVT']);
    $diaUtilMarcoVT        = validaNumero($beneficio['diaUtilMarcoVT']);
    $diaUtilAbrilVT        = validaNumero($beneficio['diaUtilAbrilVT']);
    $diaUtilMaioVT        = validaNumero($beneficio['diaUtilMaioVT']);
    $diaUtilJunhoVT        = validaNumero($beneficio['diaUtilJunhoVT']);
    $diaUtilJulhoVT        = validaNumero($beneficio['diaUtilJulhoVT']);
    $diaUtilAgostoVT        = validaNumero($beneficio['diaUtilAgostoVT']);
    $diaUtilSetembroVT    = validaNumero($beneficio['diaUtilSetembroVT']);
    $diaUtilOutubroVT     = validaNumero($beneficio['diaUtilOutubroVT']);
    $diaUtilNovembroVT    = validaNumero($beneficio['diaUtilNovembroVT']);
    $diaUtilDezembroVT    = validaNumero($beneficio['diaUtilDezembroVT']);
    $tipoDiaUtilVT =        validaNumero($beneficio['tipoDiaUtilVT']);


    $totalValorAcrescimoBeneficioIndireto = str_replace(',', '.', $beneficio['totalValorAcrescimoBeneficioIndireto']);
    $totalValorAcrescimoBeneficioIndireto =  (float)$totalValorAcrescimoBeneficioIndireto;
    $totalValorAbaterBeneficioIndireto = str_replace(',', '.', $beneficio['totalValorAbaterBeneficioIndireto']);
    $totalValorAbaterBeneficioIndireto = (float)$totalValorAbaterBeneficioIndireto;

    $ativo = 1;

    $saldoDisponivel = validaNumero($beneficio['saldoDisponivel']);
    $salarioFuncionario = validaNumero($beneficio['salarioFuncionario']);

    $municipioFerias =        validaNumero($beneficio['municipioFerias']);
    $tipoBeneficio = "'" . $beneficio['tipoBeneficio'] . "'";

    $escalaFerias = +$beneficio['escalaFerias'];
    $escalaFeriasVAVR = +$beneficio['escalaFeriasVAVR'];

    $localizacao = (int)$beneficio['localizacao'];
    $posto = (int)$beneficio['descricaoPosto'];
    if ($localizacao == 0) {
        $localizacao = 'NULL';
    }
    if ($posto == 0) {
        $posto = 'NULL';
    }

    $departamento = (int)$beneficio['departamento'];
    if($departamento == 0){
        $departamento = 'NULL';
    }
 

    $horaEntrada = "'" .$beneficio['horaEntrada']. "'" ;
    $horaInicio = "'" .$beneficio['horaInicio']. "'" ;
    $horaFim = "'" .$beneficio['horaFim']. "'" ;
    $horaSaida = "'" .$beneficio['horaSaida']. "'" ;

    $produtoVAVR = $beneficio['produtoVAVR'];


    //############################# INICIO DO XML DE VT ##############################//
    $strArrayValeTransporte = $beneficio['jsonValeTransporte'];
    $arrayValeTransporte = json_decode($strArrayValeTransporte, true);
    $xmlValeTransporte = "";
    $nomeXml = "ArrayOfBeneficioProjetoVT";
    $nomeTabela = "beneficioProjetoVT";
    if (sizeof($arrayValeTransporte) > 0) {
        $xmlValeTransporte = '<?xml version="1.0"?>';
        $xmlValeTransporte = $xmlValeTransporte . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayValeTransporte as $chave) {
            $xmlValeTransporte = $xmlValeTransporte . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialValeTransporte")) {
                    continue;
                }
                if (mb_eregi("valor", $campo)) {
                    // $valor = str_replace('.', '', $valor);
                    $valor = str_replace(',', '.', $valor);
                }
                if (mb_ereg("^\.0", $valor)) {
                    $valor = 0;
                }
                if (($campo === "dataInativacao")) {
                    if ($valor === "//" || $valor === "") {
                        $valor = NULL;
                    } else {
                        $valor = validaData($valor);
                    }
                }

                $xmlValeTransporte = $xmlValeTransporte . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlValeTransporte = $xmlValeTransporte . "</" . $nomeTabela . ">";
        }
        $xmlValeTransporte = $xmlValeTransporte . "</" . $nomeXml . ">";
    } else {
        $xmlValeTransporte = '<?xml version="1.0"?>';
        $xmlValeTransporte = $xmlValeTransporte . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlValeTransporte = $xmlValeTransporte . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlValeTransporte);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlValeTransporte = "'" . $xmlValeTransporte . "'";
    //############################# INICIO DE PLANO SAUDE ##############################//
    $strArrayPlanoSaude = $beneficio['jsonPlanoSaude'];
    $arrayPlanoSaude = json_decode($strArrayPlanoSaude, true);
    $xmlPlanoSaude = "";
    $nomeXml = "ArrayOfBeneficioProjetoPlanoSaude";
    $nomeTabela = "beneficioProjetoPlanoSaude";
    if (sizeof($arrayPlanoSaude) > 0) {
        $xmlPlanoSaude = '<?xml version="1.0"?>';
        $xmlPlanoSaude = $xmlPlanoSaude . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayPlanoSaude as $chave) {
            $xmlPlanoSaude = $xmlPlanoSaude . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialPlanoSaude")) {
                    continue;
                }
                if (($campo === "valorDependente")) {
                    continue;
                }
                if (($campo === "descontoSindicatoDependente")) {
                    continue;
                }
                if (($campo === "valorDescontoSindicatoDependente")) {
                    continue;
                }
                if (($campo === "descontoProjetoDependente")) {
                    continue;
                }
                if (($campo === "valorDescontoProjetoDependente")) {
                    continue;
                }
                if (($campo === "valorProdutoDependente")) {
                    continue;
                }
                if (($campo === "valorEmpresaDependente")) {
                    continue;
                }
                if (mb_eregi("valor|desconto", $campo)) {
                    if ($valor == "") {
                        $valor = 0;
                    } else {
                        $valor = str_replace('.', '', $valor);
                        $valor = str_replace(',', '.', $valor);
                    }
                }
                if (mb_ereg("^\.0", $valor)) {
                    $valor = 0;
                }
                $xmlPlanoSaude = $xmlPlanoSaude . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlPlanoSaude = $xmlPlanoSaude . "</" . $nomeTabela . ">";
        }
        $xmlPlanoSaude = $xmlPlanoSaude . "</" . $nomeXml . ">";
    } else {
        $xmlPlanoSaude = '<?xml version="1.0"?>';
        $xmlPlanoSaude = $xmlPlanoSaude . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlPlanoSaude = $xmlPlanoSaude . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlPlanoSaude);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlPlanoSaude = "'" . $xmlPlanoSaude . "'";
    //############################# INICIO DE PLANO SAUDE DEPENDENTE ##############################//
    $strArrayPlanoSaudeDependente = $beneficio['jsonPlanoSaudeDependente'];
    $arrayPlanoSaudeDependente = json_decode($strArrayPlanoSaudeDependente, true);
    $xmlPlanoSaudeDependente = "";
    $nomeXml = "ArrayOfBeneficioProjetoPlanoSaudeDependente";
    $nomeTabela = "beneficioProjetoPlanoSaudeDependente";
    if (sizeof($arrayPlanoSaudeDependente) > 0) {
        $xmlPlanoSaudeDependente = '<?xml version="1.0"?>';
        $xmlPlanoSaudeDependente = $xmlPlanoSaudeDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayPlanoSaudeDependente as $chave) {
            $xmlPlanoSaudeDependente = $xmlPlanoSaudeDependente . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialPlanoSaudeDependente")) {
                    continue;
                }
                if (($campo === "valorTotalTitular")) {
                    continue;
                }
                if (($campo === "valorTotalGeral")) {
                    continue;
                }

                if (($campo === "valorFuncionarioTitular")) {
                    continue;
                }
                if (($campo === "descontoSindicatoTitular")) {
                    continue;
                }
                if (($campo === "valorDescontoSindicatoTitular")) {
                    continue;
                }
                if (($campo === "descontoProjetoTitular")) {
                    continue;
                }
                if (($campo === "valorDescontoProjetoTitular")) {
                    continue;
                }
                if (($campo === "valorProdutoTitular")) {
                    continue;
                }
                if (($campo === "valorEmpresaTitular")) {
                    continue;
                }
                if (($campo === "valorDescontoPlanoSaudeTitular")) {
                    continue;
                }
                if (($campo === "descontoPlanoSaudeTitular")) {
                    continue;
                }
                if (mb_eregi("valor|desconto", $campo)) {
                    if ($valor == "") {
                        $valor = 0;
                    } else {
                        $valor = str_replace('.', '', $valor);
                        $valor = str_replace(',', '.', $valor);
                    }
                }
                if (mb_ereg("^\.0", $valor)) {
                    $valor = 0;
                }

                $xmlPlanoSaudeDependente = $xmlPlanoSaudeDependente . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlPlanoSaudeDependente = $xmlPlanoSaudeDependente . "</" . $nomeTabela . ">";
        }
        $xmlPlanoSaudeDependente = $xmlPlanoSaudeDependente . "</" . $nomeXml . ">";
    } else {
        $xmlPlanoSaudeDependente = '<?xml version="1.0"?>';
        $xmlPlanoSaudeDependente = $xmlPlanoSaudeDependente . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlPlanoSaudeDependente = $xmlPlanoSaudeDependente . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlPlanoSaudeDependente);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Plano Saude";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlPlanoSaudeDependente = "'" . $xmlPlanoSaudeDependente . "'";


    //############################# INICIO DO XML DE BENEFICIO DIRETO##############################//
    $strArrayBeneficioIndireto = $beneficio['jsonBeneficioIndireto'];
    $arrayBeneficioIndireto = json_decode($strArrayBeneficioIndireto, true);
    $xmlBeneficioIndireto = "";
    $nomeXml = "ArrayOfBeneficioIndireto";
    $nomeTabela = "beneficioIndireto";
    if (sizeof($arrayBeneficioIndireto) > 0) {
        $xmlBeneficioIndireto = '<?xml version="1.0"?>';
        $xmlBeneficioIndireto = $xmlBeneficioIndireto . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayBeneficioIndireto as $chave) {
            $xmlBeneficioIndireto = $xmlBeneficioIndireto . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialBeneficioIndireto")) {
                    continue;
                }
                if (mb_eregi("valor|saldo", $campo)) {
                    if ($valor == "") {
                        $valor = 0;
                    } else {
                        $valor = str_replace('.', '', $valor);
                        $valor = str_replace(',', '.', $valor);
                    }
                }
                if (mb_ereg("^\.0", $valor)) {
                    $valor = 0;
                }
                $xmlBeneficioIndireto = $xmlBeneficioIndireto . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlBeneficioIndireto = $xmlBeneficioIndireto . "</" . $nomeTabela . ">";
        }
        $xmlBeneficioIndireto = $xmlBeneficioIndireto . "</" . $nomeXml . ">";
    } else {
        $xmlBeneficioIndireto = '<?xml version="1.0"?>';
        $xmlBeneficioIndireto = $xmlBeneficioIndireto . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlBeneficioIndireto = $xmlBeneficioIndireto . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlBeneficioIndireto);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlBeneficioIndireto = "'" . $xmlBeneficioIndireto . "'";


    $sql = "Ntl.beneficioProjeto_Atualiza
        $codigo,
        $projeto,
        $funcionario,
        $tipoDiaUtil,
        $sindicato,
        $percentualDescontoProjetoVAVR, 
        $valorDescontoProjetoVAVR, 
        $percentualDescontoSindicatoVAVR, 
        $valorDescontoSindicatoVAVR, 
        $valorDiarioFuncionarioVAVR, 
        $valorMensalFuncionarioVAVR, 
        $percentualDescontoMesCorrenteVAVR,  
        $valorDescontoMesCorrenteVAVR,  
        $valorDiarioFuncionarioVAVR,
        $valorCestaBasica,
        $diaUtilJaneiro,						
	    $diaUtilFevereiro,						
	    $diaUtilMarco,							
	    $diaUtilAbril,							
	    $diaUtilMaio,							
	    $diaUtilJunho,							
	    $diaUtilJulho,							
        $diaUtilAgosto,							
	    $diaUtilSetembro,						
	    $diaUtilOutubro,							
	    $diaUtilNovembro,						
        $diaUtilDezembro,
        $ativo,
        $valorTotalPlanoSaude,
        $valorTotalTitularPlanoSaude,
        $valorTotalDependentePlanoSaude,
        $valorDiarioProjetoVAVR,
        $valorMensalProjetoVAVR,
        $valorDiarioSindicatoVAVR,
        $valorMensalSindicatoVAVR,
        $percentualDescontoFolhaFuncionarioVAVR,
        $valorDescontoFolhaFuncionarioVAVR,
        $valorMensalSindicatoCestaBasica,
        $percentualDescontoSindicatoCestaBasica,
        $valorDescontoSindicatoCestaBasica,
        $tipoDescontoVAVR,
        $perdaBeneficio,
        $saldoDisponivel,
        $salarioFuncionario,
        $consideraVAVR,
        $consideraVt,
        $diaUtilJaneiroVT,						
	    $diaUtilFevereiroVT,						
	    $diaUtilMarcoVT,							
	    $diaUtilAbrilVT,							
	    $diaUtilMaioVT,							
	    $diaUtilJunhoVT,							
	    $diaUtilJulhoVT,							
        $diaUtilAgostoVT,							
	    $diaUtilSetembroVT,						
	    $diaUtilOutubroVT,							
	    $diaUtilNovembroVT,						
        $diaUtilDezembroVT,
        $tipoDiaUtilVAVR,
        $tipoDiaUtilVT,
        $municipioDiasUteisVAVR,
        $municipioDiasUteisVT,
        $xmlValeTransporte,
        $xmlPlanoSaude,
        $xmlPlanoSaudeDependente,
        $xmlBeneficioIndireto,
        $valorTotalFuncionarioVT,
        $totalValorAcrescimoBeneficioIndireto,
        $totalValorAbaterBeneficioIndireto,
        $municipioFerias,
        $tipoBeneficio,
        $escalaFerias,
        $escalaFeriasVAVR,
        $localizacao,
        $posto,
        $usuario,
        $horaEntrada,
        $horaInicio,
        $horaFim,
        $horaSaida,
        $departamento,
        $produtoVAVR";

    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}


function recuperaBeneficio()
{

    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT * FROM Ntl.beneficioProjeto WHERE codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {


        $id = validaNumeroRecupera($row['codigo']);
        $projeto = validaNumeroRecupera($row['projeto']);
        $funcionario = validaNumeroRecupera($row['funcionario']);
        $tipoDiaUtil = validaNumeroRecupera($row['tipoDiaUtil']);
        $sindicato = validaNumeroRecupera($row['sindicato']);
        $salarioFuncionario = validaNumeroRecupera($row['salarioFuncionario']);

        $percentualDescontoProjetoVR = validaNumeroRecupera($row['percentualDescontoProjetoVR']);
        $valorDescontoProjetoVR = validaNumeroRecupera($row['valorDescontoProjetoVR']);
        $percentualDescontoSindicatoVR = validaNumeroRecupera($row['percentualDescontoSindicatoVR']);
        $valorDescontoSindicatoVR = validaNumeroRecupera($row['valorDescontoSindicatoVR']);
        $percentualDescontoFuncionarioVR = validaNumeroRecupera($row['percentualDescontoFuncionarioVR']);
        $valorDescontoFuncionarioVR = validaNumeroRecupera($row['valorDescontoFuncionarioVR']);
        $percentualDescontoMesCorrenteVR = validaNumeroRecupera($row['percentualDescontoMesCorrenteVR']);
        $valorDescontoMesCorrenteVR = validaNumeroRecupera($row['valorDescontoMesCorrenteVR']);
        $valorDiarioProjetoVR = validaNumeroRecupera($row['valorDiarioProjetoVR']);
        $valorMensalProjetoVR = validaNumeroRecupera($row['valorMensalProjetoVR']);
        $valorDiarioSindicatoVR = validaNumeroRecupera($row['valorDiarioSindicatoVR']);
        $valorMensalSindicatoVR = validaNumeroRecupera($row['valorMensalSindicatoVR']);
        $valorDiaFuncionarioVR = validaNumeroRecupera($row['valorDiaFuncionarioVR']);
        $valorMensalFuncionarioVR = validaNumeroRecupera($row['valorMensalFuncionarioVR']);
        $valorProdutoVR = validaNumeroRecupera($row['valorProdutoVR']);
        $valorFuncionarioVR = validaNumeroRecupera($row['valorFuncionarioVR']);
        $valorEmpresaVR = validaNumeroRecupera($row['valorEmpresaVR']);
        $tipoDescontoVR = validaNumeroRecupera($row['tipoDescontoVR']);


        $percentualDescontoProjetoVAVR = validaNumeroRecupera($row['percentualDescontoProjetoVAVR']);
        $valorDescontoProjetoVAVR = validaNumeroRecupera($row['valorDescontoProjetoVAVR']);
        $percentualDescontoSindicatoVAVR = validaNumeroRecupera($row['percentualDescontoSindicatoVAVR']);
        $valorDescontoSindicatoVAVR = validaNumeroRecupera($row['valorDescontoSindicatoVAVR']);
        $valorDiarioFuncionarioVAVR = validaNumeroRecupera($row['valorDiarioFuncionarioVAVR']);
        $valorMensalFuncionarioVAVR = validaNumeroRecupera($row['valorMensalFuncionarioVAVR']);
        $percentualDescontoMesCorrenteVAVR = validaNumeroRecupera($row['percentualDescontoMesCorrenteVAVR']);
        $valorDescontoMesCorrenteVAVR = validaNumeroRecupera($row['valorDescontoMesCorrenteVAVR']);
        $valorDiarioFuncionarioVAVR = validaNumeroRecupera($row['valorDiarioFuncionarioVAVR']);
        $valorDiarioProjetoVAVR = validaNumeroRecupera($row['valorDiarioProjetoVAVR']);
        $valorMensalProjetoVAVR = validaNumeroRecupera($row['valorMensalProjetoVAVR']);
        $valorDiarioSindicatoVAVR = validaNumeroRecupera($row['valorDiarioSindicatoVAVR']);
        $valorMensalSindicatoVAVR = validaNumeroRecupera($row['valorMensalSindicatoVAVR']);
        $percentualDescontoFolhaFuncionarioVAVR = validaNumeroRecupera($row['percentualDescontoFolhaFuncionarioVAVR']);
        $valorDescontoFolhaFuncionarioVAVR = validaNumeroRecupera($row['valorDescontoFolhaFuncionarioVAVR']);
        $valorProdutoVAVR = validaNumeroRecupera($row['valorProdutoVAVR']);
        $valorFuncionarioVAVR = validaNumeroRecupera($row['valorFuncionarioVAVR']);
        $valorEmpresaVAVR = validaNumeroRecupera($row['valorEmpresaVAVR']);
        $tipoDescontoVAVR = validaNumeroRecupera($row['tipoDescontoVAVR']);


        $valorCestaBasica = validaNumeroRecupera($row['valorCestaBasica']);
        $valorDiarioSindicatoCestaBasica = validaNumeroRecupera($row['valorDiarioSindicatoCestaBasica']);
        $valorMensalSindicatoCestaBasica = validaNumeroRecupera($row['valorMensalSindicatoCestaBasica']);
        $percentualDescontoSindicatoCestaBasica = validaNumeroRecupera($row['percentualDescontoSindicatoCestaBasica']);
        $valorDescontoSindicatoCestaBasica = validaNumeroRecupera($row['valorDescontoSindicatoCestaBasica']);
        $perdaBeneficio = validaNumeroRecupera($row['perdaBeneficio']);

        $valorProdutoCestaBasica = validaNumeroRecupera($row['valorProdutoCestaBasica']);
        $valorFuncionarioCestaBasica = validaNumeroRecupera($row['valorFuncionarioCestaBasica']);
        $valorEmpresaCestaBasica = validaNumeroRecupera($row['valorEmpresaCestaBasica']);


        $consideraVAVR = validaNumeroRecupera($row['consideraVAVR']);
        $consideraVr = validaNumeroRecupera($row['consideraVr']);
        $consideraVt = validaNumeroRecupera($row['consideraVt']);

        $municipioDiasUteisVAVR = validaNumeroRecupera($row['municipioDiasUteisVAVR']);
        $diaUtilJaneiro = validaNumeroRecupera($row['diaUtilJaneiroVAVR']);
        $diaUtilFevereiro = validaNumeroRecupera($row['diaUtilFevereiroVAVR']);
        $diaUtilMarco = validaNumeroRecupera($row['diaUtilMarcoVAVR']);
        $diaUtilAbril = validaNumeroRecupera($row['diaUtilAbrilVAVR']);
        $diaUtilMaio = validaNumeroRecupera($row['diaUtilMaioVAVR']);
        $diaUtilJunho = validaNumeroRecupera($row['diaUtilJunhoVAVR']);
        $diaUtilJulho = validaNumeroRecupera($row['diaUtilJulhoVAVR']);
        $diaUtilAgosto = validaNumeroRecupera($row['diaUtilAgostoVAVR']);
        $diaUtilSetembro = validaNumeroRecupera($row['diaUtilSetembroVAVR']);
        $diaUtilOutubro = validaNumeroRecupera($row['diaUtilOutubroVAVR']);
        $diaUtilNovembro = validaNumeroRecupera($row['diaUtilNovembroVAVR']);
        $diaUtilDezembro = validaNumeroRecupera($row['diaUtilDezembroVAVR']);
        $tipoDiaUtilVAVR = validaNumeroRecupera($row['tipoDiaUtilVAVR']);


        $municipioDiasUteisVT = validaNumeroRecupera($row['municipioDiasUteisVT']);
        $diaUtilJaneiroVT = validaNumeroRecupera($row['diaUtilJaneiroVT']);
        $diaUtilFevereiroVT = validaNumeroRecupera($row['diaUtilFevereiroVT']);
        $diaUtilMarcoVT = validaNumeroRecupera($row['diaUtilMarcoVT']);
        $diaUtilAbrilVT = validaNumeroRecupera($row['diaUtilAbrilVT']);
        $diaUtilMaioVT = validaNumeroRecupera($row['diaUtilMaioVT']);
        $diaUtilJunhoVT = validaNumeroRecupera($row['diaUtilJunhoVT']);
        $diaUtilJulhoVT = validaNumeroRecupera($row['diaUtilJulhoVT']);
        $diaUtilAgostoVT = validaNumeroRecupera($row['diaUtilAgostoVT']);
        $diaUtilSetembroVT = validaNumeroRecupera($row['diaUtilSetembroVT']);
        $diaUtilOutubroVT = validaNumeroRecupera($row['diaUtilOutubroVT']);
        $diaUtilNovembroVT = validaNumeroRecupera($row['diaUtilNovembroVT']);
        $diaUtilDezembroVT = validaNumeroRecupera($row['diaUtilDezembroVT']);
        $tipoDiaUtilVT = validaNumeroRecupera($row['tipoDiaUtilVT']);

        $departamento = validaNumeroRecupera($row['departamento']);

        $horaEntrada = $row['horaEntrada'];
        $horaInicio = $row['horaInicio'];
        $horaFim = $row['horaFim'];
        $horaSaida = $row['horaSaida'];

        $produtoVAVR = $row['produtoVAVR'];



        $saldoDisponivel = validaNumeroRecupera($row['saldoDisponivel']);
        if ($saldoDisponivel == 0) {
            $saldoDisponivel = 0;
        }

        $municipioFerias = validaNumeroRecupera($row['municipioFerias']);
        $tipoBeneficio = $row['tipoBeneficio'];

        $escalaFerias = +$row['escalaFerias'];
        $escalaFeriasVAVR = +$row['escalaFeriasVAVR'];

        $localizacao = +$row['localizacao'];
        $posto = +$row['descricaoPosto'];
        //----------------------Montando o array do Plane Saude Titular

        $reposit = "";
        $result = "";
        $sql = "SELECT BP.codigo, BS.funcionario, BS.convenio, BS.produto, BS.cobranca, BS.idade, 
        BS.percentualDescontoSindicato,
        BS.valorDescontoSindicato, BS.percentualDescontoProjeto, BS.valorDescontoProjeto, BS.valorProduto, BS.valorFuncionario, BS.valorEmpresa, BS.baseDesconto,
		BS.percentualDescontoPlanoSaude, BS.valorDescontoPlanoSaude 
        FROM Ntl.beneficioProjeto BP
        INNER JOIN Ntl.beneficioProjetoPlanoSaudeTitular BS ON BP.codigo = BS.beneficioProjeto WHERE (0=0) AND BP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorPlanoSaude = 0;
        $arrayPlanoSaude = array();
        foreach ($result as $row) {




            $funcionarioPlanoSaude = +$row['funcionario'];
            $convenio = +$row['convenio'];
            $cobranca = +$row['cobranca'];
            $idade = +$row['idade'];

            $produto = +$row['produto'];


            $percentualDescontoSindicato = $row['percentualDescontoSindicato'];
            $percentualDescontoSindicato = str_replace('.', ',', $percentualDescontoSindicato);

            $valorDescontoSindicato = $row['valorDescontoSindicato'];
            $valorDescontoSindicato = str_replace('.', ',', $valorDescontoSindicato);

            $percentualDescontoProjeto = $row['percentualDescontoProjeto'];
            $percentualDescontoProjeto = str_replace('.', ',', $percentualDescontoProjeto);

            $valorDescontoProjeto = $row['valorDescontoProjeto'];
            $valorDescontoProjeto = str_replace('.', ',', $valorDescontoProjeto);

            $valorProduto = $row['valorProduto'];
            $valorProduto = str_replace('.', ',', $valorProduto);

            $valorFuncionario = $row['valorFuncionario'];
            $valorFuncionario = str_replace('.', ',', $valorFuncionario);

            $valorEmpresa = $row['valorEmpresa'];
            $valorEmpresa = str_replace('.', ',', $valorEmpresa);

            $percentualDescontoPlanoSaude = $row['percentualDescontoPlanoSaude'];
            $percentualDescontoPlanoSaude = str_replace('.', ',', $percentualDescontoPlanoSaude);

            $valorDescontoPlanoSaude = $row['valorDescontoPlanoSaude'];
            $valorDescontoPlanoSaude = str_replace('.', ',', $valorDescontoPlanoSaude);

            $baseDescontoTitular = +$row['baseDesconto'];

            $contadorPlanoSaude = $contadorPlanoSaude + 1;
            $arrayPlanoSaude[] = array(
                "descricaoFuncionarioTitular" => $funcionarioPlanoSaude,
                "descricaoConvenioTitular" => $convenio,
                "descricaoProdutoTitular" => $produto,
                "cobrancaTitular" => $cobranca,
                "idadeTitular" => $idade,
                "descontoSindicatoTitular" => $percentualDescontoSindicato,
                "valorDescontoSindicatoTitular" => $valorDescontoSindicato,
                "descontoProjetoTitular" => $percentualDescontoProjeto,
                "valorDescontoProjetoTitular" => $valorDescontoProjeto,
                "valorProdutoTitular" => $valorProduto,
                "valorFuncionarioTitular" => $valorFuncionario,
                "valorEmpresaTitular" => $valorEmpresa,
                "sequencialPlanoSaude" => $contadorPlanoSaude,
                "baseDescontoPlanoSaudeTitular" => $baseDescontoTitular,
                "valorDescontoPlanoSaudeTitular" => $valorDescontoPlanoSaude,
                "percentualDescontoPlanoSaudeTitular" => $percentualDescontoPlanoSaude
            );
        }


        $strArrayPlanoSaude = json_encode($arrayPlanoSaude);
        //----------------------Montando o array do Plane Saude Dependente

        $reposit = "";
        $result = "";
        $sql = "SELECT BP.codigo, BS.dependente, BS.convenio, BS.produto, BS.cobranca, BS.idade, 
        BS.percentualDescontoSindicato,
        BS.valorDescontoSindicato, BS.percentualDescontoProjeto, BS.valorDescontoProjeto, BS.valorProduto, BS.valorDependente, BS.valorEmpresa 
        FROM Ntl.beneficioProjeto BP
        INNER JOIN Ntl.beneficioProjetoPlanoSaudeDependente BS ON BP.codigo = BS.beneficioProjeto WHERE (0=0) AND BP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorPlanoSaudeDependente = 0;
        $arrayPlanoSaudeDependente = array();
        foreach ($result as $row) {




            $dependentePlanoSaude = +$row['dependente'];
            $convenio = +$row['convenio'];
            $cobranca = +$row['cobranca'];
            $idade = +$row['idade'];

            $produto = +$row['produto'];
            $baseDescontoDependente = +$row['baseDesconto'];

            $percentualDescontoSindicato = $row['percentualDescontoSindicato'];
            $percentualDescontoSindicato = str_replace('.', ',', $percentualDescontoSindicato);

            $valorDescontoSindicato = $row['valorDescontoSindicato'];
            $valorDescontoSindicato = str_replace('.', ',', $valorDescontoSindicato);

            $percentualDescontoProjeto = $row['percentualDescontoProjeto'];
            $percentualDescontoProjeto = str_replace('.', ',', $percentualDescontoProjeto);

            $valorDescontoProjeto = $row['valorDescontoProjeto'];
            $valorDescontoProjeto = str_replace('.', ',', $valorDescontoProjeto);

            $valorProduto = $row['valorProduto'];
            $valorProduto = str_replace('.', ',', $valorProduto);

            $valorDependente = $row['valorDependente'];
            $valorDependente = str_replace('.', ',', $valorDependente);

            $valorEmpresa = $row['valorEmpresa'];
            $valorEmpresa = str_replace('.', ',', $valorEmpresa);




            $contadorPlanoSaudeDependente = $contadorPlanoSaudeDependente + 1;
            $arrayPlanoSaudeDependente[] = array(
                "descricaoNomeDependente" => $dependentePlanoSaude,
                "descricaoConvenioDependente" => $convenio,
                "descricaoProdutoDependente" => $produto,
                "cobrancaDependente" => $cobranca,
                "idadeDependente" => $idade,
                "descontoSindicatoDependente" => $percentualDescontoSindicato,
                "valorDescontoSindicatoDependente" => $valorDescontoSindicato,
                "descontoProjetoDependente" => $percentualDescontoProjeto,
                "valorDescontoProjetoDependente" => $valorDescontoProjeto,
                "valorProdutoDependente" => $valorProduto,
                "valorDependente" => $valorDependente,
                "valorEmpresaDependente" => $valorEmpresa,
                "sequencialPlanoSaudeDependente" => $contadorPlanoSaudeDependente,
                "baseDescontoPlanoSaudeDependente" => $baseDescontoDependente

            );
        }


        $strArrayPlanoSaudeDependente = json_encode($arrayPlanoSaudeDependente);


        //----------------------Montando o array do VT

        $reposit = "";
        $result = "";
        $sql = "SELECT *
        FROM Ntl.beneficioProjetoVT where beneficioProjeto = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorVT = 0;
        $arrayVT = array();
        foreach ($result as $row) {

            $beneficioProjetoId = $row['beneficioProjeto'];
            $trajetoIdaVolta = +$row['trajetoIdaVolta'];
            $tipoDesconto = +$row['tipoDesconto'];
            $dataInativacao = validaDataRecupera($row['dataInativacao']);
            if ($tipoDesconto == 1) {
                $descricaoTipoDesconto = "Conforme a lei";
            } else if ($tipoDesconto == 2) {
                $descricaoTipoDesconto = "Real utilização";
            } else if ($tipoDesconto == 3) {
                $descricaoTipoDesconto = "Nenhum";
            }


            $tipoVale = +$row['tipoVale']; //
            if ($tipoVale == 0) {
                $descricaoTipoVale = "Modal";
            } else if ($tipoVale == 1) {
                $descricaoTipoVale = "Unitário";
            }
            $trajeto = +$row['trajeto']; //
            if ($trajeto == 1) {
                $descricaoTrajeto =  "Ida";
            } else if ($trajeto == 2) {
                $descricaoTrajeto = "Volta";
            } else if ($trajeto == 3) {
                $descricaoTrajeto = "Ida e Volta";
            }

            if ($trajetoIdaVolta === 1) {
                $valorTotalVT = $row['valorTotal'];
                $valorTotalVT = str_replace('.', ',', $valorTotalVT);
            }
            $valorTotalVT = $row['valorTotal'];
            $observacaoVT = $row['observacao'];
            $codigoVT = +$row['transporte'];



            if ($descricaoTipoVale == "Modal") {

                $sql = "SELECT codigo, descricao FROM Ntl.valeTransporteModal WHERE codigo =  " . $codigoVT;
                $reposit = new reposit();
                $result2 = $reposit->RunQuery($sql);
                if ($row = $result2[0]) {

                    $descricaoVT = $row['descricao'];
                }
            } else {

                $sql = "SELECT codigo, descricao FROM Ntl.valeTransporteUnitario WHERE codigo =  " . $codigoVT;
                $reposit = new reposit();
                $result2 = $reposit->RunQuery($sql);
                if ($row = $result2[0]) {

                    $descricaoVT = $row['descricao'];
                }
            }

            //Verifica se o vale transporte é ida e volta

            $contadorVT = $contadorVT + 1;
            $arrayVT[] = array(
                "sequencialValeTransporte" => $contadorVT,
                "descricaoTipoDesconto" => $descricaoTipoDesconto,
                "descricaoTipoVale" => $descricaoTipoVale,
                "descricaoVT" => $descricaoVT,
                "descricaoTrajeto" => $descricaoTrajeto,
                "valorPassagem" => $valorTotalVT,
                "valorTotalVT" => $valorTotalVT,

                "observacaoVT" => $observacaoVT,
                "tipoDesconto" => $tipoDesconto,
                "tipoVale" => $tipoVale,
                "valeTransporte" => $codigoVT,
                "trajetoVT" => $trajeto,
                "trajetoIdaVolta" => $trajetoIdaVolta,
                "dataInativacao" => $dataInativacao
            );
        }


        $strArrayVT = json_encode($arrayVT);

        //----------------------Montando o array do Beneficio Direto

        $reposit = "";
        $result = "";
        $sql = "SELECT BP.codigo, BD.beneficio, BD.valorBeneficioFuncionario, BD.valorAcrescimo, BD.valorAbater, BD.valorFinalBeneficio 
        FROM Ntl.beneficioProjeto BP INNER JOIN Ntl.beneficioProjetoBeneficioIndireto BD ON BP.codigo = BD.beneficioProjeto WHERE BP.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorBeneficioDireto = 0;
        $arrayBeneficioIndireto = array();
        foreach ($result as $row) {



            $valorBeneficioFuncionario = $row['valorBeneficioFuncionario'];
            $valorBeneficioFuncionario = str_replace('.', ',', $valorBeneficioFuncionario);

            $valorAcrescimo = $row['valorAcrescimo'];
            $valorAcrescimo = str_replace('.', ',', $valorAcrescimo);

            $valorAbater = $row['valorAbater'];
            $valorAbater = str_replace('.', ',', $valorAbater);

            $valorFinalBeneficio = $row['valorFinalBeneficio'];
            $valorFinalBeneficio = str_replace('.', ',', $valorFinalBeneficio);

            $beneficio = +$row['beneficio']; //




            $contadorBeneficioDireto = $contadorBeneficioDireto + 1;
            $arrayBeneficioIndireto[] = array(
                "sequencialBeneficioIndireto" => $contadorBeneficioDireto,
                "beneficioIndireto" => $beneficio,
                "descricaoBeneficio" => $beneficio,
                "valorBeneficioFuncionario" => $valorBeneficioFuncionario,
                "valorAcrescimo" => $valorAcrescimo,
                "valorAbater" => $valorAbater,
                "valorFinalBeneficio" => $valorFinalBeneficio

            );
        }


        $strArrayBeneficioIndireto = json_encode($arrayBeneficioIndireto);




        $out = $id . "^" .
            $projeto . "^" .
            $funcionario . "^" .
            $tipoDiaUtil . "^" .
            $sindicato . "^" .
            $percentualDescontoProjetoVR . "^" .
            $valorDescontoProjetoVR . "^" .
            $percentualDescontoSindicatoVR . "^" .
            $valorDescontoSindicatoVR . "^" .
            $percentualDescontoFuncionarioVR . "^" .
            $valorDescontoFuncionarioVR . "^" .
            $percentualDescontoMesCorrenteVR . "^" .
            $valorDescontoMesCorrenteVR . "^" .
            $percentualDescontoProjetoVAVR . "^" .
            $valorDescontoProjetoVAVR . "^" .
            $percentualDescontoSindicatoVAVR . "^" .
            $valorDescontoSindicatoVAVR . "^" .
            $valorDiarioFuncionarioVAVR . "^" .
            $valorMensalFuncionarioVAVR . "^" .
            $percentualDescontoMesCorrenteVAVR . "^" .
            $valorDescontoMesCorrenteVAVR . "^" .
            $valorDiarioFuncionarioVAVR . "^" .
            $valorCestaBasica . "^" .
            $diaUtilJaneiro . "^" .
            $diaUtilFevereiro . "^" .
            $diaUtilMarco . "^" .
            $diaUtilAbril . "^" .
            $diaUtilMaio . "^" .
            $diaUtilJunho . "^" .
            $diaUtilJulho . "^" .
            $diaUtilAgosto . "^" .
            $diaUtilSetembro . "^" .
            $diaUtilOutubro . "^" .
            $diaUtilNovembro . "^" .
            $diaUtilDezembro . "^" .
            // $valorDiarioProjetoVR . "^" .
            // $valorMensalProjetoVR . "^" .
            // $valorDiarioSindicatoVR . "^" .
            // $valorMensalSindicatoVR . "^" .
            // $valorDiaFuncionarioVR . "^" .
            // $valorMensalFuncionarioVR . "^" .
            // $valorProdutoVR . "^" .
            // $valorFuncionarioVR . "^" .
            // $valorEmpresaVR . "^" .
            $valorDiarioProjetoVAVR . "^" .
            $valorMensalProjetoVAVR . "^" .
            $valorDiarioSindicatoVAVR . "^" .
            $valorMensalSindicatoVAVR . "^" .
            $percentualDescontoFolhaFuncionarioVAVR . "^" .
            $valorDescontoFolhaFuncionarioVAVR . "^" .
            $valorProdutoVAVR . "^" .
            $valorFuncionarioVAVR . "^" .
            $valorEmpresaVAVR . "^" .
            $valorDiarioSindicatoCestaBasica . "^" .
            $valorMensalSindicatoCestaBasica . "^" .
            $percentualDescontoSindicatoCestaBasica . "^" .
            $valorDescontoSindicatoCestaBasica . "^" .
            $valorProdutoCestaBasica . "^" .
            $valorFuncionarioCestaBasica . "^" .
            $valorEmpresaCestaBasica . "^" .
            // $tipoDescontoVR . "^" .
            $tipoDescontoVAVR . "^" .
            $perdaBeneficio . "^" .
            $saldoDisponivel . "^" .
            $salarioFuncionario . "^" .
            $consideraVAVR . "^" .
            // $consideraVr . "^" .
            $consideraVt . "^" .
            $trajetoIdaVolta . "^" .
            $diaUtilJaneiroVT   . "^" .
            $diaUtilFevereiroVT . "^" .
            $diaUtilMarcoVT     . "^" .
            $diaUtilAbrilVT     . "^" .
            $diaUtilMaioVT      . "^" .
            $diaUtilJunhoVT     . "^" .
            $diaUtilJulhoVT     . "^" .
            $diaUtilAgostoVT    . "^" .
            $diaUtilSetembroVT  . "^" .
            $diaUtilOutubroVT   . "^" .
            $diaUtilNovembroVT  . "^" .
            $diaUtilDezembroVT . "^" .
            $tipoDiaUtilVAVR . "^" .
            $tipoDiaUtilVT . "^" .
            $municipioDiasUteisVAVR . "^" .
            $municipioDiasUteisVT . "^" .
            $municipioFerias . "^" .
            $tipoBeneficio . "^" .
            $escalaFerias . "^" .
            $escalaFeriasVAVR . "^" .
            $localizacao . "^" .
            $posto . "^" .
            $horaEntrada . "^" .
            $horaInicio . "^" .
            $horaFim . "^" .
            $horaSaida . "^" .
            $departamento . "^" .
            $produtoVAVR;

        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out . "#" . $strArrayVT . "#" . $strArrayPlanoSaude . "#" . $strArrayPlanoSaudeDependente . "#" . $strArrayBeneficioIndireto;
        return;
    }
}

function excluirBeneficio()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("BENEFICIOPROJETO_ACESSAR|BENEFICIOPROJETO_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Beneficio para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    $result = $reposit->update('Ntl.beneficioProjeto' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function recuperaValeTransporteModal()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }

    $sql = "SELECT codigo, descricao, valorTotal FROM Ntl.valeTransporteModal WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $valorTotal = +$row['valorTotal'];

        $out = $id . "^" . $valorTotal;
        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    } else {
        echo "failed#";
        return;
    }
}

function valorProdutoPlanoSaude()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
        $idade = (int) $_POST["idade"];
    }


    $sql = "SELECT codigo,cobranca
            FROM Ntl.produto 
            WHERE (0=0) AND ativo = 1 AND codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {

        $cobranca = +$row["cobranca"];
        if ($cobranca == 1) {
            $result = "";
            $sql = "SELECT valorIdade 
                    FROM Ntl.produtoIdade 
                    WHERE produto = " . $id . " AND " . $idade . " BETWEEN idadeInicial AND idadeFinal";
            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if ($row = $result[0]) {

                $valorIdade = +$row['valorIdade'];
                //$valorIdade = str_replace('.', ',', $valorIdade);
                $out = $valorIdade;
            }
            if ($row != false) {
                echo "sucess#" . $out;
                return;
            } else {
                echo "failed#";
                return;
            }
        }
        if ($cobranca == 0) {
            $sql = "";
            $sql = "SELECT codigo, valorProduto FROM Ntl.produto WHERE codigo = " . $id;
            $reposit = new reposit();
            $result = $reposit->RunQuery($sql);
            if ($row = $result[0]) {
                $valorProduto = $row['valorProduto'];
            }
            $out = $valorProduto;
            if ($out == "") {
                echo "failed#";
                return;
            } else {
                echo "sucess#" . $out;
                return;
            }
        }
    }
}

function calculaIdadeFuncionario()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }

    $sql = "SELECT codigo, dataNascimento FROM Ntl.funcionario WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $dataNascimento = $row['dataNascimento'];

        $dataNascimento = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimento);
        $idade = $difData->format('%y');



        $out = $idade;
        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    }
}
function calculaIdadeDependente()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }

    $sql = "SELECT codigo, dataNascimentoDependente FROM Ntl.funcionarioDependente WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $dataNascimento = $row['dataNascimentoDependente'];

        $dataNascimento = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimento);
        $idade = $difData->format('%y');



        $out = $idade;
        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    }
}
function recuperaValeTransporteUnitario()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }

    $sql = "SELECT codigo, valorUnitario FROM Ntl.valeTransporteUnitario WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $valorUnitario = +$row['valorUnitario'];

        $out = $id . "^" . $valorUnitario;
        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    }
}
function populaComboNomeDependentePlanoSaude()
{
    $id = (int) $_POST["codigo"];

    $sql = "SELECT codigo, nomeDependente FROM Ntl.funcionarioDependente WHERE funcionario = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $contador = 0;

    foreach ($result as $row) {
        $id = $row['codigo'];
        $nomeDependente = $row['nomeDependente'];

        if ($nomeDependente == "") {
            $nomeDependente = "Não Possui";
        }

        $out = $out . $id . "^" . $nomeDependente . "|";

        $contador = $contador + 1;
    }


    echo "sucess#" . $contador . "#" . $out;
    return;
}

function populaCobrancaPlanoSaude()
{

    $id = (int) $_POST["codigo"];

    $sql = "SELECT codigo, cobranca FROM Ntl.produto WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $contador = 0;

    foreach ($result as $row) {
        $id = $row['codigo'];
        $cobranca = $row['cobranca'];


        $out =  $cobranca;
    }
    // if ($out == "") {
    //     echo "failed#0 ";
    // }
    if ($out == 0 || $out == 1) {
        echo "sucess#" . "#" . $out;
    }
    return;
}
function populaComboProdutoPlanoSaude()
{

    $id = (int) $_POST["codigo"];
    $sql = "SELECT codigo, produto, cobranca FROM Ntl.produto WHERE (0=0) AND ativo = 1 AND convenioSaude = " . $id . " ORDER BY produto";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $contador = 0;
    foreach ($result as $row) {

        $id = +$row['codigo'];
        $produto = $row['produto'];
        $out .= $id . "^" . $produto . "|";
        $contador = $contador + 1;
    }


    if ($out == "") {
        echo "failed#";
    }
    if ($out != '') {
        echo "sucess#" . $contador . "#" . $out;
    }
    return;
}
function listaComboVT()
{

    $id = (int) $_POST["codigo"];

    if ($id == 0) {
        $sql = "SELECT * FROM Ntl.valeTransporteModal WHERE descricao != '' AND valorTotal IS NOT NULL ORDER BY descricao";
    } else {
        $sql = "SELECT * FROM Ntl.valeTransporteUnitario  WHERE descricao != '' AND valorUnitario IS NOT NULL ORDER BY descricao";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $contador = 0;

    foreach ($result as $row) {
        $id = $row['codigo'];
        $valeTransporte = $row['descricao'];

        $out = $out . $id . "^" . $valeTransporte . "|";
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

function descontoTipoDiaUtilSindicato()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }


    if ($id == 2) {
        $sql = "SELECT codigo, dataNascimento FROM Ntl.funcionario WHERE codigo = " . $id;
    }
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $dataNascimento = $row['dataNascimento'];

        $dataNascimento = new DateTime($dataNascimento);
        $dataAtual = new DateTime();
        $difData = date_diff($dataAtual, $dataNascimento);
        $idade = $difData->format('%y');



        $out = $idade;
        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    }
}

function valorDescontoSindicatoValeRefeicao()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }


    $sql = "SELECT codigo, descontoFolhaRefeicao, valorDescontoRefeicao FROM Ntl.sindicato WHERE codigo =  " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {

        $descontoFolhaVR = validaNumero($row["descontoFolhaRefeicao"]);
        $valorDescontoFolhaVR = validaNumero($row['valorDescontoRefeicao']);


        $out = $descontoFolhaVR;
        $outValorDescontoFolhaVR = $valorDescontoFolhaVR;
        if ($out == "" && $outValorDescontoFolhaVR == "") {
            echo "failed#";
            return;
        } else {
            echo "sucess#" . $out . "#" . $outValorDescontoFolhaVR;
            return;
        }
    }
}
function valorDescontoProjetoValeRefeicao()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }


    $sql = "SELECT codigo, descontoFolhaVR, valorDescontoFolhaVR FROM Ntl.projeto WHERE (0=0) AND codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {

        $descontoFolhaVR = validaNumero($row["descontoFolhaVR"]);
        $valorDescontoFolhaVR = validaNumero($row['valorDescontoFolhaVR']);


        $out = $descontoFolhaVR;
        $outValorDescontoFolhaVR = $valorDescontoFolhaVR;
        if ($out == "" && $outValorDescontoFolhaVR == "") {
            echo "failed#";
            return;
        } else {
            echo "sucess#" . $out . "#" . $outValorDescontoFolhaVR;
            return;
        }
    }
}
function valorDescontoSindicatoPlanoSaude()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }


    $sql = "SELECT codigo, valorBolsaPlanoSaude, percentualBolsaPlanoSaude FROM Ntl.sindicato WHERE (0=0) AND codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {

        $valorBolsaPlanoSaude = validaNumeroRecupera($row["valorBolsaPlanoSaude"]);
        if ($valorBolsaPlanoSaude == 0) {
            $valorBolsaPlanoSaude = 0;
        }
        $percentualBolsaPlanoSaude = validaNumeroRecupera($row["percentualBolsaPlanoSaude"]);


        $out = $percentualBolsaPlanoSaude;
        $outValorDescontoFolhaPlanoSaude = $valorBolsaPlanoSaude;
        if ($out == "" && $outValorDescontoFolhaPlanoSaude == "") {
            echo "failed#";
            return;
        } else {
            echo "sucess#" . $out . "#" . $outValorDescontoFolhaPlanoSaude;
            return;
        }
    }
}
function valorDescontoProjetoPlanoSaude()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }


    $sql = "SELECT codigo, descontoFolhaPlanoSaude, valorDescontoFolhaPlanoSaude FROM Ntl.projeto WHERE (0=0) AND codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {

        $valorDescontoFolhaPlanoSaude = validaNumeroRecupera($row["valorDescontoFolhaPlanoSaude"]);
        $descontoFolhaPlanoSaude = validaNumeroRecupera($row['descontoFolhaPlanoSaude']);


        $out = $valorDescontoFolhaPlanoSaude;
        $outValorDescontoFolhaPlanoSaude = $descontoFolhaPlanoSaude;
        if ($out == "" && $outValorDescontoFolhaPlanoSaude == "") {
            echo "failed#";
            return;
        } else {
            echo "sucess#" . $out . "#" . $outValorDescontoFolhaPlanoSaude;
            return;
        }
    }
}
function valorDescontoProdutoPlanoSaude()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }


    $sql = "SELECT codigo, descontoFolha, valorDescontoFolha FROM Ntl.produto WHERE (0=0) AND codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($row = $result[0]) {

        $valorDescontoFolhaPlanoSaude = validaNumeroRecupera($row["valorDescontoFolha"]);
        if ($valorDescontoFolhaPlanoSaude == 0) {
            $valorDescontoFolhaPlanoSaude = 0;
        }
        $descontoFolhaPlanoSaude = validaNumeroRecupera($row['descontoFolha']);
        if ($descontoFolhaPlanoSaude == 0) {
            $descontoFolhaPlanoSaude = 0;
        }


        $out = $valorDescontoFolhaPlanoSaude;
        $outValorDescontoFolhaPlanoSaude = $descontoFolhaPlanoSaude;
        if ($out == "" && $outValorDescontoFolhaPlanoSaude == "") {
            echo "failed#";
            return;
        } else {
            echo "sucess#" . $out . "#" . $outValorDescontoFolhaPlanoSaude;
            return;
        }
    }
}

function valorBolsaBeneficioSindicato()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }

    $sql = "SELECT codigo,valorBolsaBeneficio FROM Ntl.sindicato WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $valorBolsaBeneficio = validaNumeroRecupera($row['valorBolsaBeneficio']);

        $out = $valorBolsaBeneficio;
        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    } else {
        echo "failed#";
        return;
    }
}
function descricaoSindicato()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }

    $sql = "SELECT codigo,descricao FROM Ntl.sindicato WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {

        $descricao = $row['descricao'];

        $out = $descricao;
        if ($out == "") {
            echo "failed#";
            return;
        }
        echo "sucess#" . $out;
        return;
    }
}
function recuperaDescontoVR()
{
    $id = (int) $_POST["codigo"];
    if ($id >= 0) {

        $projeto = (int) $_POST["projeto"];
        $sindicato = (int) $_POST["sindicato"];
    } else {
        return false;
    }


    if ($id == 0) {
        $sql = "SELECT codigo, valorDiarioVR, valorMensalVR, descontoFolhaVR, valorDescontoFolhaVR FROM Ntl.projeto WHERE 
            (0=0) AND codigo = " . $projeto;
        $verificacao = 0;
        $out = "";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        if ($row = $result[0]) {

            $valorDiarioVR = validaNumeroRecupera($row['valorDiarioVR']);
            $valorMensalVR = validaNumeroRecupera($row['valorMensalVR']);
            $descontoFolhaVR = validaNumeroRecupera($row['descontoFolhaVR']);
            $valorDescontoFolhaVR = validaNumeroRecupera($row['valorDescontoFolhaVR']);


            $out = $valorDiarioVR . "^" . $valorMensalVR . "^" . $descontoFolhaVR . "^" . $valorDescontoFolhaVR;
            if ($out == "") {
                echo "failed#";
                return;
            }
            echo "sucess#" . $out . "#" . $verificacao;
            return;
        }
    }

    if ($id == 1) {
        $sql = "SELECT codigo, valorDiarioRefeicao, valorMensalRefeicao, descontoFolhaRefeicao, valorDescontoRefeicao FROM Ntl.sindicato WHERE 
            (0=0) AND codigo = " . $sindicato;
        $verificacao = 1;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        if ($row = $result[0]) {

            $valorDiarioRefeicao = validaNumeroRecupera($row['valorDiarioRefeicao']);
            $valorMensalRefeicao = validaNumeroRecupera($row['valorMensalRefeicao']);
            $descontoFolhaRefeicao = validaNumeroRecupera($row['descontoFolhaRefeicao']);
            $valorDescontoRefeicao = validaNumeroRecupera($row['valorDescontoRefeicao']);


            $out = $valorDiarioRefeicao . "^" . $valorMensalRefeicao . "^" . $descontoFolhaRefeicao . "^" . $valorDescontoRefeicao;
            if ($out == "") {
                echo "failed#";
                return;
            }
            echo "sucess#" . $out . "#" . $verificacao;
            return;
        }
    }

    echo "failed#";
    return;
}
function recuperaDescontoVA()
{
    $id = (int) $_POST["codigo"];
    if ($id >= 0) {

        $projeto = (int) $_POST["projeto"];
        $sindicato = (int) $_POST["sindicato"];
    } else {
        return false;
    }


    if ($id == 0) {
        $sql = "	SELECT codigo, descontoFolhaVAVR, valorDescontoFolhaVAVR, valorDiarioVAVR, valorMensalVAVR FROM Ntl.projeto WHERE 
             (0=0) AND codigo = " . $projeto;
        $verificacao = 0;
        $out = "";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        if ($row = $result[0]) {

            $valorDiarioVA = validaNumeroRecupera($row['valorDiarioVAVR']);
            $valorMensalVA = validaNumeroRecupera($row['valorMensalVAVR']);
            $descontoFolhaVA = validaNumeroRecupera($row['descontoFolhaVAVR']);
            $valorDescontoFolhaVA = validaNumeroRecupera($row['valorDescontoFolhaVAVR']);


            $out = $valorDiarioVA . "^" . $valorMensalVA . "^" . $descontoFolhaVA . "^" . $valorDescontoFolhaVA;
            if ($out == "") {
                echo "failed#";
                return;
            }
            echo "sucess#" . $out . "#" . $verificacao;
            return;
        }
    }

    if ($id == 1) {
        $sql = "SELECT codigo, descontoFolhaAlimentacao, valorDescontoAlimentacao, valorDiarioAlimentacao, valorMensalAlimentacao FROM Ntl.sindicato WHERE 
            (0=0) AND codigo = " . $sindicato;
        $verificacao = 1;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        if ($row = $result[0]) {

            $valorDiarioAlimentacao = validaNumeroRecupera($row['valorDiarioAlimentacao']);
            $valorMensalAlimentacao = validaNumeroRecupera($row['valorMensalAlimentacao']);
            $descontoFolhaAlimentacao = validaNumeroRecupera($row['descontoFolhaAlimentacao']);
            $valorDescontoAlimentacao = validaNumeroRecupera($row['valorDescontoAlimentacao']);


            $out = $valorDiarioAlimentacao . "^" . $valorMensalAlimentacao . "^" . $descontoFolhaAlimentacao . "^" . $valorDescontoAlimentacao;
            if ($out == "") {
                echo "failed#";
                return;
            }
            echo "sucess#" . $out . "#" . $verificacao;
            return;
        }
    }

    echo "failed#";
    return;
}

function valorCestaBasicaSindicato()
{
    if ((empty($_POST["codigo"])) || (!isset($_POST["codigo"])) || (is_null($_POST["codigo"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["codigo"];
    }

    $sql = "SELECT valorMensalCestaBasica, descontoFolhaCestaBasica, valorDescontoCestaBasica FROM Ntl.sindicato WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $valorMensalCestaBasica = validaNumeroRecupera($row['valorMensalCestaBasica']);
        if ($valorMensalCestaBasica == 0) {
            $valorMensalCestaBasica = 0;
        }
        $descontoFolhaCestaBasica = validaNumeroRecupera($row['descontoFolhaCestaBasica']);
        if ($descontoFolhaCestaBasica == 0) {
            $descontoFolhaCestaBasica = 0;
        }
        $valorDescontoCestaBasica = validaNumeroRecupera($row['valorDescontoCestaBasica']);
        if ($valorDescontoCestaBasica == 0) {
            $valorDescontoCestaBasica = 0;
        }

        $out = $valorMensalCestaBasica . "#" . $descontoFolhaCestaBasica . "#" . $valorDescontoCestaBasica;
        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    } else {
        echo "failed#";
        return;
    }
}
function verificaFuncionarioProjeto()
{
    $funcionario = $_POST['funcionario'];
    $projeto = $_POST['projeto'];

    $sql = "SELECT codigo, funcionario, projeto FROM Ntl.beneficioProjeto WHERE (0=0) AND funcionario = " . $funcionario . " AND projeto = " . $projeto . " AND ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    $row = $result[0];

    if ($row == false) {
        echo "failed#";
        return;
    }
    echo "sucess#" . $out;
    return;
}

function validaNumero($value)
{
    $aux = $value;
    $aux = str_replace('.', '', $aux);
    $aux = str_replace(',', '.', $aux);
    $aux = floatval($aux);
    if (!$aux) {
        $aux = 0;
    }
    return $aux;
}
function validaNumeroRecupera($value)
{
    $aux = $value;
    $aux = str_replace('.', ',', $aux);
    if (!$aux) {
        $aux = 0;
    }
    return $aux;
}

function validaString($value)
{
    $null = 'NULL';
    if ($value == '')
        return $null;
    return '\'' . $value . '\'';
}

//Transforma uma data D-M-Y para Y-M-D 
function validaData($campo)
{
    $campo = explode("/", $campo);
    $campo = $campo[2] . "/" . $campo[1] . "/" . $campo[0];
    return  $campo;
}
//Transforma uma data Y-D-M para D-M-Y 
function validaDataRecupera($campo)
{
    $campo = explode("-", $campo);
    $dia = explode(" ", $campo[2]);
    $campo = $dia[0] . "/" . $campo[1] . "/" . $campo[0];
    return  $campo;
}

function preencheValorPosto()
{
    $posto = (int) $_POST['posto'];

    $sql = "SELECT codigo,descricaoPosto,valor FROM Ntl.valorPosto WHERE codigo = $posto";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if ($row = $result[0]) {
        $valorPosto = $row['valor'];
    }
    $out = $valorPosto;
    if ($out != '' || $out == 0) {
        echo "sucess#" . $out;
    }
    return;
}

function populaComboDescricaoPosto()
{
    $projeto = $_POST["projeto"];
    if ($projeto > 0) {
        $sql = "SELECT VP.codigo, VP.descricaoPosto,P.descricao AS nomePosto
        FROM Ntl.valorPosto VP 
        LEFT JOIN Ntl.posto P on P.codigo = VP.descricaoPosto
        where VP.ativo = 1 AND VP.projeto = $projeto order by nomePosto ";

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contador = 0;
        $out = "";
        foreach ($result as $row) {
            $id = $row['codigo'];
            $descricaoPosto = $row['nomePosto'];

            $out = $out . $id . "^" . $descricaoPosto . "|";

            $contador = $contador + 1;
        }
        if ($out != "") {
            echo "sucess#" . $contador . "#" . $out;
            return;
        }
        echo "failed#";
        return;
    }
}
