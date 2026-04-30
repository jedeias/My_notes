<?php

namespace src\Models\Infra\Repository\Anotacoes;

use src\Models\Core\Repository\Anotacoes\IrepositoryAnotacoesPacientes;
use src\Models\Core\Entities\Anotacoes\IanotacoesPacientes;
use src\Models\Core\Entities\Pessoas\Ipacientes;
use src\Models\Infra\Security\AES\CryptoService;
use src\Models\Infra\Data\Sql;
use PDOException;
use PDO;

class RepositorioAnotacoesPacientes implements IrepositoryAnotacoesPacientes {
    private Sql $MySql;
    private CryptoService $cryptoService;

    public function __construct() {
        $this->MySql = new Sql();
        $this->cryptoService = new CryptoService();
    }

    public function findAnotacaoByPkPacientes(Ipacientes|int $pkAnotacoesPacientes): array{
        try {

            if ($pkAnotacoesPacientes instanceof Ipacientes) {
                $pk = $pkAnotacoesPacientes->getPacientesPk();
            }
            else {
                $pk = $pkAnotacoesPacientes;
            }

            $prepare = $this->MySql->getConnect()->prepare("CALL findAnotacoesByPkPacientes(:pk);");
            $prepare->bindValue(":pk", $pk);
            $prepare->execute();
            $data = $prepare->fetchAll(PDO::FETCH_ASSOC);

            if (empty($data)) {
                return [];
            } else {
                $dataDecrypt = $this->cryptoService->decrypt($data);
                return $dataDecrypt;

            }
        } catch (PDOException $erros) {
            echo("tivemos um erro.:");
            return[$erros->getMessage()];
        }
    }

        public function findAnotacaoByPk(Ipacientes|int $pkAnotacoesPacientes): array{
        try {

            

            if ($pkAnotacoesPacientes instanceof Ipacientes) {
                $pk = $pkAnotacoesPacientes->getPacientesPk();
            }
            else {
                $pk = $pkAnotacoesPacientes;
            }

            $prepare = $this->MySql->getConnect()->prepare("SELECT * FROM anotacoespacientes WHERE pkAnotacaoPaciente = (:pk);");
            $prepare->bindValue(":pk", $pk);
            $prepare->execute();
            $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
            
            $dataInSecrity = $this->cryptoService->decrypt($data);
            
            $data = $dataInSecrity;

            unset($data[0]["tag"]);
            unset($data[0]["IV"]);

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

    public function insert(IanotacoesPacientes $anotacao): void{
        
        $dataInSecrity = $this->cryptoService->encrypt($anotacao->getAnotacao());

        try {
            $prepare = $this->MySql->getConnect()->prepare("CALL insertAnotacoesPacientes(:fkPaciente, :dia, :anotacao, :iv, :tag);");
            $prepare->bindValue(":fkPaciente", $anotacao->getPacientes()->getPacientesPk());
            $dataHora = date('Y-m-d H:i:s');
            $prepare->bindValue(":dia",$dataHora );
            $prepare->bindValue(":anotacao", $dataInSecrity['ciphertext']);
            $prepare->bindValue(':iv', $dataInSecrity['iv']);
            $prepare->bindValue(':tag', $dataInSecrity['tag']);
            $prepare->execute();
        } catch (PDOException $erros) {
            echo("tivemos um erro.:");
            echo($erros->getMessage());
            die();
        }
    }
    public function update(IanotacoesPacientes $anotacao): void{
        // provavelmente vou remover essa função, não faz sentido o paciente poder alterar ou modificar a anotação
    }
    public function delete(int $pkAnotacoesPacientes): bool{
        // provavelmente vou remover essa função, não faz sentido o paciente poder alterar ou modificar a anotação
        return false;
    }
}


?>