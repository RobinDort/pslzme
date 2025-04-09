<?php
namespace RobinDort\PslzmeLinks\Elements;

use Contao\ContentElement;
use Contao\FilesModel;
use Contao\PageModel;
use Exception;

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
        $map = [
            'player_autoplay'     => 'autoplay',
            'player_loop'         => 'loop',
            'player_playsinline'  => 'playsinline',
            'player_muted'        => 'muted',
        ];
        if ($this->unpersonalizedVideo) {
            $unpersonalizedVideo = FilesModel::findByUuid($this->unpersonalizedVideo);

            $upPlayerOptions = deserialize($this->upPlayerOptions, true);
            $upVideoDataOptions = [];

             // Add only selected options
             foreach ($map as $key => $attribute) {
                if (in_array($key, $upPlayerOptions)) {
                    $upVideoDataOptions[] = $attribute;
                }
            }
            // Add controls only if NOT hidden
            if (!in_array('player_nocontrols', $upPlayerOptions)) {
                $upVideoDataOptions[] = 'controls';
            }

            $upVideoData = [
                "src"           => $unpersonalizedVideo ? $unpersonalizedVideo->path : "",
                "size"          => deserialize($this->upPlayerSize),
                "preload"       => $this->upPlayerPreload,
                "caption"       => $this->upPlayerCaption,
            ];

            $this->Template->upVideoData = $upVideoData;
            $this->Template->upVideoDataOptions = $upVideoDataOptions;
        }


        if ($this->personalizedVideo) {
            $personalizedVideo = FilesModel::findByUuid($this->personalizedVideo);

            $playerOptions = deserialize($this->playerOptions, true);
            
            $pVideoDataOptions = [];
            
            // Add only selected options
            foreach ($map as $key => $attribute) {
                if (in_array($key, $playerOptions)) {
                    $pVideoDataOptions[] = $attribute;
                }
            }
            // Add controls only if NOT hidden
            if (!in_array('player_nocontrols', $playerOptions)) {
                $pVideoDataOptions[] = 'controls';
            }

            $pVideoData = [
                "src"           => $personalizedVideo ? $personalizedVideo->path : "",
                "size"          => deserialize($this->playerSize),
                "preload"       => $this->playerPreload,
                "caption"       => $this->playerCaption,
            ];

            $this->Template->pVideoData = $pVideoData;
            $this->Template->pVideoDataOptions = $pVideoDataOptions;
        }
    }
}


?>