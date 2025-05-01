<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Core\Entities\Pessoas\Ipessoas;
use src\Models\Core\Entities\Telefones\Telefones;
use src\Models\Core\Repository\Pessoas\IrepositoryPessoas;
use src\Models\Infra\Data\Sql;
use src\Models\Infra\Repository\Enderecos\RepositorioEndereco;
use src\Models\Infra\Repository\Telefones\RepositorioTelefone;
use PDO;
use PDOException;

class RepositorioPessoa implements IrepositoryPessoas{

    private Sql $MySql;
    private RepositorioEndereco $repositorioEndereco;
    private RepositorioTelefone $repositorioTelefone;

    public function __construct() {
        $this->MySql = new Sql();
        $this->repositorioEndereco = new RepositorioEndereco();
        $this->repositorioTelefone = new RepositorioTelefone();
    }

    public function insert(Ipessoas $pessoa) : void{
        try {

            $pessoa->getEndereco()->setPkEndereco($this->cheackedEndereco($pessoa->getEndereco()));
            $pessoa->getTelefone()->setPkTelefone($this->cheackedTelefone($pessoa->getTelefone()));

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
        
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }

    }

    function findByPK(Ipessoas $pessoa) : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM pessoas WHERE pkPessoa = :pkPessoa;");
            $prepare->bindValue(":pkPessoa", $pessoa->getPessoaPk());	
            $prepare->execute();
            $data = $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
            if(empty($data)){
                return [];
            }else{
                return $data;;
            }
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }

    public function findByCPF(Ipessoas $pessoa) : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM pessoas WHERE CPF = :CPF;");
            $prepare->bindValue(":CPF", $pessoa->getCPF());	
            $prepare->execute();

            $data = $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
            if(empty($data)){
                return [];
            }else{
                return $data;
            }
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }



    function findByEmail(Ipessoas $pessoa) : array{

        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM pessoas WHERE email = :email;");
            $prepare->bindValue(":email", $pessoa->getEmail());	
            $prepare->execute();

            $data = $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
            if(empty($data)){
                return [];
            }else{
                return $data;
            }
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }

    function findAll() : array{
        
        try {
            $prepare = $this->MySql->getConnect()->prepare("SELECT pkPessoa, nome, email, dataDeNascimento, RG, sexo, imageLocal, fkTelefone, fkEndereco FROM pessoas;");
            $prepare->execute();

            $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
            if(empty($data)){
                return [];
            }else{
                return $data;;
            }
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
        
    }

    public function cheackedEndereco(Enderecos $enderecos): int{
        $dataBaseRequest = $this->repositorioEndereco->findByRuaAndNumero($enderecos);

        if(empty($dataBaseRequest) || $dataBaseRequest == null){
            $this->repositorioEndereco->insert($enderecos);

            $dataBaseRequest = $this->repositorioEndereco->findByRuaAndNumero($enderecos);

            $retrunPk = $dataBaseRequest["pkEndereco"];

        }else{
            $retrunPk = $dataBaseRequest["pkEndereco"];
        }

        return $retrunPk;
    }
    

    public function cheackedTelefone(Telefones $telefones): int {
        $dataBaseRequests = $this->repositorioTelefone->findByNumero($telefones);
        
        if(empty($dataBaseRequests) || $dataBaseRequests == null){
            $this->repositorioTelefone->insert($telefones);

            $dataBaseRequests = $this->repositorioTelefone->findByNumero($telefones);

            $retrunPk = $dataBaseRequests["pkTelefone"];   
        }else{
            $retrunPk = $dataBaseRequests["pkTelefone"];
        }
        return $retrunPk;
    }
}

?>