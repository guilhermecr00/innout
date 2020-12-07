<?php

if ($exception) { //para verificarmos se a msg que deve ser impressa é de erro, já iniciamos testando se a $exception está setada
    $message = [ //vamos gerar uma mensagem
        'type' => 'error', //o tipo
        'message' => $exception->getMessage() //a mensagem em si
    ];
}
?>

<?php if (isset($message)) { ?>
<div role="alert" class="my-3 alert alert-danger">
    <?= $message['message']; ?>
</div>

<?php } ?>