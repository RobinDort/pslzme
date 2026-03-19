<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

class PslzmeImageElement extends ContentElement {
    protected $strTemplate = 'ce_pslzme_image';

    protected function compile() {
        $unit = $this->contentSpaceUnit ?: 'px';

        $contentSpaceValue = unserialize($this->contentSpace) ?: [];
        $cpTop    = $contentSpaceValue['top'] ?? 0;
        $cpRight  = $contentSpaceValue['right'] ?? 0;
        $cpBottom = $contentSpaceValue['bottom'] ?? 0;
        $cpLeft   = $contentSpaceValue['left'] ?? 0;
        $cpUnit   = $contentSpaceValue['unit'] ?? 'px';
        $contentSpace = sprintf(
            "%s%s %s%s %s%s %s%s",
            $cpTop, $cpUnit,
            $cpRight, $cpUnit,
            $cpBottom, $cpUnit,
            $cpLeft, $cpUnit,
        );

        $textSpaceValue = unserialize($this->textSpace) ?: [];
        $tpTop    = $textSpaceValue['top'] ?? 0;
        $tpRight  = $textSpaceValue['right'] ?? 0;
        $tpBottom = $textSpaceValue['bottom'] ?? 0;
        $tpLeft   = $textSpaceValue['left'] ?? 0;
        $tpUnit   = $textSpaceValue['unit'] ?? 'px';
        $textSpace = sprintf(
            "%s%s %s%s %s%s %s%s",
            $tpTop, $tpUnit,
            $tpRight, $tpUnit,
            $tpBottom, $tpUnit,
            $tpLeft, $tpUnit,
        );

        $this->Template->contentSpace = $contentSpace;
        $this->Template->textSpace = $textSpace;
        $this->Template->firstImage = $this->firstImage;
        $this->Template->firstImageSize = $this->firstImageSize;
        $this->Template->firstImageAlt = $this->firstImageAlt;
        $this->Template->firstImageTitle = $this->firstImageTitle;
        $this->Template->secondImage = $this->secondImage;
        $this->Template->secondImageLink = $this->secondImageLink;
        $this->Template->secondImageSize = $this->secondImageSize;
        $this->Template->secondImageAlt = $this->secondImageAlt;
        $this->Template->secondImageTitle = $this->secondImageTitle;
        $this->Template->personalizedText = $this->personalizedText;
        $this->Template->unpersonalizedText = $this->unpersonalizedText;
    }
}