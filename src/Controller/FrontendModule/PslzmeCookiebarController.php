<?php
namespace RobinDort\PslzmeLinks\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use RobinDort\PslzmeLinks\Service\Backend\DatabasePslzmeConfigStmtExecutor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PslzmeCookiebarController extends AbstractFrontendModuleController {

    public function __construct(private readonly DatabasePslzmeConfigStmtExecutor $dbStmtExecutor) {}

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response {
        $imprintID = null;
        $privacyID = null;

       
        $dbConfigData = $this->dbStmtExecutor->selectCurrentDatabaseConfigurationData();
        $internalPageRefs = json_decode($dbConfigData['databaseIPR'] ?? '', true) ?? [];

        // if (!empty($internalPageRefs['Imprint'])) {
        //     $imprintUrl = $template->insertTags->replace(
        //         '{{link_url::' . $internalPageRefs['Imprint'] . '}}'
        //     );
        // }

        // if (!empty($internalPageRefs['Privacy'])) {
        //     $privacyUrl = $template->insertTags->replace(
        //         '{{link_url::' . $internalPageRefs['Privacy'] . '}}'
        //     );
        // }

        // $template->imprintURL = $imprintUrl;
        // $template->privacyURL = $privacyUrl;

        return $template->getResponse();
    }
}

?>