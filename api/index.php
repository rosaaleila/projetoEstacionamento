<?php

  /********************************************************************************************************
   *Objetivo: Arquivo Prncipal da API que irá receber a URL requisitada e redirecionar para as APIs(router)                                                                          *
   *Autor:Vinicio
   *Data:19/05/2022
   *Versão:1.0                                                                                                                                                                                    *
   *******************************************************************************************************/
  
    // permite ativar quais enderecos de sites que poderao fazer requisições na api (* = todos)
    header('Access-Control-Allow-Origin: *');

    // permite definir quais metodos serao aceitos pela api 
    header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
    
    // permite ativar o content-type (formato de dados que sera utilizado (JSON, XML, FORM/DATA...)) das requisicoes 
    header('Access-Control-Allow-Header: Content-Type');
    
    // permite definir quais os tipos de content type que serao aceitos 
    header('Content-Type: application/json');

  //Recebe a URL digitada na requisição
  $urlHTTP = (string) $_GET['url'];
  
  //Converte a URL requisitadaa em um array para dividir as opçoes de busca, que é separada pelo "/"
  $url = explode('/', $urlHTTP);
  
  //o utl vem um array então tem que dar no indice 0
  // verifica qual API será encaminhada a requisição (contatos, estados, etc)
  switch (strtoupper($url[0])) {
    case 'CLIENTES':
      require_once('clienteAPI/index.php');
      break;
    
    case 'EMAILCLIENTES':
      require_once('emailCliente/index.php');
      break;
    
    case 'TELEFONECLIENTES':
      require_once('telefoneCliente/index.php');
      break;

    case 'VEICULOS':
      require_once('veiculoAPI/index.php');
      break;

    case 'SETORES':
      require_once('setorAPI/index.php');
      break;
    
    case 'DIAS':
      require_once('diaAPI/index.php');
      break;
    
    case 'PLANOS':
      require_once('planoAPI/index.php');
      break;

    case 'VAGAS':
      require_once('vagaAPI/index.php');
      break;
    
    case 'ESTACIONAMENTOS':
      require_once('estacionamentoAPI/index.php');
      break;
  }
