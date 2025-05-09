<?php

namespace src\Models\Infra\Repository\Login;
use src\Models\Infra\Data\Sql;
use PDO;
use PDOException;

class RepositorioLogin {

    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function findAllTypePessoasByEmailAndPasswords(string $email, string $senha) : array|null {
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findAllTypePessoasByEmailAndPassword(:email, :senha);");
            $prepare->bindParam(":email", $email);
            $prepare->bindParam(":senha", $senha);
            $prepare->execute();

            $data = $prepare->fetchAll(PDO::FETCH_ASSOC)[0];

            if(empty($data) || !$data || $data == null){
                return[];
            }else{
                return $data;
            }
        } catch (PDOException $erros) {
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }
    
}

?>