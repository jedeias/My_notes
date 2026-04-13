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

// $RepositorioTelefone = new RepositorioTelefone();
// $RepositorioEndereco = new RepositorioEndereco();

// $telefone = Telefones::create("81", "564621245");
// $telefone->setPkTelefone(7);
// $endereco = Enderecos::create(
//     "rua", 
//     2314, 
//     "casa b", 
//     "JD das rosas", 
//     00000000,
//     "são paulo",
//     "SP"
// );

// $endereco->setPkEndereco(4);

// $RepositorioTelefone->insert($telefone);
// $RepositorioEndereco->insert($endereco);
    
// $pessoa = Pacientes::create(
//     "nome",
//     "email",
//     "senha",
//     "1994-01-01",
//     "RG",
//     "CPF",
//     "Masculino",
//     "image",
//     $endereco,
//     $telefone
// );

// print_r($pessoa);

// $repository = new RepositorioPessoa();
// $repository->insert($pessoa);

// font https://www.php.net/manual/en/function.openssl-encrypt.php

//$key should have been previously generated in a cryptographically safe way, like openssl_random_pseudo_bytes
$plaintext = "OLA MUNDO"; // texto que queremos criptografar
$cipher = "aes-256-gcm"; // tipo de cifra
$key = "123456789"; // a chave mestra para criptografar e descriptografar.

if (in_array($cipher, openssl_get_cipher_methods())) // verificação se a cifra existe 
{
    $ivlen = openssl_cipher_iv_length($cipher); // pega o temanho do vetor de inicialização (IV) necessário para a cifra
    $iv = openssl_random_pseudo_bytes($ivlen); // remove ou adicona bytes aleatórios para criar um IV do tamanho correto
    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag); // inplementa a cifra
    //store $cipher, $iv, and $tag for decryption later
    

    echo "KEY: ".$key."\n"; // estou validando se a senha é a mesma inicial

    echo"<br>";

    echo "Ciphertext: ".$ciphertext."\n"; // pelo que entendi esse é o texto cifrado

    echo"<br>";

    $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag); // descriptografa o texto cifrado usando a mesma chave
    
    echo "Palavra descriptografada" . $original_plaintext."\n"; // exibe a palavra descriptografada

    // eis a questão o IV para descriptografia precisa ser o mesmo que foi usado para criptografia e a tag da onde veio e se ela é nescesassaria para a descriptografia?
    // a questão se IV é para garantir o tamanho de bits que a criptografia precisa eu poderia simplesmente usar um sha-256 para dar um hash que sempre gere o mesmo IV ou teria de guardar meu IV no banco de dados com cada nova mensagem ?

    echo "<hr>";
    echo "<h1>Testando a descriptografia do AES-256-GCM</h1>";

    $textInSecrity = base64_decode("RantElC2D1RYWxtiFemUSCHd2/rWtt/eWEYShVY=");
    $senha = "20617adab6c29f7c3495f668e095a44f6189781f8ecbe148a97e990f913020c7";
    $ivInDataBase = base64_decode("BJQow7ExioL5/M3Y");
    $tagInDataBase = base64_decode("teugJhcjDx3btuyEcikigA==");

    $texto = openssl_decrypt($textInSecrity, $cipher, $senha, OPENSSL_RAW_DATA, $ivInDataBase, $tagInDataBase); // descriptografa o texto cifrado usando a mesma chave
    
    
    var_dump($texto);
    echo "<hr>";

}

?>