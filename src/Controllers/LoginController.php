<?php 
namespace src\Controllers;
use src\Models\UseCases\Login\Login;

require_once __DIR__ . '/../../vendor/autoload.php';

class LoginController{
    
    private Login $login;
    
    public function __construct(string $email,string  $senha){
        $this->login = new Login();
        
        $user = $this->login->Autenticacao($email, $senha);

        $types = [
            'Psicologos',
            'Pacientes',
            'Secretarios',
        ];

        // echo(get_class($user) . '<br>');

        foreach ($types as $type) {
            
            $class = 'src\Models\Core\Entities\Pessoas\\' . $type;

            echo "class var = " . $class. "<br><br>";

            echo "class user loger = ". get_class($user). "<br><br>";

            if (get_class($user) == $class) {

                $userConstructor = 'src\Models\Infra\Repository\Pessoas\\' .'Repositorio'. $type;     
                
                $userRepository = new $userConstructor();

                print_r($userRepository->findByPk($user));

                // header("Location: ../view/telas/pessoas/". $type .".html");
            }
        }

    }
    
}

$login = new LoginController($_POST['email'], $_POST['senha']);

?>



view/telas/pessoas/Pacientes.html
view/telas/pessoas/Pacientes.html