<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\FilesModel;
use Contao\PageModel;
use Contao\System;

class PslzmeImageElement extends ContentElement {
    protected $strTemplate = 'ce_pslzme_image';

    protected function compile() {
        $unit = $this->contentSpaceUnit ?: 'px';
        $style = '';

        if ($this->contentSpaceTop !== '') {
            $style .= 'margin-top:' . $this->contentSpaceTop . $unit . ';';
        }
        if ($this->contentSpaceRight !== '') {
            $style .= 'margin-right:' . $this->contentSpaceRight . $unit . ';';
        }
        if ($this->contentSpaceBottom !== '') {
            $style .= 'margin-bottom:' . $this->contentSpaceBottom . $unit . ';';
        }
        if ($this->contentSpaceLeft !== '') {
            $style .= 'margin-left:' . $this->contentSpaceLeft . $unit . ';';
        }


        $this->Template->style = $style;
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