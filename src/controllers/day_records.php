<?php
session_start();
requireValidSession(); //só será carregado caso haja uma sessão válida. Se der tudo certo, irá carregar a página day_records através da função loadTemplateView('day_records.php');

loadModel('WorkingHours');

$date = (new Datetime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

loadTemplateView('day_records', [
    'today' => $today,
    'records' => $records
]);