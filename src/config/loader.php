<?php
//Criar algumas funções que nos ajudarão a carregar as Classes.

function loadModel($modelName)
{
    require_once(MODEL_PATH . "/{$modelName}.php");
}

function loadView($viewName, $params = array())
{
    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            if (strlen($key) > 0) { //se a chave for uma string válida
                //'listaDeUsuarios'
                //na view vai ser: $listaDeUsuarios
                ${$key} = $value; //estamos criando uma variável com o mesmo nome da chave que foi feita pelo foreach
            }
        }
    }
    require_once(VIEW_PATH . "/{$viewName}.php");
}