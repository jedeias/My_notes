<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\Autentificacao;
use src\Models\Core\Entities\Session\Sessions;
use src\Controllers\NilveDeAcessos\StrategyNivelDeAcessoPacientes;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Atividades\Atividades;
use src\Models\Infra\Repository\Atividades\RepositorioAtividades;

$auth = new Autentificacao();
$session = new Sessions();

$nivelDeAcesso = new StrategyNivelDeAcessoPacientes();

$dadosPacientes = $session->get('user');


$psicologos = new Psicologos();
$psicologos->setPsicologosPk($dadosPacientes['fkPsicologo']);
$pacientes = new Pacientes();
$pacientes->setPacientesPk($dadosPacientes['pkPaciente']);
$pacientes->setNome($dadosPacientes['nome']);
$pacientes->setEmail($dadosPacientes['email']);
$pacientes->setImageLocal($dadosPacientes['imageLocal']);
$pacientes->setPsicologo($psicologos);

if($dadosPacientes['pkResponsavel'] != null){
    $pacientes->setResponsavel($dadosPacientes['pkResponsavel']);
}

$arrayAtividades = new RepositorioAtividades();

$arrayAtividades = $arrayAtividades->findAllAtividadesOfPacientes($pacientes);

?>
<!DOCTYPE html>
<html lang="Pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/atividades.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <title>Atividades Recomendadas</title>
</head>
<body>

    <div id="menuBtn" onclick="openNav()">&#9776;</div>
    <div id="mySidenav" class="sidenav">

        <img src="../image/images.png" alt="">
        <h1 class="title">My-Notes</h1>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="pacientes.php">Anotaçoes</a>
        <a href="#">Agenda</a>
        <a href="#">Consultas Agendadas</a>
        <a href="#">Contato</a>
        <a href="../sair.php">sair</a>
        <a href="../config.php"><i class="fa-solid fa-gear"></i></a> 
    </div>

    <div class="container">

        <?php

            foreach ($arrayAtividades as $value) {
                echo "<div class='att'>
                <h1>" . $value['titulo'] . "</h1>
                <p>". $value['descricao'] ."</p>
                </div>";
            }
            

        ?>

    </div>
    
    <script src="../../../JS/menu.js"></script>
</body>
</html>