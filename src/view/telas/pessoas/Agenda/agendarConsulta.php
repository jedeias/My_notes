<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\Autentificacao;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Session\Sessions;
use src\Models\Core\Entities\Consultas\Consultas;
use src\Models\Infra\Repository\Consultas\RepositorioConsutas;
use src\Models\Infra\Repository\Pessoas\RepositorioPacientes;

$auth = new Autentificacao();
$session = new Sessions();

$pessoas = $session->get('user');

if($pessoas["pkPaciente"] !== null){
    header("location: agenda.php");
}

if(! empty($_GET["pesquisa"])){
    $repositorioPacientes = new RepositorioPacientes();
    $listaDePacientes = $repositorioPacientes->findPacienteComLike($_GET["pesquisa"]);
    

}else{
    
    $repositorioPacientes = new RepositorioPacientes();
    $listaDePacientes = $repositorioPacientes->findAll();

}

if($_POST){

    echo "<pre>";
    print_r($_POST);

    $consultas = new Consultas();
    $consultas->setDiaEHora($_POST['dataConsulta']);
    $consultas->setPacientes($_POST['pkPaciente']);
    
    $repositorioConsutas = new RepositorioConsutas();

    $repositorioConsutas->insert($consultas);

    header("location: agenda.php");

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <link rel="stylesheet" href="../../../CSS/AgendarConsulta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>cadastra agendamento</title>
</head>
<body>

    <div id="menuBtn" onclick="openNav()">
    <i class="fa-solid fa-bars"></i>
</div>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="sidenav-profile">
        <img src="../../../image/fotosUsuarios/<?php echo $pessoas["imageLocal"] ?>" 
             onerror="this.src='../../image/default-profile.webp'" 
             alt="Foto do Usuário">
        
        <div class="title"><?php echo $pessoas["nome"]; ?></div>
        <div class="subtitle"><?php echo $pessoas["email"]; ?></div>
    </div>

    <div class="sidenav-links">
        <?php 
            if($pessoas["pkSecretario"] !== NULL){
                echo "<a href='../secretarios/secretarios.php'><i class='fa-solid fa-house'></i> Home</a>";
            }else if($pessoas["pkPsicologo"] !== NULL){
                echo "<a href='../psicologos/psicologos.php'><i class='fa-solid fa-house'></i> Home</a>";
            }
            if($pessoas["pkPaciente"] !== NULL){
                echo "<a href='../pacientes/pacientes.php'><i class='fa-solid fa-house'></i> Home</a>";
            }
        ?>
        
        <a href="agenda/agendarConsulta.php"><i class="fa-solid fa-calendar-plus"></i> Agendar Consulta</a>
        <a href="agenda/agenda.php"><i class="fa-solid fa-calendar-check"></i> Consultas Agendadas</a>
        
        <a href="../sair.php" class="sair" style="margin-top: auto; color: var(--danger);">
            <i class="fa-solid fa-right-from-bracket"></i> Sair
        </a> 
    </div>
</div>

    <section>

        <form action="" method="get">
            <label for="pesquisa">paciente</label>
            <input type="text" name="pesquisa">
            <button type="submit">pesquisar</button>
        </form>


        <?php 
            foreach ($listaDePacientes as $pacientes) {
                echo "<div>";
                echo "<p>" . $pacientes['nome'] . "</p>";
                echo "<p>" . $pacientes['email'] . "</p>";
                echo "<button onclick='fichaDeCadastro({$pacientes['pkPaciente']})'>Agendar consulta</button>";
                echo "</div>";
            }
        ?>

        <div class="cadastro" id="fichaDeCadastro" hidden>
            <form action="" method="post">    
                <label for="data">Dia da consulta</label>
                <input type="datetime-local" name="dataConsulta" id="data">

                <input type="hidden" name="pkPaciente" id='pkDoPacienteParaAgendar' ?>
                
                <button type="submit">cadastra</button>
            </form>
        </div>
    </section>

    <script>
        function fichaDeCadastro(pk) {

            let div = document.getElementById("fichaDeCadastro");

            div.removeAttribute("hidden");
            
            let pacientePK = document.getElementById("pkDoPacienteParaAgendar");
            pacientePK.value = pk;
            
        }
    </script>
    
    <script src="../../../JS/menu.js"></script>

</body>
</html>
