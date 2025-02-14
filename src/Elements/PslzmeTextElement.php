<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

class PslzmeTextElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_text';


    protected function compile() {
        $this->Template->personalizedText = $this->personalizedText;
        $this->Template->unpersonalizedText = $this->unpersonalizedText;
    }

}


?>