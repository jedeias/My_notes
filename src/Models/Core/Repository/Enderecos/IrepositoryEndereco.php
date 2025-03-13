<?php

namespace src\Models\Core\Repository\Enderecos;
use src\Models\Core\Entities\Enderecos\Ienderecos;

interface IrepositoryEndereco{
    public function insert(Ienderecos $endereco) : void;
    public function update(Ienderecos $endereco) : void;
    public function findByCep(Ienderecos $endereco) : array;
    public function findByPk(Ienderecos $endereco) : array;
    public function findAll() : array;
}



?>