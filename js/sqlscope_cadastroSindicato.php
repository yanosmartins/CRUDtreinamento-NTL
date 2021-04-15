<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaSindicato') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaSindicato') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}
if ($funcao == 'pesquisaCnpj') {
    call_user_func($funcao);
}

if ($funcao == 'listaSindicatoAtivoAutoComplete') {
    call_user_func($funcao);
}


return;

function gravaSindicato()
{

    $reposit = new reposit(); //Abre a conexão.

    //Verifica permissões
    $possuiPermissao = $reposit->PossuiPermissao("SINDICATO_ACESSAR|SINDICATO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";

    //Atributos de vale de transporte
    $sindicato = $_POST['sindicato'];
    $codigo =  validaNumero($sindicato['codigo']);
    $mesBase = validaNumero($sindicato['dataBase']);
    $descricao = validaString($sindicato['descricao']);
    $apelido = validaString($sindicato['apelido']);
    $cnpj = validaString($sindicato['cnpj']);
    $codigoSindicatoSCI = validaNumero($sindicato['codigoSindicatoSCI']);

    $valorBolsaBeneficio = validaNumero($sindicato['valorBolsaBeneficio']);
    $descontarValeRefeicao = validaNumero($sindicato['descontarValeRefeicao']);
    $descontarFeriasRefeicao = validaNumero($sindicato['descontarFeriasVR']);
    $valorDiarioRefeicao = validaNumero($sindicato['valorDiarioVR']);
    $valorMensalRefeicao = validaNumero($sindicato['valorMensalVR']);
    $descontoFolhaRefeicao = validaNumero($sindicato['descontoVRFolha']);
    $valorDescontoRefeicao = validaNumero($sindicato['valorDescontoVRFolha']);
    $descontarValeAlimentacao = validaNumero($sindicato['descontaVA']);
    $descontarFeriasAlimentacao = validaNumero($sindicato['descontarFeriasVA']);
    $valorDiarioAlimentacao = validaNumero($sindicato['valorDiarioVA']);
    $valorMensalAlimentacao = validaNumero($sindicato['valorMensalVA']);
    $descontoFolhaAlimentacao = validaNumero($sindicato['descontoVAFolha']);
    $valorDescontoAlimentacao = validaNumero($sindicato['valorDescontoVAFolha']);
    $valorDiarioCestaBasica = validaNumero($sindicato['valorDiarioCestaBasica']);
    $valorMensalCestaBasica = validaNumero($sindicato['valorMensalCestaBasica']);
    $descontoFolhaCestaBasica = validaNumero($sindicato['descontoFolhaCestaBasica']);
    $valorDescontoCestaBasica = validaNumero($sindicato['valorDescontoCestaBasica']);
    $perdaBeneficio = validaNumero($sindicato['perdaBeneficio']);
    $qtdDiaFalta = validaNumero($sindicato['qtdDiaFalta']);
    $qtdDiaAusencia = validaNumero($sindicato['qtdDiaAusencia']);

    $valorBolsaPlanoSaude = validaNumero($sindicato['valorBolsa']);
    $percentualBolsaPlanoSaude = validaNumero($sindicato['percentualBolsa']);
    $seguroVida = validaNumero($sindicato['seguroVida']);
    $valorBolsaBeneficio6h = validaNumero($sindicato['valorBolsaBeneficio6h']);

    $percentualHoraExtraSegundaSabado = validaNumero($sindicato['percentualHoraExtraSegundaSabado']);
    $percentualHoraExtraDomingoFeriado = validaNumero($sindicato['percentualHoraExtraDomingoFeriado']);
    $percentualHoraExtraSegundaSabadoNoturno = validaNumero($sindicato['percentualHoraExtraSegundaSabadoNoturno']);
    $percentualHoraExtraDomingoFeriadoNoturno = validaNumero($sindicato['percentualHoraExtraDomingoFeriadoNoturno']);
    $adicionalNoturno = validaNumero($sindicato['adicionalNoturno']);

    $cep = validaString($sindicato['cep']);
    $logradouro = validaString($sindicato['logradouro']);
    $numeroEndereco = validaNumero($sindicato['numero']);
    $complemento = validaString($sindicato['complemento']);
    $bairro = validaString($sindicato['bairro']);
    $cidade = validaString($sindicato['cidade']);
    $estado = validaString($sindicato['estado']);
    $situacao = 1;

    $horaInicialAidicionalNoturno = validaString($sindicato['horaInicialAidicionalNoturno']);
    $horaFinalAidicionalNoturno = validaString($sindicato['horaFinalAidicionalNoturno']);
    //Dias úteis VAVR
    $diaUtilJaneiro   = validaNumero($sindicato['diaUtilJaneiro']);
    $diaUtilFevereiro = validaNumero($sindicato['diaUtilFevereiro']);
    $diaUtilMarco     = validaNumero($sindicato['diaUtilMarco']);
    $diaUtilAbril     = validaNumero($sindicato['diaUtilAbril']);
    $diaUtilMaio      = validaNumero($sindicato['diaUtilMaio']);
    $diaUtilJunho     = validaNumero($sindicato['diaUtilJunho']);
    $diaUtilJulho     = validaNumero($sindicato['diaUtilJulho']);
    $diaUtilAgosto    = validaNumero($sindicato['diaUtilAgosto']);
    $diaUtilSetembro  = validaNumero($sindicato['diaUtilSetembro']);
    $diaUtilOutubro   = validaNumero($sindicato['diaUtilOutubro']);
    $diaUtilNovembro  = validaNumero($sindicato['diaUtilNovembro']);
    $diaUtilDezembro  = validaNumero($sindicato['diaUtilDezembro']);

    //Dias Uteis VT
    $diaUtilJaneiroVT   = validaNumero($sindicato['diaUtilJaneiroVT']);
    $diaUtilFevereiroVT = validaNumero($sindicato['diaUtilFevereiroVT']);
    $diaUtilMarcoVT     = validaNumero($sindicato['diaUtilMarcoVT']);
    $diaUtilAbrilVT     = validaNumero($sindicato['diaUtilAbrilVT']);
    $diaUtilMaioVT      = validaNumero($sindicato['diaUtilMaioVT']);
    $diaUtilJunhoVT     = validaNumero($sindicato['diaUtilJunhoVT']);
    $diaUtilJulhoVT     = validaNumero($sindicato['diaUtilJulhoVT']);
    $diaUtilAgostoVT    = validaNumero($sindicato['diaUtilAgostoVT']);
    $diaUtilSetembroVT  = validaNumero($sindicato['diaUtilSetembroVT']);
    $diaUtilOutubroVT   = validaNumero($sindicato['diaUtilOutubroVT']);
    $diaUtilNovembroVT  = validaNumero($sindicato['diaUtilNovembroVT']);
    $diaUtilDezembroVT  = validaNumero($sindicato['diaUtilDezembroVT']);

    $descontarFeriasCestaBasica  = +$sindicato['descontarFeriasCestaBasica'];

    //------------------------Sindicato Telefone------------------
    $strArrayTelefone = $sindicato['jsonTelefone'];
    $arrayTelefone = json_decode($strArrayTelefone, true);
    $xmlTelefone = "";
    $nomeXml = "ArrayOfSindicatoTelefone";
    $nomeTabela = "sindicatoTelefone";
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

    //-------------------------Sindicato Email---------------------
    $strArrayEmail = $sindicato['jsonEmail'];
    $arrayEmail = json_decode($strArrayEmail, true);
    $xmlEmail = "";
    $nomeXml = "ArrayOfSindicatoEmail";
    $nomeTabela = "sindicatoEmail";
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



    $sql = "Ntl.sindicato_Atualiza 
        $codigo,
        $mesBase,
        $descricao,
        $apelido,
        $cnpj,
        $valorBolsaBeneficio,
        $descontarValeRefeicao,
        $descontarFeriasRefeicao,
        $valorDiarioRefeicao,
        $valorMensalRefeicao,
        $descontoFolhaRefeicao,
        $valorDescontoRefeicao,
        $descontarValeAlimentacao,
        $descontarFeriasAlimentacao,
        $valorDiarioAlimentacao,
        $valorMensalAlimentacao,
        $descontoFolhaAlimentacao,
        $valorDescontoAlimentacao,
        $valorDiarioCestaBasica,
        $valorMensalCestaBasica,
        $descontoFolhaCestaBasica,
        $valorDescontoCestaBasica,
        $valorBolsaPlanoSaude,
        $percentualBolsaPlanoSaude,
        $seguroVida,
        $percentualHoraExtraSegundaSabado,
        $percentualHoraExtraDomingoFeriado,
        $adicionalNoturno,
        $cep,
        $logradouro,
        $numeroEndereco,
        $complemento,
        $bairro,
        $cidade,
        $estado,
        $situacao,
        $horaInicialAidicionalNoturno,
        $horaFinalAidicionalNoturno,
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
        $perdaBeneficio,
        $percentualHoraExtraSegundaSabadoNoturno,
        $percentualHoraExtraDomingoFeriadoNoturno,
        $valorBolsaBeneficio6h,
        $qtdDiaFalta,
        $qtdDiaAusencia,
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
        $codigoSindicatoSCI,
        $descontarFeriasCestaBasica,
        $xmlTelefone,
        $xmlEmail,
        $usuario";

    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}


function recuperaSindicato()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT * FROM Ntl.sindicato WHERE codigo = " . $id;


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0]) {


        $id = +$row['codigo'];
        $mesBase = +$row['mesBase'];
        $descricao = $row['descricao'];
        $apelido = $row['apelido'];
        $cnpj = $row['cnpj'];
        $codigoSindicatoSCI = +$row['codigoSindicatoSCI'];
        $valorBolsaBeneficio = validaNumeroRecupera($row['valorBolsaBeneficio']);
        $descontarValeRefeicao = +$row['descontoValeRefeicao'];
        $descontarFeriasRefeicao = +$row['descontoFeriasRefeicao'];
        $valorDiarioRefeicao = validaNumeroRecupera($row['valorDiarioRefeicao']);
        $valorMensalRefeicao = validaNumeroRecupera($row['valorMensalRefeicao']);
        $descontoFolhaRefeicao = validaNumeroRecupera($row['descontoFolhaRefeicao']);
        $valorDescontoRefeicao = validaNumeroRecupera($row['valorDescontoRefeicao']);
        $descontarValeAlimentacao = validaNumeroRecupera($row['descontoValeAlimentacao']);
        $descontarFeriasAlimentacao = validaNumeroRecupera($row['descontoFeriasAlimentacao']);
        $valorDiarioAlimentacao = validaNumeroRecupera($row['valorDiarioAlimentacao']);
        $valorMensalAlimentacao = validaNumeroRecupera($row['valorMensalAlimentacao']);
        $descontoFolhaAlimentacao = validaNumeroRecupera($row['descontoFolhaAlimentacao']);
        $valorDescontoAlimentacao = validaNumeroRecupera($row['valorDescontoAlimentacao']);
        $valorDiarioCestaBasica = validaNumeroRecupera($row['valorDiarioCestaBasica']);
        $valorMensalCestaBasica = validaNumeroRecupera($row['valorMensalCestaBasica']);
        $descontoFolhaCestaBasica = validaNumeroRecupera($row['descontoFolhaCestaBasica']);
        $valorDescontoCestaBasica = validaNumeroRecupera($row['valorDescontoCestaBasica']);
        $valorBolsaPlanoSaude = validaNumeroRecupera($row['valorBolsaPlanoSaude']);
        $percentualBolsaPlanoSaude = validaNumeroRecupera($row['percentualBolsaPlanoSaude']);
        $seguroVida = validaNumeroRecupera($row['seguroVida']);
        $cep = $row['cep'];
        $logradouro =  $row['logradouro'];
        $numeroEndereco = +$row['numeroEndereco'];
        $complemento = $row['complemento'];
        $bairro = $row['bairro'];
        $cidade = $row['cidade'];
        $estado = $row['estado'];
        $percentualHoraExtraSegundaSabado = validaNumeroRecupera($row['percentualHoraExtraSegundaSabado']);
        $percentualHoraExtraDomingoFeriado = validaNumeroRecupera($row['percentualHoraExtraDomingoFeriado']);
        $percentualHoraExtraSegundaSabadoNoturno = validaNumeroRecupera($row['percentualHoraExtraSegundaSabadoNoturno']);
        $percentualHoraExtraDomingoFeriadoNoturno = validaNumeroRecupera($row['percentualHoraExtraDomingoFeriadoNoturno']);
        $adicionalNoturno = +$row['adicionalNoturno'];
        $horaInicialAdicionalNoturno = $row['horaInicialAdicionalNoturno'];
        $horaFinalAdicionalNoturno = $row['horaFinalAdicionalNoturno'];
      
        $perdaBeneficio  = +$row['perdaBeneficio'];
        $qtdDiaFalta  = +$row['qtdDiaFalta'];
        $qtdDiaAusencia  = +$row['qtdDiaAusencia'];
        $perdaBeneficio  = +$row['perdaBeneficio'];
        $valorBolsaBeneficio6h  = validaNumeroRecupera($row['valorBolsaBeneficio6h']);
        //Dias Uteis VAVR
        $diaUtilJaneiro   = +$row['diaUtilJaneiroVAVR'];
        $diaUtilFevereiro = +$row['diaUtilFevereiroVAVR'];
        $diaUtilMarco     = +$row['diaUtilMarcoVAVR'];
        $diaUtilAbril     = +$row['diaUtilAbrilVAVR'];
        $diaUtilMaio      = +$row['diaUtilMaioVAVR'];
        $diaUtilJunho     = +$row['diaUtilJunhoVAVR'];
        $diaUtilJulho     = +$row['diaUtilJulhoVAVR'];
        $diaUtilAgosto    = +$row['diaUtilAgostoVAVR'];
        $diaUtilSetembro  = +$row['diaUtilSetembroVAVR'];
        $diaUtilOutubro   = +$row['diaUtilOutubroVAVR'];
        $diaUtilNovembro  = +$row['diaUtilNovembroVAVR'];
        $diaUtilDezembro  = +$row['diaUtilDezembroVAVR'];
        //Dias Uteis VT
        $diaUtilJaneiroVT   = +$row['diaUtilJaneiroVT'];
        $diaUtilFevereiroVT = +$row['diaUtilFevereiroVT'];
        $diaUtilMarcoVT     = +$row['diaUtilMarcoVT'];
        $diaUtilAbrilVT     = +$row['diaUtilAbrilVT'];
        $diaUtilMaioVT      = +$row['diaUtilMaioVT'];
        $diaUtilJunhoVT     = +$row['diaUtilJunhoVT'];
        $diaUtilJulhoVT     = +$row['diaUtilJulhoVT'];
        $diaUtilAgostoVT    = +$row['diaUtilAgostoVT'];
        $diaUtilSetembroVT  = +$row['diaUtilSetembroVT'];
        $diaUtilOutubroVT   = +$row['diaUtilOutubroVT'];
        $diaUtilNovembroVT  = +$row['diaUtilNovembroVT'];
        $diaUtilDezembroVT  = +$row['diaUtilDezembroVT'];

        $descontarFeriasCestaBasica  = +$row['descontarFeriasCestaBasica'];
        //----------------------Montando o array do Telefone

        $reposit = "";
        $result = "";
        $sql = "SELECT * FROM Ntl.sindicato SI 
        INNER JOIN Ntl.sindicatoTelefone ST ON SI.codigo = ST.sindicato WHERE SI.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorTelefone = 0;
        $arrayTelefone = array();
        foreach($result as $row) {
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
        $sql = "SELECT * FROM Ntl.sindicato SI 
        INNER JOIN Ntl.sindicatoEmail SE ON SI.codigo = SE.sindicato WHERE SI.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorEmail = 0;
        $arrayEmail = array();
        foreach($result as $row) {
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

        $out = $id . "^" .
            $mesBase . "^" .
            $descricao . "^" .
            $apelido . "^" .
            $cnpj . "^" .
            $valorBolsaBeneficio . "^" .
            $descontarValeRefeicao . "^" .
            $descontarFeriasRefeicao . "^" .
            $valorDiarioRefeicao . "^" .
            $valorMensalRefeicao . "^" .
            $descontoFolhaRefeicao . "^" .
            $valorDescontoRefeicao . "^" .
            $descontarValeAlimentacao . "^" .
            $descontarFeriasAlimentacao . "^" .
            $valorDiarioAlimentacao . "^" .
            $valorMensalAlimentacao . "^" .
            $descontoFolhaAlimentacao . "^" .
            $valorDescontoAlimentacao . "^" .
            $valorDiarioCestaBasica . "^" .
            $valorMensalCestaBasica . "^" .
            $descontoFolhaCestaBasica . "^" .
            $valorDescontoCestaBasica . "^" .
            $valorBolsaPlanoSaude . "^" .
            $percentualBolsaPlanoSaude . "^" .
            $seguroVida . "^" .
            $cep . "^" .
            $logradouro . "^" .
            $numeroEndereco . "^" .
            $complemento . "^" .
            $bairro . "^" .
            $cidade . "^" .
            $estado . "^" .
            $percentualHoraExtraSegundaSabado . "^" .
            $percentualHoraExtraDomingoFeriado . "^" .
            $adicionalNoturno . "^" .
            $horaInicialAdicionalNoturno . "^" .
            $horaFinalAdicionalNoturno . "^" .
            $strArrayTelefone . "^" .
            $strArrayEmail . "^" .
            $diaUtilJaneiro  . "^" .
            $diaUtilFevereiro . "^" .
            $diaUtilMarco    . "^" .
            $diaUtilAbril    . "^" .
            $diaUtilMaio     . "^" .
            $diaUtilJunho    . "^" .
            $diaUtilJulho    . "^" .
            $diaUtilAgosto   . "^" .
            $diaUtilSetembro . "^" .
            $diaUtilOutubro  . "^" .
            $diaUtilNovembro . "^" .
            $diaUtilDezembro . "^" .
            $perdaBeneficio . "^" .
            $percentualHoraExtraSegundaSabadoNoturno . "^" .
            $percentualHoraExtraDomingoFeriadoNoturno . "^" .
            $valorBolsaBeneficio6h . "^" .
            $qtdDiaFalta . "^" .
            $qtdDiaAusencia . "^" .
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
            $diaUtilDezembroVT  . "^" .
            $codigoSindicatoSCI . "^" .
            $descontarFeriasCestaBasica;



        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out . "#" . $strArrayTelefone . "#" . $strArrayEmail;
        return;
    }
}


function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("SINDICATO_ACESSAR|SINDICATO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um tipo de Sindicato.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $result = $reposit->update('Ntl.sindicato' . '|' . 'situacao = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function pesquisaCnpj()
{
    $condicaocnpj = !((empty($_POST["cnpj"])) || (!isset($_POST["cnpj"])) || (is_null($_POST["cnpj"])));

    if ($condicaocnpj) {
        $condicaocnpj = "'" . $_POST["cnpj"] . "'";
    }

    $sql = "SELECT codigo, cnpj FROM Ntl.sindicato WHERE cnpj = " . $condicaocnpj;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0]) {
        $cnpj = $row['cnpj'];
        //manda os dados pra piece e depois são explodidos
        $out = $cnpj;
    }
    if ($out == "") {
        echo "failed#";
    }
    if ($out != '') {
        echo "sucess#" . $out;
    }
    return;
}

function validaNumero($value)
{
    return floatval($value);
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


function listaSindicatoAtivoAutoComplete()
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
    $sql = "SELECT codigo,apelido FROM Ntl.sindicato WHERE (0=0) AND situacao = 1 AND apelido LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY descricao";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach($result as $row) {
        $id = $row['codigo'];
        $descricao = $row["apelido"];
        $contador = $contador + 1;
        $array[] = array("id" => $id, "apelido" => $descricao);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}
