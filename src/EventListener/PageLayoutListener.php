<?php
namespace RobinDort\PslzmeLinks\EventListener;

use Contao\PageModel;
use Contao\LayoutModel;

class PageLayoutListener {
    public function __invoke(PageModel $pageModel, LayoutModel $layoutModel): void
    {
        if ($pageModel->type === 'pslzme_page') {
            $layoutModel->template = 'fe_page_pslzme';
        }
    }
}
?>