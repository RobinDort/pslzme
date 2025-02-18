<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\FilesModel;

class Pslzme3DContentElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_3D_content';


    protected function compile() {
        $this->Template->pageLink = $this->pageLink;
        $this->Template->html = $this->html;
        $this->Template->imageContent = $this->imageContent;

        if ($this->imageContent) {
            $imageModel = FilesModel::findByUuid($this->imageContent);
            
            if ($imageModel !== null) {
                $this->Template->imagePath = $imageModel->path;
                $this->Template->altText = $this->alt;
                $this->Template->imageCaption = $this->caption;
                $this->Template->floating = $this->floating;
            }
        }        
    }

}


?>