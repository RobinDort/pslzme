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
        $requiredParams = ['q1', 'q3', 'q4', 'q5', 'q6', 'q7', 'q9', 'q11'];

        // Check if any required parameter is missing
        foreach ($requiredParams as $param) {
            if (!$request->query->has($param)) {
                $homepage = PageModel::findFirstPublishedRootByHostAndLanguage(
                    $request->getHost(),
                    $pageModel->language
                );
            
                return new RedirectResponse(
                    $homepage !== null ? $homepage->getFrontendUrl() : '/'
                );
            }
        }

        return (new FrontendIndex())->renderPage($pageModel);
    }
}

?>