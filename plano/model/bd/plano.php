<?php 

 
    // import do arquivo que estavbece a conexão com o BD
    require_once('../modulo/conexaoMySql.php');

    //Função para realizar o insert no BD
    function insertPlano($dadosPlano)
    {
        //declaração de variavel para utilizar no return desta função
        $statusResposta = (boolean) false;

        //Abre aconexão com o BD
        $conexao = conexaoMysql();

        //Monta o script para enviar para o BD
        $sql = "insert into tblPlano 
                    (nome, 
                     primeiraHora,
                     horasAdicionais,
                     diaria                     
                     )
                values 
                    ('".$dadosPlano['nome']."',   
                    '".$dadosPlano['primeiraHora']."',
                    '".$dadosPlano['horasAdicionais']."',                  
                    '".$dadosPlano['diaria']."'
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

    function listarAllPlanos()
    {

        // abre a conexao com o BD
        $conexao = conexaoMysql();

        // script para listar todos os dados do BD
        $sql = "select * from tblPlano order by id desc;";

        // executa o script sql no BD e guarda o retorno dos dados (se houver)
        $result = mysqli_query($conexao, $sql);

        // valida se o BD retornou registros 
        if ($result) {

            $cont = 0;

            while ($rsDados = mysqli_fetch_assoc($result)) // é o mesmo que criar um cont, converter para array e guardar a qtd de itens
            {

                $arrayDados[$cont] = array(
                    "id"        =>  $rsDados['id'],
                    "nome"      =>  $rsDados['nome'],
                    "primeiraHora"  =>  $rsDados['primeiraHora'],
                    "horaAdicional"  =>  $rsDados['horasAdicionais'],
                    "diaria"  =>  $rsDados['diaria']
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

    function selectByIdPlano($id)
    {

        // abre a conexao com o BD
        $conexao = conexaoMysql();

        // script para listar todos os dados do BD em ordem decrescente
        $sql = "select * from tblPlano where id = " . $id;

        // executa o script sql no BD e guarda o retorno dos dados (se houver)
        $result = mysqli_query($conexao, $sql);

        // valida se o BD retornou registros 
        if ($result) {

            if ($rsDados = mysqli_fetch_assoc($result)) 
            {

                $arrayDados = array(
                    "id"        =>  $rsDados['id'],
                    "nome"      =>  $rsDados['nome'],
                    "primeiraHora"  =>  $rsDados['primeiraHora'],
                    "horaAdicional"  =>  $rsDados['horasAdicionais'],
                    "diaria"  =>  $rsDados['diaria']
                );
                
                return $arrayDados;
            } else {
                return false;
            }

            // solicita o fechamento da conexao com o BD
            fecharConexaoMysql($conexao);

        }

    }

    function updatePlano($dadosPlano)
    {

        $status = (bool) false;

        //Abre a conexão com o banco de dados
        $conexao = conexaoMysql();

        //Monta o script para enviar para o BD
        $sql = "update tblPlano set
                        nome = '" . $dadosPlano['nome'] . "', 
                        primeiraHora = " . $dadosPlano['primeiraHora'] . ",
                        horasAdicionais = " . $dadosPlano['horasAdicionais'] . ", 
                        diaria = " . $dadosPlano['diaria'] . " 
                        where id =" . $dadosPlano['id'];

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

    function deletePlano($id)
    {

        // abre a conexao com o BD
        $conexao = conexaoMySql();

        $status = (bool) false;

        $sql = "delete from tblPlano where id =" . $id;

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