<?php
namespace RobinDort\PslzmeLinks\Model;

use Contao\ArticleModel;
use Contao\PageModel;
use Contao\Database;


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

    public function __construct() {
        parent::__construct();

        $time = time();

        $this->pid = 252;
        $this->title = "Pslzme-Accept";
        $this->alias = "pslzme-accept";
        $this->author = 2;
        $this->inColumn = "main";
        $this->sorting = 128;
        $this->tstamp = $time;
        $this->published = true;
        $this->teaserCssID = serialize(["", ""]);
        $this->cssID = serialize(["", ""]);
    }

    public function selfExists() {
        $existentArticle = ArticleModel::findOneBy('title', self::ARTICLE_TITLE);
        
        if ($existentArticle !== null) {
            return true;
         }
   
         return false;

    }

    public function findParentPageID() {
        $sqlQuery = "SELECT id FROM tl_page WHERE title='" . self::ARTICLE_TITLE . "'";
        $stmt = Database::getInstance()->execute($sqlQuery);
        $result = $stmt->fetchAssoc();

        return $result ? $result["id"] : 1;
    }
}

?>