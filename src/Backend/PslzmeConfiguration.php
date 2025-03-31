<?php
namespace RobinDort\PslzmeLinks\Backend;

use Contao\BackendModule;
use Contao\BackendTemplate;
use Contao\PageTree;
use Contao\Input;
use Contao\System;

/**
 * Class that handles the backend configuration module for plszme
 */
use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

class PslzmeConfiguration extends BackendModule {

    protected $strTemplate = "be_pslzme_configuration";

    private $pslzmeDBName;
    private $pslzmeDBUser;
    private $pslzmeDBIPR;
    private $urlLicensed;


    /**
     * constructor 
     */
    public function __construct() {
        parent::__construct();

        $dbPslzmeStmtExecutor = System::getContainer()->get(DatabasePslzmeConfigStmtExecutor::class);

        $databaseData = $dbPslzmeStmtExecutor->selectCurrentDatabaseConfigurationData();
        if (!empty($databaseData)) {
            $this->pslzmeDBName = $databaseData["databaseName"];
            $this->pslzmeDBUser = $databaseData["databaseUser"];
            $this->pslzmeDBIPR = $databaseData["databaseIPR"];
            $this->urlLicensed = $databaseData["urlLicensed"];
        }
    }


    /**
     * {@inheritDoc}
     */
    public function compile() {}

    /**
     * generate function to assign template variables
     */
    public function generate() {
        $this->Template = new BackendTemplate($this->strTemplate);
        $this->Template->pslzmeDBName = $this->pslzmeDBName;
        $this->Template->pslzmeDBUser = $this->pslzmeDBUser;
        $this->Template->urlLicensed = $this->urlLicensed;

        if(!empty($this->pslzmeDBIPR)) {
            $decodedPages = json_decode($this->pslzmeDBIPR,true);
            $imprintID = $decodedPages["Imprint"];
            $privacyID = $decodedPages["Privacy"];

            $this->Template->imprintID = $imprintID;
            $this->Template->privacyID = $privacyID;
        }

        $this->compile();

        return $this->Template->parse();
    }
}
?>