<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Leila
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a Model (função Insert)
function inserirTelefoneCliente($dadosCliente)
{

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosCliente)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosCliente['telefone']) && !empty($dadosCliente['idCliente'])) {
            
            // Criação do array de dados que será encaminhado para a Model
            $arrayDados = array(
                "telefone"      => $dadosCliente['telefone'],
                "idCliente"  => $dadosCliente['idCliente']
            );

            // Import do arquivo de Model
            require_once(SRC . 'cliente/model/bd/telefoneCliente.php');

            // Chama e verifica sucesso da função da Model
            if (insertTelefoneCliente($arrayDados))
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
function atualizarTelefoneCliente($dadosCliente)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosCliente['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosCliente)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosCliente[0]['telefone']) && !empty($dadosCliente[0]['idCliente'])) {
            
            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"        => $id,
                    "telefone"      => $dadosCliente[0]['telefone'],
                    "idCliente" => $dadosCliente[0]['idCliente']
                );

                // Import do arquivo de Model
                require_once(SRC . 'cliente/model/bd/telefoneCliente.php');
                
                // Chama e verifica sucesso da função da Model
                if (updateTelefoneCliente($arrayDados)) {
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
function excluirTelefoneCliente($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'cliente/model/bd/telefoneCliente.php');

        // Import do arquivo de configurações do projeto
        require_once(SRC . 'modulo/config.php');

        // Chama e verifica sucesso da função da Model
        if (deleteTelefoneCliente($id)) {
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
function listarTelefoneCliente()
{

    // Import do arquivo de Model
    require_once(SRC . 'cliente/model/bd/telefoneCliente.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllTelefoneClientes();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarTelefoneCliente($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'cliente/model/bd/telefoneCliente.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdTelefoneCliente($id);

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
