<?php

require_once ("vendor/autoload.php");

use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Pessoas\Secretarios;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Infra\Repository\RepositorioAtividades;
use src\Models\Core\Entities\Atividades\Atividades;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Infra\Repository\Enderecos\RepositorioEndereco;
use src\Models\Core\Entities\Flags\Flags;
use src\Models\Infra\Repository\Flags\RepositorioFlag;
use src\Models\Core\Entities\Telefones\Telefones;
use src\Models\Infra\Repository\Telefones\RepositorioTelefone;
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;

$RepositorioTelefone = new RepositorioTelefone();
$RepositorioEndereco = new RepositorioEndereco();

$telefone = Telefones::create("81", "564621245");
$telefone->setPkTelefone(7);
$endereco = Enderecos::create(
    "rua", 
    2314, 
    "casa b", 
    "JD das rosas", 
    00000000,
    "são paulo",
    "SP"
);

$endereco->setPkEndereco(4);

$RepositorioTelefone->insert($telefone);
$RepositorioEndereco->insert($endereco);
    
$pessoa = Pacientes::create(
    "nome",
    "email",
    "senha",
    "1994-01-01",
    "RG",
    "CPF",
    "Masculino",
    "image",
    $endereco,
    $telefone
);

print_r($pessoa);

$repository = new RepositorioPessoa();
$repository->insert($pessoa);
?>