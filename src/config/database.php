<?php
class Database
{ //PQ ELE NÃO FEZ COM PDO?

    public static function getConecction()
    { //1º classe que vai estabelecer a conexão com o BD

        $envPath = realpath(dirname(__FILE__) . '/../env.ini'); // variável que vai possuir a pasta que está o arquivo env.ini
        //realpath() - retorna o path absoluta canonicalizado
        //dirname() - retorna o caminho/path do diretório pai
        $env = parse_ini_file($envPath); //função que interperta um arquivo de configuração
        $conn = new mysqli(
            $env['host'],
            $env['username'],
            $env['password'],
            $env['database']
        ); //parametros q estão no env.ini e instanciando a conexão

        if ($conn->connect_error) { //tratando o possível erro na conexão
            die("Erro: " . $conn->connect_error);
        }

        return $conn; //tem que ter isso para poder acessar os métodos/atributos da classe mysqli
    }

    public static function getResultFromQuery($sql)
    { //2º - consultar e retornar o resultado
        //para executar a query DE CONSULTAS

        $conn = self::getConecction(); //estabelecendo a conexão
        $result = $conn->query($sql); //executando a sql e atribuindo o resultado à variável $result
        $conn->close(); //fechando a conexão;
        return $result; //retornando o resultado

    }
    public static function executeSQL($sql)
    { //vai executar uma sql
        $conn = self::getConecction();
        if (!mysqli_query($conn, $sql)) { //se esse método retornar falso, isso quer dizer q houve um problema e, então, vamos lançar um exceção
            throw new Exception((mysqli_error($conn))); //que passará a mensagem de erro
        } //usando o método nativo do mysqli_insert_id
        $id = $conn->insert_id; //por padrão, quando se insere algum dado, é desejado que retorne o id do usuário que foi executado a query
        $conn->close();
        return $id;
    }
}