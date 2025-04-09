<?php
use Contao\System;

/**
 * Configuration for pslzme_text element
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['pslzme_text'] = '{type_legend},type,headline;{text_legend},personalizedText,unpersonalizedText;{expert_legend:hide},showUnpersonalizedText,cssID';


$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedTextGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['personalizedText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => false],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedTextGroup'] = [
    'inputType' => 'group',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['unpersonalizedText'] = [
    'exclude'   => true,
    'inputType' => 'textarea',
    'eval'      => ['rte' => 'tinyMCE', 'helpwizard' => true, 'mandatory' => true],
    'sql' => "TEXT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['showUnpersonalizedText'] = [
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
 '{type_legend},type,headline;{Content Type},selectedContent;{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'selectedContent';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['selectedContent_image-content'] =
    '{Personalized Image Content:hide},personalizedImage,alt,size,imageUrl,caption;
     {Unpersonalized Image content:hide},unpersonalizedImage,upAlt,upSize,upImageUrl,upCaption';


$GLOBALS['TL_DCA']['tl_content']['subpalettes']['selectedContent_video-content'] =
    'personalizedVideo,unpersonalizedVideo';


$GLOBALS['TL_DCA']['tl_content']['fields']['selectedContent'] = [
    'label'     => ['Content Type', 'Select whether you want to show a personalized/unpersonalized video or image'],
    'inputType' => 'radio',
    'options'   => ['image-content' => 'Image', 'video-content' => 'Video'],
    'default'   => 'image-content',
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

$GLOBALS['TL_DCA']['tl_content']['fields']['upSize'] = [
    'label'     => ['Image size', 'Set the size for the image.'],
    'inputType' => 'imageSize',
    'options_callback' => function () {
        return System::getContainer()->get('contao.image.sizes')->getAllOptions();
    },
    'eval'      => array('rgxp'=>'digit', 'includeBlankOption'=>true, 'tl_class'=>'w50'),
    'sql'       => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upAlt'] = [
    'label'     => ['Alternative text', 'Enter an alternative text for the image.'],
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL"
];


$GLOBALS['TL_DCA']['tl_content']['fields']['upImageUrl'] = [
    'label'     => ['Image link address', 'Select a url where the image will link to'],
    'inputType' => 'pageTree',
    'eval'      => [
        'fieldType' => 'radio',
        'tl_class' => 'w50',
    ],
    'sql'       => "text NOT NULL"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['upCaption'] = [
    'label'     => ['Image Caption', 'Enter a caption for the image.'],
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'clr'],
    'sql'       => "varchar(255) NOT NULL default ''"
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