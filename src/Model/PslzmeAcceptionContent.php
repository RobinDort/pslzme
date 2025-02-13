<?php
namespace RobinDort\PslzmeLinks\Model;

use Contao\ContentModel;
use Contao\Files;
use Contao\ArticleModel;


class PslzmeAcceptionContent extends ContentModel {
    /**
    * Properties extended from Contaos ContentModel class.
    * @property string|integer    $id
    * @property string|integer    $pid
    * @property string            $ptable
    * @property string|integer    $sorting
    * @property string|integer    $tstamp
    * @property string            $type
    * @property string            $headline
    * @property string|null       $text
    * @property string|boolean    $addImage
    * @property string|boolean    $inline
    * @property string|boolean    $overwriteMeta
    * @property string|null       $singleSRC
    * @property string            $alt
    * @property string            $imageTitle
    * @property string|integer    $size
    * @property string|array      $imagemargin
    * @property string            $imageUrl
    * @property string|boolean    $fullsize
    * @property string            $caption
    * @property string            $floating
    * @property string|null       $html
    * @property string            $listtype
    * @property string|array|null $listitems
    * @property string|array|null $tableitems
    * @property string            $summary
    * @property string|boolean    $thead
    * @property string|boolean    $tfoot
    * @property string|boolean    $tleft
    * @property string|boolean    $sortable
    * @property string|integer    $sortIndex
    * @property string            $sortOrder
    * @property string            $mooHeadline
    * @property string            $mooStyle
    * @property string            $mooClasses
    * @property string            $highlight
    * @property string            $markdownSource
    * @property string|null       $code
    * @property string            $url
    * @property string|boolean    $target
    * @property string|boolean    $overwriteLink
    * @property string            $titleText
    * @property string            $linkTitle
    * @property string            $embed
    * @property string            $rel
    * @property string|boolean    $useImage
    * @property string|array|null $multiSRC
    * @property string|array|null $orderSRC
    * @property string|boolean    $useHomeDir
    * @property string|integer    $perRow
    * @property string|integer    $perPage
    * @property string|integer    $numberOfItems
    * @property string            $sortBy
    * @property string|boolean    $metaIgnore
    * @property string            $galleryTpl
    * @property string            $customTpl
    * @property string|null       $playerSRC
    * @property string            $youtube
    * @property string            $vimeo
    * @property string|null       $posterSRC
    * @property string|array      $playerSize
    * @property string|array|null $playerOptions
    * @property string|integer    $playerStart
    * @property string|integer    $playerStop
    * @property string            $playerCaption
    * @property string            $playerAspect
    * @property string|boolean    $splashImage
    * @property string            $playerPreload
    * @property string            $playerColor
    * @property string|array|null $youtubeOptions
    * @property string|array|null $vimeoOptions
    * @property string|integer    $sliderDelay
    * @property string|integer    $sliderSpeed
    * @property string|integer    $sliderStartSlide
    * @property string|boolean    $sliderContinuous
    * @property string|integer    $cteAlias
    * @property string|integer    $articleAlias
    * @property string|integer    $article
    * @property string|integer    $form
    * @property string|integer    $module
    * @property string|boolean    $protected
    * @property string|array|null $groups
    * @property string|boolean    $guests
    * @property string|array      $cssID
    * @property string|boolean    $invisible
    * @property string|integer    $start
    * @property string|integer    $stop
    * @property string|boolean    $showPreview
    */

    protected static $strTable = 'tl_content';

    public function __construct() {
        parent::__construct();

        $time = time();

        $this->pid = $this->findParentArticleID();
        $this->type = "text";
        $this->sorting = 128;
        $this->tstamp = $time;
        $this->text = $GLOBALS['TL_LANG']['robindort_pslzme_links']['pslzme_accept_content'];
        $this->addImage = true;
        $this->size = serialize(array(
            0 => "350",
            1 => "",
            2 => "proportional"
        ));
        $this->imagemargin = serialize(array(
            "bottom" => 50,
            "left" => "",
            "right" => "",
            "top" => 100,
            "unit" => "px"
        ));
        $this->singleSRC = $this->findUUID();
        $this->floating = "above";
        $this->cssID = serialize(["",""]);

    }


    public function findUUID() {
        // Get the pslzme logo as image from the asset folder
        $filepath = 'bundles/robindortpslzmelinks/images/pslzme_logo.svg';

        // Find the file in Contao's file system
        $file = Files::getPathFromUuid($filePath);

        // If the file is found, get the UUID
        $fileUUID = $file ? $file->getUuid() : null;

        return $fileUUID;
    }

    public function findParentArticleID() {
        $parentArticle = ArticleModel::findOneBy('title', "Pslzme-Accept");
        $pid = $parentArticle->id ?? 1;
        return $pid;
    }

    public function selfExists() {
        $existentContent = ContentModel::findOneByPid($this->pid);
        if ($existentContent !== null) {
            return true;
         }
   
         return false;
    }
}

?>