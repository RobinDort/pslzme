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

        $imprintPageTree = new PageTree([
            'id'        => 'Imprint',
            'name'      => 'Imprint',
            'value'     => '',
            'fieldType' => 'radio', // Only one page per name
            'multiple'  => false
        ]);
        $imprintPageTree->generate();

        $privacyPolicyPageTree = new PageTree([
            'id'        => 'Privacy Policy',
            'name'      => 'Privacy Policy',
            'value'     => '',
            'fieldType' => 'radio', // Only one page per name
            'multiple'  => false
        ]);
        $privacyPolicyPageTree->generate();

        $homePageTree = new PageTree([
            'id'        => 'Home',
            'name'      => 'Home',
            'value'     => '',
            'fieldType' => 'radio', // Only one page per name
            'multiple'  => false
        ]);
        $HomePageTree->generate();

        $this->Template->imprintPageTree = $imprintPageTree;
        $this->Template->privacyPolicyPageTree = $privacyPolicyPageTree;
        $this->Template->homePageTree = $homePageTree;

        $this->compile();

        return $this->Template->parse();
    }
}
?>