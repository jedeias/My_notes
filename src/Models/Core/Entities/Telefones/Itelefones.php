<?php

namespace src\Models\Core\Entities\Telefones;

interface Itelefones{
    function getPkTelefone() : int;
    function setPkTelefone(int $pkTelefone) : self;
    function getDDD() : int ;
    function setDDD(int $ddd) : self ;
    function getNumero() : int ;
    function setNumero(int $numero) : self ;
}

?>