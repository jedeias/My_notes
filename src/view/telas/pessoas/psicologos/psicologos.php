<?php

include "../../../../../vendor/autoload.php";

use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Infra\Repository\Pessoas\RepositorioPsicologos;
use src\Controllers\NilveDeAcessos\StrategyNivelDeAcessoPsicologos;
use src\Models\Core\Entities\Session\Sessions;
use src\Controllers\Autentificacao;

$auth = new Autentificacao();
$session = new Sessions();
$nivelDeAcesso = new StrategyNivelDeAcessoPsicologos();

$dadosPsicologo = $session->get('user');

$psicologos = new Psicologos();
$psicologos->setPsicologosPk($dadosPsicologo['pkPsicologo']);
$psicologos->setNome($dadosPsicologo['nome']);
$psicologos->setEmail($dadosPsicologo['email']);
$psicologos->setImageLocal($dadosPsicologo['imageLocal']);
$psicologos->setCRP($dadosPsicologo['CRP']);
$psicologos->setPessoaPk($dadosPsicologo['pkPessoa']);

$listaDePacientes = new RepositorioPsicologos();
$listaDePacientes = $listaDePacientes->findAllPacientesOfPsicologo($psicologos);


// var_dump($psicologos->getImageLocal());


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psicólogos</title>
    <script  src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.17/index.global.min.js'></script>
    <script  src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.17/index.global.min.js'></script>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../../CSS/psicologos.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
</head>
<body>
    
    <div id="menuBtn" onclick="openNav()">&#9776;</div>
    <div id="mySidenav" class="sidenav">

        <img src="../../../image/fotosUsuarios/<?php echo $psicologos->getImageLocal()?>" alt='../../../image/default-profile.webp'>
        <h1 class="title"><?php echo $dadosPsicologo["nome"]; ?></h1>
        <h2 class="subtitle"><?php echo $dadosPsicologo["email"]; ?></h2>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Atividades</a>
        <a href="#">Consultas Agendadas</a>
        <a href="#">Contato</a>
        <a href="../sair.php">sair</a>
        <a href="../config.php"><i class="fa-solid fa-gear"></i></a> 
    </div>

    <article class="pacientes">
        <h2 class="pacientes-title">Lista de Pacientes</h2>
        
        <input type="text" class="search" placeholder="Pesquisar Paciente" id="searchInput">
        <button class="btnsearch"><i class="fa-solid fa-magnifying-glass"></i></button>
        
        <h1>Selecione um Paciente</h1>


        <div class="container">
            <?php

                foreach($listaDePacientes as $paciente){
                    echo "<section class='paciente-card'>";
                    echo "<p><strong>" . $paciente['nome'] . "</strong></p>";
                    echo "<p><strong>" . $paciente['email'] . "</strong></p>";
                    echo "<button class='btn-next-paciente' onclick='dadosPacientes(". $paciente['pkPaciente'].")'>informações</button>";
                    echo "</section>";
                }
            ?>

            <section class="paciente-card" >
            <p><strong>Jorge Santos</strong></p>
            <p>Idade: 35</p>
            <p>Última consulta: 10/02/2023</p>
            <button class="btn-next-paciente" onclick="nextPaciente()">Próximo Paciente</button>
            </section>
        </div>



    </article>
    

    <main>

        <article class="null">
        </article>

        <div class="agenda">
            <div id="calendar"></div>
        </div>

        <article class="button">
            <button class="btn-prev" onclick="prevClick()"><i class="fa-solid fa-arrow-left"></i></button>
            <button class="btn-next" onclick="nextClick()"><i class="fa-solid fa-arrow-right"></i></button>
        </article>

        <article class="anotação" hidden>
            <h1 class="anotacao-title">Anotação</h1>

            <section class="anotacao-content">
                
                <section hidden="true" id="listaDeAnotacoesDoPaciente" class="listaDeAnotacoesDoPaciente">
                    <button class="anotacoes" onclick="hiddenListaDeAnotacoes()">Fechar lista</button>
                </section>

                <button class="anotacoes" onclick="ligarVisibilidadeDasAnotacoes()">Lista de Anotações</button>
            </section>

        </article>
                
        <article class="atividadesRecomendadas" hidden>
            <h1 class="atividades-title">Atividades Recomendadas</h1>

            <img src="" alt="Adicionar" class="add-icon">

            
            <form action="" method="post" class="atividades-form">
                
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" class="titulo">
                
                <label for="atividade">Recomendação</label>
                <input type="text" name="atividade" id="atividade" class="atividade">
                
                <button type="submit" class="btn-submit">Enviar</button>
                
            </form>
            <button class="listAtividade" onclick="ligarVisibilidadeDasAtividades()">Lista De Atividades</button>
            
            <section hidden="true" id="listaDeAtividadesDoPaciente" class="listaDeAtividadesDoPaciente">
            
                <button class="listAtividade" onclick="hiddenListaDeAtividades()">Fechar lista</button>
                
            </section>
        </article>
    
    </main>

    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="../../../JS/psicologos.js"></script>
    <script src="../../../JS/psicologosDadosPacientes.js"></script>
    <script defer src="../../../JS/agenda.js"></script>
    <script src="../../../JS/atividades.js"></script>
    <script src="../../../JS/menu.js"></script>
</body>
</html>