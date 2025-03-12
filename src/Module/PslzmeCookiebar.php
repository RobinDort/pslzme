<?php
namespace RobinDort\PslzmeLinks\Module;

use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

use Contao\Module;

class PslzmeCookiebar extends Module {
    protected $strTemplate = "mod_pslzme_cookiebar";

    private $dbStmtExecutor;

    public function __construct(DatabasePslzmeConfigStmtExecutor $dbStmtExecutor) {
        try {
            $this->dbStmtExecutor = $dbStmtExecutor;
        } catch (DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    protected function compile() {}
}


?>