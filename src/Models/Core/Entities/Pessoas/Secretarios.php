<?php 

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Enderecos\Ienderecos;
use src\Models\Core\Entities\Pessoas\Pessoas;
use src\Models\Core\Entities\Telefones\Itelefones;

class Secretarios extends Pessoas{

    private int $SecretariosPk;

    public function getSecretariosPk(): int
    {
        return $this->SecretariosPk;
    }
    
    public function setSecretariosPk(int $SecretariosPk): self
    {
        $this->SecretariosPk = $SecretariosPk;

        return $this;
    }

    public static function create(
        string $nome,
        string $email,
        string $senha,
        string $dataDeNascimento,
        string $RG,
        string $CPF,
        string $sexo,
        string $imageLocal,
        string $CRP,
        Ienderecos $endereco,
        Itelefones $telefone,
        ): self{
            
            $pessoa = new Secretarios();
            $pessoa->setNome($nome);
            $pessoa->setEmail($email);
            $pessoa->setSenha($senha);
            $pessoa->setDataDeNascimento($dataDeNascimento);
            $pessoa->setRG($RG);
            $pessoa->setCPF($CPF);
            $pessoa->setSexo($sexo);
            $pessoa->setImageLocal($imageLocal);
            $pessoa->setEndereco($endereco);
            $pessoa->setTelefone($telefone);

            return $pessoa;
    }

}


?>