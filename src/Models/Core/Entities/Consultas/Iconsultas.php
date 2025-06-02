<?php

namespace Src\Models\Core\Entities\Consultas;
use src\Models\Core\Entities\Pessoas\Ipacientes;

interface Iconsultas
{
    public function getPacientes(): int;
    public function setPacientes(int $pacientes): self;
    public function getDiaEHora(): string;
    public function setDiaEHora(string $dia): self;
    public function getPkConsultas(): int;
    public function setPkConsultas(int $pkConsultas): self;
    static function create(int $paciente, string $dia, string $hora): Iconsultas;
}

?>