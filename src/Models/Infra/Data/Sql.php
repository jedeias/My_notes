<?php 

namespace src\Models\Infra\Data;
use PDOException;
use src\Config\Hosts;

use PDO;

class Sql extends Hosts{

    private $connect; 

    public function __construct() {
        try {
            $this->connect = new PDO("mysql:host={$this->getServer()};dbname={$this->getDatabase()}", 
                                 $this->getUser(), 
                                 $this->getPassword());    
        } catch (PDOException $error) {
            echo "Sorry we have a erro, try later";
            echo($error->getMessage());
        }
        
    }

	public function getConnect() {
		return $this->connect;
	}

    function __destruct() {
        $this->connect = null;
    }

}

?>