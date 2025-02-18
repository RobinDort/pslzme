<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

class Pslzme3DContentElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_3D_content';


    protected function compile() {
        $this->Template->pageLink = $this->pageLink;
        $this->Template->html = $this->html;
        $this->Template->imageContent = $this->imageContent;

        if ($this->imageContent) {
            $this->addImageToTemplate($this->Template, $this->arrData);
        }        
    }

}


?>