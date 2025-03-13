<?php

namespace src\Models\Infra\Repository\Telefones;
use src\Models\Core\Entities\Telefones\Itelefones;
use src\Models\Core\Repository\Telefones\IrepositoryTelefone;
use src\Models\Infra\Data\Sql;
use PDO;

class RepositorioTelefone implements IrepositoryTelefone {

    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function insert(Itelefones $telefones) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertTelefone(:ddd, :numero);");
            
            $prepare->bindValue(":ddd", $telefones->getDDD());
            $prepare->bindValue(":numero", $telefones->getNumero());
            $prepare->execute();
        
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }
    function update(Itelefones $telefones) : void{
        
    }

    function findByPk(Itelefones $telefones) : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM telefones WHERE pkTelefone = :pkTelefone;");
            $prepare->bindValue(":pkTelefone", $telefones->getPkTelefone());	
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }

    function findAll() : array{
        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM telefones;");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }
    
}

?>