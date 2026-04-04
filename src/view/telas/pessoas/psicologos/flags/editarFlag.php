<?php

include "../../../../../../vendor/autoload.php";

use src\Models\Core\Entities\Flags\Flags;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Infra\Repository\Flags\RepositorioFlag;
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

if(empty($_GET)){
    header("location: flags.php");
}

$repositoryFlags = new RepositorioFlag();
$flagToEdit = new Flags;
$flagToEdit->setPkFlags($_GET['pkFlag']);
$flagAtual = $repositoryFlags->findByPk($flagToEdit);

if($_POST){
    $flagToEdit->setColor($_POST['color']);
    $flagToEdit->setTituloDaFlag($_POST['titulo']);
    $flagToEdit->setDescricao($_POST['descricao']);
    echo "<pre>";
    print_r($flagToEdit);
    $repositoryFlags->update($flagToEdit);
    header("location: flags.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../CSS/editarflags.css">
    <link rel="stylesheet" href="../../../../CSS/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Editar flag <?php echo "{$flagAtual['tituloDaFlag']}" ?></title>
</head>
<body>

    <div id="menuBtn" onclick="openNav()">&#9776;</div>

    <div id="mySidenav" class="sidenav">

    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="sidenav-profile">
        <!-- <img src="../../../image/fotosUsuarios/<?php echo $psicologos->getImageLocal(); ?>" 
                onerror="this.src='../../../image/default-profile.webp'" 
                alt="Foto de Perfil"> -->
        
        <div class="title"><?php echo $dadosPsicologo["nome"]; ?></div>
        <div class="subtitle"><?php echo $dadosPsicologo["email"]; ?></div>
    </div>

    <div class="sidenav-links">
        <a href='../../psicologos/psicologos.php'><i class='fa-solid fa-house'></i> Home</a>
        <a href="../../agenda/agenda.php"><i class="fa-solid fa-calendar-days"></i> Agenda</a>
        <a href="../../config.php"><i class="fa-solid fa-gear"></i> Configurações</a> 
        
        <a href="../sair.php" class="sair" style="margin-top: auto; color: var(--danger);">
            <i class="fa-solid fa-right-from-bracket"></i> Sair
        </a> 
        
    </div>
    </div>

    <form action="" method="post">
        <label for="color">Cor Atual da flag</label>
        <input type="color" name="color" id="color" value="<?php echo "{$flagAtual['color']}"; ?>">
        
        <label for="titulo">Titulo Atual da flag</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo "{$flagAtual['tituloDaFlag']}"; ?>">
        
        <label for="descricao">Descrição Atual da flag</label>
        <textarea name="descricao" id="descricao"><?php echo "{$flagAtual['descricao']}"; ?></textarea>

        <button type="submit">Editar flag</button>

    </form>
    <script src="../../../../JS/menu.js"></script>
</body>
</html>
