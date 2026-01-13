<?php
namespace RobinDort\PslzmeLinks\EventListener\contao;

use Contao\CoreBundle\DependencyInjection\Attribute\AsInsertTag;
use Contao\CoreBundle\InsertTag\InsertTagResult;
use Contao\CoreBundle\InsertTag\OutputType;
use Contao\CoreBundle\InsertTag\ResolvedInsertTag;
use RobinDort\PslzmeLinks\Exceptions\InvalidFileException;
use Contao\System;
use Exception;

class ReplaceInsertTags {

    public function __invoke(ResolvedInsertTag $insertTag): InsertTagResult {
       // Get the first parameter after the tag name
        $usedTemplateTag = $insertTag->getParameters()->get(0);

        try {
            $templatePath = System::getContainer()->getParameter('kernel.project_dir') 
                . "/templates/pslzme/" 
                . $usedTemplateTag 
                . ".html5";

            if (file_exists($templatePath)) {
                ob_start();
                include $templatePath; // Execute PHP inside the template
                $templateContent = ob_get_clean();

                return new InsertTagResult($templateContent, OutputType::text);
            } else {
                throw new InvalidFileException("File with path: " . $templatePath . " does not exist");
            }
        } catch (InvalidFileException $ife) {
            error_log($ife->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }

        // fallback if something fails
        return new InsertTagResult('', OutputType::text);
    }
}

?>