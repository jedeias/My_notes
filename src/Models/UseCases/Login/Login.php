<?php

namespace src\Models\UseCases\Login;
use src\Models\Infra\Repository\Login\RepositorioLogin;
use src\Models\UseCases\Interfaces\Ilogin;
use src\Models\Core\Entities\Session\Sessions;


class Login implements Ilogin {
    private RepositorioLogin $loginRepository;
    private Sessions $sessions;

    public function __construct() {
        $this->loginRepository = new RepositorioLogin();
    }

    public function Autenticacao(string $email, string $senha) {
        try{

            $dataArray = $this->loginRepository->findAllTypePessoasByEmailAndPasswords($email, $senha);
        }catch(\Throwable $th){
            echo $th->getMessage();
        }

        if(empty($dataArray)){
            return false;
        }

        $this->sessions = new Sessions();
        $this->sessions->set("user", $dataArray);

        $typesOfClients = [
            'Psicologos' => 'pkPsicologo',
            'Secretarios' => 'pkSecretario',
            'Pacientes' => 'pkPaciente',
        ];

        foreach ($typesOfClients as $type => $key) {
            if (($dataArray[$key] != null)) {
                $classUser = 'src\Models\Core\Entities\Pessoas\\' . $type;
                $pessoas = new $classUser();
                // print_r($pessoas);
                $pessoas->setEmail($email);
                $pessoas->setPessoaPk($dataArray['pkPessoa']);
                $setTypePk = 'set' . $type . 'Pk';
                $pessoas->$setTypePk($dataArray[$key]);
                return $pessoas;
            }
        }

    }
}
?>