<?php
include "js/repositorio.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-center" style="min-width:30px;" hidden></th>
                    <th class="text-center" style="min-width:30px;">Portal</th>
                    <th class="text-center" style="min-width:200px;">Nome do Orgão Licitante</th>
                    <th class="text-center" style="min-width:50px;">Número do Pregao</th>
                    <th class="text-center" style="min-width:50px;">Oportunidade de Compra</th>
                    <th class="text-center" style="min-width:50px;">Situação</th>
                    <th class="text-center" style="min-width:50px;">Condição</th>
                    <th class="text-center" style="min-width:30px;">Posição</th>
                    <th class="text-center" style="min-width:30px;">Data Reabertura Pregao</th>
                    <th class="text-center" style="min-width:30px;">Hora Reabertura Pregao</th>
                    <th class="text-center" style="min-width:30px;">Prioridade</th>
                    <th class="text-left" style="min-width:200px; ">Resumo do Pregão</th>
                    <th class="text-left" style="min-width:100px;">Grupo</th>
                    <th class="text-left" style="min-width:110px;">Responsável</th>
                    <th class="text-center" style="min-width:30px;">Quem Atualizou</th>
                    <th class="text-center" style="min-width:30px;">Data</th>
                    <th class="text-center" style="min-width:30px;">Hora</th>
                    <th class="text-center" style="min-width:30px;">Data de lançamento</th>

                </tr>
            </thead>
            <tbody>
                <?php

                $hoje = "'" . date("Y-m-d") . "'";

                $sql = "SELECT GP.codigo, P.descricao, P.endereco, GP.orgaoLicitante, GP.numeroPregao, GP.oportunidadeCompra, S.codigo as codigoSituacao, S.corFundo, S.corFonte, S.descricao as situacao, GP.posicao, GP.dataReabertura, 
                    GP.horaReabertura, GP.prioridade, GP.ativo, GP.dataAlerta, GP.horaAlerta,GP.resumoPregao, GP.usuarioAlteracao, GP.dataAlteracao, GP.dataCadastro,
                    G.descricao AS grupoResponsavel, R.nome AS responsavelPregao
                    FROM ntl.pregao GP
                    LEFT JOIN ntl.portal P ON P.codigo = GP.portal
                    LEFT JOIN ntl.situacao S ON S.codigo = GP.situacao
                    INNER JOIN ntl.grupo G ON G.codigo = GP.grupoResponsavel
                    INNER JOIN ntl.responsavel R ON R.codigo = GP.responsavel";
                $where = " WHERE (0 = 0) AND GP.participaPregao = 1 AND GP.condicao = 2 AND GP.dataReabertura <= " . $hoje;

                if ($_POST["numeroPregao"] != "") {
                    $numeroPregao = $_POST["numeroPregao"];
                    $where = $where . " AND ( GP.numeroPregao like '%' + " . "replace('" . $numeroPregao . "',' ','%') + " . "'%')";
                }

                if ($_POST["ativo"] != "") {
                    $ativo = +$_POST["ativo"];
                    $where = $where . " AND GP.ativo = " . $ativo;
                }

                if ($_POST["portal"] != "") {
                    $portal = +$_POST["portal"];
                    $where = $where . " AND P.codigo = $portal ";
                }

                if ($_POST["orgaoLicitante"] != "") {
                    $orgaoLicitante = $_POST["orgaoLicitante"];
                    $where = $where . " AND ( GP.orgaoLicitante like '%' + " . "replace('" . $orgaoLicitante . "',' ','%') + " . "'%')";
                }

                if ($_POST['dataReabertura'] != "") {
                    $dataReabertura = date_create_from_format('!j/m/Y', $_POST["dataReabertura"]); //! faz com que não precise de um timestamp junto com o formato da data. 
                    $dataReabertura = date_format($dataReabertura, "Y-m-d");
                    $where = $where . " AND GP.dataReabertura <= '$dataReabertura'";
                }

                if ($_POST['horaPregao'] != "") {
                    $dataReabertura = $_POST["horaPregao"];
                    $where = $where . " AND GP.horaReabertura <= '$dataReabertura'";
                }

                if ($_POST['condicao'] != "") {
                    $condicao = (int)$_POST["condicao"];
                    $where = $where . " AND GP.condicao = $condicao";
                }

                if ($_POST["situacao"] != "") {
                    $situacao = +$_POST["situacao"];
                    $where = $where . " AND S.codigo = " . $situacao;
                }
                if ($_POST["quemLancouAtualizacao"] != "") {
                    $quemLancouAtualizacao = $_POST["quemLancouAtualizacao"];
                    $where = $where . " AND ( GP.usuarioAlteracao like '%' + " . "replace('" . $usuarioAlteracao . "',' ','%') + " . "'%')";
                }

                if ($_POST["resumoPregao"] != "") {
                    $resumoPregao = $_POST["resumoPregao"];
                    $where = $where . " AND ( GP.resumoPregao like '%' + " . "replace('" . $resumoPregao . "',' ','%') + " . "'%')";
                }

                if (($_POST["dataInicioPeriodo"] != "") &&  ($_POST["dataFimPeriodo"] != "")) {
                    $dataInicioPeriodo = date_create_from_format('!j/m/Y', $_POST["dataInicioPeriodo"]); //! faz com que não precise de um timestamp junto com o formato da data.  
                    $dataFimPeriodo = date_create_from_format('!j/m/Y', $_POST["dataFimPeriodo"]);
                    $dataInicioPeriodo = date_format($dataInicioPeriodo, "Y-m-d");
                    $dataFimPeriodo = date_format($dataFimPeriodo, "Y-m-d");
                    $where = $where . " AND GP.dataReabertura between '$dataInicioPeriodo' and '$dataFimPeriodo' ";
                }

                if ($_POST["grupo"] != "") {
                    $grupo = +$_POST["grupo"];
                    $where = $where . " AND G.codigo = " . $grupo;
                }

                if ($_POST["responsavelPregao"] != "") {
                    $responsavelPregao = +$_POST["responsavelPregao"];
                    $where = $where . " AND R.codigo = " . $responsavelPregao;
                }

                $where = $where . " ORDER by GP.prioridade DESC, GP.posicao, GP.dataReabertura ASC";

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {

                    //testando a hora do alerta
                    $dataAlerta = $row['dataAlerta'];
                    $hojeAlerta =  date("Y-m-d");
                    $horaAlerta = strtotime($row['horaAlerta']);
                    $hora = strtotime(date("h:i", time()));

                    $id = $row['codigo'];
                    $portal = $row['descricao'];
                    $orgaoLicitante = $row['orgaoLicitante'];
                    $numeroPregao = $row['numeroPregao'];

                    //A data recuperada foi formatada para D/M/Y
                    $dataReabertura = $row['dataReabertura'];
                    if ($dataReabertura != "") {
                        $dataReabertura = explode("-", $dataReabertura);
                        $dataReabertura = $dataReabertura[2] . "/" . $dataReabertura[1] . "/" . $dataReabertura[0];
                    }

                    //Arrumando a data e a hora em que foi ATUALIZADO no sistema.
                    $dataAlteracao = $row['dataAlteracao'];
                    $descricaoData = explode(" ", $dataAlteracao);
                    $descricaoData = explode("-", $descricaoData[0]);
                    $descricaoHora = explode(" ", $dataAlteracao);
                    $descricaoHora = $descricaoHora[1];
                    $descricaoHora = explode(":", $descricaoHora);
                    $descricaoHora = $descricaoHora[0] . ":" . $descricaoHora[1];
                    $descricaoData =  $descricaoData[2] . "/" . $descricaoData[1] . "/" . $descricaoData[0];

                    $id = $row['codigo'];
                    $portal = $row['descricao'];
                    $enderecoPortal = $row['endereco'];
                    $orgaoLicitante = $row['orgaoLicitante'];
                    $usuarioAlteracao = $row['usuarioAlteracao'];
                    $numeroPregao = $row['numeroPregao'];
                    $horaReabertura = $row['horaReabertura'];
                    $oportunidadeCompra = $row['oportunidadeCompra'];
                    $ativo = $row['ativo'];
                    $ativo == 1 ? $descricaoAtivo = 'Sim' : $descricaoAtivo = 'Não';
                    $situacao = $row['situacao'];
                    $posicao = $row['posicao'];
                    $campoPrioridade = '';
                    $prioridade = $row['prioridade'];
                    $resumoPregao = $row['resumoPregao'];
                    $dataLancamento = $row['dataCadastro'];
                    $dataLancamento = explode(" ", $dataLancamento);
                    $dataLancamento = $dataLancamento[0];
                    $dataLancamento = explode("-", $dataLancamento);
                    $dataLancamento = "$dataLancamento[2]/$dataLancamento[1]/$dataLancamento[0]";
                    $corFundo = '';
                    $corFonte = '';
                    $corLink = '';

                    $grupo = $row['grupoResponsavel'];
                    $responsavelPregao = $row['responsavelPregao'];

                    $condicao = (int)$row['condicao'];


                    switch ($condicao) {
                        case 1:
                            $condicao = 'Adiado';
                            break;
                        case 2:
                            $condicao = 'Em Andamento';
                            break;
                        case 3:
                            $condicao = 'Cancelado';
                            break;
                        case 4:
                            $condicao = 'Fracassado';
                            break;
                        case 5:
                            $condicao = 'Desistência';
                            break;
                        case 6:
                            $condicao = 'Concluído';
                            break;
                        default:
                            $condicao = '';
                    }

                    $corFundo = "#bf2724";


                    echo '<tr style="background:' . $corFundo . '; color:' . $corFonte . ';">';
                    echo '<td class="text-center" hidden></td>';
                    if ($prioridade == "1") {
                        echo '<td class="text-left"><a style="color:' . $corLink . ';" target="_blank" rel="noopener noreferrer" href="' . $enderecoPortal . '"><strong>' . $portal . '</strong></a></td>';
                    } else {
                        echo '<td class="text-left"><a style="color:' . $corLink . ';" target="_blank" rel="noopener noreferrer" href="' . $enderecoPortal . '">' . $portal . '</a></td>';
                    }
                    echo '<td class="text-justify">' . $orgaoLicitante . '</td>';
                    if ($prioridade == "1") {
                        echo '<td class="text-center"><a style="color:' . $corLink . ';" href="licitacao_pregaoEmAndamentoCadastro.php?id=' . $id . '"><strong>' . $numeroPregao . '</strong></a></td>';
                    } else {
                        echo '<td class="text-center"><a style="color:' . $corLink . ';" href="licitacao_pregaoEmAndamentoCadastro.php?id=' . $id . '">' . $numeroPregao . '</a></td>';
                    }
                    echo '<td class="text-center">' . $oportunidadeCompra . '</td>';
                    echo '<td class="text-center">' . $situacao . '</td>';
                    echo '<td class="text-center">' . $condicao . '</td>';
                    echo '<td class="text-center">' . $posicao . '</td>';
                    echo '<td class="text-center">' . $dataReabertura . '</td>';
                    echo '<td class="text-center">' . $horaReabertura . '</td>';
                    echo '<td class="text-center">' . $campoPrioridade . '</td>';
                    echo '<td class="text-justify">' . $resumoPregao . '</td>';
                    echo '<td class="text-justify">' . $grupo . '</td>';
                    echo '<td class="text-justify">' . $responsavelPregao . '</td>';
                    echo '<td class="text-justify">' . $usuarioAlteracao . '</td>';
                    echo '<td class="text-left">' . $descricaoData . '</td>';
                    echo '<td class="text-left">' . $descricaoHora . '</td>';
                    echo '<td class="text-left">' . $dataLancamento . '</td>';
                }


                $where = "";
                $reposit = "";
                $result = "";

                $sql = " SELECT GP.codigo, P.descricao, P.endereco, GP.orgaoLicitante, GP.numeroPregao, GP.oportunidadeCompra, GP.condicao, S.codigo as codigoSituacao,  S.corFundo, S.corFonte, S.descricao as situacao, GP.posicao, GP.dataReabertura, 
                GP.horaReabertura, GP.prioridade, GP.ativo, GP.dataAlerta, GP.horaAlerta,GP.resumoPregao,GP.usuarioAlteracao,GP.dataAlteracao, GP.dataCadastro,
                G.descricao AS grupoResponsavel, R.nome AS responsavelPregao
                FROM ntl.pregao GP
                LEFT JOIN ntl.portal P ON P.codigo = GP.portal
                LEFT JOIN ntl.situacao S ON S.codigo = GP.situacao
                INNER JOIN ntl.grupo G ON G.codigo = GP.grupoResponsavel
                INNER JOIN ntl.responsavel R ON R.codigo = GP.responsavel";
                $where = " WHERE (0 = 0) AND GP.participaPregao = 1 AND GP.dataReabertura IS NULL OR GP.dataReabertura > " . $hoje;

                if ($_POST["numeroPregao"] != "") {
                    $numeroPregao = $_POST["numeroPregao"];
                    $where = $where . " AND ( GP.numeroPregao like '%' + " . "replace('" . $numeroPregao . "',' ','%') + " . "'%')";
                }

                if ($_POST["ativo"] != "") {
                    $ativo = +$_POST["ativo"];
                    $where = $where . " AND GP.ativo = " . $ativo;
                }

                if ($_POST["portal"] != "") {
                    $portal = +$_POST["portal"];
                    $where = $where . " AND P.codigo = $portal ";
                }

                if ($_POST["orgaoLicitante"] != "") {
                    $orgaoLicitante = $_POST["orgaoLicitante"];
                    $where = $where . " AND ( GP.orgaoLicitante like '%' + " . "replace('" . $orgaoLicitante . "',' ','%') + " . "'%')";
                }
                if ($_POST["quemLancouAtualizacao"] != "") {
                    $quemLancouAtualizacao = $_POST["quemLancouAtualizacao"];
                    $where = $where . " AND ( GP.usuarioAlteracao like '%' + " . "replace('" . $usuarioAlteracao . "',' ','%') + " . "'%')";
                }

                if ($_POST['dataReabertura'] != "") {
                    $dataReabertura = formataDataValorSQL($_POST["dataReabertura"]);
                    $where = $where . " AND GP.dataReabertura == '$dataReabertura'";
                }

                if ($_POST['horaPregao'] != "") {
                    $dataReabertura = $_POST["horaPregao"];
                    $where = $where . " AND GP.horaReabertura <= '$dataReabertura'";
                }

                if ($_POST['condicao'] != "") {
                    $condicao = (int)$_POST["condicao"];
                    $where = $where . " AND GP.condicao = $condicao";
                }

                if ($_POST["situacao"] != "") {
                    $situacao = (int)$_POST["situacao"];
                    $where = $where . " AND S.codigo = " . $situacao;
                }

                if ($_POST["resumoPregao"] != "") {
                    $resumoPregao = $_POST["resumoPregao"];
                    $where = $where . " AND ( GP.resumoPregao like '%' + " . "replace('" . $resumoPregao . "',' ','%') + " . "'%')";
                }

                if (($_POST["dataInicioPeriodo"] != "") &&  ($_POST["dataFimPeriodo"] != "")) {
                    $dataInicioPeriodo = formataDataValorSQL($_POST["dataInicioPeriodo"]);
                    $dataFimPeriodo = formataDataValorSQL($_POST["dataFimPeriodo"]);
                    $where = $where . " AND GP.dataReabertura between '$dataInicioPeriodo' and '$dataFimPeriodo' ";
                }

                if ($_POST["grupo"] != "") {
                    $grupo = (int)$_POST["grupo"];
                    $where = $where . " AND G.codigo = " . $grupo;
                }

                if ($_POST["responsavelPregao"] != "") {
                    $responsavelPregao = (int)$_POST["responsavelPregao"];
                    $where = $where . " AND R.codigo = " . $responsavelPregao;
                }

                $where = $where . " ORDER by GP.prioridade DESC, GP.posicao, GP.dataReabertura ASC";

                $sql .= $where;
                $reposit = new reposit();
                $result = $reposit->RunQuery($sql);

                foreach ($result as $row) {

                    //testando a hora do alerta
                    $dataAlerta = $row['dataAlerta'];
                    $hojeAlerta =  date("Y-m-d");
                    if ($dataAlerta == $hojeAlerta) {
                        $horaAlerta = strtotime($row['horaAlerta']);
                        $hora = strtotime(date("h:i", time()));
                        if ($horaAlerta <= $hora) {
                            continue;
                        }
                    }
                    //A data recuperada foi formatada para D/M/Y
                    $dataReabertura = $row['dataReabertura'];
                    if ($dataReabertura != "") {
                        $dataReabertura = date_create_from_format('!Y-m-d', $dataReabertura); //! faz com que não precise de um timestamp junto com o formato da data. 
                        $dataReabertura = date_format($dataReabertura, "d/m/Y");
                    }
                    //Arrumando a data e a hora em que foi ATUALIZADO no sistema.
                    $dataAlteracao = $row['dataAlteracao'];
                    $descricaoData = explode(" ", $dataAlteracao);
                    $descricaoData = explode("-", $descricaoData[0]);
                    $descricaoHora = explode(" ", $dataAlteracao);
                    $descricaoHora = $descricaoHora[1];
                    $descricaoHora = explode(":", $descricaoHora);
                    $descricaoHora = $descricaoHora[0] . ":" . $descricaoHora[1];
                    $descricaoData =  $descricaoData[2] . "/" . $descricaoData[1] . "/" . $descricaoData[0];

                    //Variáveis
                    $id = $row['codigo'];
                    $portal = $row['descricao'];
                    $enderecoPortal = $row['endereco'];
                    $orgaoLicitante = $row['orgaoLicitante'];
                    $numeroPregao = $row['numeroPregao'];
                    $usuarioAlteracao = $row['usuarioAlteracao'];
                    $horaReabertura = $row['horaReabertura'];
                    $oportunidadeCompra = $row['oportunidadeCompra'];
                    $ativo = $row['ativo'];
                    $ativo == 1 ? $descricaoAtivo = 'Sim' : $descricaoAtivo = 'Não';
                    $situacao = $row['situacao'];
                    $posicao = $row['posicao'];
                    $campoPrioridade = '';
                    $prioridade = $row['prioridade'];
                    $resumoPregao = $row['resumoPregao'];
                    $dataLancamento = $row['dataCadastro'];
                    $dataLancamento = explode(" ", $dataLancamento);
                    $dataLancamento = explode("-", $dataLancamento[0]);
                    $dataLancamento = "$dataLancamento[2]/$dataLancamento[1]/$dataLancamento[0]";
                    $corFundo = '';
                    $corFonte = '';
                    $corLink = '';

                    $grupo = $row['grupoResponsavel'];
                    $responsavelPregao = $row['responsavelPregao'];


                    $condicao = (int)$row['condicao'];


                    switch ($condicao) {
                        case 1:
                            $condicao = 'Adiado';
                            break;
                        case 2:
                            $condicao = 'Em Andamento';
                            break;
                        case 3:
                            $condicao = 'Cancelado';
                            break;
                        case 4:
                            $condicao = 'Fracassado';
                            break;
                        case 5:
                            $condicao = 'Desistência';
                            break;
                        case 6:
                            $condicao = 'Concluído';
                            break;
                        default:
                            $condicao = '';
                    }

                    if ($prioridade == "1") {
                        $campoPrioridade = '<i class="fa fa-check-circle-o" aria-hidden="true"></i>';
                        $corFundo = "#bf2724";
                        $corFonte = "#fff5f5";
                        $corLink = "#ffffff";
                    }


                    echo '<tr style="background:' . $corFundo . '; color:' . $corFonte . ';">';
                    echo '<td class="text-center" hidden></td>';
                    if ($prioridade == "1") {
                        echo '<td class="text-left"><a style="color:' . $corLink . ';" target="_blank" rel="noopener noreferrer" href="' . $enderecoPortal . '"><strong>' . $portal . '</strong></a></td>';
                    } else {
                        echo '<td class="text-left"><a style="color:' . $corLink . ';" target="_blank" rel="noopener noreferrer" href="' . $enderecoPortal . '">' . $portal . '</a></td>';
                    }
                    echo '<td class="text-justify">' . $orgaoLicitante . '</td>';
                    if ($prioridade == "1") {
                        echo '<td class="text-center"><a style="color:' . $corLink . ';" href="licitacao_pregaoEmAndamentoCadastro.php?id=' . $id . '"><strong>' . $numeroPregao . '</strong></a></td>';
                    } else {
                        echo '<td class="text-center"><a style="color:' . $corLink . ';" href="licitacao_pregaoEmAndamentoCadastro.php?id=' . $id . '">' . $numeroPregao . '</a></td>';
                    }
                    echo '<td class="text-center">' . $oportunidadeCompra . '</td>';
                    echo '<td class="text-center">' . $situacao . '</td>';
                    echo '<td class="text-center">' . $condicao . '</td>';
                    echo '<td class="text-center">' . $posicao . '</td>';
                    echo '<td class="text-center">' . $dataReabertura . '</td>';
                    echo '<td class="text-center">' . $horaReabertura . '</td>';
                    echo '<td class="text-center">' . $campoPrioridade . '</td>';
                    echo '<td class="text-justify">' . $resumoPregao . '</td>';
                    echo '<td class="text-justify">' . $grupo . '</td>';
                    echo '<td class="text-justify">' . $responsavelPregao . '</td>';
                    echo '<td class="text-justify">' . $usuarioAlteracao . '</td>';
                    echo '<td class="text-left">' . $descricaoData . '</td>';
                    echo '<td class="text-left">' . $descricaoHora . '</td>';
                    echo '<td class="text-left">' . $dataLancamento . '</td>';
                }

                //Funções que formatam datas para um tipo específico.
                function formataDataValorSQL($data)
                {
                    // O (!) na frente faz com que não precise de um timestamp junto com a data.
                    $data = date_create_from_format('!j/m/Y', $data);
                    return date_format($data, "Y-m-d");
                }

                function formataDataValorHtml($data)
                {
                    // O (!) na frente faz com que não precise de um timestamp junto com a data.
                    $data = explode(" ", $data); //Vem com os segundos, então precisa dar um explode.
                    $data = date_create_from_format('!Y-m-j', $data[0]);
                    return date_format($data, "d/m/Y");
                }

                ?>

            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<!--script src="js/plugin/datatables/dataTables.tableTools.min.js"></script-->
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="js/plugin/Buttons-1.5.2/css/buttons.dataTables.min.css" />

<script type="text/javascript" src="js/plugin/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="js/plugin/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="js/plugin/Buttons-1.5.2/js/buttons.print.min.js"></script>


<script>
    $(document).ready(function() {
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({

            // Tabletools options:
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'B'l'C>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                //"sLengthMenu": "_MENU_ Resultados por página",
                "sLengthMenu": "_MENU_",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "buttons": [
                //{extend: 'copy', className: 'btn btn-default'},
                //{extend: 'csv', className: 'btn btn-default'},
                {
                    extend: 'excel',
                    className: 'btn btn-default'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-default'
                },
                //{extend: 'print', className: 'btn btn-default'}
            ],
            "autoWidth": true,
            "aaSorting": [],

            "preDrawCallback": function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

        /* END TABLETOOLS */
    });
</script>