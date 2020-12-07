<?php

//require_once(realpath(MODEL_PATH . '/User.php'));
loadModel('User');

class Login extends Model
{ //1º)Vai instanciar primeiro a Class Login, setando o e-mail e senha passados na interface de login. 
    //2º)Logo em seguida, a class User só será instanciada na variável $user se constar no BD o e-mail informado no ato de realizar o login. Se não constar, a variável $user terá valor ‘null’.
    //3º)Assim sendo, vamos utilizar o método ::getOne da Class User. Carregamos a $chave = $valor com e-mail passado pelo usuário que deseja logar(que no caso será a $this→email da Class Login). 
    //4º)Esse e-mail servirá de filtro para realizar a busca no BD e verificar se existe já algum usuário registrado com ele.
    //5º)Se tiver correto o e-mail informado, passaremos agora para verificar, com uma função nativa, se a senha informada bate com o que está na $chave password do que foi recuperado do BD.
    public function checkLogin()
    {
        $user = User::getOne(['email' => $this->email]); //A BUSCA AQUI É FEITA COM O ATRIBUTO DA Class Login instanciada na $login->email
        if ($user) { //verifica se foi encontrado algum registro no BD com o $login→email e, consequentemente, instanciada a Class User baseado no que foi informado, verificaremos o password

            if ($user->end_date) {
                throw new AppException("Usuário {$user->name} está desligado da empresa.");
            }
            if (password_verify($this->password, $user->password)) { //Vemos que o atributo e-mail da Class Login tem correspondência no BD.
                //Agora, vamos verificar se a senha também está correta. 
                return $user;
            }
        }
        throw new AppException('Usuário e senha inválidos.'); //tem q passar a msg pois foi assim instituído pela __construct dessa Class
    }
}