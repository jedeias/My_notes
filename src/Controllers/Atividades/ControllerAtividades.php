<?php


namespace src\Controllers\Atividades;

require_once __DIR__ . '/../../../vendor/autoload.php';

use src\Models\Core\Entities\Atividades\Atividades;
use src\Models\Infra\Repository\Atividades\RepositorioAtividades;

class ControllerAtividades{
    private Atividades $atividades;
    private RepositorioAtividades $repositorio;

    public function __construct() {
        $this->atividades = new Atividades();
        $this->repositorio = new RepositorioAtividades();
    }

    public function getAtividades(): Atividades{
        return $this->atividades;
    }

    public function setAtividades(Atividades $atividades): self{
        $this->atividades = $atividades;
        return $this;
    }

    public function getRepositorio(): RepositorioAtividades{
        return $this->repositorio;
    }

    public function setRepositorio(RepositorioAtividades $repositorio): self{
        $this->repositorio = $repositorio;
        return $this;
    }
}

if(!empty($_POST)){
    
    if(isset($_POST['titulo']) && isset($_POST['atividade'])){
        $controllerAtividades = new ControllerAtividades();
        $controllerAtividades->getAtividades()->setTitulo($_POST['titulo'])->setDescricao($_POST["atividade"]);
        $controllerAtividades->getRepositorio()->insertAtividadesPaciente($controllerAtividades->getAtividades(), $_POST['pkPaciente']);
        header("location: ../../view/telas/pessoas/psicologos/psicologos.php");
    }

    var_dump($_POST);

}

?>