<?php
use RobinDort\PslzmeLinks\Module\QueryDecryption;
use RobinDort\PslzmeLinks\Module\PslzmeCookiebar;
use RobinDort\PslzmeLinks\EventListener\contao\InitialSetup;


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

// Run initial setup when installing the plugin
$GLOBALS['TL_HOOKS']['initializeSystem'][] = [InitialSetup::class, 'runSetup'];

?>