<?php


require_once __DIR__ . '/../../../vendor/autoload.php';

use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Anotacoes\AnotacoesPacientes;
use src\Models\Infra\Repository\Anotacoes\RepositorioAnotacoesPacientes;
use src\Models\Infra\Repository\Atividades\RepositorioAtividades;

session_start();

$limit = 10; // requisições
$time = 5;   // segundos

if (!isset($_SESSION['requests'])) {
    $_SESSION['requests'] = [];
}

$_SESSION['requests'] = array_filter(
    $_SESSION['requests'],
    fn($t) => $t > time() - $time
);

if (count($_SESSION['requests']) >= $limit) {
    http_response_code(429);
    die('Muitas requisições. Tente novamente.');
}

$_SESSION['requests'][] = time();

$pacientes = new Pacientes();
$pacientes->setPacientesPk($_POST['pk']);

$anotacaoPaciente = new RepositorioAnotacoesPacientes();
$atividadesPaciente = new RepositorioAtividades();

$anotacaoPaciente = $anotacaoPaciente->findAnotacaoByPkPacientes($pacientes);
$atividadesPaciente = $atividadesPaciente->findAllAtividadesOfPacientes($pacientes);

if($_SESSION['user']['pkPsicologo'] != $anotacaoPaciente[0]['fkPsicologo']){
    echo json_encode([
        'anotacoes' => "Você não tem permissão para acessar as anotações deste paciente.",
        'atividades' => "Você não tem permissão para acessar as atividades deste paciente."
    ], JSON_UNESCAPED_UNICODE);
    die(); 
}

echo json_encode([
    'anotacoes' => $anotacaoPaciente,
    'atividades' => $atividadesPaciente
], JSON_UNESCAPED_UNICODE);

?>