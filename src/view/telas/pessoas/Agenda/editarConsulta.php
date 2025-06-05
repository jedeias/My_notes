<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\Autentificacao;
use src\Models\Core\Entities\Session\Sessions;
use src\Models\Core\Entities\Consultas\Consultas;
use src\Models\Infra\Repository\Consultas\RepositorioConsutas;

$auth = new Autentificacao();
$session = new Sessions();

$pessoas = $session->get('user');

if(empty($_GET['pkConsulta']) || $_GET['pkConsulta'] == null ){
    header("location: agenda.php");
}

if($pessoas["pkPaciente"] !== null){
    header("location: agenda.php");
}

$repositorioConsutas = new RepositorioConsutas();

$dadosAtuaisDaConsulta = $repositorioConsutas->findByPKConsulta($_GET['pkConsulta']);

if($_POST){
    $novaConsulta = new Consultas();

    $novaConsulta->setPacientes($_POST['pkPaciente']);
    $novaConsulta->setPkConsultas($_POST['pkCosulta']);
    $novaConsulta->setDiaEHora($_POST['novaDia']);

    $repositorioConsutas->update($novaConsulta);

    header("location: agenda.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <title>editar</title>
</head>
<body>

    <div id="menuBtn" onclick="openNav()">&#9776;</div>
    <div id="mySidenav" class="sidenav">
        <img src="../../../image/fotosUsuarios/<?php echo $pessoas["imageLocal"] ?>" alt="../../image/default-profile.webp">
        <h1 class="title"><?php echo $pessoas["nome"]; ?></h1>
        <h2 class="subtitle"><?php echo $pessoas["email"]; ?></h2>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <?php 
            if($pessoas["pkSecretario"] !== NULL){
                echo "<a href='../secretarios/secretarios.php'>home</a>";
            }else if($pessoas["pkPsicologo"] !== NULL){
                echo "<a href='../psicologos/psicologos.php'>home</a>";
            }
            if($pessoas["pkPaciente"] !== NULL){
                echo "<a href='../pacientes/pacientes.php'>home</a>";
            }
        ?>
        <a href="agenda/agendarConsulta.php">Agenda</a>
        <a href="agenda/agenda.php">Consultas Agendadas</a>
        <a href="#"><i class="fa-solid fa-right-from-bracket"></i></a> 
        
    </div>


    <form action="" method="post">

        <input type="hidden" name="pkCosulta" value="<?php echo $dadosAtuaisDaConsulta['pkCosulta']; ?>">
        <input type="hidden" name="pkPaciente" value="<?php echo $dadosAtuaisDaConsulta['pkPaciente']; ?>">

        <label> <?php echo $dadosAtuaisDaConsulta['nome']; ?></label>

        <label for="novaData"> Nova data da consulta</label>
        <input type="dateTime-local" name="novaDia" id="novaDia">

        <button type="submit">Enviar</button>
    </form>

            
    <script src="../../../JS/menu.js"></script>

</body>
</html>
