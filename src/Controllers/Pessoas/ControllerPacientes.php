<?php

namespace src\Controllers\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipacientes;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Infra\Repository\Pessoas\RepositorioPacientes;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Core\Entities\Telefones\Telefones;

class ControllerPacientes{
    
    private  $repositorioPessoa;
    private Ipacientes $paceintes;

    public function __construct() {
        $this->repositorioPessoa = new RepositorioPacientes();
        $this->paceintes = new Pacientes();
    }

    public function setTelefones(Telefones $telefone): self{
        $this->telefones = $telefone;
        return $this;
    }

    public function setEnderecos(Enderecos $enderecos) : self {
        $this->endereco = $enderecos;
        return $this;
    }

    public function insert(Ipacientes $pessoa) : void{
        $this->repositorioPessoa->insert($pessoa);
    }
    
    public function findByPk(Ipacientes $pessoa) : array{
        return $this->repositorioPessoa->findByPk($pessoa);
    }
    
    public function findByEmail(Ipacientes $pessoa) : array{
        return $this->repositorioPessoa->findByEmail($pessoa);
    }
    
}

?>