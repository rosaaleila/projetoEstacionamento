<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Leila
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a model (função Update)
function atualizarEstacionamento($dadosEstacionamento)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosEstacionamento['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosEstacionamento)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosEstacionamento[0]['nome']) && !empty($dadosEstacionamento[0]['logradouro']) && !empty($dadosEstacionamento[0]['numero']) && !empty($dadosEstacionamento[0]['bairro']) && !empty($dadosEstacionamento[0]['cep']) && !empty($dadosEstacionamento[0]['cidade']) && !empty($dadosEstacionamento[0]['estado'])) {

            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"            =>  $id,
                    "nome"          =>  $dadosEstacionamento['nome'],
                    "logradouro"    =>  $dadosEstacionamento['logradouro'],
                    "numero"        =>  $dadosEstacionamento['numero'],
                    "cep"           =>  $dadosEstacionamento['cep'],
                    "bairro"        =>  $dadosEstacionamento['bairro'],
                    "cidade"        =>  $dadosEstacionamento['cidade'],
                    "estado"        =>  $dadosEstacionamento['estado']
                );

                // Import do arquivo de Model
                require_once(SRC . 'estacionamento/model/bd/estacionamento.php');

                // Chama e verifica sucesso da função da Model
                if (updateEstacionamento($arrayDados)) {
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

// Função para solicitar os dados da Model e encaminhar a lista de registros para a View
function listarEstacionamento()
{

    // Import do arquivo de Model
    require_once(SRC . 'estacionamento/model/bd/estacionamento.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllEstacionamentos();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarEstacionamento($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'estacionamento/model/bd/estacionamento.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdEstacionamento($id);

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
