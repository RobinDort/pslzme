<?php
use RobinDort\PslzmeLinks\Module\QueryDecryption;
use RobinDort\PslzmeLinks\Module\PslzmeCookiebar;
use RobinDort\PslzmeLinks\Module\PslzmeCookieCaller;
use RobinDort\PslzmeLinks\Elements\PslzmeTextElement;
use RobinDort\PslzmeLinks\EventListener\contao\InitialSetup;
use RobinDort\PslzmeLinks\EventListener\InstallListener;


// Init all css / js files
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/animations.css|static";
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/pslzme-cookiebar.css|static";
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/pslzme-cookie-caller.css|static";

$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/url-query-data-filter.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/cookie-extractor.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/api-request.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/redirect-cookie-acception.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/query-click-listener.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/pslzme-cookiebar.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/pslzme-cookie-caller.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/pslzme-cookiebar-name-and-greeting-verifyer.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/cookie-acception.js|static";
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/main.js|static";


// Init the Frontend Modules
$GLOBALS['FE_MOD']['pslzme']['query_decryption'] = QueryDecryption::class;
$GLOBALS['FE_MOD']['pslzme']['pslzme_cookiebar'] = PslzmeCookiebar::class;
$GLOBALS['FE_MOD']['pslzme']['pslzme_cookie_caller'] = PslzmeCookieCaller::class;

// Init the Content Elements
$GLOBALS['TL_CTE']['pslzme']['pslzme_text'] = PslzmeTextElement::class;

// Run initial setup when installing the plugin
$GLOBALS['TL_HOOKS']['initializeSystem'][] = [InitialSetup::class, 'runSetup'];

?>