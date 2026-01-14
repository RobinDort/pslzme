<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

class PslzmeImageElement extends ContentElement {
    protected $strTemplate = 'ce_pslzme_image';

    protected function compile() {
        $this->Template->contenSpaceUnit = $this->contentSpaceUnit;
        $this->Template->contentSpaceTop = $this->contentSpaceTop;
        $this->Template->contentSpaceRight = $this->contentSpaceRight;
        $this->Template->contentSpaceBottom = $this->contentSpaceBottom;
        $this->Template->contentSpaceLeft = $this->contentSpaceLeft;
        $this->Template->firstImage = $this->firstImage;
        $this->Template->firstImageSize = $this->firstImageSize;
        $this->Template->firstImageAlt = $this->firstImageAlt;
        $this->Template->firstImageTitle = $this->firstImageTitle;
        $this->Template->secondImage = $this->secondImage;
        $this->Template->secondImageSize = $this->secondImageSize;
        $this->Template->secondImageLink = $this->secondImageLink;
        $this->Template->secondImageAlt = $this->secondImageAlt;
        $this->Template->secondImageTitle = $this->secondImageTitle;
        $this->Template->personalizedText = $this->personalizedText;
        $this->Template->unpersonalizedText = $this->unpersonalizedText;
    }
}