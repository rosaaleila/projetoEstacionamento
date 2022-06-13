<?php

 /***********************************************************************
 * Objetivo: Arquivo responsável por preparar os endpoints do cliente à serem 
 * usados como uma API pegando os dados armazenados no banco de dados e 
 * retornando para quem fizer a requisição dos endpoints. 
 * 		    
 * Autora: Leila e Vinicio
 * Data: 02/06/2022
 * Versão: 1.0
 ***********************************************************************/


  // Import do arquivo autoload, que fará as instancias do slim
  require_once('vendor/autoload.php');  

  // Criando um objeto do slim chamado app, para configurar os Endpoints
  $app = new \Slim\App();

  // Endpoint que retorna todos os Veículos de veículos
  $app->get('/veiculos', function ($request, $response, $args) {

    // importa do arquivo de configuracao
    require_once('../modulo/config.php');
    // import da controller de Veículos, que fara a busca de dados
    require_once('../veiculo/controller/controllerVeiculos.php');

    // solicita os dados para a controller
    if ($dados = listarVeiculo()) {
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
            ->write('{"idErro": "404", "message": "Não foi possivel encontrar Veículos."}');
    }
});

  // Endpoint que retorna um veículo de acordo com seu ID
  $app->get('/veiculos/{id}', function($request, $response, $args){
    
    //Recebe o id do Veículo que devera ser retornado pela api
    //Esse ID está chegando pela varável criada no endpoint
    $id = $args['id'];
     
     //import da controller de Veículos, que fará a busca de dados
    require_once('../modulo/config.php');
    require_once('../veiculo/controller/controllerVeiculos.php');
    //solicita os dados para a controller
    if($dados = buscarVeiculo($id))
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

  // Endpoint que adiciona um novo veículo ao BD
  $app->post('/veiculos', function($request, $response, $args){
    
    //Recebe do header da requisição qual será o content type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    //Cria um array ois dependendo do content-type temos mais informações separadas
    $contentType = explode(';', $contentTypeHeader);

    switch ($contentType[0]) {
      case 'application/json':

        //Recebe os dados enviado pelo corpo da requisição
        $dadosBody = $request->getParsedBody();   
      
      //import da controller de Veículos, que fará a busca de dados
      require_once('../modulo/config.php');
      require_once('../veiculo/controller/controllerVeiculos.php');
      
      $resposta = inserirVeiculo($dadosBody);

      if (is_int($resposta)) {

        return $response   ->withStatus(201)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Veículo inserido com sucesso", "idVeiculo": '.$resposta.'}');

      } elseif (is_array($resposta) && $resposta['idErro'])        
      {
        $dadosJSON = createJSON($resposta);

        return $response   ->withStatus(400)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Erro ao inserir Veículo."},
                            "Erro": '.$dadosJSON.' }');
      }     
        
        break;     
      
    }

  });
 
  // Endpoint que atualiza um veículo de acordo com seu ID
  $app->put('/veiculos/{id}', function($request, $response, $args){
      
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

          // Import do arquivo de configuração do projeto
          require_once('../modulo/config.php');
          
          // Import da controller de Veículos, que fará a busca de dados
          require_once('../veiculo/controller/controllerVeiculos.php');

          $dadosBody = $request->getParsedBody();
            
          //Cria um array com toods os dados couns e do do arquivo que será enviado para o servidor
          $arrayDados = array( $dadosBody,                               
                              "id" => $id                              
          );
          
          $resposta = atualizarVeiculo($arrayDados);

          if (is_bool($resposta) && $resposta == true) {

            return $response   ->withStatus(200)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Veículo atualizado com sucesso"}');

          } elseif (is_array($resposta) && $resposta['idErro'])        
          {
            $dadosJSON = createJSON($resposta);

            return $response   ->withStatus(400)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Erro ao atualizar Veículo."},
                                "Erro": '.$dadosJSON.' }');
            break;      
          
          
        } 
      }
    }else
    {
      //retorna um erro que significa que o cliente passou os dados errados
      return  $response   ->withStatus(404)
                          ->withHeader('Content-Type', 'application/json')
                          ->write('{"message" : "É obrigatorio informar um ID com formato válido (número)!"}');
    }
  });

  // Endpoint que deleta um veículo de acordo com seu ID
  $app->delete('/veiculos/{id}', function($request, $response, $args){

    if(is_numeric($args['id']))
    {
      require_once('../modulo/config.php');

      require_once('../veiculo/controller/controllerVeiculos.php');

      //Recebe o id enviado no Endpoint atraves da vareavel ID
      $id = $args['id'];

      //Busca o nome da foto para ser excluida na coontroller
      if($resposta = excluirVeiculo($id))
      {
        
        if(is_bool($resposta) && $resposta == true)
        {
          return  $response   ->withStatus(200)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Veículo excluido com sucesso"}');
        }elseif(is_array($resposta) && isset($resposta['idErro']))
        {
          if($resposta['idErro'] == 5)
          {
            return  $response   ->withStatus(200)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message" : "Veículo excluido com sucesso, porém houve um problema na exclusão da foto"}');
          }else{

          
            $dadosJSON=createJSON($resposta);

            return  $response ->withStatus(404)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Houve um problema no processo de excluir",
                                      "Erro" : '.$dadosJSON.'}');
          }                          
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

  // Endpoint que lista todos os veículos estacionados
  $app->get('/veiculos/estacionados/', function ($request, $response, $args) {

    // importa do arquivo de configuracao
    require_once('../modulo/config.php');
    // import da controller de Veículos, que fara a busca de dados
    require_once('../veiculo/controller/controllerVeiculos.php');

    // solicita os dados para a controller
    if ($dados = listarCarrosEstacionados()) {
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
            ->write('{"idErro": 404, "message": "Não foi possivel encontrar Veículos."}');
    }
  });

  //Executa todos os Endpoint
  $app->run();

?>