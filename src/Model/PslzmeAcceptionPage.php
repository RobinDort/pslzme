<?php
namespace RobinDort\PslzmeLinks\Model;

use RobinDort\PslzmeLinks\Interfaces\CustomPageModel;

use Contao\PageModel;
use Contao\Database;

class PslzmeAcceptionPage extends PageModel implements CustomPageModel{

    /**
     * Properties extended from Contaos PageModel class.
     * @property integer $id
     * @property integer $pid
     * @property integer $sorting
     * @property integer $tstamp
     * @property string  $title
     * @property string  $alias
     * @property string  $type
     * @property string  $pageTitle
     * @property string  $language
     * @property string  $robots
     * @property string  $description
     * @property string  $redirect
     * @property integer $jumpTo
     * @property string  $url
     * @property boolean $target
     * @property string  $dns
     * @property string  $staticFiles
     * @property string  $staticPlugins
     * @property boolean $fallback
     * @property string  $adminEmail
     * @property string  $dateFormat
     * @property string  $timeFormat
     * @property string  $datimFormat
     * @property boolean $createSitemap
     * @property string  $sitemapName
     * @property boolean $useSSL
     * @property boolean $autoforward
     * @property boolean $protected
     * @property string  $groups
     * @property boolean $includeLayout
     * @property integer $layout
     * @property integer $mobileLayout
     * @property boolean $includeCache
     * @property integer $cache
     * @property boolean $includeChmod
     * @property integer $cuser
     * @property integer $cgroup
     * @property string  $chmod
     * @property boolean $noSearch
     * @property string  $cssClass
     * @property string  $sitemap
     * @property boolean $hide
     * @property boolean $guests
     * @property integer $tabindex
     * @property boolean $accesskey
     * @property boolean $published
     * @property string  $start
     * @property string  $stop
     * @property array   $trail
     * @property string  $mainAlias
     * @property string  $mainTitle
     * @property string  $mainPageTitle
     * @property string  $parentAlias
     * @property string  $parentTitle
     * @property string  $parentPageTitle
     * @property string  $folderUrl
     * @property integer $rootId
     * @property string  $rootAlias
     * @property string  $rootTitle
     * @property string  $rootPageTitle
     * @property string  $domain
     * @property string  $rootLanguage
     * @property boolean $rootIsPublic
     * @property boolean $rootIsFallback
     * @property boolean $rootUseSSL
     * @property string  $rootFallbackLanguage
     * @property array   $subpages
     * @property string  $outputFormat
     * @property string  $outputVariant
     * @property boolean $hasJQuery
     * @property boolean $hasMooTools
     * @property boolean $isMobile
     * @property string  $template
     * @property string  $templateGroup
     * */


    protected static $strTable = 'tl_page';

    private const PAGE_TITLE = "Pslzme-Accept";
    private const PAGE_TYPE = "regular";
    private const PAGE_ROBOTS = "index,follow";
    private const PAGE_REDIRECT = "permanent";
    private const PAGE_SITEMAP = "map_default";


    public function __construct() {
        parent::__construct();

        $unixTime = time();
        $layoutID = $this->findMostUsedLayoutID();
        
        $this->tstamp = $unixTime;
        $this->title = self::PAGE_TITLE;
        $this->pageTitle = self::PAGE_TITLE;
        $this->alias = strtolower(self::PAGE_TITLE);
        $this->type = self::PAGE_TYPE;
        $this->robots = self::PAGE_ROBOTS;
        $this->redirect = self::PAGE_REDIRECT;
        $this->jumpTo = 0;
        $this->chmod = serialize(array(
            0 => "u1",
            1 => "u2",
            2 => "u3",
            3 => "u4",
            4 => "u5",
            5 => "u6",
            6 => "g4",
            7 => "g5",
            8 => "g6"
        ));
        $this->sitemap = self::PAGE_SITEMAP;
        $this->hide = false;
        $this->published = true;

        // include layout when one is present
        if ($layoutID !== -1) {
            $this->includeLayout = true;
            $this->layout = $layoutID;
        }
    }

    public function selfExists() {
        // Check if the page is already existent.
        $existentPage = PageModel::findByTitle(self::PAGE_TITLE);
        if ($existentPage !== null) {
           return true;
        }
  
        return false;
    }


    public function selectActivePageRootID() {
        $sqlQuery = "SELECT id FROM tl_page WHERE type='root' AND fallback=1";
        $stmt = Database::getInstance()->execute($sqlQuery)->fetchAssoc();

        return $stmt["id"] ?? 1;
    }

    public function findMostUsedLayoutID() {
        $sqlQuery = "SELECT layout, COUNT(layout) AS count FROM tl_page GROUP BY layout ORDER BY count DESC LIMIT 1";
        $stmt = Database::getInstance()->execute($sqlQuery)->fetchAssoc();

        return $stmt["layout"] ?? -1;
    }


    public function findLatestSorting($pid) {
        $sqlQuery = "SELECT * FROM 'l_page' WHERE pid = " . $pid . " GROUP BY sorting ORDER BY sorting DESC LIMIT 1;";
        $stmt = Database::getInstance()->execute($sqlQuery)->fetchAssoc();

        return $stmt["sorting"] + 1 ?? 1;
    }
  
    public function getTitle() {
        return $this->title;
    }
  
    public function getID() {
        return $this->id;
    }
  
    public function setParentPageID($parentPageID) {
        $this->pid = $parentPageID;
        $this->sorting = $this->pid + 1; 
    }

    public function setSorting($sorting) {
        $this->sorting = $sorting;
    }
}

?>