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
    <title>cadastra agendamento</title>
</head>
<body>
    
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

</body>
</html>
