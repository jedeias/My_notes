<?php

namespace src\Models\Core\Repository\Telefones;
use src\Models\Core\Entities\Telefones\Itelefones;

interface IrepositoryTelefone{
    public function insert(Itelefones $telefones) : void;
    public function update(Itelefones $telefones) : void;
    public function findByPk(Itelefones $telefones) : array;
    public function findAll() : array;
}
?>