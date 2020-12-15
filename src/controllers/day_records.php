<?php
session_start();
requireValidSession(); //só será carregado caso haja uma sessão válida. Se der tudo certo, irá carregar a página day_records através da função loadTemplateView('day_records.php');

loadModel('WorkingHours');

$date = (new Datetime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date); //a diferença de obtenção do dia atual para o do método loadFromUserAndDate é que
//o primeiro precisa ser tratado para ser impresso, já o segundo será usado no BD e não suportaria esse tipo de formatação

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

loadTemplateView('day_records', [
    'today' => $today,
    'records' => $records
]);
