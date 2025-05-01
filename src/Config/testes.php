<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;
use src\Models\Infra\Repository\Telefones\RepositorioTelefone;
use src\Models\Infra\Repository\Pessoas\RepositorioPacientes;
use src\Models\UseCases\Login\Login;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Pessoas\Secretarios;
use src\Models\Infra\Repository\Enderecos\RepositorioEndereco;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Core\Entities\Telefones\Telefones;
/*          TESTE LOGIN

$login = new Login();
$user = $login->Autenticacao("fernando@email.com", "senha258");

$types = [
    'Psicologo' => Psicologos::class,
    'Paciente' => Pacientes::class,
    'Secretario' => Secretarios::class,
];

foreach ($types as $type => $class) {
    if ($user instanceof $class) {
        $userConstructor = 'src\Models\Infra\Repository\Pessoas\\' .'Repositorio'. $type;     
        $userRepository = new $userConstructor();
        print_r($userRepository->findByPk($user));   
    }
}

print_r($user);


*/


/* Endereco */

$repositorioEndereco = new RepositorioEndereco();
$repositorioPessoas = new RepositorioPessoa();


// $endereco = new Enderecos();
// $endereco->setRua("Avenida Central")->setNumero(789); // rua existente;

// $endereco = Enderecos::create(
//     'Rua dos cravos',
//     123,
//     'logo ai',
//     'Centro',
//     123452348,
//     'São Paulo',
//     'SP'
// ); // nova rua


// $telefone = Telefones::create(11, 56154022);

// $repositoryTelefone = new RepositorioTelefone();


// $data = $repositorioPessoas->cheackedTelefone($telefone);
// print_r($data);



// $outPut = $repositorioEndereco->findByRuaAndNumero($endereco);

// echo "pre";

// print_r($outPut);

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

$repositoryPacientes = new RepositorioPacientes();

$arrayPaciente =$repositoryPacientes->findByPk($pacientes);
$paciete = Pacientes::create(
    'João Pedro',
    'joaoPedro@gmail.com',
    'senha',
    '1990-01-01',
    '643456781',
    '45665478923',
    'M',
    'imageLocal',
    $endereco,
    $telefone
);

$psicologos = Psicologos::create(
    'gertrudes', 
    'gertrudes@gertrudes.com', 
    "senha", 
    "1970-01-01", 
    "12345676", 
    "45667891", 
    "F",
    "senhorinha.png",
    "544685654", 
    $endereco, $telefone
);

$paciete->setPsicologo($psicologos);

print_r($repositoryPacientes->insert($paciete));


?>