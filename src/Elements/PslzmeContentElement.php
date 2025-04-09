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

        $pImageData = [];
        $upImageData = [];

        $this->Template->selectedContent = $this->selectedContent;


        /** Images */

        if ($this->unpersonalizedImage) {
            $unpersonalizedImage = FilesModel::findByUuid($this->unpersonalizedImage);

            if ($this->upImageUrl) {
                $unpersonalizedImagePage = PageModel::findPublishedById($this->upImageUrl);
                if ($unpersonalizedImagePage) {
                    $unpersonalizedImageLink = $unpersonalizedImagePage->getFrontendUrl();  // Get the URL of the page
                }
            }
            // Add unpersonalized image to the template
            $upImageData['unpersonalizedImage'] = [
                'singleSRC'     => $unpersonalizedImage->path,
                'size'          => $this->upSize,
                'config' => [
                    'metadata' => [
                        'alt' => $this->upAlt,
                        'caption' => $this->upCaption,
                    ],
                    'linkHref' => $unpersonalizedImageLink ?? '',
                ],
            ];
        }

        if ($this->personalizedImage) {
            $personalizedImage = FilesModel::findByUuid($this->personalizedImage);

            // Add personalized image to the template
            $pImageData['personalizedImage'] = [
                'singleSRC'     => $personalizedImage->path,
                'size'          => $this->size,
                'config' => [
                    'metadata' => [
                        'alt' => $this->alt,
                        'caption' => $this->caption,
                    ],
                    'linkHref' => $this->imageUrl,
                ],
            ];
        }

        $this->Template->upImageData = $upImageData;
        $this->Template->pImageData = $pImageData;


        /** Videos */
        if ($this->personalizedVideo) {
            $personalizedVideo = FilesModel::findByUuid($this->personalizedVideo);
            if ($this->posterSRC) {
                $personalizedVideoPoster = FilesModel::findByUuid(($this->posterSRC));
            }

            $pVideoData = [
                "src"           => $personalizedVideo ? $personalizedVideo->path : "",
                "size"          => deserialize($this->playerSize),
                "poster"        => $personalizedVideoPoster ?? $this->personalizedVideoPoster->path,
                "autoplay"      => $this->playerOptions['player_autoplay'] ?? false,
                "loop"          => $this->playerOptions['player_loop'] ?? false,
                "muted"         => $this->playerOptions['player_muted'] ?? false,
                "inline"        => $this->playerOptions['player_playsinline'] ?? false,
                "noControls"    => $this->playerOptions['player_nocontrols'] ?? false,
                "preload"       => $this->playerPreload,
                "caption"       => $this->playerCaption,
            ];

            $this->Template->pVideoData = $pVideoData;
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