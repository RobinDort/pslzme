<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

class PslzmeImageElement extends ContentElement {
    protected $strTemplate = 'ce_pslzme_image';

    protected function compile() {
        $this->Template->firstImage = $this->firstImage;
        $this->Template->firstImageSize = $this->firstImageSize;
        $this->Template->secondImage = $this->secondImage;
        $this->Template->secondImageSize = $this->secondImageSize;
        $this->Template->personalizedText = $this->personalizedText;
        $this->Template->unpersonalizedText = $this->unpersonalizedText;
    }
}