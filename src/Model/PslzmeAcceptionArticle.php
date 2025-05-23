<?php
namespace RobinDort\PslzmeLinks\Model;

use RobinDort\PslzmeLinks\Interfaces\CustomArticleModel;

use Contao\ArticleModel;
use Contao\PageModel;
use Contao\Database;
use Contao\BackendUser;


class PslzmeAcceptionArticle extends ArticleModel implements CustomArticleModel{
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

        $this->pid = $this->findParentPageID();
        $this->title = self::ARTICLE_TITLE;
        $this->alias = strtolower(self::ARTICLE_TITLE);
        $this->author = $this->findAuthorID();
        $this->sorting = 128;
        $this->tstamp = $time;
        $this->published = true;
    }

    public function selfExists() {
        $existentArticle = ArticleModel::findOneBy('title', self::ARTICLE_TITLE);
        
        if ($existentArticle !== null) {
            return true;
         }
   
         return false;

    }

    public function findParentPageID() {
       // find the parent page and its ID by searching for its title. Same title as the articles.
       $parentPage = PageModel::findByTitle(self::ARTICLE_TITLE);

       // Check if $parentPage is a collection or a single model, then return its ID
       if ($parentPage instanceof \Model\Collection) {
           return $parentPage->current()->id ?? 1;
       }
       return $parentPage->id ?? 1;
    }

    public function findAuthorID() {
        $currentBackendUser = BackendUser::getInstance();
        $authorId = $currentBackendUser->id;
        return $authorId ?? 1;
    }

    public function setInColumn($value) {
        $this->inColumn = $value;
    }
}

?>