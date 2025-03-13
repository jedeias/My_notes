<?php

namespace src\Models\Core\Entities\Atividades;

interface Iatividades{
     function getPk(): int;
     function setPk(int $pk): self;
     function getTitulo(): string;
     function setTitulo(string $Titulo): self;
     function getDescricao(): string;
     function setDescricao(string $descricao): self;

     static function create(string $titulo, string $descricao): self; 
}

?>