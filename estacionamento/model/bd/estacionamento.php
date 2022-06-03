<?php

/***********************************************************************
 * Objetivo: Arquivo responsável por manipular os dados dentro do BD
 *          (insert, update, select e delete).
 * Autora: Leila
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Import do arquivo para estabecer a conexão com o BD
require_once('../modulo/conexaoMySql.php');

// Função para listar todos os registros no BD
function listarAllEstacionamentos()
{

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select * from tblEstacionamento order by id desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"            =>  $rsDados['id'],
                "nome"          =>  $rsDados['nome'],
                "logradouro"    =>  $rsDados['logradouro'],
                "numero"        =>  $rsDados['numero'],
                "cep"           =>  $rsDados['cep'],
                "bairro"        =>  $rsDados['bairro'],
                "cidade"        =>  $rsDados['cidade'],
                "estado"        =>  $rsDados['estado']
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
function selectByIdEstacionamento($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD, em ordem decrescente
    $sql = "select * from tblEstacionamento where id = " . $id;

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"            =>  $rsDados['id'],
                "nome"          =>  $rsDados['nome'],
                "logradouro"    =>  $rsDados['logradouro'],
                "numero"        =>  $rsDados['numero'],
                "cep"           =>  $rsDados['cep'],
                "bairro"        =>  $rsDados['bairro'],
                "cidade"        =>  $rsDados['cidade'],
                "estado"        =>  $rsDados['estado']
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
function updateEstacionamento($dadosEstacionamento)
{

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para atualizar um registro através de seu id
    $sql = "update tblEstacionamento set
                        nome = '" . $dadosEstacionamento['nome'] . "',
                        logradouro = '" . $dadosEstacionamento['logradouro'] . "',
                        numero = '" . $dadosEstacionamento['numero'] . "',
                        cep = '" . $dadosEstacionamento['cep'] . "',
                        bairro = '" . $dadosEstacionamento['bairro'] . "',
                        cidade = '" . $dadosEstacionamento['cidade'] . "',
                        estado = '" . $dadosEstacionamento['estado'] . "'
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
