<?php 

namespace src\Models\Core\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipessoas;

interface IrepositoryPessoas{
    public function insert(Ipessoas $pessoas) : void;
    public function findByPk(Ipessoas $pessoas) : array;
    public function findByEmail(Ipessoas $pessoas) : array;
    public function findAll() : array;
}

?>