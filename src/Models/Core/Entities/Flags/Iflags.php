<?php 

namespace src\Models\Core\Entities\Flags;

interface Iflags{
    function getPkFlags() : int;
    function setPkFlags(int $flags) : self;
    function getColor() : string;
    function setColor(string $color) : self;
    function getTituloDaFlag() : string;
    function setTituloDaFlag(string $tituloDaFlag) : self;
    function getDescricao() : string;
    function setDescricao(string $descricao) : self;
}

?>