<?php

namespace src\Models\Infra\Repository\Consutas;
use Src\Models\Core\Entities\Consultas\Iconsultas;
use src\Models\Core\Entities\Pessoas\Ipacientes;
use src\Models\Core\Repository\Consultas\IrepositoryConsutas;
use src\Models\Infra\Data\Sql;
use PDOException;
use PDO;
use src\Models\Infra\Repository\Pessoas\RepositorioPacientes;

class RepositorioConsutas implements IrepositoryConsutas{
    
    private Sql $Mysql;
    private RepositorioPacientes $repositorioPacientes;

    public function __construct(){
        $this->Mysql = new Sql();
        $this->repositorioPacientes = new RepositorioPacientes();
    }
    public function findAllConsultas(): array{
        try{    
            $stmt = $this->Mysql->getConnect()->prepare("call findAllConsultas()");
            $stmt->execute();
            
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($data)){
                return [];
            }else{
                return $data;                
            }
        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }
    public function findByPKConsulta(int|Iconsultas $pkConsultas): array{
        try{
            if($pkConsultas instanceof Iconsultas){
                
                $pkConsultas = $pkConsultas->getPkConsultas();
            }else
            $stmt = $this->Mysql->getConnect()->prepare("Call findByPkconsultas(:pk);");
            $stmt->bindValue(":pk", $pkConsultas);
            $stmt->execute();
            
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            if(empty($data)){
                return [];
            }else{
                return $data;                
            }
        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }
    public function insert(Iconsultas $consulta): void{
        try{
            $consulta->setPacientes($this->cheackedPacientes($consulta->getPacientes()));

            $stmt = $this->Mysql->getConnect()->prepare("Call insertConsulta(:fkPaciente, :dataHora);");
            $stmt->bindValue(":fkPaciente", $consulta->getPacientes()->getPacientesPk());



            $stmt->bindValue(":dataHora", $consulta->setDia());
            $stmt->execute();
            
        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }
    public function update(Iconsultas $consulta): void{

    }
    public function delete(int $pkConsultas): bool{

    }

    private function cheackedPacientes(Ipacientes $pacientes): int {
        $dataPacientes = $this->repositorioPacientes->findByEmail($pacientes);

        if(!$dataPacientes || $dataPacientes == null || empty($dataPacientes)){
            $this->repositorioPacientes->insert($pacientes);
            
            $dataPacientes = $this->repositorioPacientes->findByEmail($pacientes);
            return $dataPacientes["pkPaciente"];
        }else{
            return $dataPacientes["pkPaciente"];
        }

    }
}


?>