<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

/**
 * custom contao element that represents the main pslzme text element that is used to show personalized messages.
 */
class PslzmeTextElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_text';


    public function generate() {
        $varsSet = $GLOBALS['decryptedVars']['varsSet'] ?? false;

        $personalized   = $this->personalizedText;
        $unpersonalized = $this->unpersonalizedText;
        $showUnpersonalized = $this->showUnpersonalizedText === "1";

        $shouldRender = false;

        if ($varsSet) {
            if (!empty($personalized) || ($showUnpersonalized && !empty($unpersonalized))) {
                $shouldRender = true;
            }
        } else {
            if ($showUnpersonalized && !empty($unpersonalized)) {
                $shouldRender = true;
            }
        }

        if (!$shouldRender) {
            return '';
        }

        return parent::generate();
    }


    protected function compile() {
        $this->Template->personalizedText = $this->personalizedText;
        $this->Template->unpersonalizedText = $this->unpersonalizedText;
        $this->Template->showUnpersonalizedText = $this->showUnpersonalizedText;
    }

}


?>