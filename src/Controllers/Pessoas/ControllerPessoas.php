<?php

namespace src\Controllers\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipacientes;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Core\Entities\Telefones\Telefones;

class ControllerPessoas{
    
    private RepositorioPessoa $repositorioPessoa;
    private Ipacientes $pessoas;

    public function __construct() {
        $this->repositorioPessoa = new RepositorioPessoa();
        $this->pessoas = new Pacientes(); // A classe pessoas é abstra então nos faz esse role para intanciar ela com outra classe que tem o mesmo contrato
        // $this->endereco = new Enderecos();
        // $this->telefones = new Telefones();
    }

    public function setTelefones(Telefones $telefone): self{
        $this->telefones = $telefone;
        return $this;
    }

    public function setEnderecos(Enderecos $enderecos) : self {
        $this->endereco = $enderecos;
        return $this;
    }

    public function getPessoas(): Ipacientes{
        return $this->pessoas;
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
    
    public function getRepositorioPessoa(): RepositorioPessoa
    {
        return $this->repositorioPessoa;
    }
}

?>