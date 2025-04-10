<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\ModuleNavigation;
use Contao\PageModel;

class PslzmeNavigation extends ModuleNavigation {

    protected function compile(): void {
        $this->navigationTpl = 'nav_pslzme';
        parent::compile();
    }
}


?>