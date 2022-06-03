<?php

/***********************************************************************
 * Objetivo: Arquivo responsável por manipular os dados dentro do BD
 *          (insert, update, select e delete).
 * Autora: Leila
 * Data: 01/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Import do arquivo para estabecer a conexão com o BD
require_once('../modulo/conexaoMySql.php');

// Função para realizar o insert de um registro no BD
function insertTelefoneEstacionamento($dadosEstacionamento)
{
    // Declaração de variavel para se utilizar no return
    $statusResposta = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para adição de registro
    $sql = "insert into tblTelefone_Estacionamento 
                    (telefone, 
                     idEstacionamento                     
                     )
                values 
                    ('" . $dadosEstacionamento['telefone'] . "',                     
                    '" . $dadosEstacionamento['idEstacionamento'] . "'
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
function listarAllTelefoneEstacionamento()
{

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select * from tblTelefone_Estacionamento order by id desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"        =>  $rsDados['id'],
                "telefone"      =>  $rsDados['telefone'],
                "idEstacionamento"  =>  $rsDados['idEstacionamento']
            );
            $cont++;
        }

        // solicita o fechamento da conexao com o BD
        fecharConexaoMysql($conexao);

        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

// Função para selecionar um registro no BD, pelo seu ID
function selectByIdTelefoneEstacionamento($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD, em ordem decrescente
    $sql = "select * from tblTelefone_Estacionamento where id = " . $id;

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"        =>  $rsDados['id'],
                "telefone"      =>  $rsDados['telefone'],
                "idEstacionamento"  =>  $rsDados['idEstacionamento']
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
function updateTelefoneEstacionamento($dadosEstacionamento)
{

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para atualizar um registro através de seu id
    $sql = "update tblTelefone_Estacionamento set
                        telefone = '" . $dadosEstacionamento['telefone'] . "', 
                        idEstacionamento = '" . $dadosEstacionamento['idEstacionamento'] . "'
                        where id =" . $dadosEstacionamento['id'];

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
function deleteTelefoneEstacionamento($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMySql();

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Script para deletar um registro através de seu ID
    $sql = "delete from tblTelefone_Estacionamento where id =" . $id;

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
