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

$repositoryFlags = new RepositorioFlag();
$allFalgs = $repositoryFlags->findAll();

if($_POST){
    print_r($_POST);
    $novaFlaga = new Flags;
    $novaFlaga->setColor($_POST['color'])->
    setDescricao($_POST['decricao'])->
    setTituloDaFlag($_POST['tituloDaFlag']);

    $repositoryFlags->insert($novaFlaga);
    header("location: flags.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flags</title>
</head>
<body>
    <style>
        .flagInList{
            border: 1px solid;
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>
    <form action="" method="post">

        <label for="color">Cor Da flag</label>
        <input type="color" name="color" id="color">

        <label for="tituloDaFlag">Titulo</label>
        <input type="text" name="tituloDaFlag" id="tituloDaFlag">

        <label for="decricao">Descrição</label>
        <textarea name="decricao" id="decricao"></textarea>

        <button type="submit">cadastra nova flag</button>

    </form>

    <section class="listOfFlags">
        <?php
            foreach ($allFalgs as  $value) {
                
                echo "<div class='flagInList'>";
                echo "<p class='colorOfFlag' style='background-color: {$value['color']};'> {$value['color']}</p>";
                echo "<p class='tituloDaFlagInList'> {$value['tituloDaFlag']} </p>";
                echo "<p class='descricaoDaFlagInList'> {$value['descricao']} </p>";
                echo "<a href='editarFlag.php?pkFlag={$value['pkFlag']}'> <button>editar Flag</button> </a>";
                echo "</div>";
            }
        ?>
    </section>

</body>
</html>