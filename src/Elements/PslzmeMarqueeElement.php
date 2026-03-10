<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

/**
 * custom contao element that represents the main pslzme marquee element that is used to display a moving slider.
 */
class PslzmeMarqueeElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_marquee';

    protected function compile() {
        $content = '';

        if ($this->personalizedMarqueeText && $GLOBALS['decryptedVars']['varsSet'] === true) {
            $content = $this->personalizedMarqueeText;
        } else {
            $content = $this->unpersonalizedMarqueeText;
        }

        $this->Template->content = $content;
    }

}


?>