<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Repository\Pessoas\IrepositorySecretarios;
use src\Models\Infra\Data\Sql;
use src\Models\Core\Entities\Pessoas\Isecretarios;
use PDO;
use PDOException;

class RepositorioSecretarios implements IrepositorySecretarios{

    private Sql $MySql; 

    public function __construct() {
        $this->MySql = new Sql();
    }

    
    public function insert(Isecretarios $secretarios) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertSecretario(:fkPessoa);");
            $prepare->bindValue(":fkPessoa", $secretarios->getPessoaPk());
            $prepare->execute();

        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }

    public function findByPk(Isecretarios $secretarios) : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findSecretarioByPk(:pkSecretario);");
            $prepare->bindValue(":pkSecretario", $secretarios->getSecretariosPk());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }

    public function findByEmail(Isecretarios $secretarios) : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findSecretarioByEmail(:email);");
            $prepare->bindValue(":CRP", $secretarios->getEmail());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }

    public function findAll() : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findAllSecretarios();");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }

}

?>