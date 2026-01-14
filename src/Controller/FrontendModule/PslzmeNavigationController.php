<?php
namespace RobinDort\PslzmeLinks\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Contao\ModuleNavigation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PslzmeNavigationController extends AbstactFrontendModuleController {

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response {
        $model->navigationTpl = 'nav_pslzme';

        $navigation = new ModuleNavigation($model);
        $navigation->compile();
        $template->items = $navigation->Template->items ?? [];
        $template->level = $navigation->Template->level ?? 'level_1';

        return $template->getResponse();
    }

}
?>