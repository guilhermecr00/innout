<?php

require_once(realpath(MODEL_PATH . '/Model.php'));

class User extends Model
{
    protected static $tableName = 'users'; //static para poder ser igual à todas as instâncias e com o mesmo valor
    protected static $columns = [ // as colunas que estarão disponíveis na tabela users
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin'
    ];
}
