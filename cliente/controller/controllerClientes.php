<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de clientes.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Vinicio
 * Data: 01/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a Model cliente (função Insert)
function inserirCliente($dadosCliente)
{

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosCliente)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosCliente['nome']) && !empty($dadosCliente['documento']) && !empty($dadosCliente['telefone']) && !empty($dadosCliente['email'])){

            // Criação do array de dados que será encaminhado para a Model
            $arrayDados = array(
                "nome"      => $dadosCliente['nome'],
                "documento"  => $dadosCliente['documento'],
                "telefone"   => $dadosCliente['telefone'],
                "email"      => $dadosCliente['email']
            );

            // Import do arquivo de Model
            require_once(SRC . 'cliente/model/bd/cliente.php');

            // Chama e verifica sucesso da função da Model
            if (is_int($id = insertCliente($arrayDados)))
                return $id;
            else
                return array(
                    'idErro'  => 1,
                    'message' => 'Não foi possivel inserir os dados no Banco de Dados'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatórios que não foram preenchidos.'
            );
    }
}

// Função para receber dados da View e encaminhar para a model (função Update)
function atualizarCliente($dadosCliente)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosCliente['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosCliente)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosCliente[0]['nome']) && !empty($dadosCliente[0]['documento']) && !empty($dadosCliente[0]['telefone']) && !empty($dadosCliente[0]['email'])){

            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"        => $id,
                    "nome"      => $dadosCliente[0]['nome'],
                    "documento" => $dadosCliente[0]['documento'],
                    "telefone"  => $dadosCliente[0]['telefone'],
                    "email"     => $dadosCliente[0]['email']
                );

                // Import do arquivo de Model
                require_once(SRC . 'cliente/model/bd/cliente.php');

                // Chama e verifica sucesso da função da Model
                if (updateCliente($arrayDados)) {
                    return true;
                } else
                    return array(
                        'idErro'  => 1,
                        'message' => 'Não foi possivel editar os dados do cliente no Banco de Dados'
                    );
            } else
                return array(
                    'idErro'   => 4,
                    'message'  => 'Não é possível editar o registro do cliente sem informar um id válido.'
                );
        } else
            return array(
                'idErro'   => 2,
                'message'  => 'Existem campos obrigatórios que não foram preenchidos.'
            );
    }
}

// Função para realizar a exclusão de um registro
function excluirCliente($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'cliente/model/bd/cliente.php');

        // Import do arquivo de configurações do projeto
        require_once(SRC . 'modulo/config.php');

        // Chama e verifica sucesso da função da Model
        if (deleteCliente($id)) {
            return true;
        } else
            return array(
                'idErro'   => 3,
                'message'  => 'O banco de dados não pode excluir o registro do cliente.'
            );
    } else
        return array(
            'idErro'   => 4,
            'message'  => 'Não é possível excluir um registro do cliente sem informar um id válido.'
        );
}

// Função para solicitar os dados da Model e encaminhar a lista de registros para a View
function listarCliente()
{

    // Import do arquivo de Model
    require_once(SRC . 'cliente/model/bd/cliente.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllClientes();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarCliente($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'cliente/model/bd/cliente.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdCliente($id);

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
