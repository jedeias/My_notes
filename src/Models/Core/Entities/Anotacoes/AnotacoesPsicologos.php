<?php

namespace Src\Models\Core\Entities\Anotacoes;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use src\Models\Core\Entities\Flags\Iflags;
use Src\Models\Core\Entities\Anotacoes\IAnotacoesPacientes;
use Src\Models\Core\Entities\Anotacoes\IanotacoesPsicologos;

class AnotacoesPsicologos implements IanotacoesPsicologos{
    
    private Ipsicologos|int $psicologos;
    private Iflags|int $flags;
    private string $descricao;
    private string $observacoes;
    private string $dia;
    private int $pkAnotacoesPsicologos;
    private IAnotacoesPacientes|int $anotacaoPacietes;


    public function getPsicologos(): Ipsicologos|int{
        return $this->psicologos;
    }

    public function setPsicologos(Ipsicologos|int $psicologos): self{
        $this->psicologos = $psicologos;

        return $this;
    }

    public function getFlags(): Iflags|int{
        return $this->flags;
    }

    public function setFlags(Iflags|int $flags): self{
        $this->flags = $flags;

        return $this;
    }

    public function getDescricao(): string{
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self{
        $this->descricao = $descricao;

        return $this;
    }

    public function getObservacoes(): string{
        return $this->observacoes;
    }

    public function setObservacoes(string $observacoes): self{
        $this->observacoes = $observacoes;

        return $this;
    }

    public function getDia(): string{
        return $this->dia;
    }

    public function setDia(string $dia): self{
        $this->dia = $dia;

        return $this;
    }

    public function getPkAnotacoesPsicologos(): int{
        return $this->pkAnotacoesPsicologos;
    }

    public function setPkAnotacoesPsicologos(int $pkAnotacoesPsicologos): self{
        $this->pkAnotacoesPsicologos = $pkAnotacoesPsicologos;

        return $this;
    }

    public function getAnotacaoPacietes(): IAnotacoesPacientes|int{
        return $this->anotacaoPacietes;
    }

    public function setAnotacaoPacietes(IAnotacoesPacientes|int $anotacaoPacietes): self{
        $this->anotacaoPacietes = $anotacaoPacietes;

        return $this;
    }

    static function create(
        Ipsicologos|int $psicologos,
        Iflags|int $flags,
        string $descricao,
        string $observacoes,
        IAnotacoesPacientes|int $anotacaoPacietes
    ): AnotacoesPsicologos{
        $anotacao = new AnotacoesPsicologos();
        $anotacao->setPsicologos($psicologos);
        $anotacao->setFlags($flags);
        $anotacao->setDescricao($descricao);
        $anotacao->setObservacoes($observacoes);
        $anotacao->setAnotacaoPacietes($anotacaoPacietes);
        return $anotacao;
    }
}


?>