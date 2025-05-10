<?php 
namespace src\Controllers;
use src\Models\UseCases\Login\Login;

require_once __DIR__ . '/../../vendor/autoload.php';

class LoginController{
    
    private Login $login;

    public function __construct(string $email,string  $senha){
        $this->login = new Login();
        
        $user = $this->login->Autenticacao($email, $senha);

        print_r($user);

        $types = [
            'Psicologos',
            'Pacientes',
            'Secretarios',
        ];

    // echo(get_class($user) . '<br>');

        foreach ($types as $type) {
            
            $class = 'src\Models\Core\Entities\Pessoas\\' . $type;
            
            try {
 
                if (get_class($user) == $class) {
                    
                    $userConstructor = 'src\Models\Infra\Repository\Pessoas\\' .'Repositorio'. $type;     
                    
                    header("Location: ../view/telas/pessoas/$type/". $type .".php");
                    break;
                }else{
                    
                    header("Location: ../../index.html?status='usaurio nao localizado ou senha incorreta ERRRO'");
                }
            } catch (\Throwable $th) {
                header("Location: ../../index.html?status='usaurio nao localizado ou senha incorreta ERRRO'");
            }
        }
    

    }
    
}

$login = new LoginController($_POST['email'], md5($_POST['senha']));

?>