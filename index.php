<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/view/CSS/login.css">
</head>

<body>

    <section class="content">
        
        <div class="logo-container">
    

            <div class="logo-text">
                <div class="logo-main">
                    <h1>Minhas-Anotações</h1>
                </div>
                <p>Organize seus pensamentos, transforme sua vida.</p>

            </div>

        </div>
        
        <div class="login-container">
            
            <form class="login" action="src/Controllers/LoginController.php" method="POST" enctype="multipart/form-data">
                
                <h1 class="login-label">LOGIN</h1>        
                <input type="text" name="email" placeholder="E-mail" class="usuario-input" required>
               
            
                <div class="senha-container">
                        <input type="password" name="senha" required id="loginSenha" placeholder="Senha" class="senha-input">
                </div>
            
                <?php
                    // OBS ISSO É TRANPO QUE DAVA PARA FAZER NO JS.
                    // Se for validação posso fazer, mas se for algo de status assim da não

                    if (isset($_GET['status'])) {
                        $status = $_GET['status'];
                        echo "<p> $status </p>";
                    }
                ?>

                <div class="action-button">
                    <input type="submit" name="entrar" class="entrar-button" value="Entrar">
                </div>
            
            </form>

            
        
        </div>
    
    </section>

</body>
</html>