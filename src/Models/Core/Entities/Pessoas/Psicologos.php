<?php 

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Enderecos\Ienderecos;
use src\Models\Core\Entities\Pessoas\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use src\Models\Core\Entities\Telefones\Itelefones;

class Psicologos extends Pessoas implements Ipsicologos{

    private string $CRP;

    public function getCRP(): string{
        return $this->CRP;
    }

    public function setCRP(string $CRP): self{
        $this->CRP = $CRP;
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
            
            $pessoa = new Psicologos();
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