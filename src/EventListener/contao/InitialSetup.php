<?php
namespace RobinDort\PslzmeLinks\EventListener\contao;

use RobinDort\PslzmeLinks\Model\PslzmeAcceptionPage;
use RobinDort\PslzmeLinks\Model\PslzmeDeclinePage;
use RobinDort\PslzmeLinks\Model\PslzmeAcceptionArticle;
use RobinDort\PslzmeLinks\Model\PslzmeAcceptionContent;


class InitialSetup {

    private $ranOnce = false; 

    public function runSetup() {
        if ($this->ranOnce === true) {
            return; // Exit if setup was already completed
        }

        // Create new pages for pslzme redirection (accepted, locked)
        $pslzmeAcceptionPage = new PslzmeAcceptionPage();
        $pslzmeDeclinePage = new PslzmeDeclinePage();

        // Check if the page already exists.
        if (!$pslzmeAcceptionPage->selfExists()) {

            // Get parent page ID.
            $pid = $pslzmeAcceptionPage->selectActivePageRootID();

            // Set the parent page ID to the new page.
            $pslzmeAcceptionPage->setParentPageID($pid);

            // Save the new page.
            $pslzmeAcceptionPage->save();

            // create the new pslzme acception article
            $pslzmeAcceptionArticle = new PslzmeAcceptionArticle();

            // save the new article when not existent
            if (!$pslzmeAcceptionArticle->selfExists()) {
                $pslzmeAcceptionArticle->save();

                // create new pslzme acception content
                $pslzmeAcceptionContent = new PslzmeAcceptionContent();
                if (!$pslzmeAcceptionContent->selfExists()) {
                    $pslzmeAcceptionContent->save();
                }
            }
        }

        // Do the same check for the other page
        if (!$pslzmeDeclinePage->selfExists()) {

            // Get parent page ID.
            $pid = $pslzmeDeclinePage->selectActivePageRootID();

            // Set the parent page ID to the new page.
            $pslzmeDeclinePage->setParentPageID($pid);

            // Save the new page.
            $pslzmeDeclinePage->save();
        }

        $this->ranOnce = true;
    }
}

?>