<?php

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Pessoas\Ipessoas;
use src\Models\Core\Entities\Enderecos\Ienderecos;
use src\Models\Core\Entities\Telefones\Itelefones;

abstract class Pessoas implements Ipessoas{
    
    private int $pk;
    private string $nome;
    private string $email;
    private string $senha;
    private string $dataDeNascimento;
    private string $RG;
    private string $CPF;
    private string $sexo;
    private string $imageLocal;
    private Ienderecos $Endereco;
    private Itelefones $telefone;
    
    public function getPessoaPk(): int{
        return $this->pk;
    }

    
    public function setPessoaPk(int $pk): self{
        $this->pk = $pk;
        return $this;
    }

    
    public function getNome(): string{
        return $this->nome;
    }

    
    public function setNome(string $nome): self{
        $this->nome = $nome;
        return $this;
    }

    
    public function getEmail(): string{
        return $this->email;
    }

    
    public function setEmail(string $email): self{
        $this->email = $email;
        return $this;
    }

    
    public function getSenha(): string{
        return $this->senha;
    }

    
    public function setSenha(string $senha): self{
        $this->senha = md5($senha);
        return $this;
    }

    
    public function getDataDeNascimento(): string{
        return $this->dataDeNascimento;
    }

    
    public function setDataDeNascimento(string $dataDeNascimento): self{
        $this->dataDeNascimento = $dataDeNascimento;
        return $this;
    }

    
    public function getRG(): string{
        return $this->RG;
    }

    
    public function setRG(string $RG): self{
        $this->RG = $RG;
        return $this;
    }

    
    public function getCPF(): string{
        return $this->CPF;
    }

    
    public function setCPF(string $CPF): self{
        $this->CPF = $CPF;
        return $this;
    }

    
    public function getSexo(): string{
        return $this->sexo;
    }

    
    public function setSexo(string $sexo): self{
        
        if($sexo != 'M' || $sexo != 'F'){
            $sexo = 'N/A';
        }
        
        $this->sexo = $sexo;
        return $this;
    }

    
    public function getImageLocal(): string{
        return $this->imageLocal;
    }

    
    public function setImageLocal(string $imageLocal): self{
        $this->imageLocal = $imageLocal;
        return $this;
    }

    public function getEndereco(): Ienderecos{
        return $this->Endereco;
    }

    public function setEndereco(Ienderecos $Endereco): self{
        $this->Endereco = $Endereco;
        return $this;
    }

    public function getTelefone(): Itelefones{
        return $this->telefone;
    }

    public function setTelefone(Itelefones $telefone): self{
        $this->telefone = $telefone;

        return $this;
    }

}


?>