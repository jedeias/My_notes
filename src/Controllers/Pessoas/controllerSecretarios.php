<?php

namespace src\Controllers\Pessoas;

use Src\Models\Core\Entities\Pessoas\Isecretarios;
use src\Models\Infra\Repository\Pessoas\RepositorioSecretarios;

class controllerSecretarios{
    
    private Isecretarios $secretarios;

    private RepositorioSecretarios $repositorioSecretarios;

    public function __construct() {
        $this->repositorioSecretarios = new RepositorioSecretarios();
    }
    
    public function getSecretarios(): Isecretarios{
        return $this->secretarios;
    }

    public function setSecretarios(Isecretarios $secretarios): self{
        $this->secretarios = $secretarios;

        return $this;
    }

    public function getRepositorioSecretarios(): RepositorioSecretarios{
        return $this->repositorioSecretarios;
    }

    public function setRepositorioSecretarios(RepositorioSecretarios $repositorioSecretarios): self{
        $this->repositorioSecretarios = $repositorioSecretarios;

        return $this;
    }
}


?>