<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Leila
 * Data: 03/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a Model (função Insert)
function inserirRegistro($dadosRegistro)
{

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosRegistro)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosRegistro['horaEntrada']) && !empty($dadosRegistro['diaEntrada']) && !empty($dadosRegistro['idVagas']) && !empty($dadosRegistro['idVeiculo'])) {

            // Criação do array de dados que será encaminhado para a Model
            $arrayDados = array(
                "horaEntrada"           => $dadosRegistro['horaEntrada'],
                "horaSaida"             => isset($dadosRegistro['horaSaida']) ? $dadosRegistro['horaSaida'] : 'null',
                "diaEntrada"            => $dadosRegistro['diaEntrada'],
                "diaSaida"              => isset($dadosRegistro['diaSaida']) ? $dadosRegistro['diaSaida'] : 'null',
                "precoFinal"            => isset($dadosRegistro['precoFinal']) ? $dadosRegistro['precoFinal'] : 'null',
                "idVagas"               => $dadosRegistro['idVagas'],
                "idVeiculo"             => $dadosRegistro['idVeiculo']
            );

            // Import do arquivo de Model
            require_once(SRC . 'registro/model/bd/registro.php');

            // Chama e verifica sucesso da função da Model
            if (insertRegistro($arrayDados))
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
function atualizarRegistro($dadosRegistro)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosRegistro['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosRegistro)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosRegistro[0]['horaEntrada']) && !empty($dadosRegistro[0]['diaEntrada']) && !empty($dadosRegistro[0]['idVagas']) && !empty($dadosRegistro[0]['idVeiculo'])) {

            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"        => $id,
                    "horaEntrada"           => $dadosRegistro[0]['horaEntrada'],
                    "horaSaida"             => $dadosRegistro[0]['horaSaida'],
                    "diaEntrada"            => $dadosRegistro[0]['diaEntrada'],
                    "diaSaida"              => $dadosRegistro[0]['diaSaida'],
                    "precoFinal"            => $dadosRegistro[0]['precoFinal'],
                    "idVagas"               => $dadosRegistro[0]['idVagas'],
                    "idVeiculo"             => $dadosRegistro[0]['idVeiculo']

                );

                // Import do arquivo de Model
                require_once(SRC . 'registro/model/bd/registro.php');

                // Chama e verifica sucesso da função da Model
                if (updateRegistro($arrayDados)) {
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
function excluirRegistro($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'registro/model/bd/registro.php');

        // Import do arquivo de configurações do projeto
        require_once(SRC . 'modulo/config.php');

        // Chama e verifica sucesso da função da Model
        if (deleteRegistro($id)) {
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
function listarRegistro()
{

    // Import do arquivo de Model
    require_once(SRC . 'registro/model/bd/registro.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllRegistros();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarRegistro($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'registro/model/bd/registro.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdRegistro($id);

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
