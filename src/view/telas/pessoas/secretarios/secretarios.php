<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\NilveDeAcessos\StrategyNivelDeAcessoSecretarios;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Pessoas\Secretarios;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Core\Entities\Telefones\Telefones;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Core\Entities\Session\Sessions;
use src\Controllers\Autentificacao;
use src\Models\Infra\Repository\Enderecos\RepositorioEndereco;
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;
use src\Models\Infra\Repository\Pessoas\RepositorioPacientes;
use src\Models\Infra\Repository\Pessoas\RepositorioPsicologos;
use src\Models\Infra\Repository\Telefones\RepositorioTelefone;


$auth = new Autentificacao();
$session = new Sessions();

$nivelDeAcesso = new StrategyNivelDeAcessoSecretarios();

$userData = $session->get('user');

$secretarios = new Secretarios();
$secretarios->setSecretariosPk($userData['pkSecretario']);
$secretarios->setNome($userData['nome']);
$secretarios->setEmail($userData['email']);
$secretarios->setImageLocal($userData['imageLocal']);
$secretarios->setPessoaPk($userData['pkPessoa']);

$repositorioPsicologos = new RepositorioPsicologos();
$allPsicologos = $repositorioPsicologos->findAll();

if(! empty($_POST)){
    if(isset($_POST['CRM'])){

        //insert de teste
        $_POST = [
            'nome' => 'Marcia',
            'email' => 'marciaReges@email.com',
            'senha' => 'senha',
            'dataDeNascimento' => '1990-06-12',
            'RG' => '113456789',
            'CPF' => '11245678900',
            'sexo' => 'F',
            'cep' => '01101000',
            'rua' => 'Rua das Flores',
            'numeroDaCasa' => '123',
            'complemento' => 'Apto 45',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'DD' => '11',
            'numeroDeTelefone' => '912345678',
            'CRM' => '2'
        ];


        // inserte de psigologo;
        
        $telefone = new Telefones();
        $telefone->setDDD($_POST['DD']);
        $telefone->setNumero($_POST['numeroDeTelefone']);
        
        $endereco = new Enderecos();
        $endereco->setCep($_POST['cep']);
        $endereco->setRua($_POST['rua']);
        $endereco->setNumero($_POST['numeroDaCasa']);
        $endereco->setComplemento($_POST['complemento']);
        $endereco->setBairro($_POST['bairro']);
        $endereco->setCidade($_POST['cidade']);
        $endereco->setEstado($_POST['estado']);

        $psicologos = new Psicologos();
        $psicologos->setNome($_POST['nome']);
        $psicologos->setEmail($_POST['email']);
        $psicologos->setSenha($_POST['senha']);
        $psicologos->setDataDeNascimento($_POST['dataDeNascimento']);
        $psicologos->setRG($_POST['RG']);
        $psicologos->setCPF($_POST['CPF']);
        $psicologos->setCRP($_POST['CRM']);
        $psicologos->setSexo($_POST['sexo']);
        $psicologos->setEndereco($endereco);
        $psicologos->setTelefone($telefone);


        $repositorioTelefone = new RepositorioTelefone();
        $repositorioEndereco = new RepositorioEndereco();
        $repositorioPessoas = new RepositorioPessoa();
        $repositorioPsicologos = new RepositorioPsicologos();
        
        $repositorioTelefone->insert($psicologos->getTelefone());
        $dadosTelefone = $repositorioTelefone->findByNumero($psicologos->getTelefone());
        $psicologos->getTelefone()->setPkTelefone($dadosTelefone['pkTelefone']);

        $repositorioEndereco->insert($psicologos->getEndereco());
        $dadosEndereco = $repositorioEndereco->findByRuaAndNumero($psicologos->getEndereco());
        $psicologos->getEndereco()->setPkEndereco($dadosEndereco['pkEndereco']);

        $repositorioPessoas->insert($psicologos);
        $dadosPessoas = $repositorioPessoas->findByEmail($psicologos);
        $psicologos->setPessoaPk($dadosPessoas['pkPessoa']);

        $repositorioPsicologos->insert($psicologos);
        // $repositoriopsicologos->insert($psicologos);



        echo"<pre>";
        print_r($_POST);
    }else if(isset($_POST['psicologos'])){
        $pkPsicologo = $_POST['psicologos'];
        //insert de teste
        $_POST = [
            'nome' => 'João da Silva',
            'email' => 'joao.silva.teste@example.com',
            'senha' => 'SenhaForte123!',
            'dataDeNascimento' => '1990-05-12',
            'RG' => '123456789',
            'CPF' => '11145678900',
            'sexo' => 'M',
            'cep' => '01001000',
            'rua' => 'Rua das Flores',
            'numeroDaCasa' => '123',
            'complemento' => 'Apto 45',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'DD' => '11',
            'numeroDeTelefone' => '912345678',
            'psicologos' => $pkPsicologo
        ];

        //paciente
        echo"<pre>";
        print_r($_POST);

        $telefone = new Telefones();
        $telefone->setDDD($_POST['DD']);
        $telefone->setNumero($_POST['numeroDeTelefone']);

        $endereco = new Enderecos();
        $endereco->setCep($_POST['cep']);
        $endereco->setRua($_POST['rua']);
        $endereco->setNumero($_POST['numeroDaCasa']);
        $endereco->setComplemento($_POST['complemento']);
        $endereco->setBairro($_POST['bairro']);
        $endereco->setCidade($_POST['cidade']);
        $endereco->setEstado($_POST['estado']);
        
        $psicologos = new Psicologos();
        $psicologos->setPsicologosPk($_POST['psicologos']);

        $pacientes = new Pacientes();
        $pacientes->setNome($_POST['nome']);
        $pacientes->setEmail($_POST['email']);
        $pacientes->setSenha($_POST['senha']);
        $pacientes->setDataDeNascimento($_POST['dataDeNascimento']);
        $pacientes->setRG($_POST['RG']);
        $pacientes->setCPF($_POST['CPF']);
        $pacientes->setSexo($_POST['sexo']);
        $pacientes->setEndereco($endereco);
        $pacientes->setTelefone($telefone);
        $pacientes->setPsicologo($psicologos);

        $repositorioTelefone = new RepositorioTelefone();
        $repositorioEndereco = new RepositorioEndereco();
        $repositorioPessoas = new RepositorioPessoa();
        $repositorioPacientes = new RepositorioPacientes();
        
        $repositorioTelefone->insert($pacientes->getTelefone());
        $dadosTelefone = $repositorioTelefone->findByNumero($pacientes->getTelefone());
        $pacientes->getTelefone()->setPkTelefone($dadosTelefone['pkTelefone']);

        $repositorioEndereco->insert($pacientes->getEndereco());
        $dadosEndereco = $repositorioEndereco->findByRuaAndNumero($pacientes->getEndereco());
        $pacientes->getEndereco()->setPkEndereco($dadosEndereco['pkEndereco']);

        $repositorioPessoas->insert($pacientes);
        $dadosPessoas = $repositorioPessoas->findByEmail($pacientes);
        $pacientes->setPessoaPk($dadosPessoas['pkPessoa']);

        $repositorioPacientes->insert($pacientes);


    }else{
        "slc num compensa";
    }
}

