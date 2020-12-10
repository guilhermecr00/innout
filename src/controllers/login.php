<?php
//Que hora chamar a view, que hora chamar a model? É o controller que determinará conforme a necessidade/requisição.
//VAI FAZER chamadas no model, quando necessário, e
//encaminhar para a view para ser renderizado.

//no controllers vai acontecer a instanciação da class Login e verificação
loadModel('Login');
session_start();

$exception = null; //para funcionar a messages.php

if (count($_POST) > 0) { //enviar o formulário vazio conta pq fica: array(2) { ["email"]=> string(0) "" ["password"]=> string(0) "" }, o que já conta como 2 valores dentro do array, logo maior que zero
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        $_SESSION['user'] = $user;
        header("Location:day_records.php");
    } catch (AppException $e) { //no momento q acontecer isso, será instanciado a Class AppException
        $exception = $e; //e logo em seguida setaremos a $exception, seja de desligamento ou de dados inválidos, que cairá lá na template/messages.php
        //e executará a mensagem que foi posta no AppException do models/Login.php
    }
}

loadView('login', $_POST + ['exception' => $exception]);