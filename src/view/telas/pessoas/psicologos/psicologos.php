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


var_dump($psicologos->getImageLocal());


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psicólogos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../../CSS/psicologos.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
</head>
<body>
    
    <div id="menuBtn" onclick="openNav()">&#9776;</div>
    <div id="mySidenav" class="sidenav">

        <img src="../../../image/fotosUsuarios/<?php echo $psicologos->getImageLocal()?>" alt='../../../image/default-profile.webp'>
        <h1 class="title">My-Notes</h1>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Atividades</a>
        <a href="#">Agenda</a>
        <a href="#">Consultas Agendadas</a>
        <a href="#">Contato</a>
        <a href="../sair.php">sair</a>
        <a href="../config.php"><i class="fa-solid fa-gear"></i></a> 
    </div>
    <article class="pacientes">
        <h2 class="pacientes-title">Lista de Pacientes</h2>
        <h1>Selecione um Paciente</h1>

        <input type="text" class="search" placeholder="Pesquisar Paciente" id="searchInput">
        <button>"joga imagem de uma lupa aqui"</button>
        

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



    </article>

    <main>

        <article class="null">
        </article>

        <article class="button">
            <button class="btn-prev" onclick="prevClick()"><i class="fa-solid fa-arrow-left"></i></button>
            <button class="btn-next" onclick="nextClick()"><i class="fa-solid fa-arrow-right"></i></button>
        </article>

        <article class="anotação">
            <h1 class="anotacao-title">Anotação</h1>

            <section class="anotacao-content">
                
                <section hidden="true" id="listaDeAnotacoesDoPaciente" class="listaDeAnotacoesDoPaciente">
                    <button onclick="hiddenListaDeAnotacoes()">fechar lista</button>
                </section>

                <button onclick="ligarVisibilidadeDasAnotacoes()">mostra lista de anotacoes</button>
            </section>

        </article>
        
        <article class="agenda" hidden>
            <h1>Agenda</h1>

            Falta subir o full_calender para implementar essa parte do código
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
            <button onclick="ligarVisibilidadeDasAtividades()">lista De Ativiades atual do paciente</button>
            
            <section hidden="true" id="listaDeAtividadesDoPaciente" class="listaDeAtividadesDoPaciente">
            
                <button onclick="hiddenListaDeAtividades()">fechar lista</button>
                
            </section>
        </article>
    
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="../../../JS/psicologos.js"></script>
    <script src="../../../JS/psicologosDadosPacientes.js"></script>
    <script src="../../../JS/menu.js"></script>
</body>
</html>