<?php 

namespace src\Models\Core\Entities\Flags;
use src\Models\Core\Entities\Flags\Iflags;


class Flags implements Iflags{
    private int $pkFlags;
    private string $color;
    private string $tituloDaFlag;
    private string $descricao;

    
    public function getPkFlags(): int{
        return $this->pkFlags;
    }

    
    public function setPkFlags(int $pkFlags): self{
        $this->pkFlags = $pkFlags;
        return $this;
    }

    
    public function getColor(): string{
        return $this->color;
    }

    
    public function setColor(string $color): self{
        $this->color = $color;
        return $this;
    }

    
    public function getTituloDaFlag(): string{
        return $this->tituloDaFlag;
    }

    
    public function setTituloDaFlag(string $tituloDaFlag): self{
        $this->tituloDaFlag = $tituloDaFlag;
        return $this;
    }

    
    public function getDescricao(): string{
        return $this->descricao;
    }

    
    public function setDescricao(string $descricao): self{
        $this->descricao = $descricao;
        return $this;
    }

    public static function create(string $color, string $tituloDaFlag, string $descricao): Flags{
        $flags = new Flags();
        $flags->setColor($color)->setTituloDaFlag($tituloDaFlag)->setDescricao($descricao);
        return $flags;
    }

}


?>