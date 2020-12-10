<?php
session_start(); //acessar a $_SESSION
session_destroy(); //destruir a sessão
header('Location: login.php');