<?php

namespace Src\Models\Core\Entities\Anotacoes;
use src\Models\Core\Entities\Pessoas\Ipacientes;
use src\Models\Core\Entities\Anotacoes\IanotacoesPacientes;

class AnotacoesPacientes implements IanotacoesPacientes{
    
    private Ipacientes $pacientes;
    private string $anotacao;
    private string $dia;
    private int $pkAnotacoesPacientes;

    public function getPacientes(): Ipacientes{
        return $this->pacientes;
    }

    public function setPacientes(Ipacientes $pacientes): self{
        $this->pacientes = $pacientes;

        return $this;
    }

    public function getAnotacao(): string{
        return $this->anotacao;
    }

    public function setAnotacao(string $anotacao): self{
        $this->anotacao = $anotacao;

        return $this;
    }

    public function getDia(): string{
        return $this->dia;
    }

    public function setDia(string $dia): self{
        $this->dia = $dia;

        return $this;
    }

    public function getPkAnotacoesPacientes(): int{
        return $this->pkAnotacoesPacientes;
    }

    public function setPkAnotacoesPacientes(int $pkAnotacoesPacientes): self{
        $this->pkAnotacoesPacientes = $pkAnotacoesPacientes;

        return $this;
    }

    static function create(
        Ipacientes $paciente,
        string $anotacaoDoPaciente,
    ): AnotacoesPacientes{
        $anotacao = new AnotacoesPacientes();
        $anotacao->setPacientes($paciente);
        $anotacao->setAnotacao($anotacaoDoPaciente);
        return $anotacao;
    }
}


?>