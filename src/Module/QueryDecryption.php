<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\Module;
use Contao\FrontendTemplate;

class QueryDecryption extends Module {
    protected $strTemplate = 'rsce_query_decryption';


    /**
     * Generate the module content
     */
    protected function compile(){
        $this->Template = new FrontendTemplate($this->strTemplate);

        return parent::generate();
    }
}
?>