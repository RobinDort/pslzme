<?php
namespace RobinDort\PslzmeLinks\EventListener\contao;

use RobinDort\PslzmeLinks\Exceptions\InvalidFileException;

use Exception;
use Contao\System;

class ReplaceInsertTags {
    public function replacePslzmeInsertTags($tag) {
        // Check if the tag starts with "pslzme-"
        if (!str_starts_with($tag, 'pslzme:')) {
            return;
        }

        // Everything after 'pslzme:'
        $usedTemplateTag = substr($tag,7);
        $fileContent;

        // try {
            switch ($usedTemplateTag) {
                case "firstname":
                    $templateFile = "print-firstname.html5";
                    $templatePath =  System::getContainer()->getParameter('kernel.project_dir') . "/templates/pslzme/" . $templateFile;

                    // If the file exists, return its content
                    if (file_exists($templatePath)) {
                        $fileContent = file_get_contents($templatePath);
                    } else {
                        throw new InvalidFileException("File with path: " . $fileContent . " does not exist");
                    }
                break;
            }
        // } catch (InvalidFileException $ife) {
        //     error_log($ife->getErrorMsg());
        // } catch (Exception $e) {
        //     error_log($e->getMessage());
        // }

        return $fileContent;
    }
}

?>