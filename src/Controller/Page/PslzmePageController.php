<?php
namespace RobinDort\PslzmeLinks\Controller\Page;

use Contao\CoreBundle\DependencyInjection\Attribute\AsPage;
use Symfony\Component\HttpFoundation\Response;

#[AsPage]
class PslzmePageController {
    public function __invoke(): Response
    {
        return new Response('Hello World!');
    }
}
?>