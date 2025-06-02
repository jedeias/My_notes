<?php

namespace src\Models\Core\Entities\Consultas;
use src\Models\Core\Entities\Pessoas\Ipacientes;
use src\Models\Core\Entities\Consultas\Iconsultas;

class Consultas implements Iconsultas {
    private int $pacientes;
    private string $diaEHora;
    private int $pkConsultas;


    public function getPacientes(): int{
        return $this->pacientes;
    }


    public function setPacientes(int $pacientes): self{
        $this->pacientes = $pacientes;

        return $this;
    }


    public function getDiaEHora(): string{
        return $this->diaEHora;
    }


    public function setDiaEHora(string $dia): self{
        $this->diaEHora = $dia;
        return $this;
    }

    public function getPkConsultas(): int{
        return $this->pkConsultas;
    }


    public function setPkConsultas(int $pkConsultas): self{
        $this->pkConsultas = $pkConsultas;
        return $this;
    }


    static function create(int $paciente, string $dia, string $hora): Iconsultas{
        $consulta = new Consultas();
        $consulta->setPacientes($paciente);
        $consulta->setDiaEHora($dia);
        return $consulta;
    }
    
}


?>