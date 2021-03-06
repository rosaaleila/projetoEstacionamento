<?php

 /***********************************************************************
 * Objetivo: Arquivo responsável por preparar os endpoints do email do 
 * estacionamento à serem usados como uma API pegando os dados armazenados 
 * no banco de dados e
 * retornando para quem fizer a requisição dos endpoints. 
 * 		    
 * Autora: Leila e Vinicio
 * Data: 03/06/2022
 * Versão: 1.0
 ***********************************************************************/

  //import do arquivo autoload, que fará as instancias do slim
  require_once('vendor/autoload.php');  

  //Criando um objeto do slim chamado app, para coonfigurar os endpoints(rotas)
  $app = new \Slim\App();

  $app->get('/emailestacionamento', function ($request, $response, $args) {

    // importa do arquivo de configuracao
    require_once('../modulo/config.php');
    // import da controller de contatos, que fara a busca de dados
    require_once('../estacionamento/controller/controllerEmailEstacionamento.php');

    // solicita os dados para a controller
    if ($dados = listarEmailEstacionamento()) {
      // realiza a conversao do array de dados em formato json
        if ($dadosJSON = createJSON($dados)) {
            // caso exista dados, retornamos o status code e enviamos os dados em json
            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write($dadosJSON);
        }
    } else {
        // retorna um status code caso a solicitacao dê errado
        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"idErro": "404", "message": "Não foi possivel encontrar registros."}');
    }
});

  //Endpoint Requisição para listar contatos pelo id
  $app->get('/emailestacionamento/{id}', function($request, $response, $args){
    
    //Recebe o id do registro que devera ser retornado pela api
    //Esse ID está chegando pela varável criada no endpoint
    $id = $args['id'];
     
     //import da controller de contatos, que fará a busca de dados
    require_once('../modulo/config.php');
    require_once('../estacionamento/controller/controllerEmailEstacionamento.php');
    //solicita os dados para a controller
    if($dados = buscarEmailEstacionamento($id))
    {
      if (!isset($dados['idErro'])) {
        
        //realiza a conversão do array de dados para json
      if ($dadosJSON = createJSON($dados))
        {   
            // Caso exista dados a serem retornados, informamos o statusCode 200 e
            // enviamos um JSON com todos os dados encontrados
           return $response   ->withStatus(200)
                              ->withHeader('Content-Type', 'application/json')
                              ->write($dadosJSON);
        }

      }else {
        $dadosJSON = createJSON($dados);

        return $response  ->withStatus(404)
                          ->withHeader('Content-Type', 'application/json')
                          ->write('{"message": "Dados inválidos",
                          "Erro": '.$dadosJSON.' }');
                          
      }
    }else{

      //retorna os statusCode que significa que a requisição foi aceita, porém 
      //sem conteudo de retorno
      return $response   ->withStatus(204);
                  
    }

  });

  //Endpoint Requisição para inserir um novo cliente
  $app->post('/emailestacionamento', function($request, $response, $args){
    
    //Recebe do header da requisição qual será o content type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    //Cria um array ois dependendo do content-type temos mais informações separadas
    $contentType = explode(';', $contentTypeHeader);

    switch ($contentType[0]) {
      case 'application/json':

        //Recebe os dados enviado pelo corpo da requisição
        $dadosBody = $request->getParsedBody();   
      
      //import da controller de contatos, que fará a busca de dados
      require_once('../modulo/config.php');
      require_once('../estacionamento/controller/controllerEmailEstacionamento.php');
      
      $resposta = inserirEmailEstacionamento($dadosBody);

      if (is_bool($resposta) && $resposta == true) {

        return $response   ->withStatus(201)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Email do estacionamento inserido com sucesso"}');

      } elseif (is_array($resposta) && $resposta['idErro'])        
      {
        $dadosJSON = createJSON($resposta);

        return $response   ->withStatus(400)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Erro ao inserir email do estacionamento."},
                            "Erro": '.$dadosJSON.' }');
      }     
        
        break;     
      
    }

  });

  //Endpoint Requisição para atualizar um contato, simulando o PUT
  $app->put('/emailestacionamento/{id}', function($request, $response, $args){
      
    //Recebe do header da requisição qual será o content type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    //Cria um array ois dependendo do content-type temos mais informações separadas
    $contentType = explode(';', $contentTypeHeader);

    if(is_numeric($args['id']))
    {
      
      
      //Recebe o id enviado no Endpoint atraves da vareavel ID
      $id = $args['id'];  
      
      echo($id);
      

      switch ($contentType[0]) {
        case 'application/json':
          //import da controller de contatos, que fará a busca de dados
          require_once('../modulo/config.php');
          require_once('../estacionamento/controller/controllerEmailEstacionamento.php');

          //chama a função para buscar a foto que ja está salva no banco de dados
          

          $dadosBody = $request->getParsedBody();
            
          //Cria um array com toods os dados couns e do do arquivo que será enviado para o servidor
          $arrayDados = array( $dadosBody,                               
                              "id" => $id                              
          );
        
          
          $resposta = atualizarEmailEstacionamento($arrayDados);

          if (is_bool($resposta) && $resposta == true) {

            return $response   ->withStatus(200)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Email do estacionamento atualizado com sucesso"}');

          } elseif (is_array($resposta) && $resposta['idErro'])        
          {
            $dadosJSON = createJSON($resposta);

            return $response   ->withStatus(400)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Erro ao atualizar email do estacionamento."},
                                "Erro": '.$dadosJSON.' }');
            break;      
          
          
        } 
      }
    }else
    {
      //retorna um erro que significa que o cliente passou os dados errados
      return  $response   ->withStatus(404)
                          ->withHeader('Content-Type', 'application/json')
                          ->write('{"message" : "É obrigatorio informar um ID com formato valido (número)"}');
    }
  });

  //Endpoit: Requisição para deletar um contato
  $app->delete('/emailestacionamento/{id}', function($request, $response, $args){



    if(is_numeric($args['id']))
    {
      require_once('../modulo/config.php');

      require_once('../estacionamento/controller/controllerEmailEstacionamento.php');

      //Recebe o id enviado no Endpoint atraves da vareavel ID
      $id = $args['id'];

      //Busca o nome da foto para ser excluida na coontroller
      if($resposta = excluirEmailEstacionamento($id))
      {       

        
        
        if(is_bool($resposta) && $resposta == true)
        {
          return  $response   ->withStatus(200)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Email excluido com sucesso"}');
        }elseif(is_array($resposta) && isset($resposta['idErro']))
        {
          if($resposta['idErro'] == 5)
          {
            return  $response   ->withStatus(200)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message" : "Email excluido com sucesso, porém houve um problema na exclusão da foto"}');
          }else{

          
            $dadosJSON=createJSON($resposta);

            return  $response ->withStatus(404)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Ouve um problema no processo de excluir o email do estacionamento",
                                      "Erro" : '.$dadosJSON.'}');
          }                          
        }
      }else
      {
        return  $response   ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message" : "O ID informado referente ao email do estacionamento não existe na base de dados"}');
      }
    }else
    {
      return  $response   ->withStatus(404)
                          ->withHeader('Content-Type', 'application/json')
                          ->write('{"message" : "É obrigatório informar um ID com formato válido (número)"}');
    }
    

  });

  //Executa todos os Endpoint
  $app->run();
  

?>