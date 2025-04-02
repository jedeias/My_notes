<?php

require_once __DIR__ . '/../vendor/autoload.php';
use src\Models\UseCases\Login\Login;

$login = new Login();
$login->Autenticacao("fernando@email.com", "senha258");
?>