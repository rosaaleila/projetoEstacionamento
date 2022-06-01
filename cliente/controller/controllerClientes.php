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

      require_once(SRC.'cliente/model/bd/cliente.php');
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
  function atualizarCliente ($dadosCliente)
  {
      
      //Recebe o id enviado pelo arrayDados
      $id = $dadosCliente['id'];

      //Validação para verificar se o objeto esta vazio
      if(!empty($dadosCliente))
      {
          //Validação de caixa vazia dos elementos nome, celular e email, 
          //pois são obrigatórios no BD
          if(!empty($dadosCliente[0]['nome']) && !empty($dadosCliente[0]['documento']))
              {
                  //Validação para garantir que id seja válido
                  if(!empty($id) && $id != 0 && is_numeric($id))
                  {
                      

                      //Criação do array de dados que será encaminhado a model
                      //para inserir no BD, é importante criar este array conforme
                      //as necessidades de manipulação do BD.
                      //OBS: criar as chaves do array conforme os nomes dos atributos
                          //do BD
                      $arrayDados = array (
                          "id"        => $id,
                          "nome"      => $dadosCliente[0]['nome'],
                          "documento" => $dadosCliente[0]['documento']
                      );

                      //import do arquivo de modelagem para manipular o BD
                      require_once(SRC.'cliente/model/bd/cliente.php');
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
  function excluirContato ($id)
  {
         

      //Validação para verificar se id contém um numero válido
      if($id != 0 && !empty($id) && is_numeric($id))
      {
          //import do arquivo de contato
          require_once(SRC.'cliente/model/bd/cliente.php');
          
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
  function listarCliente ()
  {
      //import do arquivo que vai buscar os dados no DB
      require_once(SRC.'cliente/model/bd/cliente.php');
      
      //chama a função que vai buscar os dados no BD
      $dados = listarAllClientes();

      if(!empty($dados))
          return $dados;
      else
          return false;
  }

  //Função para buscar um contato através do id do registro
  function buscarCliente($id)
  {
       //Validação para verificar se id contém um numero válido
       if($id != 0 && !empty($id) && is_numeric($id))
       {
           //import do arquivo de contato
          require_once(SRC.'cliente/model/bd/cliente.php');

          //Chama a função na model que vai buscar no BD
          $dados = selectByIdCliente($id);

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