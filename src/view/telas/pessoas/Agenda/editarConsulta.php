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
    <title>editar</title>
</head>
<body>
    
    <form action="" method="post">

        <input type="hidden" name="pkCosulta" value="<?php echo $dadosAtuaisDaConsulta['pkCosulta']; ?>">
        <input type="hidden" name="pkPaciente" value="<?php echo $dadosAtuaisDaConsulta['pkPaciente']; ?>">

        <label> <?php echo $dadosAtuaisDaConsulta['nome']; ?></label>

        <label for="novaData"> Nova data da consulta</label>
        <input type="dateTime-local" name="novaDia" id="novaDia">

        <button type="submit">Enviar</button>
    </form>

</body>
</html>
