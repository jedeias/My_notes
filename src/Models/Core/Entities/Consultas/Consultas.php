<?php

namespace Src\Models\Core\Entities\Consultas;
use Src\Models\Core\Entities\Pessoas\Ipacientes;
use Src\Models\Core\Entities\Consultas\Iconsultas;

class Consultas implements Iconsultas {
    private Ipacientes|int $pacientes;
    private string $dia;
    private string $hora;
    private int $pkConsultas;


    public function getPacientes(): Ipacientes|int{
        return $this->pacientes;
    }


    public function setPacientes(Ipacientes|int $pacientes): self{
        $this->pacientes = $pacientes;

        return $this;
    }


    public function getDiaEHora(): string{
        return $this->dia;
    }


    public function setDiaEHora(string $dia): self{
        $this->dia = $dia;

        return $this;
    }

    public function getPkConsultas(): int{
        return $this->pkConsultas;
    }


    public function setPkConsultas(int $pkConsultas): self{
        $this->pkConsultas = $pkConsultas;

        return $this;
    }


    static function create(Ipacientes|int $paciente, string $dia, string $hora): Iconsultas{
        $consulta = new Consultas();
        $consulta->setPacientes($paciente);
        $consulta->setDiaEHora($dia);
        return $consulta;
    }
    
}


?>