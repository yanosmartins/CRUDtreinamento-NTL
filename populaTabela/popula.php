<?php

function populaMes()
{
    return <<<END
            
            <option value='1'>Janeiro</option>
            <option value='2'>Fevereiro</option>
            <option value='3'>Março</option>
            <option value='4'>Abril</option>
            <option value='5'>Maio</option>
            <option value='6'>Junho</option>
            <option value='7'>Julho</option>
            <option value='8'>Agosto</option>
            <option value='9'>Setembro</option>
            <option value='10'>Outubro</option>
            <option value='11'>Novembro</option>
            <option value='12'>Dezembro</option>                                                                        
END;
}

function populaVAVR()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Descontar faltas</option>
            <option value='2'>Descontar ausências</option>
            <option value='3'>Descontar faltas e ausências</option>
            <option value='4'>Não descontar faltas nem ausências</option>                
END;
}

function populaOrigemVaVr()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Sindicato</option>
            <option value='2'>Projeto</option>
            <option value='3'>Funcionário</option>   
            <option value='4'>Mês Corrente</option>                                               
END;
}

function populaCalculoTransporte()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Conforme a lei</option>
            <option value='2'>Real utilização</option>
            <option value='3'>Nenhum</option>   
                                                           
END;
}

function populaMunicipio()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Rio de Janeiro</option>
            <option value='2'>Duque de Caxias</option>
            <option value='3'>Nova Iguaçu</option>                                               
END;
}

function populaOpcaoTrajetoVT()
{
    return <<<END
            <option value="">Selecione</option>
            <option value='1'>Ida</option>
            <option value='2'>Volta</option>
            <option value='3'>Ida e Volta</option>                                               
END;
}

function populaFuncionario()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value="1">Elisa Sueli Teresinha Bernardes</option>
            <option value="2">Rayssa Betina Silveira</option>
            <option value="3">Enzo Cláudio Ramos</option>
            <option value="4">Marcos Anthony da Rocha</option>
            <option value="5">Gael Mateus Paulo Melo</option>
            <option value="6">Laura Elisa Corte Real</option>
            <option value="7">Luana Fernanda Melissa Vieira</option>
            <option value="8">Diego Leandro Filipe da Cruz</option>
            <option value="9">Henry Bento de Paula</option>
            <option value="10">Rayssa Lorena Fogaça</option>                                                                    
END;
}

function populaProjeto()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value="1"> Projeto Petrobrás</option>
            <option value="2">Projeto Vale do Rio Doce</option>
            <option value="3"> Projeto Veiga de Almeida</option>
            <option value="4">Projeto Moville II</option>
            <option value="5">Projeto Inside</option>
            <option value="6">Projeto TEC</option>
            <option value="7">Projeto ECTIT</option>
            <option value="8">Projeto SupraTI</option>
            <option value="9">Projeto AgileEX</option>
            <option value="10">Projeto JullER</option>                                                                    
END;
}

function populaSindicato()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value="1">Sindicato da Indústria da Construção Civil de Petrópolis</option>
            <option value="2">Sindicato da Indústria da Óptica do Estado do Rio de Janeiro</option>
            <option value="3">Sindicato da Indústria de Laticínios e Produtos
                Derivados do Estado do Rio de Janeiro</option>
            <option value="4">Sindicato das Indústrias Gráficas de Campos</option>
            <option value="5">Sindicato das Indústrias Metalúrgicas, Mecânicas
                e de Mat Elétrico no Noroeste do Est do Rio de Janeiro</option>
            <option value="6">Sindicato da Indústria de Marcenaria, Móveis de Madeira, Serrarias, Carpintarias e Tanoarias de Petrópolis</option>
            <option value="7">Sindicato Interestadual das Indústrias de Energia Elétrica</option>
            <option value="8">Sindicato Nacional da Indústria de Máquinas</option>
            <option value="9">Sindicato Nacional da Indústria de Tratores, Caminhões, Automóveis e Veículos Similares</option>
            <option value="10">Sindicato da Indústria do Vestuário do Norte Fluminense</option> 

END;
}

function populaTrasporteUnitario()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
    <option value="1">Ônibus Municipal</option>
    <option value="2">Ônibus Intermunicipal</option>
     <option value="3">Ônibus Interestadual</option>
    <option value="4">Trêm </option>
     <option value="5">Metrô </option>
    <option value="6">Barca Rio - Niterói</option>
    <option value="7">Barca Rio - Paquetá</option>
    <option value="8">VLT</option>  
END;
}

function populaTrasporteModal()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
    <option value="1">Ônibus Municipal - VLT</option>
    <option value="2">Ônibus Intermunicipal - Trem</option>
    <option value="3">Ônibus Interestadual - Metrô</option> 
    <option value="4">Barca - VLT</option>
    <option value="5">Metrô - Barca</option> 
    <option value="6">Trem - VLT</option> 
    <option value="7">VLT - Ônibus Municipal</option> 

END;
}

function populaCargo()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
        <option value='1'>Desenvolvedor Web</option>
        <option value='2'>Programador Front-End</option>
        <option value='3'>Programador Back-End</option>
        <option value='4'>Suporte Técnico</option>
        <option value='5'>Aprendiz de TI</option>                                                                   
END;
}

