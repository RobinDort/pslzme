<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\Module;

class PslzmeCookiebar extends Module {
    protected $strTemplate = "mod_pslzme_cookiebar";

    private $dbc;

    public function __construct(DatabaseConnection $dbc) {
        $this->dbc = $dbc;
    }

    protected function compile() {}
}


?>