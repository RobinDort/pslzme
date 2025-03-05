<?php
namespace RobinDort\PslzmeLinks\Service\Backend;

use Exception;
use Symfony\Component\Yaml\Yaml;

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
            // Load current values from YAML
            $config = Yaml::parseFile($this->parametersFile);
            $config['parameters']['servername'] = $host;
            $config['parameters']['username'] = $user;
            $config['parameters']['password'] = $pw;
            $config['parameters']['database'] = $dbname;

            file_put_contents($this->parametersFile, Yaml::dump($config, 4));

            // Clear cache to apply changes
            shell_exec('php bin/console cache:clear --env=prod');
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}

?>