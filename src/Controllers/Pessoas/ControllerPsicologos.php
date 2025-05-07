<?php

namespace src\Controllers\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Infra\Repository\Pessoas\RepositorioPsicologos;

class ControllerPsicologos {
    private Psicologos $psicologo;
    private RepositorioPsicologos $repositorioPsicologo;

    public function __construct() {
        $this->repositorioPsicologo = new RepositorioPsicologos();
    }

    public function getPsicologo(): Psicologos
    {
        return $this->psicologo;
    }

    public function setPsicologo(Psicologos $psicologo): self
    {
        $this->psicologo = $psicologo;
        return $this;
    }

    public function getRepositorioPsicologo(): RepositorioPsicologos
    {
        return $this->repositorioPsicologo;
    }

    public function setRepositorioPsicologo(RepositorioPsicologos $repositorioPsicologo): self
    {
        $this->repositorioPsicologo = $repositorioPsicologo;
        return $this;
    }
}


?>