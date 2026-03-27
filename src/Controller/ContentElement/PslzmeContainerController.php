<?php 
namespace RobinDort\PslzmeLinks\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(
    category: 'pslzme',
    template: 'ce_pslzme_container',
    method: '__invoke',
    nestedFragments: true
)]
class PslzmeContainerController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $template->set('containerWidth', $model->pslzme_container_width);
        
        return $template->getResponse();
    }
}

?>