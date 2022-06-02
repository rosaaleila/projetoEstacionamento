<?php


  function inserirSetor ($dadosSetor){

    if(!empty($dadosSetor))
    {

      if(!empty($dadosSetor['nome']))
      {
        $arrayDados = array (
          "nome"      => $dadosSetor['nome']
      );

      require_once(SRC.'setor/model/bd/setor.php');
      if(insertSetor($arrayDados))
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
  function atualizarSetor ($dadosSetor)
  {
      
      //Recebe o id enviado pelo arrayDados
      $id = $dadosSetor['id'];

      //Validação para verificar se o objeto esta vazio
      if(!empty($dadosSetor))
      {
          //Validação de caixa vazia dos elementos nome, celular e email, 
          //pois são obrigatórios no BD
          if(!empty($dadosSetor[0]['nome']))
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
                          "nome"      => $dadosSetor[0]['nome']
                      );

                      //import do arquivo de modelagem para manipular o BD
                      require_once(SRC.'setor/model/bd/setor.php');
                      //Chama a função que fará o insert no BD (esta função esta na model)
                      if(updateSetor($arrayDados))
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
  function excluirSetor ($id)
  {
         

      //Validação para verificar se id contém um numero válido
      if($id != 0 && !empty($id) && is_numeric($id))
      {
          //import do arquivo de contato
          require_once(SRC.'setor/model/bd/setor.php');
          
          //import do arquivo de configurações do projeto
          require_once(SRC.'modulo/config.php');
          
          //Chama a função da model e valida se o retorno foi verdadeiro ou false
          if (deleteSetor($id))
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
  function listarSetor ()
  {
      //import do arquivo que vai buscar os dados no DB
      require_once(SRC.'setor/model/bd/setor.php');
      
      //chama a função que vai buscar os dados no BD
      $dados = listarAllSetores();

      if(!empty($dados))
          return $dados;
      else
          return false;
  }

  //Função para buscar um contato através do id do registro
  function buscarSetor($id)
  {
       //Validação para verificar se id contém um numero válido
       if($id != 0 && !empty($id) && is_numeric($id))
       {
           //import do arquivo de contato
          require_once(SRC.'setor/model/bd/setor.php');

          //Chama a função na model que vai buscar no BD
          $dados = selectByIdSetor($id);

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