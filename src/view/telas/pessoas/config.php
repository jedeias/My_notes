<?php

include "../../../../vendor/autoload.php";

use src\Controllers\Autentificacao;
use src\Models\Core\Entities\Session\Sessions;
use src\Models\Core\Entities\Pessoas\Psicologos;
use src\Models\Core\Entities\Pessoas\Pacientes;
use src\Models\Core\Entities\Pessoas\Secretarios;
use src\Models\Infra\Repository\Pessoas\RepositorioPessoa;
use src\Models\Infra\Repository\Pessoas\RepositorioPsicologos;
use src\Models\Core\Entities\Enderecos\Enderecos;
use src\Models\Core\Entities\Telefones\Telefones;


$auth = new Autentificacao();

$session = new Sessions();

$userData = $session->get('user');

$repositorioPessoas = new RepositorioPessoa();

$userData = $repositorioPessoas->findAllADataOfPessoaByPk($userData['pkPessoa']);

if($session->get('user') == null) {
    header("Location: ../../../../index.php");
}

/*
    Aqui da para aplica um Strategy legal para cada usuarios que precisa de update, mas estou sem tempo para isso.
*/

if($_POST){

    $foto = $_FILES['imageLocal']['name'];

    $foto = $_POST['email']."_".$foto;

    $pasta = "../../image/fotosUsuarios/";

    move_uploaded_file($_FILES['imageLocal']['tmp_name'], $pasta.$foto);

    if($userData['pkPaciente'] != null){
        $pessoa = new Pacientes();

        $pessoa->setPessoaPk($userData['pkPessoa']);
        $pessoa->setNome($_POST['nome']);
        if($_POST['senha'] == null){
            $pessoa->setSenhaComum($userData['senha']);
        }else{
            $pessoa->setSenha($_POST['senha']);
        }
        $pessoa->setEmail($_POST['email']);
        $pessoa->setImageLocal($foto);
        $pessoa->setDataDeNascimento($_POST['dataDeNascimento']);
        $pessoa->setRG($_POST['RG']);
        $pessoa->setCPF($_POST['CPF']);
        $pessoa->setSexo($_POST['sexo']);
        
        $endereco = new Enderecos();
        $endereco->setRua($_POST['rua']);
        $endereco->setNumero($_POST['numeroDaCasa']);
        $endereco->setComplemento($_POST['complemento']);
        $endereco->setBairro($_POST['bairro']);
        $endereco->setCep($_POST['cep']);
        $endereco->setCidade($_POST['cidade']);
        $endereco->setEstado($_POST['estado']);
        
        $telefone = new Telefones();
        $telefone->setDdd($_POST['DD']);
        $telefone->setNumero($_POST['numeroDeTelefone']);
        
        $pessoa->setEndereco($endereco);
        $pessoa->setTelefone($telefone);
        
        $repositorioPessoas->update($pessoa);

        
        header("Location: pacientes/pacientes.php");

    }else if($userData['pkPsicologo'] != null){
        
        $pessoa = new Psicologos();

        $pessoa->setPsicologosPk($userData['pkPsicologo']);
        $pessoa->setNome($_POST['nome']);
        if($_POST['senha'] == null){
            $pessoa->setSenhaComum($userData['senha']);
        }else{
            $pessoa->setSenha($_POST['senha']);
        }
        $pessoa->setEmail($_POST['email']);
        $pessoa->setImageLocal($foto);
        $pessoa->setDataDeNascimento($_POST['dataDeNascimento']);
        $pessoa->setRG($_POST['RG']);
        $pessoa->setCPF($_POST['CPF']);
        $pessoa->setSexo($_POST['sexo']);
        $pessoa->setCRP($_POST['CRP']);
        
        $endereco = new Enderecos();
        $endereco->setRua($_POST['rua']);
        $endereco->setNumero($_POST['numeroDaCasa']);
        $endereco->setComplemento($_POST['complemento']);
        $endereco->setBairro($_POST['bairro']);
        $endereco->setCep($_POST['cep']);
        $endereco->setCidade($_POST['cidade']);
        $endereco->setEstado($_POST['estado']);
        
        $telefone = new Telefones();
        $telefone->setDdd($_POST['DD']);
        $telefone->setNumero($_POST['numeroDeTelefone']);
        
        $pessoa->setEndereco($endereco);
        $pessoa->setTelefone($telefone);
        
        $repositorioPsicologos = new RepositorioPsicologos();
        $repositorioPsicologos->update($pessoa);
        
        header("Location: psicologos/psicologos.php");

    }else if($userData['pkSecretario'] != null){
        $pessoa = new Secretarios();
        
        $pessoa->setPessoaPk($userData['pkPessoa']);
        $pessoa->setNome($_POST['nome']);
        if($_POST['senha'] == null){
            $pessoa->setSenhaComum($userData['senha']);
        }else{
            $pessoa->setSenha($_POST['senha']);
        }
        $pessoa->setEmail($_POST['email']);
        $pessoa->setImageLocal($foto);
        $pessoa->setDataDeNascimento($_POST['dataDeNascimento']);
        $pessoa->setRG($_POST['RG']);
        $pessoa->setCPF($_POST['CPF']);
        $pessoa->setSexo($_POST['sexo']);

        $endereco = new Enderecos();
        $endereco->setRua($_POST['rua']);
        $endereco->setNumero($_POST['numeroDaCasa']);
        $endereco->setComplemento($_POST['complemento']);
        $endereco->setBairro($_POST['bairro']);
        $endereco->setCep($_POST['cep']);
        $endereco->setCidade($_POST['cidade']);
        $endereco->setEstado($_POST['estado']);
        
        $telefone = new Telefones();
        $telefone->setDdd($_POST['DD']);
        $telefone->setNumero($_POST['numeroDeTelefone']);
        
        $pessoa->setEndereco($endereco);
        $pessoa->setTelefone($telefone);
        
        $repositorioPessoas->update($pessoa);
        
        header("Location: secretarios/secretarios.php");
    }
}

