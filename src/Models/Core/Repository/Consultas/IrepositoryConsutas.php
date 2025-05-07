<?php

namespace Src\Models\Core\Repository\Consultas;
use Src\Models\Core\Entities\Consultas\Iconsultas;

interface IrepositoryConsutas{
    public function findAllConsultas(): array;
    public function findByPKConsulta(int $pkConsultas): array;
    public function insert(Iconsultas $consulta): void;
    public function update(Iconsultas $consulta): void;
    public function delete(int $pkConsultas): bool;
}

?>