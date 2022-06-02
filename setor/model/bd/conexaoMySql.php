<?php

/**********************************************************************
 * Objetivo: Arquivo para criar a conexão com o banco de dados Mysql.
 * Autora: Leila
 * Data: 25/02/2022
 * Versão: 1.3
 **********************************************************************/

// constantes para estabeleecer a conexão com o banco de dados
const SERVER = 'localhost';
const USER = 'root';
const PASSWORD = 'bcd127';
const DATABASE = 'dbfastparking';

// abre a conexão com o banco de dados Mysql
function conexaoMysql()
{
    $conexao = array();

    // se a conexão for estabelecida com o BD, iremos ter um array de dados sobre a conexão
    $conexao = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);

    // validação para verificar se a conexão foi realizada com sucesso
    if ($conexao)
        return $conexao;
    else
        return false;
}

// fecha a conexão com o banco de dados mysql
function fecharConexaoMysql($conexao)
{
    mysqli_close($conexao);
}