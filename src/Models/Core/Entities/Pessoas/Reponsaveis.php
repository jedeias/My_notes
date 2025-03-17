<?php 

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Enderecos\Ienderecos;
use src\Models\Core\Entities\Pessoas\Pessoas;
use src\Models\Core\Entities\Telefones\Itelefones;

class Reponsaveis extends Pessoas implements Iresponsavel{
    
    private int $responsavelPk;

    public function getResponsavelPk(): int
    {
        return $this->responsavelPk;
    }

    public function setResponsavelPk(int $responsavelPk): self
    {
        $this->responsavelPk = $responsavelPk;

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
        Ienderecos $endereco,
        Itelefones $telefone,
        ): self{
            
            $pessoa = new Reponsaveis();
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