<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Infra\Repository\Anotacoes\RepositorioAnotacoesPacientes;
use src\Models\Infra\Repository\Atividades\RepositorioAtividades;
use src\Models\Infra\Security\AES\CryptoService;

session_start();

$limit = 10;
$time = 5;

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

$repoAnotacao = new RepositorioAnotacoesPacientes();
$repoAtividades = new RepositorioAtividades();
$crypto = new CryptoService();

$anotacaoPaciente = $repoAnotacao->findAnotacaoByPkPacientes($pacientes);
$atividadesPaciente = $repoAtividades->findAllAtividadesOfPacientes($pacientes);

if (
    !empty($anotacaoPaciente) &&
    $_SESSION['user']['pkPsicologo'] != $anotacaoPaciente[0]['fkPsicologoPaciente']
) {
    echo json_encode([
        'anotacoes' => "Você não tem permissão para acessar as anotações deste paciente.",
        'atividades' => "Você não tem permissão para acessar as atividades deste paciente."
    ], JSON_UNESCAPED_UNICODE);
    die(); 
}

foreach ($anotacaoPaciente as &$item) {
    if (isset($item['ap_IV'])) {
        $item['IV'] = $item['ap_IV'];
    }
    if (isset($item['ap_tag'])) {
        $item['tag'] = $item['ap_tag'];
    }
}
unset($item);

$anotacaoPaciente = $crypto->decrypt($anotacaoPaciente);

foreach ($anotacaoPaciente as &$item) {
    unset(
        $item['IV'],
        $item['tag'],
        $item['ap_IV'],
        $item['ap_tag']
    );
}
unset($item);

echo json_encode([
    'anotacoes' => $anotacaoPaciente,
    'atividades' => $atividadesPaciente
], JSON_UNESCAPED_UNICODE);
?>