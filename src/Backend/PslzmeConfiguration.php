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

        $widgets = [];
        $internalPageReferences = ["Imprint", "Privacy policy", "Home"];

        foreach ($internalPageReferences as $key => $pageLabel) {
            $widget = new PageTree([
                'id'        => 'pageTree_' . $key,
                'name'      => 'pageSelections[' . $pageLabel . ']',
                'value'     => '',
                'fieldType' => 'radio', // Only one page per name
                'multiple'  => false
            ]);
    
            $widgets[$pageLabel] = $widget->generate();
        }

        $this->Template->internalPages = $widgets;
        $this->compile();

        return $this->Template->parse();
    }
}
?>