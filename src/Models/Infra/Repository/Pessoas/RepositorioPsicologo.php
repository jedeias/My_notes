<?php 

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use src\Models\Core\Repository\Pessoas\IrepositoryPsicologos;
use src\Models\Infra\Data\Sql;
use PDO;

class RepositorioPsicologo implements IrepositoryPsicologos{
    
    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function insert(Ipsicologos $psicologos) : void{
        try{
            $prepare = $this->MySql->getConnect()->prepare("CALL insertPsicologo(:fkPessoas, :CRP);"); 
            $prepare->bindValue(":fkPessoas", $psicologos->getPessoaPk());   
            $prepare->bindValue(":CRP", $psicologos->getCRP());
            
            $prepare->execute();
        }catch(\PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }

    public function findByPk(Ipsicologos $psicologos) : array{
        //findPsicologoByPk

        try{
            $prepare = $this->MySql->getConnect()->prepare("CALL findPsicologoByPk(:pkPsicologo);");
            $prepare->bindValue(":pkPsicologo", $psicologos->getPsicologoPk());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        }catch(\PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }

    }

    public function findByEmail(Ipsicologos $psicologos) : array{
        
        try{
            $prepare = $this->MySql->getConnect()->prepare("CALL findPsicologoByEmail(:email);");
            $prepare->bindValue(":email", $psicologos->getEmail());
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        }catch(\PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }


    public function findAll() : array{
        try{
            $prepare = $this->MySql->getConnect()->prepare("CALL findAllPsicologos();");
            $prepare->execute();
            
            return $prepare->fetchAll(PDO::FETCH_ASSOC);

        }catch(\PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }
}

?>