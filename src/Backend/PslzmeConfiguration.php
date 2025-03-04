<?php
namespace RobinDort\PslzmeLinks\Backend;

use Contao\BackendModule;
use Contao\BackendTemplate;
use \Contao\PageTree;

use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;

class PslzmeConfiguration extends BackendModule {

    protected $strTemplate = "be_pslzme_configuration";

    private $pslzmeDBName;
    private $pslzmeDBUser;
    private $pslzmeDBIPR;

    public function __construct() {
        parent::__construct();

        $dbPslzmeStmtExecutor = new DatabasePslzmeConfigStmtExecutor();
        $databaseData = $dbPslzmeStmtExecutor->selectCurrentDatabaseConfigurationData();
        $this->pslzmeDBName = $databaseData["databaseName"];
        $this->pslzmeDBUser = $databaseData["databaseUser"];
        $this->pslzmeDBIPR = $databaseData["databaseIPR"];
    }

    /**
     * {@inheritDoc}
     */
    public function compile() {}

    public function generate() {
        $this->Template = new BackendTemplate($this->strTemplate);
        $this->Template->pslzmeDBName = $this->pslzmeDBName;
        $this->Template->pslzmeDBUser = $this->pslzmeDBUser;

        // Create the PageTree widget
        $objWidget = new PageTree([
            'id'        => 'imprint_page',
            'name'      => 'imprint_page',
            'value'     => $selectedPageId,
            'fieldType' => 'radio', // Single selection
            'mandatory' => true, // Required
        ]);
        
        if ($_POST) {
            $objWidget->validate();
            if (!$objWidget->hasErrors()) {
                echo $objWidget->value;
            }
        }
        
        $this->compile();

        return $this->Template->parse();
    }

    
    private function saveSelectedPages() {
        $selectedPages = [
            'imprint_page' => Input::post('Imprint'),
            'privacy_page' => Input::post('privacy_policy'),
            'home_page' => Input::post('home')
        ];
    }
}
?>