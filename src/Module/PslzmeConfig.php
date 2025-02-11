<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\FrontendModule;
use Contao\FrontendTemplate;
use Contao\Controller;
use Contao\Environment;

class PslzmeConfig extends FrontendModule {
    protected $strTemplate = "mod_pslzme_config";

    protected function compile() {}

    public function generate() {
        $this->Template = new FrontendTemplate($this->strTemplate);
        $this->compile();

        return $this->Template->parse();
    }
}


?>