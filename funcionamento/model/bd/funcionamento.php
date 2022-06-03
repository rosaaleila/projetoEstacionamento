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
function listarAllFuncionamentos()
{

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD
    $sql = "select * from tblFuncionamento order by id desc;";

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        $cont = 0;

        // Converte os dados do BD em array
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "id"                    =>  $rsDados['id'],
                "horaAbertura"          =>  $rsDados['horaAbertura'],
                "horaFechamento"        =>  $rsDados['horaFechamento'],
                "idEstacionamento"      =>  $rsDados['idEstacionamento'],
                "idDia"                 =>  $rsDados['idDia']
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
function selectByIdFuncionamento($id)
{

    // Abre a conexao com o BD
    $conexao = conexaoMysql();

    // Script para listar todos os dados do BD, em ordem decrescente
    $sql = "select * from tblFuncionamento where id = " . $id;

    // Executa o script sql no BD e guarda o retorno dos dados
    $result = mysqli_query($conexao, $sql);

    // Valida se o BD retornou registros 
    if ($result) {

        // Convertendo os dados do BD em array
        if ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"                    =>  $rsDados['id'],
                "horaAbertura"          =>  $rsDados['horaAbertura'],
                "horaFechamento"        =>  $rsDados['horaFechamento'],
                "idEstacionamento"      =>  $rsDados['idEstacionamento'],
                "idDia"                 =>  $rsDados['idDia']
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
function updateFuncionamento($dadosFuncionamento)
{

    // Declaração de variavel para se utilizar no return
    $status = (bool) false;

    // Abre aconexão com o BD
    $conexao = conexaoMysql();

    // Convertendo o dado horaAbertura para o padrão necessário (00:00:00)
    preg_match_all('/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $dadosFuncionamento['horaAbertura'], $horaAbertura);
    
    // Convertendo o dado horaFechamento para o padrão necessário (00:00:00)
    preg_match_all('/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $dadosFuncionamento['horaFechamento'], $horaFechamento);

    // Script para atualizar um registro através de seu id
    $sql = "update tblFuncionamento set
                        horaAbertura = '" . $horaAbertura[0][0] . "',
                        horaFechamento = '" . $horaFechamento[0][0] . "',
                        idEstacionamento = " . $dadosFuncionamento['idEstacionamento'] . ",
                        idDia = " . $dadosFuncionamento['idDia'] . "
                        where id =" . $dadosFuncionamento['id'];

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
