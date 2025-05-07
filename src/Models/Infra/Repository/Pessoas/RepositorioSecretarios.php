<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Repository\Pessoas\IrepositorySecretarios;
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;
use src\Models\Infra\Data\Sql;
use src\Models\Core\Entities\Pessoas\Isecretarios;
use src\Models\Core\Entities\Pessoas\Ipessoas;
use PDO;
use PDOException;

class RepositorioSecretarios implements IrepositorySecretarios{

    private Sql $MySql; 
    private RepositorioPessoa $repositorioPessoa;

    public function __construct() {
        $this->MySql = new Sql();
        $this->repositorioPessoa = new RepositorioPessoa();
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

    public function cheackedPessoas(Ipessoas $pessoas): int {
        $dataPessoas = $this->repositorioPessoa->findByEmail($pessoas);

        if(!$dataPessoas || $dataPessoas == null || empty($dataPessoas)){
            $this->repositorioPessoa->insert($pessoas);
            
            $dataPessoas = $this->repositorioPessoa->findByEmail($pessoas);
            return $dataPessoas["pkPessoa"];
        }else{
            return $dataPessoas["pkPessoa"];
        }

    }

    

}

?>