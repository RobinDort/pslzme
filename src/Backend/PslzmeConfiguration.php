<?php
namespace RobinDort\PslzmeLinks\Backend;

use Contao\BackendModule;
use Contao\BackendTemplate;
use Contao\PageTree;
use Contao\Input;

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

        if (Input::post('FORM_SUBMIT') === "internal-page-form") {
            // Validate CSRF token
            if (!System::getContainer()->get('contao.csrf.token_manager')->isTokenValid(Input::post('REQUEST_TOKEN'))) {
                throw new \Exception('Invalid CSRF token');
            }
        }

        $currentValue = Input::post('imprint_page') ?: 0;

        // Create the PageTree widget
        $imprintPageTree = new PageTree([
            'id'        => 'imprint_page',
            'name'      => 'imprint_page',
            'value'     => $currentValue,
            'fieldType' => 'radio', // Single selection
            'mandatory' => true, // Required
        ]);
        
        $this->Template->imprintPageTree = $imprintPageTree->generate();
        $this->Template->selectedPage = $imprintPageTree->value;
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