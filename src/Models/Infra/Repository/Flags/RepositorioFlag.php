<?php

namespace src\Models\Infra\Repository\Flags;
use src\Models\Core\Entities\Flags\Iflags;
use src\Models\Core\Repository\Flags\IrepositoryFlag;
use src\Models\Infra\Data\Sql;
use PDO;
use PDOException;

class RepositorioFlag implements IrepositoryFlag {

    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function insert(Iflags $flags) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertFlags(:cor, :titulo, :descricao);");
            
            $prepare->bindValue(":cor", $flags->getColor());
            $prepare->bindValue(":titulo", $flags->getTituloDaFlag());
            $prepare->bindValue(":descricao", $flags->getDescricao());
            $prepare->execute();
        
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }
    function update(Iflags $flags) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL updateFlags(:pkFlag, :color, :titulo, :descricao)");
            $prepare->bindValue(":pkFlag", $flags->getPkFlags());	
            $prepare->bindValue(":color", $flags->getColor());	
            $prepare->bindValue(":titulo", $flags->getTituloDaFlag());	
            $prepare->bindValue(":descricao", $flags->getDescricao());	
            $prepare->execute();

        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
        }
    }

    function findByPk(Iflags $flags) : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM flags WHERE pkFlag = :pkFlag;");
            $prepare->bindValue(":pkFlag", $flags->getPkFlags());	
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }

    function findAll() : array{
        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM flags;");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }
    
}

?>