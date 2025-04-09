<?php
namespace RobinDort\PslzmeLinks\Controller\Page;

use Symfony\Component\HttpFoundation\Response;

class PslzmePageController {
    public function __invoke(): Response
    {
        // Initialize the template
        $template = new Template('fe_page_pslzme');
        return new Response($template->parse());
    }
}
?>