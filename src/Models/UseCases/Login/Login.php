<?php

namespace src\Models\UseCases\Login;
use src\Models\Infra\Repository\Login\RepositorioLogin;
use src\Models\UseCases\Interfaces\Ilogin;

class Login implements Ilogin {
    private RepositorioLogin $loginRepository;

    public function __construct() {
        $this->loginRepository = new RepositorioLogin();
    }

    public function Autenticacao(string $email, string $senha) {
        
        $dataArray = $this->loginRepository->findAllTypePessoasByEmailAndPasswords($email, $senha);

        if(empty($dataArray)){
            return false;
        }

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