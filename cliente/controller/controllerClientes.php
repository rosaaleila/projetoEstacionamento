<?php

  function inserirCliente ($dadosCliente){

    if(!empty($dadosCliente))
    {

      if(!empty($dadosCliente[0]['nome']) && !empty($dadosCliente[0]['documento']))
      {
        $arrayDados = array (
          "nome"      => $dadosCliente[0]['nome'],
          "documento"  => $dadosCliente[0]['documento']          
      );

      require_once(SRC.'model/bd/cliente.php');
      if(insertCliente($arrayDados))
                        return true;
                    else
                        return array('idErro'  => 1, 
                                     'message' => 'Não foi possivel inserir os dados no Banco de Dados');
      }else
      return array('idErro'   => 2,
                   'message'  => 'Existem campos obrigatório que não foram preenchidos.');
    }

  }

?>