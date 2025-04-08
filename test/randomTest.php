<?php

require_once __DIR__ . '/../vendor/autoload.php';
use src\Models\UseCases\Login\Login;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Pessoas\Secretarios;

$login = new Login();
$user = $login->Autenticacao("fernando@email.com", "senha258");

$types = [
    'Psicologo' => Psicologos::class,
    'Paciente' => Pacientes::class,
    'Secretario' => Secretarios::class,
];

foreach ($types as $type => $class) {
    if ($user instanceof $class) {
        $userConstructor = 'src\Models\Infra\Repository\Pessoas\\' .'Repositorio'. $type;     
        $userRepository = new $userConstructor();
        print_r($userRepository->findByPk($user));   
    }
}

print_r($user);

?>