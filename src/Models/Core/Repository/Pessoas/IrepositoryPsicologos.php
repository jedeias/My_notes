<?php

namespace src\Models\Core\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipsicologos;

interface IrepositoryPsicologos{
    public function insert(Ipsicologos $psicologos) : void;
    public function findByPk(Ipsicologos $psicologos) : array;
    public function findByEmail(Ipsicologos $psicologos) : array;
    public function findAll() : array;
}

?>