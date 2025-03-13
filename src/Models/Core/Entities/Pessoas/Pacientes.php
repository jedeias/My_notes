<?php 

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Enderecos\Ienderecos;
use src\Models\Core\Entities\Pessoas\Pessoas;
use src\Models\Core\Entities\Telefones\Itelefones;
use src\Models\Core\Entities\Pessoas\Ipsicologos;

class Pacientes extends Pessoas{
    private Ipsicologos $psicologo;
    private int $pacientesPk;
    
    public function getPsicologo(): Ipsicologos{
        return $this->psicologo;
    }

    
    public function setPsicologo(Ipsicologos $psicologo): self{
        $this->psicologo = $psicologo;

        return $this;
    }
    
    public function getPacientesPk(): int
    {
        return $this->pacientesPk;
    }

    public function setPacientesPk(int $pacientesPk): self
    {
        $this->pacientesPk = $pacientesPk;

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
        Itelefones $telefone,): self{
            
            $pessoa = new Pacientes();
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