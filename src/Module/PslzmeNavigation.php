<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\ModuleNavigation;
use Contao\PageModel;

class PslzmeNavigation extends ModuleNavigation {

    protected function compile(): void {
        parent::compile();
    }

    public function generate() {
        $this->navigationTpl = 'nav_pslzme';
        $this->compile();

        return $this->Template->parse();
    }
}


?>