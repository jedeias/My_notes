<?php

namespace src\Models\Core\Entities\Enderecos;
use src\Models\Core\Entities\Enderecos\Ienderecos;

class Enderecos implements Ienderecos{
    private int $pk;
    private string $rua;
    private int $numero;
    private string $complemento;
    private string $bairro;
    private int $Cep;
    private string $cidade;
    private string $estado;
    
    public function getPkEndereco(): int{
        return $this->pk;
    }

    public function setPkEndereco(int $pk): self{
        $this->pk = $pk;
        return $this;
    }

    public function getRua(): string{
        return $this->rua;
    }

    public function setRua(string $rua): self{
        $this->rua = $rua;
        return $this;
    }

    public function getNumero(): int{
        return $this->numero;
    }

    public function setNumero(int $numero): self{
        $this->numero = $numero;
        return $this;
    }

    public function getComplemento(): string{
        return $this->complemento;
    }

    public function setComplemento(string $complemento): self{
        $this->complemento = $complemento;
        return $this;
    }

    public function getBairro(): string{
        return $this->bairro;
    }

    public function setBairro(string $bairro): self{
        $this->bairro = $bairro;
        return $this;
    }

    public function getCep(): int{
        return $this->Cep;
    }

    public function setCep(int $Cep): self{
        $this->Cep = $Cep;
        return $this;
    }

    public function getCidade(): string{
        return $this->cidade;
    }

    public function setCidade(string $cidade): self{
        $this->cidade = $cidade;
        return $this;
    }

    public function getEstado(): string{
        return $this->estado;
    }

    public function setEstado(string $estado): self{
        $this->estado = $estado;
        return $this;
    }

    public static function create(
        string $rua,
        int $numero,
        string $complemento,
        string $bairro,
        int $cep,
        string $cidade,
        string $estado
    ): self{
        $endereco = new Enderecos();

        return $endereco->setRua($rua)->setNumero($numero)->setComplemento($complemento)->setBairro($bairro)->setCep($cep)->setCidade($cidade)->setEstado($estado);
    }
}


?>