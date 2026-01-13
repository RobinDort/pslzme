<?php
namespace RobinDort\PslzmeLinks\EventListener\contao;

use RobinDort\PslzmeLinks\Exceptions\InvalidFileException;
use Contao\System;
use Exception;

class PslzmeInsertTag {

    public function replacePslzmeInsertTags($tag) {
        // Check if the tag starts with "pslzme:"
        if (!str_starts_with($tag, 'pslzme:')) {
            return;
        }

        // Get the first parameter after the tag name
        $usedTemplateTag = substr($tag,7);

        try {
           $templatePath =  System::getContainer()->getParameter('kernel.project_dir') . "/templates/pslzme/" . $usedTemplateTag . ".html5";

            if(file_exists($templatePath)) {
            // Start output buffering
                ob_start();
                include $templatePath; // This will execute PHP inside the template
                $templateContent = ob_get_clean(); // Get the output and clean the buffer
                return $templateContent;
            } else {
                throw new InvalidFileException("File with path: " . $templatePath . " does not exist");
            }
        } catch (InvalidFileException $ife) {
            error_log($ife->getErrorMsg());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}

?>