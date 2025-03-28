<?php 

namespace src\Models\Core\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Isecretarios;

interface IrepositorySecretarios{
    public function insert(Isecretarios $secretarios) : void;
    public function findByPk(Isecretarios $secretarios) : array;
    public function findByEmail(Isecretarios $secretarios) : array;
    public function findAll() : array;
}

?>