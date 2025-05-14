<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\Autentificacao;
use src\Models\Core\Entities\Session\Sessions;
use src\Controllers\NilveDeAcessos\StrategyNivelDeAcessoPacientes;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Anotacoes\AnotacoesPacientes;
use src\Models\Infra\Repository\Anotacoes\RepositorioAnotacoesPacientes;

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

$anotacaoPaciente = new AnotacoesPacientes();

$anotacaoPaciente->setPacientes($pacientes);
$anotacaoPacienteRepositorio = new RepositorioAnotacoesPacientes();

$dataNotes = $anotacaoPacienteRepositorio->findAnotacaoByPkPacientes($pacientes);

if($_POST){
    $novaAnotacao = new AnotacoesPacientes();
    $novaAnotacao->setAnotacao($_POST['descricao']);
    $novaAnotacao->setPacientes($pacientes);
    $anotacaoPacienteRepositorio->insert($novaAnotacao);
    header("Location: pacientes.php");
}
?>

<!DOCTYPE html>
<html lang="Pt_Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/paciente.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Paciente</title>

</head>
<body>
    <div id="menuBtn" onclick="openNav()">&#9776;</div>
    <div id="mySidenav" class="sidenav">

        <?php

            echo "src=/".$pacientes->getImageLocal(). "alt='../../../image/default-profile.webp'";
        ?>

        <h1 class="title">My-Notes</h1>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="atividades.php">Atividades</a>
        <a href="#">Consultas Agendadas</a>
        <a href="#">Contato</a>
        <a href="#">Agenda</a>
        <a href="../sair.php">sair</a>
        <a href="../config.php"><i class="fa-solid fa-gear"></i></a> 
    </div>

    <section class="notepad-container">
        <section class="notepad-content">
            <button class="prev-button" onclick="prevNote()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                    <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                </svg>
            </button>
            <div id="anotacao<?php echo $numAnotacoes + 1;?>" class="notepad active">           
                <form action="" method="POST">
                <article class="notepad-header">
                    <div class="notepad-header-left">
                        <p id="digital-date" class="notepad-date"></p> 
                    </div>
                    <div class="notepad-header-center">
                        <label for="emotion">Tipo de Emoção:</label>
                        <select id="emotion" name="emotion">
                            <option value="feliz">Feliz &#128512;</option>
                            <option value="triste">Triste &#128542;</option>
                            <option value="ansioso">Ansioso &#128534;</option>
                            <option value="irritado">Irritado &#128545;</option>
                            <option value="calmo">Calmo &#128521;</option>
                        </select>
                    </div>
                    <div class="notepad-header-right">
                        <p id="digital-clock" class="notepad-clock"></p>
                    </div>
                </article>
                <textarea required id="textarea" placeholder="Como você está?" name="descricao"></textarea>
                <div class="action-button-container">
                    <button class="action-button" type="submit" onclick="modalclick()">Salvar</button>
                </div>

            </form>
            </div>

            <button class="next-button" onclick="nextNote()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                    <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>
            </button>
            <p id='notepad-count' class='notepad-count'>1 / <?php echo count($dataNotes) ?></p>
        </section>

        
        <div class="anotacoesDosPacientes">
            <input id="quantidadeDeAnotacoes" hidden="" values="<?php echo count($dataNotes); ?>"></input/>
            <input id="jsonDeAnotacoes" hidden="" value='<?php echo json_encode($dataNotes, JSON_UNESCAPED_UNICODE); ?>'></input>;
        
    </div>


    </section>
    <script src="../../../JS/paciente.js"></script>
    <script src="../../../JS/anotacoesPacientes.js"></script>
    <script src="../../../JS/menu.js"></script>

</body>
</html>