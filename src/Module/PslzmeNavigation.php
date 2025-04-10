<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\ModuleNavigation;
use Contao\PageModel;

class PslzmeNavigation extends ModuleNavigation {

    protected $strTemplate = "mod_pslzme_navbar";

    protected function compile(): void {
        parent::compile();
        $this->Template->items = $this->Template->items; 
        var_dump($this->Template->items);
    }
}


?>