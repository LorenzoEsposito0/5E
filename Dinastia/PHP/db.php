<?php
return [
    'dsn' => 'mysql:host = localhost, dbname=Dinastia',
    'username' => 'root',
    'password' => '',
    'options' => [PDO::ERRMODE_EXCEPTION=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ]
];
?>