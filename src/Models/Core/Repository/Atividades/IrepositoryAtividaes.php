<?php 

namespace src\Models\Core\Repository\Atividades;
use src\Models\Core\Entities\Atividades\Iatividades;

interface IrepositoryAtividaes{
    public function insert(Iatividades $atividades) : void;
    public function update(Iatividades $atividades) : void;
    public function findByTitle(Iatividades $atividades) : array;
    public function findByPk(Iatividades $atividades) : array;
    public function findAll() : array;
}



?>
