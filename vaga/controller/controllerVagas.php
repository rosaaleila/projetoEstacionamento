<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Vinicio
 * Data: 01/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a Model (função Insert)
function inserirVaga($dadosVaga)
{
    // Validação para verificar se o objeto está vazio
    if (!empty($dadosVaga)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosVaga['numero']) && !empty($dadosVaga['idSetor']) && !empty($dadosVaga['idEstacionamento']) && !empty($dadosVaga['idPlano'])) {

            // Criação do array de dados que será encaminhado para a Model
            $arrayDados = array(
                'numero' => $dadosVaga['numero'],
                'idSetor' => $dadosVaga['idSetor'],
                'idEstacionamento' => $dadosVaga['idEstacionamento'],
                'idPlano' => $dadosVaga['idPlano']
            );               

            // Import do arquivo de Model
            require_once(SRC . 'vaga/model/bd/vaga.php');

            // Chama e verifica sucesso da função da Model
            if (insertVaga($arrayDados))
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
function atualizarVaga($dadosVaga)
{
    

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosVaga['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosVaga)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosVaga[0]['numero']) && !empty($dadosVaga[0]['idSetor']) && !empty($dadosVaga[0]['idEstacionamento']) && !empty($dadosVaga[0]['idPlano'])) {

            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"        => $id,
                    "numero"    => $dadosVaga[0]['numero'],
                    "idSetor"   => $dadosVaga[0]['idSetor'],
                    "idEstacionamento" => $dadosVaga[0]['idEstacionamento'],
                    "idPlano"   => $dadosVaga[0]['idPlano']                    
                );

                // Import do arquivo de Model
                require_once(SRC . 'vaga/model/bd/vaga.php');

                // Chama e verifica sucesso da função da Model
                if (updateVaga($arrayDados)) {
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
function excluirVaga($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'vaga/model/bd/vaga.php');

        // Import do arquivo de configurações do projeto
        require_once(SRC . 'modulo/config.php');

        // Chama e verifica sucesso da função da Model
        if (deleteVaga($id)) {
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
function listarVaga()
{

    // Import do arquivo de Model
    require_once(SRC . 'vaga/model/bd/vaga.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllVagas();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarVaga($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'vaga/model/bd/vaga.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdVaga($id);

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

function buscarVagasLivres() {

    // Import do arquivo de Model
    require_once(SRC . 'vaga/model/bd/vaga.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = selectVagasDisponiveis();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;

}

// Função para solicitar os dados da Model e encaminhar a lista de registros para a View
function listarVagasLivres()
{

    // Import do arquivo de Model
    require_once(SRC . 'vaga/model/bd/vaga.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarVagasDisponiveis();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}