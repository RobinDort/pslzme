<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;

class Pslzme3DContentElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_3D_content';


    protected function compile() {
        $this->Template->pageLink = $this->pageLink;
        $this->Template->html = $this->html;
        
        if ($this->addImage) {
            $this->Template->addImage = $this->addImage;
            $this->addImageToTemplate($this->Template, $this->arrData);
        }        
    }

}


?>