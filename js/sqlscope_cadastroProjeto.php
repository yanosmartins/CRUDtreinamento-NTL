<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaProjeto') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaProjeto') {
    call_user_func($funcao);
}

if ($funcao == 'excluirProjeto') {
    call_user_func($funcao);
}
if ($funcao == 'listaProjetoAtivoAutoComplete') {
    call_user_func($funcao);
}


if ($funcao == 'recuperaNomeLogin') {
    call_user_func($funcao);
}

//if ($funcao == 'popularComboMunicipio') {
//    call_user_func($funcao);
//}

return;

function gravaProjeto()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PROJETO_ACESSAR|PROJETO_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $comum = new comum();

    //Variáveis
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";

    $projeto = $_POST['projeto'];

    $codigo = (int)$projeto['codigo'];
    $cnpj = validaString($projeto['cnpj']);
    $descricao = validaString($projeto['descricao']);
    $apelido = validaString($projeto['apelido']);
    $dataAssinatura = validaData($projeto['dataAssinatura']);
    $dataRenovacao = validaData($projeto['dataRenovacao']);
    $seguroVida =  validaNumero($projeto['seguroVida']);
    $cep = validaString($projeto['cep']);
    $logradouro = validaString($projeto['logradouro']);
    $numeroEndereco = validaNumero($projeto['numero']);
    $complemento = validaString($projeto['complemento']) ?: 'null';
    $bairro = validaString($projeto['bairro']);
    $cidade = validaString($projeto['cidade']);
    $estado = validaString($projeto['estado']);
    $ativo = 1;
    $fornecedorObrigatorio = (int)$projeto['fornecedorObrigatorio'];

    //#########     DIAS ÚTEIS VAVR ##########//
    $diaUtilJaneiroVAVR     = validaNumero($projeto['diaUtilJaneiroVA']);
    $diaUtilFevereiroVAVR   = validaNumero($projeto['diaUtilFevereiroVA']);
    $diaUtilMarcoVAVR      = validaNumero($projeto['diaUtilMarcoVA']);
    $diaUtilAbrilVAVR       = validaNumero($projeto['diaUtilAbrilVA']);
    $diaUtilMaioVAVR        = validaNumero($projeto['diaUtilMaioVA']);
    $diaUtilJunhoVAVR       = validaNumero($projeto['diaUtilJunhoVA']);
    $diaUtilJulhoVAVR       = validaNumero($projeto['diaUtilJulhoVA']);
    $diaUtilAgostoVAVR      = validaNumero($projeto['diaUtilAgostoVA']);
    $diaUtilSetembroVAVR   = validaNumero($projeto['diaUtilSetembroVA']);
    $diaUtilOutubroVAVR     = validaNumero($projeto['diaUtilOutubroVA']);
    $diaUtilNovembroVAVR    = validaNumero($projeto['diaUtilNovembroVA']);
    $diaUtilDezembroVAVR    = validaNumero($projeto['diaUtilDezembroVA']);

    $descontoVAVR    = validaNumero($projeto['descontoVA']);
    $descontoFeriasVAVR    = validaNumero($projeto['descontoFeriasVA']);
    $valorDiarioVAVR    = validaNumero($projeto['valorDiarioVA']);
    $valorMensalVAVR    = validaNumero($projeto['valorMensalVA']);
    $descontoFolhaVAVR    = validaNumero($projeto['descontoFolhaVA']);
    $valorDescontoFolhaVAVR    = validaNumero($projeto['valorDescontoFolhaVA']);
    //#########     DIAS ÚTEIS VT ##########//
    $diaUtilJaneiroVT     = validaNumero($projeto['diaUtilJaneiroVT']);
    $diaUtilFevereiroVT   = validaNumero($projeto['diaUtilFevereiroVT']);
    $diaUtilMarcoVT       = validaNumero($projeto['diaUtilMarcoVT']);
    $diaUtilAbrilVT       = validaNumero($projeto['diaUtilAbrilVT']);
    $diaUtilMaioVT        = validaNumero($projeto['diaUtilMaioVT']);
    $diaUtilJunhoVT       = validaNumero($projeto['diaUtilJunhoVT']);
    $diaUtilJulhoVT       = validaNumero($projeto['diaUtilJulhoVT']);
    $diaUtilAgostoVT      = validaNumero($projeto['diaUtilAgostoVT']);
    $diaUtilSetembroVT    = validaNumero($projeto['diaUtilSetembroVT']);
    $diaUtilOutubroVT     = validaNumero($projeto['diaUtilOutubroVT']);
    $diaUtilNovembroVT    = validaNumero($projeto['diaUtilNovembroVT']);
    $diaUtilDezembroVT    = validaNumero($projeto['diaUtilDezembroVT']);

    $descontoVT    = validaNumero($projeto['descontoVT']);
    $descontoFeriasVT    = validaNumero($projeto['descontoFeriasVT']);
    $valorDiarioVT    = validaNumero($projeto['valorDiarioVT']);
    $valorMensalVT    = validaNumero($projeto['valorMensalVT']);
    $descontoFolhaVT    = validaNumero($projeto['descontoFolhaVT']);
    $valorDescontoFolhaVT    = validaNumero($projeto['valorDescontoFolhaVT']);
    $descontoFolhaVT    = validaNumero($projeto['descontoFolhaVT']);
    $valorDescontoFolhaVT    = validaNumero($projeto['valorDescontoFolhaVT']);

    $numeroCentroCusto = validaNumero($projeto['numeroCentroCusto']);
    $descontoFolhaPlanoSaude    = validaNumero($projeto['descontoFolhaPlanoSaude']);
    $valorDescontoFolhaPlanoSaude    = validaNumero($projeto['valorDescontoFolhaPlanoSaude']);
    $municipioFerias = validaNumero($projeto['municipioFerias']);
    $razaoSocial = validaString($projeto['razaoSocial']);

    $limiteEntrada = validaString($projeto['limiteEntrada']);
    $limiteSaida = validaString($projeto['limiteSaida']);
    $imprimeCargo = $projeto['imprimeCargo'];
    $fornecedorVAVR = (int)$projeto['apelidoFornecedorId'];
    if (!$fornecedorVAVR)
        $fornecedorVAVR = $comum->formataNuloGravar($fornecedorVAVR);

    //------------------------PROJETO Telefone------------------
    $strArrayTelefone = $projeto['jsonTelefone'];
    $arrayTelefone = json_decode($strArrayTelefone, true);
    $xmlTelefone = "";
    $nomeXml = "ArrayOfProjetoTelefone";
    $nomeTabela = "projetoTelefone";
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

    //-------------------------PROJETO Email---------------------
    $strArrayEmail = $projeto['jsonEmail'];
    $arrayEmail = json_decode($strArrayEmail, true);
    $xmlEmail = "";
    $nomeXml = "ArrayOfProjetoEmail";
    $nomeTabela = "projetoEmail";
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

    //-------------------------PROJETO FOLGA---------------------
    $strArrayFolga = $projeto['jsonFolga'];
    $arrayFolga = json_decode($strArrayFolga, true);
    $xmlFolga = "";
    $nomeXml = "ArrayOfProjetoFolga";
    $nomeTabela = "projetoFolga";
    if (sizeof($arrayFolga) > 0) {
        $xmlFolga = '<?xml version="1.0"?>';
        $xmlFolga = $xmlFolga . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

        foreach ($arrayFolga as $chave) {
            $xmlFolga = $xmlFolga . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialFolga") |
                    ($campo === "descricaoDescontaVA") |
                    ($campo === "descricaoDescontaVR") |
                    ($campo === "descricaoDescontaVT")
                ) {
                    continue;
                }
                if (($campo === "dataInicioFolga")) {
                    $valor = validaDataXML($valor);
                }
                if (($campo === "dataFimFolga")) {
                    $valor = validaDataXML($valor);
                }
                $xmlFolga = $xmlFolga . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlFolga = $xmlFolga . "</" . $nomeTabela . ">";
        }
        $xmlFolga = $xmlFolga . "</" . $nomeXml . ">";
    } else {
        $xmlFolga = '<?xml version="1.0"?>';
        $xmlFolga = $xmlFolga . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlFolga = $xmlFolga . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlFolga);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlFolga = "'" . $xmlFolga . "'";


    //responsavel

    //Inicio do Json Encargo
    $strJsonResponsavel = $projeto["jsonResponsavel"];
    $arrayJsonResponsavel = json_decode($strJsonResponsavel, true);
    $xmlJsonResponsavel = "";
    $nomeXml = "ArrayOfResponsavel";
    $nomeTabela = "projetoResponsavel";
    if (sizeof($arrayJsonResponsavel) > 0) {
        $xmlJsonResponsavel = '<?xml version="1.0"?>';
        $xmlJsonResponsavel = $xmlJsonResponsavel . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayJsonResponsavel as $chave) {
            $xmlJsonResponsavel = $xmlJsonResponsavel . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                if (($campo === "sequencialResponsavel")) {
                    continue;
                }
                if (($campo === "responsavelLoginDescricao")) {
                    continue;
                }
                $xmlJsonResponsavel = $xmlJsonResponsavel . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonResponsavel = $xmlJsonResponsavel . "</" . $nomeTabela . ">";
        }
        $xmlJsonResponsavel = $xmlJsonResponsavel . "</" . $nomeXml . ">";
    } else {
        $xmlJsonResponsavel = '<?xml version="1.0"?>';
        $xmlJsonResponsavel = $xmlJsonResponsavel . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonResponsavel = $xmlJsonResponsavel . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonResponsavel);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonResponsavel = "'" . $xmlJsonResponsavel . "'";
    //Fim do Json Encargo

    $sql = "Ntl.projeto_Atualiza
        $codigo,
        $ativo,
        $cnpj,
        $descricao,
        $apelido,
        $dataAssinatura,
        $dataRenovacao,
        $seguroVida,
        $cep,
        $logradouro,
        $numeroEndereco,
        $complemento,
        $bairro,
        $cidade,
        $estado,
        $xmlTelefone,
        $xmlEmail,
        $diaUtilJaneiroVAVR,
        $diaUtilFevereiroVAVR,
        $diaUtilMarcoVAVR,
        $diaUtilAbrilVAVR,
        $diaUtilMaioVAVR,
        $diaUtilJunhoVAVR,
        $diaUtilJulhoVAVR,
        $diaUtilAgostoVAVR,
        $diaUtilSetembroVAVR,
        $diaUtilOutubroVAVR,
        $diaUtilNovembroVAVR,
        $diaUtilDezembroVAVR,
        $descontoVAVR,    
        $descontoFeriasVAVR,   
        $valorDiarioVAVR,  
        $valorMensalVAVR, 
        $descontoFolhaVAVR, 
        $valorDescontoFolhaVAVR,  
        $xmlFolga,
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
        $descontoVT,    
        $descontoFeriasVT,   
        $valorDiarioVT,  
        $valorMensalVT, 
        $descontoFolhaVT, 
        $valorDescontoFolhaVT,
        $numeroCentroCusto,
        $descontoFolhaPlanoSaude,
        $valorDescontoFolhaPlanoSaude,
        $municipioFerias,
        $razaoSocial,
        $usuario,
        $limiteEntrada,
        $limiteSaida,
        $imprimeCargo,
        $fornecedorObrigatorio,
        $xmlJsonResponsavel,
        $fornecedorVAVR";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}


