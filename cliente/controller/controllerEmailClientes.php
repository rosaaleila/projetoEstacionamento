<?php


  function inserirEmailCliente ($dadosEmailCliente){

    if(!empty($dadosEmailCliente))
    {

      if(!empty($dadosEmailCliente['email']) && !empty($dadosEmailCliente['idCliente']))
      {
        $arrayDados = array (
          "email"      => $dadosEmailCliente['email'],
            "idCliente"  => $dadosEmailCliente['idCliente']          
      );

      require_once(SRC.'cliente/model/bd/emailCliente.php');
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



  //Função para receber dados da View e encaminhar para a model (Atualizar)
  function atualizarEmailCliente ($dadosEmailCliente)
  {
      
      //Recebe o id enviado pelo arrayDados
      $id = $dadosEmailCliente['id'];

      //Validação para verificar se o objeto esta vazio
      if(!empty($dadosEmailCliente))
      {
          //Validação de caixa vazia dos elementos email, celular e email, 
          //pois são obrigatórios no BD
          if(!empty($dadosEmailCliente[0]['email']) && !empty($dadosEmailCliente[0]['idCliente']))
              {
                  //Validação para garantir que id seja válido
                  if(!empty($id) && $id != 0 && is_numeric($id))
                  {
                      

                      //Criação do array de dados que será encaminhado a model
                      //para inserir no BD, é importante criar este array conforme
                      //as necessidades de manipulação do BD.
                      //OBS: criar as chaves do array conforme os emails dos atributos
                          //do BD
                      $arrayDados = array (
                          "id"        => $id,
                          "email"      => $dadosEmailCliente[0]['email'],
                          "idCliente" => $dadosEmailCliente[0]['idCliente']
                      );

                      //import do arquivo de modelagem para manipular o BD
                      require_once(SRC.'cliente/model/bd/emailCliente.php');
                      //Chama a função que fará o insert no BD (esta função esta na model)
                      if(updateCliente($arrayDados))
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
  function excluirEmailCliente ($id)
  {
         

      //Validação para verificar se id contém um numero válido
      if($id != 0 && !empty($id) && is_numeric($id))
      {
          //import do arquivo de contato
          require_once(SRC.'cliente/model/bd/emailCliente.php');
          
          //import do arquivo de configurações do projeto
          require_once(SRC.'modulo/config.php');
          
          //Chama a função da model e valida se o retorno foi verdadeiro ou false
          if (deleteCliente($id))
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
  function listarEmailCliente ()
  {
      //import do arquivo que vai buscar os dados no DB
      require_once(SRC.'cliente/model/bd/emailCliente.php');
      
      //chama a função que vai buscar os dados no BD
      $dados = listarAllEmailClientes();

      if(!empty($dados))
          return $dados;
      else
          return false;
  }

  //Função para buscar um contato através do id do registro
  function buscarEmailCliente($id)
  {
       //Validação para verificar se id contém um numero válido
       if($id != 0 && !empty($id) && is_numeric($id))
       {
           //import do arquivo de contato
          require_once(SRC.'cliente/model/bd/emailCliente.php');

          //Chama a função na model que vai buscar no BD
          $dados = selectByIdEmailCliente($id);

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