<?php
namespace RobinDort\PslzmeLinks\Model;

use Contao\ArticleModel;

class PslzmeAcceptionArticle extends ArticleModel {
    /**
     * Properties extended from Contaos ArticleModel class.
     * @property string|integer $id
     * @property string|integer $pid
     * @property string|integer $sorting
     * @property string|integer $tstamp
     * @property string         $title
     * @property string         $alias
     * @property string|integer $author
     * @property string         $inColumn
     * @property string|null    $keywords
     * @property string|boolean $showTeaser
     * @property string         $teaserCssID
     * @property string|null    $teaser
     * @property string         $printable
     * @property string         $customTpl
     * @property string|boolean $protected
     * @property string|null    $groups
     * @property string|boolean $guests
     * @property string|array   $cssID
     * @property string|boolean $published
     * @property string|integer $start
     * @property string|integer $stop
    */

    protected static $strTable = 'tl_article';

    private const ARTICLE_TITLE = "Pslzme-Accept";

    public function __construct($parentPageID) {
        parent::construct();

        $time = time();

        $this->pid = $parentPageID;
        $this->title = self::ARTICLE_TITLE;
        $this->alias = strtolower(self::ARTICLE_TITLE);
        $this->time = $time;
        $this->sorting = 128;
        $this->published = true;
    }

    public function selfExists() {
        $existentArticle = ArticleModel::findByTitle(self::PAGE_TITLE);
        
        if ($existentArticle !== null) {
            return true;
         }
   
         return false;

    }
}

?>