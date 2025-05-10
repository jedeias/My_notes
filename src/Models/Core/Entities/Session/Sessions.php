<?php

namespace Src\Models\Core\Entities\Session;

class Sessions{
    
    // se sobra tempo da para jogar um siglenton so para dizer que tem um pattern no projeto.

    public function __construct() {
        if(!isset($_SESSION)){
            session_start();
        }
    }

    public function set($key, $value) : void {
        $_SESSION[$key] = $value;
    }

    public function get(string $key){
        return $_SESSION[$key];
    }

    public function isSessionStarted() : bool {
        if(empty($_SESSION) || $_SESSION == null){
            return false;
        }else{
            return true;
        }
    }

    public function destroy() : void {
        session_destroy();
    }

}

?>