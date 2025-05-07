<?php

namespace Src\Models\Core\Entities\Anotacoes;
use Src\Models\Core\Entities\Anotacoes\IanotacoesPacientes;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use Src\Models\Core\Entities\Flags\Iflags;

interface IanotacoesPsicologos{
    public function getPsicologos(): Ipsicologos|int;

    public function setPsicologos(Ipsicologos|int $psicologos): self;

    public function getFlags(): Iflags|int;

    public function setFlags(Iflags|int $flags): self;

    public function getDescricao(): string;

    public function setDescricao(string $descricao): self;

    public function getObservacoes(): string;

    public function setObservacoes(string $observacoes): self;

    public function getDia(): string;

    public function setDia(string $dia): self;

    public function getPkAnotacoesPsicologos(): int;

    public function setPkAnotacoesPsicologos(int $pkAnotacoesPsicologos): self;

    public function getAnotacaoPacietes(): IAnotacoesPacientes|int;
    
    public function setAnotacaoPacietes(IAnotacoesPacientes|int $anotacaoPacietes): self;

    static function create(
        Ipsicologos|int $psicologos,
        Iflags|int $flags,
        string $descricao,
        string $observacoes,
        IAnotacoesPacientes|int $anotacaoPacietes
    ): AnotacoesPsicologos;
}

?>