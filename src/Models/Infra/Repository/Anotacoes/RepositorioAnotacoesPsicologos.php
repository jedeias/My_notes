<?php

namespace Src\Models\Infra\Repository\Anotacoes;

use src\Models\Core\Repository\Anotacoes\IrepositoryAnotacoesPsicologos;
use src\Models\Core\Entities\Anotacoes\IanotacoesPsicologos;
use Src\Models\Core\Entities\Anotacoes\IanotacoesPacientes;
use Src\Models\Infra\Security\AES\CryptoService;
use src\Models\Infra\Data\Sql;
use PDOException;
use PDO;

class RepositorioAnotacoesPsicologos implements IrepositoryAnotacoesPsicologos {
    private Sql $MySql;
    private CryptoService $cryptoService;

    public function __construct() {
        $this->MySql = new Sql();
        $this->cryptoService = new CryptoService();
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


    public function insert(IanotacoesPsicologos $anotacao): void {
        try {
            $conn = $this->MySql->getConnect();

            // 🔥 CORREÇÃO AQUI
            $dataInSecrity = $this->cryptoService
                ->encrypt($anotacao->getObservacoes());

            $sql = "CALL insertAnotacoesPsicologos(
                :fkPsicologo,
                :fkFlag,
                :fkAnotacoesPacientes,
                :observacao,
                :dia,
                :IV,
                :tag
            );";

            $prepare = $conn->prepare($sql);

            $prepare->bindValue(":fkPsicologo", $anotacao->getPsicologos()->getPsicologosPk(), PDO::PARAM_INT);
            $prepare->bindValue(":fkFlag", $anotacao->getFlags()->getPkFlags(), PDO::PARAM_INT);
            $prepare->bindValue(":fkAnotacoesPacientes", $anotacao->getAnotacaoPacietes()->getPkAnotacoesPacientes(), PDO::PARAM_INT);

            $prepare->bindValue(":observacao", $dataInSecrity['ciphertext']);
            $prepare->bindValue(":IV", $dataInSecrity['iv']);
            $prepare->bindValue(":tag", $dataInSecrity['tag']);

            $dataHora = date('Y-m-d H:i:s');
            $prepare->bindValue(":dia", $dataHora);

            $prepare->execute();
            $prepare->closeCursor();

        } catch (PDOException $erros) {
            echo "tivemos um erro.: ";
            echo $erros->getMessage();
        }
    }

    public function update(IanotacoesPsicologos $anotacao): void{
        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL updateAnotacoesPsicologo(:pk, :observacao, :dia, :fkFlag);");
            $prepare->bindValue(":pk", $anotacao->getPkAnotacoesPsicologos());
            $prepare->bindValue(":fkFlag", $anotacao->getFlags()->getPkFlags());
            $prepare->bindValue(":observacao", $anotacao->getObservacoes());
            
            $dataHora = date('Y-m-d H:i:s');
            
            $prepare->bindValue(":dia",$dataHora );
            $prepare->execute();

            
        } catch (PDOException $erros) {
            echo("tivemos um erro.:");
            echo($erros->getMessage());
        }
    }
}

?>