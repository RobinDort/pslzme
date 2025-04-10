<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\ModuleNavigation;
use Contao\PageModel;

class PslzmeNavigation extends ModuleNavigation {

    protected $strTemplate = 'mod_navigation_pslzme';

    protected function compile(): void {
        parent::compile();
    }
}


?>