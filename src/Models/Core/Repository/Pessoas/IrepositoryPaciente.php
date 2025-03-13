<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Pacientes;

interface IrepositoryPaciente{
    public function insert() : void;
    public function findByPk(Pacientes $paciente) : array;
    public function findByEmail(Pacientes $paciente) : array;
    public function findAll() : array;
}

?>
