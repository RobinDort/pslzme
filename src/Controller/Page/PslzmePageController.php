<?php
namespace RobinDort\PslzmeLinks\Controller\Page;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Contao\PageModel;
use Contao\FrontendTemplate;
use Contao\FrontendIndex;

class PslzmePageController
{
    public function __invoke(Request $request, PageModel $pageModel): Response
    {
        $template = new FrontendTemplate('fe_page_pslzme');

        if ($GLOBALS['decryptedVars']['varsSet'] === false) {
            $homepage = PageModel::findFirstPublishedRootByHostAndLanguage($request->getHost(), $pageModel->language);

            if ($homepage !== null) {
                return new RedirectResponse($homepage->getFrontendUrl());
            }

             // Fallback: redirect to root slash if homepage not found
             return new RedirectResponse('/');
        }
        return (new FrontendIndex())->renderPage($pageModel);
    }
}

?>