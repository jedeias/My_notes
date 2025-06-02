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
    <div id='calendar'></div>
  </body>
</html>