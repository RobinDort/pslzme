<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\ContentModel;

/**
 * custom contao element that represents the main pslzme 3d text element that is used to show personalized messages.
 */
class PslzmeContainerElement extends ContentElement {
    protected $strTemplate = 'ce_pslzme_container';

    protected function compile() {
        $this->Template->containerWidth = $this->pslzme_container_width;

        // Fetch child elements
       $this->Template->elements = ContentModel::findBy(
            ['ptable=?'],
            [$this->id]
        );
    }

    protected function getChildElements() {
        $children = \Contao\ContentModel::findBy(
            ['ptable=?', 'pid=?'],
            ['tl_content', $this->id]
        );

        return $children;
    }
}

?>