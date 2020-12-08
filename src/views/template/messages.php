<?php

$errors = [];

if ($exception) { //para verificarmos se a msg que deve ser impressa é de erro, já iniciamos testando se a $exception está setada
    $message = [ //vamos gerar uma mensagem
        'type' => 'error', //o tipo
        'message' => $exception->getMessage() //a mensagem em si
    ];

    if (get_class($exception) === 'ValidationException') {
        $errors = $exception->getErrors(); //['senha'] = 'Senha incorreta.';
    }
}
?>
<?php
$alertType = '';

if (isset($message) && $message['type'] === 'error') {
    $alertType = 'danger';
} else {
    $alertType = 'sucess';
}
?>
<?php if (isset($message)) { ?>
<div role="alert" class="my-3 alert alert-<?= $alertType ?>">
    <?= $message['message']; ?>
</div>

<?php } ?>