?>

<!DOCTYPE html>
<html lang="pt_Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/secretario.css">
    <link rel="stylesheet" href="../../../CSS/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>secretario</title>
</head>
<body>

    <div id="menuBtn">&#9776;</div>
    <div id="mySidenav" class="sidenav">

        <img src="../../../image/fotosUsuarios/<?php echo $secretarios->getImageLocal();?>" alt='../../../image/default-profile.webp'>
        <h1 class="title"><?php echo $secretarios->getNome(); ?></h1>
        <h2 class="subtitle"><?php echo $secretarios->getEmail(); ?></h2>
        <a href="javascript:void(0)" class="closebtn">&times;</a>
        <a href="#">Atividades</a>
        <a href="../agenda/agenda.php">Agenda</a>
        <a href="#">Consultas Agendadas</a>
        <a href="#">Contato</a>
        <a href="../sair.php">sair</a>
        <a href="../config.php"><i class="fa-solid fa-gear"></i></a> 
    </div>

    <article>

        <div class="buttons">
            <button class="paci">pacientes</button>
            <button class="psico">psicologos</button>
            <button id="consultasBtn" class="consultas">Consultas</button>
        </div>

        <!-- Modal para Pacientes -->
        <div id="pacienteModal" class="modal">
        <div class="modal-content">
            
            <h2>Cadastrar pacientes</h2>

            <script>
                async function consultaCEP(event) {
                    event.preventDefault();

                    const form = event.target.closest("form");

                    const cepInput = form.querySelector('input[name="cep"]');
                    const ruaInput = form.querySelector('input[name="rua"]');
                    const bairroInput = form.querySelector('input[name="bairro"]');
                    const cidadeInput = form.querySelector('input[name="cidade"]');
                    const estadoSelect = form.querySelector('select[name="estado"]');

                    const cep = cepInput.value.replace(/\D/g, '');

                    if (cep.length !== 8) {
                        alert("CEP inválido. Deve conter 8 dígitos.");
                        return;
                    }

                    try {
                        const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                        const dados = await resposta.json();

                        if (dados.erro) {
                            alert("CEP não encontrado!");
                            return;
                        }

                        ruaInput.value = dados.logradouro || "";
                        bairroInput.value = dados.bairro || "";
                        cidadeInput.value = dados.localidade || "";
                        estadoSelect.value = dados.uf || "";

                    } catch (erro) {
                        alert("Erro ao buscar o CEP.");
                        console.error(erro);
                    }
                }
            </script>


            
            <form id="fromularioDadosPessoais" action="" method="post" enctype="multipart/form-data">
                
                <h3>Dados pessoais</h3>

                <label for="foto">Imagem:</label>
                <input type="file" id="foto" name="imageLocal" accept="image/*">
                
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome">

                <label for="email">email:</label>
                <input type="text" id="email" name="email" placeholder="Digite seu email">
                
                <label for="senha">senha:</label>
                <input type="text" id="senha" name="senha" placeholder="*******">

                <label for="dataDeNascimento">data de nascimento:</label>
                <input type="date" id="dataDeNascimento" name="dataDeNascimento" placeholder="Digite seu nome">

                <label for="RG">RG:</label>
                <input type="text" id="RG" name="RG" placeholder="Digite seu RG">

                <label for="CPF">CPF:</label>
                <input type="text" id="CPF" name="CPF" placeholder="Digite seu CPF">

                <label for="sexo">sexo:</label>
                <select name="sexo" id="sexo">
                    <option></option>
                    <option value="M">Male</option>
                    <option value="F">Famele</option>
                </select>

                <h3>Endereco</h3>
                
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" placeholder="Digite seu cep">
                <button type="button" onclick="consultaCEP(event)">Buscar CEP</button>   

                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua" placeholder="Digite seu rua">

                <label for="numero">Numero:</label>
                <input type="text" id="numero" name="numeroDaCasa" placeholder="Digite seu numero">

                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento" placeholder="Digite seu complemento">

                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite seu bairro">
                
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite seu cidade">

                <label for="estado">Estado:</label>
                <select name="estado" id="estado">
                    <option></option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
                <h3>Telefone</h3>
                
                <label for="DD">DD:</label>
                <input type="text" id="DD" name="DD" placeholder="Digite seu DD">
                
                <label for="numero">Numero:</label>
                <input type="text" id="numero" name="numeroDeTelefone" placeholder="Digite seu numero">
                
                
                
                <h3>psicologos</h3>

                <label for="psicologo">psicologo:</label>
                <select name="psicologos" id="">

                    <?php 
                        
                        foreach ($allPsicologos as $psicologos) {
                            echo "<option value='{$psicologos['pkPsicologo']}'> {$psicologos['nome']} </option>";
                        }

                    ?>
                </select>                
            

                <button type="submit">Salvar</button>
            </form>


        </div>
        </div>

        <!-- Modal para Psicólogos -->
        <div id="psicologoModal" class="modal">
        <div class="modal-content">
            
            <h2>Cadastrar Psicólogo</h2>
            
            <form id="fromularioDadosPessoais" action="" method="post" enctype="multipart/form-data">
                
                <h3>Dados pessoais</h3>

                <label for="foto">Imagem:</label>
                <input type="file" id="foto" name="imageLocal" accept="image/*">
                
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome">

                <label for="email">email:</label>
                <input type="text" id="email" name="email" placeholder="Digite seu email">
                
                <label for="senha">senha:</label>
                <input type="text" id="senha" name="senha" placeholder="*******">

                <label for="dataDeNascimento">data de nascimento:</label>
                <input type="date" id="dataDeNascimento" name="dataDeNascimento" placeholder="Digite seu nome">

                <label for="RG">o CRM:</label>
                <input type="text" id="CRM" name="CRM" placeholder="Digite o CRM">

                <label for="CPF">CPF:</label>
                <input type="text" id="CPF" name="CPF" placeholder="Digite seu CPF">

                <label for="sexo">sexo:</label>
                <select name="sexo" id="sexo">
                    <option></option>
                    <option value="M">Male</option>
                    <option value="F">Famele</option>
                </select>

                <h3>Endereco</h3>
                
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" placeholder="Digite seu cep">
                <button type="button" onclick="consultaCEP(event)">Buscar CEP</button> 

                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua" placeholder="Digite seu rua">
                
                <label for="numero">Numero:</label>
                <input type="text" id="numero" name="numeroDaCasa" placeholder="Digite seu numero">
                
                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento" placeholder="Digite seu complemento">
                
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite seu bairro">
                
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite seu cidade">

                <label for="estado">Estado:</label>
                <select name="estado" id="estado">
                    <option></option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
                <h3>Telefone</h3>

                <label for="DD">DD:</label>
                <input type="text" id="DD" name="DD" placeholder="Digite seu DD">

                <label for="numero">Numero:</label>
                <input type="text" id="numero" name="numeroDeTelefone" placeholder="Digite seu numero">

                <button type="submit">Salvar Alterações</button>
            </form>

                <script>
                    async function consultaCEP(event) {
                        event.preventDefault();

                        const form = event.target.closest("form");

                        const cepInput = form.querySelector('input[name="cep"]');
                        const ruaInput = form.querySelector('input[name="rua"]');
                        const bairroInput = form.querySelector('input[name="bairro"]');
                        const cidadeInput = form.querySelector('input[name="cidade"]');
                        const estadoSelect = form.querySelector('select[name="estado"]');

                        const cep = cepInput.value.replace(/\D/g, '');

                        if (cep.length !== 8) {
                            alert("CEP inválido. Deve conter 8 dígitos.");
                            return;
                        }

                        try {
                            const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                            const dados = await resposta.json();

                            if (dados.erro) {
                                alert("CEP não encontrado!");
                                return;
                            }

                            ruaInput.value = dados.logradouro || "";
                            bairroInput.value = dados.bairro || "";
                            cidadeInput.value = dados.localidade || "";
                            estadoSelect.value = dados.uf || "";

                        } catch (erro) {
                            alert("Erro ao buscar o CEP.");
                            console.error(erro);
                        }
                    }
                </script>
            </div>
        </div>
        

    </article>

    <!-- <article id="consultasSection" style="display: none;">
        <div class="summerFroms">
            <h1>Bem-vindo ao Sistema de Cadastro</h1>
            <p>Escolha uma das opções acima para cadastrar pacientes ou psicólogos.</p>
        </div>
        
        <section>
            <h2>Consultas:</h2>
            <button>Abrir calendário</button>
        </section>

        <section>
            <h3>Lista de Consultas do Dia</h3>
            <table>
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th>Psicólogo</th>
                        <th>Paciente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12:20</td>
                        <td>Doutora Ana</td>
                        <td>Jorge</td>
                    </tr>
                    <tr>
                        <td>14:00</td>
                        <td>Doutor Pedro</td>
                        <td>Maria</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <button id="cadastrarNovamenteBtn" class="cadastrar-novamente">Cadastrar Novamente</button>
    </article> -->

<script defer src="../../../JS/secretario.js"></script>
<script defer src="../../../JS/fromPessoas.js"></script>

</body>
</html>