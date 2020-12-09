<?php

//require_once(realpath(MODEL_PATH . '/User.php'));
loadModel('User');

class Login extends Model
{
    public function validate() //validando não o usuário, mas sim os campos do form
    {
        $errors = [];

        if (!$this->email) {
            $errors['email'] = 'E-mail é um campo obrigatório.';
        }

        if (!$this->password) {
            $errors['password'] = 'Por favor, informe a senha.';
        }
        if (count($errors) > 0) { //só entrará aqui se tiver sido setado algum dos errors acima
            throw new ValidationException($errors); //agora, para que possa ser carregado como ValidationException precisamos jogar a $errors dentro dela e, assim, será pega na controllers/login.php na parte do catch (AppException $e) {
            //$exception = $e e, logo em seguida, carregada na loadView(‘login’, $_POST + [‘exception’ => $exception]); Dessa maneira a views/template/messages.php terá acesso e poderá executar a div com a class bootstrap correta.
        }
    }
    //1º)Vai instanciar primeiro a Class Login, setando o e-mail e senha passados na interface de login. 
    //2º)Logo em seguida, a class User só será instanciada na variável $user se constar no BD o e-mail informado no ato de realizar o login. Se não constar, a variável $user terá valor ‘null’.
    //3º)Assim sendo, vamos utilizar o método ::getOne da Class User. Carregamos a $chave = $valor com e-mail passado pelo usuário que deseja logar(que no caso será a $this→email da Class Login). 
    //4º)Esse e-mail servirá de filtro para realizar a busca no BD e verificar se existe já algum usuário registrado com ele.
    //5º)Se tiver correto o e-mail informado, passaremos agora para verificar, com uma função nativa, se a senha informada bate com o que está na $chave password do que foi recuperado do BD.
    public function checkLogin()
    {
        $this->validate();
        $user = User::getOne(['email' => $this->email]); //A BUSCA AQUI É FEITA COM O ATRIBUTO DA Class Login instanciada na $login->email
        $errors = [];
        if ($user) { //verifica se foi encontrado algum registro no BD com o $login→email e, consequentemente, instanciada a Class User baseado no que foi informado, verificaremos o password

            if ($user->end_date) {
                throw new AppException("Usuário {$user->name} está desligado da empresa.");
            }
            if (password_verify($this->password, $user->password)) { //Vemos que o atributo e-mail da Class Login tem correspondência no BD.
                //Agora, vamos verificar se a senha também está correta. 
                return $user;
            }
            if (!password_verify($this->password, $user->password)) {
                $errors['senha'] = 'Senha incorreta. Caso tenha esquecido sua senha clique <a href="#">Aqui</a> para redefini-lá';
            }
        }
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        } else {
            throw new AppException('Usuário e senha inválidos.');
        } //tem q passar a msg pois foi assim instituído pela __construct dessa Class
    }
}