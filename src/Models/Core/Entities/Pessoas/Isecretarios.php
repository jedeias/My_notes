<?php

namespace Src\Models\Core\Entities\Pessoas;

interface Isecretarios extends Ipessoas{
    public function getSecretariosPk(): int;
    
    public function setSecretariosPk(int $SecretariosPk): self;
}

?>