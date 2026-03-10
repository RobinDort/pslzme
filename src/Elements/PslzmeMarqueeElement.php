<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

/**
 * custom contao element that represents the main pslzme text element that is used to show personalized messages.
 */
class PslzmeMarqueeElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_marquee';

    protected function compile() {
        $this->Template->personalizedMarqueeText = $this->personalizedMarqueeText;
        $this->Template->unpersonalizedMarqueeText = $this->unpersonalizedMarqueeText;
    }

}


?>