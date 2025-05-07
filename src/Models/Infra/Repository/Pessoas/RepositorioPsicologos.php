<?php 

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use src\Models\Core\Repository\Pessoas\IrepositoryPsicologos;
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;
use src\Models\Infra\Data\Sql;
use src\Models\Core\Entities\Pessoas\Ipessoas;
use PDO;
use PDOException;

class RepositorioPsicologos implements IrepositoryPsicologos{
    
    private Sql $MySql;
    private RepositorioPessoa $repositorioPessoa;

    public function __construct() {
        $this->MySql = new Sql();
        $this->repositorioPessoa = new RepositorioPessoa();
    }

    public function insert(Ipsicologos $psicologos) : void{
        try{
            $psicologos->setPessoaPk($this->cheackedPessoas($psicologos));

            $prepare = $this->MySql->getConnect()->prepare("CALL insertPsicologo(:fkPessoas, :CRP);"); 
            $prepare->bindValue(":fkPessoas", $psicologos->getPessoaPk());   
            $prepare->bindValue(":CRP", $psicologos->getCRP());
            
            $prepare->execute();
        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }

    public function findByPk(Ipsicologos $psicologos) : array{
        //findPsicologoByPk

        try{
            $prepare = $this->MySql->getConnect()->prepare("CALL findPsicologoByPk(:pkPsicologo);");
            $prepare->bindValue(":pkPsicologo", $psicologos->getPsicologosPk());
            $prepare->execute();

            $data = $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
            if(empty($data)){
                return [];
            }else{
                return $data;;;
            }
        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }

    }

    public function findByEmail(Ipsicologos $psicologos) : array{
        
        try{
            $prepare = $this->MySql->getConnect()->prepare("CALL findPsicologoByEmail(:email);");
            $prepare->bindValue(":email", $psicologos->getEmail());
            $prepare->execute();
            
            $data = $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
            if(empty($data)){
                return [];
            }else{
                return $data;;;
            }
        }catch(PDOException $erros){
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }


    public function findAll() : array{
        try{
            $prepare = $this->MySql->getConnect()->prepare("CALL findAllPsicologos();");
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