<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Leila
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a Model (função Insert)
function inserirEmailCliente($dadosEmailCliente)
{

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosEmailCliente)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosEmailCliente['email']) && !empty($dadosEmailCliente['idCliente'])) {

            // Criação do array de dados que será encaminhado para a Model
            $arrayDados = array(
                "email"      => $dadosEmailCliente['email'],
                "idCliente"  => $dadosEmailCliente['idCliente']
            );

            // Import do arquivo de Model
            require_once(SRC . 'cliente/model/bd/emailCliente.php');

            // Chama e verifica sucesso da função da Model
            if (insertEmailCliente($arrayDados))
                return true;
            else
                return array(
                    'idErro'  => 1,
                    'message' => 'Não foi possivel inserir os dados no Banco de Dados'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatório que não foram preenchidos.'
            );
    }
}

// Função para receber dados da View e encaminhar para a model (função Update)
function atualizarEmailCliente($dadosEmailCliente)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosEmailCliente['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosEmailCliente)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosEmailCliente[0]['email']) && !empty($dadosEmailCliente[0]['idCliente'])) {

            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"        => $id,
                    "email"     => $dadosEmailCliente[0]['email'],
                    "idCliente" => $dadosEmailCliente[0]['idCliente']
                );

                // Import do arquivo de Model
                require_once(SRC . 'cliente/model/bd/emailCliente.php');

                // Chama e verifica sucesso da função da Model
                if (updateEmailCliente($arrayDados)) {
                    return true;
                } else
                    return array(
                        'idErro'  => 1,
                        'message' => 'Não foi possivel atualizar os dados no Banco de Dados'
                    );
            } else
                return array(
                    'idErro'   => 4,
                    'message'  => 'Não é possível editar um registro sem informar um id válido.'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatório que não foram preenchidos.'
            );
    }
}

// Função para realizar a exclusão de um registro
function excluirEmailCliente($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'cliente/model/bd/emailCliente.php');

        // Import do arquivo de configurações do projeto
        require_once(SRC . 'modulo/config.php');

        // Chama e verifica sucesso da função da Model
        if (deleteEmailCliente($id)) {
            return true;
        } else
            return array(
                'idErro'   => 3,
                'message'  => 'O banco de dados não pode excluir o registro.'
            );
    } else
        return array(
            'idErro'   => 4,
            'message'  => 'Não é possível excluir um registro sem informar um id válido.'
        );
}

// Função para solicitar os dados da Model e encaminhar a lista de registros para a View
function listarEmailCliente()
{

    // Import do arquivo de Model
    require_once(SRC . 'cliente/model/bd/emailCliente.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllEmailClientes();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarEmailCliente($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'cliente/model/bd/emailCliente.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdEmailCliente($id);

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
