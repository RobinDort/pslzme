<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\FilesModel;

/**
 * Custom contao element that represents the pslzme 3D content.
 */
class Pslzme3DContentElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_content';

    protected function compile() {
        $this->Template->pageLink = $this->pageLink;
        $this->Template->html = $this->html;
        
        if ($this->singleSRC) {
            $image = FilesModel::findByUuid($this->singleSRC);
            $this->addImageToTemplate($this->Template, [
                'singleSRC'     => $image->path,
                'size'          => $this->size,
                'imagemargin'   => $this->imagemargin,
                'fullsize'      => $this->fullsize,
                'imageUrl'      => $this->imageUrl,
                'floating'      => $this->floating,
                'caption'       => $this->caption,
                'alt'           => $this->alt
            ]);
        }        
    }

}


?>