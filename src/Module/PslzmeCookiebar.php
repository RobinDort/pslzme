<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\Module;

class PslzmeCookiebar extends Module {
    protected $strTemplate = "mod_pslzme_cookiebar";

    private $dbc;

    public function __construct(DatabaseConnection $dbc) {
        try {
            $this->dbc = $dbc;
        } catch (DatabaseException $dbe) {
            error_log($dbe->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    protected function compile() {}
}


?>