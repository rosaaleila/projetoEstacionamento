<?php

 /***********************************************************************
 * Objetivo: Arquivo responsável por preparar os endpoints do cliente à serem 
 * usados como uma API pegando os dados armazenados no banco de dados e 
 * retornando para quem fizer a requisição dos endpoints. 
 * 		    
 * Autora: Leila e Vinicio
 * Data: 03/06/2022
 * Versão: 1.0
 ***********************************************************************/

  //import do arquivo autoload, que fará as instâncias do slim
  require_once('vendor/autoload.php');  

  //Criando um objeto do slim chamado app, para coonfigurar os endpoints(rotas)
  $app = new \Slim\App();

  // lista todos os
  $app->get('/clientes', function ($request, $response, $args) {

    // importa do arquivo de configuracao
    require_once('../modulo/config.php');
    // import da controller de clientes, que fara a busca de dados
    require_once('../cliente/controller/controllerClientes.php');

    // solicita os dados da controller
    if ($dados = listarCliente()) {
      // realiza a conversão do array de dados em formato json
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
            ->write('{"idErro": "404", "message": "Não foi possivel encontrar clientes cadastrados."}');
    }
  });

  //Endpoint para listar um cliente pelo id
  $app->get('/clientes/{id}', function($request, $response, $args){
    
    //Recebe o id do cliente que devera ser retornado pela api
    $id = $args['id'];
      
    // importa do arquivo de configuracao
    require_once('../modulo/config.php');
    //import da controller de contatos, que fará a busca de dados
    require_once('../cliente/controller/controllerClientes.php');
    //solicita os dados da controller
    if($dados = buscarCliente($id))
    {
      if (!isset($dados['idErro'])) {
        
        //realiza a conversão do array de dados para JSON
      if ($dadosJSON = createJSON($dados))
        {   
          //caso exista dados, retornamos o status code e enviamos os dados em JSON
           return $response   ->withStatus(200)
                              ->withHeader('Content-Type', 'application/json')
                              ->write($dadosJSON);
        }

      }else {

        $dadosJSON = createJSON($dados);
        //retorna um status code caso a solicitacao dê errado
        return $response  ->withStatus(404)
                          ->withHeader('Content-Type', 'application/json')
                          ->write('{"message": "ID ou Cliente inválido",
                          "Erro": '.$dadosJSON.' }');
                          
      }
    }else{
      //status code que o endpoint deu certo mas não encontrou o cliente      
      return $response   ->withStatus(204);
                  
    }

  });

  //Endpoint para inserir um novo cliente
  $app->post('/clientes', function($request, $response, $args){
    
    //Recebe do header da requisição definindo qual será o content type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    //Cria um array  que dependendo do content-type teremos mais informações separadas
    $contentType = explode(';', $contentTypeHeader);

    //Verifica se o content-type é json
    switch ($contentType[0]) {
      case 'application/json':

      //Recebe os dados enviado pelo corpo da requisição
      $dadosBody = $request->getParsedBody();   
      
      // importa do arquivo de configuracao
      require_once('../modulo/config.php');
      // import da controller de clientes, que fara a busca de dados
      require_once('../cliente/controller/controllerClientes.php');
      //solicita os dados da controller
      $resposta = inserirCliente($dadosBody);

      if (is_int($resposta)) {
        //caso a solicitacao dê certo, retornamos o status code e enviamos os dados em JSON
        return $response   ->withStatus(201)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Cliente inserido com sucesso", "idCliente": '.$resposta.'}');

      } elseif (is_array($resposta) && $resposta['idErro'])        
      {

        $dadosJSON = createJSON($resposta);
        //caso a solicitacao dê errado, retornamos o status code e enviamos os dados em JSON
        return $response   ->withStatus(400)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Erro ao inserir um cliente."},
                            "Erro": '.$dadosJSON.' }');
      }             
      break;       
    }

  });

  //Endpoint para atualizar um cliente
  $app->put('/clientes/{id}', function($request, $response, $args){
      
    //Recebe do header da requisição definindo qual será o content type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    //Cria um array que dependendo do content-type teremos mais informações separadas
    $contentType = explode(';', $contentTypeHeader);

    if(is_numeric($args['id']))
    {     
      //Recebe o id do cliente que devera ser atualizado pela api
      $id = $args['id']; 
      
      switch ($contentType[0]) {
        
          case 'application/json':
          // importa do arquivo de configuracao
          require_once('../modulo/config.php');
          // import da controller de clientes, que fara a busca de dados
          require_once('../cliente/controller/controllerClientes.php');

          $dadosBody = $request->getParsedBody();
            
          //Cria um array com o id do registro que será atualizado
          $arrayDados = array( $dadosBody,                               
                              "id" => $id                              
          );
                  
          $resposta = atualizarCliente($arrayDados);

          if (is_bool($resposta) && $resposta == true) {

            return $response   ->withStatus(200)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Cliente atualizado com sucesso"}');

          } elseif (is_array($resposta) && $resposta['idErro'])        
          {
            $dadosJSON = createJSON($resposta);

            return $response   ->withStatus(400)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Erro ao atualizar o cliente."},
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

  //Endpoit deletar um cliente
  $app->delete('/clientes/{id}', function($request, $response, $args){



    if(is_numeric($args['id']))
    {
      require_once('../modulo/config.php');

      require_once('../cliente/controller/controllerClientes.php');

      //Recebe o id enviado no Endpoint atraves da vareavel ID
      $id = $args['id'];

      //Busca o nome da foto para ser excluida na coontroller
      if($resposta = excluirCliente($id))
      {       
        
        if(is_bool($resposta) && $resposta == true)
        {
          return  $response   ->withStatus(200)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Registro excluido com sucesso"}');
        }elseif(is_array($resposta) && isset($resposta['idErro']))
        { 
            $dadosJSON=createJSON($resposta);

            return  $response ->withStatus(404)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Ouve um problema no processo de excluir",
                                      "Erro" : '.$dadosJSON.'}');                         
        }
      }else
      {
        return  $response   ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message" : "O ID informado não existe na base de dados"}');
      }
    }else
    {
      return  $response   ->withStatus(404)
                          ->withHeader('Content-Type', 'application/json')
                          ->write('{"message" : "É obrigatorio informar um ID com formato valido (número)"}');
    }
    

  });

  
  $app->run();
  

?>