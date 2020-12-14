<?php
class Model
{
    //definir 2 
    protected static $tableName = ''; // Aqui serão definidas de maneira geral, para no User.php ser definida mais específica(ou em qualquer outro lugar que precise realizar consultas)
    protected static $columns = []; //static para poder ser igual à todas as instâncias e com o mesmo valor
    protected $values = []; // não é estático pois cada instância terá o seu próprio $values

    function __construct($arr)
    {
        $this->loadFromArray($arr); //pq carregar assim em array associativo(chave=>valor)?
        //"a ideia aqui é passar um array associativo no constructor, e uma vez passado esse array associativo, ele vai setar esses dados internamente"
        //então, por ser associativo, os valores carregados - sem array estariam "soltos - vão ser setadado conforme a chave/valor.
    }

    public function loadFromArray($arr)
    {
        if ($arr) {
            foreach ($arr as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function __get($key) //com os métodos mágicos o acesso fica direto
    {
        return $this->values[$key];
    }

    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public static function getOne($filters = [], $columns = '*') //pegar um único registro
    { //a diferença é que seu retorno não é um array de objetos - $objects = [], como no caso da getAll.
        //O seu retorno será de um único registro, no sentido que será passado um $filters para que seja feita a comparação entre
        //o que há no BD e no $_POST passado pelo usuário que deseja entrar na sua conta
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);

        return $result ? new $class($result->fetch_assoc()) : null;
        //teve resultado a query? Se sim, crie uma Class
        //com os dados obtidos por meio da query e retorne-a
        //Se não tiver resultado, retorne null
    }

    public static function get($filters = [], $columns = '*') //getAll
    {
        $objects = []; //não vou retornar as linhas sem associação do ::getResultSetFromSelect e sim os objetos da class que chamou esse método
        //Qual a vantagem de fazer isso? O retorno será organizado em chave/valor e também por estar numa class será possível usar
        //os métodos que ela dispõe
        $result = static::getResultSetFromSelect($filters, $columns);
        if ($result) { // agora para organizar o $result bruto obtido, vamos dar chave/valor a ele com o fetch_assoc()
            // e também instanciá-lo numa CLass com o retorno dentro de um Objeto
            $class = get_called_class(); //determinar qual CLass chamou a função
            while ($row = $result->fetch_assoc()) { //pegando cada uma das linhas em array associativo
                //a row é um array, já que no __construct foi determinado que as variáveis seriam inseridas desta maneira
                //e adicionando no $object e criar uma classe,
                //e esse objeto vai ser criado, vai ser um objeto da Class q foi chamada
                //de maneira que o resultado do User::get(['id' => 1], 'name, email');
                //vai ser um array com todos os objetos do tipo User que eu obtive a partir da consulta no BD
                array_push($objects, new $class($row)); //passando aqui o q foi recebido através da consulta no BD.
            }
        }
        return $objects; //se não tiver nada, vai retornar vazio []
    }

    public static function getResultSetFromSelect($filters = [], $columns = '*') //basicamente, um método que é MODELO de select para as outras class. Então, ele é bem genérico e dinâmico
    { //esse método volta o $result mais "puro"
        $sql = "SELECT ${columns} FROM "
            . static::$tableName //deixando o método mais dinâmico, já que se for chamada pelo User ela já estará setada em sua própria assim class, assim como se for por outra tbm terá sua própria
            . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql); //vamos chamar o método do Database QUE EXECUTA QUERYS
        if ($result->num_rows === 0) { //iremos verificar a $result usando o método mysqli::num_rows
            return null; //se não tiver linhas
        } else {
            return $result; // se tiver resultado, voltar o $result "bruto", sem estar em um "array associativo
            // ou com as colunas identificadas com cada valor
        }
    }

    public function insert()
    { //gerar o comando SQL para fazer a inserção
        $sql = "INSERT INTO " . static::$tableName . " ("
            . implode(",", static::$columns) . ") VALUES ("; //implode() =pega um array e transforma em string e as concatena de acordo com um separador declarado
        foreach (static::$columns as $col) { //para pegar os valores associados a cada coluna
            $sql .= static::getFormatedValue($this->$col) . ","; //já que o acesso a esse método acontecerá já por uma instância da class e, dessa maneira, podemos acessar ao atributo da instância através do $this->atributo. 

        } //vai ficar sobrando uma vírgula e precisamos fechar a sql com um parênteses, para isso:
        $sql[strlen($sql) - 1] = ')'; //acessando o último elemento da string. A última vírgula que ficou no foreach será substituída por um )
        $id = Database::executeSQL($sql); //pegando o id do usuário obtido através do insert_id que está no executesql e atribuindo a ele a variável $id.
        $this->id = $id; //agora setando o atributo id da instância atual da class declarada para o id recebido pela query executada
    }

    private static function getFilters($filters) //CONCATENAR FILTROS
    {
        $sql = '';
        if (count($filters) > 0) { //Atenção: para montar o WHERE com mais 2 $filters terá o AND no meio deles. Assim, usa-se o WHERE 1=1
            $sql .= " WHERE 1 = 1";
            foreach ($filters as $columns => $value) {
                $sql .= "  AND ${columns} = " . static::getFormatedValue($value); //TEM Q TRATAR OS VALORES, para isso, criar um método
            }
        }
        return $sql;
    }
    private static function getFormatedValue($value) //FORMATAR O VALOR quando concatenado
    {
        if (is_null($value)) {
            return "null";
        } elseif (gettype($value) === 'string') {
            return "'${value}'"; //'email'
        } else {
            return $value;
        }
    }
}