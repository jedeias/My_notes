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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <link rel="stylesheet" href="../../../CSS/agenda.css">

    <?php 

      if($tipoPessoa){
        echo "<a class='btn-agenda' href='agendarConsulta.php'><button>Agendar Consultas</button></a>";
        
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
        
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <div class="sidenav-profile">
            <img src="../../../image/fotosUsuarios/<?php echo $pessoas["imageLocal"]; ?>" 
                onerror="this.src='../../image/default-profile.webp'" 
                alt="Foto de Perfil">
            
            <div class="title"><?php echo $pessoas["nome"]; ?></div>
            <div class="subtitle"><?php echo $pessoas["email"]; ?></div>
        </div>

        <div class="sidenav-links">
            
            <?php 
                if($pessoas["pkSecretario"] !== NULL){
                    echo "<a href='../secretarios/secretarios.php'><i class='fa-solid fa-house'></i> Início</a>";
                } else if($pessoas["pkPsicologo"] !== NULL){
                    echo "<a href='../psicologos/psicologos.php'><i class='fa-solid fa-house'></i> Início</a>";
                }
                if($pessoas["pkPaciente"] !== NULL){
                    echo "<a href='../pacientes/pacientes.php'><i class='fa-solid fa-house'></i> Início</a>";
                }
            ?>
            
            <a href="agenda/agendarConsulta.php"><i class="fa-solid fa-calendar-plus"></i> Agenda</a>
            <a href="agenda/agenda.php"><i class="fa-solid fa-calendar-check"></i> Consultas Agendadas</a>
            
            <a href="#" style="margin-top: auto; color: var(--danger);">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </a> 
            
        </div>
    </div>

    <div id='calendar'></div>

    <script src="../../../JS/menu.js"></script>
  </body>
</html>