<?php
namespace RobinDort\PslzmeLinks\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use RobinDort\PslzmeLinks\Service\DatabaseConnection;


class QueryDecryptionController extends AbstractFrontendModuleController {

    private $conn;

    public function __construct(DatabaseConnection $conn) {
        $this->conn = $conn;
    }
    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response {

        $template->connection = $this->conn;
        return $template->getResponse();
    }
}
?>