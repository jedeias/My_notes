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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <title>Atividades Recomendadas</title>
</head>
<body>

         <div id="menuBtn" onclick="openNav()">&#9776;</div>

        <div id="mySidenav" class="sidenav">

        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <div class="sidenav-profile">
            <img src="../../../image/fotosUsuarios/<?php echo $pacientes->getImageLocal(); ?>" 
                    onerror="this.src='../../../image/default-profile.webp'" 
                    alt="Foto de Perfil">
                    
            <div class="title"><?php echo $dadosPacientes["nome"]; ?></div>
            <div class="subtitle"><?php echo $dadosPacientes["email"]; ?></div>
        </div>

        <div class="sidenav-links">
            <a href="pacientes.php"><i class="fa-solid fa-clipboard-list"></i> Inicio </a>
            <a href="../Agenda/agenda.php"><i class="fa-solid fa-calendar-days"></i> Consultas </a>
            <a href="../config.php"><i class="fa-solid fa-gear"></i> Configurações</a>
            
            <a href="../sair.php" class="sair" style="margin-top: auto; color: var(--danger);">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </a>
        </div>

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