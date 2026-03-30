<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\Autentificacao;
use src\Models\Core\Entities\Flags\Flags;
use src\Models\Core\Entities\Session\Sessions;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Infra\Repository\Flags\RepositorioFlag;
use src\Models\Core\Entities\Anotacoes\AnotacoesPacientes;
use src\Models\Core\Entities\Anotacoes\AnotacoesPsicologos;
use src\Models\Infra\Repository\Pessoas\RepositorioPsicologos;
use src\Models\Infra\Repository\Anotacoes\RepositorioAnotacoesPacientes;
use src\Models\Infra\Repository\Anotacoes\RepositorioAnotacoesPsicologos;
use src\Controllers\NilveDeAcessos\StrategyNivelDeAcessoPsicologos;


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

if(!$_GET["pkAnotacaoPaciente"] || empty($_GET["pkAnotacaoPaciente"])){
    header("location: psicologos.php");
}

$anotacaoPaciente = new AnotacoesPacientes();
$anotacaoPaciente->setPkAnotacoesPacientes($_GET["pkAnotacaoPaciente"]);

$repositorioAnotacaoPaciente = new RepositorioAnotacoesPacientes();
$anotacaoParaOBS = $repositorioAnotacaoPaciente->findAnotacaoByPk($anotacaoPaciente->getPkAnotacoesPacientes())[0];

$repositoryAnotacaoPsicologo = new RepositorioAnotacoesPsicologos();
$observacao = $repositoryAnotacaoPsicologo->findAnotacaoPsicologosByPkAnotacaoPaciente($anotacaoPaciente->getPkAnotacoesPacientes());

if(!empty($observacao)){

    $observacao = $observacao[0];
}


$repositorioFlags = new RepositorioFlag();
$allFalgs = $repositorioFlags->findAll();  


if($_POST){
    echo "<pre>";
    print_r($_POST);
    $flag = new Flags();
    $flag->setPkFlags($_POST['flag']);
        
    
    if(!empty($observacao)){
        $novaObservacao = new AnotacoesPsicologos();
        $novaObservacao->setPsicologos($psicologos);
        $novaObservacao->setAnotacaoPacietes(anotacaoPacietes: $anotacaoPaciente);
        $novaObservacao->setPkAnotacoesPsicologos($_GET['pkAnotacaoPaciente']);
        $novaObservacao->setFlags($flag);
        $novaObservacao->setObservacoes($_POST['observacao']);
        $repositoryAnotacaoPsicologo->update($novaObservacao);
        header("location: psicologos.php");
    }else{
        
        $novaObservacao = AnotacoesPsicologos::create(
            $psicologos, 
            $flag, 
            $_POST['observacao'], 
            $anotacaoPaciente
        );
        header("location: psicologos.php");
        $repositoryAnotacaoPsicologo->insert($novaObservacao);
    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <link rel="stylesheet" href="../../../CSS/notaspsicologos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Adicionar Anotação</title>
</head>
<body>

    <div id="menuBtn" onclick="openNav()">&#9776;</div>

    <div id="mySidenav" class="sidenav">

    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="sidenav-profile">
        <img src="../../../image/fotosUsuarios/<?php echo $psicologos->getImageLocal(); ?>" 
                onerror="this.src='../../../image/default-profile.webp'" 
                alt="Foto de Perfil">
        
        <div class="title"><?php echo $dadosPsicologo["nome"]; ?></div>
        <div class="subtitle"><?php echo $dadosPsicologo["email"]; ?></div>
    </div>

    <div class="sidenav-links">
        <a href='../psicologos/psicologos.php'><i class='fa-solid fa-house'></i> Home</a>
        <a href="../agenda/agenda.php"><i class="fa-solid fa-calendar-days"></i> Agenda</a>
        <a href="../config.php"><i class="fa-solid fa-gear"></i> Configurações</a> 
        
        <a href="../sair.php" class="sair" style="margin-top: auto; color: var(--danger);">
            <i class="fa-solid fa-right-from-bracket"></i> Sair
        </a> 
        
    </div>
    </div>
    
    <section id="facilitaMinhaVida" class="container">

        <h1>PACIENTE</h1>
        
        <div class="AnotacaoDoPacientes">
            <p><?php echo($anotacaoParaOBS['anotacao']); ?></p>
            <p><?php echo($anotacaoParaOBS['diaDaAnotacao']); ?></p>
        </div>

        <?php

            if(!empty($observacao)){
                echo("<h2>Esta nota já possui uma observação cadastrada. Você pode editá-la abaixo.</h2>");
                $buttunName = "Editar Observação";
            }else{
                $buttunName = "Salvar Observação";
            }
    
        ?>


        <form action="" method="post">

            <textarea name="observacao" id="observacao"><?php if(!empty($observacao['observacao'])){echo $observacao['observacao'];}else{echo "";} ?></textarea>
            
            <select name="flag" id="falg">

                <?php
                    if(!empty($observacao)){
                        echo "<option  onclick='tradeDescription()' value='{$observacao['pkFlag']}' style='background-color: {$observacao['color']};'> {$observacao['tituloDaFlag']} </option>";              
                    }
                ?>
                
                <?php foreach ($allFalgs as $value) {
                    echo "<option onclick='tradeDescription()' value='{$value['pkFlag']}' style='background-color: {$value['color']};'> {$value['tituloDaFlag']} </option>";
                } ?>
                

            </select>
            
            <button type="submit"><?php echo $buttunName; ?></button>

        </form>

        <a href="flags/flags.php"><button>Adicionar uma flag</button></a>

    </section>
    
    <script>

        let listOptions = <?php echo json_encode($allFalgs)?>

        console.log(listOptions);

        
        let description = document.createElement("p");
        description.className = "descricao";
        description.id = 'descricao';
        
        
        let section = document.getElementById("facilitaMinhaVida");
        
        section.appendChild(description);
        
        selected = tradeDescription();
        description.innerHTML = listOptions[selected.value-1].descricao;

        function tradeDescription() {

            let selected = document.getElementById("falg");
            console.log(selected.value);
            console.log(listOptions[selected.value-1].descricao);

            let description = document.getElementById("descricao");
            description.innerHTML = listOptions[selected.value-1].descricao;
            
            return selected;
        }


    </script>

    <script src="../../../JS/menu.js"></script>
</body>
</html>