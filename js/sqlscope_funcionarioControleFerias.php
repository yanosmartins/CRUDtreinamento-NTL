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

if ($funcao == 'pesquisaData') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosFuncionario') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosFuncionarioASO') {
    call_user_func($funcao);
}


return;


function grava()
{
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";
    $ativo = (int)$_POST['ativo'];

    $id = (int)$_POST['id'];
    $funcionario = (int)$_POST['funcionario'];
    $projeto = (int)$_POST['projeto'];

    if ($projeto == $funcionario) {
        $reposit = new reposit();
        $sql = "SELECT BP.codigo, BP.funcionario,F.cargo, BP.projeto,F.matricula, F.dataAdmissaoFuncionario
                from Ntl.beneficioProjeto BP
                inner join Ntl.funcionario F ON F.codigo = BP.funcionario
                where BP.ativo = 1  AND BP.funcionario = " . $funcionario;
        $result = $reposit->RunQuery($sql);
        foreach ($result as $row) {
            $funcionario = (int) $row['funcionario'];
            $cargo = (int) $row['cargo'];
            $projeto =(int) $row['projeto'];
            $matricula = (int)$row['matricula'];
            $dataAdmissao = "'".$row['dataAdmissaoFuncionario']."'";
        }
    }

   


    //Inicio do Json ControleFerias
    $strArrayControleFerias = $_POST['jsonControleFeriasArray'];
    $arrayControleFerias = $strArrayControleFerias;
    if (!is_null($strArrayControleFerias)) {
        $xmlControleFerias = "";
        $nomeXml = "ArrayOfControleFerias";
        $nomeTabela = "controleFeriasSolicitacao";
        if (sizeof($arrayControleFerias) > 0) {
            $xmlControleFerias = '<?xml version="1.0"?>';
            $xmlControleFerias = $xmlControleFerias . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';

            foreach ($arrayControleFerias as $chave) {
                $xmlControleFerias = $xmlControleFerias . "<" . $nomeTabela . ">";
                foreach ($chave as $campo => $valor) {
                    if (($campo === "sequencialControleFerias")) {
                        continue;
                    }
                    if ($campo == "solicitacaoInicioFerias" || $campo == "solicitacaoFimFerias" || $campo == "periodoAquisitivoInicio" || $campo == "periodoAquisitivoFim" || $campo == "periodoFeriasInicio" || $campo == "periodoFeriasFim") {
                        if ($valor != "") {
                            $aux = explode('/', $valor);
                            $data = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
                            $data = trim($data);
                            $valor = $data;
                        } else {
                            $valor = '';
                        }
                    }

                    $xmlControleFerias = $xmlControleFerias . "<" . $campo . ">" . $valor . "</" . $campo . ">";
                }
                $xmlControleFerias = $xmlControleFerias . "</" . $nomeTabela . ">";
            }
            $xmlControleFerias = $xmlControleFerias . "</" . $nomeXml . ">";
        } else {
            $xmlControleFerias = '<?xml version="1.0"?>';
            $xmlControleFerias = $xmlControleFerias . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
            $xmlControleFerias = $xmlControleFerias . "</" . $nomeXml . ">";
        }

        $xml = simplexml_load_string($xmlControleFerias);

        if ($xml === false) {
            $mensagem = "Erro na criação do XML de Data ASO";
            echo "failed#" . $mensagem . ' ';
            return;
        }
        $xmlControleFerias = "'" . $xmlControleFerias . "'";
    } else {

        $xmlControleFerias = "'" . '<?xml version="1.0"?>' . '<' . "ArrayOfControleFerias" . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">' . "</ArrayOfControleFerias>" . "'";
    }


    //Fim do Json  ControleFerias
    $sql = "Funcionario.controleFerias_Atualiza          
                $id,
                $funcionario,
                $matricula,
                $cargo,
                $projeto,
                $dataAdmissao,			
                $ativo,
                $usuario,
                $xmlControleFerias          
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
        $id = (int)$_POST["id"];
    }

    $sql = "SELECT CF.codigo, CF.funcionario, F.nome as funcionarioNome, CF.matricula, CF.cargo, C.descricao as cargoNome, CF.projeto, P.descricao as projetoNome, CF.dataAdmissao, CF.ativo
    FROM funcionario.controleFerias CF
       INNER JOIN ntl.funcionario F ON F.codigo = CF.funcionario
       INNER JOIN ntl.cargo C ON C.codigo = CF.cargo
       INNER JOIN ntl.projeto P ON P.codigo = CF.projeto
    WHERE CF.codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int) $row['codigo'];
        $funcionario = $row['funcionario'];
        $matricula = $funcionario;
        $cargo = $funcionario;
        $projeto = $funcionario;
        $dataAdmissao = $funcionario;
        $ativo = $row['ativo'];


        // XML CONTROLE FERIAS
        $reposit = "";
        $result = "";
        $sql = "SELECT FS.periodoAquisitivoInicio, FS.periodoAquisitivoFim, FS.periodoFeriasInicio, FS.periodoFeriasFim, FS.diasSolicitacao, FS.adiantamentoDecimo, FS.abono, FS.status, FS.solicitacaoInicioFerias, FS.solicitacaoFimFerias
     FROM Funcionario.controleFeriasSolicitacao FS
    INNER JOIN  Funcionario.controleFerias CF ON FS.controleFeriasSolicitacao = CF.codigo
    WHERE CF.codigo = $id";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);

        $contadorControleFerias = 0;
        $arrayControleFerias = array();
        foreach ($result as $row) {
            $periodoAquisitivoInicio = $row['periodoAquisitivoInicio'];
            if ($row['periodoAquisitivoInicio'] != "") {
                $aux = explode(' ', $row['periodoAquisitivoInicio']);
                $data = $aux[1] . ' ' . $aux[0];
                $data = $aux[0];
                $data =  trim($data);
                $aux = explode('-', $data);
                $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $data =  trim($data);
                $periodoAquisitivoInicio = $data;
            } else {
                $periodoAquisitivoInicio = '';
            };

            $periodoAquisitivoFim = $row['periodoAquisitivoFim'];
            if ($row['periodoAquisitivoFim'] != "") {
                $aux = explode(' ', $row['periodoAquisitivoFim']);
                $data = $aux[1] . ' ' . $aux[0];
                $data = $aux[0];
                $data =  trim($data);
                $aux = explode('-', $data);
                $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $data =  trim($data);
                $periodoAquisitivoFim = $data;
            } else {
                $periodoAquisitivoFim = '';
            };

            $periodoFeriasInicio = $row['periodoFeriasInicio'];
            if ($periodoFeriasInicio) {
                $aux = explode(' ', $periodoFeriasInicio);
                $data = $aux[1] . ' ' . $aux[0];
                $data = $aux[0];
                $data =  trim($data);
                $aux = explode('-', $data);
                $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $data =  trim($data);
                $periodoFeriasInicio = $data;
            } else {
                $periodoFeriasInicio = '';
            };

            $periodoFeriasFim = $row['periodoFeriasFim'];
            if ($periodoFeriasFim) {
                $aux = explode(' ', $periodoFeriasFim);
                $data = $aux[1] . ' ' . $aux[0];
                $data = $aux[0];
                $data =  trim($data);
                $aux = explode('-', $data);
                $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $data =  trim($data);
                $periodoFeriasFim = $data;
            } else {
                $periodoFeriasFim = '';
            };

            $solicitacaoInicioFerias = $row['solicitacaoInicioFerias'];
            if ($row['solicitacaoInicioFerias'] != "") {
                $aux = explode(' ', $row['solicitacaoInicioFerias']);
                $data = $aux[1] . ' ' . $aux[0];
                $data = $aux[0];
                $data =  trim($data);
                $aux = explode('-', $data);
                $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $data =  trim($data);
                $solicitacaoInicioFerias = $data;
            } else {
                $solicitacaoInicioFerias = '';
            };

            $solicitacaoFimFerias = $row['solicitacaoFimFerias'];
            if ($row['solicitacaoFimFerias'] != "") {
                $aux = explode(' ', $row['solicitacaoFimFerias']);
                $data = $aux[1] . ' ' . $aux[0];
                $data = $aux[0];
                $data =  trim($data);
                $aux = explode('-', $data);
                $data = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $data =  trim($data);
                $solicitacaoFimFerias = $data;
            } else {
                $solicitacaoFimFerias = '';
            };

            $diasSolicitacao = $row['diasSolicitacao'];
            $adiantamentoDecimo = $row['adiantamentoDecimo'];
            $abono = (int)$row['abono'];
            $status = (int)$row['status'];



            $contadorControleFerias = $contadorControleFerias + 1;
            $arrayControleFerias[] = array(
                "sequencialControleFerias" => $contadorControleFerias,
                "periodoAquisitivoInicio" => $periodoAquisitivoInicio,
                "periodoAquisitivoFim" => $periodoAquisitivoFim,
                "periodoFeriasInicio" => $periodoFeriasInicio,
                "periodoFeriasFim" => $periodoFeriasFim,
                "diasSolicitacao" => $diasSolicitacao,
                "adiantamentoDecimo" => $adiantamentoDecimo,
                "abono" => $abono,
                "status" => $status,
                "solicitacaoInicioFerias" => $solicitacaoInicioFerias,
                "solicitacaoFimFerias" => $solicitacaoFimFerias
            );
        }



        $strArrayControleFerias = json_encode($arrayControleFerias);



        $out = $codigo . "^" .
            $funcionario . "^" .
            $matricula . "^" .
            $cargo . "^" .
            $projeto . "^" .
            $dataAdmissao . "^" .
            $ativo;

        if ($out == "") {
            echo "failed#";
            return;
        }

        echo "sucess#" . $out . "#" . $strArrayControleFerias;
        return;
    }
}

function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("CONTROLEFERIAS_ACESSAR|CONTROLEFERIAS_EXCLUIR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $result = $reposit->update('Funcionario.controleFerias' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
};
