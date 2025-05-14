<?php


require_once __DIR__ . '/../../../vendor/autoload.php';

use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Anotacoes\AnotacoesPacientes;
use src\Models\Infra\Repository\Anotacoes\RepositorioAnotacoesPacientes;
use src\Models\Infra\Repository\Atividades\RepositorioAtividades;

$pacientes = new Pacientes();
$pacientes->setPacientesPk($_POST['pk']);

$anotacaoPaciente = new RepositorioAnotacoesPacientes();
$atividadesPaciente = new RepositorioAtividades();

echo json_encode([
    'anotacoes' => $anotacaoPaciente->findAnotacaoByPkPacientes($pacientes),
    'atividades' => $atividadesPaciente->findAllAtividadesOfPacientes($pacientes)
], JSON_UNESCAPED_UNICODE);

// echo "<pre>";
// var_dump($_POST);

?>