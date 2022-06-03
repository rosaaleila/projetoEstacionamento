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

// Função para realizar o insert de um registro no BD
function insertPlano($dadosPlano)
{
    // Declaração de variavel para se utilizar no return
    $statusResposta = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para adição de registro
    $sql = "insert into tblPlano 
                    (nome, 
                     primeiraHora,
                     horasAdicionais,
                     diaria                     
                     )
                values 
                    ('" . $dadosPlano['nome'] . "',   
                    '" . $dadosPlano['primeiraHora'] . "',
                    '" . $dadosPlano['horasAdicionais'] . "',                  
                    '" . $dadosPlano['diaria'] . "'
                );";


    // Validação para verificar se o script SQL está correto
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
function listarAllPlanos()
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select * from tblPlano order by id desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"        =>  $rsDados['id'],
                "nome"      =>  $rsDados['nome'],
                "primeiraHora"  =>  $rsDados['primeiraHora'],
                "horaAdicional"  =>  $rsDados['horasAdicionais'],
                "diaria"  =>  $rsDados['diaria']
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
function selectByIdPlano($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD em ordem decrescente
    $sql = "select * from tblPlano where id = " . $id;

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"        =>  $rsDados['id'],
                "nome"      =>  $rsDados['nome'],
                "primeiraHora"  =>  $rsDados['primeiraHora'],
                "horaAdicional"  =>  $rsDados['horasAdicionais'],
                "diaria"  =>  $rsDados['diaria']
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
function updatePlano($dadosPlano)
{

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Abre a conexão com o banco de dados
    $conexao = conexaoMysql();

    // Script para atualizar um registro através de seu id
    $sql = "update tblPlano set
                        nome = '" . $dadosPlano['nome'] . "', 
                        primeiraHora = " . $dadosPlano['primeiraHora'] . ",
                        horasAdicionais = " . $dadosPlano['horasAdicionais'] . ", 
                        diaria = " . $dadosPlano['diaria'] . " 
                        where id =" . $dadosPlano['id'];

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
function deletePlano($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMySql();

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Script para deletar um registro através de seu ID
    $sql = "delete from tblPlano where id =" . $id;

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
