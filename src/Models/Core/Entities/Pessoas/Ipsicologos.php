<?php

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipessoas;

interface Ipsicologos extends Ipessoas{

    
    public function getPsicologosPk(): int;
    public function setPsicologosPk(int $psicologoPk): self;

    public function getCRP(): string;

    public function setCRP(string $CRP): self;
}

?>