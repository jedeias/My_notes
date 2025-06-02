<?php

namespace src\Models\Infra\Repository\Consultas;

use src\Models\Core\Entities\Consultas\Iconsultas;
use src\Models\Core\Entities\Pessoas\Ipacientes;
use src\Models\Infra\Repository\Pessoas\RepositorioPacientes;
// use src\Models\Core\Repository\Consultas\IrepositoryConsutas;
use src\Models\Infra\Data\Sql;
use PDOException;
use PDO;

class RepositorioConsutas{
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

    public function findAllConsultasPsicologo(int $pk): array{
        try{    
            $stmt = $this->Mysql->getConnect()->prepare("call findAllConsultasPsicologo(:pk)");
            $stmt->bindValue(":pk", $pk);
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
    
        public function findAllConsultasPaciente(int $pk): array{
        try{    
            $stmt = $this->Mysql->getConnect()->prepare("call findAllConsultasPaciente(:pk)");
            $stmt->bindValue(":pk", $pk);
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
            }
            
            $stmt = $this->Mysql->getConnect()->prepare("Call findByPkconsultas(:pk);");
            $stmt->bindValue(":pk", $pkConsultas);
            $stmt->execute();
            
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            if(empty($data)){
                return [];
            }
            return $data;

        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }

    public function insert(Iconsultas $consulta): void{
        try{
            // $consulta->setPacientes($this->cheackedPacientes($consulta->getPacientes()));

            $stmt = $this->Mysql->getConnect()->prepare("Call insertConsulta(:fkPaciente, :dataHora);");
            $stmt->bindValue(":fkPaciente", $consulta->getPacientes());
            $stmt->bindValue(":dataHora", $consulta->getDiaEHora());
            $stmt->execute();
            
        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }
    
    public function update(Iconsultas $consulta): void{
        try{    
            $stmt = $this->Mysql->getConnect()->prepare("call updateConsultas(:pkConsulta, :data)");
            $stmt->bindValue(":pkConsulta", $consulta->getPkConsultas());
            $stmt->bindValue(":data", $consulta->getDiaEHora());
            $stmt->execute();
            

        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }
    public function delete(int $pkConsultas): bool{
        try{    
            $stmt = $this->Mysql->getConnect()->prepare("DELETE FROM consultas WHERE :pkConsulta");
            $stmt->bindValue(":pkConsulta", $pkConsultas);
            $stmt->execute();
            

        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
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