<?php
namespace RobinDort\PslzmeLinks\InsertTag;

use Contao\CoreBundle\InsertTag\InsertTagResult;
use Contao\CoreBundle\InsertTag\OutputType;
use Contao\CoreBundle\InsertTag\ResolvedInsertTag;
use RobinDort\PslzmeLinks\Exceptions\InvalidFileException;
use Contao\CoreBundle\InsertTag\Resolver\InsertTagResolverNestedResolvedInterface;
use Contao\System;
use Exception;

class PslzmeInsertTag implements InsertTagResolverNestedResolvedInterface {

    public function __invoke(ResolvedInsertTag $insertTag): InsertTagResult {
       // Get the first parameter after the tag name
       throw new Exception("Debugging ->" . $usedTemplateTag);
        $usedTemplateTag = $insertTag->getParameters()->get(0);

        if (!$usedTemplateTag) {
            return new InsertTagResult('', OutputType::text);
        }


        try {
            $templatePath = System::getContainer()->getParameter('kernel.project_dir') 
                . "/templates/pslzme/" 
                . basename($usedTemplateTag) 
                . ".html5";

            if (!is_file($templatePath)) {
                return new InsertTagResult('', OutputType::text);
            }

         
            ob_start();
            include $templatePath; // Execute PHP inside the template
            $templateContent = ob_get_clean();

            return new InsertTagResult($templateContent, OutputType::text);
                   
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