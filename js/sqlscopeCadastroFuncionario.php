<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravar') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosUsuario') {
    call_user_func($funcao);
}
if ($funcao == 'VerificaCPF') {
    call_user_func($funcao);
}
if ($funcao == 'ValidaCPF') {
    call_user_func($funcao);
}
if ($funcao == 'VerificaRG') {
    call_user_func($funcao);
}


return;

function gravar()
{

    $reposit = new reposit();

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = (int) $_POST["ativo"];
    }

    $id = (int)$_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $dataNascimento = $_POST['dataNascimento'];
    $dataNascimento = implode("-", array_reverse(explode("/", $dataNascimento)));
    $rg = $_POST['rg'];
    $genero = $_POST['genero'];
    $estadoCivil= (int)$_POST['estadoCivil'];


    $sql = "dbo.Funcionario_Atualiza 
            $id, 
            $ativo,
            '$nome', 
            '$cpf',
            '$dataNascimento',
            '$rg',
            '$genero',           
            '$estadoCivil'
            ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'success#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}



function VerificaCPF(){
////////verifica registros duplicados

    $cpf = $_POST["cpf"];
    
    $sql = "SELECT cpf, codigo FROM dbo.funcionario WHERE cpf='$cpf'";
    //achou 
    // $sql = "SELECT cpf FROM dbo.funcionario WHERE (0 = 0) AND" . "' cpf ='".$cpf;
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);    
    // $result = $reposit->RunQuery($sql);
    // if ($id > 0) {
    //     $sql = "SELECT codigo FROM dbo.funcionario WHERE cpf='$cpf' and codigo =$id";
    // }
    ////! ANTES É NEGAÇÃO
    if (!$result){
        echo  'success#';
    }
    else{
        $mensagem = "CPF já registrado!";
        echo "failed#" . $mensagem .' ';    
    }
    
}



function ValidaCPF() {
 
    // Extrai somente os números
    $cpf = $_POST["cpf"];
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        echo "failed";
        return;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        echo "failed";
        return;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            echo "failed";
            return;
        }
    }
    echo "success";
    return;

}


function VerificaRG(){
    ////////verifica registros duplicados
    
        $rg = $_POST["rg"];
        
        $sql = "SELECT rg FROM dbo.funcionario WHERE rg='$rg'";
        //achou 
        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);    

        ////! ANTES É NEGAÇÃO
        if (!$result){
            echo  'success#';
        }
        else{
            $mensagem = "RG já registrado!";
            echo "failed#" . $mensagem .' ';
        }
        
    }



function excluir()
{

    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("USUARIO_ACESSAR|USUARIO_EXCLUIR");


    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start();
    $usuario = $_SESSION['login'];
    $usuario = "'" . $usuario . "'";

    $result = $reposit->update('dbo.funcionario' .'|'.'ativo = 0'.'|'.'codigo ='.$id);


    $reposit = new reposit();

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}


function recupera()
{
    

    $id = $_POST["codigo"];
    



    $sql = "SELECT codigo, nome, ativo, cpf, rg, dataNascimento, genero, estadoCivil FROM dbo.funcionario WHERE codigo = $id";
    // $sql = " SELECT FU.codigo, FU.ativo, FU.cpf, FU.rg, FU.dataNascimento, FU.estadoCivil, FU.nome, GF.descricao as genero from dbo.funcionario FU
    // LEFT JOIN dbo.generoFuncionario GF on GF.codigo = FU.genero";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if ($row = $result[0]) {

        $id = (int)$row['codigo'];
        $ativo = (int)$row['ativo'];
        $nomeCompleto = (string)$row['nome'];
        $cpf = (string)$row['cpf'];
        $rg = (string)$row['rg'];
        $estadoCivil = (int)$row['estadoCivil'];
        $genero = (int)$row['genero'];
        $dataNascimento = (string)$row['dataNascimento'];
        $dataNascimento = explode("-", $dataNascimento);
        $dataNascimento = $dataNascimento[2] . "/" . $dataNascimento[1] . "/" . $dataNascimento[0];

     

        $out =  $id . "^" .
            $ativo . "^" .
            $nomeCompleto . "^" .
            $cpf . "^" .
            $rg. "^" .
            $dataNascimento. "^" .
            $estadoCivil. "^" .
            $genero;
            
  if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out;
        }
        return;
    }
}









// function validaTorre() {
//     var achouTorre = false;
//     var limiteFuncionario = false;
//     var departamentoId = +$('#departamentoProjetoId').val();
//     var sequencial = +$('#sequencialTorre').val();
//     var funcionariosTorre = +$("#funcionarioSimultaneosTorre").val();
//     var funcionarios = +$("#funcionarioSimultaneos").val();

