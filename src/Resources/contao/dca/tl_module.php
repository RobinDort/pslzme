<?php

use RobinDort\PslzmeLinks\Controller\FrontendModule\QueryDecryptionController;
use Contao\Controller;

$GLOBALS['TL_DCA']['tl_module']['palettes']['query_decryption'] = '{title_legend},name,type;{config_legend},template;';

// Define the 'template' field
$GLOBALS['TL_DCA']['tl_module']['fields']['template'] = [
    'label'     => ['Template', 'Select the template for the frontend module.'],
    'inputType' => 'select',
    'options'   => Controller::getTemplateGroup('mod_'), // Automatically loads templates prefixed with 'mod_'
    'eval'      => ['mandatory' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''"
];


?>