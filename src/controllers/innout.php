<?php

session_start();
requireValidSession(); //só será carregado caso haja uma sessão válida. Se der tudo certo, irá carregar a página day_records através da função loadTemplateView('day_records.php');

loadModel('WorkingHours');

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

$currentTime = strftime('%H:%M:%S', time()); //pegando a hora com time() e formatando com strftime
$records->innout($currentTime);
header('Location: day_records.php');