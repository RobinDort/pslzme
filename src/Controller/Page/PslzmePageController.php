<?php
namespace RobinDort\PslzmeLinks\Controller\Page;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Contao\FrontendTemplate;

class PslzmePageController
{
    public function __invoke(Request $request): Response
    {
        $template = new FrontendTemplate('fe_page_pslzme');
        return new Response($template->parse());
    }
}

?>