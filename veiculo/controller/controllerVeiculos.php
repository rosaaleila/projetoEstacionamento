<?php


  function inserirVeiculo ($dadosVeiculo){

    if(!empty($dadosVeiculo))
    {

      if(!empty($dadosVeiculo['placa']) && !empty($dadosVeiculo['idCliente']))
      {
        $arrayDados = array (
          "placa"      => $dadosVeiculo['placa'],
            "idCliente"  => $dadosVeiculo['idCliente']          
      );

      require_once(SRC.'veiculo/model/bd/veiculo.php');
      if(insertVeiculo($arrayDados))
                       return true;
                    else
                        return array('idErro'  => 1, 
                                     'message' => 'Não foi possivel inserir os dados no Banco de Dados');
      }else
      return array('idErro'   => 2,
                   'message'  => 'Existem campos obrigatório que não foram preenchidos.');
    }

  }



  //Função para receber dados da View e encaminhar para a model (Atualizar)
  function atualizarVeiculo ($dadosVeiculo)
  {
      
      //Recebe o id enviado pelo arrayDados
      $id = $dadosVeiculo['id'];

      //Validação para verificar se o objeto esta vazio
      if(!empty($dadosVeiculo))
      {
          //Validação de caixa vazia dos elementos placa, celular e email, 
          //pois são obrigatórios no BD
          if(!empty($dadosVeiculo[0]['placa']) && !empty($dadosVeiculo[0]['idCliente']))
              {
                  //Validação para garantir que id seja válido
                  if(!empty($id) && $id != 0 && is_numeric($id))
                  {
                      

                      //Criação do array de dados que será encaminhado a model
                      //para inserir no BD, é importante criar este array conforme
                      //as necessidades de manipulação do BD.
                      //OBS: criar as chaves do array conforme os placas dos atributos
                          //do BD
                      $arrayDados = array (
                          "id"        => $id,
                          "placa"      => $dadosVeiculo[0]['placa'],
                          "idCliente" => $dadosVeiculo[0]['idCliente']
                      );

                      //import do arquivo de modelagem para manipular o BD
                      require_once(SRC.'veiculo/model/bd/veiculo.php');
                      //Chama a função que fará o insert no BD (esta função esta na model)
                      if(updateVeiculo($arrayDados))
                      {                          
                          return true;
                      }
                      else
                          return array('idErro'  => 1, 
                                      'message' => 'Não foi possivel atualizar os dados no Banco de Dados');
                  }else
                      return array('idErro'   => 4,
                                   'message'  => 'Não é possível editar um registro sem informar um id válido.'
                              );
              }
                  
          else
              return array('idErro'   => 2,
                           'message'  => 'Existem campos obrigatório que não foram preenchidos.');
      }
  }

  //Função para realizar a exclusão de um contato
  function excluirVeiculo ($id)
  {
         

      //Validação para verificar se id contém um numero válido
      if($id != 0 && !empty($id) && is_numeric($id))
      {
          //import do arquivo de contato
          require_once(SRC.'veiculo/model/bd/veiculo.php');
          
          //import do arquivo de configurações do projeto
          require_once(SRC.'modulo/config.php');
          
          //Chama a função da model e valida se o retorno foi verdadeiro ou false
          if (deleteVeiculo($id))
          {
              
             return true;  

          }
          else
              return array('idErro'   => 3,
                           'message'  => 'O banco de dados não pode excluir o registro.'
              );
      }else
          return array('idErro'   => 4,
                       'message'  => 'Não é possível excluir um registro sem informar um id válido.'
      );

  }

  //Função para solicitar os dados da model e encaminhar a lista 
  //de contatos para a View
  function listarVeiculo ()
  {
      //import do arquivo que vai buscar os dados no DB
      require_once(SRC.'veiculo/model/bd/veiculo.php');
      
      //chama a função que vai buscar os dados no BD
      $dados = listarAllVeiculos();

      if(!empty($dados))
          return $dados;
      else
          return false;
  }

  //Função para buscar um contato através do id do registro
  function buscarVeiculo($id)
  {
       //Validação para verificar se id contém um numero válido
       if($id != 0 && !empty($id) && is_numeric($id))
       {
           //import do arquivo de contato
          require_once(SRC.'veiculo/model/bd/veiculo.php');

          //Chama a função na model que vai buscar no BD
          $dados = selectByIdVeiculo($id);

          //Valida se existem dados para serem devolvidos
          if(!empty($dados))
              return $dados;
          else
              return false;

       }else
          return array('idErro'   => 4,
                          'message'  => 'Não é possível buscar um registro sem informar um id válido.'
          );
  }
?>