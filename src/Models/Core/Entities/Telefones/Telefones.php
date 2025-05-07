<?php

namespace src\Models\Core\Entities\Telefones;
use src\Models\Core\Entities\Telefones\Itelefones;
class Telefones implements Itelefones{
    private int $pkTelefone;
    private int $DDD;
    private int $numero;

    public function getPkTelefone(): int{
        return $this->pkTelefone;
    }

    public function setPkTelefone(int $pkTelefone): self{
        $this->pkTelefone = $pkTelefone;
        return $this;
    }

    public function getDDD(): int{
        return $this->DDD;
    }

    public function setDDD(int $DDD): self{
        $this->DDD = $DDD;
        return $this;
    }

    public function getNumero(): int{
        return $this->numero;
    }

    public function setNumero(int $numero): self{
        $this->numero = $numero;
        return $this;
    }

    public static function create(int $DDD, int $numero): self{
        $instance = new self();
        $instance->setDDD($DDD)->setNumero($numero);
        return $instance;
    }
}


?>