<?php

namespace Src\Models\Core\Repository\Anotacoes;
use Src\Models\Core\Entities\Anotacoes\IanotacoesPacientes;
use src\Models\Core\Entities\Pessoas\Ipacientes;

interface IrepositoryAnotacoesPacientes
{
    public function findAnotacaoByPkPacientes(Ipacientes|int $pkAnotacoesPacientes): array;
    public function insert(IanotacoesPacientes $anotacao): void;
    public function update(IanotacoesPacientes $anotacao): void;
    public function delete(int $pkAnotacoesPacientes): bool;
}