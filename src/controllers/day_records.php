<?php
session_start();
requireValidSession(); //só será carregado caso haja uma sessão válida. Se der tudo certo, irá carregar a página day_records através da função loadTemplateView('day_records.php');

$date = (new Datetime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

loadTemplateView('day_records', ['today' => $today]);