<?php

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipessoas;

interface Iresponsavel extends Ipessoas{

    public function getResponsavelPk() : int;
    public function setResponsavelPk(int $responsavelPk) : self;

}

?>