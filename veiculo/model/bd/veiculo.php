<?php

/***********************************************************************
 * Objetivo: Arquivo responsável por manipular os dados dentro do BD
 *          (insert, update, select e delete).
 * Autora: Vinicio
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/


// Import do arquivo para estabecer a conexão com o BD
require_once('../modulo/conexaoMySql.php');

// Função para realizar o insert de um registro no BD
function insertVeiculo($dadosVeiculo)
{
    // Declaração de variavel para utilizar no return
    $statusResposta = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para adição de registro
    $sql = "insert into tblVeiculo 
                    (placa, 
                     idCliente                     
                     )
                values 
                    ('" . $dadosVeiculo['placa'] . "',                     
                    '" . $dadosVeiculo['idCliente'] . "'
                );";


    // Validação para veririficar se o script sql esta correto
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
function listarAllVeiculos()
{

    // Sbre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select * from tblVeiculo order by id desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        $cont = 0;

        while ($rsDados = mysqli_fetch_assoc($result)) {
            // Converte os dados do BD em array
            $arrayDados[$cont] = array(
                "id"        =>  $rsDados['id'],
                "placa"      =>  $rsDados['placa'],
                "idCliente"  =>  $rsDados['idCliente']
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
function selectByIdVeiculo($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD em ordem decrescente
    $sql = "select * from tblVeiculo where id = " . $id;

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"        =>  $rsDados['id'],
                "placa"      =>  $rsDados['placa'],
                "idCliente"  =>  $rsDados['idCliente']
            );

            return $arrayDados;
        } else {
            return false;
        }

        // Fecha a conexao com o BD
        fecharConexaoMysql($conexao);
    }
}

// Função para atualizar registro no BD
function updateVeiculo($dadosVeiculo)
{

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Abre a conexão com o banco de dados
    $conexao = conexaoMysql();

    // Script para atualizar um registro através de seu id
    $sql = "update tblVeiculo set
                        placa = '" . $dadosVeiculo['placa'] . "', 
                        idCliente = '" . $dadosVeiculo['idCliente'] . "'
                        where id =" . $dadosVeiculo['id'];

    // Validação para verificar se o script sql está correto
    if (mysqli_query($conexao, $sql)) {

        // Validacao para verificar se uma linha foi acrescentada no BD
        if (mysqli_affected_rows($conexao))
            $status = true;
    }

    // Fecha a conexao com o BD
    fecharConexaoMysql($conexao);

    return $status;
}

// Função para deletar registro no BD
function deleteVeiculo($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMySql();

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Script para deletar um registro através de seu ID
    $sql = "delete from tblVeiculo where id =" . $id;

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

// Função para selecionar um registro no BD, pelo seu ID
function selectByPlaca($placa)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD em ordem decrescente
    $sql = "select * from tblVeiculo where placa = '" . $placa . "'";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"        =>  $rsDados['id'],
                "placa"      =>  $rsDados['placa'],
                "idCliente"  =>  $rsDados['idCliente']
            );

            return $arrayDados;
        } else {
            return false;
        }

        // Fecha a conexao com o BD
        fecharConexaoMysql($conexao);
    }
}