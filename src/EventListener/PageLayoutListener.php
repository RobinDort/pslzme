<?php
namespace RobinDort\PslzmeLinks\EventListener;

use Contao\PageModel;
use Contao\LayoutModel;
use Contao\PageRegular;

class PageLayoutListener {
    public function __invoke(PageModel $pageModel, LayoutModel $layoutModel, PageRegular $pageRegular): void
    {
        if ($pageModel->type === 'pslzme') {
            $layoutModel->template = 'fe_page_pslzme';
        }
    }
}
?>