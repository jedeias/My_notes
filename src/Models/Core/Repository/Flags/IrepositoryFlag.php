<?php

namespace src\Models\Core\Repository\Flags;
use src\Models\Core\Entities\Flags\Iflags;

interface IrepositoryFlag{
    public function insert(Iflags $flags) : void;
    public function update(Iflags $flags) : void;
    public function findByPk(Iflags $flags) : array;
    public function findAll() : array;
}

?>