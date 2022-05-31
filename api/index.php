<?php

  /********************************************************************************************************
   *Objetivo: Arquivo Prncipal da API que irá receber a URL requisitada e redirecionar para as APIs(router)                                                                          *
   *Autor:Vinicio
   *Data:19/05/2022
   *Versão:1.0                                                                                                                                                                                    *
   *******************************************************************************************************/
  
  
  
  
  
  //permite ativar quais endereços de sites que poderão fazer requisições na API (* libera para todos os sites)
  header('Access-Control-Allow-Origin: *');
  //permite ativar os métodos do protocolo HTTP que irão requisitar a API
  header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
  //permite ativar o Content-type das requisições (formato de dados que será utilizado(JSON, XML,FORM/DATA,etc ))
  header('Access-Control-Allow-Header: Content-Type');
  //permite liberar quais content-type serão utilizados na API
  header('Content-Type: application/json');

  //Recebe a URL digitada na requisição
  $urlHTTP = (string) $_GET['url'];
  
  //Converte a URL requisitadaa em um array para dividir as opçoes de busca, que é separada pelo "/"
  $url = explode('/', $urlHTTP);
  
  //o utl vem um array então tem que dar no indice 0
  // verifica qual API será encaminhada a requisição (contatos, estados, etc)
  switch (strtoupper($url[0])) {
    case 'CONTATOS':
      require_once('contatosAPI/index.php');
      break;
    
    case 'ESTADOS':
      require_once('estadosAPI/index.php');
      break;
  }


?>