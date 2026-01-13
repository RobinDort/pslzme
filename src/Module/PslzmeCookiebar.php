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
    private $imprintID;
    private $privacyID;


    public function __construct(ModuleModel $objModule) {
        parent::__construct($objModule);

        $container = System::getContainer();
        $this->dbStmtExecutor = $this->dbStmtExecutor = $container->get(DatabasePslzmeConfigStmtExecutor::class);

        if (!$this->dbStmtExecutor) {
            \System::log("DB Executor is NULL in generate()", __METHOD__, TL_ERROR);
            throw new Exception("No dbStmtExecutor configured");
        }

        try {
            $dbConfigData = $this->dbStmtExecutor->selectCurrentDatabaseConfigurationData();
            $internalPageRefs = $dbConfigData["databaseIPR"];

            if (!empty($internalPageRefs)) {
                $internalPageRefs = json_decode($internalPageRefs,true);
                $this->imprintID = $internalPageRefs["Imprint"];
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
        parent::generate();

        // $imprintUrl = $this->imprintID ? System::getContainer()->get('contao.insert_tag.parser')->replace('{{link_url::' . $this->imprintID . '}}') : null;
        // $privacyUrl = $this->privacyID ? System::getContainer()->get('contao.insert_tag.parser')->replace('{{link_url::' . $this->privacyID . '}}') : null;

        $this->Template->imprintURL = $imprintUrl;
        $this->Template->privacyURL = $privacyUrl;
       
        $this->compile();

       return $this->Template->parse();
    }
}


?>