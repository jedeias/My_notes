<?php

include "../../../../../vendor/autoload.php";

use src\Controllers\NilveDeAcessos\StrategyNivelDeAcessoSecretarios;
use src\Models\Core\Entities\Pessoas\Secretarios;
use src\Models\Core\Entities\Session\Sessions;
use src\Controllers\Autentificacao;


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

                <label for="foto">Alterar Imagem:</label>
                <input type="file" id="foto" name="imageLocal" accept="image/*">
                
                <label for="nome">Alterar Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome">

                <label for="email">Alterar email:</label>
                <input type="text" id="email" name="email" placeholder="Digite seu email">
                
                <label for="senha">Alterar senha:</label>
                <input type="text" id="senha" name="senha" placeholder="*******">

                <label for="dataDeNascimento">Alterar data de nascimento:</label>
                <input type="date" id="dataDeNascimento" name="dataDeNascimento" placeholder="Digite seu nome">

                <label for="RG">Alterar RG:</label>
                <input type="text" id="RG" name="RG" placeholder="Digite seu RG">

                <label for="CPF">Alterar CPF:</label>
                <input type="text" id="CPF" name="CPF" placeholder="Digite seu CPF">

                <label for="sexo">sexo:</label>
                <select name="sexo" id="sexo">
                    <option></option>
                    <option value="M">Male</option>
                    <option value="F">Famele</option>
                </select>

                <h3>Endereco</h3>
                
                <label for="cep">Alterar CEP:</label>
                <input type="text" id="cep" name="cep" placeholder="Digite seu cep">
                <button type="button" onclick="consultaCEP(event)">Buscar CEP</button>   

                <label for="rua">Alterar Rua:</label>
                <input type="text" id="rua" name="rua" placeholder="Digite seu rua">

                <label for="numero">Alterar Numero:</label>
                <input type="text" id="numero" name="numeroDaCasa" placeholder="Digite seu numero">

                <label for="complemento">Alterar Complemento:</label>
                <input type="text" id="complemento" name="complemento" placeholder="Digite seu complemento">

                <label for="bairro">Alterar Bairro:</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite seu bairro">
                
                <label for="cidade">Alterar Cidade:</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite seu cidade">

                <label for="estado">Alterar Estado:</label>
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

                <label for="DD">Alterar DD:</label>
                <input type="text" id="DD" name="DD" placeholder="Digite seu DD">

                <label for="numero">Alterar Numero:</label>
                <input type="text" id="numero" name="numeroDeTelefone" placeholder="Digite seu numero">

            

                <button type="submit">Salvar Alterações</button>
            </form>


        </div>
        </div>

        <!-- Modal para Psicólogos -->
        <div id="psicologoModal" class="modal">
        <div class="modal-content">
            
            <h2>Cadastrar Psicólogo</h2>
            
            <form id="fromularioDadosPessoais" action="" method="post" enctype="multipart/form-data">
                
                <h3>Dados pessoais</h3>

                <label for="foto">Alterar Imagem:</label>
                <input type="file" id="foto" name="imageLocal" accept="image/*">
                
                <label for="nome">Alterar Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome">

                <label for="email">Alterar email:</label>
                <input type="text" id="email" name="email" placeholder="Digite seu email">
                
                <label for="senha">Alterar senha:</label>
                <input type="text" id="senha" name="senha" placeholder="*******">

                <label for="dataDeNascimento">Alterar data de nascimento:</label>
                <input type="date" id="dataDeNascimento" name="dataDeNascimento" placeholder="Digite seu nome">

                <label for="RG">Alterar o CRM:</label>
                <input type="text" id="CRM" name="CRM" placeholder="Digite o CRM">

                <label for="CPF">Alterar CPF:</label>
                <input type="text" id="CPF" name="CPF" placeholder="Digite seu CPF">

                <label for="sexo">sexo:</label>
                <select name="sexo" id="sexo">
                    <option></option>
                    <option value="M">Male</option>
                    <option value="F">Famele</option>
                </select>

                <h3>Endereco</h3>
                
                <label for="cep">Alterar CEP:</label>
                <input type="text" id="cep" name="cep" placeholder="Digite seu cep">
                <button type="button" onclick="consultaCEP(event)">Buscar CEP</button> 

                <label for="rua">Alterar Rua:</label>
                <input type="text" id="rua" name="rua" placeholder="Digite seu rua">
                
                <label for="numero">Alterar Numero:</label>
                <input type="text" id="numero" name="numeroDaCasa" placeholder="Digite seu numero">
                
                <label for="complemento">Alterar Complemento:</label>
                <input type="text" id="complemento" name="complemento" placeholder="Digite seu complemento">
                
                <label for="bairro">Alterar Bairro:</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite seu bairro">
                
                <label for="cidade">Alterar Cidade:</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite seu cidade">

                <label for="estado">Alterar Estado:</label>
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

                <label for="DD">Alterar DD:</label>
                <input type="text" id="DD" name="DD" placeholder="Digite seu DD">

                <label for="numero">Alterar Numero:</label>
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

    <article id="consultasSection" style="display: none;">
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
    </article>

<script defer src="../../../JS/secretario.js"></script>
<script defer src="../../../JS/fromPessoas.js"></script>

</body>
</html>