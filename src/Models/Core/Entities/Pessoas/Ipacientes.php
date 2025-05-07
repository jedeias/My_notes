<?php

namespace src\Models\Core\Entities\Pessoas;

interface Ipacientes{

    public function getPsicologo(): Ipsicologos;

    public function setPsicologo(Ipsicologos $psicologo): self;

    public function getPacientesPk(): int;

    public function setPacientesPk(int $pacientesPk): self;

    public function getResponsavel(): ?Iresponsavel;

    public function setResponsavel(Iresponsavel $responsavel): self;
}
    
?>