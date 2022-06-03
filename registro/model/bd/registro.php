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

    // Convertendo o dado horaEntrada para o padrão necessário (00:00:00)
    preg_match_all('/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $dadosRegistro['horaEntrada'], $horaEntrada);
    
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
                    ('".$horaEntrada[0][0]."',                     
                    " . $dadosRegistro['horaSaida'] . ",                     
                    '" . $dadosRegistro['diaEntrada'] . "',
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
    
    // Convertendo o dado horaSaida para o padrão necessário (00:00:00)
    preg_match_all('/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $dadosRegistro['horaSaida'], $horaSaida);
    

    // Script para atualizar um registro através de seu id
    $sql = "update tblRegistro set
                        horaEntrada = '" . $dadosRegistro['horaEntrada'] . "', 
                        horaSaida = '" . $dadosRegistro['horaSaida'] . "',
                        diaEntrada = '" . $dadosRegistro['diaEntrada'] . "', 
                        diaSaida = '" . $dadosRegistro['diaSaida'] . "', 
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