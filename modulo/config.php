<?php
    /**************************************************************************************
     * Objetivo: Arquivo responsavel pela criação de variaveis e constantes do projeto
     * Autor: Marcel
     * Data: 25/04/2022
     * Versão: 1.0
    ****************************************************************************************/

    
    
    define('SRC', $_SERVER['DOCUMENT_ROOT'].'/estacionamento/projetoEstacionamento/');
    
    /***********FUNÇÕES***************/
    //função para converter array para json 
    function createJSON($arrayDados){
        
        {
            // validação para tratar array sem dados, vazio.
            if (!empty($arrayDados)) {
                
                //configura o padrão de conexão para o formato JSON
                header('Content-Type: application/json');
    
                $dadosJSON = json_encode($arrayDados);
                
                //json_encode(); - converte o array para json
                //json_decode(); - converte o json para array
    
                return $dadosJSON;

            }else{
                return false;
            }
        }
        
    }
?>