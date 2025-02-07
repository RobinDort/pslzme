<?php
namespace RobinDort\PslzmeLinks\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ModuleModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QueryDecryptionController extends AbstractFrontendModuleController {

    public const TYPE = "pslzme";

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        return $template->getResponse();
    }
}

?>