<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Repository\Pessoas\IrepositoryPaciente;
use src\Models\Infra\Data\Sql;
use PDO;
use PDOException;

class RepositorioPaciente implements IrepositoryPaciente{
    
    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function insert(Pacientes $pacientes) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertPacientes(:fkPessoas, :fkPsicologo, :fkResponsavel);");
            
            $prepare->BindValue(":fkPessoas", $pacientes->getPessoaPk());
            $prepare->BindValue(":fkPsicologo", $pacientes->getPsicologo()->getPsicologoPk());

            if(!$pacientes->getResponsavel()){
                $prepare->BindValue(":fkResponsavel", null);
            }else{
                $prepare->BindValue(":fkResponsavel", $pacientes->getResponsavel()->getPessoaPk());
            }
            
            $prepare->execute();
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            echo $erros->getMessage();
        }
    }
    public function findByPk(Pacientes $pacientes) : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findPacienteByPk(:pkPaciente);");
            
            $prepare->BindValue(":pkPaciente", $pacientes->getPacientesPk());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
    }
    public function findByEmail(Pacientes $pacientes) : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findPacienteByEmail(:email);");
            
            $prepare->BindValue(":email", $pacientes->getEmail());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
    }
    public function findAll() : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findAllPacientes();");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
    }


}


?>