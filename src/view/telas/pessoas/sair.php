<?php

include "../../../../vendor/autoload.php";

use src\Models\Core\Entities\Session\Sessions;

$session = new Sessions();
$session->destroy();

header("Location: ../../../../index.php");
?>