function recuperaNomeLogin()
{
    if ((empty($_POST["responsavelLogin"])) || (!isset($_POST["responsavelLogin"])) || (is_null($_POST["responsavelLogin"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $responsavelLogin = (int) $_POST["responsavelLogin"];
    }

    $sql = "SELECT U.codigo AS 'codigoFuncionario', U.login ,F.nome AS 'nome' FROM Ntl.usuario U 
    INNER JOIN Ntl.funcionario F ON U.funcionario = F.codigo WHERE U.ativo = 1 AND F.ativo = 1 AND U.codigo = " . $responsavelLogin;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
       
            $codigo = (int) $row['codigoFuncionario'];
            $nomeLogin2 = $row['nome'];
        
      
        
        $out =
            $codigo . "^" .
            $nomeLogin2;

        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out;
        return;
    }
}


function recuperaProjeto()
{
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT P.codigo,P.ativo,P.cnpj,P.descricao,P.apelido,P.seguroVida,P.cep,P.numeroEndereco,P.complemento,P.bairro,P.cidade,P.estado,P.usuarioCadastro,
                    P.dataCadastro,P.usuarioAlteracao,P.dataAlteracao,P.dataAssinatura,P.dataRenovacao,P.endereco,P.diaUtilJaneiroVT,P.diaUtilFevereiroVT,
                    P.diaUtilMarcoVT,P.diaUtilAbrilVT,P.diaUtilMaioVT,P.diaUtilJunhoVT,P.diaUtilJulhoVT,P.diaUtilAgostoVT,P.diaUtilSetembroVT,P.diaUtilOutubroVT,
                    P.diaUtilNovembroVT,P.diaUtilDezembroVT,P.descontoVT,P.descontoFeriasVT,P.valorDiarioVT,P.valorMensalVT,P.descontoFolhaVT,P.valorDescontoFolhaVT,
                    P.numeroCentroCusto,P.descontoFolhaPlanoSaude,P.valorDescontoFolhaPlanoSaude,P.diaUtilJaneiroVAVR,P.diaUtilFevereiroVAVR,P.diaUtilMarcoVAVR,P.diaUtilAbrilVAVR,
                    P.diaUtilMaioVAVR,P.diaUtilJunhoVAVR,P.diaUtilJulhoVAVR,P.diaUtilAgostoVAVR,P.diaUtilSetembroVAVR,P.diaUtilOutubroVAVR,P.diaUtilNovembroVAVR,
                    P.diaUtilDezembroVAVR,P.descontoVAVR,P.descontoFeriasVAVR,P.valorDiarioVAVR,P.valorMensalVAVR,P.descontoFolhaVAVR,P.valorDescontoFolhaVAVR,
                    P.municipioFerias,P.razaoSocial,P.contratoSYSGEF,P.limiteEntrada,P.limiteSaida,P.imprimeCargo,P.fornecedorObrigatorio,P.fornecedorVAVR,
                    F.apelido AS apelidoFornecedor
                    FROM Ntl.projeto AS P 
                    LEFT JOIN Ntl.fornecedor AS F on F.codigo = P.fornecedorVAVR
                    WHERE P.codigo = " . $id;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {

        $id = +$row['codigo'];
        $cnpj = $row['cnpj'];
        $descricao = $row['descricao'];
        $apelido = $row['apelido'];
        $dataAssinatura = $row['dataAssinatura'];;
        $dataAssinatura = validaDataInversa($dataAssinatura);
        $dataRenovacao = $row['dataRenovacao'];
        $dataRenovacao = validaDataInversa($dataRenovacao);
        $seguroVida = +$row['seguroVida'];
        $cep = $row['cep'];
        $logradouro = $row['endereco'];
        $numeroEndereco = $row['numeroEndereco'];
        $complemento = $row['complemento'];
        $bairro = $row['bairro'];
        $cidade = $row['cidade'];
        $estado = $row['estado'];
        $ativo = +$row['ativo'];
        $fornecedorObrigatorio = +$row['fornecedorObrigatorio'];



        //VA
        $diaUtilJaneiroVAVR = +$row['diaUtilJaneiroVAVR'];
        $diaUtilFevereiroVAVR = +$row['diaUtilFevereiroVAVR'];
        $diaUtilMarcoVAVR = +$row['diaUtilMarcoVAVR'];
        $diaUtilAbrilVAVR = +$row['diaUtilAbrilVAVR'];
        $diaUtilMaioVAVR = +$row['diaUtilMaioVAVR'];
        $diaUtilJunhoVAVR = +$row['diaUtilJunhoVAVR'];
        $diaUtilJulhoVAVR = +$row['diaUtilJulhoVAVR'];
        $diaUtilAgostoVAVR = +$row['diaUtilAgostoVAVR'];
        $diaUtilSetembroVAVR = +$row['diaUtilSetembroVAVR'];
        $diaUtilOutubroVAVR = +$row['diaUtilOutubroVAVR'];
        $diaUtilNovembroVAVR = +$row['diaUtilNovembroVAVR'];
        $diaUtilDezembroVAVR = +$row['diaUtilDezembroVAVR'];

        $descontoVAVR = +$row['descontoVAVR'];
        $descontoFeriasVAVR = +$row['descontoFeriasVAVR'];

        $valorDiarioVAVR = $row['valorDiarioVAVR'];
        $valorDiarioVAVR = validaValorRecupera($valorDiarioVAVR);

        $valorMensalVAVR = $row['valorMensalVAVR'];
        $valorMensalVAVR = validaValorRecupera($valorMensalVAVR);

        $descontoFolhaVAVR = $row['descontoFolhaVAVR'];
        $descontoFolhaVAVR = validaValorRecupera($descontoFolhaVAVR);

        $valorDescontoFolhaVAVR = $row['valorDescontoFolhaVAVR'];
        $valorDescontoFolhaVAVR = validaValorRecupera($valorDescontoFolhaVAVR);

        //VT
        $diaUtilJaneiroVT = +$row['diaUtilJaneiroVT'];
        $diaUtilFevereiroVT = +$row['diaUtilFevereiroVT'];
        $diaUtilMarcoVT = +$row['diaUtilMarcoVT'];
        $diaUtilAbrilVT = +$row['diaUtilAbrilVT'];
        $diaUtilMaioVT = +$row['diaUtilMaioVT'];
        $diaUtilJunhoVT = +$row['diaUtilJunhoVT'];
        $diaUtilJulhoVT = +$row['diaUtilJulhoVT'];
        $diaUtilAgostoVT = +$row['diaUtilAgostoVT'];
        $diaUtilSetembroVT = +$row['diaUtilSetembroVT'];
        $diaUtilOutubroVT = +$row['diaUtilOutubroVT'];
        $diaUtilNovembroVT = +$row['diaUtilNovembroVT'];
        $diaUtilDezembroVT = +$row['diaUtilDezembroVT'];

        $descontoVT = +$row['descontoVT'];
        $descontoFeriasVT = +$row['descontoFeriasVT'];

        $valorDiarioVT = $row['valorDiarioVT'];
        $valorDiarioVT = validaValorRecupera($valorDiarioVT);

        $valorMensalVT = $row['valorMensalVT'];
        $valorMensalVT = validaValorRecupera($valorMensalVT);

        $descontoFolhaVT = $row['descontoFolhaVT'];
        $descontoFolhaVT = validaValorRecupera($descontoFolhaVT);

        $valorDescontoFolhaVT = $row['valorDescontoFolhaVT'];
        $valorDescontoFolhaVT = validaValorRecupera($valorDescontoFolhaVT);
        //VTFIM 
        $numeroCentroCusto = $row['numeroCentroCusto'];
        $descontoFolhaPlanoSaude = $row['descontoFolhaPlanoSaude'];
        $descontoFolhaPlanoSaude = validaValorRecupera($descontoFolhaPlanoSaude);
        $valorDescontoFolhaPlanoSaude = $row['valorDescontoFolhaPlanoSaude'];
        $valorDescontoFolhaPlanoSaude = validaValorRecupera($valorDescontoFolhaPlanoSaude);
        $municipioFerias = +$row['municipioFerias'];
        $razaoSocial = $row['razaoSocial'];
        $limiteEntrada = (string)$row['limiteEntrada'];
        $limiteSaida = (string)$row['limiteSaida'];
        $imprimeCargo = (int)$row['imprimeCargo'];
        $apelidoFornecedorId = $row['fornecedorVAVR'];
        $apelidoFornecedor = $row['apelidoFornecedor'];

        $out = $id . "^" .
            $cnpj . "^" .
            $descricao . "^" .
            $apelido . "^" .
            $dataAssinatura . "^" .
            $dataRenovacao . "^" .
            $seguroVida . "^" .
            $cep . "^" .
            $logradouro . "^" .
            $numeroEndereco . "^" .
            $complemento . "^" .
            $bairro . "^" .
            $cidade . "^" .
            $estado . "^" .
            $ativo . "^" .
            $diaUtilJaneiroVAVR . "^" .
            $diaUtilFevereiroVAVR . "^" .
            $diaUtilMarcoVAVR . "^" .
            $diaUtilAbrilVAVR . "^" .
            $diaUtilMaioVAVR . "^" .
            $diaUtilJunhoVAVR . "^" .
            $diaUtilJulhoVAVR . "^" .
            $diaUtilAgostoVAVR . "^" .
            $diaUtilSetembroVAVR . "^" .
            $diaUtilOutubroVAVR . "^" .
            $diaUtilNovembroVAVR . "^" .
            $diaUtilDezembroVAVR . "^" .
            $descontoVAVR . "^" .
            $descontoFeriasVAVR . "^" .
            $valorDiarioVAVR . "^" .
            $valorMensalVAVR . "^" .
            $descontoFolhaVAVR . "^" .
            $valorDescontoFolhaVAVR . "^" .
            $diaUtilJaneiroVT . "^" .
            $diaUtilFevereiroVT . "^" .
            $diaUtilMarcoVT . "^" .
            $diaUtilAbrilVT . "^" .
            $diaUtilMaioVT . "^" .
            $diaUtilJunhoVT . "^" .
            $diaUtilJulhoVT . "^" .
            $diaUtilAgostoVT . "^" .
            $diaUtilSetembroVT . "^" .
            $diaUtilOutubroVT . "^" .
            $diaUtilNovembroVT . "^" .
            $diaUtilDezembroVT . "^" .
            $descontoVT . "^" .
            $descontoFeriasVT . "^" .
            $valorDiarioVT . "^" .
            $valorMensalVT . "^" .
            $descontoFolhaVT . "^" .
            $valorDescontoFolhaVT . "^" .
            $numeroCentroCusto . "^" .
            $descontoFolhaPlanoSaude . "^" .
            $valorDescontoFolhaPlanoSaude . "^" .
            $municipioFerias . "^" .
            $razaoSocial . "^" .
            $limiteEntrada . "^" .
            $limiteSaida . "^" .
            $imprimeCargo . "^" .
            $fornecedorObrigatorio . "^" .
            $apelidoFornecedorId . "^" .
            $apelidoFornecedor;

        //----------------------Montando o array do Telefone
        $sql = "SELECT * FROM Ntl.projeto SI 
                INNER JOIN Ntl.projetoTelefone ST ON SI.codigo = ST.projeto 
                WHERE SI.codigo = " . $id;
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
        $sql = "SELECT * FROM Ntl.projeto SI 
                INNER JOIN Ntl.projetoEmail SE ON SI.codigo = SE.projeto 
                WHERE SI.codigo = " . $id;
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

        //----------------------Montando o array do FOLGA
        $sql = "SELECT * FROM Ntl.projeto SI 
                INNER JOIN Ntl.projetoFolga ST ON SI.codigo = ST.projeto 
                WHERE SI.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorFolga = 0;
        $arrayFolga = array();
        foreach ($result as $row) {

            $folgaId = $row['codigo'];
            $descricaoFolga = $row['descricaoFolga'];
            $dataInicioFolga = $row['dataInicioFolga'];
            $dataInicioFolga = validaDataInversa($dataInicioFolga);
            $dataFimFolga = $row['dataFimFolga'];
            $dataFimFolga = validaDataInversa($dataFimFolga);
            $descontaVA = +$row['descontaVA'];
            $descontaVR = +$row['descontaVR'];
            $descontaVT = +$row['descontaVT'];

            if ($descontaVA === 1) {
                $descricaoDescontaVA = "Sim";
            } else {
                $descricaoDescontaVA = "Não";
            }

            if ($descontaVR === 1) {
                $descricaoDescontaVR = "Sim";
            } else {
                $descricaoDescontaVR = "Não";
            }

            if ($descontaVT === 1) {
                $descricaoDescontaVT = "Sim";
            } else {
                $descricaoDescontaVT = "Não";
            }

            $contadorFolga = $contadorFolga + 1;
            $arrayFolga[] = array(
                "sequencialFolga" => $contadorFolga,
                "folgaId" => $folgaId,
                "descricaoFolga" => $descricaoFolga,
                "dataInicioFolga" => $dataInicioFolga,
                "dataFimFolga" => $dataFimFolga,
                "descricaoDescontaVA" => $descricaoDescontaVA,
                "descricaoDescontaVR" => $descricaoDescontaVR,
                "descricaoDescontaVT" => $descricaoDescontaVT,
                "descontaVA" => $descontaVA,
                "descontaVR" => $descontaVR,
                "descontaVT" => $descontaVT,
            );
        }
        $strArrayFolga = json_encode($arrayFolga);

        //----------------------Montando o array do Responsavel
        $sql = "SELECT  R.codigo,R.projeto,R.responsavelLogin,U.login,F.nome AS 'nome'
                 FROM Ntl.projeto P 
                INNER JOIN Ntl.projetoResponsavel R ON P.codigo = R.projeto 
                LEFT JOIN Ntl.usuario U ON U.codigo = R.responsavelLogin
                INNER JOIN Ntl.Funcionario F ON U.funcionario = F.codigo
                WHERE P.codigo = " . $id;
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contadorResponsavel = 0;
        $arrayResponsavel = array();
        foreach ($result as $row) {

            $responsavelId = $row['codigo'];
            $responsavelLogin = $row['responsavelLogin'];
            $login = $row['login'];
            $nomeLogin = $row['nome'];

            $contadorResponsavel = $contadorResponsavel + 1;
            $arrayResponsavel[] = array(
                "sequencialResponsavel" => $contadorResponsavel,
                "responsavelId" => $responsavelId,
                "responsavelLogin" => $responsavelLogin,
                "responsavelLoginDescricao" => $login,
                "nomeLogin" => $nomeLogin
            );
        }
        $strArrayResponsavel = json_encode($arrayResponsavel);


        if ($out == "") {
            echo "failed#";
            return;
        } else {
            echo "sucess#" . $out . "#" . $strArrayTelefone . "#" . $strArrayEmail . "#" . $strArrayFolga . '#' . $strArrayResponsavel;
            return;
        }
    }
}


function excluirProjeto()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("PROJETO_ACESSAR|PROJETO_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um projeto.";
        echo "failed#" . $mensagem . ' ';
        return;
    }


    $reposit = new reposit();
    $result = $reposit->update('Ntl.projeto' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function listaProjetoAtivoAutoComplete()
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
    $sql = "SELECT * FROM Ntl.projeto WHERE (0=0) AND ativo = 1 AND descricao LIKE '%" . $descricaoPesquisa . "%'COLLATE Latin1_general_CI_AI ORDER BY descricao";
    $result = $reposit->RunQuery($sql);
    $contador = 0;
    $array = array();
    foreach ($result as $row) {
        $id = $row['codigo'];
        $descricao = $row["descricao"];
        $contador = $contador + 1;
        $array[] = array("id" => $id, "descricao" => $descricao);
    }

    $strArray = json_encode($array);

    echo $strArray;

    return;
}

function validaNumero($value)
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

function validaString($value)
{
    if ($value == '')
        return 'null';
    return '\'' . $value . '\'';
}

function validaData($value)
{
    $value = explode("/", $value);
    $value = $value[2] . "/" . $value[1] . "/" . $value[0] . " 00:00:00.000";
    $value = "'" . $value . "'";
    return $value;
}

function validaDataXML($value)
{
    $value = explode("/", $value);
    $value = $value[2] . "/" . $value[1] . "/" . $value[0] . " 00:00:00.000";

    return $value;
}

function validaDataInversa($campo)
{
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}


function validaValorRecupera($valor)
{
    $valor = str_replace('.', ',', $valor);
    return $valor;
}
