<?php

namespace src\Models\Core\Entities\Pessoas;
use src\Models\Core\Entities\Enderecos\Ienderecos;
use src\Models\Core\Entities\Telefones\Itelefones;

interface Ipessoas{

    function getPessoaPk() : int;
    function setPessoaPk(int $pk) : self;
    function getNome() : string;
    function setNome(string $nome) : self;
    function getEmail() : string;
    function setEmail(string $email) : self;
    function getSenha() : string;
    function setSenha(string $senha) : self;
    function getDataDeNascimento() : string;
    function setDataDeNascimento(string $dataDeNascimento) : self;
    function getRG() : string;
    function setRG(string $RG) : self;
    function getCPF() : string;
    function setCPF(string $CPF) : self;
    function getSexo() : string;
    function setSexo(string $sexo) : self;
    function getImageLocal() : string;
    function setImageLocal(string $imageLocal) : self;
    function getTelefone() : Itelefones;
    function setTelefone(Itelefones $fkTelefone) : self;
    function getEndereco() : Ienderecos;
    function setEndereco(Ienderecos $fkEndereco) : self;

}

?>