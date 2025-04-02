<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\FilesModel;

/**
 * Custom contao element that represents the pslzme 3D content.
 */
class PslzmeContentElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_content';

    protected function compile() {
        if ($this->unpersonalizedImage) {
            $unpersonalizedImage = FilesModel::findByUuid($this->unpersonalizedImage);
            // Add personalized image to the template
            $this->addImageToTemplate($this->Template, [
                'singleSRC'     => $unpersonalizedImage->path,
                'size'          => $this->size,
                'imagemargin'   => $this->imagemargin,
                'fullsize'      => $this->fullsize,
                'imageUrl'      => $this->imageUrl,
                'floating'      => $this->floating,
                'caption'       => $this->caption,
                'alt'           => $this->alt
            ]);
        }

        // $this->Template->pageLink = $this->pageLink;
        // $this->Template->html = $this->html;
        
        // if ($this->singleSRC) {
        //     $image = FilesModel::findByUuid($this->singleSRC);
        //     $this->addImageToTemplate($this->Template, [
        //         'singleSRC'     => $image->path,
        //         'size'          => $this->size,
        //         'imagemargin'   => $this->imagemargin,
        //         'fullsize'      => $this->fullsize,
        //         'imageUrl'      => $this->imageUrl,
        //         'floating'      => $this->floating,
        //         'caption'       => $this->caption,
        //         'alt'           => $this->alt
        //     ]);
        // }        
    }

}


?>