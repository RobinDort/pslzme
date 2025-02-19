<?php
namespace RobinDort\PslzmeLinks\Service;

use RobinDort\PslzmeLinks\Service\DatabaseConnection;

class DatabaseManager {

    private $dbc;

    public function __construct(DatabaseConnection $dbc) {
        $this->dbc = $dbc;
    }
}


?>