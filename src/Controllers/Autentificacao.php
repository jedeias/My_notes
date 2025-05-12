<?php

namespace src\Controllers;
use src\Models\Core\Entities\Session\Sessions;

class Autentificacao{
    private Sessions $session;

    public function __construct() {
        $this->session = new Sessions();

        if(! $this->session->isSessionStarted()){
            header("Location: ../../../../../index.php?status='Sessão expirada... ERRRO'");
        }
        
    }
    
}

?>