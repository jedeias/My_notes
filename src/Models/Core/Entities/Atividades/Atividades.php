<?php

namespace src\Models\Core\Entities\Atividades;
use src\Models\Core\Entities\Atividades\Iatividades;


class Atividades implements Iatividades{
    private int $pk;
    private string $titulo;
    private string $descricao;
    

    public function getPk(): int{
        return $this->pk;
    }

    public function setPk(int $pk): self{
        $this->pk = $pk;
        return $this;
    }

    public function getTitulo(): string{
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self{
        $this->titulo = $titulo;
        return $this;
    }

    public function getDescricao(): string{
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self{
        $this->descricao = $descricao;
        return $this;
    }

    static function create(string $titulo, string $descricao): self{
        $atividade = new Atividades();

        return $atividade->setTitulo($titulo)->setDescricao($descricao);
    }
}


?>
