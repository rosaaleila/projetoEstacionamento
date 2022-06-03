<?php

/***********************************************************************
 * Objetivo: Arquivo responsável pela manipulação de dados de planos.
 * 		    Obs.: Este arquivo fará a ponte entre a View e a Model.
 * Autora: Leila
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/

// Função para receber dados da View e encaminhar para a model (função Update)
function atualizarFuncionamento($dadosFuncionamento)
{

    // Recebe o ID enviado pelo array de parâmetro
    $id = $dadosFuncionamento['id'];

    // Validação para verificar se o objeto está vazio
    if (!empty($dadosFuncionamento)) {

        // Validação para verificar se o objeto contém os dados obrigatórios
        if (!empty($dadosFuncionamento[0]['horaAbertura']) && !empty($dadosFuncionamento[0]['horaFechamento']) && !empty($dadosFuncionamento[0]['idEstacionamento']) && !empty($dadosFuncionamento[0]['idDia'])) {

            //Validação para verificar se o ID é válido
            if (!empty($id) && $id != 0 && is_numeric($id)) {

                // Criação do array de dados que será encaminhado para a Model
                $arrayDados = array(
                    "id"                =>  $id,
                    "horaAbertura"      =>  $dadosFuncionamento[0]['horaAbertura'],
                    "horaFechamento"    =>  $dadosFuncionamento[0]['horaFechamento'],
                    "idEstacionamento"  =>  $dadosFuncionamento[0]['idEstacionamento'],
                    "idDia"             =>  $dadosFuncionamento[0]['idDia']
                );

                // Import do arquivo de Model
                require_once(SRC . 'funcionamento/model/bd/funcionamento.php');

                // Chama e verifica sucesso da função da Model
                if (updateFuncionamento($arrayDados)) {
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
function listarFuncionamento()
{

    // Import do arquivo de Model
    require_once(SRC . 'funcionamento/model/bd/funcionamento.php');

    // Solicita a função que vai buscar os dados no BD e armazena o retorno
    $dados = listarAllFuncionamentos();

    // Verifica se os dados tragos pela Model estão vazios para então retorná-los
    if (!empty($dados))
        return $dados;
    else
        return false;
}

// Função para buscar um registro através do seu ID
function buscarFuncionamento($id)
{

    // Validação para verificar se o ID é válido
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        // Import do arquivo de Model
        require_once(SRC . 'funcionamento/model/bd/funcionamento.php');

        // Solicita a função que vai buscar os dados no BD e armazena o retorno
        $dados = selectByIdFuncionamento($id);

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
