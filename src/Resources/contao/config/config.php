<?php
use RobinDort\PslzmeLinks\Module\QueryDecryption;
use RobinDort\PslzmeLinks\Module\PslzmeCookiebar;
use RobinDort\PslzmeLinks\Module\PslzmeCookieCaller;
use RobinDort\PslzmeLinks\Module\PslzmeNavigation;
use RobinDort\PslzmeLinks\Elements\PslzmeTextElement;
use RobinDort\PslzmeLinks\Elements\PslzmeContentElement;
use RobinDort\PslzmeLinks\EventListener\contao\InitialSetup;
use RobinDort\PslzmeLinks\EventListener\contao\ReplaceInsertTags;
use RobinDort\PslzmeLinks\EventListener\InstallListener;
use RobinDort\PslzmeLinks\Backend\PslzmeConfiguration;
use Contao\System;

// load language file
System::loadLanguageFile("default");

// Init all css / js files
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/animations.css|static";
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/pslzme-cookiebar.css|static";
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/pslzme-cookie-caller.css|static";
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/pslzme-configuration.css|static";
$GLOBALS['TL_CSS'][] = "bundles/robindortpslzmelinks/css/pslzme-elements.css|static";


$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/pslzme.min.js|static";


// Init Frontend Modules
$GLOBALS['FE_MOD']['pslzme']['query_decryption'] = QueryDecryption::class;
$GLOBALS['FE_MOD']['pslzme']['pslzme_cookiebar'] = PslzmeCookiebar::class;
$GLOBALS['FE_MOD']['pslzme']['pslzme_cookie_caller'] = PslzmeCookieCaller::class;
$GLOBALS['FE_MOD']['pslzme']['pslzme_navigation'] = PslzmeNavigation::class;



// Init Backend Modules
$GLOBALS['BE_MOD']['pslzme'][$GLOBALS['TL_LANG']['BE_MOD']['pslzme_configuration']] = [
    'tables'    => [
        'tl_pslzme_config'
    ], 
    'callback' => PslzmeConfiguration::class,
];


// Init Content Elements
$GLOBALS['TL_CTE']['pslzme']['pslzme_text'] = PslzmeTextElement::class;
$GLOBALS['TL_CTE']['pslzme']['pslzme_content'] = PslzmeContentElement::class;

// Run initial setup when installing the plugin
$GLOBALS['TL_HOOKS']['initializeSystem'][] = [InitialSetup::class, 'runSetup'];

// Listen to insert tags to initialize the pslzme tags
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = [ReplaceInsertTags::class, 'replacePslzmeInsertTags'];
?>