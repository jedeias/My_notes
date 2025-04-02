<?php

require_once __DIR__ . '/../vendor/autoload.php';

use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Core\Entities\Telefones\Telefones;
use src\Models\Infra\Repository\Enderecos\RepositorioEndereco;
use src\Models\Infra\Repository\Telefones\RepositorioTelefone;
use src\Models\Infra\Repository\Pessoas\RepositorioPaciente;
use src\Models\UseCases\Login\Login;

$repositoryTelefone = new RepositorioTelefone();

$telefone = new Telefones();
$telefone->setPkTelefone(6);

$arrayNumero = $repositoryTelefone->findByPk($telefone);

$telefone->setNumero($arrayNumero['numero']);
$telefone->setDDD($arrayNumero['ddd']);

$endereco = new Enderecos();

$endereco->setPkEndereco(3);

$repositorioEndereco = new RepositorioEndereco();

$arrayEndereco = $repositorioEndereco->findByPk($endereco);

$endereco->setRua($arrayEndereco['rua']);
$endereco->setNumero($arrayEndereco['numero']);
if(empty($arrayEndereco['complemento'])){
    $endereco->setComplemento('null');
}
$endereco->setBairro($arrayEndereco['bairro']);
$endereco->setCep($arrayEndereco['cep']);
$endereco->setCidade($arrayEndereco['cidade']);
$endereco->setEstado($arrayEndereco['estado']);

$pacientes = new Pacientes();
$pacientes->setPacientesPk(1);

$repositoryPacientes = new RepositorioPaciente();

$arrayPaciente =$repositoryPacientes->findByPk($pacientes);

$paciete = Pacientes::create(
    $arrayPaciente['nome'],
    $arrayPaciente['email'],
    $arrayPaciente['senha'],
    $arrayPaciente['dataDeNascimento'],
    $arrayPaciente['RG'],
    $arrayPaciente['CPF'],
    $arrayPaciente['sexo'],
    $arrayPaciente['imageLocal'],
    $endereco,
    $telefone
);

print_r($paciete);

$login = new Login();

print_r($login->Autenticacao($paciete->getEmail(), $paciete->getSenha()));

?>