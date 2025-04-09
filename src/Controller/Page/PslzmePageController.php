<?php
namespace RobinDort\PslzmeLinks\Controller\Page;

use Symfony\Component\HttpFoundation\Response;
use Contao\FrontendTemplate;

class PslzmePageController {
    public function __invoke(): Response
    {
        // Initialize the template
        $template = new FrontendTemplate('fe_page_pslzme');
        return new Response($template->parse());
    }
}
?>