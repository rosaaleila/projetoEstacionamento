<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Vinicio
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a Model (função Insert)
function inserirSetor($dadosSetor)
{

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosSetor)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosSetor['nome'])) {

            // Criação do array de dados que será encaminhado para a Model
            $arrayDados = array(
                "nome"      => $dadosSetor['nome']
            );

            // Import do arquivo de Model
            require_once(SRC . 'setor/model/bd/setor.php');

            // Chama e verifica sucesso da função da Model
            if (insertSetor($arrayDados))
                return true;
            else
                return array(
                    'idErro'  => 1,
                    'message' => 'Não foi possivel inserir o dado no Banco de Dados'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatórios que não foram preenchidos.'
            );
    }
}

// Função para receber dados da View e encaminhar para a model (função Update)
function atualizarSetor($dadosSetor)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosSetor['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosSetor)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosSetor[0]['nome'])) {
            
            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"        => $id,
                    "nome"      => $dadosSetor[0]['nome']
                );

                // Import do arquivo de Model
                require_once(SRC . 'setor/model/bd/setor.php');

                // Chama e verifica sucesso da função da Model
                if (updateSetor($arrayDados)) {
                    return true;
                } else
                    return array(
                        'idErro'  => 1,
                        'message' => 'Não foi possivel atualizar o setor no Banco de Dados'
                    );
            } else
                return array(
                    'idErro'   => 4,
                    'message'  => 'Não é possível editar um setor sem informar um id válido.'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatórios que não foram preenchidos.'
            );
    }
}

// Função para realizar a exclusão de um registro
function excluirSetor($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'setor/model/bd/setor.php');

        // Import do arquivo de configurações do projeto
        require_once(SRC . 'modulo/config.php');

        // Chama e verifica sucesso da função da Model
        if (deleteSetor($id)) {
            return true;
        } else
            return array(
                'idErro'   => 3,
                'message'  => 'O banco de dados não pode excluir o setor.'
            );
    } else
        return array(
            'idErro'   => 4,
            'message'  => 'Não é possível excluir um setor sem informar um id válido.'
        );
}

// Função para solicitar os dados da Model e encaminhar a lista de registros para a View
function listarSetor()
{

    // Import do arquivo de Model
    require_once(SRC . 'setor/model/bd/setor.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllSetores();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarSetor($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'setor/model/bd/setor.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdSetor($id);

        // Verifica se os dados tragos pela Model estão vazios para então retorná-los
        if (!empty($dados))
            return $dados;
        else
            return false;
    } else
        return array(
            'idErro'   => 4,
            'message'  => 'Não é possível buscar um setor sem informar um id válido.'
        );
}
