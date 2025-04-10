<?php
namespace RobinDort\PslzmeLinks\Module;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ModuleModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PslzmePageModuleController extends AbstractFrontendModuleController {
    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        return $template->getResponse();
    }
}

?>