<?php

namespace src\Models\Infra\Repository\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipessoas;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Repository\Pessoas\IrepositoryPaciente;
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;
use src\Models\Infra\Data\Sql;
use PDO;
use PDOException;

class RepositorioPacientes implements IrepositoryPaciente{
    
    private Sql $MySql;
    private RepositorioPessoa $repositorioPessoa;
    private RepositorioPsicologos $repositorioPsicologos;

    public function __construct() {
        $this->MySql = new Sql();
        $this->repositorioPessoa = new RepositorioPessoa();    
        $this->repositorioPsicologos = new RepositorioPsicologos();  
    }

    public function insert(Pacientes $pacientes) : void{
        try {

            $pacientes->setPessoaPk($this->cheackedPessoas($pacientes));
            $pacientes->setPsicologo($this->cheackedPsicologo($pacientes->getPsicologo()));

            $prepare = $this->MySql->getConnect()->prepare("CALL insertPacientes(:fkPessoas, :fkPsicologo, :fkResponsavel);");
            
            $prepare->BindValue(":fkPessoas", $pacientes->getPessoaPk());
            $prepare->BindValue(":fkPsicologo", $pacientes->getPsicologo()->getPsicologosPk());

            if(!$pacientes->getResponsavel()){
                $prepare->BindValue(":fkResponsavel", null);
            }else{
                $prepare->BindValue(":fkResponsavel", $pacientes->getResponsavel()->getPessoaPk());
            }
            
            $prepare->execute();
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            echo $erros->getMessage();
        }
    }
    public function findByPk(Pacientes $pacientes) : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findPacienteByPk(:pkPaciente);");
            
            $prepare->BindValue(":pkPaciente", $pacientes->getPacientesPk());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
    }

    public function findPacienteComLike(string $pacientes) : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("
            SELECT * FROM pacientes
            INNER JOIN pessoas ON pacientes.fkPessoa = pessoas.pkPessoa
            WHERE pessoas.nome LIKE :nome;
            ");
            
            $prepare->BindValue(":nome", "%$pacientes%");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
    }
    public function findByEmail(Pacientes $pacientes) : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findPacienteByEmail(:email);");
            
            $prepare->BindValue(":email", $pacientes->getEmail());
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erros) {
            
            echo("tivemos um erro.:");
            
            return[$erros->getMessage()];
        }
    }
    public function findAll() : array{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findAllPacientes();");
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erros) {
            
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

    public function cheackedPsicologo(Ipsicologos $psicologo): Ipsicologos {
        $dataPessoas = $this->repositorioPessoa->findByEmail($psicologo);
        $dataPsicologos = $this->repositorioPsicologos->findByEmail($psicologo);

        if($dataPessoas == null || empty($dataPessoas) && $dataPsicologos == null || empty($dataPsicologos)){
            $this->repositorioPessoa->insert($psicologo);
            
            $dataPessoas = $this->repositorioPessoa->findByEmail($psicologo);
            
            $psicologo->setPessoaPk($dataPessoas["pkPessoa"]);

            $this->repositorioPsicologos->insert($psicologo);
            
            $dataPsicologos = $this->repositorioPsicologos->findByEmail($psicologo);

            $psicologo->setCRP($dataPsicologos["CRP"]);
            $psicologo->setPsicologosPk($dataPsicologos["pkPsicologo"]);
            $psicologo->setPessoaPk($dataPsicologos["pkPessoa"]);

            return $psicologo;
        }else if($dataPsicologos == null || empty($dataPsicologos)){
            
            $psicologo->setPessoaPk($dataPessoas["pkPessoa"]);

            $this->repositorioPsicologos->insert($psicologo);
            
            $psicologo->setCRP($dataPsicologos["CRP"])->
            $psicologo->setPsicologosPk($dataPsicologos["pkPsicologo"])->
            $psicologo->setPessoaPk($dataPsicologos["pkPessoa"]);

            return $psicologo;
        }else{

            $psicologo->setPessoaPk($dataPessoas["pkPessoa"]);

            $psicologo->setCRP($dataPsicologos["CRP"]);
            $psicologo->setPsicologosPk($dataPsicologos["pkPsicologo"]);
            $psicologo->setPessoaPk($dataPsicologos["pkPessoa"]);

            return $psicologo;
        }

    }

}


?>