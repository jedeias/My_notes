<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\Autentificacao;
use src\Models\Core\Entities\Session\Sessions;
use src\Models\Infra\Repository\Consultas\RepositorioConsutas;


$auth = new Autentificacao();
$session = new Sessions();

$pessoas = $session->get('user');

$tipoPessoas = null;

if($pessoas['pkSecretario'] != null || $pessoas['pkPsicologo'] != null){
  $repositorioConsutas = new RepositorioConsutas();
  $dataInSql = $repositorioConsutas->findAllConsultas();

  $tipoPessoa = true;

}else{
  $repositorioConsutas = new RepositorioConsutas();
  $dataInSql = $repositorioConsutas->findAllConsultasPaciente($pessoas["pkPaciente"]);
  $tipoPessoa = false;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.17/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.17/index.global.min.js'></script>
    <link rel="stylesheet" href="../../../CSS/header.css">
    <link rel="stylesheet" href="../../../CSS/agenda.css">

    <?php 

      if($tipoPessoa){
        echo "<a href='agendarConsulta.php'><button>Agendar Consultas</button></a>";
        
      }

    ?>

    
    <script>

      let json = <?php echo json_encode($dataInSql); ?>;

      console.log(json);

      let eventos = json.map(item => ({
        title: item.nome,
        start: item.horarioDaConsulta.replace(' ', 'T'),
        extendedProps:{
          pk: item.pkCosulta
        }
      }));


      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          events: eventos,
          eventClick: function(info) {
            let status = <?php echo json_encode([$pessoas["pkSecretario"], $pessoas["pkPsicologo"]]); ?>
            
            if(status.pkSecretario !== null || status.pkPsicologo !== null){
              window.location.href = "editarConsulta.php?pkConsulta="+info.event.extendedProps.pk;
            }

          }
        });
        calendar.render();
      });

    </script>
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

    <div id='calendar'></div>

    <script src="../../../JS/menu.js"></script>
  </body>
</html>