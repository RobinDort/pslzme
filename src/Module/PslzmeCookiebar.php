<?php
namespace RobinDort\PslzmeLinks\Module;

use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

use Contao\Module;
use Contao\ModuleModel;

class PslzmeCookiebar extends Module {
    protected $strTemplate = "mod_pslzme_cookiebar";

    private ?DatabasePslzmeConfigStmtExecutor $dbStmtExecutor = null;
    private ?string $imprintID = null;
    private ?string $privacyID = null;
    private $testDBData;


    public function __construct(ModuleModel $objModule) {
        parent::__construct($objModule);
    }


    public function setDbStmtExecutor(DatabasePslzmeConfigStmtExecutor $dbStmtExecutor) {
        $this->dbStmtExecutor = $dbStmtExecutor;

        try {
            $dbConfigData = $this->dbStmtExecutor->selectCurrentDatabaseConfigurationData();
            $this->testDBData = $dbConfigData;
            $internalPageRefs = $dbConfigData["databaseIPR"];

            if (!empty($internalPageRefs)) {
                $internalPageRefs = json_decode($internalPageRefs, true);
                $this->imprintID = $internalPageRefs["Imprint"] ?? null;
                $this->privacyID = $internalPageRefs["Privacy"] ?? null;
            }
        } catch (DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }


    protected function compile() {}


    public function generate() {
        $this->Template->testDBData = $this->testDBData;
        // $this->Template->imprintID = $this->imprintID;
        // $this->Template->privacyID = $this->privacyID;
        $this->compile();

        return $this->Template->parse();
    }
}


?>