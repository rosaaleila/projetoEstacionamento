<?php

/***********************************************************************
 * Objetivo: Arquivo responsável por manipular os dados dentro do BD
 *          (insert, update, select e delete).
 * Autora: Leila
 * Data: 03/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Import do arquivo para estabecer a conexão com o BD
require_once('../modulo/conexaoMySql.php');

// Função para realizar o insert de um registro no BD
function insertRegistro($dadosRegistro)
{
    // Declaração de variavel para se utilizar no return
    $statusResposta = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para adição de registro
    $sql = "insert into tblRegistro 
                    (horaEntrada,
                     horaSaida,
                     diaEntrada,
                     diaSaida,
                     precoFinal,
                     idVagas,
                     idVeiculo                     
                     )
                values 
                    (curtime(),                     
                    " . $dadosRegistro['horaSaida'] . ",                     
                    curdate(),
                    " . $dadosRegistro['diaSaida'] . ",
                    " . $dadosRegistro['precoFinal'] . ",
                    " . $dadosRegistro['idVagas'] . ",
                    " . $dadosRegistro['idVeiculo'] . "
                );";


    //Validação para verificar se o script SQL está correto
    if (mysqli_query($conexao, $sql)) {

        // Validação para verificar se uma linha foi acrescentada no DB
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    // Fecha a conexão com o BD
    fecharConexaoMysql($conexao);

    return $statusResposta;
}

// Função para listar todos os registros de saída no BD
function listarAllRegistroEntrada()
{

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select r.id as idRegistro,
            c.nome as nomeCliente,
            v.placa,
            vg.numero as numeroVaga,
            c.telefone
            from tblCliente c
            inner join tblVeiculo v
                on c.id = v.idCliente
            inner join tblRegistro r
                on v.id = r.idVeiculo 
            inner join tblVagas vg
                on vg.id = r.idVagas
            order by idRegistro desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros que sairam

    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"                =>  $rsDados['idRegistro'],
                "nomeCliente"       =>  $rsDados['nomeCliente'],
                "placa"             =>  $rsDados['placa'],
                "numeroVaga"        =>  $rsDados['numeroVaga'],
                "telefone"          =>  $rsDados['telefone']
            );
            $cont++;
        }

        // Fecha a conexão com o BD
        fecharConexaoMysql($conexao);

        // O script apenas foi um sucesso quando a variável arrayDados existir
        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

// Função para listar todos os registros de saída no BD
function listarAllRegistroSaida()
{

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select r.id as idRegistro,
            v.placa,
            c.nome,
            c.telefone,
            r.diasaida as dataSaida,
            r.horasaida as horaSaida
            from tblCliente c
            inner join tblVeiculo v
                on c.id = v.idCliente
            inner join tblRegistro r
                on v.id = r.idVeiculo                 
            inner join tblVagas vg
                on vg.id = r.idVagas
            where r.diasaida and r.horasaida is not null	
            order by datasaida, horasaida desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros que sairam

    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"                =>  $rsDados['idRegistro'],
                "placa"             =>  $rsDados['placa'],
                "telefone"          =>  $rsDados['telefone'],
                "dataSaida"         =>  $rsDados['dataSaida'],
                "horaSaida"       =>  $rsDados['horaSaida'] 
            );
            $cont++;
        }

        // Fecha a conexão com o BD
        fecharConexaoMysql($conexao);

        // O script apenas foi um sucesso quando a variável arrayDados existir
        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

// Função para listar todos os registros no BD
function listarAllRegistros()
{

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select * from tblRegistro order by id desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"                =>  $rsDados['id'],
                "horaEntrada"       =>  $rsDados['horaEntrada'],
                "horaSaida"         =>  $rsDados['horaSaida'],
                "diaEntrada"        =>  $rsDados['diaEntrada'],
                "diaSaida"          =>  $rsDados['diaSaida'],
                "precoFinal"        =>  $rsDados['precoFinal'],
                "idVagas"           =>  $rsDados['idVagas'],
                "idVeiculo"         =>  $rsDados['idVeiculo']
            );
            $cont++;
        }

        // Fecha a conexão com o BD
        fecharConexaoMysql($conexao);

        // O script apenas foi um sucesso quando a variável arrayDados existir
        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

// Função para selecionar um registro no BD, pelo seu ID
function selectByIdRegistro($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD, em ordem decrescente
    $sql = "select * from tblRegistro where id = " . $id;

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"                =>  $rsDados['id'],
                "horaEntrada"       =>  $rsDados['horaEntrada'],
                "horaSaida"         =>  $rsDados['horaSaida'],
                "diaEntrada"        =>  $rsDados['diaEntrada'],
                "diaSaida"          =>  $rsDados['diaSaida'],
                "precoFinal"        =>  $rsDados['precoFinal'],
                "idVagas"           =>  $rsDados['idVagas'],
                "idVeiculo"         =>  $rsDados['idVeiculo']
            );

            return $arrayDados;
        } else {
            return false;
        }

        // Fecha a conexão com o BD
        fecharConexaoMysql($conexao);
    }
}

// Função para atualizar registro no BD
function updateRegistro($dadosRegistro)
{

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Convertendo o dado horaEntrada para o padrão necessário (00:00:00)
    preg_match_all('/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $dadosRegistro['horaEntrada'], $horaEntrada);

    // Script para atualizar um registro através de seu id
    $sql = "update tblRegistro set
                        horaEntrada = '" . $dadosRegistro['horaEntrada'] . "', 
                        horaSaida = curtime(),
                        diaEntrada = '" . $dadosRegistro['diaEntrada'] . "', 
                        diaSaida = curdate(), 
                        precoFinal = " . $dadosRegistro['precoFinal'] . ", 
                        idVagas = " . $dadosRegistro['idVagas'] . ", 
                        idVeiculo = " . $dadosRegistro['idVeiculo'] . "
                        where id =" . $dadosRegistro['id'];

    // Validação para verificar se o script sql está correto
    if (mysqli_query($conexao, $sql)) {

        // Validacao para verificar se uma linha foi acrescentada no BD
        if (mysqli_affected_rows($conexao))
            $status = true;
    }

    // Fecha a conexão com o BD
    fecharConexaoMysql($conexao);

    return $status;
}

// Função para deletar registro no BD
function deleteRegistro($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMySql();

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Script para deletar um registro através de seu ID
    $sql = "delete from tblRegistro where id =" . $id;

    // Validação para verificar se o script sql está correto para executá-lo
    if (mysqli_query($conexao, $sql)) {

        // Validacao para verificar se uma linha foi acrescentada no BD
        if (mysqli_affected_rows($conexao))
            $status = true;
    }

    // Fecha a conexao com o BD
    fecharConexaoMysql($conexao);

    return $status;
}

// Função para listar todos os registros no BD
function buscarDadosRegistro($placa)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD, em ordem decrescente
    $sql = "select 
    tblveiculo.id as idVeiculo,
    tblplano.id as idPlano,
    tblveiculo.placa,
    tblcliente.nome as nomeCliente,
    tblcliente.documento as RG,
    tblregistro.horaentrada as horaEntrada,
    tblregistro.diaentrada as diaEntrada,
        (select datediff(curdate(), diaEntrada)) as totalDias,
        (select hour(timediff(horaEntrada, curtime()))) as totalHoras,
        (select CASE 
            WHEN totalHoras <= 1 THEN tblplano.primeiraHora + (totalDias * tblplano.diaria)
            WHEN totalHoras > 1  THEN ((totalHoras - 1) * tblplano.horasAdicionais) + tblplano.primeiraHora + (totalDias * tblplano.diaria)
            END) as valorTotal,
    tblvagas.numero as vaga,
    tblsetor.nome as setor,
    tblplano.nome as plano
    from tblveiculo 
    inner join tblcliente 
    on tblcliente.id = tblveiculo.idcliente 
    inner join tblregistro 
    on tblveiculo.id = tblregistro.idveiculo
    and tblveiculo.placa = '".$placa."'
    and tblregistro.diasaida is null
    inner join tblvagas
    on tblvagas.id = tblregistro.idvagas
    inner join tblsetor
    on tblsetor.id = tblvagas.idsetor
    inner join tblplano
    on tblplano.id = tblvagas.idplano;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "idVeiculo"         =>  $rsDados['idVeiculo'],
                "idPlano"           =>  $rsDados['idPlano'],
                "placa"             =>  $rsDados['placa'],
                "nomeCliente"       =>  $rsDados['nomeCliente'],
                "RG"                =>  $rsDados['RG'],
                "horaentrada"       =>  $rsDados['horaEntrada'],
                "diaentrada"        =>  $rsDados['diaEntrada'],
                "totalHoras"        =>  $rsDados['totalHoras'],
                "totalDias"         =>  $rsDados['totalDias'],
                "valorTotal"        =>  $rsDados['valorTotal'],
                "vaga"              =>  $rsDados['vaga'],
                "setor"             =>  $rsDados['setor'],
                "plano"             =>  $rsDados['plano']
            );

            return $arrayDados;
        } else {
            return false;
        }
    }

    // Fecha a conexão com o BD
    fecharConexaoMysql($conexao);
}

function buscarRelatorio($diaInicio, $diaFim)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD, em ordem decrescente
    $sql = "select 
	count(tblveiculo.placa) as veiculosEstacionados,
    SUM(tblregistro.precofinal) as valorTotal
    from tblregistro
    inner join tblveiculo
    on tblveiculo.id = tblregistro.idveiculo
    and tblregistro.diaEntrada
    between '".$diaInicio."' and '".$diaFim."'
    and tblregistro.diasaida is not null;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "veiculosEstacionados"      =>  $rsDados['veiculosEstacionados'],
                "valorTotal"                =>  $rsDados['valorTotal']
            );
            $cont++;
        }

        // O script apenas foi um sucesso quando a variável arrayDados existir
        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;

    }

    // Fecha a conexão com o BD
    fecharConexaoMysql($conexao);
}
