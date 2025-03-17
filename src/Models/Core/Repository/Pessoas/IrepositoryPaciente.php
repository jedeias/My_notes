<?php

namespace src\Models\Core\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Pacientes;

interface IrepositoryPaciente{
    public function insert(Pacientes $paciente) : void;
    public function findByPk(Pacientes $paciente) : array;
    public function findByEmail(Pacientes $paciente) : array;
    public function findAll() : array;
}

?>