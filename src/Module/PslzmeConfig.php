<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\Module;
use Contao\FrontendTemplate;
use Contao\Controller;
use Contao\Environment;

class PslzmeConfig extends Module {
    protected $strTemplate = "mod_pslzme_config";

    protected function compile() {}

    public function generate() {
        $this->Template = new FrontendTemplate($this->strTemplate);
        $this->compile();

        return $this->Template->parse();
    }
}


?>