?>

<!DOCTYPE html>
<html lang="pt_Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/config.css">
    <link rel="stylesheet" href="../../CSS/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Configurações</title>
</head>
<body>
    <div id="menuBtn" onclick="openNav()">&#9776;</div>
    <div id="mySidenav" class="sidenav">
        <img src="../image/images.png" alt="">
        <h1 class="title"><?php echo $userData["nome"]; ?></h1>
        <h2 class="subtitle"><?php echo $userData["email"]; ?></h2>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Atividades</a>
        <a href="#">Agenda</a>
        <a href="#">Consultas Agendadas</a>
        <a href="#">Contato</a>
        <a href="#"><i class="fa-solid fa-right-from-bracket"></i></a> 
        
    </div>

        <div class="modal-content">
            
            <h2>Configurações</h2>
            
            <form id="fromularioDadosPessoais" action="" method="post" enctype="multipart/form-data">
                
                <h3>Dados pessoais</h3>

                <label for="foto">Alterar Imagem:</label>
                <input type="file" id="foto" name="imageLocal" value="<?php echo $userData['imageLocal'] ?>" accept="image/*">
                
                <label for="nome">Alterar Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" value="<?php echo $userData['nome'] ?>">

                <label for="email">Alterar email:</label>
                <input type="text" id="email" name="email" placeholder="Digite seu email" value="<?php echo $userData['email'] ?>">
                
                <label for="senha">Alterar senha:</label>
                <input type="text" id="senha" name="senha" placeholder="*******">

                <label for="dataDeNascimento">Alterar data de nascimento:</label>
                <input type="date" id="dataDeNascimento" name="dataDeNascimento" placeholder="Digite seu nome" value="<?php echo $userData['dataDeNascimento'] ?>">

                <label for="RG">Alterar RG:</label>
                <input type="text" id="RG" name="RG" placeholder="Digite seu RG" value="<?php echo $userData['RG'] ?>">

                <label for="CPF">Alterar CPF:</label>
                <input type="text" id="CPF" name="CPF" placeholder="Digite seu CPF" value="<?php echo $userData['CPF'] ?>">

                <label for="sexo">sexo:</label>
                <select name="sexo" id="sexo">
                    <option value="<?php echo $userData["sexo"]; ?>"><?php echo $userData["sexo"]; ?></option>
                    <option value="M">Male</option>
                    <option value="F">Famele</option>
                </select>

                <h3>Endereco</h3>

                <label for="rua">Alterar Rua:</label>
                <input type="text" id="rua" name="rua" placeholder="Digite seu rua" value="<?php echo $userData['rua'] ?>">

                <label for="numero">Alterar Numero:</label>
                <input type="text" id="numero" name="numeroDaCasa" placeholder="Digite seu numero" value="<?php echo $userData['numeroDaCasa'] ?>">

                <label for="complemento">Alterar Complemento:</label>
                <input type="text" id="complemento" name="complemento" placeholder="Digite seu complemento" value="<?php echo $userData['complemento'] ?>">

                <label for="bairro">Alterar Bairro:</label>
                <input type="text" id="bairro" name="bairro" placeholder="Digite seu bairro" value="<?php echo $userData['bairro'] ?>">

                <label for="cep">Alterar CEP:</label>
                <input type="text" id="cep" name="cep" placeholder="Digite seu cep" value="<?php echo $userData['cep'] ?>">

                <label for="cidade">Alterar Cidade:</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite seu cidade" value="<?php echo $userData['cidade'] ?>">

                <label for="estado">Alterar Estado:</label>
                <select name="estado" id="estado">
                    <option value="<?php echo $userData['estado'] ?>"><?php echo $userData['estado'] ?></option>
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
                <input type="text" id="DD" name="DD" placeholder="Digite seu DD" value="<?php echo $userData['ddd'] ?>">

                <label for="numero">Alterar Numero:</label>
                <input type="text" id="numero" name="numeroDeTelefone" placeholder="Digite seu numero" value="<?php echo $userData['numeroDeTelefone'] ?>">

                <?php
                
                if($userData['pkPsicologo'] != null){
                    echo "<label for='CRP'>Alterar CRP:</label>";
                    echo "<input type='text' name='CRP' value='".$userData['CRP']."'>";
                }

                ?>

                <button type="submit">Salvar Alterações</button>
            </form>

        </div>
        <script src="../../JS/menu.js"></script>
    </body>
</html>