<?php

function listarDias ()
{
    //import do arquivo que vai buscar os dados no DB
    require_once(SRC.'dia/model/bd/dia.php');
    
    //chama a função que vai buscar os dados no BD
    $dados = listarAllDias();

    if(!empty($dados))
        return $dados;
    else
        return false;
}

  //Função para buscar um contato através do id do registro
  function buscarDia($id)
  {
       //Validação para verificar se id contém um numero válido
       if($id != 0 && !empty($id) && is_numeric($id))
       {
           //import do arquivo de contato
          require_once(SRC.'dia/model/bd/dia.php');

          //Chama a função na model que vai buscar no BD
          $dados = selectByIdDia($id);

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