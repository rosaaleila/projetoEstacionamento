<?php

  /***********************************************************************
 * Objetivo: Arquivo responsável por preparar os endpoints do dia à serem 
 * usados como uma API pegando os dados armazenados no banco de dados e 
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

  $app->get('/dias', function ($request, $response, $args) {

    // importa do arquivo de configuracao
    require_once('../modulo/config.php');
    // import da controller de contatos, que fara a busca de dados
    require_once('../dia/controller/controllerDias.php');

    // solicita os dados para a controller
    if ($dados = listarDias()) {
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
  $app->get('/dias/{id}', function($request, $response, $args){
    
    //Recebe o id do registro que devera ser retornado pela api
    //Esse ID está chegando pela varável criada no endpoint
    $id = $args['id'];
     
     //import da controller de contatos, que fará a busca de dados
    require_once('../modulo/config.php');
    require_once('../dia/controller/controllerDias.php');
    //solicita os dados para a controller
    if($dados = buscarDia($id))
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

  $app->run();


?>