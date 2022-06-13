<?php

  /*
  * $request -> Recebe dados do corpo da requisição (JSON, FORM/DATA, XML, etc)
  * $response -> Envia dados de retorno da API
  * $args -> Permite receber dados de atributos na API
  *
  * Os metodos de reposição para uma API RESTful são:
  * GET       - para buscar dados
  * POST      - para iserir um novo dado
  * DELETE    - para apagar dados
  * PUT/PATCH - para editar um dado já existente
  *             o mais utilizado é o PUT
  *
  * 
  */

  //import do arquivo autoload, que fará as instancias do slim
  require_once('vendor/autoload.php');  

  //Criando um objeto do slim chamado app, para coonfigurar os endpoints(rotas)
  $app = new \Slim\App();

  $app->get('/setores', function ($request, $response, $args) {

    // importa do arquivo de configuracao
    require_once('../modulo/config.php');
    // import da controller de Setors, que fara a busca de dados
    require_once('../setor/controller/controllerSetores.php');

    // solicita os dados para a controller
    if ($dados = listarSetor()) {
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
            ->write('{"idErro": "404", "message": "Não foi possivel encontrar Setores."}');
    }
});

  //Endpoint Requisição para listar Setors pelo id
  $app->get('/setores/{id}', function($request, $response, $args){
    
    //Recebe o id do Setor que devera ser retornado pela api
    //Esse ID está chegando pela varável criada no endpoint
    $id = $args['id'];
     
     //import da controller de Setors, que fará a busca de dados
    require_once('../modulo/config.php');
    require_once('../setor/controller/controllerSetores.php');
    //solicita os dados para a controller
    if($dados = buscarSetor($id))
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
  $app->post('/setores', function($request, $response, $args){
    
    //Recebe do header da requisição qual será o content type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    //Cria um array ois dependendo do content-type temos mais informações separadas
    $contentType = explode(';', $contentTypeHeader);

    switch ($contentType[0]) {
      case 'application/json':

        //Recebe os dados enviado pelo corpo da requisição
        $dadosBody = $request->getParsedBody();   
      
      //import da controller de Setores, que fará a busca de dados
      require_once('../modulo/config.php');
      require_once('../setor/controller/controllerSetores.php');
      
      $resposta = inserirSetor($dadosBody);

      if (is_bool($resposta) && $resposta == true) {

        return $response   ->withStatus(201)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Setor inserido com sucesso"}');

      } elseif (is_array($resposta) && $resposta['idErro'])        
      {
        $dadosJSON = createJSON($resposta);

        return $response   ->withStatus(400)
                            ->withHeader('Content-Type', 'application/json')
                            ->write('{"message":"Erro ao inserir Setor."},
                            "Erro": '.$dadosJSON.' }');
      }     
        
        break;     
      
    }

  });

  //Endpoint Requisição para atualizar um Setor, simulando o PUT
  $app->put('/setores/{id}', function($request, $response, $args){
      
    //Recebe do header da requisição qual será o content type
    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    //Cria um array ois dependendo do content-type temos mais informações separadas
    $contentType = explode(';', $contentTypeHeader);

    if(is_numeric($args['id']))
    {
    
      //Recebe o id enviado no Endpoint atraves da vareavel ID
      $id = $args['id'];  

      switch ($contentType[0]) {
        case 'application/json':
          //import da controller de Setors, que fará a busca de dados
          require_once('../modulo/config.php');
          require_once('../setor/controller/controllerSetores.php');

          $dadosBody = $request->getParsedBody();
            
          //Cria um array com toods os dados couns e do do arquivo que será enviado para o servidor
          $arrayDados = array( $dadosBody,                               
                              "id" => $id                              
          );
          
          $resposta = atualizarSetor($arrayDados);

          if (is_bool($resposta) && $resposta == true) {

            return $response   ->withStatus(200)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Setor atualizado com sucesso"}');

          } elseif (is_array($resposta) && $resposta['idErro'])        
          {
            $dadosJSON = createJSON($resposta);

            return $response   ->withStatus(400)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message":"Erro ao atualizar Setor."},
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

  //Endpoit: Requisição para deletar um Setor
  $app->delete('/setores/{id}', function($request, $response, $args){

    if(is_numeric($args['id']))
    {
      require_once('../modulo/config.php');

      require_once('../setor/controller/controllerSetores.php');

      //Recebe o id enviado no Endpoint atraves da vareavel ID
      $id = $args['id'];

      //Busca o nome da foto para ser excluida na coontroller
      if($resposta = excluirSetor($id))
      {       
        if(is_bool($resposta) && $resposta == true)
        {
          return  $response   ->withStatus(200)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Setor excluido com sucesso"}');
        }elseif(is_array($resposta) && isset($resposta['idErro']))
        {

            $dadosJSON=createJSON($resposta);

            return  $response ->withStatus(404)
                              ->withHeader('Content-Type', 'application/json')
                              ->write('{"message" : "Houve um problema no processo de excluir",
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

  //Executa todos os Endpoint
  $app->run();
  

?>