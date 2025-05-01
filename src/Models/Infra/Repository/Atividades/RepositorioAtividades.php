<?php

namespace src\Models\Infra\Repository\Atividades;
use src\Models\Core\Entities\Atividades\Iatividades;
use src\Models\Core\Repository\Atividades\IrepositoryAtividaes; 
use src\Models\Infra\Data\Sql;
use PDO;
use PDOException;

class RepositorioAtividades implements IrepositoryAtividaes {

    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    function insert(Iatividades $atividades) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertEndereco(:titulo, :descricao);");
            $prepare->bindValue(":titulo", $atividades->getTitulo());
            $prepare->bindValue(":descricao", $atividades->getDescricao());
            $prepare->execute();
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }
    function update(Iatividades $atividades) : void{
        
    }

    function findByTitle(Iatividades $atividades): array{
        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM atividades WHERE titulo = :titulo;");
            $prepare->bindValue(":titulo", $atividades->getTitulo());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }

    }

    function findByPk(Iatividades $atividades) : array{
        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM atividades WHERE pkAtividade = :pkAtividade;");
            $prepare->bindValue(":pkAtividade", $atividades->getPk());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }

    }
    function findAll() : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM atividades;");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }
}

?>