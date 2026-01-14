<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\FilesModel;
use Contao\PageModel;
use Contao\CoreBundle\Image\Studio\FigureFactory;
use Contao\System;

class PslzmeImageElement extends ContentElement {
    protected $strTemplate = 'ce_pslzme_image';

    protected function compile() {
        $factory = System::getContainer()->get(FigureFactory::class);
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

        $backgroundImage = '';
        if ($this->firstImage) {
            $file = FilesModel::findByUuid($this->firstImage);
            if ($file !== null) {
                $figure = $factory->create(
                    $file->path,
                    $this->firstImageSize ?? null,
                    [
                        'metadata' => [
                            'alt'   => $this->firstImageAlt ?: null,
                            'title' => $this->firstImageTitle ?: null,
                        ],
                    ]
                );
                $backgroundImage = '<div class="pslzme-background-figure">' . $figure->getHtml() . '</div>';
            }
        }

        $foregroundImage = '';
        if ($this->secondImage) {
            $file = FilesModel::findByUuid($this->secondImage);
            if ($file !== null) {
                $linkHref = null;
                
                if ($this->secondImageLink) {
                    $page = PageModel::findById($this->secondImageLink);

                    if ($page !== null) {
                        $linkHref = $page->getFrontendUrl();
                    }
                }
                
                $options = [
                    'metadata' => [
                        'alt'   => $this->secondImageAlt ?: null,
                        'title' => $this->secondImageTitle ?: null,
                    ],
                ];
                
                if ($linkHref) {
                    $options['linkHref'] = $linkHref;
                }
                
                $figure = $factory->create(
                    $file->path,
                    $this->secondImageSize ?? null,
                    $options
                );
                
                $foregroundImage = '<div class="pslzme-foreground-figure">' . $figure->getHtml() . '</div>';
            }
        }

        $this->Template->style = $style;
        $this->Template->backgroundImage = $backgroundImage;
        $this->Template->foregroundImage = $foregroundImage;
        $this->Template->personalizedText = $this->personalizedText;
        $this->Template->unpersonalizedText = $this->unpersonalizedText;
    }
}