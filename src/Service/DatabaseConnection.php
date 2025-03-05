<?php
namespace RobinDort\PslzmeLinks\Service;

use mysqli;
use Contao\System;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use RobinDort\PslzmeLinks\Exceptions\DatabaseException;
use RobinDort\PslzmeLinks\Service\DatabaseManager;
use RobinDort\PslzmeLinks\Exceptions\InvalidDataException;

use Exception;

class DatabaseConnection {
    private $connection;
    // private $servername;
    // private $username;
    // private $password;
    // private $dbname;

    private $params;

    // public function __construct($servername, $username, $password, $dbname) {
    //     $this->servername = $servername;
    //     $this->username = $username;
    //     $this->password = $password;
    //     $this->dbname = $dbname;


    //     try {
    //         // create connection to database
    //         $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

    //         // check if connection was established
    //         if($this->connection->connect_error) {
    //             throw new Exception("Connection to database failed: " . $this->connection->connect_error);
    //         } 

    //     } catch (Exception $e) {
    //         $this->connection->rollback();
    //         $this->closeConnection();
    //         error_log($e->getMessage());
    //     }
    // }


    public function __construct(ParameterBagInterface $params) {
        $this->params = $params;

        try {
            $servername = $this->params->get('servername');
            $username =  $this->params->get('username');
            $password =  $this->params->get('password');
            $dbname =  $this->params->get('dbname');

            if (empty($servername) || empty($username) || empty($password) || empty($dbname)) {
                throw new InvalidDataException("Unable to extract parameters from ParamaterBagInterface");
            }
     
            // create connection to database
            $this->connection = new mysqli($servername, $username, $password, $dbname);

            // check if connection was established
            if($this->connection->connect_error) {
                throw new DatabaseException("Connection to database failed: " . $this->connection->connect_error);
            } 

        } catch(InvalidDataException $ide) {
            error_log($ide->getErrorMsg());
            $this->closeConnection();
        } catch(DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
            $this->closeConnection();
        } catch(Exception $e) {
            $this->closeConnection();
            error_log($e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection !== null && $this->connection->ping()) {
            $this->connection->close();
        }
    }
}
?>