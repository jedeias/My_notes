<?php

namespace src\Models\Core\Entities\Enderecos;

interface Ienderecos{
    function getPkEndereco() : int;
    function setPkEndereco(int $pkEndereco) : self;
    function getRua() : string;
    function setRua(string $rua) : self;
    function getNumero() : int;
    function setNumero(int $numero) : self;
    function getComplemento() : string;
    function setComplemento(string $complemento) : self;
    function getBairro() : string;
    function setBairro(string $bairro) : self;
    function getCep() : int;
    function setCep(int $cep) : self;
    function getCidade() : string;
    function setCidade(string $cidade) : self;
    function getEstado() : string;
    function setEstado(string $estado) : self;
}

?>