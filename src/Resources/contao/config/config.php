<?php
use RobinDort\PslzmeLinks\Module\QueryDecryption;
use RobinDort\PslzmeLinks\Module\PslzmeCookiebar;
use RobinDort\PslzmeLinks\Model\PslzmeAcceptionPage;
use RobinDort\PslzmeLinks\Model\PslzmeDeclinePage;
use RobinDort\PslzmeLinks\Model\PslzmeAcceptionArticle;


// Init all css / js files
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/pslzme-cookiebar.css|static";

$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/url-query-data-filter.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/cookie-extractor.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/api-request.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/redirect-cookie-acception.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/query-click-listener.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/pslzme-cookiebar-controller.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/pslzme-cookiebar-name-and-greeting-verifyer.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/cookie-acception.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/main.js|static";

$GLOBALS['FE_MOD']['pslzme']['query_decryption'] = QueryDecryption::class;
$GLOBALS['FE_MOD']['pslzme']['pslzme_cookiebar'] = PslzmeCookiebar::class;


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
        $pslzmeAcceptionArticle->refresh();
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


?>