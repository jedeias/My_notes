<?php

namespace Src\Models\Core\Entities\Anotacoes;
use Src\Models\Core\Entities\Pessoas\Ipacientes;

interface IanotacoesPacientes
{
    public function getPacientes(): Ipacientes;
    public function getAnotacao(): string;
    public function getDia(): string;
    public function getPkAnotacoesPacientes(): int;
    static function create(Ipacientes $paciente,string $anotacaoDoPaciente): AnotacoesPacientes;
}
