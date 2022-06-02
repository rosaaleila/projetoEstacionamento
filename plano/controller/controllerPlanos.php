<?php

  function inserirPlano ($dadosPlano){ 

    if(!empty($dadosPlano))
    {

      if(!empty($dadosPlano['nome']) && !empty($dadosPlano['primeiraHora']) && !empty($dadosPlano['horaAdicional']) && !empty($dadosPlano['diaria']))
      {
        $arrayDados = array (
            "nome"      => $dadosPlano['nome'],
            "primeiraHora"  => $dadosPlano['primeiraHora'],
            "horasAdicionais"  => $dadosPlano['horaAdicional'],
            "diaria"  => $dadosPlano['diaria']          
      );

      require_once(SRC.'plano/model/bd/plano.php');

      if(insertPlano($arrayDados))
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
  function atualizarPlano ($dadosPlano)
  {
      
      //Recebe o id enviado pelo arrayDados
      $id = $dadosPlano['id'];

      //Validação para verificar se o objeto esta vazio
      if(!empty($dadosPlano))
      {
          //Validação de caixa vazia dos elementos nome, celular e email, 
          //pois são obrigatórios no BD
          if(!empty($dadosPlano[0]['nome']) && !empty($dadosPlano[0]['primeiraHora']) && !empty($dadosPlano[0]['horasAdicionais']) && !empty($dadosPlano[0]['diaria']))
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
                          "nome"      => $dadosPlano[0]['nome'],
                          "primeiraHora" => $dadosPlano[0]['primeiraHora'],
                          "horasAdicionais" => $dadosPlano[0]['horasAdicionais'],
                          "diaria" => $dadosPlano[0]['diaria']
                      );

                      //import do arquivo de modelagem para manipular o BD
                      require_once(SRC.'plano/model/bd/plano.php');
                      //Chama a função que fará o insert no BD (esta função esta na model)
                      if(updatePlano($arrayDados))
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
  function excluirPlano ($id)
  {
         
      //Validação para verificar se id contém um numero válido
      if($id != 0 && !empty($id) && is_numeric($id))
      {
          //import do arquivo de contato
          require_once(SRC.'plano/model/bd/plano.php');
          
          //import do arquivo de configurações do projeto
          require_once(SRC.'modulo/config.php');
          
          //Chama a função da model e valida se o retorno foi verdadeiro ou false
          if (deletePlano($id))
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
  function listarPlano ()
  {
      //import do arquivo que vai buscar os dados no DB
      require_once(SRC.'plano/model/bd/plano.php');
      
      //chama a função que vai buscar os dados no BD
      $dados = listarAllPlanos();

      if(!empty($dados))
          return $dados;
      else
          return false;
  }

  //Função para buscar um contato através do id do registro
  function buscarPlano($id)
  {
       //Validação para verificar se id contém um numero válido
       if($id != 0 && !empty($id) && is_numeric($id))
       {
           //import do arquivo de contato
          require_once(SRC.'plano/model/bd/plano.php');

          //Chama a função na model que vai buscar no BD
          $dados = selectByIdPlano($id);

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