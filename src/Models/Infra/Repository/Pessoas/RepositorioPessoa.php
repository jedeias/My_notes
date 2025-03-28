<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipessoas;
use src\Models\Core\Repository\Pessoas\IrepositoryPessoas;
use src\Models\Infra\Data\Sql;
use PDO;
use PDOException;

class RepositorioPessoa implements IrepositoryPessoas{

    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function insert(Ipessoas $pessoa) : void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertPessoa(
            :nome, 
            :email, 
            :senha,
            :dataNasc,
            :RG,
            :CPF,
            :sexo,
            :image,
            :fkTelefone,
            :fkEndereco);");
            
            $prepare->bindValue(":nome", $pessoa->getNome());
            $prepare->bindValue(":email", $pessoa->getEmail());
            $prepare->bindValue(":senha", $pessoa->getSenha());
            $prepare->bindValue(":dataNasc", $pessoa->getDataDeNascimento());
            $prepare->bindValue(":RG", $pessoa->getRG());
            $prepare->bindValue(":CPF", $pessoa->getNome());
            $prepare->bindValue(":sexo", $pessoa->getSexo());
            $prepare->bindValue(":image", $pessoa->getImageLocal());
            $prepare->bindValue(":fkTelefone", $pessoa->getTelefone()->getPkTelefone());
            $prepare->bindValue(":fkEndereco", $pessoa->getEndereco()->getPkEndereco());
            $prepare->execute();
        
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }

    function findByPK(Ipessoas $pessoa) : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM pessoas WHERE pkPessoa = :pkPessoa;");
            $prepare->bindValue(":pkPessoa", $pessoa->getPessoaPk());	
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }


    function findByEmail(Ipessoas $pessoa) : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM pessoas WHERE email = :email;");
            $prepare->bindValue(":email", $pessoa->getEmail());	
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }

    function findAll() : array{
        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT pkPessoa, nome, email, dataDeNascimento, RG, sexo, imageLocal, fkTelefone, fkEndereco FROM pessoas;");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }
    
}

?>