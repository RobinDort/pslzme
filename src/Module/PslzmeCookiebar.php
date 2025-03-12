<?php
namespace RobinDort\PslzmeLinks\Module;

use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

use Contao\Module;

class PslzmeCookiebar extends Module {
    protected $strTemplate = "mod_pslzme_cookiebar";

    private $dbStmtExecutor;
    private $imprintID;
    private $privacyID;

    public function setDbStmtExecutor(DatabasePslzmeConfigStmtExecutor $dbStmtExecutor){
        try {
            $this->dbStmtExecutor = $dbStmtExecutor;
            $dbConfigData = $this->dbStmtExecutor->selectCurrentDatabaseConfigurationData();
            $internalPageRefs = $dbConfigData["databaseIPR"];

            if (!empty($internalPageRefs)) {
                $internalPageRefs = json_decode($internalPageRefs,true);
                $this->imprintId = $internalPageRefs["Imprint"];
                $this->privacyID = $internalPageRefs["Privacy"];
            }

        } catch (DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    protected function compile() {}


    public function generate() {
        $this->Template->imprintID = $this->imprintID;
        $this->Template->privacyID = $this->privacyID;
        $this->compile();

        return $this->Template->parse();
    }
}


?>