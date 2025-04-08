<?php

/**
 * Configuration for pslzme_text element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_text'] = '{type_legend},type,headline;{text_legend},personalizedText,unpersonalizedText;{expert_legend:hide},showUnpersonalizedText,cssID';


$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedTextGroup'] = [
    'label' => array('Personalized Text/HTML/Code'),
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedText'] = [
    'label'     => ['Personalized Text', 'Enter personalized text'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => false],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedTextGroup'] = [
    'label' => array('Unpersonalized Text/HTML/Code'),
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedText'] = [
    'label'     => ['Unpersonalized Text', 'Enter unpersonalized text'],
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => true],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['showUnpersonalizedText'] = [
    'label'     => ["Show Unpersonalized Text", 'Choose selection'],
    'exclude'   => true,
    'inputType' => 'radio',
    'options'   => ['1' => 'Yes', '0' => 'No'],
    'default'   => '1',
    'eval'      => ['mandatory' => true, 'tl_class' => 'w50'],
    'sql'       => "char(1) NOT NULL default '1'"
];



/**
 * Configuration for pslzme_content element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_content'] = 
 '{type_legend},type,headline;{Content Type},contentType;{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'contentType';

// $GLOBALS['TL_DCA']['tl_content']['subpalettes'] = [
//     'contentType_image' => 'personalizedImage,unpersonalizedImage',
// ];


$GLOBALS['TL_DCA']['tl_content']['subpalettes']['contentType_image'] =
    'personalizedImage,unpersonalizedImage';


$GLOBALS['TL_DCA']['tl_content']['subpalettes']['contentType_video'] =
    'personalizedVideo,unpersonalizedVideo';


// $GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_content'] = '
//     {type_legend},type,headline;
//     {Content Type},contentType;
//     {expert_legend:hide},cssID';



// $GLOBALS['TL_DCA']['tl_content']['subpalettes']['contentType_video'] = '
//     {Video Content},personalizedVideo,unpersonalizedVideo;';


$GLOBALS['TL_DCA']['tl_content']['fields']['contentType'] = [
    'label'     => ['Content Type', 'Select whether you want to show a personalized/unpersonalized video or image'],
    'inputType' => 'radio',
    'options'   => ['image', 'video'],
    'default'   => 'image',
    'eval'      => ['mandatory' => true, 'submitOnChange' => true, 'tl_class' => 'clr'],
    'sql'       => "varchar(32) default NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedImage'] = [
    'label'     => ['Personalized Image', 'Show a personalized image.'],
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => false, 
        'filesOnly' => true, 
        'fieldType' => 'radio', 
        'extensions' => 'jpg,jpeg,png,gif,webp', 
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedImage'] = [
    'label'     => ['Unpersonalized Image', 'Show an unpersonalized image.'],
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => true, 
        'filesOnly' => true, 
        'fieldType' => 'radio', 
        'extensions' => 'jpg,jpeg,png,gif,webp', 
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedVideo'] = [
    'label'     => ['Personalized Video', 'Show a personalized video.'],
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => false, 
        'filesOnly' => true, 
        'fieldType' => 'radio', 
        'extensions' => 'mp4,webm', 
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];


$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedVideo'] = [
    'label'     => ['Unpersonalized Video', 'Show an unpersonalized video.'],
    'inputType' => 'fileTree',
    'eval'      => [
        'mandatory' => true, 
        'filesOnly' => true, 
        'fieldType' => 'radio', 
        'extensions' => 'mp4,webm', 
        'tl_class' => 'clr',
    ],
    'sql'       => "binary(16) NULL"
];



?>