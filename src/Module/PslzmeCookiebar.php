<?php
namespace RobinDort\PslzmeLinks\Module;

use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

use Contao\Module;
use Contao\ModuleModel;
use Contao\System;
use Exception;

class PslzmeCookiebar extends Module {
    protected $strTemplate = "mod_pslzme_cookiebar";

    private ?DatabasePslzmeConfigStmtExecutor $dbStmtExecutor = null;
    private ?string $imprintID = null;
    private ?string $privacyID = null;


    public function __construct(ModuleModel $objModule) {
        parent::__construct($objModule);

        $container = System::getContainer();
        $this->dbStmtExecutor = $this->dbStmtExecutor = $container->get(DatabasePslzmeConfigStmtExecutor::class);

        if (!$this->dbStmtExecutor) {
            \System::log("DB Executor is NULL in generate()", __METHOD__, TL_ERROR);
            throw new Exception("No dbStmtExecutor configured");
        }

        // try {
            $dbConfigData = $this->dbStmtExecutor->selectCurrentDatabaseConfigurationData();
            $internalPageRefs = $dbConfigData["databaseIPR"];

            if (!empty($internalPageRefs)) {
                //$internalPageRefs = $internalPageRefs;
                \System::log("Page refs: " . $internalPageRefs["Imprint"], __METHOD__, "TL_ERROR");
                throw new Exception("page refs!");
                $this->imprintID = $internalPageRefs["Imprint"] ?? null;
                $this->privacyID = $internalPageRefs["Privacy"] ?? null;
            }
        // } catch (DatabaseException $dbe) {
        //     error_log($dbe->getErrorMsg());
        // } catch (Exception $e) {
        //     error_log($e->getMessage());
        // }
    }


    protected function compile() {}


    public function generate() {
        $output = parent::generate();

        $this->Template->imprintID = $this->imprintID;
        $this->Template->privacyID = $this->privacyID;
        $this->compile();

       return $output;
    }
}


?>