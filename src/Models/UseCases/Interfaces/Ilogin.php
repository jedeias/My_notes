<?php

namespace src\Models\UseCases\Interfaces;
use src\Models\Core\Entities\Pessoas\Ipsicologos;
use src\Models\Core\Entities\Pessoas\Isecretarios;
use src\Models\Core\Entities\Pessoas\Ipacientes;

interface Ilogin {
    public function Autenticacao(string $email, string $senha);

}

?>