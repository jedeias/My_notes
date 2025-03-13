<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Infra\Repository\Pessoas\IrepositoryPaciente;
use src\Models\Infra\Data\Sql;
use PDO;

class RepositorioPaciente implements IrepositoryPaciente{
    
    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function insert() : void{
        // Precisos setar o parametro na interface, implementar a call insertPacientes que já existe no banco
        //OBS preciso voltar adicionado a chave primaria de Psicologos e Secretarios e Responsaveis, eles tem apenas a chave de pessoas.
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