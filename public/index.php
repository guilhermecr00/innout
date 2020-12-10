<?php
require_once(dirname(__FILE__, 2) . '/src/config/config.php'); // ATENTAR PARA O TANTO QUE 
//ESSE REQUIRE CARREGA DE ARQUIVOS, já que tem muita coisa na /src/config/config.php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) //usaremos o parse_url para decompor a uri
    //no segundo parâmetro usamos o PHP_URL_PATH para retornar esse componente específico da URL como uma string setada no path dentro do array parse_url
); //pegar o que foi passado depois da barra/
//ou seja, localhost:8080/blablá será pego o /blablá para ir a um certo endereço


if ($uri === '/' || $uri === '' || $uri === '/index.php') { //vamos forçar com que quando passado o / ou vazio, vá para a login.php
    $uri = '/login.php';
}

require_once(CONTROLLER_PATH . "/{$uri}");//se for algum dos casos acima, vai cair no login.php
//se não, irá ser chamado conforme passado no $uri, o que pode ser o days_records com o direcionamento forçado após o login