<?php

namespace Src\Models\Core\Repository\Anotacoes;
use Src\Models\Core\Entities\Anotacoes\IanotacoesPsicologos;
use Src\Models\Core\Entities\Anotacoes\IanotacoesPacientes;

interface IrepositoryAnotacoesPsicologos{
    public function findAnotacaoPsicologosByPkAnotacaoPaciente(IanotacoesPacientes|int $pkAnotacoesPsicologos): array;
    public function insert(IanotacoesPsicologos $anotacao): void;
    public function update(IanotacoesPsicologos $anotacao): void;
}

?>