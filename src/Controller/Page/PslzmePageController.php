<?php
namespace RobinDort\PslzmeLinks\Controller\Page;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Contao\PageModel;
use Contao\FrontendTemplate;
use Contao\FrontendIndex;

class PslzmePageController
{
    public function __invoke(Request $request, PageModel $pageModel): Response
    {
        $template = new FrontendTemplate('fe_page_pslzme');
        return (new FrontendIndex())->renderPage($pageModel);
    }
}

?>