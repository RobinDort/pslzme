<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

/**
 * custom contao element that represents the main pslzme text element that is used to show personalized messages.
 */
class PslzmeTextElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_text';

    protected function compile() {
        $shouldRender = false;

        if ($varsSet) {
            if (!empty($this->personalizedText) || ($this->showUnpersonalizedText && !empty($this->unpersonalizedText))) {
                $shouldRender = true;
            }
        } else {
            if ($this->showUnpersonalizedText && !empty($this->unpersonalizedText)) {
                $shouldRender = true;
            }
        }

        if (!$shouldRender) {
            return;
        }
        
        $this->Template->personalizedText = $this->personalizedText;
        $this->Template->unpersonalizedText = $this->unpersonalizedText;
    }

}


?>