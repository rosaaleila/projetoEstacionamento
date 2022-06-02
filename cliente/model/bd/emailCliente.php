<?php 

 
    // import do arquivo que estavbece a conexão com o BD
    require_once('../modulo/conexaoMySql.php');


    //Função para realizar o insert no BD
    function insertEmailCliente($dadosCliente)
    {
        //declaração de variavel para utilizar no return desta função
        $statusResposta = (boolean) false;

        //Abre aconexão com o BD
        $conexao = conexaoMysql();

        //Monta o script para enviar para o BD
        $sql = "insert into tblEmail_Cliente 
                    (email, 
                     idCliente                     
                     )
                values 
                    ('".$dadosCliente['email']."',                     
                    '".$dadosCliente['idCliente']."'
                );";

       
        //Executa o scriipt no BD
            //Validação para veririficar se o script sql esta correto
        if (mysqli_query($conexao, $sql))
        {   
            //Validação para verificar se uma linha foi acrescentada no DB
            if(mysqli_affected_rows($conexao))
                $statusResposta = true;
        }
        
        //Solicita o fechamento da conexão com o BD
        fecharConexaoMysql($conexao);

        return $statusResposta;

    }

    function listarAllEmailClientes()
    {

        // abre a conexao com o BD
        $conexao = conexaoMysql();

        // script para listar todos os dados do BD
        $sql = "select * from tblEmail_Cliente order by id desc;";

        // executa o script sql no BD e guarda o retorno dos dados (se houver)
        $result = mysqli_query($conexao, $sql);

        // valida se o BD retornou registros 
        if ($result) {

            $cont = 0;

            while ($rsDados = mysqli_fetch_assoc($result)) // é o mesmo que criar um cont, converter para array e guardar a qtd de itens
            {

                $arrayDados[$cont] = array(
                    "id"        =>  $rsDados['id'],
                    "email"      =>  $rsDados['email'],
                    "idCliente"  =>  $rsDados['idCliente']
                );
                $cont++;

            }

            // solicita o fechamento da conexao com o BD
            fecharConexaoMysql($conexao);
            
            if (isset($arrayDados))
                return $arrayDados;
            else
                return false;

        }

    }

    function selectByIdEmailCliente($id)
    {

        // abre a conexao com o BD
        $conexao = conexaoMysql();

        // script para listar todos os dados do BD em ordem decrescente
        $sql = "select * from tblEmail_Cliente where id = " . $id;

        // executa o script sql no BD e guarda o retorno dos dados (se houver)
        $result = mysqli_query($conexao, $sql);

        // valida se o BD retornou registros 
        if ($result) {

            if ($rsDados = mysqli_fetch_assoc($result)) 
            {

                $arrayDados = array(
                    "id"        =>  $rsDados['id'],
                    "email"      =>  $rsDados['email'],
                    "idCliente"  =>  $rsDados['idCliente']
                );
                
                return $arrayDados;
            } else {
                return false;
            }

            // solicita o fechamento da conexao com o BD
            fecharConexaoMysql($conexao);

        }

    }

    function updateEmailCliente($dadosCliente)
    {

        $status = (bool) false;

        //Abre a conexão com o banco de dados
        $conexao = conexaoMysql();

        //Monta o script para enviar para o BD
        $sql = "update tblEmail_Cliente set
                        email = '" . $dadosCliente['email'] . "', 
                        idCliente = '" . $dadosCliente['idCliente'] . "'
                        where id =" . $dadosCliente['id'];

        // validação para verificar se o script sql está correto
        if (mysqli_query($conexao, $sql)) {
            // validacao para verificar se uma linha foi acrescentada no BD
            if (mysqli_affected_rows($conexao))
                $status = true;
        }

        // fecha a conexao com o BD
        fecharConexaoMysql($conexao);

        return $status;

    }

    function deleteEmailCliente($id)
    {

        // abre a conexao com o BD
        $conexao = conexaoMySql();

        $status = (bool) false;

        $sql = "delete from tblEmail_Cliente where id =" . $id;

        // validação para verificar se o script sql está correto para executá-lo
        if (mysqli_query($conexao, $sql)) {

            // validacao para verificar se uma linha foi acrescentada no BD
            if (mysqli_affected_rows($conexao))
                $status = true;

        }

        // fecha a conexao com o BD
        fecharConexaoMysql($conexao);

        return $status;

    }

?>