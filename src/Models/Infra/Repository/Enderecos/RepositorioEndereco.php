<?php

namespace src\Models\Infra\Repository\Enderecos;
use src\Models\Core\Entities\Enderecos\Ienderecos;
use src\Models\Core\Repository\Enderecos\IrepositoryEndereco;
use src\Models\Infra\Data\Sql;
use PDO;

class RepositorioEndereco implements IrepositoryEndereco {

    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function insert(Ienderecos $endereco) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertEndereco(:rua,:numero, :complemento, :bairro, :cep, :cidade, :estado);");
            
            $prepare->bindValue(":rua", $endereco->getRua());
            $prepare->bindValue(":numero", $endereco->getNumero());
            $prepare->bindValue(":complemento", $endereco->getComplemento());
            $prepare->bindValue(":bairro", $endereco->getBairro());
            $prepare->bindValue(":cep", $endereco->getCep());
            $prepare->bindValue(":cidade", $endereco->getCidade());
            $prepare->bindValue(":estado", $endereco->getEstado());
            $prepare->execute();
        
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }
    function update(Ienderecos $endereco) : void{
        
    }

    function findByCep(Ienderecos $endereco): array{        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM enderecos WHERE cep = :cep;");
            $prepare->bindValue(":cep", $endereco->getCep());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
    }

    function findByPk(Ienderecos $endereco) : array{
        #REVISAR DPS.
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM enderecos WHERE pkEndereco = :pkEndereco;");
            $prepare->bindValue(":pkEndereco", $endereco->getPkEndereco());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }

    }
    function findAll() : array{
        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM enderecos;");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }
    
}

?>