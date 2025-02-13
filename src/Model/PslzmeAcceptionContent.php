<?php
namespace RobinDort\PslzmeLinks\Model;

use RobinDort\PslzmeLinks\Interfaces\CustomContentModel;

use Contao\ContentModel;
use Contao\FilesModel;
use Contao\ArticleModel;
use Contao\Environment;


class PslzmeAcceptionContent extends ContentModel implements CustomContentModel {
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
        $this->addImage = false;
        $this->cssID = serialize(["",""]);
        $this->text = '<h1 style="text-align: left;">Dear visitor,</h1>
                    <p style="text-align: left;">You visited our website via a revolutionary pslz<strong>me</strong> link.</p>
                    <p style="text-align: left;">With pslz<strong>me</strong> we are able to <strong>personalize</strong> our website for you <strong>in compliance with GDPR</strong>, if you allow us to do so.</p>
                    <p style="text-align: left;">Please let us know via the pslz<strong>me</strong> pop-up whether we may personalize our website for you or whether you do not wish us to do so.</p>
                    <p style="text-align: left;"><strong>Don\'t worry</strong>: pslz<strong>me</strong> runs exclusively on our servers in Germany and there is no data exchange with other servers.</p>
                    <p style="text-align: left;">If you object to the pslz<strong>me</strong> function, we will simply redirect you to our standard website and your data will not be used in any way.</p>
                    <p style="text-align: left;">However, if you agree, you will experience a <strong>veritable firework </strong>display of almost <strong>limitless possibilities</strong> that are available via our <strong>sophisticated system</strong> in the areas of <strong>programmatic web</strong> and even <strong>programmatic print</strong> and which we would also like to offer you for use <strong>on your own websites</strong>.</p>
                    <p style="text-align: left;"><strong>Best regards,</strong><br><strong>Your team at Alexander Dort GmbH</strong></p>
                    <p style="text-align: left;">[nbsp]</p>';

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