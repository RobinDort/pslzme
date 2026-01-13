<?php
namespace RobinDort\PslzmeLinks\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PslzmeCookieCallerController extends AbstractFrontendModuleController {

     protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response {
        return $template->getResponse();
    }
}

?>