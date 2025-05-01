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

    public function findAllTypePessoasByEmailAndPasswords(string $email, string $senha) : array {
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL findAllTypePessoasByEmailAndPassword(:email, :senha);");
            $prepare->bindValue(":email", $email);
            $prepare->bindValue(":senha", $senha);
            $prepare->execute();

            return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $erros) {
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }
    
}

?>