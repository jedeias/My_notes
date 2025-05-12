<?php

namespace src\Controllers\NilveDeAcessos;

use src\Controllers\NilveDeAcessos\IstrategyNivelDeAcessos;
use src\Models\Core\Entities\Session\Sessions;

final class StrategyNivelDeAcessoPacientes implements IstrategyNivelDeAcessos
{
    
    private Sessions $session;

    public function __construct()
    {
        $this->session = new Sessions();
        $this->PermissaoDeAcesso();
    }

    public function PermissaoDeAcesso(): void
    {
        $userData = $this->session->get('user');

        if($userData['pkPsicologo'] != null){
            header("Location: ../psicologos/psicologos.php");
        }else if($userData['pkSecretario'] != null){
            header("Location: ../secretarios/secretarios.php");
        }
    }

}
