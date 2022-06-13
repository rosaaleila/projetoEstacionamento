<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Vinicio
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a Model (função Insert)
function inserirVeiculo($dadosVeiculo)
{

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosVeiculo)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosVeiculo['placa']) && !empty($dadosVeiculo['idCliente'])) {

            // Criação do array de dados que será encaminhado para a Model
            $arrayDados = array(
                "placa"      => $dadosVeiculo['placa'],
                "idCliente"  => $dadosVeiculo['idCliente']
            );

            // Import do arquivo de Model
            require_once(SRC . 'veiculo/model/bd/veiculo.php');

            // Chama e verifica sucesso da função da Model
            if (is_int($id = insertVeiculo($arrayDados)))
                return $id;
            else
                return array(
                    'idErro'  => 1,
                    'message' => 'Não foi possivel inserir o veiculo no Banco de Dados'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatórios que não foram preenchidos.'
            );
    }
}

// Função para receber dados da View e encaminhar para a model (função Update)
function atualizarVeiculo($dadosVeiculo)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosVeiculo['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosVeiculo)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosVeiculo[0]['placa']) && !empty($dadosVeiculo[0]['idCliente'])) {

            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"        => $id,
                    "placa"      => $dadosVeiculo[0]['placa'],
                    "idCliente" => $dadosVeiculo[0]['idCliente']
                );

                // Import do arquivo de Model
                require_once(SRC . 'veiculo/model/bd/veiculo.php');

                // Chama e verifica sucesso da função da Model
                if (updateVeiculo($arrayDados)) {
                    return true;
                } else
                    return array(
                        'idErro'  => 1,
                        'message' => 'Não foi possivel atualizar o veiculo no Banco de Dados'
                    );
            } else
                return array(
                    'idErro'   => 4,
                    'message'  => 'Não é possível editar um veiculo sem informar um id válido.'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatórios que não foram preenchidos.'
            );
    }
}

// Função para realizar a exclusão de um registro
function excluirVeiculo($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'veiculo/model/bd/veiculo.php');

        // Import do arquivo de configurações do projeto
        require_once(SRC . 'modulo/config.php');

        // Chama e verifica sucesso da função da Model
        if (deleteVeiculo($id)) {
            return true;
        } else
            return array(
                'idErro'   => 3,
                'message'  => 'O banco de dados não pode excluir a vaga.'
            );
    } else
        return array(
            'idErro'   => 4,
            'message'  => 'Não é possível excluir uma vaga sem informar um id válido.'
        );
}

// Função para solicitar os dados da Model e encaminhar a lista de registros para a View
function listarVeiculo()
{

    // Import do arquivo de Model
    require_once(SRC . 'veiculo/model/bd/veiculo.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllVeiculos();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarVeiculo($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'veiculo/model/bd/veiculo.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdVeiculo($id);

        // Verifica se os dados tragos pela Model estão vazios para então retorná-los
        if (!empty($dados))
            return $dados;
        else
            return false;
    } else
        return array(
            'idErro'   => 4,
            'message'  => 'Não é possível buscar uma vaga sem informar um id válido.'
        );
}

function listarCarrosEstacionados() {

    // Import do arquivo de Model
    require_once(SRC . 'veiculo/model/bd/veiculo.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = selectCarrosEstacionados();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;

}

