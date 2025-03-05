<?php
namespace RobinDort\PslzmeLinks\Service\Backend;

use Exception;

class ParametersUpdater {
    private $parametersFile;

    public function __construct() {
        $this->parametersFile = __DIR__ . "../../../config/parameters.yaml";
    }

    public function updateDatabaseParameters($host, $user, $pw, $dbname) {
        try {
            if (!is_writable($this->parametersFile)) {
                throw new Exception("Error: Cannot write to parameters.yaml");
            }
            $content = file_get_contents($this->parametersFile);
            $content = preg_replace('/servername: .*/', "servername: '$host'", $content);
            $content = preg_replace('/username: .*/', "username: '$user'", $content);
            $content = preg_replace('/password: .*/', "password: '$pw'", $content);
            $content = preg_replace('/database: .*/', "database: '$dbname'", $content);

            file_put_contents($this->parametersFile, $content);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}

?>