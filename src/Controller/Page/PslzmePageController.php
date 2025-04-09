<?php
namespace RobinDort\PslzmeLinks\Controller\Page;

use Symfony\Component\HttpFoundation\Response;

class PslzmePageController {
    public function __invoke(): Response
    {
        return new Response('Hello World!');
    }
}
?>