<?php
use RobinDort\PslzmeLinks\Module\QueryDecryption;

// Init all css / js files
$GLOBALS['TL_JAVASCRIPT'][] = "bundles/robindortpslzmelinks/js/api-request.js|static";

$GLOBALS['FE_MOD']['pslzme']['query_decryption'] = \RobinDort\PslzmeLinks\Module\QueryDecryption::class;

?>