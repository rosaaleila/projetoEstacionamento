<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Leila
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para solicitar os dados da Model e encaminhar a lista de registros para a View
function listarDias()
{

    // Import do arquivo de Model
    require_once(SRC . 'dia/model/bd/dia.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllDias();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

/// Função para buscar um registro através do seu ID
function buscarDia($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'dia/model/bd/dia.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdDia($id);

        // Verifica se os dados tragos pela Model estão vazios para então retorná-los
        if (!empty($dados))
            return $dados;
        else
            return false;
    } else
        return array(
            'idErro'   => 4,
            'message'  => 'Não é possível buscar um registro sem informar um id válido.'
        );
}

?>