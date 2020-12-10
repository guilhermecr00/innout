<?php

function requireValidSession()
{
    $user = $_SESSION['user']; //pegando um usuário da sessão
    if (!isset($user)) { //testando se não estiver setado será redirecionado para a login.php
        header('Location: login.php');
        exit(); //garantir que nada mais será renderizado
    }
}