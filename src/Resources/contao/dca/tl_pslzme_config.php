<?php

$GLOBALS['TL_DCA']['tl_pslzme_config'] = [
    'config' => [
        'dataContainer'    => 'Table',
        'sql'              => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    ],
    'fields' => [
        'id' => [
            'sql'       => "INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
        ],
        'pslzme_db_name' => [
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "VARCHAR(255) NOT NULL"
        ],
        'pslzme_db_user' => [
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255],
            'sql'       => "VARCHAR(255) NOT NULL"
        ],
        'pslzme_db_pw' => [
            'inputType' => 'password',
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'encrypt' => true],
            'sql'       => "VARCHAR(255) NOT NULL"
        ],
        'pslzme_ipr' => [
            'inputType' => 'pageTree',
            'eval'      => [
                'multiple'   => true,  // Allows selecting multiple pages
                'mandatory'  => false, // Not required
                'fieldType'  => 'checkbox',
                'tl_class'   => 'clr'
            ],
            'sql'       => "TEXT NULL"
        ],
        'createdAt' => [
            'inputType' => 'number',
            'eval'      => ['mandatory' => true, 'rgxp' => 'digit'],
            'sql'       => "INT(10) UNSIGNED NOT NULL"
        ],
        'url_licensed' => [
            'inputType' => 'checkbox',  
            'eval' => ['tl_class' => 'w50'],
            'sql' => "TINYINT(1) NOT NULL DEFAULT '0'"
        ]
    ]
];

?>