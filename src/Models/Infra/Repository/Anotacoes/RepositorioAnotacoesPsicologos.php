<?php

namespace Src\Models\Infra\Repository\Anotacoes;

use src\Models\Core\Repository\Anotacoes\IrepositoryAnotacoesPsicologos;
use src\Models\Core\Entities\Anotacoes\IanotacoesPsicologos;
use Src\Models\Core\Entities\Anotacoes\IanotacoesPacientes;
use src\Models\Infra\Data\Sql;
use PDOException;
use PDO;

class RepositorioAnotacoesPsicologos implements IrepositoryAnotacoesPsicologos {
    private Sql $MySql;

    public function __construct() {
        $this->MySql = new Sql();
    }

    public function findAnotacaoPsicologosByPkAnotacaoPaciente(IanotacoesPacientes|int $pkAnotacoesPsicologos): array{
        try{
            if ($pkAnotacoesPsicologos instanceof IanotacoesPacientes) {
                $pk = $pkAnotacoesPsicologos->getPkAnotacoesPacientes();
            }
            else {
                $pk = $pkAnotacoesPsicologos;
            }

            $prepare = $this->MySql->getConnect()->prepare("CALL findAnotacoesPsicologosByPkAnotacoesPacientes(:pk);");
            $prepare->bindValue(":pk", $pk);
            $prepare->execute();
            $data = $prepare->fetchAll(PDO::FETCH_ASSOC);

            if (empty($data)) {
                return [];
            } else {
                return $data;
            }
        } catch (PDOException $erros) {
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }


    public function insert(IanotacoesPsicologos $anotacao): void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertAnotacoesPsicologos(:fkPsicolgo, :fkFlag, :fkAnotacoesPacientes, :observacao :dia);");
            $prepare->bindValue(":fkPsicolgo", $anotacao->getPsicologos()->getPsicologosPk());
            $prepare->bindValue(":fkFlag", $anotacao->getFlags()->getPkFlags());
            $prepare->bindValue(":fkAnotacoesPacientes", $anotacao->getAnotacaoPacietes()->getPkAnotacoesPacientes());
            $prepare->bindValue(":observacao", $anotacao->getObservacoes());
            $dataHora = date('Y-m-d H:i:s');
            $prepare->bindValue(":dia",$dataHora );
            $prepare->execute();
        } catch (PDOException $erros) {
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }
    public function update(IanotacoesPsicologos $anotacao): void{
        // aqui vou fazer o update porem preciso de analizar se faço o update sobre escrevendo um update simple o com inner join
    }
}

?>