function populaMotivoDoAfastamento()
{
    return <<<END
        <option value="" style="display:none;">Selecione</option>
        <option value='1'>Maternidade</option>
        <option value='2'>Doença</option>
         <option value='3'>Sem remuneração</option>                                                                  
END;
}


function populaSimNao()
{
    return <<<END
        <option></option>
        <option value='1'>Sim</option>
        <option value='2'>Não</option>                                                                
END;
}

function populaSexo()
{
    return <<<END
        <option></option>
        <option value='M'>Masculino</option>
        <option value='F'>Feminino</option>
        <option value='O'>Outros</option>                                                                  
END;
}

function populaOperadorSaude()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
        <option value='1'>UNIMED</option>
        <option value='2'>AMIL</option>
        <option value='3'>Bradesco Saúde</option>
        <option value='4'>ASSIM</option>
        <option value='5'> Golden Cross</option>

END;
}

function populaPlanoSaude()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
        <option value='1'>Clássico I</option>
        <option value='2'>Clássico II</option>
        <option value='3'> Clássico III</option>
        <option value='4'>Alfa</option>
        <option value='5'>Beta</option>
        <option value='6'>Delta</option>
        <option value='7'>Odonto</option>                                                                
END;
}

function populaDiaUtilMes()
{
    return <<<END
            <option></option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>                                                               
END;
}

function populaBeneficio()
{
    return <<<END
            <option selected></option>
            <option value='1'>VA e VR</option>
            <option value='3'>Plano Saúde</option> 
END;
}

function populaTipoFeriado()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Municipal</option>
            <option value='2'>Estadual</option>
            <option value='3'>Nacional</option>                                                        
END;
}

function populaDependente()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Pedro Batista Mendes</option>
            <option value='2'>Mariana Batista Mendes</option>
            <option value='3'>Carla Batista Mendes</option> 
            <option value='4'>Maria Batista Mendes</option>  
END;
}

function populaGrauParentesco()
{
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Conjuge/Companheiro</option>
            <option value='2'>Filho/Enteado</option>
            <option value='3'>Agregado</option>                                                        
END;
}

function populaTipoDiaUtil()
{
    //Mes corrente retirado devido a falta de uso por parte da ntl temporariamente.
    // <option value='4' selected>Mês Corrente</option> 
    return <<<END
            <option value="" style="display:none;">Selecione</option>
            <option value='1'>Projeto</option>
            <option value='2'>Sindicato</option>
            <option value='3'>Funcionário</option> 
        
            <option value='5' selected>Município</option> 
END;
}
function populaQtdDias()
{
    return <<<END
            <option value='0'>Não Perde</option> 
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option> 
            <option value='5'>5</option> 
            <option value='6'>6</option> 
            <option value='7'>7</option> 
            <option value='8'>8</option> 
            <option value='9'>9</option> 
            <option value='10'>10</option> 
            <option value='11'>11</option> 
            <option value='12'>12</option> 
            <option value='13'>13</option> 
            <option value='14'>14</option> 
            <option value='15'>15</option> 
            <option value='16'>16</option> 
            <option value='17'>17</option> 
            <option value='18'>18</option> 
            <option value='19'>19</option> 
            <option value='20'>20</option> 
            <option value='21'>21</option> 
            <option value='22'>22</option> 
            <option value='23'>23</option> 
            <option value='24'>24</option> 
            <option value='25'>25</option> 
            <option value='26'>26</option> 
            <option value='27'>27</option> 
            <option value='28'>28</option> 
            <option value='29'>29</option> 
            <option value='30'>30</option> 
            <option value='31'>31</option> 
END;
}

function populaUf()
{
    return <<<END
            <option></option>
            <option value="AC">AC</option>
            <option value="AL">AL</option>
            <option value="AM">AM</option>
            <option value="AP">AP</option>
            <option value="BA">BA</option>
            <option value="CE">CE</option>
            <option value="DF">DF</option>
            <option value="ES">ES</option>
            <option value="GO">GO</option>
            <option value="MA">MA</option>
            <option value="MG">MG</option>
            <option value="MS">MS</option>
            <option value="MT">MT</option>
            <option value="PA">PA</option>
            <option value="PB">PB</option>
            <option value="PE">PE</option>
            <option value="PI">PI</option>
            <option value="PR">PR</option>
            <option value="RJ">RJ</option>
            <option value="RN">RN</option>
            <option value="RS">RS</option>
            <option value="RO">RO</option>
            <option value="RR">RR</option>
            <option value="SC">SC</option>
            <option value="SE">SE</option>
            <option value="SP">SP</option>
            <option value="TO">TO</option>                                                  
END;
}
function populaAno()
{
    $anoAtual = intval(date('Y'));
    $string = "";
    for ($i = 0; $i < 5; $i++) {
        $string2 = '<option value="' . $anoAtual . '">' . $anoAtual . '</option>';
        $string = $string . $string2;
        $anoAtual++;
    }
    return $string;
}

function populaAnoPonto()
{

    $ano = 2010;
    $anoAtual = intval(date('Y'));

    $string = '<option value="" style="display:none;">Selecione</option>';

    while ($ano <= $anoAtual) {
        $string2 = '<option value="' . $ano . '">' . $ano . '</option>';
        $string = $string . $string2;
        $ano++;
    }

    return $string;
}

function populaBdi()
{
    return <<<END
            <option></option>
            <option value="I">Imposto</option>
            <option value="L">Lucro</option>
            <option value="C">Custo</option>
END;
}
