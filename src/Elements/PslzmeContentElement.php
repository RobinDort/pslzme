<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\FilesModel;
use Contao\PageModel;

/**
 * Custom contao element that represents the pslzme 3D content.
 */
class PslzmeContentElement extends ContentElement {

    protected $strTemplate = 'ce_pslzme_content';

    protected function compile() {
        $arrData = [];

        if ($this->unpersonalizedImage) {
            $unpersonalizedImage = FilesModel::findByUuid($this->unpersonalizedImage);

            if ($this->upImageUrl) {
                $unpersonalizedImagePage = PageModel::findPublishedById($this->upImageUrl);
                if ($unpersonalizedImagePage) {
                    $unpersonalizedImageLink = $unpersonalizedImagePage->getFrontendUrl();  // Get the URL of the page
                }
            }
            // Add unpersonalized image to the template
            $arrData['unpersonalizedImage'] = [
                'singleSRC'     => $unpersonalizedImage->path,
                'size'          => $this->upSize,
                'alt'           => $this->upAlt,
                'imageUrl'      => $unpersonalizedImageLink ?? '',
                'caption'       => $this->upCaption,
            ];
        }

        if ($this->personalizedImage) {
            $personalizedImage = FilesModel::findByUuid($this->personalizedImage);

            // Add personalized image to the template
            $arrData['personalizedImage'] = [
                'singleSRC'     => $personalizedImage->path,
                'size'          => $this->size,
                'alt'           => $this->alt,
                'imageUrl'      => $this->imageUrl,
                'caption'       => $this->caption,
            ];
        }

        // Pass the data to the template and insert images using the 'image' template part
        $this->Template->arrData = $arrData;

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