//     if (!funcionarios) {
//       smartAlert("Atenção", "Preencha o campo de Fun. Simultaneos por Departamento", "error");
//       return;
//     }

//     for (i = jsonTorreArray.length - 1; i >= 0; i--) {
//       if (departamentoId !== "") {
//         if ((jsonTorreArray[i].departamentoProjetoId === departamentoId) && (jsonTorreArray[i].sequencialTorre !== sequencial)) {
//           achouTorre = true;
//           break;
//         }
//       }
//     }

//     if (achouTorre === true) {
//       smartAlert("Erro", "Já existe um Departamento na lista.", "error");
//       $('#departamentoProjeto').val("");
//       return false;
//     }

//     //-------------------------------- Validação de funcionarios da torre -----------------------------------
//     //OBS:O numero de funcionarios por projeto não pode passar o numero de funcionarios simultaneos da torre

//     for (i = jsonTorreArray.length; i >= 0; i--) {
//       if (funcionariosTorre < funcionarios) {
//         limiteFuncionario = true;
//         $("#funcionarioSimultaneos").val('');
//         break;
//       }
//     }

//     if (limiteFuncionario === true) {
//       smartAlert("Atenção", `A torre tem o limite de ${funcionariosTorre} funcionarios simultaneos`, "warning");
//       return false;
//     }
//     //------------------------------------------------------------------------------------------

//     return true;
//   }
// ----------------------------------------------------------------------------------------------------------------------------------------
//   function addTorre() {
//     var item = $("#formTorre").toObject({
//       mode: 'combine',
//       skipEmpty: false
//     });

//     if (item["sequencialTorre"] === '') {
//       if (jsonTorreArray.length === 0) {
//         item["sequencialTorre"] = 1;
//       } else {
//         item["sequencialTorre"] = Math.max.apply(Math, jsonTorreArray.map(function(o) {
//           return o.sequencialTorre;
//         })) + 1;
//       }
//       item["torreId"] = 0;
//     } else {
//       item["sequencialTorre"] = +item["sequencialTorre"];
//     }

//     var index = -1;
//     $.each(jsonTorreArray, function(i, obj) {
//       if (+$('#sequencialTorre').val() === obj.sequencialTorre) {
//         index = i;
//         return false;
//       }
//     });

//     if (index >= 0)
//       jsonTorreArray.splice(index, 1, item);
//     else
//       jsonTorreArray.push(item);

//     $("#jsonTorre").val(JSON.stringify(jsonTorreArray));

//     fillTableTorre();
//     clearFormTorre();
//   }

//   function fillTableTorre() {
//     $("#tableTorre tbody").empty();
//     for (var i = 0; i < jsonTorreArray.length; i++) {
//       var row = $('<tr />');

//       $("#tableTorre tbody").append(row);
//       row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTorreArray[i].sequencialTorre + '"><i></i></label></td>'));

//       if (jsonTorreArray[i].departamentoProjeto != undefined) {
//         row.append($('<td class="text-left" >' + jsonTorreArray[i].departamentoProjeto + '</td>'));
//       } else {
//         row.append($('<td class="text-left" >' + jsonTorreArray[i].descricaoProjeto + " - " + jsonTorreArray[i].descricaoDepartamento + '</td>'));
//       }

//       row.append($('<td class="text-left" >' + jsonTorreArray[i].funcionarioSimultaneos + '</td>'));
//     }
//   }

//   function clearFormTorre() {
//     $("#torreId").val('');
//     $("#sequencialTorre").val('');
//     $("#departamentoProjeto").val('');
//     $("#funcionarioSimultaneos").val('');
//   }

//   function excluiTorreTabela() {
//     var arrSequencial = [];
//     $('#tableTorre input[type=checkbox]:checked').each(function() {
//       arrSequencial.push(parseInt($(this).val()));
//     });
//     if (arrSequencial.length > 0) {
//       for (i = jsonTorreArray.length - 1; i >= 0; i--) {
//         var obj = jsonTorreArray[i];
//         if (jQuery.inArray(obj.sequencialTorre, arrSequencial) > -1) {
//           jsonTorreArray.splice(i, 1);
//         }
//       }
//       $("#jsonTorre").val(JSON.stringify(jsonTorreArray));
//       fillTableTorre();
//     } else
//       smartAlert("Erro", "Selecione pelo menos um Projeto para excluir.", "error");
//   }
