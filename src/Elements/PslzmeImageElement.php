<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

class PslzmeImageElement extends ContentElement {
    protected $strTemplate = 'ce_pslzme_image';

    protected function compile() {
        $unit = $this->contentSpaceUnit ?: 'px';

        $contentSpaceValue = unserialize($this->contentSpace);
        $contentSpace = sprintf(
            "%s%s %s%s %s%s %s%s",
            $contentSpaceValue['top'] ?? 0, $contentSpaceValue['unit'] ?? 'px',
            $contentSpaceValue['right'] ?? 0, $contentSpaceValue['unit'] ?? 'px',
            $contentSpaceValue['bottom'] ?? 0, $contentSpaceValue['unit'] ?? 'px',
            $contentSpaceValue['left'] ?? 0, $contentSpaceValue['unit'] ?? 'px',
        );

        $textSpaceValue = unserialize($this->textSpace);
        $textSpace = sprintf(
            "%s%s %s%s %s%s %s%s",
            $textSpaceValue['top'] ?? 0, $textSpaceValue['unit'] ?? 'px',
            $textSpaceValue['right'] ?? 0, $textSpaceValue['unit'] ?? 'px',
            $textSpaceValue['bottom'] ?? 0, $textSpaceValue['unit'] ?? 'px',
            $textSpaceValue['left'] ?? 0, $textSpaceValue['unit'] ?? 'px',
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