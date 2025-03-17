<?php

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipessoas;

interface Ipsicologos extends Ipessoas{

    
    public function getPsicologoPk(): int;
    public function setPsicologoPk(int $psicologoPk): self;

    public function getCRP(): string;

    public function setCRP(string $CRP): self;
}

?>