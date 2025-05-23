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
    <title>Editar flas <?php echo "{$flagAtual['tituloDaFlag']}" ?></title>
</head>
<body>
    
    <form action="" method="post">
        <label for="color">Cor Atual da flag</label>
        <input type="color" name="color" id="color" value="<?php echo "{$flagAtual['color']}"; ?>">
        
        <label for="titulo">Titulo Atual da flag</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo "{$flagAtual['tituloDaFlag']}"; ?>">
        
        <label for="descricao">Descrição Atual da flag</label>
        <textarea name="descricao" id="descricao"><?php echo "{$flagAtual['descricao']}"; ?></textarea>

        <button type="submit">editar flag</button>

    </form>

</body>
</html>
